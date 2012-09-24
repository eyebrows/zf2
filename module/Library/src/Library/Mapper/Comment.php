<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class Comment extends Core\AbstractMapper {

	protected $entityTable = 'comments';
	protected $userMapper;

	public function __construct(Core\PdoAdapter $adapter, User $userMapper=null) {
		if($userMapper)
			$this->userMapper = $userMapper;
		parent::__construct($adapter);
	}

//called by the AbstractMapper's saveEntity() method (until I come up with a tidier way of doing this, probably, as "author_id" now appears twice...)
	protected function getReferencedEntityIds($entity) {
		$ids = array();
		if($user = $entity->getReferenced('user', true))
			$ids['user_id'] = $user->id;
		return $ids;
	}

	protected function createEntity(array $row) {
		if($this->userMapper)
			$user = new Core\EntityPlaceholder($this->userMapper, array('id'=>$row['user_id']));
		return new Model\Comment($row['id'], $row['content'], isset($user)?$user:null);
	}
}

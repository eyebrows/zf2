<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class User extends Core\AbstractMapper {

	protected $entityTable = 'users';
	protected $commentsMapper;

	public function __construct(Core\PdoAdapter $adapter, Comment $commentsMapper=null) {
		if($commentsMapper)
			$this->commentsMapper = $commentsMapper;
		parent::__construct($adapter);
	}

	public function insert(Model\User $user) {
		$user->id = $this->adapter->insert($this->entityTable, array(
			'name'=>$user->name,
			'username'=>$user->username,
		));
		return $user->id;
	}

	protected function createEntity(array $row) {
		if($this->commentsMapper)
			$comments = new Core\EntityPlaceholder($this->commentsMapper, array('user_id'=>$row['id']));
		return new Model\User($row['id'], $row['name'], $row['email'], isset($comments)?$comments:null);
	}
}

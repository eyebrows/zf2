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

//figure out the best way of doing this - pull IDs from Entities, or pass literal IDs in?
	public function insert(Model\Comment $comment, $book_id, $user_id) {
		$comment->id = $this->adapter->insert($this->entityTable, array(
			'content'=>$comment->content,
			'book_id'=>$book_id,
			'user_id'=>$user_id,
		));
		return $comment->id;
	}

	protected function createEntity(array $row) {
		if($this->userMapper)
			$user = new Core\EntityPlaceholder($this->userMapper, array('id'=>$row['user_id']));
		return new Model\Comment($row['id'], $row['content'], isset($user)?$user:null);
	}
}

<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class User extends Core\AbstractMapper {

	protected $entityTable = 'users';
	protected $usertypeMapper;
	protected $commentsMapper;

	public function __construct(Core\PdoAdapter $adapter, Usertype $usertypeMapper=null, Comment $commentsMapper=null) {
		if($usertypeMapper)
			$this->usertypeMapper = $usertypeMapper;
		if($commentsMapper)
			$this->commentsMapper = $commentsMapper;
		parent::__construct($adapter);
	}

	public function saveEntity($user) {
		$data = get_object_vars($user);
		if(isset($data['password']))
			$data['password'] = md5($data['password']);
		parent::saveEntity($user, $data);
	}

	protected function createEntity(array $row) {
		if($this->usertypeMapper)
			$usertype = new Core\EntityPlaceholder($this->usertypeMapper, array('id'=>$row['usertype_id']));
		if($this->commentsMapper)
			$comments = new Core\EntityPlaceholder($this->commentsMapper, array('user_id'=>$row['id']));
		return new Model\User($row['id'], $row['date_registered'], $row['name'], $row['username'], '', $row['max_concurrent_rentals'], $row['max_rental_days'], isset($usertype)?$usertype:null, isset($comments)?$comments:null);
	}
}

<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class Usertype extends AbstractEntity {

	public $name;

	protected $users;

	public function __construct($id=null, $name=null, $users=null) {
		$this->id = $id;
		$this->name = $name;
		if($users)
			$this->users = $users;
	}

	public function getUsers() {
		return parent::getDependent('users');
	}
}

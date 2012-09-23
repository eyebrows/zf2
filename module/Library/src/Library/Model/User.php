<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class User extends AbstractEntity {

	public $name;
	public $username;

	protected $comments;

	public function __construct($id, $name, $username, $comments=null) {
		$this->id = $id;
		$this->setName($name);
		$this->setUsername($username);
	}

	public function getComments() {
		return parent::getDependent('comments');
	}

	public function setName($name) {
		if(strlen($name)<2 || strlen($name)>30)
			throw new \InvalidArgumentException('The user name is invalid.');
		$this->name = htmlspecialchars(trim($name), ENT_QUOTES);
		return $this;
	}

	public function setUsername($email) {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			throw new \InvalidArgumentException('The User\'s username is invalid.');
		$this->email = $email;
		return $this;
	}
}

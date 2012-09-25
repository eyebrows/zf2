<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class User extends AbstractEntity {

	public $date_registered;
	public $name;
	public $username;
	public $password;
	public $max_concurrent_rentals;
	public $max_rental_days;

	protected $comments;

	public function __construct($id=null, $date_registered=null, $name=null, $username=null, $password=null, $max_concurrent_rentals=null, $max_rental_days=null, $comments=null) {
		$this->id = $id;
		$this->date_registered = $date_registered?$date_registered:date('Y-m-d G:i:s');
		$this->name = $name;
		$this->username = $username;
		$this->password = $password;
		$this->max_concurrent_rentals = $max_concurrent_rentals?$max_concurrent_rentals:0;
		$this->max_rental_days = $max_rental_days?$max_rental_days:0;
	}

	public function getComments() {
		return parent::getDependent('comments');
	}

	public function exchangeArray($data) {
		unset($data['confirm']);
		parent::exchangeArray($data);
	}
}

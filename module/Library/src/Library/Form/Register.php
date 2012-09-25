<?php
namespace Library\Form;

use Zend\Form\Form;

class Register extends Form {

	public function __construct($name=null) {
		parent::__construct('user');
		$this->setAttribute('method', 'post');
/*
		$this->add(array(
			'name'=>'id',
			'attributes'=>array(
				'type'=>'hidden',
			),
		));
*/
		$this->add(array(
			'name'=>'username',
			'attributes'=>array(
				'type'=>'text',
			),
			'options'=>array(
				'label'=>'Email Address',
			),
		));
		$this->add(array(
			'name'=>'name',
			'attributes'=>array(
				'type'=>'text',
			),
			'options'=>array(
				'label'=>'Name',
			),
		));
		$this->add(array(
			'name'=>'password',
			'attributes'=>array(
				'type'=>'password',
			),
			'options'=>array(
				'label'=>'Create Password',
			),
		));
		$this->add(array(
			'name'=>'confirm',
			'attributes'=>array(
				'type'=>'password',
			),
			'options'=>array(
				'label'=>'Confirm Password',
			),
		));
		$this->add(array(
			'name'=>'submit',
			'attributes'=>array(
				'type'=>'submit',
				'value'=>'Register',
				'id'=>'submitbutton',
			),
		));
	}
}

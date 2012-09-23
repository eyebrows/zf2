<?php
namespace Library\Form;

use Zend\Form\Form;

class Login extends Form {

	public function __construct($name=null) {
		parent::__construct('user');
		$this->setAttribute('method', 'post');
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
			'name'=>'password',
			'attributes'=>array(
				'type'=>'password',
			),
			'options'=>array(
				'label'=>'Password',
			),
		));
		$this->add(array(
			'name'=>'submit',
			'attributes'=>array(
				'type'=>'submit',
				'value'=>'Login',
				'id'=>'submitbutton',
			),
		));
	}
}

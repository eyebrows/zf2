<?php
namespace Library\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

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

	public function getInputFilter() {
		if(!isset($this->inputFilter)) {
			$this->inputFilter = new InputFilter();
			$factory = new InputFactory();
			$this->inputFilter->add($factory->createInput(array(
				'name'=>'username',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'EmailAddress',
					),
				),
			)));
			$this->inputFilter->add($factory->createInput(array(
				'name'=>'password',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'=>8,
							'max'=>32,
						),
					),
				),
			)));
		}
		return $this->inputFilter;
	}
}

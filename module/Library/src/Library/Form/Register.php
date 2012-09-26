<?php
namespace Library\Form;

use Application\Core;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Register extends Form {

	private $mapper;

	public function __construct(Core\AbstractMapper $mapper) {
		parent::__construct('user');
		$this->mapper = $mapper;

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

	public function getInputFilter() {
		if(!isset($this->inputFilter)) {
			$this->inputFilter = new InputFilter();
			$factory = new InputFactory();
/*
			$this->inputFilter->add($factory->createInput(array(
				'name'=>'id',
				'required'=>true,
				'filters'=>array(
					array('name'=>'Int'),
				),
			)));
*/
			$this->inputFilter->add($factory->createInput(array(
				'name'=>'name',
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
							'min'=>3,
							'max'=>100,
						),
					),
				),
			)));
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
					array(
						'name'=>'Db\NoRecordExists',
						'options'=>array(
							'adapter'=>$this->mapper->getDbAdapter()->getZendAdapter(),
							'table'=>$this->mapper->getEntityTable(),
							'field'=>'username',
						),
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
			$this->inputFilter->add($factory->createInput(array(
				'name'=>'confirm',
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
					array(
						'name'=>'Identical',
						'options'=>array(
							'token'=>'password',
						),
					),
				),
			)));
		}
		return $this->inputFilter;
	}
}

<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class User extends Core\AbstractMapper {

	protected $entityTable = 'users';
	protected $commentsMapper;

	public function __construct(Core\PdoAdapter $adapter, Comment $commentsMapper=null) {
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
		if($this->commentsMapper)
			$comments = new Core\EntityPlaceholder($this->commentsMapper, array('user_id'=>$row['id']));
		return new Model\User($row['id'], $row['date_registered'], $row['name'], $row['email'], '', $row['max_concurrent_rentals'], $row['max_rental_days'], isset($comments)?$comments:null);
	}

	public function createInputFilter() {
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
						'adapter'=>$this->adapter->getZendAdapter(),
						'table'=>$this->entityTable,
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
}

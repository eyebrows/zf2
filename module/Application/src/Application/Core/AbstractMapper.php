<?php
namespace Application\Core;

use Application\Core\PdoAdapter;

abstract class AbstractMapper {

	protected $adapter;
	protected $entityTable;

	public function __construct(PdoAdapter $adapter) {
		$this->adapter = $adapter;
	}

	public function getAdapter() {
		return $this->adapter;
	}

	public function findById($id) {
		$this->adapter->select($this->entityTable, array('id'=>$id));
		if(!$row = $this->adapter->fetch())
			return null;
		return $this->createEntity($row);
	}

	public function findAll(array $conditions = array()) {
		$entities = array();
		$this->adapter->select($this->entityTable, $conditions);
		$rows = $this->adapter->fetchAll();
		if($rows)
			foreach($rows as $row)
				$entities[] = $this->createEntity($row);
		return $entities;
	}

	public function deleteEntity($entity) {
		return $this->adapter->delete($this->entityTable, array('id='.$entity->id));
	}

	public function deleteById($id) {
		return $this->adapter->delete($this->entityTable, array('id='.$id));
	}

//for any mapper not passed in at __construct() time
	public function setMapper($property, $mapper) {
		$this->{$property.'Mapper'} = $mapper;
	}

/*
//so far only used by chained placeholders to access mappers inside mappers
	public function getMapper($name) {
		$mapper = $name.'Mapper';
		if(!property_exists($this, $mapper))
			throw new \Exception('Invalid mapper access request ('.$mapper.').');
		return $this->$mapper;
	}
*/

//every implemented Mapper must have a createEntity function which must take an array of data, which is a record from a DB
	abstract protected function createEntity(array $row);
}

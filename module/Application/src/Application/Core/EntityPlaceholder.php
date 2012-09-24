<?php
namespace Application\Core;

class EntityPlaceholder {

	private $mapper;
	private $conditions;

	public function __construct($mapper, array $conditions) {
		$this->mapper = $mapper;
		$this->conditions = $conditions;
	}

//for references (e.g. we're a placeholder inside a Book, to fetch our Author)
	public function fetchEntity() {
		return $this->mapper->findById($this->conditions['id']);
	}

//for dependents (e.g. we're a placeholder inside an Author, to fetch our Books)
	public function fetchEntities() {
		return $this->mapper->findAll($this->conditions);
	}
}

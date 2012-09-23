<?php
namespace Application\Core;

class EntityPlaceholder {

	private $mapper;
	private $conditions;
//	private $chained_placeholder;

/*
//the old constructor for the mapper-based mTm shortcut version
	public function __construct($mapper, array $conditions, $chained_placeholder=null) {
		$this->mapper = $mapper;
		$this->conditions = $conditions;
		if($chained_placeholder)
			$this->chained_placeholder = $chained_placeholder;
	}
*/

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
/*
//chained placeholder is for the mapper-based shortcut method for many-to-many linking tables, no longer implemented, but saved for reference
		if($this->chained_placeholder) {
			$entities = $this->mapper->findAll($this->conditions);
			return $this->chained_placeholder->fetchFromUpChainEntities($entities);
		}
		else
*/
		return $this->mapper->findAll($this->conditions);
	}

/*
	public function fetchFromUpChainEntities($entities) {
		list($primary_key, $child_entity, $child_key) = $this->conditions;
		$keys = array();
		foreach($entities as $entity)
			$keys[] = $entity->{'get'.$child_entity}()->$child_key;
		return $this->mapper->findAll(array($primary_key=>$keys));
	}
*/
}

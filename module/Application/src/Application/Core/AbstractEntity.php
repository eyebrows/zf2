<?php
namespace Application\Core;

abstract class AbstractEntity {

	public $id;

	public function __set($name, $value) {
		$field = strtolower($name);
		if(!property_exists($this, $field))
			throw new \InvalidArgumentException('Setting the field \''.$field.'\' is not valid for this entity.');
		$mutator = 'set'.ucfirst(strtolower($name));
		if(method_exists($this, $mutator) && is_callable(array($this, $mutator)))
			$this->$mutator($value);
		else
			$this->$field = $value;
		return $this;
	}

	public function __get($name) {
		$field = strtolower($name);
		if(!property_exists($this, $field))
			throw new \InvalidArgumentException('Getting the field \''.$field.'\' is not valid for this entity.');
		$accessor = 'get'.ucfirst(strtolower($name));
		if(method_exists($this, $accessor) && is_callable(array($this, $accessor)))
			return $this->$accessor();
		else
			return $this->$field;
	}

//$dont_translate needed so the Mapper::save() method can tell if it needs to actually grab the id of the referenced object or not
	public function getReferenced($property, $dont_translate=false) {
		if($dont_translate)
			return 'Application\Core\EntityPlaceholder'==get_class($this->$property)?false:$this->$property;
		if(is_object($this->$property) && 'Application\Core\EntityPlaceholder'==get_class($this->$property))
			$this->$property = $this->$property->fetchEntity();
		else if(is_null($this->$property))
			throw new \Exception('Attempt to access null property as Referenced Object - '.$property);
		return $this->$property;
	}

	public function getDependent($property) {
		if(is_object($this->$property) && 'Application\Core\EntityPlaceholder'==get_class($this->$property))
			$this->$property = $this->$property->fetchEntities();
		else if(is_null($this->$property))
			throw new \Exception('Attempt to access null property as Dependent Object - '.$property);
		return $this->$property;
	}

	public function setId($id) {
		if($this->id!==null)
			throw new \BadMethodCallException('The ID for this '.get_called_class().' has been set already.');
		if(!is_int($id) || $id<1)
			throw new \InvalidArgumentException('The '.get_called_class().'\'s ID is invalid.');
		$this->id = $id;
		return $this;
	}

//below two methods used by the InputFilter thing for validating input from forms
	public function getArrayCopy() {
		return get_object_vars($this);
	}

	public function exchangeArray($data) {
		foreach($data as $key=>$value)
			$this->$key = $value;
	}
}

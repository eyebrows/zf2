<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class Category extends AbstractEntity {

	public $name;

//dependent entity array
	protected $bookcategories;
	protected $books;

	public function __construct($id, $name, $bookcategories=null) {
		$this->id = $id;
		$this->name = $name;
		if($bookcategories)
			$this->bookcategories = $bookcategories;
	}

	public function getBookCategories() {
		return parent::getDependent('bookcategories');
	}

//shortcut method so view scripts don't have to go via BookCategories as they won't care about them
	public function getBooks() {
		$books = array();
		$bookcategories = $this->getBookCategories();
		foreach($bookcategories as $bookcategory)
			$books[] = $bookcategory->getBook();
		return $books;
	}
}

<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class Author extends AbstractEntity {

	public $name;

//sub-objects should be protected so the getBooks method gets auto-called by AbstractEntity's __get() magic method, in case it's needed
	protected $books;

	public function __construct($id, $name, $books=null) {
		$this->id = $id;
		$this->name = $name;
		if($books)
			$this->books = $books;
	}

	public function getBooks() {
		return parent::getDependent('books');
	}
}

<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class BookCategory extends AbstractEntity {

	public $book_id;
	public $category_id;

//referenced entities
	protected $book, $category;

	public function __construct($id, $book=null, $category=null) {
		$this->id = $id;
		if($book)
			$this->book = $book;
		if($category)
			$this->category = $category;
	}

	public function getBook() {
		return parent::getReferenced('book');
	}

	public function getCategory() {
		return parent::getReferenced('category');
	}
}

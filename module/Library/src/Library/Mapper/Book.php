<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class Book extends Core\AbstractMapper {

	protected $entityTable = 'books';
	protected $authorMapper, $bookcategoriesMapper;

	public function __construct(Core\PdoAdapter $adapter, Author $authorMapper=null, BookCategory $bookcategoriesMapper=null) {
		if($authorMapper)
			$this->authorMapper = $authorMapper;
		if($bookcategoriesMapper)
			$this->bookcategoriesMapper = $bookcategoriesMapper;
		parent::__construct($adapter);
	}

	public function insert(Model\Book $book) {
		$book->id = $this->adapter->insert($this->entityTable, array(
			'title'=>$book->title,
		));
		return $book->id;
	}

	protected function createEntity(array $row) {
		if($this->authorMapper)
			$author = new Core\EntityPlaceholder($this->authorMapper, array('id'=>$row['author_id']));
/*
//this is the mapper-based way of doing shortcuts so the model never even sees a BookCategory object, they never exist as far as its concerned
//not used as it's a bit finnecky and some link table data might be needed anyway. Easier to comprehend model-based shortcuts over this n'mare, too
		if($this->bookcategoriesMapper) {
			$categories = new Core\EntityPlaceholder($this->bookcategoriesMapper->getMapper('category'), array('id', 'Category', 'id'));
			$bookcategories = new Core\EntityPlaceholder($this->bookcategoriesMapper, array('book_id'=>$row['id']), $categories);
		}
*/
		if($this->bookcategoriesMapper)
			$bookcategories = new Core\EntityPlaceholder($this->bookcategoriesMapper, array('book_id'=>$row['id']));
		return new Model\Book($row['id'], $row['title'], isset($author)?$author:null, isset($bookcategories)?$bookcategories:null);
	}
}

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

//called by the AbstractMapper's saveEntity() method (until I come up with a tidier way of doing this, probably, as "author_id" now appears twice...)
	protected function getReferencedEntityIds($entity) {
		$ids = array();
		if($author = $entity->getReferenced('author', true))
			$ids['author_id'] = $author->id;
		return $ids;
	}

	protected function createEntity(array $row) {
		if($this->authorMapper)
			$author = new Core\EntityPlaceholder($this->authorMapper, array('id'=>$row['author_id']));
		if($this->bookcategoriesMapper)
			$bookcategories = new Core\EntityPlaceholder($this->bookcategoriesMapper, array('book_id'=>$row['id']));
		return new Model\Book($row['id'], $row['title'], isset($author)?$author:null, isset($bookcategories)?$bookcategories:null);
	}
}

<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class BookCategory extends Core\AbstractMapper {

	protected $entityTable = 'book_categories';
	protected $bookMapper, $categoryMapper;

	public function __construct(Core\PdoAdapter $adapter, Book $bookMapper=null, Category $categoryMapper=null) {
		if($bookMapper)
			$this->bookMapper = $bookMapper;
		if($categoryMapper)
			$this->categoryMapper = $categoryMapper;
		parent::__construct($adapter);
	}

//called by the AbstractMapper's saveEntity() method (until I come up with a tidier way of doing this, probably, as "author_id" now appears twice...)
	protected function getReferencedEntityIds($entity) {
		$ids = array();
		if($book = $entity->getReferenced('book', true))
			$ids['book_id'] = $book->id;
		if($category = $entity->getReferenced('category', true))
			$ids['category_id'] = $category->id;
		return $ids;
	}

	protected function createEntity(array $row) {
		if($this->bookMapper)
			$books = new Core\EntityPlaceholder($this->bookMapper, array('id'=>$row['book_id']));
		if($this->categoryMapper)
			$categories = new Core\EntityPlaceholder($this->categoryMapper, array('id'=>$row['category_id']));
		return new Model\BookCategory($row['id'], isset($books)?$books:null, isset($categories)?$categories:null);
	}
}

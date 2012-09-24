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

	protected function createEntity(array $row) {
		if($this->bookMapper)
			$books = new Core\EntityPlaceholder($this->bookMapper, array('id'=>$row['book_id']));
		if($this->categoryMapper)
			$categories = new Core\EntityPlaceholder($this->categoryMapper, array('id'=>$row['category_id']));
		return new Model\BookCategory($row['id'], isset($books)?$books:null, isset($categories)?$categories:null);
	}
}

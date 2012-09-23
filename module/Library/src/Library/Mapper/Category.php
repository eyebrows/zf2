<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class Category extends Core\AbstractMapper {

	protected $entityTable = 'categories';
	protected $bookcategoriesMapper;

	public function __construct(Core\PdoAdapter $adapter, BookCategory $bookcategoriesMapper=null) {
		if($bookcategoriesMapper)
			$this->bookcategoriesMapper = $bookcategoriesMapper;
		parent::__construct($adapter);
	}

	public function insert(Model\Category $category) {
		$category->id = $this->adapter->insert($this->entityTable, array(
			'name'=>$category->name,
		));
		return $category->id;
	}

	protected function createEntity(array $row) {
/*
//this is the mapper-based way of doing shortcuts so the model never even sees a BookCategory object, they never exist as far as its concerned
//not used as it's a bit finnecky and some link table data might be needed anyway. Easier to comprehend model-based shortcuts over this n'mare, too
		if($this->bookcategoriesMapper) {
			$books = new Core\EntityPlaceholder($this->bookcategoriesMapper->getMapper('book'), array('id', 'Book', 'id'));
			$bookcategories = new Core\EntityPlaceholder($this->bookcategoriesMapper, array('category_id'=>$row['id']), $books);
		}
*/
		if($this->bookcategoriesMapper)
			$bookcategories = new Core\EntityPlaceholder($this->bookcategoriesMapper, array('category_id'=>$row['id']));
		return new Model\Category($row['id'], $row['name'], isset($bookcategories)?$bookcategories:null);
	}
}

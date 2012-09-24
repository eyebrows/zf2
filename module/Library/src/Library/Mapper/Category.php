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
		if($this->bookcategoriesMapper)
			$bookcategories = new Core\EntityPlaceholder($this->bookcategoriesMapper, array('category_id'=>$row['id']));
		return new Model\Category($row['id'], $row['name'], isset($bookcategories)?$bookcategories:null);
	}
}

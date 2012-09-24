<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class Author extends Core\AbstractMapper {

	protected $entityTable = 'authors';
	protected $booksMapper;

	public function __construct(Core\PdoAdapter $adapter, Book $booksMapper=null) {
		if($booksMapper)
			$this->booksMapper = $booksMapper;
		parent::__construct($adapter);
	}

	protected function createEntity(array $row) {
		if($this->booksMapper)
			$books = new Core\EntityPlaceholder($this->booksMapper, array('author_id'=>$row['id']));
		return new Model\Author($row['id'], $row['name'], isset($books)?$books:null);
	}
}

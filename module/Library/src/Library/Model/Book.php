<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class Book extends AbstractEntity {

	public $title;

//sub-objects should be protected so the getAuthor method gets auto-called by AbstractEntity's __get() magic method
	protected $author;
	protected $bookcategories;
	protected $categories;

	public function __construct($id, $title, $author=null, $bookcategories=null) {
		$this->id = $id;
		$this->setTitle($title);
		if($author)
			$this->author = $author;
		if($bookcategories)
			$this->bookcategories = $bookcategories;
	}

	public function getAuthor() {
		return parent::getReferenced('author');
	}

	public function getBookCategories() {
		return parent::getDependent('bookcategories');
	}

//shortcut method so view scripts don't have to go via BookCategories as they won't care about them
	public function getCategories() {
		$categories = array();
		$bookcategories = $this->getBookCategories();
		foreach($bookcategories as $bookcategory)
			$categories[] = $bookcategory->getCategory();
		return $categories;
	}

//what do we need this for? anything? we're already validating the form...
	public function setTitle($title) {
		if(!is_string($title) || strlen($title)<2 || strlen($title)>100)
			throw new \InvalidArgumentException('The post title is invalid.');
		$this->title = htmlspecialchars(trim($title), ENT_QUOTES);
		return $this;
	}
}

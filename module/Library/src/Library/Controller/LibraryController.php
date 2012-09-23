<?php
namespace Library\Controller;

use Zend\View\Model\ViewModel;
use Application\Core\MasterController;

use Library\Mapper;
use Library\Model;
use Library\Form;

class LibraryController extends MasterController {

	public function indexAction() {

//here are three discrete examples of how to fetch data

//this way around the Book is the primary object, and getAuthor() can be called on each book to go get the right one from the bookMapper
		$authorMapper = new Mapper\Author($this->dbAdapter);
		$bookMapper = new Mapper\Book($this->dbAdapter, $authorMapper);
		$books = $bookMapper->findAll();

//but now the authorMapper can also fetch related books
		$authorMapper = new Mapper\Author($this->dbAdapter);
		$categoryMapper = new Mapper\Category($this->dbAdapter);
		$bookcategoryMapper = new Mapper\BookCategory($this->dbAdapter, null, $categoryMapper);
		$bookMapper = new Mapper\Book($this->dbAdapter, $authorMapper, $bookcategoryMapper);
		$authorMapper->setMapper('books', $bookMapper);
		$highlighted_author = $authorMapper->findById(2);

//and this is just a category listing
		$bookMapper = new Mapper\Book($this->dbAdapter);
		$bookcategoryMapper = new Mapper\BookCategory($this->dbAdapter, $bookMapper, null);
		$categoryMapper = new Mapper\Category($this->dbAdapter, $bookcategoryMapper);
		$highlighted_category = $categoryMapper->findById(2);

		return new ViewModel(array(
			'books'=>$books,
			'highlighted_author'=>$highlighted_author,
			'highlighted_category'=>$highlighted_category,
		));
	}

	public function registerAction() {
		$form = new Form\Register();
		$form->get('submit')->setValue('Register');
		$request = $this->getRequest();
		if($request->isPost()) {
			$user = new Model\User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()) {
				$user->exchangeArray($form->getData());
				$this->getUserTable()->saveUser($user);
				return $this->redirect()->toRoute('library');
			}
		}
		return array('form'=>$form);
	}

	public function loginAction() {
		$form = new Form\Login();
		$form->get('submit')->setValue('Login');
		$request = $this->getRequest();
		if($request->isPost()) {
			$user = new Model\User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()) {
/*
				$user->exchangeArray($form->getData());
				$this->getUserTable()->saveUser($user);
				return $this->redirect()->toRoute('library');
*/
			}
		}
		return array('form'=>$form);
	}
}

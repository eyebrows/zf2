<?php
namespace Library\Controller;

use Zend\View\Model\ViewModel;
use Application\Core\MasterController;
use Zend\Authentication\AuthenticationService as Auth;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Library\Mapper;
use Library\Model;
use Library\Form;

class LibraryController extends MasterController {

	public function indexAction() {
		$auth = new Auth();
		$data = $auth->getStorage()->read();
		if($data['user_id']) {
			$usertypeMapper = new Mapper\Usertype($this->dbAdapter);
			$userMapper = new Mapper\User($this->dbAdapter, $usertypeMapper);
			$user = $userMapper->findById($data['user_id']);
		}

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

		return array(
			'books'=>$books,
			'highlighted_author'=>$highlighted_author,
			'highlighted_category'=>$highlighted_category,
			'user'=>isset($user)?$user:'',
		);
	}

	public function libraryAction() {
		$auth = new Auth();
		$data = $auth->getStorage()->read();
		if($data['user_id']) {
			$usertypeMapper = new Mapper\Usertype($this->dbAdapter);
			$userMapper = new Mapper\User($this->dbAdapter, $usertypeMapper);
			$user = $userMapper->findById($data['user_id']);
		}

		$authorMapper = new Mapper\Author($this->dbAdapter);
		$bookMapper = new Mapper\Book($this->dbAdapter, $authorMapper);
		$books = $bookMapper->findAll();

		return array(
			'books'=>$books,
			'user'=>isset($user)?$user:'',
		);
	}

	public function registerAction() {
		$userMapper = new Mapper\User($this->dbAdapter);
		$form = new Form\Register($userMapper);
//		$form->get('submit')->setValue('Register');
		$request = $this->getRequest();
		if($request->isPost()) {
			$form->setData($request->getPost());
			if($form->isValid()) {
				$user = new Model\User();
				$user->exchangeArray($form->getData());
				$userMapper->saveEntity($user);
				return $this->redirect()->toUrl('/library/login#registered=justnow');
			}
		}
		return array(
			'form'=>$form,
		);
	}

	public function loginAction() {
		$form = new Form\Login();
		$request = $this->getRequest();
		if($request->isPost()) {
			$form->setData($request->getPost());
			if($form->isValid()) {
				$data = $form->getData();
				$auth = new Auth();
				$authAdapter = new AuthAdapter($this->dbAdapter->getZendAdapter(), 'users', 'username', 'password');
				$authAdapter
					->setIdentity($data['username'])
					->setCredential(md5($data['password']));
				if($auth->authenticate($authAdapter)->isValid()) {
					$id = $authAdapter->getResultRowObject()->id;
					$auth->getStorage()->write(array(
						'user_id'=>$id,
					));
					$this->redirect()->toUrl('/#loggedin=justnow');
				}
				else
					$error = 'Invalid username or password';
			}
		}
		return array(
			'form'=>$form,
			'error'=>isset($error)?$error:'',
		);
	}

	public function logoutAction() {
		$auth = new Auth();
		if($auth->hasIdentity())
			$auth->clearIdentity();
		$this->redirect()->toUrl('/');
	}
}

<?php
namespace Library\Model;

use Application\Core\AbstractEntity;

class Comment extends AbstractEntity {

	public $content;
	protected $user;

	public function __construct($id, $content, $user=null) {
		$this->id = $id;
		$this->setContent($content);
		if($user)
			$this->user = $user;
	}

	public function getUser() {
		return parent::getReferenced('user');
	}

	public function setContent($content) {
		if(!is_string($content) || strlen($content)<2)
			throw new \InvalidArgumentException('The content of the Comment is invalid.');
		$this->content = htmlspecialchars(trim($content), ENT_QUOTES);
		return $this;
	}
}

<?php
namespace Application\Core;

use Zend\Mvc\Controller\AbstractActionController;

class MasterController extends AbstractActionController {

	protected $dbAdapter;

	public function setDbAdapter(PdoAdapter $dbAdapter) {
		$this->dbAdapter = $dbAdapter;
	}
}

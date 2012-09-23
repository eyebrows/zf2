<?php
namespace Application\Core;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommonServiceFactory implements FactoryInterface {

	protected $controller;

	public function createService(ServiceLocatorInterface $services) {
		$serviceLocator = $services->getServiceLocator();
		$dbAdapter = $serviceLocator->get('Application\Core\PdoAdapter');
		$controller = new $this->controller;
		$controller->setDbAdapter($dbAdapter);
		return $controller;
	}

	public function setController($controller) {
		$this->controller = $controller;
	}
}

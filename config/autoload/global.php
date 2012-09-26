<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db'=>array(
		'driver'=>'Pdo',
		'dsn'=>'mysql:dbname=zf2tutorial;host=localhost',
		'driver_options'=>array(
			PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'UTF8\'',
		),
	),
	'service_manager'=>array(
		'factories'=>array(
			'Application\Core\PdoAdapter'=>function($serviceManager) {
				$config = $serviceManager->get('configuration');
				return new \Application\Core\PdoAdapter($config['db']['dsn'], $config['db']['username'], $config['db']['password'], $config['db']['driver_options']);
			},
			'Zend\Db\Adapter\Adapter'=>function($serviceManager) {
				$dbAdapter = $serviceLocator->get('Application\Core\PdoAdapter');
				return $dbAdapter->getZendAdapter();
			},
		),
	),
);

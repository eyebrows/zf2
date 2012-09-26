<?php
return array(
	'controllers'=>array(
		'factories'=>array(
			'Library\Controller\Library'=>function($serviceManager) {
				$service = new \Application\Core\CommonServiceFactory();
				$service->setController('\Library\Controller\LibraryController');
				return $service->createService($serviceManager);
			},
		),
//this was from before I was using my CommonServiceFactory to inject the dbadapter
//		'invokables'=>array(
//			'Library\Controller\Library'=>'Library\Controller\LibraryController',
//		),
	),
	'router'=>array(
		'routes'=>array(
			'library'=>array(
				'type'=>'segment',
				'options'=>array(
					'route'=>'/library[/:action][/:id]',
					'constraints'=>array(
						'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
						'id'=>'[0-9]+',
					),
					'defaults'=>array(
						'controller'=>'Library\Controller\Library',
						'action'=>'index',
					),
				),
			),
		),
	),
	'view_manager'=>array(
		'template_path_stack'=>array(
			'library'=>__DIR__.'/../view',
		),
	),
);

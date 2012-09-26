<?php
namespace Library\Mapper;

use Application\Core;
use Library\Model;

class Usertype extends Core\AbstractMapper {

	protected $entityTable = 'usertypes';
	protected $usersMapper;

	public function __construct(Core\PdoAdapter $adapter, User $usersMapper=null) {
		if($usersMapper)
			$this->usersMapper = $usersMapper;
		parent::__construct($adapter);
	}

	protected function createEntity(array $row) {
		if($this->usersMapper)
			$users = new Core\EntityPlaceholder($this->usersMapper, array('usertype_id'=>$row['id']));
		return new Model\Usertype($row['id'], $row['name'], isset($users)?$users:null);
	}
}

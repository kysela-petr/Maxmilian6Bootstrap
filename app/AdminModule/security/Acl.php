<?php

namespace AdminModule\Security;

use Nette\Security\Permission;

class Acl extends Permission
{
    public function __construct()
    {
        // roles
		$this->addRole('editor');
        $this->addRole('admin', 'editor');
		$this->addRole('root');

        // resources
        $this->addResource('Admin:Homepage');

        // privileges
		$this->allow('editor', Permission::ALL, Permission::ALL);
        $this->allow('admin', Permission::ALL, Permission::ALL);
        
		$this->allow('root', Permission::ALL, Permission::ALL);
    }
}


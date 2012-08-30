<?php

namespace Maxmilian\Security;

use Nette\Security\Permission;

class Acl extends Permission
{
    public function __construct()
    {
        // roles
		$this->addRole('quest'); // normální návštěvník aplikace
        $this->addRole('customer', 'quest'); // registrovaný návštěvník aplikace
        $this->addRole('editor', 'customer'); // správce aplikace s omezenými právy
        $this->addRole('admin', 'editor'); // administrátor aplikace
        $this->addRole('root', 'admin'); // super administrátor aplikace

        // resources
        $this->addResource('Front:Homepage');

        // privileges
		$this->allow('quest', Permission::ALL, Permission::ALL);
    }
}


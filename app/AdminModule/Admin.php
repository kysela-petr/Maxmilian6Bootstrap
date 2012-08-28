<?php

namespace AdminModule;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * Admin
 * =====
 * Základní třída modulu administrace Maxmilian (http://www.kysela.biz/maxmilian)
 *
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Admin
 * @package Admin
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0
 */
class Admin
{

	/**
	 * Vytvoření rout pro modul administrace
	 * @param \Nette\Application\Routers\RouteList $router
	 * @param string $prefix | část URL adresy "/_admin/"
	 */
	static function createRoutes(\Nette\Application\Routers\RouteList $router, $prefix)
    {
        $router[] = $admin = new RouteList('Admin');
                    $admin[] = new Route($prefix . 'index.php', 'Homepage:default');
    }
	
}
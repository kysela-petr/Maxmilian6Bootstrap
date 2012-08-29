<?php

namespace FrontModule;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * Front
 * =====
 * Základní třída modulu frontendu Maxmilian (http://www.kysela.biz/maxmilian)
 *
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Front
 * @package Front
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0
 */
class Front
{

	/**
	 * Vytvoření rout pro modul frontendu
	 * @param \Nette\Application\Routers\RouteList $router
	 * @param string $prefix | část URL adresy "/_admin/"
	 */
	static function createRoutes(\Nette\Application\Routers\RouteList $router, $prefix)
    {
        $router[] = $admin = new RouteList('Front');
                    $admin[] = new Route($prefix . '<presenter>/<action>[/<id>]', 'Homepage:default');
    }
	
}
<?php

namespace FrontModule;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * Front
 * =====
 * Základní třída s nastavením Front Modulu
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Class
 * @package Maxmilian\Front
 * @uses BasePresenter
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0, 29.8.2012
 */
class Front extends \Nette\Object
{

	/**
	 * Vytvoření rout pro modul frontendu
	 * @param \Nette\Application\Routers\RouteList $router
	 * @param string $prefix | část URL adresy, například: front/
	 */
	static function createRoutes(\Nette\Application\Routers\RouteList $router, $prefix)
    {
        $routs = new RouteList('Front');
        $routs[] = new Route($prefix . '<presenter>/<action>[/<id>]', 'Homepage:default');
        $router[] = $routs;
    }
	
}
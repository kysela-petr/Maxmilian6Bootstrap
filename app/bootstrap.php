<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;


// Load Nette Framework
require LIBS_DIR . '/Nette/loader.php';


// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setDebugMode(FALSE);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(TEMP_DIR);
$loader = $configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

// Pannels
Extras\Debug\ComponentTreePanel::register();
Panel\ServicePanel::register($container, $loader);

// Setup router
$container->router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);

	// FrontModule Router
	FrontModule\Front::createRoutes($container->router, '');

    // AdminModule Router
	AdminModule\Admin::createRoutes($container->router, '_admin/');


// Configure and run the application!
$container->application->run();

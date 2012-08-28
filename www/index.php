<?php

// uncomment this line if you must temporarily take down your site for maintenance
// require '.maintenance.php';

// absolute filesystem path to this web root
define('WWW_DIR', __DIR__);

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/../app');

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../libs');

// absolute filesystem path to the temp dir
define('TEMP_DIR', WWW_DIR . '/../temp');

// absolute filesystem path to the web temp
define('WEB_TEMP_DIR', WWW_DIR . '/webTemp');

// load bootstrap file
require APP_DIR . '/bootstrap.php';

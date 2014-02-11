<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
if($_SERVER['APPLICATION_ENV']=='development'){
   error_reporting(E_ALL);
   ini_set("display_errors",1);
}

chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();

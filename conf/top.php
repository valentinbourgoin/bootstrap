<?php

/* 
 * Settings
 */
require_once 'settings.php';

/* 
 * Libs
 */
require_once LIB_PATH . 'Twig/Autoloader.php';
require_once LIB_PATH . 'database.class.php';
require_once LIB_PATH . 'tools.class.php';
require_once LIB_PATH . 'mail.class.php';
require_once LIB_PATH . 'model.class.php';
require_once LIB_PATH . 'controller.class.php';

/* 
 * Models
 */
spl_autoload_register(array('Model', 'autoload'));
spl_autoload_register(array('Controller', 'autoload'));

require 'urls.php';
require 'init.php';


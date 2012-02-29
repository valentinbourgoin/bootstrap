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
require_once LIB_PATH . 'object.class.php';

/* 
 * Models
 */
spl_autoload_register(array('Tools', 'autoload'));

require 'init.php';


<?php


/*
 * BDD 
 */
define('DB_SERVER', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_BASE', '');

/*
 * Paths
 */
define('ROOT_URL', 'http://localhost:8888/');
define('ROOT_PATH', realpath('.')."/");
define('APP_URL', '');
define('UPLOAD_PATH', ROOT_PATH . 'media/');

define('LIB_PATH', 'lib/');
define('MODEL_PATH', 'models/');
define('TEMPLATE_PATH', 'templates/');
define('TEMPLATEC_PATH', 'templates/_compiled/');
define('MEDIA_URL', ROOT_URL . 'media/');

/*
 * Facebook App
 */
define('APPID', '');
define('APIKEY', '');
define('SECRET', '');


/*
 * Types
 */
define('TYPE_INT', 1);
define('TYPE_STR', 2);
define('TYPE_TEXT', 3);
define('TYPE_DATE', 4);


/*
 * DEBUG
 */
define('DEBUG_TPL', true);
define('DEBUG', true);
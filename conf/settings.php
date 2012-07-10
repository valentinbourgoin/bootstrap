<?php


/*
 * BDD 
 */
define('DB_SERVER', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_BASE', '');
define('DB_PORT', '');

/*
 * Paths
 */
define('ROOT_URL', '/YOUR_PATH/');
define('ROOT_PATH', realpath('.')."/");
define('APP_URL', '');
define('UPLOAD_PATH', ROOT_PATH . 'media/');

define('LIB_PATH', 'lib/');
define('MODEL_PATH', 'models/');
define('CONTROLLER_PATH', 'controllers/');
define('TEMPLATE_PATH', 'templates/');
define('TEMPLATEC_PATH', 'templates/_compiled/');
define('MEDIA_URL', ROOT_URL . 'media/');
define('STATIC_URL', ROOT_URL . 'static/');

/*
 * Facebook App
 */
define('APPID', '');
define('APIKEY', '');
define('SECRET', '');


/*
 * Types
 */
define('TYPE_INT', 'INTEGER(11)');
define('TYPE_STR', 'VARCHAR(255)');
define('TYPE_TEXT', 'TEXT');
define('TYPE_DATE', 'DATETIME');


/*
 * DEBUG
 */
define('DEBUG_TPL', true);
define('DEBUG', true);
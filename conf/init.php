<?php

/*
 * Twig
 */
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(TEMPLATE_PATH);
$twig_params = array(
    'cache' => TEMPLATEC_PATH,
);
$twig_params['debug'] = DEBUG_TPL;

$twig = new Twig_Environment($loader, $twig_params);

$escaper = new Twig_Extension_Escaper(false);
$twig->addExtension($escaper);

/*
 * Globals
 */
$twig->addGlobal('DEBUG', DEBUG);
$twig->addGlobal('MEDIA_URL', MEDIA_URL);
$twig->addGlobal('STATIC_URL', STATIC_URL);
$twig->addGlobal('ROOT_URL', ROOT_URL);
$twig->addGlobal('APPID', APPID);
$twig->addGlobal('APP_URL', APP_URL);
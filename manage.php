<?php

require 'conf/top.php';

$mode = (isset($_SERVER["argv"][0])) ? 'SHELL' : 'HTTP';
if($mode == "HTTP") exit;

$cmd = $_SERVER["argv"][1];
switch($cmd) {
	/*
	 * Syncdb
	 */
	case 'syncdb': 
		if($handle = opendir(MODEL_PATH)) {
			while (false !== ($model = readdir($handle))) {
				preg_match('/(?P<model>\w+).class.php/', $model, $matches);
				if(sizeof($matches) > 0) { 
					$c = ucfirst($matches['model']);
					$instance = new $c();
					$instance->createTable();
					echo 'Synchronisation de la classe ' . $c . "... \n";
				}
		    }
			closedir($handle);
		} else {
			'Erreur : répertoire ' . MODEL_PATH . ' introuvable' . " \n";
		}
		break;
}

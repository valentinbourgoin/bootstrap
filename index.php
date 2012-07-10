<?php

require 'conf/top.php';

if(isset($urls[$_SERVER['PATH_INFO']])) {
	$c = $urls[$_SERVER['PATH_INFO']];
	new $c();
} else {
	new ErrorController();
}
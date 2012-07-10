<?php

class IndexController extends Controller {
    protected $name     = 'index';
    protected $template = 'index.html';
  
  	public function init() {
  		$this->assign('hello', 'hello');
  		parent::init();
  	}
	
    
}
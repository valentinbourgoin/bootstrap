<?php

class IndexController extends Controller {
    protected $name     = 'index';
    protected $template = 'index.html';
  
  	public function init() {
		$this->vars = array(
			'first_var' => 'hello',
		);
  		$this->display();
  	}
	
    
}
<?php

abstract class Controller {
    protected $name;
    protected $vars;
    protected $template;

    protected $formvars;

    /* 
	 * Controller construct
	 */
    public function __construct() {
        if(empty($this->vars)) $this->vars = array();
        if(empty($this->formvars)) $this->formvars = array();
		if(!empty($formvars) && !empty($_POST)) $this->doForm();
        $this->init();
    }

	/*
	 * Init controller
	 * In case of form submission, call doForm() method
	 */
    public function init() {
        $this->display();
    }

	/*
	 * Form treatmenent
	 */
    public function doForm() { }

    
    /*
	 * Display template
	 */
    public function display() {
        global $twig;
        $tpl = $twig->loadTemplate($this->template);
        $tpl->display($this->vars);
    }
    

    /*
     * Load controller classes
     * @param classname Class name
     */
    public static function autoload($className) {
        if(!class_exists($className)) {
            if(is_readable(ROOT_PATH.CONTROLLER_PATH.strtolower($className).".class.php")) {
                require_once(ROOT_PATH.CONTROLLER_PATH.strtolower($className).".class.php");
            }
        }
    }

}
?>

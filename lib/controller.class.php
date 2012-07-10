<?php

abstract class Controller {
    protected $name;
    protected $vars;
    protected $template;

    protected $formvars;

    /*
     * Global
     */
    # Constructeur
    public function __construct() {
        if(empty($this->vars)) $this->vars = array();
        if(empty($this->formvars)) $this->formvars = array();
        $this->init();
    }

    public function init() {
        if(!empty($formvars) && !empty($_POST)) $this->doForm();
        $this->display();
    }

    public function doForm() { }

    public function assign($name, $value) {
        $this->vars[$name] = $value;
    }
    
    public function display() {
        global $twig;
        $tpl = $twig->loadTemplate($this->template);
        $tpl->display($this->vars);
    }
    

    /*
     * Chargement automatique des classes (models)
     * @param classname Nom de la classe
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

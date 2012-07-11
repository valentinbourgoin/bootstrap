<?php

abstract class Model implements ArrayAccess {
    protected $tablename;
    protected $fields;

    /*
     * Global
     */
    # Constructeur
    public function __construct($id='', $autoload=true, $params=array()) {
        $this->init($id, $params);
        if($autoload && !empty($id) && ctype_digit((string)$id)) {
            $this->load();
        }
    }
    
    public function init($id='', $params=array()) {
        if(!empty($id) && ctype_digit((string)$id)) {
            $this->id = $id;
            if(sizeof($params) > 0) {
                foreach($params as $k=>$v) {
                    if(Tools::checkField($k, $this->fields))
                        $this->$k = Tools::prepareField($v);
                }
                $this->loaded = true;
            }
        }
    }


    # Chargement
    public function load() {
        $r = new ReflectionObject($this);
        $sql = 'SELECT * FROM ' . $this->tablename . ' WHERE id = ' . $this->id;
        $result = Database::getInstance()->fetch($sql);
        if(sizeof($result) > 0) {
            foreach($result[0] as $k=>$v) {
                if(Tools::checkField($k, $this->fields))
                    $this->$k = Tools::prepareField($v);
            }
            $this->loaded = true;
        }
    }

    # Sauvegarde
    public function save() {
        $r = new ReflectionObject($this);
        if(empty($this->id)) {
            $sql = 'INSERT INTO `' . $this->tablename . '` (';
            foreach($this->fields as $k=>$field) {
                $sql .= '`' . $field[0] . '`';
				if($k != count($this->fields)-1) $sql .= ', ';
            }
            $sql .= ') VALUES (';
            foreach($this->fields as $k=>$field) {
                if(isset($this->$field[0])) $value = $this->$field[0];
                else $value = '';
                $sql .= '\'' . Tools::protectField($value, $field[1]) . '\'';
                if($k != count($this->fields)-1) $sql .= ', ';
            }
            $sql .= ')';
            $result = Database::getInstance()->exec($sql);
            $this->id = Database::getInstance()->getInsertedId();
        } else {
            $sql = 'UPDATE `' . $this->tablename . '` SET ';
            foreach($this->fields as $k=>$field) {
                if(isset($this->$field[0])) $value = $this->$field[0];
                else $value = '';
                $sql .= '`' . $field[0] . '`=\'' . Tools::protectField($value, $field[1]) . '\'';
                if($k != count($this->fields)-1) $sql .= ', ';
            }
            $sql .= ' WHERE id = ' . $this->id;
            return Database::getInstance()->exec($sql);
        }
    }

    # Suppression
    public function delete() {
        $r = new ReflectionObject($this);
        $sql = 'DELETE FROM ' . $this->tablename . ' WHERE id = ' . $this->id . ' LIMIT 1';
        return Database::getInstance()->exec($sql);
    }

    # Creation 
    public function createTable() {
        $r = new ReflectionObject($this);
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->tablename . '` (';
        foreach($this->fields as $k=>$field) {
            $sql .= '`' . $field[0] . '` ' . $field[1] . ' NOT NULL';
            if($k == 0) $sql .= ' AUTO_INCREMENT PRIMARY KEY';
            if($k != count($this->fields)-1) $sql .= ', ';
        }
        $sql .= ')';
        return Database::getInstance()->exec($sql);
    }

    # Affichage
    public function __toString() {
        $str = '<object ' . $this->getClass() . '>' . "\n";
        foreach($this->fields as $f) {
            if(isset($this->$f)) $value = $this->$f;
            else $value = '';
            $str .= '     ' . $f . ' => ' . $value . "\n";
        }
        $str .= '</object>';
        return $str;
    }
   
    /*
     * Array Access
     */
    public function offsetExists($o) {
        $r = new ReflectionObject($this);
        return isset($this->$o);
    }

    public function offsetGet($o) {
       $r = new ReflectionObject($this);
        try {
            return $r->getMethod("get".ucfirst($o))->invoke($this);
        } catch(Exception $e) {
            if(!isset($this->$o)) $this->load();
            return $this->$o;
        }
    }

    public function offsetSet($o, $v) {
        $r = new ReflectionObject($this);
		return $this->$o = $v;
    }

    public function offsetUnset($o) {
        unset($this->$o);
    }

    /*
     * Serialisation
     */
    public function __sleep() {
        $r = new ReflectionObject($this);
        $properties = array();
        foreach($r->getProperties() as $prop) {
            $name = $prop->getName();
            if(@$this->$name) {
                $properties[] = $name;
            }
        }
        return $properties;
    }

    public function getClass(){
        $r = new ReflectionObject($this);
        return get_class($this);
    }

    public function getArray(){
        $r = new ReflectionObject($this);
        $array = array();
        foreach($r->getProperties() as $prop){
             $name = $prop->getName();
            if(@$this->$name && $name != 'fields' && $name != 'tablename') {
                $array[$name] = $this->$name;
            }

        }
        return $array;
    }

    public function getUrlEncode() {
        $r = new ReflectionObject($this);
        return urlencode(urlencode($this->__toString()));
    }
	
	public function getJSON() {
		return json_encode($this->getArray());
	}

    /*
     * Chargement automatique des classes (models)
     * @param classname Nom de la classe
     */
    public static function autoload($className) {
        if(!class_exists($className)) {
            if(is_readable(ROOT_PATH.MODEL_PATH.strtolower($className).".class.php")) {
                require_once(ROOT_PATH.MODEL_PATH.strtolower($className).".class.php");
            }
        }
    }

}
?>

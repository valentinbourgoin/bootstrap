<?php

class Tools {
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

    /*
	 * Protège un champ avant l'insert dans la BDD 
	 * @param value Champ à protéger
     * @param type Type de champ (text, int, string...)
	 * @param length Longueur max (SQL) du champ
	 */
	public static function protectField($value, $type=TYPE_TEXT, $length=null) {
		$db = Database::getInstance();
		if($type == TYPE_INT) {
			$value = intval($value);
		} elseif($type == TYPE_STR) {
			$value = (string) $value;
		} elseif($type == TYPE_TEXT) {
            $value = (string) $value;
        }
        if($length != null) {
            $value = substr($value, 0, $length);
        }
        $value = mysql_real_escape_string($value);
        if(DEBUG) {
            $value = utf8_decode($value);
        }
		return stripslashes($value);
	}
    
	/*
	 * Protège un champ une fois chargé depuis la base de données
	 * @param value Chaîne retournée
	 */
    public static function prepareField($value) {
        if(DEBUG) {
            $value = utf8_encode($value);
        }
        return $value;
    }
    
	/*
	 * Vérifie si une variable est présente dans les champs de la base de données
	 * @param value Champ recherché
	 * @param fields Tableau de champs ([name, type])
	 */
    public static function checkField($value, $fields) {
        foreach($fields as $f) {
            if($value == $f[0]) return true;
        }
        return false;
    }

    /*
     * Récupère la vraie adresse IP
     */
    public static function getIpAddress(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    /*
     * Uploade une image
     * @param nom du champ (FILE)
     * @param répertoire d'upload
     */
    public static function upload($name, $dir) {
         $tmp_file = $_FILES[$name]['tmp_name'];
         if(!is_uploaded_file($tmp_file)) {
            return '';
         }
         $upload_path = str_replace('admin/', '', UPLOAD_PATH);
         if(!is_dir($upload_path . $dir)) {
             mkdir($upload_path . $dir, 0777);
         }
         $name_file = $_FILES[$name]['name'];
         if(!move_uploaded_file($tmp_file, $upload_path . $dir . $name_file)) {
             return '';
         }
         return $dir . $name_file;
    }
	
	/*
     * Vérifie les paramètres passés
     * @param params Liste des champs attendus
     * @param request POST ou GET
     */
    public static function checkService($params, $request) {
		$params[] = 'jsonp';
		$params[] = '_';
        //if(sizeof($params) != sizeof($request)) return false;
        foreach($request as $k=>$v) {
            if(!in_array($k, $params)) return false;
        }
        return true;
    }

    /*
     * Protège un champ CSV
     */
    public static function escapeCSV($str) {
        return str_replace(';', '', str_replace("\n", '', $str));
    }
	
	/*
	 * Supprime toute mise en forme 
	 * @param value Chaîne à traiter
	 */
	public static function escapeFormat($value) {
		return str_replace(array("\n", "\r", "\t"), '', $value);
	}
    
    /*
     * Conversion d'une date
     * @param date Chaine de caractère d'une date
     * @param input Format d'entrée
     * @param format Format de sortie
     * TODO : Prévoir d'autres formats
     */
    public function convertDate($date, $input, $output) {
        if($input == 'dd/mm/yyyy') {
            $d = substr($date, 0, 2);
            $m = substr($date, 3, 2);
            $y = substr($date, 6, 4);
        }
        if($output == 'yyyy-mm-dd') {
            return $y . '-' . $m . '-' . $d;
        }
    }

    /*
     * Temps relatif
     */
    public static function plural($num = NULL) {
        if ($num != 1) return "s";
    }
    public static function relative_time($date = NULL) {
        $diff = time() - strtotime($date);
            if ($diff<60)
                return "il y a ". $diff . " seconde" . Tools::plural($diff);
                    $diff = round($diff/60);
                    if ($diff<60)
                            return "il y a ". $diff . " minute" . Tools::plural($diff);
                    $diff = round($diff/60);
                    if ($diff<24)
                        return "il y a environ ". $diff . " heure" . Tools::plural($diff);
                    $diff = round($diff/24);
                    if ($diff<7)
                            return "il y a ". $diff . " jour" . Tools::plural($diff);
                    $diff = round($diff/7);
                    if ($diff<4)
                            return "il y a ". $diff . " semaine" . Tools::plural($diff);
                    return "le " . date("F j, Y", strtotime($date));
	}
	
	
	public static function generateJSON($json, $data) {
		if(!isset($data['jsonp']) || !isset($data['_'])) return false;
		return $data['jsonp'] . '(' . $json . ')';
	}

}
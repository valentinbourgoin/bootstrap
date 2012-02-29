<?php

class User extends Object {
    protected $tablename = 'user';
    protected $fields = array(
        array('id', TYPE_INT),
        array('username', TYPE_STR),
        array('mail', TYPE_STR),
        array('password', TYPE_STR),
        array('key_id', TYPE_STR),
        array('added', TYPE_DATE)
    );

    public function __toString() {
        return $this->username;
    }

    public function save() {
        if(empty($this->added)) $this->added = date('Y-m-d H:i:s');
        return parent::save();
    }
	
	public function getStats() {
		# Main stats
		$sql = 'SELECT us.victories_nb, us.defeats_nb, us.kills_nb, us.shots_nb, us.deaths_nb, us.credit, ur.rank, us.total_time, COUNT(ua.id) AS achievments_nb
				FROM user_stats us
				  LEFT JOIN rank ur ON ur.user_id = us.user_id 
				  LEFT JOIN user_achievment ua ON ua.user_id = us.user_id
				WHERE us.user_id = ' . Tools::protectField($this->id) . '
				  AND ur.added >= "' . date('Y-m-d') . '" 
				LIMIT 1';
		$result = Database::getInstance()->fetch($sql);
		if(sizeof($result) > 0) {
			foreach($result[0] as $k=>$v) {
				$this->$k = $v;
			}
		} 
		
		# Loyalty
		$sql = 'SELECT l.loyalty, l.corpo_id
				FROM user_stats_loyalty l
				  INNER JOIN user_stats us ON l.user_stats_id = us.id
				WHERE us.user_id = ' . Tools::protectField($this->id);
		$result = Database::getInstance()->fetch($sql);
		foreach($result as $line) {
			$this->loyalty[] = array(
								'corpo_id' => $line['corpo_id'],
								'loyalty'  => $line['loyalty']
							);
		}
	}
	
	public function getRankings($date, $nb) {
		$sql = 'SELECT * 
				FROM rank
				WHERE user_id = ' . Tools::protectField($this->id) . '
				  AND added <= "' . Tools::protectField($date) . '"
				ORDER BY added DESC
				LIMIT ' . Tools::protectField($nb);
		$result = Database::getInstance()->fetch($sql);
		$table = array();
		foreach($result as $line) {
			$table[] = new Rank($line['id'], false, $line);
		}
		return $table;
	}


    /*
     * Récupération d'un utilisateur en fonction de son mail
     * @param email E-mail
     */
    public static function getByUsername($username) {
        $sql = 'SELECT * FROM user WHERE username = "'.$username.'" LIMIT 1';
        $result = Database::getInstance()->fetch($sql);
        if(sizeof($result) > 0) {
            return new User($result[0]['id'], false, $result[0]);
        }
        return false;
    }
	
    /*
     * Récupération de tous les utilisateurs
     * @param order L'ordre
     * @param nb Limite
     * @param offset Offset
     */
    public static function getUsers($order='RAND()', $nb=1000000, $offset=0) {
        $sql = "SELECT u.*
                    FROM user u
                    ORDER BY ".$order."
                    LIMIT ".$nb."
                    OFFSET ".$offset;
        $array = array();
        $result = Database::getInstance()->fetch($sql);
        foreach($result as $line) {
            $array[] = new User($line['id'], false, $line);
        }
        return $array;
    }
	
	public static function login($username, $password) {
		$sql = "SELECT id
				FROM user
				WHERE username = '" . $username . "'
				AND password = '" . md5($password) . "' 
				LIMIT 1";
		$result = Database::getInstance()->fetch($sql);
		if(sizeof($result) > 0) {
			return new User($result[0]['id'], $result[0]);
		}
		return false;
	}
	
	public static function getUserByUsername($username) {
		$sql = "SELECT id
				FROM user
				WHERE username = '" . $username . "'
				LIMIT 1";
		$result = Database::getInstance()->fetch($sql);
		if(sizeof($result) > 0) {
			return new User($result[0]['id'], $result[0]);
		}
		return false;
	}
	
    
}
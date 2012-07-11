<?php

/**
 * \file		database.class.php
 * \author		Valentin
 * \version   	1.0
 * \date		juillet 2012
 * \brief       MySQL database class
 *
 * \details		Access to the MySQL server (singleton)           
 */
class Database { 
 	private static $instance;
	private $queries;
	private $db;
 
	/**
	 * \brief		Constructor
	 * \details		MySQL connection & instanciation
	 */
	private function __construct() {	
		 try {
            $this->db = mysql_connect(DB_SERVER . ':' . DB_PORT, DB_USER, DB_PASS);
			mysql_select_db(DB_BASE, $this->db);
        } catch(Exception $e) {
            die("Database not found");
        }
    }
	
	/**
	 * \brief		Destructor
	 * \details		MySQL disconnection
	 */
	public function __destruct() {
		mysql_close($this->db);
		$this->instance = null;
	}
		
	/**
	 * \brief		Get singleton instance
	 * \details		If the database connection is inactive : connection. 
	 * \return 		Return instace of Database object
	 */
	static function getInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new Database;
		}
		return self::$instance;
	}
	
	/**
	 * \brief		Fetch SQL results
	 * \param		SQL query
	 * \return 		Associative array
	 */
	public function fetch($sql) {
		$result = mysql_query($sql);	
		$results = array() ;
		while ($ligne = @mysql_fetch_array($result)) array_push($results,$ligne);
		@mysql_free_result($result) ;
		$this->queries[] = $sql;
		return $results ;
	}
	
	/**
	 * \brief		Execute SQL query
	 * \details		No results fetched : only for UPDATE, DELETE, CREATE queries
	 * \param		SQL query
	 * \return 		Boolean
	 */
	public function exec($sql) {
		$result = mysql_query($sql);	
		@mysql_free_result($result) ;
		$this->queries[] = $sql;
		return $result ;
	}
	
	/**
	 * \brief		Get executed query 
	 * \details		Get all the instance queries
	 * \return 		Array of query strings
	 */
	public function getQueries() {
		return $this->queries;
	}
	
	/**
	 * \brief		Get last inserted entry ID
	 * \details		For autoincrements fields
	 * \return 		ID
	 */
	public function getInsertedId() {
		return mysql_insert_id();
	}

}

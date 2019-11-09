<?php

class Model{
	protected $db;
	public function __construct(){
		global $config;
		$this->db = new PDO('mysql:host=localhost;dbname='.$config["database"].';charset=utf8', $config["user"], $config["password"]);
   		if (!$config["envProd"]) $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	}

}
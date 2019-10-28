<?php

class Back{
	
	public function __construct($uri){
		global $securite;
		if (method_exists($uri[0])) $todo = $uri[0];
		else $todo = "accueilAdmin";
		if (! $securite->sessionValid() ) $todo = "login";
		$this->$todo();
	}

	private function edite_chapitre(){
	}

	private function accueilAdmin(){

	}

	private function login(){

	}
}
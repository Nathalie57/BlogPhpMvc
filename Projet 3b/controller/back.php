<?php

require_once "model/chapitremodel.php";
require_once "view/view.php";
require_once "controller/post.php";

class Back{
	
	private $chapitremodel;
	private $post;

	public function __construct($uri){
		global $securite;
		if (method_exists($this, $uri[0])) $todo = $uri[0];
		else $todo = "accueilAdmin";
	//	if (! $securite->sessionValid() ) $todo = "login";
	//	$this->$todo();
	
	$content = [
		"{{ content }}"=>$this->html,
		"{{ title }}"=>$this->title
	];
	
	$view = new View($content, "admin");
	$this->html = $view->html;

	}

	private function accueilAdmin(){
		$this->html = file_get_contents("template/admin.html");
		$this->title = "Administrateur ?";
	}
	
	private function edite_chapitre(){
	}

	

	private function login(){

	}
}
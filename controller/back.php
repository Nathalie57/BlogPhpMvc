<?php

require_once "model/chapitremodel.php";
require_once "model/adminmodel.php";
require_once "view/view.php";
require_once "controller/post.php";
require_once "controller/adminpost.php";
require_once "controller/admincomment.php";
require_once "controller/admin.php";

class Back{
	
	public $html;
	private $title;

	public function __construct($uri){

		$this->admin = new Admin();

		if (isset($uri[0])) $todo = $uri[0]; 
		else $todo = "accueilAdmin";

		if (!method_exists($this, $todo)) $todo = "accueilAdmin";

		if($this->admin->id === null) $todo = "showLogin";
		$argument = null;
		if (isset($uri[1])) $argument = $uri[1];

   		$this->$todo($argument);
			
		$content = [
			"{{ content }}"=>$this->html,
			"{{ title }}"=>$this->title,
			"{{ login }}"=>$this->admin->name
		];

		$view = new View($content, "admin");
		$this->html = $view->html;
	}
	
	private function deconnexion(){
		$this->admin->clearSession();
		global $config;
		header('Location: /'.$config['directory'].'/admin');
	}

	private function showlogin(){

		$this->html = file_get_contents("template/formLogin.html");
		$this->title = "Connexion";
	}

	public function accueilAdmin(){

		$adminpost = new AdminPost();
		$writeNewPost = new AdminPost();
		$updatePost = new AdminPost();
	
		global $safeData;
			if (!is_null($safeData->post["title"])) {
				$updatePost = $adminpost->updateFeaturedPost();
				$writeNewPost->writePost($safeData->post["idChapitre"], $safeData->post["title"], $safeData->post["content"], $safeData->post["slug"]);
				global $config;
				header('Location: /'.$config['directory'].'/admin');
			}
	
		$content = $adminpost->showAdminListPost();
		$admincomment = new AdminComment();
		$content .= $admincomment->showNewComment();
		$content .= $admincomment->showReportComment();

		$this->html = $content;
		$this->title = "Accueil";

	}
	
	private function editeChapitre($slug){
		$chapitre = new AdminPost();
		$updatePost = new AdminPost();
		
		$content = $chapitre->showUpdatePost($slug);

		global $safeData;
			if (!is_null($safeData->post["title"])) {
				$updatePost->makeUpdatePost($safeData->post["title"], $safeData->post["content"], $safeData->post["slug"], $safeData->post["ID"]);

				global $config;
				header('Location: /'.$config['directory'].'/admin');
			}
			else $this->ack = ["Votre chapitre n'a pas pu être enregistré. Veuillez réessayer !"];

		$this->html = $content;
       	$this->title = "Modifier le chapitre";
	}

	private function effaceChapitre($slug){
		$chapitre = new AdminPost();
		$chapitre->deletePost($slug);
		global $config;
		header('Location: /'.$config['directory'].'/admin');
	}

	private function effaceCommentaire($idComment){
		$comment = new AdminComment();
		$comment->deleteComment($idComment);
		global $config;
		header('Location: /'.$config['directory'].'/admin');
	}

	private function valideNouveauCommentaire($idComment){
		$comment = new AdminComment();
		$comment->validateNewComment($idComment);
		global $config;
		header('Location: /'.$config['directory'].'/admin');
	}

	private function valideCommentaireSignale($idComment){
		$comment = new AdminComment();
		$comment->validateReportComment($idComment);
		global $config;
		header('Location: /'.$config['directory'].'/admin');
	}
}	



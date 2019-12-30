<?php
require_once "model/chapitremodel.php";
require_once "view/view.php";
require_once "controller/post.php";
require_once "controller/comment.php";
require_once "controller/messageview.php";

class Front{
	private $chapitremodel;
	private $post;
	private $ack;

	public function __construct ($uri){
		$this->chapitremodel = new ChapitreModel();
	
		switch ($uri[0]){
			case "quisuisje":
				$this->biographie();
				break;
			case "chapitre":
				$this->chapitre(array_slice($uri, 1));
				break;
			case "chapitres":
				$this->chapitres();
				break;
			default :
				$this->accueil();
				break;
		}
		if (isset($this->ack)) {
			$view = new MessageView($this->ack);
			$this->html = $view->html.$this->html;
		}

      	$content = [
			"{{ content }}"=>$this->html,
			"{{ title }}"=>$this->title,
			];

		$view = new View($content, "index");
		$this->html = $view->html;
	}

	private function biographie(){
		$this->html = file_get_contents("template/biographie.html");
		$this->title = "Qui je suis ?";
	}

	private function chapitre($uri){
		if (empty($uri)) {
			global $config;
			header("Location: /".$config['directory']);
		}
		//die(var_dump($uri));
		if ($uri[0]==="") {
			global $config;
			header("Location: /".$config['directory']);
		}

		$slug = $uri[0];
		$chapitre = new Post();
		$comment = new Comment();
		$view = new MessageView();
		if(isset($uri[1])) $comment->reportComment($uri[1]);
		$content = $chapitre->showSinglePost($slug);
		$content .= $comment->countValidateComment($chapitre->idPost);
		$content .= $comment->showValidateComment($chapitre->idPost);
	//	$content .= $comment->showDefinitiveComment($chapitre->idPost);
		

		global $safeData;
		if (!is_null($safeData->post["author"])) {
			$comment->addComment($safeData->post["author"], $safeData->post["comment"], $chapitre->idPost);
			header("Location: #");}
			
			/*$this->ack = [
				"message" => "Votre commentaire a bien été enregistré",
				"type" => "success"
			];
		}
		else $this->ack = ["Votre commentaire n'a pas pu être enregistré. Veuillez réessayer !"];*/
		
		
		$this->html = $content;
       	$this->title = $chapitre->title;
	}

	private function chapitres(){
		$chapitres = new Post();
		$content = $chapitres->showListPost();
		$this->html = $content;
       	$this->title = "Tous les chapitres";
	}

	private function accueil(){
        $home = new Post();
        $content = $home->showFeaturedPost();
        $this->html = $content;
        $this->title = "La nouvelle histoire de Jean Forteroche";
    }
	
	private function signalerCommentaire($idComment){
		$comment = new Comment();
		$content = $comment->reportComment($idComment);
	}

}
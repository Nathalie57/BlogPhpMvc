<?php
require_once "model/chapitremodel.php";
require_once "view/view.php";
require_once "controller/post.php";
require_once "controller/comment.php";


class Front{
	private $chapitremodel;
	private $post;

	public function __construct ($uri){
		$this->chapitremodel = new ChapitreModel();
	
		switch ($uri[0]){
			case "quisuisje":
				$this->biographie();
				break;
			case "chapitre":
				$this->chapitre($uri[1]);
				break;
			case "chapitres":
				$this->chapitres();
				break;
			default :
				$this->accueil();
				break;
		}
      	$content = [
			"{{ content }}"=>$this->html,
			"{{ title }}"=>$this->title
		];

		$view = new View($content, "index");
		$this->html = $view->html;
	}
	
	private function biographie(){
		$this->html = file_get_contents("template/biographie.html");
		$this->title = "Qui je suis ?";
	}

	private function chapitre($slug){
		$chapitre = new Post();
		$comment = new Comment();
		$content = $chapitre->showSinglePost($slug);
		$content .= $comment->showComment($chapitre->idPost);
		$this->html = $content;
       	$this->title = $chapitre->title;
       
  /* return [
      "{{ content }}"=>$content
    ];*/
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
       
/*   return [
      "{{ content }}"=>$content
    ];*/
    }
	

}
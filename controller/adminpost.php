<?php

require_once "model/chapitremodel.php";
require_once "view/view.php";
require_once "controller/post.php";


class AdminPost{
	public $title;
	public $idPost;


  	public function __construct(){
    $this->chapitremodel = new ChapitreModel();
  	}

public function showAdminListPost(){
	
	$adminListPost = $this->chapitremodel->listPost();
    $myview = new View($adminListPost, "adminListPost");
    $data["{{ adminListPost }}"] = $myview->html;
    $myview = new View($data, "accueilAdmin");
    $data["{{ accueilAdmin }}"] = $myview->html;
  	return $myview->html;
	}

public function writePost($idChapitre, $title, $content, $slug){

	$this->chapitremodel->newPost($idChapitre, $title, $content, $slug);
	}	

public function updateFeaturedPost(){
	$this->chapitremodel->updateFeaturedPost();
	}	

public function showUpdatePost($slug){
	$data = $this->chapitremodel->singlePost($slug);
  	$myview = new View($data, "updatePost");

  	return $myview->html;
  	}

public function makeUpdatePost($title, $content, $slug, $ID){
  	$this->chapitremodel->updatePost($title, $content, $slug, $ID);
	}

public function deletePost($slug){
	$this->chapitremodel->deletePost($slug);
}

}
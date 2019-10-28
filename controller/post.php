<?php

require_once "model/chapitremodel.php";
require_once "view/view.php";


class Post{
	private $model;
	private $view;

  	public function __construct(){
    $this->model = new ChapitreModel();
  //	$this->view = new View();
    //$this->model->featuredPost();
  	}


  	public function showFeaturedPost(){

  		$data = $this->model->featuredPost();		
  		$myview = new View($data, "featuredPost");

  		return $myview->html;
  	}

	public function allPosts(){
  		
  	}

	public function listPost(){
  		
  	}

	public function otherPost(){
  		
  		$data = $this->model->otherPost();
  		$myview = new View($data, "otherPost");

  		return $myview->html;
  	}

}
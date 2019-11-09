<?php

require_once "model/commentmodel.php";
require_once "view/view.php";


class Comment{
	private $commentmodel;
	private $view;

  	public function __construct(){
    $this->commentmodel = new CommentModel();

  	}

 public function showComment($idPost){

  		$comment = $this->commentmodel->comment($idPost);		
  		$myview = new View($comment, "comment");
  	//	$data["{{ comment }}"] = $myview->html;
  	//	$myview = new View($data, "singlePost");

  		return $myview->html;
  	}
}
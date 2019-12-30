<?php

require_once "model/commentmodel.php";
require_once "view/view.php";


class AdminComment{
	private $commentmodel;
	private $view;

  	public function __construct(){
    $this->commentmodel = new CommentModel();

  	}

/*public function showAccueilAdmin(){

      $comment = $this->commentmodel->newComment();   
      $myview = new View($comment, "newCommentTable");
      $data["{{ newCommentTable }}"] = $myview->html;
return $myview->html;
}*/

public function showNewComment(){

      $comment = $this->commentmodel->newComment();
      if($comment){		
  		    $myview = new View($comment, "newCommentTable"); 
          $data["{{ newCommentTable }}"] = $myview->html;
          $myview = new View($data, "showNewCommentTable");
  //		die(var_dump($myview));
          return $myview->html;
          } 
    	}

public function showReportComment(){

  		$comment = $this->commentmodel->reportComment();
      if($comment){    		
  		    $myview = new View($comment, "reportCommentTable");
          $data["{{ reportCommentTable }}"] = $myview->html;
          $myview = new View($data, "showReportCommentTable");
  		    return $myview->html;
          }
      //else 
    	}

public function deleteComment($idComment){

      $comment = $this->commentmodel->deleteComment($idComment);
      }

public function validateNewComment($idComment){

      $comment = $this->commentmodel->validateNewComment($idComment);
      }

public function validateReportComment($idComment){

      $comment = $this->commentmodel->validateReportComment($idComment);
      }
}
<?php

require_once "model/commentmodel.php";
require_once "view/view.php";


class AdminComment{
	private $commentmodel;

  	public function __construct(){
    $this->commentmodel = new CommentModel();

  	}

public function showNewComment(){

      $comment = $this->commentmodel->newComment();
      if($comment){		
  		    $myview = new View($comment, "newCommentTable"); 
          $data["{{ newCommentTable }}"] = $myview->html;
          $myview = new View($data, "showNewCommentTable");
  
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
    	}

public function deleteComment($idComment){

      $this->commentmodel->deleteComment($idComment);
      }

public function validateNewComment($idComment){

      $this->commentmodel->validateNewComment($idComment);
      }

public function validateReportComment($idComment){

      $this->commentmodel->validateReportComment($idComment);
      }
}
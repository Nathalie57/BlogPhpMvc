<?php

require_once "model/commentmodel.php";
require_once "view/view.php";


class Comment{
	private $commentmodel;
	private $view;

  	public function __construct(){
    $this->commentmodel = new CommentModel();

  	}


public function showValidateComment($idPost){
 
      $validateComment = $this->commentmodel->validateComment($idPost);	
    
 //     if(isset($validateComment['state'])) $state = $validateComment['state'];
      $html = "";
        foreach($validateComment as $comment){
          $state = $comment['state'];
  		    if ($state === '1') $myview = new View($comment, "comment");
              
          else $myview = new View($comment, "definitiveComment");
          $html .= $myview->html;
    //      var_dump($comment);
  	     }
       
  //   die(var_dump($html));
      return $html;
      }

/*public function showDefinitiveComment($idPost){

      $comment = $this->commentmodel->definitiveComment($idPost);   
      if ($comment) {
          $myview = new View($comment, "definitiveComment");
          return $myview->html;
          }
      }  */  

public function countValidateComment($idPost){
  	
  		$comments = $this->commentmodel->countValidateComment($idPost);
  		$pluriel = "";
      if($comments>1) $pluriel="s";
      $data = [
          "{{ nComments }}" => $comments['total'],
          "{{ pluriel }}" => $pluriel
          ];
    // die(var_dump($comments));     
      $myview = new View($data, "countComment");
  		return $myview->html;
  	}
 
public function addComment($author, $comment, $idPost){
		
		$comment = $this->commentmodel->insertComment($author, $comment, $idPost);
}

public function reportComment($idComment){

     $comment = $this->commentmodel->reportNewComment($idComment);
}

}

<?php

require_once "model/commentmodel.php";
require_once "view/view.php";


class Comment
{
    private $commentmodel;

    public function __construct()
    {
        $this->commentmodel = new CommentModel();
    }

    public function showValidateComment($idPost)
    {
        $validateComment = $this->commentmodel->validateComment($idPost);
        $html = "";
        foreach ($validateComment as $comment) {
            $state = $comment['state'];
            if ($state === '1') {
                $myview = new View($comment, "comment");
            } else {
                $myview = new View($comment, "definitiveComment");
            }
         
            $html .= $myview->html;
        }

        return $html;
    }

    public function countValidateComment($idPost)
    {
        $comments = intval($this->commentmodel->countValidateComment($idPost));
        $pluriel = "";
        if ($comments>1) {
            $pluriel="s";
        }

        $data = [
          "{{ nComments }}" => $comments,
          "{{ pluriel }}" => $pluriel
          ];
   
        $myview = new View($data, "countComment");
        return $myview->html;
    }
 
    public function addComment($author, $comment, $idPost)
    {
        $comment = $this->commentmodel->insertComment($author, $comment, $idPost);
    }

    public function reportComment($idComment)
    {
        $this->commentmodel->reportNewComment($idComment);
    }
}

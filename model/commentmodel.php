<?php
require_once "model/model.php";
class CommentModel extends Model
{
    public $result;

    public function __construct()
    {
        parent::__construct();
    }

    public function validateComment($idPost)
    {
        $sql = "SELECT 
			author AS `{{ author }}`, 
			comment AS `{{ content }}`, 
			DATE_FORMAT(date, '%d/%m/%Y') AS `{{ published }}`,
			idComment AS `{{ idComment }}`,
			state AS `state`
			
			FROM `comments` 
			WHERE `idPost` = '$idPost' AND (state = 1 OR state = 3) ORDER BY date DESC";
        
        $data = $this->db->query($sql);
        $result = $data->fetchAll();
        return $result;
    }

    public function newComment()
    {
        $sql = "SELECT 
			posts.idChapitre `{{ newidPost }}`, 
			comments.idComment `{{ idComment }}`,
			author AS `{{ newauthor }}`, 
			comment AS `{{ newcontent }}`, 
			DATE_FORMAT(date, '%d/%m/%Y') AS `{{ newpublished }}`

			FROM `comments`
			INNER JOIN `posts`
			ON comments.idPost = posts.ID
			WHERE `state`= 0 ORDER BY date DESC";

        $data = $this->db->query($sql);
        $result = $data->fetchAll();
        if (!empty($result)) {
            return $result;
        }
    }

    public function reportComment()
    {
        $sql = "SELECT 
			posts.idChapitre `{{ reportidPost }}`, 
			comments.idComment AS `{{ idComment }}`,
			author AS `{{ reportauthor }}`, 
			comment AS `{{ reportcomment }}`, 
			DATE_FORMAT(date, '%d/%m/%Y') AS `{{ reportpublished }}`
			
			
			FROM `comments` 
			INNER JOIN `posts`
			ON comments.idPost = posts.ID
			WHERE `state`= 2 ORDER BY date DESC";
        
        $data = $this->db->query($sql);
        $result = $data->fetchAll();

        return $result;
    }

    public function countValidateComment($idPost)
    {
        $sql = "SELECT COUNT(*) AS 'total'

    	FROM comments 
    	WHERE `idPost` = '$idPost' AND (state = 1 OR state = 3)";

        $data = $this->db->query($sql);
        $result = $data->fetch();
        return $result['total'];
    }

    public function insertComment($author, $comment, $idPost)
    {
        try {
            $tab = array(
            'author' => $author,
            'comment' => $comment,
            'idPost' => $idPost,
              'date' => date("Y-m-d"),
              'state' => '0');

            $sql = "INSERT INTO comments";
            $sql .= "(`".implode("`, `", array_keys($tab))."`)";
            $sql .= " VALUES ('".implode("', '", $tab)."') ";
            
            $resultat = $this->db->prepare($sql);
                  
            $affectedLines = $resultat->execute($tab);
 
            $resultat->closeCursor();
            return $affectedLines;
        } catch (Exception $e) {
            return [
             "succeed" => false,
            "data"    => $e
          ];
        }
    }

    public function validateNewComment($idComment)
    {
        $sql ='UPDATE comments SET state = 1 WHERE idComment="'.$idComment.'"';
        $resultat = $this->db->prepare($sql);
        $affectedLines = $resultat->execute();
        $resultat->closeCursor();
        return $affectedLines;
    }

    public function validateReportComment($idComment)
    {
        $sql = 'UPDATE comments SET state = 3 WHERE idComment="'.$idComment.'"';
        $resultat = $this->db->prepare($sql);
        $affectedLines = $resultat->execute();
        $resultat->closeCursor();
        return $affectedLines;
    }

    public function reportNewComment($idComment)
    {
        $sql ='UPDATE comments SET state = 2 WHERE idComment="'.$idComment.'"';
        $resultat = $this->db->prepare($sql);
        $affectedLines = $resultat->execute();
 
        $resultat->closeCursor();
        return $affectedLines;
    }

    public function deleteComment($idComment)
    {
        $sql ='DELETE from comments WHERE idComment="'.$idComment.'"';
        $data = $this->db->prepare($sql);
        $result = $data->execute();
        return $result;
    }
}

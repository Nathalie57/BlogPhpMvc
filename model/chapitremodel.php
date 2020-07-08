<?php
require_once "model/model.php";
class ChapitreModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function featuredPost()
    {
        $sql = "SELECT 
			ID AS `{{ id }}`,
			idChapitre AS `{{ idChapitre }}`, 
			title AS `{{ title }}`, 
			DATE_FORMAT(published, '%d/%m/%Y') AS `{{ published }}`, 
			content AS `{{ content }}`, 
			SUBSTR(content, 1, 400) AS `{{ resume }}`,
			slug AS `{{ slug }}`,
			featured AS `featured`

			FROM `posts` 
			WHERE `featured` = 1 AND published IS NOT NULL";

        $data = $this->db->query($sql);
        $result = $data->fetch();

        return $result;
    }

    public function otherPost()
    {
        $sql = "SELECT 
			ID AS `{{ id }}`, 
			idChapitre AS `{{ idChapitre }}`, 
			title AS `{{ title }}`, 
			DATE_FORMAT(published, '%d/%m/%Y') AS `{{ published }}`, 
			content AS `{{ content }}`, 
			SUBSTR(content, 1, 200) AS `{{ resume }}`,
			slug AS `{{ slug }}`

			FROM `posts` 
			WHERE `featured` = 0 AND published IS NOT NULL ORDER BY ID DESC LIMIT 4";

        $data = $this->db->query($sql);
        $result = $data->fetchAll();

        return $result;
    }

    public function singlePost($slug)
    {
        $sql = "SELECT
			ID AS `{{ id }}`,
			idChapitre AS `{{ idChapitre }}`, 
			title AS `{{ title }}`, 
			DATE_FORMAT(published, '%d/%m/%Y') AS `{{ published }}`, 
			content AS `{{ content }}`,
			slug AS `{{ slug }}`

			FROM `posts` 
			WHERE `slug` = '$slug' AND published IS NOT NULL";
        $data = $this->db->query($sql);
        $result = $data->fetch();

        return $result;
    }
    

    public function listPost()
    {
        $sql = "SELECT
			ID AS `{{ id }}`,
			idChapitre AS `{{ idChapitre }}`, 
			title AS `{{ title }}`, 
			DATE_FORMAT(published, '%d/%m/%Y') AS `{{ published }}`,
			slug AS `{{ slug }}`
			
			FROM `posts` 
			WHERE published IS NOT NULL ORDER BY ID DESC";

        $data = $this->db->query($sql);
        $result = $data->fetchAll();

        return $result;
    }

    public function newPost($idChapitre, $title, $content, $slug)
    {
        try {
            $tab = array(
            'idChapitre' => $idChapitre,
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'published' => date("Y-m-d"),
               'featured' => '1');
          

            $sql = "INSERT INTO posts";
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

    public function deletePost($slug)
    {
        $sql ='DELETE from posts WHERE slug="'.$slug.'"';
        $data = $this->db->prepare($sql);
        $result = $data->execute();
        return $result;
    }

    public function updatePost($title, $content, $slug, $idChapitre, $ID)
    {
        try {
            $tab = array(
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'idChapitre' =>$idChapitre,
            'ID'=> $ID);

            $sql ='UPDATE `posts` SET `title` = :title, `content` = :content, `idChapitre` = :idChapitre,`slug` = :slug WHERE `ID` = :ID';
                 
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

    public function updateFeaturedPost()
    {
        try {
            $tab = array(
            'featured' => '1');

            $sql ='UPDATE `posts` SET `featured` = 0 WHERE `featured` = 1';
                 
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

    public function updateIfDeletePost()
    {
        try {
            $tab = array(
            'featured' => '0',
            'published' => date("Y-m-d"));

            $sql ='UPDATE `posts` SET `featured` = 1 WHERE published IS NOT NULL ORDER BY ID DESC LIMIT 1';
                 
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
}

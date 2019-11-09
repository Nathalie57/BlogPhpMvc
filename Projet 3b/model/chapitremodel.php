<?php
require_once "model/model.php";
class ChapitreModel extends Model{
	public function __construct(){
		parent::__construct();
	}

	public function featuredPost(){
		$sql = "SELECT 
			ID AS `{{ id }}`, 
			title AS `{{ title }}`, 
			DATE_FORMAT(published, '%d/%m/%Y') AS `{{ published }}`, 
			content AS `{{ content }}`, 
			SUBSTR(content, 1, 400) AS `{{ resume }}`,
			slug AS `{{ slug }}`

			FROM `posts` 
			WHERE `featured` = 1 AND published IS NOT NULL";

		$data = $this->db->query($sql);
		$result = $data->fetch();

		return $result;

	}

	public function otherPost(){
		$sql = "SELECT 
			ID AS `{{ id }}`, 
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

	public function singlePost($slug){
		$sql = "SELECT
			ID AS `{{ id }}`,
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
	

	public function listPost(){
		$sql = "SELECT
			ID AS `{{ id }}`,
			title AS `{{ title }}`, 
			DATE_FORMAT(published, '%d/%m/%Y') AS `{{ published }}`,
			slug AS `{{ slug }}`
			
			FROM `posts` 
			WHERE published IS NOT NULL ORDER BY ID DESC";

		$data = $this->db->query($sql);
		$result = $data->fetchAll();

		return $result;
		}
}

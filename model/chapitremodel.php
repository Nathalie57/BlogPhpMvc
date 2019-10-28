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
			published AS `{{ published }}`, 
			content AS `{{ content }}`, 
			SUBSTR(content, 1, 100) AS `{{ resume }}` 

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
			published AS `{{ published }}`, 
			content AS `{{ content }}`, 
			SUBSTR(content, 1, 100) AS `{{ resume }}` 

			FROM `posts` 
			WHERE `featured` = 0 AND published IS NOT NULL";
			// ORDER BY `ID DESC`
			//LIMIT = 5;

			
		$data = $this->db->query($sql);
		$result = $data->fetch();
	}
}
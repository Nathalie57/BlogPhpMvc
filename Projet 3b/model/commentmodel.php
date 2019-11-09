<?php
require_once "model/model.php";
class CommentModel extends Model{
	public function __construct(){
		parent::__construct();
	}

	public function comment($idPost){
		$sql = "SELECT 
			author AS `{{ author }}`, 
			comment AS `{{ content }}`, 
			DATE_FORMAT(date, '%d/%m/%Y') AS `{{ published }}`
			
			FROM `comments` 
			WHERE `idPost` = '$idPost' ORDER BY date DESC";
		
		$data = $this->db->query($sql);
		$result = $data->fetchAll();

		return $result;
	}
}
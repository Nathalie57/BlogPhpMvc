<?php
require_once "model/model.php";

class AdminModel extends Model
{
    public $info;

    public function __construct($login, $password)
    {
        parent::__construct();
        $this->login($login, $password);
    }

    public function login($login, $password)
    {
        $sql = "SELECT 
  			idAdmin, 
  			login  

  			FROM `admin` 
  			WHERE `login` = '$login' AND `password` = '$password'";
  
        $data = $this->db->query($sql);
  
        $this->info = $data->fetch();
    }
}

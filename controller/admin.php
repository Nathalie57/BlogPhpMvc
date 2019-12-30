<?php

require_once "model/adminmodel.php";
require_once "view/view.php";


class Admin{
	public  $id = null;
    public  $name = null;
    public $timeout_duration = 1800;


    public function __construct(){
        session_start();
        if (isset($_SESSION['valide'])) $this->verifToujoursValide();
        else $this->verifDonneesPost();
    }

    private function verifToujoursValide(){
		$time = $_SERVER['REQUEST_TIME'];
	
		if (isset($_SESSION["valide"]) && 
   		($time - $_SESSION["valide"]) > 0) {
    		return $this->clearSession();
		}
		$this->updateValidity();
    }

    public function clearSession(){
    	$_SESSION= [];
    	session_unset();
    	session_destroy();
   		session_start();
   		$this->id = null;
        $this->name = null;
        $this->verifDonneesPost();
    }

    private function verifDonneesPost(){
     	global $safeData;
        if (!is_null($safeData->post["login"]) && !is_null($safeData->post["password"])){
            $pwd = hash("sha256", $safeData->post["password"]);
            $adminmodel = new AdminModel($safeData->post["login"], $pwd);    
            if ($adminmodel) $this->activeSession($adminmodel);
    //       die(var_dump($adminmodel));
        }
    }

    private function activeSession($adminmodel){
    //	die(var_dump($adminmodel));
        $_SESSION["id"] = $adminmodel->info["idAdmin"];
  	    $_SESSION["name"] = $adminmodel->info["login"];
 		$this->updateValidity();	
    
    }

    private function updateValidity(){
    	$_SESSION["valide"] = $_SERVER['REQUEST_TIME'] + $this->timeout_duration;
    	$this->id = $_SESSION["id"];
    	$this->name = $_SESSION["name"];
    }
}

<?php
require_once "controller/front.php";
require_once "controller/back.php";

$config = [
"directory" => "Projet%203b",
"database" => "projet3",
"user" => "root",
"password" => "",
"envProd" => false
];
$uri = explode ("/", filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW));
$uri = array_slice($uri, array_search($config["directory"], $uri)+1);
switch ($uri[0]) {
	case 'admin':
		$page = new Back(array_slice($uri, 1));
		break;
	
	default:
		$page = new Front($uri);
		break;
}
echo $page->html;
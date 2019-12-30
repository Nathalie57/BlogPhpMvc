	<?php
	require_once "controller/front.php";
	require_once "controller/back.php";
	require_once "controller/security.php";

	$config = [
		"directory" => "Projet%203b",
		"database" => "projet3",
		"user" => "root",
		"password" => "",
		"envProd" => false
	];

	$safeData = new Security([

		"post" => [
			"author"  => FILTER_SANITIZE_STRING,
			"comment" => FILTER_SANITIZE_STRING,
			"login" => FILTER_SANITIZE_STRING,
			"password" => FILTER_SANITIZE_STRING,
			"title" => FILTER_SANITIZE_STRING,
			"content" => FILTER_DEFAULT,
			"slug" => FILTER_SANITIZE_STRING,
			"idChapitre" => FILTER_SANITIZE_STRING,
			"ID" => FILTER_SANITIZE_STRING,
		]
	]
);

	$uri = $safeData->uri;
	
	switch ($uri[0]) {
		case 'admin':
		$page = new Back(array_slice($uri, 1));
		break;
		
		default:
		$page = new Front($uri);
		break;
	}
	echo $page->html;
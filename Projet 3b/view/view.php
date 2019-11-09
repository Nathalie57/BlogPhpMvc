<?php

class View{
	public $html;
	public function __construct($data, $template){
		if (isset ($data[0])) {
			$this->html = $this->makeLoopHtml($data, $template);
		}
		else $this->html = $this->makeHtml($data, $template);
	}

	public function makeHtml($data, $template){
		global $config;
		$data["{{ path }}"] = $config["directory"]."/";
	  return str_replace(
      array_keys($data),
      $data,
      file_get_contents("template/$template.html"));
	}

	public function makeLoopHtml($data, $template){
		$html = "";
		if (isset($data)) {
		foreach ($data as $value) {
			$html .= $this->makeHtml($value, $template);
			}
		}
		return $html;
	}
}





// class voiture{
// 	public $couleur;

// 	public function __constructor($marque){
// 		if ($marque === "dacia") $this->couleur ="blanc";
// 		if ($marque === "ferrari") $this->couleur ="rouge";
// 	}
// }

// $maVoiture = new Voiture("ferrari");
// echo $maVoiture->couleur; //rouge



// $vue = new View($data, "commentaire");
// $monHtml = $vue->html; 
// $monHtml .= "lmklklmklmklmk";
// $monHtml2 = $vue->html; 



// $vue = new View();
// $monHtml = $vue->makeHtml($data, "commentaire");
// $monHtml .= "lmklklmklmklmk";
// $monHtml2 = $vue->makeHtml($data, "commentaire");


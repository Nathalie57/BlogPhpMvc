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
		global $safeData;
		$data["{{ path }}"] = $config["directory"]."/";
		if(count($safeData->uri)>2){
			$data["{{ fullpath }}"] = "/".$config['directory']."/".$safeData->uri[0]."/".$safeData->uri[1];
		}
		else $data["{{ fullpath }}"] = $safeData->uristring;
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


<?php

class Security{



    public $get;

    public $post;

    public $uri;

    public $uristring;

    public function __construct($args){

    	global $config;
        if (isset($args["post"]) ) $this->post = filter_input_array(INPUT_POST, $args["post"]);

        if (isset($args["get"]) ) $this->get = filter_input_array(INPUT_GET, $args["get"]);
        $this->uristring = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $this->uri = explode ("/", $this->uristring);
        $this->uri = array_slice($this->uri, array_search($config["directory"], $this->uri)+1);
    }



}

<?php
/*
 * App Core Class
 * Creates Url & loads core controller
 * URL FORMAT - /controller/method/params
 */
namespace App\Classes;
class Core {
    protected $currentController = "MainController";
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();
        // if something was set in get parameter
        if (!empty($url)) {
            // creating a controller name
            $controller = ucfirst(strtolower($url[0]))."Controller";
            // checking if a controller with such a name exists
            if (file_exists(__DIR__."/../controllers/".$controller.".php")) {
                $this->currentController = $controller;
            }
            unset($url[0]);
        }
        //Requesting a file with a controller
//        require_once __DIR__."/../controllers/".$this->currentController.".php";
        //And setting a new controller name
        $this->currentController = "App\\Controllers\\".$this->currentController;
        $this->currentController = new $this->currentController;

        // Check for the second part of the url
        if (isset($url[1])) {
            $method = strtolower($url[1]);
            //check to see if method exists in controller
            if (method_exists($this->currentController, $method)) {
                $this->currentMethod = $method;
            }
            unset($url[1]);
        }
        //Get params
        if (isset($url[2])) {
            $this->params = $url ? array_values($url) : [];
        }
        // calling a controllers method with given params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET["url"])) {
            $url = rtrim($_GET["url"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }
    }
}
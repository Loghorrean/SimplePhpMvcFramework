<?php
namespace App\Classes;
abstract class Controller {

    public $model;
    public $view;

    //Requiring a model by name

    public function model($model) {
        $model = "App\\Models\\".$model;
        return new $model;
    }

    //Requiring a view by name and passing it data if needed

    public function view($view, $data = []) {
        if (file_exists(__DIR__."/../views/".$view."View.php")) {
            require_once __DIR__."/../views/".$view."View.php";
        }
        else {
            die("View does not exist");
        }
    }
}
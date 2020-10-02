<?php
namespace App\Controllers;
use App\Classes\Controller;
class MainController extends Controller {
    public function __construct() {
        session_start();
        $this->model = $this->model('MainModel');
    }

    public function index($user = NULL) {
        if (isset($_POST["search"])) {
            header("Location: ".URL_ROOT."main/search/".$_POST["search"]);
            exit();
        }
        $data = $this->model->getData();
        $this->view("Main/index", $data);
    }

    public function cat($cat_id = NULL) {
        if (isset($cat_id)) {
            $cat_id = (int)$cat_id;
            $data = $this->model->getCatPage($cat_id);
            $this->view("Main/cat", $data);
        }
        else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }

    public function search($tag = NULL) {
        if (isset($_POST["search"]) && $_POST["search"] != NULL) {
            $tag = (string)$_POST["search"];
            $data = $this->model->getSearchPage($tag);
            $this->view("Main/search", $data);
        }
        else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }

    public function post($post_id = NULL) {
        if (isset($post_id)) {
            $post_id = (int)$post_id;
            $data = $this->model->getPostPage($post_id);
            $this->view("Main/post", $data);
        }
        else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }
}


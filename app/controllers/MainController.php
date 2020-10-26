<?php
namespace App\Controllers;
use App\Classes\Controller;
class MainController extends Controller {
    public function __construct() {
        $this->model = $this->getModel('MainModel');
    }

    public function index() {
        $data = $this->model->getData();
        $this->getView("Main/index", $data);
    }

    public function cat($cat_title = NULL) {
        if (isset($cat_title)) {
            $cat_title = (string)$cat_title;
            $data = $this->model->getCatPage($cat_title);
            $this->getView("Main/cat", $data);
        } else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }

    public function search($tag = NULL) {
        if (isset($_POST["search"]) && $_POST["search"] != NULL) {
            $tag = (string)$_POST["search"];
            $data = $this->model->getSearchPage($tag);
            $this->getView("Main/search", $data);
        } else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }

    public function post($post_id = NULL) {
        if (isset($post_id)) {
            $post_id = (int)$post_id;
            $data = $this->model->getPostPage($post_id);
            $this->getView("Main/post", $data);
        } else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }
}


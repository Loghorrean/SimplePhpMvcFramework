<?php
namespace App\Controllers;
use App\Classes\Controller;
class MainController extends Controller {
    public function __construct() {
        $this->model = $this->model('MainModel');
    }

    public function index($user = NULL) {
        $data = $this->model->getData();
        $this->view("Main/index", $data);
    }

    public function cat($cat_id = NULL) {
        if (isset($cat_id)) {
            $cat_id = (int)$cat_id;
            $data = $this->model->getCategories($cat_id);
            $this->view("Main/cat", $data);
        }
        else {
            header("Location: ".URL_ROOT);
            exit();
        }
    }
}


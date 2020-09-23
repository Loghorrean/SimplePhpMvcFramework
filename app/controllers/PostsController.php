<?php
namespace App\Controllers;
use App\Classes\Controller;
class PostsController extends Controller {
    public function __construct() {
        $this->model = $this->model('PostsModel');
    }

    public function index($arg1 = NULL) {
        if (isset($_POST["submit_add"])) {
            echo "submit_add";
        }
        $data = $this->model->getData($arg1);
        $this->view("Pages/index", $data);
    }

    public function about() {
        $data = ["title" => "About"];
        $this->view("Pages/about", $data);
    }
}
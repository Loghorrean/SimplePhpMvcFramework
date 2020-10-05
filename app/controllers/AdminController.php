<?php
namespace App\Controllers;
use App\Classes\Controller;
class AdminController extends Controller {
    public function __construct() {
        session_start();
        $_SESSION["auth"] = false;
        if (isset($_SESSION["auth"])) {
            if ($_SESSION["user_role"] !== "admin") {
                header("Location: ".URL_ROOT);
                exit();
            }
        }
        else {
            header("Location: ".URL_ROOT);
            exit();
        }
        $this->model = $this->model("AdminModel");
    }

    public function index() {
        $_SESSION["auth"] = true;
        $_SESSION["username"] = "Loghorrean";
        $_SESSION["user_role"] = "admin";
        $_SESSION["user_id"] = 7;
        if ($_SESSION["auth"]) {
            if ($_SESSION["user_role"] !== "admin") {
                header("Location: ".URL_ROOT);
                exit();
            }
        }
        else {
            header("Location: ".URL_ROOT);
            exit();
        }
        $data = $this->model->getData();
        $this->view("Admin/index", $data);
    }




    public function posts() {
        if (isset($_GET["delete"])) {
            if (!checkId($_GET["delete"])) {
                header("Location: /mvcframework/admin/posts");
                exit();
            }
        }
        if (isset($_GET["source"])) {
            $source = $_GET["source"];
        }
        else {
            $source = "";
        }
        switch($source) {
            case "add_post":
                $data = $this->model->getAddPostsPage();
                $this->view("Admin/postsAdd", $data);
                break;
            case "edit_post" :

                break;
            default:
                $data = $this->model->getPostsPage();
                $this->view("Admin/posts", $data);
        }
    }
}
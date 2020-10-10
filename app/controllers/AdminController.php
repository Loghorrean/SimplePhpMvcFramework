<?php
namespace App\Controllers;
use App\Classes\Controller;
class AdminController extends Controller {
    public function __construct() {
        session_start();
        if ($_SESSION["user_role"] !== "Admin") {
            $_SESSION["error"] = "You do not have permission to come here";
            header("Location: /mvcframework");
            exit();
        }
        $this->model = $this->model("AdminModel");
    }

    public function index() {
        $data = $this->model->getData();
        $this->view("Admin/index", $data);
    }

    public function categories() {
        if (isset($_GET["delete"]) && !checkId($_GET["delete"])) {
            header("Location: /mvcframework/admin/categories");
            exit();
        }
        if (isset($_GET["edit"]) && !checkId($_GET["edit"])) {
            header("Location: /mvcframework/admin/categories");
            exit();
        }
        $data = $this->model->getCategoriesPage();
        $this->view("Admin/categories", $data);
    }

    public function posts($post_id = null) {
        if (isset($_GET["delete"]) && !checkId($_GET["delete"])) {
            $_SESSION["error"] = "Wrong delete id!";
            header("Location: /mvcframework/admin/posts");
            exit();
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
//                TODO: implement the edit_post function
                if ($post_id === NULL) {
                    $_SESSION["error"] = "Wrong edit id!";
                    header("Location: /mvcframework/admin/posts");
                    exit();
                }
                $data = $this->model->getEditPostPage();
                $this->view("Admin/postsEdit", $data);
                break;
            default:
                $data = $this->model->getPostsPage();
                $this->view("Admin/posts", $data);
        }
    }

    public function users() {
        if (isset($_GET["delete"]) && !checkId($_GET["delete"])) {
            $_SESSION["error"] = "Wrong delete id!";
            header("Location: /mvcframework/admin/users");
            exit();
        }
        if (isset($_GET["source"])) {
            $source = $_GET["source"];
        }
        else {
            $source = "";
        }
        switch ($source) {
            case "add_user":
                $data = $this->model->getAddUsersPage();
                $this->view("Admin/usersAdd", $data);
                break;
            case "edit_user":
                //TODO: implement the edit_user function
                break;
            default:
                $data = $this->model->getUsersPage();
                $this->view("Admin/users", $data);
        }
    }

    public function comments() {
        if (isset($_GET["delete"]) && !checkId($_GET["delete"])) {
            $_SESSION["Wrong delete id!"];
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        if (isset($_GET["approve"]) && !checkId($_GET["approve"])) {
            $_SESSION["Wrong id to approve"];
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        if (isset($_GET["unapprove"]) && !checkId($_GET["unapprove"])) {
            $_SESSION["Wrong id to unapprove!"];
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        $data = $this->model->getCommentsPage();
        $this->view("Admin/comments", $data);
    }
}
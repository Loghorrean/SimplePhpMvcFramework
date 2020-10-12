<?php
namespace App\Controllers;
use App\Classes\Controller;
class AdminController extends Controller {
    public function __construct() {
        session_start();
        if ($_SESSION["user_role"] !== "Admin") {
            $_SESSION["error"] = "You do not have permission to come here";
            header("Location: ".URL_ROOT);
            exit();
        }
        $this->model = $this->getModel("AdminModel");
    }

    public function index() {
        $data = $this->model->getData();
        $this->getView("Admin/index", $data);
    }

    public function categories() {
        $data = $this->model->getCategoriesPage();
        $data["cat_title"] = $data["cat_title_error"] = "";
        if (isset($_GET["delete"])) {
            $this->model->checkGetCategory($_GET["delete"]);
        }
        if (isset($_GET["edit"])) {
            $this->model->checkGetCategory($_GET["edit"]);
            $data["cat_title_edit"] = $previousCatName = $this->model->findCategoryById($_GET["edit"])["cat_title"];
            $data["cat_title_edit_error"] = "";
        }


        if (isset($_POST["submit_add"])) {
            $data["cat_title"] = filterInput($_POST["cat_title"]);
            if (empty($data["cat_title"])) {
                $data["cat_title_error"] = "This field must not be empty";
            } elseif ($this->model->checkIfCategoryExists($data["cat_title"])) {
                $data["cat_title_error"] = "Category with this name already exists";
            }

            if (empty($data["cat_title_error"])) {
                if ($this->model->addCategory($data["cat_title"])) {
                    flashMessager("category_add_success", "Category " . $data["cat_title"] . " added succesfully");
                    redirect("admin/categories");
                    exit();
                }
                else {
                    die("Error");
                }
            }
        }


        if (isset($_POST["submit_delete"])) {
            if ($this->model->deleteCategory($_POST["cat_id_delete"])) {
                flashMessager("category_delete_success", "Category deleted succesfully");
                redirect("admin/categories");
                exit();
            }
            else {
                die("Error");
            }
        }


        if (isset($_POST["submit_edit"])) {
            $data["cat_title_edit"] = filterInput($_POST["cat_title_edit"]);
            if (empty($data["cat_title_edit"])) {
                $data["cat_title_edit_error"] = "This field must not be empty";
            } elseif ($this->model->checkIfCategoryExists($data["cat_title_edit"])) {
                $data["cat_title_edit_error"] = "Category with this name already exists";
            }

            if (empty($data["cat_title_edit_error"])) {
                if ($this->model->editCategory($_POST["cat_id_edit"], $data["cat_title_edit"])) {
                    flashMessager("category_edit_success", "Category " . $previousCatName . " edited to " . $data["cat_title_edit"] . " succesfully");
                    redirect("admin/categories");
                    exit();
                }
                else {
                    die("Error");
                }
            }
        }
        $this->getView("Admin/categories", $data);
    }


    /*
     * posts actions: show, add, delete, edit
     * urls like: admin/posts/show/1, admin/posts/add, admin/posts/edit/1, admin/posts/delete/1
     */
    public function posts($action = "show", $post_id = NULL) {
        $viewName = "posts" . ucfirst($action);
        $action = "get" . ucfirst($action) . "PostPage";
        $args = func_get_args();
        array_shift($args);
        $data = call_user_func_array(array($this->model, $action), $args);
        var_dump($viewName);
        $this->getView("Admin/".$viewName, $data);


//        switch($action) {
//            case "add_post":
//                $data = $this->model->getAddPostsPage();
//                $this->getView("Admin/postsAdd", $data);
//                break;
//            case "edit_post" :
////                TODO: implement the edit_post function
//                if ($post_id === NULL) {
//                    $_SESSION["error"] = "Wrong edit id!";
//                    header("Location: " . URL_ROOT . "/admin/posts");
//                    exit();
//                }
//                $data = $this->model->getEditPostPage();
//                $this->getView("Admin/postsEdit", $data);
//                break;
//            default:
//                $data = $this->model->getPostsPage();
//                $this->getView("Admin/posts", $data);
//        }
    }

    public function users() {
        if (isset($_GET["delete"]) && !checkId($_GET["delete"])) {
            $_SESSION["error"] = "Wrong delete id!";
            header("Location: " . URL_ROOT . "/admin/users");
            exit();
        }
        $source = "";
        if (isset($_GET["source"])) {
            $source = $_GET["source"];
        }
        switch ($source) {
            case "add_user":
                $data = $this->model->getAddUsersPage();
                $this->getView("Admin/usersAdd", $data);
                break;
            case "edit_user":
                //TODO: implement the edit_user function
                break;
            default:
                $data = $this->model->getUsersPage();
                $this->getView("Admin/users", $data);
        }
    }

    public function comments() {
        if (isset($_GET["delete"]) && !checkId($_GET["delete"])) {
            $_SESSION["Wrong delete id!"];
            header("Location: " . URL_ROOT . "/admin/comments");
            exit();
        }
        if (isset($_GET["approve"]) && !checkId($_GET["approve"])) {
            $_SESSION["Wrong id to approve"];
            header("Location: " . URL_ROOT . "/admin/comments");
            exit();
        }
        if (isset($_GET["unapprove"]) && !checkId($_GET["unapprove"])) {
            $_SESSION["Wrong id to unapprove!"];
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        $data = $this->model->getCommentsPage();
        $this->getView("Admin/comments", $data);
    }
}
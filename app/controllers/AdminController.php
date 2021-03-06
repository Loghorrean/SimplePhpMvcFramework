<?php
namespace App\Controllers;
use App\Classes\Controller;
class AdminController extends Controller {
    public function __construct() {
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
                    flashMessager("category_add_success", "Category " . $data["cat_title"] . " added successfully");
                    redirect("admin/categories");
                    exit();
                }
                else {
                    die("Error during adding category");
                }
            }
        }


        if (isset($_POST["submit_delete"])) {
            if ($this->model->deleteCategory($_POST["cat_id_delete"])) {
                flashMessager("category_delete_success", "Category deleted successfully");
                redirect("admin/categories");
                exit();
            }
            else {
                die("Error during deleting category");
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
                    flashMessager("category_edit_success", "Category " . $previousCatName . " edited to " . $data["cat_title_edit"] . " successfully");
                    redirect("admin/categories");
                    exit();
                }
                else {
                    die("Error during editing category");
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
        $this->getView("Admin/".$viewName, $data);
    }
    public function comments() {
        $data = $this->model->getCommentsPage();
        if (isset($_GET["delete"])) {
            $this->model->checkGetComment($_GET["delete"]);
        }
        if (isset($_GET["approve"])) {
           $this->model->checkGetComment($_GET["approve"]);
        }
        if (isset($_GET["unapprove"])) {
            $this->model->checkGetComment($_GET["unapprove"]);
        }

        if (isset($_POST["submit_delete"])) {
            if ($this->model->deleteComment($_GET["delete"])) {
                flashMessager("comment_delete_success", "Comment deleted");
                redirect("admin/comments");
                exit();
            }
        }

        if (isset($_POST["submit_approve"])) {
            if ($this->model->setCommentStatus($_GET["approve"], "Approved")) {
                flashMessager("comment_approve_success", "Comment approved");
                redirect("admin/comments");
                exit();
            }
        }

        if (isset($_POST["submit_unapprove"])) {
            if ($this->model->setCommentStatus($_GET["unapprove"], "Unapproved")) {
                flashMessager("comment_unapprove_success", "Comment unapproved");
                redirect("admin/comments");
                exit();
            }
        }

        $this->getView("Admin/comments", $data);
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
}
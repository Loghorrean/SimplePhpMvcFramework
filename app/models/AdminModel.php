<?php
namespace App\Models;
use App\Classes\CrudCommentsController;
use App\Classes\Model;
use App\Classes\CrudPostsController;
use App\Classes\CrudCategoriesController;
use App\Classes\CrudUsersController;
class AdminModel implements Model {
    private $categories;
    private $posts;
    private $users;
    private $comments;

    public function __construct() {
        $this->categories = CrudCategoriesController::getInstance();
        $this->posts = CrudPostsController::getInstance();
        $this->users = CrudUsersController::getInstance();
        $this->comments = CrudCommentsController::getInstance();
    }

    private function getCommonData() {
        //TODO: implement the way to get a data used across all pages
    }

    public function checkGetCategory($get) {
        $_SESSION["error"] = "";
        if (!checkId($get)) {
            $_SESSION["error"] = "Wrong id format";
        } elseif (!$this->findCategoryById($get)) {
            $_SESSION["error"] = "Cannot find category with such id";
        }
        if (!empty($_SESSION["error"])) {
            header("Location:".URL_ROOT."/admin/categories");
            exit();
        }
    }

    public function checkIfCategoryExists($cat_title) {
        $category = $this->categories->getRow("SELECT * FROM category where cat_title = :ttl", ["ttl" => $cat_title]);
        if ($category != NULL) {
            return true;
        }
        return false;
    }

    public function findCategoryById($cat_id) {
        $category = $this->categories->getRow("SELECT * FROM category WHERE cat_id = :id", ["id" => $cat_id]);
        if ($category == NULL) {
            return false;
        }
        return $category;
    }

    public function addCategory($cat_title) {
        $this->categories->Insert(["cat_ttl" => $cat_title]);
        return true;
    }

    public function deleteCategory($cat_id) {
        $this->categories->Delete(["id" => $cat_id]);
        return true;
    }

    public function editCategory($cat_id, $cat_title) {
        $this->categories->Update(["id" => $cat_id, "ttl" => $cat_title]);
        return true;
    }

    public function getData() {
        $data = array();
        $data["counter"] = array();
        $sql = "SELECT (SELECT count(post_id) from posts) as postCount, ";
        $sql .= "(SELECT count(post_id) from posts where post_status = 'draft') as draftPostCount, ";
        $sql .= "(SELECT count(comment_id) from comments) as comCount, ";
        $sql .= "(SELECT count(comment_id) from comments where comment_status = 'Unapproved') as unappComCount, ";
        $sql .= "(SELECT count(user_id) from users) as userCount, ";
        $sql .= "(SELECT count(user_id) from users where user_role = 'subscriber') as subUserCount, ";
        $sql .= "(SELECT count(cat_id) from category) as catCount";
        $counts = $this->posts->getRow($sql);
        $data["counter"]["posts_count"] = $counts["postCount"];
        $data["counter"]["comments_count"] = $counts["comCount"];
        $data["counter"]["users_count"] = $counts["userCount"];
        $data["counter"]["cats_count"] = $counts["catCount"];
        return $data;
    }

    public function getCategoriesPage() {
        $data = array();
        $sql = "SELECT * from category";
        $data["categories"] = $this->categories->getRows($sql);
        return $data;
    }

    public function getShowPostPage($post_id = NULL) {
        $data = array();
        $sql = "SELECT category.cat_title as 'cat_title', users.username as 'post_author', posts.* from posts ";
        $sql .= "left join category on posts.post_category_id = category.cat_id ";
        $sql .= "left join users on posts.post_author_id = users.user_id ";
        if (isset($post_id)) {
            $sql .= " WHERE posts.post_id = :id ";
        }
        $sql .= "ORDER BY posts.post_id DESC";
        if (isset($post_id)) {
            $data["posts"] = $this->posts->getRows($sql, ["id" => $post_id]);
        } else {
            $data["posts"] = $this->posts->getRows($sql);
        }
        return $data;
    }

    public function getAddPostPage() {
        $data = array();
        $data["categories"] = $this->categories->getRows("SELECT * FROM category");
        if (isset($_POST["create_post"])) {
            //TODO: implement the way to handle POST data correctly (select lists and file uploads)
        }
        else {
            $data = [
                "post_title" => "",
                "post_title_error" => "",
                "post_tags" => "",
                "post_tags_error" => "",
                "post_content" => "",
                "post_content_error" => ""
            ];
        }
        return $data;
    }

    public function getEditPostPage() {
        $data = array();

        return $data;
    }

    public function getUsersPage() {
        if (isset($_POST["submit_delete"])) {
            $this->users->Delete(["id" => $_POST["user_id"]]);
            $_SESSION["success"] = "User deleted!";
            header("Location: /mvcframework/admin/users");
            exit();
        }
        $data = array();
        $sql = "SELECT * from users";
        $data["users"] = $this->users->getRows($sql);
        return $data;
    }

    public function getAddUsersPage() {
        if (isset($_POST["add_user"])) {
            if (!checkPassword($_POST["user_password"])) {
                header("Location: /mvcframework/admin/users?source=add_user");
                exit();
            }
            elseif (!checkUserExistance($_POST["username"])) {
                header("Location: /mvcframework/admin/users?source=add_user");
                exit();
            }
            $salt = generateSalt();
            $password = hash("md5", $salt.$_POST["password"]);
            //TODO: implement the way to insert user_images
            $this->users->Insert(["name" => $_POST["username"], "pwd" => $password, "lname" => $_POST["user_lastname"],
                "fname" => $_POST["user_firstname"], "mail" => $_POST["user_email"], "img" => NULL,
                "role" => $_POST["user_role"], "salt" => $salt]);
            $_SESSION["success"] = "User inserted!";
            header("Location: /mvcframework/admin/users");
            exit();
        }
    }

    public function getCommentsPage() {
        if (isset($_POST["submit_delete"])) {
            $this->comments->Delete(["id" => $_POST["comment_id"], "post_id" => $_POST["comment_post_id"]]);
            $_SESSION["success"] = "Comment deleted!";
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        if (isset($_POST["submit_approve"])) {
            $sql = "UPDATE comments set comment_status = 'Approved' where comment_id = :id";
            $this->comments->sql($sql, ["id" => $_POST["comment_id"]]);
            $_SESSION["success"] = "Comment approved!";
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        if (isset($_POST["submit_unapprove"])) {
            $sql = "UPDATE comments set comment_status = 'Unapproved' where comment_id = :id";
            $this->comments->sql($sql, ["id" => $_POST["comment_id"]]);
            $_SESSION["success"] = "Comment unapproved!";
            header("Location: /mvcframework/admin/comments");
            exit();
        }
        $data = array();
        $sql = "SELECT posts.post_title as 'post_title', users.username as 'username', users.user_email as 'user_email', comments.* from comments ";
        $sql .= "inner join posts on comments.comment_post_id = posts.post_id ";
        $sql .= "left join users on comments.comment_author_id = users.user_id";
        $data["comments"] = $this->comments->getRows($sql);
        return $data;
    }
}
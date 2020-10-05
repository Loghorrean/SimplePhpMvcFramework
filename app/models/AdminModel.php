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
        //TODO: Need to fetch values, that are used across all pages
    }

    public function getData() {
        $data = array();
        $data["current_user"] = $_SESSION["username"];
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
        if (isset($_POST["submit_add"])) {
            $this->categories->Insert(["cat_ttl" => $_POST["cat_title"]]);
            $_SESSION["success"] = "Category added";
            header("Location: /mvcframework/admin/categories");
            exit();
        }
        if (isset($_POST["submit_delete"])) {
            $this->categories->Delete(["id" => $_POST["cat_id"]]);
            $_SESSION["success"] = "Category deleted";
            header("Location: /mvcframework/admin/categories");
            exit();
        }
        if (isset($_POST["submit_edit"])) {
            $this->categories->Update(["ttl" => $_POST["cat_title"], "id" => $_POST["cat_id"]]);
            $_SESSION["success"] = "Category edited";
            header("Location: /mvcframework/admin/categories");
            exit();
        }
        $data = array();
        $data["current_user"] = $_SESSION["username"];
        $sql = "SELECT * from category";
        $data["categories"] = $this->categories->getRows($sql);
        return $data;
    }

    public function getPostsPage() {
        if (isset($_POST["submit_delete"])) {
            $this->posts->Delete(["id" => $_POST["post_id"]]);
            header("Location: /mvcframework/admin/posts");
            exit();
        }
        $data = array();
        $sql = "SELECT category.cat_title as 'cat_title', users.username as 'post_author', posts.* from posts ";
        $sql .= "left join category on posts.post_category_id = category.cat_id ";
        $sql .= "left join users on posts.post_author_id = users.user_id order by posts.post_id DESC";
        $data["posts"] = $this->posts->getRows($sql);
        return $data;
    }

    public function getAddPostsPage() {
        if (isset($_POST["create_post"])) {
            $uploadDir = __DIR__."/../../public/images/";
            $allowed_types = ["jpeg", "jpg", "png"];
            $post_image = uploadFile($uploadDir, "post_image", "/mvcframework/admin/posts", MAX_FILE_SIZE, $allowed_types);
            $this->posts->Insert(["cat_id" => $_POST["post_category_id"], "ttl" => $_POST["post_title"],
                "auth_id" => $_SESSION["user_id"], "img" => $post_image, "cont" => $_POST["post_content"],
                "tag" => $_POST["post_tags"], "stat" => $_POST["post_status"]]);
            $_SESSION["success"] = "Post added!";
            header("Location: /mvcframework/admin/posts");
            exit();
        }
        $data = array();
        $sql = "SELECT * from category";
        $data["categories"] = $this->categories->getRows($sql);
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
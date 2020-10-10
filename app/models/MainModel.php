<?php
namespace App\Models;
use App\Classes\CrudCommentsController;
use App\Classes\Model;
use App\Classes\CrudPostsController;
use App\Classes\CrudCategoriesController;
use App\Classes\CrudUsersController;
class MainModel implements Model {
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

    private function getCategories($cat_id = NULL) {
        if (isset($cat_id)) {
            $sql = "SELECT * from category where cat_id = :id";
            return $this->categories->getRows($sql, ["id" => $cat_id]);
        }
        else {
            $sql = "SELECT * from category";
            return $this->categories->getRows($sql);
        }
    }

    private function getPosts($post_id = NULL) {
        if (isset($post_id)) {
            $sql = "SELECT users.username as 'username', posts.* from posts ";
            $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' and post_id = :id";
            return $this->posts->getRows($sql, ["id" => $post_id]);
        }
        else {
            $sql = "SELECT users.username as 'username', posts.* from posts ";
            $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published'";
            return $this->posts->getRows($sql);
        }
    }

    private function getUsers($user_id = NULL) {
        if (isset($user_id)) {
            $sql = "SELECT * from users where user_id = :id";
            return $this->users->getRow($sql, ["id" => $user_id]);
        }
        else {
            $sql = "SELECT * from users";
            return $this->users->getRows($sql);
        }
    }

    public function getData() {
        $data = array();
        $data["categories"] = $this->getCategories();
        $data["posts"] = $this->getPosts();
        foreach($data["posts"] as &$post) {
            $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35) . "..." : $post["post_content"];
        }
        $data["adminButton"] = false;
        if (isset($_SESSION["auth"])) {
            $data["users"] = $this->getUsers($_SESSION["user_id"]);
            $data["adminButton"] = $this->checkUserRights($data["users"]);
        }
        return $data;
    }

    public function getCatPage($cat_title) {
        $data = array();
        $data["categories"] = $this->getCategories();
        /*
         * TODO: implement a proper way to select all posts through private function
         * and make this part of the model available, I want to sleep
         */
        $sql = "SELECT users.username as 'username', posts.*, category.cat_title as 'cat_title' from posts ";
        $sql .= "left join users on users.user_id = posts.post_author_id ";
        $sql .= "inner join category on category.cat_id = posts.post_category_id ";
        $sql .= "where post_status = 'published' and cat_title = :ttl";
        $data["posts"] = $this->posts->getRows($sql, ["ttl" => $cat_title]);
        foreach($data["posts"] as &$post) {
            $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35) . "..." : $post["post_content"];
        }
        $data["category_name"] = $cat_title;
        if (isset($_SESSION["auth"])) {
            $data["users"] = $this->getUsers($_SESSION["user_id"]);
            $data["adminButton"] = $this->checkUserRights($data["users"]);
        }
        return $data;
    }

    public function getSearchPage($tag) {
        $data = array();
        $data["search_item"] = $tag;
        $tag = "%".htmlspecialchars($tag)."%";
        $data["categories"] = $this->getCategories();
        $sql = "SELECT users.username as 'username', posts.* from posts ";
        $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' and post_tags like :tag";
        $data["posts"] = $this->posts->getRows($sql, ["tag" => $tag]);
        if (isset($_SESSION["auth"])) {
            $data["users"] = $this->getUsers($_SESSION["user_id"]);
            $data["adminButton"] = $this->checkUserRights($data["users"]);
        }
        return $data;
    }

    public function getPostPage($post_id) {
        if (isset($_POST["create_comment"])) {
            $this->comments->Insert(["post_id" => $post_id, "auth_id" => $_SESSION["user_id"],
                "cont" => $_POST["comment_content"], "stat" => 'Unapproved']);
            $_SESSION["success"] = "Comment is waiting to be approved!";
            header("Location: /mvcframework/main/post/".$post_id);
            exit();
        }
        $data = array();
        $data["categories"] = $this->getCategories();
        $sql = "SELECT users.username as 'username', posts.* from posts ";
        $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' and post_id = :id";
        $data["post"] = $this->posts->getRow($sql, ["id" => $post_id]);
        if (isset($_SESSION["auth"])) {
            $data["users"] = $this->getUsers($_SESSION["user_id"]);
            $data["adminButton"] = $this->checkUserRights($data["users"]);
            $data["editButton"] = $this->checkEditButton($data["users"], $data["post"]["post_author_id"]);
        }
        $sql = "SELECT users.username as 'comment_author', comments.* from comments ";
        $sql .= "left join users on users.user_id = comments.comment_author_id where comment_post_id = :id ";
        $sql .= "and comment_status = 'Approved' Order By comment_id DESC";
        $data["comments"] = $this->comments->getRows($sql, ["id" => $post_id]);
        return $data;
    }

    private function checkUserRights($user) {
        $user_role = $user["user_role"];
        if ($user_role === "Admin") {
            return true;
        }
        else {
            return false;
        }
    }

    private function checkEditButton($user, $post_author_id) {
        if ($this->checkUserRights($user) || $post_author_id == $user["user_id"]) {
            return true;
        }
        else {
            return false;
        }
    }

}
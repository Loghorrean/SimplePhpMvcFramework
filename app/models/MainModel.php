<?php
namespace App\Models;
use App\Classes\Model;
use App\Classes\CrudPostsController;
use App\Classes\CrudCategoriesController;
use App\Classes\CrudUsersController;
class MainModel implements Model {
    private $categories;
    private $posts;
    private $users;

    public function __construct() {
        $this->categories = CrudCategoriesController::getInstance();
        $this->posts = CrudPostsController::getInstance();
        $this->users = CrudUsersController::getInstance();
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
            return $this->users->getRows($sql, ["id" => $user_id]);
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
        $_SESSION["auth"] = true;
        $_SESSION["user_id"] = 7; // THIS IS JUST FOR A TEST
        if (isset($_SESSION["auth"])) {
            $data["users"] = $this->getUsers($_SESSION["user_id"]);
            if ($data["users"][0]["user_role"] == "admin") {
                $data["adminButton"] = true;
            }
            else {
                $data["adminButton"] = false;
            }
        }
        return $data;
    }

    public function getCatPage($cat_id) {
        $data = array();
        $data["categories"] = $this->getCategories();
        /*
         * TODO: implement a proper way to select all posts through private function
         * and make this part of the model available, I want to sleep
         */
        $sql = "SELECT users.username as 'username', posts.* from posts ";
        $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' and post_category_id = :id";
        $data["posts"] = $this->posts->getRows($sql, ["id" => $cat_id]);
        foreach($data["posts"] as &$post) {
            $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35) . "..." : $post["post_content"];
        }
        $data["category_name"] = $this->getCategories($cat_id)[0]["cat_title"];
        if (isset($_SESSION["auth"])) {
            $data["users"] = $this->getUsers($_SESSION["user_id"]);
            if ($data["users"][0]["user_role"] == "admin") {
                $data["adminButton"] = true;
            }
            else {
                $data["adminButton"] = false;
            }
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
            if ($data["users"][0]["user_role"] == "admin") {
                $data["adminButton"] = true;
            }
            else {
                $data["adminButton"] = false;
            }
        }
        return $data;
    }
}
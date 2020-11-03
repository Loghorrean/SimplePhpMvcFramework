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

    private function getNavigationData(array &$data) : void {
        $data["categories"] = $this->categories->getAll();
        $data["isAdmin"] = false;
        if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "Admin") {
            $data["isAdmin"] = true;
        }
    }

    public function getData() : array {
        $data = array();
        $this->getNavigationData($data);
        $data["posts"] = $this->posts->getAll();
        foreach($data["posts"] as &$post) {
            $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35) . "..." : $post["post_content"];
        }
        return $data;
    }

    public function getCatPage(string $cat_title) : array {
        $data = array();
        $this->getNavigationData($data);
        $sql = "SELECT users.username AS 'username', posts.*, category.cat_title AS 'cat_title' FROM posts ";
        $sql .= "LEFT JOIN users ON users.user_id = posts.post_author_id ";
        $sql .= "INNER JOIN category ON category.cat_id = posts.post_category_id ";
        $sql .= "WHERE post_status = 'published' AND cat_title = :ttl";
        $data["posts"] = $this->posts->getRows($sql, ["ttl" => $cat_title]);
        foreach($data["posts"] as &$post) {
            $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35) . "..." : $post["post_content"];
        }
        $data["category_name"] = $cat_title;
        return $data;
    }

    public function getSearchPage(string $tag) : array {
        $data = array();
        $data["search_item"] = $tag;
        $tag = "%".htmlspecialchars($tag)."%";
        $this->getNavigationData($data);
        $sql = "SELECT users.username AS 'username', posts.* FROM posts ";
        $sql .= "LEFT JOIN users ON users.user_id = posts.post_author_id WHERE post_status = 'Published' AND post_tags LIKE :tag";
        $data["posts"] = $this->posts->getRows($sql, ["tag" => $tag]);
        return $data;
    }

    public function getPostPage(int $post_id) : array {
        if (isset($_POST["create_comment"])) {
            $this->comments->Insert(["post_id" => $post_id, "auth_id" => $_SESSION["user_id"],
                "cont" => $_POST["comment_content"], "stat" => 'Unapproved']);
            $_SESSION["success"] = "Comment is waiting to be approved!";
            header("Location: " . URL_ROOT . "/main/post/".$post_id);
            exit();
        }
        $data = array();
        $this->getNavigationData($data);
        $sql = "SELECT users.username AS 'username', posts.* FROM posts ";
        $sql .= "LEFT JOIN users ON users.user_id = posts.post_author_id ";
        $sql .= "WHERE post_status = 'Published' AND post_id = :id";
        $data["post"] = $this->posts->getRow($sql, ["id" => $post_id]);
        if (isset($_SESSION["user_id"])) {
            $data["editButton"] = $this->checkEditButton($data["post"]["post_author_id"]);
        }
        $sql = "SELECT users.username AS 'comment_author', comments.comment_date, comments.comment_content FROM comments ";
        $sql .= "LEFT JOIN users ON users.user_id = comments.comment_author_id ";
        $sql .= "WHERE comment_post_id = :id ";
        $sql .= "AND comment_status = 'Approved' ORDER BY comment_id DESC";
        $data["comments"] = $this->comments->getRows($sql, ["id" => $post_id]);
        return $data;
    }

    private function checkEditButton(int $post_author_id) : bool {
        if ($_SESSION["user_role"] === "Admin" || $post_author_id === $_SESSION["user_id"]) {
            return true;
        }
        return false;
    }

}
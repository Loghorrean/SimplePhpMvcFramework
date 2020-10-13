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

    public function checkGetCategory($get) {
        $_SESSION["error"] = "";
        if (!checkId($get)) {
            $_SESSION["error"] = "Wrong id format";
        } elseif (!$this->findCategoryById($get)) {
            $_SESSION["error"] = "Cannot find category with such id";
        }
        if (!empty($_SESSION["error"])) {
            redirect("admin/categories");
            exit();
        }
    }

    public function checkIfCategoryExists($cat_title) {
        $category = $this->categories->getRow("SELECT * FROM category WHERE cat_title = :ttl", ["ttl" => $cat_title]);
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

    public function checkIfPostExists($post_title) {
        $post = $this->posts->getRow("SELECT * FROM posts WHERE post_title = :ttl", ["ttl" => $post_title]);
        if ($post != NULL) {
            return true;
        }
        return false;
    }
  
    public function findCommentById($comment_id) {
        $comment = $this->comments->getRow("SELECT * FROM comments WHERE comment_id = :id", ["id" => $comment_id]);
        if ($comment == NULL) {
            return false;
        }
        return $comment;
    }

    public function checkGetComment($get) {
        $_SESSION["error"] = "";
        if (!checkId($get)) {
            $_SESSION["error"] = "Wrong id format";
        } elseif (!$this->findCommentById($get)) {
            $_SESSION["error"] = "Couldn't find comment with such id!";
        }
        if (!empty($_SESSION["error"])) {
            redirect("admin/comments");
            exit();
        }
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

    public function addPost($values) {
        $this->posts->Insert($values);
    }
      
    public function deleteComment($com_id) {
        $this->comments->Delete(["id" => $com_id]);
        return true;
    }

    public function setCommentStatus($com_id, $status) {
        $this->comments->sql("UPDATE comments SET comment_status = :status WHERE comment_id = :id",
            ["status" => $status, "id" => $com_id]);
        return true;
    }

    public function getData() {
        $data = array();
        $data["counter"] = array();
        $sql = "SELECT (SELECT COUNT(post_id) FROM posts) AS postCount, ";
        $sql .= "(SELECT COUNT(post_id) FROM posts WHERE post_status = 'draft') AS draftPostCount, ";
        $sql .= "(SELECT COUNT(comment_id) FROM comments) AS comCount, ";
        $sql .= "(SELECT COUNT(comment_id) FROM comments WHERE comment_status = 'Unapproved') AS unappComCount, ";
        $sql .= "(SELECT COUNT(user_id) FROM users) AS userCount, ";
        $sql .= "(SELECT COUNT(user_id) FROM users WHERE user_role = 'Subscriber') AS subUserCount, ";
        $sql .= "(SELECT COUNT(cat_id) FROM category) AS catCount";
        $counts = $this->posts->getRow($sql);
        $data["counter"]["posts_count"] = $counts["postCount"];
        $data["counter"]["comments_count"] = $counts["comCount"];
        $data["counter"]["users_count"] = $counts["userCount"];
        $data["counter"]["cats_count"] = $counts["catCount"];
        return $data;
    }

    public function getCategoriesPage() {
        $data = array();
        $sql = "SELECT * FROM category";
        $data["categories"] = $this->categories->getRows($sql);
        return $data;
    }

    public function getCommentsPage() {
        $data = array();
        $sql = "SELECT posts.post_title AS 'post_title', users.username AS 'username', users.user_email AS 'user_email', comments.* FROM comments ";
        $sql .= "INNER JOIN posts ON comments.comment_post_id = posts.post_id ";
        $sql .= "LEFT JOIN users ON comments.comment_author_id = users.user_id";
        $data["comments"] = $this->comments->getRows($sql);
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
        if (isset($_POST["create_post"])) {
            //TODO: implement the image uploading
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                "post_title" => filterInput($_POST["post_title"]),
                "post_title_error" => "",
                "post_tags" => filterInput($_POST["post_tags"]),
                "post_tags_error" => "",
                "post_content" => filterInput($_POST["post_content"]),
                "post_content_error" => ""
            ];
            if (empty($data["post_title"])) {
                $data["post_title_error"] = "Post_title should not be empty";
            } elseif ($this->checkIfPostExists($data["post_title"])) {
                $data["post_title_error"] = "Post with such name already exists";
            }

            if (empty($data["post_tags"])) {
                $data["post_tags_error"] = "Post tags should not be empty";
            }

            if (empty($data["post_content"])) {
                $data["post_content_error"] = "Post content should not be empty";
            }

            if (empty($data["post_title_error"]) && empty($data["post_tags_error"]) && empty($data["post_content_error"])) {
                if ($this->addPost(["cat_id" => $_POST["post_category_id"], "ttl" => $data["post_title"], "auth_id" => $_SESSION["user_id"],
                    "img" => NULL, "cont" => $data["post_content"], "tag" => $data["post_tags"], "stat" => $_POST["post_status"]])) {
//                    flashMessager("");
                    // TODO: implement the flash message of adding posts
                    redirect("admin/posts");
                }
                else {
                    die("Error occured during adding post");
                }
            }
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
        $data["categories"] = $this->categories->getRows("SELECT * FROM category");
        return $data;
    }

    public function getEditPostPage($post_id = NULL) {
        $data = array();
        if ($post_id == NULL) {
            redirect("admin/posts");
            exit();
        }
        if (isset($_POST["submit_edit"])) {
            $data = [
                "post_title" => filterInput($_POST["post_title"]),
                "post_title_error" => "",
                "post_image" => "",
                "post_image_error" => "",
                "post_tags" => filterInput($_POST["post_tags"]),
                "post_tags_error" => "",
                "post_content" => filterInput($_POST["post_content"]),
                "post_content_error" => ""
            ];
            if (empty($data["post_title"])) {
                $data["post_title_error"] = "Post title should not be empty";
            } elseif ($this->checkIfPostExists($data["post_title"])) {
                $data["post_title_error"] = "Post with such title already exists";
            }

            if (empty($data["post_tags"])) {
                $data["post_tags_error"] = "Tags should not be empty";
            }

            if (empty($data["post_content"])) {
                $data["post_content_error"] = "Post content should not be empty";
            }
        } else {
            $post = $this->posts->getRow("SELECT * FROM posts WHERE post_id = :id", ["id" => $post_id]);
            $data = [
                "post_title" => $post["post_title"],
                "post_title_error" => "",
                "post_image" => $post["post_image"],
                "post_image_error" => "",
                "post_tags" => $post["post_tags"],
                "post_tags_error" => "",
                "post_content" => $post["post_content"],
                "post_content_error" => ""
            ];
        }
        $data["categories"] = $this->categories->getRows("SELECT * FROM category");
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
}
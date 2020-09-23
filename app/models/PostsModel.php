<?php
namespace App\Models;
use App\Classes\Model;
use App\Classes\CrudPostsController;
class PostsModel implements Model {

    private $posts;

    public function __construct() {
        $this->posts = CrudPostsController::getInstance();
    }

    public function getData($arg1)
    {
        $data = array();
        if (isset($arg1)) {
            $data["users"] = $this->posts->getRows("SELECT * from posts where post_id = :id", ["id" => $arg1]);
        }
        else {
            $data["users"] = $this->posts->getRows("SELECT * from posts");
        }
        return $data;
    }
}
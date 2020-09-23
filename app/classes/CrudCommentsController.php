<?php
namespace App\Classes;
class CrudCommentsController extends Database implements CrudController {

    use basicPdoFunctions;

    public function __destruct() {

    }

    public function Insert($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        try {
            $this->beginTransaction();
            $sql = "INSERT into comments (comment_post_id, comment_author_id, comment_content, comment_status, comment_date) ";
            $sql .= "VALUES (:post_id, :auth_id, :cont, :stat, now())";
            $this->run($sql, $values);
            $post = CrudPostsController::getInstance();
            var_dump($post);
            $sql = "UPDATE posts SET post_comment_count = post_comment_count + 1 where post_id = :id";
            $post->sql($sql, ["id" => $values["post_id"]]);
            $this->commit();
        } catch (\PDOException $e) {
            $this->rollBack();
            die($e->getMessage());
        }
    }

    public function Delete($values = []) {
        if (empty($values)) {
            die("Vi eblan");
        }
        try {
            $this->beginTransaction();
            $sql = "DELETE from comments where comment_id = :id";
            $this->run($sql, ["id" => $values["id"]]);
            $user = CrudPostsController::getInstance();
            $sql = "UPDATE posts SET post_comment_count = post_comment_count - 1 where post_id = :post_id";
            $user->sql($sql, ["post_id" => $values["post_id"]]);
            $this->commit();
        } catch (PDOException $e) {
            $this->rollBack();
            die($e->getMessage());
        }

    }

    public function Update($values = []) {
        $sql = "UPDATE comments SET comment_content = :cont, comment_status = 'Unapproved', ";
        $sql .= "comment_date = now() where comment_id = :id";
        $this->run($sql, $values);
    }
}
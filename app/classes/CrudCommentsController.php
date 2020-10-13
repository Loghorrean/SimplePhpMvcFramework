<?php
namespace App\Classes;
class CrudCommentsController extends Database implements CrudController {

    use basicPdoFunctions;

    public function Insert($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        try {
            $this->beginTransaction();
            $sql = "INSERT INTO comments (comment_post_id, comment_author_id, comment_content, comment_status, comment_date) ";
            $sql .= "VALUES (:post_id, :auth_id, :cont, :stat, now())";
            $this->run($sql, $values);
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
            $sql = "DELETE FROM comments WHERE comment_id = :id";
            $this->run($sql, ["id" => $values["id"]]);
            $this->commit();
        } catch (\PDOException $e) {
            $this->rollBack();
            die($e->getMessage());
        }

    }

    public function Update($values = []) {
        $sql = "UPDATE comments SET comment_content = :cont, comment_status = 'Unapproved', ";
        $sql .= "comment_date = now() WHERE comment_id = :id";
        $this->run($sql, $values);
    }
}
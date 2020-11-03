<?php
namespace App\Classes;
class CrudCommentsController extends Database implements CrudController {

    use basicPdoFunctions;

    public function getAll() : array {
        $sql = "SELECT users.username AS 'comment_author', comments.* FROM comments ";
        $sql .= "LEFT JOIN users ON users.user_id = comments.comment_author_id ";
        $sql .= "WHERE comment_status = 'Approved' ORDER BY comment_id DESC";
        return $this->getRows($sql);
    }

    public function getOneById(int $id) : array {
        $sql = "SELECT users.username AS 'comment_author', comments.* FROM comments ";
        $sql .= "LEFT JOIN users ON users.user_id = comments.comment_author_id ";
        $sql .= "WHERE comment_status = 'Approved' and comment_id = :id ORDER BY comment_id DESC";
        return $this->getRow($sql, ["id" => $id]);
    }

    public function Insert(array $values = []) : void {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        try {
            $sql = "INSERT INTO comments (comment_post_id, comment_author_id, comment_content, comment_status, comment_date) ";
            $sql .= "VALUES (:post_id, :auth_id, :cont, :stat, now())";
            $this->run($sql, $values);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete(array $values = []) : void {
        if (empty($values)) {
            die("Vi eblan");
        }
        try {
            $sql = "DELETE FROM comments WHERE comment_id = :id";
            $this->run($sql, ["id" => $values["id"]]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

    }

    public function Update(array $values = []) : void {
        $sql = "UPDATE comments SET comment_content = :cont, comment_status = 'Unapproved', ";
        $sql .= "comment_date = now() WHERE comment_id = :id";
        $this->run($sql, $values);
    }
}
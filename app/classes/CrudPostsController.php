<?php
namespace App\Classes;
class CrudPostsController extends Database implements CrudController {

    use basicPdoFunctions;

    public function getAll() : array {
        $sql = "SELECT users.username AS 'username', posts.* FROM posts ";
        $sql .= "LEFT JOIN users ON users.user_id = posts.post_author_id WHERE post_status = 'Published'";
        return $this->getRows($sql);
    }

    public function getOneById(int $id): array {
        $sql = "SELECT users.username AS 'username', posts.* FROM posts ";
        $sql .= "LEFT JOIN users ON users.user_id = posts.post_author_id WHERE post_status = 'Published' ";
        $sql .= "AND post_id = :id";
        return $this->getRow($sql, ["id" => $id]);
    }

    public function Insert(array $values = []) : void {
        try {
            $sql = "INSERT INTO posts (post_category_id, post_title, post_author_id, post_date, post_image, post_content, post_tags, post_status) ";
            $sql .= "VALUES (:cat_id, :ttl, :auth_id, now(), :img, :cont, :tag, :stat)";
            $this->run($sql, $values);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Update(array $values = []) : void {
        try {
            $sql = "UPDATE posts SET post_category_id = :cat_id, post_title = :ttl, post_author_id = :auth_id, ";
            $sql .= "post_date = now(), post_image = :img, post_content = :cnt, post_tags = :tags, post_status = :stat ";
            $sql .= "WHERE post_id = :id";
            $this->run($sql, $values);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete(array $values = []) : void {
        try {
            $sql = "DELETE FROM posts WHERE post_id = :id";
            $this->run($sql, $values);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}

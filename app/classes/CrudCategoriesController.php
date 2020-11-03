<?php
namespace App\Classes;
class CrudCategoriesController extends Database implements CrudController {

    use basicPdoFunctions;

    public function getAll() : array {
        $sql = "SELECT * FROM category";
        return $this->getRows($sql);
    }

    public function getOneById(int $id) : array {
        $sql = "SELECT * FROM category WHERE cat_id = :id";
        return $this->getRow($sql, ["id" => $id]);
    }

    public function Insert(array $values = []) : void {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "INSERT INTO category (cat_title) VALUES (:cat_ttl)";
        $this->run($sql, $values);
    }

    public function Update(array $values = []) : void {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "UPDATE category SET cat_title = :ttl WHERE category.cat_id = :id";
        $this->run($sql, $values);
    }

    public function Delete(array $values = []) : void {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "DELETE FROM category WHERE cat_id = :id";
        $this->run($sql, $values);
    }
}

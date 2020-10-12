<?php
namespace App\Classes;
class CrudCategoriesController extends Database implements CrudController {

    use basicPdoFunctions;

    public function Insert($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "INSERT INTO category (cat_title) VALUES (:cat_ttl)";
        $this->run($sql, $values);
    }

    public function Update($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "UPDATE category SET cat_title = :ttl WHERE category.cat_id = :id";
        $this->run($sql, $values);
    }

    public function Delete($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "DELETE FROM category WHERE cat_id = :id";
        $this->run($sql, $values);
    }

    public function __destruct() {

    }
}

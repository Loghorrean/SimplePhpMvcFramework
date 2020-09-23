<?php
namespace App\Classes;
class CrudCategoriesController extends Database implements CrudController {

    use basicPdoFunctions;

    public function Insert($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "INSERT into category (cat_title) VALUES (:cat_ttl)";
        $this->run($sql, $values);
    }

    public function Update($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "UPDATE category SET cat_title = :ttl where category.cat_id = :id";
        $this->run($sql, $values);
    }

    public function Delete($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "DELETE from category where cat_id = :id";
        $this->run($sql, $values);
    }

    public function __destruct() {

    }
}

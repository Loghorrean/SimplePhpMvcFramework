<?php
namespace App\Classes;
class CrudUsersController extends Database implements CrudController {

    use basicPdoFunctions;

    public function Insert($values = []) {
        $sql = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_image, user_role, randSalt) ";
        $sql .= "VALUES (:name, :pwd, :fname, :lname, :mail, :img, :role, :salt)";
        $this->run($sql, $values);
    }

    public function Update($values = []) {
        $sql = "UPDATE users SET username = :nam, user_firstname = :fname, user_lastname = :lname, ";
        $sql .= "user_email = :mail, user_image = :img, user_role = :role where user_id = :id";
        $this->run($sql, $values);
    }

    public function Delete($values = []) {
        $sql = "DELETE FROM users WHERE user_id = :id";
        $this->run($sql, $values);
    }
}

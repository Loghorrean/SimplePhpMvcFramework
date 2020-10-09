<?php
namespace App\Models;
use App\Classes\Model;
use App\Classes\CrudUsersController;
class UsersModel implements Model {
    private $users;
    public function __construct() {
        $this->users = CrudUsersController::getInstance();
    }

    public function getData() {

    }

    public function checkIfUserExists($username) {
        $user = $this->users->getRow("SELECT * from users where username = :name", ["name" => $username]);
        if ($user) {
            return true;
        }
        return false;
    }

    public function checkIfEmailExists($email) {
        $user = $this->users->getRow("SELECT * from users where user_email = :mail", ["mail" => $email]);
        if ($user) {
            return true;
        }
        return false;
    }

    public function register($data) {
        $salt = generateSalt();
        $data["password"] = hash("md5",$salt.$data["password"]);
        $this->users->sql("INSERT INTO users (username, user_password, user_email) VALUES (:name, :pwd, :mail)",
            ["name" => $data["name"], "pwd" => $data["password"], "mail" => $data["email"]]);
        $_SESSION["success"] = "You are registered!";
        $_SESSION["auth"] = true;
        $_SESSION["user_id"] = $this->users->lastInsertId();
        $_SESSION["username"] = $data["name"];
        $_SESSION["user_role"] = "subscriber";
        return true;
    }
}
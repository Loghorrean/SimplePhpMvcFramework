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
        if ($user != NULL) {
            return true;
        }
        return false;
    }

    public function checkIfEmailExists($email) {
        $user = $this->users->getRow("SELECT * FROM users WHERE user_email = :mail", ["mail" => $email]);
        if ($user != NULL) {
            return true;
        }
        return false;
    }

    public function checkIfPasswordMatch($username, $password) {
        $user = $this->users->getRow("SELECT * FROM users WHERE username = :name", ["name" => $username]);
        $hashed_password = hash("md5", $user["randSalt"].$password);
        if ($hashed_password != $user["user_password"]) {
            return false;
        }
        return true;
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

    public function login($data) {
        $user = $this->users->getRow("SELECT * FROM users WHERE username = :name", ["name" => $data["name"]]);
        $_SESSION["auth"] = true;
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["user_role"] = $user["user_role"];
        $_SESSION["success"] = "You are logged in!";
        return true;
    }
}
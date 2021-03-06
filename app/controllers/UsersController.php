<?php
namespace App\Controllers;
use App\Classes\Controller;
use App\Loggers\UserLogger;

class UsersController extends Controller {
    private $logger;
    public function __construct() {
        $this->model = $this->getModel("UsersModel");
        $this->logger = UserLogger::getInstance();
    }

    public function registration() {
        $data = [
            "name" => "",
            "name_error" => "",
            "email" => "",
            "email_error" => "",
            "password" => "",
            "password_error" => "",
            "verify_password" => "",
            "verify_password_error" => "",
        ];

        if (isset($_POST["submitReg"])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data["name"] = filterInput($_POST["username"]);
            $data["email"] = filterInput($_POST["email"]);
            $data["password"] = filterInput($_POST["password"]);
            $data["verify_password"] = filterInput($_POST["verify_password"]);

            if (empty($data["name"])) {
                $data["name_error"] = "Name field must be filled";
            } elseif ($this->model->checkIfUserExists($data["name"])) {
                $data["name_error"] = "Username is already taken, try another";
            }

            if (empty($data["email"])) {
                $data["email_error"] = "Email field must be filled";
            } elseif ($this->model->checkIfEmailExists($data["email"])) {
                $data["email_error"] = "Email is already taken";
            }

            if (empty($data["password"])) {
                $data["password_error"] = "Password field must be filled";
            } elseif (!checkPassword($data["password"])) {
                $data["password_error"] = $_SESSION["error"];
            }

            if (empty($data["verify_password"])) {
                $data["verify_password_error"] = "This field must be filled too";
            } elseif ($data["password"] !== $data["verify_password"]) {
                $data["verify_password_error"] = "Passwords do not match";
            }
            if (empty($data["name_error"]) && empty($data["email_error"])
                && empty($data["password_error"]) && empty($data["verify_password_error"])) {
                if ($this->model->register($data)) {
                    $this->logger->logAction($_SESSION["username"] . " just got registered");
                    flashMessager("registration_success", "You are registered as " . $_SESSION["username"]);
                    unset($_SESSION["username"]);
                    redirect("users/login");
                    exit();
                }
                else {
                    die("Error");
                }
            }
        }
        $this->getView('Users/registration', $data);
    }

    public function login() {
        if (isset($_POST["submitLog"])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                "name" => filterInput($_POST["username"]),
                "password" => filterInput($_POST["password"]),
                "name_error" => "",
                "password_error" => "",
            ];
            if (empty($data["name"])) {
                $data["name_error"] = "This field must be filled";
            } elseif(!$this->model->checkIfUserExists($data["name"])) {
                $data["password_error"] = "Wrong username/password";
            }

            if (empty($data["password"])) {
                $data["password_error"] = "This field must be filled";
            }

            if (empty($data["name_error"]) && empty($data["password_error"])) {
                if(!$this->model->checkIfPasswordMatch($data["name"], $data["password"])) {
                    $data["password_error"] = "Wrong username/password!";
                } else {
                    if ($this->model->login($data)) {
                        $this->logger->logAction($_SESSION["username"] . " just logged in");
                        redirect("main");
                    } else {
                        die("Error");
                    }
                }
            }

            $this->getView('Users/login', $data);
        } else {
            $data = [
                "name" => "",
                "name_error" => "",
                "password" => "",
                "password_error" => "",
            ];
            $this->getView('Users/login', $data);
        }
    }

    public function logout() {
        $this->logger->logAction($_SESSION["username"] . " just logged out");
        session_destroy();
        header("Location: ".URL_ROOT);
    }
}
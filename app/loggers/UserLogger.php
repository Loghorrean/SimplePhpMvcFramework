<?php
namespace App\Loggers;

class UserLogger extends BaseLogger {
    protected function __construct() {
        parent::__construct("userLogs.txt");
    }

    public function logAction($message) {
        $message = "Action: " . $message;
        parent::logAction($message);
    }

    public function logException($message) {
        $message = "Unhandled exception: " . $message;
        parent::logException($message);
    }
}
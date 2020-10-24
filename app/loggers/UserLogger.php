<?php
namespace App\Loggers;

class UserLogger extends BaseLogger {
    protected function __construct() {
        parent::__construct("userLogs.txt");
    }
}
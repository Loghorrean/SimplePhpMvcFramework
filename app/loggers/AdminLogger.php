<?php
namespace App\Loggers;

class AdminLogger extends BaseLogger {
    protected function __construct() {
        parent::__construct("adminLogs.txt");
    }
}
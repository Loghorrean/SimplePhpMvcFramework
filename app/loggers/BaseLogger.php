<?php
namespace App\loggers;

abstract class BaseLogger {
    protected static $path = APP_ROOT."/logs/";
    private static $instances = array();
    protected $file;
    protected $fileStream;

    protected function __construct($filename) {
        $this->file = $filename;
        $this->fileStream = fopen(self::$path.$filename, "a+");
    }

    private function __clone() {

    }
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static;
        }
        return self::$instances[$class];
    }

    public function logAction($message) {
        $message .= PHP_EOL;
        if (!fwrite($this->fileStream, $message)) {
            $message = $message . PHP_EOL;
            die("File " . $this->file . " is corrupted ad could not be opened");
        }
    }

    public function logException($message) {
        $message = "Unhandled Exception : " . $message . PHP_EOL;
        if (!fwrite($this->fileStream, $message)) {
            die("File " . $this->file . " is corrupted ad could not be opened");
        }
    }

    public function setPath($path) {
        $this::$path = $path;
    }

    public function __destruct() {
        fclose($this->fileStream);
    }
}
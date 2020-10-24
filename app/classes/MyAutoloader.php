<?php
namespace App\Classes;
class MyAutoloader {
    public static function Classloader($classname) {
        $prefix = "App\\Classes\\";
        $base_dir = APP_ROOT."/classes";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
    }

    public static function ControllerLoader($classname) {
        $prefix = "App\\Controllers\\";
        $base_dir = APP_ROOT."/controllers";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
    }

    public static function ConfigLoader($classname) {
        $prefix = "App\\Config\\";
        $base_dir = APP_ROOT."/config";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
    }

    public static function ModelLoader($classname) {
        $prefix = "App\\Models\\";
        $base_dir = APP_ROOT."/models";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
    }

    public static function LoggerLoader($loggerName) {
        $prefix = "App\\Loggers\\";
        $base_dir = APP_ROOT."/loggers";
        MyAutoloader::Loader($prefix, $base_dir, $loggerName);
    }

    private static function Loader($prefix, $base_dir, $classname) {
        $len = strlen($prefix);
        if (strncmp($prefix, $classname, $len) !== 0) {
            return;
        }
        $relative_class = substr($classname, $len);
        $file = $base_dir."/".str_replace("\\", "/", $relative_class).".php";
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
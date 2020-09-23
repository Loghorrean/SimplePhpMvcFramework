<?php
namespace App\Classes;
class MyAutoloader {
    public static function Classloader($classname) {
        $prefix = "App\\Classes\\";
        $base_dir = __DIR__;
        MyAutoloader::Loader($prefix, $base_dir, $classname);
        return;
    }

    public static function ControllerLoader($classname) {
        $prefix = "App\\Controllers\\";
        $base_dir = __DIR__."/../controllers";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
        return;
    }

    public static function ConfigLoader($classname) {
        $prefix = "App\\Config\\";
        $base_dir = __DIR__."/../config";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
        return;
    }
    public static function ModelLoader($classname) {
        $prefix = "App\\Models\\";
        $base_dir = __DIR__."/../models";
        MyAutoloader::Loader($prefix, $base_dir, $classname);
        return;
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
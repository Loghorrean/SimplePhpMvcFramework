<?php
require_once __DIR__."/helpers/functions.php";
require_once __DIR__."/config/Config.php";
require_once __DIR__."/classes/MyAutoloader.php";
use App\Classes\MyAutoloader;
use App\Classes\Core;

//AutoLoad
spl_autoload_register(function ($class) {
    MyAutoloader::Classloader($class);
});
spl_autoload_register(function ($class) {
    MyAutoloader::ControllerLoader($class);
});
spl_autoload_register(function ($class) {
    MyAutoloader::Configloader($class);
});
spl_autoload_register(function ($class) {
    MyAutoloader::Modelloader($class);
});
spl_autoload_register(function ($class) {
    MyAutoloader::Loggerloader($class);
});
$core = new Core();
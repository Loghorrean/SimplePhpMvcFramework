<?php
namespace App\Config;
abstract class Config {
    const DB_HOST = "localhost";
    const DB_PORT = "3307";
    const DB_NAME = "cms";
    const DB_USER = "root";
    const DB_PASS = "potryasno1233";
}
//App Root
define ('APP_ROOT', dirname(dirname(__FILE__)));
//URL Root
define('URL_ROOT', 'http://localhost/mvcframework');
//Max file size to upload
define ("MAX_FILE_SIZE", 5000000);
//Allowed types of files to upload
define ("ALLOWED_TYPES", array("jpeg", "png", "jpg", "bmp", "gif"));
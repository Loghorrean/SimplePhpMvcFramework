<?php
if (file_exists(__DIR__."/../app/bootstrap.php")) {
    require_once __DIR__."/../app/bootstrap.php";
}
else {
    die("Bootstrap file is not located");
}
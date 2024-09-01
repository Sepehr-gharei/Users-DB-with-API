<?php

include("app/users.php");

spl_autoload_register(function ($class) {
    $class_file = __DIR__ . "/" . $class . '.php';
    if (file_exists($class_file)){
        include $class_file;
    }
});
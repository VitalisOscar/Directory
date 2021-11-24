<?php

spl_autoload_register(function($name){
    require __DIR__ . "/$name.php";
});

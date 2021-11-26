<?php

spl_autoload_register(function($name){
    if(file_exists(__DIR__.'/'.$name.'.php')){
        require __DIR__ . "/$name.php";
    }
});

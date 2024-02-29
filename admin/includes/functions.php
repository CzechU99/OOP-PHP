<?php 

  function my_autoloader($class){

    $class = strtolower($class);
    $path = "includes/{$class}.php";

    if(file_exists($path)){
      include($path);
    }else{
      die("This file name {$class}.php does not exist...");
    }

  }

  spl_autoload_register('my_autoloader');

  function redirect($location){
    header("Location: {$location}");
  }

?>
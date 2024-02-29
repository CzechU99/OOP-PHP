<?php 

class Cars {

  public $wheels = 4;
  static $door = 5;

  function __construct() {
    echo $this->wheels;
    echo self::$door++;
  }

  function __destruct() {
    echo self::$door--;
  }

}

$bmw = new Cars();
$bmw2 = new Cars();

?>
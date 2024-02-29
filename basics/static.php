<?php 

class Cars {

  public $wheels = 4;
  static $door = 5;

  static function car_detail() {
    echo Cars::$door;
  }

}

echo Cars::car_detail();

?>
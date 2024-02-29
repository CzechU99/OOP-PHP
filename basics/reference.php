<?php 

class Cars {

  static $wheels = 4;
  static $door = 5;

  static function car_detail() {
    return self::$wheels;
    return self::$door;
  }

}

class Trucks extends Cars {

  static function display() {
    echo parent::car_detail();
  }

}

Trucks::display();

?>
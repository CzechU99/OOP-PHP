<?php 

class Cars {

  var $wheels = 4;

  function gretting() {
    echo "Hello Student";
  }

}

$bmw = new Cars();

class Trucks extends Cars {

}

$ford = new Trucks();

echo $ford->wheels;

?>
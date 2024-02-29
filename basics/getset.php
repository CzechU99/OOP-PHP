<?php 

class Cars {

  private $door = 5;

  function getDoor() {
    echo $this->door;
  }

  function setDoor(int $value){
    $this->door = $value;
  }

}

$bmw = new Cars();
$bmw->getDoor();
$bmw->setDoor(6);
$bmw->getDoor();

?>
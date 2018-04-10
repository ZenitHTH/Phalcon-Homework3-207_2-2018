<?php
use Phalcon\Mvc\Model;
class Activities  extends Model{
  public function initialize()
    {
        $this->setSource('activities');
    }
	public function getSource(){
    return "activities"; // ชื่อ ตาราง ใน ฐานข้อมูล จริงๆ
  }
}
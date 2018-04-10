<?php
use Phalcon\Mvc\View;

class EventController extends ControllerBase{

  public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
	  if(!$this->session->has('memberAuthen')) // ตรวจสอบว่ามี session การเข้าระบบ หรือไม่
    		 $this->response->redirect('authen');

   }
   public function indexAction(){


  }




  public function editAction(){
    if($this->request->isPost()){

      $photoUpdate='';
 	   if($this->request->hasFiles() == true){
 		   	$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
 			$uploads = $this->request->getUploadedFiles();

 				$isUploaded = false;
 				foreach($uploads as $upload){
 					if(in_array($upload->gettype(), $allowed)){
 					 $photoName=md5(uniqid(rand(), true)).strtolower($upload->getname());
 					 $path = '../public/img/'.$photoName;
 					 ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
 					}
 				}

 				if($isUploaded)  $photoUpdate=$photoName ;
 		}else
 				 die('You must choose at least one file to send. Please try again.');


      $name = trim($this->request->getPost('act_name')); // รับค่าจาก form
      $date = trim($this->request->getPost('act_date')); // รับค่าจาก form
      $detail = trim($this->request->getPost('act_detail')); // รับค่าจาก form
      //$picture = trim($this->request->getPost('act_picture'));
      $id=$this->session->get('act_num');//activitiesID
      $event=Activities::findFirst("act_num = '$id'"); //เอา no.post มาเทียบกับ id ตรวจ Email
      $event->id=$this->session->get('memberAuthen'); //เป็นเลข ID ที่login อยู่
      $event->act_name=$name;
      $event->act_date=$date;
      $event->act_detail=$detail;
      $event->act_picture=$photoUpdate;
      $event->save();
      $this->response->redirect('event');
      }
  }


  public function addAction(){
    if($this->request->isPost()){
      if($this->request->hasFiles() == true){
         $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
       $uploads = $this->request->getUploadedFiles();

         $isUploaded = false;
         foreach($uploads as $upload){
           if(in_array($upload->gettype(), $allowed)){
            $photoName=md5(uniqid(rand(), true)).strtolower($upload->getname());
            $path = '../public/img/'.$photoName;
            ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
           }
         }

         if($isUploaded)  $photoUpdate=$photoName ;
     }else
          die('You must choose at least one file to send. Please try again.');

      $name = trim($this->request->getPost('act_name')); // รับค่าจาก form
      $date = trim($this->request->getPost('act_date')); // รับค่าจาก form
      $detail = trim($this->request->getPost('act_detail')); // รับค่าจาก form
      $photo = trim($this->request->getPost('act_picture'));
      $event=new Activities();
      $event->id=$this->session->get('memberAuthen');
      $event->act_name=$name;
      $event->act_date=$date;
      $event->act_detail=$detail;
      $event->act_picture=$photoUpdate;
      $event->save();
      $this->response->redirect('event');
      }

  }
  public function setIdAction($temp){
    $this->session->set('act_num',$temp);
	  $this->response->redirect('event/edit');
  }
  public function deleteIdAction($temp){
    $event = Activities::findFirst($temp);
    $event->delete();
	  $this->response->redirect('event');
  }
  }

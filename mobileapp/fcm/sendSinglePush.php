<?php 
//importing required files 
require_once 'DbOperation.php';
require_once 'Firebase.php';
require_once 'Push.php'; 
 
$db = new DbOperation();
 
$response = array(); 
$response['error']=true;
 
if($_SERVER['REQUEST_METHOD']=='POST'){ 
 //hecking the required params 
 if(isset($_POST['message']) and isset($_POST['fromEmail']) and isset($_POST['chatId']) and isset($_POST['destId'])){
 //$from = $db->getUserIdByEmail($_POST['fromEmail']);
// $to = $db->getUserIdByEmail($_POST['destEmail']);

 $to_id=$_POST['destId'];
 $from = $_POST['fromEmail']; 
 $chatId = $_POST['chatId'];
 $message = $_POST['message'];
 $from_id=$db->getUserIdByEmail($from);
 $from_name=$db->getUserNameById($from_id);
 $from_img= $db->getUserPicById($from_id);
 $fromProfession = $db->getUserProfessionById($from_id);
 $imageData="";
 $media_lnk = "";
 $mediaType = "";
 
 if(isset($_POST['imageData']))
 {
	 $imageData=$_POST['imageData'];
	 $mediaArr=json_decode($imageData,true);
				$media_lnk = $mediaArr["secure_url"];
				$mediaType = $mediaArr["type"];
 }
 //creating a new push
 $push = null; 
 //first check if the push has an image with it
 $push = new Push( $chatId, $message, $media_lnk, $from_name, $from_id, $from_img, "1",$fromProfession,$mediaType);

 
 //getting the push from push object
 $mPushNotification = $push->getPush(); 
 //getting the token from database object 
 $devicetoken = $db->getTokenById($to_id);
 //creating firebase class object 
 $firebase = new Firebase();
 
	 //inserting new message in db
	 if($db->addMessage($chatId,$from_id,$to_id,$message,$imageData)){
		  $response['error']=false;
		  //getting push notification and sending message
		   $result= json_decode($firebase->send($devicetoken, $mPushNotification), true);
			 if($result["success"]){
				 $response['sent']=true;
			 }
		  echo json_encode($response);
		  $db->updateChat($from_id,$message,$chatId);
	}	
 
 
 }else{
 $response['error']=true;
 $response['message']='Parameters missing';
 echo json_encode($response);
 }
}else{
 $response['error']=true;
 $response['message']='Invalid request';
 echo json_encode($response);
}
 

?>
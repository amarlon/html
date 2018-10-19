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
 if(isset($_POST['message']) and isset($_POST['fromEmail']) and isset($_POST['chatId'])) {
 //creating a new push
 $from = $_POST['fromEmail']; 
 $chatId = $_POST['chatId'];
 $message = $_POST['message'];
 $from_id=$db->getUserIdByEmail($from);
 $from_name=$db->getUserNameById($from_id);
 $group_name = $db->getGroupNameById($chatId);
 $from_img= $db->getGroupPicById($chatId);
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
 //$push = new Push( $chatId, $message, $media_lnk, $from_name, $from_id, $from_img,"0");

 //Added by Bonaventure DOSSOU

 $push = new Push( $chatId, $from_name.':'.$message, $media_lnk, $group_name, $from_id, $from_img,"0",$fromProfession,$mediaType);
 
 //getting the push from push object
 $mPushNotification = $push->getPush(); 
 
 //getting the token from database object
 $tokGroup = array();
 $tokGroup = $db->getGroupTokens($chatId);
 
 //creating firebase class object 
 $firebase = new Firebase(); 
 
 //inserting new message in db
	 if($db->addGroupMessage($chatId,$from_id,$message,$imageData)){
		  $response['error']=false;
		  //sending push notification message to group
		   $result= json_decode($firebase->sendToGroup($tokGroup, $mPushNotification), true);
			 if($result["success"]){
				 $response['sent']=true;
			 }
			 //sending push notification and displaying result
		  echo json_encode($response);
		  $db->updateGroupChat($from_id,$message,$chatId);
	}	

 }else{
 $response['error']=true;
 $response['message']='Parameters missing';
 }
}else{
 $response['error']=true;
 $response['message']='Invalid request';
}
?>

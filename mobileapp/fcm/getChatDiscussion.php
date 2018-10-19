<?php 
//importing required files 
require_once 'DbOperation.php';

$db = new DbOperation();
 
if($_SERVER['REQUEST_METHOD']=='POST'){ 
 //hecking the required params 
	if(isset($_POST['chat_id']) and isset($_POST['chat_type'])){
		if($_POST['chat_type']=="1"){
			echo json_encode($db->getUserChatDiscussion($_POST['chat_id']));
		}else if($_POST['chat_type']=="0") {
			echo json_encode($db->getGroupChatDiscussion($_POST['chat_id']));
		}
		
	}
 }
 ?>
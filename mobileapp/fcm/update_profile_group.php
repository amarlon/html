<?php 
//importing required files 
require_once 'DbOperation.php';

$db = new DbOperation();
 
if($_SERVER['REQUEST_METHOD']=='POST'){ 
 //hecking the required params 
	if(isset($_POST['chat_id']) and isset($_POST['pic_url'])){
			echo json_encode($db->updateGroupChatProfile($_POST['chat_id'],$_POST['pic_url']));		
	}
 }
 ?>
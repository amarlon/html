<?php 
//importing required files 
require_once 'DbOperation.php';

 
$db = new DbOperation();
$chatlistsing=array();
$chatlistgrp=array();
$response = array();
 
if($_SERVER['REQUEST_METHOD']=='POST'){ 
 //hecking the required params 
	if(isset($_POST['email'])){
		$id=$db->getUserIdByEmail($_POST['email']);
		$chatlistsing = $db->getUserSingleChatList($id);
		$chatlistgrp = $db->getUserGroupChatList($id);
		$response =array_merge($chatlistsing,$chatlistgrp);
		echo json_encode($response);
	}
 }

 ?>
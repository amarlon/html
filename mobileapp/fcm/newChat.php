<?php 
//importing required files 
require_once 'DbOperation.php';

$db = new DbOperation();
$response=array();
$response["error"]=true;
if($_SERVER['REQUEST_METHOD']=='POST'){ 
	 //hecking the required params 
	 if(isset($_POST['destEmail']) and isset($_POST['fromEmail'])){
			$to = $db->getUserIdByEmail($_POST['destEmail']);
			$from = $db->getUserIdByEmail($_POST['fromEmail']);
			$res=$db->addNewChat($from,$to);
			
				 if($res["success"]){
					$response["error"]=false;
					$response["chatid"]=$res["chatid"];	
					$response["chat_user_name"]=$db->getUserNameById($to);
					$response["destId"] = $to;
					$response["type"] = 1;
				}
	 	 
				echo json_encode($response);
		}
 
	}
 ?>
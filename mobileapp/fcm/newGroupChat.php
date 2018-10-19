<?php 
//importing required files 
require_once 'DbOperation.php';

$db = new DbOperation();
$response=array();
$response["error"]=true;
if($_SERVER['REQUEST_METHOD']=='POST'){ 
	 //hecking the required params 
	 if(isset($_POST['groupMembers']) and isset($_POST['goupName'])){
			$groupMembers = $_POST['groupMembers'];
			$goupName = $_POST['goupName'];
			$res=$db->addNewGroupChat($groupMembers,$goupName);
			
				 if($res["success"]){
					$response["error"]=false;
					$response["chatid"]=$res["chatid"];	
					$response["group_chat_name"]=$goupName;
					$response["type"] = 0;
				}
	 	 
				echo json_encode($response);
		}
 
	}
 ?>
<?php 
//importing required files 
require_once 'DbOperation.php';

$db = new DbOperation();
$error['error'] = true;
if($_SERVER['REQUEST_METHOD']=='POST'){ 
	 //hecking the required params 

	 if(isset($_POST['member_id']) and isset($_POST['goupId'])){

			 $member_id= $_POST['member_id'];

			$goupId = $_POST['goupId'];
			$res=$db->addNewGroupMember($member_id,$goupId);
			//echo $res;
				 if($res==1){
					$error['error']=false;
					
				}
	 	 
				echo json_encode($error);
		}
 
	}
 ?>

<?php
//encoding the file and datas
header('Content-Type:application/json ; charset=utf-8');
//inclusion faite pour établir la connexion une seule fois
//conseillé d'avoir une seule connexion entrante dans la base de données

require_once dirname(__FILE__) . '/DbConnect.php';
		$db = new DbConnect();
        $conn = $db->connect();
        //$offset = $_POST['OFFSET'];  
        $username = $_POST['username'];
		$stmt = $conn->prepare("SELECT users.id,users.fullname,users.email,users.image FROM users WHERE fullname LIKE '%".$username."%'");
      

      	if ($stmt->execute()) {
           
           $final_result = array();
           $query_result = array();
		   //bind_result =  definins les cariables dans lesquelles je veux stoquer les résultats 
            $stmt->bind_result($id,$fullname,$user_email,$user_image);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            $stmt->store_result();

            if ($stmt->num_rows >= 0) {
            	while($stmt->fetch()){

                    if ($user_image==null) {
                        $user_image="";
                    }
            
            array_push($query_result,array('name' =>$fullname,'id' =>$id,'email' =>$user_email,'pic_url' =>$user_image));
}

	}
		
        array_push($final_result,array('friends' =>$query_result));
		echo json_encode($final_result,JSON_UNESCAPED_UNICODE);
		$stmt->close();
		
}

else{

    echo "An error occured or there's not such user!";

}

?>
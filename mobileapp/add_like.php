<?php
//encoding the file and datas
//inclusion faite pour établir la connexion une seule fois
//conseillé d'avoir une seule connexion entrante dans la base de données

require_once dirname(__FILE__) . '/DbConnect.php';
	

$db = new mysqli('localhost','root','L*gicXor0110SQLH','hotshi');

$id_post = $_POST['p_id'];
$id_user = $_POST['u_id'];
$db_1 = new DbConnect();
$conn = $db_1->connect();


$sql = "INSERT INTO post_likes(post_likes.post_id,post_likes.user_id) VALUES ('$id_post','$id_user')";

	if (!($db->query($sql))) {

		echo "Failure";

} else {
      


			$stmt1 = $conn->prepare("SELECT user_id,users.fullname,users.email,users.image FROM post_likes INNER JOIN users on users.id = post_likes.user_id WHERE post_likes.post_id = '$id_post'");

            if($stmt1->execute())
            {


            		$result=array();
            		$post_likers = array();
            		$stmt1->bind_result($user_id, $user_name,$user_email,$user_pic_url);
					$stmt1->store_result();
            
            if ($stmt1->num_rows > 0) {

            	while($stmt1->fetch()){

            		if ($user_pic_url==null) {
										
										$user_pic_url = "";
					# code...
				}

				array_push($post_likers,array('name' =>$user_name,'id' =>$user_id,'email' =>$user_email,'pic_url' =>$user_pic_url));
	}		

		}



		array_push($result,array('likers' =>$post_likers));
        echo json_encode($result,JSON_UNESCAPED_UNICODE);

        $stmt1->close();
        exit;
}
			



}

?> 
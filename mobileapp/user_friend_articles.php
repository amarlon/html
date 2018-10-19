<?php
//encoding the file and datas
header('Content-Type:application/json ; charset=utf-8');
//inclusion faite pour établir la connexion une seule fois
//conseillé d'avoir une seule connexion entrante dans la base de données

require_once dirname(__FILE__) . '/DbConnect.php';


function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'Just now';
    }

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return '' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}




        // opening db connection
        $db = new DbConnect();
        $conn = $db->connect();
        $email = $_POST['email'];
        $stmt = $conn->prepare("SELECT users.id as u_id,fullname,is_organisation_user FROM users WHERE users.email = '$email'");
		$friend_list = array();

      	if ($stmt->execute()) {
           
           //bind_result =  definins les cariables dans lesquelles je veux stoquer les résultats 
            $stmt->bind_result($id,$fullname, $is_organisation_user);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

            	while($stmt->fetch()){

            		if($is_organisation_user==0)

            		{

            			
            			$stmt1 = $conn->prepare("SELECT users.id as friend_id FROM messages_map INNER JOIN `users` ON users.id=messages_map.user_b_id WHERE messages_map.user_a_id = '$id'");

            		$stmt1->execute();
					$stmt1->bind_result($friend_id);
					$stmt1->store_result();

					if ($stmt1->num_rows >= 0) {
						
						while($stmt1->fetch()){

				array_push($friend_list,$friend_id);

            }

	}

		$stmt2 = $conn->prepare("SELECT users.id as friend_id FROM messages_map INNER JOIN `users` ON users.id=messages_map.user_a_id WHERE messages_map.user_b_id = '$id' ");

            		$stmt2->execute();
					$stmt2->bind_result($friend_id);
					$stmt2->store_result();

					if ($stmt2->num_rows >= 0) {
						
						while($stmt2->fetch()){
						if (!in_array($friend_id, $friend_list)) {

				array_push($friend_list,$friend_id);

            }

	}

}
		
	}

		else   {


					$stmt1 = $conn->prepare("SELECT organisations.id as org_id FROM organisations WHERE name = '$fullname'");

					$stmt1->execute();
		   //bind_result =  definins les cariables dans lesquelles je veux stoquer les résultats 
 					$stmt1->bind_result($org_id);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            		$stmt1->store_result();


					if ($stmt1->num_rows >= 0) {
						
						while($stmt1->fetch()){
						
						$stmt2 = $conn->prepare("SELECT users.id as follower_id FROM follows INNER JOIN `users` ON users.id=follows.user_id WHERE follows.organisation_id = '$org_id'");

					$stmt2->execute();
					$stmt2->bind_result($follower_id);
					$stmt2->store_result();

					if ($stmt2->num_rows >= 0) {
						
						while($stmt2->fetch()){

					array_push($friend_list,$follower_id);

		}


            }

	}


		}
        
	}

}

	}

		$stmt->close();
		
}

$user_articles=array(); 
foreach ($friend_list as $value) {
	$user_id = $value;


		$stmt = $conn->prepare("SELECT articles.id as art_id,users.fullname as author_name, articles.title as art_title , articles.description as art_desc, articles.date_created as art_date , articles.image as art_image , users.image as user_image FROM articles INNER JOIN `users` ON users.id='$user_id' WHERE articles.user_id = '$user_id' ORDER BY articles.id DESC");       

		
		 if ($stmt->execute()) {

            $stmt->bind_result($id,$fullname,$title,$description,$date,$article_image,$user_profile_pic);
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                
                while($stmt->fetch()){

                	if ($article_image==null) {
                		$article_image = '';
                		# code...
                	}

                	if ($user_profile_pic==null) {
                		$user_profile_pic='';
                		# code...
                	}

                	$head = trim($fullname).'-'.$title;

										# code...
										array_push($user_articles,array(
                                                'authId'=>$user_id,
                                                'id'=>$id,
												'title'=>$head,        
												'description'=>strip_tags($description),
												'user_image'=>$user_profile_pic,
												'date'=>get_timeago(strtotime($date)),
												'image'=>$article_image
												)
											);				

								}                               
                
                $stmt->close();
                
                
            } else {
                echo "";
            }
        } else {
         
            echo "";
        }



}

echo json_encode($user_articles,JSON_UNESCAPED_UNICODE);
	


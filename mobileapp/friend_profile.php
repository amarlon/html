<?php
//encoding the file and datas
header('Content-Type:application/json ; charset=utf-8');
//inclusion faite pour établir la connexion une seule fois
//conseillé d'avoir une seule connexion entrante dans la base de données

require_once dirname(__FILE__) . '/DbConnect.php';
		$db = new DbConnect();
        $conn = $db->connect();
        $email = $_POST['email'];
		$stmt = $conn->prepare("SELECT users.id as u_id,fullname,firstname,is_organisation_user, users.image as user_image,users.profession as occupation,users.about as about_user,users.website as user_website,users.country_id as location,users.country_origin_id as origin,users.is_active as active,users.tags as skills FROM users WHERE users.email = '$email'");

      	if ($stmt->execute()) {
           
           $status_array = array();
        	$occupation='';
        	$about='';
        	$website='';
        	$location='';
        	$origin='';
        	$active = "Offline";
        	$skills ="";
           $result = array();
           $friend_list = array();
           $follower_list = array();
           $mOrg_list = array();
		   //bind_result =  definins les cariables dans lesquelles je veux stoquer les résultats 
            $stmt->bind_result($id,$fullname,$firstname, $is_organisation_user, $user_image,$profession,$user_about,$user_website,$user_location,$user_origin,$is_active,$user_skills);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

            	while($stmt->fetch()){

            		if($is_organisation_user==0)

            		{

            			
            			if ($profession!=null) {

        		$occupation = strip_tags($profession);
        						
        						}


        				if ($user_about!=null) {

        		$about = strip_tags($user_about);
        	}

        	if ($user_website!=null) {

        		$website = strip_tags($user_website);
        	}

        	if ($user_location!=0) {

        		$id_location = $user_location;

        		$query_country = $conn->prepare("SELECT countries.name as location FROM countries WHERE countries.id = '$id_location'");
        		$query_country->execute();
        		$query_country->bind_result($location_user);
        		$query_country->store_result();

        		if ($query_country->num_rows > 0) {

            	while($query_country->fetch()){

            		$location = $location_user;
            	}

            }

        }

        	if ($user_origin!=0) {
		
			$id_origin = $user_origin;

			$query_country_origin = $conn->prepare("SELECT countries.name as location FROM countries WHERE countries.id = '$id_origin'");
        		$query_country_origin->execute();
        		$query_country_origin->bind_result($origin_user);
        		$query_country_origin->store_result();

        		if ($query_country_origin->num_rows > 0) {

            	while($query_country_origin->fetch()){

            		$origin = $origin_user;
            	}

            }

        }

			if ($is_active==1) {

        		$active = "Online";
        	}

		if ($user_skills!=null) {

        		$skills = strip_tags($user_skills);
        	}



            $stmt1 = $conn->prepare("SELECT users.fullname as friend_name,users.id as friend_id, users.email as friend_email,users.image as friend_pic_url FROM messages_map INNER JOIN `users` ON users.id=messages_map.user_b_id WHERE messages_map.user_a_id = '$id'");

            		$stmt1->execute();
					$stmt1->bind_result($friend_name, $friend_id,$friend_email,$friend_pic_url);
					$stmt1->store_result();

					if ($stmt1->num_rows >= 0) {
						
						while($stmt1->fetch()){
						
								if ($friend_pic_url==null) {
										
										$friend_pic_url = "";
					# code...
				}

				array_push($friend_list,array('name' =>$friend_name,'id' =>$friend_id,'email' =>$friend_email,'pic_url' =>$friend_pic_url));

            }

	}


		$stmt2 = $conn->prepare("SELECT users.fullname as friend_name,users.id as friend_id, users.email as friend_email,users.image as friend_pic_url FROM messages_map INNER JOIN `users` ON users.id=messages_map.user_a_id WHERE messages_map.user_b_id = '$id' ");

            		$stmt2->execute();
					$stmt2->bind_result($friend_name, $friend_id,$friend_email,$friend_pic_url);
					$stmt2->store_result();

					if ($stmt2->num_rows >= 0) {
						
						while($stmt2->fetch()){
						if (!in_array($friend_id, $friend_list)) {

					if ($friend_pic_url==null) {
					$friend_pic_url = "";
					# code...
				}

				array_push($friend_list,array('name' =>$friend_name,'id' =>$friend_id,'email' =>$friend_email,'pic_url' =>$friend_pic_url));

            }

	}

}


		$stmt3 = $conn->prepare("SELECT organisations.name as mOrg_name,organisation_users.organisation_id as mOrg_id,organisations.profile_image as mOrg_pic FROM organisation_users INNER JOIN `organisations` ON organisations.id=organisation_users.organisation_id WHERE organisation_users.user_id = '$id' ");

            		$stmt3->execute();
					$stmt3->bind_result($mOrg_name,$mOrg_id,$mOrg_pic_url);
					$stmt3->store_result();

					if ($stmt3->num_rows >= 0) {
						
						while($stmt3->fetch()){

					if ($mOrg_pic_url==null) {
					$mOrg_pic_url = "";
					# code...
				}

				$stmt4 = $conn->prepare("SELECT users.email as mOrg_email from users WHERE users.fullname = '$mOrg_name'");
				$stmt4->execute();
				$stmt4->bind_result($mOrg_email);
				$stmt4->store_result();
				$stmt4->fetch();
				
				array_push($mOrg_list,array('name' =>$mOrg_name,'id' =>$mOrg_id,'email' =>$mOrg_email,'pic_url' =>$mOrg_pic_url));


	}

}


		if($user_image!=null)
		{
		
						array_push($status_array,array(
						'id'=> $id,	
						'status'=> 'success',        
						'username'=> $fullname,
						'account'=> 'Personal Account',
						'profile_image'=> $user_image,
						'occupation'=> $occupation,
						'about'=> $about,
						'website'=> $website,
						'location'=> $location,
						'origin'=> $origin,
						'active'=> $active,
						'skills'=> $skills,
						'friends'=> $friend_list,
						'orgs'=>$mOrg_list
						)
					);
		}

		else 
		{

			array_push($status_array,array(
						'id'=> $id,
						'status'=> 'success',        
						'username'=> $fullname,
						'account'=> 'Personal Account',
						'profile_image'=> '',
						'occupation'=> $occupation,
						'about'=> $about,
						'website'=> $website,
						'location'=> $location,
						'origin'=> $origin,
						'active'=> $active,
						'skills'=> $skills,
						'friends'=> $friend_list,
						'orgs'=>$mOrg_list
						)
					);
			
		}
		
		echo json_encode($status_array,JSON_UNESCAPED_UNICODE);
        exit;


	}

		else   {



					$stmt1 = $conn->prepare("SELECT organisations.id as org_id ,organisations.is_active as active,organisations.about as org_about,organisations.website as org_website, organisations.country_id as org_location,organisations.intro_video as org_video FROM organisations WHERE name = '$fullname'");
					$stmt1->execute();
		   //bind_result =  definins les cariables dans lesquelles je veux stoquer les résultats 
 					$stmt1->bind_result($org_id,$org_active,$org_about, $org_website, $org_location,$org_intro_video);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            		$stmt1->store_result();

					if ($stmt1->num_rows >= 0) {
						
						while($stmt1->fetch()){


							if ($org_about!=null) {

        		$about = strip_tags($org_about);
        	}

        	if ($org_website!=null) {

        		$website = strip_tags($org_website);
        	}

        	if ($org_active==1) {

        		$active = "Online";
        	}

        	if ($org_intro_video!=null) {
        		$skills = $org_intro_video;
        		# code...
        	}

        	if ($org_location!=0) {

        		$id_location = $org_location;

        		$query_country_org = $conn->prepare("SELECT countries.name as location FROM countries WHERE countries.id = '$id_location'");
        		$query_country_org->execute();
        		$query_country_org->bind_result($location_org);
        		$query_country_org->store_result();

        		if ($query_country_org->num_rows > 0) {

            	while($query_country_org->fetch()){

            		$location = $location_org;
            	}

            }

        }


						
		$stmt2 = $conn->prepare("SELECT users.fullname as follower_name,users.id as follower_id,users.email as follower_email, users.image as follower_pic_url FROM follows INNER JOIN `users` ON users.id=follows.user_id WHERE follows.organisation_id = '$org_id'");

					$stmt2->execute();
					$stmt2->bind_result($follower_name, $follower_id,$follower_email,$follower_pic_url);
					$stmt2->store_result();

					if ($stmt2->num_rows >= 0) {
						
						while($stmt2->fetch()){

					if ($follower_pic_url==null) {
					$follower_pic_url = "";
					# code...
				}

					array_push($follower_list,array('name' =>$follower_name,'id' =>$follower_id,'email' =>$follower_email,'pic_url' =>$follower_pic_url));

		}


            }
        }

    }


		$stmt3 = $conn->prepare("SELECT organisations.name as mOrg_name,organisation_users.organisation_id as mOrg_id,organisations.profile_image as mOrg_pic FROM organisation_users INNER JOIN `organisations` ON organisations.id=organisation_users.organisation_id WHERE organisation_users.user_id = '$id' ");

            		$stmt3->execute();
					$stmt3->bind_result($mOrg_name,$mOrg_id,$mOrg_pic_url);
					$stmt3->store_result();

					if ($stmt3->num_rows >= 0) {
						
						while($stmt3->fetch()){

					if ($mOrg_pic_url==null) {
					$mOrg_pic_url = "";
					# code...
				}

				$stmt4 = $conn->prepare("SELECT users.email as mOrg_email from users WHERE users.fullname = '$mOrg_name'");
				$stmt4->execute();
				$stmt4->bind_result($mOrg_email);
				$stmt4->store_result();
				$stmt4->fetch();

				array_push($mOrg_list,array('name' =>$mOrg_name,'id' =>$mOrg_id,'email' =>$mOrg_email,'pic_url' =>$mOrg_pic_url));


	}

}





            	if($user_image!=null)
		{
		
						array_push($status_array,array(
						'id'=> $id,
						'org_id'=> $org_id,
						'status'=> 'success',        
						'username'=>$fullname,
						'account'=> 'Organisation Account',
						'profile_image'=> $user_image,
						'occupation'=> $occupation,
						'about'=> $about,
						'website'=> $website,
						'location'=> $location,
						'origin'=> $origin,
						'active'=> $active,
						'skills'=> $skills,
						'friends'=> $follower_list,
						'orgs'=>$mOrg_list
						)
					);
		}

		else 
		{

			array_push($status_array,array(
						'id'=> $id,
						'org_id'=> $org_id,
						'status'=> 'success',        
						'username'=> $fullname,
						'account'=> 'Organisation Account',
						'profile_image'=> '',
						'occupation'=> $occupation,
						'about'=> $about,
						'website'=> $website,
						'location'=> $location,
						'origin'=> $origin,
						'active'=> $active,
						'skills'=>$skills,
						'friends'=> $follower_list,
						'orgs'=>$mOrg_list
						)
					);
			
		}
		echo json_encode($status_array,JSON_UNESCAPED_UNICODE);
        exit;

	}
			
}


}

		$stmt->close();
		
}

?>
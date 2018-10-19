<?php
//encoding the file and datas
header('Content-Type:application/json ; charset=utf-8');
//inclusion faite pour établir la connexion une seule fois
//conseillé d'avoir une seule connexion entrante dans la base de données

require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $conn = $db->connect();
		$user_id = $_POST['user_id'];  
		        
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

function multi_in_array($value, $array) 
{ 
    foreach ($array AS $item) 
    { 
        if (!is_array($item)) 
        { 
            if ($item == $value) 
            { 
                return 1; 
            } 
            continue; 
        } 

        if (in_array($value, $item)) 
        { 
            return 1; 
        } 
        else if (multi_in_array($value, $item)) 
        { 
            return 1; 
        } 
    } 
    return 0; 
} 



  

        // opening db connection
        $db = new DbConnect();
        $conn = $db->connect();
        $offset = $_POST['OFFSET']; 
        $id_user = $_POST['id']; 
		$stmt = $conn->prepare("SELECT fullname,users.id as author_id,users.email as author_email,description,posts.id,posts.date_created as post_date,users.image as post_owner_pic,posts.image as post_image , users.profession FROM `posts` INNER JOIN `users` ON users.id=posts.user_id WHERE posts.is_deleted=0 and users.id = '$id_user' ORDER BY posts.id DESC");
  
		 //  LIMIT 20 OFFSET $offset

		 if ($stmt->execute()) {
           $listPosts=array(); $pcomments=array(); $creplys=array(); $has_been_liked = 0 ; $post_likers = array();
		   //bind_result =  definins les cariables dans lesquelles je veux stoquer les résultats 
            $stmt->bind_result($authpost,$author_id,$auth_mail,$pcontent, $pid, $date_post,$image_owner_post,$image_post,$profession);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                
                while($stmt->fetch()){
					$stmt1 = $conn->prepare("SELECT fullname,users.id as auth_comment_id , post_comments.comment,post_comments.id,users.image as comment_user_pic,post_comments.date_created FROM `post_comments` INNER JOIN `users` ON users.id=post_comments.user_id  WHERE post_comments.post_id = ? ");
					// '?' fais pour mésure de sécurité afin d"éviter les injections ou toute autre attaque
					$stmt1->bind_param("s", $pid);//permet de preciser la variable qui doit être à la place de '?'
					$stmt1->execute();
					$stmt1->bind_result($authcomm, $authcomm_id,$ccontent, $cid,$pic_user_comment,$date_comment);
					$stmt1->store_result();
					
					if ($stmt1->num_rows >= 0) {
						
						while($stmt1->fetch() ){
						
							$stmt2 = $conn->prepare("SELECT fullname,post_comment_replies.comment,users.image as reply_user_pic , post_comment_replies.date_created FROM `post_comment_replies` INNER JOIN `users` ON users.id = post_comment_replies.from_user_id WHERE post_comment_replies.comment_id = ? ");
							$stmt2->bind_param("s", $cid);
							$stmt2->execute();
							$stmt2->bind_result($authreply, $rcontent,$pic_user_reply,$reply_date);
							$stmt2->store_result();
							
							if ($stmt2->num_rows >= 0) {
								
									while($stmt2->fetch() ){									
									
									if ($pic_user_reply==null) {
										# code...
										array_push($creplys,array(
												'author_reply'=>$authreply,        
												'rcontent'=>strip_tags($rcontent),
												'reply_pic_url'=>'',
												'reply_date'=>get_timeago(strtotime($reply_date))
												)
											);
									}

									else{

											array_push($creplys,array(
												'author_reply'=>$authreply,        
												'rcontent'=>strip_tags($rcontent),
												'reply_pic_url'=>$pic_user_reply,
												'reply_date'=>get_timeago(strtotime($reply_date))
												)
											);

									}
											
									}

							}

							if ($pic_user_comment==null) {
							

								array_push($pcomments,array(
									'post_id'=>$pid,
									'author_comm'=>$authcomm,
									'author_comm_id'=>$authcomm_id,        
									'ccontent'=>strip_tags($ccontent),
									'id_comment'=>$cid,
									'comment_pic_url'=>'',
									'replys'=>$creplys,
									'comment_date'=>get_timeago(strtotime($date_comment))
									)
								);
								# code...
							}

							else
							{

									array_push($pcomments,array(
									'post_id'=>$pid,
									'author_comm'=>$authcomm,
									'author_comm_id'=>$authcomm_id,        
									'ccontent'=>strip_tags($ccontent),
									'id_comment'=>$cid,
									'comment_pic_url'=>$pic_user_comment,
									'replys'=>$creplys,
									'comment_date'=>get_timeago(strtotime($date_comment))
									)
								);


							}

							$creplys=array();
						}
						
					}

				
				$stmt3 = $conn->prepare("SELECT users.id,users.fullname,users.email,users.image FROM post_likes INNER JOIN users ON users.id = post_likes.user_id WHERE post_likes.post_id = '$pid'");

            if($stmt3->execute())
            {
            		$stmt3->bind_result($user_id, $user_name,$user_email,$user_pic_url);
					$stmt3->store_result();
            
            if ($stmt3->num_rows >= 0) {

            	while($stmt3->fetch()){

            		if ($user_pic_url==null) {
										
										$user_pic_url = "";
					# code...
				}

				array_push($post_likers,array('name' =>$user_name,'id' =>$user_id,'email' =>$user_email,'pic_url' =>$user_pic_url));
	}		

		}

	}


				if (multi_in_array($id_user,$post_likers) == 1) {
					# code...
					$has_been_liked = 1;
				}


				if ($profession==null) {
					$profession = "";
					# code...
				}



					if($image_owner_post == null)
			    
				{
					
					if ($image_post==null) {


						array_push($listPosts,array(
						'date'=>get_timeago(strtotime($date_post)),
						'author'=>$authpost,
						'author_id'=>$author_id,
						'author_email'=>$auth_mail,
						'profession'=>$profession,
						'id_post'=>$pid,
						'picture_url'=>'',
						'post_image_url'=>'',
						'pcontent'=>strip_tags($pcontent),
						'comments'=>$pcomments,
						'likes'=> $post_likers,
						'has_clicked'=> $has_been_liked
						)
					);
						$has_been_liked = 0;

					}

					else
					{

				

						array_push($listPosts,array(
						'date'=>get_timeago(strtotime($date_post)),
						'author'=>$authpost,
						'author_id'=>$author_id,
						'author_email'=>$auth_mail,
						'profession'=>$profession,					
						'id_post'=>$pid,
						'picture_url'=>'',
						'post_image_url'=>$image_post,
						'pcontent'=>strip_tags($pcontent),
						'comments'=>$pcomments,
						'likes'=> $post_likers,
						'has_clicked'=> $has_been_liked
						)
					);
						$has_been_liked = 0;

					}
				}
				
				else
				{

					if ($image_post==null) {
					
				
					array_push($listPosts,array(
						'date'=>get_timeago(strtotime($date_post)),
						'author'=>$authpost,
						'author_id'=>$author_id,
						'author_email'=>$auth_mail,
						'profession'=>$profession,					
						'id_post'=>$pid,
						'picture_url'=>$image_owner_post,
						'post_image_url'=>'',        
						'pcontent'=>strip_tags($pcontent),
						'comments'=>$pcomments,
						'likes'=> $post_likers,
						'has_clicked'=> $has_been_liked
						)
					);

					$has_been_liked = 0;

				}
					else

					{
						array_push($listPosts,array(
						'date'=>get_timeago(strtotime($date_post)),
						'author'=>$authpost,
						'author_id'=>$author_id,
						'author_email'=>$auth_mail,
						'profession'=>$profession,
						'id_post'=>$pid,
						'picture_url'=>$image_owner_post,
						'post_image_url'=>$image_post,        
						'pcontent'=>strip_tags($pcontent),
						'comments'=>$pcomments,
						'likes'=> $post_likers,
						'has_clicked'=> $has_been_liked
						)
					);

						$has_been_liked = 0;
					}

				}
					
					$pcomments=array();
					$has_been_liked = 0;
					$post_likers = array();
		}                               
                
                $stmt->close();
                
                echo json_encode($listPosts,JSON_UNESCAPED_UNICODE);
               
            } else {

            	if (sizeof($listPosts)==0) {

            		# code...
            		echo "No posts linked to this account";
            	}
            	else
            	{
				  echo "Failed to fetch data";

            	}
            }
        } else {
				  echo "Failed to fetch data";
        }


?>
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
    	    		$pid = $_POST['postId'];
					$stmt1 = $conn->prepare("SELECT fullname,users.id as auth_comment_id , post_comments.comment,post_comments.id,users.image as comment_user_pic,post_comments.date_created FROM `post_comments` INNER JOIN `users` ON users.id=post_comments.user_id  WHERE post_comments.post_id = ? ");
					// '?' fais pour mésure de sécurité afin d"éviter les injections ou toute autre attaque
					$stmt1->bind_param("s", $pid);//permet de preciser la variable qui doit être à la place de '?'
					$stmt1->execute();

					$pcomments=array(); $creplys=array();
					$stmt1->bind_result($authcomm, $authcomm_id,$ccontent, $cid,$pic_user_comment,$date_comment);
					$stmt1->store_result();
										
					if ($stmt1->num_rows >= 0) {
						
						while($stmt1->fetch() ){
						
							$stmt2 = $conn->prepare("SELECT post_comment_replies.id,post_comment_replies.from_user_id,fullname,post_comment_replies.comment,users.image as reply_user_pic , post_comment_replies.date_created FROM `post_comment_replies` INNER JOIN `users` ON users.id = post_comment_replies.from_user_id WHERE post_comment_replies.comment_id = ? ");
							$stmt2->bind_param("s", $cid);
							$stmt2->execute();
							$stmt2->bind_result($id,$authid,$authreply, $rcontent,$pic_user_reply,$reply_date);
							$stmt2->store_result();
							
							if ($stmt2->num_rows >= 0) {
								
									while($stmt2->fetch() ){									
									
									if ($pic_user_reply==null) {
										# code...
										array_push($creplys,array(
												'id'=>$id,
												'from'=>$authid,
												'author_reply'=>$authreply,        
												'rcontent'=>strip_tags($rcontent),
												'reply_pic_url'=>'',
												'reply_date'=>get_timeago(strtotime($reply_date))
												)
											);
									}

									else{

											array_push($creplys,array(
												'id'=>$id,						
												'from'=>$authid,
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

  				$stmt1->close();                              
                echo json_encode($pcomments,JSON_UNESCAPED_UNICODE);
                
?>
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
		$user_id = $_POST['user_id'];  
		$stmt = $conn->prepare("SELECT articles.user_id,articles.id as art_id,articles.title as art_title , articles.description as art_desc, articles.date_created as art_date , articles.image as art_image , users.image as user_image,users.fullname FROM articles INNER JOIN `users` ON users.id='$user_id' WHERE articles.user_id = '$user_id' ORDER BY articles.id DESC");       
		
		 if ($stmt->execute()) {

           	$user_articles=array(); 
            $stmt->bind_result($uid,$id,$title,$description,$date,$article_image,$user_profile_pic,$fullname);
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

										# code...
										array_push($user_articles,array(
                                                'authId'=>$uid,
                                                'id'=>$id,
												'title'=>trim($fullname).'-'.$title,        
												'description'=>strip_tags($description),
												'user_image'=>$user_profile_pic,
												'date'=>get_timeago(strtotime($date)),
												'image'=>$article_image
												)
											);				

								}                               
                
                $stmt->close();
                
                echo json_encode($user_articles,JSON_UNESCAPED_UNICODE);
                
            } else {
                
       if (sizeof($user_articles)==0) {

                    # code...
                    echo "No articles linked to this account";
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
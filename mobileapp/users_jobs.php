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
		$stmt = $conn->prepare("SELECT opportunities.user_id,opportunities.id as opp_id,opportunities.title as opp_title , opportunities.description as opp_desc, opportunities.date_created as opp_date , opportunities.image as opp_image , opportunities.qualifications as opp_q, opportunities.skills as opp_skills, opportunities.location as opp_loc,users.image as user_image,users.fullname FROM opportunities INNER JOIN `users` ON users.id='$user_id' WHERE opportunities.user_id = '$user_id' ORDER BY opportunities.id DESC");       
		
		 if ($stmt->execute()) {

           	$user_jobs=array(); 
            $stmt->bind_result($uid,$id,$title,$description,$date,$opp_image,$opp_qlf,$opp_skills,$opp_location,$user_profile_pic,$fullname);
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                
                while($stmt->fetch()){

                	if ($opp_image==null) {
                		$opp_image = '';
                		# code...
                	}

                	if ($user_profile_pic==null) {
                		$user_profile_pic='';
                		# code...
                	}

                        $opp_desc = $description.'dfgQualifications: '.$opp_qlf.'dfgRequired Skills: '.$opp_skills.'dfgLocation : '.$opp_location;
										# code...
										array_push($user_jobs,array(
                                                'authId'=>$uid,
                                                'id'=>$id,
												'title'=>trim($fullname).'-'.$title,        
												'description'=>strip_tags($opp_desc),
												'user_image'=>$user_profile_pic,
												'date'=>get_timeago(strtotime($date)),
												'image'=>$opp_image
												)
											);				

								}                               
                
                $stmt->close();
                
                echo json_encode($user_jobs,JSON_UNESCAPED_UNICODE);
                
            } else {


                if (sizeof($user_jobs)==0) {

                    # code...
                    echo "No jobs linked to this account";
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
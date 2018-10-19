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
		$stmt = $conn->prepare("SELECT projects.user_id ,projects.id as prj_id,projects.title as prj_title , projects.description as prj_desc, projects.date_created as prj_date , projects.image as prj_image , projects.qualifications as prj_q, projects.skills as prj_skills, projects.location as prj_loc,users.image as user_image, users.fullname as prj_auth FROM projects INNER JOIN `users` ON users.id=projects.user_id ORDER BY projects.id DESC");       
		
		 if ($stmt->execute()) {

           	$projects=array(); 
            $stmt->bind_result($uid,$id,$title,$description,$date,$prj_image,$project_qlf,$project_skills,$project_location,$user_profile_pic,$prj_auth);
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                
                while($stmt->fetch()){

                	if ($prj_image==null) {
                		$prj_image = '';
                		# code...
                	}

                	if ($user_profile_pic==null) {
                		$user_profile_pic='';
                		# code...
                	}

                        $proj_desc = $description.'dfgQualifications: '.$project_qlf.'dfgRequired Skills: '.$project_skills.'dfgLocation: '.$project_location;

                                                array_push($projects,array(
                                                'authId'=>$uid,
                                                'id'=>$id,
												'title'=>trim($prj_auth).'-'.$title,        
												'description'=>strip_tags($proj_desc),
												'user_image'=>$user_profile_pic,
												'date'=>get_timeago(strtotime($date)),
												'image'=>$prj_image
												)
											);				

								}                               
                
                $stmt->close();
                
                echo json_encode($projects,JSON_UNESCAPED_UNICODE);
                
            } else {
                


                                if (sizeof($projects)==0) {

                    # code...
                    echo "No projects available";
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
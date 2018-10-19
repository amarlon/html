<?php
//encoding the file and datas
header('Content-Type:application/json ; charset=utf-8');
//inclusion faite pour établir la connexion une seule fois
//conseillé d'avoir une seule connexion entrante dans la base de données
		$db = mysqli_connect('localhost','root','L*gicXor0110SQLH');
        $select_db=mysqli_select_db($db,'hotshi') or die('Could not connect to database');

        $type_account_int = $_POST['type_account_int'];
        $user_id = $_POST['user_id'];
        $tags = $_POST['tags'];
        $profession = $_POST['profession'];
        $about = $_POST['about'];
        $website = $_POST['website'];
        $org_name = $_POST['org_name'];
        $country_origin = $_POST['country_origin'];
        $country_location = $_POST['country_location'];
        $intro_video_secure_url = $_POST['intro_video_secure_url'];
        $intro_video_public_id = $_POST['intro_video_public_id'];
        $intro_video_bytes = $_POST['intro_video_bytes'];

        $secure_url = null;
        $pic_bytes = '';
        $public_id = '';

        if($_POST['secure_url']!="") {
            $secure_url = $_POST['secure_url'];
            $pic_bytes = $_POST['pic_bytes'];
            $public_id = $_POST['public_id'];


            $query=mysqli_query($db,"UPDATE users SET users.image ='$secure_url' , users.image_bytes = '$pic_bytes', users.image_public_id = '$public_id' WHERE users.id = '$user_id'");

                    if ($type_account_int==0) {
        $query=mysqli_query($db,"UPDATE users SET users.profession = '$profession', users.tags = '$tags' , users.about = '$about' , users.website = '$website', users.country_id = '$country_location' ,users.country_origin_id='$country_origin' WHERE users.id = '$user_id'");
        $num_rows= mysqli_num_rows($query);

            if ($num_rows==0) {

                    echo "success";

            }

            else
            {

                echo "failure";
            }
            # code...
        }

        else
        {


            if ($type_account_int==1) {           
      

        if ($intro_video_secure_url!="") {

                    //update in organisation table
                    $query=mysqli_query($db,"UPDATE organisations SET about = '$about' , website = '$website', country_id = '$country_location' , intro_video = '$intro_video_secure_url', intro_video_bytes = '$intro_video_bytes', intro_video_public_id='$intro_video_public_id' WHERE name = '$org_name'");

                    //update in users table
                    $query1 = mysqli_query($db,"UPDATE users SET about = '$about' , website = '$website', country_id = '$country_location' WHERE id = '$user_id'");


            $num_rows= mysqli_num_rows($query);
            $num_rows1= mysqli_num_rows($query1);

            if ($num_rows==0 and $num_rows1==0) {

                    echo "success";
            }

            else
            {

                echo "failure";
            }




        }

        else{


                        $query=mysqli_query($db,"UPDATE organisations SET about = '$about' , website = '$website', country_id = '$country_location' WHERE name = '$org_name'");

                    //update in users table
                    $query1 = mysqli_query($db,"UPDATE users SET about = '$about' , website = '$website', country_id = '$country_location' WHERE id = '$user_id'");


            $num_rows= mysqli_num_rows($query);
            $num_rows1= mysqli_num_rows($query1);

            if ($num_rows==0 and $num_rows1==0) {

                    echo "success";
            }

            else
            {

                echo "failure";
            }

        }

        }
        
    }


           }    

else

{
        
        if ($type_account_int==0) {
        $query=mysqli_query($db,"UPDATE users SET users.profession = '$profession', users.tags = '$tags' , users.about = '$about' , users.website = '$website', users.country_id = '$country_location' ,users.country_origin_id='$country_origin' WHERE users.id = '$user_id'");
        $num_rows= mysqli_num_rows($query);

        	if ($num_rows==0) {

        			echo "success";

        	}

        	else
        	{

        		echo "failure";
        	}
        	# code...
        }

        else
        {


        	if ($type_account_int==1) {

              

        if ($intro_video_secure_url!="") {

                    //update in organisation table
                    $query=mysqli_query($db,"UPDATE organisations SET about = '$about' , website = '$website', country_id = '$country_location' , intro_video = '$intro_video_secure_url', intro_video_bytes = '$intro_video_bytes', intro_video_public_id='$intro_video_public_id' WHERE name = '$org_name'");

                    //update in users table
                    $query1 = mysqli_query($db,"UPDATE users SET about = '$about' , website = '$website', country_id = '$country_location' WHERE id = '$user_id'");


            $num_rows= mysqli_num_rows($query);
            $num_rows1= mysqli_num_rows($query1);

            if ($num_rows==0 and $num_rows1==0) {

                    echo "success";
            }

            else
            {

                echo "failure";
            }




        }

        else{


                        $query=mysqli_query($db,"UPDATE organisations SET about = '$about' , website = '$website', country_id = '$country_location' WHERE name = '$org_name'");

                    //update in users table
                    $query1 = mysqli_query($db,"UPDATE users SET about = '$about' , website = '$website', country_id = '$country_location' WHERE id = '$user_id'");


            $num_rows= mysqli_num_rows($query);
            $num_rows1= mysqli_num_rows($query1);

            if ($num_rows==0 and $num_rows1==0) {

                    echo "success";
            }

            else
            {

                echo "failure";
            }

        }



        }
		
	}
}

?>
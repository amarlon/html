<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
function replace_accents($string) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    $chars = array(
    // Decompositions for Latin-1 Supplement
    chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
    chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
    chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
    chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
    chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
    chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
    chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
    chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
    chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
    chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
    chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
    chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
    chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
    chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
    chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
    chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
    chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
    chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
    chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
    chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
    chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
    chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
    chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
    chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
    chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
    chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
    chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
    chr(195).chr(191) => 'y',
    // Decompositions for Latin Extended-A
    chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
    chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
    chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
    chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
    chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
    chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
    chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
    chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
    chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
    chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
    chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
    chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
    chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
    chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
    chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
    chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
    chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
    chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
    chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
    chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
    chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
    chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
    chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
    chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
    chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
    chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
    chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
    chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
    chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
    chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
    chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
    chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
    chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
    chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
    chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
    chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
    chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
    chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
    chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
    chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
    chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
    chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
    chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
    chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
    chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
    chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
    chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
    chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
    chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
    chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
    chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
    chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
    chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
    chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
    chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
    chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
    chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
    chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
    chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
    chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
    chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
    chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
    chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
    chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
    );

    $string = strtr($string, $chars);

    return $string;
}


function removeBOM($text="") {
    if(substr($text, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
        $text= substr($text, 3);
    }
    return $text;
}

/*
* file.php - файл, в котором нужно удалить BOM
*/
 
$text=file_get_contents('page_login.php');
$text = removeBOM($text);

require_once (APPPATH . 'core/Base_Controller.php');
require_once dirname(__FILE__) . '/DbConnect.php';

class page_login extends Base_Controller {
    /*
     * Declare constructor to initialize
     */
    public function __construct() {
        parent::__construct ();
        if( !$this->is_logged_in() ) {
        }
    }


    public function getCountry($id){
        
        $db = new DbConnect();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT countries.name FROM countries where countries.id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $stmt->bind_result($country_name);
        $stmt->store_result();
        $result="";
        //$result = $stmt->get_result()->fetch_assoc();
        
        if ($stmt->num_rows>=0) {
            while ($stmt->fetch()) {
            
                if ($country_name==null) {
                    $country_name = "";
                }            

                $result = $country_name;
            }
            # code...
        }

        return $result;        
    } 


    public function login() {

        if( !$this->data['is_logged_in'] ) {

        
        $db = new DbConnect();
        $conn = $db->connect();

        $email=$_POST['email'];
        $pass=$_POST['password'];        
 
         
        

        $status_array = array();
	    $query=$conn->prepare("SELECT users.id,users.fullname,users.password,users.firstname,users.is_organisation_user, users.image ,users.profession,users.about,users.website,users.country_id,users.country_origin_id,users.is_active,users.tags FROM users WHERE email = '$email'");

        if ($query->execute()) {
            $query->bind_result($id,$fullname,$password,$firstname,$is_organisation_user,$user_image,$occupation,$about_user,$user_website,$location,$origin,$active,$skills);
            //store_result permet de stocker les resultats dans ses variables préalablement définies
            $query->store_result();

            if ($query->num_rows >= 0) {


                while ($query->fetch()) {

                $e_password = $this->decrypt($password);

                        $occupation1='';
                        $about1='';
                        $website1='';
                        $location1='';
                        $origin1='';
                        $active1 = "Offline";
                        $skills1 ="";
       
                if ($e_password == $pass){


                                if($is_organisation_user==0)
                
                {


                                    if ($occupation!=null) {

                $occupation1 = strip_tags($occupation);
            }

            if ($about_user!=null) {

                $about1 = strip_tags($about_user);
            }

            if ($user_website!=null) {

                $website1 = strip_tags($user_website);
            }

            if ($location!=0) {

                $location1 = $this->getCountry($location);
            }

            if ($origin!=0) {
        
                $origin1 = $this->getCountry($origin);;
            }

            if ($active==1) {

                $active1 = "Online";
            }

        if ($skills!=null) {

                $skills1 = strip_tags($skills);
            }

                if($user_image!=null)
        {
        
                        array_push($status_array,array(
                        'id'=> $id, 
                        'status'=> 'success',
                        'origin'=> $origin1,        
                        'username'=> replace_accents($fullname),
                        'account'=> 'Personal Account',
                        'profile_image'=> $user_image,
                        'occupation'=>replace_accents($occupation1),
                        'about'=> replace_accents($about1),
                        'website'=> $website1,
                        'location'=> $location1,
                        'active'=> $active1,
                        'skills'=> replace_accents($skills1)
                        )
                    );
        }

        else 
        {

            array_push($status_array,array(
                        'id'=> $id,
                        'origin'=> $origin1,
                        'status'=> 'success',        
                        'username'=> replace_accents($fullname),
                        'account'=> 'Personal Account',
                        'profile_image'=> '',
                        'occupation'=>replace_accents($occupation1),
                        'about'=> replace_accents($about1),
                        'website'=> $website1,
                        'location'=> $location1,
                        'active'=> $active1,
                        'skills'=> replace_accents($skills1)
                        )
                    );
            
        }
         
                }


                            else{


                    if ($is_organisation_user==1) {


                    $name=$fullname;

                    $query_org=$conn->prepare("SELECT organisations.id as org_id ,organisations.is_active as active,organisations.about as org_about,organisations.website as org_website, organisations.country_id as org_location,organisations.intro_video as org_video FROM organisations WHERE name = '$name'");

                    if($query_org->execute()){

                        $query_org->bind_result($org_id,$org_active,$org_about,$org_website,$org_location,$org_video);
                        $query_org->store_result();
                        while ($query_org->fetch()) {


                                    if ($org_about!=null) {

                                        $about1 = strip_tags($org_about);
                                }

                                    if ($org_website!=null) {

                                        $website1 = strip_tags($org_website);
                                }

                                    if ($org_video!=null) {

                                        $skills1 = $org_video;
                                }

            if ($org_location!=0) {

                $location1 = $this->getCountry($org_location);
            }

            if ($org_active==1) {

                $active1 = "Online";
            }

    }


        }

        if($user_image!=null)
        {
        
                        array_push($status_array,array(
                        'id'=> $id,
                        'status'=> 'success',        
                        'username'=> replace_accents($fullname),
                        'account'=> 'Organisation Account',
                        'profile_image'=> $user_image,
                        'occupation'=> replace_accents($occupation1),
                        'about'=> replace_accents($about1),
                        'website'=> $website1,
                        'location'=>$location1,
                        'origin'=> $origin1,
                        'active'=> $active1,
                        'skills'=> $skills1
                        )
                    );
        }


            else 
        {

            array_push($status_array,array(
                        'id'=> $id,
                        'status'=> 'success',        
                        'username'=> replace_accents($fullname),
                        'account'=> 'Organisation Account',
                        'profile_image'=> '',
                        'occupation'=> replace_accents($occupation1),
                        'about'=> replace_accents($about1),
                        'website'=> $website1,
                        'location'=> $location1,
                        'origin'=> $origin1,
                        'active'=> $active1,
                        'skills'=> $skills1
                        )
                    );
            
        }

                    }

                }
                
        }else{

            echo "failure";
        }

            }
        }
        
        echo json_encode($status_array,JSON_UNESCAPED_UNICODE);
        $query->close();
        
        }

    }
}

}


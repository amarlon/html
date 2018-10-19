<?php
 
class DbOperation
{
    //Database connection link
    private $con;
	private $conChat;
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect_maindb();
		$this->conChat = $db->connect_chatdb();
    }
 
    
 //storing token in database 
    public function registerDevice($email,$token){
        if($this->isEmailExist($email)){
            $stmt = $this->con->prepare("UPDATE users SET android_device_id = ? where email = ? ");
            $stmt->bind_param("ss",$token,$email);
            if($stmt->execute())
			{return 0; }//return 0 means success
            return 1; //return 1 means failure
        }else{
            return 2; //returning 2 means email doesnt exist
        }
    }
	
    //the method will check if email already exist 
    private function isEmailexist($email){
        $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }   
   
	//getting a specified name
    public function getUserNameById($id){
        $stmt = $this->con->prepare("SELECT fullname FROM users WHERE id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute(); 
		$stmt->bind_result($user_name);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        return $user_name;        
    }

    //Added by Bonaventure DOSSOU
    public function getGroupNameById($id){
        $stmt = $this->conChat->prepare("SELECT group_name FROM groupchat_list WHERE group_chat_id=?");
        $stmt->bind_param("s",$id);
        $stmt->execute(); 
		$stmt->bind_result($group_name);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        return $group_name;        
    }


	
	//getting a specified email
    public function getUserEmailById($id){
        $stmt = $this->con->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
		$stmt->bind_result($userEmail);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        return $userEmail;        
    }
	
	//getting a specified email
    public function getUserPicById($id){
        $stmt = $this->con->prepare("SELECT image FROM users where id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
		$stmt->bind_result($userPic);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        if ($userPic==null) {

        $userPic = "";
        	# code...
        }

        return $userPic;        
    }
	


	//Added by Bonaventure DOSSOU

    public function getGroupPicById($id){
        $stmt = $this->conChat->prepare("SELECT profile_img FROM groupchat_list where group_chat_id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
		$stmt->bind_result($groupPic);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        if ($groupPic==null) {

        $groupPic = "";
        	# code...
        }

        return $groupPic;        
    }

     public function getUserProfessionById($id){
        $stmt = $this->con->prepare("SELECT profession FROM users where id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
		$stmt->bind_result($userProfession);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        if ($userProfession==null) {

        $userProfession = "";
        	# code...
        }

        return $userProfession;        
    }

	 //getting a specified token to send push to selected device
    public function getTokenById($id){
        $stmt = $this->con->prepare("SELECT android_device_id FROM users WHERE id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
		$stmt->bind_result($token);
		$stmt->fetch();
		return $token; 		
    }
	
	//getting a specified id
    public function getUserIdByEmail($email){
        $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
		$stmt->bind_result($userId);
		$stmt->fetch();
        //$result = $stmt->get_result()->fetch_assoc();
        return $userId;        
    }
		

	//getting a specified token to send push to selected device
    public function getTokenByEmail($email){
        $stmt = $this->con->prepare("SELECT android_device_id FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute(); 
		$stmt->bind_result($token);
		$stmt->fetch();
		//return $token;
        //$result = $stmt->get_result()->fetch_assoc();
        return $token;        
    }
	

    //Added by Bonaventure DOSSOU
     public function getLastMessageSentAt($chatid) {
        $stmt = $this->conChat->prepare("SELECT sent_at FROM chat_$chatid ORDER BY msg_id DESC");
        $stmt->execute();
        $stmt->bind_result($sent_at);
		$stmt->fetch();
		return $sent_at;
    }

	
	public function getLastGroupMessageSentAt($chatid) {
        $stmt = $this->conChat->prepare("SELECT sent_at FROM groupchat_$chatid ORDER BY msg_id DESC");
        $stmt->execute();
        $stmt->bind_result($sent_at);
		$stmt->fetch();
		return $sent_at;
    }


	// fetching one to one chat list
    public function getUserSingleChatList($userid) {
		$response = array();
        $stmt = $this->conChat->prepare("SELECT * FROM chat_list where user1 = ? or user2 = ?");
		$stmt->bind_param("ss",$userid, $userid);
        $stmt->execute();
        $stmt->bind_result($chatid,$u1,$u2,$lmu,$lm,$ca);
		$stmt->store_result();
		
		// pushing single chat room into array
		while ($stmt->fetch()) {

			if ($lm!=null) {

			$tmp = array();
			$tmp["chat_id"] = $chatid;
			//recuperer le nom de lid
			if($userid==$u1){$tmp["chat_user_name"] = $this->getUserNameById($u2);
					$tmp["destId"] = $u2;
					$tmp["profile_img"] = $this->getUserPicById($u2);
					}
				else{$tmp["chat_user_name"] = $this->getUserNameById($u1);
					$tmp["destId"] = $u1;
					$tmp["profile_img"] = $this->getUserPicById($u1);
					}
			$tmp["type"] = 1;
			$tmp["last_msg_user_name"] = "";
			$tmp["last_msg"] = $lm;
			$tmp["users"] = array();
			$tmp["last_sent_at"] = $this->getLastMessageSentAt($chatid);
			array_push($response, $tmp);

				# code...
			}
		}
		
        $stmt->close();
        return $response;
    }
	// fetching group chat list
    public function getUserGroupChatList($userid) {
		$response = array();
        $stmt = $this->conChat->prepare("SELECT * FROM groupchat_list where id_members LIKE '%:".$userid.":%'");
        $stmt->execute();
        $stmt->bind_result($chatid,$users,$profile_img,$name,$lmu,$lm,$ca);
		$stmt->store_result();
		
		// pushing single chat room into array
		while ($stmt->fetch()) {

			if ($profile_img==null) {
				$profile_img = "";
			}


			if ($lm==null) {
				$lm = "Group actually without content";
			}

			$tmp = array();
			$tmp["chat_id"] = $chatid;
			$tmp["chat_user_name"] = $name;
			$tmp["destId"] = 0;
			$tmp["profile_img"] = $profile_img;
			$tmp["type"] = 0;
			$tmp["last_msg_user_name"] = $this->getUserNameById($lmu);
			$tmp["last_msg"] = $lm;
			$tmp["last_sent_at"] = $this->getLastGroupMessageSentAt($chatid);
		
			$arr_ids_list = explode(":", $users);
			$group_users = array();			
			foreach ($arr_ids_list as $value) {

				$current_id = $value;
				if ($current_id!="") {

									array_push($group_users,array(
                                                'name'=>$this->getUserNameById($current_id),
                                                'id'=>$current_id,
												'email'=>$this->getUserEmailById($current_id),        
												'pic_url'=>$this->getUserPicById($current_id)
												));


					# code...
				}
			}

			$tmp["users"] = $group_users;
		


			array_push($response, $tmp);
		}
		
        $stmt->close();
        
        return $response;
    }
	
	
	///*********************************
	///ONE TO ONE MESSAGING OPERATIPONS
	///*********************************
	
	// fetching chat discussion
    public function getUserChatDiscussion($chatid) {
		$response = array();
        $stmt = $this->conChat->prepare("SELECT * from (SELECT msg_id, id_from, msg_text, msg_media, sent_at FROM chat_$chatid ORDER BY msg_id ) sub ORDER BY msg_id ASC");
        $stmt->execute();
        $stmt->bind_result($msgid,$from,$msg,$media,$sent_at);
		$stmt->store_result();
		
		// pushing every messages into array
		while ($stmt->fetch()) {
			$tmp = array();
			$tmp["msg_id"] = $msgid;
			$tmp["msg_from_id"] = $from;
			$tmp["msg_text"] = $msg;
			
			//Added by Bonaventure DOSSOU
			$tmp["from_pic"] = $this-> getUserPicById($from);
			$tmp["profession"] = $this-> getUserProfessionById($from);

			if($media!=="" and $media!==null){
				$mediaArr=json_decode($media,true);
				$tmp["media_lnk"] = $mediaArr["secure_url"];
				//Getting the type of media
				$tmp["media_type"] = $mediaArr["type"];

			}else{
				$tmp["media_lnk"] = "";
				$tmp["media_type"] = "";
			}		
			
			$tmp["sent_at"] = $sent_at;
			array_push($response, $tmp);
		}
		
        $stmt->close();
        return $response;
    }
	
	//the method will return if chatid of two users if it already exists
    private function getChatId($u1,$u2){
        $stmt = $this->conChat->prepare("SELECT chat_id FROM chat_list WHERE (user1=? and user2=?) or (user1=? and user2=?)");
        $stmt->bind_param("ssss",$u1,$u2,$u2,$u1);
        $stmt->execute();
        $stmt->bind_result($chatid);
		$stmt->fetch();
        return $chatid;
    }
	
	public function addNewChat($from, $to){
		$tmp=$this->getChatId($from,$to);
		if($tmp > 0){
			$res=array();
			$res["success"]=1;
			 $res["chatid"]=$tmp;
			 
			 return $res;
		}else{	
		$res=array();
        $stmt = $this->conChat->prepare("INSERT INTO chat_list(user1,user2) VALUES(?, ?)");
        $stmt->bind_param("ss",$from,$to);
			if ($result = $stmt->execute()) {
				$tableid = $stmt->insert_id;
				$stmt1 = $this->conChat->prepare("CREATE TABLE chat_$tableid(msg_id INT(12) unsigned PRIMARY KEY AUTO_INCREMENT, id_from INT(11) NOT NULL, id_to INT(12) NOT NULL, msg_text TEXT, msg_media TEXT, sent_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");			
				 $res["success"]=$stmt1->execute();
				 $res["chatid"]=$tableid;
				 
				 return $res;
			}
		}
    
	}
 
	public function addMessage($chatId,$from,$to,$message,$mediadata){
		$stmt = $this->conChat->prepare("INSERT INTO chat_$chatId(id_from,id_to,msg_text,msg_media) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss",$from,$to,$message,$mediadata);
		return $stmt->execute();
		
	}
	
	//updating chat in database 
    public function updateChat($lastUid,$lastMsg,$chatId){
   
            $stmt = $this->conChat->prepare("UPDATE chat_list SET last_msg_user_id = ?, last_msg = ? where chat_id = ? ");
            $stmt->bind_param("sss",$lastUid,$lastMsg,$chatId);
            if($stmt->execute())
			{return 0; }//return 0 means success
            return 1; //return 1 means failure
    }
	
	///********************************
	///GROUP MESSAGING OPERATIPONS
	///********************************
	
	// fetching group chat discussion
    public function getGroupChatDiscussion($chatid) {
		$response = array();
        $stmt = $this->conChat->prepare("SELECT * from (SELECT * FROM groupchat_$chatid ORDER BY msg_id) sub ORDER BY msg_id ASC");
        $stmt->execute();
        $stmt->bind_result($msgid,$from,$from_name,$msg,$media,$sent_at);
		$stmt->store_result();
		
		// pushing every messages into array
		while ($stmt->fetch()) {
			$tmp = array();
			$tmp["msg_id"] = $msgid;
			$tmp["msg_from_id"] = $from;
			$tmp["from_name"] = $from_name;
			$tmp["msg_text"] = $msg;
			

			//Added by Bonaventure DOSSOU
			$tmp["from_pic"] = $this->getUserPicById($from);
			$tmp["profession"] = $this-> getUserProfessionById($from);

			if($media!=="" and $media!==null){
				$mediaArr=json_decode($media,true);
				$tmp["media_lnk"] = $mediaArr["secure_url"];
				//Getting the type of media
				$tmp["media_type"] = $mediaArr["type"];

			}else{
				$tmp["media_lnk"] = "";
				$tmp["media_type"] = "";
			}
			$tmp["sent_at"] = $sent_at;
			array_push($response, $tmp);
		}
		
        $stmt->close();
        return $response;
    }
	
	public function addNewGroupChat($users, $name){
		
	
		$res=array();
        $stmt = $this->conChat->prepare("INSERT INTO groupchat_list(id_members,group_name) VALUES(?, ?)");
        $stmt->bind_param("ss",$users,$name);
			if ($result = $stmt->execute()) {
				$tableid = $stmt->insert_id;
				$stmt1 = $this->conChat->prepare("CREATE TABLE groupchat_$tableid(msg_id INT(12) PRIMARY KEY AUTO_INCREMENT, id_from INT(11) not null, from_name varchar(100) not null, msg_text TEXT, msg_media TEXT, sent_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");			
				 $res["success"]=$stmt1->execute();
				 $res["chatid"]=$tableid;
				 
				 return $res;
			}
		
    
	}
	
	public function addNewGroupMember($id, $groupId){
		$stmt = $this->conChat->prepare("SELECT id_members from groupchat_list where group_chat_id=?");
		$stmt->bind_param("s",$groupId);
        $stmt->execute(); 
		$stmt->bind_result($id_members);
		$stmt->fetch();
		$stmt->close();
		$new_id_members=$id_members.$id;

		$stmt1 = $this->conChat->prepare("UPDATE groupchat_list SET id_members = ? where group_chat_id = ? ");
		$stmt1->bind_param("ss",$new_id_members,$groupId);
		return $stmt1->execute();
	}
	
	//getting group tokens to send push to all devices
    public function getGroupTokens($chatId){
		$stmt = $this->conChat->prepare("SELECT id_members FROM groupchat_list where group_chat_id=?");
		$stmt->bind_param("s",$chatId);
		$stmt->execute();
        $stmt->bind_result($ids_list);
		$stmt->fetch();
		
		$arr_ids_list = explode(":", $ids_list);
		$tmp = join(",",$arr_ids_list);		
		$tmp = substr($tmp, 1, strlen($tmp) - 2);
		
        $stmt1 = $this->con->prepare("SELECT android_device_id FROM users where id IN ($tmp)");
        $stmt1->execute();
        //$result = $stmt1->get_result();
		$stmt1->bind_result($token);
		$stmt1->store_result();
        $tokens = array(); 
        while($stmt1->fetch()){
            array_push($tokens, $token);
        }
        return $tokens; 
    }
	
	public function addGroupMessage($chatId,$from,$message,$mediadata){
		$from_name = $this->getUserNameById($from);
		$stmt = $this->conChat->prepare("INSERT INTO groupchat_$chatId(id_from,from_name,msg_text,msg_media) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss",$from,$from_name,$message,$mediadata);
		return $stmt->execute();
		
	}
	
	//updating group chat in database 
    public function updateGroupChat($lastUid,$lastMsg,$chatId){
   
            $stmt = $this->conChat->prepare("UPDATE groupchat_list SET last_msg_uid = ?, last_msg = ? where group_chat_id = ? ");
            $stmt->bind_param("sss",$lastUid,$lastMsg,$chatId);
            if($stmt->execute())
			{return 0; }//return 0 means success
            return 1; //return 1 means failure
    }


    //Added by Bonaventure DOSSOU
    public function updateGroupChatProfile($chatId,$p_url){
   
            $stmt = $this->conChat->prepare("UPDATE groupchat_list SET profile_img = ? where group_chat_id = ? ");
            $stmt->bind_param("ss",$p_url,$chatId);
            if($stmt->execute())
			{
				return 0; 
			}//return 0 means success
            
            else{
            
            	return 1;
            }
             //return 1 means failure
    }


	 /*/getting all tokens to send push to all devices
    public function getAllTokens(){
        $stmt = $this->con->prepare("SELECT gcm_registration_id FROM users");
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['gcm_registration_id']);
        }
        return $tokens; 
    }
	
	
    //getting all the registered devices from database 
    public function getAllDevices(){
        $stmt = $this->con->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result; 
    }
	
	//getting a specified token to send push to selected device
    public function getTokenByEmail($email){
        $stmt = $this->con->prepare("SELECT gcm_registration_id FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute(); 
        $result = $stmt->get_result()->fetch_assoc();
        return array($result['gcm_registration_id']);        
    }
	
	*/
}

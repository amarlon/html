<?php 
 
class Push {
    //notification from
    private $chatId;
 
    //notification message 
    private $message;
 
	//notification message image link
    private $media_lnk;
	
    //notification fromName url 
    private $fromName;
	
	//notification fromId
	private $fromId; 
	
	//notification fromId
	private $fromImg; 
	
	//notification fromId
	private $chatType; 
 
    private $fromProfession; 

    private $mediaType; 

    //initializing values in this constructor
    function __construct($chatId, $message, $media_lnk, $fromName, $fromId, $fromImg, $chatType,$fromProfession,$mediaType) {
         $this->chatId = $chatId;
         $this->message = $message;
		 $this->media_lnk = $media_lnk;		 
         $this->fromName = $fromName;
		 $this->fromId = $fromId;
		 $this->fromImg = $fromImg;	
		 $this->chatType = $chatType;
         $this->fromProfession = $fromProfession;
         $this->mediaType = $mediaType;

    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['data']['chatId'] = $this->chatId;
        $res['data']['message'] = $this->message;
		$res['data']['media_lnk'] = $this->media_lnk;
        $res['data']['fromName'] = $this->fromName;
		$res['data']['fromId'] = $this->fromId;
		$res['data']['fromImg'] = $this->fromImg;
		$res['data']['chatType'] = $this->chatType;
        $res['data']['profession'] = $this->fromProfession;
        $res['data']['mediaType'] = $this->mediaType;

        return $res;
    }
 
}
?>
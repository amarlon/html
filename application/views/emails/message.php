<a href="<?=base_url()?>page/profile/<?=$email_data['sender_id']?>" style="color:#391C4A;text-decoration:none;"><span><?=$email_data['sender_fullname']?></span></a> sent you a message.
<br><br>

Message:<br> <span style="font-style: italic;font-size: 12px;font-weight:bold;"><?=$email_data['message']?></span><br><br><br>

<a href="<?=base_url()?>account/inbox?contactid=<?=$email_data['sender_id']?>" class="btn btn-primary" style="background-color:#391C4A;color: #ffffff;padding: 10px;text-decoration: none;border-radius: 3px;moz-border-radius: 5px;khtml-border-radius: 5px;o-border-radius: 5px;webkit-border-radius: 5px;ms-border-radius: 5px;">Go to inbox</a>
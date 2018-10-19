<a href="<?=base_url()?>account/feed/<?=$email_data['post_category_id']?>/<?=$email_data['post_id']?>?showcomments=<?=$email_data['post_id']?>" style="color:#391C4A;text-decoration:none;"><?=$email_data['post_title']?></a>
<br><br>

<a href="<?=base_url()?>page/profile/<?=$email_data['sender_id']?>" style="color:#391C4A;text-decoration:none;"><span><?=$email_data['sender_fullname']?></span></a> replied to your comment.
<br><br>

Wrote:<br> <span style="font-style: italic;font-size: 12px;font-weight:bold;"><?=$email_data['comment']?></span><br><br><br>

<a href="<?=base_url()?>account/feed/<?=$email_data['post_category_id']?>/<?=$email_data['post_id']?>?showcomments=<?=$email_data['post_id']?>" class="btn btn-primary" style="background-color:#391C4A;color: #ffffff;padding: 10px;text-decoration: none;border-radius: 3px;moz-border-radius: 5px;khtml-border-radius: 5px;o-border-radius: 5px;webkit-border-radius: 5px;ms-border-radius: 5px;">View comments</a>
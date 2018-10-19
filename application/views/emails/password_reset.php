Someone asked to reset your <?=ucfirst($GLOBALS['COMPANY_NAME'])?> password. If this was you, please click the link below, otherwise simply ignore this email.
<br><br><br>

<a href="<?=base_url()?>page/reset_password/<?=$email_data['reset_token']?>" class="btn btn-primary" style="background-color:#391C4A;color: #ffffff;padding: 10px;text-decoration: none;border-radius: 3px;moz-border-radius: 5px;khtml-border-radius: 5px;o-border-radius: 5px;webkit-border-radius: 5px;ms-border-radius: 5px;">Reset password</a>
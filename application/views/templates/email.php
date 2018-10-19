<?=$email_header?>

    <div style="font-family: 'Open Sans', Helvetica, Arial, sans-serif;font-size:25px;font-weight:100;color:#3E4D5C;"><?=$email_title?></div>
    <br>

    <div class="body-text" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif;font-size: 14px;line-height: 20px;text-align: left;color: #3E4D5C;">

        <?=$email_content?>

        <br><br><br>

        <span style="font-style:italic;font-size:12px;"><?=ucfirst($GLOBALS['COMPANY_NAME'])?> Team</span>
        <br><br><br><br>

    </div>

<?=$email_footer?>
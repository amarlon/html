Thank you for enrolling in <?=$email_data['course_title']?> by <?=$email_data['course_creator']?>

<br><br>

You can begin your course anytime by clicking the link below.
<br><br><br>

<a href="<?=base_url()?>org/lessons/<?=$email_data['org_id']?>/<?=$email_data['course_id']?>" class="btn btn-primary" style="background-color:#391C4A;color: #ffffff;padding: 10px;text-decoration: none;border-radius: 3px;moz-border-radius: 5px;khtml-border-radius: 5px;o-border-radius: 5px;webkit-border-radius: 5px;ms-border-radius: 5px;">Course lessons</a>
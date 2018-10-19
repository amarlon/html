<p class="bold"><i class="fa fa-arrow-down"></i></p>

<?php if($is_course_owner): ?>
    <hr>
    <p class="course-level-list <?=$active_course_students ? 'bold':'' ?>"><a href="/org_tutor/course_students/<?=$course['id']?>"><i class="icon-users"></i> My students (<?=$num_course_students?>)</a></p>
<?php endif; ?>

<hr>
<p class="course-level-list <?=$active_course ? 'bold':''?>"><a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>">- Overview</a></p>
<hr>
<p class="course-level-list <?=$active_lessons ? 'bold':''?>"><a href="/org/lessons/<?=$course['organisation_id']?>/<?=$course['id']?>">- Lessons</a></p>
<hr>
<p class="course-level-list <?=isset($active_forums) && $active_forums ? 'bold':''?>"><a href="/org/discussions/<?=$course['organisation_id']?>/<?=$course['id']?>">- Discussions</a></p>
<hr>
<?php if($is_course_owner): ?>
    <p class="course-level-list <?=isset($active_certify) && $active_certify ? 'bold':''?>"><a href="/org_tutor/certify/<?=$course['id']?>">- Certify</a></p>
    <hr>
<?php endif; ?>
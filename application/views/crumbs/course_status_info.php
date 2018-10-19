<?php if( !$course['can_enrol'] && $is_organisation_admin ): ?>
    <div class="alert alert-warning col-md-10">
        <i class="fa fa-warning"></i> <span class="font-12px" style="font-weight:normal;">This course is currently inactive (i.e. students cannot enrol). <a href="javascript:;" id="<?=$course['id']?>" class="btn btn-large btn-danger enable-course-enrolment-btn pull-right">ALLOW ENROLMENTS</a> </span>
    </div>
<?php elseif( !$course['can_enrol'] && $is_course_owner ): ?>
    <div class="alert alert-danger col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa fa-warning"></i>
        <span class="font-12px" style="font-weight:normal;"><b>Note</b>: Course is currently inactive (i.e. students cannot enrol). Please check with <a href="/page/profile/<?=$course['created_by']?>"><b>course admin</b></a> to enable course enrolments.</span>
    </div>
<?php elseif(!$course['can_enrol'] && $course['end_date'] > date('Y-m-d') ): ?>
    <div class="alert alert-warning col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa fa-warning"></i>
        <span class="font-12px" style="font-weight:normal;"><b>Note</b>: Course enrolments will begin soon. Check again shortly. </span>
    </div>
<?php elseif( $course['end_date'] <= date('Y-m-d') ): ?>
    <div class="alert alert-warning col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa fa-warning"></i>
        <span class="font-12px" style="font-weight:normal;"><b>Note</b>: Course finished. For next enrolment dates, please check again shortly. </span>
    </div>
<?php endif; ?>

<?php if( $course['end_date'] <= date('Y-m-d') && $is_organisation_admin ): ?>
    <div class="alert alert-danger col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa fa-warning"></i>
        <span class="font-12px" style="font-weight:normal;"> <b>Course expired!</b> To renew, click <b><a href="/org_admin/edit_course/<?=$course['id']?>/<?=$course['organisation_id']?>">edit course</a></b> and update course start/end dates.</span>
    </div>
<?php elseif( $course['end_date'] <= date('Y-m-d') && $is_course_owner ): ?>
    <div class="alert alert-danger col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa fa-warning"></i>
        <span class="font-12px" style="font-weight:normal;"><b>Note</b>: Course expired. Please check with <a href="/page/profile/<?=$course['created_by']?>"><b>course admin</b></a> to extend course star/end dates.</span>
    </div>

<?php endif; ?>

<?php if($is_enrolled_in_course): ?>
    <div class="alert alert-success col-md-10">
        <i class="fa fa-check"></i>
        <span class="font-12px" style="font-weight:normal;">You're enrolled.</span>
        <button class="btn btn-sm btn-default uppercase pull-right unenroll-course-btn" id="<?=$course['id']?>"><i class="fa fa-times"></i> Leave course </button>
    </div>
    <style>
        .enrol-course-btn{ display: none; }
    </style>
<?php endif; ?>
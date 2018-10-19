<div class="caption search-results-caption">
    <span class="caption-subject text"><a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>"><?=$course['title']?></a></span>
    <div class="margin-top-20"></div>
</div>

<div class="actions <?=isset($hide_buttons) ? $hide_buttons : '' ?>">
    <?php if( !$is_course_owner ): ?>
        <?php if( !$is_logged_in ): ?>
            <a href="" data-toggle="modal" data-target="#bs-login-or-signup" class="btn btn-large btn-default uppercase"><i class="fa fa-graduation-cap"></i> Enrol (<span class="bold"><?=$course['cert_cost'] ? '&euro;'.$course['cert_cost']:'FREE' ?></span>) </a>
        <?php elseif( $course['can_enrol'] && $course['end_date'] > date('Y-m-d') ): ?>
            <?php if( $is_made_payment ): ?>
                <a href="javascript:;" class="btn btn-large btn-success uppercase enrol-course-btn" id="<?=$course['id']?>"><i class="fa fa-graduation-cap"></i> Enrol </a>
            <?php else: ?>
                <a href="javascript:;" class="btn btn-large btn-success uppercase" id="customCheckoutButton"><i class="fa fa-graduation-cap"></i> Enrol (<span class="bold"><?=$course['cert_cost'] ? '&euro;'.$course['cert_cost']:'FREE' ?></span>)</a>
                <input type="hidden" id="cert-cost" value="<?=$course['cert_cost']?>">
                <input type="hidden" id="course-id" value="<?=$course['id']?>">
            <?php endif; ?>
        <?php elseif( !$course['end_date'] < date('Y-m-d') ): ?>
            <button disabled class="btn btn-large btn-default uppercase"><i class="fa fa-graduation-cap"></i> Enrol (<span class="bold"><?=$course['cert_cost'] ? '&euro;'.$course['cert_cost']:'FREE' ?></span>)</button>
        <?php else: ?>

        <?php endif; ?>

    <?php endif; ?>
</div>

<!-- Modal -->
<div id="bs-login-or-signup" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span>Hey there</span></h4>
            </div>
            <div class="modal-body">
                <p>Please <a href="/" class="bold">register</a> or <a href="/page/login" class="bold">login</a> to continue.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="bs-must-enrol-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span>Hey <?= $is_logged_in ? $user['firstname']:'there' ?></span>,</h4>
            </div>
            <div class="modal-body">
                <?php if( $is_course_owner ): ?>
                    <p>This applies to enrolled students only.</p>
                <?php else: ?>
                    <p>You must be enrolled in the course to access this.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php if( $is_logged_in ): ?>
    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <!-- BEGIN COPYRIGHT -->
                <div class="col-md-3 col-sm-6">
                    <div class="copyright" style="padding:0;"><?=date("Y");?> &copy; Hotshi.</div>
                </div>
                <!-- END COPYRIGHT -->
            </div>
        </div>
    </div>
    <!-- END FOOTER -->
<?php endif; ?>

<!-- Common scripts -->
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/assets/global/scripts/jquery.cookie.js" type="text/javascript"></script>
<script src="/assets/global/scripts/form-ajax.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>


<script src="/assets/global/scripts/common.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>


<?php if( $is_logged_in ): ?>

    <!--[if lt IE 9]>
    <script src="/assets/global/plugins/respond.min.js"></script>
    <script src="/assets/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/global/scripts/bootstrap-tour.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->


    <script type="text/javascript" src="/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

    <script src="/assets/admin/pages/scripts/todo.js" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="/assets/admin/layout3/scripts/layout.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>
    <script src="/assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
    <script src="/assets/admin/pages/scripts/profile.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>

    <script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

    <?php if( $this->router->method != 'add_test_question_answers' ): ?>
        <script src="/assets/global/plugins/icheck/icheck.min.js"></script>
    <?php endif; ?>


    <script src="/assets/admin/pages/scripts/components-dropdowns.js"></script>


    <?php if( $is_organisation_member && !is_mobile_device() ): ?>
        <script src="/assets/global/scripts/tour.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>
    <?php endif; ?>

    <?php if( $this->router->method == 'certificate' ): ?>
        <script src="/assets/admin/layout3/scripts/html2canvas.js" type="text/javascript"></script>
    <?php endif; ?>


    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Demo.init(); // init demo features\
            Profile.init(); // init page demo
            Todo.init(); // init todo page
            ComponentsDropdowns.init();
        });


    </script>

<?php else: ?>

    <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <!--[if lt IE 9]>
    <script src="/assets/global/plugins/respond.min.js"></script>
    <![endif]-->

    <!-- BEGIN RevolutionSlider -->
    <script src="/assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js" type="text/javascript"></script>
    <script src="/assets/frontend/onepage/scripts/revo-ini.js" type="text/javascript"></script>
    <!-- END RevolutionSlider -->

    <!-- Core plugins BEGIN (required only for current page) -->
    <script src="/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
    <script src="/assets/global/plugins/jquery.easing.js"></script>
    <script src="/assets/global/plugins/jquery.parallax.js"></script>
    <script src="/assets/global/plugins/jquery.scrollTo.min.js"></script>
    <!--<script src="/assets/frontend/onepage/scripts/jquery.nav.js"></script>-->
    <!-- Core plugins END (required only for current page) -->

    <script src="/assets/frontend/onepage/scripts/layout.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>
    <?php if( $this->router->method == 'login' || $this->router->method == 'signup' ): ?>
        <script src="/assets/global/scripts/fb-login.js?v=<?=FILE_VERSION?>" type="text/javascript"></script>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            Layout.init();
        });
    </script>

<?php endif; ?>

<?=isset($page_js) ? $page_js : ''?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-102453178-1', 'auto');
    ga('send', 'pageview');

</script>


</body>
</html>
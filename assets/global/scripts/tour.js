$(function(){

    var route = $('#js-current-route').val();

    var is_french_user = $('#is-french-user').length;
    var tout_feed_title = "Welcome to Hotshi";
    var tout_feed_intro = "<p>Fancy a quick tour?</p> <p>Click <b>Next</b> to begin, or End tour to continue to your feed page.</p>";

    if( is_french_user ) {
        tout_feed_title= "Bienvenue sur Hotshi";
        tout_feed_intro = "<p>Vous voulez une visite rapide?</p> <p>Cliquez sur <b>Suivant</b> pour commencer ou, <b>Fin Visite</b> pour continuer votre page de flux.</p>";
    }

    // Instance the tour
    var tour_feed = new Tour({
        backdrop: true,
        orphan: true,
        steps: [
            {
                element: "",
                title: tout_feed_title,
                content: tout_feed_intro
            },
            {
                element: "#tour-main-nav",
                title: "Main menu",
                content: "<p>Quick links to your organisations, courses, profile, articles, contacts, etc.</p>",
                placement: 'bottom'
            },
            {
                element: "#tour-my-organisation",
                title: "Your organisation(s)",
                content: "<p>If you belong to 1 or more organisations (e.g. uni/schools) - a lists will appear here.</p> <p>Organisation admins can create courses and manage users from their profile page.</p>"
            },
            {
                element: "#tour-my-courses",
                title: "Your courses",
                content: "<p>If you're enrolled or tutoring a course, a list of your courses will appear here, grouped by tutoring/enrolled/certificates.</p>"
            },
            {
                element: "#tour-news-feed",
                title: "Your news feed",
                content: "<p>You can view a dynamic stream of user activity on your feed page. Photos, links, discussion, etc.</p>"
            },
            {
                element: "#tour-user-settings",
                title: "Quick links",
                content: "<p>Access your inbox, profile, logout, search, settings, etc. from here.</p>",
                placement: 'bottom'
            },
            {
                element: "#tour-end-feed",
                title: "Finally...",
                content: "<p>To start a quick tour on a page, look for the <b>Tour</b> button.</p> <p>That's all for now!</p> <p>Click <b>End tour</b> to finish.</p>"
            }

        ]});

    var tour_org_profile = new Tour({
        backdrop: true,
        orphan: true,
        steps: [
            {
                element: "",
                title: "Your organisation page",
                content: "<p>Click <b>Next</b> to begin tour. You can end and restart tour at any point.</p>"
            },
            {
                element: "#tour-manage-org",
                title: "Manage organisation",
                content: "<p>If you're your organisation admin, you can add other members, updated profile information (photo, video, etc).</p>",
                placement: 'bottom'
            },
            {
                element: "#tour-manager-courses",
                title: "Your courses",
                content: "<p>All courses created by your organisation will appear here.</p> <p>To add a new course, click the <b>create new course</b>. You must be an organisation admin.</p>",
                placement: 'top'
            },
            {
                element: "#tour-org-tutors",
                title: "Your course tutors",
                content: "<p>When you create a course, you can assign members of your organisation as course tutors.</p> <p>You can add new members from the <b>add users</b> link.</p>",
                placement: 'left'
            },
            {
                element: "#tour-org-intro",
                title: "Introduction (video)",
                content: "<p>You can upload a short introduction video. to tell users about your organisation.</p>",
                placement: 'left'
            },
            {
                element: "#tour-end-feed",
                title: "Finally...",
                content: "<p>To start a quick tour on a page, look for the <b>Tour</b> button.</p> <p>That's all for now!</p> <p>Click <b>End tour</b> to finish.</p>"
            }

        ]});

    var tour_course = new Tour({
        backdrop: true,
        orphan: true,
        steps: [
            {
                element: "",
                title: "Your organisation courses",
                content: "<p>Click <b>Next</b> to begin tour. You can end and restart tour at any point.</p>"
            },
            {
                element: "#tour-course-overview",
                title: "Course overview",
                content: "<p>Students can view some general info about your course. The organisation, course level, start/end dates, and number of lecture videos.</p>",
                placement: 'left'
            },
            {
                element: "#tour-course-introduction",
                title: "Course Introduction (video)",
                content: "<p>You can upload a quick course introduction video. It should contain a high-level description of the course in question.</p>",
                placement: 'left'
            },
            {
                element: "#tour-course-instructor",
                title: "The course tutor",
                content: "<p>The course tutor will be responsible for course lesson content, e.g. lesson videos, tests, etc.</p> <p>This can be the organisation admin or another member of your organisation.</p>",
                placement: 'top'
            },
            {
                element: "#tour-course-menu",
                title: "Course menu",
                content: "<p>Add lessons, certify, manages your students, etc.</p>",
                placement: 'right'
            },
            {
                element: "#tour-end-feed",
                title: "Finally...",
                content: "<p>To start a quick tour on a page, look for the <b>Tour</b> button.</p> <p>That's all for now!</p> <p>Click <b>End tour</b> to finish.</p>"
            }

        ]});

    var tour_default = new Tour({
        backdrop: true,
        orphan: true,
        steps: [
            {
                element: "",
                title: "Oops!",
                content: "<p>Work in progress. Please try again shortly. Click <b>End tour</b> to cancel.</p>"
            }

        ]});

    var $start_tour_btn = $('.start-tour-btn');


    switch (route) {
        case 'feed':
            tour_feed.init();
            tour_feed.start();
            break;
        case 'course':
            tour_course.init();
            tour_course.start();
            break;
        case 'org_profile':
            tour_org_profile.init();
            tour_org_profile.start();
            break;
        default:
            $start_tour_btn.hide();
    }


    $start_tour_btn.on('click', function(){
        var page = $(this).attr('data-page');
        switch(page) {
            case 'feed':
                tour_feed.restart();
                break;
            case 'course':
                tour_course.restart();
                break;
            case 'org_profile':
                tour_org_profile.restart();
                break;
            default:
                tour_default.restart();
        }
    });



});
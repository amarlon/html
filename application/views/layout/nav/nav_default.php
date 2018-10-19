<!-- Nav+logo BEGIN -->



<div class="header header-mobi-ext" style="background:none;">

    <?php if( $this->router->method == 'home' ): ?>
        <!--<div class="services-block content content-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 item">
                        <i class="icon-refresh"></i>
                        <h3>Connect</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 item">
                        <i class="icon-share"></i>
                        <h3>Collaborate</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 item">
                        <i class="icon-graph"></i>
                        <h3>Grow</h3>
                    </div>
                </div>
            </div>
        </div>-->
    <?php endif; ?>

    <div class="content content-center" style="background:#000;">
        <div class="container">
            <div class="row">
                <!-- Logo BEGIN -->
                <div class="col-md-2 col-sm-2 page-logo">
                    <a href="/" class="site-logo">
                        <img src="/assets/global/img/logo-landing-2.png" alt="Hotshi logo">
                    </a>
                    <!--<a class="site-logo" href="/"><p style="padding:0;padding-top:5px;font-weight:normal;">Hotshi &copy; <?/*=date("Y");*/?></p></a>-->

                </div>
                <!-- Logo END -->
                <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
                <!-- Navigation BEGIN -->
                <div class="col-md-10 pull-right">
                    <ul class="header-navigation">
                        <li><a href="javascript:" class="tooltips" data-placement="left" data-original-title="<?=$is_french_user ? 'en':'fr'?>" id="toggle-lang-btn"><?=$is_french_user ? '<b class="lang-text" title="en" data-lang="en">EN</b>' : '<b class="lang-text" title="fr" data-lang="fr">FR</b>' ?></a></li>
                        <!--<li class="li-nav-btn li-nav-btn-search"><a href="javascript:;" data-toggle="modal" data-target="#bs-search-modal"><i class="icon-magnifier"></i></a></li>-->
                        <li><a href="/"><?=$is_french_user ? 'Accueil' : 'Home' ?></a></li>
                        <li><a href="/org/courses"><?=$is_french_user ? 'Cours' : 'Courses' ?></a></li>
                        <li><a href="/page/about"><?=$is_french_user ? 'A propos' : 'About' ?></a></li>
                        <!--<li><a href="/page/faq">Faqs</a></li>-->
                        <li class="dropdown">
                            <a href="javascript:" onclick="dropDownCustom()" class="dropbtn">Pages</a>
                            <ul id="myDropdown" class="dropdown-content dropdown-default-nav" style="list-style-type: none;padding-left: 0;">
                                <li><a href="/page/articles">Articles</a></li>
                                <li><a href="/page/users"><?=$is_french_user ? 'utilisateurs':'Users' ?></a></li>
                                <li><a href="/page/organisations"><?=$is_french_user ? 'l’organisation' : 'Organisations' ?></a></li>
                            </ul>
                        </li>
                        <!--<li><a href="/page/tos">Terms</a></li>-->
                        <!--<li><a href="/page/contact">Contact</a></li>-->
                        <li><a href="/page/login" class="text-purple"><i class="icon-user"></i> <?=$is_french_user ? 'Connexion' : 'Login' ?></a></li>
                        <li><a href="#bs-signup-modal" data-toggle="modal" class="text-purple"><i class="icon-note"></i> <?=$is_french_user ? 'Inscription' : 'Register' ?></a></li>
                    </ul>
                </div>
                <!-- Navigation END -->
            </div>
        </div>
    </div>

</div>
<!-- Nav+logo END -->

<style>
    .dropdown-content {
        display: none;
    }
</style>

<script>
    function dropDownCustom() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
<!-- Modal -->
<div id="bs-signup-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title centered-text">DISCOVER HOTSHI</h4>
            </div>
            <div class="modal-body">

                <div class="row signup-options">
                    <div class="col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="border-right:1px solid #eee;">
                            <a href="/page/signup/learner" class="no-text-decoration"><i class="icon-user"></i><br><br> <?=$is_french_user ? 'Je suis un utilisateur':'I\'m a User' ?></a>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="/page/signup/tutor" class="no-text-decoration"><i class="fa fa-institution"></i><br><br> <?=$is_french_user ? 'Institution / Entreprise':'Institution/Company' ?></a>
                        </div>
                    </div>

                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <?php if( $is_french_user ): ?>
                            <p class="font-12px" style="color:#391C4A;"><b>Utilisateurs</b>: connectez-vous avec d'autres utilisateurs, perfectionnez vos compétences et obtenez des opportunités auprès des entreprises.</p>
                            <p class="font-12px" style="color:#391C4A;"><b>Institutions/Entreprise</b>: Créez une page pour votre Entreprise ou Institution, connectez et collaborez avec les utilisateurs, compagnies, institutions, créez des cours et plus.
                            </p>
                        <?php else: ?>
                            <p class="font-12px" style="color:#391C4A;"><b>Users</b>: Enroll in courses, engage / network with other users.</p>
                            <p class="font-12px" style="color:#391C4A;"><b>Institution/Company</b>: Create a page for your Company or Institution, connect and collaborate with users, other companies, institutions, create courses, plus more.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
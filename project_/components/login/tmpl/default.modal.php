<?php
define('MODAL_ID', 'modal-' . time());
?>
<div id="<?= MODAL_ID ?>" class="modal fade" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $this->title ?? '' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php if($this->serverAvailable) : ?>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="username" placeholder="Benutzername">
                    <label for="username">Benutzername</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="pass" placeholder="Passwort">
                    <label for="pass">Passwort</label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid d-grid gap-2">
                    <?= implode('', $this->buttons ?? [] ) ?>
                </div>
            </div>
            <?php else : ?>
            <div class="alert alert-danger m-3"><?=MSG['db']['danger'][1]?></div>
            <?php endif; ?>
        </form>
    </div>
    <script>
        <?= implode('', $this->scripts ?? []) ?>
        $(document).ready((event) => {
            $('#<?= MODAL_ID ?>').modal('show');            
        });
        // verify login data
        function checkLogin() {
            new Ajax({
                component: 'login.verify',
                values: {
                    username: $('#username').val(),
                    password: $('#pass').val()
                }
            }, null, (response) => {
                if (response.data.success) {
                    // reload menu -> login/logout
                    new Ajax({
                        component: 'menu.show',
                        values: {
                            template:'default',
                        }
                    }, null, callbackLoadMenu);
                    // close modal login
                    closeModal();
                } else {
                    $('.modal-content').effect("shake");
                    $('.modal-content input').val('');
                }
            })
        }
        // close modal login and get modal register
        function register() {
            // close modal login
            closeModal();
            // wait 400ms and open modal register
            window.setTimeout(() => {
                // open modal register
                new Ajax({
                    component:'register.show',
                    values: {
                        title: 'Registrierung',
                        modal: 'true',
                        buttons: [
                            {
                                text: "Registrieren",
                                class: "btn btn-success",
                                click: '(event)=>{register();}'
                            },
                            {
                                text: "Zurück zum Login",
                                class: "btn btn-link",
                                click: '(event)=>{backToLogin();}'
                            },
                            {
                                text: "Abbrechen und schließen",
                                class: "btn btn-link",
                                click: '(event)=>{closeModal();}'
                            },
                        ]                    
                    }
                }, null, callbackLoadModal);
            }, 400);
        }
        // remove modal on reset
        function closeModal() {
            // hide modal dialog
            $('#<?=MODAL_ID?>').hide(400, () => {
                // delete modal and backdrop from DOM
                $('#<?=MODAL_ID?>, .modal-backdrop.show').remove();
                $('body').removeClass('modal-open').css({
                    'overflow': 'unset',
                    'padding-right': 'unset'
                });
            });
        }
    </script>
</div>
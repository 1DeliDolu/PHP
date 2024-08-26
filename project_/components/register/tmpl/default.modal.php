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
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="username" placeholder="Benutzername">
                    <label for="username">Benutzername</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="pass" placeholder="Passwort">
                    <label for="pass">Passwort</label>
                    <ul class="form-text password-requirements">
                        <li class="len"><?php
                        if(defined('MAX_LENGTH')) {
                            printf(MSG['password']['require']['len_minmax'], MIN_LENGTH, MAX_LENGTH);
                        } else {
                            printf(MSG['password']['require']['len_min'], MIN_LENGTH);
                        }
                        ?></li>
                        <?php if(defined('UCASE') && UCASE) : ?>
                        <li class="ucase"><?=MSG['password']['require']['ucase']?></li>
                        <?php endif ;?>
                        <?php if(defined('LCASE') && LCASE) : ?>
                        <li class="lcase"><?=MSG['password']['require']['lcase']?></li>
                        <?php endif ;?>
                        <?php if(defined('DIGIT') && DIGIT) : ?>
                        <li class="digit"><?=MSG['password']['require']['digit']?></li>
                        <?php endif ;?>
                        <?php if(defined('SYMBOL') && SYMBOL) : ?>
                        <li class="symbol"><?=MSG['password']['require']['symbol']?></li>
                        <?php endif ;?>
                    </ul>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="pass_repeat" placeholder="Passwort wiederholen">
                    <label for="pass_repeat">Passwort wiederholen</label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid d-grid gap-2">
                    <?= implode('', $this->buttons ?? [] ) ?>
                </div>
            </div>
        </form>
    </div>
    <script>
        <?= implode('', $this->scripts ?? []) ?>
        $(document).ready((event) => {
            $('#<?= MODAL_ID ?>').modal('show');
            // check username (mail) on input
            $('#username').on('input', (event) => {
                new Ajax({
                    component: 'register.validateusername',
                    values: {
                        username: $('#username').val(),
                        field: $('#username').attr('id')
                    }
                }, null, setValidation);
            });
            // check password on input
            $('#pass').on('input', (event) => {
                new Ajax({
                    component: 'register.validatepassword',
                    values: {
                        password: $('#pass').val(),
                        field: $('#pass').attr('id')
                    }
                }, null, setValidation);
                $('#pass_repeat').trigger('input');
            });
            // check password repeat on input
            $('#pass_repeat').on('input', (event) => {
                $(event.target).removeClass('is-valid is-invalid');
                if( $(event.target).val().length ){
                    $(event.target).addClass($('#pass').val() == $('#pass_repeat').val() ? 'is-valid' : 'is-invalid');
                }
            });
            // deactivate submit on load
            $('.modal-content').find('.btn-success').prop('disabled', true);
            // activate submit if all inputs valid
            $('.modal-content input').on('input', (event) => {
                if( $('.modal-content input').length === $('.modal-content input.is-valid').length ) {
                    $('.modal-content').find('.btn-success').prop('disabled', false);
                }else{
                    $('.modal-content').find('.btn-success').prop('disabled', true);
                }
            });

        });
        var setValidation = (response) => {
            $('#' + response.data.field).removeClass('is-valid is-invalid');
            if( $('#' + response.data.field).val().length) {
                $('#' + response.data.field).addClass( response.data.isvalid ? 'is-valid' : 'is-invalid');
            }
            if(response.data.field == 'pass') {
                let code = 0;
                try {
                    code = response.msgs[0].code;
                }catch(e) {
                    code = 0;
                }
                $('#' + response.data.field).siblings('ul').children('li').removeClass('valid-feedback invalid-feedback');
                $('#' + response.data.field).siblings('ul').children('.len').addClass(
                    code & 0b00001 ? 'invalid-feedback' : 'valid-feedback'
                );
                $('#' + response.data.field).siblings('ul').children('.ucase').addClass(
                    code & 0b00010 ? 'invalid-feedback' : 'valid-feedback'
                );
                $('#' + response.data.field).siblings('ul').children('.lcase').addClass(
                    code & 0b00100 ? 'invalid-feedback' : 'valid-feedback'
                );
                $('#' + response.data.field).siblings('ul').children('.digit').addClass(
                    code & 0b01000 ? 'invalid-feedback' : 'valid-feedback'
                );
                $('#' + response.data.field).siblings('ul').children('.symbol').addClass(
                    code & 0b10000 ? 'invalid-feedback' : 'valid-feedback'
                );
            }
        }
        // verify login data
        function backToLogin() {
            // close register
            closeModal();
            // wait for 400ms and open modal login
            window.setTimeout(() => {
                // load login
                $('a[data-target="login.show"]').trigger('click');
            }, 400)
        }
        // register user if no invalid fields
        function register() {
            // save data
            new Ajax({
                component:'register.register',
                values: {
                    username: $('#username').val(),
                    password: $('#pass').val()
                }
            }, null, (response) => {
                if (response.data.success) {
                    // back to login
                    backToLogin();
                } else {
                    console.log('Die Registrierung war nicht erfolgreich!', response);
                }
            });

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
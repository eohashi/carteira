       <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url(<?php echo base_url(); ?>assets/theme/img/bg/bg-1.jpg); ">
                <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                    <div class="m-login__container">
                        <div class="m-login__logo">
                            <h1 class="titulo-stronger">Primeiro acesso</h1>
                        </div>
                        <div class="m-login__signin">
                            <form class="m-login__form m-form" action="<?php echo base_url(); ?>first_access/changePassword" method="post">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Nova senha" name="conf_senha" required>
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirme sua senha" name="nova_senha" required>
                                </div>
                                <div class="m-top-25-px form-group m-form__group row">
                                    <label for="cd_area" class="first-access-title col-2 col-form-label">Área</label>
                                    <?php echo form_dropdown('cd_area', $areas, set_value('cd_area', $usuario->cd_area), 'required class="form-control m-input col-md-10 first-access-select" id="cd_area"')?>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="first-access-title col-2 col-form-label">
                                        Célula
                                    </label>
                                    <?php echo form_dropdown('cd_celula', $celulas, set_value('cd_celula', $usuario->cd_celula), 'required class="form-control m-input col-md-10 first-access-select" id="cd_celula"')?>
                                </div>
                                <div class="m-login__form-action">
                                    <button class="btn-alterar-senha btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                        Confirmar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

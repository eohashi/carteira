       <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url(<?php echo base_url(); ?>assets/theme/img/bg/bg-1.jpg); ">
                <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                    <div class="m-login__container">
                        <div class="m-login__logo">
                            <img src="<?php echo base_url(); ?>assets/theme/img/logo.png" style="width: 280px;">
                        </div>
                        <div class="m-login__signin">
                            <form class="m-login__form m-form" action="<?php echo base_url(); ?>login/validateLogin" method="post">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input"   type="email" placeholder="Email" name="no_email" autocomplete="off" required>
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="no_senha" required>
                                </div>
                                <div class="row m-login__form-sub">
                                    <div class="col m--align-left m-login__form-left">
                                        <label class="m-checkbox  m-checkbox--light">
                                            <input type="checkbox" name="remember">
                                            Lembrar de mim
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col m--align-right m-login__form-right">
                                        <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                            Esqueceu a Senha ?
                                        </a>
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button class="btn-login btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                        Sign In
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__forget-password">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Esqueceu sua senha?
                                </h3>
                                <div class="m-login__desc">
                                    Informe seu email para solicitar uma nova senha
                                </div>
                            </div>
                            <form class="m-login__form m-form" action="<?php echo base_url(); ?>login/newPassword" method="post">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="email" placeholder="Email" name="no_email_new_password" id="m_email" autocomplete="off" required>
                                </div>
                                <div class="m-login__form-action">
                                    <button class="btn btn-esqueceu-senha m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary btn-esqueceu-senha">
                                        Solicitar
                                    </button>
                                    &nbsp;&nbsp;
                                    <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                        Voltar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

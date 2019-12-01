        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <?php $this->load->view("include/header"); ?>
            <!-- END: Header -->
            <div class="m-grid__item m-grid__item--fluid m-wrapper m-body">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4">
                                <div class="m-portlet m-portlet--full-height  ">
                                    <div class="m-portlet__body">
                                        <div class="m-card-profile">
                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper" style="position: relative;">
                                                    <img style="width: 130px;height: 130px;" class="profile-pic" src="<?php echo base_url().'upload/profiles/'.$usuario->no_foto_usuario; ?>" alt=""/>
                                                </div>
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__name">
                                                    <?php echo $usuario->no_usuario; ?>
                                                </span>
                                                <a class="m-card-profile__email m-link">
                                                    <?php echo $usuario->no_email; ?>
                                                </a>                                                
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__name" style="padding-top:5px;">
                                                    <?php echo $usuario->nr_saldo.' Cherries'; ?>
                                                </span>                                         
                                            </div>
                                        </div>
                                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                            <li class="m-nav__section m--hide">
                                                <span class="m-nav__section-text">
                                                    Section
                                                </span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="<?php echo base_url().'explore' ?>" class="m-nav__link">
                                                    <i class="m-nav__link-icon la la-retweet"></i>
                                                    <span class="m-nav__link-text">
                                                        Explore/Transfer
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="<?php echo base_url().'reward' ?>" class="m-nav__link">
                                                    <i class="m-nav__link-icon la la-trophy"></i>
                                                    <span class="m-nav__link-text">
                                                        Rewards
                                                    </span>
                                                </a>
                                            </li>                                           
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-8">
                                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-tools">
                                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" role="tab">
                                                        <i class="flaticon-share m--hide"></i>
                                                        Profile
                                                    </a>
                                                </li>                                               
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m_user_profile_tab_1">
                                            <form action="<?php echo base_url().'profile/updateProfile' ?>" class="m-form m-form--fit m-form--label-align-right">
                                                <?php echo form_hidden('cd_usuario', $usuario->cd_usuario); ?>
                                                <div class="m-portlet__body">
                                                    <div class="form-group m-form__group row"  style="padding-top: 40px;">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                1. Personal Details
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Nome
                                                        </label>
                                                        <div class="col-7">
                                                            <input required name="no_usuario" class="form-control m-input" type="text" value="<?php echo $usuario->no_usuario; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Descrição
                                                        </label>
                                                        <div class="col-7">
                                                            <textarea class="no-resize form-control m-input" name="ds_descricao"><?php echo $usuario->ds_descricao; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            E-mail
                                                        </label>
                                                        <div class="col-7">
                                                            <input required class="form-control m-input" type="text" value="<?php echo $usuario->no_email; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Nova Senha
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="no_senha" class="form-control m-input" type="password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Confirme sua senha
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="conf_senha" class="form-control m-input" type="password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row" style="padding-bottom: 40px;">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Data Início
                                                        </label>
                                                        <div class="col-7">
                                                            <input disabled readonly class="form-control m-input" type="text" value="<?php echo $usuario->dt_inicio; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row" style="padding-bottom: 40px;">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Data Nascimento
                                                        </label>
                                                        <div class="col-7">
                                                            <input disabled readonly class="form-control m-input" type="text" value="<?php echo $usuario->dt_nasc; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Alterar foto<br>
                                                            <small><strong>Máx: 200x200 px</strong></small>
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="foto" type="file">
                                                        </div>
                                                    </div>
                                                    <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                2. Business Details
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="cd_area" class="col-2 col-form-label">Área</label>
                                                        <?php echo form_dropdown('cd_area', $areas, set_value('cd_area', $usuario->cd_area), 'required class="form-control m-input select-resize" id="cd_area"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Célula
                                                        </label>
                                                        <?php echo form_dropdown('cd_celula', $celulas, set_value('cd_celula', $usuario->cd_celula), 'required class="form-control m-input select-resize" id="cd_celula"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Unidade
                                                        </label>
                                                        <?php echo form_dropdown('cd_unidade', $unidades, set_value('cd_unidade', $usuario->cd_unidade), 'required class="form-control m-input select-resize" id="cd_unidade"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row" style="padding-bottom: 40px;">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Tipo de Usuário
                                                        </label>
                                                        <?php echo form_dropdown('',$usuario->no_tipo_usuario, set_value('', $usuario->no_tipo_usuario), 'class="form-control m-input select-resize" readonly disabled')?>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-12" style="text-align: center;">
                                                                <a href="#" class="btn-save-profile btn btn-accent m-btn m-btn--air m-btn--custom">
                                                                    Salvar
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane " id="m_user_profile_tab_2"></div>
                                        <div class="tab-pane " id="m_user_profile_tab_3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
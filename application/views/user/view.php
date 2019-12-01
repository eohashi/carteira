        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <?php $this->load->view("include/header"); ?>
            <!-- END: Header -->
            <div class="m-grid__item m-grid__item--fluid m-wrapper m-body">
                    <div class="m-content">
                        <div class="row">
                            <?php echo form_hidden('md5_receiver', $colaborador->no_email_md5); ?>
                            <div class="col-xl-3 col-lg-4">
                                <div class="m-portlet m-portlet--full-height  ">
                                    <div class="m-portlet__body">
                                        <div class="m-card-profile">
                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper">
                                                    <img src="<?php echo base_url().'upload/profiles/'.$colaborador->no_foto_usuario; ?>" alt=""/>
                                                </div>
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__name">
                                                    <?php echo $colaborador->no_usuario; ?>
                                                </span>
                                                <a href="mailto:<?php echo $colaborador->no_email; ?>" class="m-card-profile__email m-link">
                                                    <?php echo $colaborador->no_email; ?>
                                                </a>                                                
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__name" style="padding-top:5px;">
                                                    <?php echo $colaborador->nr_saldo.' Cherries'; ?>
                                                </span>                                         
                                            </div>
                                        </div>
                                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                            <li style="text-align: center" class="m-nav__item">
                                                <a>
                                                    <i class="m-nav__link-icon la la-dollar"></i>
                                                    <span class="m-nav__link-text">
                                                        Adicionar Cherries
                                                    </span>
                                                </a>
                                            </li>
                                            <br>
                                            <br>
                                        </ul>
                                        <form action="<?php echo base_url().'user/depositoUser' ?>" class="m-form m-form--fit">
                                            <?php echo form_hidden('cd_usuario', $colaborador->cd_usuario); ?>
                                            <?php echo form_hidden('nr_saldo', $colaborador->nr_saldo); ?>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-3 col-form-label">
                                                    Valor
                                                </label>
                                                <div class="col-9">
                                                    <input required name="nr_valor" class="form-control m-input" type="tel">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-3 col-form-label">
                                                    Motivo
                                                </label>
                                                <div class="col-9">
                                                    <textarea required name="ds_motivo" class="no-resize form-control m-input"></textarea>
                                                </div>
                                            </div>
                                            <div class="m-form__actions">
                                                <div class="row">
                                                    <div class="col-12" style="text-align: center;">
                                                        <button type="button" class="btn-deposito btn btn-accent m-btn m-btn--air m-btn--custom">
                                                            Adicionar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
                                            <form action="<?php echo base_url().'user/updateProfile' ?>" class="m-form m-form--fit m-form--label-align-right">
                                                <div class="m-portlet__body">

                                                    <?php echo form_hidden('cd_usuario', $colaborador->cd_usuario); ?>

                                                    <div class="form-group m-form__group row"  style="padding-top: 40px;">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                1. Personal Details
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Nome Completo
                                                        </label>
                                                        <div class="col-7">
                                                            <input required name="no_usuario" class="form-control m-input" type="text" value="<?php echo $colaborador->no_usuario; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            E-mail
                                                        </label>
                                                        <div class="col-7">
                                                            <input required class="form-control m-input" type="text" value="<?php echo $colaborador->no_email; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Senha
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="no_senha" class="form-control m-input" type="password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Confirme a senha
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="conf_senha" class="form-control m-input" type="password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                             Data Início 
                                                        </label>
                                                        <div style="width:55% !important;margin-left: 15px;" class="input-group date">
                                                            <input type="text" class="form-control m-input" name="dt_inicio" data-date-format="dd/mm/yyyy" placeholder="Selecionar data" id="dt_inicio">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar glyphicon-th"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                             Data Nascimento
                                                        </label>
                                                        <div style="width:55% !important;margin-left: 15px;" class="input-group date">
                                                            <input type="text" class="form-control m-input" name="dt_nasc" data-date-format="dd/mm/yyyy" placeholder="Selecionar data" id="dt_nasc">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar glyphicon-th"></i>
                                                                </span>
                                                            </div>
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

                                                        <?php echo form_dropdown('cd_area', $areas , set_value('cd_area', $colaborador->cd_area), 'required class="form-control m-input select-resize"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Célula
                                                        </label>
                                                        <?php echo form_dropdown('cd_celula', $celulas, set_value('cd_celula', $colaborador->cd_celula), 'required class="form-control m-input select-resize"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Unidade
                                                        </label>
                                                        <?php echo form_dropdown('cd_unidade', $unidades, set_value('cd_unidade', $colaborador->cd_unidade), 'required class="form-control m-input select-resize"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Tipo de Usuário
                                                        </label>
                                                        <?php echo form_dropdown('cd_tipo_usuario', $tipos , set_value('cd_tipo_usuario', $colaborador->cd_tipo_usuario), 'required class="form-control m-input select-resize"')?>
                                                    </div>
                                                    <div class="form-group m-form__group row" style="padding-bottom: 40px;">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Status
                                                        </label>
                                                        <?php echo form_dropdown('cd_status', $status, set_value('cd_status', $colaborador->cd_status), 'class="form-control m-input select-resize" name="cd_status" required')?>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
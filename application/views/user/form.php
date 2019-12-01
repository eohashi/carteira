        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <?php $this->load->view("include/header"); ?>
            <!-- END: Header -->
            <div class="m-grid__item m-grid__item--fluid m-wrapper m-body">
                    <div class="m-content">
                        <div class="row">
                            <div class="offset-lg-2 col-xl-8 col-lg-8">
                                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-tools">
                                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" role="tab">
                                                        <i class="flaticon-share m--hide"></i>
                                                        Create User
                                                    </a>
                                                </li>                                               
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m_user_profile_tab_1">
                                            <form action="<?php echo base_url().'user/createUser' ?>" class="m-form m-form--fit m-form--label-align-right">
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
                                                            Nome Completo
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="no_usuario" class="form-control m-input" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            E-mail
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="no_email" class="form-control m-input" type="email" required>
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
                                                        <?php echo form_dropdown('cd_area', $areas, set_value('cd_area'), 'class="form-control m-input select-resize" name="cd_area" required')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Célula
                                                        </label>
                                                        <?php echo form_dropdown('cd_celula', $celulas, set_value('cd_celula'), 'class="form-control m-input select-resize" name="cd_celula" required')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Unidade
                                                        </label>
                                                        <?php echo form_dropdown('cd_unidade', $unidades, set_value('cd_unidade'), 'class="form-control m-input select-resize" name="cd_unidade" required')?>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Tipo de Usuário
                                                        </label>
                                                        <?php echo form_dropdown('cd_tipo_usuario', $tipos, set_value('cd_tipo_usuario'), 'class="form-control m-input select-resize" name="cd_tipo_usuario" required')?>
                                                    </div>
                                                    <div class="form-group m-form__group row" style="padding-bottom: 40px;">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Status
                                                        </label>
                                                        <?php echo form_dropdown('cd_status', $status, set_value('cd_status'), 'class="form-control m-input select-resize" name="cd_status" required')?>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-12" style="text-align: center;">
                                                                <button type="button" class="btn-create-user btn btn-accent m-btn m-btn--air m-btn--custom">
                                                                    Salvar
                                                                </button>
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
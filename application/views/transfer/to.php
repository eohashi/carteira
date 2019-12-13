        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <?php $this->load->view("include/header"); ?>
            <!-- END: Header -->
            <div class="m-grid__item m-grid__item--fluid m-wrapper m-body">
                    <!-- END: Subheader -->
                    <div class="m-content">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4">
                                <div class="m-portlet m-portlet--full-height  ">
                                    <div class="m-portlet__body">
                                        <div class="m-card-profile">
                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper">
                                                    <img width="130px" height="130px" src="<?php echo base_url().$this->config->item('dir_upload_profile').$user_to->no_foto_usuario; ?>" alt="<?php echo  $user_to->no_usuario; ?>" title="<?php echo  $user_to->no_usuario; ?>"/>
                                                </div>
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__name">
                                                    <?php echo $user_to->no_usuario; ?>
                                                </span>
                                                <a href="mailto:<?php echo $user_to->no_email; ?>" class="m-card-profile__email m-link">
                                                    <?php echo $user_to->no_email; ?>
                                                </a>                                                
                                            </div>
                                            <hr>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__email">
                                                    Area
                                                </span>
                                                <span class="m-card-profile__name" style="padding-top:5px;">
                                                    <?php echo $user_to->no_area; ?>
                                                </span>                                         
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__email">
                                                    Célula
                                                </span>
                                                <span class="m-card-profile__name" style="padding-top:5px;">
                                                    <?php echo $user_to->no_celula; ?>
                                                </span>                                         
                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__email">
                                                    Unidade
                                                </span>
                                                <span class="m-card-profile__name" style="padding-top:5px;padding-bottom:15px;">
                                                   <?php echo $user_to->no_unidade; ?>
                                                </span>                                         
                                            </div>
                                        </div>                                                                      
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
                                                        Transfer
                                                    </a>
                                                </li>                                               
                                            </ul>
                                        </div>
                                        <div class="m-portlet__head-tools"></div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m_user_profile_tab_1">
                                            <form class="m-form m-form--fit m-form--label-align-right">
                                                <?php echo form_hidden('no_email_md5', set_value('no_email_md5', $usuario->no_email_md5), 'id="no_email_md5"'); ?>
                                                <?php echo form_hidden('user_to_no_email', set_value('user_to_no_email', $user_to->no_email), 'id="user_to_no_email"'); ?>
                                                <?php echo form_hidden('user_to_email_md5', set_value('user_to_email_md5', $user_to->no_email_md5), 'id="user_to_email_md5"'); ?>
                                                <div class="m-portlet__body">   
                                                    <br>                        
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                Transfer Details
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Saldo atual
                                                        </label>
                                                        <div class="col-7">
                                                            <?php echo form_input('nr_saldo', set_value('nr_saldo', $usuario->nr_saldo.' CheckPoints'), 'class="form-control m-input" name="nr_saldo" disabled'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Valor
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="transfer_value" class="form-control m-input" type="tel" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Motivo
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="ds_motivo" class="form-control m-input" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Senha
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="no_senha" class="form-control m-input" type="password" required>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>

                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    
                                                    <div class="m-form__actions">
                                        
                                                        <div class="row">
                                                            <div class="text-center col-12">
                                                                <button type="button" class="btn-transfer btn m-btn--pill m-btn--air btn-outline-brand m-btn m-btn--custom m-btn--outline-2x">
                                                                    Confirmar
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
            <!-- end:: Body -->

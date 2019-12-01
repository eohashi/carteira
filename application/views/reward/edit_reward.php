        <!-- begin:: Page -->
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
                                                        Edit Reward
                                                    </a>
                                                </li>                                               
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m_user_profile_tab_1">
                                            <form action="<?php echo base_url().'reward/updateReward' ?>" class="m-form m-form--fit m-form--label-align-right">
                                                <?php echo form_hidden('cd_premio', $premio->cd_premio); 
                                                      echo form_hidden('cd_usuario', $usuario->cd_usuario); 
                                                ?>
                                                <div class="m-portlet__body">
                                                    <div class="form-group m-form__group row"  style="padding-top: 40px;">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                1. Reward Details
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Nome
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="no_premio" class="form-control m-input" type="text" value="<?php echo $premio->no_premio ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Valor
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="nr_valor" class="form-control m-input" type="tel" value="<?php echo $premio->nr_valor ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Descrição
                                                        </label>
                                                        <div class="col-7">
                                                            <input name="ds_premio" class="form-control m-input" type="text" value="<?php echo $premio->ds_premio ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Categoria
                                                        </label>
                                                            <?php echo form_dropdown('cd_categoria', $categorias, set_value('cd_categoria',$premio->cd_categoria), 'required class="form-control m-input select-resize" id="cd_categoria"');?>
                                                    </div>
                                                    <div class="form-group m-form__group row" style="padding-bottom: 40px;">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Status
                                                        </label>
                                                        <?php echo form_dropdown('cd_status', $status, set_value('cd_status',$premio->cd_status), 'class="form-control m-input select-resize" name="cd_status" required')?>
                                                    </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-12" style="text-align: center;">
                                                                <button type="button" class="btn-save-reward btn btn-accent m-btn m-btn--air m-btn--custom">
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
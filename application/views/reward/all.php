        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <?php $this->load->view('include/header'); ?>
            <!-- END: Header -->        
        <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
                    <i class="la la-close"></i>
                </button>
                <!-- END: Left Aside -->
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <!-- BEGIN: Subheader -->
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title ">
                                    
                                </h3>
                            </div>
                            
                        </div>
                    </div>
                    <!-- END: Subheader -->
                    <div class="m-content">
                        <!--Begin::Section-->
                            <div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon">
                                            <i class="la la-trophy" style="color: rgb(251, 231, 58);"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                            Rewards
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <?php echo form_hidden('nr_saldo', set_value('nr_saldo', $usuario->nr_saldo)); 
                                      echo form_hidden('no_email_md5', set_value('no_email_md5', $usuario->no_email_md5)); 
                                ?>
                                <div class="m-pricing-table-1">
                                    <div class="m-pricing-table-1__items row">
                                        <?php
                                            foreach($premios as $premio){

                                                if($premio->cd_categoria == $this->config->item('premio_alimentacao')){
                                                    $cor_img = 'reward-alimentacao-img';
                                                    $icon = 'la-cutlery';           
                                                    $cor_btn = 'reward-alimentacao-btn';                                         
                                                }
                                                else if($premio->cd_categoria == $this->config->item('premio_entretenimento')){
                                                    $cor_img = 'reward-entretenimento-img';
                                                    $icon = 'la-gamepad';
                                                    $cor_btn = 'reward-entretenimento-btn'; 
                                                }
                                                else if($premio->cd_categoria == $this->config->item('premio_viagem')){
                                                    $cor_img = 'reward-viagem-img';
                                                    $icon = 'la-plane';
                                                    $cor_btn = 'reward-viagem-btn'; 

                                                }
                                                else if($premio->cd_categoria == $this->config->item('premio_presente')){
                                                    $cor_img = 'reward-presente-img';
                                                    $icon = 'la-gift';
                                                    $cor_btn = 'reward-presente-btn'; 
                                                }

                                                echo '
                                                <div class="item-reward m-pricing-table-1__item col-lg-3">'.
                                                    form_hidden('cd_premio', set_value('cd_premio', $premio->cd_premio)).
                                                    form_hidden('no_premio', set_value('no_premio', $premio->no_premio)).
                                                    form_hidden('nr_valor', set_value('nr_valor', $premio->nr_valor)).
                                                    '<div class="m-pricing-table-1__visual">
                                                        <div class="m-pricing-table-1__hexagon1"></div>
                                                        <div class="m-pricing-table-1__hexagon2"></div>
                                                        <span class="m-pricing-table-1__icon '.$cor_img.'">
                                                            <i class="la '.$icon.'"></i>
                                                        </span>
                                                    </div>
                                                    <span class="m-pricing-table-1__price">
                                                        '
                                                        .$premio->nr_valor.
                                                        '
                                                        <span style="font-size: 1.1rem;padding-left: 5px;" class="m-pricing-table-1__label">
                                                            CH$
                                                        </span>
                                                    </span>
                                                    <h2 class="m-pricing-table-1__subtitle">
                                                        '
                                                        .$premio->no_premio.
                                                        '
                                                    </h2>
                                                    <span class="m-pricing-table-1__description">
                                                        '
                                                        .$premio->ds_premio.
                                                        '
                                                    </span>
                                                    <div class="m-pricing-table-1__btn">
                                                        <button data-toggle="modal" data-target="#myModal" type="button" class="btn-troca btn m-btn--pill  btn-accent m-btn--wide m-btn--uppercase m-btn--bolder m-btn--sm '.$cor_btn.'">
                                                            Trocar
                                                        </button>
                                                    </div>
                                                </div>
                                                ';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End::Section-->
                    </div>
                </div>
            </div>
            <!-- end:: Body -->
        </div>
        <!-- end:: Page -->
                
        <!-- begin::Scroll Top -->
        <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
            <i class="la la-arrow-up"></i>
        </div>
        
            
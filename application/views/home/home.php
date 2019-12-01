        <div class="m-grid m-grid--hor m-grid--root m-page">
            <?php $this->load->view('include/header'); ?>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="m-portlet  m-portlet--full-height">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <div class="m-widget17__item home-margin-img">
                                                    <span class="m-widget17__icon">
                                                        <i class="la la-dashboard m--font-brand" style="font-size:2.5rem;"></i>
                                                    </span> 
                                                </div>
                                                <h3 class="m-portlet__head-text">&nbsp; Activities</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        <div class="m-scrollable mCustomScrollbar _mCS_5 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="380" style="overflow: visible; height: 380px; max-height: 380px; position: relative;">
                                            <div class="m-timeline-2">
                                                <div class="m-timeline-2__items  m--padding-top-25 m--padding-bottom-30">
                                                    <?php
                                                        function date_compare($a, $b){
                                                            return strcmp($b->dt_cadastro,$a->dt_cadastro);
                                                        };

                                                        $temp = (array)[$resgates,$transacao];
                                                        $array = [];

                                                        for($i = 0; $i < sizeof($temp); $i++){
                                                            for($j = 0; $j < sizeof($temp[$i]); $j++){
                                                                $array[] = $temp[$i][$j];      
                                                            }
                                                        }

                                                        if (sizeof($array)!=0){
                                                            usort($array, 'date_compare');
                                                        }
                                                        
                                                            foreach($array as $item){
                                                                if(($item->cd_usuario == $usuario->cd_usuario) || (isset($item->cd_recebedor) && $item->cd_recebedor == $usuario->cd_usuario)){
                                                                    echo '<div class="item-activities m-timeline-2__item m--margin-top-30">
                                                                            <span class="m-timeline-2__item-time">'.date('d/m', strtotime($item->dt_cadastro)).'</span>
                                                                            <div class="m-timeline-2__item-cricle">';
                                                                                if($item->cd_tipo_transacao == $this->config->item('transaction_resgate')){
                                                                                    $class = 'm--font-warning"';
                                                                                } else{
                                                                                    if($item->cd_recebedor == $usuario->cd_usuario){
                                                                                        $class = 'green-transfer"';
                                                                                    } else{
                                                                                        $class = 'red-transfer"';
                                                                                    }
                                                                                }
                                                                                echo '<i class="fa fa-genderless '.$class.'"></i>
                                                                            </div>
                                                                            <div class="m-timeline-2__item-text m--padding-top-5">';
                                                                                if($item->cd_tipo_transacao == $this->config->item('transaction_resgate')){
                                                                                    echo 'Você trocou '.$item->nr_valor.' Cherries por <a class="m-link m-link--metal m-timeline-3__item-link" href="'.base_url().'reward">'.$item->no_premio.'</a>';
                                                                                } else{
                                                                                    if($item->cd_recebedor == $usuario->cd_usuario){
                                                                                        echo '<a class="m-link m-link--brand m--font-bolder" href="'.base_url().'transfer/to/'.$item->payer_md5.'">'.$item->payer.'</a> pagou '.$item->nr_valor.' Cherries para mim';
                                                                                    }else{
                                                                                        echo 'Você pagou '.$item->nr_valor.' Cherries a <a class="m-link m-link--brand m--font-bolder" href="'.base_url().'transfer/to/'.$item->receiver_md5.'">'.$item->receiver.'</a>';
                                                                                    }
                                                                                    echo '<br/>
                                                                                    <b>Motivo:</b> '.$item->ds_motivo;
                                                                                }
                                                                            echo '</div>
                                                                        </div>';
                                                                }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Activities box -->
                            <!-- Start of Activities box -->
                            <div class="col-xl-6 col-lg-12">
                                <div class="m-portlet  m-portlet--full-height">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <div class="m-widget17__item home-margin-img">
                                                    <span class="m-widget17__icon">
                                                        <i class="la la-globe m--font-brand" style="font-size:2.5rem;color: #2b9cd2 !important;"></i>
                                                    </span> 
                                                </div>
                                                <h3 class="m-portlet__head-text">&nbsp; Timeline</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
                                        <div class="tab-content">
                                            <div id="m_widget2_tab1_content" class="tab-pane active m-scrollable mCustomScrollbar _mCS_5 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="380" style="overflow: visible; height: 380px; max-height: 380px; position: relative;">
                                                <div class="m-timeline-3">
                                                    <div class="m-timeline-3__items" style="padding-top: 25px;">
                                                        <?php
                                                            foreach($array as $item){
                                                                if($item->cd_tipo_transacao == $this->config->item('transaction_resgate')){
                                                                    $class = 'm-timeline-3__item--warning';
                                                                } else{
                                                                    $class = 'm-timeline-3__item--brand';
                                                                } ?>
                                                                <div class="item-timeline m-timeline-3__item <?php echo $class; ?>">
                                                                    <span class="m-timeline-3__item-time"><?php echo date('d/m', strtotime($item->dt_cadastro)); ?></span>
                                                                    <div class="m-timeline-3__item-desc">
                                                                        <span class="m-timeline-3__item-text">
                                                                            <?php
                                                                                if($item->cd_tipo_transacao == $this->config->item('transaction_resgate')){?>
                                                                                    Troca por Prêmio! <?php echo '['.$item->no_premio.' - '.$item->nr_valor.' Cherries]'; ?>
                                                                                    <br>
                                                                                    <span class="m-timeline-3__item-user-name">
                                                                                        <a href="<?php echo base_url().'transfer/to/'.$item->payer_md5; ?>" class="m-link m-link--metal m-timeline-3__item-link"><?php echo $item->payer; ?></a>
                                                                                    </span>
                                                                                <?php } else{ ?>
                                                                                    <b><a href="<?php echo base_url().'transfer/to/'.$item->receiver_md5; ?>" class="m-link m-link--brand m--font-bolder"><?php echo $item->receiver; ?></a></b> recebeu <?php echo $item->nr_valor; ?> Cherries
                                                                                    <br>
                                                                                    <b>Motivo: </b><?php echo $item->ds_motivo; ?>
                                                                                    <br>
                                                                                    <span class="m-timeline-3__item-user-name">
                                                                                        de <a href="<?php echo base_url().'transfer/to/'.$item->payer_md5; ?>" class="m-link m-link--metal m-timeline-3__item-link"><?php echo $item->payer; ?></a>
                                                                                    </span>
                                                                                <?php } ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        ?>                                                                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Activities box -->
                        </div>
                        <!-- End of row of Activities and Timeline -->
                        <div class="row">
                            <!-- Start of bithdays box -->
                            <div class="col-sm-12">
                                    <div class="m-portlet  m-portlet--full-height">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <div class="m-widget17__item home-margin-img">
                                                        <span class="m-widget17__icon">
                                                            <i class="fa fa-birthday-cake m--font-brand" style="font-size:2.1rem;color: #e2ab2b !important;"></i>
                                                        </span> 
                                                    </div>
                                                    <h3 class="m-portlet__head-text">&nbsp; Aniversariantes do mês </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="m-scrollable mCustomScrollbar _mCS_5 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="600" style="overflow: visible; height: 380px; max-height: 380px; position: relative;">
                                                    <div class="row-profiles">
                                                        <div class="m-pricing-table-1">
                                                            <div class="row-users m-pricing-table-1__items row">
                                                            <?php
                                                                foreach($aniversariantes as $usuarios){?>
                                                                    <div class="border-aniversariantes item-profile m-pricing-table-1__item col-lg-3">
                                                                        <div class="m-card-profile">
                                                                            <div class="m-card-profile__pic">
                                                                                <div class="m-card-profile__pic-wrapper">
                                                                                    <img width="130px" height="130px" src="<?php echo base_url().$this->config->item('dir_upload_profile').$usuarios->no_foto_usuario?>" alt="<?php echo $usuarios->no_usuario;?>" title="<?php echo $usuarios->no_usuario;?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <h2 class="m-pricing-table-1__subtitle"><?php echo $usuarios->no_usuario;?></h2>
                                                                        <h3 class="m-pricing-table-1__subtitle"><?php echo str_replace('-', '/', date('d/m/Y',strtotime($usuarios->dt_nasc))); ?></h3>
                                                                        <div class="m-pricing-table-1__btn"></div>
                                                                    </div>
                                                                <?php }  
                                                            ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of bithdays box -->
                            </div>
                    </div>
                </div>
            </div>
            <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
                <i class="la la-arrow-up"></i>
            </div>
        </div>
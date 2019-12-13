        <div class="m-grid m-grid--hor m-grid--root m-page">
            <?php $this->load->view('include/header'); ?>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-subheader ">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-subheader__title "></h3>
                            </div>                            
                        </div>
                    </div>
                    <div class="m-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">Rewards cadastradas</h3>
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-tools">
                                             <a href="<?php echo base_url().'reward/create'; ?>" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                <span>
                                                    <i class="la la-trophy"></i>
                                                    <span>
                                                        Nova Reward
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
								        <div class="m-section">
                                            <div class="m-section__content">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Status</th>
													        <th>Nome</th>
                                                            <th>Valor</th>
                                                            <th>Ações</th>
                                                        </tr>
											        </thead>
											        <tbody class="all-users">
                                                        <?php
                                                            foreach($premios as $item){?>
                                                                <tr class="row-reward">
                                                                    <td scope="row"><?php echo $item->no_status; ?></td>
                                                                    <td ><b><?php echo $item->no_premio;?></b><p><?php echo $item->ds_premio;?></p></td>
                                                                    <td><?php echo $item->nr_valor; ?> CheckPoints</td>
                                                                    <td>
                                                                        <?php 
                                                                            echo form_hidden('no_premio', set_value('no_premio', $item->no_premio));
                                                                            echo form_hidden('cd_premio', set_value('cd_usuario', $item->cd_premio));
                                                                        ?>
                                                                        <button data-toggle="modal" data-target="#myModal" type="button" class="btn-delete-reward btn btn-danger m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill">
                                                                            <i class="la la-trash"></i>
                                                                        </button>
                                                                        <a href="<?php echo base_url().'reward/view/'.$item->cd_premio ?>" class="btn btn-accent m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill">
                                                                            <i class="la la-pencil"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        ?>
											        </tbody>
                                                </table>
									        </div>
								        </div>
                                    </div>
						        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
            <i class="la la-arrow-up"></i>
        </div>

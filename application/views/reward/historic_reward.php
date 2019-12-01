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
                                                <h3 class="m-portlet__head-text">Histórico Rewards</h3>
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-tools">
                                            <a  onclick="exportCSV()" style="color: #ffff" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                <span>
                                                    <i class="la la-download"></i>
                                                    <span>
                                                        Exportar CSV
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
                                                            <th>Nome</th>
													        <th>Valor</th>
                                                            <th>Status</th>
                                                            <th>Quantidade resgates</th>
                                                            <th>Ações</th>
                                                        </tr>
											        </thead>
											        <tbody class="all-users">
                                                        <?php
                                                            foreach($resgates as $item){?>

                                                                <tr class="resgate-row">
                                                                    <td class="nome_reward"><b><?php echo $item['no_premio'];?></b><p><?php echo $item['ds_premio'];?></p></td>
                                                                    <td class="valor_reward"><?php echo $item['nr_valor']; ?></td>
                                                                    <td class="status_reward"><?php echo $item['no_status']; ?></td>
                                                                    <td class="qtd_reward"><?php echo $item['qtd_resgate']; ?></td>
                                                                    <td>
                                                                        <?php 
                                                                            $arrayMail = "";
                                                                            $arrayName = "";
                                                                            $arrayData = "";

                                                                            foreach ($item['usuarios'] as $user) {
                                                                               $arrayMail .= $user->no_email.';';
                                                                               $arrayName .= $user->no_usuario.';';
                                                                               $arrayData .= date('d/m/Y', strtotime($user->dt_cadastro)).';';
                                                                            }
                                                                            echo form_hidden('no_usuario', set_value('no_usuario', $arrayName));
                                                                            echo form_hidden('no_email', set_value('no_email', $arrayMail));
                                                                            echo form_hidden('no_premio', set_value('no_premio', $item['no_premio']));
                                                                            echo form_hidden('cd_premio', set_value('cd_usuario', $item['cd_premio']));
                                                                            echo form_hidden('qtd_resgate', set_value('qtd_resgate', $item['qtd_resgate']));
                                                                             echo form_hidden('dt_cadastro', set_value('dt_cadastro', $arrayData))
                                                                        ?>
                                                                        <button class="btn-resgates-history btn btn-accent m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill" style="color: white !important;">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
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
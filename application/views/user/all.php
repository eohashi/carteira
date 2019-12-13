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
                                                <h3 class="m-portlet__head-text">Usuários cadastrados</h3>
                                                <input type="text" id="buscarUsuario" class="search" oninput="buscarUsuarioUserAll()" placeholder="Procurar usuário . . .">
                                            </div>
                                        </div>
                                        <div class="m-portlet__head-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a href="<?php echo base_url(); ?>user/create" class="dropdown-item">
                                                        <span><i class="fa flaticon-user-add"></i>
                                                            <span>Novo usuário</span>
                                                        </span>
                                                    </a>
                                                    <button data-toggle="modal" data-target="#myModalKavs" class="btn-kavs-for-all dropdown-item">
                                                        <span><i class="fa flaticon-piggy-bank"></i>
                                                            <span>CheckPoints para todos</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__body">
								        <div class="m-section">
                                            <div class="m-section__content">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Status</th>
													        <th>Nome</th>
                                                            <th>Saldo</th>
                                                            <th>Ações</th>
                                                        </tr>
											        </thead>
											        <tbody class="all-users">
                                                        <?php
                                                            foreach($usuarios as $item){?>
                                                                <tr class="row-user">
                                                                    <td scope="row"><?php echo $item->cd_usuario; ?></td>
                                                                    <td ><?php echo $item->no_status; ?></td>
                                                                    <td class="name-user"><?php echo $item->no_usuario; ?></td>
                                                                    <td><?php echo $item->nr_saldo; ?> CheckPoints</td>
                                                                    <td>
                                                                        <?php 
                                                                            echo form_hidden('no_usuario', set_value('no_usuario', $item->no_usuario));
                                                                            echo form_hidden('cd_usuario', set_value('cd_usuario', $item->cd_usuario));
                                                                        ?>
                                                                        <button data-toggle="modal" data-target="#myModal" type="button" class="btn-delete btn btn-danger m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill">
                                                                            <i class="la la-trash"></i>
                                                                        </button>
                                                                        <a href="<?php echo base_url().'user/view/'.$item->no_email_md5 ?>" class="btn btn-accent m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill">
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
                        <?php
                            if(isset($offset)){
                                echo '
                                <div class="col-7 ml-auto">
                                    <a href="#" id="carregar-mais" data-offset="'.$offset.'" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Carregar mais</a>
                                </div>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
            <i class="la la-arrow-up"></i>
        </div>

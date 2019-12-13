            <header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
                <div class="m-container m-container--fluid m-container--full-height">
                    <div class="m-stack m-stack--ver m-stack--desktop">
                        <!-- BEGIN: Brand -->
                        <div class="m-stack__item m-brand  m-brand--skin-dark ">
                            <div class="m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-stack__item--middle m-stack__item--center m-brand__logo">
                                    <a href="<?php echo base_url(); ?>" class="m-brand__logo-wrapper">
                                        <img alt="Home" src="<?php echo base_url(); ?>assets/img/logo.png" style="width:100px;"/>
                                    </a>
                                </div>
                                <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                    <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                    <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                        <div class="m-card-user__pic">
                                            <img style="width: 40px;height: 40px;" class="user-pic-mobile" src="<?php echo base_url().'upload/profiles/'.$usuario->no_foto_usuario; ?>"/>
                                        </div>
                                    </a>
                                    <!-- BEGIN: Topbar Toggler -->
                                </div>
                            </div>
                        </div>
                        <!-- END: Brand -->
                        <div style="background: #282a3c;" class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                            <!-- BEGIN: Horizontal Menu -->
                            <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                                <i class="la la-close"></i>
                            </button>
                            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
                                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                                    <li  class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                        <a  href="<?php echo base_url(); ?>" class="m-menu__link ">
                                            <span id="home" class="m-menu__link-text">
                                                Home
                                            </span>
                                            
                                        </a>
                                    </li>
                                    <li  class="m-menu__item  m-menu__item--submenu m-menu__item--rel m--visible-tablet-and-mobile-inline-block"  data-menu-submenu-toggle="click" aria-haspopup="true">
                                        <a  href="<?php echo base_url().'profile/my/'.$this->session->userdata('user'); ?>" class="m-menu__link ">
                                            <span id="profile" class="m-menu__link-text">
                                                Perfil
                                            </span>
                                            
                                        </a>
                                    </li>
                                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
                                        <a  href="<?php echo base_url(); ?>explore" class="m-menu__link">
                                            <span id="explore" class="m-menu__link-text">
                                                Transferir
                                            </span>
                                        </a>
                                    </li>
                                        <?php 

                                            if($usuario->cd_tipo_usuario !=2){
                                                echo '<li class="m-menu__item m-menu__item--submenu m-menu__item--rel" data-menu-submenu-toggle="click">
                                                        <a href="#" class="m-menu__link m-menu__toggle ">
                                                            <span id="reward" class="m-menu__link-text">
                                                                Premios
                                                            </span>
                                                            <i class="m-menu__hor-arrow la la-angle-down"></i>
                                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                                        </a>
                                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                                            <span class="m-menu__arrow m-menu__arrow--adjust" style="left: 73px;"></span>
                                                            <ul class="m-menu__subnav">';
                                                                if($usuario->cd_tipo_usuario == $this->config->item('usuario_admin')
                                                                || $usuario->cd_tipo_usuario == $this->config->item('usuario_rh')){
                                                                    echo '<li class="m-menu__item ">
                                                                            <a href="'.base_url().'reward" class="m-menu__link ">
                                                                                <i class="m-menu__link-icon la la-trophy"></i>
                                                                                <span class="m-menu__link-text">
                                                                                    Resgatar Premio
                                                                                </span>
                                                                            </a>
                                                                        </li>';
                                                                }
                                                          echo '<li class="m-menu__item ">
                                                                    <a href="'.base_url().'reward/create" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon flaticon-file"></i>
                                                                        <span class="m-menu__link-text">
                                                                            Cadastrar Novo
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-menu__item ">
                                                                    <a href="'.base_url().'reward/all" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon fa fa-eye"></i>
                                                                        <span class="m-menu__link-text">
                                                                            Visualizar Premios
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-menu__item ">
                                                                    <a href="'.base_url().'reward/historic" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon la la-history"></i>
                                                                        <span class="m-menu__link-text">
                                                                            Históricode Premios
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>';
                                            }
                                            else{
                                                echo '
                                                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
                                                        <a  href="'.base_url().'reward" class="m-menu__link">
                                                            <span id="reward" class="m-menu__link-text">
                                                                    Premios
                                                            </span>
                                                          </a>
                                                    </li>';
                                            }

                                        ?>
                                    <?php if($usuario->cd_tipo_usuario != 2){
                                        echo '
                                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
                                            <a  href="'.base_url().'user/all" class="m-menu__link">
                                                <span id="user" class="m-menu__link-text">
                                                    Usuários
                                                </span> 
                                            </a>
                                        </li>';
                                    }?>
                                </ul>
                            </div>
                            <!-- END: Horizontal Menu -->                               <!-- BEGIN: Topbar -->
                            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-topbar__nav-wrapper">
                                    <ul class="m-topbar__nav m-nav m-nav--inline">
                                                              
                                        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-topbar__userpic">
                                                    <img id="profile-pic-header" class="m-stack--desktop" style="width: 60px;height: 60px;" src="<?php echo base_url().'upload/profiles/'.$usuario->no_foto_usuario; ?>"/>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url(); ?>assets/theme/img/bg/bg-2.jpg); background-size: cover;">
                                                        <div class="m-card-user m-card-user--skin-dark">
                                                            <div class="m-card-user__pic">
                                                                <img style="width: 60px;height: 60px;" src="<?php echo base_url().'upload/profiles/'.$usuario->no_foto_usuario; ?>"/>
                                                            </div>
                                                            <div class="m-card-user__details">
                                                                <span class="m-card-user__name m--font-weight-500">
                                                                    <?php echo $usuario->no_usuario; ?>
                                                                </span>
                                                                <a class="m-card-user__email m--font-weight-300 m-link">
                                                                    <?php echo $usuario->no_email; ?>
                                                                </a>
                                                                <span class="m-card-user__name m--font-weight-500" style="padding-top:5px;">
                                                                    <?php echo $usuario->nr_saldo; ?> CheckPoints
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav m-nav--skin-light">
                                                                <li class="m-nav__item">
                                                                    <a href="<?php echo base_url().'profile/my/'.$this->session->userdata('user'); ?>" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                        <span class="m-nav__link-title">
                                                                            <span class="m-nav__link-wrap">
                                                                                <span class="m-nav__link-text">
                                                                                    Perfil
                                                                                </span>
                                                                                
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="<?php echo base_url(); ?>explore" class="m-nav__link">
                                                                        <i class="m-nav__link-icon la la-retweet"></i>
                                                                        <span class="m-nav__link-text">
                                                                            Transferir
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="<?php echo base_url(); ?>reward" class="m-nav__link">
                                                                        <i class="m-nav__link-icon la la-trophy"></i>
                                                                        <span class="m-nav__link-text">
                                                                            Premios
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                                                <li class="m-nav__item">
                                                                    <a href="<?php echo base_url(); ?>login/logout" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                        Logout
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END: Topbar -->
                        </div>
                    </div>
                </div>
            </header>

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
											<i class="la la-retweet" style="color: #b663e0;"></i>
										</span>
										<h3 class="m-portlet__head-text explore-transfer">
											Explore / Transfer
										</h3>
										<input type="text" id="buscarUsuario" class="search" oninput="buscarUsuario()" placeholder="Procurar usuário . . .">
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
								<?php
				                    foreach($celulas as $celula){
				                        echo '<div class="row-profiles">
					                        	  <div class="row-title row title-row-explore">
													<h2 class="m-pricing-table-1__subtitle">
														'.$celula->no_celula.'
													</h2>
												  </div>
												  <div class="m-pricing-table-1">
												  	<div class="row-users m-pricing-table-1__items row" style="padding: 0 0 0 0 !important;">';         
					                                foreach($usuarios as $item){
					                                	if($celula->cd_celula == $item->cd_celula){
						                                	echo '<div class="item-profile m-pricing-table-1__item col-lg-3">
																	<div class="m-card-profile">
																		<div class="m-card-profile__pic">
																			<div class="m-card-profile__pic-wrapper">
																				<img width="130px" height="130px" src="'.base_url().$this->config->item('dir_upload_profile').$item->no_foto_usuario.'" alt="'.$item->no_usuario.'" title="'.$item->no_usuario.'">
																			</div>
																		</div>
																	</div>							
																	<h2 class="m-pricing-table-1__subtitle">
																		'.$item->no_usuario.'
																	</h2>										
																	<div class="m-pricing-table-1__btn" >
																		<a href="'.base_url().'transfer/to/'.$item->no_email_md5.'" class="btn btn-outline-brand m-btn m-btn--icon m-btn--pill m-btn--air" style="padding: 0.86rem 1.57rem 0.86rem 1.57rem !important;">
																			<span>
																				<i class="fa fa-exchange"></i>
																				<span>
																					TRANSFERIR
																				</span>
																			</span>
																		</a>
																	</div>
																</div>';
													}
		                                        }
				                        echo '</div>
				                            </div>
				                        </div>';
	                        		}
             					?>
							</div>
						</div>
						<!--End::Section-->
					</div>
				</div>
			</div>
			<!-- end:: Body -->
		</div>
		<!-- end:: Page -->
    		 
		<!-- end::Quick Sidebar -->		    
	    <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
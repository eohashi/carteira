        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid  m-error-5" style="background-image: url(<?php echo base_url().'assets/theme/img/error/bg5.jpg' ?>);">
                <div class="m-error_container">
                    <span class="m-error_title">
                        <h1>
                            Oops!
                        </h1>
                    </span>
                    <p class="m-error_subtitle">
                        <?php echo $texto; ?>
                    </p>
                    <p class="m-error_description">
                        <a style="margin-top: 50px;" href="<?php echo base_url() ?>" class="btn m-btn--pill    btn-outline-warning btn-lg">
                            Voltar para home
                        </a>
                    </p>
                </div>
            </div>
        </div>
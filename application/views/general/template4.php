        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-error-4" style="background-image: url(<?php echo base_url().'assets/theme/img/error/bg4.jpg' ?>);">
                <div class="m-error_container">
                    <h1 class="m-error_number">
                        404
                    </h1>
                    <p class="m-error_title">
                        ERROR
                    </p>
                    <p class="m-error_description">
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
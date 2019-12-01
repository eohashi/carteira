        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid  m-error-6" style="background-image: url(<?php echo base_url().'assets/theme/img/error/bg6.jpg' ?>);">
                <div class="m-error_container">
                    <div class="m-error_subtitle m--font-light">
                        <h1>
                            Oops...
                        </h1>
                    </div>
                    <p class="m-error_description m--font-light">
                        <?php echo $texto; ?>               
                    </p>
                    <p class="m-error_description">
                        <a href="<?php echo base_url() ?>" class="btn m-btn--pill    btn-info m-btn m-btn--custom btn-lg">
                            Voltar para home
                        </a>
                    </p>
                </div>
            </div>
        </div>
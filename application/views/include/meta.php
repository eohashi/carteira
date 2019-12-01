<!DOCTYPE html>
<html lang="pt">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            <?php echo $this->config->item('title_generic'); ?>
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="<?php echo base_url(); ?>assets/theme/js/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Montserrat:300,400,500,600,700","Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <link href="<?php echo base_url(); ?>assets/theme/css/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/theme/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/cereja.png" />
        <?php if(isset($css)) foreach($css as $key=>$value) echo $value; ?>
    </head>
     <?php echo form_hidden('base_url', set_value('', base_url())); ?>
        
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <!-- begin:: Page -->

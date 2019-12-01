

        <!-- Customs JS -->
        <script src="<?php echo base_url(); ?>assets/theme/js/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/theme/js/scripts.bundle.js" type="text/javascript"></script>
        <?php if(isset($src)) foreach($src as $key=>$value) echo $value; ?>
	</body>
</html>
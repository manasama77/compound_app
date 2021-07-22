<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('layouts/member/_head'); ?>

<?php
if (isset($vitamin_css)) {
	$this->load->view('pages/member/' . $vitamin_css);
}
?>

<body class="control-sidebar-slide-open layout-fixed sidebar-mini-sm text-sm" style="height: auto;">
	<div class="wrapper">

		<!-- Preloader -->
		<?php $this->load->view('layouts/member/_preloader');
		?>
		<!-- /.Preloader -->

		<!-- Navbar -->
		<?php $this->load->view('layouts/member/_navbar'); ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php $this->load->view('layouts/member/_aside'); ?>
		<!-- /.Main Sidebar Container -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php //echo '<pre>' . print_r($this->session->all_userdata(), 1) . '</pre>'; 
			?>
			<?php $this->load->view('pages/member/' . $content); ?>
		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<?php $this->load->view('layouts/member/_footer'); ?>
	</div>
	<!-- ./wrapper -->

	<form id="form_otp">
		<div class="modal fade" id="modal_otp" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">OTP</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="otp">OTP</label>
							<input type="number" class="form-control" id="otp" name="otp" min="100000" max="999999" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery 3.5 -->
	<script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4.6 -->
	<script src="<?= base_url(); ?>vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.js"></script>

	<!-- overlayScrollbars -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

	<!-- PAGE PLUGINS -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/raphael/raphael.min.js"></script>
	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<script src="<?= base_url(); ?>public/js/sweetalert2.min.js"></script>
	<script src="<?= base_url(); ?>public/js/toastr.min.js"></script>


	<!-- DataTables  & Plugins -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jszip/jszip.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
</body>

</html>


<?php
if (isset($vitamin_js)) {
	$this->load->view('pages/member/' . $vitamin_js);
}
?>

<script>
	function otpAuth() {
		return $.ajax({
			url: '<?= site_url('otp_auth'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				otp: $('#otp').val()
			},
			beforeSend: function(e) {
				$.blockUI();
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				html: e.responseText,
			});
			console.log(e);
		});
	}

	function sendOTP() {
		return $.ajax({
			url: '<?= site_url('otp_resend'); ?>',
			method: 'post',
			dataType: 'text',
			beforeSend: function() {
				$.blockUI();
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
			if (e.responseText != '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
			}
		});
	}
</script>

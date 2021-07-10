<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="index2.html" class="h1"><b><?= APP_NAME; ?></b></a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">We will send email to reset your password</p>

				<form id="form_forgot_password">
					<div class="input-group mb-3">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<label for="email" class="fas fa-envelope"></label>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">Send Email</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<p class="mb-1 mt-3">
					<a href="<?= site_url('login'); ?>">I remember my password</a>
				</p>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.min.js"></script>
	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<script src="<?= base_url(); ?>public/js/sweetalert2.all.min.js"></script>
</body>

</html>
<script>
	$(document).ready(function() {
		$('#form_forgot_password').on('submit', function(e) {
			e.preventDefault();
			sendForgotApprove();
		});
	});

	function sendForgotApprove() {
		let email = $('#email').val();

		$.ajax({
			url: '<?= site_url('send_forgot_password'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				email: email
			},
			beforeSend: function() {
				$.blockUI();
			}
		}).always(function(e) {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
			if (e.responseText != '') {
				console.log(e);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Send Email Forgot Password Failed, Connection Issue. Please check email address or try again',
				});
			} else if (e.code == 200) {
				Swal.fire({
					icon: 'success',
					title: 'Send Email Forgot Password Success',
					text: 'Please check your email to reset your password',
				});
			}
		});
	}
</script>

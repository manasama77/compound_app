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
	<link href="<?= base_url(); ?>public/css/sweetalert2-theme-dark.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/login.css">
	<link rel="icon" href="<?= base_url(); ?>public/img/logo.png">
	<style>
		.login-box {
			margin-top: -8rem !important;
		}
	</style>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="<?= base_url(); ?>" class="h1"><b><?= APP_NAME; ?></b></a>
			</div>
			<div class="card-body">

				<form id="form" action="<?= site_url('auth'); ?>" method="post">
					<div class="input-group mb-3">
						<input type="email" class="form-control lowercase <?= $this->session->flashdata('email_state'); ?>" id="email" name="email" placeholder="Email" autocomplete="email" value="<?= $this->session->flashdata('email_value'); ?>" minlength="5" maxlength="100" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
						<div class="invalid-feedback">
							<?= $this->session->flashdata('email_state_message'); ?>
						</div>

					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control <?= $this->session->flashdata('password_state'); ?>" id="password" name="password" placeholder="Password" minlength="4" maxlength="16" autocomplete="current-password" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span id="eye" class="fas fa-eye"></span>
							</div>
						</div>
						<div class="invalid-feedback">
							<?= $this->session->flashdata('password_state_message'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" id="remember" name="remember" value="yes">
								<label for="remember">
									Ingatkan Saya
								</label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4">
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" class="btn btn-primary btn-block">Masuk</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<div class="mb-1 mt-4">
					<div class="float-right">
						<a href="<?= LINK_PENDAFTARAN; ?>"><strong>Pendaftaran</strong></a>
					</div>
					<a href="<?= site_url('forgot_password'); ?>">Lupa Password ?</a>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.login-box -->
	</div>

	<nav class="navbar fixed-bottom navbar-dark bg-light">
		<strong>Copyright &copy; <?= APP_YEAR_TO; ?> <a href="<?= site_url(); ?>"><?= APP_NAME; ?></a>. All rights reserved.</strong>
		<div class="float-right d-none d-sm-inline-block">
			<b>Version</b> <?= APP_VERSION; ?>
		</div>
	</nav>

	<!-- jQuery -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.min.js"></script>


	<script src="<?= base_url(); ?>public/js/sweetalert2.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#eye').on('click', function() {
				let pass = document.getElementById("password");
				if (pass.type === "password") {
					$('#eye').removeClass("fa-eye").addClass("fa-eye-slash");
					pass.type = "text";
				} else {
					$('#eye').removeClass("fa-eye-slash").addClass("fa-eye");
					pass.type = "password";
				}
			});
		});
	</script>
</body>

</html>
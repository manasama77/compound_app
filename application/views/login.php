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
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/login.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="<?= base_url(); ?>" class="h1"><b><?= APP_NAME; ?></b></a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form action="<?= site_url('auth'); ?>" method="post">
					<div class="input-group mb-3">
						<input type="email" class="form-control lowercase <?= $this->session->flashdata('email_state'); ?>" id="email" name="email" placeholder="Email" autocomplete="email" value="<?= $this->session->flashdata('email_value'); ?>" required>
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
						<input type="password" class="form-control <?= $this->session->flashdata('password_state'); ?>" id="password" name="password" placeholder="Password" minlength="4" autocomplete="current-password" required>
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
						<div class="col-12">
							<div class="h-captcha" data-sitekey="3ee57b90-ce1a-422c-ab84-84fab9c5e97f"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" id="remember" name="remember" value="yes">
								<label for="remember">
									Remember Me
								</label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<p class="mb-1 mt-3">
					<a href="<?= site_url('forgot_password'); ?>">I forgot my password</a>
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

	<script src='https://www.hCaptcha.com/1/api.js' async defer></script>

	<script>
		$("form").submit(function(event) {

			var hcaptchaVal = $('[name=h-captcha-response]').value;
			if (hcaptchaVal === "") {
				event.preventDefault();
				alert("Please complete the hCaptcha");
			}
		});
	</script>
</body>

</html>

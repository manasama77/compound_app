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
				<a href="javascript:void(0)" class="h1"><b><?= APP_NAME; ?></b></a>
			</div>
			<div class="card-body">
				<?php if (validation_errors()) { ?>
					<div class="alert alert-danger mb-3" role="alert">
						<?= validation_errors(); ?>
					</div>
				<?php } ?>
				<p class="login-box-msg">Siapkan password Baru Anda</p>

				<form action="<?= site_url(); ?>reset_password/<?= $this->uri->segment(2); ?>/<?= $this->uri->segment(3); ?>" method="post">
					<div class="input-group mb-3">
						<input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" placeholder="Email" required readonly>
						<div class="input-group-append">
							<div class="input-group-text">
								<label for="email" class="fas fa-email"></label>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" id="password" name="password" placeholder="New Password" min="4" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<label for="password" class="fas fa-key"></label>
							</div>
						</div>
					</div>

					<div class="input-group mb-3">
						<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Verify New Password" min="4" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<label for="verify_password" class="fas fa-key"></label>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">Set New Password</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

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
</body>

</html>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= APP_NAME; ?> | Aktivasi Berhasil</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/dist/css/adminlte.min.css">

</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 offset-md-4 mt-5">
				<div class="alert alert-success" role="alert">
					<h4 class="alert-heading">Well done!</h4>
					<p>Reset Password Berhasil, Anda dapat Masuk sekarang dengan kata sandi baru Anda!</p>
					<hr>
					<p class="mb-0">Pastikan tidak pernah membagikan akun Anda kepada orang lain dengan alasan apa pun. Kami tidak dapat membantu jika terjadi sesuatu pada akun Anda!</p>
					<hr>
					<a href="<?= site_url('login'); ?>" class="btn btn-success btn-block">Continue Log In</a>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>

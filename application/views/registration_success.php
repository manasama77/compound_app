<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 offset-md-4 mt-5">
				<div class="alert alert-success" role="alert">
					<h4 class="alert-heading"><a href="<?= site_url('activation_account_success'); ?>">Well done!</a></h4>
					<p>You're registration success, please check your email for activation!</p>
					<hr>
					<p class="mb-0">Be sure check your Inbox Folder or Spam Folder!</p>
					<hr>
					<a href="<?= site_url('login'); ?>" class="btn btn-success btn-block">Go to Login Page</a>
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

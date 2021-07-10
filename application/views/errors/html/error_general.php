<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/dist/css/adminlte.min.css">

	<title>Error</title>
	<style>
		body {
			background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);
		}

		.error-template {
			padding: 40px 15px;
			text-align: center;
		}

		.error-actions {
			margin-top: 15px;
			margin-bottom: 15px;
		}

		.error-actions .btn {
			margin-right: 10px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="error-template">
					<img src="<?= base_url('public/img/logo.png'); ?>" class="img-fluid mb-3" alt="<?= APP_NAME; ?> LOGO">
					<h1>
						Oops!</h1>
					<h2><?php echo $heading; ?></h2>
					<div class="error-details">
						<?= $message; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>

<!-- jQuery 3.5 -->
<script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
<!-- Bootstrap 4.6 -->
<script src="<?= base_url(); ?>vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.js"></script>
<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
<script src="<?= base_url(); ?>public/js/sweetalert2.min.js"></script>

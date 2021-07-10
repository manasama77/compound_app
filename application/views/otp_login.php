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
	<link href="<?= base_url(); ?>public/css/sweetalert2-theme-dark.css" rel="stylesheet">
	<link href="<?= base_url(); ?>public/css/toastr.min.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 offset-md-4 mt-5">
				<form id="form_otp">
					<div class="card">
						<div class="card-header">
							Form OTP - Login
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="otp">OTP</label>
								<input type="number" class="form-control mb-2" id="otp" name="otp" min="100000" max="999999" placeholder="000000" autofocus required>
								<span class="help-block"><small>We already sent OTP to <kbd><?= $this->session->userdata(SESI . 'email'); ?></kbd></small></span>
							</div>
							<button type="button" class="btn btn-warning btn-sm btn-block" id="resend_button" onclick="resendOTP('<?= $this->session->userdata(SESI . 'email'); ?>');" disabled>
								Didn't receive OTP Code ?<br />
								Try send again<br />
								(After <span id="time">03:00</span>)
							</button>
							<button type="submit" class="btn btn-primary btn-block" id="submit_btn">Verify</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.min.js"></script>

	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<script src="<?= base_url(); ?>public/js/sweetalert2.min.js"></script>
	<script src="<?= base_url(); ?>public/js/toastr.min.js"></script>
</body>

</html>

<script>
	let toastrOptions = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": 300,
			"hideDuration": 1000,
			"timeOut": 3000,
			"extendedTimeOut": 0,
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		},
		minutes = 10 * 1,
		display = $('#time');

	$(document).ready(function() {
		startTimer(minutes, display);

		$('#form_otp').on('submit', function(e) {
			e.preventDefault();
			checkOTP();
		});
	});

	function startTimer(duration, display) {
		var timer = duration,
			minutes, seconds;

		setInterval(function() {
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.text(minutes + ":" + seconds);

			if (--timer < 0) {
				timer = 0;
				$("#resend_button").attr('disabled', false);
			}
		}, 1000);
	}

	function checkOTP() {
		let email = $('#email').val(),
			otp = $('#otp').val();

		$.ajax({
			url: '<?= site_url('otp_auth'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				email: email,
				otp: otp,
			},
			beforeSend: function() {
				$('#otp').attr('disabled', true);
				$("#resend_button").attr('disabled', true);
				$('#submit_btn').attr('disabled', true);
				$.blockUI();
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
		}).done(function(e) {
			if (e.code == 500) {
				$('#otp').attr('disabled', false);
				$("#resend_button").attr('disabled', false);
				$('#submit_btn').attr('disabled', false);
				toastr.warning('Warning', 'OTP Wrong', toastrOptions);
				setTimeout(function() {
					$('#otp').focus();
				}, 3000);
			} else if (e.code == 200) {
				toastr.success('Success', 'OTP Verified', toastrOptions);
				setTimeout(function() {
					window.location.replace('<?= site_url('dashboard'); ?>');
				}, 3000);
			} else {
				toastr.error('Error', 'Response Unknown', toastrOptions);
			}
		});
	}

	function resendOTP(email) {
		$.ajax({
			url: '<?= site_url('otp_resend'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				email: email
			},
			beforeSend: function() {
				$("#resend_button").attr('disabled', true);
				$.blockUI();
			}
		}).always(function() {
			$.unblockUI();
			startTimer(minutes, display);
		}).fail(function(e) {
			console.log(e);
		}).done(function(e) {
			console.log(e);
		});
	}
</script>

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
	<link rel="icon" href="<?= base_url(); ?>public/img/logo.png">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 offset-md-4 mt-5">
				<form id="form_otp">
					<div class="card">
						<div class="card-header">
							Verifikasi OTP <i>(One Time Password)</i>
						</div>
						<div class="card-body">
							<div class="form-group text-center">
								<label for="otp">OTP</label>
								<input type="text" class="form-control mb-2" id="otp" name="otp" minlength="6" maxlength="6" placeholder="000000" inputmode="numeric" autofocus required>
								<span class="help-block"><small>Sistem telah mengirimkan kode OTP pada alamat email <kbd><?= $this->session->userdata(SESI . 'email'); ?></kbd></small></span>
							</div>
							<button type="button" class="btn btn-warning btn-sm btn-block" id="resend_button" onclick="resendOTP('<?= $this->session->userdata(SESI . 'email'); ?>');" disabled>
								Tidak menerima kode OTP ?<br />
								Coba kirimkan kembali kode OTP<br />
								(Setelah <span id="time">01:00</span>)
							</button>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" class="btn btn-primary btn-block mt-3" id="submit_btn">Verifikasi</button>
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
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			} else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			} else {
				this.value = "";
			}
		});
	};

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
		minutes = <?= TIMER_OTP; ?>,
		display = $('#time');

	$(document).ready(function() {
		startTimer(minutes, display);

		$("#otp").inputFilter(function(value) {
			return /^\d*$/.test(value); // Allow digits only, using a RegExp
		});

		$('#form_otp').on('submit', function(e) {
			e.preventDefault();
			checkOTP();
		});
	});

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
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
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
				}, 2000);
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
				email: email,
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			beforeSend: function() {
				$("#resend_button").attr('disabled', true);
				$.blockUI();
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
		}).done(function(e) {
			console.log(e);
			window.location.reload();
		});
	}

	function startTimer(duration, display) {
		let timer = duration,
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
</script>

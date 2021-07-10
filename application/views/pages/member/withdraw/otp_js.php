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

		$('#form_withdraw').on('submit', function(e) {
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
					window.location.replace('<?= site_url('withdraw/process'); ?>');
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

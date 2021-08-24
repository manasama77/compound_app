<script>
	let rate = $('#rate').val();
	let amount_usdt = $('#amount_usdt');
	let amount_ratu = $('#amount_ratu');

	$('#document').ready(function() {
		$('#form_add').on('submit', function(e) {
			e.preventDefault();
			if (amount_usdt.val() == 0 || amount_ratu.val() == 0) {
				Swal.fire({
					icon: 'warning',
					title: 'Nominal USDT atau RATU Nol...',
					showConfirmButton: false,
					toast: true,
					timer: 3000,
					timerProgressBar: true,
				});
			} else if ($('#otp').val().lenght < 6) {
				Swal.fire({
					icon: 'error',
					title: 'OTP Salah...',
					showConfirmButton: false,
					toast: true,
					timer: 3000,
					timerProgressBar: true,
				});
			} else {
				storeData();
			}
		});

		$('#otp').on('keyup', function(e) {
			if ($(this).val().length == 6) {
				$(this).trigger("keydown", [9]);
				otpAuth().done(function(e) {
					console.log(e);
					if (e.code == 500) {
						Swal.fire({
							icon: 'error',
							title: 'OTP Salah...',
							showConfirmButton: false,
							toast: true,
							timer: 2000,
							timerProgressBar: true,
						});
						$('#otp').val('');
					} else if (e.code == 200) {
						$('#btn_otp').attr('disabled', false).unblock();
						Swal.fire({
							icon: 'success',
							title: 'OTP Valid...',
							showConfirmButton: false,
							toast: true,
							timer: 2000,
							timerProgressBar: true,
						});

						$('#otp').attr('disabled', true);
						$('#btn_otp').attr('disabled', true);
						$('#btn_submit').attr('disabled', false);
					}
				});
			}
		});

		amount_usdt.on('change keyup', function(e) {
			let amount = (amount_usdt.val() - (amount_usdt.val() * <?= $x_app->row()->potongan_swap; ?> / 100)) * rate;
			amount_ratu.val(amount);
		});
	});

	function storeData() {
		$.ajax({
			url: '<?= site_url('convert/store'); ?>',
			method: 'post',
			dataType: 'json',
			data: $('#form_add').serialize(),
			beforeSend: function() {
				$('#btn_submit').attr('disabled', true);
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function(e) {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
			if (e.responseText != '') {
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
					text: e.msg,
				});
			} else if (e.code == 404) {
				Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: e.msg,
				});
			} else if (e.code == 200) {
				setTimeout(function() {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Success...',
						text: e.msg,
						showConfirmButton: true,
						timer: 2000,
						timerProgressBar: true,
					}).then((res) => {
						window.location.reload();
					});
				}, 500);
			}
		});
	}

	function kirimOTP() {
		$.ajax({
			url: '<?= site_url('otp_resend'); ?>',
			method: 'post',
			dataType: 'json',
			beforeSend: function() {
				$('#otp').attr('disabled', true);
				$('#btn_submit').attr('disabled', true);
				$('#btn_otp').attr('disabled', true).block({
					message: '<i class="fas fa-spinner fa-spin"></i>'
				});
			}
		}).always(function() {
			//
		}).fail(function(e) {
			console.log(e);
			if (e.responseText != '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
					howConfirmButton: false,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 200) {
				$('#otp').attr('disabled', false);
				setTimeout(function() {
					$('#otp').attr('disabled', true);
					$('#btn_otp').attr('disabled', false).unblock();
				}, 120000);
			}
		});
	}
</script>

<script>
	$('#document').ready(function() {
		$("#amount").on('change', function() {
			if ($('#amount').val() >= <?= LIMIT_WITHDRAW; ?> && $('#coin_type').val() != null) {
				checkRates();
			} else {
				$('#estimation').val('0');
			}
		});

		$("#coin_type").on('change', function() {
			if ($('#amount').val() >= <?= LIMIT_WITHDRAW; ?> && $('#coin_type').val() != null) {
				checkRates();
			}

			renderWalletLabel();
		});

		$('#id_wallet').on('change', function() {
			if ($('#id_wallet').val() != null) {
				renderWalletAddress();
			}
		});

		$('#form_withdraw').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('withdraw_auth'); ?>',
				method: 'post',
				dataType: 'json',
				data: $('#form_withdraw').serialize(),
				beforeSend: function() {
					$.blockUI({
						message: `<i class="fas fa-spinner fa-spin"></i>`
					});
				}
			}).always(function() {
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
				if (e.code == 200) {
					window.location.replace('<?= site_url(); ?>withdraw/success/' + e.tx_id);
				} else if (e.code == 501) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						html: e.message,
					}).then(() => {
						window.location.reload();
					});
				} else {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						html: e.message,
					});
				}
			});
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
							timer: 3000,
							timerProgressBar: true,
						});
						$('#otp').val('');
					} else if (e.code == 200) {
						Swal.fire({
							icon: 'success',
							title: 'OTP Valid...',
							showConfirmButton: false,
							toast: true,
							timer: 3000,
							timerProgressBar: true,
						});

						$('#otp').attr('disabled', true);
						$('#btn_otp').attr('disabled', true);
						$('#btn_submit').attr('disabled', false);
					}
				});
			}
		});

	});

	function checkRates() {
		let coin_type = $('#coin_type').val();
		let amount = $('#amount').val();

		$.ajax({
			url: '<?= site_url('withdraw_rates'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				amount: amount,
				coin_type: coin_type,
			},
			beforeSend: function() {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function() {
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
			if (e.code == 200) {
				$('#estimation').val(e.result);
			} else {
				Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					html: e.message,
				});
				$('#estimation').val(0);
			}
		});
	}

	function renderWalletLabel() {
		let coin_type = $('#coin_type').val();

		$.ajax({
			url: '<?= site_url('withdraw_render_wallet_label'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				coin_type: coin_type,
			},
			beforeSend: function() {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function() {
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
			let option = '<option value="" disabled selected>-Pilih Wallet Label-</option>';
			if (e.code == 200) {
				$.each(e.data, function(i, k) {
					option += `<option value="${k.id}">${k.wallet_label}</option>`;
				});
			} else {
				let option = '<option value="" disabled selected>-Pilih Wallet Label-</option>';
			}

			$('#id_wallet').html(option);
		});
	}

	function renderWalletAddress() {
		let id_wallet = $('#id_wallet').val();

		$.ajax({
			url: '<?= site_url('withdraw_render_wallet_address'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				id_wallet: id_wallet,
			},
			beforeSend: function() {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function() {
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
			let option = "";
			if (e.code == 200) {
				option = e.wallet_address;
			}

			$('#wallet_address').val(option);
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
				}, 60000);
			}
		});
	}
</script>

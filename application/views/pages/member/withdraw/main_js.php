<script>
	$('#document').ready(function() {
		$("#amount").on('change', function() {
			if ($('#amount').val() >= 100 && $('#receive_coin').val() != null) {
				checkRates();
			}
		});

		$("#receive_coin").on('change', function() {
			if ($('#amount').val() >= 100 && $('#receive_coin').val() != null) {
				checkRates();
			}

			generateHostWallet();
		});

		$('#wallet_host').on('change', function() {
			if ($('#wallet_host').val() != null) {
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
					$.blockUI();
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
					window.location.replace('<?= site_url('withdraw/otp'); ?>');
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
	});

	function checkRates() {
		let amount = $('#amount').val();
		let receive_coin = $('#receive_coin').val();

		$.ajax({
			url: '<?= site_url('withdraw_rates'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				amount: amount,
				receive_coin: receive_coin,
			},
			beforeSend: function() {
				$.blockUI();
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

	function generateHostWallet() {
		let receive_coin = $('#receive_coin').val();

		$.ajax({
			url: '<?= site_url('withdraw_generate_wallet_host'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				receive_coin: receive_coin,
			},
			beforeSend: function() {
				$.blockUI();
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
			let option = '<option value="" disabled selected>-Select Wallet Host-</option>';
			if (e.code == 200) {
				$.each(e.data, function(i, k) {
					option += `<option value="${k.wallet_host}">${k.wallet_host.toUpperCase()}</option>`;
				});
			} else {
				let option = '<option value="" disabled selected>-Select Wallet Host-</option>';
			}

			$('#wallet_host').html(option);
		});
	}

	function renderWalletAddress() {
		let wallet_host = $('#wallet_host').val();

		$.ajax({
			url: '<?= site_url('withdraw_generate_wallet_address'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				wallet_host: wallet_host,
			},
			beforeSend: function() {
				$.blockUI();
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
			let option = '<option value="" disabled selected>-Select Wallet Address-</option>';
			if (e.code == 200) {
				$.each(e.data, function(i, k) {
					option += `<option value="${k.id}">${k.wallet_address}</option>`;
				});
			} else {
				let option = '<option value="" disabled selected>-Select Wallet Host-</option>';
			}

			$('#wallet_address').html(option);
		});
	}
</script>

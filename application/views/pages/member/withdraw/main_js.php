<script>
	$('#document').ready(function() {
		$("#amount").on('change', function() {
			if ($('#amount').val() >= <?= LIMIT_WITHDRAW; ?> && $('#coin_type').val() != null) {
				checkRates();
			}
		});

		$("#coin_type").on('change', function() {
			if ($('#amount').val() >= <?= LIMIT_WITHDRAW; ?> && $('#coin_type').val() != null) {
				checkRates();
			}

			renderWalletLabel();
		});

		$('#wallet_label').on('change', function() {
			if ($('#wallet_label').val() != null) {
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
		let coin_type = $('#coin_type').val();

		$.ajax({
			url: '<?= site_url('withdraw_rates'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				amount: amount,
				coin_type: coin_type,
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
			let option = '<option value="" disabled selected>-Select Wallet Label-</option>';
			if (e.code == 200) {
				$.each(e.data, function(i, k) {
					option += `<option value="${k.wallet_label}">${k.wallet_label}</option>`;
				});
			} else {
				let option = '<option value="" disabled selected>-Select Wallet Label-</option>';
			}

			$('#wallet_label').html(option);
		});
	}

	function renderWalletAddress() {
		let wallet_label = $('#wallet_label').val();

		$.ajax({
			url: '<?= site_url('withdraw_render_wallet_address'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				wallet_label: wallet_label,
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

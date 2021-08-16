<script>
	let id_member = $('#id_member').val();

	$('#document').ready(function() {
		$("#table_data").DataTable({
			"scrollX": "300px",
			"scrollY": "300px",
			order: [
				[0, 'asc']
			],
			responsive: false,
			lengthChange: false,
			autoWidth: false,
			buttons: ["copy", "csv", "excel", "pdf"],
			columnDefs: [{
				targets: [4],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

		$('#form_add').on('submit', function(e) {
			e.preventDefault();
			storeData();
		});

		$('#form_edit').on('submit', function(e) {
			e.preventDefault();
			updateData();
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

	function storeData() {
		$.ajax({
			url: '<?= site_url('wallet/store'); ?>',
			method: 'post',
			dataType: 'json',
			data: $('#form_add').serialize(),
			beforeSend: function() {
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
					text: 'Failed connect to Database, please contact web developer',
				});
			} else if (e.code == 201) {
				Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: `Wallet Address with Coin Type ${$('#coin_type :selected').val()} already registered`,
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Store Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		});
	}

	function editData(id, coin_type, wallet_label, wallet_address) {
		$('#id_edit').val(id);
		$('#coin_type_edit').val(coin_type);
		$('#wallet_label_edit').val(wallet_label);
		$('#wallet_address_edit').val(wallet_address);
		$('#modal_edit').modal('show');
	}

	function updateData() {
		$.ajax({
			url: '<?= site_url('wallet/update'); ?>',
			method: 'post',
			dataType: 'json',
			data: $('#form_edit').serialize(),
			beforeSend: function() {
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
				}).then((res) => {
					window.location.reload();
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Failed connect to Database, please contact web developer',
				}).then((res) => {
					window.location.reload();
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Update Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		});
	}

	function deleteData(id, wallet_label, wallet_address) {
		Swal.fire({
			title: 'Are you sure?',
			text: `Delete Wallet ${wallet_address} with label ${wallet_label}`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				processDeleteData(id);
			}
		})
	}

	function processDeleteData(id) {
		$.ajax({
			url: '<?= site_url('wallet/destroy'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id,
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			beforeSend: function() {
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
				}).then((res) => {
					window.location.reload();
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Failed connect to Database, please contact web developer',
				}).then((res) => {
					window.location.reload();
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Delete Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
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

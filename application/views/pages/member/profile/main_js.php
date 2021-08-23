<script>
	$(document).ready(function() {

		$('#id_bank').val('<?= $arr->row()->id_bank; ?>').trigger('change');

		$('#form_setting').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('setting_update'); ?>',
				method: 'post',
				dataType: 'json',
				data: $('#form_setting').serialize(),
				beforeSend: function() {
					$.blockUI({
						message: `<i class="fas fa-spinner fa-spin"></i>`
					});
				}
			}).always(function(e) {
				$.unblockUI();
			}).fail(function(e) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
				console.log(e);
			}).done(function(e) {
				console.log(e);
				if (e.code == 500) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Gagal Terhubung Dengan Server Database, silahkan coba kembali',
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
		});

		$('#form_reset_password').on('submit', function(e) {
			e.preventDefault();
			checkCurrentPassword();
		});

		$('#form_otp').on('submit', function(e) {
			e.preventDefault();
			otpAuth().done(function(e) {
				console.log(e);
				if (e.code == 500) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						text: 'Kode OTP Salah',
					});
				} else if (e.code == 200) {
					updatePassword();
				}
			});
		});
	});

	function checkCurrentPassword() {
		$.ajax({
			url: '<?= site_url('check_current_password'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				current_password: $('#current_password').val(),
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
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				html: e.responseText,
			});
			console.log(e);
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Gagal Terhubung Dengan Server Database, silahkan coba kembali',
				});
			} else if (e.code == 404) {
				Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: 'Password Saat Ini salah, silahkan coba kembali',
				});
			} else if (e.code == 200) {
				compareNewPassword();
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Unknown Response!',
				});
			}
		});
	}

	function compareNewPassword() {
		let new_password = $('#new_password').val(),
			verify_password = $('#verify_password').val();

		if (new_password != verify_password) {
			Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Password Baru & Verifikasi Password Baru harus sama!',
			});
		} else {
			sendOTP().done(function(e) {
				console.log(e);
				$('#modal_otp').modal('show');
			});
		}
	}

	function updatePassword() {
		$.ajax({
			url: '<?= site_url('update_password'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				new_password: $('#new_password').val(),
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
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Gagal Terhubung Dengan Server Database, silahkan coba kembali',
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Berhasil...',
					text: 'Update Password Berhasil',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		});
	}
</script>

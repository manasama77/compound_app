<script>
	let id_member = $('#id_member').val();
	let fullname = $('#fullname');
	let id_card_number = $('#id_card_number');
	let country_code = $('#country_code');
	let address = $('#address');
	let postal_code = $('#postal_code');
	let id_bank = $('#id_bank');
	let no_rekening = $('#no_rekening');
	let foto_ktp = $('#foto_ktp');
	let foto_pegang_ktp = $('#foto_pegang_ktp');

	let formData;

	$('#document').ready(function() {
		$("#id_card_number").inputFilter(function(value) {
			return /^\d*$/.test(value); // Allow digits only, using a RegExp
		});

		$("#postal_code").inputFilter(function(value) {
			return /^\d*$/.test(value); // Allow digits only, using a RegExp
		});

		$("#no_rekening").inputFilter(function(value) {
			return /^\d*$/.test(value); // Allow digits only, using a RegExp
		});

		$('#country_code').val('<?= set_value('country_code'); ?>').trigger('change');
		$('#id_bank').val('<?= set_value('id_bank'); ?>').trigger('change');

		$('#form').on('submit', function(e) {
			e.preventDefault();

			formData = new FormData(this);
			console.log(formData);

			$.ajax({
				url: '<?= site_url('cek_ktp'); ?>',
				method: 'get',
				dataType: 'json',
				data: {
					id_card_number: id_card_number.val()
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

				if (e.code == 500) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: "No KTP Telah Terdaftar",
					});
				} else if (e.code == 200) {
					checkOTP();
				}
			});
		});

		$('#form_otp').on('submit', function(e) {
			e.preventDefault();
			otpAuth().done(function(e) {
				console.log(e);
				if (e.code == 500) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						toast: true,
						text: 'Kode OTP Salah',
						showConfirmButton: false,
					});
				} else if (e.code == 200) {
					processKYC();
				}
			});
		});
	});

	function handleFiles(files) {
		for (let i = 0; i < files.length; i++) {
			const file = files[i];

			if (!file.type.startsWith('image/')) {
				continue
			}

			const img = document.createElement("img");
			img.classList.add("obj");
			img.file = file;
			preview.appendChild(img); // Assuming that "preview" is the div output where the content will be displayed.

			const reader = new FileReader();
			reader.onload = (function(aImg) {
				return function(e) {
					aImg.src = e.target.result;
				};
			})(img);
			reader.readAsDataURL(file);
		}
	}

	function checkOTP() {
		sendOTP().done(function(e) {
			console.log(e);
			$('#modal_otp').modal('show');
		});
	}

	function processKYC() {
		$.ajax({
			url: '<?= site_url('kyc_auth'); ?>',
			method: 'post',
			dataType: 'json',
			contentType: false,
			processData: false,
			data: formData,
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
					html: e.msg,
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Pengajuan KYC Berhasil...',
					html: e.msg,
					showConfirmButton: true,
					timer: 4000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.replace('<?= site_url('profile'); ?>');
				});
			}
		});
	}
</script>

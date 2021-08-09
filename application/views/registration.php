<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/login.css">
	<style>
		.login-box,
		.register-box {
			max-width: 750px !important;
		}

		@media (min-width: 768px) {

			.login-box,
			.register-box {
				min-width: 750px !important;
			}
		}
	</style>
</head>

<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo">
			<a href="javascript:void(0)"><b><?= APP_NAME; ?></b></a>
		</div>


		<div class="card">
			<div class="card-body register-card-body">
				<p class="login-box-msg">Pendaftaran Member Baru</p>
				<?php if ($arr->num_rows() != 0) { ?>
					<p class="login-box-msg">Reffered by:<br><?= $fullname; ?> <small>(<?= $email; ?>)</small></p>
				<?php } ?>

				<?php if ($arr->num_rows() == 0) { ?>
					<div class="alert alert-warning" role="alert">
						<h4 class="alert-heading">Referral Link Salah!</h4>
						<p>Pastikan Referral Link yang Anda dapatkan dari member yang telah terdaftar.</p>
						<hr>
						<p class="mb-0">Jika terjadi kendala, coba tanyakan Referral Link dari Calon Upline Kamu...</p>
					</div>
				<?php } else { ?>

					<form id="form_registration" action="<?= site_url(); ?>registration/<?= $this->uri->segment(2); ?>/<?= $this->uri->segment(3); ?>" method="post">
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="input-group mb-3">
									<input type="text" class="form-control <?= (form_error('fullname')) ? 'is-invalid' : '' ?>" id="fullname" name="fullname" placeholder="Nama Lengkap" value="<?= set_value('fullname'); ?>" minlength="3" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<label for="fullname" class="fas fa-user"></label>
										</div>
									</div>
									<div class="invalid-feedback">
										<?= form_error('fullname'); ?>
									</div>
								</div>

								<div class="input-group mb-3">
									<input type="tel" class="form-control <?= (form_error('phone_number')) ? 'is-invalid' : '' ?>" id="phone_number" name="phone_number" placeholder="No Telepon" value="<?= set_value('phone_number'); ?>" minlength="8" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<label for="phone_number" class="fas fa-phone"></label>
										</div>
									</div>
									<div class="invalid-feedback">
										<?= form_error('phone_number'); ?>
									</div>
								</div>

								<div class="input-group mb-3">
									<input type="number" class="form-control <?= (form_error('id_card_number')) ? 'is-invalid' : '' ?>" id="id_card_number" name="id_card_number" placeholder="No KTP" value="<?= set_value('id_card_number'); ?>" minlength="5" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<label for="id_card_number" class="fas fa-id-card"></label>
										</div>
									</div>
									<div class="invalid-feedback">
										<?= form_error('id_card_number'); ?>
									</div>
								</div>

							</div>
							<div class="col-sm-12 col-md-6">

								<div class="input-group mb-3">
									<input type="email" class="form-control lowercase <?= (form_error('email')) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="Email" autocomplete="email" value="<?= set_value('email'); ?>" minlength="5" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<label for="email" class="fas fa-envelope"></label>
										</div>
									</div>
									<div class="invalid-feedback">
										<?= form_error('email'); ?>
									</div>
								</div>
								<div class="input-group mb-3">
									<input type="password" class="form-control <?= (form_error('password')) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password" minlength="4" autocomplete="new-password" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<label for="password" class="fas fa-eye eye1"></label>
										</div>
									</div>
									<div class="invalid-feedback">
										<?= form_error('password'); ?>
									</div>
								</div>
								<div class="input-group mb-3">
									<input type="password" class="form-control <?= (form_error('verify_password')) ? 'is-invalid' : '' ?>" id="verify_password" name="verify_password" placeholder="Verifikasi Password" minlength="4" autocomplete="new-password" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<label for="verify_password" class="fas fa-eye eye2"></label>
										</div>
									</div>
									<div class="invalid-feedback">
										<?= form_error('verify_password'); ?>
									</div>
								</div>

								<div class="icheck-primary">
									<input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
									<label for="agreeTerms">
										Saya Setuju <u><a href="javascript:;" onclick="showModalTerm();">Syarat & Ketentuan</a></u>
									</label>
								</div>
								<input type="hidden" class="form-control" id="id_upline" name="id_upline" value="" readonly>
								<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
								<button type="submit" class="btn btn-primary btn-block mb-3">Daftar</button>
								<a href="<?= site_url('login'); ?>" class="text-center">Sudah menjadi Member?</a>

							</div>
						</div>

					</form>

				<?php } ?>

			</div>

		</div>

	</div>

	<div class="modal fade" id="term_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Term</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto sequi nemo voluptates
						nesciunt quis tempore dolor, repudiandae consequuntur nobis pariatur!</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>

<script>
	$(document).ready(function() {
		$('#form_add').on('submit', function(e) {
			let hcaptchaVal = $('[name=h-captcha-response]').val();
			if (hcaptchaVal === "") {
				event.preventDefault();
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Please complete the hCaptcha!'
				});
			}
		});

		$('.eye1').on('click', function() {
			let pass = document.getElementById("password");
			if (pass.type === "password") {
				$('.eye1').removeClass("fa-eye").addClass("fa-eye-slash");
				pass.type = "text";
			} else {
				$('.eye1').removeClass("fa-eye-slash").addClass("fa-eye");
				pass.type = "password";
			}
		});

		$('.eye2').on('click', function() {
			let pass = document.getElementById("verify_password");
			if (pass.type === "password") {
				$('.eye2').removeClass("fa-eye").addClass("fa-eye-slash");
				pass.type = "text";
			} else {
				$('.eye2').removeClass("fa-eye-slash").addClass("fa-eye");
				pass.type = "password";
			}
		});
	});

	function showModalTerm() {
		$('#term_modal').modal('show');
	}
</script>

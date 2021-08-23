<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Penarikan OTP</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Penarikan</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-md-6 offset-md-3">
				<form id="form_withdraw">
					<div class="card elevation-3">
						<div class="card-header">
							<h3 class="card-title">Penarikan OTP</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-sm mb-5">
									<tr>
										<th>Sumber</th>
										<th><?= ucfirst($source); ?></th>
									</tr>
									<tr>
										<th>Nominal Penarikan</th>
										<th><?= check_float($amount); ?> <small>USDT</small></th>
									</tr>
									<tr>
										<th>Ke Wallet Address</th>
										<th><small><?= $wallet_address; ?></small><br /><?= strtoupper($wallet_label); ?></th>
									</tr>
								</table>
							</div>
							<div class="form-group">
								<label for="otp">OTP</label>
								<input type="number" class="form-control mb-2" id="otp" name="otp" min="100000" max="999999" placeholder="000000" autofocus required>
								<span class="help-block"><small>Sistem telah mengirimkan kode OTP pada alamat email <kbd><?= $this->session->userdata(SESI . 'email'); ?></kbd></small></span>
							</div>
							<button type="button" class="btn btn-warning btn-sm btn-block elevation-2 mb-3" id="resend_button" onclick="resendOTP('<?= $this->session->userdata(SESI . 'email'); ?>');" disabled>
								Tidak menerima Kode OTP ?<br />
								Coba kirimkan kembali kode OTP<br />
								(Setelah <span id="time">01:00</span>)
							</button>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" id="submit_btn" class="btn btn-primary btn-block elevation-2">Verifikasi</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

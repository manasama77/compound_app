<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Transfer</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Transfer</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row mb-4">
			<div class="col-sm-12 col-md-4">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Profit Paid</span>
						<span class="info-box-number">
							<?= check_float($profit_paid); ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Bonus</span>
						<span class="info-box-number">
							<?= check_float($bonus); ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-purple elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">RATU</span>
						<span class="info-box-number">
							<?= check_float($ratu); ?>
							<small>RATU</small>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-sm-12 col-md-6 offset-md-3">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Form Transfer RATU Coin</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="wallet_address">Wallet Tujuan</label>
								<div class="input-group">
									<input type="text" class="form-control" id="wallet_address" name="wallet_address" minlength="48" maxlength="48" placeholder="Wallet Tujuan" required>
									<div class="input-group-append">
										<button type="button" id="scan" class="input-group-text bg-purple" data-qrr-target="#wallet_address"><i class="fas fa-qrcode fa-fw"></i> SCAN</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="amount_ratu">Jumlah</label>
								<div class="input-group">
									<input type="number" class="form-control" id="amount_ratu" name="amount_ratu" min="100" step="0.01" placeholder="Jumlah Transfer" required>
									<div class="input-group-append">
										<span class="input-group-text bg-purple">RATU</span>
									</div>
								</div>
								<span class="help-block text-muted">Minimal Transfer 100 RATU</span>
							</div>
							<div class="form-group">
								<label for="otp">OTP</label>
								<div class="input-group">
									<input type="text" class="form-control" id="otp" name="otp" minlength="6" maxlength="6" required disabled>
									<div class="input-group-append">
										<button id="btn_otp" type="button" class="btn btn-dark" onclick="kirimOTP();">Kirim OTP</button>
									</div>
								</div>
							</div>

							<div class="alert alert-warning p-1">
								<strong>Catatan:</strong><br />
								<ul class="p-3">
									<li>Setiap transaksi transfer akan dikenakan potongan <?= check_float($x_app->row()->potongan_transfer); ?>%</li>
									<li>Pastikan Wallet Address tujuan adalah untuk RATU Coin</li>
									<li>Pastikan Wallet Address yang Anda masukan Valid dan tidak salah dalam memasukan alamat</li>
									<li><?= APP_NAME; ?> tidak bertanggung jawab atas semua kesalahan input Anda baik dari Wallet Address yang tidak Valid atau salah kepemilikan Wallet Address</li>
								</ul>
							</div>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<input type="hidden" id="rate" name="rate" value="<?= $x_app->row()->rate_usdt_ratu; ?>" />
							<button id="btn_submit" type="submit" class="btn btn-primary btn-block" disabled>Kirim</button>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

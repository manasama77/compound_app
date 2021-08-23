<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Konversi</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Konversi</li>
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
						<h3 class="card-title">Form Konversi USDT/RATU</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="source">Sumber</label>
								<select class="form-control" id="source" name="source" required>
									<option value="profit_paid">Profit Paid</option>
									<option value="bonus">Bonus</option>
								</select>
							</div>
							<div class="form-group">
								<label for="amount_usdt">USDT / RATU</label>
								<div class="input-group">
									<input type="number" class="form-control" id="amount_usdt" name="amount_usdt" min="1" step="0.01" value="0" required>
									<div class="input-group-append">
										<span class="input-group-text bg-primary">USDT</span>
									</div>
									<input type="text" class="form-control" id="amount_ratu" name="amount_ratu" min="1" step="0.01" value="0" required readonly>
									<div class="input-group-append">
										<span class="input-group-text bg-purple">RATU</span>
									</div>
								</div>
								<span class="help-block text-muted">Rate USDT/RATU: <?= check_float($x_app->row()->rate_usdt_ratu); ?></span>
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
									<li>Setiap Transaksi Konversi akan dikenakan potongan <?= check_float($x_app->row()->potongan_swap); ?>%</li>
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

<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Penarikan</h1>
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

		<div class="row mb-4">
			<div class="col-12 col-sm-6 col-md-6">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Profit</span>
						<span class="info-box-number">
							<?= $profit; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-6">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Bonus</span>
						<span class="info-box-number">
							<?= $bonus; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-sm-12 col-md-6 offset-md-3">
				<form id="form_withdraw">
					<div class="card elevation-3">
						<div class="card-header">
							<h3 class="card-title">Penarikan</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="source">Sumber</label>
								<select class="form-control" id="source" name="source" required>
									<option value="profit">Profit</option>
									<option value="bonus">Bonus</option>
								</select>
							</div>
							<div class="form-group">
								<label for="amount">Nominal</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" id="amount" name="amount" step="0.00000001" min="<?= LIMIT_WITHDRAW; ?>" placeholder="Nominal" value="<?= set_value('amount'); ?>" required>
									<div class="input-group-append">
										<div class="input-group-text bg-primary">USDT</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="coin_type">Jenis Coin</label>
								<select class="form-control" id="coin_type" name="coin_type" required>
									<option value="" disabled selected>-Pilih Jenis Coin-</option>
									<option value="BNB.BSC">BNB.BEP20 - BSC</option>
									<option value="TRX">TRON</option>
									<option value="LTCT">Litecoin Testnet</option>
								</select>
							</div>
							<div class="form-group">
								<label for="estimation">Perkiraan Diterima</label>
								<input type="text" class="form-control" id="estimation" name="estimation" required readonly>
							</div>
							<div class="form-group">
								<label for="wallet_label">Wallet Label</label>
								<select class="form-control" id="wallet_label" name="wallet_label" required>
									<option value="" disabled selected>-Pilih Wallet Label-</option>
								</select>
							</div>
							<div class="form-group">
								<label for="wallet_address">Wallet Address</label>
								<select class="form-control" id="wallet_address" name="wallet_address" required>
									<option value="" disabled selected>-Pilih Wallet Address-</option>
								</select>
							</div>
							<div class="alert alert-warning p-1 elevation-1">
								<strong>Catatan:</strong><br />
								<ul class="p-3">
									<li>Binance BNB.BEP20 adalah Jenis Coin Binance yang berjalan di jaringan Binance Smart Chain (BSC). Jenis Coin ini berbeda dengan Binance BNB.BEP2 yang berjalan di jaringan Binance Chain (BC)</li>
									<li>Pastikan Wallet Address yang Anda masukan Valid dan tidak salah dalam memasukan alamat</li>
									<li>Pastikan juga Wallet Address dapat menerima jenis coin yang sama dan berada di jaringan yang sama. Jika tidak, pada saat proses Penarikan Coin yang dikirimkan akan terbakar dijaringan / kehilangan permanent</li>
									<li><?= APP_NAME; ?> tidak bertanggung jawab atas semua kesalahan input Anda baik dari Wallet Address yang tidak Valid atau salah kepemilikan Wallet Address</li>
								</ul>
							</div>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" class="btn btn-primary btn-block elevation-2">Penarikan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

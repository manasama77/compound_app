<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0"><?= $arr[0]['name']; ?></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('trade_manager/add'); ?>">List Paket Trade Manager</a></li>
					<li class="breadcrumb-item active">Pilih Paket Trade Manager</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-md-12">

				<form id="form_submit" class="form-horizontal" action="<?= site_url('trade_manager/checkout/coinpayment'); ?>" method="post">

					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Informasi Detail Paket</h3>

							<div class="card-tools">
								<a href="<?= site_url('trade_manager/add'); ?>" class="btn btn-dark btn-sm elevation-2">
									<i class="fas fa-chevron-left fa-fw"></i> Kembali ke List Paket Trade Manager
								</a>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="row">
								<div class="col-md-5">
									<p class="card-text">
									<ul>
										<li>
											Nilai Investasi: <span id="total_investment"><?= $arr[0]['amount']; ?></span> <small>USDT</small>
										</li>
										<li>
											Profit Per Bulan: <?= $arr[0]['profit_per_month_percent']; ?>% (<?= $arr[0]['profit_per_month_value']; ?> <small>USDT</small>)
										</li>
										<li>
											Profit Per Hari: <span id="profit_per_day_x"><?= $arr[0]['profit_per_day_percentage']; ?>% (<?= $arr[0]['profit_per_day_value']; ?> <small>USDT</small>)
										</li>
										<li>
											Masa Aktif: <?= $arr[0]['contract_duration']; ?> <small>Hari</small>
										</li>
										<li>
											Rasio Profit Sharing:
											<ul>
												<li>
													Member: <?= $arr[0]['share_self_percentage']; ?>% (<span id="self_share"><?= $arr[0]['share_self_value']; ?></span> <small>USDT</small>)
												</li>
												<li>
													Upline: <?= check_float($arr[0]['share_upline_percentage']); ?>% (<span id="upline_share"><?= $arr[0]['share_upline_value']; ?></span> <small>USDT</small>)
												</li>
												<li>
													Perusahaan: <?= $arr[0]['share_company_percentage']; ?>% (<span id="company_share"><?= $arr[0]['share_company_value']; ?></span> <small>USDT</small>) </li>
											</ul>
										</li>
									</ul>
									</p>
								</div>
								<div class="col-md-7 p-4">
									<div class="form-group row">
										<label for="id_wallet_admin" class="col-form-label col-md-4">Nilai Investasi<sup class="text-danger">*</sup></label>
										<div class="col-md-7">
											<div class="input-group">
												<?php
												$readonly = "";
												$min      = MIN_CROWN;
												$type     = "number";

												if (str_replace(UYAH, "", base64_decode($id_package_trade_manager)) != "6") {
													$readonly = "readonly";
													$min      = "1";
													$type     = "text";
												}
												?>
												<input type="<?= $type; ?>" class="form-control" id="total_transfer" name="total_transfer" value="<?= $arr[0]['amount']; ?>" required <?= $readonly; ?> min="<?= $min; ?>">
												<div class="input-group-append">
													<span class="input-group-text bg-primary">USDT</span>
												</div>
											</div>
											<?php if (str_replace(UYAH, "", base64_decode($id_package_trade_manager)) == "6") { ?>
												<small class="form-text text-muted">Minimum Total Investment <?= MIN_CROWN; ?> USDT</small>
											<?php } ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="coin_type" class="col-form-label col-md-4">Koin Pembayaran</label>
										<div class="col-sm-12 col-md-7">
											<select class="form-control" id="coin_type" name="coin_type" required>
												<option value="USDT.ERC20">Tether USD - ERC20 (USDT.ERC20)</option>
												<option value="LTCT">Lite Coin Test (LTCT)</option>
											</select>
										</div>
										<div class="col-12">
											<div class="alert alert-info mt-3">
												<strong>Pastikan pada saat melakukan transfer.<br />Jenis coin & Network (jaringan) coin yang digunakan sama</strong><br />Jika terjadi kesalahan pada saat pengiriman dikarenakan kesalahan jenis coin atau jaringan coin, <?= APP_NAME; ?> tidak bertanggung jawab atas kehilangan coin tersebut.
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-center">
							<input type="hidden" class="form-control" id="id_package_trade_manager" name="id_package_trade_manager" value="<?= $id_package_trade_manager; ?>">
							<input type="hidden" class="form-control" id="id_konfigurasi_trade_manager" name="id_konfigurasi_trade_manager" value="<?= $id_konfigurasi_trade_manager; ?>">
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button id="submit" type="submit" class="btn btn-primary btn-block btn-flat elevation-2">Checkout</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Trade Manager - Checkout</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('trade_manager'); ?>">Trade Manager</a></li>
					<li class="breadcrumb-item active">Checkout Trade Manager</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Informasi Pembayaran</h3>

						<div class="card-tools">
							<div class="btn-group">
								<a href="<?= site_url('trade_manager/add'); ?>" class="btn btn-secondary btn-sm">
									<i class="fas fa-chevron-left fa-fw"></i> Kembali ke List Join Paket
								</a>
								<a href="<?= site_url('trade_manager/index'); ?>" class="btn btn-dark btn-sm">
									<i class="fas fa-chevron-left fa-fw"></i> Kembali ke Paket Kamu
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<?php if ($state != "active") { ?>
							<div class="alert alert-warning" role="alert">
								Sistem otomatis melakukan check pembayaran setiap 30 detik...
							</div>
						<?php } ?>
						<?php if ($state == "waiting payment") { ?>
							<img src="<?= $arr->row()->qrcode_url; ?>" class="rounded mx-auto d-block" />
						<?php } ?>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td style="width: 200px;">Invoice</td>
										<td>:</td>
										<td class="text-left">
											<span id="state_badge"><?= $arr->row()->invoice; ?></span>
										</td>
									</tr>
									<tr>
										<td style="width: 200px;">Paket Trade Manager</td>
										<td>:</td>
										<td class="text-left">
											<span id="state_badge"><?= $arr->row()->package_name; ?> <small>(<?= $arr->row()->package_code; ?>)</small></span>
										</td>
									</tr>
									<tr>
										<td style="width: 200px;">Status Pembayaran</td>
										<td>:</td>
										<td class="text-left">
											<span id="state_badge"><?= $state_badge; ?></span>
										</td>
									</tr>
									<tr>
										<td>Total Transfer</td>
										<td>:</td>
										<td class="text-left font-weight-bold"><?= $arr->row()->amount_2; ?> <small><?= $arr->row()->currency2; ?></small></td>
									</tr>
									<tr>
										<td>Wallet Address Tujuan</td>
										<td>:</td>
										<td class="text-left font-weight-bold">
											<div class="input-group">
												<input type="text" class="form-control text-dark" id="receiver_wallet_address" value="<?= $arr->row()->receiver_wallet_address; ?>" readonly />
												<div class="input-group-append">
													<button type="button" class="btn btn-dark" id="copy" onclick="CopyUrl('receiver_wallet_address');">
														<i class="fas fa-clipboard fa-fw"></i> Copy
													</button>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>Total Diterima</td>
										<td>:</td>
										<td class="text-left">
											<span id="receivedf"></span> <span id="coin"><?= $arr->row()->receive_amount; ?> <small><?= $arr->row()->currency2; ?></small></span>
										</td>
									</tr>
									<tr>
										<td>Batas Waktu Transfer</td>
										<td>:</td>
										<td class="text-left font-weight-bold">
											<span id="time_left"></span>
										</td>
									</tr>
									<tr>
										<td>ID Pembayaran</td>
										<td>:</td>
										<td class="text-left"><code class="text-dark"><?= $arr->row()->txn_id; ?></code></td>
									</tr>
									<tr>
										<td colspan="3" class="text-center">
											<a href="<?= $arr->row()->checkout_url; ?>" target="_blank" class="btn btn-app bg-indigo elevation-1">
												<i class="fas fa-link"></i> Coinpayment Checkout
											</a>
											<a href="<?= $arr->row()->status_url; ?>" target="_blank" class="btn btn-app bg-indigo elevation-1">
												<i class="fas fa-link"></i> Coinpayment Status
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<?php if ($state != "active") { ?>
							<div class="row mt-5">
								<div class="col-sm-12 col-md-3">
									<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
										<a class="nav-link active" id="v-pills-q1-tab" data-toggle="pill" href="#v-pills-q1" role="tab">Apa yang harus dilakukan selanjutnya?</a>
										<a class="nav-link" id="v-pills-q2-tab" data-toggle="pill" href="#v-pills-q2" role="tab">Bagaimana jika nominal yang saya transfer kurang?</a>
									</div>
								</div>
								<div class="col-sm-12 col-md-9">
									<div class="tab-content bg-dark pl-1 pr-1 pt-3 pb-3" id="v-pills-tabContent">
										<div class="tab-pane fade show active" id="v-pills-q1" role="tabpanel">
											<ol>
												<li>
													Silahkan lakukan pembayaran Coin <mark><?= $arr->row()->amount_2; ?> <?= $arr->row()->currency2; ?></mark> Ke Wallet Address <mark><code class="text-dark"><?= $arr->row()->receiver_wallet_address; ?></code></mark>. <span class="text-danger">(Pastikan Nominal Pembayaran telah menutup biaya transfer / transaksi Coin!)</span> Kamu dapat melakukan pembayaran melalui Wallet Pribadi Kamu atau dari Wallet Exchanger. Selanjutnya Copy & Paste Wallet Address Tujuan dan Total Transfer di Wallet atau Exchanger. Kita akan mengirimkan Email kepada kamu ketika semua dana telah diterima dan diverifikasi. Jika kamu mengirimkan dana yang tidak terkonfirmasi sampai batas waktu atau tidak mengirimkan cukup coin, kamu akan otomatis menerima Email untuk mengklaim dana kamu dalam 8 Jam. Jika kamu tidak menerima email, silahkan hubungi team <a href="https://www.coinpayments.net/supwiz" target="_blank">CoinPayments.Net</a> dengan menginformasikan data seperti dibawah ini:
													<ul class="mb-3">
														<li>ID Transaksi: <mark><code class="text-dark"><?= $arr->row()->txn_id; ?></code></mark></li>
														<li>Wallet Address untuk mengirimkan Dana: <?= $arr->row()->receiver_wallet_address; ?></li>
													</ul>
												</li>
												<li>
													Setelah mentransfer pembayaran, review status pembayaran kamu <a href="<?= $arr->row()->status_url; ?>" target="_blank">dihalaman ini</a>. Setelah pembayaran dikonfirmasi di Blockchain, pembayaran telah selesai kita akan memberitahu Sistem CryptoPerty untuk mengaktifkan paket kamu. Proses konfirmasi biasanya memakan waktu 10~45 Menit tetapi bervariasi tergantung jenis coin yang digunakan atau jenis Block dan Jumlah Validator yang akan memvalidasi. Halaman Status Pembayaran di CoinPayments hanya tersedia untuk 30 Hari kedepan saja.
												</li>
											</ol>
										</div>
										<div class="tab-pane fade" id="v-pills-q2" role="tabpanel">
											Jika Nominal yang dikirimkan kurang, tenang. Kamu cukup kirimkan sisanya dan sistem otomatis akan menggabungkannya untuk kamu. Kamu juga dapat mengirimkan dari beberapa Wallet atau Akun di Exchanger selama belum melewati batas waktu transfer.
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

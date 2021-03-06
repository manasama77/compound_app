<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Trade Manager - Checkout</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Trade Manager</a></li>
					<li class="breadcrumb-item active">Add Trade Manager</li>
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
							<a href="<?= site_url('crypto_asset/add'); ?>" class="btn btn-dark btn-sm">
								<i class="fas fa-chevron-left fa-fw"></i> Kembali ke Paket
							</a>
						</div>
					</div>
					<div class="card-body">
						<?php if ($state != "active") { ?>
							<div class="alert alert-warning" role="alert">
								Sistem akan otomatis memeriksa status pembayaran setiap 30 Detik...
							</div>
						<?php } ?>
						<?php if ($state == "waiting payment") { ?>
							<img src="<?= $arr->row()->qrcode_url; ?>" class="rounded mx-auto d-block" />
						<?php } ?>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td>Status</td>
										<td>:</td>
										<td class="text-left">
											<span id="state_badge"><?= $state_badge; ?></span>
										</td>
									</tr>
									<tr>
										<td>Nominal Transfer</td>
										<td>:</td>
										<td class="text-left"><?= $arr->row()->amount_coin; ?> <?= $arr->row()->currency2; ?></td>
									</tr>
									<tr>
										<td>Kirim Ke Alamat</td>
										<td>:</td>
										<td class="text-left"><code class="text-dark"><?= $arr->row()->receiver_wallet_address; ?></code></td>
									</tr>
									<tr>
										<td>Jumlah Yang di terima</td>
										<td>:</td>
										<td class="text-left">
											<span id="receivedf"></span> <span id="coin"></span>
										</td>
									</tr>
									<tr>
										<td>Waktu Tersisa untuk Transfer</td>
										<td>:</td>
										<td class="text-left">
											<span id="time_left"></span>
										</td>
									</tr>
									<tr>
										<td>ID pembayaran</td>
										<td>:</td>
										<td class="text-left"><code class="text-dark"><?= $arr->row()->txn_id; ?></code></td>
									</tr>
									<tr>
										<td>Coinpayment Checkout Page</td>
										<td>:</td>
										<td class="text-left">
											<a href="<?= $arr->row()->checkout_url; ?>" target="_blank"><?= $arr->row()->checkout_url; ?></a>
										</td>
									</tr>
									<tr>
										<td>Coinpayment Status Page</td>
										<td>:</td>
										<td class="text-left">
											<a href="<?= $arr->row()->status_url; ?>" target="_blank"><?= $arr->row()->status_url; ?></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<?php if ($state != "active") { ?>
							<div class="row mt-5">
								<div class="col-sm-12 col-md-3">
									<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
										<a class="nav-link active" id="v-pills-q1-tab" data-toggle="pill" href="#v-pills-q1" role="tab">What to do Next?</a>
										<a class="nav-link" id="v-pills-q2-tab" data-toggle="pill" href="#v-pills-q2" role="tab">What if I accidentally don't send enough?</a>
									</div>
								</div>
								<div class="col-sm-12 col-md-9">
									<div class="tab-content bg-dark pl-1 pr-1 pt-3 pb-3" id="v-pills-tabContent">
										<div class="tab-pane fade show active" id="v-pills-q1" role="tabpanel">
											<ol>
												<li>
													Tolong Kirim <mark><?= $arr->row()->amount_coin; ?> <?= $arr->row()->currency2; ?></mark> Ke Alamat <mark><code class="text-dark"><?= $arr->row()->receiver_wallet_address; ?></code></mark>. <span class="text-danger">(Make sure to send enough to cover any coin transaction fees!)</span> You will need to initiate the payment using your software or online wallet and copy/paste the address and payment amount into it. We will email you when all funds have been received. If you send funds that don't confirm by the timeout or don't send enough coins you will receive an automatic email to claim your funds within 8 hours. If you don't receive the email contact us with the information below and CoinPayments.net will send you a refund:
													<ul class="mb-3">
														<li>The transaction ID: <mark><code class="text-dark"><?= $arr->row()->txn_id; ?></code></mark></li>
														<li>A payment address to send the funds to <?= $arr->row()->receiver_wallet_address; ?></li>
													</ul>
												</li>
												<li>
													Setelah mengirim pembayaran, tinjau status transaksi Anda <a href="<?= $arr->row()->status_url; ?>" target="_blank">on this page</a>. Once the payment is confirmed several times in the block chain, the payment will be completed and the merchant will be notified. The confirmation process usually takes 10-45 minutes but varies based on the coin's target block time and number of block confirms required. The status page is available for the next 30 days.
												</li>
											</ol>
										</div>
										<div class="tab-pane fade" id="v-pills-q2" role="tabpanel">
											If you don't send enough, that is OK. Just send the remainder and we will combine them for you. You can also send from multiple wallets/accounts.
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

					</div>
				</div>

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!--/. container-fluid -->
</section>

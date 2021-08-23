<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Catatan Crypto Asset - <?= $invoice; ?></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Catatan</a></li>
					<li class="breadcrumb-item active">Catatan Crypto Asset</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row mt-3 mb-3">
			<div class="col-12">
				<a href="<?= site_url('log/crypto_asset'); ?>" class="btn btn-dark btn-block elevation-2">
					<i class="fas fa-backward fa-fw"></i> Kembali ke List Invoice
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Catatan Package History</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="timeline">
							<?php
							foreach ($data_package_history as $key => $val) :
								$dt = new DateTime($key);
							?>
								<div class="time-label">
									<span class="bg-red"><?= $dt->format('M d, Y'); ?></span>
								</div>
								<?php
								foreach ($val as $key2) :
									$state = $key2['state'];
									$timex = $key2['created_at']->format('H:i');
									$description = $key2['description'];
									if ($state == "waiting payment") {
										$color = "bg-info";
										$icon  = "fa-hourglass-start";
										$text  = 'Menunggu Pembayaran';
									} elseif ($state == "pending") {
										$color = "bg-secondary";
										$icon  = "fa-hourglass-half";
										$text  = 'Pembayaran Sedang Diproses';
									} elseif ($state == "active") {
										$color = "bg-success";
										$icon  = "fa-check";
										$text  = 'Aktif';
									} elseif ($state == "cancel") {
										$color = "bg-warning";
										$icon  = "fa-times";
										$text  = 'Tidak Aktif';
									} elseif ($state == "inactive") {
										$color = "bg-dark";
										$icon  = "fa-times";
										$text  = 'Transaksi Dibatalkan';
									} elseif ($state == "expired") {
										$color = "bg-danger";
										$icon  = "fa-times";
										$text  = 'Pembayaran Melewati Batas Waktu';
									}
								?>
									<div>
										<i class="fas <?= $icon; ?> <?= $color; ?>"></i>
										<div class="timeline-item">
											<span class="<?= $color; ?> time"><i class="fas fa-clock"></i> <?= $timex; ?></span>
											<h3 class="timeline-header <?= $color; ?>"><?= ucwords($text); ?></h3>
											<div class="timeline-body">
												<p><?= $description; ?></p>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endforeach; ?>
							<div>
								<i class="fas fa-clock bg-gray"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Catatan Profit History</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="timeline">
							<?php
							foreach ($data_profit_history as $key => $val) :
								$dt = new DateTime($key);
							?>
								<div class="time-label">
									<span class="bg-red"><?= $dt->format('M d, Y'); ?></span>
								</div>
								<?php
								$color2 = "bg-success";
								$icon2  = "fa-check";
								foreach ($val as $key2) :
									$state = $key2['state'];
									$timex = $key2['created_at']->format('H:i:s');
									$description = $key2['description'];
									if ($state == "correction") {
										$color2 = "bg-warning";
										$icon2  = "fa-hourglass-half";
									}
								?>
									<div>
										<i class="fas <?= $icon2; ?> <?= $color2; ?>"></i>
										<div class="timeline-item">
											<span class="time <?= $color2; ?> "><i class="fas fa-clock"></i> <?= $timex; ?></span>
											<h3 class="timeline-header <?= $color2; ?>"><?= ucwords($state); ?></h3>
											<div class="timeline-body <?= $color2; ?>">
												<p><?= $description; ?></p>
												<p class="font-weight-bold">
													Nilai Investasi: <?= $key2['amount']; ?><br />
													Profit Perhari: <?= $key2['profit']; ?> <small>USDT</small> (<?= $key2['persentase']; ?>%)<br />
												</p>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endforeach; ?>
							<div>
								<i class="fas fa-clock bg-gray"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-12">
				<a href="<?= site_url('log/crypto_asset'); ?>" class="btn btn-warning btn-block elevation-2">Back to List Invoice</a>
			</div>
		</div>
	</div>
</section>

<a id="back-to-top" href="#" class="btn btn-primary back-to-top mb-4" role="button" aria-label="Scroll to top">
	<i class="fas fa-chevron-up"></i>
</a>

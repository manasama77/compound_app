<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Catatan Penarikan</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Catatan Penarikan</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Catatan Penarikan</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_data" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th class="text-center align-middle" style="min-width: 120px;">Tanggal</th>
										<th class="align-middle">Invoice</th>
										<th class="text-right align-middle" style="min-width: 120px;">Dari Coin</th>
										<th class="text-right align-middle" style="min-width: 120px;">Ke Coin</th>
										<th class="text-center align-middle" style="min-width: 70px;">Sumber</th>
										<th class="align-middle">Wallet</th>
										<th class="text-center align-middle">Status</th>
										<th class="align-middle">TXID</th>
									</tr>
								</thead>
								<tbody>

									<?php if ($arr->num_rows() > 0) : ?>
										<?php foreach ($arr->result() as $key) : ?>

											<tr>
												<td class="text-center align-middle">
													<?= $key->created_at; ?>
												</td>
												<td class="align-middle">
													<?= $key->invoice; ?>
												</td>
												<td class="text-right align-middle">
													<?= check_float($key->amount_1); ?> <small><?= $key->currency_1; ?></small>
												</td>
												<td class="text-right align-middle">
													<?= check_float($key->amount_2); ?> <small><?= $key->currency_2; ?></small>
												</td>
												<td class="text-center align-middle">
													<?php
													if ($key->source == "profit_paid") {
														echo "PROFIT PAID";
													} else {
														echo "BONUS";
													}
													?>
												</td>
												<td class="align-middle">
													<small><?= $key->wallet_address; ?></small>
												</td>
												<td class="text-center align-middle">
													<?= strtoupper($key->state); ?>
												</td>
												<td class="align-middle">
													<small><?= $key->tx_id; ?></small>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="8" class="text-center text-danger">- Kamu tidak Catatan Penarikan -</td>
										</tr>

									<?php endif; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

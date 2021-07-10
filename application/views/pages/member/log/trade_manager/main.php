<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Log Trade Manager</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Log</a></li>
					<li class="breadcrumb-item active">Trade Manager</li>
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
						<h3 class="card-title">Log Trade Manager</h3>

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
										<th class="text-center align-middle" style="min-width: 100px;">Date</th>
										<th class="align-middle">Invoice</th>
										<th class="text-right align-middle" style="min-width: 130px;">Amount Invest</th>
										<th class="text-right align-middle" style="min-width: 130px;">Amount Transfer</th>
										<th class="text-center align-middle">Status</th>
										<th class="align-middle" style="min-width: 500px;">Description</th>
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
													<?= number_format($key->amount_invest, 8); ?> <small>USDT</small>
												</td>
												<td class="text-right align-middle">
													<?= number_format($key->amount_transfer, 8); ?> <small><?= $key->currency_transfer; ?></small>
												</td>
												<td class="text-center align-middle">
													<?= strtoupper($key->state); ?>
												</td>
												<td class="align-middle">
													<small><?= $key->description; ?></small>
												</td>
												<td class="align-middle">
													<small><?= $key->txn_id; ?></small>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="7" class="text-center text-danger">- You Don't Have Any History Withdraw -</td>
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
<!-- /.Main Content -->

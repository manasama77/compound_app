<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">List Crypto Asset</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Crypto Asset</a></li>
					<li class="breadcrumb-item active">List Crypto Asset</li>
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
						<h3 class="card-title">List Crypto Asset</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_data" class="table">
								<thead>
									<tr>
										<th class="align-middle">Invoice</th>
										<th class="align-middle">Package</th>
										<th class="align-middle">Investment</th>
										<th class="align-middle">Profit/Day</th>
										<th class="text-center align-middle">Register Date</th>
										<th class="text-center align-middle">Expired Date</th>
										<th class="text-center align-middle">Total Profit Asset</th>
										<th class="text-center align-middle">Status</th>
										<th class="align-middle text-center"><i class="fas fa-cogs"></i></th>
									</tr>
								</thead>
								<tbody>

									<?php if (count($data_crypto_asset) > 0) : ?>
										<?php
										foreach ($data_crypto_asset as $key) :
										?>

											<tr>
												<td class="align-middle">
													<?= $key['invoice']; ?>
												</td>
												<td class="align-middle">
													<?= $key['package']; ?>
												</td>
												<td class="align-middle">
													<?= $key['amount']; ?> <small>USDT</small>
												</td>
												<td class="align-middle">
													<?= $key['profit_per_day']; ?> <small>USDT</small>
												</td>
												<td class="align-middle text-center">
													<?= $key['created_at']; ?>
												</td>
												<td class="align-middle text-center">
													<?php
													if (in_array($key['state'], ['active', 'inactive', 'expired'])) {
														echo $key['expired_at'] . " 00:00:00";
													} else {
														echo "-";
													}
													?>
												</td>
												<td class="align-middle">
													<?= $key['profit_asset']; ?> <small>USDT</small>
												</td>
												<td class="text-center align-middle">
													<?php
													$state = $key['state'];
													if ($state == "waiting payment") {
														$badge_color = 'info';
													} elseif ($state == "pending") {
														$badge_color = 'secondary';
													} elseif ($state == "active") {
														$badge_color = 'success';
													} elseif ($state == "inactive") {
														$badge_color = 'dark';
													} elseif ($state == "cancel") {
														$badge_color = 'warning';
													} elseif ($state == "expired") {
														$badge_color = 'danger';
													}
													?>
													<span class="badge badge-<?= $badge_color; ?>">
														<?= STRTOUPPER($key['state']); ?>
													</span>
												</td>
												<td class="text-center align-middle">
													<div class="btn-group" role="group">

														<div class="btn-group" role="group">
															<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
																Actions
															</button>
															<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
																<button class="dropdown-item" onclick="showDetail('<?= $key['invoice']; ?>');">
																	<i class="fas fa-eye fa-fw"></i> Detail
																</button>
																<?php if ($key['state'] == "waiting payment" || $key['state'] == "pending") { ?>
																	<hr />
																	<a href="<?= site_url('crypto_asset/checkout/' . base64_encode(UYAH . $key['invoice'])); ?>" class="dropdown-item">
																		<i class="fas fa-coins fa-fw"></i> Payment Info
																	</a>
																<?php } ?>
															</div>
														</div>
													</div>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="9" class="text-center text-danger">- You Don't Have Any Package, why not try to add new one? -</td>
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

<div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail - <span id="package"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Amount</th>
								<th>:</th>
								<th id="amount"></th>
							</tr>
							<tr>
								<th>Subscription At</th>
								<th>:</th>
								<th id="created_at"></th>
							</tr>
							<tr>
								<th class="align-top">Payment</th>
								<th class="align-top">:</th>
								<th class="align-top" id="payment"></th>
							</tr>
							<tr>
								<th>Expired At</th>
								<th>:</th>
								<th id="expired_at"></th>
							</tr>
							<tr>
								<th>Status</th>
								<th>:</th>
								<th id="state"></th>
							</tr>
							<tr>
								<th>Profit Monthly</th>
								<th>:</th>
								<th id="profit_monthly"></th>
							</tr>
							<tr>
								<th>Profit Daily</th>
								<th>:</th>
								<th id="profit_daily"></th>
							</tr>
							<tr>
								<th>Total Profit Asset</th>
								<th>:</th>
								<th id="profit_asset"></th>
							</tr>
							<tr>
								<th class="align-top">Profit Sharing Rules</th>
								<th class="align-top">:</th>
								<th class="align-top">
									<table class="table table-sm">
										<thead>
											<tr>
												<th class="align-middle">Self</th>
												<th class="align-middle">:</th>
												<th class="align-middle" id="profit_self"></th>
											</tr>
											<tr>
												<th class="align-middle">Upline</th>
												<th class="align-middle">:</th>
												<th class="align-middle" id="profit_upline"></th>
											</tr>
											<tr>
												<th class="align-middle">Company</th>
												<th class="align-middle">:</th>
												<th class="align-middle" id="profit_company"></th>
											</tr>
										</thead>
									</table>
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<form id="form_extend">
	<div class="modal fade" id="modal_extend" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Change Extend Mode - <span id="package_extend"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="invoice_extend">Invoice</label>
						<input type="text" class="form-control-plaintext" id="invoice_extend" name="invoice_extend" required readonly>
					</div>
					<div class="form-group">
						<label for="is_extend_mode">Extend Mode</label>
						<select class="form-control" id="is_extend_mode" name="is_extend_mode" required>
							<option value="auto">Auto</option>
							<option value="manual">Manual</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>

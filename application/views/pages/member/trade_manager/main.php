<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Paket Trade Manager Kamu</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Paket Trade Manager Kamu</li>
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
						<h3 class="card-title">List Paket Trade Manager Kamu</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<?php
							$tooltip_text = "<h5>Mode Perpanjangan</h5><br/><b>Otomatis Perpanjang</b> = Otomatis perpanjang masa aktif paket setelah melewati tanggal kedaluwarsa<br/><b>Manual Perpanjang</b> = Berhenti berlangganan paket setelah melewati tanggal kedaluwarsa paket. Setelah itu sistem akan otomatis memindahkan nilai investasi awal kamu ke dompet profit";
							?>
							<table id="table_data" class="table table-bordered">
								<thead class="bg-dark">
									<tr>
										<th class="text-center align-middle" style="min-width: 120px;">Tanggal Registrasi</th>
										<th class="align-middle" style="min-width: 80px;">Paket</th>
										<th class="text-center align-middle">Status</th>
										<th class="text-right align-middle" style="min-width: 130px;">Nilai Investasi <small>(USDT)</small></th>
										<th class="text-right align-middle" style="min-width: 100px;">Profit Per Bulan <small>(USDT)</small></th>
										<th class="text-right align-middle" style="min-width: 100px;">Profit Per Hari <small>(USDT)</small></th>
										<th class="text-right align-middle" style="min-width: 130px;">Profit Share Member Per Hari <small>(USDT)</small></th>
										<th class="text-center align-middle" style="min-width: 120px;">Tanggal Kedaluwarsa</th>
										<th class="text-center align-middle" style="min-width: 120px;">
											Mode Perpanjangan
										</th>
										<th class="text-center align-middle"><i class="fas fa-cogs"></i></th>
									</tr>
								</thead>
								<tbody>

									<?php if (count($data_trade_manager) > 0) : ?>
										<?php
										foreach ($data_trade_manager as $key) :
										?>

											<tr>
												<td class="align-middle">
													<?= $key['created_at']; ?>
												</td>
												<td class="align-middle">
													<?= $key['package_name']; ?>
												</td>
												<td class="text-center align-middle">
													<?= $key['state_badge']; ?>
												</td>
												<td class="text-right align-middle">
													<?= $key['amount_1']; ?>
												</td>
												<td class="text-right align-middle">
													<?= $key['profit_per_month_value']; ?>
												</td>
												<td class="text-right align-middle">
													<?= $key['profit_per_day_value']; ?>
												</td>
												<td class="text-right align-middle">
													<?= $key['share_self_value']; ?>
												</td>
												<td class="align-middle text-center">
													<?php
													if (in_array($key['state'], ['active', 'inactive', 'expired'])) {
														echo $key['expired_package'] . " 00:00:00";
													} else {
														echo "-";
													}
													?>
												</td>
												<td class="align-middle text-center">
													<?php
													$is_extend = $key['is_extend'];
													if ($is_extend == "auto") {
														$badge_color = 'primary';
													} elseif ($is_extend == "manual") {
														$badge_color = 'danger';
													}
													?>

													<?php
													if (in_array($key['state'], ['active', 'inactive', 'expired'])) {
													?>
														<span class="badge badge-<?= $badge_color; ?>">
															<?= STRTOUPPER($key['is_extend']); ?>
														</span>
													<?php
													} else {
														echo "-";
													}
													?>
												</td>
												<td class="text-center align-middle">
													<div class="btn-group" role="group">

														<div class="btn-group" role="group">
															<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
																Actions
															</button>
															<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
																<button class="dropdown-item" onclick="showDetail('<?= $key['invoice']; ?>');">
																	<i class="fas fa-eye fa-fw"></i> Detail
																</button>
																<?php if ($key['state'] == "active") { ?>
																	<hr />
																	<button class="dropdown-item" onclick="showExtend('<?= $key['invoice']; ?>', '<?= $key['package_name']; ?>', '<?= $key['is_extend']; ?>');">
																		<i class="fas fa-business-time fa-fw"></i> Ganti Mode Perpanjangan
																	</button>
																<?php } ?>
																<?php if ($key['state'] == "waiting payment" || $key['state'] == "pending") { ?>
																	<hr />
																	<a href="<?= site_url('trade_manager/checkout/' . base64_encode(UYAH . $key['invoice'])); ?>" class="dropdown-item">
																		<i class="fas fa-coins fa-fw"></i> Informasi Pembayaran
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
											<td colspan="10" class="text-center text-danger">- Anda Tidak Memiliki Paket, mengapa tidak mencoba menambahkan yang baru? -</td>
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
								<th>Investasi</th>
								<th>:</th>
								<th id="amount"></th>
							</tr>
							<tr>
								<th>Tanggal Registrasi</th>
								<th>:</th>
								<th id="created_at"></th>
							</tr>
							<tr>
								<th class="align-top">Pembayaran</th>
								<th class="align-top">:</th>
								<th class="align-top" id="payment"></th>
							</tr>
							<tr>
								<th>Tanggal Kedaluwarsa</th>
								<th>:</th>
								<th id="expired_at"></th>
							</tr>
							<tr>
								<th>Status</th>
								<th>:</th>
								<th id="state"></th>
							</tr>
							<tr>
								<th>Mode Perpanjangan</th>
								<th>:</th>
								<th id="is_extend"></th>
							</tr>
							<tr>
								<th>Profit Bulanan</th>
								<th>:</th>
								<th id="profit_monthly"></th>
							</tr>
							<tr>
								<th>Profit Harian</th>
								<th>:</th>
								<th id="profit_daily"></th>
							</tr>
							<tr>
								<th class="align-top">Rasio Profit Sharing</th>
								<th class="align-top">:</th>
								<th class="align-top">
									<table class="table table-sm">
										<thead>
											<tr>
												<th class="align-middle">Member</th>
												<th class="align-middle">:</th>
												<th class="align-middle" id="profit_self"></th>
											</tr>
											<tr>
												<th class="align-middle">Upline</th>
												<th class="align-middle">:</th>
												<th class="align-middle" id="profit_upline"></th>
											</tr>
											<tr>
												<th class="align-middle">Perusahaan</th>
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
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<form id="form_extend">
	<div class="modal fade" id="modal_extend" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Ganti Mode Perpanjangan - <span id="package_extend"></span></h5>
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
						<label for="is_extend_mode">Mode Perpanjangan</label>
						<select class="form-control" id="is_extend_mode" name="is_extend_mode" required>
							<option value="auto">Otomatis</option>
							<option value="manual">Manual</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</div>
		</div>
	</div>
</form>

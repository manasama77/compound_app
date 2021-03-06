<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-12">
				<h1 class="m-0">Beranda</h1>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-info elevation-1">
						<i class="fas fa-coins"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Total Omzet</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['downline_omset']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-danger elevation-1">
						<a href="<?= site_url('downline'); ?>"><i class="fas fa-users"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Downline</span>
						<span class="info-box-number"><?= $data_card['count_all_downline']; ?></span>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1">
						<a href="<?= site_url('trade_manager/index'); ?>"><i class="fas fa-coins"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Trade Manager</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['total_invest_trade_manager']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1">
						<a href="<?= site_url('crypto_asset/index'); ?>"><i class="fas fa-coins"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Crypto Asset</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['total_invest_crypto_asset']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>

			<div class="clearfix hidden-md-up"></div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1">
						<a href="<?= site_url('log/profit_trade_manager'); ?>"><i class="fas fa-coins"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Profit Paid</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['profit_paid']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-secondary elevation-1">
						<a href="<?= site_url('log/profit_trade_manager'); ?>"><i class="fas fa-coins"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Profit Unpaid</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['profit_unpaid']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-dark elevation-1">
						<a href="<?= site_url('log/bonus_recruitment'); ?>"><i class="fas fa-coins"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Bonus</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['bonus']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-purple elevation-1">
						<a href="#" onclick="comingSoon();"><i class="fas fa-coins"></i></a>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Ratu Wallet</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['ratu']; ?>
							<small>RATU</small>
						</span>
					</div>
				</div>
			</div>
		</div>

		<?php if ($data_card['data_balance']['total_invest_trade_manager'] > 0 || $data_card['data_balance']['total_invest_crypto_asset'] > 0) { ?>
			<div class="row">
				<div class="col-12">
					<div class="card bg-navy">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-link"></i> Referral Link</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="input-group">
								<input type="text" class="form-control bg-info" id="recruitment_link" value="<?= $recruitment_link; ?>" readonly />
								<div class="input-group-append">
									<button type="button" class="btn btn-dark" id="copy" onclick="CopyUrl('recruitment_link');">
										<i class="fas fa-clipboard fa-fw"></i> Copy
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="row">
			<div class="col-12">
				<div class="card bg-indigo">
					<div class="card-header">
						<h3 class="card-title"><i class="fas fa-link"></i> RATU Wallet Address</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="input-group">
							<input type="text" class="form-control bg-purple" id="ratu_wallet" value="<?= $ratu_wallet; ?>" readonly />
							<div class="input-group-append">
								<button type="button" class="btn bg-dark" id="copy" onclick="CopyUrl('ratu_wallet');">
									<i class="fas fa-clipboard fa-fw"></i> Copy
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-md-12">

				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><i class="fas fa-users"></i> Member Terbaru</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-bordered table-sm">
								<thead>
									<tr>
										<th class="text-center align-middle"><i class="fas fa-image"></i></th>
										<th class="align-middle">User ID</th>
										<th class="align-middle">Nama Lengkap</th>
										<th class="align-middle" style="width: 200px;">Upline</th>
										<th class="text-center align-middle">Generasi</th>
										<th class="text-right align-middle">Total Omzet</th>
										<th class="text-right align-middle">Total Downline</th>
										<th class="text-center align-middle">
											<i class="fas fa-cog"></i>
										</th>
									</tr>
								</thead>
								<tbody>

									<?php if (count($data_latest_downline) > 0) : ?>
										<?php
										$itteration = 1;
										foreach ($data_latest_downline as $key) :
										?>
											<tr>
												<td class="text-center align-middle">
													<img src="<?= $key['profile_picture']; ?>" alt="Profile Picture" class="img-size-50">
												</td>
												<td class="align-middle">
													<?= $key['user_id']; ?>
												</td>
												<td class="align-middle">
													<?= $key['fullname']; ?>
												</td>
												<td class="align-middle">
													<?= $key['user_id_upline']; ?>
												</td>
												<td class="text-center align-middle">
													<span class="badge badge-primary">
														<i class="fas fa-sun"></i> <?= $key['generation']; ?>
													</span>
												</td>
												<td class="text-right align-middle">
													<?= $key['total_omset']; ?>
												</td>
												<td class="text-right align-middle">
													<?= $key['total_downline']; ?>
												</td>
												<td class="text-center align-middle">
													<button type="button" class="btn btn-info btn-xs" onclick="showModalDownline('<?= $key['id']; ?>', '<?= $key['fullname']; ?>')">
														<i class="fas fa-eye fa-fw"></i> Detail
													</button>
												</td>
											</tr>

										<?php
											$itteration++;
										endforeach;
										?>
									<?php else : ?>

										<tr>
											<td colspan="8" class="text-center text-danger">- Kamu belum memiliki Downline -</td>
										</tr>

									<?php endif; ?>

								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer text-center">
						<?php if ($data_card['count_all_downline'] > 10) : ?>
							<a href="<?= site_url('downline'); ?>" class="uppercase">Selanjutnya...</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Member <span id="name_downline"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Trade Manager</h4>
				<div class="table-resonsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Paket</th>
								<th class="align-middle text-right">Nilai Investasi</th>
								<th class="align-middle text-center">Durasi</th>
								<th class="align-middle text-center">Status</th>
							</tr>
						</thead>
						<tbody id="v_trade_manager">
							<tr>
								<td colspan="4" class="text-center align-middle">-Tidak Ada Paket Aktif-</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h4>Crypto Asset</h4>
				<div class="table-resonsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Paket</th>
								<th class="align-middle text-right">Nilai Investasi</th>
								<th class="align-middle text-center">Durasi</th>
								<th class="align-middle text-center">Status</th>
							</tr>
						</thead>
						<tbody id="v_crypto_asset">
							<tr>
								<td colspan="4" class="text-center align-middle">-Tidak Ada Paket Aktif-</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h4 class="mt-3">Downline</h4>
				<div class="table-responsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">User ID</th>
								<th class="align-middle">Nama Lengkap</th>
								<th class="align-middle">Upline</th>
								<th class="align-middle text-center">Generasi</th>
								<th class="align-middle text-right">Total Omzet</th>
								<th class="align-middle text-right">Total Downline</th>
							</tr>
						</thead>
						<tbody id="v_downline">
							<tr>
								<td colspan="6" class="text-center align-middle">-Tidak ada data Downline-</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

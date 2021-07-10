<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Dashboard</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-info elevation-1">
						<i class="fas fa-coins"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Total Turnover</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['total_omset']; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-danger elevation-1">
						<i class="fas fa-users"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Members</span>
						<span class="info-box-number"><?= $data_card['count_all_downline']; ?></span>
					</div>
				</div>
			</div>

			<div class="clearfix hidden-md-up"></div>

			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1">
						<i class="fas fa-coins"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Trade Managers</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['total_invest_trade_manager']; ?>
							<small>USDT</small></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1">
						<i class="fas fa-coins"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Crypto Assets</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['total_invest_crypto_asset']; ?>
							<small>USDT</small></span>
					</div>
				</div>
			</div>

			<div class="clearfix hidden-md-up"></div>

			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-dark elevation-1">
						<i class="fas fa-coins"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Profit</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['profit']; ?>
							<small>USDT</small></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-dark elevation-1">
						<i class="fas fa-coins"></i>
					</span>

					<div class="info-box-content">
						<span class="info-box-text">Bonus</span>
						<span class="info-box-number">
							<?= $data_card['data_balance']['bonus']; ?>
							<small>USDT</small></span>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Recruitment Link</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="input-group">
							<input type="text" class="form-control" id="recruitment_link" value="<?= $recruitment_link; ?>" readonly />
							<div class="input-group-append">
								<button type="button" class="btn btn-dark" id="copy" onclick="CopyUrl();">
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
						<h3 class="card-title">Latest Member</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-sm">
								<thead>
									<tr>
										<th class="align-middle">Picture</th>
										<th class="align-middle">Fullname</th>
										<th class="align-middle">Email</th>
										<th class="align-middle">Phone Number</th>
										<th class="text-center align-middle" style="width: 200px;">Upline</th>
										<th class="text-center align-middle">Generation</th>
										<th class="text-center align-middle">Total Turnover</th>
										<th class="text-center align-middle">Total Downline</th>
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
												<td class="align-middle">
													<img src="<?= $key['profile_picture']; ?>" alt="Profile Picture" class="img-size-50">
												</td>
												<td class="align-middle">
													<?= $key['fullname']; ?>
												</td>
												<td class="align-middle">
													<?= $key['email']; ?>
												</td>
												<td class="align-middle">
													<?= $key['phone_number']; ?>
												</td>
												<td class="align-middle text-center">
													<?= $key['fullname_upline']; ?> <br />(<?= $key['email_upline']; ?>)
												</td>
												<td class="text-center align-middle">
													<span class="badge badge-primary">
														<i class="fas fa-sun"></i> <?= $key['generation']; ?>
													</span>
												</td>
												<td class="text-center align-middle">
													<?= $key['total_omset']; ?> USDT
												</td>
												<td class="text-center align-middle">
													<?= $key['total_downline']; ?> Member
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
											<td colspan="8" class="text-center text-danger">- You Don't Have Any Friend On Your Circle -</td>
										</tr>

									<?php endif; ?>

								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer text-center">
						<?php if ($data_card['count_all_downline'] > 10) : ?>
							<a href="<?= site_url('member'); ?>" class="uppercase">View More...</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.Main Content -->

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Member - <span id="name_downline"></span></h5>
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
								<th class="align-middle">Package</th>
								<th class="align-middle">Amount</th>
								<th class="align-middle">Profit /Day</th>
								<th class="align-middle">Duration</th>
								<th class="align-middle">Status</th>
							</tr>
						</thead>
						<tbody id="v_trade_manager">
							<tr>
								<td colspan="5" class="text-center align-middle">-No Package Active-</td>
							</tr>
						</tbody>
					</table>
				</div>
				<h4 class="mt-3">Downline</h4>
				<div class="table-resonsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Fullname</th>
								<th class="align-middle">Email</th>
								<th class="align-middle">Phone Number</th>
								<th class="align-middle">Upline</th>
								<th class="align-middle">Generation</th>
								<th class="align-middle">Total Turnover</th>
								<th class="align-middle">Total Downline</th>
							</tr>
						</thead>
						<tbody id="v_downline">
							<tr>
								<td colspan="7" class="text-center align-middle">-No Downline Data-</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

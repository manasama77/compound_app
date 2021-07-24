<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Rewards</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Rewards</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-12 col-sm-6 col-md-8">
				<div class="info-box">
					<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text font-weight-bold">
							Main Line Total Turnover<br /><small><?= $downline_main_line; ?></small>
						</span>
						<span class="info-box-number">
							<?= $omset_main_line; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text font-weight-bold">Other Line Total Turnover</span>
						<span class="info-box-number">
							<?= $omset_other_line; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<!-- LAPTOP -->
			<div class="col-sm-12 col-md-4">

				<div class="card" style="min-height: 500px;">
					<img src="<?= base_url('public/img/rewards/photo_2021-07-02_19-20-45.jpg'); ?>" class="card-img-top img-fluid" alt="Laptop" style="height: 200px;">
					<div class="card-body">
						<h4 class="text-center mb-3">
							Laptop<br />
							<?php if ($arr->row()->reward_1 == "no") { ?>
								<span class="badge badge-dark">On Going</span>
							<?php } elseif ($arr->row()->reward_1 == "yes" && $arr->row()->reward_1_done == "no") { ?>
								<span class="badge badge-success">
									Target Achieved<br />
									<small><?= $arr->row()->reward_1_date; ?></small>
								</span>
							<?php } elseif ($arr->row()->reward_1 == "yes" && $arr->row()->reward_1_done == "yes") { ?>
								<span class="badge badge-primary">
									Has Been Obtained<br />
									<small><?= $arr->row()->reward_1_date; ?></small>
								</span>
							<?php } ?>
						</h4>
						<table class="table table-sm">
							<tbody>
								<tr>
									<th class="table-dark">Price:</th>
									<th class="text-right table-dark">±700 USDT</th>
								</tr>
								<tr>
									<th colspan="2" class="text-center table-success">Target to Claim</th>
								</tr>
								<tr>
									<th class="table-success">Main Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_1, 0); ?> USDT</th>
								</tr>
								<tr>
									<th class="table-success">Other Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_1, 0); ?> USDT</th>
								</tr>
							</tbody>
							<?php if ($arr->row()->reward_1 == "yes" && $arr->row()->reward_1_done == "no") { ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-center">
											<button type="button" class="btn btn-success btn-block btn-flat">Claim Now!</button>
										</th>
									</tr>
								</tfoot>
							<?php } ?>
						</table>
					</div>
				</div>

			</div>

			<!-- HONDA PCX -->
			<div class="col-sm-12 col-md-4">

				<div class="card" style="min-height: 500px;">
					<img src="<?= base_url('public/img/rewards/photo_2021-07-02_19-21-41.jpg'); ?>" class="card-img-top img-fluid" alt="Honda PCX" style="height: 200px;">
					<div class="card-body">
						<h4 class="text-center mb-3">
							Honda PCX<br />
							<?php if ($arr->row()->reward_2 == "no") { ?>
								<span class="badge badge-dark">On Going</span>
							<?php } elseif ($arr->row()->reward_2 == "yes" && $arr->row()->reward_2_done == "no") { ?>
								<span class="badge badge-success">
									Target Achieved<br />
									<small><?= $arr->row()->reward_2_date; ?></small>
								</span>
							<?php } elseif ($arr->row()->reward_2 == "yes" && $arr->row()->reward_2_done == "yes") { ?>
								<span class="badge badge-primary">
									Has Been Obtained<br />
									<small><?= $arr->row()->reward_2_date; ?></small>
								</span>
							<?php } ?>
						</h4>
						<table class="table table-sm">
							<tbody>
								<tr>
									<th class="table-dark">Price:</th>
									<th class="text-right table-dark">±2,100 USDT</th>
								</tr>
								<tr>
									<th colspan="2" class="text-center table-success">Target to Claim</th>
								</tr>
								<tr>
									<th class="table-success">Main Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_2, 0); ?> USDT</th>
								</tr>
								<tr>
									<th class="table-success">Other Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_2, 0); ?> USDT</th>
								</tr>
							</tbody>
							<?php if ($arr->row()->reward_2 == "yes" && $arr->row()->reward_2_done == "no") { ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-center">
											<button type="button" class="btn btn-success btn-block btn-flat">Claim Now!</button>
										</th>
									</tr>
								</tfoot>
							<?php } ?>
						</table>
					</div>
				</div>

			</div>

			<!-- LIVINA ALL NEW -->
			<div class="col-sm-12 col-md-4">

				<div class="card" style="min-height: 500px;">
					<img src="<?= base_url('public/img/rewards/photo_2021-07-02_19-22-05.jpg'); ?>" class="card-img-top img-fluid" alt="Livina All New" style="height: 200px;">
					<div class="card-body">
						<h4 class="text-center mb-3">
							Livina All New<br />
							<?php if ($arr->row()->reward_3 == "no") { ?>
								<span class="badge badge-dark">On Going</span>
							<?php } elseif ($arr->row()->reward_3 == "yes" && $arr->row()->reward_3_done == "no") { ?>
								<span class="badge badge-success">
									Target Achieved<br />
									<small><?= $arr->row()->reward_3_date; ?></small>
								</span>
							<?php } elseif ($arr->row()->reward_3 == "yes" && $arr->row()->reward_3_done == "yes") { ?>
								<span class="badge badge-primary">
									Has Been Obtained<br />
									<small><?= $arr->row()->reward_3_date; ?></small>
								</span>
							<?php } ?>
						</h4>
						<table class="table table-sm">
							<tbody>
								<tr>
									<th class="table-dark">Price:</th>
									<th class="text-right table-dark">±17,250 USDT</th>
								</tr>
								<tr>
									<th colspan="2" class="text-center table-success">Target to Claim</th>
								</tr>
								<tr>
									<th class="table-success">Main Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_3, 0); ?> USDT</th>
								</tr>
								<tr>
									<th class="table-success">Other Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_3, 0); ?> USDT</th>
								</tr>
							</tbody>
							<?php if ($arr->row()->reward_3 == "yes" && $arr->row()->reward_3_done == "no") { ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-center">
											<button type="button" class="btn btn-success btn-block btn-flat">Claim Now!</button>
										</th>
									</tr>
								</tfoot>
							<?php } ?>
						</table>
					</div>
				</div>

			</div>

			<!-- PAJERO SPORT -->
			<div class="col-sm-12 col-md-4">

				<div class="card" style="min-height: 500px;">
					<img src="<?= base_url('public/img/rewards/photo_2021-07-02_19-37-05.jpg'); ?>" class="card-img-top img-fluid" alt="Pajero" style="height: 200px;">
					<div class="card-body">
						<h4 class="text-center mb-3">
							Pajero Sport<br />
							<?php if ($arr->row()->reward_4 == "no") { ?>
								<span class="badge badge-dark">On Going</span>
							<?php } elseif ($arr->row()->reward_4 == "yes" && $arr->row()->reward_4_done == "no") { ?>
								<span class="badge badge-success">
									Target Achieved<br />
									<small><?= $arr->row()->reward_4_date; ?></small>
								</span>
							<?php } elseif ($arr->row()->reward_4 == "yes" && $arr->row()->reward_4_done == "yes") { ?>
								<span class="badge badge-primary">
									Has Been Obtained<br />
									<small><?= $arr->row()->reward_4_date; ?></small>
								</span>
							<?php } ?>
						</h4>
						<table class="table table-sm">
							<tbody>
								<tr>
									<th class="table-dark">Price:</th>
									<th class="text-right table-dark">±38,000 USDT</th>
								</tr>
								<tr>
									<th colspan="2" class="text-center table-success">Target to Claim</th>
								</tr>
								<tr>
									<th class="table-success">Main Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_4, 0); ?> USDT</th>
								</tr>
								<tr>
									<th class="table-success">Other Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_4, 0); ?> USDT</th>
								</tr>
							</tbody>
							<?php if ($arr->row()->reward_4 == "yes" && $arr->row()->reward_4_done == "no") { ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-center">
											<button type="button" class="btn btn-success btn-block btn-flat">Claim Now!</button>
										</th>
									</tr>
								</tfoot>
							<?php } ?>
						</table>
					</div>
				</div>

			</div>

			<!-- RUMAH -->
			<div class="col-sm-12 col-md-4">

				<div class="card" style="min-height: 500px;">
					<img src="<?= base_url('public/img/rewards/rumah.png'); ?>" class="card-img-top img-fluid" alt="Luxury House" style="height: 200px;">
					<div class="card-body">
						<h4 class="text-center mb-3">
							Luxury House<br />
							<?php if ($arr->row()->reward_5 == "no") { ?>
								<span class="badge badge-dark">On Going</span>
							<?php } elseif ($arr->row()->reward_5 == "yes" && $arr->row()->reward_5_done == "no") { ?>
								<span class="badge badge-success">
									Target Achieved<br />
									<small><?= $arr->row()->reward_5_date; ?></small>
								</span>
							<?php } elseif ($arr->row()->reward_5 == "yes" && $arr->row()->reward_5_done == "yes") { ?>
								<span class="badge badge-primary">
									Has Been Obtained<br />
									<small><?= $arr->row()->reward_5_date; ?></small>
								</span>
							<?php } ?>
						</h4>
						<table class="table table-sm">
							<tbody>
								<tr>
									<th class="table-dark">Price:</th>
									<th class="text-right table-dark">±70,000 USDT</th>
								</tr>
								<tr>
									<th colspan="2" class="text-center table-success">Target to Claim</th>
								</tr>
								<tr>
									<th class="table-success">Main Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_5, 0); ?> USDT</th>
								</tr>
								<tr>
									<th class="table-success">Other Line Sum:</th>
									<th class="text-right table-success"><?= number_format(LIMIT_REWARD_5, 0); ?> USDT</th>
								</tr>
							</tbody>
							<?php if ($arr->row()->reward_5 == "yes" && $arr->row()->reward_5_done == "no") { ?>
								<tfoot>
									<tr>
										<th colspan="2" class="text-center">
											<button type="button" class="btn btn-success btn-block btn-flat">Claim Now!</button>
										</th>
									</tr>
								</tfoot>
							<?php } ?>
						</table>
					</div>
				</div>

			</div>

		</div>
	</div>
</section>

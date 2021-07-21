<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Add Crypto Asset</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Crypto Asset</a></li>
					<li class="breadcrumb-item active">Add Crypto Asset</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<?php
			$x = 0;
			foreach ($arr->result() as $key) {
			?>

				<div class="col-sm-12 col-md-6">

					<div class="card bg-<?= $arr_bg_color[$x]; ?> text-white mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-md-5">
									<img src="<?= base_url(); ?>public/img/package_logo/<?= $key->logo; ?>" class="img-fluid" alt="starter">
									<?php if ($arr_state[$x] == 0) { ?>
										<a href="<?= site_url('crypto_asset/pick/' . base64_encode(UYAH . $key->id)); ?>" class="btn btn-dark btn-flat btn-block font-weight-bold">
											<i class="fas fa-toggle-off fa-fw"></i> Pick Package
										</a>
									<?php } elseif ($arr_state[$x] == 1) { ?>
										<span class="btn btn-success btn-flat btn-block font-weight-bold">
											<i class="fas fa-toggle-on fa-fw"></i> Active
										</span>
									<?php } else { ?>
										<span class="btn btn-secondary btn-flat btn-block font-weight-bold">
											Disabled
										</span>
									<?php } ?>
								</div>
								<div class="col-md-7">

									<h3 class="mt-3">
										<?= $key->name; ?>
									</h3>
									<p class="card-text">
									<ul>
										<li>
											Total Investment: <?= check_float($key->amount); ?> USDT
										</li>
										<li>
											Profit (%) /Month: <?= check_float($key->profit_per_month_percent); ?>%
										</li>
										<li>
											Profit /Day: <?= check_float($key->profit_per_day_value); ?> USDT
										</li>
										<li>
											Contract Duration: <?= $key->contract_duration; ?> Day
										</li>
									</ul>
									</p>

								</div>
							</div>
						</div>
					</div>

				</div>

			<?php
				$x++;
			}
			?>

		</div>
	</div>
</section>

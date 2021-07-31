<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Log Crypto Asset - <?= $invoice; ?></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Log</a></li>
					<li class="breadcrumb-item active">Log Crypto Asset</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row mt-3 mb-3">
			<div class="col-12">
				<a href="<?= site_url('log/crypto_asset'); ?>" class="btn btn-warning btn-block elevation-2">Back to List Invoice</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Log Package History</h3>

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
										$color = "bg-warning";
										$icon  = "fa-hourglass-start";
									} elseif ($state == "pending") {
										$color = "bg-info";
										$icon  = "fa-hourglass-half";
									} elseif ($state == "active") {
										$color = "bg-success";
										$icon  = "fa-check";
									}
								?>
									<div>
										<i class="fas <?= $icon; ?> <?= $color; ?>"></i>
										<div class="timeline-item">
											<span class="<?= $color; ?> time"><i class="fas fa-clock"></i> <?= $timex; ?></span>
											<h3 class="timeline-header <?= $color; ?>"><?= ucwords($state); ?></h3>
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
						<h3 class="card-title">Log Profit History</h3>

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
								foreach ($val as $key2) :
									$state = $key2['state'];
									$timex = $key2['created_at']->format('H:i:s');
									$description = $key2['description'];
									if ($state == "correction") {
										$color = "bg-warning";
										$icon  = "fa-hourglass-half";
									} elseif ($state == "get") {
										$color = "bg-success";
										$icon  = "fa-check";
									}
								?>
									<div>
										<i class="fas <?= $icon; ?> <?= $color; ?>"></i>
										<div class="timeline-item">
											<span class="time <?= $color; ?> "><i class="fas fa-clock"></i> <?= $timex; ?></span>
											<h3 class="timeline-header <?= $color; ?>"><?= ucwords($state); ?></h3>
											<div class="timeline-body <?= $color; ?>">
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

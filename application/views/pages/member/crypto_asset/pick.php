<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0"><?= $arr->row()->name; ?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Trade Manager</a></li>
					<li class="breadcrumb-item active">Add Trade Manager</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>

<section class="content">
	<div class="container-fluid">

		<!-- Main row -->
		<div class="row">

			<div class="col-md-12">

				<form class="form-horizontal" action="<?= site_url('crypto_asset/checkout/coinpayment'); ?>" method="post">

					<!-- PRODUCT LIST -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Package Detail</h3>

							<div class="card-tools">
								<a href="<?= site_url('crypto_asset/add'); ?>" class="btn btn-dark btn-sm">
									<i class="fas fa-chevron-left fa-fw"></i> Back to Package
								</a>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<div class="row">
								<div class="col-md-5">
									<p class="card-text">
									<ul>
										<li>
											Total Investment: <span id="total_investment"><?= check_float($arr->row()->amount); ?></span> USDT
										</li>
										<li>
											Profit per Month: <?= check_float($arr->row()->profit_per_month_percent); ?>%
										</li>
										<li>
											Profit per Day: <span id="profit_per_day_x"><?= check_float($arr->row()->profit_per_day_value); ?></span> USDT
										</li>
										<li>
											Contract Duration: <?= $arr->row()->contract_duration; ?> Day
										</li>
										<li>
											Profit Share Rules:
											<ul>
												<li>
													Self: <?= check_float($arr->row()->share_self_percentage); ?>% (<span id="self_share"><?= check_float($arr->row()->share_self_value); ?></span> USDT)
												</li>
												<li>
													Upline: <?= check_float($arr->row()->share_upline_percentage); ?>% (<span id="upline_share"><?= check_float($arr->row()->share_upline_value); ?></span> USDT)
												</li>
												<li>
													Company: <?= check_float($arr->row()->share_company_percentage); ?>% (<span id="company_share"><?= check_float($arr->row()->share_company_value); ?></span> USDT) </li>
											</ul>
										</li>
									</ul>
									</p>
								</div>
								<div class="col-md-7 p-4">
									<div class="form-group row">
										<label for="id_wallet_admin" class="col-form-label col-md-4">Total Investment<sup class="text-danger">*</sup></label>
										<div class="col-md-7">
											<div class="input-group">
												<input type="text" class="form-control" id="total_transfer" name="total_transfer" value="<?= $arr->row()->amount; ?>" required readonly>
												<div class="input-group-append">
													<span class="input-group-text">USDT</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="coin_type" class="col-form-label col-md-4">Coin Type</label>
										<div class="col-md-7">
											<select class="form-control" id="coin_type" name="coin_type" required>
												<option value="USDT.ERC20">Tether USD - ERC20 (USDT.ERC20)</option>
												<option value="USDT.BEP20">Tether USD - BSC Chain (USDT.BEP20)</option>
												<option value="LTCT">Lite Coin Test (LTCT)</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer text-center">
							<input type="hidden" class="form-control" id="id_package" name="id_package" value="<?= $id_package; ?>">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Checkout</button>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->
				</form>

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!--/. container-fluid -->
</section>

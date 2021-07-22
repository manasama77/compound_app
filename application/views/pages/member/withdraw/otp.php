<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Withdraw OTP</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Withdraw</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-md-8 offset-md-2">
				<form id="form_withdraw">
					<div class="card elevation-3">
						<div class="card-header">
							<h3 class="card-title">Withdraw OTP</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-sm mb-5">
									<tr>
										<th>Source</th>
										<th><?= ucfirst($source); ?></th>
									</tr>
									<tr>
										<th>Amount</th>
										<th><?= check_float($amount); ?> <small>USDT</small></th>
									</tr>
									<tr>
										<th>Target Address</th>
										<th><small><?= $wallet_address; ?></small><br /><?= strtoupper($wallet_label); ?></th>
									</tr>
								</table>
							</div>
							<div class="form-group">
								<label for="otp">OTP</label>
								<input type="number" class="form-control mb-2" id="otp" name="otp" min="100000" max="999999" placeholder="000000" autofocus required>
								<span class="help-block"><small>We already sent OTP to <kbd><?= $this->session->userdata(SESI . 'email'); ?></kbd></small></span>
							</div>
							<button type="button" class="btn btn-warning btn-sm btn-block elevation-2 mb-3" id="resend_button" onclick="resendOTP('<?= $this->session->userdata(SESI . 'email'); ?>');" disabled>
								Didn't receive OTP Code ?<br />
								Try send again<br />
								(After <span id="time">03:00</span>)
							</button>
							<button type="submit" id="submit_btn" class="btn btn-primary btn-block elevation-2">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.Main Content -->

<div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th>Amount</th>
							<th>:</th>
							<th id="amount_usd"></th>
						</tr>
						<tr>
							<th>Duration</th>
							<th>:</th>
							<th id="contract_duration"></th>
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
							<th class="align-top">Profit Rules</th>
							<th class="align-top">:</th>
							<th>
								<table class="table">
									<thead>
										<tr>
											<th>Self</th>
											<th>:</th>
											<th id="profit_self"></th>
										</tr>
										<tr>
											<th>Upline</th>
											<th>:</th>
											<th id="profit_upline"></th>
										</tr>
										<tr>
											<th>Company</th>
											<th>:</th>
											<th id="profit_company"></th>
										</tr>
									</thead>
								</table>
							</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

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
								Tidak menerima Kode OTP ?<br />
								Coba kirim lagi<br />
								(After <span id="time">01:00</span>)
							</button>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" id="submit_btn" class="btn btn-primary btn-block elevation-2">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

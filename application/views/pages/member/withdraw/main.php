<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Withdraw</h1>
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

		<div class="row mb-4">
			<div class="col-12 col-sm-6 col-md-6">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Profit</span>
						<span class="info-box-number">
							<?= $profit; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-6">
				<div class="info-box elevation-3">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Bonus</span>
						<span class="info-box-number">
							<?= $bonus; ?>
							<small>USDT</small>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-sm-12 col-md-6 offset-md-3">
				<form id="form_withdraw">
					<div class="card elevation-3">
						<div class="card-header">
							<h3 class="card-title">Withdraw</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="source">Source</label>
								<select class="form-control" id="source" name="source" required>
									<option value="profit">Profit</option>
									<option value="bonus">Bonus</option>
								</select>
							</div>
							<div class="form-group">
								<label for="amount">Amount</label>
								<div class="input-group mb-2">
									<input type="number" class="form-control" id="amount" name="amount" step="0.00000001" min="100" placeholder="Amount" value="<?= set_value('amount'); ?>" required>
									<div class="input-group-append">
										<div class="input-group-text">USDT</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="receive_coin">Coin Receive</label>
								<select class="form-control" id="receive_coin" name="receive_coin" required>
									<option value="" disabled selected>-Pick Coin Receive-</option>
									<option value="trx">Tron Coin Mainnet (TRX)</option>
									<option value="bnb">Binance Coin Mainnet (BNB)</option>
									<option value="ltct">Litecoin Testnet (LTCT)</option>
								</select>
							</div>
							<div class="form-group">
								<label for="estimation">Estimation Receive</label>
								<input type="text" class="form-control" id="estimation" name="estimation" required readonly>
							</div>
							<div class="form-group">
								<label for="wallet_host">Wallet Host</label>
								<select class="form-control" id="wallet_host" name="wallet_host" required>
									<option value="" disabled selected>-Select Wallet Host-</option>
								</select>
							</div>
							<div class="form-group">
								<label for="wallet_address">Wallet Address</label>
								<select class="form-control" id="wallet_address" name="wallet_address" required>
									<option value="" disabled selected>-Select Wallet Address-</option>
								</select>
								<small class="form-text text-danger"><i class="fas fa-info-circle fa-fw"></i>Please make sure your wallet address are valid address. We can't responsible and cover for invalid wallet address or fail withdraw transaction</small>
							</div>
							<button type="submit" class="btn btn-primary btn-block elevation-2">Withdraw</button>
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

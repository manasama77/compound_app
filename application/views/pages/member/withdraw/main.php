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
									<input type="number" class="form-control" id="amount" name="amount" step="0.00000001" min="<?= LIMIT_WITHDRAW; ?>" placeholder="Amount" value="<?= set_value('amount'); ?>" required>
									<div class="input-group-append">
										<div class="input-group-text bg-primary">USDT</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="coin_type">Coin Type</label>
								<select class="form-control" id="coin_type" name="coin_type" required>
									<option value="" disabled selected>-Pick Coin Type-</option>
									<option value="BNB.BSC">BNB.BEP20 - BSC</option>
									<option value="TRX">TRON</option>
									<option value="LTCT">Litecoin Testnet</option>
								</select>
							</div>
							<div class="form-group">
								<label for="estimation">Estimation Receive</label>
								<input type="text" class="form-control" id="estimation" name="estimation" required readonly>
							</div>
							<div class="form-group">
								<label for="wallet_label">Wallet Label</label>
								<select class="form-control" id="wallet_label" name="wallet_label" required>
									<option value="" disabled selected>-Select Wallet Label-</option>
								</select>
							</div>
							<div class="form-group">
								<label for="wallet_address">Wallet Address</label>
								<select class="form-control" id="wallet_address" name="wallet_address" required>
									<option value="" disabled selected>-Select Wallet Address-</option>
								</select>
							</div>
							<div class="alert alert-warning p-1">
								<small>
									<strong>Notes:</strong><br />
									<ul class="p-3">
										<li>BNB.BEP20 are Binance that run on Binance Smart Chain Network. It different from BNB.BEP2 that run on Binance Chain Network</li>
										<li>Make sure the wallet address you are input are valid</li>
										<li>Also Make sure the wallet address are support for receive with the coin type. If not the withdrawal coin transaction will be burn / permanent lost</li>
										<li><?= APP_NAME; ?> did not responsible for all your mistake input for invalid address or wrong target address</li>
									</ul>
								</small>
							</div>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" class="btn btn-primary btn-block elevation-2">Withdraw</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

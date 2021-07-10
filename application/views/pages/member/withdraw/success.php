<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Withdraw Request Done</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Withdraw Request Done</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-md-8 offset-md-2">
				<div class="alert alert-primary" role="alert">
					<h4 class="alert-heading">Withdraw <?= strtoupper($arr->row()->state); ?></h4>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-sm bg-dark">
							<tr>
								<th>Invoice</th>
								<th><?= $arr->row()->invoice; ?></th>
							</tr>
							<tr>
								<th>Source</th>
								<th><?= strtoupper($arr->row()->source); ?></th>
							</tr>
							<tr>
								<th>TXID</th>
								<th><?= $arr->row()->tx_id; ?></th>
							</tr>
							<tr>
								<th>Withdraw Amount</th>
								<th><?= number_format($arr->row()->amount_1, 8); ?> USDT</th>
							</tr>
							<tr>
								<th>Receive Amount</th>
								<th><?= number_format($arr->row()->amount_2, 8); ?> <?= strtoupper($arr->row()->currency_2); ?></th>
							</tr>
							<tr>
								<th>Wallet Address</th>
								<th><?= $arr->row()->wallet_address; ?> <small>(<?= $arr->row()->wallet_host; ?>)</small></th>
							</tr>
						</table>
					</div>
					<hr>
					<p class="mb-0"><i class="fas fa-info-circle"></i> Please wait maximum 1 day for system to transfer your withdraw request.</p>
				</div>
			</div>
		</div>
	</div>
</section>

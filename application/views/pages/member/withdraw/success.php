<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Permintaan Penarikan Telah Dibuat</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Permintaan Penarikan Telah Dibuat</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-md-8 offset-md-2">
				<div class="alert alert-secondary" role="alert">
					<h4 class="alert-heading">Penarikan <?= strtoupper($arr->row()->state); ?></h4>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-sm bg-dark">
							<tr>
								<th>Invoice</th>
								<th><?= $arr->row()->invoice; ?></th>
							</tr>
							<tr>
								<th>Sumber</th>
								<th><?= strtoupper($arr->row()->source); ?></th>
							</tr>
							<tr>
								<th>TXID</th>
								<th><small><?= $arr->row()->tx_id; ?></small></th>
							</tr>
							<tr>
								<th>Nominal Penarikan</th>
								<th><?= check_float($arr->row()->amount_1); ?> <small>USDT</small></th>
							</tr>
							<tr>
								<th>Nominal Diterima</th>
								<th><?= check_float($arr->row()->amount_2); ?> <small><?= strtoupper($arr->row()->currency_2); ?></small></th>
							</tr>
							<tr>
								<th>Wallet Address</th>
								<th><small><?= $arr->row()->wallet_address; ?></small><br /><?= $arr->row()->wallet_label; ?></th>
							</tr>
						</table>
					</div>
					<a href="<?= site_url('log/withdraw'); ?>" class="btn btn-dark btn-block">Lihat Catatan Penarikan</a>
					<hr>
					<p class="mb-0"><i class="fas fa-info-circle"></i> Harap tunggu maksimal 24 jam agar sistem memproses Permintaan Penarikan Anda.</p>
				</div>
			</div>
		</div>
	</div>
</section>

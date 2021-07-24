<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Log Crypto Asset</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Log</a></li>
					<li class="breadcrumb-item active">Crypto Asset</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<h4>List Invoice</h4>
		<div class="row">
			<?php foreach ($arr->result() as $key) : ?>
				<div class="col-lg-3 col-6">
					<a href="<?= site_url('log/crypto_asset/detail/' . $key->invoice); ?>">
						<div class="small-box bg-primary">
							<div class="inner">
								<h5><?= $key->name; ?></h5>
								<p><?= $key->invoice; ?></p>
							</div>
							<div class="icon">
								<i class="fas fa-file-invoice-dollar"></i>
							</div>
							<span class="small-box-footer">
								More info <i class="fas fa-arrow-circle-right"></i>
							</span>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

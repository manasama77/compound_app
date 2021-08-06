<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Downline</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Downline</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12 col-md-8">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Filter Downline</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<form action="<?= site_url('downline/show'); ?>" method="GET">
							<div class="form-group">
								<label for="depth">Kedalaman</label>
								<select class="form-control" id="depth" name="depth" required>
									<?php if ($max_depth == 0) {
										echo '<option value="" selected disabled>Anda tidak memiliki Downline</option>';
									} else {
										for ($x = 1; $x <= $max_depth; $x++) {
									?>
											<option value="<?= $x; ?>">Generasi <?= $x; ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

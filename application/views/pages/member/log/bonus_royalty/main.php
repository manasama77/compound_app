<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Catatan Bonus Royalti</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Catatan Bonus Royalti</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Catatan Bonus Royalti</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_data" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th class="text-center align-top" style="min-width: 120px;">Tanggal Waktu</th>
										<th class="align-top" style="min-width: 120px;">Downline</th>
										<th class="align-top" style="min-width: 120px;">Upline</th>
										<th class="align-top" style="min-width: 80px;">Paket</th>
										<th class="align-top" style="min-width: 120px;">Tipe</th>
										<th class="align-top text-right" style="min-width: 100px;">Bonus</th>
									</tr>
								</thead>
								<tbody>

									<?php if ($arr->num_rows() > 0) : ?>
										<?php foreach ($arr->result() as $key) : ?>

											<tr>
												<td class="text-center align-top">
													<?= $key->created_at; ?>
												</td>
												<td class="align-top">
													<?= $key->downline_user_id; ?>
												</td>
												<td class="align-top">
													<?= $key->upline_user_id; ?>
												</td>
												<td class="align-top">
													<?= $key->package; ?>
												</td>
												<td class="align-top">
													<?= ucwords($key->type); ?></small>
												</td>
												<td class="align-top text-right">
													<?= check_float($key->package_amount); ?>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="6" class="text-center text-danger">-Kamu Tidak Memiliki Catatan Bonus Royalti-</td>
										</tr>

									<?php endif; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.Main Content -->

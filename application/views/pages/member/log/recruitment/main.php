<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Catatan Rekrutmen</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Catatan Rekrutmen</li>
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
						<h3 class="card-title">Catatan Rekrutmen</h3>

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
										<th class="text-center align-middle"><i class="fas fa-image"></i></th>
										<th class="align-middle">Member</th>
										<th class="text-center align-middle">Generasi</th>
										<th class="text-center align-middle">Upline</th>
										<th class="text-center align-middle" style="min-width: 150px; width: 150px;">Tanggal Join</th>
									</tr>
								</thead>
								<tbody>

									<?php if (count($data_downline) > 0) : ?>
										<?php foreach ($data_downline as $key) : ?>

											<tr>
												<td class="text-center align-middle no-sort">
													<img src="<?= $key['profile_picture_downline']; ?>" alt="Profile Picture" class="img-size-50">
												</td>
												<td class="align-middle">
													<?= $key['user_id_downline']; ?>
												</td>
												<td class="text-center align-middle">
													<span class="badge badge-primary">
														<i class="fas fa-sun"></i> G<?= $key['generation_downline']; ?>
													</span>
												</td>
												<td class="align-middle text-center">
													<?= $key['user_id_upline']; ?>
												</td>
												<td class="align-middle text-center">
													<?= $key['created_at_downline']; ?>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="5" class="text-center text-danger">- KAMU TIDAK MEMILIKI DOWNLINE-</td>
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

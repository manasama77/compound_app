<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Downline</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
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
								<label for="depth">Generasi</label>
								<select class="form-control" id="depth" name="depth" required>
									<?php for ($x = 1; $x <= $max_depth; $x++) { ?>
										<option value="<?= $x; ?>" <?= ($x == $depth) ? 'selected' : ''; ?>>Generasi <?= $x; ?></option>
									<?php } ?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
						</form>
					</div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Downline</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_data" class="table table-sm">
								<thead>
									<tr>
										<th class="text-center align-middle"><i class="fas fa-image"></i></th>
										<th class="align-middle">User ID</th>
										<th class="align-middle">Nama Lengkap</th>
										<th class="align-middle">Upline</th>
										<th class="text-center align-middle">Generasi</th>
										<th class="text-right align-middle">Total Omzet</th>
										<th class="text-right align-middle">Total Downline</th>
										<th class="text-center align-middle">
											<i class="fas fa-cog"></i>
										</th>
									</tr>
								</thead>
								<tbody>

									<?php if (count($arr) > 0) : ?>
										<?php
										$itteration = 1;
										foreach ($arr as $key) :
										?>
											<tr>
												<td class="align-middle">
													<img src="<?= $key['profile_picture']; ?>" alt="Profile Picture" class="img-size-50">
												</td>
												<td class="align-middle">
													<?= $key['user_id']; ?>
												</td>
												<td class="align-middle">
													<?= $key['fullname']; ?>
												</td>
												<td class="align-middle">
													<?= $key['user_id_upline']; ?>
												</td>
												<td class="text-center align-middle">
													<span class="badge badge-primary">
														<i class="fas fa-sun"></i> <?= $key['generation']; ?>
													</span>
												</td>
												<td class="text-right align-middle">
													<?= $key['total_omset']; ?>
												</td>
												<td class="text-right align-middle">
													<?= $key['total_downline']; ?>
												</td>
												<td class="text-center align-middle">
													<button type="button" class="btn btn-info btn-xs" onclick="showModalDownline('<?= $key['id']; ?>', '<?= $key['fullname']; ?>')">
														<i class="fas fa-eye fa-fw"></i> Detail
													</button>
												</td>
											</tr>

										<?php
											$itteration++;
										endforeach;
										?>
									<?php else : ?>

										<tr>
											<td colspan="8" class="text-center text-danger">- Anda Tidak Memiliki Downline -</td>
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


<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Member <span id="name_downline"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Trade Manager</h4>
				<div class="table-resonsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Paket</th>
								<th class="align-middle text-right">Nilai Investasi</th>
								<th class="align-middle text-center">Durasi</th>
								<th class="align-middle text-center">Status</th>
							</tr>
						</thead>
						<tbody id="v_trade_manager">
							<tr>
								<td colspan="4" class="text-center align-middle">-Tidak Ada Paket Aktif-</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h4>Crypto Asset</h4>
				<div class="table-resonsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Paket</th>
								<th class="align-middle text-right">Nilai Investasi</th>
								<th class="align-middle text-center">Durasi</th>
								<th class="align-middle text-center">Status</th>
							</tr>
						</thead>
						<tbody id="v_crypto_asset">
							<tr>
								<td colspan="4" class="text-center align-middle">-Tidak Ada Paket Aktif-</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h4 class="mt-3">Downline</h4>
				<div class="table-responsive">
					<table id="table_downline" class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">User ID</th>
								<th class="align-middle">Nama Lengkap</th>
								<th class="align-middle">Upline</th>
								<th class="align-middle text-center">Generasi</th>
								<th class="align-middle text-right">Total Omzet</th>
								<th class="align-middle text-right">Total Downline</th>
							</tr>
						</thead>
						<tbody id="v_downline">
							<tr>
								<td colspan="6" class="text-center align-middle">-Tidak ada data Downline-</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

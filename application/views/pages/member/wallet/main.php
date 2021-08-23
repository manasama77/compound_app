<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Wallet</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Wallet</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-md-4">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Tambah Wallet</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="coin_type">Jenis Coin</label>
								<select class="form-control" id="coin_type" name="coin_type" required>
									<!-- <option value="BNB.BSC">Binance BNB.BEP20 - BSC</option> -->
									<option value="TRX">TRON (TRX)</option>
									<option value="LTCT">Litecoin Testnet</option>
								</select>
							</div>
							<div class="form-group">
								<label for="id_wallet">Wallet Label</label>
								<input type="text" class="form-control" id="id_wallet" name="id_wallet" required>
							</div>
							<div class="form-group">
								<label for="wallet_address">Wallet Address</label>
								<input type="text" class="form-control" id="wallet_address" name="wallet_address" required>
							</div>
							<div class="form-group">
								<label for="otp">OTP</label>
								<div class="input-group">
									<input type="text" class="form-control" id="otp" name="otp" minlength="6" maxlength="6" required disabled>
									<div class="input-group-append">
										<button id="btn_otp" type="button" class="btn btn-dark" onclick="kirimOTP();">Kirim OTP</button>
									</div>
								</div>
							</div>

							<div class="alert alert-warning p-1">
								<strong>Catatan:</strong><br />
								<ul class="p-3">
									<li>Satu Jenis Coin hanya dapat didaftarkan satu Wallet Address</li>
									<!-- <li>Binance BNB.BEP20 adalah Jenis Coin Binance yang berjalan di jaringan Binance Smart Chain (BSC). Jenis Coin ini berbeda dengan Binance BNB.BEP2 yang berjalan di jaringan Binance Chain (BC)</li> -->
									<li>Pastikan Wallet Address yang Anda masukan Valid dan tidak salah dalam memasukan alamat</li>
									<li>Pastikan juga Wallet Address dapat menerima jenis coin yang sama dan berada di jaringan yang sama. Jika tidak, pada saat proses Penarikan Coin yang dikirimkan akan terbakar dijaringan / kehilangan permanent</li>
									<li><?= APP_NAME; ?> tidak bertanggung jawab atas semua kesalahan input Anda baik dari Wallet Address yang tidak Valid atau salah kepemilikan Wallet Address</li>
								</ul>
							</div>
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button id="btn_submit" type="submit" class="btn btn-primary btn-block" disabled>Simpan</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-8">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Wallet</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_data" class="table">
								<thead>
									<tr>
										<th class="align-middle">#</th>
										<th class="align-middle">Jenis Coin</th>
										<th class="align-middle">Wallet Label</th>
										<th class="align-middle">Wallet Address</th>
										<th class="align-middle text-center" style="min-width: 140px !important;"><i class="fas fa-cogs"></i></th>
									</tr>
								</thead>
								<tbody id="v_data">
									<?php
									$itteration = 1;
									foreach ($arr->result() as $key) {
									?>
										<tr>
											<td class="text-center align-middle"><?= $itteration++; ?></td>
											<td class="align-middle"><?= $key->coin_type; ?></td>
											<td class="align-middle"><?= $key->wallet_label; ?></td>
											<td class="align-middle"><small><?= $key->wallet_address; ?></small></td>
											<td class="text-center align-middle" style="width: 80px;">
												<div class="btn-group">
													<!-- <button type="button" class="btn btn-warning btn-sm" onclick="editData('<?= $key->id; ?>', '<?= $key->coin_type; ?>', '<?= $key->wallet_label; ?>', '<?= $key->wallet_address; ?>');"><i class="fas fa-pencil-alt fa-fw"></i> Edit</button> -->
													<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('<?= $key->id; ?>', '<?= $key->wallet_label; ?>', '<?= $key->wallet_address; ?>');"><i class="fas fa-trash-alt fa-fw"></i> Delete</button>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<form id="form_edit">
	<div class="modal fade" id="modal_edit" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Edit Wallet</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="coin_type_edit">Coin Type</label>
						<select class="form-control" id="coin_type_edit" name="coin_type_edit" required>
							<!-- <option value="BNB.BSC">BNB.BEP20 - BSC</option> -->
							<option value="TRX">TRON (TRX)</option>
							<option value="LTCT">Litecoin Testnet</option>
						</select>
					</div>
					<div class="form-group">
						<label for="wallet_label_edit">Wallet Label</label>
						<input type="text" class="form-control" id="wallet_label_edit" name="wallet_label_edit" required>
					</div>
					<div class="form-group">
						<label for="wallet_address_edit">Wallet Address</label>
						<input type="text" class="form-control" id="wallet_address_edit" name="wallet_address_edit" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_edit" name="id_edit" required>
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>

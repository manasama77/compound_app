<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Wallet</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Wallet</li>
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
										<th class="align-middle">Receive Coin</th>
										<th class="align-middle" style="min-width: 120px !important;">Source</th>
										<th class="align-middle">Address</th>
										<th class="align-middle text-center" style="min-width: 120px !important;"><i class="fas fa-cogs"></i></th>
									</tr>
								</thead>
								<tbody id="v_data">
									<?php
									$itteration = 1;
									foreach ($arr->result() as $key) {
									?>
										<tr>
											<td class="text-center align-middle"><?= $itteration++; ?></td>
											<td class="align-middle"><?= STRTOUPPER($key->receive_coin); ?></td>
											<td class="align-middle"><?= ucwords($key->wallet_host); ?></td>
											<td class="align-middle"><?= $key->wallet_address; ?></td>
											<td class="text-center align-middle" style="width: 120px;">
												<button type="button" class="btn btn-warning btn-sm" onclick="editData('<?= $key->id; ?>', '<?= $key->receive_coin; ?>', '<?= $key->wallet_host; ?>', '<?= $key->wallet_address; ?>');">Edit</button>
												<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('<?= $key->id; ?>', '<?= $key->wallet_host; ?>', '<?= $key->wallet_address; ?>');">Delete</button>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Add Wallet</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="receive_coin">Receive Coin</label>
								<select class="form-control" id="receive_coin" name="receive_coin" required>
									<option value="bnb">BNB</option>
									<option value="trx">TRX</option>
									<option value="ltct">LTCT</option>
								</select>
							</div>
							<div class="form-group">
								<label for="wallet_host">Wallet Host</label>
								<select class="form-control" id="wallet_host" name="wallet_host" required>
									<option value="">-</option>
								</select>
							</div>
							<div class="form-group">
								<label for="wallet_address">Wallet Address</label>
								<input type="text" class="form-control" id="wallet_address" name="wallet_address" required>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Submit</button>
						</form>
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
						<label for="receive_coin_edit">Receive Coin</label>
						<select class="form-control" id="receive_coin_edit" name="receive_coin_edit" required>
							<option value="bnb">BNB</option>
							<option value="trx">TRX</option>
							<option value="ltct">LTCT</option>
						</select>
					</div>
					<div class="form-group">
						<label for="wallet_host_edit">Wallet Source</label>
						<select class="form-control" id="wallet_host_edit" name="wallet_host_edit" required>
							<option value="">-</option>
						</select>
					</div>
					<div class="form-group">
						<label for="wallet_address_edit">Wallet Address</label>
						<input type="text" class="form-control" id="wallet_address_edit" name="wallet_address_edit" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_edit" name="id_edit" required>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>

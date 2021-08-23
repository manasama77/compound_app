<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Profit Crypto Asset</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Profit Crypto Asset</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-12">
				<div class="card">
					<div class="card-header">
						List Profit Crypto Asset
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th class="text-center" style="min-width: 100px;">Tanggal</th>
										<th style="min-width: 100px;">Member</th>
										<th style="min-width: 100px;">Invoice</th>
										<th style="min-width: 100px;">Paket</th>
										<th class="text-right" style="min-width: 100px;">Profit</th>
										<th class="text-center">Status</th>
										<th class="text-center" style="min-width: 100px;">Tanggal Paid</th>
										<th style="min-width: 100px;">Downline</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key['created_at']; ?></td>
												<td><?= $key['user_id']; ?></td>
												<td><?= $key['invoice']; ?></td>
												<td><?= $key['package_name']; ?></td>
												<td class="text-right"><?= $key['profit']; ?></td>
												<td class="text-center">
													<?php
													if ($key['is_unpaid'] == "yes") {
														echo '<span class="badge badge-warning">UNPAID</span>';
													} else {
														echo '<span class="badge badge-success">PAID</span>';
													}
													?>
												</td>
												<td class="text-center"><?= $key['release_date']; ?></td>
												<td><?= $key['downline_user_id']; ?></td>
											</tr>
									<?php
										endforeach;
									endif;
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<form id="form_reset">
	<div class="modal fade" id="modal_reset" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="email_reset">Email</label>
						<input type="text" class="form-control" id="email_reset" name="email_reset" required readonly>
					</div>
					<div class="form-group">
						<label for="password_reset">New Password</label>
						<input type="password" class="form-control" id="password_reset" name="password_reset" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_reset" name="id_reset">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>

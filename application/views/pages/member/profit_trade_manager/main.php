<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Profit Trade Manager</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Profit Trade Manager</li>
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
						List Profit Trade Manager
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th style="min-width: 100px;">Date</th>
										<th style="min-width: 100px;">Member</th>
										<th style="min-width: 100px;">Invoice</th>
										<th style="min-width: 100px;">Package</th>
										<th class="text-right" style="min-width: 100px;">Profit</th>
										<th style="min-width: 350px;">Description</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key['created_at']; ?></td>
												<td><?= $key['fullname']; ?><br /><small>(<?= $key['email']; ?>)</small></td>
												<td><?= $key['invoice']; ?></td>
												<td><?= $key['package_name']; ?></td>
												<td class="text-right"><?= $key['profit']; ?> <small>USDT</small></td>
												<td><?= $key['description']; ?></td>
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

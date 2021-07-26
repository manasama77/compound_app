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
								<label for="depth">Depth</label>
								<select class="form-control" id="depth" name="depth" required>
									<?php for ($x = 1; $x <= $max_depth; $x++) { ?>
										<option value="<?= $x; ?>" <?= ($x == $id_member_depth) ? 'selected' : ''; ?>>Generation <?= $x; ?></option>
									<?php } ?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Show</button>
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
										<th class="align-middle">Picture</th>
										<th class="align-middle">Fullname</th>
										<th class="align-middle">Email</th>
										<th class="align-middle">Phone Number</th>
										<th class="text-center align-middle" style="width: 200px;">Upline</th>
										<th class="text-center align-middle">Generation</th>
										<th class="text-center align-middle">Total Turnover</th>
										<th class="text-center align-middle">Total Downline</th>
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
													<?= $key['fullname']; ?>
												</td>
												<td class="align-middle">
													<?= $key['email']; ?>
												</td>
												<td class="align-middle">
													<?= $key['phone_number']; ?>
												</td>
												<td class="align-middle text-center">
													<?= $key['fullname_upline']; ?> <br />(<?= $key['email_upline']; ?>)
												</td>
												<td class="text-center align-middle">
													<span class="badge badge-primary">
														<i class="fas fa-sun"></i> <?= $key['generation']; ?>
													</span>
												</td>
												<td class="text-center align-middle">
													<?= $key['total_omset']; ?> USDT
												</td>
												<td class="text-center align-middle">
													<?= $key['total_downline']; ?> Member
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
											<td colspan="8" class="text-center text-danger">- You Don't Have Any Friend On Your Circle -</td>
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
				<h5 class="modal-title" id="exampleModalLabel">Detail Member - <span id="name_downline"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4>Trade Manager</h4>
				<div class="table-resonsive">
					<table class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Package</th>
								<th class="align-middle">Amount</th>
								<th class="align-middle">Profit /Day</th>
								<th class="align-middle">Duration</th>
								<th class="align-middle">Status</th>
							</tr>
						</thead>
						<tbody id="v_trade_manager">
							<tr>
								<td colspan="5" class="text-center align-middle">-No Package Active-</td>
							</tr>
						</tbody>
					</table>
				</div>
				<h4 class="mt-3">Downline</h4>
				<div class="table-responsive">
					<table class="table table-sm">
						<thead>
							<tr>
								<th class="align-middle">Fullname</th>
								<th class="align-middle">Email</th>
								<th class="align-middle">Phone Number</th>
								<th class="align-middle">Upline</th>
								<th class="align-middle">Generation</th>
								<th class="align-middle text-right">Total Turnover</th>
								<th class="align-middle text-center">Total Downline</th>
							</tr>
						</thead>
						<tbody id="v_downline">
							<tr>
								<td colspan="7" class="text-center align-middle">-No Downline Data-</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

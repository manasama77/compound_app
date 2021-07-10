<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Log Recruitment</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Log</a></li>
					<li class="breadcrumb-item active">Recuritment</li>
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
						<h3 class="card-title">Log Recruitment</h3>

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
										<th class="align-middle">Picture</th>
										<th class="align-middle">Fullname</th>
										<th class="align-middle">Email</th>
										<th class="align-middle">Phone Number</th>
										<th class="text-center align-middle">Generation</th>
										<th class="text-center align-middle">Upline</th>
										<th class="text-center align-middle" style="min-width: 150px; width: 150px;">Join Date</th>
									</tr>
								</thead>
								<tbody>

									<?php if (count($data_downline) > 0) : ?>
										<?php foreach ($data_downline as $key) : ?>

											<tr>
												<td class="align-middle no-sort">
													<img src="<?= $key['profile_picture_downline']; ?>" alt="Profile Picture" class="img-size-50">
												</td>
												<td class="align-middle">
													<?= $key['fullname_downline']; ?>
												</td>
												<td class="align-middle">
													<?= $key['email_downline']; ?>
												</td>
												<td class="align-middle">
													<?= $key['phone_number_downline']; ?>
												</td>
												<td class="text-center align-middle">
													<span class="badge badge-primary">
														<i class="fas fa-sun"></i> G<?= $key['generation_downline']; ?>
													</span>
												</td>
												<td class="align-middle text-center">
													<?= $key['fullname_upline']; ?> <small>(<?= $key['email_upline']; ?>)</small>
												</td>
												<td class="align-middle text-center">
													<?= $key['created_at_downline']; ?>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="7" class="text-center text-danger">- You Don't Have Any Friend On Your Circle -</td>
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

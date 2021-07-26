<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Log Bonus Recruitment</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Log</a></li>
					<li class="breadcrumb-item active">Bonus Recruitment</li>
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
						<h3 class="card-title">Log Bonus Recruitment</h3>

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
										<th class="text-center align-top" style="min-width: 120px;">Member</th>
										<th class="align-top">Package</th>
										<th class="align-top" style="min-width: 120px;">Type</th>
										<th class="align-top" style="min-width: 120px;">Description</th>
									</tr>
								</thead>
								<tbody>

									<?php if ($arr->num_rows() > 0) : ?>
										<?php foreach ($arr->result() as $key) : ?>

											<tr>
												<td class="text-center align-top">
													<?= $key->fullname; ?>
												</td>
												<td class="align-top">
													<?= $key->package; ?>
												</td>
												<td class="align-top">
													<?= ucwords($key->type); ?></small>
												</td>
												<td class="align-top">
													<?= $key->description; ?>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php else : ?>

										<tr>
											<td colspan="8" class="text-center text-danger">- You Don't Have Any History Bonus Recruitment -</td>
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

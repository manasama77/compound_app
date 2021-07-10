<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Profile</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Profile</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<?php //echo '<pre>' . print_r($arr->result(), 1) . '</pre>'; 
		?>
		<div class="row">
			<div class="col-md-3">

				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="<?= $this->session->userdata(SESI . 'profile_picture'); ?>" alt="Profile Picture">
						</div>

						<h4 class="profile-username text-center">
							<?= $this->session->userdata(SESI . 'fullname'); ?>
							<?php if ($is_founder == "yes") { ?>
								<br><span class="badge badge-primary">Founder</span>
							<?php } ?>
						</h4>
						<p class="text-muted text-center">Member since<br><?= $member_since; ?></p>
					</div>
				</div>

				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">About Me</h3>
					</div>
					<div class="card-body">

						<strong><i class="fas fa-envelope mr-1"></i> Email</strong>
						<p class="text-muted mb-0">
							<?= $this->session->userdata(SESI . 'email'); ?>
						</p>

						<hr>
						<strong><i class="fas fa-phone mr-1"></i> Phone</strong>
						<p class="text-muted mb-0">
							<?= $this->session->userdata(SESI . 'phone_number'); ?>
						</p>

						<?php if ($country_name != null) { ?>
							<hr>
							<strong><i class="fas fa-globe mr-1"></i> Country</strong>
							<p class="text-muted mb-0">
								<?= $country_name; ?>
							</p>
						<?php } ?>

					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
							<li class="nav-item"><a class="nav-link" href="#reset_password" data-toggle="tab">Reset Password</a></li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">

							<div class="tab-pane active" id="settings">
								<form class="form-horizontal" id="form_setting">
									<div class="form-group row">
										<label for="fullname" class="col-sm-2 col-form-label">Name</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Name" value="<?= $arr->row()->fullname; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
										<div class="col-sm-10">
											<input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="<?= $arr->row()->phone_number; ?>">
										</div>
									</div>
									<hr />
									<div class="form-group row">
										<label for="phone_number" class="col-sm-2 col-form-label">Country</label>
										<div class="col-sm-10">
											<input class="form-control" list="country_list" id="country_code" name="country_code" placeholder="Select Country" value="<?= $arr->row()->country_code; ?>">
											<datalist id="country_list">
												<?php
												foreach ($arr_country->result() as $key) {
													echo '<option value="' . $key->code . '">' . $key->name . '</option>';
												}
												?>
											</datalist>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<button type="submit" class="btn btn-danger btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>

							<div class="tab-pane" id="reset_password">
								<form class="form-horizontal" id="form_reset_password">
									<div class="form-group row">
										<label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="new_password" class="col-sm-2 col-form-label">New
											Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="verify_password" class="col-sm-2 col-form-label">Verify
											Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Verify Password" required>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<button type="submit" class="btn btn-danger btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>

						</div>

					</div>
				</div>

			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

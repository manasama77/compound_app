<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Profil</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Profil</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">

				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="<?= $this->session->userdata(SESI . 'profile_picture'); ?>" alt="Profil Picture">
						</div>

						<h4 class="profile-username text-center">
							<?= $this->session->userdata(SESI . 'fullname'); ?>
							<?php if ($is_founder == "yes") { ?>
								<br><span class="badge badge-primary">Founder</span>
							<?php } ?>
						</h4>
						<p class="text-muted text-center">Member Sejak<br><?= $member_since; ?></p>
					</div>
				</div>

				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Informasi Member</h3>
					</div>
					<div class="card-body">

						<strong><i class="fas fa-envelope mr-1"></i> Email</strong>
						<p class="text-muted mb-0">
							<?= $this->session->userdata(SESI . 'email'); ?>
						</p>

						<hr>
						<strong><i class="fas fa-phone mr-1"></i> Telepon</strong>
						<p class="text-muted mb-0">
							<?= $this->session->userdata(SESI . 'phone_number'); ?>
						</p>

						<?php if ($is_founder == "no") { ?>
							<hr>
							<strong><i class="fas fa-chalkboard-teacher mr-1"></i> Upline</strong>
							<p class="text-muted mb-0">
								<?= $arr_upline->row()->fullname; ?> (<?= $arr_upline->row()->email; ?>)
							</p>
						<?php } ?>

						<?php if ($country_name != null) { ?>
							<hr>
							<strong><i class="fas fa-globe mr-1"></i> Negara</strong>
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
							<li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Setting</a></li>
							<li class="nav-item"><a class="nav-link" href="#reset_password" data-toggle="tab">Reset Password</a></li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">

							<div class="tab-pane active" id="settings">
								<form class="form-horizontal" id="form_setting">
									<div class="form-group row">
										<label for="fullname" class="col-sm-2 col-form-label">Nama</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nama" value="<?= $arr->row()->fullname; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="phone_number" class="col-sm-2 col-form-label">Nomor Telepon</label>
										<div class="col-sm-10">
											<input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Nomor Telepon" value="<?= $arr->row()->phone_number; ?>">
										</div>
									</div>
									<hr />
									<div class="form-group row">
										<label for="country_code" class="col-sm-2 col-form-label">Negara</label>
										<div class="col-sm-10">
											<select class="form-control select2" id="country_code" name="country_code" data-placeholder="Pilih Negara" required>
												<?php
												foreach ($arr_country->result() as $key) {
													$selected = ($key->name == $country_name) ? "selected" : "";
													echo '<option value="' . $key->code . '" ' . $selected . '>' . $key->name . '</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
											<button type="submit" class="btn btn-danger btn-block elevation-2">Simpan</button>
										</div>
									</div>
								</form>
							</div>

							<div class="tab-pane" id="reset_password">
								<form class="form-horizontal" id="form_reset_password">
									<div class="form-group row">
										<label for="current_password" class="col-sm-3 col-form-label">Password Saat Ini</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Saat Ini" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="new_password" class="col-sm-3 col-form-label">Password Baru</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password Baru" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="verify_password" class="col-sm-3 col-form-label">Verifikasi Password Baru</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Verifikasi Password Baru" required>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
											<button type="submit" class="btn btn-danger btn-block elevation-2">Simpan</button>
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

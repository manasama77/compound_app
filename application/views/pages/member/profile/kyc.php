<!-- content-header -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">KYC</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">KYC</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-md-6 offset-md-3">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Form KYC</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">

						<?php if (validation_errors()) { ?>
							<div class="alert alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong><?= validation_errors(); ?></strong>
							</div>
						<?php } ?>

						<form id="form" enctype="multipart/form-data">
							<div class="form-group">
								<label for="fullname">Nama Lengkap</label>
								<input type="text" class="form-control" id="fullname" name="fullname" minlength="3" maxlength="100" placeholder="Nama Lengkap" value="<?= ($arr_member->row()->fullname) ?? set_value('fullname'); ?>" required>
								<div class="help-block mt-1">
									<span class="text-muted"><small>Sesuai KTP</small></span>
								</div>
							</div>
							<div class="form-group">
								<label for="id_card_number">No KTP</label>
								<input type="text" class="form-control" id="id_card_number" name="id_card_number" minlength="16" maxlength="20" placeholder="No KTP" value="<?= set_value('id_card_number'); ?>" required>
							</div>
							<div class="form-group">
								<label for="country_code">Negara</label>
								<select class="form-control select2" id="country_code" name="country_code" data-placeholder="Pilih Negara" required>
									<option value=""></option>
									<?php foreach ($arr_negara->result() as $item) : ?>
										<option value="<?= $item->code; ?>"><?= $item->name; ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="address">Alamat</label>
								<textarea class="form-control" name="address" id="address" rows="2" placeholder="Alamat" minlength="10" required><?= set_value('address'); ?></textarea>
								<div class="help-block mt-1">
									<span class="text-muted"><small>Sesuai KTP</small></span>
								</div>
							</div>
							<div class="form-group">
								<label for="postal_code">Kode POS</label>
								<input type="text" class="form-control" id="postal_code" name="postal_code" minlength="5" maxlength="5" placeholder="Kode POS" value="<?= set_value('postal_code'); ?>" required>
								<div class="help-block mt-1">
									<span class="text-muted"><small>Sesuai KTP</small></span>
								</div>
							</div>
							<div class="form-group">
								<label for="id_bank">Bank</label>
								<select class="form-control select2" id="id_bank" name="id_bank" data-placeholder="Pilih Bank" required>
									<option value=""></option>
									<?php foreach ($arr_bank->result() as $item) : ?>
										<option <?php (set_value('id_bank') == $item->id) ? "selected" : ""; ?> value="<?= $item->id; ?>"><?= $item->name; ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="no_rekening">No Rekening</label>
								<input type="text" class="form-control" id="no_rekening" name="no_rekening" minlength="10" maxlength="20" placeholder="No Rekening" value="<?= set_value('no_rekening'); ?>" required>
							</div>
							<div class="form-group">
								<label for="foto_ktp">Foto KTP</label>
								<input type="file" class="form-control" id="foto_ktp" name="foto_ktp" lang="id" accept="image/*" capture="user" required>
							</div>
							<div class="form-group">
								<label for="foto_pegang_ktp">Foto Diri & KTP</label>
								<input type="file" class="form-control" id="foto_pegang_ktp" name="foto_pegang_ktp" lang="id" accept="image/*" capture="user" required>
							</div>

							<div class="alert alert-info">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Admin akan memproses KYC kamu maksimal 7 hari kerja (Senin ~ Jumat)</strong>
							</div>

							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<button type="submit" class="btn btn-primary btn-block">Ajukan KYC</button>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

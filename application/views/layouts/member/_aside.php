<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="<?= site_url('dashboard'); ?>" class="brand-link">
		<img src="<?= base_url('public/img/logo.png'); ?>" alt="<?= APP_NAME; ?> LOGO" class="img-fluid brand-image" style="opacity: .8; max-width: 60px;">
		<span class="brand-text font-weight-bold text-white"><?= APP_NAME; ?></span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?= $this->session->userdata(SESI . 'profile_picture'); ?>" class="img-circle elevation-2" alt="Member Image">
			</div>
			<div class="info">
				<span class="d-block text-white"><?= $this->session->userdata(SESI . 'fullname'); ?></span>
				<div class="btn-group">
					<a href="<?= site_url('profile'); ?>" class="btn btn-info btn-sm btn-flat text-white">
						<i class="fas fa-user"></i> Profil
					</a>
					<a href="<?= site_url('logout'); ?>" class="btn btn-danger btn-sm btn-flat text-white">
						<i class="fas fa-sign-out-alt"></i> Keluar
					</a>
				</div>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?= site_url('dashboard'); ?>" class="nav-link <?= ($this->uri->segment(1) == "dashboard") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Beranda
						</p>
					</a>
				</li>
				<li class="nav-item <?= ($this->uri->segment(1) == "trade_manager") ? "menu-is-opening menu-open" : ""; ?>">
					<a href="#" class="nav-link <?= ($this->uri->segment(1) == "trade_manager") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-coins"></i>
						<p>
							Trade Manager
							<i class="fas fa-angle-left right"></i>
							<span class="badge badge-success right"><?= $aside_count_trade_manager; ?></span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('trade_manager/index'); ?>" class="nav-link <?= ($this->uri->segment(1) == "trade_manager" && $this->uri->segment(2) == "index") ? "active" : ""; ?>">
								<i class="fas fa-robot nav-icon"></i>
								<p>Paket Kamu</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('trade_manager/add'); ?>" class="nav-link <?= ($this->uri->segment(1) == "trade_manager" && in_array($this->uri->segment(2), ['add', 'pick'])) ? "active" : ""; ?>">
								<i class="fas fa-plus nav-icon"></i>
								<p>Join Paket</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?= ($this->uri->segment(1) == "crypto_asset") ? "menu-is-opening menu-open" : ""; ?>">
					<a href="#" class="nav-link <?= ($this->uri->segment(1) == "crypto_asset") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-house-user"></i>
						<p>
							Crypto Asset
							<i class="right fas fa-angle-left"></i>
							<span class="badge badge-success right"><?= $aside_count_crypto_asset; ?></span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('crypto_asset/index'); ?>" class="nav-link <?= ($this->uri->segment(1) == "crypto_asset" && $this->uri->segment(2) == "index") ? "active" : ""; ?>">
								<i class="fas fa-list nav-icon"></i>
								<p>Paket Kamu</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('crypto_asset/add'); ?>" class="nav-link <?= ($this->uri->segment(1) == "crypto_asset" && in_array($this->uri->segment(2), ['add', 'pick'])) ? "active" : ""; ?>">
								<i class="fas fa-plus nav-icon"></i>
								<p>Join Paket</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" onclick="comingSoon();" class="nav-link class=" nav-link <?= ($this->uri->segment(1) == "crypto_asset" && in_array($this->uri->segment(2), ['claim'])) ? "active" : ""; ?>">
								<i class="fas fa-gift nav-icon"></i>
								<p>Terima Hadiah Asset</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('downline'); ?>" class="nav-link <?= ($this->uri->segment(1) == "downline") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-users"></i>
						<p>
							Downline
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('wallet'); ?>" class="nav-link <?= ($this->uri->segment(1) == "wallet") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-wallet"></i>
						<p>
							Wallet
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('withdraw'); ?>" class="nav-link <?= ($this->uri->segment(1) == "withdraw") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-hand-holding-usd"></i>
						<p>
							Penarikan
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('convert'); ?>" class="nav-link <?= ($this->uri->segment(1) == "convert") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-long-arrow-alt-right"></i>
						<p>
							Konversi
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('transfer'); ?>" class="nav-link <?= ($this->uri->segment(1) == "transfer") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-paper-plane"></i>
						<p>
							Transfer
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('rewards'); ?>" class="nav-link <?= ($this->uri->segment(1) == "rewards") ? "active" : ""; ?>">
						<i class="fas fa-tasks nav-icon"></i>
						<p>
							Hadiah
						</p>
					</a>
				</li>
				<li class="nav-item <?= ($this->uri->segment(1) == "log") ? "menu-is-opening menu-open" : ""; ?>">
					<a href="#" class="nav-link <?= ($this->uri->segment(1) == "log") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-scroll"></i>
						<p>
							Catatan
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('log/trade_manager'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "trade_manager") ? "active" : ""; ?>">
								<i class="fas fa-file nav-icon"></i>
								<p>Trade Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/profit_trade_manager'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "profit_trade_manager") ? "active" : ""; ?>">
								<i class="fas fa-file nav-icon"></i>
								<p>Profit Trade Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/crypto_asset'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "crypto_asset") ? "active" : ""; ?>">
								<i class="fas fa-file nav-icon"></i>
								<p>Crypto Asset</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/profit_crypto_asset'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "profit_crypto_asset") ? "active" : ""; ?>">
								<i class="fas fa-file nav-icon"></i>
								<p>Profit Crypto Asset</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/bonus_recruitment'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "bonus_recruitment") ? "active" : ""; ?>">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Bonus Sponsor</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/bonus_ql'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "bonus_ql") ? "active" : ""; ?>">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Bonus Kualifikasi Leader</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/bonus_royalty'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "bonus_royalty") ? "active" : ""; ?>">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Bonus Royalty</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/recruitment'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "recruitment") ? "active" : ""; ?>">
								<i class="fas fa-sun nav-icon"></i>
								<p>Rekrutmen</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/withdraw'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "withdraw") ? "active" : ""; ?>">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Penarikan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/convert'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "convert") ? "active" : ""; ?>">
								<i class="fas fa-long-arrow-alt-right nav-icon"></i>
								<p>Konversi</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/transfer'); ?>" class="nav-link <?= ($this->uri->segment(1) == "log" && $this->uri->segment(2) == "transfer") ? "active" : ""; ?>">
								<i class="fas fa-paper-plane nav-icon"></i>
								<p>Transfer</p>
							</a>
						</li>
						<li>
							<hr />
						</li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</aside>

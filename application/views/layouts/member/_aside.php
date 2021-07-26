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
				<span class="d-block text-white"><small><?= $this->session->userdata(SESI . 'fullname'); ?></small></span>
				<div class="btn-group">
					<a href="<?= site_url('profile'); ?>" class="btn btn-info btn-sm btn-flat text-white">
						<i class="fas fa-user"></i> Profile
					</a>
					<a href="<?= site_url('logout'); ?>" class="btn btn-danger btn-sm btn-flat text-white">
						<i class="fas fa-sign-out-alt"></i> Sign Out
					</a>
				</div>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?= site_url('dashboard'); ?>" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-coins"></i>
						<p>
							Trade Manager
							<i class="fas fa-angle-left right"></i>
							<span class="badge badge-success right"><?= $aside_count_trade_manager; ?></span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('trade_manager'); ?>" class="nav-link">
								<i class="fas fa-robot nav-icon"></i>
								<p>List Trade Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('trade_manager/add'); ?>" class="nav-link">
								<i class="fas fa-plus nav-icon"></i>
								<p>Add Trade Manager</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-house-user"></i>
						<p>
							Crypto Asset
							<i class="right fas fa-angle-left"></i>
							<span class="badge badge-success right"><?= $aside_count_crypto_asset; ?></span>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('crypto_asset'); ?>" class="nav-link">
								<i class="fas fa-list nav-icon"></i>
								<p>List Crypto Asset</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('crypto_asset/add'); ?>" class="nav-link">
								<i class="fas fa-plus nav-icon"></i>
								<p>Add Crypto Asset</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('crypto_asset/claim'); ?>" class="nav-link">
								<i class="fas fa-gift nav-icon"></i>
								<p>Claim Reward</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('downline'); ?>" class="nav-link">
						<i class="nav-icon fas fa-users"></i>
						<p>
							Downline Management
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('wallet'); ?>" class="nav-link">
						<i class="nav-icon fas fa-wallet"></i>
						<p>
							Wallet Management
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('withdraw'); ?>" class="nav-link">
						<i class="nav-icon fas fa-wallet"></i>
						<p>
							Withdraw
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= site_url('rewards'); ?>" class="nav-link">
						<i class="fas fa-tasks nav-icon"></i>
						<p>
							Rewards
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-scroll"></i>
						<p>
							Logs
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('log/trade_manager'); ?>" class="nav-link">
								<i class="fas fa-file nav-icon"></i>
								<p>Trade Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/crypto_asset'); ?>" class="nav-link">
								<i class="fas fa-file nav-icon"></i>
								<p>Crypto Asset</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/recruitment'); ?>" class="nav-link">
								<i class="fas fa-sun nav-icon"></i>
								<p>Recruitment</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/withdraw'); ?>" class="nav-link">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Withdraw</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/bonus_recruitment'); ?>" class="nav-link">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Bonus Recruitment</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/bonus_ql'); ?>" class="nav-link">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Bonus Qualification Leader</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('log/bonus_royalty'); ?>" class="nav-link">
								<i class="fas fa-wallet nav-icon"></i>
								<p>Bonus Royalty</p>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>

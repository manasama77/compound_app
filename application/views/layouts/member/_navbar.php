<nav class="main-header navbar navbar-expand navbar-dark">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
				<i class="fas fa-bars fa-fw"></i> MENU
			</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a data-fancybox="single" href="https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl=<?= hash('sha1', $this->session->userdata(SESI . 'id')) ?>&choe=UTF-8" data-caption="<?= hash('sha1', $this->session->userdata(SESI . 'id')) ?>">
				<img src="https://chart.googleapis.com/chart?cht=qr&chs=40x40&chl=<?= hash('sha1', $this->session->userdata(SESI . 'id')) ?>&choe=UTF-8" data-lazy-src="https://chart.googleapis.com/chart?cht=qr&chs=40x40&chl=<?= hash('sha1', $this->session->userdata(SESI . 'id')) ?>&choe=UTF-8" />
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-white" data-widget="fullscreen" href="#" role="button">
				<i class="fas fa-expand-arrows-alt"></i>
			</a>
		</li>
	</ul>
</nav>

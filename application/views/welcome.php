<!DOCTYPE html>
<html lang="en">

<head>
	<title><?= APP_NAME; ?> Official Website</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- owl carousel css -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/owl.carousel.min.css" />
	<!-- font awesome icons -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/font-awesome.css" />
	<!-- bootstrap css -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/bootstrap4.6.0.min.css" />
	<!-- main css -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/css/style.css" />

	<!-- favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url(); ?>public/img/public/img/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url(); ?>public/img/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url(); ?>public/img/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>public/img/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url(); ?>public/img/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url(); ?>public/img/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url(); ?>public/img/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>public/img/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>public/img/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url(); ?>public/img/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>public/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url(); ?>public/img/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>public/img/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url(); ?>manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?= base_url(); ?>public/img/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>

<body>
	<!-- preloader start -->
	<div class="preloader">
		<span></span>
	</div>
	<!-- preloader end -->

	<!-- navbar start -->
	<nav class="navbar navbar-expand-lg fixed-top">
		<div class="container">
			<!-- Brand -->
			<a class="navbar-brand" href="<?= site_url(); ?>">
				<div class="navbar-brand-img">
					<img src="<?= base_url(); ?>public/img/logo.png" alt="<?= APP_NAME; ?> Logo">
				</div>
			</a>

			<!-- Toggler/collapsibe Button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<i class="fas fa-bars"></i>
			</button>

			<!-- Navbar links -->
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link active" href="#" data-scroll-nav="0">home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" data-scroll-nav="1">what is <?= APP_NAME; ?>?</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" data-scroll-nav="2">profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" data-scroll-nav="3">stacking</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#" data-scroll-nav="4">our teams</a>
					</li>
					<!-- <li class="nav-item">
                        <a class="nav-link" href="#" data-scroll-nav="5">timeline</a>
                    </li> -->
					<li class="nav-item">
						<a class="nav-link" href="javascript:;" onclick="comingSoon();">Marketplace</a>
					</li>
					<li class="nav-item">
						<a class="nav-link font-weight-bold" href="<?= site_url(); ?>login"><i class="fas fa-sign-in-alt fa-fw"></i> Sign In</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- navbar end -->

	<!-- home section start -->
	<section id="home" class="home d-flex align-items-center" data-scroll-index="0">
		<div class="effect-wrap">
			<i class="fas fa-plus effect effect-1"></i>
			<i class="fas fa-plus effect effect-2"></i>
			<i class="fas fa-circle-notch effect effect-3"></i>
		</div>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-7">
					<div class="home-text">
						<h1>The Derivates Liquidity Protocol</h1>
						<p>The <?= APP_NAME; ?> token is DeFi who use decentralization blockchain method. Enabling anyone,
							anywhere to join a pool of
							liquidity to build your asset or trading an asset.</p>
						<div class="home-btn">
							<a href="<?= site_url(); ?>member/signup" class="btn btn-1"><i class="fas fa-file-signature fa-fw"></i> Join Now</a>
							<a href="<?= site_url(); ?>member/signin" class="btn btn-1"><i class="fas fa-sign-in-alt fa-fw"></i> Sign In</a>
							<a href="<?= base_url(); ?>public/pdf/white_paper_bioner.pdf" target="_blank" class="btn btn-1"><i class="fas fa-newspaper fa-fw"></i> White
								Paper</a>
							<!-- <button type="button" class="btn btn-1 video-play-btn">
                                <i class="fas fa-play"></i>
                            </button> -->
						</div>
					</div>
				</div>
				<div class="col-md-5 text-center">
					<div class="home-img">
						<div class="circle"></div>
						<img src="<?= base_url(); ?>public/img/app-screenshots/1.png" alt="bioner apps">
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- home section end -->

	<!-- about us section start -->
	<section id="about-us" class="about-us section-padding" data-scroll-index="1">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-lg-6 d-flex align-items-center justify-content-center">
					<div class="about-us-img">
						<img src="<?= base_url(); ?>public/img/app-screenshots/2.png" alt="bnr x trx" />
					</div>
				</div>
				<div class="col-md-7 col-lg-6">
					<div class="section-title">
						<h2>what is <span>bioner ?</span></h2>
						<h1>bioner is an asset published on a decentralized
							protocol built on top of the Tron blockchain</h1>
					</div>
					<div class="about-us-text">
						<p><?= APP_NAME; ?> (BNR) token are part of crypto coin who issued on Tron (TRX) Network, <?= APP_NAME; ?> token
							secured and locked by Smart Contract. Allows users to perform direct conversion between BNR
							to another tokens or other
							crypto coins in smart
							contracts. <?= APP_NAME; ?> token use liquidity pool method, it allow anyone participate as investor
							to join as part of <?= APP_NAME; ?>
							family, stacking their asset to ensure grow up of BNR. Investor who risk their stack asset
							on BNR will get fees based on
							their proportion percentage shares on liquidity pool for every transaction on BNR token.
							Also you can join as short term
							trader or long term trader.
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- about us section end -->

	<!-- profile section start -->
	<section id="profile" class="profile section-padding" data-scroll-index="2">
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-lg-6">
					<div class="section-title">
						<h2><?= APP_NAME; ?> <span>Profile</span></h2>
						<h1><?= APP_NAME; ?> Token (BNR) Built on Tron Blockchain</h1>
					</div>
					<div class="profile-text">
						<p><?= APP_NAME; ?> is the IDR-pegged stablecoin issued by <?= APP_NAME; ?> on the TRON network. The token will be
							able to complete issuance, holding and transfer via smart contract on TRON, with a
							completely free and transparent process, and instant delivery, it will also be able to write
							programs that are highly expansible based on smart contract. TRC20 based <?= APP_NAME; ?> enables
							interoperability with TRON-based protocols and Decentralised Applications (DApps) while
							allowing users to transact and exchange fiat pegged currencies across the TRON Network.
						</p>
						<button type="button" class="btn btn-primary" onclick="showModalTokenDetail();"><?= APP_NAME; ?> Token
							Detail</button>
						<a href="https://bioner.online/public/pdf/white_paper_bioner.pdf" target="_blank" class="btn btn-info">Whitepaper</a>
					</div>
				</div>
				<div class="col-md-5 col-lg-6 d-flex align-items-center justify-content-center">
					<div class="profile-img">
						<img src="<?= base_url(); ?>public/img/app-screenshots/4.png" alt="trx blockchain" />
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- profile section end -->

	<!-- stacking section start -->
	<section id="stacking" class="stacking section-padding" data-scroll-index="3">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="section-title">
						<h2><?= APP_NAME; ?> <span>stacking</span></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-lg-6 d-flex align-items-center justify-content-center">
					<div class="stacking-img">
						<img src="<?= base_url(); ?>public/img/app-screenshots/3.png" alt="bnr x trx stacking" />
						<!-- <a href='https://www.freepik.com/photos/phone'>Phone photo created by drobotdean - www.freepik.com</a> -->
					</div>
				</div>
				<div class="col-md-7 col-lg-6">
					<div class="stacking-text">
						<h2>Stacking <span>Reward</span></h2>
						<p>The primary function of BNR is to protect the integrity of <?= APP_NAME; ?> mechanisms by locking
							value within the <?= APP_NAME; ?> ecosystem through staking. <br>
							However, in providing network security, BNR holders and delegators are exposed to the risks
							of maintaining a long-term position on a fluctuating asset. Staking rewards therefore
							provide the incentives to keep long-term interest in BNR ownership.
							In the <?= APP_NAME; ?> protocol, staking rewards are first distributed to validators who take a
							commission for providing their operations, and then are withdrawn individually by
							delegators.<br>
							Rewards from stake are determined largely by the relative size of node, and are structured
							in such a way that rewards increase as nodes increases. BNR ownership is thus an investment
							in the long term growth of <?= APP_NAME; ?>.<br>
							Staking rewards come from three sources: Energy (compute fees), Taxes, and Voting Validator
							Rewards.
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- stacking section end -->


	<!-- team member start -->
	<section id="team" class="team section-padding" data-scroll-index="4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="section-title">
						<h2>team <span>member</span></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="owl-carousel team-carousel">
					<div class="team-item text-center">
						<div class="text-center">
							<img src="<?= base_url(); ?>public/img/team/1.png" alt="h. alif" class="img-thumbnail">
						</div>
						<h3>H. Alif</h3>
						<span>Founder</span>
					</div>
					<div class="team-item text-center">
						<img src="<?= base_url(); ?>public/img/team/2.png" alt="h. abdul" class="img-thumbnail">
						<h3>H. Abdul</h3>
						<span>CEO</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- team member end -->

	<!-- timeline start -->
	<!-- <section id="timeline" class="timeline section-padding" data-scroll-index="5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>The <span>Timeline</span></h2>
                        <p>With help from our teams, contributors and investors these are the
                            milestones we are looking forward to achieve.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel timeline-carousel">
                    <div class="timeline-item">
                        <div class="step">Q4 2020</div>
                        <p>
                            <span class="text-danger"><?= APP_NAME; ?> PHASE 1</span>
                            Product Dev<br>
                            Deploy <?= APP_NAME; ?> Token<br>
                        </p>
                    </div>
                    <div class="timeline-item">
                        <div class="step">Q1 2020</div>
                        <p>
                            Released <?= APP_NAME; ?> Webbased<br>
                            Registered KEMENKUMHAM<br>
                            Deploy <?= APP_NAME; ?> Mobile Apps<br>
                            Deploy <?= APP_NAME; ?> Dapps<br>
                            Registered <?= APP_NAME; ?> Merchant<br>
                            Registered <?= APP_NAME; ?> Supplyer<br>
                        </p>
                    </div>
                    <div class="timeline-item">
                        <div class="step">Q2 2020</div>
                        <p>
                            <span class="text-danger"><?= APP_NAME; ?> PHASE 2</span>
                            Licensed KEMENKUMHAM<br>
                            Registered ISO 9001<br>
                            Registered ISO 27001<br>
                            Registered BAPPEBTI<br>
                            Registered OJK<br>
                        </p>
                    </div>
                    <div class="timeline-item">
                        <div class="step">Q3 2020</div>
                        <p>
                            Licensed ISO 9001<br>
                            Licensed ISO 27001<br>
                            Licensed BAPPEBTI<br>
                            Licensed OJK<br>
                            Released <?= APP_NAME; ?> Token<br>
                            Released <?= APP_NAME; ?> Project<br>
                            Trial <?= APP_NAME; ?> Mobile Apps<br>
                            Registered <?= APP_NAME; ?> Token to Global Exchange<br>
                            Registered <?= APP_NAME; ?> Token to CMC<br>
                        </p>
                    </div>
                    <div class="timeline-item">
                        <div class="step">Q4 2021</div>
                        <p>
                            Released <?= APP_NAME; ?> Token in Global Exchange<br>
                            Released <?= APP_NAME; ?> Token in CMC<br>
                            Released <?= APP_NAME; ?> Mobile Apss<br>
                            GRAND LAUNCHING <?= APP_NAME; ?><br>
                            Started <?= APP_NAME; ?> Blockchain Project<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
	<!-- timeline end -->

	<!-- as-seen section start -->
	<section class="as-seen section-padding">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="section-title">
						<h2>As Seen <span>In</span></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="owl-carousel as-seen-carousel">
					<div class="as-seen-item">
						<a href="https://github.com/<?= APP_NAME; ?>-Token" target="_blank">
							<img src="<?= base_url(); ?>public/img/github_PNG15.png" alt="GITHUB" class="img-fluid mx-auto d-block">
						</a>
					</div>
					<div class="as-seen-item">
						<a href="https://tronscan.io/#/token20/TU9PmX8ivxMScQSWq67xHMHL8KBUTSyFwV" target="_blank">
							<img src="<?= base_url(); ?>public/img/tronscan.png" alt="TRONSCAN" class="img-fluid mx-auto d-block">
						</a>
					</div>
					<div class="as-seen-item">
						<a href="https://justswap.io/#/home" target="_blank">
							<img src="<?= base_url(); ?>public/img/justswap.png" alt="JUSTSWAP" class="img-fluid mx-auto d-block">
						</a>
					</div>
					<div class="as-seen-item">
						<a href="https://www.tronlink.org/" target="_blank">
							<img src="<?= base_url(); ?>public/img/tronlink.png" alt="TRONLINK" class="img-fluid mx-auto d-block">
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- as-seen section end -->

	<!-- contact section start -->
	<section class="contact section-padding" data-scroll-index="6">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="section-title">
						<h2>get in <span>touch</span></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-lg-4">
					<div class="contact-info">
						<h3>For Any Queries and Support</h3>
						<div class="contact-info-item">
							<i class="fas fa-location-arrow"></i>
							<h4>Company Location</h4>
							<p>
								<a href="https://www.google.com/search?q=bioner&safe=strict&rlz=1C1CHZN_enID906ID906&ei=pFZnYKiWB56H4-EPq--9iAc&oq=bioner&gs_lcp=Cgdnd3Mtd2l6EAMyBwgAEMkDEAoyBQgAEJIDMgUIABCSAzICCAAyAggAMgIIADIECAAQCjICCAAyBAgAEAoyAggAOgcIABBHELADUKYXWLsYYN0ZaAFwAXgAgAGrAYgBrgOSAQMwLjOYAQCgAQGqAQdnd3Mtd2l6yAEIwAEB&sclient=gws-wiz&ved=2ahUKEwjE44CRjeDvAhU4yDgGHdPdAdQQvS4wAHoECAQQLg&uact=5&tbs=lf:1,lf_ui:2&tbm=lcl&rflfq=1&num=10&rldimm=147105881091625054&lqi=CgZiaW9uZXJaEAoGYmlvbmVyIgZiaW9uZXKSARBjb21tdW5pdHlfY2VudGVyqgEOEAEqCiIGYmlvbmVyKAA&rlst=f#rlfi=hd:;si:147105881091625054,l,CgZiaW9uZXJaEAoGYmlvbmVyIgZiaW9uZXKSARBjb21tdW5pdHlfY2VudGVyqgEOEAEqCiIGYmlvbmVyKAA;mv:[[52.0709155,-118.1531556],[-33.7945478,133.42145739999998]];tbs:lrf:!1m4!1u3!2m2!3m1!1e1!1m4!1u2!2m2!2m1!1e1!2m1!1e2!2m1!1e3!3sIAE,lf:1,lf_ui:2">
									Jl. Pasir Kuda Raya Blok Jabaru 2 No.175, RT.04/RW.04, Pasirkuda, West Bogor, Bogor City, West Java 16119
								</a>
							</p>
						</div>
						<div class="contact-info-item">
							<i class="fas fa-envelope"></i>
							<h4>Write to us at</h4>
							<p>
								<a href="mailto:admin@bioner.online">
									admin@bioner.online
								</a>
							</p>
						</div>
						<div class="contact-info-item">
							<i class="fas fa-phone"></i>
							<h4>Call us on</h4>
							<p>
								<a href="https://wa.me/<?= WA_ADMIN; ?>">
									<?= WA_ADMIN2; ?>
								</a>
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-lg-8">
					<div class="contact-form">
						<form id="form_guestbook">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Your Name" id="nama" name="nama" required>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<input type="email" class="form-control" placeholder="Your Email" id="email" name="email" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<input type="tel" class="form-control" placeholder="Your Phone" id="phone" name="phone" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Subject" id="subject" name="subject" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<textarea class="form-control" placeholder="Your Message" id="pesan" name="pesan" required></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<button type="submit" class="btn btn-2">Send Mesasge</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- contact section end -->

	<!-- footer section start -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-3">
					<div class="footer-col">
						<h3>About us</h3>
						<p><?= APP_NAME; ?> Is An Asset Published On A Decentralized Protocol Built On Top Of The Tron Blockchain
						</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="footer-col">
						<h3>Apps</h3>
						<ul>
							<li>
								<a href="<?= site_url(); ?>member/signin">Sign in <?= APP_NAME; ?></a>
							</li>
							<li>
								<a href="<?= site_url(); ?>member/signup">Sign up <?= APP_NAME; ?></a>
							</li>
							<li>
								<a href="https://tronscan.io/#/token20/TU9PmX8ivxMScQSWq67xHMHL8KBUTSyFwV" target="_blank">Tronlink</a>
							</li>
							<li>
								<a href="https://justswap.io" target="_blank">Justswap</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="footer-col">
						<h3>Quick Links</h3>
						<ul>
							<li>
								<a href="#home">Home</a>
							</li>
							<li>
								<a href="#about-us">What is <?= APP_NAME; ?>?</a>
							</li>
							<li>
								<a href="#profile">Profile</a>
							</li>
							<li>
								<a href="#stacking">Stacking</a>
							</li>
							<li>
								<a href="#team">Our Teams</a>
							</li>
							<!-- <li>
                                <a href="#timeline">Timeline</a>
                            </li> -->
							<li>
								<a href="javascript:;" onclick="comingSoon();">Marketplace</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="footer-col">
						<h3>Social Pages</h3>
						<ul>
							<li>
								<a href="https://github.com/<?= APP_NAME; ?>-Token" target="_blank">Github</a>
							</li>
							<li>
								<a href="https://web.facebook.com/bionercoin" target="_blank">Facebook</a>
							</li>
							<li>
								<a href="https://t.me/joinchat/1cIjWvGCyjI0ODdl" target="_blank">Telegram</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 text-white">
					<p class="copyright-text">
					<div class="float-right d-none d-sm-block">
						version <?= APP_VERSION; ?>
					</div>
					<strong>Copyright &copy; 2021 <a href=" <?= site_url(); ?>" class="footer_link"><?= APP_NAME; ?> Online</a></strong>
					</p>
				</div>
			</div>
		</div>
	</footer>
	<!-- footer section end -->

	<!-- toggle theme start -->
	<div class="toggle-theme">
		<i class="fas"></i>
	</div>
	<!-- toggle theme end -->


	<!-- video popup start -->
	<div class="video-popup">
		<div class="video-popup-inner">
			<i class="fas fa-times video-popup-close"></i>
			<div class="iframe-box">
				<!-- <iframe id="player-1" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
			</div>
		</div>
	</div>
	<!-- video popup end -->

	<!-- bioner token detail start -->
	<div class="modal fade" id="bioner_token_detail" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle"><?= APP_NAME; ?> Token Detail</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" style="font-size: 12px;">
							<thead>
								<tr>
									<th>Token Name</th>
									<th>:</th>
									<th><?= APP_NAME; ?></th>
								</tr>
								<tr>
									<th>Ticker Name</th>
									<th>:</th>
									<th>BNR</th>
								</tr>
								<tr>
									<th>Mainnet</th>
									<th>:</th>
									<th>Tron Blockchain</th>
								</tr>
								<tr>
									<th>Precision</th>
									<th>:</th>
									<th>4</th>
								</tr>
								<tr>
									<th>Total Supply</th>
									<th>:</th>
									<th>100,000,000 BNR</th>
								</tr>
								<tr>
									<th>Circulating Supply</th>
									<th>:</th>
									<th>100,000,000 BNR</th>
								</tr>
								<tr>
									<th>Reputation</th>
									<th>:</th>
									<th>Neutral</th>
								</tr>
								<tr>
									<th>Smart Contract Type</th>
									<th>:</th>
									<th>Smart Contract TRC-20 Proof of Stake Currencies</th>
								</tr>
								<tr>
									<th>Contract</th>
									<th>:</th>
									<th>
										<a href="https://tronscan.io/#/token20/TU9PmX8ivxMScQSWq67xHMHL8KBUTSyFwV" target="_blank">
											TU9PmX8ivxMScQSWq67xHMHL8KBUTSyFwV
										</a>
									</th>
								</tr>
								<tr>
									<th>Compiler Version</th>
									<th>:</th>
									<th>solidity 0.5.10</th>
								</tr>
								<tr>
									<th>Issuing Time</th>
									<th>:</th>
									<th>2021-01-29 16:17:56 (UTC)</th>
								</tr>
								<tr>
									<th>Issuer</th>
									<th>:</th>
									<th>
										<a href="https://tronscan.io/#/address/TGvYiVbMzczALgf7YmjYoxGP3bLkqMTATH" target="_blank">
											TGvYiVbMzczALgf7YmjYoxGP3bLkqMTATH
										</a>
									</th>
								</tr>
								<tr>
									<th>Official Website</th>
									<th>:</th>
									<th>
										<a href="https://bioner.online">
											https://bioner.online
										</a>
									</th>
								</tr>
								<tr>
									<th>White Paper</th>
									<th>:</th>
									<th>
										<a href="https://bioner.online/public/pdf/white_paper_bioner.pdf" target="_blank">
											https://bioner.online/public/pdf/white_paper_bioner.pdf
										</a>
									</th>
								</tr>
								<tr>
									<th>Social Profiles</th>
									<th>:</th>
									<th>
										<a href="https://web.facebook.com/bionercoin" target="_blank">
											<i class="fab fa-facebook fa-2x"></i>
										</a>
										<a href="https://t.me/joinchat/1cIjWvGCyjI0ODdl" target="_blank">
											<i class="fab fa-telegram fa-2x"></i>
										</a>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- bioner token detail end -->

	<input type="hidden" id="site_url" value="<?= site_url(); ?>" />

	<!-- jquery js -->
	<script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
	<!-- popper js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<!-- bootstrap js -->
	<script src="<?= base_url(); ?>public/js/bootstrap4.6.0.min.js"></script>
	<!-- owl carousel js -->
	<script src="<?= base_url(); ?>public/js/owl.carousel.min.js"></script>
	<!-- ScrollIt js -->
	<script src="<?= base_url(); ?>public/js/scrollIt.min.js"></script>
	<!-- sweetalert2 -->
	<script src="<?= base_url(); ?>public/js/sweetalert2.all.min.js"></script>
	<!-- blockui -->
	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<!-- main js -->
	<script src="<?= base_url(); ?>public/js/main.js"></script>

</body>

</html>

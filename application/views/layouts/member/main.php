<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('layouts/member/_head'); ?>

<?php
if (isset($vitamin_css)) {
	$this->load->view('pages/member/' . $vitamin_css);
}
?>

<body class="control-sidebar-slide-open layout-fixed sidebar-mini-sm text-sm" style="height: auto;">
	<div class="wrapper">

		<!-- Preloader -->
		<?php //$this->load->view('layouts/member/_preloader');
		?>
		<!-- /.Preloader -->

		<!-- Navbar -->
		<?php $this->load->view('layouts/member/_navbar'); ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php $this->load->view('layouts/member/_aside'); ?>
		<!-- /.Main Sidebar Container -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<h5 class="marquee bg-dark py-2" style="display: none; font-size: 14px;">
				<span class="mx-2">- USDT/RATU : 1</span>
				<span class="mx-2">- USDT/IDR : 1</span>
				<span class="mx-2">- TRX/IDR : 1</span>
			</h5>
			<?php $this->load->view('pages/member/' . $content); ?>
		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<?php $this->load->view('layouts/member/_footer'); ?>
	</div>
	<!-- ./wrapper -->

	<form id="form_otp">
		<div class="modal fade" id="modal_otp" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">OTP</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="otp">OTP</label>
							<input type="text" class="form-control" id="otp" name="otp" minlength="6" maxlength="6" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery 3.5 -->
	<script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4.6 -->
	<script src="<?= base_url(); ?>vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.js"></script>

	<!-- overlayScrollbars -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

	<!-- PAGE PLUGINS -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/raphael/raphael.min.js"></script>
	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<script src="<?= base_url(); ?>public/js/sweetalert2.min.js"></script>
	<script src="<?= base_url(); ?>public/js/toastr.min.js"></script>


	<!-- DataTables  & Plugins -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jszip/jszip.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/select2/js/select2.full.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
</body>

</html>


<?php
if (isset($vitamin_js)) {
	$this->load->view('pages/member/' . $vitamin_js);
}
?>

<script>
	$(document).ready(function() {
		(function($) {
			$.fn.textWidth = function() {
				var calc = '<span style="display:none">' + $(this).text() + '</span>';
				$('body').append(calc);
				var width = $('body').find('span:last').width();
				$('body').find('span:last').remove();
				return width;
			};

			$.fn.marquee = function(args) {
				var that = $(this);
				var textWidth = that.textWidth(),
					offset = that.width(),
					width = offset,
					css = {
						'text-indent': that.css('text-indent'),
						'overflow': that.css('overflow'),
						'white-space': that.css('white-space')
					},
					marqueeCss = {
						'text-indent': width,
						'overflow': 'hidden',
						'white-space': 'nowrap'
					},
					args = $.extend(true, {
						count: -1,
						speed: 1e1,
						leftToRight: false
					}, args),
					i = 0,
					stop = textWidth * -1,
					dfd = $.Deferred();

				function go() {
					if (!that.length) return dfd.reject();
					if (width <= stop) {
						i++;
						if (i == args.count) {
							that.css(css);
							return dfd.resolve();
						}
						if (args.leftToRight) {
							width = textWidth * -1;
						} else {
							width = offset;
						}
					}
					that.css('text-indent', width + 'px');
					if (args.leftToRight) {
						width++;
					} else {
						width--;
					}
					setTimeout(go, args.speed);
				};
				if (args.leftToRight) {
					width = textWidth * -1;
					width++;
					stop = offset;
				} else {
					width--;
				}
				that.css(marqueeCss);
				go();
				return dfd.promise();
			};
		})(jQuery);

		setTimeout(function() {
			$('.marquee').fadeIn();
			$('.marquee').marquee();
		}, 1000);
	});


	Fancybox.bind("[data-fancybox]", {
		Image: {
			zoom: false,
		},
		Thumbs: true,
		Toolbar: false,
		closeButton: 'outside',
		autoFocus: true
	});

	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			} else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			} else {
				this.value = "";
			}
		});
	};

	$("#otp").inputFilter(function(value) {
		return /^\d*$/.test(value); // Allow digits only, using a RegExp
	});

	$('.select2').select2({
		theme: 'bootstrap4'
	});

	function otpAuth() {
		return $.ajax({
			url: '<?= site_url('otp_auth'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				otp: $('#otp').val(),
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			beforeSend: function(e) {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				html: e.responseText,
			});
			console.log(e);
		});
	}

	function sendOTP() {
		return $.ajax({
			url: '<?= site_url('otp_resend'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
			},
			beforeSend: function() {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
			if (e.responseText != '') {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
			}
		});
	}

	function CopyUrl(id) {
		let copyText = document.getElementById(id);
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		document.execCommand("copy");

		Swal.fire({
			position: 'top-end',
			icon: 'success',
			text: 'Copy Berhasil',
			showConfirmButton: false,
			toast: true,
			timer: 3000,
			timerProgressBar: true,
		});
	}

	function comingSoon() {
		Swal.fire({
			position: 'top-end',
			icon: 'warning',
			text: 'Coming Soon',
			showConfirmButton: false,
			toast: true,
			timer: 3000,
			timerProgressBar: true,
		});
	}
</script>

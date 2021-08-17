<script>
	$(document).ready(function() {
		$('.bond_tooltip').tooltip({
			boundary: 'window'
		})

		$("#table_data").DataTable({
			dom: 'Brtip',
			scrollX: "300px",
			scrollY: "300px",
			order: [
				[0, 'desc']
			],
			responsive: false,
			lengthChange: false,
			autoWidth: false,
			buttons: [
				"copy",
				"csv",
				{
					extend: 'excelHtml5',
					text: 'Excel',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Trade Manager - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					filename: "Trade Manager - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
						modifier: {
							page: 'all'
						},
					}
				},
				{
					extend: 'pdfHtml5',
					text: 'PDF',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Trade Manager - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					filename: "Trade Manager - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
						modifier: {
							page: 'all'
						},
					}
				}
			],
			columnDefs: [{
				targets: [9],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

		$('#form_extend').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('trade_manager/update_extend'); ?>',
				method: 'post',
				dataType: 'json',
				data: $('#form_extend').serialize(),
				beforeSend: function() {
					$.blockUI({
						message: `<i class="fas fa-spinner fa-spin"></i>`
					});
				}
			}).always(function(e) {
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
			}).done(function(e) {
				console.log(e);
				if (e.code == 500 || e.code == 400) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: e.status_text,
					}).then(() => {
						window.location.reload();
					});
				} else if (e.code == 200) {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil...',
						html: e.status_text,
					}).then(() => {
						window.location.reload();
					});
				}
			});
		});
	});

	function showDetail(invoice) {
		$.ajax({
			url: '<?= site_url('trade_manager/detail'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				invoice: invoice,
			},
			beforeSend: function() {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function(e) {
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
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.status_text,
				});
			} else if (e.code == 200) {
				$('#package').html(e.result.package_name);
				$('#amount').html(e.result.amount_1 + " <small>USDT</small>");
				$('#created_at').html(e.result.created_at);

				if (e.result.state == "active" || e.result.state == "expired") {
					$('#expired_at').html(`${e.result.expired_package} 00:00:00`);
					$('#is_extend').html(e.result.is_extend.toUpperCase());
				} else {
					$('#expired_at').html(`-`);
					$('#is_extend').html('-');
				}
				$('#state').html(e.result.state_badge);

				let profit_montly_text = `${e.result.profit_per_month_value} <small>USDT</small> (${e.result.profit_per_month_percent}%)`;
				let profit_daily_text = `${e.result.profit_per_day_value} <small>USDT</small> (${e.result.profit_per_day_percentage}%)`;
				let profit_self_text = `${e.result.share_self_value} <small>USDT per day</small> (${e.result.share_self_percentage}%)`;
				let profit_upline_text = `${e.result.share_upline_value} <small>USDT per day</small> (${e.result.share_upline_percentage}%)`;
				let profit_company_text = `${e.result.share_company_value} <small>USDT per day</small> (${e.result.share_company_percentage}%)`;
				let payment_text = `CoinPayments TXID <small>${e.result.txn_id}</small><br/>Total Transfer ${e.result.amount_2} <small>${e.result.currency2}</small>`;

				$('#profit_monthly').html(profit_montly_text);
				$('#profit_daily').html(profit_daily_text);
				$('#profit_self').html(profit_self_text);
				$('#profit_upline').html(profit_upline_text);
				$('#profit_company').html(profit_company_text);
				$('#payment').html(payment_text);
				$('#modal_detail').modal('show');
			}
		});
	}

	function showExtend(invoice, package, is_extend) {
		$('#package_extend').text(package);
		$('#invoice_extend').val(invoice);
		$('#is_extend_mode').val(is_extend);
		$('#modal_extend').modal('show');
	}
</script>

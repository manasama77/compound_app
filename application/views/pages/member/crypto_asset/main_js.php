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
					title: "Crypto Asset - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					filename: "Crypto Asset - <?= $this->session->userdata(SESI . 'fullname'); ?>",
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
					title: "Crypto Asset - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					filename: "Crypto Asset - <?= $this->session->userdata(SESI . 'fullname'); ?>",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, ],
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
	});

	function showDetail(invoice) {
		$.ajax({
			url: '<?= site_url('crypto_asset/detail'); ?>',
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
				} else {
					$('#expired_at').html(`-`);
				}
				$('#state').html(e.result.state_badge);

				let amount_profit_text = `${e.result.amount_profit} <small>USDT</small>`;
				let profit_montly_text = `${e.result.profit_per_month_value} <small>USDT</small> (${e.result.profit_per_month_percent}%)`;
				let profit_daily_text = `${e.result.profit_per_day_value} <small>USDT</small> (${e.result.profit_per_day_percentage}%)`;
				let profit_self_text = `${e.result.share_self_value} <small>USDT per day</small> (${e.result.share_self_percentage}%)`;
				let profit_upline_text = `${e.result.share_upline_value} <small>USDT per day</small> (${e.result.share_upline_percentage}%)`;
				let profit_company_text = `${e.result.share_company_value} <small>USDT per day</small> (${e.result.share_company_percentage}%)`;
				let payment_text = `CoinPayment - <small>${e.result.txn_id}</small><br/>Amount Transfer ${e.result.amount_2} <small>${e.result.currency2}</small>`;

				$('#amount_profit').html(amount_profit_text);
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

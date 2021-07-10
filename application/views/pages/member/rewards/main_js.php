<script>
	$('#document').ready(function() {
		$("#table_data").DataTable({
			// "scrollX": "300px",
			// "scrollY": "300px",
			order: [
				[0, 'asc']
			],
			responsive: true,
			lengthChange: false,
			autoWidth: false,
			buttons: ["copy", "csv", "excel", "pdf"],
			columnDefs: [{
				targets: [6],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');
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
				$.blockUI();
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
					text: e.status_text,
				});
			} else if (e.code == 200) {
				$('#amount_usd').html(e.result.amount_usd);
				$('#contract_duration').html(e.result.contract_duration);
				$('#profit_monthly').html(e.result.profit_monthly);
				$('#profit_daily').html(e.result.profit_daily);
				$('#profit_self').html(e.result.profit_self);
				$('#profit_upline').html(e.result.profit_upline);
				$('#profit_company').html(e.result.profit_company);
				$('#modal_detail').modal('show');
			}
		});
	}
</script>

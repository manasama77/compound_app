<script>
	let defaultVTradeManager = `
	<tr>
		<td	td colspan="5" class="text-center align-middle">-No Package Active-</td>
	</tr>`;

	let defaultVDownline = `
	<tr>
		<td colspan="7" class="text-center align-middle">-No Downline Data-</td>
	</tr>`;

	$(document).ready(function() {
		$("#table_data").DataTable({
			"scrollX": "300px",
			"scrollY": "300px",
			order: [
				[0, 'asc']
			],
			responsive: false,
			lengthChange: false,
			autoWidth: false,
			buttons: ["copy", "csv", "excel", "pdf"],
			columnDefs: [{
				targets: [8],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

		$("#depth").val('<?= $this->input->get('depth'); ?>');
	});

	function CopyUrl() {
		let copyText = document.getElementById("recruitment_link");
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		document.execCommand("copy");

		Swal.fire({
			position: 'top-end',
			icon: 'success',
			text: 'Copied Recruitment Link',
			showConfirmButton: true,
			timer: 2000,
			timerProgressBar: true,
		});
	}

	function showModalDownline(id_member, fullname) {

		$.ajax({
			url: '<?= site_url('dashboard/downline_detail'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				id_member: id_member
			},
			beforeSend: function() {
				$.blockUI();
				$('#v_trade_manager').html(defaultVTradeManager);
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
			if (e.code == 200) {
				let newVTradeManager = defaultVTradeManager;
				if (e.data_package.length > 0) {
					newVTradeManager = "";
					$.each(e.data_package, function(i, k) {
						newVTradeManager += `
						<tr>
							<td>${k.package}</td>
							<td>${k.amount}</td>
							<td>${k.profit_per_day}</td>
							<td>${k.duration}</td>
							<td>${k.status}</td>
						</tr>
						`;
					});
				}

				let newVDownline = defaultVDownline;
				if (e.data_downline.length > 0) {
					newVDownline = "";
					$.each(e.data_downline, function(i, k) {
						newVDownline += `
						<tr>
							<td>${k.fullname}</td>
							<td>${k.email}</td>
							<td>${k.phone_number}</td>
							<td>${k.fullname_upline}<br/><small>${k.email_upline}</small></td>
							<td>
								<span class="badge badge-primary">
									<i class="fas fa-sun"></i> ${k.generation}
								</span>
							</td>
							<td class="text-right">${k.total_omset} <small>USDT</small></td>
							<td class="text-center">${k.total_downline}</td>
						</tr>
						`;
					});
				}
				$('#name_downline').text(fullname);
				$('#v_trade_manager').html(newVTradeManager);
				$('#v_downline').html(newVDownline);
				$('#modal_detail').modal('show');
			}
		});
	}
</script>

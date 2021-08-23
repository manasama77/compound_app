<script>
	$('#document').ready(function() {
		$("#table_data").DataTable({
			scrollX: "300px",
			scrollY: "300px",
			order: [
				[4, 'asc']
			],
			responsive: false,
			lengthChange: false,
			autoWidth: false,
			buttons: [{
					extend: 'copy',
					text: 'Copy',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Founder",
					filename: "Founder",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
						modifier: {
							page: 'all'
						},
					}
				},
				{
					extend: 'csv',
					text: 'CSV',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Founder",
					filename: "Founder",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
						modifier: {
							page: 'all'
						},
					}
				},
				{
					extend: 'excelHtml5',
					text: 'Excel',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Founder",
					filename: "Founder",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
					title: "Founder",
					filename: "Founder",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
						modifier: {
							page: 'all'
						},
					}
				}
			],
			columnDefs: [{
				targets: [0],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');
	});
</script>

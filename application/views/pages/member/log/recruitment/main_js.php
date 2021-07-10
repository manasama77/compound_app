<script>
	$('#document').ready(function() {
		$("#table_data").DataTable({
			// "scrollX": "300px",
			// "scrollY": "300px",
			order: [
				[1, 'asc']
			],
			responsive: true,
			lengthChange: false,
			autoWidth: false,
			buttons: ["copy", "csv", "excel", "pdf"],
			columnDefs: [{
				targets: [0],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');
	});
</script>

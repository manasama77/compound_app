<script>
	$('#document').ready(function() {
		$("#table_data").DataTable({
			"scrollX": "300px",
			"scrollY": "300px",
			order: [
				[0, 'desc']
			],
			responsive: false,
			lengthChange: false,
			autoWidth: false,
			buttons: ["copy", "csv", "excel", "pdf"],
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');
	});
</script>

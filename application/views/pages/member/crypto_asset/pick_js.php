<script>
	$(document).ready(function() {
		$('#form_submit').on('submit', function(e) {
			$.blockUI();
			$('#submit').attr('disabled', true);
		});
	});
</script>

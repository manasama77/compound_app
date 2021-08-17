<script>
	$(document).ready(function() {
		$('#form_submit').on('submit', function(e) {
			$.blockUI({
				message: `<i class="fas fa-spinner fa-spin"></i>`
			});
			$('#submit').attr('disabled', true);
		});
	});
</script>

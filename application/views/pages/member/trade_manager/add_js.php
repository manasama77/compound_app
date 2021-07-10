<script>
	$(document).ready(function() {
		$('#amount').on('change', function(e) {
			updateProfit();
		});
	});
</script>

<script>
	function updateProfit() {
		let amount = $('#amount').val();
		let profit_monthly_percent = $('#profit_monthly_percent').val();
		let profit_monthly_value = $('#profit_monthly_value').val();
		let profit_daily_percentage = $('#profit_daily_percentage').val();
		let profit_daily_value = $('#profit_daily_value').val();

		if (amount > 0) {
			if (profit_monthly_percent != null || profit_monthly_percentage > 0) {
				profit_daily_value = amount
			}
		}
	}
</script>

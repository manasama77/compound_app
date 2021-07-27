<script>
	$(document).ready(function() {
		if ('<?= str_replace(UYAH, "", base64_decode($id_package)); ?>' == "6") {
			$('#total_transfer').on('change', function(e) {
				let total_transfer = $('#total_transfer').val();
				let profit_per_month_value = (total_transfer * 15) / 100;
				let profit_per_day_value = profit_per_month_value / 30;
				let self_share = (profit_per_day_value * 90) / 100;
				let upline_share = (profit_per_day_value * 5) / 100;
				let company_share = (profit_per_day_value * 5) / 100;

				$('#total_investment').html(total_transfer);
				$('#profit_per_day_x').html(profit_per_day_value);
				$('#self_share').html(self_share);
				$('#upline_share').html(upline_share);
				$('#company_share').html(company_share);
			});
		}

		$('#form_submit').on('submit', function(e) {
			$.blockUI();
			$('#submit').attr('disabled', true);
		});
	});
</script>

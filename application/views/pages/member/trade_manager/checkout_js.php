<script>
	let state = "<?= $state; ?>",
		arr_state_except = [
			'active',
			'expired',
		];

	$(document).ready(function() {
		if ('<?= $state; ?>' == 'waiting payment' || '<?= $state; ?>' == 'pending') {
			timeLeft('<?= $time_left; ?>');
		} else {
			$('#time_left').html('0s');
		}

		// checkStatusPayment('<?= $arr->row()->txn_id; ?>');
		console.log(state);
		if (arr_state_except.includes(state) == false) {
			console.log("timer on");
			setInterval(function() {
				checkStatusPayment('<?= $arr->row()->txn_id; ?>');
			}, 30000);
		}
	});

	function timeLeft(time_left) {
		console.log(time_left);
		// Set the date we're counting down to
		var countDownDate = new Date(time_left).getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

			// Get today's date and time
			var now = new Date().getTime();

			// Find the distance between now and the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Display the result in the element with id="demo"
			document.getElementById("time_left").innerHTML = days + "d " + hours + "h " +
				minutes + "m " + seconds + "s ";

			// If the count down is finished, write some text
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("time_left").innerHTML = `<span class="badge badge-danger">Cancel / Time Out</span>`;
			}
		}, 1000);
	}

	function checkStatusPayment(txid) {
		// $.ajax({
		// 	url: '<?= site_url('trade_manager/get_tx_info'); ?>',
		// 	method: 'get',
		// 	dataType: 'json',
		// 	data: {
		// 		txid: txid
		// 	},
		// 	beforeSend: function() {
		// 		$.blockUI();
		// 	}
		// }).always(function() {
		// 	$.unblockUI();
		// }).fail(function(e) {
		// 	console.log(e);
		// 	if (e.responseText != '') {
		// 		Swal.fire({
		// 			icon: 'error',
		// 			title: 'Oops...',
		// 			html: e.responseText,
		// 		});
		// 	}
		// }).done(function(e) {
		// 	console.log(e);
		// 	let showText = "";
		// 	if (e.code == 500) {
		// 		Swal.fire({
		// 			icon: 'warning',
		// 			title: 'Failed to connect to Coinpayment',
		// 			html: e.status_text,
		// 		}).then(() => {
		// 			window.location.reload();
		// 		});
		// 	} else if (e.code == 200) {
		// 		$('#state_badge').html(e.state_badge);
		// 		$('#receivedf').html(e.receivedf);
		// 		$('#coin').html(e.coin);

		// 		if (e.state == "active") {
		// 			Swal.fire({
		// 				position: 'top-end',
		// 				icon: 'success',
		// 				title: 'Success...',
		// 				text: "Package Trade Manager Already Active",
		// 				showConfirmButton: true,
		// 				timer: 0,
		// 				timerProgressBar: true,
		// 			}).then(() => {
		// 				$("#state_badge").html(e.state_badge);
		// 				window.location.replace('<?= site_url('trade_manager'); ?>');
		// 			});
		// 		} else if (e.state == "cancel") {
		// 			Swal.fire({
		// 				position: 'top-end',
		// 				icon: 'warning',
		// 				title: 'Payment Warning',
		// 				text: e.status_text,
		// 				toast: true,
		// 				showConfirmButton: false,
		// 				timer: 5000,
		// 				timerProgressBar: true,
		// 			}).then(() => {
		// 				$("#state_badge").html(e.state_badge);
		// 				window.location.replace('<?= site_url('trade_manager'); ?>');
		// 			});
		// 		}


		// 	}
		// });

		window.location.reload();
	}
</script>

<script>
	let id_member = $('#id_member').val();

	$('#document').ready(function() {
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
				targets: [4],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

		$('#form_add').on('submit', function(e) {
			e.preventDefault();
			storeData();
		});

		$('#form_edit').on('submit', function(e) {
			e.preventDefault();
			updateData();
		});

		generateWalletSource('add');

		$('#receive_coin').on('change', function() {
			generateWalletSource('add');
		});

		$('#receive_coin_edit').on('change', function() {
			generateWalletSource('edit');
		});
	});

	function generateWalletSource(type) {
		console.log(type);
		let receive_coin = '';

		if (type == "add") {
			receive_coin = $('#receive_coin').val();
		} else {
			receive_coin = $('#receive_coin_edit').val();
		}

		let option = '<option value="">-</option>';

		if (receive_coin == "bnb") {
			console.log(receive_coin);
			option = `
			<option value="binance mainnet">Binance Mainnet</option>
			<option value="trustwallet">Trust Wallet</option>
			<option value="tokocrypto">TokoCrypto</option>
			<option value="indodax">Indodax</option>
			`;
		} else if (receive_coin == "trx") {
			option = `
			<option value="tronlink mainnet">TronLink</option>
			<option value="trustwallet">TrustWallet</option>
			<option value="binance mainnet">Binance Mainnet</option>
			<option value="tokocrypto">TokoCrypto</option>
			<option value="indodax">Indodax</option>
			`;
		} else if (receive_coin == "ltct") {
			option = `<option value="litecoin wallet testnet">LiteCoin Test</option>`;
		}

		if (type == "add") {
			console.log(option)
			$('#wallet_host').html(option);
		} else {
			$('#wallet_host_edit').html(option);
		}

	}

	function storeData() {
		$.ajax({
			url: '<?= site_url('wallet/store'); ?>',
			method: 'post',
			dataType: 'json',
			data: $('#form_add').serialize(),
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
					text: 'Failed connect to Database, please contact web developer',
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Store Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		});
	}

	function editData(id, receive_coin, wallet_host, wallet_address) {
		$('#id_edit').val(id);
		$('#receive_coin_edit').val(receive_coin).trigger('change');
		$('#wallet_host_edit').val(wallet_host);
		$('#wallet_address_edit').val(wallet_address);
		$('#modal_edit').modal('show');
	}

	function updateData() {
		$.ajax({
			url: '<?= site_url('wallet/update'); ?>',
			method: 'post',
			dataType: 'json',
			data: $('#form_edit').serialize(),
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
				}).then((res) => {
					window.location.reload();
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Failed connect to Database, please contact web developer',
				}).then((res) => {
					window.location.reload();
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Update Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		});
	}

	function deleteData(id, wallet_host, wallet_address) {
		Swal.fire({
			title: 'Are you sure?',
			text: `Delete Wallet ${wallet_address} from ${wallet_host}`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				processDeleteData(id);
			}
		})
	}

	function processDeleteData(id) {
		$.ajax({
			url: '<?= site_url('wallet/destroy'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id
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
				}).then((res) => {
					window.location.reload();
				});
			}
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Failed connect to Database, please contact web developer',
				}).then((res) => {
					window.location.reload();
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Delete Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			}
		});
	}
</script>

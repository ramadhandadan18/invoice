<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title bg-primary">
					<h5>Laporan Mingguan</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up text-white"></i>
						</a>
					</div>
				</div>
				<br><br>
				<div class="form-row">
					<div class="form-group col">
						<label>Nama Pegawai</label>
						<select class="form-control" id="fill_pegawai_id" name="fill_pegawai_id">
							<option value="" disabled selected>Pilih...</option>
						</select>
					</div>
					<div class="form-group col">
						<label>Tahun</label>
						<select class="form-control" id="fill_tahun" name="fill_tahun">
							<option value="" disabled selected>Pilih...</option>
						</select>
					</div>
					<div class="form-group col">
						<label>Bulan</label>
						<select class="form-control" id="fill_bulan" name="fill_bulan">
							<option value="" disabled selected>Pilih...</option>
						</select>
					</div>
					<div class="form-group col">
						<label>Minggu Ke</label>
						<select class="form-control" id="fill_minggu" name="fill_minggu">
							<option value="" disabled selected>Pilih...</option>
						</select>
					</div>
					<div class="form-group col">
						<label>Kategori</label>
						<select class="form-control" id="fill_kategori" name="fill_kategori">
							<option value="" disabled selected>Pilih...</option>
						</select>
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="main-table">
							<thead>
								<tr>
									<th width="5%">No</th>
									<th width="30%">No Kendaraan</th>
									<th width="20%">Nama</th>
									<th width="20%">Tanggal Transaksi</th>
									<th width="20%">Minggu ke</th>
									<th width="20%">Kategori</th>
									<th width="20%">Qty</th>
									<th width="20%">Harga</th>
									<th width="20%">Deskripsi</th>
									<th width="20%">Total</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th colspan="9" style="text-align:right">Total:</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo base_url() ?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/toastr/toastr.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url() ?>assets/js/inspinia.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/pace/pace.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>



<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		getMainTable();
		getdatapegawai();
		getdatatahun();
		getdatabulan();
		getdataminggu();
		getdatakategori();
	});

	$('#fill_pegawai_id').on('change', function() {
		getMainTable();
	});

	$('#fill_tahun').on('change', function() {
		getMainTable();
	});

	$('#fill_bulan').on('change', function() {
		getMainTable();
	});

	$('#fill_minggu').on('change', function() {
		getMainTable();
	});

	$('#fill_kategori').on('change', function() {
		getMainTable();
	});

	function getdatapegawai() {
		$.ajax({
			url: '<?php echo base_url() ?>Transaksi_mingguan/get_data_pegawai',
			method: "POST",
			async: true,
			dataType: 'json',
			success: function(data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i].pegawai_id + '>' + data[i].pegawai_nama + '</option>';
				}
				$('#fill_pegawai_id').html(html);
				$('#pegawai_id').html(html);
				$('#pegawai_id_edit').html(html);
			}
		});
	}

	function getdatakategori() {
		$.ajax({
			url: '<?php echo base_url() ?>Kategori/get_data_kategori',
			method: "POST",
			async: true,
			dataType: 'json',
			success: function(data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i].kategori_id + '>' + data[i].kategori_nama + '</option>';
				}
				$('#fill_kategori').html(html);
			}
		});
	}

	function getdatatahun() {
		$.ajax({
			url: '<?php echo base_url() ?>Transaksi_mingguan/get_data_tahun',
			method: "POST",
			async: true,
			dataType: 'json',
			success: function(data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i].tahun + '>' + data[i].tahun_desc + '</option>';
				}
				$('#fill_tahun').html(html);
			}
		});
	}

	function getdatabulan() {
		$.ajax({
			url: '<?php echo base_url() ?>Transaksi_mingguan/get_data_bulan_2',
			method: "POST",
			async: true,
			dataType: 'json',
			success: function(data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i].bulan + '>' + data[i].bulan_desc + '</option>';
				}
				$('#fill_bulan').html(html);
			}
		});
	}

	function getdataminggu() {
		$.ajax({
			url: '<?php echo base_url() ?>Transaksi_mingguan/get_data_minggu',
			method: "POST",
			async: true,
			dataType: 'json',
			success: function(data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i].minggu + '>' + data[i].minggu_desc + '</option>';
				}
				$('#fill_minggu').html(html);
			}
		});
	}

	function download_xls() {
		var fill_pegawai_id = $('#fill_pegawai_id').val() == null ? 'ALL' : $('#fill_pegawai_id').val();
		var fill_tahun = $('#fill_tahun').val() == null ? 'ALL' : $('#fill_tahun').val();
		var fill_bulan = $('#fill_bulan').val() == null ? 'ALL' : $('#fill_bulan').val();
		var fill_minggu = $('#fill_minggu').val() == null ? 'ALL' : $('#fill_minggu').val();
		var fill_kategori = $('#fill_kategori').val() == null ? 'ALL' : $('#fill_kategori').val();
		window.location = '<?php echo base_url() ?>Transaksi_mingguan/export_data/' + fill_pegawai_id + '/' + fill_tahun + '/' + fill_bulan + '/' + fill_minggu + '/' + fill_kategori
	}

	function getMainTable() {
		var fill_pegawai_id = $('#fill_pegawai_id').val() == null ? 'ALL' : $('#fill_pegawai_id').val();
		var fill_tahun = $('#fill_tahun').val() == null ? 'ALL' : $('#fill_tahun').val();
		var fill_bulan = $('#fill_bulan').val() == null ? 'ALL' : $('#fill_bulan').val();
		var fill_minggu = $('#fill_minggu').val() == null ? 'ALL' : $('#fill_minggu').val();
		var fill_kategori = $('#fill_kategori').val() == null ? 'ALL' : $('#fill_kategori').val();

		var role_id = 1;
		var oTable = $('#main-table').DataTable({
			processing: true,
			select: true,
			destroy: true,
			searching: true,
			lengthChange: true,
			pageLength: 50,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: {
				buttons: [{
					text: '<i class="fa fa-download"></i>&ensp;Download XLS',
					action: function(e, dt, node, config) {
						download_xls();
					}
				}, ],
				dom: {
					button: {
						tag: "button",
						className: "btn btn-primary btn-sm"
					},
					buttonLiner: {
						tag: null
					}
				}
			},
			footerCallback: function(row, data, start, end, display) {
				var api = this.api(),
					data;

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i : 0;
				};

				// Total over all pages
				total = api
					.column(9)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Total over this page
				pageTotal = api
					.column(9, {
						page: 'current'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer
				let nf = new Intl.NumberFormat('en-US', {
					maximumFractionDigits: 2
				});
				$(api.column(9).footer()).html(
					nf.format(pageTotal) + ' (' + nf.format(total) + ')'
				);
			},
			ajax: {
				url: '<?= base_url("Transaksi_mingguan/get_data/") ?>' + fill_pegawai_id + '/' + fill_tahun + '/' + fill_bulan + '/' + fill_minggu + '/' + fill_kategori,
				type: 'GET',
				dataSrc: function(json) {
					var return_data = new Array()
					$.each(json['response'], function(i, item) {
						return_data.push({
							'no': (i + 1),
							'pegawai_no': item['pegawai_no'],
							'pegawai_nama': item['pegawai_nama'],
							'tgl_transaksi': item['tgl_transaksi'],
							'mingguan': item['mingguan'],
							'kategori': item['kategori'],
							'qty': item['qty'],
							'harga': item['harga'],
							'deskripsi': item['deskripsi'],
							'total': item['total'],
						})
					})
					return return_data
				}
			},
			columns: [{
					data: 'no'
				},
				{
					data: 'pegawai_no'
				},
				{
					data: 'pegawai_nama'
				},
				{
					data: 'tgl_transaksi'
				},
				{
					data: 'mingguan'
				},
				{
					data: 'kategori'
				},
				{
					data: 'qty'
				},
				{
					data: 'harga'
				},
				{
					data: 'deskripsi'
				},
				{
					data: 'total'
				}
			]
		});
	}

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>
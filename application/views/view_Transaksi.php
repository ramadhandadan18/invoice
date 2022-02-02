<?php
//index.php

$connect = new PDO("mysql:host=localhost;dbname=pembukuan", "root", "");
function fill_unit_select_box($connect)
{
	$output = '';
	$query = "SELECT * FROM master_kategori ORDER BY kategori_id ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		$output .= '<option value="' . $row["kategori_kode"] . '">' . $row["kategori_nama"] . '</option>';
	}
	return $output;
}

?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title bg-primary">
					<h5>Master Data Transaksi</h5>
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
									<!-- <th width="30%">Id pegawai</th> -->
									<!-- <th width="20%">No Kendaraan</th> -->
									<th width="20%">Nama</th>
									<th width="20%">Tanggal Input</th>
									<th width="20%">Minggu ke</th>
									<th width="20%">Tanggal Transaksi</th>
									<th width="20%">Kategori</th>
									<th width="20%">Qty</th>
									<th width="20%">Harga</th>
									<th width="20%">Total</th>
									<th width="20%">Deskripsi</th>
									<th width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ADD TRANSAKSI -->
<div class="modal inmodal" id="add_transaksi_mdl" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Tambah Data Transaksi</h4>
			</div>
			<div class="container">
				<form method="post" id="insert_form">
					<div class="panel-body">
						<span id="success_result"></span>
						<div class="form-row">
							<div class="form-group col">
								<label>Nama Pegawai</label>
								<select class="form-control" id="pegawai_id" name="pegawai_id" required>
									<option value="" disabled selected>Pilih...</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Tanggal</label>
								<input type="date" class="form-control" id="tanggal" name="tanggal" required>
							</div>
							<div class="form-group col-md-6 .ml-auto">
								<label>Minggu ke</label>
								<select class="form-control" id="mingguan" name="mingguan" required>
									<option value="" disabled selected>Pilih...</option>
									<option value="1">Minggu ke 1</option>
									<option value="2">Minggu ke 2</option>
									<option value="3">Minggu ke 3</option>
									<option value="4">Minggu ke 4</option>
									<option value="5">Minggu ke 5</option>
								</select>
							</div>
						</div>
						<div id="container">
							<table class="table table-bordered" id="item_table">
								<tr>
									<th>Date</th>
									<th>Pilih barang</th>
									<th>QTY</th>
									<th>Harga</th>
									<th>Deskripsi</th>
									<th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span>Add more</button> </th>
								</tr>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
		</form>
	</div>
</div>

<!-- EDIT MODAL  -->
<div class="modal inmodal" id="edit_transaksi_mdl" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="header_edit_pegawai"></h4>
			</div>
			<div class="container">
				<form method="post" action="" enctype="multipart/form-data" id="myform_edit">
					<div class="panel-body">
						<span id="success_result"></span>
						<div class="form-row" style="display: none;">
							<div class="form-group col">
								<label>ID</label>
								<input type="text" class="form-control" id="id_edit" name="id_edit" readonly="true">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Nama Pegawai</label>
								<select class="form-control" id="pegawai_id_edit" name="pegawai_id_edit" required>
									<option value="" disabled selected>Pilih...</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Tanggal</label>
								<input type="date" class="form-control" id="tanggal_edit" name="tanggal_edit" required>
							</div>
							<div class="form-group col-md-6 .ml-auto">
								<label>Minggu ke</label>
								<select class="form-control" id="mingguan_edit" name="mingguan_edit" required>
									<option value="" disabled selected>Pilih...</option>
									<option value="1">Minggu ke 1</option>
									<option value="2">Minggu ke 2</option>
									<option value="3">Minggu ke 3</option>
									<option value="4">Minggu ke 4</option>
									<option value="5">Minggu ke 5</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Date</label>
								<input type="date" class="form-control" id="tgl_transaksi_edit" name="tgl_transaksi_edit" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Kategori</label>
								<select class="form-control" id="kategori_edit" name="kategori_edit">
									<option value="" disabled selected>Pilih...</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Qty</label>
								<input type="number" class="form-control" id="qty_edit" name="qty_edit" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Harga</label>
								<input type="number" class="form-control" id="harga_edit" name="harga_edit" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label>Deskrippsi</label>
								<input type="text" class="form-control" id="deskripsi_edit" name="deskripsi_edit" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="save_edit_pegawai()">Save changes</button>
					</div>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
		</form>
	</div>
</div>

<!-- DELETE MODAL -->
<div class="modal inmodal" id="confirm_delete_transaksi_mdl" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="header_delete_transaksi"></h4>
			</div>
			<div class="modal-body">
				<div class="form-row" style="display: none;">
					<div class="form-group col">
						<label>ID</label>
						<input type="text" class="form-control" id="id_delete" name="id_delete" placeholder="...">
					</div>
				</div>
				<div>
					<span>
						Apakah anda yakin?
					</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" onclick="save_delete_transaksi()">Yes</button>
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
<script src="<?php echo base_url() ?>assets/js/plugins/repeaterjs/repeater.js"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {
		$(document).on('click', '.add', function() {
			var html = '';
			html += '<tr>';
			html += '<td><input type="date" name="tgl_transaksi[]" class="form-control tanggal" /></td>';
			html += '<td><select name="kategori[]" class="form-control kategori"><option value="">Select Unit</option><?php echo fill_unit_select_box($connect); ?></select></td>';
			html += '<td><input type="number" value="1" name="qty[]" class="form-control qty" /></td>';
			html += '<td><input type="number" name="harga[]" class="form-control harga" /></td>';
			html += '<td><input type="text" name="deskripsi[]" class="form-control deskripsi" /></td>';
			html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span> Remove</button></td></tr>';
			$('#item_table').append(html);
		});
		$(document).on('click', '.remove', function() {
			$(this).closest('tr').remove();
		});
	});

	$(document).ready(function() {

		getMainTable();
		getdatapegawai();
		getdatapegawai2();
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
			url: '<?php echo base_url() ?>Transaksi/get_data_pegawai',
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
			}
		});
	}

	function getdatapegawai2() {
		$.ajax({
			url: '<?php echo base_url() ?>Transaksi/get_data_pegawai_2',
			method: "POST",
			async: true,
			dataType: 'json',
			success: function(data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=' + data[i].pegawai_id + '>' + data[i].pegawai_nama + '</option>';
				}
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
				$('#fill_kategori_inp').html(html);
				$('#kategori_edit').html(html);
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
			url: '<?php echo base_url() ?>Transaksi_mingguan/get_data_bulan',
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
				$('#mingguan_edit').html(html);
			}
		});
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
			pageLength: 10,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: {
				buttons: [{
					text: '<i class="fa fa-plus-square"></i>&ensp;Tambah Transaksi',
					action: function(e, dt, node, config) {
						add_pegawai();
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
			ajax: {
				url: '<?= base_url("Transaksi/get_data/") ?>' + fill_pegawai_id + '/' + fill_tahun + '/' + fill_bulan + '/' + fill_minggu + '/' + fill_kategori,
				type: 'GET',
				dataSrc: function(json) {
					var return_data = new Array()
					$.each(json['response'], function(i, item) {
						var button = '' +
							'<div class="btn-group">' +
							'<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data" onclick="edit_pegawai(\'' + item["id"] + '\')"><i class="fa fa-edit"></i>&ensp;Edit</button>' +
							'<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Data" onclick="confirm_delete_transaksi(\'' + item["id"] + '\')"><i class="fa fa-trash"></i>&ensp;Delete</button>' +
							'</div>'
						return_data.push({
							'no': (i + 1),
							'pegawai_nama': item['pegawai_nama'],
							'tanggal': item['tanggal'],
							'mingguan': item['mingguan'],
							'qty': item['qty'],
							'tgl_transaksi': item['tgl_transaksi'],
							'kategori': item['kategori'],
							'deskripsi': item['deskripsi'],
							'harga': item['harga'],
							'total': item['total'],
							'action': item['id'] != '' ? button : ''
						})
					})
					return return_data
				}
			},
			columns: [{
					data: 'no'
				},
				{
					data: 'pegawai_nama'
				},
				{
					data: 'tanggal'
				},
				{
					data: 'mingguan'
				},
				{
					data: 'tgl_transaksi'
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
					data: 'total'
				},
				{
					data: 'deskripsi'
				},
				{
					data: 'action'
				}
			]
		});
	}

	function add_pegawai() {
		$('#pegawai_id').val('');
		$('#pegawai_nama').val('');
		$('#tanggal').val('');
		$('#mingguan').val('');
		$('#qty').val('');
		$('#tgl_transaksi').val('');
		$('#kategori').val('');
		$('#deskripsi').val('');
		$('#harga').val('');
		//$('#item_table > tr > td').detach();
		// var html = '';
		// html += '<tr>';
		// html += '<th>Date</th>';
		// html += '<th>Pilih barang</th>';
		// html += '<th>QTY</th>';
		// html += '<th>Harga</th>';
		// html += '<th>Deskripsi</th>';
		// html += '<th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span>Add more</button> </th>';
		// html += '</tr>';

		// $('#item_table').append(html);

		$('#add_transaksi_mdl').modal('show');
	}


	$('#insert_form').on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: '<?php echo base_url() ?>Transaksi/save_add',
			method: "POST",
			data: form_data,
			success: function(data) {
				console.log(data);
				if (data == 1) {
					toastr.success('Data berhasil diperbarui', 'Success');

					$('#add_transaksi_mdl').modal('hide');
					location.reload();
					getMainTable();
				} else {
					toastr.error(data, 'Failed');
				}
			}
		});
	});

	function edit_pegawai(id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url() ?>Transaksi/get_data_by_id/' + id,
			dataType: 'json',
			success: function(data) {
				$('#id_edit').val(data.id);
				$('#pegawai_id_edit').val(data.pegawai_id).change();
				$('#tanggal_edit').val(data.tanggal);
				$('#mingguan_edit').val(data.mingguan).change();
				$('#qty_edit').val(data.qty);
				$('#tgl_transaksi_edit').val(data.tgl_transaksi);
				$('#harga_edit').val(data.harga);
				$('#kategori_edit').val(data.kategori);
				$('#deskripsi_edit').val(data.deskripsi);
				$('#header_edit_pegawai').html('Edit Data Transaksi ID <span class="text-info">' + data.id + '</span>');
				$('#edit_transaksi_mdl').modal("show");
			}
		});
	}

	function save_edit_pegawai() {
		var id = $('#id_edit').val();
		var pegawai_id = $('#pegawai_id_edit').val();
		var tanggal = $('#tanggal_edit').val();
		var mingguan = $('#mingguan_edit').val();
		var qty = $('#qty_edit').val();
		var tgl_transaksi = $('#tgl_transaksi_edit').val();
		var kategori = $('#kategori_edit').val();
		var deskripsi = $('#deskripsi_edit').val();
		var harga = $('#harga_edit').val();

		$.ajax({
			type: "POST",
			url: '<?php echo base_url() ?>Transaksi/save_edit',
			data: {
				id: id,
				pegawai_id: pegawai_id,
				tanggal: tanggal,
				mingguan: mingguan,
				qty: qty,
				tgl_transaksi: tgl_transaksi,
				kategori: kategori,
				deskripsi: deskripsi,
				harga: harga,
			},
			success: function(data) {
				console.log(data);
				if (data == 1) {
					toastr.success('Data berhasil diperbarui', 'Success');
					$('#edit_transaksi_mdl').modal('hide');
					getMainTable();
				} else {
					toastr.error(data, 'Failed');
				}
			}
		});

	}

	function confirm_delete_transaksi(id) {

		$('#id_delete').val(id);
		$('#header_delete_transaksi').html('Confirm Delete Data pegawai');
		$('#confirm_delete_transaksi_mdl').modal('show');
	}

	function save_delete_transaksi() {
		var id = $('#id_delete').val();

		$.ajax({
			type: "POST",
			url: '<?php echo base_url() ?>Transaksi/save_delete',
			data: {
				id: id,
			},
			success: function(data) {
				console.log(data);
				if (data == 1) {
					toastr.success('Data berhasil diperbarui', 'Success');
					$('#confirm_delete_transaksi_mdl').modal('hide');
					getMainTable();
				} else {
					toastr.error("Data gagal diperbarui", 'Failed');
				}
			}
		});
	}

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>
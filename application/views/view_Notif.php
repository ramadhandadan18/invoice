<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-primary">
                    <h5>Notifikasi Ganti Oli</h5>
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
                        <label>Status</label>
                        <select class="form-control" id="fill_status" name="fill_status">
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
                                    <th width="20%">Tanggal Transaksi</th>
                                    <th width="20%">Tanggal End</th>
                                    <th width="20%">Status</th>
                                    <th width="20%">Action</th>
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

<!-- EDIT MODAL -->
<div class="modal inmodal" id="edit_status_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_edit_status"></h4>
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
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" id="pegawai_id_edit" name="pegawai_id_edit" readonly="true">
                                </input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Tanggal Transaksi</label>
                                <input type="date" class="form-control" id="tgl_transaksi_edit" name="tgl_transaksi_edit" readonly="true">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Tanggal End</label>
                                <input type="date" class="form-control" id="tgl_end_edit" name="tgl_end_edit" readonly="true">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Status</label>
                                <select class="form-control" id="status_edit" name="status_edit">
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="1">Sudah Ganti Oli</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="save_edit_pegawai()">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
        </form>
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
        getdatastatus();
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

    $('#fill_status').on('change', function() {
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
                $('#pegawai_id').html(html);
                $('#pegawai_id_edit').html(html);
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
            }
        });
    }

    function getdatastatus() {
        $.ajax({
            url: '<?php echo base_url() ?>Notif/get_data_status',
            method: "POST",
            async: true,
            dataType: 'json',
            success: function(data) {

                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].status + '>' + data[i].status_desc + '</option>';
                }
                $('#fill_status').html(html);
            }
        });
    }

    function getMainTable() {
        var fill_pegawai_id = $('#fill_pegawai_id').val() == null ? 'ALL' : $('#fill_pegawai_id').val();
        var fill_tahun = $('#fill_tahun').val() == null ? 'ALL' : $('#fill_tahun').val();
        var fill_bulan = $('#fill_bulan').val() == null ? 'ALL' : $('#fill_bulan').val();
        var fill_minggu = $('#fill_minggu').val() == null ? 'ALL' : $('#fill_minggu').val();
        var fill_status = $('#fill_status').val() == null ? 'ALL' : $('#fill_status').val();

        var role_id = 1;
        var oTable = $('#main-table').DataTable({
            processing: true,
            select: true,
            destroy: true,
            searching: true,
            lengthChange: true,
            pageLength: 10,
            responsive: true,

            ajax: {
                url: '<?= base_url("Notif/get_data/") ?>' + fill_pegawai_id + '/' + fill_tahun + '/' + fill_bulan + '/' + fill_minggu + '/' + fill_status,
                type: 'GET',
                dataSrc: function(json) {
                    var return_data = new Array()
                    $.each(json['response'], function(i, item) {
                        var button = '' +
                            '<div class="btn-group">' +
                            '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data" onclick="edit_pegawai(\'' + item["id"] + '\')"><i class="fa fa-edit"></i>&ensp;Edit</button>' +
                            '</div>'
                        return_data.push({
                            'no': (i + 1),
                            'pegawai_id': item['pegawai_id'],
                            'tgl_transaksi': item['tgl_transaksi'],
                            'tgl_end': item['tgl_end'],
                            'status': item['status'],
                            'action': item['transaksi_id'] != '' ? button : ''
                        })
                    })
                    return return_data
                }
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'pegawai_id'
                },
                {
                    data: 'tgl_transaksi'
                },
                {
                    data: 'tgl_end'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    function edit_pegawai(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Notif/get_data_by_id/' + id,
            dataType: 'json',
            success: function(data) {
                $('#id_edit').val(data.id);
                $('#pegawai_id_edit').val(data.pegawai_id).change();
                $('#tgl_transaksi_edit').val(data.tgl_transaksi);
                $('#tgl_end_edit').val(data.tgl_end);
                $('#status_edit').val(data.status);
                $('#header_edit_status').html('Edit Status ID Transaksi <span class="text-info">' + data.id + '</span>');
                $('#edit_status_mdl').modal("show");
            }
        });
    }

    function save_edit_pegawai() {
        var id = $('#id_edit').val();
        var pegawai_id = $('#pegawai_id_edit').val();
        var tgl_end = $('#tgl_end_edit').val();
        var tgl_transaksi = $('#tgl_transaksi_edit').val();
        var status = $('#status_edit').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>Notif/save_edit',
            data: {
                id: id,
                pegawai_id: pegawai_id,
                tgl_transaksi: tgl_transaksi,
                tgl_end: tgl_end,
                status: status,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#edit_status_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
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
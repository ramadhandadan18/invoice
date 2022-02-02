<?php
//index.php

$connect = new PDO("mysql:host=localhost;dbname=pembukuan", "root", "");
function fill_unit_select_box($connect)
{
    $output = '';
    $query = "SELECT * FROM gaji ORDER BY pegawai_id ASC";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output .= '<option value="' . $row["pegawai_id"] . '">' . $row["pegawai_nama"] . '</option>';
    }
    return $output;
}

?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-primary">
                    <h5>Master Data Gaji</h5>
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
                                    <th width="20%">Bulan</th>
                                    <th width="20%">Gaji</th>
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

<!-- MODAL ADD GAJI -->
<div class="modal inmodal" id="add_gaji_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Tambah Data gaji</h4>
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
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Gaji</label>
                                <input type="Number" class="form-control" id="gaji" name="gaji" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary" onclick="save_add_gaji()">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal inmodal" id="edit_gaji_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_edit_gaji"></h4>
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
                        <div class="form-row" style="display: none;">
                            <div class="form-group col">
                                <label>Nama Pegawai</label>
                                <select class="form-control" id="pegawai_id_edit" name="pegawai_id_edit" readonly="true" required>
                                    <option value="" disabled selected>Pilih...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_edit" name="tanggal_edit" readonly="true" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Gaji</label>
                                <input type="number" class="form-control" id="gaji_edit" name="gaji_edit" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="save_edit_gaji()">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal inmodal" id="confirm_delete_gaji_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_delete_gaji"></h4>
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
                <button type="button" class="btn btn-danger" onclick="save_delete_gaji()">Yes</button>
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

        getMainTable();
        getdatapegawai();
        getdatatahun();
        getdatabulan();
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

    function getMainTable() {
        var fill_pegawai_id = $('#fill_pegawai_id').val() == null ? 'ALL' : $('#fill_pegawai_id').val();
        var fill_tahun = $('#fill_tahun').val() == null ? 'ALL' : $('#fill_tahun').val();
        var fill_bulan = $('#fill_bulan').val() == null ? 'ALL' : $('#fill_bulan').val();
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
                    text: '<i class="fa fa-plus-square"></i>&ensp;Tambah Gaji',
                    action: function(e, dt, node, config) {
                        add_gaji();
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
                url: '<?= base_url("Gaji/get_data/") ?>' + fill_pegawai_id + '/' + fill_tahun + '/' + fill_bulan,
                type: 'GET',
                dataSrc: function(json) {
                    var return_data = new Array()
                    $.each(json['response'], function(i, item) {
                        var button = '' +
                            '<div class="btn-group">' +
                            '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data" onclick="edit_gaji(\'' + item["id"] + '\')"><i class="fa fa-edit"></i>&ensp;Edit</button>' +
                            '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Data" onclick="confirm_delete_gaji(\'' + item["id"] + '\')"><i class="fa fa-trash"></i>&ensp;Delete</button>' +
                            '</div>'
                        return_data.push({
                            'no': (i + 1),
                            'pegawai_nama': item['pegawai_nama'],
                            'month': item['month'],
                            'gaji': item['gaji'],
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
                    data: 'month'
                },
                {
                    data: 'gaji'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    function add_gaji() {
        $('#pegawai_id').val('');
        $('#tanggal').val('');
        $('#gaji').val('');
        $('#add_gaji_mdl').modal('show');
    }

    $('#insert_form').on('submit', function(event) {
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url() ?>Gaji/save_add',
            method: "POST",
            data: form_data,
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#add_gaji_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });
    });

    function save_add_gaji() {
        $.ajax({
            url: '<?php echo base_url() ?>Gaji/save_add',
            method: "POST",
            data: insert_form,
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#add_gaji_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });
    }

    function edit_gaji(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Gaji/get_data_by_id/' + id,
            dataType: 'json',
            success: function(data) {
                $('#id_edit').val(data.id);
                $('#pegawai_id_edit').val(data.pegawai_id).change();
                $('#tanggal_edit').val(data.tanggal);
                $('#gaji_edit').val(data.gaji).change();
                $('#header_edit_gaji').html('Edit Data Gaji Pegawai <span class="text-info">' + data.pegawai_nama + '</span>');
                $('#edit_gaji_mdl').modal("show");
            }
        });
    }

    function save_edit_gaji() {
        var id = $('#id_edit').val();
        var pegawai_id = $('#pegawai_id_edit').val();
        var tanggal = $('#tanggal_edit').val();
        var gaji = $('#gaji_edit').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>Gaji/save_edit',
            data: {
                id: id,
                pegawai_id: pegawai_id,
                tanggal: tanggal,
                gaji: gaji,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#edit_gaji_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });

    }

    function confirm_delete_gaji(id) {

        $('#id_delete').val(id);
        $('#header_delete_gaji').html('Confirm Delete Data Gaji');
        $('#confirm_delete_gaji_mdl').modal('show');
    }

    function save_delete_gaji() {
        var id = $('#id_delete').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>Gaji/save_delete',
            data: {
                id: id,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#confirm_delete_gaji_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error("Data gagal diperbarui", 'Failed');
                }
            }
        });
    }
</script>
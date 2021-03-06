<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-primary">
                    <h5>List Data Invoice</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="main-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <!-- <th width="30%">Id Kategori</th> -->
                                    <th width="45%">Invoice No</th>
                                    <th width="45%">Client</th>
                                    <th width="40%">Doc Status</th>
                                    <th width="40%">Payment Status</th>
                                    <th width="40%">Amount</th>
                                    <th width="40%">Outsanding</th>
                                    <th width="40%">Invoice Date</th>
                                    <th width="40%">Due Date</th>
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

<div class="modal inmodal" id="add_Kategori_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Tambah Data Kategori</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" placeholder="Nama">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save_add_Kategori()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="edit_Kategori_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_edit_Kategori"></h4>
            </div>
            <div class="modal-body">
                <div class="form-row" style="display: none;">
                    <div class="form-group col">
                        <label>ID</label>
                        <input type="text" class="form-control" id="kategori_id_edit" name="kategori_id" readonly="true">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" id="kategori_nama_edit" name="kategori_nama_edit" placeholder="Nama">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save_edit_Kategori()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="confirm_delete_Kategori_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_delete_Kategori"></h4>
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
                <button type="button" class="btn btn-danger" onclick="save_delete_Kategori()">Yes</button>
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

    });

    $('#fill_no_inv').on('change', function() {
        getMainTable();
    });

    $('#fill_client').on('change', function() {
        getMainTable();
    });

    $('#fill_doc_status').on('change', function() {
        getMainTable();
    });

    $('#fill_date_inv').on('change', function() {
        getMainTable();
    });
    $('#fill_date_due').on('change', function() {
        getMainTable();
    });

    function getMainTable() {
        // var fill_no_iv = $('#fill_no_inv').val() == null ? 'ALL' : $('#fill_no_inv').val();
        // var fill_client = $('#fill_client').val() == null ? 'ALL' : $('#fill_client').val();
        // var fill_doc_status = $('#fill_doc_status').val() == null ? 'ALL' : $('#fill_doc_status').val();
        // var fill_date_inv = $('#fill_date_inv').val() == null ? 'ALL' : $('#fill_date_inv').val();
        // var fill_date_due = $('#fill_date_due').val() == null ? 'ALL' : $('#fill_date_due').val();
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
                    text: '<i class="fa fa-plus-square"></i>&ensp;Tambah Invoice',
                    action: function(e, dt, node, config) {
                        add_invoice();
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
                url: '<?= base_url("Invoice/get_data_by_id") ?>', //+ fill_no_iv + '/' + fill_client + '/' + fill_doc_status + '/' + fill_date_inv + '/' + fill_date_due,
                type: 'GET',
                dataSrc: function(json) {
                    var return_data = new Array()
                    $.each(json['response'], function(i, item) {
                        var button = '' +
                            '<div class="btn-group">' +
                            '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data" onclick="edit_Kategori(\'' + item["kategori_id"] + '\')"><i class="fa fa-edit"></i>&ensp;Edit</button>' +
                            '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Data" onclick="confirm_delete_Kategori(\'' + item["kategori_id"] + '\')"><i class="fa fa-trash"></i>&ensp;Delete</button>' +
                            '</div>'
                        return_data.push({
                            'no': (i + 1),
                            'id': item['id'],
                            'no_inv': item['no_inv'],
                            'client': item['client'],
                            'doc_status': item['doc_status'],
                            'payment_status': item['payment_status'],
                            'amount': item['amount'],
                            'outstanding': item['outstanding'],
                            'date_inv': item['date_inv'],
                            'due_date': item['due_date'],
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
                    data: 'no_inv'
                },
                {
                    data: 'client'
                },
                {
                    data: 'doc_status'
                },
                {
                    data: 'payment_status'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'outstanding'
                },
                {
                    data: 'date_inv'
                },
                {
                    data: 'due_date'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    function add_Kategori() {
        $('#kategori_nama').val('');
        $('#add_Kategori_mdl').modal('show');
    }

    function save_add_Kategori() {
        var kategori_nama = $('#kategori_nama').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>Kategori/save_add',
            data: {
                kategori_nama: kategori_nama,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#add_Kategori_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });

    }

    function edit_Kategori(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Kategori/get_data_by_id/' + id,
            dataType: 'json',
            success: function(data) {

                $('#kategori_id_edit').val(data.kategori_id);
                $('#kategori_nama_edit').val(data.kategori_nama);

                $('#header_edit_Kategori').html('Edit Data Kategori <span class="text-info">' + data.kategori_nama + '</span>');
                $('#edit_Kategori_mdl').modal("show");
            }
        });

    }

    function save_edit_Kategori() {
        var kategori_id = $('#kategori_id_edit').val();
        var kategori_nama = $('#kategori_nama_edit').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>Kategori/save_edit',
            data: {
                kategori_id: kategori_id,
                kategori_nama: kategori_nama,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#edit_Kategori_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });

    }

    function confirm_delete_Kategori(id) {

        $('#id_delete').val(id);

        $('#header_delete_Kategori').html('Confirm Delete Data Kategori');

        $('#confirm_delete_Kategori_mdl').modal('show');

    }

    function save_delete_Kategori() {
        var id = $('#id_delete').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>Kategori/save_delete',
            data: {
                id: id,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#confirm_delete_Kategori_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error("Data gagal diperbarui", 'Failed');
                }
            }
        });

    }
</script>
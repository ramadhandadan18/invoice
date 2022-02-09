<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-primary">
                    <h5>Master Data Supir</h5>
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
                                    <!-- <th width="30%">Id pegawai</th> -->
                                    <th width="10%">Client ID</th>
                                    <th width="10%">Nama Company</th>
                                    <th width="10%">Nama Pemilik</th>
                                    <th width="10%">Email</th>
                                    <th width="10%">Phone Company</th>
                                    <th width="10%">Phone Owner</th>
                                    <th width="5%">Action</th>
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

<div class="modal inmodal" id="add_client_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Tambah Data Client</h4>
            </div>
            <form method="post" action="" enctype="multipart/form-data" id="myform">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Client ID</label>
                            <input type="text" class="form-control" id="client_id" name="client_id" placeholder="No Client" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Company Name</label>
                            <input type="text" class="form-control" id="nmcomp" name="nmcomp" placeholder="Company Name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Nama Owner</label>
                            <input type="text" class="form-control" id="nmperson" name="nmperson" placeholder="Owner Name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Phone Company</label>
                            <input type="text" class="form-control" id="phonecomp" name="phonecomp" placeholder="Phone Company" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Phone Owner</label>
                            <input type="text" class="form-control" id="phoneperson" name="phoneperson" placeholder="Phone Ownwer" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_add_client()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal" id="edit_client_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_edit_client"></h4>
            </div>
            <form method="post" action="" enctype="multipart/form-data" id="myform_edit">
                <div class="modal-body">
                    <div class="form-row" style="display: none;">
                        <div class="form-group col">
                            <label>ID</label>
                            <input type="text" class="form-control" id="client_id_edit" name="client_id" readonly="true">
                        </div>
                    </div>
                    <div class="form-row" style="display: none;">
                        <div class="form-group col">
                            <label>ID</label>
                            <input type="text" class="form-control" id="file_prev" name="file_prev" readonly="true">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Nama Comp</label>
                            <input type="text" class="form-control" id="nmcomp_edit" name="nmcomp_edit" placeholder="Nama" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Nama owner</label>
                            <input type="text" class="form-control" id="nmperson_edit" name="nmperson_edit" placeholder="No Kendaraan" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email_edit" name="nmperson_edit" placeholder="No Kendaraan" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>No Kendaraan</label>
                            <input type="text" class="form-control" id="nmperson_edit" name="nmperson_edit" placeholder="No Kendaraan" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>No Kendaraan</label>
                            <input type="text" class="form-control" id="nmperson_edit" name="nmperson_edit" placeholder="No Kendaraan" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>No Kendaraan</label>
                            <input type="text" class="form-control" id="nmperson_edit" name="nmperson_edit" placeholder="No Kendaraan" required>
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
</div>

<div class="modal inmodal" id="confirm_delete_client_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="header_delete_pegawai"></h4>
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
                <button type="button" class="btn btn-danger" onclick="save_delete_client()">Yes</button>
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

    function getMainTable() {
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        // alert(tahun+'-'+bulan);
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
                    text: '<i class="fa fa-plus-square"></i>&ensp;Tambah Supir',
                    action: function(e, dt, node, config) {
                        add_client();
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
                url: "<?= base_url('Client/get_data') ?>",
                type: 'GET',
                dataSrc: function(json) {
                    var return_data = new Array()
                    $.each(json['response'], function(i, item) {
                        var button = '' +
                            '<div class="btn-group">' +
                            '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data" onclick="edit_pegawai(\'' + item["pegawai_id"] + '\')"><i class="fa fa-edit"></i>&ensp;Edit</button>' +
                            '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Data" onclick="confirm_delete_pegawai(\'' + item["pegawai_id"] + '\')"><i class="fa fa-trash"></i>&ensp;Delete</button>' +
                            '</div>'
                        return_data.push({
                            'no': (i + 1),
                            'client_id': item['client_id'],
                            'nmcomp': item['nmcomp'],
                            'nmperson': item['nmperson'],
                            'email': item['email'],
                            'phonecomp': item['phonecomp'],
                            'phoneperson': item['phoneperson'],
                            'action': item['client_id'] != '' ? button : ''
                        })
                    })
                    return return_data
                }
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'client_id'
                },
                {
                    data: 'nmcomp'
                },
                {
                    data: 'nmperson'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phonecomp'
                },
                {
                    data: 'phoneperson'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    function add_client() {
        $('#client_id').val('');
        $('#nmcomp').val('');
        $('#nmperson').val('');
        $('#email').val('');
        $('#phonecomp').val('');
        $('#phoneperson').val('');
        $('#add_client_mdl').modal('show');
    }

    function save_add_client() {
        var client_id = $('#client_id').val();
        var nmcomp = $('#nmcomp').val();
        var nmperson = $('#nmperson').val();
        var email = $('#email').val();
        var phonecomp = $('#phonecomp').val();
        var phoneperson = $('#phoneperson').val();
        var fd = new FormData();

        fd.append('client_id', client_id);
        fd.append('nmcomp', nmcomp);
        fd.append('nmperson', nmperson);
        fd.append('email', email);
        fd.append('phonecomp', phonecomp);
        fd.append('phoneperson', phoneperson);

        $.ajax({
            url: '<?php echo base_url() ?>client/save_add',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#add_client_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });

    }

    function edit_client(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>client/get_data_by_id/' + id,
            dataType: 'json',
            success: function(data) {

                $('#pegawai_id_edit').val(data.pegawai_id);
                $('#pegawai_no_edit').val(data.pegawai_no);
                $('#pegawai_nama_edit').val(data.pegawai_nama);
                $('#file_prev').val(data.gambar);
                if (data.gambar != null)
                    $('#imgView').attr('src', '<?php echo base_url() ?>/assets/images/' + data.gambar);
                else
                    $('#imgView').hide();

                $('#header_edit_pegawai').html('Edit Data Supir <span class="text-info">' + data.pegawai_nama + '</span>');
                $('#edit_pegawai_mdl').modal("show");
            }
        });

    }

    function save_edit_pegawai() {
        var pegawai_id = $('#pegawai_id_edit').val();
        var file_prev = $('#file_prev').val();
        var pegawai_no = $('#pegawai_no_edit').val();
        var pegawai_nama = $('#pegawai_nama_edit').val();

        var fd = new FormData();
        var files = $('#file_edit')[0].files[0];
        fd.append('pegawai_id', pegawai_id);
        fd.append('pegawai_no', pegawai_no);
        fd.append('pegawai_nama', pegawai_nama);
        fd.append('file', files);
        fd.append('file_prev', file_prev);

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>pegawai/save_edit',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#edit_pegawai_mdl').modal('hide');
                    getMainTable();
                } else {
                    toastr.error(data, 'Failed');
                }
            }
        });

    }

    function confirm_delete_pegawai(id) {

        $('#id_delete').val(id);

        $('#header_delete_pegawai').html('Confirm Delete Data Supir');

        $('#confirm_delete_pegawai_mdl').modal('show');

    }

    function save_delete_pegawai() {
        var id = $('#id_delete').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>pegawai/save_delete',
            data: {
                id: id,
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    toastr.success('Data berhasil diperbarui', 'Success');
                    $('#confirm_delete_pegawai_mdl').modal('hide');
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
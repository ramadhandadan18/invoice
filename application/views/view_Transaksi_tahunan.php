<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-primary">
                    <h5>Laporan Tahunan</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up text-white"></i>
                        </a>
                    </div>
                </div>
                <br><br>
                <div class="form-row col-lg-6">
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
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="main-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="40%">Nama</th>
                                    <th width="40%">Jan</th>
                                    <th width="40%">Feb</th>
                                    <th width="40%">Mar</th>
                                    <th width="40%">Apr</th>
                                    <th width="40%">Mei</th>
                                    <th width="40%">Jun</th>
                                    <th width="40%">Jul</th>
                                    <th width="40%">Agu</th>
                                    <th width="40%">Sep</th>
                                    <th width="40%">Okt</th>
                                    <th width="40%">Nov</th>
                                    <th width="40%">Des</th>
                                    <th width="40%">Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th colspan="1" style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
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
    });

    $('#fill_pegawai_id').on('change', function() {
        getMainTable();
    });

    $('#fill_tahun').on('change', function() {
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


    function download_xls() {
        var fill_pegawai_id = $('#fill_pegawai_id').val() == null ? 'ALL' : $('#fill_pegawai_id').val();
        var fill_tahun = $('#fill_tahun').val() == null ? 'ALL' : $('#fill_tahun').val();
        window.location = '<?php echo base_url() ?>Transaksi_mingguan/export_data_tahunan/' + fill_pegawai_id + '/' + fill_tahun
    }

    function getMainTable() {
        var fill_pegawai_id = $('#fill_pegawai_id').val() == null ? 'ALL' : $('#fill_pegawai_id').val();
        var fill_tahun = $('#fill_tahun').val() == null ? 'ALL' : $('#fill_tahun').val();

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
                    .column(14)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(14, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total Mingguan
                var m1 = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m2 = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m3 = api
                    .column(4)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m4 = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m5 = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m6 = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m7 = api
                    .column(8)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                var m8 = api
                    .column(9)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m9 = api
                    .column(10)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m10 = api
                    .column(11)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m11 = api
                    .column(12)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m12 = api
                    .column(13)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var m13 = api
                    .column(14)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                let nf = new Intl.NumberFormat('en-US', {
                    maximumFractionDigits: 2
                });
                $(api.column(14).footer()).html(
                    nf.format(pageTotal) + ' (' + nf.format(total) + ')'
                );
                $(api.column(2).footer()).html(nf.format(m1));
                $(api.column(3).footer()).html(nf.format(m2));
                $(api.column(4).footer()).html(nf.format(m3));
                $(api.column(5).footer()).html(nf.format(m4));
                $(api.column(6).footer()).html(nf.format(m5));
                $(api.column(7).footer()).html(nf.format(m6));
                $(api.column(8).footer()).html(nf.format(m7));
                $(api.column(9).footer()).html(nf.format(m8));
                $(api.column(10).footer()).html(nf.format(m9));
                $(api.column(11).footer()).html(nf.format(m10));
                $(api.column(12).footer()).html(nf.format(m11));
                $(api.column(13).footer()).html(nf.format(m12));
                $(api.column(14).footer()).html(nf.format(m13));
            },
            ajax: {
                url: '<?= base_url("Transaksi_mingguan/get_data_tahunan/") ?>' + fill_pegawai_id + '/' + fill_tahun,
                type: 'GET',
                dataSrc: function(json) {
                    var return_data = new Array()
                    $.each(json['response'], function(i, item) {
                        return_data.push({
                            'no': (i + 1),
                            'pegawai_nama': item['pegawai_nama'],
                            'v1': item['v1'],
                            'v2': item['v2'],
                            'v3': item['v3'],
                            'v4': item['v4'],
                            'v5': item['v5'],
                            'v6': item['v6'],
                            'v7': item['v7'],
                            'v8': item['v8'],
                            'v9': item['v9'],
                            'v10': item['v10'],
                            'v11': item['v11'],
                            'v12': item['v12'],
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
                    data: 'pegawai_nama'
                },
                {
                    data: 'v1'
                },
                {
                    data: 'v2'
                },
                {
                    data: 'v3'
                },
                {
                    data: 'v4'
                },
                {
                    data: 'v5'
                },
                {
                    data: 'v6'
                },
                {
                    data: 'v7'
                },
                {
                    data: 'v8'
                },
                {
                    data: 'v9'
                },
                {
                    data: 'v10'
                },
                {
                    data: 'v11'
                },
                {
                    data: 'v12'
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
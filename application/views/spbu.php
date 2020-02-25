<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 dahsboard-column">
                <section class="box-typical box-typical-dashboard panel x-ua-compatible scrollable">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">
                            DAFTAR SPBU
                            <span style="float: right" class="tbl-cell">
                                <a class="btn btn-nav btn-rounded btn-inline btn-success-outline"
                                   href="<?php echo site_url('spbu/edit'); ?>">+ Tambah</a>
                            </span>
                        </h3>
                    </header>
                    <div class="">
                        <div class="streaming-table">
                            <table id="spbu-table" class="table table-bordered table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPBU</th>
                                    <th>Kabupaten / Kota</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br><br>
                        </div>
                    </div><!--"" -->
                </section><!--.box-typical-dashboard-->
            </div><!--.col-->
        </div>
    </div><!--.container-fluid-->
</div><!--.page-content-->


<script src="<?php echo base_url(); ?>assets/js/lib/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#spbu-table').DataTable({
            "ajax": "<?php echo site_url('spbu/get_data_spbu'); ?>",
            "columns": [
                // order no
                {
                    "data": null,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var orderNo = iRow + 1;
                        $(nTd).html(orderNo);
                    }
                },
                // no spbu
                {"data": "no_spbu"},
                // kab kota
                {"data": "kabupaten"},
                // action edit, delete
                {
                    "data": null,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var customButton = `<a href=<?php echo site_url('spbu/edit') ?>/${oData.id} class='btn btn-warning'
                        role='button'>Edit</a>
                        &nbsp
                        <a href=<?php echo site_url('spbu/trash') ?>/${oData.id} class='btn btn-danger' role='button'>Delete</a>`;
                        $(nTd).html(customButton);
                    }
                }
            ]
        });
    });
</script>
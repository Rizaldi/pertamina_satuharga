<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 dahsboard-column">
                <section class="box-typical box-typical-dashboard panel x-ua-compatible scrollable">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">DASHBOARD STOK BBM SATU HARGA
                            <span style="margin-left: 10px;">
	                        </span>
                            <span>
	                        </span>
                        </h3>
                    </header>
                    <div class="">
                        <div class="streaming-table">
                            <!-- filter by date -->
                            <div class="row" style="margin-bottom: 1em;">
                                <div class="col-md-1">
                                    <p style="padding-top: 8px">Tanggal</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" data-autoclose="true">
                                        <input type="text" name="start_date" class="form-control date"
                                               value="<?php echo date("Y/m/d"); ?>"/>
                                        <span class="input-group-addon">
												<span class="font-icon font-icon-calend"></span>
											</span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <p style="padding-top: 8px">Sampai</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" data-autoclose="true">
                                        <input type="text" name="end_date" class="form-control date"
                                               value="<?php echo date("Y/m/d"); ?>"/>
                                        <span class="input-group-addon">
												<span class="font-icon font-icon-calend"></span>
											</span>
                                    </div>
                                </div>
                            </div> <!-- row mb -->
                            <!-- filter by pilihan bbm, kab / kota, dan provinsi -->
                            <div class="row" style="margin-bottom: 4em;">
                                <div class="col-md-3">
                                    <!--                                    <label class="form-label semibold" for="exampleInput">Pilihan BBM</label>-->
                                    <select id="id_bbm" class="form-control">
                                        <option value="0">Pilihan BBM</option>
                                        <option value="1">Premium</option>
                                        <option value="2">Solar</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="list_provinsi" class="select2">
                                        <option value="0">Pilih Provinsi</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <!--                                    <label class="form-label semibold" for="exampleInput">Nama Petugas</label>-->
                                    <select id="list_kabkot" class="select2">
                                        <option value="0">Pilih Kabupaten / Kota</option>
                                    </select>
                                </div>
                                <div class="col-md-1 exp-button">
                                    <a id="filter_datatable_satuharga" class="btn btn-primary">Filter</a>
                                </div>
                                <div class="col-md-1 exp-button">
                                    <a href="<?php echo site_url() ?>home/excel" class="btn btn-success">Export</a>
                                </div>
                            </div> <!-- row mb -->
                            <span id="found" class="label label-info"></span>
                            <table id="mytable" class="table table-bordered table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>No.SPBU</th>
                                    <th>Pilihan BBM</th>
                                    <th>Stok Awal</th>
                                    <th>Penerimaan BBM</th>
                                    <th>Penjualan</th>
                                    <th>Stok Akhir</th>
                                    <th>Loses</th>
                                    <th>Tanggal</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br><br>
                        </div>
                    </div>
                </section><!--.box-typical-dashboard-->
            </div><!--.col-->
        </div>
    </div><!--.container-fluid-->
</div><!--.page-content-->


<script src="<?php echo base_url(); ?>assets/js/lib/jquery/jquery.min.js"></script>

<script>
    $(function () {

        // fetch provinsi
        var fetch_data_provinsi = function () {
            $.get('<?php echo base_url(); ?>Api/wilayah/provinsi', function (result) {
                // loop result, append to select2 dropdown
                // val = object of provinsi
                $.each(result, function (i, val) {
                    var prov = `<option value=${val.id_prov}>${val.provinsi}</option>`;
                    $("select[id='list_provinsi']").append(prov);
                });
            });
        };

        fetch_data_provinsi();

        // fetch kab / kota
        var fetch_data_kabkot = function (id_prov) {
            var select_list_kabkot = $("select[id='list_kabkot']");

            $.get('<?php echo base_url(); ?>Api/wilayah/kabkot/' + id_prov, function (result) {
                // loop result, append to select2 dropdown
                // val = object of kabupaten / kota
                var count = 0;
                select_list_kabkot.empty(); // empty value of kabkot
                $.each(result, function (i, val) {
                    if(i == 0) {
                        var kabkot = `<option value="0">Pilih Kabupaten / Kota</option>`;
                    }
                    kabkot += `<option value=${val.id_kab}>${val.kabupaten}</option>`;
                    select_list_kabkot.append(kabkot);
                    count++;
                });

            });
        };

        // Event listener for PROVINSI
        // fetch data for select2 dropdown `kab kota`
        $("select[id='list_provinsi']").on('select2:select', function (e) {
            e.preventDefault();
            var id_prov = $(this).val();
            fetch_data_kabkot(id_prov);
        });

        // Event listener for PILIHAN BBM
//        $("select[id='id_bbm']").on('select2:select', function (e) {
//            e.preventDefault();
//            if($(this).val(0)) {
//                $("select[id='list_provinsi']").val(0);
//                $("select[id='list_kabkot']").val(0);
//            }
//        });

        // Event listener for FILTER button
        // update datatable #mytable content appropriate by filter
        $("#filter_datatable_satuharga").on("click", function (e) {
                e.preventDefault();

                // get value from query string to use as url parameters
                var start_date = $("input[name=start_date]").val().replace(/\//g, "-"); // replace "/" to "x" globally
                var end_date = $("input[name=end_date]").val().replace(/\//g, "-"); // replace "/" to "x" globally
                var id_bbm = $("select[id=id_bbm]").val();
                var id_prov = $("select[id=list_provinsi]").val();
                var id_kabkot = $("select[id=list_kabkot]").val();

                // create url & url params
                var params = `start_date=${start_date}&end_date=${end_date}&id_bbm=${id_bbm}&id_prov=${id_prov}&id_kabkot=${id_kabkot}`;
                var url_param_dt = `https://ptmsatuharga.com/Api/satuharga/filter_test/?${params}`;

                // init, reinit, and destroy datatable
                $('#mytable').DataTable({
                    "order": [
                        [7, "desc"]
                    ],
                    "scrollX": true,
                    "ajax": {
                        url: url_param_dt,
                        dataSrc: ""
                    },
                    "columns": [
                        {
                            "name": "first",
                            "data": "no_spbu"
                        },
                        {"data": "pilihan_bbm"},
                        {"data": "stok_awal"},
                        {"data": "terima"},
                        {"data": "jual"},
                        {"data": "stok_akhir"},
                        {"data": "loses"},
                        {"data": "tgl"},
                        {"data": "provinsi"},
                        {"data": "kabupaten"}
                    ],
                    "rowsGroup": [
                        'first:name', 0, 0
                    ],
                    "bDestroy": true
                });
            }
        );


    });
</script>

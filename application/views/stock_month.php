<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 dahsboard-column">
                <section class="box-typical box-typical-dashboard panel x-ua-compatible scrollable">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">Report Stok Bulanan
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
                            <div class="row" style="margin-bottom: 2em;">
                                <div class="col-md-3">
                                    <select id="no_spbu" class="select2">
                                        <!--<option value="0">Cari No SPBU</option>-->
                                    </select>
                                </div> 
                                <div class="col-md-1 exp-button">
                                    <a id="filter_datatable_satuharga" class="btn btn-primary">Search</a>
                                </div>
                                <!--<div class="col-md-1 exp-button">-->
                                <!--    <a href="<?php echo site_url() ?>home/excel" class="btn btn-success">Export</a>-->
                                <!--</div>-->
                            </div> <!-- row mb -->
                            <span id="found" class="label label-info"></span>
                            <table id="mytable" class="table table-bordered table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>No. SPBU</th>
                                    <th>Produk BBM</th>
                                    <th>Stok Awal (Lt)</th>
                                    <th>Penerimaan BBM (Lt)</th>
                                    <th>Jual (Lt)</th>                                    
                                    <th>Losses (Lt)</th>
                                    <th>Stok Akhir (Lt)</th>
                                    <th>Kabupaten</th>
                                    <th>Provinsi</th>
                                    <th>Tgl</th>                                    
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function () {
        $('input[name="start_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '2018-11-01',
            locale: {
                format: 'YYYY/MM/DD'
            }
        }, function (start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
            $.ajax({
                type: 'POST',
                data: {
                    date_start: start.format('YYYY-MM-DD')
                },
                url: 'http://localhost/ptm/home/ajax_store_datepicker_input_start',
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    });
</script>

<script>
    $(function () {
        $('input[name="end_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '2018-11-01',
            locale: {
                format: 'YYYY/MM/DD'
            }
        }, function (start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
            $.ajax({
                type: 'POST',
                data: {
                    date_end: start.format('YYYY-MM-DD')
                },
                url: 'http://localhost/ptm/home/ajax_store_datepicker_input_end',
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    });
</script>
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
        
        
        // filter no_spbu (modul stok)
        var urlSpbuStok = "http://ptmsolar.com/api_pertamina/apix_satuharga/api_report/get_spbu_stok";
        var select_no_spbu = $('#no_spbu');
        
        $.get(urlSpbuStok, function(result) {
            select_no_spbu.empty();
            let r = JSON.parse(result);
            var noSpbu = "";
            $.each(r.data, function(i, val) {
                if(i == 0) {
                    noSpbu += `<option value='${i}'>Pilih No SPBU</option>`;                    
                } else {
                     noSpbu += `<option value='${val.no_spbu}'>${val.no_spbu}</option>`;   
                }
            });
            select_no_spbu.append(noSpbu);
        });


        // Event listener for PROVINSI
        // fetch data for select2 dropdown `kab kota`
        select_no_spbu.on('select2:select', function (e) {
            e.preventDefault();
            console.log($(this).val());
        });


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
                if($.fn.dataTable.isDataTable('#mytable')){

                  $('#mytable').DataTable().clear();

                  $('#mytable').DataTable().destroy();

                }
                e.preventDefault();

                // get value from query string to use as url parameters
                var start_date = $("input[name=start_date]").val().replace(/\//g, "-"); // replace "/" to "x" globally
                var end_date = $("input[name=end_date]").val().replace(/\//g, "-"); // replace "/" to "x" globally
                // var id_bbm = $("select[id=id_bbm]").val();
                var no_spbu = $("select[id=no_spbu]").val();
                // var no_pol = $("select[id=no_pol]").val();
                
                // console.log(start_date, end_date,);

                // create url & url params
                var url_param_dt = `http://ptmsolar.com/api_pertamina/apix_satuharga/api_report/get_report_bulanan`;

                // init, reinit, and destroy datatable
                $('#mytable').DataTable({
                	"processing": true,
                    "scrollX": true,
                    "serverSide": true,
                    "ajax": {
		                // "url": base_url+"konsumen/transaksi",
		                url: url_param_dt,
		                type: "GET",
		                data : {"no_spbu":no_spbu,"end_date":end_date, "start_date": start_date}
		            }
                });
            }
        );


    });
</script>

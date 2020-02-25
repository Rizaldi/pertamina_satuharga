<style>

    .btn.btn-default {

        background: #46c35f;

    }



    .titlez {

        padding-top: 8px;

        font-size: 14px;

        padding-right: 0px;

    }



    .col-lg-1.titlez {

        width: 12%;

    }

.zui-table {

    border: none;

    border-right: solid 1px #DDEFEF;

    border-collapse: separate;

    border-spacing: 0;

    font: normal 13px Arial, sans-serif;

}

.zui-table thead th {

    background-color: #DDEFEF;

    border: none;

    color: #336B6B;

    padding: 10px;

    text-align: left;

    text-shadow: 1px 1px 1px #fff;

    white-space: nowrap;

}

.zui-table tbody td {

    border-bottom: solid 1px #DDEFEF;

    color: #333;

    padding: 10px;

    text-shadow: 1px 1px 1px #fff;

    white-space: nowrap;

}

.zui-wrapper {

    position: relative;

}

.zui-scroller {

    margin-left: 480px;

    overflow-x: scroll;

    overflow-y: visible;

    padding-bottom: 5px;

    width: 51%;

}

.zui-table .zui-sticky-col {

    border-left: solid 1px #DDEFEF;

    border-right: solid 1px #DDEFEF;

    left: 20px;

    position: absolute;

    top: auto;

    width: 100px;

}

.zui-table .zui-sticky-coldua {

    border-left: solid 1px #DDEFEF;

    border-right: solid 1px #DDEFEF;

    left: 120px;

    position: absolute;

    top: auto;

    width: 180px;

}

.zui-table .zui-sticky-coltiga {

    border-left: solid 1px #DDEFEF;

    border-right: solid 1px #DDEFEF;

    left: 300px;

    position: absolute;

    top: auto;

    width: 180px;

}

</style>
<!-- <script src="<?php echo base_url('') ?>assets/js/lib/jquery/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<div class="page-content">

    <div class="container-fluid">

        <header class="box-typical-header card-header">

            <div class="tbl-row">

                <div class="tbl-cell tbl-cell-title">

                    <h3>REPORT DAILY SALE</h3>

                </div>

            </div>

        </header>

        <form action="<?php echo site_url('reports/dailySale'); ?>" method="post">

            <div class="row">

                <fieldset class="form-group">

                    <div class="col-lg-1 semibold titlez">Tanggal</div>

                    <div class="col-lg-3">

                        <div class="input-group" data-autoclose="true">

                            <?php

                            $tgl_start = isset($s_tgl) ? $s_tgl : date("Y-m-d");

                            if ($tgl_start == "0000-00-00") $tgl = date("Y-m-d");

                            if ($tgl_start) {

                                $exp = explode("-", $tgl_start);

                                $tgl_start = $exp[2] . "/" . $exp[1] . "/" . $exp[0];

                            }

                            ?>

                            <input type="text" name="tgl_start" class="form-control date" placeholder="dd/mm/yyyy"

                                   value="<?php echo $tgl_start; ?>">

                            <span class="input-group-addon">

								<span class="font-icon font-icon-calend"></span>

							</span>

                        </div>

                    </div>

                    <div class="col-lg-1 semibold titlez">Sampai</div>

                    <div class="col-lg-3">

                        <div class="input-group" data-autoclose="true">

                            <?php

                            $tgl_end = isset($e_tgl) ? $e_tgl : date("Y-m-d");

                            if ($tgl_end == "0000-00-00") $tgl_end = date("Y-m-d");

                            if ($tgl_end) {

                                $exp = explode("-", $tgl_end);

                                $tgl_end = $exp[2] . "/" . $exp[1] . "/" . $exp[0];

                            }

                            ?>

                            <input type="text" name="tgl_end" class="form-control date" placeholder="dd/mm/yyyy"

                                   value="<?php echo $tgl_end; ?>">

                            <span class="input-group-addon">

								<span class="font-icon font-icon-calend"></span>

							</span>

                        </div>

                    </div>

                    <div class="progress-demo">

                        <div class="form-group">

                            <input type="submit" value="SEARCH" name="tombol" class="btn btn-inline btn-success" />

                            <a id="export_avg" class="btn btn-inline btn-primary" href="<?php echo site_url('testing/get_all_spbu/?start_date='.$tgl_start.'&end_date='.$tgl_end.' '); ?>"

                               role="button">EXPORT</a>

                            </div>

                        </div>

                </fieldset>

            </div>

        </form>



        <div class="">

            <div class="streaming-table">

                <span id="found" class="label label-info"></span>

                <div class="zui-wrapper">

                    <div class="zui-scroller">

                        <table class="zui-table">

                            <?php #if($result != 1){ ?>

                            <thead>

                                <tr>

                                    <th class="zui-sticky-col">NO SPBU</th>

                                    <th class="zui-sticky-coldua">PROVINSI</th>

                                    <th class="zui-sticky-coltiga">KABUPATEN</th>

                                    <?php foreach ($colom as $h) { ?>

                                        <th><?php echo $h['day_name']; ?></th>

                                    <?php } ?>

                                </tr>

                                <tr>

                                    <th class="zui-sticky-col">&nbsp;</th>

                                    <th class="zui-sticky-coldua">&nbsp;</th>

                                    <th class="zui-sticky-coltiga">&nbsp;</th>

                                    <?php foreach ($colom as $h) { ?>

                                        <th><?php echo date('d M Y', strtotime($h['date_col'])); ?></th>

                                    <?php } ?>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($result as $r) { ?>

                                <tr>

                                    <td class="zui-sticky-col"><?php echo $r['no_spbu']; ?></td>

                                    <td class="zui-sticky-coldua"><?php echo $r['provinsi']; ?></td>

                                    <td class="zui-sticky-coltiga"><?php echo $r['kab']; ?></td>

                                    <?php 

                                    foreach ($colom as $c) { ?>

                                        <?php 

                                        $liter = "";

                                        foreach ($r['transaction'] as $t) { ?>

                                            <?php if($c['date_col'] == $t['date']){ 

                                                $liter = 'Rp '.number_format($t['rekap_penjualan'],0,",",".");

                                            break; } ?>

                                        <?php } ?>

                                        <td><?php if(!empty($liter)){echo $liter;}else{echo"&nbsp;";} ?></td>

                                    <?php } ?>

                                </tr>

                                <?php } ?>

                            </tbody>

                            <?php #} else echo ""; ?>

                        </table>

                    </div>

                </div>

                <br><br>

            </div>

        </div>

    </div>

</div>



<!-- <script src="<?php echo base_url(); ?>assets/js/lib/datatables-net/datatables.min.js"></script> -->

<link href="<?php echo base_url(); ?>assets/css/lib/datatables-net/datatables.min.css" rel="stylesheet"

      type="text/css"/>

<link href="<?php echo base_url(); ?>assets/css/separate/vendor/datatables-net.min.css" rel="stylesheet"

      type="text/css"/>

<script>

    // var table;

    // $(document).ready(function () {

    //     //datatables

    //     table = $('#table-edit').DataTable({

    //         //"scrollY": "970px",

    //         "order": [],

    //         "searching": false,

    //         "processing": true, //Feature control the processing indicator.

    //         "serverSide": true, //Feature control DataTables' server-side processing mode.

    //         "scrollX": true,

    //         "lengthChange": true,

    //         "lengthMenu": [[20, 200, 400], [20, 200, 400]],

    //         "language": {

    //             "search": "Search",

    //         },

    //         "columnDefs": [

    //             //{orderable: false, targets: [ 2,5,9,11,12,13,14 ] }

    //             {orderable: false, targets: [4, 7]}

    //         ],

    //         // Load data for the table's content from an Ajax source

    //         "ajax": {

    //             "url": "<?php #echo site_url($filename . '/bbm_list/' . $param);?>",

    //             "type": "POST"

    //         },

    //         /*dom: 'Bfrtlp',

    //          buttons: [

    //          'excel'

    //          ]*/

    //     });

    // });

</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/lib/jquery-flex-label/jquery.flex.label.css"> 
<!-- Original -->

<script src="<?php echo base_url(); ?>assets/js/lib/jquery-flex-label/jquery.flex.label.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/input-mask/jquery.mask.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/input-mask/input-mask-init.js"></script>



<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/ladda-button/ladda-themeless.min.css">

<script src="<?php echo base_url(); ?>assets/js/lib/ladda-button/spin.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/ladda-button/ladda.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/ladda-button/ladda-button-init.js"></script>



<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/clockpicker/bootstrap-clockpicker.min.css">

<script src="<?php echo base_url(); ?>assets/js/lib/clockpicker/bootstrap-clockpicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/clockpicker/bootstrap-clockpicker-init.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/separate/vendor/bootstrap-daterangepicker.min.css">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/moment/moment-with-locales.min.js"></script>

<script type="text/javascript"

        src="<?php echo base_url(); ?>assets/js/lib/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/daterangepicker/daterangepicker.js"></script>



<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/separate/vendor/select2.min.css">

<script src="<?php echo base_url(); ?>assets/js/lib/bootstrap-select/bootstrap-select.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/lib/select2/select2.full.min.js"></script>



<script type="application/javascript">

    (function ($) {

        $(document).ready(function () {

            $('.fl-flex-label').flexLabel();

            $('.date').daterangepicker({

                singleDatePicker: true,

                showDropdowns: true,

                locale: {

                    format: 'DD/MM/YYYY'

                },

            });



            var url = window.location.origin + "/testing/get_all_spbu/?";

            var download_url = "";

            var start_d = "";

            var end_d = "&end_date=" + new Date().toISOString().slice(0,10); // tambahkan current date



            var dateObj = new Date();

            var default_m = dateObj.getUTCMonth() + 1; //months from 1-12

            var default_d = dateObj.getUTCDate();

            var default_y = dateObj.getUTCFullYear();



            var current_date = default_y + '-' + default_m + '-' + default_d;



            // add default href for export daily avg button

//            $("#export_avg").attr("href", url + "start_date=" + current_date + "&end_date=" + current_date);



            $("input[name=tgl_start]").on('apply.daterangepicker', function (ev, picker) {

                var tgl_start =  $(this).val();



                // start date

                var sdd = tgl_start.substr(0, 2);

                var smm = tgl_start.substr(3, 2);

                var syy = tgl_start.substr(6, 4);



                start_d = "start_date=" + syy + "-" + smm + "-" + sdd;



                $("#export_avg").attr("href", url + start_d + end_d);

                download_url = url + start_d + end_d;

                console.log(download_url);

            });



            $("input[name=tgl_end]").on('apply.daterangepicker', function (ev, picker) {

                var tgl_end =  $(this).val();



                // end date

                var edd = tgl_end.substr(0, 2);

                var emm = tgl_end.substr(3, 2);

                var eyy = tgl_end.substr(6, 4);



                end_d = "&end_date=" + eyy + "-" + emm + "-" + edd;;

                $("#export_avg").attr("href", url + start_d + end_d);

                download_url = url + start_d + end_d;

                console.log(download_url);

            });



            $("#export_avg").on("click", function (ev) {

                console.log("download from url : " + download_url);

            });



            $('.prov').change(function () {

                get_kab($(this).val());

            });



        });

    })(jQuery);





    var id_prop = '<?php echo $id_prov;?>';

    var id_kab  = '<?php echo $id_kab;?>';

    if (id_prop > 0) get_kab(id_prop, id_kab);

    function get_kab(val, val_kab) {

        $.post('<?php echo base_url();?>report/get_kabupaten', {id_prop: val, id_kab: val_kab}, function (data) {

            $("#id_kab").html(data);

        });

    }





</script>
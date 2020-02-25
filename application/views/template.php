<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title; ?></title>

    <link href="<?php echo base_url(); ?>assets/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png"
          sizes="144x144">
    <link href="<?php echo base_url(); ?>assets/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png"
          sizes="114x114">
    <link href="<?php echo base_url(); ?>assets/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png"
          sizes="72x72">
    <link href="<?php echo base_url(); ?>assets/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="<?php echo base_url(); ?>assets/img/favicon.png" rel="icon" type="image/png">
    <link href="<?php echo base_url(); ?>assets/img/favicon.ico" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--  select2 dropdown  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/lobipanel/lobipanel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/separate/vendor/lobipanel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/separate/pages/widgets.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/desktop.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script src="<?php echo base_url(); ?>assets/js/lib/jquery/jquery.min.js"></script>
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php $this->load->view($header); ?>

<?php $this->load->view($sidebar); ?>

<?php $this->load->view($main); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/tether/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/jqueryui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/lobipanel/lobipanel.min.js"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>assets/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>-->
<script type="text/javascript">
//
//    $(document).ready(function () {
//        const url = window.location.origin + '/Api/satuharga/transaction';
//        // const url = window.location.origin + '/stokbbmsatuharga.com/Api/satuharga/transaction';
//        $('#mytable').DataTable({
//            "order": [
//                [7, "desc"]
//            ],
//            "scrollX": true,
//            "ajax": url,
//            "columns": [
//                {
//                    "name": "first",
//                    "data": "no_spbu"
//                },
//                {
//                    "data": "pilihan_bbm"
//                },
//                {"data": "stok_awal"},
//                {"data": "terima"},
//                {"data": "jual"},
//                {"data": "stok_akhir"},
//                {"data": "loses"},
//                {"data": "tgl"},
//            ],
//            "rowsGroup": [
//                'first:name', 0, 0
//            ],
//            "pageLength": "20"
//        });
//    });

</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
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
                url: '<?php echo site_url('home/ajax_store_datepicker_input_start'); ?>',
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
                url: '<?php echo site_url('home/ajax_store_datepicker_input_end'); ?>',
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

</body>
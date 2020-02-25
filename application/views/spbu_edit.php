<div class="page-content">
    <div class="container-fluid" style="background:none;">
        <section class="card card-blue">
            <header class="card-header" style="padding-left:20px;">
                <?php echo $title; ?>
            </header>
            <div class="card-block">
                <form action="<?php echo site_url($filename . '/update'); ?>" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo isset($row_spbu['id']) ? $row_spbu['id'] : 0; ?>">
                    <div class="row">
                        <fieldset class="form-group">
                            <div class="col-lg-8">
                                <label class="form-label semibold" for="exampleInput">No SPBU</label>
                                <div class="input-group">
                                    <?php
                                    echo form_input("no_spbu", isset($row_spbu['no_spbu']) ? $row_spbu['no_spbu'] : '', "class='form-control' required");
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="form-group">
                            <div class="col-lg-8">
                                <label class="form-label semibold" for="exampleInput">Password</label>
                                <div class="input-group">
                                    <?php
                                    echo form_password("password", isset($row_spbu['password']) ? base64_decode($row_spbu['password']) : '', "class='form-control' required");
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Lokasi SPBU -->
                    <div class="row">
                        <fieldset class="form-group">
                            <div class="col-lg-8">
                                <label class="form-label semibold" for="exampleInput">Lokasi SPBU</label>
                                <div class="input-group">
                                    <?php
                                    echo form_input("lokasi", isset($row_spbu['lokasi']) ? $row_spbu['lokasi'] : '', "class='form-control' required");
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Region -->
                    <div class="row">
                        <fieldset class="form-group">
                            <div class="col-lg-8">
                                <label class="form-label semibold" for="exampleInput">Region</label>
                                <div class="input-group">
                                    <?php
                                    echo form_input("region", isset($row_spbu['region']) ? $row_spbu['region'] : '', "class='form-control' required");
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>


                    <div class="row">
                        <fieldset class="form-group">
                            <div class="col-lg-8">
                                <label class="form-label semibold" for="exampleInput">Provinsi</label>
                                <div class="input-group">
                                    <?php
                                    $id_prov = isset($row_spbu['id_kab']) ? substr($row_spbu['id_kab'], 0, 2) : 0;
                                    echo form_dropdown("id_prov", $opt_prov, $id_prov, "class='prov form-control' required");
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="form-group">
                            <div class="col-lg-8">
                                <label class="form-label semibold" for="exampleInput">Kab/Kota</label>
                                <div class="input-group" id="id_kab">
                                    <?php
                                    $id_kab = isset($row_spbu['id_kab']) ? $row_spbu['id_kab'] : 0;
                                    echo form_dropdown("id_kab", $opt_kab, $id_kab, "class='form-control' required");
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="progress-demo">
                        <div class="form-group">
                            <br><br>
                            <button class="btn btn-inline btn-success ladda-button" data-style="expand-right"><span
                                        class="ladda-label">SIMPAN</span></button>
                            <input type="button" value="BACK" class="btn btn-inline btn-warning"
                                   onClick=javascript:window.location="<?php echo site_url('spbu'); ?>">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div><!--.container-fluid-->
</div><!--.page-content-->

<script src="<?php echo base_url(); ?>assets/js/lib/jquery/jquery.min.js"></script>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/separate/vendor/select2.min.css">
<script src="<?php echo base_url(); ?>assets/js/lib/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/select2/select2.full.min.js"></script>

<script type="application/javascript">
    $(function () {

        var id_kab = "<?php echo($row_spbu['id_kab'] ? $row_spbu['id_kab'] : 0) ?>";

        // if existing spbu opened
        if (id_kab > 0) {
            $('.prov').on('change load', function () {
                var id_prov = $(this).val();
                $.get("<?php echo site_url('spbu/get_kabupaten?id_prov=') ?>" + id_prov + "&id_kab=" + id_kab, function (data) {
                    $('#id_kab').html(data);
                });
            });

            $(window).load(function () {
                var id_prov = $('.prov').val();
                $.get("<?php echo site_url('spbu/get_kabupaten?id_prov=') ?>" + id_prov + "&id_kab=" + id_kab, function (data) {
                    $('#id_kab').html(data);
                });

            });
            // create new spbu
        } else {
            $('.prov').on('change load', function () {
                var id_prov = $(this).val();
                $.get("<?php echo site_url('spbu/get_kabupaten?id_prov=') ?>" + id_prov + "&id_kab=" + id_kab, function (data) {
                    $('#id_kab').html(data);
                });
            });
        }

    })
</script>
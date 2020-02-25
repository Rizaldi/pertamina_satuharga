
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
    </div><!--.container-fluid-->
</div><!--.page-content-->

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <figure class="highcharts-figure">
                    <div id="container_region"></div>
                </figure>
            </div>
        </div>
    </div><!--.container-fluid-->
</div><!--.page-content-->

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <figure class="highcharts-figure">
                    <div id="container_type_region"></div>
                </figure>
            </div>
        </div>
    </div><!--.container-fluid-->
</div><!--.page-content-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeEPj1UtxUnb5N39BEKbX2-GrcBTlW1sY&libraries=
places&callback=initAutocomplete"
async defer></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">$.noConflict();</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/mustache/mustache.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '<?php echo base_url('Reports/getTypeRegion') ?>',
            type: 'POST',
            dataType: 'json',
        })
        .done(function(data) {
            console.log(data);
            Highcharts.chart('container_type_region', {
                        chart: {
                            type: 'column',
                            title: 'SPBU Type Region'
                        },
                        title: {
                            text: 'SPBU Type Region'
                        },
                        subtitle: {
                            // text: 'Source: WorldClimate.com'
                        },
                        xAxis: {
                            categories: data.spbu_type,
                        },
                        yAxis: {
                            title: {
                                text: 'Data Target Per Region'
                            },
                            visible: true,
                            labels: {
                        format: '{value}'
                    },
                            min: 0,
                            max: 16,
                            opposite: true
                        },
                        plotOptions: {
                            line: {
                                stacking: 'normal',
                                pointPadding: 0,
                                groupPadding: 0,
                                dataLabels: {
                                    enabled: true,
                                    color: '#FFFFFF'
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: data
                    });  
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        $.ajax({
            url: '<?php echo base_url('Reports/getTargetRegion') ?>',
            type: 'POST',
            dataType: 'json',
        })
        .done(function(data) {
            console.log(data);
            Highcharts.chart('container_region', {
                        chart: {
                            type: 'column',
                            title: 'Target Region'
                        },
                        title: {
                            text: 'Target Per Region'
                        },
                        subtitle: {
                            // text: 'Source: WorldClimate.com'
                        },
                        xAxis: {
                            categories: [
                                '2017',
                                '2018',
                                '2019',
                                '2020'
                            ],
                        },
                        yAxis: {
                            title: {
                                text: 'Data Target Per Region'
                            },
                            visible: true,
                            labels: {
                        format: '{value}'
                    },
                            min: 0,
                            max: 16,
                            opposite: true
                        },
                        plotOptions: {
                            line: {
                                stacking: 'normal',
                                pointPadding: 0,
                                groupPadding: 0,
                                dataLabels: {
                                    enabled: true,
                                    color: '#FFFFFF'
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: data
                    });  
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        $.ajax({
            url: '<?php echo base_url('Reports/getTahap') ?>',
            type: 'POST',
            dataType: 'json',
        })
        .done(function(data) {
            Highcharts.chart('container', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Report Stage'
                        },
                        subtitle: {
                            // text: 'Source: WorldClimate.com'
                        },
                        xAxis: {
                            categories: data.parameter
                        },
                        yAxis: {
                            title: {
                                text: 'Data Tahap'
                            },
                            visible: false,
                            labels: {
                        format: '{value} %'
                    },
                            min: 0,
                            max: 400,
                            opposite: false
                        },
                        plotOptions: {
                            line: {
                                stacking: 'normal',
                                pointPadding: 0,
                                groupPadding: 0,
                                dataLabels: {
                                    enabled: true,
                                    color: '#FFFFFF'
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: [{
                            colorByPoint: true,
                            data: data.data_tahap
                        }]
                    });  
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    });
    var map;
    var myLatLng = {lat: -0.8243447, lng: 119.4417262};

    function CenterControl(controlDiv, map) {

            // Set CSS for the control border.
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#fff';
            controlUI.style.border = '2px solid #fff';
            controlUI.style.borderRadius = '3px';
            controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
            controlUI.style.cursor = 'pointer';
            controlUI.style.marginBottom = '22px';
            controlUI.style.textAlign = 'left';
            controlUI.title = 'Click to recenter the map';
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior.
            var controlText = document.createElement('div');
            controlText.style.color = 'rgb(25,25,25)';
            controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
            controlText.style.fontSize = '16px';
            controlText.style.lineHeight = '38px';
            controlText.style.paddingLeft = '5px';
            controlText.style.paddingRight = '5px';
            controlText.innerHTML = 'Add New Location';
            controlUI.appendChild(controlText);

            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener('click', function() {
              // map.setCenter(myLatLng);
                $('#addLocationModal').modal({backdrop: 'static', keyboard: false});
                $("#addLocationModal").modal('show');
            });

    }
    function initAutocomplete() {
        var iconBase = "<?php echo base_url('assets/img/') ?>";

        var icons = {
          parking: {
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            icon: iconBase + 'library_maps.png'
          },
          info: {
            icon: iconBase + 'info-i_maps.png'
          }
        };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: myLatLng
        });
        var centerControlDiv = document.createElement('div');
        var centerControl = new CenterControl(centerControlDiv, map);

        centerControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
        var marker;
        var mark;
        var no_spbu_s;
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Maps/get_location') ?>",
            dataType: "json",
            success: function(data) {
                
                for(var i in data){
                    var icon;
                    if (data[i].tahun_operasi == "2017" || data[i].tahun_operasi == "2018" || data[i].tahun_operasi == "2019") {
                        icon = iconBase + 'iconlama.png';
                    }
                    else if (data[i].tahun_operasi == "2020"){
                        icon = iconBase + 'iconbaru.png';
                    }else{
                        icon = iconBase + 'iconlama.png';
                    }
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(data[i].lat, data[i].lng),
                        map: map,
                        id_info_spbu:data[i].id,
                        no_spbu:data[i].no_spbu,
                        icon: icon,
                        title: data[i].no_spbu
                    });
                    google.maps.event.addListener(marker, 'click', (function(marker) {
                        return function() {
                            mark = marker.id_info_spbu;
                            no_spbu_s = marker.no_spbu;
                            // console.log(no_spbu_s);
                            $(".modal-title").text(no_spbu_s);
                            $(".modal-body").text("");
                            $('#myModal').modal({backdrop: 'static', keyboard: false});
                            $("#myModal").modal('show');
                        }
                    })(marker));

                }
            }
        });

        $("#insert_detail").click(function() {
            // console.log("submit");
            var fd = new FormData();
            var files = $('#image_spbu')[0].files[0];
            fd.append('image_spbu',files);

            fd.append('pengusaha',$("#pengusaha").val());
            fd.append('no_spbu',$("#no_spbu").val());
            fd.append('alamat',$("#alamat").val());
            fd.append('tahun_operasi',$("#tahun_operasi").val());
            fd.append('mor',$("#mor").val());
            fd.append('prov',$("#prov").val());
            fd.append('kab',$("#kab").val());
            fd.append('kec',$("#kec").val());
            fd.append('lat',$("#lat").val());
            fd.append('lng',$("#lng").val());

            fd.append('tgl_operasional',$("#tgl_operasional").val());

            $.ajax({
                url: '<?php echo base_url('Maps/insert_detail') ?>',
                type: 'POST',
                dataType: 'json',
                data: fd,
                cache : false,
                processData: false,
                contentType: false
            })
            .done(function() {
                toastr.success('Insert Detail.', 'Success Insert Data', {timeOut: 5000});
                window.location.reload(true);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        });
        $("#myModal").on('show.bs.modal', function(data){
            console.log(no_spbu_s);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Maps/get_location_id') ?>",
                data: {"id_info":mark, "no_spbu":no_spbu_s},
                dataType: "json",
                success: function(data) {
                    var html = "";
                    html += '<div style="height:200px;overflow-y: scroll;">';
                    html += '<p id="total_progress">'+data.total_progress+'%</p>';
                    $.each(data.data_bobot, function(index, val) {
                        html += '<button style="background:#00A8FF;color:white;" onclick="myFunction(Demo2)" class="w3-button w3-block w3-left-align"> '+val.progress_name+'</button><div id="Demo2" style="border:solid 1px black;" class="w3-container"> <p>'+parseFloat(val.last_progress)+'%</p> </div>';

                    });
                    html += '</div>';
                    html += '<br><br><button class="btn btn-primary" style="float:right;" id="update_detail" data-id="'+data.id+'">Update Detail</button><button class="btn btn-primary" style="float:right;display:none;" id="save_detail" data-id="'+data.id+'">Save Detail</button><br><br><img width="300" src="<?php echo base_url('assets/img/img_spbu/'); ?>'+data.image_spbu+'"><div id="img_spbu"></div><br><br><div style="height:500px;overflow-y: scroll;"><table width="100%" border="1"> <tbody> <tr> <td width="25%">Last Update</td> <td class="MarkerModal__onlyDesktop--1N9vw">'+data.modified_at+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Pengusaha</td> <td id="pengusaha"> <h5 class="MarkerModal__onlyMobile--22ncp"></h5>'+data.pengusaha+' </td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">No. Lembaga</td> <td id="no_spbu">'+data.no_spbu+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Alamat</td> <td id="alamat">'+data.alamat+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Tipe</td> <td id="jenis_spbu">'+data.jenis_spbu+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Tahap</td> <td> <h5 class="MarkerModal__onlyMobile--22ncp">Tahap</h5>Operasi</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Rencana Beroperasi</td> <td id="tahun_operasi">'+data.tahun_operasi+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Region</td> <td id="region">'+data.mor+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Propinsi</td> <td id="provinsi">'+data.prov+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Kabupaten</td> <td id="kabupaten">'+data.kab+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Kecamatan</td> <td id="kecamatan">'+data.kec+'</td> </tr> <tr> <th colspan="2">Location Details</th> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Latitude</td> <td id="latitude">'+data.lat+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Longitude</td> <td id="longitude">'+data.lng+'</td> </tr> </tbody> </table></div><br><br><br>';
                    html += '<div class="row" style="margin-bottom: 1em;"> <div class="col-md-1"> <p style="padding-top: 8px">Tanggal</p> </div> <div class="col-md-3"> <div class="input-group" data-autoclose="true"> <input type="text" name="start_date" class="form-control date"value="<?php echo date("Y/m/d"); ?>"/> <span class="input-group-addon"> <span class="font-icon font-icon-calend"></span> </span> </div> </div> <div class="col-md-1"> <p style="padding-top: 8px">Sampai</p> </div> <div class="col-md-3"> <div class="input-group" data-autoclose="true"> <input type="text" name="end_date" id="end_date" class="form-control date"value="<?php echo date("Y/m/d"); ?>"/> <span class="input-group-addon"> <span class="font-icon font-icon-calend"></span> </span> </div> </div><div class="col-md-1 exp-button"></div> </div><br>';

                    html += '<table id="mapsTable" class="table table-bordered table-hover" style="width:100%;"> <thead> <tr> <th>No.</th> <th>No.SPBU</th> <th>Pilihan BBM</th> <th>Stok Awal</th> <th>Penerimaan BBM</th> <th>Penjualan</th> <th>Stok Akhir</th> <!--<th>Loses</th>--> <th>Dot</th><th>Cd</th><th>Tanggal</th> </thead> <tbody> <tr><td>12345</td><td>12345</td><td>12345</td><td>12345</td><td>12345</td><td>12345</td><td>12345</td></tr> </tbody> </table>';
                    function filter_datatable_satuharga() {
                        console.log("test");
                    }
                    $("#end_date").change(function() {
                        console.log("test");
                    });
                    
                    $(".modal-body").html(html);
                    $(".modal-body").html(html);
                    function myFunction(id) {
                      var x = document.getElementById(id);
                      if (x.className.indexOf("w3-show") == -1) {
                        x.className += " w3-show";
                      } else { 
                        x.className = x.className.replace(" w3-show", "");
                      }
                    }
                    $("#mapsTable").DataTable({
                        "processing": true,
                        "serverSide": false,
                        "order": [[0, 'asc']], 
                        "oLanguage": {
                           "sSearch": "Pencarian",
                        },
                        "ajax": {
                            // "url": base_url+"konsumen/transaksi",
                            "url": "<?php echo base_url('Maps/get_data') ?>",
                            "type": "POST",
                            "data" : {"id_info": mark, "no_spbu":no_spbu_s}
                        },
                        "columnDefs": [
                            { 
                                "targets": [ 0 ],
                                "orderable": true, 
                                "width": 100,
                                "className": 'text-center'
                            },
                            { 
                                "targets": [ 2 ],
                                "width": 80,
                                "className": 'text-center'
                            },
                            { 
                                "targets": [ 3 ],
                                "width": 180,
                                "className": 'text-center'
                            },
                            { 
                                "targets": [ 4 ],
                                "width": 100,
                                "className": 'text-center'
                            },
                            { 
                                "targets": [ 5 ],
                                "width": 100,
                                "className": 'text-center'
                            },
                            { 
                                "targets": [ 6 ],
                                "orderable": false, 
                                "width": 100,
                                "className": 'text-center'
                            },
                        ]  
                    });
                    $("#save_detail").click(function() {
                        var fd = new FormData();
                        var files = $('#input_img_spbu')[0].files[0];
                        fd.append('img_spbu',files);

                        fd.append('input_id',$("#input_id").val());
                        fd.append('input_pengusaha',$("#input_pengusaha").val());
                        fd.append('input_no_spbu',$("#input_no_spbu").val());
                        fd.append('input_alamat',$("#input_alamat").val());
                        fd.append('input_tahun_operasi',$("#input_tahun_operasi").val());
                        fd.append('input_a',$("#input_a").val());
                        fd.append('input_region',$("#input_region").val());
                        fd.append('input_provinsi',$("#input_provinsi").val());
                        fd.append('input_kabupaten',$("#input_kabupaten").val());
                        fd.append('input_kecamatan',$("#input_kecamatan").val());
                        fd.append('input_latitude',$("#input_latitude").val());
                        fd.append('input_longitude',$("#input_longitude").val());
                        $.ajax({
                            url: '<?php echo base_url('Maps/update_detail') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: fd,
                            cache : false,
                            processData: false,
                            contentType: false
                        })
                        .done(function() {
                            toastr.success('Update Detail.', 'Success Update Data', {timeOut: 5000});
                            window.location.reload(true);
                        })
                        .fail(function() {
                            console.log("error");
                        })
                        .always(function() {
                            console.log("complete");
                        });
                    });
                    $("#update_detail").click(function() {
                        $("#update_detail").hide();

                        $("#save_detail").show();
                        // console.log("ast");
                        var id = $(this).attr('data-id');
                        $("#pengusaha").html("<input class='form-control' type='hidden' id='input_id' name='id_info' value='"+id+"'><input class='form-control' type='text' id='input_pengusaha' name='pengusaha' value='"+$("#pengusaha").text()+"'>");
                        $("#img_spbu").html("<input class='form-control' type='file' id='input_img_spbu' name='img_spbu'>");
                        $("#no_spbu").html("<input class='form-control' type='text' id='input_no_spbu' name='no_spbu' value='"+$("#no_spbu").text()+"'>");
                        $("#alamat").html("<input class='form-control' type='text' id='input_alamat' name='alamat' value='"+$("#alamat").text()+"'>");
                        $("#jenis_spbu").html('<select class="form-control" name="spbuType"><option value="">Pilih Tipe SPBU</option><option value="DODO">DODO</option><option value="Kompak">Kompak</option><option value="Modular">Modular</option><option value="Mini">Mini</option><option value="SPBUN">SPBUN</option></select>');
                        $("#tahun_operasi").html("<input class='form-control' type='text' id='input_tahun_operasi' name='tahun_operasi' value='"+$("#tahun_operasi").text()+"'>");
                        $("#a").html("<input class='form-control' type='text' id='input_a' name='a' value='"+$("#a").text()+"'>");
                        $("#region").html("<input class='form-control' type='text' id='input_region' name='region' value='"+$("#region").text()+"'>");
                        $("#provinsi").html("<input class='form-control' type='text' id='input_provinsi' name='provinsi' value='"+$("#provinsi").text()+"'>");
                        $("#kabupaten").html("<input class='form-control' type='text' id='input_kabupaten' name='kabupaten' value='"+$("#kabupaten").text()+"'>");
                        $("#kecamatan").html("<input class='form-control' type='text' id='input_kecamatan' name='kecamatan' value='"+$("#kecamatan").text()+"'>");
                        $("#latitude").html("<input class='form-control' type='text' id='input_latitude' name='latitude' value='"+$("#latitude").text()+"'>");
                        $("#longitude").html("<input class='form-control' type='text' id='input_longitude' name='longitude' value='"+$("#longitude").text()+"'>");
                        // console.log(id);

                    });
                    $('input[name="start_date"]').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minDate: '2018-11-01',
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    }, function (start, end, label) {
                        console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
                        console.log("test");
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
                    $('input[name="end_date"]').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minDate: '2018-11-01',
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    }, function (start, end, label) {
                        if($.fn.dataTable.isDataTable('#mapsTable')){
                          $('#mapsTable').DataTable().clear();
                          $('#mapsTable').DataTable().destroy();
                        }
                        console.log("A new date selection was made: " + $("input[name='start_date']").val());
                        console.log("A new date selection was made: " + end.format('YYYY-MM-DD'));
                        // $.ajax({
                        //     type: 'POST',
                        //     data: {
                        //         date_start: $("input[name='start_date']").val(),
                        //         date_end: start.format('YYYY-MM-DD'),
                        //         id_info: mark, 
                        //         no_spbu: no_spbu_s
                        //     },
                        //     url: "<?php echo base_url('Maps/get_data') ?>",
                        //     success: function (data) {
                        //         if($.fn.dataTable.isDataTable('#mapsTable')){
                        //           $('#mapsTable').DataTable().clear();
                        //           $('#mapsTable').DataTable().destroy();
                        //         }
                        //     },
                        //     error: function (jqXHR, textStatus, errorThrown) {
                        //         console.log(errorThrown);
                        //     }
                        // });
                        $("#mapsTable").DataTable({
                            "processing": true,
                            "serverSide": false,
                            "order": [[0, 'asc']], 
                            "oLanguage": {
                               "sSearch": "Pencarian",
                            },
                            "ajax": {
                                "url": "<?php echo base_url('Maps/get_data') ?>",
                                "type": "POST",
                                "data" : {"id_info": mark, "no_spbu":no_spbu_s, "date_start": $("input[name='start_date']").val(), "date_end": start.format('YYYY-MM-DD')}
                            },
                            "columnDefs": [
                                { 
                                    "targets": [ 0 ],
                                    "orderable": true, 
                                    "width": 100,
                                    "className": 'text-center'
                                },
                                { 
                                    "targets": [ 2 ],
                                    "width": 80,
                                    "className": 'text-center'
                                },
                                { 
                                    "targets": [ 3 ],
                                    "width": 180,
                                    "className": 'text-center'
                                },
                                { 
                                    "targets": [ 4 ],
                                    "width": 100,
                                    "className": 'text-center'
                                },
                                { 
                                    "targets": [ 5 ],
                                    "width": 100,
                                    "className": 'text-center'
                                },
                                { 
                                    "targets": [ 6 ],
                                    "orderable": false, 
                                    "width": 100,
                                    "className": 'text-center'
                                },
                            ]  
                        });
                    });
                }
            });
        });
        var infowindow = new google.maps.InfoWindow();
        /*Google Map Marker Click Function*/
        
    }
</script>
<!-- <script>
    $(function () {
        $('input[name="start_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '2018-11-01',
            locale: {
                format: 'YYYY/MM/DD'
            }
        }, function (start, end, label) {
            console.log("test");
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
            console.log("A new date selection was made: " + end.format('YYYY-MM-DD'));

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
</script> -->
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
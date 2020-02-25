

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>

    .col-sm-9 div,.col-sm-3{

      margin-bottom:10px;

      color:#fff;

  }



  .col-sm-3{

      height:50px;

  }

  #map {

    height: 100%;

    width: 100%;

}

table {

  border-collapse: collapse;

  border-spacing: 0;

  width: 100%;

  border: 1px solid #ddd;

  padding: 15px;

}



th, td {

  text-align: left;

  padding: 50px;

}



tr:nth-child(even) {

  background-color: #f2f2f2;

}

/* width */

::-webkit-scrollbar {

  width: 5px;

}



/* Track */

::-webkit-scrollbar-track {

  box-shadow: inset 0 0 5px grey; 

  border-radius: 5px;

}



/* Handle */

::-webkit-scrollbar-thumb {

  background: #7B0000; 

  border-radius: 5px;

}



/* Handle on hover */

::-webkit-scrollbar-thumb:hover {

  background: #F2DEDE; 

}

/*** PANEL SUCCESS ***/

.with-nav-tabs.panel-success .nav-tabs > li > a,

.with-nav-tabs.panel-success .nav-tabs > li > a:hover,

.with-nav-tabs.panel-success .nav-tabs > li > a:focus {

    color: #3c763d;

}

.with-nav-tabs.panel-success .nav-tabs > .open > a,

.with-nav-tabs.panel-success .nav-tabs > .open > a:hover,

.with-nav-tabs.panel-success .nav-tabs > .open > a:focus,

.with-nav-tabs.panel-success .nav-tabs > li > a:hover,

.with-nav-tabs.panel-success .nav-tabs > li > a:focus {

    color: #3c763d;

    background-color: #d6e9c6;

    border-color: transparent;

}

.with-nav-tabs.panel-success .nav-tabs > li.active > a,

.with-nav-tabs.panel-success .nav-tabs > li.active > a:hover,

.with-nav-tabs.panel-success .nav-tabs > li.active > a:focus {

    color: #3c763d;

    background-color: #fff;

    border-color: #d6e9c6;

    border-bottom-color: transparent;

}

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu {

    background-color: #dff0d8;

    border-color: #d6e9c6;

}

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a {

    color: #3c763d;   

}

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {

    background-color: #d6e9c6;

}

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a,

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,

.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {

    color: #fff;

    background-color: #3c763d;

}



</style>

<div class="page-content" id="page_content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div id="map">



                </div>

            </div>

        </div>

    </div><!--.container-fluid-->

</div><!--.page-content-->



<br><br>

<figure class="highcharts-figure">

    <div id="container"></div>

</figure>





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

<div class="modal fade" id="myModal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content" style="width:900px;">

            <div class="modal-header">

                <h4 class="modal-title"></h4>

            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <!-- <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

          </button>

      </div> -->

  <div class="modal-body">

    <form method="post">

        <div class="MarkerModal__formContainer--1I8Ug top">

            <fieldset>

                <div class="form-group">

                    <label>SPBU No.</label>

                    <input type="text" class="form-control" id="no_spbu" name="no_spbu" placeholder="Type SPBU No…" value="">

                </div>

                <div class="form-group">

                    <label>SPBU Type</label>

                    <select class="form-control" id="jenis_spbu" name="jenis_spbu">

                        <option value="">Pilih Tipe SPBU</option>

                        <option value="DODO">DODO</option>

                        <option value="Kompak">Kompak</option>

                        <option value="Modular">Modular</option>

                        <option value="Mini">Mini</option>

                        <option value="SPBUN">SPBUN</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Region</label>

                    <select class="form-control" id="mor" name="mor">

                        <option value="">Pilih Region</option>

                        <option value="I">Region 1</option>

                        <option value="II">Region 2</option>

                        <option value="III">Region 3</option>

                        <option value="IV">Region 4</option>

                        <option value="V">Region 5</option>

                        <option value="VI">Region 6</option>

                        <option value="VII">Region 7</option>

                        <option value="VIII">Region 8</option>

                        <option value="NO">No region</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Province</label>

                    <select class="form-control" id="prov" name="prov">

                        <option value="">Pilih Propinsi</option>

                        <option value="Sumatera Utara">Sumatera Utara</option>

                        <option value="Sumatera Barat">Sumatera Barat</option>

                        <option value="Riau">Riau</option>

                        <option value="Kepulauan Riau">Kepulauan Riau</option>

                        <option value="Aceh">Aceh</option>

                        <option value="Sumatera Selatan">Sumatera Selatan</option>

                        <option value="Lampung">Lampung</option>

                        <option value="Jambi">Jambi</option>

                        <option value="Bangka-Belitung">Bangka-Belitung</option>

                        <option value="Bengkulu">Bengkulu</option>

                        <option value="DKI Jakarta">DKI Jakarta</option>

                        <option value="Jawa Barat">Jawa Barat</option>

                        <option value="Banten">Banten</option>

                        <option value="Jawa Tengah">Jawa Tengah</option>

                        <option value="D.I Yogyakarta">D.I Yogyakarta</option>

                        <option value="NTT">NTT</option>

                        <option value="NTB">NTB</option>

                        <option value="Jawa Timur">Jawa Timur</option>

                        <option value="Bali">Bali</option>

                        <option value="Kalimantan Utara">Kalimantan Utara</option>

                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>

                        <option value="Kalimantan Timur">Kalimantan Timur</option>

                        <option value="Kalimantan Barat">Kalimantan Barat</option>

                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>

                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>

                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>

                        <option value="Sulawesi Barat">Sulawesi Barat</option>

                        <option value="Sulawesi Utara">Sulawesi Utara</option>

                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>

                        <option value="Gorontalo">Gorontalo</option>

                        <option value="Papua">Papua</option>

                        <option value="Papua Barat">Papua Barat</option>

                        <option value="Maluku">Maluku</option>

                        <option value="Maluku Utara">Maluku Utara</option>

                        <option value="Teluk Cendrawasih">Teluk Cendrawasih</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>District</label>

                    <input type="text" class="form-control" id="kab" name="kab" placeholder="Type district name…" value="">

                </div>

                <div class="form-group">

                    <label>Sub District</label>

                    <input type="text" class="form-control" id="kec" name="kec" placeholder="Type sub-district name…" value="">

                </div>

                <div class="form-group">

                    <label>Address</label>

                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Type location address…"></textarea>

                </div>

                <div class="form-group">

                    <label>Keeper Name</label>

                    <input type="text" class="form-control" id="pengusaha" name="pengusaha" placeholder="Type keeper name…" value="">

                </div>

                <div class="group">

                    <label for="">Tahap</label>

                    <select class="form-control" id="tahap" name="tahap">

                        <option value="">Pilih Tahap</option>

                        <option value="1">Pembangunan</option>

                        <option value="2">Paralel Pembangunan</option>

                        <option value="3">Perizinan PEMDA</option>

                        <option value="4">Finalisasi</option>

                        <option value="5">Operasi</option>

                    </select>

                </div>

            </fieldset>

            <fieldset>

                <div class="form-group">

                    <label>Latitude</label>

                    <input type="text" class="form-control" id="lat" name="lat" value="">

                </div>

                <div class="form-group">

                    <label>Longitude</label>

                    <input type="text" class="form-control" id="lng" name="lng" value="">

                </div>

            </fieldset>

            <fieldset>

                <legend>Location Profile</legend>

                <div class="form-group">

                    <label for="">Operational Date</label>

                    <div class="DayPickerInput">

                        <input class="form-control" placeholder="YYYY-MM-DD" value="" id="tgl_operasional" name="tgl_operasional">

                    </div>

                </div>

                <div class="form-group">

                    <label for="">Location Image</label>

                    <input class="form-control" type="file" id="image_spbu" name="image_spbu">

                </div>

            </fieldset>

        </div>

    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="button" id="insert_detail" class="btn btn-primary">Save changes</button>

    </div>

</form>

</div>

</div>

</div>

<!-- Modal -->

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

      </button>

  </div>

  <div class="modal-body">

  </div>

  <div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

    <button type="submit" class="btn btn-primary">Save changes</button>

</div>

</div>

</div>

</div>

<div id="detail_location" type="text/template">

    <div class="row">

        <!-- <button style="background:#00A8FF;color:white;" onclick="myFunction(Demo2)" class="w3-button w3-block w3-left-align"> '+val.progress_name+'</button>

        <div id="Demo2" style="border:solid 1px black;" class="w3-container">

            <p>'+parseFloat(val.last_progress)+'%</p>

        </div> -->

        <div class="col-md-12">

            <div class="panel with-nav-tabs panel-success">

                <div class="panel-heading">

                    <ul class="nav nav-tabs">

                        <li class="active"><a href="#tab1success" data-toggle="tab">Detail Info</a></li>

                        <li><a href="#tab2success" data-toggle="tab">Data DOT & CD</a></li>

                    </ul>

                </div>

                <div class="panel-body">

                    <div class="tab-content">

                        <div class="tab-pane fade in active" id="tab1success">

                            <div class="row">

                                <div class="col-sm-4">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <br><br>

                                            <img style="width:275px;height: 200px;" src="<?php echo base_url('assets/img/img_spbu/'); ?>{{image_spbu}}"><div id="img_spbu"></div><br>

                                        </div>

                                        <div class="col-md-12" style="height: 150px; overflow-y: scroll;">

                                            Total Progress <div id="total_progress"></div>

                                            <div id="bobot_progress">

                                                

                                            </div>

                                            <!-- {{#bobot_progress_name}}

                                            <button style="background:#00A8FF;color:white;" onclick="myFunction(Demo2)" class="w3-button w3-block w3-left-align">{{progress_name}} </button>

                                            <div id="Demo2" style="border:solid 1px black;" class="w3-container">

                                                <p>{{last_progress}}</p>

                                            </div>

                                            <div class="form-check" id="{{id}}">

                                              <input class="parent-check progress-check form-check-input" type="checkbox" value="" id="{{id}}" >

                                              <label class="form-check-label" for="defaultCheck1">

                                                {{progress_name}} 

                                              </label>

                                            </div>

                                            {{#bobots}}

                                                    <div style="margin-left: 20px" class="form-check">

                                                      <input class="progress-check form-check-input" type="checkbox" value="" id="{{id}}">

                                                      <label class="form-check-label" for="defaultCheck1">

                                                        {{sub_progress_name}} 

                                                      </label>

                                                    </div>

                                            {{/bobots}}

                                            {{/bobot_progress_name}} -->

                                        </div>

                                    </div>

                                </div>

                                <div class="col-sm-8 hidden-xs">

                                    <div style="height:400px;overflow-y: scroll;">

                                            <div style="padding-right: 5px; float: right;">

                                                <button class="btn btn-primary" style="float:right;" id="update_detail" data-id="{{id}}">Update Detail</button>

                                                    <button class="btn btn-primary" style="float:right;display:none;" id="save_detail" data-id="{{id}}">Save Detail</button>

                                                <br><br>

                                            </div>

                                        <table>

                                            <tbody>

                                                <tr>

                                                    <td width="25%" style="padding: 10px;">Last Update</td>

                                                    <td></td>

                                                </tr>

                                                <tr>

                                                    <td style="padding: 10px;">Pengusaha</td>

                                                    <td style="padding: 10px;" id="pengusaha">

                                                        <h5></h5>{{pengusaha}} </td>

                                                    </tr>

                                                    <tr>

                                                        <td style="padding: 10px;">No. Lembaga</td>

                                                        <td style="padding: 10px;" id="no_spbu">{{no_spbu}}</td>

                                                    </tr>

                                                    <tr>

                                                        <td style="padding: 10px;">Alamat</td>

                                                        <td style="padding: 10px;" id="alamat">{{alamat}}</td>

                                                    </tr>

                                                    <tr>

                                                        <td style="padding: 10px;">Tipe</td>

                                                        <td style="padding: 10px;" id="jenis_spbu">{{jenis_spbu}}</td>

                                                    </tr>

                                                    <tr>

                                                        <td style="padding: 10px;">Tahap</td>

                                                        <td style="padding: 10px;">

                                                            <h5>Tahap</h5>Operasi</td>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Rencana Beroperasi</td>

                                                            <td style="padding: 10px;" id="tahun_operasi">{{tahun_operasi}}</td>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Region</td>

                                                            <td style="padding: 10px;" id="region">{{mor}}</td>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Propinsi</td>

                                                            <td style="padding: 10px;" id="provinsi">{{prov}}</td>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Kabupaten</td>

                                                            <td style="padding: 10px;" id="kabupaten">{{kab}}</td>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Kecamatan</td>

                                                            <td style="padding: 10px;" id="kecamatan">{{kec}}</td>

                                                        </tr>

                                                        <tr>

                                                            <th colspan="2">Location Details</th>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Latitude</td>

                                                            <td style="padding: 10px;" id="latitude">{{lat}}</td>

                                                        </tr>

                                                        <tr>

                                                            <td style="padding: 10px;">Longitude</td>

                                                            <td style="padding: 10px;" id="longitude">{{lng}}</td>

                                                        </tr>

                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane fade" id="tab2success">

                                    <div class="row" style="margin-bottom: 1em;">

                                        <div class="col-md-1">

                                            <p style="padding-top: 8px">Tanggal</p>

                                        </div>

                                        <div class="col-md-3">

                                            <div class="input-group" data-autoclose="true">

                                                <input type="text" name="start_date" class="form-control date" value="<?php echo date(" Y/m/d "); ?>"/> <span class="input-group-addon"> <span class="font-icon font-icon-calend"></span> </span>

                                            </div>

                                        </div>

                                        <div class="col-md-1">

                                            <p style="padding-top: 8px">Sampai</p>

                                        </div>

                                        <div class="col-md-3">

                                            <div class="input-group" data-autoclose="true">

                                                <input type="text" name="end_date" id="end_date" class="form-control date" value="<?php echo date(" Y/m/d "); ?>"/> <span class="input-group-addon"> <span class="font-icon font-icon-calend"></span> </span>

                                            </div>

                                        </div>

                                        <div class="col-md-1 exp-button"></div>

                                    </div>

                                    <br>



                                    <table id="mapsTable" class="table table-bordered table-hover" style="width:100%;">

                                        <thead>

                                            <tr>

                                                <th>No.</th>

                                                <th>No.SPBU</th>

                                                <th>Pilihan BBM</th>

                                                <th>Stok Awal</th>

                                                <th>Penerimaan BBM</th>

                                                <th>Penjualan</th>

                                                <th>Stok Akhir</th>

                                                <!--<th>Loses</th>-->

                                                <th>Dot</th>

                                                <th>Cd</th>

                                                <th>Tanggal</th>

                                        </thead>

                                        <tbody>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">



                    </div>

                </div>

            </div>

        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeEPj1UtxUnb5N39BEKbX2-GrcBTlW1sY&libraries=

        places&callback=initAutocomplete"

        async defer></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/pace.js"></script>

        <script type="text/javascript">$.noConflict();</script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/lib/jquery/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.0/mustache.min.js"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <script src="https://code.highcharts.com/modules/export-data.js"></script>

        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <script>

            let url = '<?php echo site_url('maps/') ?>update_progress'; // insert

            let loadProgressUrl = '<?php echo site_url('maps/') ?>load_progress'; // insert



            async function updateProgress(url, queryParams) {

                let response = await axios.post(url, queryParams); 

                let data = await response.data;

                return data;

            }



            async function loadProgress(url) {

                let response = await axios.get(url); 

                let data = await response.data;

                return data;

            }

            async function loadProgressWithParam(url, queryParams) {

                let response = await axios.post(url, queryParams); 

                let data = await response.data;

                return data;

            }

            $(document).ready(function() {

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

            controlUI.addEventListener('click', function(event) {

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
        $('#addLocationModal').on('hidden.bs.modal', function () {
            $(".modal-footer").html('<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div>');
        });
        $('#myModal').on('hidden.bs.modal', function () {
            console.log("close");
            // refreshMyDiv();
            // location.reload();
            // $("#page_content").load(location.href + " #page_content");
            // $(".modal-header").html("Add new Location");
            $(".modal-body").html('<form method="post"> <div class=""> <fieldset> <div class="form-group"> <label>SPBU No.</label> <input type="text" class="form-control" id="no_spbu" name="no_spbu" placeholder="Type SPBU No…" value=""> </div> <div class="form-group"> <label>SPBU Type</label> <select class="form-control" id="jenis_spbu" name="jenis_spbu"> <option value="">Pilih Tipe SPBU</option> <option value="DODO">DODO</option> <option value="Kompak">Kompak</option> <option value="Modular">Modular</option> <option value="Mini">Mini</option> <option value="SPBUN">SPBUN</option> </select> </div> <div class="form-group"> <label>Region</label> <select class="form-control" id="mor" name="mor"> <option value="">Pilih Region</option> <option value="I">Region 1</option> <option value="II">Region 2</option> <option value="III">Region 3</option> <option value="IV">Region 4</option> <option value="V">Region 5</option> <option value="VI">Region 6</option> <option value="VII">Region 7</option> <option value="VIII">Region 8</option> <option value="NO">No region</option> </select> </div> <div class="form-group"> <label>Province</label> <select class="form-control" id="prov" name="prov"> <option value="">Pilih Propinsi</option> <option value="Sumatera Utara">Sumatera Utara</option> <option value="Sumatera Barat">Sumatera Barat</option> <option value="Riau">Riau</option> <option value="Kepulauan Riau">Kepulauan Riau</option> <option value="Aceh">Aceh</option> <option value="Sumatera Selatan">Sumatera Selatan</option> <option value="Lampung">Lampung</option> <option value="Jambi">Jambi</option> <option value="Bangka-Belitung">Bangka-Belitung</option> <option value="Bengkulu">Bengkulu</option> <option value="DKI Jakarta">DKI Jakarta</option> <option value="Jawa Barat">Jawa Barat</option> <option value="Banten">Banten</option> <option value="Jawa Tengah">Jawa Tengah</option> <option value="D.I Yogyakarta">D.I Yogyakarta</option> <option value="NTT">NTT</option> <option value="NTB">NTB</option> <option value="Jawa Timur">Jawa Timur</option> <option value="Bali">Bali</option> <option value="Kalimantan Utara">Kalimantan Utara</option> <option value="Kalimantan Tengah">Kalimantan Tengah</option> <option value="Kalimantan Timur">Kalimantan Timur</option> <option value="Kalimantan Barat">Kalimantan Barat</option> <option value="Kalimantan Selatan">Kalimantan Selatan</option> <option value="Sulawesi Tenggara">Sulawesi Tenggara</option> <option value="Sulawesi Tengah">Sulawesi Tengah</option> <option value="Sulawesi Barat">Sulawesi Barat</option> <option value="Sulawesi Utara">Sulawesi Utara</option> <option value="Sulawesi Selatan">Sulawesi Selatan</option> <option value="Gorontalo">Gorontalo</option> <option value="Papua">Papua</option> <option value="Papua Barat">Papua Barat</option> <option value="Maluku">Maluku</option> <option value="Maluku Utara">Maluku Utara</option> <option value="Teluk Cendrawasih">Teluk Cendrawasih</option> </select> </div> <div class="form-group"> <label>District</label> <input type="text" class="form-control" id="kab" name="kab" placeholder="Type district name…" value=""> </div> <div class="form-group"> <label>Sub District</label> <input type="text" class="form-control" id="kec" name="kec" placeholder="Type sub-district name…" value=""> </div> <div class="form-group"> <label>Address</label> <textarea class="form-control" id="alamat" name="alamat" placeholder="Type location address…"></textarea> </div> <div class="form-group"> <label>Keeper Name</label> <input type="text" class="form-control" id="pengusaha" name="pengusaha" placeholder="Type keeper name…" value=""> </div> <div class="group"> <label for="">Tahap</label> <select class="form-control" id="tahap" name="tahap"> <option value="">Pilih Tahap</option> <option value="1">Pembangunan</option> <option value="2">Paralel Pembangunan</option> <option value="3">Perizinan PEMDA</option> <option value="4">Finalisasi</option> <option value="5">Operasi</option> </select> </div> </fieldset> <fieldset> <div class="form-group"> <label>Latitude</label> <input type="text" class="form-control" id="lat" name="lat" value=""> </div> <div class="form-group"> <label>Longitude</label> <input type="text" class="form-control" id="lng" name="lng" value=""> </div> </fieldset> <fieldset> <legend>Location Profile</legend> <div class="form-group"> <label for="">Operational Date</label> <div class="DayPickerInput"> <input class="form-control" placeholder="YYYY-MM-DD" value="" id="tgl_operasional" name="tgl_operasional"> </div> </div> <div class="form-group"> <label for="">Location Image</label> <input class="form-control" type="file" id="image_spbu" name="image_spbu"> </div> </fieldset> </div> </div>');
            $(".modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="button" id="insert_detail" class="btn btn-primary">Save changes</button> </div> </form>');
        });
        $("#myModal").on('show.bs.modal', function(data){

            console.log(no_spbu_s);

            $.ajax({

                type: "POST",

                url: "<?php echo base_url('Maps/get_location_id') ?>",

                data: {"id_info":mark, "no_spbu":no_spbu_s},

                dataType: "json",

                success: function(data) {

                    console.log(no_spbu_s);

                    var htmls = "";

                    $.each(data.bobot_progress_name, function(index, bobot_progress) {

                        htmls += '<div class="form-check" id="'+bobot_progress.id+'"> <input class="parent-check progress-check form-check-input" type="checkbox" value="" id="'+bobot_progress.id+'" > <label class="form-check-label" for="defaultCheck1"> '+bobot_progress.progress_name+' </label> </div>'; 

                        $.each(data.bobots, function(index, bobot) {

                            if(bobot_progress.progress_name == bobot.progress_name && bobot.sub_progress_name != null){

                                htmls += '<div style="margin-left: 20px" class="form-check"> <input class="progress-check form-check-input" type="checkbox" value="" id="'+bobot.id+'"> <label class="form-check-label" for="defaultCheck1"> '+bobot.sub_progress_name +' </label> </div>';

                            }

                        });

                    });

                    var template = $('#detail_location').html();

                    var html = Mustache.to_html(template, data);

                    $('#bobot_progress').html(htmls);

                    $('.modal-body').html(html);



                    let params = {no_spbu: no_spbu_s};

                    let result = loadProgressWithParam(loadProgressUrl, jQuery.param(params));

                    result.then(response => {



                        $('.parent-check.progress-check').each((i, el_chk) => {

                            response.progress_name_once.forEach((progress, i) => {

                                if(el_chk.id == progress.id) {

                                    $(el_chk).parent().css({

                                        marginLeft: "-20px"

                                    });

                                    $(el_chk).remove();

                                }

                            });

                        });



                        response.data.forEach((el, index) => {      



                            $('.progress-check').each(function() {



                                // check id_bobot_spbu dari server == id checkbox

                                if(el.id_bobot_spbu == this.id) {

                                    $(this).prop('checked', true);

                                }

                            });

                        });





                        let percentage = response.total_progress;

                        $('#total_progress').text(percentage + '%');

                        console.log(response);



                    });



                    $('.progress-check').on('click', function(event) {

                        //

                    let idBobot = $(this).attr('id'); // get id on click event

                    let response;

                    if(!this.checked) { // if kondisi not unchecked

                        let params = {id: idBobot,no_spbu: no_spbu_s, state: 'unchecked'};

                        response = updateProgress(url, jQuery.param(params));

                    } else {

                        let params = {id: idBobot,no_spbu: no_spbu_s, state: 'checked'};

                        response = updateProgress(url, jQuery.param(params));

                    }



                    response.then(response => {

                        let percentage = response.total_progress * 100;

                        $('#total_progress').text(percentage + '%');

                        console.log(response);

                    });



                });

                    // var html = "";

                    // var template = $('#detail_location').html();

                    // var html = Mustache.to_html(template, data);

                    // $(".modal-body").html(html);

                    // html += '<div style="height:200px;overflow-y: scroll;">';

                    // html += '<p id="total_progress">'+data.total_progress+'%</p>';

                    // $.each(data.data_bobot, function(index, val) {

                        // html += '<button style="background:#00A8FF;color:white;" onclick="myFunction(Demo2)" class="w3-button w3-block w3-left-align"> '+val.progress_name+'</button><div id="Demo2" style="border:solid 1px black;" class="w3-container"> <p>'+parseFloat(val.last_progress)+'%</p> </div>';



                    // });

                    // html += '</div>';

                    // html += '    <br><button class="btn btn-primary" style="float:right;" id="update_detail" data-id="'+data.id+'">Update Detail</button><button class="btn btn-primary" style="float:right;display:none;" id="save_detail" data-id="'+data.id+'">Save Detail</button><br><br><img width="300" src="<?php echo base_url('assets/img/img_spbu/'); ?>'+data.image_spbu+'"><div id="img_spbu"></div><br><br><div style="height:500px;overflow-y: scroll;"><table width="100%" border="1"> <tbody> <tr> <td width="25%">Last Update</td> <td class="MarkerModal__onlyDesktop--1N9vw">'+data.modified_at+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Pengusaha</td> <td id="pengusaha"> <h5 class="MarkerModal__onlyMobile--22ncp"></h5>'+data.pengusaha+' </td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">No. Lembaga</td> <td id="no_spbu">'+data.no_spbu+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Alamat</td> <td id="alamat">'+data.alamat+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Tipe</td> <td id="jenis_spbu">'+data.jenis_spbu+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Tahap</td> <td> <h5 class="MarkerModal__onlyMobile--22ncp">Tahap</h5>Operasi</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Rencana Beroperasi</td> <td id="tahun_operasi">'+data.tahun_operasi+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Region</td> <td id="region">'+data.mor+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Propinsi</td> <td id="provinsi">'+data.prov+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Kabupaten</td> <td id="kabupaten">'+data.kab+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Kecamatan</td> <td id="kecamatan">'+data.kec+'</td> </tr> <tr> <th colspan="2">Location Details</th> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Latitude</td> <td id="latitude">'+data.lat+'</td> </tr> <tr> <td class="MarkerModal__onlyDesktop--1N9vw">Longitude</td> <td id="longitude">'+data.lng+'</td> </tr> </tbody> </table></div><br><br><br>';

                    // html += '<div class="row" style="margin-bottom: 1em;"> <div class="col-md-1"> <p style="padding-top: 8px">Tanggal</p> </div> <div class="col-md-3"> <div class="input-group" data-autoclose="true"> <input type="text" name="start_date" class="form-control date"value="<?php echo date("Y/m/d"); ?>"/> <span class="input-group-addon"> <span class="font-icon font-icon-calend"></span> </span> </div> </div> <div class="col-md-1"> <p style="padding-top: 8px">Sampai</p> </div> <div class="col-md-3"> <div class="input-group" data-autoclose="true"> <input type="text" name="end_date" id="end_date" class="form-control date"value="<?php echo date("Y/m/d"); ?>"/> <span class="input-group-addon"> <span class="font-icon font-icon-calend"></span> </span> </div> </div><div class="col-md-1 exp-button"></div> </div><br>';



                    // html += '<table id="mapsTable" class="table table-bordered table-hover" style="width:100%;"> <thead> <tr> <th>No.</th> <th>No.SPBU</th> <th>Pilihan BBM</th> <th>Stok Awal</th> <th>Penerimaan BBM</th> <th>Penjualan</th> <th>Stok Akhir</th> <!--<th>Loses</th>--> <th>Dot</th><th>Cd</th><th>Tanggal</th> </thead> <tbody> <tr><td>12345</td><td>12345</td><td>12345</td><td>12345</td><td>12345</td><td>12345</td><td>12345</td></tr> </tbody> </table>';

                    function filter_datatable_satuharga() {

                        console.log("test");

                    }

                    $("#end_date").change(function() {

                        console.log("test");

                    });

                    

                    // $(".modal-body").html(html);

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

                     "sEmptyTable":     "No data available in table"

                 },

                 "ajax": {

                            // "url": base_url+"konsumen/transaksi",

                            "url": "<?php echo base_url('Maps/get_data') ?>",

                            "type": "POST",

                            "data" : {"id_info": mark, "no_spbu":no_spbu_s}

                        }

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

                    if($.fn.dataTable.isDataTable('#mapsTable')){

                      $('#mapsTable').DataTable().clear();

                      $('#mapsTable').DataTable().destroy();

                    }

                    $("#mapsTable").DataTable({

                            "processing": true,

                            "serverSide": false,

                            "order": [[0, 'asc']], 

                            "oLanguage": {

                             "sSearch": "Pencarian",

                             "sEmptyTable":     "No data available in table"

                             

                         },

                         "ajax": {

                            "url": "<?php echo base_url('Maps/get_data') ?>",

                            "type": "POST",

                            "data" : {"id_info": mark, "no_spbu":no_spbu_s, "date_start":start.format('YYYY-MM-DD') , "date_end": $("input[name='end_date']").val()}

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
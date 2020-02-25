<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 dahsboard-column">
                <section class="box-typical box-typical-dashboard panel x-ua-compatible scrollable">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">Report Data Pembelian
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
                                        <input type="text" name="beli_start_date" class="form-control date"
                                               value=""/>
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
                                        <input type="text" name="beli_end_date" class="form-control date"
                                               value=""/>
                                        <span class="input-group-addon">
												<span class="font-icon font-icon-calend"></span>
											</span>
                                    </div>
                                </div>
                            </div> <!-- row mb -->
                            <!-- filter by pilihan bbm, kab / kota, dan provinsi -->
                            <div class="row" style="margin-bottom: 4em;">
                                <div class="col-md-3">
                                    <select id="no_spbu" class="select2">
                                        <option value="0">Cari No SPBU</option>
                                            <?php
                                            foreach ($this->db->distinct()->select('no_spbu')->get_where('kg_beli_pribadi', array('app'=>'satuharga'))->result() as $key => $value) {
                                                 echo "<option value='".$value->no_spbu."'>".$value->no_spbu."</option>";
                                             } 
                                            ?>
                                    </select>
                                </div> 
                                <div class="col-md-3">
                                    <!--                                    <label class="form-label semibold" for="exampleInput">Nama Petugas</label>-->
                                    <select id="no_pol" class="select2">
                                        <option value="0">Cari No Kendaraan</option>
                                        <?php
                                        foreach ($this->db->distinct()->select('no_pol')->get_where('kg_beli_pribadi', array('app'=>'satuharga'))->result() as $key => $value) {
                                             echo "<option value='".$value->no_pol."'>".$value->no_pol."</option>";
                                         } 
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1 exp-button">
                                    <a id="filter_datatable_satuharga" class="btn btn-primary">Search</a>
                                </div>
                                <div class="col-md-1 exp-button">
                                    <a href="<?php echo site_url() ?>home/excel" class="btn btn-success">Export</a>
                                </div>
                            </div> <!-- row mb -->
                            <span id="found" class="label label-info"></span>
                            <table id="mytable" class="table table-bordered table-hover" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>No. SPBU</th>
                                    <th>No. Polisi</th>
                                    <th>No. Hp</th>
                                    <th>Pembelian</th>
                                    <!--<th>Loses</th>-->
                                    <th>Tanggal</th>
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
        
    	/**
    	 * Create format date YYYY-MM-DD from Date.now()
    	 * @param  {[type]} date [description]
    	 * @return {[type]}      [description]
    	 */
    	function formatDateCalendar(date) {
    	    var d = new Date(date),
    	        month = '' + (d.getMonth() + 1),
    	        day = '' + d.getDate(),
    	        year = d.getFullYear();
    
    	    if (month.length < 2) 
    	        month = '0' + month;
    	    if (day.length < 2) 
    	        day = '0' + day;
    
    	    return [year, month, day].join('-');
    	}        

    	/**
    	 * DATERANGE PICKER : 
    	 * 1. TGL START
    	 */
    	
    	var beliStartDate = formatDateCalendar(Date.now()); 
    	var beliStartDateCalendar = $('input[name="beli_start_date"]');
    	beliStartDateCalendar.daterangepicker({
    		singleDatePicker: true,
    		showDropdowns: true,
    		locale: {
    			format: 'DD/MM/YYYY'
    		}
    	}, function(start, end, label) {
    		beliStartDate = end.format('YYYY-MM-DD');
    		console.log(beliStartDate);
    	});
    
    	/**
    	 * 2. TGL END
    	 */
    	var beliEndDate = "";
    	var beliEndDateCalendar = $('input[name="beli_end_date"]');
    	beliEndDateCalendar.daterangepicker({
    		singleDatePicker: true,
    		showDropdowns: true,
    		locale: {
    			format: 'DD/MM/YYYY'
    		}
    	}, function(start, end, label) {
    		beliEndDate = end.format('YYYY-MM-DD');
    		console.log(beliEndDate);
    	});
    	
    	$('#filter_datatable_satuharga').on('click', function() {
    	    console.log(beliStartDate + ' , ' + beliEndDate);
    	});

    });
</script>

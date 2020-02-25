<div class="container">
	<div class="row">
		<div style="margin-top: 20px" class="col-md-4">
			<p id="total_progress"><?php echo $total_progress; ?>%</p>
			<?php
			foreach($bobot_progress_name as $progress): ?>
				<div class="form-check" id="<?php echo $progress['id']; ?>">
				  <input class="parent-check progress-check form-check-input" type="checkbox" value="" id="<?php echo $progress['id']; ?>" >
				  <label class="form-check-label" for="defaultCheck1">
				    <?php echo $progress['progress_name']; ?> 
				  </label>
				</div>

				<?php foreach($bobots as $bobot): ?>
					<?php if($progress['progress_name'] == $bobot['progress_name'] && $bobot['sub_progress_name'] != NULL): ?>
						<div style="margin-left: 20px" class="form-check">
						  <input class="progress-check form-check-input" type="checkbox" value="" id="<?php echo $bobot['id']; ?>">
						  <label class="form-check-label" for="defaultCheck1">
						    <?php echo $bobot['sub_progress_name']; ?> 
						  </label>
						</div>	
					<?php endif; ?>
				<?php endforeach; ?>

			<?php endforeach; ?>

		</div>
	</div>
</div>


<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
 <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script type="text/javascript">

	let url = '<?php echo site_url('bobot/') ?>update_progress'; // insert
	let loadProgressUrl = '<?php echo site_url('bobot/') ?>load_progress'; // insert

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

	$(window).on('load', function(){


		let result = loadProgress(loadProgressUrl);
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


			let percentage = response.total_progress * 100;
			$('#total_progress').text(percentage + '%');
			console.log(response);

		});


	});

	$('.progress-check').on('click', function(event) {

		let idBobot = $(this).attr('id'); // get id on click event
		let response;
		if(!this.checked) { // if kondisi not unchecked
			let params = {id: idBobot, state: 'unchecked'};
			response = updateProgress(url, jQuery.param(params));
		} else {
			let params = {id: idBobot, state: 'checked'};
			response = updateProgress(url, jQuery.param(params));
		}

		response.then(response => {
			let percentage = response.total_progress * 100;
			$('#total_progress').text(percentage + '%');
			console.log(response);
		});

	});


</script>
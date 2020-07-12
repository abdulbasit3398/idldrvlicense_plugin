<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://tahir.codes/
 * @since      1.0.0
 *
 * @package    Idldrvlicense
 * @subpackage Idldrvlicense/public/partials
 */
?>
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css' type='text/css' media='all' />
<style type="text/css">
	.et_pb_section_1.et_pb_section{
		padding-top: 280px !important;
	}
</style>
<form id="msform">
		<input type="hidden" name="dataid" id="dataid" value="<?php echo $id;?>">
		<!-- progressbar -->
		<ul id="progressbar">
			<li class="active">UW GEGEVENS</li>
			<li>UW AFSPRAAK</li>
			<li>OVERZICHT</li>
		</ul>
		<!-- fieldsets -->

		<div class="body-panel">

			<div class="form-header">
				<div class="form-header-heading">
					<h5 class="bold">Je rijbewijs aanvragen</h5>
					<p>Direct online een afspraak maken bij uw gemeente.</p>
				</div>
				<span>Veilige verbinding <img src="<?php echo $images?>/lock.png" alt="image"></span>
			</div>

			<div class="form-body">

				<h4 class="bold">Uw gegevens</h4>

				<div class="form-fields row">

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo FIRSTNAME;?></label>
							<input type="text" name="first_name" id="first_name" class="jchange" value="<?php echo $license->first_name?>" />
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo LASTNAME;?></label>
							<input type="text" name="last_name" id="last_name" class="jchange" value="<?php echo $license->last_name?>" />
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo EMAIL;?></label>
							<input type="text" name="email" id="email" class="jchange" value="<?php echo $license->email?>"/>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo PHONENUMBER;?></label>
							<input type="text" name="phone_number" id="phone_number" class="jchange" value="<?php echo $license->phone_number?>"/>
						</div>
					</div>

				</div>

			</div>			
			<button type="button" name="next" class="next arrow-next action-button">Volgende</button>
		</div>

		<div class="body-panel">
			<div class="form-header">
				<div class="form-header-heading">
					<h5 class="bold">Je rijbewijs aanvragen</h5>
					<p>Direct online een afspraak maken bij uw gemeente.</p>
				</div>
				<span>Veilige verbinding <img src="<?php echo $images?>/lock.png" alt="image"></span>
			</div>
			<div class="form-body">
				<h4 class="bold">Uw afspraak</h4>
				<div class="form-fields row">

					<div class="col-md-3">
						<div class="form-group">
							<div style="display: inline-block;">
								<label><?php echo POSTCODE;?></label>
								<input type="text" name="postcode" id="postcode" class="jchange" value="<?php echo $license->postcode?>"/>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<div style="display: inline-block; float: right;">
								<label><?php echo HOUSENUMBER;?></label>
								<input type="text" name="house_number" id="house_number" class="jchange" value="<?php echo $license->house_number?>"/>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo DOB;?></label>
							<input type="text" name="dob" id="dob" class="jchange" value="<?php echo ($license->dob)? date('d/m/Y',$license->dob):'' ?>" />
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo PREFERREDDATE;?></label>
							<div class="form-icon">
								<select name="preferred_day[]" id="preferred_day" class="jchange js-example-basic-multiple" multiple required>
									<?php foreach($this->preferred_day as $val=>$pday): ?>
										<option value="<?php echo $pday?>" <?php echo ($pday == 'Maandag') ? 'selected': ''?>><?php echo $pday?></option>
									<?php endforeach; ?>
								</select>
								<span class="selecticon"><img src="<?php echo $images?>/form-arrow.png" alt=""></span>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo PREFERREDTIME;?></label>
							<div class="form-icon">

								<select name="preferred_time[]" id="preferred_time" class="jchange"  multiple>
									<?php foreach($this->preferred_time as $val=>$pday): ?>
										<option value="<?php echo $pday?>" <?php echo ($pday == '9-10'/* $license->preferred_time*/) ? 'selected': ''?>><?php echo $pday?></option>
									<?php endforeach; ?>
								</select>
								<span class="selecticon"><img src="<?php echo $images?>/form-arrow.png" alt=""></span>
							</div>
						</div>
					</div>

				</div>

			</div>
			
			<button type="button" name="previous" class="previous arrow-previous action-button">Vorige</button>
			<button type="button" name="next" class="next arrow-next action-button" value="arrow-next" >Volgende</button>
		</div>

		<div class="body-panel">

			<div class="form-header">
				<div class="form-header-heading">
					<h5 class="bold">Je rijbewijs aanvragen</h5>
					<p>Direct online een afspraak maken bij uw gemeente.</p>
				</div>
				<span>Veilige verbinding <img src="<?php echo $images?>/lock.png" alt="image"></span>
			</div>

			<div class="form-body">
				<?php if( "true" == $_GET['idllast'] ){ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  Uw betaling is mislukt, probeer het nog eens.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<?php } ?>
				<h4 class="bold">Overzicht</h4>

				<div class="form-fields row">

					<div class="col">
						<div class="form-field-text">
							<div class="text-field-box">
								<p><?php echo FIRSTNAME;?></p>
								<h4 id="d_first_name"></h4>
							</div>
							<div class="text-field-box">
								<p><?php echo LASTNAME;?></p>
								<h4 id="d_last_name"></h4>
							</div>
							<div class="text-field-box">
								<p><?php echo EMAIL?></p>
								<h4 id="d_email"></h4>
							</div>
							<div class="text-field-box">
								<p><?php echo PHONENUMBER;?></p>
								<h4 id="d_phone_number"></h4>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="form-field-text">
							<div class="text-field-box">
								<p><?php echo POSTCODE?></p>
								<h4 id="d_postcode"></h4>
							</div>
							<div class="text-field-box">
								<p><?php echo DOB?></p>
								<h4 id="d_dob"></h4>
							</div>
							<div class="text-field-box">
								<p><?php echo PREFERREDDATE?></p>
								<h4 id="d_preferred_day"></h4>
							</div>
							<div class="text-field-box">
								<p><?php echo PREFERREDTIME?></p>
								<h4 id="d_preferred_time"></h4>
							</div>
						</div>
					</div>

				</div>

				<div class="check-box2">
					<input type="checkbox" id="agreeterms" name="agreeterms" value="value1">
					<label for="agreeterms">
						Ik ga akkoord met de
						<?php 
						if (get_option('algemene_voorwaarden_link')) {
							$algemene_voorwaarden_link = get_option('algemene_voorwaarden_link');
						}
						else{
							$algemene_voorwaarden_link = "#";
						}

						if (get_option('privacy_policy_link')) {
							$privacy_policy_link = get_option('privacy_policy_link');
						}
						else{
							$privacy_policy_link = "#";
						}

						?>
						<a href="<?php echo $algemene_voorwaarden_link; ?>" target="_blank">algemene voorwaarden </a>& de
						<a href="<?php echo $privacy_policy_link; ?>" target="_blank">privacy policy</a>
						en geef jullie toestemming om mijn persoonsgegevens te verwerken ten behoeve van het maken van een afspraak bij uw plaatselijke gemeente.
					</label>
				</div>

			</div>
			
			<button type="button" name="previous" class="previous arrow-previous action-button">Vorige</button>
			<button type="button" name="acceptit" class="submit idlsubmit action-button">Afspraak bevestigen</button>
			<p class="price">Kosten bedragen €9,95.</p>
		</div>

	</form>

<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'></script>
<!--
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/spectrum.js"></script>
<script type="text/javascript" src="/js/jscharts.js"></script>
-->
<?php
/**
 * @var MY_Loader $this
 */
$this->manager_js->runAll();
$this->manager_css->runAll();
?>

<?php
//include_once '/home/dev41/www/ShoutburstCopy/shoutburst/js/reports/update.php';
//<script src="/js/reports/update.js"></script>
?>

<?php echo form_open_multipart('reports/', array('name'=>'add_report', 'id'=>'add_report', 'onsubmit'=>"return check_it(this)")) ?>
<?php echo $this->session->flashdata('message');?>

<div id="content">
	<div class="container">
		<div id="report_content" class="cf">

			<!-- Step 1 -->
			<div id="step_1">
				<div class="row content-header">
					<?php echo heading('Update Report', 1); ?>
				</div>
				<!-- .row -->

				<div class="row content-body">
					<div class="col-sm-6">
						<div class="form-horizontal sb-form">
							<div class="form-group">
								<label class="col-sm-6 control-label" for="report_name">Report Name</label>

								<div class="col-sm-6">
									<input type="text" value="<?php echo _ran_rinnk($reportData, 'report_name'); ?>"
										   name="report_name" id="report_name" class="sb-control"
										   placeholder="Report name" autofocus>

									<div id='reportNameErr'></div>
								</div>

							</div>
							<div class="form-group">
								<label class="col-sm-6 control-label" for="report_type">Report Type:</label>

								<div class="col-sm-6">
									<select id="report_type" class="sb-control" name="report_type">
										<?php foreach ($report_types as $rt) {

											$selected = "";
											if (isset($reportData['report_type']) && $reportData['report_type'] == strtolower($rt->type_name)) {
												$selected = "selected='selected'";
											}
											?>
											<option
												value="<?php echo strtolower($rt->type_name) ?>" <?php echo $selected; ?>><?php echo $rt->type_name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group" id='reportPeriodRegion'>
								<label class="col-sm-6 control-label" for="report_period">Report Period:</label>

								<div class="col-sm-6">

									<select id="report_period" class="sb-control" name="report_period"
											onChange='reportPeriodOptionCheck();'>
										<?php foreach ($report_periods as $rp) {
											$selected = "";
											if (isset($reportData['report_period']) && $reportData['report_period'] == strtolower($rp->rep_prd_name)) {
												$selected = "selected='selected'";
											}
											?>
											<option
												value="<?php echo strtolower($rp->rep_prd_name) ?>" <?php echo $selected; ?>><?php echo $rp->rep_prd_name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="customDateRegion" style='display:none;'>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="datepicker">Start Date:</label>

									<div class="col-sm-6 sb-date-picker">
										<input type="text" name='start_date' id="datepicker"
											   class='datePicker sb-control'
											   value="<?php if (isset($reportData['custom_start_date'])) {
												   echo $reportData['custom_start_date'];
											   } ?>">

										<div id='start_dateErr' style='color:red;diplay:none;'></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="datepicker2">End Date</label>

									<div class="col-sm-6 sb-date-picker">
										<input type="text" name='end_date' id="datepicker2"
											   class='datePicker sb-control'
											   value="<?php if (isset($reportData['custom_end_date'])) {
												   echo $reportData['custom_end_date'];
											   } ?>">

										<div id='end_dateErr' style='color:red;diplay:none;'></div>
									</div>
								</div>
								<div id='customDateErr' style='display:none;'></div>
							</div>
							<div class="form-group customDayRegion" style='display:none;'>
								<label class="col-sm-6 control-label" for="custom_date">Select Date:</label>

								<div class="col-sm-6 sb-date-picker">
									<input type="text" name='custom_date' id="custom_date" class='sb-control datePicker'
										   value="<?php if (isset($reportData['report_period_date'])) {
											   echo $reportData['report_period_date'];
										   } ?>">

									<div id='customDayErr' style='display:none;'></div>
								</div>
							</div>
							<div class="form-group" id='reportInetrvalRegion'>
								<label class="col-sm-6 control-label" for="report_interval">Intervals:</label>

								<div class="col-sm-6">
									<select id="report_interval" class="sb-control" name="report_interval">
										<?php foreach ($report_intervals as $ri) {
											$selected = "";
											if (isset($reportData['report_interval']) && $reportData['report_interval'] == strtolower($ri->rep_interval_name)) {
												$selected = "selected='selected'";
											}
											?>
											<option
												value="<?php echo strtolower($ri->rep_interval_name) ?>" <?php echo $selected; ?> ><?php echo $ri->rep_interval_name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group" id="output_requirements_div">
								<label class="col-sm-6 control-label" for="op_req">Output Requirements:</label>

								<div class="col-sm-6">
									<select name="op_req" class="sb-control" id="op_req"
											onChange='outputRequirementCheck();'>
										<option
											value="data"  <?php if (isset($reportData['op_req']) && $reportData['op_req'] == 'data') {
											echo "selected='selected'";
										} ?> >On Screen
										</option>
										<option
											value="email" <?php if (isset($reportData['op_req']) && $reportData['op_req'] == 'email') {
											echo "selected='selected'";
										} ?>>Email
										</option>
										<option
											value="ftp"   <?php if (isset($reportData['op_req']) && $reportData['op_req'] == 'ftp') {
											echo "selected='selected'";
										} ?>>FTP
										</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="email_tr" style="display:none;">
								<label class="col-sm-6 control-label" for=""></label>

								<div class="col-sm-6">
									<textarea name="email_address" rows="3" cols="10" class="sb-textarea"
											  placeholder="Add email addresses [comma separated] ..."><?php if (isset($reportData['email_address'])) {
											echo $reportData['email_address'];
										} ?></textarea>
								</div>
							</div>
							<!-- #email_tr -->

							<div id="ftp_tr" style="display:none;">
								<div class="form-group">
									<label class="col-sm-6 control-label" for="ftp_host_name">Host:</label>

									<div class="col-sm-6">
										<input type="text" class="sb-control" name="ftp_host_name" id="ftp_host_name"
											   placeholder="Host"
											   value="<?php if (isset($reportData['ftp_host_name'])) {
												   echo $reportData['ftp_host_name'];
											   } ?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="ftp_port">Port:</label>

									<div class="col-sm-6">
										<input type="text" class="sb-control" name="ftp_port" id="ftp_port"
											   placeholder="Port" value="<?php if (isset($reportData['ftp_port'])) {
											echo $reportData['ftp_port'];
										} ?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="ftp_user_name">Username:</label>

									<div class="col-sm-6">
										<input type="text" class="sb-control" name="ftp_user_name" id="ftp_user_name"
											   placeholder="Username"
											   value="<?php if (isset($reportData['ftp_user_name'])) {
												   echo $reportData['ftp_user_name'];
											   } ?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="ftp_password">Password:</label>

									<div class="col-sm-6">
										<input type="text" class="sb-control" name="ftp_password" id="ftp_password"
											   placeholder="Password"
											   value="<?php if (isset($reportData['ftp_password'])) {
												   echo $reportData['ftp_password'];
											   } ?>"/>
									</div>
								</div>
							</div>
							<!-- #ftp_tr -->
							<?php
							$displayProp = "";
							if ($reportData['report_type'] == 'data') {
								$displayProp = "style='display:none;'";
							}
							?>
							<!--  	<div class="form-group" id="assigned" <?php echo $displayProp; ?> > -->
							<div class="form-group" id="assigned">
								<label class="col-sm-6 control-label" for="">Assigned?</label>

								<div class="col-sm-6"  <?php echo $displayProp; ?>>
									<input type="checkbox" id="dashboard"
										   name="dashboard" <?php if (isset($reportData['dashboard']) && $reportData['dashboard'] == 1) {
										echo 'checked';
									} ?>> <label for="dashboard"><span></span>Dashboard</label>
									<br></div>
								<div class="col-sm-6">
									<input type="checkbox" id="wallboard"
										   name="wallboard" <?php if (isset($reportData['wallboard']) && $reportData['wallboard'] == 1) {
										echo 'checked';
									} ?>> <label for="wallboard"><span></span>Wallboard</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-6 control-label" for="">Privacy:</label>

								<div class="col-sm-6">
									<input type="radio" id="private" name="privacy"
										   value="private" <?php if (isset($reportData['privacy']) && $reportData['privacy'] == 'private') {
										echo 'checked="checked"';
									} ?>>
									<label for="private"><span></span>Private</label>
									<br>
									<input type="radio" id="global" name="privacy"
										   value="global" <?php if (isset($reportData['privacy']) && $reportData['privacy'] == 'global') {
										echo 'checked="checked"';
									} ?>>
									<label for="global"><span></span>Global</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-6 control-label" for=""></label>

								<div class="col-xs-6">
									<input type="hidden" name="op_req_flag" id="op_req_flag" value="data"/>
									<input type="button" class="btn btn-primary-green" value="Next" name="btn_step_2"
										   id="btn_step_2" onclick="next_step(2,1); setXAxisLabel(); "/>
								</div>
							</div>
						</div>
						<!-- .form-horizontal .sb-form -->
					</div>
					<!-- .col-sm-12 -->
				</div>
				<!-- .content-body -->
			</div>
			<!--// Step 1 -->

			<!-- Step 2 -->
			<div id="step_2" style="display:none;">
				<div class="row content-header">
					<?php echo heading('Data Control', 1); ?>
				</div>
				<!-- .row -->

				<div class="row content-body">
					<div class="col-sm-12">
						<div class="row dragdrop-wrap data-control">
							<div class="col-sm-6">
								<h3 class="hidden-xs">Drag from here</h3>
								<span>Reference</span>
								<ul id="sort1" class="dragdrop ddsmall">

									<?php
									if (!empty($dataControlColumn)) {
										foreach ($general as $refField) {
											if (in_array($refField, $dataControlColumn)) {
												?>
												<li class="general"><?php echo $refField; ?></li>
											<?php
											}
										}
									}
									?>
								</ul>

								<span>Numerical</span>
								<ul id="sort1" class="dragdrop ddsmall">

									<?php
									if (!empty($dataControlColumn)) {
										foreach ($score as $refField) {
											if (in_array($refField, $dataControlColumn)) {
												?>
												<li class="score"><?php echo $refField; ?></li>
											<?php
											}
										}
										?>
										<li class="score">NPS</li>
										<!--  <li class="score">Adjusted NPS</li> -->

									<?php
									}
									?>
								</ul>

								<span>Detail</span>
								<ul id="sort1" class="dragdrop ddsmall">

									<?php
									if (!empty($dataControlColumn)) {
										foreach ($detail as $refField) {
											if (in_array($refField, $dataControlColumn)) {
												?>
												<li class="detail"><?php echo $refField; ?></li>
											<?php
											}
										}
									}
									?>
								</ul>


							</div>

							<!-- Hidding right arrow on small devices i.e. smart phone -->
							<div class="col-sm-2 hidden" style="text-align: center;"><span
									class="glyphicon glyphicon-arrow-right"
									style="font-size: 60px; margin-top:200px; color:#666;"></span></div>
							<!-- Showing down arrow on small devices -->
							<div class="col-xs-12 visible-xs" style="text-align: center;"><span
									class="glyphicon glyphicon-arrow-down"
									style="font-size: 60px; margin: 20px auto; color:#666;"></span></div>
							<!-- Showing clear and spacing on small devices -->
							<div class="clearfix visible-xs" style="margin-top: 20px;"></div>

							<div class="col-sm-6">
								<h3 class="hidden-xs">Output Fields</h3>
								<ul id="sort2" class="dragdrop makTest">
									<?php
									if (!empty($selectedDataControl) && !empty($selectedDataControl[0])) {
										foreach ($selectedDataControl as $selectedDataControlRow) {
											if (in_array($selectedDataControlRow, $general)) {
												$sel_class = 'general';
											} elseif (in_array($selectedDataControlRow, $score)) {
												$sel_class = 'score';
											} elseif (in_array($selectedDataControlRow, $detail)) {
												$sel_class = 'detail';
											} else {
												$sel_class = '';
											}
											?>
											<li class="<?php echo $sel_class ?>"><?php echo $selectedDataControlRow; ?></li>
										<?php
										}
									}
									?>


								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-horizontal sb-form">
									<div class="form-group">
										<div class="col-xs-6"><input type="button" class="btn btn-primary" value="Back"
																	 name="btn_step_1" id="btn_step_1"
																	 onclick="next_step(1,2);"/></div>
										<div class="col-xs-6">
											<input type="button" class="btn btn-primary-green" value="Next"
												   name="btn_step_3" id="btn_step_3" onclick="save_fields();"/>
										</div>
									</div>
								</div>
								<!-- .form-horizontal .sb-form -->
							</div>
						</div>
						<!-- .row -->

					</div>
					<!-- .col-sm-12 -->
				</div>
				<!-- .content-body -->
			</div>
			<!--// Step 2 -->

			<!-- Step 3 -->
			<div id="step_3" style="display:none;">
				<div class="row content-header">
					<?php echo heading('Filter', 1); ?>
				</div>
				<!-- .row -->

				<div class="row content-body">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-xs-3 col-w-110">
								Condition
							</div>
							<div class="col-xs-3">
								Data Type
							</div>
							<div class="col-xs-3">
								Filter
							</div>
							<div class="col-xs-3">
								Detail
							</div>
						</div>

						<?php
						/**
						 * Set Filter HTML From Previous Save Report
						 * */

						if (isset ($query_data_type) && !empty($query_data_type)) {
							$divCount = 0;
							foreach ($query_data_type as $recordKey => $query_data_typeRow) {

								$divClass = "_extraPersonTemplate ";

								?><?php if ($divCount > 0) {
									?><div class="relative"  id="filter_<?php echo $divCount; ?>" ><?php } ?>
								<div class="<?php echo $divClass; ?>">
									<div class="controls controls-row">
										<div class="form-group row">
											<div class="col-xs-2 col-w-110">
												<?php if ($divCount > 0) {
													?>
													<select class="span2 sb-control" id="condition" name="condition[]">
														<?php
														$conidtionArr = array('AND' => 'And', 'OR' => 'Or');
														if (!empty($conidtionArr)) {
															foreach ($conidtionArr as $key => $conidtionRow) {

																$selected = "";
																if ($query_condition[$divCount] == $key) {
																	$selected = "selected='selected'";
																}
																?>
																<option
																	value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $conidtionRow; ?></option>
															<?php
															}
														}
														?>

													</select>
												<?php } ?>
											</div>

											<div class="col-xs-3">
												<select class="span2 sb-control"
														id="data_type<?= $divCount == 0 ? "" : "_$divCount" ?>"
														name="data_type[]"
														onchange="<?= $divCount == 0 ? "getval(this);" : "callme(this);" ?>">
													<?php
													$dataTypeArr = array(
														'' => 'Select',
														'user_pin' => 'Agent PIN',
														'full_name' => 'Agent Name',
														'dialed_number' => 'Dialled Number',
														'cli' => 'CLI',
														'source' => 'source',
														'q1' => 'Q1 score',
														'q2' => 'Q2 score',
														'q3' => 'Q3 score',
														'q4' => 'Q4 score',
														'q5' => 'Q5 score',
														'total_score' => 'Total Score',
														'average_score' => 'Average Score',
														'recording' => 'Recording',
														'tag_name' => 'Tag',
														'transcription_id' => 'Transcription ID',
														'sentiment_score' => 'Sentiment Score',
													);
													if (!empty($dataTypeArr)) {
														foreach ($dataTypeArr as $key => $dataTypeRow) {
															$selected = "";
															if ($query_data_type[$recordKey] == $key) {
																$selected = "selected='selected'";
															}

															?>
															<option
																value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $dataTypeRow; ?></option>
														<?php
														}
													}
													?>
												</select>
											</div>
											<div class="col-xs-3">
												<select class="span2 sb-control" id="filter" name="filter[]">
													<?php
													$filtereArr = array('' => 'Select',
														'e' => 'Equal',
														'ne' => 'Not Equal',
														'gt' => 'Greater Than',
														'lt' => 'Less Than',
														'b' => 'Between',
														'like' => 'Like'
													);
													if (!empty($filtereArr)) {
														foreach ($filtereArr as $key => $filtereRow) {

															$selected = "";
															if ($query_filter[$recordKey] == $key) {
																$selected = "selected='selected'";
															}

															?>
															<option
																value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $filtereRow; ?>
															</option>
														<?php
														}
													}
													?>
												</select>
											</div>
											<div class="col-xs-3">
												<input class="span3 sb-control" placeholder="Detail" type="text"
													   id="detail" value="<?php echo $query_detail[$recordKey]; ?>"
													   name="detail[]"><span
													id="detailbox<?= $divCount == 0 ? "" : $divCount; ?>" name="tingu">
<?php
// pre-select PINs
//var_dump($query_data_type[$recordKey]);

//var_dump($query_detail[$recordKey]);
if ($query_data_type[$recordKey] == "user_pin") {
	?>
	<select multiple id="detail_pins<?= $divCount == 0 ? "" : $divCount; ?>" style="height:60px;"
			class="span3 sb-control" onchange="updateField(this,<?= $divCount == 0 ? "-1" : $divCount; ?>);">
		<?php
		$pins = explode(",", $query_detail[$recordKey]);
		for ($i = 0; $i < count($pins); $i++) {
			$pins[$i] = trim($pins[$i]);
		}

		foreach ($allpins as $pin) {
			$selstat = "";

			if (in_array($pin, $pins)) {
				$selstat = "selected='selected'";
			}

			?>
			<option value='<?= $pin ?>' <?= $selstat ?>><?= $pin ?></option>
		<?php
		}
		?>
	</select>
<?php
}
?>

													<?php

													// pre-select names

													if ($query_data_type[$recordKey] == "full_name") {
														?>
														<select multiple
																id="detail_fn<?= $divCount == 0 ? "" : $divCount; ?>"
																style="height:60px;" class="span3 sb-control"
																onchange="updateField(this,<?= $divCount == 0 ? "-1" : $divCount; ?>);">
															<?php
															$names = explode(",", $query_detail[$recordKey]);
															for ($i = 0; $i < count($names); $i++) {
																$names[$i] = trim($names[$i]);
															}

															foreach ($allnames as $name) {
																$selstat = "";

																if (in_array($name, $names)) {
																	$selstat = "selected='selected'";
																}

																?>
																<option
																	value='<?= $name ?>' <?= $selstat ?>><?= $name ?></option>
															<?php
															}
															?>
														</select>
													<?php
													}
													?>



													<?php

													// pre-select names

													if ($query_data_type[$recordKey] == "tag_name") {
														?>
														<select multiple id="detail_tag<?=$divCount == 0 ? "" : $divCount;?>" style="height:60px;" class="span3 sb-control" onchange="updateField(this,<?=$divCount == 0 ? "-1" : $divCount;?>);">
															<?php
															$names = explode(",",$query_detail[$recordKey]);
															for ($i=0;$i < count($names);$i++) {
																$names[$i] = trim($names[$i]);
															}
															$json  = json_encode($tags);
															$tags = json_decode($json, true);
															foreach ($tags as $name) {
																$selstat = "";

																if (in_array($name['tag_name'],$names)) {
																	$selstat = "selected='selected'";
																}

																?>
																<option value='<?=$name['tag_name']?>' <?=$selstat?>><?=$name['tag_name']?></option>
															<?php
															}
															?>
														</select>
													<?php
													}
													?>


</span>
											</div>
										</div>
									</div><!-- .controls .controls-row -->
								</div>
								<?php if( $divCount > 0 )
								{?>
									<a href="#" id="<?php echo $divCount; ?>" class="remove_filter report-filter-icon-remove-row"
									   onClick="remove_filter(<?php echo $divCount; ?>)">
										<span class="glyphicon red glyphicon-minus-sign" style="display: inline-block;"></span>
									</a>
								</div><?php }?>
								<!-- .extraPersonTemplate -->

								<?php
								$divCount++;
							}
						}
						?>
						<div id="container"></div>
						<p>
							<a href="#" class="report-filter-icon-add-row" id="addRow">
								<span class="glyphicon glyphicon-plus-sign green" style="display: inline-block;"></span>
							</a>
						</p><br/>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-horizontal sb-form">
									<div class="form-group">
										<div class="col-xs-6"><input type="hidden" id="reports_fields" name="reports_fields">
											<input type="button" class="btn btn-primary" value="Back" name="btn_step_2" id="btn_step_2" onclick="next_step(2,3);">
										</div>
										<div class="col-xs-6">
											<input type="button" class="btn btn-primary-green" value="Next" name="btn_step_4" id="btn_step_4" onclick="next_step(4);">
										</div>
									</div>
								</div><!-- .form-horizontal .sb-form -->
							</div>
						</div><!-- .row -->
					</div><!-- .col-sm-12 -->
				</div><!-- .content-body -->
			</div><!--// Step 3 -->

			<!-- Step 4 -->
			<div id="step_4" style="display:none;">
				<div class="row content-header">
					<?php echo heading('Report Stylesheet', 1);?>
				</div>
				<!-- .row -->

				<div class="row content-body">
					<div class="col-sm-6">
						<div class="form-horizontal sb-form">
							<div class="form-group">
								<label class="col-sm-6 control-label" for="x_axis_label">Background Colour</label>
								<div class="col-sm-6">
									<input type="text" value="<?php
									if(!empty($reportData['background_color']))
									{
										echo $reportData['background_color'];
									}
									else
									{
										echo '#ffffff';
									}?>" name="background_color" id="background_color" class="custom-color-picker" placeholder="Background Colour" />
								</div>
							</div>
						</div>
						<div class="form-horizontal sb-form" id="x_axis_label_div">
							<div class="form-group">
								<label class="col-sm-6 control-label" for="x_axis_label">X Axis Label</label>
								<div class="col-sm-6">
									<input type="text" value="" name="x_axis_label" id="x_axis_label" class="sb-control" readonly placeholder="X Axis Label" />
									<!--  <span>Note: Must be one column from <i>(Day,Agent)</i></span>-->
								</div>
							</div>
						</div>
						<div class="form-horizontal sb-form" id="y_axis_label_div">
							<div class="form-group">
								<label class="col-sm-6 control-label" for="y_axis_label">Y Axis Label</label>
								<div class="col-sm-6">
									<select name="y_axis_label" id="y_axis_label" class="sb-control">
										<?php
										if(!empty($yAxisColoumnList)){
											foreach($yAxisColoumnList as $coloumnName=>$yAxisColoumnRow){

												$selected	=	"";
												if($reportData['y_axis_label']==$coloumnName){
													$selected	=	"selected='selected'";
												}
												?>
												<option value="<?php echo $coloumnName;?>" <?php echo $selected;?>><?php echo $yAxisColoumnRow;?></option>
											<?php
											}
										}
										?>
									</select>
									<!-- <span>Note: Must be one column from <i>(Total Score)</i></span>-->
								</div>
							</div>
						</div>
						<div class="form-horizontal sb-form" id="pie_chart_base" style="display: none;">
							<div class="form-group">
								<label class="col-sm-6 control-label" for="y_axis_label">Select Chart Base</label>
								<div class="col-sm-6">
									<select name="y_axis_label2" id="y_axis_label2" class="sb-control">
										<?php
										if(!empty($yAxisColoumnList)){
											foreach($yAxisColoumnList as $coloumnName=>$yAxisColoumnRow){
												?>
												<option value="<?php echo $coloumnName;?>"><?php echo $yAxisColoumnRow;?></option>
											<?php
											}
										}
										?>
									</select>
									<!--  <span>Note: Must be one column from <i>(Total Score)</i></span> --></div>
							</div>
						</div>
						<div class="form-horizontal sb-form" id="y_axis_midpoint_div">
							<div class="form-group">
								<label class="col-sm-6 control-label" for="y_axis_midpoint">Y Axis Midpoint</label>
								<div class="col-sm-6">
									<input type="text" value="<?php echo $reportData['y_axis_midpoint'];?>" name="y_axis_midpoint" id="y_axis_midpoint" class="sb-control" placeholder="Y Axis Midpoint" />
								</div>
							</div>
						</div>
						<div class="form-horizontal sb-form">
							<div class="form-group">
								<div class="col-sm-6">Include Logo</div>
								<div class="col-sm-6">
									<input type="radio" id="yes" name="logo" value="1" <?php if($reportData['logo']==1){?>checked="checked"<?php }?> /> <label for="yes"><span></span>Yes</label>
									<br />
									<input type="radio" id="no" name="logo" value="0" <?php if($reportData['logo']==0){?>checked="checked"<?php }?>/> <label for="no"><span></span>No</label>
								</div>
							</div>
						</div>
						<div class="form-horizontal sb-form">
							<div class="form-group">
								<div class="col-xs-6"><input type="button" class="btn btn-primary" value="Back" name="btn_step_3" id="btn_step_3" onclick="next_step(3,4);"></div>
								<div class="col-xs-6">
									<input type="button" class="btn btn-primary-green query_builder" value="Next" name="btn_step_5" id="btn_step_5" onclick="next_step(5,4); ">
								</div>
							</div>
						</div><!-- .form-horizontal .sb-form -->
					</div><!-- .col-sm-12 -->
				</div><!-- .content-body -->
			</div><!--// Step 4 -->

			<!-- Step 5 last step-->
			<div id="step_5" style="display:none;">
				<div class="row content-header">
					<?php echo heading('Report Preview', 1);?>
					<div style='float:right; padding-right:10px;'>
						<!-- 	<a href='javascript:void(0);' onClick='gen_pdf();' class='btn btn-primary'>Export to PDF</a>
                            <a href='javascript:;' rrrrr onClick='return false;' class='btn btn-primary'>Export to CSV</a> -->
						<a href='javascript:;'
						   onClick='report_list(); clearContent(); liveChartIntervalRemove(); return false;'
						   class='btn btn-primary'> Back
						</a>
					</div>
				</div>
				<!-- .row -->

				<div class="row content-body">
					<div class="col-sm-12">
						<div class="form-horizontal sb-form querySaveDivRegion">
							<div class="form-group">

								<div class="col-xs-6">
									<input type="button" class="btn btn-primary" value="Back" name="btn_step_4" id="btn_step_4"
										   onclick="next_step(4,5); clearContent(); liveChartIntervalRemove();">
								</div>

								<div class="col-xs-6">
									<input type='hidden' name='report_id' value='<?php if(isset($reportId)){echo $reportId;}?>'/>
									<input type="button" class="btn btn-primary-green reportSave" value="Update Report"
										   name="btn_step_save" style='float:right;' id="btn_step_save" onclick="next_step('update',5); ">

								</div>

							</div>
							<div class='queryBuilderHtml'></div>

						</div><!-- .form-horizontal .sb-form -->
					</div><!-- .col-sm-12 -->
				</div>
			</div><!--// Step 5 -->

		</div><!-- #report_content -->
		</form>

<script>
	function remove_filter(id)
	{
		$("#filter_"+id).remove();
	}
</script>

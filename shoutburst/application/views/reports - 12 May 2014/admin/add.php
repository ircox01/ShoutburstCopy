<?php echo form_open_multipart('reports/', array('name'=>'add_report', 'id'=>'add_report', 'onsubmit'=>"return check_it(this)")) ?>
<?php echo $this->session->flashdata('message');?>
<div id="content">
<div class="container">
<div id="report_content" class="cf"><!--<input type="button" onclick="gen_pdf()" value="PDF" />-->
    <!-- Step 1 -->
    <div id="step_1">
        <div class="row content-header">        
	        <a class="sb-btn sb-btn-white" onclick="report_list(); clearContent(); liveChartIntervalRemove(); return false;" href="javascript:;">Cancel</a>
			<?php echo heading('Report Creation', 1);?>
        </div><!-- .row -->
        <div class="row content-body">
            <div class="col-sm-6">
                <div class="form-horizontal sb-form">
               
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="report_name">Report Name</label>
                        <div class="col-sm-6">
                            <input type="text" value="" name="report_name" id="report_name" class="sb-control" placeholder="Report name" autofocus>
                            <div id='reportNameErr' style='color:red;diplay:none;'></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="report_type">Report Type:</label>
                        <div class="col-sm-6">
                            <select id="report_type" class="sb-control" name="report_type">
                                <?php foreach ($report_types as $rt){?>
                                <option value="<?php echo strtolower( $rt->type_name )?>"><?php echo $rt->type_name?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id='reportPeriodRegion'>
                        <label class="col-sm-6 control-label" for="report_period">Report Period:</label>
                        <div class="col-sm-6">
                            <select id="report_period" class="sb-control" name="report_period" onChange='reportPeriodOptionCheck();'>
                                <?php foreach ($report_periods as $rp){?>
                                <option value="<?php echo strtolower( $rp->rep_prd_name )?>"><?php echo $rp->rep_prd_name?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="customDateRegion" style='display:none;'>
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="datepicker">
                                Start Date
                            </label>
                            <div class="col-sm-6 sb-date-picker">
                                <input type="text" name='start_date' id="datepicker" class='datePicker sb-control'>
                          	 	
                                 <div id='start_dateErr' style='color:red;diplay:none;'></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="datepicker2">
                                End Date
                            </label>
                            <div class="col-sm-6 sb-date-picker">
                                <input type="text" name='end_date' id="datepicker2" class='sb-control datePicker'>                               
                                 <div id='end_dateErr' style='color:red;diplay:none;'></div>
                            </div>
                            
                        </div>
                    </div><!-- .customDateRegion -->
                    
                    <div class="form-group customDayRegion" style='display:none;'>
                        <label class="col-sm-6 control-label" for="custom_date">Select Date:</label>
                        <div class="col-sm-6 sb-date-picker">
                            <input type="text" name='custom_date' id="custom_date" class='sb-control datePicker'>
                        
                            <div id='customDateErr' style='color:red;display:none;'></div>
                        </div>
                        
                    </div>
                    <div class="form-group" id='reportInetrvalRegion'>
                        <label class="col-sm-6 control-label" for="report_interval">Intervals:</label>
                        <div class="col-sm-6">
                            <select id="report_interval" class="sb-control" name="report_interval">
                                <?php foreach ($report_intervals as $ri){?>
                                <option value="<?php echo strtolower( $ri->rep_interval_name )?>"><?php echo $ri->rep_interval_name?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="output_requirements_div" >
                        <label class="col-sm-6 control-label" for="op_req">Output Requirements:</label>
                        <div class="col-sm-6">
                            <select name="op_req" class="sb-control" id="op_req">    
                             <option value="">Select</option>                           
                                <option value="email">Email</option>
                                  <option value="data">On Screen</option>
                                    <option value="ftp">FTP</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="email_tr" style="display:none;">
                        <label class="col-sm-6 control-label" for=""></label>
                        <div class="col-sm-6">
                            <textarea name="email_address" rows="3" cols="10" class="sb-textarea" placeholder="Add email addresses [comma separated] ..."></textarea>
                        </div>
                    </div>
                    <!-- #email_tr -->
                    <div id="ftp_tr" style="display:none;">
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="ftp_host_name">Host:</label>
                            <div class="col-sm-6">
                                <input type="text" class="sb-control" name="ftp_host_name" id="ftp_host_name" placeholder="Host" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="ftp_port">Port:</label>
                            <div class="col-sm-6">
                                <input type="text" class="sb-control" name="ftp_port" id="ftp_port" placeholder="Port" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="ftp_user_name">Username:</label>
                            <div class="col-sm-6">
                                <input type="text" class="sb-control" name="ftp_user_name" id="ftp_user_name" placeholder="Username" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="ftp_password">Password:</label>
                            <div class="col-sm-6">
                                <input type="text" class="sb-control" name="ftp_password" id="ftp_password" placeholder="Password" />
                            </div>
                        </div>
                    </div>
                    <!-- #ftp_tr -->
                    <div class="form-group" id="assigned">
                        <label class="col-sm-6 control-label" for="">Assigned?</label>
                        <div class="col-sm-6">
                            <input type="checkbox" id="dashboard" name="dashboard">
                            <label for="dashboard"><span></span>Dashboard</label>
                            <br>
                            <input type="checkbox" id="wallboard" name="wallboard">
                            <label for="wallboard"><span></span>Wallboard</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="">Privacy:</label>
                        <div class="col-sm-6">
                            <input type="radio" id="private" name="privacy" value="private" checked="checked">
                            <label for="private"><span></span>Private</label>
                            <br>
                            <input type="radio" id="global" name="privacy" value="global">
                            <label for="global"><span></span>Global</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-6 control-label" for=""></label>
                        <div class="col-xs-6">
                            <input type="hidden" name="op_req_flag" id="op_req_flag" value="data" />
                            <input type="button" class="sb-btn sb-btn-green" value="Next" name="btn_step_2" id="btn_step_2" onclick="next_step(2,1); setXAxisLabel(); " />
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
        	<a class="sb-btn sb-btn-white" onclick="report_list(); clearContent(); liveChartIntervalRemove(); return false;" href="javascript:;">Cancel</a>
        	<?php echo heading('Data Control', 1);?>
        </div>
        <!-- .row -->
        <div class="row content-body">
            <div class="col-sm-12">
                <div class="row dragdrop-wrap data-control">
					<div class="col-xs-6">
						<h3 class="hidden-xs">Drag from here</h3>
						<div class="row">
							<div class="col-sm-12">
								<ul id="sort1" class="dragdrop">
									<li class="general">Campaign</li>
									<li class="general">Agent PIN</li>
									<li class="general">Agent Name</li>
									<li class="general">Dialed Number</li>
									<li class="general">CLI</li>								                 
									<li class="score">Q1 Score</li>
									<li class="score">Q2 Score</li>
									<li class="score">Q3 Score</li>
									<li class="score">Q4 Score</li>
									<li class="score">Q5 Score</li>
									<li class="score">Total Score</li>
                                    <li class="score">Total Surveys</li>
									<li class="score">Average Score</li> 
									<li class="detail">Sentiment</li>
									<li class="detail">Recording</li>
									<li class="detail">Transcription</li>
									<li class="detail">Notes</li>
									<li class="detail">Tag</li>   
								</ul>
							</div>
						</div><!-- .row -->
					</div><!-- .col-sm-6 -->
					
					<!-- Hidding right arrow on small devices i.e. smart phone -->
					<div class="col-sm-2 hidden" style="text-align: center;"> <span class="glyphicon glyphicon-arrow-right" style="font-size: 60px; margin-top:200px; color:#666;"></span> </div>
					<!-- Showing down arrow on small devices -->
					<div class="col-xs-12 visible-xs" style="text-align: center;"> <span class="glyphicon glyphicon-arrow-down" style="font-size: 60px; margin: 20px auto; color:#666;"></span> </div>
					<!-- Showing clear and spacing on small devices -->
					<div class="clearfix visible-xs" style="margin-top: 20px;"></div>
					
					<div class="col-sm-6">
					  <h3 class="hidden-xs">Output Fields</h3>
					  <div class="row">
						<div class="col-sm-12">
							<ul id="sort2" class="dragdrop makTest">
							</ul>
						</div>
					  </div>
					</div><!-- .col-sm-6 -->
                
                </div><!-- .row -->
			
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-horizontal sb-form">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_1" id="btn_step_1" onclick="next_step(1,2);" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="button" class="sb-btn sb-btn-green" value="Next" name="btn_step_3" id="btn_step_3" onclick="save_fields();" />
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
        	<a class="sb-btn sb-btn-white" onclick="report_list(); clearContent(); liveChartIntervalRemove(); return false;" href="javascript:;">Cancel</a>
        	<?php echo heading('Filter', 1);?>
        </div>
        <!-- .row -->
        <div class="row content-body">
            <div class="col-sm-12">
                <div class="row form-group">
                    <div class="col-xs-2 col-w-110"> Condition </div>
                    <div class="col-xs-3"> Data Type </div>
                    <div class="col-xs-3"> Filter </div>
                    <div class="col-xs-3"> Detail </div>
                </div>
                
                <div class="extraPersonTemplate relative" style="display:none;">
                    <div class="controls controls-row">
                        <div class="form-group row">
                            <div class='col-xs-2 col-w-110'>
                            	<select class='span2 sb-control' id='condition' name='condition[]'>
                                    <option value='AND'>And</option>
                                    <option value='OR'>Or</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <select class="span2 sb-control" id="data_type" name="data_type[]">
                                    <option value="">Select</option>
                                    <option value="user_pin">Agent PIN</option>
                                    <option value="full_name">Agent Name</option>
                                    <option value="">Dialled Number</option>
                                    <option value="cli">CLI</option>
                                    <option value="q1">Q1 score</option>
                                    <option value="q2">Q2 score</option>
                                    <option value="q3">Q3 score</option>
                                    <option value="q4">Q4 score</option>
                                    <option value="q5">Q5 score</option>
                                    <option value="total_score">Total Score</option>
                                    <option value="average_score">Average Score</option>
                                    <option value="audio_file">Recording</option>
                                    <option value="transcription_id">Transcription</option>
                                    <option value="sentiment_score">Sentiment</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <select class="span2 sb-control" id="filter" name="filter[]">
                                  	<option value="">Select</option>
                                    <option value="e">Equal</option>
                                    <option value="ne">Not Equal</option>
                                    <option value="gt">Greater Than</option>
                                    <option value="lt">Less Than</option>
                                    <option value="b">Between</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <input class="span3 sb-control" placeholder="Detail" type="text" id="detail" name="detail[]">
                            </div>                            
                        </div>                        
                    </div>
                    <!-- .controls .controls-row -->
                </div>
                
                <div class="_extraPersonTemplate relative">
                    <div class="controls controls-row">
                        <div class="form-group row">
                        	<div class='col-xs-2 col-w-110'></div>
                            <div class="col-xs-3">
                                <select class="span2 sb-control" id="data_type" name="data_type[]">
                                	<option value="">Select</option>
                                    <option value="user_pin">Agent PIN</option>
                                    <option value="full_name">Agent Name</option>
                                    <option value="">Dialled Number</option>
                                    <option value="cli">CLI</option>
                                    <option value="q1">Q1 score</option>
                                    <option value="q2">Q2 score</option>
                                    <option value="q3">Q3 score</option>
                                    <option value="q4">Q4 score</option>
                                    <option value="q5">Q5 score</option>
                                    <option value="total_score">Total Score</option>
                                    <option value="average_score">Average Score</option>
                                    <option value="audio_file">Recording</option>
                                    <option value="transcription_id">Transcription</option>
                                    <option value="sentiment_score">Sentiment</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <select class="span2 sb-control" id="filter" name="filter[]">
                                    	<option value="">Select</option>
                                    	<option value="e">Equal</option>
                                    <option value="ne">Not Equal</option>
                                    <option value="gt">Greater Than</option>
                                    <option value="lt">Less Than</option>
                                    <option value="b">Between</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <input class="span3 sb-control" placeholder="Detail" type="text" id="detail" name="detail[]">
                            </div>                            
                        </div>                        
                    </div>
                    <!-- .controls .controls-row -->
                </div>
                <!-- .extraPersonTemplate -->
                <div id="container"></div>
                <a href="#" class="report-filter-icon-add-row" id="addRow"><span class="glyphicon glyphicon-plus-sign green"></span></p></a>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-horizontal sb-form">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <input type="hidden" id="reports_fields" name="reports_fields">
                                    <input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_2" id="btn_step_2" onclick="next_step(2,3);">
                                </div>
                                <div class="col-xs-6">
                                    <input type="button" class="sb-btn sb-btn-green" value="Next" name="btn_step_4" id="btn_step_4" onclick="next_step(4);">
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
    <!--// Step 3 -->
    <!-- Step 4 -->
    <div id="step_4" style="display:none;">
        <div class="row content-header">
        	<a class="sb-btn sb-btn-white" onclick="report_list(); clearContent(); liveChartIntervalRemove(); return false;" href="javascript:;">Cancel</a>
        	<?php echo heading('Report Stylesheet', 1);?>
        </div>
        <!-- .row -->
        <div class="row content-body">
            <div class="col-sm-6">
                <div class="form-horizontal sb-form">
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="x_axis_label">Background Colour</label>
                        <div class="col-sm-6">
                            <input type="text" value="" name="background_color" id="background_color" class="custom-color-picker" placeholder="Background Colour" />
                        </div>
                    </div>
                </div>
                <div class="form-horizontal sb-form" id="x_axis_label_div">
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="x_axis_label">X Axis Label</label>
                        <div class="col-sm-6">
                            <input type="text" value="" name="x_axis_label" id="x_axis_label" class="sb-control" readonly placeholder="X Axis Label" />
                           <!-- <span>Note: Must be one column from <i>(Day,Agent)</i></span> --></div>
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
                  <div class="form-horizontal sb-form" id="pie_chart_base" style="display: hidden;">
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
                          <!--   <span>Note: Must be one column from <i>(Total Score)</i></span> --></div>
                    </div>
                </div>
                <div class="form-horizontal sb-form" id="y_axis_midpoint_div">
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="y_axis_midpoint">Y Axis Midpoint</label>
                        <div class="col-sm-6">
                            <input type="text" value="" name="y_axis_midpoint" id="y_axis_midpoint" class="sb-control" placeholder="0" />
                        </div>
                    </div>
                </div>
                <div class="form-horizontal sb-form">
                    <div class="form-group">
                        <div class="col-sm-6">Include Logo</div>
                        <div class="col-sm-6">
                            <input type="radio" id="yes" name="logo" value="1" checked="checked"/>
                            <label for="yes"><span></span>Yes</label>
                            <br />
                            <input type="radio" id="no" name="logo" value="0" />
                            <label for="no"><span></span>No</label>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal sb-form">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_3" id="btn_step_3" onclick="next_step(3,4);">
                        </div>
                        <div class="col-xs-6">
                            <input type="button" class="sb-btn sb-btn-green query_builder" value="Next" name="btn_step_5" id="btn_step_5" onclick="next_step(5,4); ">
                        </div>
                    </div>
                </div>
                <!-- .form-horizontal .sb-form -->
            </div>
            <!-- .col-sm-12 -->
        </div>
        <!-- .content-body -->
    </div>
    <!--// Step 4 -->
    <!-- Step 5 -->
    <div id="step_5" style="display:none;">
        <div class="row content-header">

					<a href='javascript:;' onClick='report_list(); clearContent(); liveChartIntervalRemove(); return false;' class='sb-btn sb-btn-white'>Cancel</a>
					<a href='javascript:;' onClick='return false;' class='sb-btn sb-btn-blue' style='margin-left: 0px;'>Export to CSV</a>
					<a href='javascript:void(0);' onClick='gen_pdf();' class='sb-btn sb-btn-blue'>Export to PDF</a>
			<?php echo heading('Report Preview', 1);?>  	
		</div>
   
        <!-- .row -->
        <div class="row content-body">
            <div class="col-sm-12">
                <div class="form-horizontal sb-form querySaveDivRegion">
                    <div class="form-group">
                        <div class='queryBuilderHtml' id="queryBuilderHtml"></div>
                        <div class="col-xs-6">
                        	<div style="display:none;"><textarea id="report_html" name="report_html"></textarea></div>
                            <input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_4" id="btn_step_4" onclick="next_step(4,5); clearContent(); liveChartIntervalRemove();">
                        </div>
                        <div class="col-xs-6">
                            <input type="button" class="sb-btn sb-btn-green reportSave" value="Save" name="btn_step_save" id="btn_step_save" onclick="next_step('save',5); liveChartIntervalRemove();">                            
                        </div>
                    </div>
                </div>
                <!-- .form-horizontal .sb-form -->
            </div>
            <!-- .col-sm-12 -->
        </div>
    </div>
    <!--// Step 5 -->
</div>
<!-- #report_content -->
</form>
<link rel="stylesheet" href="<?php echo base_url()?>css/spectrum.css" />
<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/spectrum.js"></script>

<!-- JS Chart file need to be here because when ajax request send it will loaded again for each -->
<script type="text/javascript" src="<?php echo base_url()?>js/jscharts.js"></script>
<script type="text/javascript">

$(function () {
	//ajax loader
	jQuery('body').append('<div id="ajaxBusy"><div id="spinner">Please wait a few moment while we process your request.<br/><br/><img src="<?php echo base_url(); ?>/images/ajax-loader.gif"></div></div>');
	
	
	$("ul.dragdrop").sortable({
		connectWith: "ul"
    });
});


function report_list(){
	window.location = "<?php echo base_url().'reports'?>";
}

/**
 * Color Picker Bind 
 */
//Custom Color Picker - http://bgrins.github.io/spectrum/
$(document).ready(function(){
	
	$('[name="start_date"]').datetimepicker( {format:'m/d/Y H:i'});
	$('[name="end_date"]').datetimepicker({ format:'m/d/Y H:i'});
	$('[name="custom_date"]').datetimepicker({ 
			timepicker:false,
			format:'m/d/Y'
	});
	$("input.custom-color-picker").spectrum({});
});

$(document).ready(function(){
	$("#op_req").change(function(){
		var value = $(this).val();

		switch (value){
			case 'email':
				$('#ftp_tr').hide();
				$('#email_tr').show();
				$('#op_req_flag').val('email');
			break;

			case 'ftp':
				$('#email_tr').hide();
				$('#ftp_tr').show();
				$('#op_req_flag').val('ftp');
			break;

			default:
				$('#email_tr').hide();
				$('#ftp_tr').hide();
				$('#op_req_flag').val('data');
			break;
		}
	});
});

/*
 * @author:	Muhammad Sajid
 * @name:	next_step
 */
function next_step(step, current)
{ 
	if(validateCustomDateRange(step)){
		if (step == 'save'){
			//alert('Saved Successfully');
			saveReportData();
		} else {
			// hide all steps
			for(var i=1; i<=5; i++)
			{
				$("#step_"+i).hide();
			}
			var report_type = $("#report_type").val();
			
			if(report_type=="pie chart" || report_type=='bar chart' || report_type=='line graph')
			{
				$("#step_2").hide(); if(current==1)step=3;if(current==3)step=1;
			}
			// show only upcoming step
		
			 $("#step_"+step).show();	
		}
	}
}

/*
 * @author:	Muhammad Sajid
 * @name:	save_fields
 * @desc:	save selected fields for reports
 */
function save_fields(){
	var i = 0;
	var data = new Array();
	$('#sort2').each(function(k, items_list){
			$(items_list).find('li').each(function(j, li){
			data[i++] = $(li).text();
		});
	 });
	/*$('#sort4').each(function(k, items_list){
		$(items_list).find('li').each(function(j, li){
		data[i++] = $(li).text();
		});  
	});
	$('#sort6').each(function(k, items_list){
		$(items_list).find('li').each(function(j, li){
			data[i++] = $(li).text();
		});
	});*/
	// save in hidden field
	$("#reports_fields").val(data);
        
	// check report_type
	var report_type = $("#report_type").val();
	var report_fields = data.length;
	
	if(report_type=="pie chart" || report_type =='bar chart' || report_type=='line graph')
	{
		$('#step_1').hide();
	}
	else
	{
		if(report_fields == 0)
		{
			alert('Please select Data Control');
			$("#step_3").hide();
			$("#step_2").show();
		}
		/*else if ((report_type == 'pie chart') && ( (report_fields <= 1) || (report_fields > 2) ) )
		{
			alert("You need to select exactly two Data Controls for Pie Chart");
			$("#step_3").hide();
			$("#step_2").show();
		}*/
		else if ((report_type == 'data') && ( (report_fields <= 1) || (report_fields >= 2) ) ) 
		{
			var lis = document.getElementById("sort2").getElementsByTagName("li");
			var dtscore=false;
			var dtgen=false;
		
			$("#sort2 li").each(function()
			{
				if($(this).hasClass("score"))
					dtscore=true;
				else if ($(this).hasClass("general"))
					dtgen=true;		   
			});
			if(dtscore && dtgen)
			{
				next_step(3,2);
			}else
			{
				alert("You need to select atleast one score control and one data type control");
				$("#step_3").hide();
				$("#step_2").show();
			}
		}
		else
		{
			next_step(3,2);
		}
	}
}

$(document).ready(function () {

     $('#addRow').click(function () {
	 	var div_len = $('.extraPerson').length;
           $('<div/>', {
		   	   'id'	: 'filter_'+div_len,
               'class' : 'extraPerson relative', html: GetHtml()
     		}).hide().appendTo('#container').slideDown('slow');
     });

	$('.query_builder').click(function ()
	{
		// post data to query_builder
		request = $.ajax({
            type : 'POST',
			url : "<?php echo base_url().'reports/query_builder/'?>",
			data:$("#add_report").serialize(),
            success:function (data) {
            	if(data){            	
                		jQuery('.queryBuilderHtml').html(data);                		
            	}
            }          
        });	    

		});	
	//	jQuery('.queryBuilderHtml').html(img);
	
});

//save Report
function saveReportData(){
	// post data to query_builder
	
	$.ajax({
        type : 'POST',
		url : "<?php echo base_url().'reports/query_builder/'?>",
		data:"saveReport=saveReportData&"+$("#add_report").serialize(),
        success:function (data) {
        	if(data){
        			jQuery('#ajaxBusy').show();
        			window.location.replace("<?php echo base_url().'reports'?>");
            		jQuery('.querySaveDivRegion').html(data);
        	}
        }          
    });
}

//clear report html content
function clearContent(){

	jQuery('.queryBuilderHtml').html('Please Wait...');
}

/*
 * @author:	Muhammad Sajid
 * @name:	GetHtml
 */
function GetHtml()
{
    var len = $('.extraPerson').length;
    var $html = $('.extraPersonTemplate').clone();
	var $remove_link = '<a href="#" id="'+len+'" class="remove_filter report-filter-icon-remove-row" onClick="remove_filter('+len+')"><span class="glyphicon red glyphicon-minus-sign"></span></a>';

	if($html.find('[id=condition]').length == 0)
	{
		//$("#con_div", $html).attr("name", "condition[]");
		//$html.append($("<select class='span2 sb-control' id='condition' name='condition[]'><option value='AND'>And</option><option value='OR'>Or</option></select>"));
		var $div = $("<select class='span2 sb-control' id='condition' name='condition[]'><option value='AND'>And</option><option value='OR'>Or</option></select>");
		$("#con_div").append($div);
		//$html.find('[id=condition]')[0].name="condition[]";
	}
	//$html.find('[id=condition]')[0].name="condition[]";

	$html.find('[id=data_type]')[0].name="data_type[]";
    $html.find('[id=filter]')[0].name="filter[]";
    $html.find('[id=detail]')[0].name="detail[]";
	$html = $html.append($remove_link);
	return $html.html();    
}

/*
 * @author:	Muhammad Sajid
 * @name:	gen_pdf
 */
function gen_pdf()
{
	$('#report_html').val($('#queryBuilderHtml').html());
	//var dataURL = document.getElementById("JSChart_graph").toDataURL();
	$("#img").attr("src", dataURL);
	$.ajax({
		type : 'POST',
		url : "<?php echo base_url().'reports/generate_pdf/'?>",
		data: $("#add_report").serialize(),
		success:function (data) {
			console.log(data);
			alert(data);
		},
		error:function(data, errorThrown)
        {
            alert('request failed :'+errorThrown);
			
		}
	});
}

/**
 * Set X-Axis Label 
 */
function setXAxisLabel(){

	var report_period 	= jQuery('#report_period').val();
	var report_interval = jQuery('#report_interval').val();

	//upper case fisrt letter
	report_period 	= report_period.charAt(0).toUpperCase() + report_period.slice(1);
	report_interval = report_interval.charAt(0).toUpperCase() + report_interval.slice(1);
	
	jQuery('#x_axis_label').val(report_period+' ( '+report_interval+' )');
 }

$(document).ready(function()
{	
	$("#op_req option[value='data']").hide();
	$("#op_req option[value='ftp']").hide();
	$('#pie_chart_base').hide();
	$("#filter").change(function()
	{
		var value = $(this).val();
		if (value == "b"){
			alert('Please specify range eg: start,end');
		}
	});	
	
	$("#report_type").change(function()
	{		
		var value = $(this).val();
		reportPeriodOptionCheck();

		$("#op_req option[value='']").attr('selected', 'selected');
		$('#email_tr').hide();
		
		if ( ((value == "bar chart") || (value == "line graph")) && (value != "pie chart") )
		{
			$('#assigned').show();		
			$("#op_req option[value='data']").hide();
			$("#op_req option[value='ftp']").hide();
			$('#reportPeriodRegion').show();
			$('#reportInetrvalRegion').show();		
			$('#ftp_tr').hide();
			$('#pie_chart_base').hide();
		}
		else if (value == "detail")
		{
			$('#assigned').hide();		
			$('.customDateRegion').hide();
			$('#reportPeriodRegion').hide();
			$('#reportInetrvalRegion').show();
			$("#op_req option[value='ftp']").show();
			$('#dashboard').prop('checked', false); 
			$('#wallboard').prop('checked', false); 
		}
		else if(value == "pie chart")
		{
			$('#assigned').show();		
			$("#op_req option[value='data']").hide();
			$("#op_req option[value='ftp']").hide();
			$('#reportPeriodRegion').show();				
			$('#ftp_tr').hide();
			$("#reportInetrvalRegion").hide();
			$('#pie_chart_base').show();
		}
		else
		{
			$('#assigned').hide();		
			$("#op_req option[value='data']").show();
			$("#op_req option[value='ftp']").show();
			$('#reportPeriodRegion').show();
			$('#reportInetrvalRegion').show();
			$('#dashboard').prop('checked', false); 
			$('#wallboard').prop('checked', false); 
		}

		if ( (value == "bar chart") || (value == "line graph") )
		{
			$('#x_axis_label_div').show();
			$('#y_axis_label_div').show();
			$('#y_axis_midpoint_div').show();
		}
		else
		{
			$('#x_axis_label_div').hide();
			$('#y_axis_label_div').hide();
			$('#y_axis_midpoint_div').hide();
		}	
	});
}); 
	
	//validate custom date range
	function validateCustomDateRange(step){
		isvalid=true;
		if(step==2){
			
			var report_period = jQuery('#report_period').val();
			var startDate     = jQuery('#datepicker').val();
			var endDate       = jQuery('#datepicker2').val();
			var report_name	  = jQuery('#report_name').val();
			var custom_date	  = jQuery('#custom_date').val();
			var	report_type	  = jQuery('#report_type').val();
			var reportnameErr = "";

			//report name validate
			if(report_name==""){
				reportnameErr = "Report name is required.";
				jQuery('#reportNameErr').html(reportnameErr);
				jQuery('#reportNameErr').css('display','block');
				isvalid= false;
			}else{
				jQuery('#reportNameErr').html('');
				jQuery('#reportNameErr').css('display','none');
				//return true;
			}
			if(report_name!=""&&report_period=='custom'&&report_type!='detail')
			{
				var errMessage	= "";
				
				if(startDate==''){
					errMessage = "Please Select Start Date.<br/>";
					jQuery('#start_dateErr').html(errMessage);
					jQuery('#start_dateErr').css('display','block');
					isvalid= false;
				}else{
					jQuery('#start_dateErr').html('');
					jQuery('#start_dateErr').css('display','none');
					//return true;
				}

				if(endDate==''){
					errMessage = "Please Select End Date.<br/>";
					jQuery('#end_dateErr').html(errMessage);
					jQuery('#end_dateErr').css('display','block');
					isvalid= false;
				}else{
					jQuery('#end_dateErr').html('');
					jQuery('#end_dateErr').css('display','none');
					//return true;
				}
			
				if(startDate!=''&&endDate!=''){
					 if( (new Date(startDate).getTime() >= new Date(endDate).getTime()))
					 {
						 errMessage = "End Date should be greater than start date.<br/>";
						 jQuery('#end_dateErr').html(errMessage);
						 jQuery('#end_dateErr').css('display','block');
						 isvalid= false;
					 }else{
							jQuery('#end_dateErr').html('');
							jQuery('#end_dateErr').css('display','none');
							//return true;
						}
				}			
			}
			else if(report_period=='day')
			{				
				var errMessage	= "";
				
				if(custom_date=='')
				{
					errMessage = "Please Select Date.<br/>";
				}

				//check err msg
				if(errMessage!=''){
					jQuery('#customDateErr').html(errMessage);
					jQuery('#customDateErr').css('display','block');
					isvalid= false;
				}
				else
				{					
					jQuery('#customDateErr').html('');
					jQuery('#customDateErr').css('display','none');
					//return true;
				}
			}			
			return isvalid;
		}else{
			return true;
		}
	}

	//if Report Peroid is custom then show 
	function reportPeriodOptionCheck(){
		
		if(jQuery('#report_period').val()=='custom'){
			
			jQuery('.customDateRegion').css('display','block');
			jQuery('.customDayRegion').css('display','none');
			
		}else if(jQuery('#report_period').val()=='day'){
			
			jQuery('.customDayRegion').css('display','block');
			jQuery('.customDateRegion').css('display','none');
			
		}else{
			
			jQuery('.customDateRegion').css('display','none');
			jQuery('.customDayRegion').css('display','none');
		}
	}
</script>
<script>
function remove_filter(id){
	$("#filter_"+id).remove();
}
</script>
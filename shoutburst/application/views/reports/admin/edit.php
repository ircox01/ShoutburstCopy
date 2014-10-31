<script src="<?php echo base_url()?>js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/spectrum.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/spectrum.css" />
<!-- JS Chart file need to be here because when ajax request send it will loaded again for each -->
<script type="text/javascript" src="<?php echo base_url()?>js/jscharts.js"></script>
<style>
#ajaxBusy {
	display : none;
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: rgba(0, 0, 0, .1);
 -webkit-transition: all .5s ease;
	z-index: 1000;
}
#spinner {
	position: fixed;
	width: 328px;
	height: 150px;
	top: 40%;
	left: 50%;
	margin-top: -50px;
	margin-left: -101px;
	text-align:center;
	-webkit-transition: all 1000s linear;
}
</style>	
<script type="text/javascript">
$(function () {
	//ajax loader
	jQuery('body').append('<div id="ajaxBusy"><div id="spinner">Please wait a few moment while we process your request.<br/><br/><img src="<?php echo base_url(); ?>/images/simple-loader.png"></div></div>');
	
	$("ul.dragdrop").sortable({
		connectWith: "ul"
    });
});

</script>

<script type="text/javascript">

function report_list(){
	window.location = "<?php echo base_url().'reports'?>";
}

/**
 * Color Picker Bind 
 */
//Custom Color Picker - http://bgrins.github.io/spectrum/
$(document).ready(function(){
	$('[name="start_date"]').datetimepicker( {format:'d/m/Y H:i'});
	$('[name="end_date"]').datetimepicker({ format:'d/m/Y H:i'});
	$('[name="custom_date"]').datetimepicker({ 
		timepicker:false,
		 format:'d/m/Y'
	});
 $("input.custom-color-picker").spectrum(
 	{
 		color : "<?php if(!empty($reportData['background_color'])){ echo $reportData['background_color'];}else{ echo '#ffffff';}?>"
 	}
 );
});

$(document).ready(function(){

	//show report period
	reportPeriodOptionCheck();
	//show output requirement  region
	outputRequirementCheck();
	//show/hide report type required region
	var value = $('#report_type').val();
	repotTypeRegionDisplay(value);
});

/**
 * @author Arshad 
 */
 
 function outputRequirementCheck(){
	 
	var value = $('#op_req').val();

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
}

/*
 * @author:	Muhammad Sajid
 * @name:	next_step
 */
//Global array for storing selected fields.
var df = new Array();

function next_step(step, current)
{
	if(validateCustomDateRange(step)){

        if (step == 2 && current == 1) {
                var report_type = $("#report_type").val();
                if (report_type == "word cloud") {
                        save_fields();
                        return;

                }
        }
        if( ( step == 2 && current == 3))
        {
        	     var report_type = $("#report_type").val();
                if (report_type == "word cloud") {
                        save_fields();
                        step=1;
                        current=current-1;

                }
        }


		if(step == 'update'){
			updateReportData();
		}
		else
		{
			// hide all steps
			for(var i=1; i<=5; i++)
			{
				$("#step_"+i).hide();
			}
	
			var report_type = $("#report_type").val();
			
			// show only upcoming step
		
			 $("#step_"+step).show();
		}

		if(step ==4){
			tag_varification(df);
		}
	}
}

//Tag varification 
//Author: Usama Noman
function tag_varification(df){
	var Allelements=$("#step_3 .col-sm-12 > div");
	for(var i=0;i<Allelements.length-3;i++){
		if(i==0){
			if($("#data_type").val() == 'tag_name'){
				if(df.indexOf('Tag')<0){
					alert("You must select TAG in fields in order to filter reports with TAGS");
    				next_step(2,3);
				}
			}
		}
		else{
			if($("#data_type"+"_"+i).val() == 'tag_name'){
				if(df.indexOf('Tag')<0){
					alert("You must select TAG in fields in order to filter reports with TAGS");
    				next_step(2,3);
				}
			}
		}
	}

	Allelements=$("#step_3 .col-sm-12 #container > div");
	for(var i=2;i<Allelements.length;i++){
		
		if($("#data_type"+"_"+i).val() == 'tag_name'){
			if(df.indexOf('Tag')<0){
				alert("You must select TAG in fields in order to filter reports with TAGS");
				next_step(2,3);
			}
		}
		
	}
}

/*
 * @author:	Muhammad Sajid
 * @name:	save_fields
 * @desc:	save selected fields for reports
 */
function save_fields(){

	$('.makTest').each(function(i, items_list){       
        var i = 0;
        var data = new Array();

        $(items_list).find('li').each(function(j, li){
			data[i++] = $(li).text();
        })

         var ref_fields = ['Agent PIN','Agent Name','Dialed Number','CLI','Campaign'];
         var score_fields = ['Q1 Score','Q2 Score','Q3 Score','Q4 Score','Q5 Score','Total Score','Total Surveys'];
         var detail_fields = ['Recording','Transcription','Sentiment','Notes','Tag'];

        var has_ref = false;
        var total_ref = 0;
        var total_score = 0;
        var total_dets = 0;
        var has_score_or_detail = false;

        var report_type = $("#report_type").val();

        if (report_type == "bar chart" || report_type =="line graph" || report_type == "pie chart") {

                for (i = 0 ;i < ref_fields.length;i++) {
                        if (data.indexOf(ref_fields[i]) != -1) {
                                total_ref++;
                        }
                }

                for (i = 0 ;i < score_fields.length;i++) {
                        if (data.indexOf(score_fields[i]) != -1) {
                                total_score++;
                        }
                }

                for (i = 0 ;i < detail_fields.length;i++) {
                        if (data.indexOf(detail_fields[i]) != -1) {
                                total_dets++;
                        }
                }

                //alert(total_ref+ "/" + total_score + "/"+total_dets);

                if ( !(total_ref == 1 && ((total_score == 1 && total_dets == 0) || (total_score ==0 && total_dets == 1)))) {
                        alert("You must select exactly 1 reference field and 1 numerical OR 1 detail field");
                        return;
                }
        }

    df=data;
        
  // save in hidden field
	$("#reports_fields").val(data);
        
	// check report_type
	var report_type = $("#report_type").val();
	var report_fields = data.length;
	
	/*if(report_type=="pie chart" || report_type =='bar chart' || report_type=='line graph')
	{
		$('#step_1').hide();
	}
	else
	{*/
		if(report_fields == 0 && report_type != 'word cloud')
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
		else if ((report_type == 'data' || report_type == 'detail') && ( (report_fields <= 1) || (report_fields >= 2) ) ) 
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
	//}
	});
}

$(document).ready(function () {
     $('#addRow').click(function () {
	 	var div_len = $('div[id^=filter_]').length+1;
	 	
           $('<div/>', {
		   	   'id'	: 'filter_'+div_len,
               'class' : 'extraPerson relative', 
               html: GetHtml1(div_len)
     		}).hide().appendTo('#container').slideDown('slow');
     });

	$('.query_builder').click(function ()
	{
		// post data to query_builder
		$.ajax({
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
            		jQuery('.queryBuilderHtml').html(data);
        	}
        }          
    });
}

//update report data
function updateReportData(){
	// post data to query_builder
	$.ajax({
        type : 'POST',
		url : "<?php echo base_url().'reports/query_builder/'?>",
		data:"saveReport=updateReportData&"+$("#add_report").serialize(),
        success:function (data) {
        	if(data)
            {
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

function GetHtml1(div_len)
{
	$html = '<div class="extraPersonTemplate relative" style="display:block;">'+
   ' <div class="controls controls-row">'+
    '<div class="form-group row">'+
     '   <div class="col-xs-2 col-w-110">'+
      '  	<select class="span2 sb-control" id="condition" name="condition[]">'+
       '         <option value="AND">And</option>'+
        '        <option value="OR">Or</option>'+
         '   </select>'+
        '</div>'+
        '<div class="col-xs-3">'+
         '   <select class="span2 sb-control" id="data_type_'+div_len+'" name="data_type[]" onchange="callme(this);">'+
          '      <option value="">Select</option>'+
           '     <option value="user_pin">Agent PIN</option>'+
            '   <option value="full_name">Agent Name</option>'+
             '   <option value="dialed_number">Dialled Number</option>'+
              '  <option value="cli">CLI</option>'+
              '  <option value="q1">Q1 score</option>'+
              '  <option value="q2">Q2 score</option>'+
              '  <option value="q3">Q3 score</option>'+
              '  <option value="q4">Q4 score</option>'+
              '  <option value="q5">Q5 score</option>'+
              '  <option value="total_score">Total Score</option>'+
               ' <option value="average_score">Average Score</option>'+
              '  <option value="recording">Recording</option>'+
              '  <option value="tag_name">Tag</option>'+
              '  <option value="transcription_id">Transcription ID</option>'+
              '  <option value="sentiment_score">Sentiment Score</option>'+
           ' </select>'+
     '   </div>'+
     '   <div class="col-xs-3">'+
        '    <select class="span2 sb-control" id="filter1_'+div_len+'" name="filter[]">'+
            '  	<option value="">Select</option>'+
            '    <option value="e">Equal</option>'+
             '   <option value="ne">Not Equal</option>'+
             '   <option value="gt">Greater Than</option>'+
              '  <option value="lt">Less Than</option>'+
               ' <option value="b">Between</option>'+
               ' <option value="like">Like</option>'+
            '</select>'+
        '</div>'+
        '<div class="col-xs-3">'+
            '<input class="span3 sb-control" placeholder="Detail" type="text" id="detail1" name="detail[]"><span id="detailbox'+div_len+'"></span>'+
            '<!--<span><i>Note: Add values (comma separated)</i></span>-->'+
        '</div>'                            +
    '</div>'                       + 
'</div>'+
<!-- .controls .controls-row -->
'</div>';
var $remove_link = '<a href="#" id="'+div_len+'" class="remove_filter report-filter-icon-remove-row" onClick="remove_filter('+div_len+')"><span class="glyphicon red glyphicon-minus-sign"></span></a>';

return $html+$remove_link;
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
</script>

<script type="text/javascript">
$(document).ready(function(){	
	
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
		repotTypeRegionDisplay(value);
		
	});

	
});
function repotTypeRegionDisplay(value){
	
	if ( (value == "bar chart") || (value == "line graph") || (value == "pie chart") || (value == "word cloud") ){
		$('#assigned').show();		
		$('#reportPeriodRegion').show();
		$('#reportInetrvalRegion').show();
		$("#op_req option[value='data']").hide();
		$("#op_req option[value='ftp']").hide();
		//$('#email_tr').hide();
		$('#ftp_tr').hide();
	}
	else if (value == "detail")
	{
		$('#assigned').show();
		$('.customDateRegion').hide();
		$('#reportPeriodRegion').show();
		$('#reportInetrvalRegion').hide();
		$('#dashboard').prop('checked', false); 
		$('#wallboard').prop('checked', false); 
	}
	else
	{
		$('#assigned').hide();
		$('#reportPeriodRegion').show();
		$('#reportInetrvalRegion').show();
		$("#op_req option[value='data']").show();
		$("#op_req option[value='ftp']").show();
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

	if(value == "pie chart")
	{
		$("#reportInetrvalRegion").hide();
		$('#pie_chart_base').show();
	}
	else
	{
		$("#reportInetrvalRegion").show();
		$('#pie_chart_base').hide();
	}
}


var allnames = <?=json_encode($allnames)?>;
var allpins = <?=json_encode($allpins)?>;
var tags = <?=json_encode($tags)?>	
	//validate custom date range
	function validateCustomDateRange(step){
		isvalid= true;
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
			}else
			{
				jQuery('#reportNameErr').html('');
				jQuery('#reportNameErr').css('display','none');
				//return true;
			}
			if(report_name!=""&&report_period=='custom'&&report_type!='detail'){
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

			if(report_period=='day')
			{				
				var errMessage	= "";
				
				if(custom_date=='')
				{
					errMessage += "Please Select Date.<br/>";
				}

				//check err msg
				if(errMessage!=''){
					jQuery('#customDayErr').html('<div style="color:red;">'+errMessage+'</div>');
					jQuery('#customDayErr').css('display','block');
					 isvalid= false;
				}else{
					jQuery('#customDayErr').html('');
					jQuery('#customDayErr').css('display','none');
				//	return true;
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



	function getval(selectedVal) 
	{	

//		alert(selectedVal.value);
		$("#detail").val('');

		if(selectedVal.value==="user_pin" || selectedVal.value==="full_name" || selectedVal.value==="cli" || selectedVal.value==="dialed_number" || selectedVal.value==="recording" || selectedVal.value==="tag_name" )
		{
			$("#filter option[value='gt']").hide();
			$("#filter option[value='lt']").hide();
			$("#filter option[value='b']").hide();
		}else
		{
			$("#filter option[value='gt']").show();
			$("#filter option[value='lt']").show();
			$("#filter option[value='b']").show();
		}	
		if(selectedVal.value==="full_name" || selectedVal.value==="recording" )
		{
			$("#filter option[value='like']").show();
		}else
		{
			$("#filter option[value='like']").hide();
		}


        // show the special fields for agent name & agent PIN & tags
        if(selectedVal.value==="full_name") {
                // change inner html of detail html
                $("#detailbox").html('<select multiple id="detail_fn" style="height:60px;" class="span3 sb-control" onchange="updateField(this,-1);"></select>');
                console.log("noop");console.log("noop");
                for (i = 0;i < allnames.length;i++) {
                        $("#detail_fn").append(new Option(allnames[i],allnames[i]));

                }

        }

        if(selectedVal.value==="tag_name") {
	        // change inner html of detail html
	        //console.log(detail_fields)
	        if(df.indexOf('Tag')>-1){
		        $("#detailbox").html('<select multiple id="detail_tag" style="height:60px;" class="span3 sb-control" onchange="updateField(this,-1);"></select>');
		        for (i = 0;i < tags.length;i++) {
		            $("#detail_tag").append(new Option(tags[i].tag_name,tags[i].tag_name));

		        }
	        }
	        else{
	        	alert("You must select TAG in fields in order to filter reports with TAGS");
	        	next_step(2,3);
	        }
	    	

	    }


        if(selectedVal.value==="user_pin") {
                // change inner html of detail html
                $("#detailbox").html('<select multiple id="detail_pins" style="height:60px;" class="span3 sb-control" onchange="updateField(this,-1);"></select>');
                console.log("noop");console.log("noop");
                for (i = 0;i < allpins.length;i++) {
                        $("#detail_pins").append(new Option(allpins[i],allpins[i]));

                }

        }


       if (selectedVal.value != "user_pin" && selectedVal.value != "full_name" &&  selectedVal.value != "tag_name" ) {
                $("#detailbox").html('');
        }

        
	}

	function callme(val)
	{
		
		id = val.id;
//alert(id);		
arr = id.split('_');
//alert(arr);
		$("#detail_"+arr[2]).val('');
		
		if(val.value==="user_pin" || val.value==="full_name" || val.value==="cli" || val.value==="dialed_number" || val.value==="recording" || val.value==="tag_name")
		{
			$("#filter_"+arr[2]+" option[value='gt']").hide();
			$("#filter_"+arr[2]+" option[value='lt']").hide();
			$("#filter_"+arr[2]+" option[value='b']").hide();
		}else
		{
			$("#filter_"+arr[2]+" option[value='gt']").show();
			$("#filter_"+arr[2]+" option[value='lt']").show();
			$("#filter_"+arr[2]+" option[value='b']").show();
		}	
		if(val.value === "full_name" || val.value==="recording" )
		{
			$("#filter_"+arr[2]+" option[value='like']").show();
		}else
		{
			$("#filter_"+arr[2]+" option[value='like']").hide();
		}


        // show the special fields for agent name & agent PIN
        if(val.value==="full_name") {
                // change inner html of detail html
                $("#detailbox"+ arr[2]).html('<select multiple id="detail_fn' + arr[2]  +'" style="height:60px;" class="span3 sb-control" onchange="updateField(this,arr[2]);"></select>');
//		alert(arr[2]);
		
                console.log("noop");console.log("noop");
                console.log("noop");console.log("noop");
                for (i = 0;i < allnames.length;i++) {
                        $("#detail_fn" + arr[2]).append(new Option(allnames[i],allnames[i]));

                }

        }


        if(val.value==="tag_name") {
	        // change inner html of detail html
	        //console.log(detail_fields)
	        if(df.indexOf('Tag')>-1){
		        $("#detailbox"+arr[2]).html('<select multiple id="detail_tag" style="height:60px;" class="span3 sb-control" onchange="updateField(this,-1);"></select>');
		        for (i = 0;i < tags.length;i++) {
		            $("#detail_tag").append(new Option(tags[i].tag_name,tags[i].tag_name));

		        }
	        }
	        else{
	        	alert("You must select TAG in fields in order to filter reports with TAGS");
	        	next_step(2,3);
	        }
	    	

	    }

        if(val.value==="user_pin") {
                // change inner html of detail html
                $("#detailbox"+ arr[2]).html('<select multiple id="detail_pins' + arr[2]  +'" style="height:60px;" class="span3 sb-control" onchange="updateField(this,arr[2]);"></select>');
                console.log("noop");console.log("noop");
                console.log("noop");console.log("noop");
	                for (i = 0;i < allpins.length;i++) {
                        $("#detail_pins"  + arr[2]).append(new Option(allpins[i],allpins[i]));

                }

        }

        if (val.value != "user_pin" && val.value != "full_name" && val.value!="tag_name") {
                $("#detailbox"+ arr[2]).html('');
        }

        /*if(val.value==="tag_name") {
        	alert();
        }*/


	}

function updateField(selectbox, idx) {
                var arr = $("#"+selectbox.id).val();
                var leparent = $("#"+selectbox.id).parent();

                var lesib = leparent.siblings()[0];
                lesib.value = arr;
}




</script>

<?php echo form_open_multipart('reports/', array('name'=>'add_report', 'id'=>'add_report', 'onsubmit'=>"return check_it(this)")) ?>
<?php echo $this->session->flashdata('message');?>
<?php	 
if($reportData['report_type']=='detail'){
?>
<?php 	
}
?>
<div id="content">
  <div class="container">
	
<div id="report_content" class="cf">
	
	<!-- Step 1 -->
	<div id="step_1">
		<div class="row content-header">
			<?php echo heading('Update Report', 1);?>
		</div>
    	<!-- .row -->
		
	    <div class="row content-body">
		  <div class="col-sm-6">
			<div class="form-horizontal sb-form">
				<div class="form-group">
					<label class="col-sm-6 control-label" for="report_name">Report Name</label>
					<div class="col-sm-6">
						<input type="text" value="<?php if(isset($reportData['report_name'])){ echo $reportData['report_name'];}?>" name="report_name" id="report_name" class="sb-control" placeholder="Report name" autofocus>
						<div id='reportNameErr' style='color:red;diplay:none;'></div>
					</div>
					
				</div>
				<div class="form-group">
					<label class="col-sm-6 control-label" for="report_type">Report Type:</label>
					<div class="col-sm-6">
					<select id="report_type" class="sb-control" name="report_type">
	                <?php foreach ($report_types as $rt){
	                	
	                	$selected	=	"";
	                	if(isset($reportData['report_type'])&&$reportData['report_type']==strtolower( $rt->type_name )){
	                		$selected	=	"selected='selected'";
	                	}
	                ?>	                
	                	<option value="<?php echo strtolower( $rt->type_name )?>" <?php echo $selected;?>><?php echo $rt->type_name?></option>
	                <?php }?>
	                </select>
					</div>
				</div>
				<div class="form-group"  id='reportPeriodRegion'>
					<label class="col-sm-6 control-label" for="report_period">Report Period:</label>
					<div class="col-sm-6">
					
	                <select id="report_period" class="sb-control" name="report_period" onChange='reportPeriodOptionCheck();'>
	                <?php foreach ($report_periods as $rp){
	               			$selected	=	"";
		                	if(isset($reportData['report_period'])&&$reportData['report_period']==strtolower( $rp->rep_prd_name )){
		                		$selected	=	"selected='selected'";
		                	}
	                ?>
	                	<option value="<?php echo strtolower( $rp->rep_prd_name )?>" <?php echo $selected;?>><?php echo $rp->rep_prd_name?></option>
	                <?php }?>                	
	                </select>
					</div>
				</div>
                <div class="customDateRegion" style='display:none;'>
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="datepicker">Start Date:</label>
                        <div class="col-sm-6 sb-date-picker">
                        	<input type="text" name='start_date' id="datepicker" class='datePicker sb-control' value="<?php if(isset($reportData['custom_start_date'])){echo $reportData['custom_start_date'];} ?>">
                        	<div id='start_dateErr' style='color:red;diplay:none;'></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="datepicker2">End Date</label>
                        <div class="col-sm-6 sb-date-picker">
                        	<input type="text" name='end_date' id="datepicker2" class='datePicker sb-control' value="<?php if(isset($reportData['custom_end_date'])){echo $reportData['custom_end_date'];} ?>">
                        	<div id='end_dateErr' style='color:red;diplay:none;'></div>
                        </div>
                    </div>
					<div id='customDateErr' style='display:none;'></div>
	            </div>
	            <div class="form-group customDayRegion" style='display:none;'>				  
                   <label class="col-sm-6 control-label" for="custom_date">Select Date:</label>
                   		<div class="col-sm-6 sb-date-picker">
						<input type="text" name='custom_date' id="custom_date" class='sb-control datePicker' value="<?php if(isset($reportData['report_period_date'])){echo $reportData['report_period_date'];} ?>">
					  <div id='customDayErr' style='display:none;'></div>
				   </div>
	            </div>
				<div class="form-group" id='reportInetrvalRegion'>
					<label class="col-sm-6 control-label" for="report_interval">Intervals:</label>
					<div class="col-sm-6">					
	                <select id="report_interval" class="sb-control" name="report_interval">
	                <?php foreach ($report_intervals as $ri){
	               			$selected	=	"";
		                	if(isset($reportData['report_interval'])&&$reportData['report_interval']==strtolower( $ri->rep_interval_name )){
		                		$selected	=	"selected='selected'";
		                	}
	                ?>
	                	<option value="<?php echo strtolower( $ri->rep_interval_name )?>" <?php echo $selected;?> ><?php echo $ri->rep_interval_name?></option>
	                <?php }?>                	
	                </select>
					</div>
				</div>
				<div class="form-group" id="output_requirements_div" >
					<label class="col-sm-6 control-label" for="op_req">Output Requirements:</label>
					<div class="col-sm-6">
						<select name="op_req" class="sb-control" id="op_req" onChange='outputRequirementCheck();'>
							<option value="" >Select</option>
							<option value="data"  <?php if(isset($reportData['op_req'])&&$reportData['op_req']=='data'){echo "selected='selected'";}?> >On Screen</option>
							<option value="email" <?php if(isset($reportData['op_req'])&&$reportData['op_req']=='email'){echo "selected='selected'";}?>>Email</option>
							<option value="ftp"   <?php if(isset($reportData['op_req'])&&$reportData['op_req']=='ftp'){echo "selected='selected'";}?>>FTP</option>
						</select>
					</div>
				</div>
				<div class="form-group" id="email_tr" style="display:none;">
					<label class="col-sm-6 control-label" for=""></label>
					<div class="col-sm-6">
						<textarea name="email_address" rows="3" cols="10" class="sb-textarea" placeholder="Add email addresses [comma separated] ..."><?php if(isset($reportData['email_address'])){ echo $reportData['email_address'];}?></textarea>
					</div>
				</div><!-- #email_tr -->
				
				<div id="ftp_tr" style="display:none;">
					<div class="form-group">
						<label class="col-sm-6 control-label" for="ftp_host_name">Host:</label>
						<div class="col-sm-6">
							<input type="text" class="sb-control" name="ftp_host_name" id="ftp_host_name" placeholder="Host" value="<?php if(isset($reportData['ftp_host_name'])){ echo $reportData['ftp_host_name'];}?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-6 control-label" for="ftp_port">Port:</label>
						<div class="col-sm-6">
							<input type="text" class="sb-control" name="ftp_port" id="ftp_port" placeholder="Port" value="<?php if(isset($reportData['ftp_port'])){ echo $reportData['ftp_port'];}?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-6 control-label" for="ftp_user_name">Username:</label>
						<div class="col-sm-6">
							<input type="text" class="sb-control" name="ftp_user_name" id="ftp_user_name" placeholder="Username" value="<?php if(isset($reportData['ftp_user_name'])){ echo $reportData['ftp_user_name'];}?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-6 control-label" for="ftp_password">Password:</label>
						<div class="col-sm-6">
							<input type="text" class="sb-control" name="ftp_password" id="ftp_password" placeholder="Password" value="<?php if(isset($reportData['ftp_password'])){ echo $reportData['ftp_password'];}?>" />
						</div>
					</div>
				</div><!-- #ftp_tr -->
				<?php
					$displayProp	=	""; 
					if($reportData['report_type']=='data'){
						$displayProp	=	"style='display:none;'"; 
					}
				?>
				<div class="form-group" id="assigned" <?php echo $displayProp;?> >
					<label class="col-sm-6 control-label" for="">Assigned?</label>
					<div class="col-sm-6">
						<input type="checkbox" id="dashboard" name="dashboard" <?php if(isset($reportData['dashboard'])&&$reportData['dashboard']==1){ echo 'checked';}?>> <label for="dashboard"><span></span>Dashboard</label>
						<br>
						<input type="checkbox" id="wallboard" name="wallboard" <?php if(isset($reportData['wallboard'])&&$reportData['wallboard']==1){ echo 'checked';}?>> <label for="wallboard"><span></span>Wallboard</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-6 control-label" for="">Privacy:</label>
					<div class="col-sm-6">		
						<input type="radio" id="private" name="privacy" value="private" <?php if(isset($reportData['privacy'])&&$reportData['privacy']=='private'){ echo 'checked="checked"';}?>>
                        <label for="private"><span></span>Private</label>
						<br>
						<input type="radio" id="global" name="privacy" value="global" <?php if(isset($reportData['privacy'])&&$reportData['privacy']=='global'){ echo 'checked="checked"';}?>>
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
			</div><!-- .form-horizontal .sb-form -->
		  </div><!-- .col-sm-12 -->
		</div><!-- .content-body -->
	</div><!--// Step 1 -->
	
	<!-- Step 2 -->
	<div id="step_2" style="display:none;">
		<div class="row content-header">
			<?php echo heading('Data Control', 1);?>
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
                                if(!empty($dataControlColumn)){
                                        foreach($general as $refField)  {
						if (in_array($refField, $dataControlColumn)) {
?>
							<li class="general"><?php echo $refField;?></li>
<?php
						} 
                                        }
                                }
                        ?>
			</ul>

                       <span>Numerical</span>
                       <ul id="sort1" class="dragdrop ddsmall">

                       <?php
                                if(!empty($dataControlColumn)){
                                        foreach($score as $refField)  {
                                                if (in_array($refField, $dataControlColumn)) {
?>
                                                        <li class="score"><?php echo $refField;?></li>
<?php
                                                }
                                        }
?>
                                                                        <li class="score">NPS</li>
                                                                        <li class="score">Adjusted NPS</li>

<?php
                                }
                        ?>
                        </ul>

                       <span>Detail</span>
                       <ul id="sort1" class="dragdrop ddsmall">

                       <?php
                                if(!empty($dataControlColumn)){
                                        foreach($detail as $refField)  {
                                                if (in_array($refField, $dataControlColumn)) {
?>
                                                        <li class="detail"><?php echo $refField;?></li>
<?php
                                                }
                                        }
                                }
                        ?>
                        </ul>



				</div>

                <!-- Hidding right arrow on small devices i.e. smart phone -->
				<div class="col-sm-2 hidden" style="text-align: center;"> <span class="glyphicon glyphicon-arrow-right" style="font-size: 60px; margin-top:200px; color:#666;"></span> </div>
				<!-- Showing down arrow on small devices -->
				<div class="col-xs-12 visible-xs" style="text-align: center;"> <span class="glyphicon glyphicon-arrow-down" style="font-size: 60px; margin: 20px auto; color:#666;"></span> </div>
				<!-- Showing clear and spacing on small devices -->
				<div class="clearfix visible-xs" style="margin-top: 20px;"></div>
                
                <div class="col-sm-6">
                    <h3 class="hidden-xs">Output Fields</h3>
                    <ul id="sort2" class="dragdrop makTest">
	                    <?php
                    		if(!empty($selectedDataControl) && !empty($selectedDataControl[0]) ){
                    			foreach($selectedDataControl as $selectedDataControlRow)
								{
									if (in_array($selectedDataControlRow, $general)){
										$sel_class = 'general';
									} elseif (in_array($selectedDataControlRow, $score)) {
										$sel_class = 'score';
									} elseif (in_array($selectedDataControlRow, $detail)) {
										$sel_class = 'detail';
									} else {
										$sel_class = '';
									}
                    	?>
                    				<li class="<?php echo $sel_class?>"><?php echo $selectedDataControlRow;?></li>
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
						<div class="col-xs-6"><input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_1" id="btn_step_1" onclick="next_step(1,2);" /></div>
						<div class="col-xs-6">
							<input type="button" class="sb-btn sb-btn-green" value="Next" name="btn_step_3" id="btn_step_3" onclick="save_fields();" />
						</div>
					</div>
				</div><!-- .form-horizontal .sb-form -->
			  </div>
			</div><!-- .row -->
			
		  </div><!-- .col-sm-12 -->
		</div><!-- .content-body -->
	</div><!--// Step 2 -->
	
	<!-- Step 3 -->
	<div id="step_3" style="display:none;">
		<div class="row content-header">
			<?php echo heading('Filter', 1);?>
		</div>
    	<!-- .row -->
		
	    <div class="row content-body">
		  <div class="col-sm-12">
		  	<div class="row">
				<div class="col-xs-3 col-w-110" >
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
				
				if( isset ( $query_data_type ) && !empty( $query_data_type) )
				{
					$divCount = 0;
					foreach($query_data_type as $recordKey=>$query_data_typeRow)
					{						
						$divClass	=	"_extraPersonTemplate ";
						
			?><?php if( $divCount > 0 )
									{
									?><div class="relative"  id="filter_<?php echo $divCount;?>" ><?php }?>
				<div class="<?php echo $divClass;?>">
					<div class="controls controls-row">
							<div class="form-group row">								
								<div class="col-xs-2 col-w-110">
									<?php if( $divCount > 0 )
									{
									?>
									<select class="span2 sb-control" id="condition" name="condition[]">
										<?php 
											$conidtionArr	=	array('AND'=>'And','OR'=>'Or');
											if(!empty($conidtionArr)){
												foreach($conidtionArr as $key=>$conidtionRow){
													
													$selected	=	"";
													if($query_condition[$divCount]==$key){
														$selected	=	"selected='selected'";
													}
										?>
													<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $conidtionRow;?></option>
										<?php 
												}
											}
										?>
										
									</select>
									<?php } ?>
								</div>
								
								<div class="col-xs-3">
									<select class="span2 sb-control" id="data_type<?=$divCount == 0 ? "": "_$divCount"?>" name="data_type[]" onchange="<?= $divCount == 0 ? "getval(this);":"callme(this);"?>">
										<?php 
											$dataTypeArr	=	array(
																		''			=>'Select',
																		'user_pin'			=>'Agent PIN',
																		'full_name'			=>'Agent Name',
																		'dialed_number'		=>'Dialled Number',
																		'cli'				=>'CLI',
																		'q1'				=>'Q1 score',
																		'q2'				=>'Q2 score',
																		'q3'				=>'Q3 score',
																		'q4'				=>'Q4 score',
																		'q5'				=>'Q5 score',
																		'total_score'		=>'Total Score',
																		'average_score'		=>'Average Score',
																		'recording'		=>'Recording',
																		'tag_name'	=>'Tag',
																		'transcription_id'	=>'Transcription ID',
																		'sentiment_score'	=>'Sentiment Score',
																	);
											if(!empty($dataTypeArr))
											{
												foreach($dataTypeArr as $key=>$dataTypeRow)
												{													
													$selected	=	"";
													if($query_data_type[$recordKey]==$key)
													{
														$selected	=	"selected='selected'";
													}
													
										?>
													<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $dataTypeRow;?></option>
										<?php 
												}
											}
										?>
									</select>
								</div>
								<div class="col-xs-3">					
									<select class="span2 sb-control" id="filter" name="filter[]">
										<?php 
											$filtereArr	=	array(		''			=>'Select',
																		'e'			=>'Equal',
																		'ne'		=>'Not Equal',
																		'gt'		=>'Greater Than',
																		'lt'		=>'Less Than',
																		'b'			=>'Between',
																		'like'		=>'Like'
																	);
											if(!empty($filtereArr)){
												foreach($filtereArr as $key=>$filtereRow){
													
													$selected	=	"";
													if($query_filter[$recordKey]==$key){
														$selected	=	"selected='selected'";
													}
													
										?>
													<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $filtereRow;?></option>
										<?php 
												}
											}
										?>
									</select>
								</div>
								<div class="col-xs-3">
									<input class="span3 sb-control" placeholder="Detail" type="text" id="detail" value="<?php echo $query_detail[$recordKey]; ?>" name="detail[]"><span id="detailbox<?=$divCount == 0 ? "" : $divCount;?>" name="tingu">
<?php
// pre-select PINs
//var_dump($query_data_type[$recordKey]);

//var_dump($query_detail[$recordKey]);
if ($query_data_type[$recordKey] == "user_pin") {
?>
<select multiple id="detail_pins<?=$divCount == 0 ? "" : $divCount;?>" style="height:60px;" class="span3 sb-control" onchange="updateField(this,<?=$divCount == 0 ? "-1" : $divCount;?>);"> 
<?php
$pins = explode(",",$query_detail[$recordKey]);
for ($i=0;$i < count($pins);$i++) {
	$pins[$i] = trim($pins[$i]);
}

foreach ($allpins as $pin) {
$selstat = "";

if (in_array($pin,$pins)) {
	$selstat = "selected='selected'";
}

?>
<option value='<?=$pin?>' <?=$selstat?>><?=$pin?></option>
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
<select multiple id="detail_fn<?=$divCount == 0 ? "" : $divCount;?>" style="height:60px;" class="span3 sb-control" onchange="updateField(this,<?=$divCount == 0 ? "-1" : $divCount;?>);">
<?php
$names = explode(",",$query_detail[$recordKey]);
for ($i=0;$i < count($names);$i++) {
        $names[$i] = trim($names[$i]);
}

foreach ($allnames as $name) {
$selstat = "";

if (in_array($name,$names)) {
        $selstat = "selected='selected'";
}

?>
<option value='<?=$name?>' <?=$selstat?>><?=$name?></option>
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
				    <?php if( $divCount > 0 ){?><a href="#" id="<?php echo $divCount; ?>" class="remove_filter report-filter-icon-remove-row" onClick="remove_filter(<?php echo $divCount; ?>)"><span class="glyphicon red glyphicon-minus-sign"></span></a>
				    </div><?php }?>
				   <!-- .extraPersonTemplate -->
				  
			<?php 
						$divCount++;
					}
				}
			?>
			<div id="container"></div>
			<a href="#" class="report-filter-icon-add-row" id="addRow"><span class="glyphicon glyphicon-plus-sign green"></span></p></a>
			
			<div class="row">
  			  <div class="col-sm-6">
				<div class="form-horizontal sb-form">
					<div class="form-group">
						<div class="col-xs-6"><input type="hidden" id="reports_fields" name="reports_fields">
							<input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_2" id="btn_step_2" onclick="next_step(2,3);">
						</div>
						<div class="col-xs-6">							
							<input type="button" class="sb-btn sb-btn-green" value="Next" name="btn_step_4" id="btn_step_4" onclick="next_step(4);">
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
						<input type="text" value="<?php if(!empty($reportData['background_color'])){ echo $reportData['background_color'];}else{ echo '#ffffff';}?>" name="background_color" id="background_color" class="custom-color-picker" placeholder="Background Colour" />
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
			</div>	    <div class="form-horizontal sb-form" id="pie_chart_base" style="display: hidden;">
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
					<div class="col-xs-6"><input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_3" id="btn_step_3" onclick="next_step(3,4);"></div>
					<div class="col-xs-6">						
						<input type="button" class="sb-btn sb-btn-green query_builder" value="Next" name="btn_step_5" id="btn_step_5" onclick="next_step(5,4); ">
					</div>
				</div>
			</div><!-- .form-horizontal .sb-form -->
		  </div><!-- .col-sm-12 -->
		</div><!-- .content-body -->
	</div><!--// Step 4 -->
	
	
	<!-- Step 5 -->
	<div id="step_5" style="display:none;">
		<div class="row content-header">
			<?php echo heading('Report Preview', 1);?>
			  <div style='float:right; padding-right:10px;'>
				<!-- 	<a href='javascript:void(0);' onClick='gen_pdf();' class='btn btn-primary'>Export to PDF</a>
					<a href='javascript:;' onClick='return false;' class='btn btn-primary'>Export to CSV</a> -->
					<a href='javascript:;' onClick='report_list(); clearContent(); liveChartIntervalRemove(); return false;' class='btn btn-primary'>Back</a>
				</div>
		</div>
    	<!-- .row -->
    	
    	<div class="row content-body">
			<div class="col-sm-12">
				<div class="form-horizontal sb-form querySaveDivRegion">
				  <div class="form-group">
					<div class="col-xs-6">
						<input type="button" class="sb-btn sb-btn-white" value="Back" name="btn_step_4" id="btn_step_4" onclick="next_step(4,5); clearContent(); liveChartIntervalRemove();">

					</div>
					<div class="col-xs-6">
					 		<input type='hidden' name='report_id' value='<?php if(isset($reportId)){echo $reportId;}?>'/>
					 		<input type="button" class="sb-btn sb-btn-green reportSave" value="Update Report" name="btn_step_save" style='float:right;' id="btn_step_save" onclick="next_step('update',5); ">

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

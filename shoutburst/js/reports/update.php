<script>

BASE_URL = <?php echo '"'.base_url().'"' ?>;

function SB_addAjaxLoader()
{
    jQuery('body').append('' +
        '<div id="ajaxBusy">' +
        '<div id="spinner">' +
        'Please wait a few moment while we process your request.' +
        '<br/>' +
        '<br/>' +
        '<img src="' + BASE_URL + '/images/simple-loader.png"></div></div>');
}

$(function () {

    SB_addAjaxLoader();


    $("ul.dragdrop").sortable({
        connectWith: "ul"
    });

    //Custom Color Picker - http://bgrins.github.io/spectrum/
    $('[name="start_date"]').datetimepicker( {format:'Y-m-d H:i:s'} );
    $('[name="end_date"]').datetimepicker( {format:'Y-m-d H:i:s'} );
    $('[name="custom_date"]').datetimepicker({
        timepicker:true,
        format:'Y-m-d H:i:s'
    });
    $("input.custom-color-picker").spectrum( {
        color : "<?php
        if(!empty($reportData['background_color']))
    {
        echo $reportData['background_color'];
    }
    else
    {
        echo '#ffffff';
    }?>"
} );

//show report period
reportPeriodOptionCheck();
//show output requirement  region
outputRequirementCheck();
//show/hide report type required region
var value = $('#report_type').val();
repotTypeRegionDisplay(value);

$('#addRow').click(function ()
{
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
        data : $("#add_report").serialize(),
        success:function (data) {
            if(data){
                jQuery('.queryBuilderHtml').html(data);
            }
        }
    });
});

$("#filter").change(function()
{
    var value = $(this).val();
    if (value == "b")
    {
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

function report_list()
{
    window.location = "<?php echo base_url().'reports'?>";
}

function outputRequirementCheck()
{
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

//Global array for storing selected fields.
var df = new Array();

function next_step(step, current)
{
    if (validateCustomDateRange(step)) {
        if (step == 2 && current == 1) {
            var report_type = $("#report_type").val();
            if (report_type == "word cloud") {
                save_fields();
                return;

            }
        }
        if (( step == 2 && current == 3)) {
            var report_type = $("#report_type").val();
            if (report_type == "word cloud") {
                save_fields();
                step = 1;
                current = current - 1;
            }
        }

        if (step == 'update') {
            updateReportData();
        } else {
            // hide all steps
            for (var i = 1; i <= 5; i++) {
                $("#step_" + i).hide();
            }

            var report_type = $("#report_type").val();

            // show only upcoming step

            $("#step_" + step).show();
        }

        if (step == 4) {
            tag_varification(df);
        }
    }
}

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

function save_fields(){

    $('.makTest').each(function(i, items_list){
        var i = 0;
        var data = new Array();

        $(items_list).find('li').each(function(j, li){
            data[i++] = $(li).text();
        })

        var ref_fields = ['Agent PIN','Agent Name','Dialed Number','CLI','Campaign', 'Source'];
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

//Set X-Axis Label
function setXAxisLabel(){

    var report_period 	= jQuery('#report_period').val();
    var report_interval = jQuery('#report_interval').val();

    //upper case fisrt letter
    report_period 	= report_period.charAt(0).toUpperCase() + report_period.slice(1);
    report_interval = report_interval.charAt(0).toUpperCase() + report_interval.slice(1);

    jQuery('#x_axis_label').val(report_period+' ( '+report_interval+' )');
}

function repotTypeRegionDisplay(value)
{
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
        $('#dashboard').prop('checked', true);
        $('#wallboard').prop('checked', false);
    }
    else if (value == "data")
    {
        $('#assigned').show();
        $('.customDateRegion').hide();
        $('#reportPeriodRegion').show();
        $('#reportInetrvalRegion').hide();
        $('#wallboard').prop('checked', false);
    }
    else
    {
        $('#assigned').hide();
        $('#reportPeriodRegion').show();
        $('#reportInetrvalRegion').show();
        $("#op_req option[value='data']").show();
        $("#op_req option[value='ftp']").show();
        $('#dashboard').prop('checked', true);
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

    console.log(allnames);
    console.log(allpins);
    console.log(tags);

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
};

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

function updateField(selectbox, idx)
{
    var arr = $("#" + selectbox.id).val();
    var leparent = $("#" + selectbox.id).parent();

    var lesib = leparent.siblings()[0];
    lesib.value = arr;
}
</script>
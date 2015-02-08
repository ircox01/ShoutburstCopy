<?php
$dateRangeHtml = "";
if (!empty($dateRange) && $dateRange != null) {
    $dateRangeHtml = $dateRange;
}

$report_period = ucwords($report_period);
$report_interval = ucwords($report_interval);
//get commong button which will display on reporting
$commonButtons = '';//commonButtons();
?>
<style>
    .rowHeight {
        height: 30px;
    }

    .mainDiv {
        font-weight: bold;
        color: #A3CEED;
        padding: 20px;
    }

    .childDiv {
        padding: 4px;
    }

    .childDivContent {
        color: #53A1F4;
    }

    .table-sb .Transcription {
        width: 40% !important;
    }

    .table-sb .Transcription {
        width: 40% !important;
    }

    .table-sb .Date_Time {
        width: 160px !important;
    }

    .hancytable {
        margin:0px;padding:0px;
        width:100%;
        box-shadow: 10px 10px 5px #888888;
        border:1px solid #000000;

        -moz-border-radius-bottomleft:20px;
        -webkit-border-bottom-left-radius:20px;
        border-bottom-left-radius:20px;

        -moz-border-radius-bottomright:20px;
        -webkit-border-bottom-right-radius:20px;
        border-bottom-right-radius:20px;

        -moz-border-radius-topright:20px;
        -webkit-border-top-right-radius:20px;
        border-top-right-radius:20px;

        -moz-border-radius-topleft:20px;
        -webkit-border-top-left-radius:20px;
        border-top-left-radius:20px;
    }
    .hancytable table {
         border-collapse: collapse;
         border-spacing: 0;
         width:100%;
         height:100%;
         margin:0px;padding:0px;

    }
    .hancytable tr:last-child td:last-child {
          -moz-border-radius-bottomright:20px;
          -webkit-border-bottom-right-radius:20px;
          border-bottom-right-radius:20px;
    }
    .hancytable table thead tr:first-child th:first-child {
        -moz-border-radius-topleft:20px;
        -webkit-border-top-left-radius:20px;
        border-top-left-radius:20px;
    }
    .hancytable table thead tr:first-child th:last-child {
        -moz-border-radius-topright:20px;
        -webkit-border-top-right-radius:20px;
        border-top-right-radius:20px;
    }
    .hancytable tr:last-child td:first-child {
         -moz-border-radius-bottomleft:20px;
         -webkit-border-bottom-left-radius:20px;
         border-bottom-left-radius:20px;
    }
    .hancytable tr:hover td {
          background-color:#ffffff;
    }
    .hancytable td {
        vertical-align:middle;

        background-color:#aad4ff;

        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        text-align:left;
        padding:5px;
        font-size:20px;
        font-family:Arial;
        font-weight:normal;
        color:#000000;
    }
    .hancytable tr:last-child td {
         border-width:0px 1px 0px 0px;
    }
    .hancytable tr td:last-child {
          border-width:0px 0px 1px 0px;
    }
    .hancytable tr:last-child td:last-child {
           border-width:0px 0px 0px 0px;
    }
    .hancytable tr:first-child th {
        background:-o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f) );
        background:-moz-linear-gradient( center top, #005fbf 5%, #003f7f 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");	background: -o-linear-gradient(top,#005fbf,003f7f);

        background-color:#005fbf;
        border:0px solid #000000;
        text-align:center;
        border-width:0px 0px 1px 1px;
        font-size:30px;
        font-family:Arial;
        font-weight:bold;
        color:#ffffff;
    }
    .hancytable tr:first-child:hover th {
        background:-o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f) );
        background:-moz-linear-gradient( center top, #005fbf 5%, #003f7f 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");	background: -o-linear-gradient(top,#005fbf,003f7f);

        background-color:#005fbf;
    }
    .hancytable tr:first-child th:first-child {
        border-width:0px 0px 1px 0px;
    }
    .hancytable tr:first-child th:last-child {
        border-width:0px 0px 1px 1px;
    }
</style>

<?php
if (!empty($logo) && isset($logo)) {
    ?>
    <img src='<?php echo $logo ?>' width="200" height="70" class="shadow"
         style="position: absolute; top: 15px; right: 15px;">
<?php
}
?>
<?php if (!$hancymode): ?>
<div class='report-preview '>
    <div class='row'>
        <div class='col-sm-2 col-field'>Report Name:</div>
        <div class='col-sm-4 col-data'><?php echo $report_name; ?></div>
    </div>
    <div class='row'>
        <div class='col-sm-2 col-field'>Report Date</div>
        <div class='col-sm-4 col-data'><?php echo $report_date; ?></div>
    </div>
    <div class='row'>
        <div class='col-sm-2 col-field'>Report Period:</div>
        <div class='col-sm-4 col-data'><?php echo $report_period; ?></div>
    </div>
    <?php
    if ($report_type != "Pie Chart") {
    ?>
        <div class='row'>
            <div class='col-sm-2 col-field'>Report Interval:</div>
            <div class='col-sm-4 col-data'><?php echo $report_interval; ?></div>
        </div>
    <?php
    }
    ?>

    <div class='row'>
        <div class='col-sm-2 col-field'>Date Filter:</div>
        <div class='col-sm-4 col-data'><?php echo $dateRangeHtml; ?></div>
    </div>
    <div class='row'>
        <div class='col-sm-2 col-field'>Report Type:</div>
        <div class='col-sm-4 col-data'><?php echo $report_type; ?></div>
    </div>
    <p class="countdown"></p>
</div>
<?php endif; ?>
<?php
/**
 * Record Not Found
 * */

if (isset($errMessage) && $errMessage != '') {
    echo $errMessage;
} else {

    $selectedColoumnHeadingArr = explode(",", $selectedColoumnHeading);

    ?>
    <div <?=$hancymode?'class="hancytable"':''?>>
    <table id='myTable' class='table-sb'>
        <thead>
        <tr class='dark-blue-title'>
            <?php
            $totalColumn = count($selectedColoumnHeadingArr);
            $totalColumn = $totalColumn + 2; //increment count value 2 so that we'll able to fetch all desire record b/c in array 0 and 1 key value are something else

            //check total is comming from selected data control
            $totalSurveyColPosition = array_search('Total Surveys', $selectedColoumnHeadingArr);
            if ($totalSurveyColPosition !== false) {
                $totalSurveyColPosition = $totalSurveyColPosition + 2;
            }

            $tagNamePosition = array_search('Tag', $selectedColoumnHeadingArr);
            if ($tagNamePosition !== false) {
                $tagNamePosition = $tagNamePosition + 2;
            }


            /**
             * Set Table Heading HTML
             * */

            if (!empty($selectedColoumnHeadingArr)) {

                ?>
                <?php if($report_period != 'Today'): ?>
                    <th <?=$hancymode?'':"style='background-color: #19458B;'"?>>Date</th>
                <?php endif; ?>
                <?php
                foreach ($selectedColoumnHeadingArr as $selectedColoumnHeadingRow) {
                    $hclass = 'background-color: #19458B;';
                    if ($selectedColoumnHeadingRow == "Campaign" || $selectedColoumnHeadingRow == "Agent PIN" || $selectedColoumnHeadingRow == "Agent Name" ||
                        $selectedColoumnHeadingRow == "Dialed Number" || $selectedColoumnHeadingRow == "CLI"
                    ) {
                        $hclass = "background-color: #19458B;";
                    } else if ($selectedColoumnHeadingRow == "Notes" || $selectedColoumnHeadingRow == "Recording" || $selectedColoumnHeadingRow == "Transcription" || $selectedColoumnHeadingRow == "Tag" || $selectedColoumnHeadingRow == "Sentiment") {
                        $hclass = "background-color: #209700;";
                    } else {
                        //$hclass="background-color: #2254a2;";
                        $hclass = "background-color: #19458B;";
                    }
                    $selectedColoumnHeadingRow = trim($selectedColoumnHeadingRow);
                    ?>
                    <th style=' white-space: normal !important; background-color: #19458B;' class='text-center'>
                        <?php echo $selectedColoumnHeadingRow; ?>
                    </th>

                <?php
                }
            }


            ?>

        </tr>
        </thead>
        <tbody>
        <?php
        /**
         * Set Agent Base Record
         * */

        //var_debug($agentRecordData);exit();
        if (!empty($agentRecordData)){
        //Total
        $overAllTotalArr = array();

        //record by agent name
        foreach ($agentRecordData as $agentName => $agentRecordDataRow){

        ksort($agentRecordDataRow);
        if (!empty($agentRecordDataRow)){

        /**
         * Record Raw Divided Date(Day) Basis
         * */
        foreach ($agentRecordDataRow as $recordDate => $agentRecordDateWise){

        /**
         * Define Sub-Total Variable for each selected heading
         * */
        $subTotalArray = array();
        $q1_total = 0;
        $q2_total = 0;
        $q3_total = 0;
        $q4_total = 0;
        $q5_total = 0;
        $total_score = 0;
        $agent_name = $recordDate;
        $rows_count = 0;
        $transcription_counts = 0;
        $recording_counts = 0;
        $agent_pin = 0;
        $sentiments_counts = 0;
        $dialed_number = 0;
        $cli = 0;
        $tag_name = "-";
        $camp_name = "-";
        if (!empty($agentRecordDateWise)){
        $loopount = 0;
        if (in_array("Campaign", $selectedColoumnHeadingArr)) {
            $previous_camp_name = $agentRecordDateWise[0]['camp_name'];
        }
        foreach ($agentRecordDateWise as $agentRecordDateWiseRow){
        if (in_array("Campaign", $selectedColoumnHeadingArr)) {
        if ($previous_camp_name != $agentRecordDateWiseRow['camp_name']) {

        ?>
        <tbody>
        <tr class='overall-total'>
            <?php
            if (!empty($selectedColoumnHeadingArr)) {
                ?>
                <td>
                    <?php echo $agentName; ?>
                </td>
                <?php
                foreach ($selectedColoumnHeadingArr as $selectedColoumnHeadingRow) {
                    $hclass = '-';
                    if ($selectedColoumnHeadingRow == "Q1 Score") {
                        $hclass = number_format($q1_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Q2 Score") {
                        $hclass = number_format($q2_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Q3 Score") {
                        $hclass = number_format($q3_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Transcription") {
                        $hclass = $transcription_counts;
                    } else if ($selectedColoumnHeadingRow == "Recording") {
                        $hclass = $recording_counts;
                    } else if ($selectedColoumnHeadingRow == "Q4 Score") {
                        $hclass = number_format($q4_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Q5 Score") {
                        $hclass = number_format($q5_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Agent Name") {
                        $hclass = $recordDate;
                    } else if ($selectedColoumnHeadingRow == "Agent PIN") {
                        $hclass = $agent_pin;
                    } else if ($selectedColoumnHeadingRow == "Sentiment") {
                        $hclass = $sentiments_counts / $rows_count;
                    } else if ($selectedColoumnHeadingRow == "Total Score") {
                        $hclass = $total_score;
                    } else if ($selectedColoumnHeadingRow == "Total Surveys") {
                        $hclass = $rows_count;
                    } else if ($selectedColoumnHeadingRow == "Dialed Number") {
                        $hclass = $rows_count;
                    } else if ($selectedColoumnHeadingRow == "CLI") {
                        $hclass = $cli;
                    } else if ($selectedColoumnHeadingRow == "Tag") {
                        $hclass = $tag_name;
                    } else if ($selectedColoumnHeadingRow == "Campaign") {
                        $hclass = $camp_name;
                    }

                    ?>
                    <td style=' white-space: normal !important;' class='text-center'>
                        <?php echo $hclass; ?>
                    </td>
                <?php
                }
            }
            ?>
        </tr>
        <?php

        $q1_total = 0;
        $q2_total = 0;
        $q3_total = 0;
        $q4_total = 0;
        $q5_total = 0;
        $total_score = 0;
        $agent_name = $recordDate;
        $rows_count = 0;
        $transcription_counts = 0;
        $recording_counts = 0;
        $agent_pin = 0;
        $sentiments_counts = 0;
        $dialed_number = 0;
        $cli = 0;
        $tag_name = "-";
        $camp_name = "-";
        $previous_camp_name = $agentRecordDateWiseRow['camp_name'];

        }

        }

        $range = end($agentRecordDateWiseRow);
        //die(var_debug($agentRecordDateWiseRow));
        if (isset($agentRecordDateWiseRow['user_pin']) && !empty($agentRecordDateWiseRow['user_pin'])) {
            $agent_pin = $agentRecordDateWiseRow['user_pin'];
        }
        if (isset($agentRecordDateWiseRow['tag_name']) && !empty($agentRecordDateWiseRow['tag_name'])) {
            $tag_name = $agentRecordDateWiseRow['tag_name'];
        }
        if (isset($agentRecordDateWiseRow['dialed_number']) && !empty($agentRecordDateWiseRow['dialed_number'])) {
            $dialed_number = $agentRecordDateWiseRow['dialed_number'];
        }
        if (isset($agentRecordDateWiseRow['cli']) && !empty($agentRecordDateWiseRow['cli'])) {
            $cli = $agentRecordDateWiseRow['cli'];
        }
        if (isset($agentRecordDateWiseRow['total_score']) && !empty($agentRecordDateWiseRow['total_score'])) {
            $total_score = $agentRecordDateWiseRow['total_score'];
        }
        if (isset($agentRecordDateWiseRow['camp_name']) && !empty($agentRecordDateWiseRow['camp_name'])) {
            $camp_name = $agentRecordDateWiseRow['camp_name'];
        }
        if (isset($agentRecordDateWiseRow['q1']) && !empty($agentRecordDateWiseRow['q1'])) {
            $q1_total = $agentRecordDateWiseRow['q1'];
        }
        if (isset($agentRecordDateWiseRow['q2']) && !empty($agentRecordDateWiseRow['q2'])) {
            $q2_total = $agentRecordDateWiseRow['q2'];
        }
        if (isset($agentRecordDateWiseRow['q3']) && !empty($agentRecordDateWiseRow['q3'])) {
            $q3_total = $agentRecordDateWiseRow['q3'];
        }
        if (isset($agentRecordDateWiseRow['q4']) && !empty($agentRecordDateWiseRow['q4'])) {
            $q4_total = $agentRecordDateWiseRow['q2'];
        }
        if (isset($agentRecordDateWiseRow['q5']) && !empty($agentRecordDateWiseRow['q5'])) {
            $q5_total = $agentRecordDateWiseRow['q3'];
        }
        if (!empty($agentRecordDateWiseRow['transcriptions_text']) && isset($agentRecordDateWiseRow['transcriptions_text'])) {
            $transcription_counts++;
        }
        if (!empty($agentRecordDateWiseRow['recording']) && isset($agentRecordDateWiseRow['recording'])) {
            $recording_counts++;
        }
        if (!empty($agentRecordDateWiseRow['sentiment_score']) && isset($agentRecordDateWiseRow['sentiment_score'])) {
            $sentiments_counts += calc_sentimentscore($agentRecordDateWiseRow['sentiment_score']);
        }

        $rows_count++;
        }

        ?>

        <tr class='overall-total'>
            <?php
            if (!empty($selectedColoumnHeadingArr)) {
                ?>
                <?php if($report_period!='Today'): ?>
                <td>
                    <?php echo $agentName; ?>
                </td>
                <?php endif; ?>
                <?php
                foreach ($selectedColoumnHeadingArr as $selectedColoumnHeadingRow) {
                    $hclass = '-';
                    if ($selectedColoumnHeadingRow == "Q1 Score") {
                        $hclass = number_format($q1_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Q2 Score") {
                        $hclass = number_format($q2_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Q3 Score") {
                        $hclass = number_format($q3_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Transcription") {
                        $hclass = $transcription_counts;
                    } else if ($selectedColoumnHeadingRow == "Recording") {
                        $hclass = $recording_counts;
                    } else if ($selectedColoumnHeadingRow == "Q4 Score") {
                        $hclass = number_format($q4_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Q5 Score") {
                        $hclass = number_format($q5_total, 1);
                    } else if ($selectedColoumnHeadingRow == "Agent Name") {
                        $hclass = $recordDate;
                    } else if ($selectedColoumnHeadingRow == "Agent PIN") {
                        $hclass = $agent_pin;
                    } else if ($selectedColoumnHeadingRow == "Sentiment") {
                        $hclass = ($sentiments_counts / $rows_count);
                    } else if ($selectedColoumnHeadingRow == "Total Score") {
                        $hclass = number_format($total_score, 1);
                    } else if ($selectedColoumnHeadingRow == "Total Surveys") {
                        $hclass = $rows_count;
                    } else if ($selectedColoumnHeadingRow == "Dialed Number") {
                        $hclass = $rows_count;
                    } else if ($selectedColoumnHeadingRow == "CLI") {
                        $hclass = $cli;
                    } else if ($selectedColoumnHeadingRow == "Tag") {
                        $hclass = $tag_name;
                    } else if ($selectedColoumnHeadingRow == "Campaign") {
                        $hclass = $camp_name;
                    }

                    //$selectedColoumnHeadingRow=trim($selectedColoumnHeadingRow);
                    ?>
                    <td style=' white-space: normal !important;' class='text-center'>
                        <?php echo $hclass; ?>
                    </td>
                <?php
                }
            }
            ?>
        </tr>
        <?php

        }
        }
        }
        }
        }

        ?>
    </table>
    </div>
    <br/>

    <!-- Modal -->
    <div id="myModal" class="modal sb nohf fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div style='width:150px;height:300px;margin-top:20%;' class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
                <div class="modal-body">
                    Please Wait...
                </div>
                <!-- .modal-body -->
            </div>
        </div>
    </div>
    <!--// Modal -->
<?php
//	var_debug($selectedColoumnHeading);
//var_debug($agentRecordData);
//exit();

}
/**
 * LIVE CHART REQUEST IF INTERVAL IS LIVE
 */
if (strtolower($report_interval) == 'live') {

    $liveChartDuration = LIVE_CHART_UPDATE_DURATION;

    $liveChartUpdate = site_url("reports/data_report_view/$report_id/liveRequest");
    ?>
    <script type="text/javascript">

        // update chart
        var ajax_call = function () {
            jQuery.ajax({
                type: "POST",
                url: '<?=$liveChartUpdate?>',
                async: true,
                success: function (data) {
                    if (data) {
                        var builderHtml = jQuery('.queryBuilderHtml');
                        builderHtml.html(data);
                        //jQuery('queryBuilderHtml').html(data);
                    }
                }
            });
        };

        var interval = 1000 * <?=$liveChartDuration?>; // where X is your every X minutes (1000 * Sec * Minute) i.e for second interval  (1000 * 1) => 1 sec for minutes interval  (1000 * 60 * 1) => 1 Minutes
        var refreshIntervalId = setInterval(ajax_call, interval);

    </script>
<?php


}

//remove set interval method global in this file b/c it will call on each time of back button hit
?>
<script type="text/javascript">
    function liveChartIntervalRemove() {
        // check interval id is define or not
        if (typeof countdown !== 'undefined') {
            clearInterval(countdown);
        }
    }


    var base_url_of_website = '<?php echo base_url(); ?>';

</script>


<script>
    $(function () {
        var audio = document.getElementById('audio');
        if (!audio) return false;
        $(".music_btn").on("click", function () {
            var data = $(this).attr("data-src");
            if (audio.paused) {
                //audio.currentTime = 0;
                $("#audio > source").attr("src", data);
                audio.load();
                audio.play();
                $(".music_btn").attr("src", base_url_of_website + "images/play.png");
                $(this).attr("src", base_url_of_website + "images/pause.png");

            }
            else {
                if (data == $("#audio > source").attr("src")) {
                    audio.pause();
                    $(this).attr("src", base_url_of_website + "images/play.png");

                }
                else {
                    audio.pause();
                    //audio.currentTime = 0;
                    $("#audio > source").attr("src", data);
                    audio.load();
                    audio.play();

                    $(".music_btn").attr("src", base_url_of_website + "images/play.png");
                    $(this).attr("src", base_url_of_website + "images/pause.png");


                }
            }

        });

    });

</script>

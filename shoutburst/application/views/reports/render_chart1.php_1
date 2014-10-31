<?php
if (isset($chartData) && !empty($chartData)){

        if ($report_type == 'Bar Chart'){
		
		     //   echo '<div id="graph"><i>Loading graph...</i></div>';
                $chartData = str_replace("'", '"', $chartData);


?>

<?php
$lefetch  = explode("],[",$chartData);
$cats = array();

foreach ($lefetch as $row) {
	$row = explode(",",$row);
	$row[0] = str_replace("]","",str_replace("[","",$row[0]));
	$row[1] = str_replace("]","",str_replace("[","",$row[1]));
	$cats[] = $row[0];
	$ydata[] = $row[1];
}

$cats = implode(",",$cats);
$ydata = implode(",",$ydata);

?>
<div id="container2" style="min-width: 275px; height: 250px; margin: 0 auto"></div>


<script type='text/javascript'>
$(function () {
        $('#container2').highcharts({
            chart: {
                type: 'column',
				options3d: {
					enabled: true,
					alpha: 5,
					beta: 15,
					depth: 50,
					viewDistance: 25
				}
            },
            title: {
                text: '<?php echo $graphTitle?>',
		style : { fontSize : 11 }


            },

            xAxis: {
				title: {
                    text: '<?php echo $X_Axis?>'
                },			
                categories: [<?=$cats?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $Y_Axis?>'
                }
            },
            plotOptions: {
                column: {
				depth:25
                }
            },
            series: [{
                name: 'Score',
                data: [<?=$ydata?>],
                color: '#993D3D'

            }]
        });
    });
</script>
    
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<!--

<script type="text/javascript">
        var myData = new Array(<?php echo $chartData?>);
        var colors = [<?php echo $colorThemes?>];
        var maxScore = <?php echo $maxScore?>;
        var myChart = new JSChart('graph', 'bar');

        var chartWidth          =       <?php echo $chartWidth?>;
        var chartHeight         =       <?php echo $chartHeight?>;

        var fullView            = '<?php echo $fullView; ?>';

        if(fullView=='full_view')
        {
                chartWidth = ($(window).width() - 17);  // returns height of browser window document
                chartHeight = ($(document).height() -16); // returns height of HTML document
        }

        myChart.setDataArray(myData);
        myChart.colorizeBars(colors);
        myChart.setTitle('<?php echo $graphTitle?>');
        myChart.setTitleFontFamily('Helvetica');
        myChart.setTitleFontSize(<?php echo $titleFontSize?>);
        myChart.setTitleColor('#53A1F4');
        myChart.setSize(chartWidth, chartHeight);
        myChart.setBackgroundColor('<?php echo $background_color?>');
        myChart.setAxisNameX('<?php echo $X_Axis?>');
        myChart.setAxisNameY('<?php echo $Y_Axis?>');
        myChart.setAxisValuesAngle(45);
        myChart.setTitleFontSize(<?php echo $fontSize?>);
        myChart.setBarSpacingRatio(50);
        myChart.setAxisPaddingTop(50);
		myChart.setAxisPaddingBottom(100);
    myChart.setAxisPaddingLeft(50);
    myChart.setAxisPaddingRight(60);
        myChart.setBarValues(false);
        myChart.setBarOpacity(1);
        myChart.setAxisWidth(1);
        if(maxScore!=0){
                myChart.setIntervalEndY(maxScore)
        }
        for(i=0;i<myData.length;i++)
        {
                myChart.setTooltip([myData[i][0],myData[i][1]]);
        }
        myChart.set3D(true);
        myChart.draw();
</script>

-->
<?php
        } elseif ($report_type == 'Line Graph'){
		
				        //echo '<div id="graph"><i>Loading graph...</i></div>';
		
?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>


<div id="container2" style="min-width: 275px; height: 250px; margin: 0 auto"></div>
<script type='text/javascript'>
<?php

/* {"Nadir":
	[
		["0",0],
		["Tuesday",15]
	]
} */

$lefetch  = json_decode ( $chartData, true );
$members = array_keys($lefetch);
$cats = array();

if (count($members) > 0) {
	foreach ($members as $member) {
		$member_obj = "name: '$member', data: [";
		$coords = $lefetch[$member];
		foreach ($coords as $point) {
			$x = $point[0];
			$y = $point[1];
			if (!($x == 0 && $y == 0)) {
			//$member_obj .=  "{name: '$x',y: $y},";
			$member_obj .= "['$x',$y],";
			$cats[] = "'$x'";
			}
		}
		$member_obj .= "]";
	}

	$cats = array_unique($cats);
	$cats = implode(",",$cats);
	
}


?>
$(function () {
        $('#container2').highcharts({
            title: {
                text: '<?php echo $graphTitle?>',
                x: -20, //center
		style : { fontSize : 11 }
            },
			xAxis: {
				min: 0,
				title: {
                    text: '<?php echo $X_Axis?>'
                },
                categories: [<?=$cats?>]
            },
            yAxis: {
                title: {
                    text: '<?php echo $Y_Axis?>'
                },
				min: 0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'points'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
<?=$member_obj?>
            }]
        });
    });
</script>

<!--
                <script type='text/javascript'>
                        var myColor                     = [<?php echo $colorThemes?>]
                        var     lineName                = [<?php echo $lineChartAgentName?>];
                        var areaName            = [<?php echo $lineChartAxisName?>];
                        var grapgTitle          = '<?php echo $graphTitle?>';
                        var agentLineData       = eval(<?php echo $chartData?>);

                        var chartWidth          =       <?php echo $chartWidth?>;
                        var chartHeight         =       <?php echo $chartHeight?>;

                        var fullView            = '<?php echo $fullView?>';

                        if(fullView=='full_view')
                        {
                                chartWidth = ($(window).width() - 17);  // returns height of browser window document
                                chartHeight = ($(document).height() - 16); // returns height of HTML document
                                //alert(chartWidth+' --------------- '+chartHeight);
                        }

                        var myData = new Array();

                        for(var i=0;i<lineName.length;){
                                var agentName = lineName[i];
                                var agentData = agentLineData[agentName];
                                myData[i]         = agentData;
                                i++;
                        }

                        var myChart = new JSChart('graph', 'line');

                        for(var i=0;i<lineName.length;)
                        {
                                myChart.setDataArray(myData[i], lineName[i]);
                                myChart.setLineColor(myColor[i], lineName[i]);

                                for(var j=0;j<myData[i].length;)
                                {
                                        var str  =      myData[i][j];
                                        if( areaName.length == 1 )
                                        {
                                                areaName[j]=areaName[0];
                                        }
                                        myChart.setTooltip([str[0], ' '+lineName[i]+' <?php echo $Y_Axis?> on '+areaName[j]+' is : '+ str[1],lineName[i]]);
                                        j++;
                                }
                                i++;
                        }
                        myChart.setLegendShow(true);
                        myChart.setTitleFontFamily('Helvetica');
                        myChart.setLegendFontSize(10);
                        myChart.setLegendPosition('right top');
                        myChart.setAxisNameX('<?php echo $X_Axis?>');
                        myChart.setAxisNameY('<?php echo $Y_Axis?>');
                        myChart.setBackgroundColor('<?php echo $background_color?>');
                        myChart.setSize(chartWidth, chartHeight);
                        myChart.setTitle(grapgTitle);
                        myChart.setTitleColor('#5555AA');
                        myChart.setTitleFontSize(<?php echo $fontSize?>);
                        myChart.setAxisValuesAngle(60);
                        myChart.setAxisPaddingTop(50);
                    myChart.setAxisPaddingBottom(110);
                    myChart.setAxisPaddingLeft(50);
                        myChart.draw();
						
				
						
                        </script>
	-->					
		
<?php
        } elseif ($report_type == 'Pie Chart'){
		        //echo '<div id="graph"><i>Loading graph...</i></div>';

?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>


<div id="container2" style="min-width: 275px; height: 250px; margin: 0 auto"></div>

<script type='text/javascript'>

$(function () {
    $('#container2').highcharts({
        chart: {
            type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
             text: '<?=$graphTitle?>',
		style : { fontSize : 11 }

        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '<?=$Y_Axis?>',
            data: [
					<?=$chartData?>
            ]
        }]
    });
});

</script>

<?php	
				
				
                $html = "
                <script type='text/javascript'>

                        var myData          = new Array($chartData);
                    var colors          = [$colorThemes];
                    var dataSize        =       myData.length;

                    var chartWidth              =       $chartWidth;
                        var chartHeight         =       $chartHeight;

                        var fullView            = '$fullView';
                        if(fullView=='full_view')
                        {
                                chartWidth = ($(window).width() - 17);  // returns height of browser window document
                                chartHeight = ($(document).height() - 16); // returns height of HTML document
                        }

                        var myChart = new JSChart('graph', 'pie');
                        myChart.setDataArray(myData);
                        myChart.colorize(colors);
                        myChart.setSize(chartWidth, chartHeight);
                        myChart.setTitle('$graphTitle');
                        myChart.setTitleColor('#53A1F4');
                        myChart.setTitleFontFamily('Helvetica');
                        myChart.setTitleFontSize($fontSize);
                        myChart.setBackgroundColor('$background_color');
                        myChart.setPieValuesColor('#FFFFFF');
                        myChart.setPieValuesFontSize(9);
                        myChart.setPiePosition($pie_x,$pie_y);
                        myChart.setShowXValues(true);
                        myChart.setShowYValues(true);

                        for(var i=0; i<dataSize ; i++){

                                var arrayElement = myData[i];
                                var colorCode    = colors[i];

                                var xAxis       = arrayElement[0];
                                var yAxis   = arrayElement[1];

                                var message = '$Y_Axis = '+yAxis+' found '+xAxis;
                                myChart.setLegend(colorCode, message);

                        }

                        myChart.setLegendShow(true);
                        myChart.setLegendFontFamily('Helvetica');
                        myChart.setLegendFontSize($legendFontSize);
                        myChart.setLegendPosition($pie_leg_pos_x, $pie_leg_pos_y);
                        myChart.setPieAngle(45);
                        myChart.setPieRadius($pieRadius);
                        myChart.set3D(true);
                        myChart.draw();
                </script>";

        //echo $html;
        }

} else {
        echo $errMessage;
}
?>


<style>
.highcharts-contextmenu div{
        font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif !important;
}
</style>

<script type="text/javascript" src="/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="/highcharts/js/highcharts-3d.js"></script>
<script type="text/javascript" src="/highcharts/js/modules/exporting.js"></script>

<!--  

	Dashboard graphs 
	
--> 

<?php
if (stripos($_SERVER['REQUEST_URI'],'wallboard') !== FALSE) {
	$graphTitle = "";
} 

if (isset($chartData) && !empty($chartData)){

        if ($report_type == 'Bar Chart'){
		
		     //   echo '<div id="graph"><i>Loading graph...</i></div>';
                $chartData = str_replace("'", '"', $chartData);
                $y_axis_midpoint		=		($y_axis_midpoint * 2);
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
if(strlen($graphTitle) > 40){
$graphTitle = substr($graphTitle, 0,40);
$graphTitle .= "[...]";
}
//echo $cats;

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
				},
                height: 220
            },

            credits: {
                enabled: false
            },
            
            title: {
                text: '<?php echo $graphTitle?>',
		        style : { fontSize : 11 }
            },

            xAxis: {
				title: {
                    text: '<?php echo $X_Axis?>'
                },			
                categories: [<?=$cats?>],
                labels:
                {
                    enabled: false
                }
            },
            yAxis: {
                min: 0,
                max: '<?php echo $y_axis_midpoint?>',
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
        			 colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a']
            }]
        });
    });
</script>

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
    $member_obj = "[";
    $m=1;
    foreach ($members as $member) {
        $member_obj = $member_obj .  "{ \"name\" : \"".$member."\" , \"data\" : [";
        $coords = $lefetch[$member];
        $l=1;
        foreach ($coords as $point) {
            $x = $point[0];
            $y = $point[1];
            if (!($x == 0 && $y == 0)) {
            //$member_obj .=  "{name: '$x',y: $y},";
            if($l==count($coords))
                $member_obj .= "[$y]";
            else
                $member_obj .= "[$y],";
            $cats[] = "\"".$x."\"";
            }
            $l++;
        }

        if($m == count($members))
            $member_obj .= "]}";
        else
            $member_obj .= "]},";
        $m++;
    }
    $member_obj .= "]";
    //print_r($member_obj);
    $cats = array_unique($cats);
    $cats = implode(",",$cats);
    
}

if(strlen($graphTitle) > 40){
$graphTitle = substr($graphTitle, 0,40);
$graphTitle .= "[...]";
}

?>
$(function () {
        $('#container2').highcharts({
            chart: {
                height: 220,
                type: 'line'
            },

            credits: {
                enabled: false
            },

            title: {
                text: '<?php echo $graphTitle?>',
                x: -20, //center
		        style : { fontSize : 11 }
            }

            ,
			xAxis: {
				min: 0,
				title: {
                    text: '<?php echo $X_Axis?>'
                },
                categories: [<?=$cats?>],
                labels: { enabled: false} 
            },
            yAxis: {
                title: {
                    text: '<?php echo $Y_Axis?>'
                },
				min: 0,
                max: '<?php echo $y_axis_midpoint?>',
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
            series: <?=$member_obj?>,
        		colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a']
        });
    });
</script>

<?php
        } elseif ($report_type == 'Pie Chart'){
		        //echo '<div id="graph"><i>Loading graph...</i></div>';
if(strlen($graphTitle) > 40){
$graphTitle = substr($graphTitle, 0,40);
$graphTitle .= "[...]";
}
?>

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
            },
            height: 220
            
        },

        credits: {
              enabled: false
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


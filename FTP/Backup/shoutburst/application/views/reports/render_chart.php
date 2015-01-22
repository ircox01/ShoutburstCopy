<script type="text/javascript" src="/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="/highcharts/js/highcharts-3d.js"></script>
<script type="text/javascript" src="/highcharts/js/modules/exporting.js"></script>
<?php
$dateRangeHtml = "";
if(!empty($dateRange)&&$dateRange!=null){
        $dateRangeHtml = $dateRange;
}

$report_period          =       ucwords($report_period);
$report_interval        =       ucwords($report_interval);
if (!empty($y_axis_midpoint)) {
$y_axis_midpoint		=		($y_axis_midpoint * 2);
} else {
	$y_axis_midpoint	= '20';
}
//get commong button which will display on reporting
//$commonButtons			    = commonButtons();

$html = <<<HTML
<style>
#graph img {
	display:none;
	visibility:hidden
}
body{
	height: 85% !important;
}
.mainDiv{font-weight:bold; color:#A3CEED;padding:20px;}
.childDiv{padding:4px;}
.childDivContent{color:#53A1F4;}
.highcharts-contextmenu div{
	font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif !important;
}
</style>
HTML;
 if (stripos($_SERVER['REQUEST_URI'] ,'wallboard') !== FALSE) {
	$graphTitle = "";
	$wallboard = true;
} else {
	$wallboard = false;
}
if(!empty($logo))
{
	if (stripos($_SERVER['REQUEST_URI'] ,'wallboard') !== FALSE) {
		$logo_path = "";
		$graphTitle = "";
		$wallboard = true;
	} else {
		$logo_path = "<img src='$logo' width=\"200\" height=\"57\" class=\"shadow\" style=\"position: absolute; top: 15px; right: 15px;z-index:999;\">";
		$wallboard = false;
	}

        $html .= $logo_path;



}else
{
        $logo = base_url().COMP_LOGO."/temp_logo.png";

	if (stripos($_SERVER['REQUEST_URI'] ,'wallboard') !== FALSE) {
		$logo_path = "";
	} else {
		$logo_path = "<img src='$logo' width=\"200\" height=\"57\" class=\"shadow\" style=\"position: absolute; top: 15px; right: 15px;z-index:999;\">";
	
	}

	$html .= $logo_path;
}
$html .=<<<HTML
<!-- <div class='report-preview' style='font-family: "Museo Sans 500", Arial, Helvetica, sans-serif'>
        <div class='row'>
			    <div class='col-sm-2 col-field'>Report Name: $report_name </div>
        </div>
        <div class='row'>
			    <div class='col-sm-2 col-field'>Report Date: $report_date </div>
        </div>
        <div class='row'>
			    <div class='col-sm-2 col-field'>Report Period: $report_period</div>
        </div>

HTML;
if($report_type!="Pie Chart")
{
		$html .=<<<HTML
		<div class='row'>
		<div class='col-sm-2 col-field'>Report Interval: $report_interval</div>
		</div>
HTML;
}

$html .=<<<HTML
	<div class='row'>
	<div class='col-sm-2 col-field'>Date Filter: $dateRangeHtml</div>
	</div>

</div> -->

HTML;
echo $html;
if (isset($chartData) && !empty($chartData)){

	if ($report_type == 'Bar Chart') {
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
<?php
	if ($wallboard) {
?>
<div id="container2" style="min-width: 550px; height: 510px; margin: 0 auto; margin-top:80px;"></div>
<?php
}
?>
<?php
	if (!$wallboard) {
?>
<div id="container2" style="min-width: 500px; height: 610px; margin: 0 auto; margin-top:80px;"></div>
<?php
}
?>
<script type='text/javascript'>
$(function () {
        $('#container2').highcharts({
			chart: {
			    type: 'column',
			    
				options3d: {
					enabled: true,
					alpha: 5,
					beta: 15,
					depth: 300,
					viewDistance: 35
				},
				width:($(window).width()-90),
				height:($(document).height()-310),
				marginLeft:10
			},
			
			credits: {
			    enabled: false
			},

			legend: {
			    enabled: false
			},

			
			title: {
			    text: '<?php echo $graphTitle?>'
			},
				
				
				subtitle: {
							text: '.',					    
					   // text: '<?=$report_name?> (<?=$report_date?>), Period: <?=$report_period?>, Interval : <?=$report_interval?>',
					    marginLeft: '400px'
         	},
	
				labels: {
					items: {					    
					    html: '<?=$report_name?> (<?=$report_date?>), Period: <?=$report_period?>, Interval : <?=$report_interval?>',
					    style:{ left: '40px', top:'50px'}
					}		
         	},
          
			xAxis: {
			
				title: {
			        text: '<?php echo $X_Axis?>'
			    },			

			    categories: [<?=$cats?>],
			    labels: { enabled: false} 

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
			    data: [<?=$ydata?>]
			}],
			colors: ['#0d233a', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a','#2f7ed8'],
        });
    });
</script>

<?php
        } elseif ($report_type == 'Line Graph'){
?>
<?php

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
?>

<div id="container2" style="min-width: 500px; height: 500px; margin: 0 auto;margin-top:80px;"></div>

<script type='text/javascript'>

$(function () {
        $('#container2').highcharts({
          chart: {
			type: 'line',
       
			    width:($(window).width()-90),
			    height:($(document).height()-310),           
        },
			
			title: {
			    text: '<?php echo $graphTitle?>',
			    x: -20 //center
			},
        
        credits: {
			  enabled: false
        },
<?php
        if (!$wallboard) {
?>
			    subtitle: {
			    text: '<?=$report_name?> (<?=$report_date?>), Period: <?=$report_period?>, Interval : <?=$report_interval?>'
         },
<?php
}
?>
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
         //   colors: ['#727272', '#f1595f', '#79c36a', '#599ad3', '#f9a65a', '#9e66ab', '#cd7058', '#d77fb3', '#c42525', '#a6c96a']
			
        });
    });
</script>

<?php
        } elseif ($report_type == 'Pie Chart'){

			    $html = "
			    <script type='text/javascript'>

						var myData          = new Array($chartData);
			        var colors          = [$colorThemes];
			        var dataSize        =       myData.length;

			        var chartWidth			  =       $chartWidth;
						var chartHeight         =       $chartHeight;

						var fullView			= '$fullView';
						if(fullView=='full_view')
						{
						        chartWidth = ($(window).width() - 17);  // returns height of browser window document
						        chartHeight = ($(document).height() - 16); // returns height of HTML document
						}

						var myChart = new JSChart('graph', 'pie');
						myChart.setDataArray(myData);
						myChart.colorize(colors);
						myChart.setSize(chartWidth-100, chartHeight-100);
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
?>
<?php
        if (!$wallboard) {
?>
<div id="container2" style="min-width: 900px; height: 510px; margin: 0 auto;margin-top:70px;"></div>
<?php
}
?>

<?php
        if ($wallboard) {
?>
<div id="container2" style="min-width: 200px; height: 610px; margin: 0 auto;margin-top:0px;"></div>
<?php
}
?>
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
			    width:($(window).width()-90),
			    height:($(document).height()-210),
        },
        title: {
			 text: '<?=$graphTitle?>'
        },
        
        credits: {
			  enabled: false
        },
<?php
        if (!$wallboard) {
?>
			    subtitle: {
			    text: '<?=$report_name?> (<?=$report_date?>), Period: <?=$report_period?>'
         },
<?php
}
?>
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
		
        }

} else {
        echo $errMessage;
}
?>

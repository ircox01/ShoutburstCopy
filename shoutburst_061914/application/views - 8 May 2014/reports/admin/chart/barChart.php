<?php
$html = <<<HTML
		<script type="text/javascript">
		
		jQuery(document).ready(function() {
			var myData = new Array($chartData);
			var colors = [$colorThemes];
			var maxScore = $maxScore;
			var myChart = new JSChart('graph', 'bar');
			myChart.setDataArray(myData);
			myChart.colorizeBars(colors);
			myChart.setTitle('$graphTitle');
			myChart.setTitleFontFamily('Helvetica');
			myChart.setTitleFontSize(25);
			myChart.setTitleColor('#53A1F4');
			myChart.setSize($chartWidth, $chartHeight);
			myChart.setBackgroundColor('$background_color');
			myChart.setAxisNameX('$X_Axis');
			myChart.setAxisNameY('$Y_Axis');
			myChart.setAxisValuesAngle(45);
			myChart.setTitleFontSize(10);
			myChart.setBarSpacingRatio(50);
			myChart.setAxisPaddingTop(50);
		    myChart.setAxisPaddingBottom(100);
		    myChart.setAxisPaddingLeft(60);
		    myChart.setAxisPaddingRight(60);
			myChart.setBarValues(false);
			myChart.setBarOpacity(1);
			myChart.setAxisWidth(1);
			if(maxScore!=0){
				myChart.setIntervalEndY(maxScore)
			}
			myChart.set3D(true);
			myChart.draw();
			//set graph title
	//		jQuery('#graph').prepend("<div style='color:grey;'></div>");
		});
		</script>
HTML;

echo $html;
?>
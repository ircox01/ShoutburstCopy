<?php 
$html = <<<HTML
		<script type="text/javascript">
		
		jQuery(document).ready(function() {
		
		    var myData	    = new Array($chartData);
		    var colors 		= [$colorThemes];
		    var dataSize	=	myData.length;
		  
			var myChart = new JSChart('graph', 'pie');
			myChart.setDataArray(myData);
			myChart.colorize(colors);
			myChart.setSize($chartWidth, $chartHeight);
			myChart.setTitle('$graphTitle');
			myChart.setTitleColor('#53A1F4');
			myChart.setTitleFontFamily('Helvetica');
			myChart.setTitleFontSize(14);
			myChart.setBackgroundColor('$background_color');
			myChart.setPieRadius(95);
			myChart.setPieValuesColor('#FFFFFF');
			myChart.setPieValuesFontSize(9);
			myChart.setPiePosition(180, 165);
			myChart.setShowXValues(true);
			myChart.setShowYValues(true);
			
			for(var i=0; i<dataSize ; i++){
				
				var arrayElement = myData[i];
				var colorCode    = colors[i];
				
				var xAxis	= arrayElement[0];
				var yAxis   = arrayElement[1];
				
				var message = '$Y_Axis = '+yAxis+' found '+xAxis;
				myChart.setLegend(colorCode, message);
				
			}
			
			myChart.setLegendShow(true);
			myChart.setLegendFontFamily('Helvetica');
			myChart.setLegendFontSize(10);
			myChart.setLegendPosition(350, 120);
			myChart.setPieAngle(45);
			myChart.setPieRadius(85);
			myChart.set3D(true);
			myChart.draw();
			
		});
		</script>

HTML;

echo $html;
?>
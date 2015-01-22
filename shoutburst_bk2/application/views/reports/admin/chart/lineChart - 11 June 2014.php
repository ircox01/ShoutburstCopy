<?php
$html = <<<HTML
		<script type="text/javascript">		
		jQuery(document).ready(function() {		
		
			var myColor			= [$colorThemes]
			var	lineName 		= [$lineChartAgentName];
			var areaName		= [$lineChartAxisName];
			var grapgTitle		= '$graphTitle';
			var agentLineData 	= eval($chartData);
			
			var myData = new Array();
			
			for(var i=0;i<lineName.length;){
				var agentName = lineName[i];
				var agentData = agentLineData[agentName];				
				myData[i] 	  = agentData;
				i++;
			}
			
			var myChart = new JSChart('graph', 'line');
		
			for(var i=0;i<lineName.length;){
				myChart.setDataArray(myData[i], lineName[i]);
				myChart.setLineColor(myColor[i], lineName[i]);
		
				for(var j=0;j<myData[i].length;){
					var str	 =	myData[i][j]; 
					myChart.setTooltip([str[0], ' '+lineName[i]+ ' $Y_Axis in ' +areaName[j]+' is : '+ str[1],lineName[i]]);
					j++;
				}
				i++;				
			}
			myChart.setLegendShow(true);
			myChart.setLegendFontFamily('Helvetica');
			myChart.setLegendFontSize(10);
			myChart.setLegendPosition('right top');
			myChart.setAxisNameX('$X_Axis');
			myChart.setAxisNameY('$Y_Axis');
			myChart.setBackgroundColor('$background_color');
			myChart.setSize($chartWidth, $chartHeight);
			myChart.setTitle(grapgTitle);
			myChart.setTitleColor('#5555AA');
			myChart.setTitleFontFamily('Helvetica');
			myChart.setTitleFontSize(10);
			myChart.setAxisValuesAngle(60);
			myChart.setAxisPaddingTop(50);
		    myChart.setAxisPaddingBottom(110);
		    myChart.setAxisPaddingLeft(60);
			myChart.draw();				
		});		
		</script>
HTML;

echo $html;
?>
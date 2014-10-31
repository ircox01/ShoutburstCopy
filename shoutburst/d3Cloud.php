<?php
ini_set("display_errors",1);
if (isset($_GET['text'])) {
  $text = base64_decode($_GET['text']);
} else {
  return;
}
$has_logo = false;
if (isset($_GET['logo'])) {
  $logo = $_GET['logo'];
  if ($logo != "") {
    $has_logo = true;
  }
}
$chart_title = "";
if (isset($_GET['title']) && !empty($_GET['title'])) {
  $chart_title = $_GET['title'];
}
else{
  $chart_title = "No title found";
}


//print_r($text);



$text = str_replace(","," ",$text);
$text = str_replace("\r"," ",$text);
$text = str_replace("\n"," ",$text);
$text = str_replace(".","",$text);

$words = explode(" ",$text);


$list = array();

if (count($words) > 0) {
    foreach ($words as $word) {
        if (trim($word) != "") {
            $list[] = strtolower(trim($word));
        }
    }
}

$freq = array_count_values($list);
//echo "<br><br>";


arsort($list);
//echo "<br><br>";

//print_r($list);
    
$i=1;
$WordData= "[";
foreach($freq as $key=>$value) {
  $WordData.="{\"valuee\": \"$key\",\"weight\": $value}";
  if($i != count($freq)){
    $WordData  .= ",";
  }
  $i++;
}
$WordData .= "]";

if(strlen($chart_title)>40){
  $chart_title = substr($chart_title,0,40);
  $chart_title .= "[...]";
}

?>
<!DOCTYPE html>
<meta charset="utf-8">
<head>
<script src="js/d3.js"></script>
<script src="js/d3.layout.cloud.js"></script>
<style>
body{
  width: 500px;
  height: 200px;
}
.title_comp{
  font-size: 11px;
  font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;
  padding-left: 10%;
  text-align: center;
  
}
.logo_comp{
  width: 40%;
  float: left;

}
.logo_comp img{
  width: 100px;
  height: 100px;
  display: block;
  margin: 0 auto;
}
.svg_cloud{
  padding-top: 10px;
  display: block;
  margin: 0 auto;

}
</style>
</head>
<body>

<div>
<div class="title_comp">
<?php echo $chart_title; ?>
</div>


</div>
<script>
  var fill = d3.scale.category20();
  var nonaa =<?php echo $WordData; ?>;
      console.log(nonaa);
  d3.layout.cloud().size([300, 200])
      .words(nonaa.map(function(d) {
        return {text: d.valuee, size: (d.weight*2) +5 };
      }))
      .padding(5)
      .rotate(function() { return ~~(Math.random() * 2) * 90; })
      .font("Impact")
      .fontSize(function(d) { return d.size; })
      .on("end", draw)
      .start();

  function draw(words) {
    d3.select("body").append("svg")
        .attr("width", 300)
        .attr("height", 200)
        .attr("class","svg_cloud")
        .attr("id","cloud")
      .append("g")
        .attr("transform", "translate(150,100)")
      .selectAll("text")
        .data(words)
      .enter().append("text")
        .style("font-size", function(d) { return d.size + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return fill(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {
          return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });
  }


  
</script>

</body>
</html>

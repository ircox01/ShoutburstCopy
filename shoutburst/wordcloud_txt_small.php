<?php
//ini_set("display_errors",1);
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
if (isset($_GET['title'])) {
	$chart_title = $_GET['title'];
}

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
arsort($freq);


$numelems = count($freq);
$words = array_keys($freq);

if($freq[$words[0]] < 10) {
		$adjust = 5;
} else {
		$adjust = 0;
}

$first_elem = ($freq[$words[0]] + $adjust)." ".$words[0];

$pusher = "";
for ($i=1;$i < $numelems;$i++) {
		$pusher .= "list.push('".($freq[$words[$i]] + $adjust)." ".$words[$i]."');";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Wordcloud</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="http://netdna.bootstrapcdn.com/bootstrap/2.2.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://netdna.bootstrapcdn.com/bootstrap/2.2.2/css/bootstrap-responsive.min.css" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Finger+Paint" id="link-webfont" rel="stylesheet">
  <style>
  *[hidden] {
    display: none;
  }

  #canvas-container {
    /*overflow-x: auto;
    overflow-y: visible;
    position: relative;
    margin-top: 0px;
    margin-bottom: 0px;
 */
	float:none;
	width: 300px;
	margin: auto;

  }
  .canvas {
    display: block;
    position: relative;
    overflow: hidden;
  }

  .canvas.hide {
    display: none;
  }

  #html-canvas > span {
    transition: text-shadow 1s ease, opacity 1s ease;
    -webkit-transition: text-shadow 1s ease, opacity 1s ease;
    -ms-transition: text-shadow 1s ease, opacity 1s ease;
  }

  #html-canvas > span:hover {
    text-shadow: 0 0 10px, 0 0 10px #fff, 0 0 10px #fff, 0 0 10px #fff;
    opacity: 0.5;
  }

  #box {
    pointer-events: none;
    position: absolute;
    box-shadow: 0 0 200px 200px rgba(255, 255, 255, 0.5);
    border-radius: 50px;
    cursor: pointer;
  }

  textarea {
    height: 20em;
  }
  #config-option {
    font-family: monospace;
  }
  select { width: 100%; }

  #loading {
    animation: blink 2s infinite;
    -webkit-animation: blink 2s infinite;
  }
  @-webkit-keyframes blink {
    0% { opacity: 1; }
    100% { opacity: 0; }
  }
  @keyframes blink {
    0% { opacity: 1; }
    100% { opacity: 0; }
  }

  </style>
  <script type="text/javascript">
    if (window.location.hostname === 'timdream.org') {
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-4623408-2']);
      _gaq.push(['_trackPageview']);
    }

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</head>
<body>
  <div class="container">
  <?php
  if ($has_logo) {
  ?>
	<span style='float:right;'><img src='company_logo/<?=$logo?>' /></span>
	<?php
	
	}
	?>
    <div id="not-supported" class="alert" hidden>
      <strong>Your browser is not supported.</strong>
    </div>
    <form id="form" method="get" action="" style='text-align:center;'>
      <div class="row" style="margin-left:50px;margin-right:50px;">
	<span style='font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;font-size:11px;'><?=$chart_title?></span>
        <div class="span12" id="canvas-container">
          <canvas id="canvas" class="canvas"></canvas>
          <div id="html-canvas" class="canvas hide"></div>
        </div>

        <span style='visibility:hidden;'>
        <div class="span6">
          <button class="btn btn-primary" type="submit">Run</button>
          <span id="loading" hidden>......</span>
        </div>
      </div>
      <div class="tabbable" style='height:0px;width:0px'>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-list">
            <textarea id="input-list" placeholder="Put your list here." rows="2" cols="30" class="span12"></textarea>
          </div>
          <div class="tab-pane" id="tab-config">
            <label>Options as a literal Javascript object</label>
            <textarea id="config-option" placeholder="Put your literal option object here." rows="2" cols="30" class="span12"></textarea>
            <!--
            XXX Security consideration:
              Do not implement a feature that allow users to submit/share their script here
              directly or indirectly. Doing so would invite XSS attack on your site.
            -->
            <span class="help-block">See <a href="https://github.com/timdream/wordcloud2.js/blob/master/API.md">API</a> document for available options.</span>
          </div>
          <div class="tab-pane" id="tab-dim">
            <label for="config-width">Width</label>
            <div class="input-append">
              <input type="number" id="config-width" class="input-small" min="1">
              <span class="add-on">px</span>
            </div>
            <span class="help-block">Leave blank to use page width.</span>
            <label for="config-height">Height</label>
            <div class="input-append">
              <input type="number" id="config-height" class="input-small" min="1">
              <span class="add-on">px</span>
            </div>
            <span class="help-block">Leave blank to use 0.65x of the width.</span>
            <label for="config-height">Device pixel density (<span title="Dots per 'px' unit">dppx</span>)</label>
            <div class="input-append">
              <input type="number" id="config-dppx" class="input-mini" min="1" value="1" required>
              <span class="add-on">x</span>
            </div>
            <span class="help-block">Adjust the weight, grid size, and canvas pixel size for high pixel density displays.</span>
          </div>
          <div class="tab-pane" id="tab-webfont">
            <label for="config-css">Extra Web Font CSS</label>
            <input type="url" id="config-css" size="40" class="input-xxlarge" placeholder="https://fonts.googleapis.com/css?family=Libre+Baskerville:700" value="https://fonts.googleapis.com/css?family=Finger+Paint">
            <span class="help-block">Find your favorite font on <a href="https://www.google.com/webfonts">Google Web Fonts</a>. Re-run if the font didn't load in time.</span>
         </div>
        </div>
      </div>
          </span>
    </form>
  </div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.2.2/bootstrap.min.js"></script>
  <script src="./js/wordcloud2.js"></script>
  <script>
  'use strict';

  jQuery(function ($) {
    var $form = $('#form');
    var $canvas = $('#canvas');
    var $htmlCanvas = $('#html-canvas');
    var $canvasContainer = $('#canvas-container');
    var $loading = $('#loading');

    var $list = $('#input-list');
    var $options = $('#config-option');
    var $width = $('#config-width');
    var $height = $('#config-height');
    var $dppx = $('#config-dppx');
    var $css = $('#config-css');
    var $webfontLink = $('#link-webfont');

    if (!WordCloud.isSupported) {
      $('#not-supported').prop('hidden', false);
      $form.find('textarea, input, select, button').prop('disabled', true);
      return;
    }

    var $box = $('<div id="box" hidden />');
    $canvasContainer.append($box);
    window.drawBox = function drawBox(item, dimension) {
      if (!dimension) {
        $box.prop('hidden', true);

        return;
      }

      var dppx = $dppx.val();

      $box.prop('hidden', false);
      $box.css({
        left: dimension.x / dppx + 'px',
        top: dimension.y / dppx + 'px',
        width: dimension.w / dppx + 'px',
        height: dimension.h / dppx + 'px'
      });
    };

    // Update the default value if we are running in a hdppx device
    if (('devicePixelRatio' in window) &&
        window.devicePixelRatio !== 1) {
      $dppx.val(window.devicePixelRatio);
    }

    $canvas.on('wordcloudstop', function wordcloudstopped(evt) {
      $loading.prop('hidden', true);
    });

    $form.on('submit', function formSubmit(evt) {
      evt.preventDefault();

      changeHash('');
    });

    $('#btn-save').on('click', function save(evt) {
      var url = $canvas[0].toDataURL();
      if ('download' in document.createElement('a')) {
        this.href = url;
      } else {
        evt.preventDefault();
        alert('Please right click and choose "Save As..." to save the generated image.');
        window.open(url, '_blank', 'width=500,height=300,menubar=yes');
      }
    });

    $('#btn-canvas').on('click', function showCanvas(evt) {
      $canvas.removeClass('hide');
      $htmlCanvas.addClass('hide');
      $('#btn-canvas').prop('disabled', true);
      $('#btn-html-canvas').prop('disabled', false);
    });

    $('#btn-html-canvas').on('click', function showCanvas(evt) {
      $canvas.addClass('hide');
      $htmlCanvas.removeClass('hide');
      $('#btn-canvas').prop('disabled', false);
      $('#btn-html-canvas').prop('disabled', true);
    });

    $('#btn-canvas').prop('disabled', true);
    $('#btn-html-canvas').prop('disabled', false);

    var $examples = $('#examples');
    $examples.on('change', function loadExample(evt) {
      changeHash(this.value);

      this.selectedIndex = 0;
      $examples.blur();
    });

    var run = function run() {
      $loading.prop('hidden', false);

      // Load web font
      $webfontLink.prop('href', $css.val());

      // devicePixelRatio
      var devicePixelRatio = parseFloat($dppx.val());

      // Set the width and height
//      var width = $width.val() ? $width.val() : $('#canvas-container').width();
//      var height = $height.val() ? $height.val() : Math.floor(width * 0.65);

      var width = 300;
      var height = 175;


          var pixelWidth = width;
      var pixelHeight = height;

      if (devicePixelRatio !== 1) {
        $canvas.css({'width': width + 'px', 'height': height + 'px'});

        pixelWidth *= devicePixelRatio;
        pixelHeight *= devicePixelRatio;
      } else {
        $canvas.css({'width': '', 'height': '' });
      }

      $canvas.attr('width', pixelWidth);
      $canvas.attr('height', pixelHeight);

      $htmlCanvas.css({'width': pixelWidth + 'px', 'height': pixelHeight + 'px'});

      // Set the options object
      var options = {};
      if ($options.val()) {
        options = (function evalOptions() {
          try {
            return eval('(' + $options.val() + ')');
          } catch (error) {
            alert('The following Javascript error occurred in the option definition; all option will be ignored: \n\n' +
              error.toString());
            return {};
          }
        })();
      }

      // Set devicePixelRatio options
      if (devicePixelRatio !== 1) {
        if (!('gridSize' in options)) {
          options.gridSize = 8;
        }
        options.gridSize *= devicePixelRatio;

        if (options.origin) {
          if (typeof options.origin[0] == 'number')
            options.origin[0] *= devicePixelRatio;
          if (typeof options.origin[1] == 'number')
            options.origin[1] *= devicePixelRatio;
        }

        if (!('weightFactor' in options)) {
          options.weightFactor = 1;
        }
        if (typeof options.weightFactor == 'function') {
          var origWeightFactor = options.weightFactor;
          options.weightFactor =
            function weightFactorDevicePixelRatioWrap() {
              return origWeightFactor.apply(this, arguments) * devicePixelRatio;
            };
        } else {
          options.weightFactor *= devicePixelRatio;
        }
      }

      // Put the word list into options
      if ($list.val()) {
        var list = [];
        $.each($list.val().split('\n'), function each(i, line) {
          if (!$.trim(line))
            return;

          var lineArr = line.split(' ');
          var count = parseFloat(lineArr.shift()) || 0;
          list.push([lineArr.join(' '), count]);
        });
        options.list = list;
      }

      // All set, call the WordCloud()
      // Order matters here because the HTML canvas might by
      // set to display: none.
      WordCloud([$canvas[0], $htmlCanvas[0]], options);
    };

    var loadExampleData = function loadExampleData(name) {
      var example = examples[name];

      $options.val(example.option || '');
      $list.val(example.list || '');
      $css.val(example.fontCSS || '');
      $width.val(example.width || '');
      $height.val(example.height || '');
    };

    var changeHash = function changeHash(name) {
      if (window.location.hash === '#' + name ||
          (!window.location.hash && !name)) {
        // We got a same hash, call hashChanged() directly
        hashChanged();
      } else {
        // Actually change the hash to invoke hashChanged()
        window.location.hash = '#' + name;
      }
    };

    var hashChanged = function hashChanged() {
      var name = window.location.hash.substr(1);
      if (!name) {
        // If there is no name, run as-is.
        run();
      } else if (name in examples) {
        // If the name matches one of the example, load it and run it
        loadExampleData(name);
        run();
      } else {
        // If the name doesn't match, reset it.
        window.location.replace('#');
      }
    }

    $(window).on('hashchange', hashChanged);

    if (!window.location.hash ||
      !(window.location.hash.substr(1) in examples)) {
      window.location.replace('#loader');
    } else {
      hashChanged();
    }
  });

  var examples = {
    'loader' : {
      list: (function generateLoaderList() {
        var list = ['<?=$first_elem?>'];
                <?=$pusher?>
        return list.join('\n');
      })(),
      option: '{\n' +
        '  gridSize: Math.round(16 * $(\'#canvas\').width() / 1024),\n' +
        '  weightFactor: function (size) {\n' +
        '    return Math.pow(size, 2.3) * $(\'#canvas\').width() / 1024;\n' +
        '  },\n' +
        '  fontFamily: \'Times, serif\',\n' +
        '  color: function (word, weight) {\n' +
        '    return (weight === 12) ? \'#c09292\' : \'#c09292\';\n' +
        '  },\n' +
        '  rotateRatio: 0.5,\n' +
        '  backgroundColor: \'#ffffff\'\n' +
        '}',
    }
  };
  </script>
</body>
</html>

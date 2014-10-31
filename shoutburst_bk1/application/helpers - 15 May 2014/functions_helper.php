<?php
function var_debug($arr, $return=false) {
    if ($return == false) {
        echo '<pre>';
        print_r($arr, $return);
        echo '</pre>';
    } else {
        $var = '<pre>';
        $var.=print_r($arr, $return);
        $var.= '</pre>';
        return $var;
    }
}

/*
 * @author:	Muhammad Sajid
 * @name:	generate_url_slug
 */
function generate_url_slug($str)
{
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_| -]+/", '-', $clean);

    return $clean;
}

/*
 * @author:	Muhammad Sajid
 * @name:	full_txt
 */
function full_txt($val){

	switch ($val){
		case 'f':
			echo 'Female';
		break;
		
		case 'm':
			echo 'Male';
		break;
		
		case 'hp':
			echo 'Highly Positive';
		break;
		
		case 'p':
			echo 'Positive';
		break;
		
		case 'n':
			echo 'Neutral';
		break;
		
		case 'neg':
			echo 'Negative';
		break;
		
		case 'hn':
			echo 'Highly Negative';
		break;
		
		case 'mpn':
			echo 'Mixed Positive/Negative';
		break;
		
		default:
			echo '-';
		break;
	}
}

/*
 * @author:	M.Sajid
 * @name:	transcribe_js
 */
function transcribe_js($return = false) {

	$script = '<style type="text/css" title="currentStyle">
                @import "' . base_url() . 'skin/circle.skin/circle.player.css";
                </style>
                    
                <script type="text/javascript" language="javascript" src="' . base_url() . 'skin/js/jquery.jplayer.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="' . base_url() . 'skin/js/jquery.transform2d.js"></script>
                <script type="text/javascript" charset="utf-8" src="' . base_url() . 'skin/js/jquery.grab.js"></script>
				<script type="text/javascript" charset="utf-8" src="' . base_url() . 'skin/js/mod.csstransforms.min.js"></script>
				<script type="text/javascript" charset="utf-8" src="' . base_url() . 'skin/js/circle.player.js"></script>';
	
    if ($return == false) {
        echo $script;
    } else {
        return $script;
    }
}
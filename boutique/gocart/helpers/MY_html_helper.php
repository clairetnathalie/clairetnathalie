<?php

function load_jquery($front = false) {
	
	//jquery & jquery ui files & path
	$path = 'js/jquery';
	
	$jquery = 'jquery-1.5.1.min.js';
	$jquery_ui = 'jquery-ui-1.8.11.custom.min.js';
	$jquery_ui_css = 'jquery-ui-1.8.11.custom.css';
	
	//load jquery ui css
	

	if ($front) {
		echo link_tag ( $path . '/' . $front . '/' . $jquery_ui_css );
	} else {
		echo link_tag ( $path . 'gocart/' . $jquery_ui_css );
	}
	//load scripts
	echo load_script ( $path . '/' . $jquery );
	echo load_script ( $path . '/' . $jquery_ui );
	
	//colorbox
	$path = $path . '/colorbox';
	$colorbox = 'jquery.colorbox-min.js';
	$colorbox_css = 'colorbox.css';
	
	echo link_tag ( $path . '/' . $colorbox_css );
	echo load_script ( $path . '/' . $colorbox );
}

function load_script($path) {
	return '<script type="text/javascript" src="/' . $path . '"></script>';
}

function html_helper_tag_manager() {
	$tags = "<!-- Google Tag Manager -->";
	$tags .= '<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-BD6F"';
	$tags .= 'height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
	$tags .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':";
	$tags .= "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],";
	$tags .= "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=";
	$tags .= "'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);";
	$tags .= "})(window,document,'script','dataLayer','GTM-BD6F');</script>";
	$tags .= "<!-- End Google Tag Manager -->";
	return $tags;
}

/**
 * Convert an array into a stdClass()
 * 
 * @param   array   $array  The array we want to convert
 * 
 * @return  object
 */
function arrayToObject($array) {
	// First we convert the array to a json string
	$json = json_encode ( $array );
	
	// The we convert the json string to a stdClass()
	$object = json_decode ( $json );
	
	return $object;
}

/**
 * Convert a object to an array
 * 
 * @param   object  $object The object we want to convert
 * 
 * @return  array
 */
function objectToArray($object) {
	// First we convert the object into a json string
	$json = json_encode ( $object );
	
	// Then we convert the json string to an array
	$array = json_decode ( $json, true );
	
	return $array;
}

function preg_replace_skip($pattern, $replace, $subject, $skip = 0) {
	return preg_replace_callback ( $pattern, create_function ( '$m', 'static$s;$s++;return($s<=' . $skip . ')?$m[0]:"' . $replace . '";' ), $subject );
} // end preg_replace_skip 


function print_r_html($arr) {
	?><pre><?
	print_r ( $arr );
	?></pre><?
}

function deleteDir($dirPath) {
	if (! is_dir ( $dirPath )) {
		throw new InvalidArgumentException ( "$dirPath must be a directory" );
	}
	if (substr ( $dirPath, strlen ( $dirPath ) - 1, 1 ) != '/') {
		$dirPath .= '/';
	}
	$files = glob ( $dirPath . '*', GLOB_MARK );
	foreach ( $files as $file ) {
		if (is_dir ( $file )) {
			//self::deleteDir($file);
			deleteDir ( $file );
		} else {
			unlink ( $file );
		}
	}
	rmdir ( $dirPath );
}

function resize_image_centered($source_image, $destination_width, $destination_height, $type = 0) {
	// $type (1=crop to fit, 2=letterbox)
	$source_width = imagesx ( $source_image );
	$source_height = imagesy ( $source_image );
	$source_ratio = $source_width / $source_height;
	$destination_ratio = $destination_width / $destination_height;
	if ($type == 1) {
		// crop to fit
		if ($source_ratio > $destination_ratio) {
			// source has a wider ratio
			$temp_width = ( int ) ($source_height * $destination_ratio);
			$temp_height = $source_height;
			$source_x = ( int ) (($source_width - $temp_width) / 2);
			$source_y = 0;
		} else {
			// source has a taller ratio
			$temp_width = $source_width;
			$temp_height = ( int ) ($source_width / $destination_ratio);
			$source_x = 0;
			$source_y = ( int ) (($source_height - $temp_height) / 2);
		}
		$destination_x = 0;
		$destination_y = 0;
		$source_width = $temp_width;
		$source_height = $temp_height;
		$new_destination_width = $destination_width;
		$new_destination_height = $destination_height;
	} else {
		// letterbox
		if ($source_ratio < $destination_ratio) {
			// source has a taller ratio
			$temp_width = ( int ) ($destination_height * $source_ratio);
			$temp_height = $destination_height;
			$destination_x = ( int ) (($destination_width - $temp_width) / 2);
			$destination_y = 0;
		} else {
			// source has a wider ratio
			$temp_width = $destination_width;
			$temp_height = ( int ) ($destination_width / $source_ratio);
			$destination_x = 0;
			$destination_y = ( int ) (($destination_height - $temp_height) / 2);
		}
		$source_x = 0;
		$source_y = 0;
		$new_destination_width = $temp_width;
		$new_destination_height = $temp_height;
	}
	$destination_image = imagecreatetruecolor ( $destination_width, $destination_height );
	if ($type > 1) {
		imagefill ( $destination_image, 0, 0, imagecolorallocate ( $destination_image, 255, 255, 255 ) );
	}
	imagecopyresampled ( $destination_image, $source_image, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height );
	return $destination_image;
}

//$patterns_htmlHex = array('/&/i', "/'/i", '/</i', '/>/i', '/"/i', '/é/i', '/è/i', '/ë/i', '/ê/i', '/É/i', '/È/i', '/Ê/i', '/Ë/i', '/ï/i', '/î/i', '/Ï/i', '/Î/i', '/à/i', '/â/i', '/À/i', '/Â/i', '/ô/i', '/ö/i', '/Ô/i', '/Ö/i', '/ù/i', '/ü/i', '/û/i', '/Ù/i', '/Ü/i', '/Û/i', '/ç/i', '/Ç/i', '/%/i', '/-/i');
//$replacements_htmlHex = array('&#x26;', '&#x27;', '&#x3C;', '&#x3E;', '&#x22;', '&#xE9;', '&#xE8;', '&#xEB;', '&#xEA;', '&#xC8;', '&#xC9;', '&#xCA;', '&#xCB;', '&#xEF;', '&#xEE;', '&#xCF;', '&#xCE;', '&#xE0;', '&#xE2;', '&#xC0;', '&#xC2;', '&#xF4;', '&#xF6;', '&#xD4;', '&#xD6;', '&#xF9;', '&#xFC;', '&#xFB;', '&#xD9;', '&#xDC;', '&#xDB;', '&#xE7;', '&#xC7;', '&#x25;', '&#x2D;');


function patterns_str_to_hex() {
	return array ('/&/i', "/'/i", '/\</i', '/\>/i', '/"/i', '/\//i', '/=/i', '/,/i' );
}

function replacements_str_to_hex() {
	return array ('&#26;', '&#27;', '&#3C;', '&#3E;', '&#22;', '&#47;', '&#61;', '&#44;' );
}

function patterns_hex_to_str() {
	return array ('/&#26;/i', '/&#27;/i', '/&#3C;/i', '/&#3E;/i', '/&#22;/i', '/&#47;/i', '/&#61;/i', '/&#44;/i' );
}

function replacements_hex_to_str() {
	return array ('&', "'", '<', '>', '"', '/', '=', ',' );
}

function patterns_str_to_htmlentity() {
	return array ('/&/i', "/'/i", '/\</i', '/\>/i', '/"/i' );
}

function replacements_str_to_htmlentity() {
	return array ('&amp;', '&apos;', '&lt;', '&gt;', '&quot;' );
}

function patterns_htmlentity_to_str() {
	return array ('/&amp;/i', '/&apos;/i', '/&lt;/i', '/&gt;/i', '/&quot;/i' );
}

function replacements_htmlentity_to_str() {
	return array ('&', "'", '<', '>', '"' );
}
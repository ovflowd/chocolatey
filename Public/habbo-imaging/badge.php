<?php

header("Content-type: image/gif");
$im = imagecreatefromgif("./badges/base/base.gif");

if(isset($_GET['badge']))
	$badgedata = $_GET['badge'];
else 
	$badgedata = "";

if(empty($badgedata))
	exit;
	
if (strpos($badgedata,'.gif') !== false) {
	$badgedata = str_replace(".gif", "", $badgedata);
}

$letters = array("b", "X");
$badgedata = str_replace($letters, "", $badgedata);
$layer = explode("s", $badgedata);

$sourcefile_id = imageCreateFromgif("./badges/base/base.gif");

if (isset($layer[0]))
{
	$str = "$layer[0]";
	$arr = str_split($str, 2);
}
else
{
	$str = "";
	$arr = str_split("", 2);
}

if (empty($str))
{
	$lay = "./badges/templates/none.gif";
	$lay = imagecreatefromgif($lay);
    	imagecopy($im, $lay, 0, 0, 0, 0, 0, 0);
}
else
{
	$colcode = $arr[1];


	if ("$colcode" == "01")
		$col = '0xff0xd60x01';
	else if ("$colcode" == "02")
		$col = '0xee0x760x00';
	else if ("$colcode" == "03") 
		$col = '0x840xde0x00';
	else if ("$colcode" == "04") 
		$col = '0x580x9a0x00';
	else if ("$colcode" == "05") 
		$col = '0x500xc10xfb';
	else if ("$colcode" == "06") 
		$col = '0x000x6f0xcf';
	else if ("$colcode" == "07") 
		$col = '0xff0x980xe3';
	else if ("$colcode" == "08") 
		$col = '0xf30x340xbf';
	else if ("$colcode" == "09") 
		$col = '0xff0x2d0x2d';
	else if ("$colcode" == "10") 
		$col = '0xaf0x0a0x0a';
	else if ("$colcode" == "11") 
		$col = '0xff0xff0xff';
	else if ("$colcode" == "12") 
		$col = '0xc00xc00xc0';
	else if ("$colcode" == "13") 
		$col = '0x370x370x37';
	else if ("$colcode" == "14") 
		$col = '0xfb0xe70xac';
	else if ("$colcode" == "15") 
		$col = '0x970x760x41';
	else if ("$colcode" == "16") 
		$col = '0xc20xea0xff';
	else if ("$colcode" == "17") 
		$col = '0xff0xf10x65';
	else if ("$colcode" == "18") 
		$col = '0xaa0xff0x7d';
	else if ("$colcode" == "19") 
		$col = '0x870xe60xc8';
	else if ("$colcode" == "20") 
		$col = '0x980x440xe7';
	else if ("$colcode" == "21") 
		$col = '0xde0xa90xff';
	else if ("$colcode" == "22") 
		$col = '0xff0xb50x79';
	else if ("$colcode" == "23") 
		$col = '0xc30xaa0x6e';
	else if ("$colcode" == "24") 
		$col = '0x7a0x7a0x7a';

	$colour = str_split($col, 4);
	$hex1 = $colour[0];
	$hex2 = $colour[1];
	$hex3 = $colour[2];

	function image_colorize(&$img, $rgb)
	{
  		imageTrueColorToPalette($img, true, 256);

  		$numColors = imageColorsTotal($img);

 		for ($x = 0; $x < $numColors; $x++)
		{
			list($r, $g, $b) = array_values(imageColorsForIndex($img, $x));
			$grayscale = ($r + $g + $b) / 3 / 0xff;
			imageColorSet($img, $x, $grayscale * $rgb[0], $grayscale * $rgb[1], $grayscale * $rgb[2]);
		}
	}

	$insertfile_id = imageCreateFromgif("./badges/base/$arr[0].gif");
	$sourcefile_width = imageSX($sourcefile_id);

	$insertfile_width = imageSX($insertfile_id);
	$sourcefile_height = imageSY($sourcefile_id);
	$insertfile_height = imageSY($insertfile_id);

	$p = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
	$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	$image = getimagesize ("./badges/base/$arr[0].gif");

	$h = $image[0];
	$w = $image[1];

	$color = array($hex1, $hex2, $hex3);

	$lay = "./badges/base/$arr[0].gif";
	$img = imageCreateFromgif($lay);

	image_colorize($img, $color);

	if(file_exists("./badges/base/$arr[0]_$arr[0].gif"))
	{
		$olay = imagecreatefromgif("./badges/base/$arr[0]_$arr[0].gif");
		imagecopymerge($img, $olay, 0, 0, 0, 0, $h, $w, 100);

		imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
	else
		imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
}

//Layer one
if (isset($layer[1]))
{
	$str1 = "$layer[1]";
	
	$LayerOneLength = strlen($str1);
	
	if ($LayerOneLength == 6)
		$arr1 = str_split($str1, 3);
	else
		$arr1 = str_split($str1, 2);
}
else
{
	$str1 = "";
	$arr1 = str_split($str1, 2);
}


if (empty($str1))
{
	$lay1 = "./badges/templates/none.gif";
	$lay1 = imagecreatefromgif($lay1);

	imagecopy($im, $lay1, 0, 0, 0, 0, 0, 0);
}
else
{
	$image = getimagesize ("./badges/templates/$arr1[0].gif");

	$h = $image[0];
	$w = $image[1];
	if ($LayerOneLength == 6) {
		$pos = $arr1[1];
		$pos = substr($pos, -1, 1);
	} else {
		$pos = $arr1[2];
	}
	
	if ("$pos" == "0")
	{
		$p = "0";
		$pp = "0";
	}
	else if ("$pos" == "1")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = 0;
	}
	else if ("$pos" == "2")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = 0;
	}
	else if ("$pos" == "3")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "4")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "5")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "6")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "7")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "8")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr1[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = $sourcefile_height - $insertfile_height;
	}

	if ($LayerOneLength == 6) {
		$colcode = $arr1[1];
		$colcode = substr($colcode, -3, 2);
	} else {
		$colcode = $arr1[1];
	}

	if ("$colcode" == "01")
		$col = '0xff0xd60x01';
	else if ("$colcode" == "02")
		$col = '0xee0x760x00';
	else if ("$colcode" == "03") 
		$col = '0x840xde0x00';
	else if ("$colcode" == "04") 
		$col = '0x580x9a0x00';
	else if ("$colcode" == "05") 
		$col = '0x500xc10xfb';
	else if ("$colcode" == "06") 
		$col = '0x000x6f0xcf';
	else if ("$colcode" == "07") 
		$col = '0xff0x980xe3';
	else if ("$colcode" == "08") 
		$col = '0xf30x340xbf';
	else if ("$colcode" == "09") 
		$col = '0xff0x2d0x2d';
	else if ("$colcode" == "10") 
		$col = '0xaf0x0a0x0a';
	else if ("$colcode" == "11") 
		$col = '0xff0xff0xff';
	else if ("$colcode" == "12") 
		$col = '0xc00xc00xc0';
	else if ("$colcode" == "13") 
		$col = '0x370x370x37';
	else if ("$colcode" == "14") 
		$col = '0xfb0xe70xac';
	else if ("$colcode" == "15") 
		$col = '0x970x760x41';
	else if ("$colcode" == "16") 
		$col = '0xc20xea0xff';
	else if ("$colcode" == "17") 
		$col = '0xff0xf10x65';
	else if ("$colcode" == "18") 
		$col = '0xaa0xff0x7d';
	else if ("$colcode" == "19") 
		$col = '0x870xe60xc8';
	else if ("$colcode" == "20") 
		$col = '0x980x440xe7';
	else if ("$colcode" == "21") 
		$col = '0xde0xa90xff';
	else if ("$colcode" == "22") 
		$col = '0xff0xb50x79';
	else if ("$colcode" == "23") 
		$col = '0xc30xaa0x6e';
	else if ("$colcode" == "24") 
		$col = '0x7a0x7a0x7a';
		
	$colour = str_split($col, 4);

	$hex1 = $colour[0];
	$hex2 = $colour[1];
	$hex3 = $colour[2];


	function image_colorize1(&$img, $rgb)
	{
		imageTrueColorToPalette($img,true,256);
		$numColors = imageColorsTotal($img);

		for ($x = 0; $x < $numColors; $x++)
		{
			list($r, $g, $b) = array_values(imageColorsForIndex($img, $x));

			$grayscale = ($r + $g + $b) / 3 / 0xff;

			imageColorSet($img, $x, $grayscale * $rgb[0], $grayscale * $rgb[1], $grayscale * $rgb[2]);
		}
	}

	$color = array($hex1, $hex2, $hex3);

	$lay1 = "./badges/templates/$arr1[0].gif";

	$img = imageCreateFromgif($lay1);
	image_colorize1($img, $color);

	if(file_exists("./badges/templates/$arr1[0]_$arr1[0].gif"))
	{
		$olay = imagecreatefromgif("./badges/templates/$arr1[0]_$arr1[0].gif");

		imagecopymerge($img, $olay, 0, 0, 0, 0, $h, $w, 100);
     	imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
	else
	{
		imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
}

//Layer two
if (isset($layer[2]))
{
	$str2 = "$layer[2]";
	
	$LayerTwoLength = strlen($str2);
	
	if ($LayerTwoLength == 6)
		$arr2 = str_split($str2, 3);
	else
		$arr2 = str_split($str2, 2);
}
else
{
	$str2 = "";
	$arr2 = str_split($str2, 2);
}

if (empty($str2))
{
	$lay2 = "./badges/templates/none.gif";
	$lay2 = imagecreatefromgif($lay2);

	imagecopy($im, $lay2, 0, 0, 0, 0, 0, 0);
}
else
{
	$image = getimagesize ("./badges/templates/$arr2[0].gif");

	$h = $image[0];
	$w = $image[1];
	if ($LayerTwoLength == 6) {
		$pos = $arr2[1];
		$pos = substr($pos, -1, 1);
	} else {
		$pos = $arr2[2];
	}
	
	if ("$pos" == "0")
	{
		$p = "0";
		$pp = "0";
	}
	else if ("$pos" == "1")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = 0;
	}
	else if ("$pos" == "2")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = 0;
	}
	else if ("$pos" == "3")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "4")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "5")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "6")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "7")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "8")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr2[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = $sourcefile_height - $insertfile_height;
	}

	if ($LayerTwoLength == 6) {
		$colcode = $arr2[1];
		$colcode = substr($colcode, -3, 2);
	} else {
		$colcode = $arr2[1];
	}
	
	
	if ("$colcode" == "01")
		$col = '0xff0xd60x01';
	else if ("$colcode" == "02")
		$col = '0xee0x760x00';
	else if ("$colcode" == "03") 
		$col = '0x840xde0x00';
	else if ("$colcode" == "04") 
		$col = '0x580x9a0x00';
	else if ("$colcode" == "05") 
		$col = '0x500xc10xfb';
	else if ("$colcode" == "06") 
		$col = '0x000x6f0xcf';
	else if ("$colcode" == "07") 
		$col = '0xff0x980xe3';
	else if ("$colcode" == "08") 
		$col = '0xf30x340xbf';
	else if ("$colcode" == "09") 
		$col = '0xff0x2d0x2d';
	else if ("$colcode" == "10") 
		$col = '0xaf0x0a0x0a';
	else if ("$colcode" == "11") 
		$col = '0xff0xff0xff';
	else if ("$colcode" == "12") 
		$col = '0xc00xc00xc0';
	else if ("$colcode" == "13") 
		$col = '0x370x370x37';
	else if ("$colcode" == "14") 
		$col = '0xfb0xe70xac';
	else if ("$colcode" == "15") 
		$col = '0x970x760x41';
	else if ("$colcode" == "16") 
		$col = '0xc20xea0xff';
	else if ("$colcode" == "17") 
		$col = '0xff0xf10x65';
	else if ("$colcode" == "18") 
		$col = '0xaa0xff0x7d';
	else if ("$colcode" == "19") 
		$col = '0x870xe60xc8';
	else if ("$colcode" == "20") 
		$col = '0x980x440xe7';
	else if ("$colcode" == "21") 
		$col = '0xde0xa90xff';
	else if ("$colcode" == "22") 
		$col = '0xff0xb50x79';
	else if ("$colcode" == "23") 
		$col = '0xc30xaa0x6e';
	else if ("$colcode" == "24") 
		$col = '0x7a0x7a0x7a';

	$colour = str_split($col, 4);

	$hex1 = $colour[0];
	$hex2 = $colour[1];
	$hex3 = $colour[2];


	function image_colorize2(&$img, $rgb)
	{
		imageTrueColorToPalette($img,true,256);
		$numColors = imageColorsTotal($img);

		for ($x = 0; $x < $numColors; $x++)
		{
			list($r, $g, $b) = array_values(imageColorsForIndex($img, $x));

			$grayscale = ($r + $g + $b) / 3 / 0xff;

			imageColorSet($img, $x, $grayscale * $rgb[0], $grayscale * $rgb[1], $grayscale * $rgb[2]);
		}
	}

	$color = array($hex1, $hex2, $hex3);

	$lay2 = "./badges/templates/$arr2[0].gif";

	$img = imageCreateFromgif($lay2);
	image_colorize2($img, $color);

	if(file_exists("./badges/templates/$arr2[0]_$arr2[0].gif"))
	{
		$olay = imagecreatefromgif("./badges/templates/$arr2[0]_$arr2[0].gif");

		imagecopymerge($img, $olay, 0, 0, 0, 0, $h, $w, 100);
     	imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
	else
	{
		imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
}

//Layer three
if (isset($layer[3]))
{
	$str3 = "$layer[3]";
	
	$LayerThreeLength = strlen($str3);
	
	if ($LayerThreeLength == 6)
		$arr3 = str_split($str3, 3);
	else
		$arr3 = str_split($str3, 2);
}
else
{
	$str3 = "";
	$arr3 = str_split($str3, 2);
}

if (empty($str3))
{
	$lay3 = "./badges/templates/none.gif";
	$lay3 = imagecreatefromgif($lay3);

	imagecopy($im, $lay3, 0, 0, 0, 0, 0, 0);
}
else
{
	$image = getimagesize ("./badges/templates/$arr3[0].gif");

	$h = $image[0];
	$w = $image[1];
	if ($LayerThreeLength == 6) {
		$pos = $arr3[1];
		$pos = substr($pos, -1, 1);
	} else {
		$pos = $arr3[2];
	}
	
	if ("$pos" == "0")
	{
		$p = "0";
		$pp = "0";
	}
	else if ("$pos" == "1")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = 0;
	}
	else if ("$pos" == "2")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = 0;
	}
	else if ("$pos" == "3")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "4")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "5")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "6")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "7")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "8")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr3[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = $sourcefile_height - $insertfile_height;
	}

	if ($LayerThreeLength == 6) {
		$colcode = $arr3[1];
		$colcode = substr($colcode, -3, 2);
	} else {
		$colcode = $arr3[1];
	}
	
	
	if ("$colcode" == "01")
		$col = '0xff0xd60x01';
	else if ("$colcode" == "02")
		$col = '0xee0x760x00';
	else if ("$colcode" == "03") 
		$col = '0x840xde0x00';
	else if ("$colcode" == "04") 
		$col = '0x580x9a0x00';
	else if ("$colcode" == "05") 
		$col = '0x500xc10xfb';
	else if ("$colcode" == "06") 
		$col = '0x000x6f0xcf';
	else if ("$colcode" == "07") 
		$col = '0xff0x980xe3';
	else if ("$colcode" == "08") 
		$col = '0xf30x340xbf';
	else if ("$colcode" == "09") 
		$col = '0xff0x2d0x2d';
	else if ("$colcode" == "10") 
		$col = '0xaf0x0a0x0a';
	else if ("$colcode" == "11") 
		$col = '0xff0xff0xff';
	else if ("$colcode" == "12") 
		$col = '0xc00xc00xc0';
	else if ("$colcode" == "13") 
		$col = '0x370x370x37';
	else if ("$colcode" == "14") 
		$col = '0xfb0xe70xac';
	else if ("$colcode" == "15") 
		$col = '0x970x760x41';
	else if ("$colcode" == "16") 
		$col = '0xc20xea0xff';
	else if ("$colcode" == "17") 
		$col = '0xff0xf10x65';
	else if ("$colcode" == "18") 
		$col = '0xaa0xff0x7d';
	else if ("$colcode" == "19") 
		$col = '0x870xe60xc8';
	else if ("$colcode" == "20") 
		$col = '0x980x440xe7';
	else if ("$colcode" == "21") 
		$col = '0xde0xa90xff';
	else if ("$colcode" == "22") 
		$col = '0xff0xb50x79';
	else if ("$colcode" == "23") 
		$col = '0xc30xaa0x6e';
	else if ("$colcode" == "24") 
		$col = '0x7a0x7a0x7a';

	$colour = str_split($col, 4);

	$hex1 = $colour[0];
	$hex2 = $colour[1];
	$hex3 = $colour[2];


	function image_colorize3(&$img, $rgb)
	{
		imageTrueColorToPalette($img,true,256);
		$numColors = imageColorsTotal($img);

		for ($x = 0; $x < $numColors; $x++)
		{
			list($r, $g, $b) = array_values(imageColorsForIndex($img, $x));

			$grayscale = ($r + $g + $b) / 3 / 0xff;

			imageColorSet($img, $x, $grayscale * $rgb[0], $grayscale * $rgb[1], $grayscale * $rgb[2]);
		}
	}

	$color = array($hex1, $hex2, $hex3);

	$lay3 = "./badges/templates/$arr3[0].gif";

	$img = imageCreateFromgif($lay3);
	image_colorize3($img, $color);

	if(file_exists("./badges/templates/$arr3[0]_$arr3[0].gif"))
	{
		$olay = imagecreatefromgif("./badges/templates/$arr3[0]_$arr3[0].gif");

		imagecopymerge($img, $olay, 0, 0, 0, 0, $h, $w, 100);
     	imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
	else
	{
		imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
}

//Layer four
if (isset($layer[4]))
{
	$str4 = "$layer[4]";
	
	$LayerFourLength = strlen($str4);
	
	if ($LayerFourLength == 6)
		$arr4 = str_split($str4, 3);
	else
		$arr4 = str_split($str4, 2);
}
else
{
	$str4 = "";
	$arr4 = str_split($str4, 2);
}

if (empty($str4))
{
	$lay4 = "./badges/templates/none.gif";
	$lay4 = imagecreatefromgif($lay4);

	imagecopy($im, $lay4, 0, 0, 0, 0, 0, 0);
}
else
{
	$image = getimagesize ("./badges/templates/$arr4[0].gif");

	$h = $image[0];
	$w = $image[1];
	if ($LayerFourLength == 6) {
		$pos = $arr4[1];
		$pos = substr($pos, -1, 1);
	} else {
		$pos = $arr4[2];
	}
	
	if ("$pos" == "0")
	{
		$p = "0";
		$pp = "0";
	}
	else if ("$pos" == "1")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = 0;
	}
	else if ("$pos" == "2")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = 0;
	}
	else if ("$pos" == "3")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "4")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "5")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}
	else if ("$pos" == "6")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = 0;
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "7")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$pp = $sourcefile_height - $insertfile_height;
	}
	else if ("$pos" == "8")
	{
		$insertfile_id = imageCreateFromgif("./badges/templates/$arr4[0].gif");

		$sourcefile_width = imageSX($sourcefile_id);
		$insertfile_width = imageSX($insertfile_id);
		$sourcefile_height = imageSY($sourcefile_id);
		$insertfile_height = imageSY($insertfile_id);

		$p = $sourcefile_width - $insertfile_width;
		$pp = $sourcefile_height - $insertfile_height;
	}

	if ($LayerFourLength == 6) {
		$colcode = $arr4[1];
		$colcode = substr($colcode, -3, 2);
	} else {
		$colcode = $arr4[1];
	}
	
	
	if ("$colcode" == "01")
		$col = '0xff0xd60x01';
	else if ("$colcode" == "02")
		$col = '0xee0x760x00';
	else if ("$colcode" == "03") 
		$col = '0x840xde0x00';
	else if ("$colcode" == "04") 
		$col = '0x580x9a0x00';
	else if ("$colcode" == "05") 
		$col = '0x500xc10xfb';
	else if ("$colcode" == "06") 
		$col = '0x000x6f0xcf';
	else if ("$colcode" == "07") 
		$col = '0xff0x980xe3';
	else if ("$colcode" == "08") 
		$col = '0xf30x340xbf';
	else if ("$colcode" == "09") 
		$col = '0xff0x2d0x2d';
	else if ("$colcode" == "10") 
		$col = '0xaf0x0a0x0a';
	else if ("$colcode" == "11") 
		$col = '0xff0xff0xff';
	else if ("$colcode" == "12") 
		$col = '0xc00xc00xc0';
	else if ("$colcode" == "13") 
		$col = '0x370x370x37';
	else if ("$colcode" == "14") 
		$col = '0xfb0xe70xac';
	else if ("$colcode" == "15") 
		$col = '0x970x760x41';
	else if ("$colcode" == "16") 
		$col = '0xc20xea0xff';
	else if ("$colcode" == "17") 
		$col = '0xff0xf10x65';
	else if ("$colcode" == "18") 
		$col = '0xaa0xff0x7d';
	else if ("$colcode" == "19") 
		$col = '0x870xe60xc8';
	else if ("$colcode" == "20") 
		$col = '0x980x440xe7';
	else if ("$colcode" == "21") 
		$col = '0xde0xa90xff';
	else if ("$colcode" == "22") 
		$col = '0xff0xb50x79';
	else if ("$colcode" == "23") 
		$col = '0xc30xaa0x6e';
	else if ("$colcode" == "24") 
		$col = '0x7a0x7a0x7a';

	$colour = str_split($col, 4);

	$hex1 = $colour[0];
	$hex2 = $colour[1];
	$hex3 = $colour[2];


	function image_colorize4(&$img, $rgb)
	{
		imageTrueColorToPalette($img,true,256);
		$numColors = imageColorsTotal($img);

		for ($x = 0; $x < $numColors; $x++)
		{
			list($r, $g, $b) = array_values(imageColorsForIndex($img, $x));

			$grayscale = ($r + $g + $b) / 3 / 0xff;

			imageColorSet($img, $x, $grayscale * $rgb[0], $grayscale * $rgb[1], $grayscale * $rgb[2]);
		}
	}

	$color = array($hex1, $hex2, $hex3);

	$lay4 = "./badges/templates/$arr4[0].gif";

	$img = imageCreateFromgif($lay4);
	image_colorize4($img, $color);

	if(file_exists("./badges/templates/$arr4[0]_$arr4[0].gif"))
	{
		$olay = imagecreatefromgif("./badges/templates/$arr4[0]_$arr4[0].gif");

		imagecopymerge($img, $olay, 0, 0, 0, 0, $h, $w, 100);
     	imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
	else
	{
		imagecopy($im, $img, $p, $pp, 0, 0, $h, $w);
	}
}

imagegif($im);
$badgedata = $_GET['badge'];
?>
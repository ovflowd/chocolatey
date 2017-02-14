<?php
/*=========================================================+
|| # Xdr
|| # Open Source.
|| # Version: 2.8 2016
|| # PHP 7.0 or superior.
|+=========================================================+
|| # Based in Jaym/Kreechin.
|+=========================================================+
*/

$Dir = 'BN';

const COLORSRGB = [1 => [255, 214, 1], 2 => [238, 118, 0], 3 => [132, 222, 0], 4 => [88, 154, 0], 5 => [80, 193, 251], 6 => [0, 111, 207], 7 => [255, 152, 227], 8 => [243, 52, 191], 9 => [255, 45, 45], 10 => [175, 10, 10], 11 => [255, 255, 255], 12 => [192, 192, 192], 13 => [55, 55, 55], 14 => [251, 231, 172], 15 => [151, 118, 65], 16 => [194, 234, 255], 17 => [255, 241, 101], 18 => [170, 255, 125], 19 => [135, 230, 200], 20 => [152, 68, 231], 21 => [222, 169, 255], 22 => [255, 181, 121], 23 => [195, 170, 110], 24 => [122, 122, 122]];
const UNPAINTABLE = [209, 210, 211, 212];

//Methods
function GetParts($partCode, $isSymbol = false) {
	$len = strlen($partCode);
	
	if ($len < 4 || $len > 6)
		return null;

	$partKey = substr($partCode, 0, (strlen($partCode) == 6 || (!$isSymbol && strlen($partCode) == 5)) ? 3 : 2);
	$partColor = (int)substr($partCode, strlen($partKey), 2);
	if ($len > strlen($partKey) + 2)
		$partPos = (int)substr($partCode, -1, 1);

	return [$partKey, COLORSRGB[$partColor] ?? '', $partPos ?? 0];
}

function CheckStr($str) {
	return preg_match('/^[a-z0-9-]*\$/i', $str);
}

function Colorize($img, $rgb) {
  	imagetruecolortopalette($img, true, 256);
  	$numColors = imagecolorstotal($img);

 	for ($x = 0; $x < $numColors; $x++) {
		list($r, $g, $b) = array_values(imagecolorsforindex($img, $x));
		$grayscale = ($r + $g + $b) / 3 / 0xff;

		imagecolorset($img, $x, $grayscale * $rgb[0], $grayscale * $rgb[1], $grayscale * $rgb[2]);
	}
}

// Security
if (!isset($_GET['badge']) || CheckStr($_GET['badge']))
	exit;

$BadgeCode = str_replace(['.gif', 'X'], '', $_GET['badge']);
// Cache
if (file_exists($Dir . '/cache/' . $BadgeCode . '.gif'))
{
	header('Content-type: image/gif');
	imagegif (imagecreatefromgif($Dir . '/cache/' . $BadgeCode . '.gif'));
	exit;
}

$BaseCode = '';
$SymbolsCode = [];

// Generator
$Base = strstr($BadgeCode, 'b') !== false;
$Symbols = strstr($BadgeCode, 's') !== false;

if ($Symbols)
{
	$Parts = explode('s', $BadgeCode);
	$BaseCode = str_replace('b', '', $Parts[0]);

	if (strlen($BaseCode) < 4 && strlen($BaseCode) > 5)
		exit;
	unset($Parts[0]);

	foreach($Parts as $k => $p)
	{
		if (strlen($p) < 4 || strlen($p) > 6 || !is_numeric($p))
			continue;	
		$SymbolsCode[] = $p;
	}
}
else
{
	$BaseCode = str_replace('b', '', $BadgeCode);
	if (strlen($BaseCode) < 3 || strlen($BaseCode) > 5)
		exit;
}

$GIF = imagecreatefromgif($Dir . '/base/base.gif');
$GIFWidth = imagesx($GIF); // Always 39x39 but... who knows?
$GIFHeight = imagesy($GIF);

//Base
if ($Base)
{
	if (!is_numeric($BaseCode))
		goto b;

	$BasePartArray = GetParts($BaseCode);
	if ($BasePartArray == null)
		goto b;

	$ColourHex = $BasePartArray[1];

	if (!file_exists($Dir . '/base/' .  $BasePartArray[0] . '.gif'))
		goto b;

	$BaseImage = imagecreatefromgif($Dir . '/base/' .  $BasePartArray[0] . '.gif');
	$Width = imagesx($BaseImage);
	$Height = imagesy($BaseImage);
	
	$x = ($GIFWidth / 2) - ($Width / 2);
	$y = ($GIFHeight / 2) - ($Height / 2);

	if (!empty($BasePartArray[1]))
		Colorize($BaseImage, $ColourHex);

	if (file_exists($Dir . '/base/' .  $BasePartArray[0] . '_' .  $BasePartArray[0] . '.gif'))
		imagecopymerge($BaseImage, imagecreatefromgif($Dir . '/base/' .  $BasePartArray[0] . '_' .  $BasePartArray[0] . '.gif'), 0, 0, 0, 0, $Width, $Height, 100);

	imagecopy($GIF, $BaseImage, $x, $y, 0, 0, $Width, $Height);
}
b:

if ($Symbols)
{
	foreach($SymbolsCode as $SymbolCode)
	{
		$SymbolPartArray = GetParts($SymbolCode, true);
		if ($SymbolPartArray == null)
			continue;

		if ($SymbolPartArray[0] == 0 || !file_exists($Dir . '/templates/' . $SymbolPartArray[0] . '.gif'))
			continue;

		$SymbolImage = imagecreatefromgif($Dir . '/templates/' . $SymbolPartArray[0] . '.gif');
		$Pos = (!isset($SymbolPartArray[2]) || $SymbolPartArray[2] < 0 || $SymbolPartArray[2] > 8) ? 0 : $SymbolPartArray[2];

		$x = 0;
		$y = 0;
		$Width = imagesx($SymbolImage);
		$Height = imagesy($SymbolImage);

		if ($Pos == 1)
			$x = ($GIFWidth - $Width) / 2;
		else if ($Pos == 2)
			$x = $GIFWidth - $Width;
		else if ($Pos == 3)
			$y = ($GIFHeight / 2) - ($Height / 2);
		else if ($Pos == 4)
		{
			$x = ($GIFWidth / 2) - ($Width / 2);
			$y = ($GIFHeight / 2) - ($Height / 2);
		}
		else if ($Pos == 5)
		{
			$x = $GIFWidth - $Width;
			$y = ($GIFHeight / 2) - ($Height / 2);
		}
		else if ($Pos == 6)
			$y = $GIFHeight - $Height;
		else if ($Pos == 7)
		{
			$x = ($GIFWidth - $Width) / 2;
			$y = $GIFHeight - $Height;
		}
		else if ($Pos == 8)
		{
			$x = $GIFWidth - $Width;
			$y = $GIFHeight - $Height;
		}

		if (!empty($SymbolPartArray[1]) && !isset(UNPAINTABLE[$SymbolPartArray[0]]))
			Colorize($SymbolImage, $SymbolPartArray[1]);

		if (file_exists($Dir . '/templates/' . $SymbolPartArray[0] . '_' . $SymbolPartArray[0] . '.gif'))
			imagecopymerge($SymbolImage, imagecreatefromgif($Dir . '/templates/' . $SymbolPartArray[0] . '_' . $SymbolPartArray[0] . '.gif'), 0, 0, 0, 0, $Width, $Height, 100);
		
		imagecopy($GIF, $SymbolImage, $x, $y, 0, 0, $Width, $Height);
	}
}

header('Content-type: image/gif');
imagegif ($GIF);
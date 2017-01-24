<?php
header('Content-Type: image/gif');

$figure = str_replace(".gif", "", $_GET['figure']);
$url = 'http://avatar-retro.com/habbo-imaging/avatarimage?figure=' . $figure . '&headonly=1';

$image = imagecreatetruecolor(54, 62);
imagealphablending($image, false);
$col = imagecolorallocatealpha($image, 255, 255, 255, 127);
imagefilledrectangle($image, 0, 0, 485, 500, $col);
imagealphablending($image, true);

/* add door glass */
$img_avatar = imagecreatefromstring(file_get_contents($url));
imagecopyresampled($image, $img_avatar, -2, 0, 0, 0, 54, 62, 54, 62);
imagealphablending($image, true);


$fn = md5(microtime() . "door_builder") . ".png";

imagealphablending($image, false);
imagesavealpha($image, true);

imagepng($image);
imagedestroy($image);
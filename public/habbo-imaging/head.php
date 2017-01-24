<?php
header('Content-Type: image/gif');

$figure = str_replace(".gif", "", $_GET['figure']);
$url = 'http://avatar-retro.com/habbo-imaging/avatarimage?figure=' . $figure;

$image = imagecreatetruecolor(64, 60);
imagealphablending($image, false);
$col = imagecolorallocatealpha($image, 255, 255, 255, 127);
imagefilledrectangle($image, 0, 0, 485, 500, $col);
imagealphablending($image, true);

$img_avatar = imagecreatefrompng($url);
imagecopyresampled($image, $img_avatar, 0, 0, 0, 0, 64, 60, 64, 60);
imagealphablending($image, true);

imagealphablending($image, false);
imagesavealpha($image, true);

imagepng($image);
imagedestroy($image);
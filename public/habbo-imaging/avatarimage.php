<?php

$no_rea = true;
$no_maintenance = true;

Header("Content-type: image/png");

$figure = $_GET['figure'];
$size = $_GET['size'];
$direction = $_GET['direction'];
$head_direction = $_GET['head_direction'];
$gesture = $_GET['gesture'];
$action = $_GET['action'];

if (!empty($figure)) {
    $real_figure = $figure;
}

if (empty($size)) {
    $size = "b";
}

if (empty($direction)) {
    $direction = "3";
}

if (empty($head_direction)) {
    $head_direction = "3";
}

if (empty($gesture)) {
    $gesture = "sml";
}


echo file_get_contents('http://avatar-retro.com/habbo-imaging/avatarimage?figure=' . $figure . '&size=' . $size . '&direction=' . $direction . '&head_direction=' . $head_direction . '&gesture=' . $gesture . '&action=' . $action);
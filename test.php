<?php

//$img = imagecreatefromjpeg('./data/upload/1/77A8MjpjN5c.jpg');


function resizeImage(string $filePath, int $w = 240)
{
    list($width, $height) = getimagesize($filePath);
    $r = $width / $height;

    $newHeight = $w / $r;
    $newWidth = $w;

    $src = imagecreatefromjpeg($filePath);
    $dst = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($dst, "./data/upload/test.jpg", 80);
//    return $dst;
}

resizeImage('./data/upload/1/77A8MjpjN5c.jpg');
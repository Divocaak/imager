<?php
header('Content-type: image/jpeg');
addBorderpng('source/R1-00.jpg', 500);

function addBorderpng($add, $bdr, $color = '#ababab')
{
    $rotate = true;

    $arr = explode('.', $add);
    $extension = strtolower(end($arr));
    $border = $bdr;

    if ($extension == 'jpg') {
        $im = imagecreatefromjpeg($add);
    } else if ($extension == 'png') {
        $im = imagecreatefrompng($add);
    }

    if ($rotate) {
        $im = imagerotate($im, -90, 0);
    }

    // 1228 × 1818
    $width = imagesx($im);
    $height = imagesy($im);

    $minimalBorderX = 100;
    $minimalBorderY = 100;

    $desiredWidth = 1080;
    $desiredHeight = 1350;

    $resizedImageDimensions = getResizedImageDimensions($width, $height, $desiredWidth - ($minimalBorderX * 2), $desiredHeight - ($minimalBorderY * 2));

    $newimage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    $color_gb_temp = HexToRGB($color);
    $border_color = imagecolorallocate($newimage, $color_gb_temp['r'], $color_gb_temp['g'], $color_gb_temp['b']);
    imagefilledrectangle($newimage, 0, 0, $desiredWidth, $desiredHeight, $border_color);

    $resizedImage = imagescale($im, $resizedImageDimensions["w"], $resizedImageDimensions["h"]);
    imagecopyresized($newimage, $resizedImage, $minimalBorderX, $minimalBorderY, 0, 0, $resizedImageDimensions["w"], $resizedImageDimensions["h"], $desiredWidth, $desiredHeight);
    if ($extension == 'jpg') {
        //chmod("$add", 0666);
        //imagejpeg($newimage, "out/" . $add, 9);
        
        imagejpeg($newimage);
    } else if ($extension == 'png')
        imagepng($newimage, $add, 9);
    //imagepng($newimage);

}

function getResizedImageDimensions($srcWidth, $srcHeight, $maxWidth, $maxHeight)
{
    $resizeWidth = $srcWidth;
    $resizeHeight = $srcHeight;

    $aspect = $resizeWidth / $resizeHeight;

    if ($resizeWidth > $maxWidth) {
        $resizeWidth = $maxWidth;
        $resizeHeight = $resizeWidth / $aspect;
    }
    if ($resizeHeight > $maxHeight) {
        $aspect = $resizeWidth / $resizeHeight;
        $resizeHeight = $maxHeight;
        $resizeWidth = $resizeHeight * $aspect;
    }


    return ["w" => $resizeWidth, "h" => $resizeHeight];
}

function HexToRGB($hex)
{
    $hex = str_replace("#", "", $hex);
    $color = array();

    if (strlen($hex) == 3) {
        $color['r'] = hexdec(substr($hex, 0, 1)/*  . $r */);
        $color['g'] = hexdec(substr($hex, 1, 1)/*  . $g */);
        $color['b'] = hexdec(substr($hex, 2, 1)/*  . $b */);
    } else if (strlen($hex) == 6) {
        $color['r'] = hexdec(substr($hex, 0, 2));
        $color['g'] = hexdec(substr($hex, 2, 2));
        $color['b'] = hexdec(substr($hex, 4, 2));
    }
    return $color;
}

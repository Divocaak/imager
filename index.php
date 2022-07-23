<?php
$targetWidth = 1080;
$targetHeight = 1350;

function addBorderpng($add, $bdr, $color = '#ababab')
{
    $arr = explode('.', $add);
    $extension = strtolower(end($arr));
    $border = $bdr;

    if ($extension == 'jpg') {
        $im = imagecreatefromjpeg($add);
    } else if ($extension == 'png') {
        $im = imagecreatefrompng($add);
    }

    $width = imagesx($im);
    $height = imagesy($im);

    $img_adj_width = $width + (2 * $border);
    $img_adj_height = $height + (2 * $border);

    $newimage = imagecreatetruecolor($img_adj_width, $img_adj_height);

    $color_gb_temp = HexToRGB($color);
    $border_color = imagecolorallocate($newimage, $color_gb_temp['r'], $color_gb_temp['g'], $color_gb_temp['b']);
    imagefilledrectangle($newimage, 0, 0, $img_adj_width, $img_adj_height, $border_color);

    imagecopyresized($newimage, $im, $border, $border, 0, 0, $width, $height, $width, $height);
    if ($extension == 'jpg') {
        //chmod("$add", 0666);
        //imagejpeg($newimage, "out/" . $add, 9);
        imagejpeg($newimage);
    } else if ($extension == 'png')
        imagepng($newimage, $add, 9);
    //imagepng($newimage);

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
header('Content-type: image/jpeg');
addBorderpng('source/R1-00.jpg', 500);

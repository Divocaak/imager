<?php
$files = glob('out/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

for ($i = 0; $i < count($_FILES["files"]["name"]); $i++) {
    $targetFile = "source/" . $_FILES["files"]["name"][$i];
    move_uploaded_file($_FILES["files"]["tmp_name"][$i], $targetFile);
    addBorder($targetFile);
}

$files = glob('source/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

function addBorder($add)
{
    $extension = strtolower(end(explode('.', $add)));
    if ($extension == 'jpg') {
        $im = imagecreatefromjpeg($add);
    } else if ($extension == 'png') {
        $im = imagecreatefrompng($add);
    }

    $im = imagerotate($im, -90, 0);

    $minimalBorderX = 100;
    $minimalBorderY = 100;

    $desiredWidth = 1080;
    $desiredHeight = 1350;

    $resizedImageDimensions = getResizedImageDimensions(imagesx($im), imagesy($im), $desiredWidth - ($minimalBorderX * 2), $desiredHeight - ($minimalBorderY * 2));

    $offsetX = ($desiredWidth - $resizedImageDimensions["w"]) / 2;
    $offsetY = ($desiredHeight - $resizedImageDimensions["h"]) / 2;

    $newImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    $border_color = imagecolorallocate($newImage, 0, 0, 0);
    imagefilledrectangle($newImage, 0, 0, $desiredWidth, $desiredHeight, $border_color);

    $resizedImage = imagescale($im, $resizedImageDimensions["w"], $resizedImageDimensions["h"]);
    imagecopy($newImage, $resizedImage, $offsetX, $offsetY, 0, 0, $desiredWidth, $desiredHeight);
    $newFileName = "out/" . str_replace("source/", "", $add);
    echo "<img src='" . $newFileName . "' style='height:50%; width: auto; padding: 1px;' />";
    if ($extension == 'jpg')
        imagejpeg($newImage, $newFileName, 100);
    else if ($extension == 'png')
        imagepng($newImage, $newFileName, 0);
}

function getResizedImageDimensions($srcWidth, $srcHeight, $maxWidth, $maxHeight)
{
    $aspect = $srcWidth / $srcHeight;

    if ($srcWidth > $maxWidth) {
        $srcWidth = $maxWidth;
        $srcHeight = $srcWidth / $aspect;
    }
    if ($srcHeight > $maxHeight) {
        $aspect = $srcWidth / $srcHeight;
        $srcHeight = $maxHeight;
        $srcWidth = $srcHeight * $aspect;
    }


    return ["w" => $srcWidth, "h" => $srcHeight];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Imager response</title>
</head>

<body>
    <a href="index.html">return</a>
    <a href="download.php">download all</a>
</body>

</html>
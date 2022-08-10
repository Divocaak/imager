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
    addBorder($targetFile, $i == 0);
}

$files = glob('source/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

if (file_exists("download.zip")) {
    unlink("download.zip");
}

function addBorder($add, $isFirst)
{
    $extensionTemp = explode('.', $add);
    $extension = strtolower(end($extensionTemp));
    if ($extension == 'jpg') {
        $im = imagecreatefromjpeg($add);
    } else if ($extension == 'png') {
        $im = imagecreatefrompng($add);
    }

    if (isset($_POST["rotate"])) {
        $im = imagerotate($im, -90, 0);
    }

    $minimalBorderX = $_POST["minWidth"];
    $minimalBorderY = $_POST["minHeight"];

    $desiredWidth = $_POST["desiredWidth"];
    $desiredHeight = $_POST["desiredHeight"];

    $resizedImageDimensions = getResizedImageDimensions(imagesx($im), imagesy($im), $desiredWidth - ($minimalBorderX * 2), $desiredHeight - ($minimalBorderY * 2));

    $offsetX = ($desiredWidth - $resizedImageDimensions["w"]) / 2;
    $offsetY = ($desiredHeight - $resizedImageDimensions["h"]) / 2;

    $newImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    $inputColor = sscanf($_POST["borderColor"], "#%02x%02x%02x");
    $border_color = imagecolorallocate($newImage, 0, 0, 0);
    imagefilledrectangle($newImage, 0, 0, $desiredWidth, $desiredHeight, $border_color);

    $resizedImage = imagescale($im, $resizedImageDimensions["w"], $resizedImageDimensions["h"]);
    imagecopy($newImage, $resizedImage, $offsetX, $offsetY, 0, 0, $desiredWidth, $desiredHeight);

    imagefill($newImage, 0, 0, imagecolorallocate($newImage, $inputColor[0], $inputColor[1], $inputColor[2]));
    $newFileName = "out/" . str_replace("source/", "", $add);
    echo  "<img src='" . $newFileName . "'" . ($isFirst ? " class='mt-4 mt-md-0' " : "") . "/>";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        img {
            height: 50%;
            width: auto;
            margin: 10px;
            box-shadow: 0px 0px 17px 0px #000000;
        }
    </style>
</head>

<body class="p-md-5 m-md-5 text-center py-5">
    <div class="fixed-top mt-2">
        <a class="btn btn-secondary" href="index.html"><i class="bi bi-arrow-left-circle pe-2"></i>Return back</a>
        <a class="btn btn-primary" href="download.php"><i class="bi bi-download pe-2"></i>Download all (.zip)</a>
    </div>
</body>

</html>
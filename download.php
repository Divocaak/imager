<?php
$zip = new ZipArchive;
$download = "imager_" . date('d-m-y h:i:s') . ".zip";
$zip->open($download, ZipArchive::CREATE);
foreach (glob("out/*.") as $file) {
    $zip->addFile($file);
}
$zip->close();
header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename = $download");
header('Content-Length: ' . filesize($download));
header("Location: $download");
//LoadModule php7_module libexec/apache2/libphp7.so

libexec/apache2/libphp7.so
LoadModule php8_module /opt/homebrew/opt/php@8.0/lib/httpd/modules/libphp.so

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Imager download</title>
</head>

<body>
    <a href="index.html">return</a>
</body>

</html>

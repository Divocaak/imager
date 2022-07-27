<?php
$zip = new ZipArchive;
$download = 'download.zip';
$zip->open($download, ZipArchive::CREATE);
foreach (glob("out/*") as $file) {
    $zip->addFile($file);
}
$zip->close();
header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename = $download");
header('Content-Length: ' . filesize($download));
header("Location: $download");
?>
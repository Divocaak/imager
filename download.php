<?php
session_start();
$zip = new ZipArchive;
$download = $_SESSION["imagerUserKey"] . ".zip";
$zip->open($download, ZipArchive::CREATE);
foreach (glob("out/" . $_SESSION["imagerUserKey"] . "/*") as $file) {
    $zip->addFile($file);
}
$zip->close();
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename = $download");
header("Content-Length: " . filesize($download));
header("Location: $download");

if(is_dir("out/" . $_SESSION["imagerUserKey"])){
    array_map('unlink', glob("out/" . $_SESSION["imagerUserKey"] . "/*"));
    rmdir("out/" . $_SESSION["imagerUserKey"]);
}
?>
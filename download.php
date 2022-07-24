<?php
$files = glob('out/*');
foreach ($files as $file) {
    if (is_file($file)) {
        readfile($file);
    }
}
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
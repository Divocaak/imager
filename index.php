<?php
session_start();
if(is_dir("out/" . $_SESSION["imagerUserKey"])){
    array_map('unlink', glob("out/" . $_SESSION["imagerUserKey"] . "/*"));
    rmdir("out/" . $_SESSION["imagerUserKey"]);
}
if (file_exists($_SESSION["imagerUserKey"] . ".zip")) {
    unlink($_SESSION["imagerUserKey"] . ".zip");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Imager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="m-md-5 p-5">
    <h1>Imager</h1>
    <a class="btn btn-outline-secondary mb-3" href="http://www.divokyvojtech.cz/"><i class="bi bi-arrow-left-circle pe-2"></i>Return</a>
    <form action="imager.php" method="post" enctype="multipart/form-data" class="row needs-validation" novalidate>
        <input type="file" class="form-control mb-3" id="files" name="files[]" multiple required>
        <div class="mb-5">
            <input class="form-check-input" type="checkbox" name="rotate" id="rotate">
            <label class="form-check-label" for="rotate">
              Rotate images
            </label>
        </div>
        <div class="mb-5">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-12 col-md-10">
                    <label for="minWidth" class="form-label">Minimal border width: 50</label>
                    <input type="range" class="form-range" id="minWidth" name="minWidth" min="0" max="100" value="50">
                    <label for="minHeight" class="form-label">Minimal border height: 50</label>
                    <input type="range" class="form-range" id="minHeight" name="minHeight" min="0" max="100" value="50">
                </div>
                <div class="col-12 col-md-2 d-flex justify-content-center">
                    <div>
                        <label for="borderColor" class="form-label">Border color</label>
                        <input type="color" class="form-control form-control-color" id="borderColor" name="borderColor" value="#000000">
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="desiredWidth" class="form-label">Output width</label>
                    <input type="number" class="form-control" id="desiredWidth" name="desiredWidth" value="1080">
                </div>
                <div class="col-12 col-md-6">
                    <label for="desiredHeight" class="form-label">Output height</label>
                    <input type="number" class="form-control" id="desiredHeight" name="desiredHeight" value="1350">
                </div>
                <p class="text-muted mt-2"><i class="bi bi-instagram pe-2"></i>Instagram format 1080x1350</p>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2"><i class="bi bi-upload pe-2"></i>Send files</button>
        <p class="text-muted">&#60;= 36 files and &#60;= 72 MB</p>
        <!-- 
        php.ini:
        upload_max_filesize = 72M
        max_file_uploads = 36
        post_max_size = 72M
        -->
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        $(document).ready(function() {
            $("#minWidth").on('input', function() {
                $(this).prev().html("Minimal border width: " + $(this).val());
            });

            $("#minHeight").on('input', function() {
                $(this).prev().html("Minimal border height: " + $(this).val());
            });
        })
    </script>
</body>

</html>
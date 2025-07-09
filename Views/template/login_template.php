<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= isset($page) ? $page : '' ?> - Aqato</title>
    <link rel="icon" type="image/x-icon" href="https://www.pngall.com/wp-content/uploads/2016/05/Kangaroo-PNG-File.png">

    <!-- <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/1624/1624023.png"> -->

    <!---------- header_scripts  ------------->
    <?= $this->include("widgets/header_scripts.php") ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>
</head>

<body class="bg-Ghostwhite">

    <!---------- admin_sidebar UI -->
    <?= $this->include("widgets/navbar.php") ?>

    <!---------- main UI -->
    <?= $this->rendersection("main") ?>

    <!---------- admin footer UI -->
    <?= $this->include("widgets/footer.php") ?>

    <!---------- footer_scripts -->
    <?= $this->include("widgets/footer_scripts.php") ?>

    <!---------- custom_script -->
    <?= $this->rendersection("custom_script") ?>
    
    <script>
        function __refresh_captcha(){
            var img = document.getElementById("captcha_image");
            img.src = "<?= base_url() ?>"+"/login/generate_captcha";
            // console.log();
        }
    </script>

</body>

</html>
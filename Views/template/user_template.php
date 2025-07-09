<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= isset($page) ? $page : '' ?> - Aqato</title>
    <link rel="icon" type="image/x-icon" href="https://www.pngall.com/wp-content/uploads/2016/05/Kangaroo-PNG-File.png">

    <!-- <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/1624/1624023.png"> -->

    <!---------- header_scripts  ------------->
    <?= $this->include("widgets/header_scripts.php") ?>
   
</head>

<body>
 <style>
        * {
            font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif !important;
        }

        b {
            font-weight: 600 !important;
        }

        thead {
            border-top: 1px solid #ebebeb !important;
        }
        .progress-bar{
            background-color: #055837;
            color: #FFC107;
        }
    </style>

    <div id="Internet_alert_box" style="display: none;">
        <div class="bg-danger text-center text-white p-1 w-100">
            <h3> There is no internet available. searching the internet... </h3>
        </div>
    </div>
    <!---------- admin_sidebar UI -->
    <?= $this->include("widgets/navbar.php") ?>
    <main>
    <!---------- main UI -->
    <?= $this->rendersection("main") ?>
    </main>
    <!---------- admin footer UI -->
    <?= $this->include("widgets/footer.php") ?>

    <!---------- footer_scripts -->
    <?= $this->include("widgets/footer_scripts.php") ?>

    <!---------- custom_script -->
    <?= $this->rendersection("custom_script") ?>

    <?= $this->include("widgets/comman_scripts.php") ?>
    
    <script>
    var links = document.getElementsByTagName('a.back_btn_id');
    for (var i = 0; i < links.length; i++) {
        if (!links[i].onclick) {
            links[i].onclick = function() {
                if (document.documentElement.getAttribute('data-page-changed') == 'true') {
                    var confirmLeave = confirm("You have unsaved changes. Are you sure you want to leave this page?");
                    if (!confirmLeave) {
                        return false;
                    }
                }
            }
        }
    }
    let form = document.querySelector('form');
    if (form != null) {
        form.addEventListener('change', function() {
            document.documentElement.setAttribute('data-page-changed', 'true');
        });
    }
</script>

<script>
    function getTheCurrentStageComment(pointer_id, stage, isShowPopup = 0){
        $.post("<?= base_url("user/getTheCommentBasedOnStage") ?>",{
            pointer_id,
            stage,
        },function(data){
            console.log(isShowPopup);
            if(isShowPopup == 1){
                data = JSON.parse(data);
                if(data["comment_show"]){
                    custom_alert_popup_show(header = '<b>Assessor Comments</b>', body_msg = data["comment_show"], close_btn_text = 'OK', close_btn_css = 'btn-danger', other_btn = false);
                }
            }
        });
    }
    

</script>

</body>


</html>
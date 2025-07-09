<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class=" bg-green text-white text-center">
    Stage 1 - Self Assessment
</div>

<style>
    .row {
        padding-left: calc(var(--bs-gutter-x) * .0) !important;
    }

    .signing_box {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.19);

        border: 1px solid;
        padding: 3px;
    }
</style>


<div class="container mt-4 mb-4">
    <?php if ($digital_signature_info['email_signachred'] != 1) {  ?>
        <div class="row text-center">

            <!-- <div class="col-md-6 bg-white shadow" style="display: none;">
                <h3>
                    <b>
                        Upload Your Signature :-
                    </b>
                </h3>
                <br>
                <div class="bg- text-danger">
                    - Only : .jpg, .jpeg, .png file Allow
                    <br> - Upload an Image with a white Background
                    <br> - File Size : 120px width , 50px height
                </div>
                <br>
                <form enctype="multipart/form-data" action="<?= base_url('user/digital_signing/signing_upload_') ?>" method="POST">
                    <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />
                    <input type="file" class="form-control" name="file" id="signing" accept=".jpg,.jpeg,.png">
                    <div class="alert text-danger ">
                        Check your signing on file and submit that documant
                    </div>
                    <br>
                    <div class="page p-3" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.19);    width: 1;    margin-left: auto;    margin-right: auto; padding: 10px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        <br>
                        <div class="text-end">
                            <b> Digital Signachut:</b> <br>
                            <br>
                            <img class="blah" src="#" width="120px" height="50px" />
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-info" id="Upload_btn">
                            Upload
                        </button>
                    </div>
                </form>
            </div>  -->

            <div class="col-md-3">
            </div>
            <div class="col-md-6 bg-white shadow">
                <h3>
                    <b>
                        Select Your Signature :- <?= $Applicant_name ?>
                    </b>
                </h3>
                <br>
                <form enctype="multipart/form-data" action="<?= base_url('user/digital_signing/signing_get_upload_') ?>" method="POST">
                    <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />

                    <input type="hidden" name="Applicant_name" value="<?= $Applicant_name ?>" readonly>

                    <div id="all_Signature" class="row text-center"> </div>
                    <div class=" text-center mt-3 p-3">
                        <button type="submit" class="btn btn_green_yellow"> Submit </button>
                    </div>
                </form>
            </div> <!-- col-sm-6  -->
            <div class="col-md-3">
            </div>
        </div> <!-- / row  -->
    <?php } else { ?>
        <div class="row">
            <div class="col-md-2"> </div>
            <!-- Done  -->
            <div class="col-md-8 bg-white shadow ">
                <div class="text-center">
                    <i style="font-size: 120px;color:red;margin-right: 5px;" class="bi bi-check-circle text-green"></i>
                    <br>
                    <h2 class="text-green"> Digital Signature</h2>
                </div>


                <table style="font-size: 20px;" class="text-green table">
                    <tr>
                        <td style="width: 220px;">
                            <i class="bi bi-envelope-at"></i> Emal send
                        </td>
                        <td>
                            <?= $digital_signature_info['email_send_time'] ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <i class="bi bi-envelope-open"></i> Emal Open
                        </td>
                        <td>
                            <?= $digital_signature_info['email_open_time'] ?> &emsp; / &emsp; <?= $digital_signature_info['client_ip'] ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <i class="bi bi-check2-circle"></i> Signature
                        </td>
                        <td>
                            <?= $digital_signature_info['email_signachr_time'] ?> &emsp; / &emsp; <?= $digital_signature_info['REMOTE_ADDR'] ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <i class="bi bi-pc-display"></i> System Information
                        </td>
                        <td>
                            <?= $digital_signature_info['HTTP_USER_AGENT'] ?>
                        </td>
                    </tr>
                </table>



            </div>
        </div>
    <?php } ?>


</div> <!-- container -->



<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<?php if ($digital_signature_info['email_signachred'] != 1) {  ?>
    <!-- Select image  -->
    <script>
        function select_img_load(text, no) {
            $.ajax({
                type: 'get',
                url: '<?= base_url('user/digital_signing/creat_image'); ?>/' + text + '/' + no,
                error: function() {
                    console.log("error --- ");
                },
                success: function(data) {
                    console.log("data --- ");

                    $(data).appendTo('#all_Signature');
                }
            });
        }
        select_img_load('<?= $Applicant_name ?>', 1);
        select_img_load('<?= $Applicant_name ?>', 2);
        select_img_load('<?= $Applicant_name ?>', 3);
        select_img_load('<?= $Applicant_name ?>', 4);
        select_img_load('<?= $Applicant_name ?>', 5);
    </script>

    <!-- select image preview  -->
    <script>
        $('.blah').hide();
        $('.page').hide();
        $('.alert').hide();
        $('#Upload_btn').hide();

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.blah').attr('src', e.target.result);
                    $('.blah').show();
                    $('.alert').show();
                    $('.page').show();

                    $('#Upload_btn').show();

                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#signing").change(function() {
            readURL(this);
        });
    </script>


    <!-- link open SQL update  -->
    <script>
        function on_page_view() {
            $.ajax({
                data: {
                    'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
                },
                type: 'post',
                url: '<?= base_url('user/digital_signing/page_view_'); ?>',
                error: function() {},
                success: function(data) {
                    console.log("data Funtion Call:- " + data);

                    if (data == "1") {}
                }
            });
        }

        on_page_view();
    </script>


<?php } ?>

<?= $this->endSection() ?>
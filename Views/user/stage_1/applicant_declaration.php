<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>


<style>
    .Hi_Lite {
        background-color: var(--offgray);
    }

    .id_row {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
    }
</style>

<!-- stepper -->
<?php include("stepper.php") ?>

<!-- start -->
<div class="container-fluid  mt-4 mb-4">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">


            <!-- form name heading -->
            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Applicant Declaration
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>



            <!-- form start  -->
            <div class="row mt-5">
                <div class="col-sm-12">

                    <!-- Alert on set - Flashdata -->
                    <?= $this->include("alert_box.php") ?>

                    <div class=" col-lg-12 bg-warning rounded p-1">
                        <br>
                        <p class="text-center">PLEASE DOWNLOAD ALL THE BELOW FORMS FOR SIGNATURES BEFORE YOU PROCEED TO THE NEXT STEP.</p>
                    </div>



                    <div class="col-lg-12 mt-4" id="file_table">
                        <table class="table table-borderedx table-hover table-hover">
                            <!-- <thead>
                                <tr>
                                    <th> File Name</th>

                                </tr>
                            </thead> -->
                            <?php foreach ($offline_file_model as $key => $value) {
                                $use_for = $value['use_for'];
                                $name = $value['name'];
                                $file_name = $value['file_name'];
                                $path_text = $value['path_text']; ?>

                                <!-- saq_file / in pathway 1 -->
                                <?php if ($occupation_application['pathway'] == "Pathway 1") { ?>
                                    <?php if ($use_for == "saq_file") { ?>
                                        <?php if (file_exists($path_text)) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url($path_text) ?>" download="<?= $name ?>">
                                                        <i style="font-size: 16px;color:red;margin-right: 5px;" class="bi bi-file-earmark-pdf-fill"></i>
                                                        SAQ File
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                            <?php } ?>

                            <?php
                            if(($occupation_application["occupation_id"] == 5 || $occupation_application["occupation_id"] == 6) && $occupation_application['pathway'] == "Pathway 2"){
                            // print_r($occupation_application);
                            ?>
                            
                            <!-- Information Release Form  auto create daynamic  -->
                            <tr>

                                <td>

                                    <!-- <a href="<?= base_url() ?>/user/information_release_form_/<?= $ENC_pointer_id ?>"> -->
                                    <a href="javascript:void(0)" onclick="check_file_and_update('industry_experience_summary_file_download')">
                                        <i style="font-size: 16px;color:red;margin-right: 5px;" class="bi bi-file-earmark-pdf-fill"></i>
                                        Industry Experience Summary
                                    </a>
                                </td>
                            </tr>
                            
                            <?php 
                            }
                            ?>
                            
                            

                            <!-- Information Release Form  auto create daynamic  -->
                            <tr>

                                <td>

                                    <!-- <a href="<?= base_url() ?>/user/information_release_form_/<?= $ENC_pointer_id ?>"> -->
                                    <a href="javascript:void(0)" onclick="check_file_and_update('information_release_file_download')">
                                        <i style="font-size: 16px;color:red;margin-right: 5px;" class="bi bi-file-earmark-pdf-fill"></i>
                                        Information Release Form
                                    </a>
                                </td>
                            </tr>


                            <!-- Applicant Declaration  auto creat daynamic data  -->
                            <tr>
                                <td>
                                    <!-- <a href="<?= base_url('user/applicant_declaration_pdf_/' . $ENC_pointer_id) ?>"> -->
                                    <a href="javascript:void(0)" onclick="check_file_and_update('applicant_declaration_file_download')">
                                        <i style="font-size: 16px;color:red;margin-right: 5px;" class="bi bi-file-earmark-pdf-fill"></i>
                                        Applicant Declaration
                                    </a>
                                </td>
                            </tr>


                        </table>
                    </div>

                    <!-- // alert box for ajex  -->
                    <!-- <div class=" col-lg-12 bg-light rounded p-1" id="digital_signature_alert">
                    </div> -->

                    <!-- testing use  -->
                    <!-- <a href="<?= base_url('user/send_email_digital_signing/' . $ENC_pointer_id) ?>" class="btn btn_green_yellow">
                            Digital Signature
                        </a> -->
                    <!--<a href="<?= base_url('user/digital_signing/' . $ENC_pointer_id) ?>" class="btn btn_green_yellow"> View Email </a>-->



                    <div class="mt-4 mb-3 text-center">
                        <a href="<?= base_url('user/stage_1/application_preview/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green">Back</a>
                        <a href="<?= base_url('user/dashboard') ?>" class="btn btn_green_yellow"> Save & Exit </a>
                        <a id="next" href="<?= base_url('user/stage_1/upload_documents/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green">Next</a>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>


<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    jQuery('#next').addClass('disabled');

    // that funtion use from application_preview controler -----
    function check_file_and_update(file_page) {
        console.log("pdf_Download_check_ :- " + file_page);

        $.ajax({
            data: {
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
                'file_page': file_page,
            },
            type: 'post',
            url: '<?= base_url('user/pdf_Download_check_'); ?>',
            error: function() {
                console.log("Error ajax");
            },
            success: function(data) {
                console.log("data Funtion Call:- " + data);
                if (data == "ok") {
                    jQuery('#next').removeClass('disabled');
                }
            }
        });
        setTimeout(() => {
            if(file_page == 'applicant_declaration_file_download'){
                window.location = '<?= base_url('user/DS_applicant_declaration_pdf_/' . $ENC_pointer_id) ?>';
            }

            if(file_page == 'information_release_file_download'){
                window.location = '<?= base_url() ?>/user/DS_information_release_form_/<?= $ENC_pointer_id ?>';
            }
            
            if(file_page == 'industry_experience_summary_file_download'){
                window.location = '<?= base_url() ?>/public/backend/Industry%20Experience%20Summary.docx';
            }
        },1000);

    }

    $(document).ready(function() {
        $.ajax({
            data: {
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
            },
            type: 'post',
            url: '<?= base_url('user/pdf_Download_check_only_'); ?>',
            error: function() {
                console.log("Error ajax");
            },
            success: function(data) {
                console.log("data Funtion Call:- " + data);
                if (data == "ok") {
                    jQuery('#next').removeClass('disabled');
                }
            }
        });
    });




    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<?= $this->endSection() ?>
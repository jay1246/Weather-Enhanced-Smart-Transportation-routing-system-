<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>

<!-- stepper -->
<?php include("stepper.php")
?>

<style>
    .Hi_Lite {
        background-color: var(--offgray);
    }

    .id_row {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
    }

    .form-control-lg {
        font-size: inherit !important;
    }

    .pl {
        padding-left: 10px;
        padding-right: 10px;
    }

    .check_box {
        /* width: 19px;
        height: 17px; */
        width: 1em;
        height: 1em;
    }
</style>


<!-- start -->
<div class="container-xxl  mt-4 mb-4">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">

            <!-- form name heading -->
            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Unique Student Identifier (USI)
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>

            <!-- form start  -->
            <div class="row mt-5 ">
                <div class="col-sm-12">

                    <form class="row  d-flex justify-content-center" id="USI_form" autocomplete="off" action="<?= base_url('user/usi_avetmiss_') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />

                        <!-- I am currently in Australia -->
                        <div class="Hi_Lite ">
                            <div class="row pl ">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label ">
                                        <b> I am currently in Australia </b>
                                        <span class="text-danger" id="imp_yes">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['currently_have_usi'] == "yes") {
                                                                                                                            echo "checked";
                                                                                                                        } elseif (empty($usi_details['currently_have_usi'])) {
                                                                                                                            // echo "checked";
                                                                                                                        } ?> name="currently_have_usi" id="currently_have_usi_yes" onclick="usi_check(this.value)" value="yes" required>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <!-- display: none; -->
                        <?php if ($usi_details['currently_have_usi'] == "yes") { ?>

                            <!-- USI*  -->
                            <div id="usi_no" class="Hi_Lite" style=" margin-bottom: 20px; padding: 10px !important; box-shadow: 0px 0px 10px 10px #f7f9F9; border: 1px solid #f7f9F9;  background-color: #FFF;">
                                <div class="row pl">
                                    <div class="col-sm-5">
                                        <label for="occupation" class="col-form-label">
                                            <b> USI </b>
                                            <span class="text-danger">*</span>
                                            <br>
                                            <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                (<b><a target="_blank" href="https://www.usi.gov.au/students/get-a-usi">Create USI</a></b>
                                                if you don’t have one)
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" class="form-control" id="INPUT_usi_no" maxlength="10" onchange="upload_auto(this.form)" value="<?= $usi_details['usi_no'] ?>" name="usi_no" />

                                    </div>
                                </div>

                                <!-- <div id="USI_Transcript_alert_box"> -->
                                <div class="" id="DIV_have_usi_transcript">
                                    <div class="row pl">
                                        <div class="col-sm-5">
                                            <label for="" class="col-form-label ">
                                                <b> Do you have a USI Transcript: </b>
                                                <span class="text-danger">*</span>
                                                <br>
                                                <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                    (Kindly refer to the <b> <a target="_blank" href="<?= base_url('public/assets/PDF/HOW_TO_GUIDE.pdf') ?>">How
                                                            to Guide </a> </b> to download transcript)
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                                <input <?php if ($usi_details['have_usi_transcript'] == "yes") {
                                                            echo "checked";
                                                        }  ?> onchange="upload_auto(this.form)" class="form-check-input" onclick="fun_USI_Transcript(this.value)" type="radio" name="have_usi_transcript" id="USI_Transcript_yes" value="yes">
                                                <span>Yes</span>
                                            </label>
                                            <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                                <input <?php if ($usi_details['have_usi_transcript'] == "no") {
                                                            echo "checked";
                                                        }  ?> onchange="upload_auto(this.form)" class="form-check-input" onclick="fun_USI_Transcript(this.value)" type="radio" name="have_usi_transcript" id="USI_Transcript_no" value="no">
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($usi_details['have_usi_transcript'] == "yes") {
                                ?>
                                    <div id="DIV_ATTC_permission">
                                        <div class="row  pl">
                                            <div class="col-sm-5">
                                                <label for="occupation" class="col-form-label">
                                                    <b>I have assigned ATTC permission to access USI Transcripts. </b>
                                                    <span class="text-danger">*</span>
                                                    <br>
                                                    <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                        (Kindly refer to the <b> <a target="_blank" href="<?php echo base_url() . "/public/assets/PDF/How_to_Guide_to_assign_permission.pdf"; ?>">How
                                                                to Guide </a> </b> assign permission)
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                                    <input <?php if ($usi_details['permission_access_usi_transcripts'] == "yes") {
                                                                echo "checked";
                                                            }  ?> onchange="upload_auto(this.form)" class="form-check-input check_box" type="checkbox" value="yes" onchange="upload_auto(this.form)" id="ATTC_permission" name="permission_access_usi_transcripts">
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 pl" id="DIV_ATTC_permission_no" style=" display: none;">
                                        <div class="  col-lg-12 bg-warning rounded p-2">
                                            <b>Note:</b>
                                            It is a mandatory requirement to verify qualifications for any skills
                                            assessment
                                            application. If the USI Transcripts are unavailable, we will have to
                                            manually
                                            verify the qualifications from the RTO which has awarded the qualification.
                                        </div>
                                    </div>
                                <?php
                                } else  if ($usi_details['have_usi_transcript'] == "no") {
                                ?>

                                    <div id="DIV_ATTC_permission" class="" style="display: none;">
                                        <div class="row  pl">
                                            <div class="col-sm-5">
                                                <label for="occupation" class="col-form-label">
                                                    <b>I have assigned ATTC permission to access USI Transcripts. </b>
                                                    <span class="text-danger">*</span>
                                                    <br>
                                                    <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                        (Kindly refer to the <b> <a target="_blank" href="<?php echo base_url() . "/public/assets/PDF/How_to_Guide_to_assign_permission.pdf"; ?>">How
                                                                to Guide </a> </b> assign permission)
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-check-label form-control-lg" style="padding-left:0px">
                                                    <input <?php if ($usi_details['permission_access_usi_transcripts'] == "yes") {
                                                                echo "checked";
                                                            }  ?> onchange="upload_auto(this.form)" class="form-check-input" style=" width:21px; height:22px;" type="checkbox" value="yes" onchange="upload_auto(this.form)" id="ATTC_permission" name="permission_access_usi_transcripts">
                                                </label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-sm-12 pl" id="DIV_ATTC_permission_no">
                                        <div class="  col-lg-12 bg-warning rounded p-2">
                                            <b>Note:</b>
                                            It is a mandatory requirement to verify qualifications for any skills
                                            assessment
                                            application. If the USI Transcripts are unavailable, we will have to
                                            manually
                                            verify the qualifications from the RTO which has awarded the qualification.
                                        </div>
                                    </div>
                                <?php
                                } else { ?>


                                    <div id="DIV_ATTC_permission">
                                        <div class="row  pl">
                                            <div class="col-sm-5">
                                                <label for="occupation" class="col-form-label">
                                                    <b>I have assigned ATTC permission to access USI Transcripts. </b>
                                                    <span class="text-danger">*</span>
                                                    <br>
                                                    <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                        (Kindly refer to the <b> <a target="_blank" href="<?php echo base_url() . "/public/assets/PDF/How_to_Guide_to_assign_permission.pdf"; ?>">How
                                                                to Guide </a> </b> to assign permission)
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                                    <input <?php if ($usi_details['permission_access_usi_transcripts'] == "yes") {
                                                                echo "checked";
                                                            }  ?> onchange="upload_auto(this.form)" class="form-check-input" style=" width:21px; height:22px;" type="checkbox" value="yes" onchange="upload_auto(this.form)" id="ATTC_permission" name="permission_access_usi_transcripts">
                                                </label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-sm-12 pl" id="DIV_ATTC_permission_no" style=" display: none;">
                                        <div class="  col-lg-12 bg-warning rounded p-2">
                                            <b>Note:</b>
                                            It is a mandatory requirement to verify qualifications for any skills
                                            assessment
                                            application. If the USI Transcripts are unavailable, we will have to
                                            manually
                                            verify the qualifications from the RTO which has awarded the qualification.
                                        </div>
                                    </div>

                                <?php   }
                                ?>


                            </div>

                        <?PHP } else { ?>
                            <div id="usi_no" style="display: none; margin-bottom: 20px; padding: 10px !important; box-shadow: 0px 0px 10px 10px #f7f9F9; border: 1px solid #f7f9F9;  background-color: #FFF;">

                                <div class="row pl">
                                    <div class="col-sm-5">
                                        <label for="occupation" class="col-form-label">
                                            <b> USI </b>
                                            <span class="text-danger">*</span>
                                            <br>
                                            <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                (<b><a target="_blank" href="https://www.usi.gov.au/students/get-a-usi">Create USI</a></b>
                                                if you don’t have one)
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" required class="form-control" id="INPUT_usi_no" maxlength="10" onchange="upload_auto(this.form)" value="<?= $usi_details['usi_no'] ?>" name="usi_no">
                                    </div>
                                </div>

                                <!-- <div id="USI_Transcript_alert_box"> -->
                                <div class="" id="DIV_have_usi_transcript" style="display: none;">
                                    <div class="row Hi_Lite pl">
                                        <div class="col-sm-5">
                                            <label for="" class="col-form-label ">
                                                <b> Do you have a USI Transcript: </b>
                                                <span class="text-danger">*</span>
                                                <br>
                                                <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                    (Kindly refer to the <b> <a target="_blank" href="<?= base_url('public/assets/PDF/HOW_TO_GUIDE.pdf'); ?>">How
                                                            to Guide </a> </b> to download transcript) </span>
                                            </label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                                <input <?php if ($usi_details['have_usi_transcript'] == "yes") {
                                                            echo "checked";
                                                        }  ?> onchange="upload_auto(this.form)" class="form-check-input" onclick="fun_USI_Transcript(this.value)" type="radio" name="have_usi_transcript" id="USI_Transcript_yes" value="yes">
                                                <span>Yes</span>
                                            </label>
                                            <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                                <input <?php if ($usi_details['have_usi_transcript'] == "no") {
                                                            echo "checked";
                                                        }  ?> onchange="upload_auto(this.form)" class="form-check-input" onclick="fun_USI_Transcript(this.value)" type="radio" name="have_usi_transcript" id="USI_Transcript_no" value="no">
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div id="DIV_ATTC_permission" style=" display: none; ">
                                    <div class="row pl">
                                        <div class="col-sm-5">
                                            <label for="occupation" class="col-form-label">
                                                <b>I have assigned ATTC permission to access USI Transcripts. </b>
                                                <span class="text-danger">*</span>
                                                <br>
                                                <span style="font-size: 90%;padding-right: 0px;margin-left: 0px !important;" class="bg-warning ">
                                                    (Kindly refer to the <b> <a target="_blank" href="<?php echo base_url() . "/public/assets/PDF/How_to_Guide_to_assign_permission.pdf"; ?>">How
                                                            to Guide </a> </b> to assign permission)
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                                <input <?php if ($usi_details['permission_access_usi_transcripts'] == "yes") {
                                                            echo "checked";
                                                        }  ?> onchange="upload_auto(this.form)" class="form-check-input" style=" width:21px; height:22px;" type="checkbox" value="yes" onchange="upload_auto(this.form)" id="ATTC_permission" name="permission_access_usi_transcripts">
                                            </label>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-sm-12 pl" id="DIV_ATTC_permission_no" style=" display: none;">
                                    <div class="  col-lg-12 bg-warning rounded p-2">
                                        <b>Note:</b>
                                        It is a mandatory requirement to verify qualifications for any skills
                                        assessment
                                        application. If the USI Transcripts are unavailable, we will have to
                                        manually
                                        verify the qualifications from the RTO which has awarded the qualification.
                                    </div>
                                </div>

                            </div>
                        <?php
                        } ?>


                        <!-- if inot USI  -->
                        <div class="row Hi_Lite pl">
                            <div class="col-sm-5" style="padding-left: 0px;">
                                <label for="" class="col-form-label pl">
                                    <b> I am offshore (outside of Australia) - Do not need any USI </b>
                                    <span class="text-danger" style="display: inline-block" id="imp_no">*</span>
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <label class="form-check-label form-control-lg" for="known_by_any_name" style="padding-left:0px;">
                                    <input class=" form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['currently_have_usi'] == "no") {
                                                                                                                        echo "checked";
                                                                                                                    } ?> name="currently_have_usi" id="currently_have_usi_no" onclick="usi_check(this.value)" value="no">
                                </label>
                            </div>
                        </div>



                        <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 23px;">
                            Avetmiss Details
                        </h5>

                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label ">
                                        <b>Do you speak a Language other than English at home? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input required class="form-check-input" id="speak_english_at_home" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['speak_english_at_home'] == "yes") {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } elseif ($usi_details['speak_english_at_home'] == "") {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?> name="speak_english_at_home" id="gridRadios3" onclick="english(this.value)" value="yes">
                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                        <input required class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['speak_english_at_home'] == "no") {
                                                                                                                                    echo "checked";
                                                                                                                                }  ?> name="speak_english_at_home" id="gridRadios3" onclick="english(this.value)" value="no">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Specify language -->
                        <div id="specify_lang">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> Specify Language </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7" style="padding-right: 7px;">
                                    <input type="text" autocomplete="off" maxlength="20" required class="form-control" id="specify_language" onchange="upload_auto(this.form)" value="<?= $usi_details['specify_language'] ?>" name="specify_language">
                                </div>
                            </div>
                        </div>


                        <!-- Proficiency in Spoken English  -->
                        <div id="proficiency" class="p-2">
                            <div class="row pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label" style="margin-left: 1px;">
                                        <b> Proficiency in Spoken English </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select required class="form-select" aria-label="Default select example" onchange="upload_auto(this.form)" name="proficiency_in_english">
                                        <?php
                                        if (!empty($usi_details['proficiency_in_english'])) {
                                            echo '<option value="' . $usi_details['proficiency_in_english'] . '" > ' . $usi_details['proficiency_in_english'] . '</option>';
                                        } else {
                                            echo '<option value=""  disabled  selected> Select An Option </option>';
                                        }

                                        ?>
                                        <option value="Very well">Very well</option>
                                        <option value="Well">Well</option>
                                        <option value="Not well">Not well</option>
                                        <option value="Not At All">Not At All</option>

                                    </select>
                                </div>
                            </div>
                        </div>


                        <!-- Are you of Aboriginal or Torres Strait Islander Origin ?  -->
                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="are_you_aboriginal" class="col-form-label ">
                                        <b> Are you of Aboriginal or Torres Strait Islander Origin ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input required class="form-check-input" id="are_you_aboriginal" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['are_you_aboriginal'] == "yes") {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?> name="are_you_aboriginal" onclick="aboriginal_(this.value)" value="yes">
                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                        <input required class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['are_you_aboriginal'] == "no") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> name="are_you_aboriginal" onclick="aboriginal_(this.value)" value="no">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Choose origin option -->
                        <div id="origin">
                            <div class="row pl">
                                <div class="col-sm-5">
                                    <label for="choose_origin" class="col-form-label ">
                                        <b> Choose origin option </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input required class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['choose_origin'] == "aboriginal") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> name="choose_origin" id="choose_origin" value="aboriginal">
                                        <span>Aboriginal</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                        <input class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['choose_origin'] == "torres_strait_islander") {
                                                                                                                            echo "checked";
                                                                                                                        } ?> name="choose_origin" id="gridRadios3" value="torres_strait_islander">
                                        <span>Torres Strait Islander</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Do you consider yourself to have a disability, impairment or long-term condition ? -->
                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label ">
                                        <b> Do you consider yourself to have a disability, impairment or long-term
                                            condition ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input required class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['have_any_disability'] == "yes") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> name="have_any_disability" id="gridRadios3" onclick="disability(this.value)" value="yes" required>
                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                        <input class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['have_any_disability'] == "no") {
                                                                                                                            echo "checked";
                                                                                                                        } ?> name="have_any_disability" id="have_any_disability" onclick="disability(this.value)" value="no">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <!-- Please indicate area  -->
                        <div id="disability">
                            <div class="row pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> Please indicate Area </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-select" id="indicate_area" required onchange="upload_auto(this.form)" aria-label="Default select example" name="indicate_area">
                                        <?php
                                        if (!empty($usi_details['indicate_area'])) {
                                            echo '<option value="' . $usi_details['indicate_area'] . '" > ' . $usi_details['indicate_area'] . '</option>';
                                        } else {
                                            echo '<option value=""  disabled  selected> Select An Option </option>';
                                        }
                                        ?>
                                        <option>Hearing/Deaf</option>
                                        <option>Mental Illness</option>
                                        <option>Learning</option>
                                        <option>Physical</option>
                                        <option>Intellectual</option>
                                        <option>Vision</option>
                                        <option>Acquired Brain Impairment</option>
                                        <option>Medical Condition</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Please specify  -->
                        <div id="DIV_please_indicate_area_note" style="display: none;">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <b> Please specify </b>
                                    <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" autocomplete="off" maxlength="100" require class="form-control" onchange="upload_auto(this.form)" value="<?= $usi_details['please_indicate_area_note'] ?>" id="please_indicate_area_note" name="please_indicate_area_note">
                                </div>

                            </div>
                        </div>

                        <!-- Will you require additional support to participate in this skills assessment ? -->
                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label ">
                                        <b> Will you require additional support to participate in this skills
                                            assessment
                                            ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input class="form-check-input" type="radio" <?php if ($usi_details['require_additional_support'] == "yes") {
                                                                                            echo "checked";
                                                                                        } ?> onchange="upload_auto(this.form)" name="require_additional_support" id="gridRadios3" onclick="skill_assessment(this.value)" value="yes" required>
                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                        <input class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['require_additional_support'] == "no") {
                                                                                                                            echo "checked";
                                                                                                                        } ?> name="require_additional_support" id="gridRadios3" onclick="skill_assessment(this.value)" value="no">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Please specify the support you need -->
                        <div id="note">
                            <div class="row pl">
                                <div class="col-sm-5">
                                    <b> Please specify the support you need</b>
                                    <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" autocomplete="off" maxlength="70" require class="form-control" onchange="upload_auto(this.form)" value="<?= $usi_details['note'] ?>" id="specify_the_support" name="note" />
                                </div>
                            </div>
                            <div class="col-sm-12 pl">
                                <label for="specify_the_support" class="col-form-label">
                                    (Note: Your Assessor will have a confidential discussion with you to
                                    determine if any reasonable adjustment of assessing is required.)
                                </label>
                            </div>
                        </div>

                        <!-- tital  -->
                        <h5 class="text-success text-center mt-3 mb-3" style="font-size: 23px; margin-left: -62px !important;">
                            Marketing
                        </h5>
                        <!-- I give Australian Trade Training College permission to use photos/ images  in -->
                        <div class="row">
                            <div class="col-sm-5" style="padding-left: 0px;">
                                <label for="" class="col-form-label pl" style="text-align: justify;">
                                    <b>I give Australian Trade Training College permission to use photos/ images
                                        in
                                        public material and social media (including any photos/ images where I
                                        may
                                        be recognised or participating in workplace activities) for current and
                                        future marketing and business purposes. I understand that I retain the
                                        right
                                        to withdraw my consent at any time via email to tra@attc.org.au. </b>
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                    <input class="form-check-input" type="radio" <?php if ($usi_details['marketing'] == "yes") {
                                                                                        echo "checked";
                                                                                    } ?> onchange="upload_auto(this.form)" name="marketing" id="gridRadios3" value="yes" required>
                                    <span>Yes</span>
                                </label>
                                <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                    <input class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($usi_details['marketing'] == "no") {
                                                                                                                        echo "checked";
                                                                                                                    } ?> name="marketing" id="gridRadios3" value="no">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>



                        <div class="text-center mt-5 mb-3">
                            <a href="<?= base_url('user/stage_1/identification_details/' . $ENC_pointer_id) ?>" class="back btn btn_yellow_green">Back</a>
                            <a href="<?= base_url('user/dashboard') ?>" class="back btn btn_green_yellow">Save & Exit</a>
                            <input type="submit" name="submit" class="btn btn_yellow_green" value="Next" />
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>



<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>


<!-- onready  -->
<script>
    // ----------alert timeout div-------
    document.getElementById('specify_lang').style.display = 'block';
    $('#specify_language').prop('required', 'true');

    $('#specify_language').prop('required', '');
    $('#currently_have_usi_no').click(function() {
        $('#INPUT_usi_no').prop('required', '');

        document.getElementById('DIV_have_usi_transcript').style.display = 'none';
        document.getElementById("USI_Transcript_yes").required = false;
        document.getElementById("USI_Transcript_no").required = false;
        document.getElementById('DIV_ATTC_permission').style.display = 'none';
        document.getElementById('DIV_ATTC_permission_no').style.display = 'none';
        document.getElementById("ATTC_permission").required = false;

    });

    $('#currently_have_usi_yes').click(function() {
        // $('#INPUT_usi_no').prop('required', '');
        document.getElementById("INPUT_usi_no").required = true;
        document.getElementById("USI_Transcript_yes").required = true;
        document.getElementById("USI_Transcript_no").required = true;
    });

    $('#are_you_aboriginal').click(function() {
        $('#choose_origin').prop('required', '');
    });

    $('#have_any_disability').click(function() {
        $('#indicate_area').prop('required', '');
    });


    $('#indicate_area').on('change', function() {
        // alert(this.value);
        let aa = this.value;
        if (aa == 'Other') {
            document.getElementById("please_indicate_area_note")
                .required =
                true;
            document.getElementById('DIV_please_indicate_area_note')
                .style
                .display = 'block';
        } else {
            document.getElementById("please_indicate_area_note")
                .required =
                false;
            document.getElementById('DIV_please_indicate_area_note')
                .style
                .display = 'none';
        }
    });


    // hide show 
    $("#i_do_not_intend").click(function() {
        $('#i_intend').prop('checked', false);
        let isChecked = $('#i_do_not_intend').is(':checked');
        if (isChecked) {
            document.getElementById('applay_for_usi').style.display = 'none';
        } else {
            document.getElementById('applay_for_usi').style.display = 'none';
        }
    });

    // hide show 
    $("#i_intend").click(function() {
        $('#i_do_not_intend').prop('checked', false);
     custom_alert_popup_show(header = '', body_msg = "A USI will be required prior to issuance, once you have been issued with an Australian Visa and arrived in Australia your visa will be activated and you will be able to apply for a USI. It’s free, easy to create and will only take a few minutes of your time", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'update_btn');
        $("#update_btn").click(function() {
            if (custom_alert_popup_close('update_btn')) {
                // if (confirm("Are you sure you want to delete this Occupation?")) {  
                           $('#applay_for_usi').show();

            }
        });
        
        
        // var data = window.confirm(
        //     'A USI will be required prior to issuance, once you have been issued with an Australian Visa and arrived in Australia your visa will be activated and you will be able to apply for a USI. It’s free, easy to create and will only take a few minutes of your time '
        // );
        // if (data == false) {
        //     $('#applay_for_usi').hide();
        //     return false;
        // } else {
        //     $('#applay_for_usi').show();
        // }
    });
</script>

<!-- funtion  -->
<script>
    // hide show 
    function usi_check(data) {
        if (data == 'yes') {
            document.getElementById('usi_no').style.display = 'block';
            document.getElementById('imp_no').style.display = 'none';
            document.getElementById('imp_yes').style.cssText = 'display: block;  display: inline-block; ';

            document.getElementById('DIV_have_usi_transcript').style.display = 'block';
            document.getElementById("USI_Transcript_yes").required = true;
            document.getElementById("USI_Transcript_no").required = true;

            document.getElementById('checkbox_intend').style.display = 'none';
        } else {
            document.getElementById('usi_no').style.display = 'none';
            document.getElementById('imp_yes').style.display = 'none';
            document.getElementById('imp_no').style.cssText = 'display: block;  display: inline-block; ';

            document.getElementById('DIV_have_usi_transcript').style.display = 'none';
            document.getElementById("USI_Transcript_yes").required = false;
            document.getElementById("USI_Transcript_no").required = false;
        }
    }

    // hide show 
    function fun_USI_Transcript(data) {
        if (data == 'yes') { // Are you currently on a bridging Visa *
            document.getElementById('DIV_ATTC_permission').style.display = 'block';
            document.getElementById('DIV_ATTC_permission_no').style.display = 'none';
            document.getElementById("ATTC_permission").required = true;
        }
        if (data == 'no') { // Are you currently on a bridging Visa *
            document.getElementById('DIV_ATTC_permission').style.display = 'none';
            document.getElementById('DIV_ATTC_permission_no').style.display = 'block';
            document.getElementById("ATTC_permission").required = false;
        }
    }


    // hide show 
    function english(data) {
        if (data == 'yes') {
            document.getElementById('specify_lang').style.display = 'block';
            $('#specify_language').prop('required', 'true');
        } else if (data == 'no') {
            document.getElementById('specify_lang').style.display = 'none';
            $('#specify_language').prop('required', '');
        } else {
            document.getElementById('specify_lang').style.display = 'block';
            $('#specify_language').prop('required', 'true');
        }
    }

    // hide show 
    function aboriginal_(data) {
        if (data == 'yes') {
            document.getElementById('origin').style.display = 'block';
            $('#choose_origin').prop('required', true);
        } else if (data == 'no') {
            document.getElementById('origin').style.display = 'none';
            $('#choose_origin').prop('required', false);
        } else {
            document.getElementById('origin').style.display = 'none';
            $('#choose_origin').prop('required', false);
        }
    }

    // hide show 
    function disability(data) {
        if (data == 'yes') {
            document.getElementById('disability').style.display = 'block';
            $('#indicate_area').prop('required', true);
        } else {
            document.getElementById('disability').style.display = 'none';
            document.getElementById("please_indicate_area_note").required = false;
            document.getElementById('DIV_please_indicate_area_note').style.display = 'none';
        }
    }

    // hide show 
    function skill_assessment(data) {
        if (data == 'yes') {
            document.getElementById('note').style.display = 'block';
            $('#specify_the_support').prop('required', true);

        } else {
            document.getElementById('note').style.display = 'none';
            $('#specify_the_support').prop('required', '');

        }
    }

    // auto save on any change
    function upload_auto(Form_data) {
        let ssss = $('#USI_form').serialize();
        $.ajax({
            data: ssss,
            type: 'post',

            url: '<?php echo base_url('user/usi_avetmiss_'); ?>',
            error: function() {
                //    alert('Auto Upload is OFF ');
            },
            success: function(data, textStatus, jqXHR) {
                //  alert(data);
            }
        });
    }
</script>

<!-- // hide show -->
<script>
    $(document).ready(function() {
        // hide show
        let checlk = $('#currently_have_usi').val();
        if (!checlk == "yes") {
            document.getElementById('imp_no').style.display = 'none';
            document.getElementById('imp_yes').style.cssText = 'display: block;  display: inline-block; ';

            document.getElementById('usi_no').style.display = 'block';
            document.getElementById('DIV_have_usi_transcript').style.display = 'block';
            document.getElementById("USI_Transcript_yes").required = true;
            document.getElementById("USI_Transcript_no").required = true;
        } else {
            document.getElementById('usi_no').style.display = 'none';
            document.getElementById('imp_yes').style.display = 'none';
            document.getElementById('imp_no').style.cssText = 'display: block;  display: inline-block; ';

            $('#INPUT_usi_no').prop('required', '');
            document.getElementById('checkbox_intend').style.display = 'none';

            document.getElementById('DIV_have_usi_transcript').style.display = 'none';
            document.getElementById("USI_Transcript_yes").required = false;
            document.getElementById("USI_Transcript_no").required = false;
            document.getElementById('DIV_ATTC_permission').style.display = 'none';
            document.getElementById('DIV_ATTC_permission_no').style.display = 'none';
            document.getElementById("ATTC_permission").required = false;
        }

        // let are_you_aboriginal = $('#are_you_aboriginal').val();
        // if (are_you_aboriginal == "yes") {
        //     $('#choose_origin').prop('required', 'true');
        //     document.getElementById('origin').style.display = 'block';
        // } else {
        //     $('#choose_origin').prop('required', '');
        //     document.getElementById('origin').style.display = 'none';
        // }

    });




    $(document).ready(function() {

        <?php
        if ($usi_details['currently_have_usi'] == "yes") { ?>
            document.getElementById('usi_no').style.display = 'block';
            document.getElementById('DIV_have_usi_transcript').style.display = 'block';
            document.getElementById("USI_Transcript_yes").required = true;
            document.getElementById("USI_Transcript_no").required = true;
            document.getElementById('checkbox_intend').style.display = 'none';
            document.getElementById("INPUT_usi_no").required = true;

            <?php if ($usi_details['have_usi_transcript'] == "yes") { ?>
                document.getElementById('DIV_ATTC_permission').style.display = 'block';
                document.getElementById('DIV_ATTC_permission_no').style.display = 'none';
                document.getElementById("ATTC_permission").required = true;
            <?php } else if ($usi_details['have_usi_transcript'] == "no") { ?>
                document.getElementById('DIV_ATTC_permission').style.display = 'none';
                document.getElementById('DIV_ATTC_permission_no').style.display = 'block';
                document.getElementById("ATTC_permission").required = false;
            <?php } ?>

        <?php } else  if ($usi_details['currently_have_usi'] == "no") { ?>
            document.getElementById('usi_no').style.display = 'none';
            $('#INPUT_usi_no').prop('required', '');
            document.getElementById('checkbox_intend').style.display = 'none';
            document.getElementById('DIV_have_usi_transcript').style.display = 'none';
            document.getElementById("USI_Transcript_yes").required = false;
            document.getElementById("USI_Transcript_no").required = false;
            document.getElementById('DIV_ATTC_permission').style.display = 'none';
            document.getElementById('DIV_ATTC_permission_no').style.display = 'none';
            document.getElementById("ATTC_permission").required = false;
        <?php } else { ?>
            document.getElementById('usi_no').style.display = 'none';
            document.getElementById('checkbox_intend').style.display = 'none';

            document.getElementById('DIV_have_usi_transcript').style.display = 'none';
            document.getElementById("USI_Transcript_yes").required = false;
            document.getElementById("USI_Transcript_no").required = false;
            document.getElementById('DIV_ATTC_permission').style.display = 'none';
            document.getElementById('DIV_ATTC_permission_no').style.display = 'none';
            document.getElementById("ATTC_permission").required = false;
        <?php } ?>



        // hide show  php on page reload
        <?php if (!empty($usi_details['indicate_area'])) { ?>
            <?php if ($usi_details['indicate_area'] == 'Other') { ?>
                document.getElementById("please_indicate_area_note").required = true;
                document.getElementById('DIV_please_indicate_area_note').style.display = 'block';
            <?php   } else {  ?>
                document.getElementById("please_indicate_area_note").required = false;
                document.getElementById('DIV_please_indicate_area_note').style.display = 'none';
            <?php } ?>
        <?php } ?>


        <?php if ($usi_details['i_do_not_intend'] == "yes") { ?>
            document.getElementById('applay_for_usi').style.display = 'none';
        <?php } else { ?>
            document.getElementById('i_intend_hide').style.display = 'block';
        <?php } ?>

        <?php if ($usi_details['i_intend'] == "yes") { ?>
            document.getElementById('applay_for_usi').style.display = 'block';
        <?php } else { ?>
            document.getElementById('applay_for_usi').style.display = 'none';
        <?php } ?>

    });
</script>


<script>
    // Do you speak a language other than English at home?
    <?php if ($usi_details['speak_english_at_home'] == "yes") { ?>
        document.getElementById('specify_lang').style.display = 'block';
        $('#specify_language').prop('required', 'true');
    <?php } elseif ($usi_details['speak_english_at_home'] == "no") {  ?>
        document.getElementById('specify_lang').style.display = 'none';
        $('#specify_language').prop('required', '');
    <?php } else { ?>
        document.getElementById('specify_lang').style.display = 'block';
        $('#specify_language').prop('required', 'true');
    <?php } ?>


    // Are you of Aboriginal or Torres Strait Islander Origin
    <?php if ($usi_details['are_you_aboriginal'] == "yes") { ?>
        document.getElementById('origin').style.display = 'block';
    <?php } else { ?>
        $('#choose_origin').prop('required', '');
        document.getElementById('origin').style.display = 'none';
    <?php } ?>

    // Do you consider yourself to have a disability, impairment or long-term condition
    <?php if ($usi_details['have_any_disability'] == "yes") { ?>
        document.getElementById('disability').style.display = 'block';
    <?php } else { ?>
        $('#indicate_area').prop('required', '');
        document.getElementById('disability').style.display = 'none';
        document.getElementById("please_indicate_area_note").required = false;
        document.getElementById('DIV_please_indicate_area_note').style.display = 'none';
    <?php } ?>

    // Will you require additional support to participate in this skills assessment
    <?php if ($usi_details['require_additional_support'] == "yes") { ?>

        document.getElementById("specify_the_support").required = true;
        document.getElementById('note').style.display = 'block';

    <?php } else { ?>
        document.getElementById("specify_the_support").required = false;
        document.getElementById('note').style.display = 'none';
    <?php } ?>
</script>

<?= $this->endSection() ?>
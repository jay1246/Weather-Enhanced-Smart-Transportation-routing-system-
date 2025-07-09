<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->

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
</style>

<!-- stepper -->
<?php include("stepper.php")  ?>

<!-- start -->
<div class="container-fluid  mt-4 mb-2">

    <div class="row  p-0">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow  p-2">


            <!-- form name heading -->
            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Occupation Details
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>



            <!-- form start  -->
            <div class="row mt-5" style="margin-bottom: 50px;">
                <div class="col-xl-12">
                    <form id="Occupation_Details" action="<?= base_url('user/occupation_') ?>" method="POST" autocomplete="off" class="row g-3 d-flex justify-content-center">
                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />
                        <!-- Choose Occupation  -->
                        <div class="row Hi_Lite">
                            <div class="col-sm-5">
                                <label for="occupation" class="col-form-label">
                                    <b>Choose Occupation </b> <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <?php
                                // echo $stage_1_occupation['occupation_id'];
                                // print_r($occupation_list);

                                ?>
                                <select class="form-select" onchange="upload_auto(this.form)" id="occupation_id" name="occupation_id" required>
                                    <option value="" disabled selected>Select Occupation</option>
                                    <?php

                                    ?>
                                    <?php

                                    foreach ($occupation_list as $result) {
                                        if ($result['status'] != "inactive") {
                                    ?>
                                            <?php
                                            $selected = "";
                                            if (isset($stage_1_occupation['occupation_id'])) {
                                                if ($stage_1_occupation['occupation_id'] == $result['id']) {
                                                    $selected = "selected";
                                                }
                                            ?>
                                                <option <?= $selected ?> value="<?= $result['id'] ?>"> <?= $result['name'] ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Skills Assessment Program -->
                        <div class="row">
                            <div class="col-sm-5">
                                <legend class="col-form-label  "><b>Skills Assessment Program</b> <span class="text-danger">*</span></legend>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-check-inline">
                                    <label class="form-check-label form-control-lg p-0">
                                        <input class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="program" value="TSS" required <?php if ($stage_1_occupation['program'] == 'TSS') {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                        TSS
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label form-control-lg " style="margin-left:24px">
                                        <input class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="program" value="OSAP" required <?php if ($stage_1_occupation['program'] == 'OSAP') {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                        OSAP
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Pathway -->
                        <div class="row Hi_Lite ">
                            <div class="col-sm-5" style="display: flex; justify-content: center;align-items: center;">
                                <legend class="col-form-label ">
                                    <b>Pathway</b> <span class="text-danger">*</span>
                                </legend>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-check">
                                    <label class="form-check-label form-control-lg p-0">
                                        <input class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="pathway" value="Pathway_1" <?php $pathway = str_replace(' ', '', $stage_1_occupation['pathway']);
                                                                                                                                                        if ($stage_1_occupation['pathway'] == 'Pathway 1') {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?> require>
                                        Pathway 1 <br>
                                        <div style="font-size:70%"><mark class="text-success"> DO NOT </mark> hold an
                                            Australian AQF III Qualification or (AQF IV for Chef) in the occupation area
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label form-control-lg p-0 ">
                                        <input required class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="pathway" value="Pathway_2" <?php if ($stage_1_occupation['pathway'] == 'Pathway 2') {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>


                                        Pathway 2 <br>
                                        <div style="font-size:70%"> Currently hold an Australian AQF III Qualification
                                            or (AQF IV for Chef), in the occupation area</div>
                                    </label>
                                </div>
                            </div>
                        </div>



                        <!-- Are you currently in Australia -->
                        <div class="row ">
                            <div class="col-sm-5">
                                <b>
                                    <legend class="col-form-label">Are you currently in Australia <span class="text-danger">*</span></legend>
                                </b>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-check-inline">
                                    <label class="form-check-label form-control-lg p-0">
                                        <input class="form-check-input" required onchange="upload_auto(this.form)" type="radio" name="currently_in_australia" id="currently_in_australia_yes" onclick="fun_currently_Australi(this.value)" value="yes" <?php if ($stage_1_occupation['currently_in_australia'] == 'yes') {
                                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                                        } ?>>
                                        <span>Yes</span>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label form-control-lg" style="margin-left:25px">
                                        <input class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="currently_in_australia" id="currently_in_australia_no" onclick="fun_currently_Australi(this.value)" value="no" <?php if ($stage_1_occupation['currently_in_australia'] == 'no') {
                                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                                            } ?>>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>



                        <!-- Are you currently on a bridging Visa -->
                        <div id="DIV_bridging_visa" style="padding-left:12px; padding-right:12px">
                            <div class="row Hi_Lite id_row ">
                                <div class="col-sm-5">
                                    <legend class="col-form-label">
                                        <b> Are you currently on a bridging Visa</b> <span class="text-danger">*</span>
                                    </legend>
                                </div>
                                <div class="col-sm-7" style="margin-right: 0px;">
                                    <div class="form-check-inline">
                                        <label class="form-check-label form-control-lg p-0">
                                            <input class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="currently_on_bridging_visa" id="currently_on_bridging_visa_yes" onclick="Fun_currently_on_bridging_visa(this.value)" value="yes" <?php if ($stage_1_occupation['currently_on_bridging_visa'] == 'yes') {
                                                                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                                                                    } ?>>
                                            <span>Yes</span>
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label form-control-lg" style="margin-left:25px">
                                            <input class="form-check-input" onchange="upload_auto(this.form)" type="radio" name="currently_on_bridging_visa" id="currently_on_bridging_visa_no" onclick="Fun_currently_on_bridging_visa(this.value)" value="no" <?php if ($stage_1_occupation['currently_on_bridging_visa'] == 'no') {
                                                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                                                } ?>>
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Current Visa Category & Subclass -->
                        <div id="DIV_current_visa">
                            <div class="row id_row">
                                <div class="col-sm-5">
                                    <label for="current_visa_category" class="col-form-label">
                                        <b> Current Visa Category & Subclass </b> <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" onchange="upload_auto(this.form)" class="form-control" name="current_visa_category" id="current_visa_category" value="<?= $stage_1_occupation['current_visa_category'] ?>" />
                                </div>
                            </div>
                        </div>

                        <!-- Visa Expiry Date (dd/mm/yyyy) -->
                        <div id="DIV_visa_expiry" style="padding-left:12px; padding-right:12px">
                            <div class="row Hi_Lite id_row">
                                <div class="col-sm-5">
                                    <b> <label class="form-label">Visa Expiry Date (dd/mm/yyyy) <span class="text-danger">*</span></label></b>
                                </div>
                                <div class="col-sm-7">
                                    <?php
                                    $visha_date = "";
                                    // echo $stage_1_occupation['visa_expiry'];
                                    if ($stage_1_occupation['visa_expiry'] !=  "0000-00-00 00:00:00") {
                                        if ($stage_1_occupation['visa_expiry'] != "") {
                                            $visha_date = date('d/m/Y', strtotime($stage_1_occupation['visa_expiry']));
                                        }
                                    }
                                    ?>
                                    <input type="text" onchange="upload_auto(this.form)" class="form-control datepicker" name="visa_expiry" id="visa_expiry_date" ng-model="visa_expiry_date" placeholder="dd/mm/yyyy" value="<?= $visha_date ?>" maxlength="10" />
                                </div>
                            </div>
                        </div>

                        <!-- Which visa do you intend to apply for in conj -->
                        <div id="">
                            <div class="row id_row">
                                <div class="col-sm-5">
                                    <label for="conjunction_with_skills_assessment" class="form-label">
                                        <b>Which visa do you intend to apply for in conjunction with this skills
                                            assessment ?</b> <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="conjunction_with_skills_assessment" onchange="upload_auto(this.form)" id="conjunction_with_skills_assessment" required value="<?= $stage_1_occupation['conjunction_with_skills_assessment'] ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5 mb-3">
                            <input type="hidden" name="flow" value="stop">
                            <input type="submit" name="submit" class="btn btn_green_yellow" value="Save & Exit" />
                            <input type="submit" name="submit" class=" btn btn_yellow_green" value="Next" />
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


<script>
    $("#visa_expiry_date").on("change  paste", function() {
        let data = $("#visa_expiry_date").val();
        let dateParts = data.split("/");
        if (dateParts[2] < 2010) {
            $("#visa_expiry_date").val("");
            alert('Please Enter Valid Date.');
        }
    })


    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
        });
    });
    //  hide show  -----------------
    $(document).ready(function() {

        document.getElementById('DIV_bridging_visa').style.display = 'none';
        document.getElementById('DIV_current_visa').style.display = 'none';
        document.getElementById('DIV_visa_expiry').style.display = 'none';

        $("#currently_on_bridging_visa_yes").prop('required', false);
        $("#current_visa_category").prop('required', false);
        $("#visa_expiry_date").prop('required', false);



        <?php if ($stage_1_occupation['currently_on_bridging_visa'] == 'no') { ?> //  Are you currently on a bridging Visa *  
            document.getElementById('DIV_current_visa').style.display = 'block';
            document.getElementById('DIV_visa_expiry').style.display = 'block';
            $("#current_visa_category").prop('required', true);
            $("#visa_expiry_date").prop('required', true);
        <?php } else if ($stage_1_occupation['currently_on_bridging_visa'] == 'yes') { ?>
            document.getElementById('DIV_current_visa').style.display = 'none';
            document.getElementById('DIV_visa_expiry').style.display = 'none';
            $("#current_visa_category").prop('required', false);
            $("#visa_expiry_date").prop('required', false);
        <?php } ?>



        <?php if ($stage_1_occupation['currently_in_australia'] == 'yes') { ?> // Are you currently in Australia*
            document.getElementById('DIV_bridging_visa').style.display = 'block';

            $("#currently_on_bridging_visa_yes").prop('required', true);
        <?php } else  if ($stage_1_occupation['currently_in_australia'] == 'no') { ?>
            document.getElementById('DIV_bridging_visa').style.display = 'none';
            document.getElementById('DIV_current_visa').style.display = 'none';
            document.getElementById('DIV_visa_expiry').style.display = 'none';

            $("#currently_on_bridging_visa_yes").prop('required', false);
            $("#current_visa_category").prop('required', false);
            $("#visa_expiry_date").prop('required', false);
        <?php } ?>


        if ('a' == 'a') {
            $("#alert").fadeIn();
            $("#alert").fadeOut(5000);

        }

    });

    //  hide show  -----------------
    function fun_currently_Australi(data) { // Are you currently in Australia*
        if (data == 'no') {
            document.getElementById('DIV_bridging_visa').style.display = 'none';
            document.getElementById('DIV_current_visa').style.display = 'none';
            document.getElementById('DIV_visa_expiry').style.display = 'none';

            $("#currently_on_bridging_visa_yes").prop('required', false);
            $("#current_visa_category").prop('required', false);
            $("#visa_expiry_date").prop('required', false);

        } else if (data == 'yes') {
            document.getElementById('DIV_bridging_visa').style.display = 'block';

            $("#currently_on_bridging_visa_yes").prop('required', true);

        }
    }

    //  hide show  -----------------
    function Fun_currently_on_bridging_visa(data) {
        if (data == 'yes') { // Are you currently on a bridging Visa *
            document.getElementById('DIV_current_visa').style.display = 'none';
            document.getElementById('DIV_visa_expiry').style.display = 'none';
            $("#current_visa_category").prop('required', false);
            $("#visa_expiry_date").prop('required', false);
        } else if (data == 'no') {
            document.getElementById('DIV_current_visa').style.display = 'block';
            document.getElementById('DIV_visa_expiry').style.display = 'block';
            $("#current_visa_category").prop('required', true);
            $("#visa_expiry_date").prop('required', true);
        }
    }

    // Auto save on change ------------
    function upload_auto(Form_data) {

        var date = document.getElementById("visa_expiry_date").value;
        // alert(date);
        var check = dateIsValid(date);
        if (check == false) {
            document.getElementById("visa_expiry_date").value = "";
            // return false;
        }
        console.log(check);
        let ssss = $('#Occupation_Details').serialize();


        $.ajax({
            data: ssss,
            type: 'post',
            url: '<?= base_url('user/occupation_'); ?>', //done by jitendra
            success: function(data, textStatus, jqXHR) {
                // alert(data);
            }
        });



    }

    // text validation -----------
    function dateIsValid(dateStr) {
        const regex = /^\d{2}\/\d{2}\/\d{4}$/;

        if (dateStr.match(regex) === null) {
            return false;
        }

        const [day, month, year] = dateStr.split('/');

        // 👇️ format Date string as `yyyy-mm-dd`
        const isoFormattedStr = `${year}-${month}-${day}`;

        const date = new Date(isoFormattedStr);

        const timestamp = date.getTime();

        if (typeof timestamp !== 'number' || Number.isNaN(timestamp)) {
            return false;
        }

        return date.toISOString().startsWith(isoFormattedStr);
    }
</script>




<?= $this->endSection() ?>
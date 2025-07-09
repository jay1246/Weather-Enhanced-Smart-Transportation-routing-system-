<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>



<!-- stepper -->
<?php include("stepper.php")
?>


<style>
    .Hi_Lite {
        background-color: var(--offgray);
    }

    .id-row {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
    }

    .lable_2 {
        font-size: 10px;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .pl {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>



<!-- start -->
<div class="container-xxl  mt-4 mb-4">
    <div class="row">

        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">

            <!-- form name heading -->
            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Education Details
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>



            <!-- form start  -->
            <div class="row mt-3">
                <div class="col-sm-12">


                    <form class="row g-3 d-flex justify-content-center" id="Form_Education_Details" action="<?= base_url('user/education_employment_details_') ?>" method="post">
                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />

                        <!-- ---------------education and employment section------------------ -->
                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label ">
                                        <b> What is your highest COMPLETED school level ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-select" onchange="upload_auto(this.form)" aria-label="Default select example" name="highest_completed_school_level" required>
                                        <?php
                                        if (!empty($education_and_employment['highest_completed_school_level'])) {
                                            echo '<option value="' . $education_and_employment['highest_completed_school_level'] . '" > ' . str_replace('_', ' ', $education_and_employment['highest_completed_school_level'])  . '</option>';
                                        } else {
                                            echo '<option value=""  disabled  selected> Select An Option </option>';
                                        }
                                        ?>

                                        <option value="Year 8 or Below ">Year 8 or Below </option>
                                        <option value="Year 9 or equivalent">Year 9 or equivalent</option>
                                        <option value="Year 10 or equivalent">Year 10 or equivalent</option>
                                        <option value="Year 11 or equivalent">Year 11 or equivalent</option>
                                        <option value="Year 12 or equivalent">Year 12 or equivalent</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="">
                            <div class="row pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b>Are you still enrolled in secondary or senior secondary education ? </b>
                                        <span class="text-danger vv">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($education_and_employment['still_enrolled_in_secondary_or_senior_secondary_education'] == "yes") {
                                                                                                                            echo "checked";
                                                                                                                        } ?> name="are_you_still_enrolled" value="yes" required>
                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" style="margin-left: 15px;">
                                        <input required class="form-check-input" type="radio" onchange="upload_auto(this.form)" <?php if ($education_and_employment['still_enrolled_in_secondary_or_senior_secondary_education'] == "no") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> name="are_you_still_enrolled" value="no">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b>Have you SUCCESSFULLY completed any qualifications ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left: 0px;">
                                        <input class="form-check-input" required type="radio" id="completed_qualifications_yes" onchange="upload_auto(this.form)" <?php if ($education_and_employment['completed_any_qualifications'] == "yes") {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    } ?> name="completed_qualifications" onclick="completed(this.value)" value="yes">

                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" style="margin-left: 15px;">
                                        <input class="form-check-input" required id="completed_qualifications" type="radio" onchange="upload_auto(this.form)" <?php if ($education_and_employment['completed_any_qualifications'] == "no") {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                } ?> name="completed_qualifications" onclick="completed(this.value)" value="no">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div id="hide">
                            <div class="row pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> Please choose applicable qualifications </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-select" required aria-label="Default select example" onchange="upload_auto(this.form)" name="applicable_qualifications" id="applicable_qualifications">
                                        <?php
                                        if (!empty($education_and_employment['applicable_qualifications'])) {
                                            echo '<option value="' . $education_and_employment['applicable_qualifications'] . '" > ' . str_replace('_', ' ', $education_and_employment['applicable_qualifications'])  . '</option>';
                                        } else {
                                            echo '<option value=""  disabled  selected> Select An Option </option>';
                                        }
                                        ?>
                                        <option value="Certificate_I">Certificate I </option>
                                        <option value="Certificate_II_Other_Certificates">Certificate II Other Certificates </option>
                                        <option value="Certificate_III_or_Trade_Certificate">Certificate III or Trade Certificate</option>
                                        <option value="Certificate_IV_or_Advanced_Certificate">Certificate IV or Advanced Certificate</option>
                                        <option value="Diploma_or_Associate_Diploma">Diploma or Associate Diploma</option>
                                        <option value="Advanced_Diploma_or-Associate-Degree">Advanced Diploma or Associate Degree</option>
                                        <option value="Bachelor_Degree_or_Higher">Bachelor Degree or Higher</option>
                                        <option value="Other_Education">Other Education</option>

                                    </select>
                                </div>
                            </div>
                        </div>



                        <div id="specify_doc">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> Please Specify</b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" maxlength="300" id="specify_doc_name" value="<?= $education_and_employment['specify_doc_name'] ?>" class="form-control" name="specify_doc_name" required />
                                </div>
                            </div>
                        </div>


                        <h4 class="mb-3 mt-5 text-success text-center " style="font-size: 23px;">Employment Details</h4>

                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> What is your current employment status ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-select" onchange="upload_auto(this.form)" aria-label="Default select example" name="current_employment_status" required>
                                        <?php
                                        if (!empty($education_and_employment['current_employment_status'])) {
                                            echo '<option value="' . $education_and_employment['current_employment_status'] . '" > ' .  str_replace('_', ' ', $education_and_employment['current_employment_status'])  . '</option>';
                                        } else {
                                            echo '<option value=""  disabled  selected> Select An Option </option>';
                                        }
                                        ?>
                                        <option value="Full_Time_Employee">Full Time Employee</option>
                                        <option value="Part_Time_Employee">Part Time Employee</option>
                                        <option value="Self_Employed_not_employing_others">Self Employed, not employing others</option>
                                        <option value="Self_Employed_employing_others">Self Employed, employing others</option>
                                        <option value="Employed_unpaid_worker_in_family_business">Employed, unpaid worker in family business</option>
                                        <option value="Unemployed_seeking_full_time_work">Unemployed, seeking full-time work</option>
                                        <option value="Unemployed_seeking_part_time_work">Unemployed, seeking part time work</option>
                                        <option value="Not_employed_not_seeking_employment">Not employed, not seeking employment</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div id="">
                            <div class="row white pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> What BEST describes your main reason for undertaking this skills assessment ? </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-select" onchange="upload_auto(this.form)" label="Default select example" name="reason_for_undertaking_this_skills_assessment" required id="reason_for_undertaking_this_skills_assessment">
                                        <?php
                                        if (!empty($education_and_employment['reason_for_undertaking_this_skills_assessment'])) {
                                            echo '<option value="' . $education_and_employment['reason_for_undertaking_this_skills_assessment'] . '" > ' . str_replace('_', ' ', $education_and_employment['reason_for_undertaking_this_skills_assessment']) . '</option>';
                                        } else {
                                            echo '<option value=""  disabled  selected> Select An Option </option>';
                                        }
                                        ?>
                                        <option value="To_get_a_job">To get a job</option>
                                        <option value="To_develop_my_existing_business">To develop my existing business</option>
                                        <option value="To_start_my_own_business">To start my own business</option>
                                        <option value="To_try_a_different_career">To try a different career</option>
                                        <option value="To_get_a_better_job_or_promotion">To get a better job or promotion</option>
                                        <option value="It_was_a_requirement_of_my_job">It was a requirement of my job</option>
                                        <option value="I_wanted_extra_skills_for_my_job">I wanted extra skills for my job</option>
                                        <option value="To_get_into_another_course_of_study">To get into another course of study</option>
                                        <option value="For_personal_interest_or_self_development">For personal interest or self-development</option>
                                        <option value="To get_skills_for_community_voluntary_work">To get skills for community/ voluntary work</option>
                                        <option value="Other_Reasons_Skills_Assessment_(VISA)">Other Reasons - Skills Assessment (VISA)</option>
                                        <option value="Other_reasons">Other reasons</option>

                                    </select>
                                </div>
                            </div>
                        </div>


                        <div id="emp_specify_doc">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b> Please specify the reason </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" maxlength="300" value="<?= $education_and_employment['other_reason_for_undertaking'] ?>" id="other_reason_for_undertaking" class="form-control" name="other_reason_for_undertaking" required />
                                </div>
                            </div>
                        </div>



                        <div class="text-center mt-5 mb-3">
                            <a href="<?= base_url('user/stage_1/usi_avetmiss/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green">Back</a>
                            <input type="submit" name="submit" class="btn btn_green_yellow" value="Save & Exit" />
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

<script>
    $('#completed_qualifications').click(function() {
        $('#applicable_qualifications').prop('required', '');
        // $('#other_reason_for_undertaking').prop('required', '');
        $('#specify_doc_name').prop('required', '');
        document.getElementById('applicable_qualifications').style.display = 'none';
        document.getElementById('specify_doc').style.display = 'none';

    });

    $('#completed_qualifications_yes').click(function() {

        document.getElementById("applicable_qualifications").required = true;
        document.getElementById("specify_doc_name").required = true;

        document.getElementById('applicable_qualifications').style.display = 'block';
        document.getElementById('specify_doc_name').style.display = 'block';

    });

    $('#applicable_qualifications').on('change', function() { // new change on 1-lul-22
        // $('#applicable_qualifications').click(function() {
        var result = $(this).val();
        // console.log(result);
        if (result == 'Other_Education') {
            document.getElementById('specify_doc').style.display = 'block';

        } else {
            document.getElementById('specify_doc').style.display = 'none';

            $('#specify_doc_name').prop('required', '');
        }
    });

    document.getElementById('hide').style.display = 'none';
    document.getElementById('specify_doc').style.display = 'none';

    $(document).ready(function() {

        <?php if ($education_and_employment['reason_for_undertaking_this_skills_assessment'] == "Other_reasons") { ?>
            document.getElementById('emp_specify_doc').style.display = 'block';
            document.getElementById("other_reason_for_undertaking").required = true;
        <?php } else { ?>
            document.getElementById('emp_specify_doc').style.display = 'none';
            $('#other_reason_for_undertaking').prop('required', '');

        <?php } ?>

        <?php
        if ($education_and_employment['applicable_qualifications'] == "Other_Education") { ?>
            var result = $('#applicable_qualifications').val();
            if (!result == 'Other_Education') {
                document.getElementById('specify_doc').style.display = 'none';
                $('#specify_doc_name').prop('required', '');
            } else {

                document.getElementById('specify_doc').style.display = 'block';

            }

        <?php  }  ?>


        <?php if ($education_and_employment['completed_any_qualifications'] == "no") { ?>
            document.getElementById('hide').style.display = 'none';
            $('#applicable_qualifications').prop('required', '');
            $('#specify_doc_name').prop('required', '');
        <?php } else  if ($education_and_employment['completed_any_qualifications'] == "yes") { ?>
            document.getElementById('hide').style.display = 'block';
            var result = $('#applicable_qualifications').val();
            // console.log(result);
            if (result == 'Other_Education') {
                document.getElementById('specify_doc').style.display = 'block';
            } else {
                document.getElementById('specify_doc').style.display = 'none';
                $('#specify_doc_name').prop('required', '');
            }
        <?php } else { ?>
            document.getElementById('hide').style.display = 'none';
        <?php } ?>



        $('#applicable_qualifications').change(function() {
            var result = $(this).val();
            if (result == 'Other_Education') {
                document.getElementById('specify_doc').style.display = 'block';
                document.getElementById("specify_doc_name").required = true;
            } else {
                document.getElementById('specify_doc').style.display = 'none';
            }
        });


        $('#reason_for_undertaking_this_skills_assessment').change(function() {
            var result = $(this).val();
            // console.log(result);
            if (result == 'Other_reasons') {
                document.getElementById("other_reason_for_undertaking").required = true;

                document.getElementById('emp_specify_doc').style.display = 'block';
            } else {
                $('#other_reason_for_undertaking').prop('required', '');

                document.getElementById('emp_specify_doc').style.display = 'none';
            }
        });

        var applicable_qualifications_result = $('#applicable_qualifications').val();
        if (applicable_qualifications_result == 'Other_Education') {
            document.getElementById('specify_doc').style.display = 'block';
            document.getElementById("specify_doc_name").required = true;
        } else {
            document.getElementById('specify_doc').style.display = 'none';
        }

    });

    function completed(data) {
        if (data == 'no') {
            document.getElementById('hide').style.display = 'none';

        } else {
            document.getElementById('hide').style.display = 'block';

        }
    }

    function upload_auto(Form_data) {
        let ssss = $('#Form_Education_Details').serialize();
        // console.log(ssss);
        $.ajax({
            data: ssss,
            type: 'post',
            url: '<?php echo base_url('user/education_employment_details_'); ?>',
            error: function() {
                //   alert('Auto Upload is OFF ');
            },
            success: function(data, textStatus, jqXHR) {
                //  alert(data);
            }
        });
    }
</script>
<?= $this->endSection() ?>
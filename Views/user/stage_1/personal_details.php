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

    .form-control-lg {
        font-size: inherit !important;
    }

    .check_box {
        /* width: 19px;
        height: 17px; */
        width: 1em;
        height: 1em;
    }
</style>

<!-- start -->
<div class="container-xxl mt-4 mb-2">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">

            <!-- form name heading -->
            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Personal details ( As Per Passport)
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>

            <?php
            // echo "<pre>";
            // print_r($account_data);
            // echo "</pre>";
            ?>
            <!-- form start  -->
            <div class="row mt-5 ">
                <div class="col-sm-12">

                    <form class="row g-3 d-flex justify-content-center" id="Personal_details" autocomplete="off" action="<?= base_url('user/personal_details_') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />


                        <div id="">
                            <div class="row Hi_Lite ">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label" style="margin-left: 16px;">
                                        <b>Preferred Title</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select required onchange="upload_auto(this.form, this)" class="form-select" style="max-width: 20000px;width:100%" aria-label="Default select example" name="preferred_title">
                                        <!-- <option selected> <?= $personal_details['preferred_title'] ?></option> -->
                                        <option <?php
                                                if ($personal_details['preferred_title'] == "Mr.") {
                                                    echo "selected";
                                                }
                                                ?> value="Mr.">Mr.</option>

                                        <option <?php
                                                if ($personal_details['preferred_title'] == "Mrs.") {
                                                    echo "selected";
                                                }
                                                ?> value="Mrs.">Mrs.</option>

                                        <option <?php
                                                if ($personal_details['preferred_title'] == "Miss.") {
                                                    echo "selected";
                                                }
                                                ?> value="Miss.">Miss.</option>

                                        <option <?php
                                                if ($personal_details['preferred_title'] == "Ms.") {
                                                    echo "selected";
                                                }
                                                ?> value="Ms.">Ms.</option>

                                        <option <?php
                                                if ($personal_details['preferred_title'] == "Others.") {
                                                    echo "selected";
                                                }
                                                ?> value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div id="div_surname_family_name" class="white">
                            <!-- hide_surname -->
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label" style="margin-left: 16px;">
                                        <b>Surname / Family Name</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input onchange="upload_auto(this.form, this)" value="<?= (empty($personal_details['surname_family_name']) ? $account_data['last_name'] : $personal_details['surname_family_name']) ?>" type="text" class="form-control" id="surname_family_name" name="surname_family_name" />
                                </div>
                            </div>
                        </div>


                        <div id="">
                            <!-- hide_surname -->
                            <div class="row Hi_Lite">
                                <div class="col-sm-5">
                                    <label for="only_have_single_name" class="col-form-label " style="margin-left: 15px;">
                                        <b> I only have a single Name </b>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input name="other_name" onkeydown="return /[a-z]/i.test(event.key)" class="form-check-input mt-2 check_box" type="checkbox" id="only_have_single_name" onchange="upload_auto(this.form, this)" <?php
                                                                                                                                                                                                                                    if ($personal_details['other_name'] == 'checked') {
                                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    ?> value="checked">
                                </div>
                            </div>
                        </div>





                        <div class="white">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label " style="margin-left: 16px;">
                                        <b> First or Given Name</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input onchange="upload_auto(this.form, this)" style=" margin-left:1px;" value="<?= (empty($personal_details['first_or_given_name']) ? $account_data['name'] : $personal_details['first_or_given_name']) ?>" type="text" class="form-control" name="first_or_given_name" required />
                                </div>
                            </div>
                        </div>

                        <div id="div_Middle_names">
                            <div class="row Hi_Lite">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label " style="margin-left: 16px;">
                                        <b> Middle Name </b>
                                        <!-- <span class="text-danger">*</span> -->
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <!-- <?= $personal_details['middle_names'] ?> -->
                                    <input onchange="upload_auto(this.form, this)" style=" margin-left:1px;" value="<?= (empty($personal_details['middle_names']) ? $account_data['middle_name'] : $personal_details['middle_names']) ?>" type="text" class="form-control" name="middle_names" id="Middle_names" />
                                </div>
                            </div>
                        </div>


                        <div id="">
                            <div class="row Hi_Lite id-row">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label">
                                        <b> Are you known by any other Name</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" style="padding-left : 0px">
                                        <input onchange="upload_auto(this.form, this)" class="form-check-input" type="radio" name="known_by_any_name" value="yes" <?php if ($personal_details['known_by_any_name'] == "yes") {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    } ?> onclick="fun_known_by_any_name(this.value)" required>
                                        <span>Yes</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                        <input onchange="upload_auto(this.form, this)" id="known_by_any_name" class="form-check-input" type="radio" name="known_by_any_name" value="no" <?php if ($personal_details['known_by_any_name'] == "no") {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?> onclick="fun_known_by_any_name(this.value)">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>




                        <div id="div_previous_surname_or_family_name">
                            <div class="row id-row">
                                <div class="col-sm-5">
                                    <label for="previous_surname_or_family_name" class="col-form-label">
                                        <b> Previous surname or family Name</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7" style=" padding-right:0px ">
                                    <input onchange="upload_auto(this.form, this)" id="previous_surname_or_family_name" value="<?php echo $personal_details['previous_surname_or_family_name']; ?>" type="text" class="form-control" name="previous_surname_or_family_name" style=" margin-left:1px;" />
                                </div>
                            </div>
                        </div>



                        <div id="div_checkbox_only_had_name">
                            <!-- hide_surname -->
                            <div class="row id-row Hi_Lite">
                                <div class="col-sm-5">
                                    <label for="checkbox_only_had_name" class="col-form-label " style="margin-left: 6px;">
                                        <span> <b> I only had one Name </b> </span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input onchange="upload_auto(this.form, this)" class="form-check-input mt-2 check_box" onclick="checkboame(this.value)" <?php if ($personal_details['checkbox_only_had_name'] == "checked") {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?> value="checked" type="checkbox" name="checkbox_only_had_name" id="checkbox_only_had_name">
                                </div>
                            </div>
                        </div>



                        <div id="div_only_one_name" class="white">
                            <div class="row ">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label" style="margin-left: 16px;">
                                        <b> Previous first or given Name</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input onchange="upload_auto(this.form, this)" id="only_one_name" value="<?= $personal_details['previous_names'] ?>" type="text" class="form-control" name="previous_names" />
                                </div>
                            </div>
                        </div>


                        <div class="Hi_Lite" id="div_previous_Middle_names">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label " style="margin-left: 16px;">
                                        <b> Previous Middle Name </b>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input onchange="upload_auto(this.form, this)" style=" margin-left:1px;" value="<?php if (isset($personal_details['previous_middle_names'])) {
                                                                                                                        echo  $personal_details['previous_middle_names'];
                                                                                                                    } ?>" type="text" class="form-control" name="previous_middle_names" id="previous_Middle_names">
                                </div>
                            </div>
                        </div>

                        <div id="">
                            <div class="row Hi_Lite">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label " style="margin-left: 15px !important">
                                        <b> Gender</b> <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <label class="form-check-label form-control-lg" for="gender_Male" style="padding-left : 0px; ">
                                        <input onchange="upload_auto(this.form, this)" <?php if ($personal_details['gender'] == "Male") {
                                                                                            echo "checked";
                                                                                        } ?> class="form-check-input" type="radio" name="gender" id="gender_Male" value="Male" required>
                                        <span>Male</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="gender_Female" style="margin-left: 15px;">
                                        <input onchange="upload_auto(this.form, this)" <?php if ($personal_details['gender'] == "Female") {
                                                                                            echo "checked";
                                                                                        } ?> class="form-check-input" type="radio" name="gender" id="gender_Female" value="Female">
                                        <span>Female</span>
                                    </label>
                                    <label class="form-check-label form-control-lg" for="gender_Other" style="margin-left: 15px;">
                                        <input onchange="upload_auto(this.form, this)" <?php if ($personal_details['gender'] == "Other") {
                                                                                            echo "checked";
                                                                                        } ?> class="form-check-input" type="radio" name="gender" id="gender_Other" value="Other">
                                        <span>Other</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div id="previous_surname_or_family_name" class="white">
                            <div class="row ">
                                <div class="col-sm-5">
                                    <label for="" class="col-form-label " style="margin-left: 16px;">
                                        <b> Date of Birth (dd/mm/yyyy)</b> <span class="text-danger">*</span>
                                    </label>
                                </div>


                                <div class="col-sm-7">
                                    <input type="text" maxlength="10" id="date" name="date_of_birth" value="<?php echo $personal_details['date_of_birth']?>" onchange="upload_auto(this.form, this)" class="form-control datepicker" required />
                                </div>
                            </div>
                        </div>


                        <br><br>
                        <div class="text-center mt-5 mb-3">

                            <a href="<?= base_url('user/stage_1/occupation/' . $ENC_pointer_id) ?>" class=" btn btn_yellow_green">Back</a>
                            <a type="submit" href="<?= base_url('user/dashboard') ?>" name="submit" class="btn btn_green_yellow">Save & Exit</a>
                            <input type="submit" onclick="getAge()" name="submit" id="action_validation_btn" class="btn btn_yellow_green" value="Next" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div> <br>
<br>
<br>


<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>



<script>
    $(function() {
        // $(".datepicker").datepicker();
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            //     // // yearRange: '-90:-16',
            //     // showButtonPanel: true
        });
    });


    // check date is valid or not 
    function getAge() {
        var bla = $('#date').val();
        const [d, M, y] = bla.match(/\d+/g);

        var birthDate = new Date(y, M, d); // {object Date}
        console.log(birthDate.getMonth());

        if (birthDate != "") {
            var today = new Date();
            var birthDate = new Date(y, M, d); // {object Date}
            var age = today.getFullYear() - birthDate.getFullYear();


            if (age >= 16 && age < 100) {
                console.log(age + "  allow");
                $('#ax').html("");
                $(".next").removeClass("disabled");
                return true;
            } else {
                $('#ax').html("Only above 16 years can apply.");
                $("#alert_date").fadeIn();
                $(".next").addClass("disabled");
                return false;
            }
        } else {
            alert("please provide your date of birth");
            return false;
        }
    }

    // check hide show from database data 
    $(document).ready(function() {
        // part 1 -------------
        $("#div_surname_family_name").prop('required', true);
        document.getElementById('div_surname_family_name').style.display = 'block';
        <?php if ($personal_details['other_name'] == 'checked') {   ?>
            $("#surname_family_name").prop('required', false);
            $("#Middle_names").prop('required', false);
            document.getElementById('div_surname_family_name').style.display = 'none';
            document.getElementById('div_Middle_names').style.display = 'none';
        <?php   } else {  ?>
            $("#surname_family_name").prop('required', true);
            document.getElementById('div_surname_family_name').style.display = 'block';
            document.getElementById('div_Middle_names').style.display = 'block';
        <?php   }  ?>

        // part 2 -------------
        document.getElementById('div_previous_surname_or_family_name').style.display = 'none';
        $("#previous_surname_or_family_name").prop('required', false);
        document.getElementById('div_checkbox_only_had_name').style.display = 'none';
        $("#checkbox_only_had_name").prop('required', false);
        document.getElementById('div_only_one_name').style.display = 'none';
        $("#only_one_name").prop('required', false);
        document.getElementById('div_previous_Middle_names').style.display = 'none';

        <?php if ($personal_details['known_by_any_name'] == "yes") {   ?>
            document.getElementById('div_previous_surname_or_family_name').style.display = 'block';
            $("#previous_surname_or_family_name").prop('required', true);
            document.getElementById('div_only_one_name').style.display = 'block';
            $("#only_one_name").prop('required', true);
            document.getElementById('div_checkbox_only_had_name').style.display = 'block';
            document.getElementById('div_previous_Middle_names').style.display = 'block';

            // second step
            <?php if ($personal_details['checkbox_only_had_name'] == "checked") { ?>
                document.getElementById('div_previous_surname_or_family_name').style.display = 'none';
                $("#previous_surname_or_family_name").prop('required', false);
                document.getElementById('div_previous_Middle_names').style.display = 'none';
            <?php   } else {  ?>
                document.getElementById('div_previous_surname_or_family_name').style.display = 'block';
                $("#previous_surname_or_family_name").prop('required', true);
                document.getElementById('div_previous_Middle_names').style.display = 'block';
            <?php   }  ?>


        <?php   } else if ($personal_details['known_by_any_name'] == "no") { ?>
            document.getElementById('div_previous_surname_or_family_name').style.display = 'none';
            $("#previous_surname_or_family_name").prop('required', false);
            document.getElementById('div_only_one_name').style.display = 'none';
            $("#only_one_name").prop('required', false);
            document.getElementById('div_checkbox_only_had_name').style.display = 'none';
            document.getElementById('div_previous_Middle_names').style.display = 'none';
        <?php   }  ?>
    });

    // hide show from on user call funtion
    function fun_known_by_any_name(onlyonename) {
        if (onlyonename == 'no') {
            document.getElementById('div_previous_surname_or_family_name').style.display = 'none';
            $("#previous_surname_or_family_name").prop('required', false);
            document.getElementById('div_only_one_name').style.display = 'none';
            $("#only_one_name").prop('required', false);
            document.getElementById('div_checkbox_only_had_name').style.display = 'none';
            document.getElementById('div_previous_Middle_names').style.display = 'none';
            $("#previous_Middle_names").prop('required', false);
        } else if (onlyonename == 'yes') {
            document.getElementById('div_previous_surname_or_family_name').style.display = 'block';
            $("#previous_surname_or_family_name").prop('required', true);
            document.getElementById('div_only_one_name').style.display = 'block';
            $("#only_one_name").prop('required', true);
            document.getElementById('div_checkbox_only_had_name').style.display = 'block';
            document.getElementById('div_previous_Middle_names').style.display = 'block';
        }
    }

    // text validate 
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

    // auto save on change inpput 
    function upload_auto(Form_data, that, isAlphabet = false) {
        if (__check__form__validation(that, isAlphabet) == false) {
            console.log("Form Error");
            return;
        }
        var date = document.getElementById("date").value;
        var check = dateIsValid(date);
        if (check == false) {
            document.getElementById("date").value = "";
            // return false;
        }
        console.log(check);

        let ssss = $('#Personal_details').serialize();

        $.ajax({
            data: ssss,
            type: 'post',
            url: '<?php echo base_url('user/personal_details_'); ?>',
            success: function(data, textStatus, jqXHR) {
                // alert(data);
            }
        });
    }

    // on submit form call funtion 
    $('form').submit(function() {
        // check date is valid
        getAge();
    });

    // hide show from on user call funtion
    $("#checkbox_only_had_name").click(function() {
        if ($('#checkbox_only_had_name').is(":checked")) {
            document.getElementById('div_previous_surname_or_family_name').style.display = 'none';
            $("#previous_surname_or_family_name").prop('required', false);
            document.getElementById('div_previous_Middle_names').style.display = 'none';
        } else {
            document.getElementById('div_previous_surname_or_family_name').style.display = 'block';
            $("#previous_surname_or_family_name").prop('required', true);
            document.getElementById('div_previous_Middle_names').style.display = 'block';
        }
    });


    // hide show from on user call funtion
    $("#only_have_single_name").click(function() {
        if ($('#only_have_single_name').is(":checked")) {
            $("#surname_family_name").prop('required', false);
            $("#Middle_names").prop('required', false);
            document.getElementById('div_surname_family_name').style.display = 'none';
            document.getElementById('div_Middle_names').style.display = 'none';
        } else {
            $("#surname_family_name").prop('required', true);
            document.getElementById('div_surname_family_name').style.display = 'block';
            document.getElementById('div_Middle_names').style.display = 'block';
        }
    });
</script>
<?= $this->endSection() ?>
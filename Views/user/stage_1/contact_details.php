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
        margin-top: -20px !important;
        margin-bottom: 5px !important;
    }

    .form-label {
        margin-bottom: 1px !important;
        margin-top: 3px !important;
    }
</style>



<!-- start -->
<div class="container-xxl  mt-4 mb-4">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow p-2">

            <!-- form name heading -->
            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Contact Details
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>

            <!-- form start  -->
            <div class="row mt-5 ">
                <div class="col-sm-12">

                    <form class="row g-3 d-flex justify-content-center" id="Contact_Details_form" action="<?= base_url('user/contact_details_') ?>" method="post">
                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />

                        <!-- Address -->
                        <div class=" Hi_Lite" style="padding: 10px;">
                            <div class="row " style="padding: 10px;">
                                <b>
                                    <h5 style="margin-left: 0px;">
                                        Residential Address
                                    </h5>
                                </b>
                                <div class="col-md-6 mb-1 ">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>

                                    <select required class="form-select" onchange="upload_auto(this.form,this)" aria-label="Default select example" id="country" name="country">
                                        <?php
                                        if (isset($Residential_country)) {
                                            if (!empty($Residential_country)) {
                                                echo '<option value="' . $Residential_country . '" > ' . $Residential_country . '</option>';
                                            } else {
                                                echo '<option value="">--Select Country--</option>';
                                            }
                                        }
                                        ?>
                                        <?php foreach ($country_list as $result) { ?>
                                            <option value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                        <?php } ?>
                                    </select>

                                </div>

                                <div class="col-md-6 mb-1 ">
                                    <div style="display: none;">
                                        <label for="building_prop_name" class="form-label">Building / Prop.name</label>
                                        <input type="text" onchange="upload_auto(this.form,this)" value="<?= $Residential_building_prop_name ?>" class="form-control" id="building_prop_name" name="building_prop_name" />
                                    </div>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label for="unit_flat_number" class="form-label">Unit / Flat Number</label>
                                    <input type="text" onchange="upload_auto(this.form,this)" value="<?= $Residential_unit_flat_number ?>" class="form-control" id="unit_flat_number" name="unit_flat_number" />
                                </div>


                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">Street / lot Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onchange="upload_auto(this.form,this)" value="<?= $Residential_street_lot_number ?>" id="street_lot_number" name="street_lot_number" required />
                                </div>

                                <div class="col-md-6 mb-1 ">
                                    <label for="inputNanme4" class="form-label">Street Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onchange="upload_auto(this.form,this)" value="<?= $Residential_street_name ?>" id="street_name" name="street_name" required />
                                </div>

                                <div class="col-md-6 mb-1 ">
                                    <label for="inputNanme4" class="form-label">Suburb / City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onchange="upload_auto(this.form,this)" value="<?= $Residential_suburb ?>" id="suburb" name="suburb" required />
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">State / Province <span class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" onchange="upload_auto(this.form,this)" value="<?= $Residential_state_proviance ?>" id="state_proviance" name="state_proviance" />
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">Postcode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onchange="upload_auto(this.form,this)" value="<?= $Residential_postcode ?>" id="postcode" name="postcode" required />
                                </div>

                                <div class="col-md-6 mb-1 ">
                                    <label for="inputNanme4" class="form-label">Email <span class="text-danger">*</span></label>

                                    <input type="email" <?php if (is_Applicant()) {
                                                            echo "required readonly";
                                                        } ?> class="form-control" onchange="upload_auto(this.form,this)" value="<?= $Residential_email ?>" id="email" name="email" required />
                                    <span style="color: red;font-size:80%" id="emai_alert"></span>
                                </div>

                                <div class="col-md-6 mb-1 ">
                                    <label for="inputNanme4" class="form-label">Alternate Email</label>
                                    <input type="email" class="form-control" id="alter_email" onchange="upload_auto(this.form,this)" value="<?= $Residential_alternate_email ?>" name="alternate_email" />
                                </div>

                                <!-- Mobile Number -->
                                <div class="col-md-6">
                                    <label class="form-label" style="margin-bottom: 0px;">
                                        Mobile Number <span class="text-danger">*</span>
                                    </label>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-5" style="padding-right:0px;">
                                            <span class="lable_2"> Country code </span>
                                            <br>
                                            <select onchange="upload_auto(this.form,this)" class="form-control " required name="mobile_number_code">
                                                <?php if (isset($country_list)) {
                                                    foreach ($country_list as $key => $value) {
                                                        $contry_id = 13;
                                                        if (isset($Residential_mobile_number_code)) {
                                                            if ($value['id'] == $Residential_mobile_number_code) {
                                                                $contry_id =  $value['id'];
                                                            } else {
                                                                $contry_id = 13;
                                                            }
                                                        }
                                                        if ($value['id'] == $contry_id) {   ?>
                                                            <option value="<?= $value['id'] ?>" Selected> <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                                        <?php } else {  ?>
                                                            <option value="<?= $value['id'] ?>"> <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-7">
                                            <span class="lable_2"> Number </span>
                                            <br>
                                            <input type="number" class="form-control" onchange="upload_auto(this.form,this)" name="mobile_number" class="form-control" value="<?= $Residential_mobile_number ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <!-- Alternate Mobile -->
                                <div class="col-md-6">
                                    <label class="form-label" style="margin-bottom: 0px;"> Alternate Mobile </label><br>
                                    <div class="row">
                                        <div class="col-sm-5" style="padding-right:0px;">
                                            <span class="lable_2"> Country code </span>
                                            <br>
                                            <select onchange="upload_auto(this.form,this)" style="" class="form-control txbox" name="alter_mobile_code" required>
                                                <?php if (isset($country_list)) {
                                                    foreach ($country_list as $key => $value) {
                                                        $contry_id = 13;

                                                        if (isset($Residential_alter_mobile_code)) {
                                                            if (!empty($Residential_alter_mobile_code)) {
                                                                if ($value['id'] == $Residential_alter_mobile_code) {
                                                                    $contry_id =  $value['id'];
                                                                } else {
                                                                    $contry_id = 13;
                                                                }
                                                            }
                                                        }

                                                        if ($value['id'] == $contry_id) {   ?>
                                                            <option value="<?= $value['id'] ?>" Selected> <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $value['id'] ?>"> <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                                        <?php   } ?>

                                                <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-7">
                                            <span class="lable_2"> Number </span>
                                            <br>
                                            <input type="number" class="form-control txbox" onchange="upload_auto(this.form,this)" placeholder="" name="alter_mobile" class="form-control" value="<?= $Residential_alter_mobile ?>" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Postal Address  :-  Yes No  -->
                        <div class="row mt-4 ">
                            <div class="col-sm-6">
                                <label for="" class="col-form-label">
                                    <b> Is your Postal Address is same as your Residential Address </b>
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-check-label form-control-lg">
                                    <input id="postal_address_is_different" class="form-check-input" type="radio" onchange="upload_auto(this.form,this)" <?php if (!empty($postal_address_is_different)) {
                                                                                                                                                                if ($postal_address_is_different == "yes") {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                }
                                                                                                                                                            } else {
                                                                                                                                                                echo "checked";
                                                                                                                                                            }
                                                                                                                                                            ?> name="postal_address_is_different" onclick="postal_hide(this.value)" value="yes" required>
                                    <span>Yes</span>
                                </label>
                                <label class="form-check-label form-control-lg" for="known_by_any_name" style="margin-left: 15px;">
                                    <input class="form-check-input" type="radio" onchange="upload_auto(this.form,this)" <?php if ($postal_address_is_different == "no") {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                        ?> name="postal_address_is_different" onclick="postal_hide(this.value)" value="no">
                                    <span>No</span>

                                </label>
                            </div>
                        </div>
                        <!-- Postal Address -->
                        <div id="postal_box" class="mt-4 Hi_Lite id-row" style="padding: 10px;">

                            <div class="row  id-row " style="padding: 10px;">
                                <b>
                                    <h5>Postal Address</h5>
                                </b>
                                <div class="col-md-6 mb-1 ">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>

                                    <select class="form-select" aria-label="Default select example" onchange="upload_auto(this.form,this)" name="Postal_country" required>
                                        <option value="Australia" selected>Australia</option>
                                        <?php
                                        if (!empty($Postal_country)) { ?>
                                            <option selected> <?= $Postal_country ?></option>
                                        <?php }  ?>
                                        <?php foreach ($country_list as $result) { ?>
                                            <option value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                        <?php } ?>
                                    </select>

                                </div>


                                <div class="col-md-6 mb-1 ">
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">Unit / Flat Number</label>
                                    <input type="text" class="form-control" id="postal_unit_flat_number" onchange="upload_auto(this.form,this)" value="<?= $postal_unit_flat_number ?>" name="postal_unit_flat_number">
                                </div>


                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">Street / lot Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="postal_street_lot_number" onchange="upload_auto(this.form,this)" value="<?= $postal_street_lot_number ?>" name="postal_street_lot_number" required />
                                </div>

                                <div class="col-md-6 mb-1 ">
                                    <label for="inputNanme4" class="form-label">Street Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="postal_street_name" onchange="upload_auto(this.form,this)" value="<?= $postal_street_name ?>" name="postal_street_name" required />
                                </div>



                                <div class="col-md-6 mb-1 ">
                                    <label for="inputNanme4" class="form-label">Suburb / City <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="postal_suburb" onchange="upload_auto(this.form,this)" value="<?= $postal_suburb ?>" name="postal_suburb" required />
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">State / Province <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="postal_state_proviance" onchange="upload_auto(this.form,this)" value="<?= $postal_state_proviance ?>" name="postal_state_proviance" required />
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label for="inputNanme4" class="form-label">Postcode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="postal_postcode" onchange="upload_auto(this.form,this)" value="<?= $postal_postcode ?>" name="postal_postcode" required />
                                </div>



                            </div>
                        </div>


                        <!-- Emergency Tital  -->
                        <h4 class="text-green text-center mt-5 mb-3" style="font-size: 20px;">Emergency Contact Details</h4>
                        <!-- Emergency form -->
                        <div class=" Hi_Lite ">
                            <div class="row mb-2 mt-2" style="padding: 10px;">
                                <div class="col-md-6">
                                    <label for="inputNanme4" class="form-label">First Name <span class="text-danger">*</span> </label>
                                    <input type="text" maxlength="20" class="form-control" id="inputNanme4" onchange="upload_auto(this.form,this,true)" value="<?= $Emergency_first_name ?>" name="first_name" required />
                                </div>

                                <div class="col-md-6">
                                    <label for="inputNanme4" class="form-label">Surname <span class="text-danger">*</span> </label>
                                    <input type="text" maxlength="20" class="form-control" id="inputNanme4" onchange="upload_auto(this.form,this,true)" value="<?= $Emergency_surname ?>" name="surname" required />
                                </div>

                                <div class="col-md-6" style="padding-top: 15px;">
                                    <label for="inputNanme4" class="form-label">Relationship <span class="text-danger">*</span> </label>

                                    <input type="text" maxlength="20" class="form-control" id="inputNanme4" onchange="upload_auto(this.form,this,true)" value="<?= $Emergency_relationship ?>" name="relationship" required />
                                </div>

                                <div class="col-md-6 ">
                                    <label class="form-label" style="margin-bottom: 0px;">
                                        Mobile Number <span class="text-danger">*</span>
                                    </label>
                                    <br>
                                    <div class="row ">
                                        <div class="col-sm-5" style="padding-right:0px;">
                                            <span class="lable_2"> Country code </span>
                                            <br>
                                            <select onchange="upload_auto(this.form,this)" style="" class="form-control txbox" name="emergency_mobile_code">
                                                <?php if (isset($country_list)) {
                                                    foreach ($country_list as $key => $value) {
                                                        $contry_id = 13;
                                                        if (isset($Emergency_emergency_mobile_code)) {
                                                            if ($value['id'] == $Emergency_emergency_mobile_code) {
                                                                $contry_id =  $value['id'];
                                                            }
                                                        }

                                                        if ($value['id'] == $contry_id) {   ?>
                                                            <option value="<?= $value['id'] ?>" Selected> <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $value['id'] ?>"> <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                                        <?php } ?>


                                                <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-7 ">
                                            <span class="lable_2"> Number </span>
                                            <br>
                                            <input type="number" class="form-control txbox" onchange="upload_auto(this.form,this)" name="emergency_mobile" class="form-control" style="" value="<?= $Emergency_emergency_mobile ?>" required />
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <!-- Next back submit Button  -->
                        <div class="text-center mt-5 mb-3">
                            <a href="<?= base_url('user/stage_1/personal_details/' . $ENC_pointer_id) ?>" class=" btn btn_yellow_green">Back</a>
                            <input type="submit" name="submit" class="btn btn_green_yellow" value="Save & Exit" />
                            <!-- <a href="<?= base_url('user/dashboard/') ?>" name="submit" class="btn btn_green_yellow">Save & Exit</a> -->
                            <input type="submit" id="action_validation_btn" name="submit" class="btn btn_yellow_green" value="Next" />
                        </div>

                    </form><!-- Vertical Form -->
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
    var alter_mobile_mobile_no = "";
    var mobile_mobile_no = "";
    var em_mobile_mobile_no = "";

    $check = $('#postal_address_is_different').val();
    if ($check == 'yes') {
        $('#postal_unit_flat_number').prop('required', '');
        $('#postal_street_lot_number').prop('required', '');
        $('#postal_street_name').prop('required', '');
        $('#postal_suburb').prop('required', '');
        $('#postal_state_proviance').prop('required', '');
        $('#postal_postcode').prop('required', '');
    }


    $('#postal_address_is_different').click(function() {
        // $('#postal_building_prop').prop('required', '');

        $check = $('#postal_address_is_different').val();
        // alert($check);
        if ($check == 'yes') {
            $('#postal_unit_flat_number').prop('required', '');
            $('#postal_street_lot_number').prop('required', '');
            $('#postal_street_name').prop('required', '');
            $('#postal_suburb').prop('required', '');
            $('#postal_state_proviance').prop('required', '');
            $('#postal_postcode').prop('required', '');
        }
    });

    //   Hide Alert bar                                              
    $(document).ready(function() {
        document.getElementById('postal_box').style.display = 'none';

        <?php if ($postal_address_is_different == "yes") { ?>
            // $('#postal_building_prop').prop('required', '');
            $('#postal_unit_flat_number').prop('required', '');
            $('#postal_street_lot_number').prop('required', '');
            $('#postal_street_name').prop('required', '');
            $('#postal_suburb').prop('required', '');
            $('#postal_state_proviance').prop('required', '');
            $('#postal_postcode').prop('required', '');
            document.getElementById('postal_box').style.display = 'none';
        <?php } else if ($postal_address_is_different == "no") { ?>
            document.getElementById('postal_box').style.display = 'block';
        <?php } ?>


        if ('a' == 'a') {
            $("#alert").fadeIn();
            $("#alert").fadeOut(5000);
        }
    });


    function postal_hide(data) {
        var value = data;
        if (data == 'yes') {
            document.getElementById('postal_box').style.display = 'none';
        } else {
            document.getElementById('postal_box').style.display = 'block';
        }
    }

    function upload_auto(Form_data, that, isAlphabet = false) {
        if (__check__form__validation(that, isAlphabet) == false) {
            console.log("Form Error");
            return;
        }
        let ssss = $('#Contact_Details_form').serialize();

        ssss = ssss + "&alter_mobile_mobile_no=" + alter_mobile_mobile_no + "&mobile_mobile_no=" + mobile_mobile_no + "&em_mobile_mobile_no=" + em_mobile_mobile_no;

        // console.log(ssss);

        $.ajax({
            data: ssss,
            type: 'post',
            url: '<?php echo base_url('user/contact_details_'); ?>',
            error: function() {
                //   alert('Auto Upload is OFF ');
            },
            success: function(data, textStatus, jqXHR) {
                //   alert(data);
            }
        });
    }

    $("#em_mobile").on("input", function() {
        var em_mobile = $("#em_mobile");
        var back = em_mobile.prev();
        var last = back[0].firstChild.title;
        var arr = last.split('+');
        em_mobile_mobile_no = arr[1];
        // console.log(em_mobile_mobile_no);
    });

    $("#alter_mobile").on("input", function() {
        var em_mobile = $("#alter_mobile");
        var back = em_mobile.prev();
        var last = back[0].firstChild.title;
        var arr = last.split('+');
        alter_mobile_mobile_no = arr[1];
        // console.log(alter_mobile_mobile_no);
    });

    $("#mobile").on("input", function() {
        var em_mobile = $("#mobile");
        var back = em_mobile.prev();
        var last = back[0].firstChild.title;
        var arr = last.split('+');
        mobile_mobile_no = arr[1];
        // console.log(mobile_mobile_no);
    });





    <?php if (is_Applicant()) { ?>
        $(document).ready(function() {
            if($('#country').val()==""){
                $('#country').focus();
                
            }
            // ---------- alert On page Exit -------
            $('#email').click(function() {
                var div = document.getElementById('emai_alert').innerHTML =
                    'Contact the support team on <a href="mailto:skills@aqato.com.au">skills@aqato.com.au</a> if you want to change the email id attached to the account.';
            });

            // ---------- Not alow to change Email ID -------
            var hasFocus = $('#email').is(':focus');
            if (!hasFocus) {
                var div = document.getElementById('emai_alert').innerHTML = "";
            }
            
            $("#email").on("focus", function() {
                var div = document.getElementById('emai_alert').innerHTML =
                    'Contact the support team on <a href="mailto:skills@aqato.com.au">skills@aqato.com.au</a> if you want to change the email id attached to the account.';
            });
        });
    <?php } ?>
</script>

<?= $this->endSection() ?>
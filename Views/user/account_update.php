<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>


<style>
    /* Mobile number contry code, contry, Number  */
    .lable_2 {
        font-size: 10px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>
<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Update Personal Details</b>

</div>


<div class="container mt-4 mb-4">

    <!-- Alert on set - Flashdata -->
    <?= $this->include("alert_box.php") ?>

    <div class="row">

        <div class="col-md-12 shadow bg-white ">
            <!-- <pre> -->
            <!-- <?php print_r($register_user); ?> -->
            <!-- <?php print_r($country_code_list); ?> -->
            <!-- </pre> -->

            <div class="card-title text-center text-success mt-3" style="font-size: 23px;">

                <?php if (is_Agent()) { ?>
                    Agent Details
                <?php } else { ?>
                    Applicant Details
                <?php } ?>

            </div>

            <!-- --------------notification of saved data----------- -->
            <?php if (session()->has('update_my_details')) { ?>
                <br>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <p class="text-center">Profile Was Updated</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>


            <form class="" method="post" action="<?= base_url('user/account_update_') ?>">
                <input type="hidden" name="user_id" value="<?= session()->get('user_id') ?>">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><b>
                                <?php if (is_Agent()) { ?>
                                    Name of Agent or Representative
                                <?php } else { ?>
                                    Name of Applicant
                                <?php } ?>
                            </b></label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" required name="name" class="form-control" value="<?= $register_user['name'] ?>">
                            </div>
                            <div class="col-sm-6" style="margin-left: -20px;">
                                <input type="text" required name="last_name" class="form-control" value="<?= $register_user['last_name'] ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Business Name(if applicable) and Agent's MARA number show only when Agent login -->
                    <?php if (is_Agent()) { ?>
                        <div class="col-md-6">
                            <label class="form-label"><b>Business Name(if applicable)</b></label>
                            <input type="text" required name="business_name" class="form-control" value="<?= $register_user['business_name'] ?>" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><b>Agent's MARA number (if applicable)</b></label>
                            <input type="text" name="mara_no" class="form-control" <?php if ($register_user['are_u_mara_agent'] == "No" || $register_user['are_u_mara_agent'] == "") {
                                                                                        echo "readonly";
                                                                                    }  ?> value="<?= $register_user['mara_no'] ?>">

                        </div>
                    <?php } ?>

                    <div class="col-md-6">
                        <label class="form-label"><b>Email</b></label>
                        <input type="email" required readonly name="email" id="Email_readonly" class="form-control" value="<?= $register_user['email'] ?>" />
                        <span style="color: red;font-size:80%" id="emai_alert"></span>
                    </div>
                </div>


                <div class="card-title text-center text-success mt-3" style="font-size: 23px;">Contact Details</div>

                <div class="row bg-Whitesmoke mt-2">
                    <div class="col-md-6 ">
                        <label for="inputNanme4" class="form-label">Unit / Flat Number</label>
                        <input type="text" onchange="upload_auto(this.form)" class="form-control" id="unit_flat_number" name="unit_flat" value="<?= $register_user['unit_flat'] ?>" />
                    </div>

                    <div class="col-md-6 ">
                        <label for="inputNanme4" class="form-label">Street / Lot number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" onchange="upload_auto(this.form)" id="street_lot_number" name="street_lot" required value="<?= $register_user['street_lot'] ?>" required="true"/>
                    </div>
                </div>

                <div class="row bg-Whitesmoke">
                    <div class="col-md-6 ">
                        <label for="inputNanme4" class="form-label">Street Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" onchange="upload_auto(this.form)" id="street_name" name="street_name" required value="<?= $register_user['street_name'] ?>" required="true" />
                    </div>

                    <div class="col-md-6 ">
                        <label for="inputNanme4" class="form-label">Suburb / City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" onchange="upload_auto(this.form)" id="suburb" name="suburb_city" required value="<?= $register_user['suburb_city'] ?>" required="true" />
                    </div>
                </div>

                <div class="row bg-Whitesmoke">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label">State / Province <span class="text-danger">*</span></label>
                        <input required type="text" v class="form-control" onchange="upload_auto(this.form)" id="state_proviance" name="state_province" value="<?= $register_user['state_province'] ?>" required="true" />
                    </div>

                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label">Postcode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" onchange="upload_auto(this.form)" id="postcode" name="postcode" required value="<?= $register_user['postcode'] ?>" required="true" />
                    </div>
                </div>

                <div class="row bg-Whitesmoke pb-2">
                    <!-- Mobile -->
                    <div class="col-md-6">
                        <label class="form-label" style="margin-bottom: 0px;">
                            Mobile <span class="text-danger">*</span>
                        </label>
                        <div class="row">
                            <div class="col-sm-5" style="padding-right:0px;">
                                <span class="lable_2"> Country code </span>
                                <br>
                                <select onchange="upload_auto(this.form)" class="form-control txbox" required name="mobile_code" required="true">
                                    <?php if (isset($country_code_list)) {
                                        foreach ($country_code_list as $key => $value) {
                                            $contry_id = 13;
                                            if (isset($register_user['mobile_code'])) {
                                                if ($value['id'] == $register_user['mobile_code']) {
                                                    $contry_id =  $value['id'];
                                                }
                                            }
                                            $Selected = "";
                                            if ($value['id'] == $contry_id) {
                                                $Selected = "Selected";
                                            }  ?>
                                            <option value="<?= $value['id'] ?>" <?= $Selected ?>>
                                                <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>

                                    <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-7">
                                <span class="lable_2"> Number </span>
                                <br>
                                <input type="number" class="form-control txbox" name="mobile_no" class="form-control" required value="<?= $register_user['mobile_no'] ?>" required="true" />
                            </div>
                        </div>
                    </div>

                    <!-- Telephone -->
                    <div class="col-md-6">
                        <label class="form-label" style="margin-bottom: 0px;">Telephone </label><br>
                        <div class="row">
                            <div class="col-sm-5" style="padding-right:0px;">
                                <span class="lable_2"> Country code </span>
                                <br>
                                <select onchange="upload_auto(this.form)" style="padding-right:0px;" class="form-control txbox" name="tel_code" >
                                    <?php if (isset($country_code_list)) {
                                        foreach ($country_code_list as $key => $value) {
                                            $contry_id = 13;
                                            if (isset($register_user['tel_code'])) {
                                                if ($value['id'] == $register_user['tel_code']) {
                                                    $contry_id =  $value['name'];
                                                }
                                            }
                                            $Selected = "";
                                            if ($value['id'] == $contry_id) {
                                                $Selected = "Selected";
                                            }
                                    ?>
                                            <option <?= $Selected ?> value="<?= $value['id'] ?>">
                                                <?php echo  $value['name'] . " (+" . $value['phonecode'] . ")" ?> </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2" style="padding-right:0px;">
                                <span class="lable_2"> Area code </span>
                                <br>
                                <input type="text" style="padding-right:10px;" class="form-control txbox" name="tel_area_code" value="<?= $register_user['tel_area_code'] ?>" />
                            </div>
                            <div class="col-sm-5" style="padding-right:0px;">

                                <span class="lable_2"> Number </span>
                                <br>
                                <input type="text" class="form-control txbox" name="tel_no" value="<?= $register_user['tel_no'] ?>" id="telephonkkke" />
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Check Box :- Postal Address Same As Physical Address -->
                <div class="row mt-4 mb-4">
                    <div class="col-sm-6">
                        <label for="add_check" class="col-form-label">
                            <b> Postal Address Same As Physical Address </b>
                        </label>
                    </div>
                    <div class="col-sm-4">
                        <input style=" margin-left :0px;margin-top :8px; width:18px; height:18px;" value="1" class="form-check-input" name="postal_ad_same_physical_ad_check" type="checkbox" id="add_check" <?php if (isset($register_user['postal_ad_same_physical_ad_check'])) {
                                                                                                                                                                                                                    if ($register_user['postal_ad_same_physical_ad_check']) { ?> checked <?php }
                                                                                                                                                                                                                                                                                    } ?>>

                    </div>
                </div>

                <!-- Physical Address -->
                <div id="ID_postal_address" class=" bg-Whitesmoke pb-2" style="padding:0px">
                    <div class="row bg-Whitesmoke ">


                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label">Unit / Flat Number</label>
                            <input type="text" onchange="upload_auto(this.form)" class="form-control" id="unit_flat_number" name="postal_unit_flat" value="<?= $register_user['postal_unit_flat'] ?>">
                        </div>


                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label">Street / Lot number </label>
                            <input type="text" class="form-control" onchange="upload_auto(this.form)" id="" name="postal_street_lot" value="<?= $register_user['postal_street_lot'] ?>">
                        </div>

                        <div class="col-md-6 ">
                            <label for="inputNanme4" class="form-label">Street Name </label>
                            <input type="text" class="form-control" onchange="upload_auto(this.form)" id="" name="postal_street_name" value="<?= $register_user['postal_street_name'] ?>">
                        </div>

                        <div class="col-md-6 ">
                            <label for="inputNanme4" class="form-label">Suburb / City </label>
                            <input type="text" class="form-control" onchange="upload_auto(this.form)" id="" name="postal_suburb_city" value="<?= $register_user['postal_suburb_city'] ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label">State / Province </label>
                            <input type="text" class="form-control" onchange="upload_auto(this.form)" id="" name="postal_state_province" value="<?= $register_user['postal_state_province'] ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label">Postcode </label>
                            <input type="text" class="form-control" onchange="upload_auto(this.form)" id="" name="postal_postcode" value="<?= $register_user['postal_postcode'] ?>">
                        </div>

                    </div>
                </div>

                <br>

                <div class="text-center">
                    <button type="submit" class="btn btn_green_yellow">Update</button>
                    <a href="<?= base_url('sing_out') ?>" id="cancel" class="btn btn_yellow_green">Cancel</a>
                </div>

            </form><!-- Vertical Form -->

            <div class="row">
                <div class="text-center" style="padding: 20px;margin-bottom: 80px;">
                    <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#Password_Reset_Modal" style="margin-left:0px;box-shadow:5px 5px 4px #ced4da;color:white;background: red;">
                        Password Reset
                    </button>
                </div>
            </div>
            <div class="modal" id="Password_Reset_Modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form text-left" action="<?= base_url("user/account_update_pass_reset") ?>" method="POST">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Password Reset</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body bg-Whitesmoke">
                                <style>
                                    /* Add a green text color and a checkmark when the requirements are right */
                                    .valid {
                                        color: green;
                                    }

                                    .valid:before {
                                        position: relative;
                                        left: -35px;
                                        content: "&#10004;";
                                    }

                                    /* Add a red text color and an "x" icon when the requirements are wrong */
                                    .invalid {
                                        color: red;
                                    }

                                    .invalid:before {
                                        position: relative;
                                        left: -35px;
                                        content: "&#10006;";
                                    }
                                </style>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="old_pass">Old Password</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" id="old_pass" name="old_pass" class="form-control" required="true">
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <label for="New_pass">New Password</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" id="New_pass" name="New_pass" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                        <label for="conf_pas">Confirm Password</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" id="conf_pas" name="conf_pas" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-sm-5">
                                    </div>
                                    <div class="col-sm-6">
                                        <small id="passwordHelpInline" class="text-muted">
                                            Must be 8-20 characters long.<br>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer mb-3">
                                <input type="submit" class="btn btn_green_yellow" value="change Password" name="">
                            </div>

                        </form>
                    </div>
                </div>
            </div>




        </div>

    </div> <!-- row  -->
</div> <!-- container  -->

<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>


<script>
    var myInput = document.getElementById("New_pass");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>





<!-- add by vishal 25/04/2022 -->
<script>
    $('#add_check').click(function() {
        let isChecked = $('#add_check').is(':checked');
        if (isChecked) {
            $('#postal_address').prop('required', '');
            document.getElementById('ID_postal_address').style.display = 'none';
        } else {
            $('#postal_address').prop('required', true);
            document.getElementById('ID_postal_address').style.display = 'block';
        }
    });




    $(document).ready(function() {
        // ---------- check data available in data base than auto feel ------------
        <?php if (isset($register_user['postal_ad_same_physical_ad_check'])) { ?>
            <?php if ($register_user['postal_ad_same_physical_ad_check'] == 1) { ?>

                let isChecked = $('#add_check').is(':checked');
                if (isChecked) {
                    $('#postal_address').prop('required', '');
                    document.getElementById('ID_postal_address').style.display = 'none';
                } else {
                    $('#postal_address').prop('required', true);
                    document.getElementById('ID_postal_address').style.display = 'block';
                }

            <?php } ?>
        <?php } ?>

        // ---------- alert On page Exit -------
        $('#cancel').click(function() {
            var data = window.confirm('Are You Sure Want To Exit The Steps');
            if (data == false) {
                return false;
            }
        });

        $("#update_btn").click(function() {
            if (custom_alert_popup_close('update_btn')) {
                return true;
            }
        });
            
            
            // var data = window.confirm('Are You Sure Want To Exit The Steps');
            // if (data == false) {
            //     return false;
            // }
        // });

        // ---------- Not alow to change Email ID -------
        var hasFocus = $('#Email_readonly').is(':focus');
        if (!hasFocus) {
            var div = document.getElementById('emai_alert').innerHTML = "";
        }

        $("#Email_readonly").on("focus", function() {
            var div = document.getElementById('emai_alert').innerHTML =
                'Contact the support team on <a href="mailto:skills@aqato.com.au">skills@aqato.com.au</a> if you want to change the email id attached to the account.';
        });
    });
</script>
<!-- / add by vishal 25/04/2022 -->

<?= $this->endSection() ?>
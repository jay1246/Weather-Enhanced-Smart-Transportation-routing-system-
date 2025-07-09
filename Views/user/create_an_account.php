<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class=" bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Create New Account </b>
</div>


<div class="container-fluid mt-4 mb-4">
    <div class="row">

        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">
            <!-- Alert Box  -->
            <div class="pt-4 pb-2">


                <!-- Alert on set - Flashdata -->
                <?= $this->include("alert_box.php") ?>
                <div class="text-center text-success mb-3" style="font-size:23px">Account Details</div>
            </div>

            <!-- form starts -->
            <form name="myForm" id="Create_account" onsubmit="return validateForm()" action="<?= base_url('create_an_account_code') ?>" method="post" class="row g-3 ">

                <div class="bg-Whitesmoke row" style="padding-top: 10px;padding-bottom: 10px; margin-left: 0px;">
                    <!-- -------account type---------- -->
                    <div class="col-md-6">
                        <label class="form-label">Account Type <span class="text-danger">*</span></label>

                        <select class="form-select" aria-label="Default select example" name="account_type" id="accouunt_type">
                            <option value="Agent">Agent</option>
                            <option value="Applicant">Applicant</option>
                        </select>
                    </div>


                    <!-- --------------email----------------- -->

                    <div class="col-md-6 ">
                        <label class="form-label">Your Email <span class="text-danger">*</span></label>
                        <input type="email" autocomplete="off" name="email" class="form-control" required="yes" onchange="__check__form__validation(this,true)">
                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>





                    <!-- --------------password----------------- -->


                    <div class="col-md-6">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" id="Password" name="password" class="form-control" required="yes">
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>



                    <!-- --------------con password----------------- -->


                    <div class="col-md-6">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" id="Confirm_Password" name="cpassword" class="form-control" required="yes">
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                </div>
                <!-- ------------------agent details-------------->

                <div class="pt-4 pb-2">

                    <div class="text-center text-success agent_details" style="font-size:23px">Agent Details</div>
                </div>
                <div class="bg-Whitesmoke row" style="padding-top: 10px;padding-bottom: 10px; margin-left:0px;">

                    <div class="col-6">
                        <label class="form-label">First / Given Name <span class="text-danger">*</span></label>
                        <input type="text" autocomplete="off" name="given-name" class="form-control" required="yes" onchange="__check__form__validation(this,true)">
                        <div class="invalid-feedback">Please enter your Name</div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Surname <span class="text-danger">*</span></label>
                        <input type="text" autocomplete="off" name="surname" class="form-control" required="yes" onchange="__check__form__validation(this,true)">
                        <div class="invalid-feedback">Please enter your Surname</div>
                    </div>

                    <!-- vishal add ID  -->
                    <div class="col-12" id="business-name">
                        <label class="form-label">Business Name <span class="text-danger">*</span></label>
                        <input type="text" name="business-name" id="business-name_id" class="form-control" required>
                        <div class="invalid-feedback">Please enter your Business Name</div>
                    </div>


                    <div class="col-md-6 mt-5" id="agent-section">
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-6 pt-0">Are you a MARA Agent?<span class="text-danger">*</span></legend>
                            <div class="col-sm-6">
                                <!-- vishal add ID  -->

                                <!-- // Vishal Change -------------------------- -->
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" required type="radio" id="agent_or_not_Yes" name="agent_or_not" onclick="agentyesno(this.value)" onchange="agentyesno(this.value)" value="Yes" checked>
                                        Yes
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" required type="radio" name="agent_or_not" id="agent_or_not_No" onclick="agentyesno(this.value)" onchange="agentyesno(this.value)" value="No">
                                        No
                                    </label>
                                </div>


                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- vishal add ID  -->
                <!-- // Vishal Change -------------------------- -->
                <div class="col-12" id="migration_number">
                    <label class="form-label">Migration Agent Registration Number (MARN)<span class="text-danger">*</span></label>
                    <input type="text" name="migration-number" id="MARN_id" class="form-control" required>
                    <div class="invalid-feedback">Please enter your Migration Agent Registration Number</div>
                </div>

                <!-- ------------------agent details ends-------------->


                <!-- google  re capchur alert  -->
                <div class="alert alert-danger" style="display: none;" id="alert">Please fill the captcha!</div>



                    <div class="row my-2 justify-content-center">
                            <div class="col-3" id="captcha_id" style="padding-left: 40px;">
                                <div class="row justify-content-center">
                                    <div class="col-6" style="margin-left: -47px;">
                                        <span style="font-size: 10px;">Verification image</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <img src="<?= base_url("login/generate_captcha") ?>" id="captcha_image">
                                        <button type="button" class="btn" title="Refresh Capctha" onclick="__refresh_captcha()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="row my-4 justify-content-center">
                            <div class="col-3">
                                <label>Enter text shown in the image</label><br/>
                                <input type="text" class="form-control" name="client_captcha" required>
                            </div>
                        </div>
                


                <div class="p-2">
                    <h4 class="text-warning text-center">Cookies Notice</h4>
                    <p class="text-center small">
                        This website uses Cookies which are used to allow us to track the number of people visiting the site, the pages that they visit and how long they stay on each page. This information allows us to continually develop and improve the service we offer our website visitors, and to ensure that we are meeting our key priority of keeping you informed.</p>
                </div>


                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">
                            I agree and accept the
                            terms and conditions
                        </label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center">
                    <input class="btn btn_green_yellow" type="submit" name="submit" value="Register" id="action_validation_btn">
                    <a href="<?= base_url() ?>" id="cancel" class=" mx-2 btn btn_yellow_green">Cancel</a>
                </div>

                <div class="col-sm-12 mb-5">
                    <p class="small mb-0">Already have an account?
                        <a href="<?= base_url('/') ?>" class="text-green">
                            <b> Log in </b>
                        </a>
                    </p>
                </div>

            </form>


        </div>

    </div>
</div>
<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<!-- form validation code  -->
<script>
    function validateForm() {
        let x = document.forms["myForm"]["account_type"].value;
        if (x == "") {
            alert("Select Account Type");
            return false;
        }
        let x = document.forms["myForm"]["email"].value;
        if (x == "") {
            alert("email must be filled out");
            return false;
        }
        let x = document.forms["myForm"]["password"].value;
        if (x == "") {
            alert("password must be filled out");
            return false;
        }
        let y = document.forms["myForm"]["cpassword"].value;
        if (x == "") {
            alert("email must be filled out");
            return false;
        }
        if (x == y) {
            alert("password not match");
            return false;
        }



    }

    function __check__form__validation(that, isAlphabet) {
        var msg = true;
        if (that.type == "email") {
            var emailString = $(that).val();
            $(that).val(emailString.toLowerCase());
        }
        if (that.type == "email" && isAlphabet == true) {
            msg = validEmailCheckForm(that);
            console.log("Email");
            return msg;
        }
        if (isAlphabet) {
            console.log("Alpha");
            if (checkValidAlpha(that, that.value) == false) {
                console.log("Form Checking False");
                msg = false;
            }
        }
        return msg;
    }

    function checkValidAlpha(that, string) {
        removeErrorMsg(that);
        if (string == "") {
            return true;
        }
        var result = /^[a-zA-Z]+$/.test(string);
        if (result == false) {
            includeErrorMsg(that, "Don't use any number or special symbols");
        }
        checkValidity();
        return result;
    }

    function includeErrorMsg(that, msgText) {
        $(that).after(`
            <input type='hidden' class='__valid_check_form' value='1'>
            <p class='text-danger'>${msgText}</p>`);
    }

    function removeErrorMsg(that) {
        $(that).next().remove();
        $(that).next().remove();
    }

    function saveExit() {
        // if (getAge() == true) {
        //     window.location = "<?= base_url('Stage1Controller/incomplete_form') ?>";
        // }
        // getAge();
        window.location = "<?= base_url('LoginController/applicant_agent') ?>";
    }

    function checkValidity() {
        if ($(".__valid_check_form").length > 0) {
            $("#action_validation_btn").attr("disabled", true);
        } else {
            $("#action_validation_btn").removeAttr("disabled");
        }
    }

    function validEmailCheckForm(input) {
        var msg = true;
        removeErrorMsg(input);
        if (input.value != "") {
            var validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            if (input.value.match(validRegex)) {
                // 

            } else {
                // $(input).css("border", "1px solid red");
                email_error = true;
                includeErrorMsg(input, "Invalid Email !");
                msg = false;
            }
        } else {
            // $(input).css("border", "1px solid #ced4da");

        }
        checkValidity();
        return msg;
    }
</script>
<script>
    $('#cancel').click(function() {

        // swal("Are you sure you want to do this?", {
        //   buttons: ["Continue!", "Exit!"],
        // });
        var data = window.confirm('Are You Sure Want To Exit The Steps');
        if (data == false) {
            return false;

        }

    });
    // --------------for mara agent section---------------


    // Vishal Creat --------------------------
    $(document).ready(function() {
        document.getElementById('migration_number').style.display = 'block';
        var type = $('#accouunt_type').val();
        if (type == 'Applicant') {
            document.getElementById('migration_number').style.display = 'none';
            document.getElementById('agent-section').style.display = 'none';
            document.getElementById('business-name').style.display = 'none';
            $('.agent_details').text('Applicant Details');
            $('#MARN_id').prop('required', '');
            $('#agent_or_not_Yes').prop('required', '');
            $('#agent_or_not_No').prop('required', '');
            $('#business-name_id').prop('required', '');
        } else {
            document.getElementById('migration_number').style.display = 'block';
            document.getElementById('agent-section').style.display = 'block';
            document.getElementById('business-name').style.display = 'block';
            $('.agent_details').text('Agent Details');

        }

    });



    // Vishal Change --------------------------
    function agentyesno(data) {
        if (data == 'Yes') {
            // console.log('clicked on yes');
            document.getElementById('migration_number').style.display = 'block';
        } else {
            // console.log('clicked on no');
            document.getElementById('migration_number').style.display = 'none';
            $('#MARN_id').prop('required', '');
        }
    }

    // --------------for data submission---------------


    // ---------------for account type dropdown---------------

    // vishal ---------------------- change
    $('#accouunt_type').change(function() {
        var type = $(this).val();
        if (type == 'Applicant') {

            document.getElementById('migration_number').style.display = 'none';
            document.getElementById('agent-section').style.display = 'none';
            document.getElementById('business-name').style.display = 'none';
            $('.agent_details').text('Applicant Details');
            $('#MARN_id').prop('required', '');
            $('#agent_or_not_Yes').prop('required', '');
            $('#agent_or_not_No').prop('required', '');
            $('#business-name_id').prop('required', '');
        } else {
            document.getElementById('migration_number').style.display = 'block';
            document.getElementById('agent-section').style.display = 'block';
            document.getElementById('business-name').style.display = 'block';
            $('.agent_details').text('Agent Details');

        }
    });

    // $(document).on('click', '#login', function() {
    //     var response = grecaptcha.getResponse();
    //     if (response.length == 0) {
    //         alert('Please Fill The Captcha');
    //         return false;
    //     }
    // });
</script>

<!-- --------------google recaptcha work only on server----------- -->
<script>
    var recaptchachecked;
    // $("#alert").hide();


    // function recaptchaCallback() {
    //     recaptchachecked = true;
    //     if (recaptchachecked) {
    //         $("#alert").fadeOut("slow");
    //     }
    // }
    // $("#Create_account").submit(function(e) {
    //     if ($("#Confirm_Password").val() != $("#Password").val()) {
    //         alert("Confirm Password does not match Password.")
    //         return false;
    //     }


    //     if (recaptchachecked) {
    //         return true;

    //     } else {
    //         $("#alert").fadeIn("slow");
    //         return false;
    //     }
    // });
</script>
<!-- --------------google recaptcha work only on server----------- -->

<?= $this->endSection() ?>
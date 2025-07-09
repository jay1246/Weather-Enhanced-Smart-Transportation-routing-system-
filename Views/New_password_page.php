<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>


<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <span>
        <b> Welcome to the Skills Assessment Online Portal </b>
    </span>
</div>

<div class="container mt-4 mb-4">
    <!-- Alert Box  -->
    <p class="alert-success text-center">
        <?= session()->get('msg'); ?>
    </p>
    <p class="alert-danger text-center">
        <?= session()->get('error_msg'); ?>
    </p>

    <div class="row">

        <!-- left div  -->
        <div class="col-md-3"></div>

        <!-- center div  -->
        <div class="col-md-6 shadow bg-white ">
            <!-- funtion tital  -->
            <h6 class="" style="padding: 5px; margin-left:10px; font-weight:bold; "> Create New Password </h6>
            <hr class="" style="margin: 0px;">
            <p class="text-danger text-center"> </p>
            <div class="row">

                <div class="col-md-2"></div>
                <div class="col-sm-8">

                    <!-- form start  -->
                    <form action="<?= base_url('New_password_check') ?>" id="form_1" name="myForm" method="post" class="row" novalidate>

                        <input type="hidden" name="tokan" value="<?= $tokan ?>" />
                        <label for="yourUsernam" class="form-label">New Password</label>
                        <div class="input-group has-validation">
                            <input type="password" name="Pass_1" id="Pass_1" class="form-control" required />
                            <div class="invalid-feedback">Please Enter New Password</div>
                        </div>

                        <label for="yourUsername" class="form-label">Confirm Password</label>
                        <div class="input-group has-validation">
                            <input type="password" name="Pass_2" id="Pass_2" class="form-control" required />
                            <div class="invalid-feedback">Please Enter Confirm Password</div>
                        </div>


                        <div class="d-flex justify-content-center p-3">
                            <input class="btn btn_green_yellow" type="submit" id="submit" name="submit" value="Change Password" />
                        </div>

                    </form>

                </div>
                <div class="col-md-2"></div>

            </div>

            <a class="text-green p-4" href="<?= base_url() ?>">
                Back To Login
            </a>


        </div>




        <!-- right  div  -->
        <div class="col-md-3"></div>


    </div> <!-- Row  -->
</div> <!-- container -->


<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>


<script>
    $(document).ready(function() {
        // Validate form fields
        $("#form_1").submit(function(e) {
            if (validateForm()) {
                document.getElementById("form_1").submit();
            }

        });
    });
    // onsubmit="return validateForm()"
    function validateForm() {
        let x = document.forms["myForm"]["Pass_1"].value;
        let y = document.forms["myForm"]["Pass_2"].value;

        let check = true;
        if (x.length >= 8) {} else {
            alert("password length minimum 8");
            check = false;
        }
        if (y.length >= 8) {} else {
            alert("password length minimum 8");
            check = false;
        }
        if (x == y) {} else {
            alert("password not match");
            check = false;
        }
        return check;
    }
</script>

<?= $this->endSection() ?>
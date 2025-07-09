<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <span>
        <b> Welcome to the Skills Assessment Online Portal </b>
    </span>
</div>


<div class="container mt-4 mb-4">
    <br>
    <br>
    <div class="row">

        <div class="col-md-3"></div>

        <div class="bg-white col-md-6 shadow">


            <form action="<?= base_url('user_login_check') ?>" id="Login_form" method="post" class="row g-3">
                <input type="hidden" name="where" value="">
                <input type="hidden" name="redayrect_url" value="<?= $redayrect_url ?>">

                <h6 class="" style="padding: 5px; margin-left:10px; ">Applicant/Agent Login</h6>
                <hr class="" style="margin: 0px;">

                <!-- <div class="p-2" style="   background-color: #fecc00;">
                    <b> Notice:<br>
                        Online Portal will be unavailable due to technical maintenance from
                        9:30 pm (AEST) Friday, 04 April 2023 till
                        11:30 pm (AEST) Monday, 04 April 2023
                    </b>
                </div> -->


                <br>

                <!-- Alert on set - Flashdata -->
                <?= $this->include("alert_box.php") ?>

                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend" style="width: 25%;">
                            <div class="input-group-text">Email <span class="text-danger" style="margin-left: 5px;">
                                    *</span> </div>
                        </div>
                        <input type="text" name="username" value="" class="form-control" id="inputText" required />
                    </div>
                </div>
                <div class="col-sm-2"></div>

                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Password <span class="text-danger" style="margin-left: 5px;"> *</span> </div>
                        </div>
                        <input type="password" value="" name="password" class="form-control" required />
                    </div>
                </div>
                <div class="col-sm-2"></div>


                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <!-- google  re capchur alert  -->
                    <div class="alert alert-danger" style="display: none;" id="alert">Please fill the captcha!</div>
                    <div class="text-center" id="recaptcha">
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?= env('Google_your_site_key') ?>"></div>
                    </div>
                </div>
                <div class="col-sm-2"></div>


                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="text-center">
                        <button class="btn btn_green_yellow w-50 login mb-4 " type="submit" id="login_btn">Login</button>
                    </div>
                </div>
                <div class="col-sm-2"></div>

            </form>


            <div class="col-12 text-center " style="font: size 14px;">
                <p class="text-center">
                    Don't have account?
                    <!-- <a href="https://at.aqato.com.au/LoginController/register" class="text-green"> -->
                    <a href="<?= base_url('create_an_account') ?>" class="text-green">
                        <b> Create an account </b>
                    </a>
                </p>
                <a href="<?= base_url('user/forgot_Password') ?>" class="text-danger">Forgot Password ?</a>
                <div style="margin-bottom: 10px;"></div>
            </div>
        </div>

        <div class="col-md-3"></div>

        <div class="col-md-12 mb-5 mt-5"></div>

    </div> <!-- row  -->
</div> <!-- container  -->

<?= $this->endSection() ?>
<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
    var recaptchachecked;
    $("#alert").hide();

    function recaptchaCallback() {
        recaptchachecked = true;
        if (recaptchachecked) {
            $("#alert").fadeOut("slow");
        }
    }
    $("#Login_form").submit(function(e) {
        if (recaptchachecked) {
            return true;
        } else {
            $("#alert").fadeIn("slow");
            return false;
        }
    });
</script>

<?= $this->endSection() ?>
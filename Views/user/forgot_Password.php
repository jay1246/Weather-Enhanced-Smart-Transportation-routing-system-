<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 130%;">

    <span class="a">
        <b> Welcome to the Skills Assessment Online Portal </b>
    </span>
</div>


<div class="container-fluid mt-4 mb-4 ">

    <div class="row justify-content-center">

        <div class="col-md-6 shadow bg-white shadow card px-0 mx-0 my-auto">

            <div class="card-header text-center" style="font-size: 20px;">
                <b>Forgot Password</b>
            </div>
            <div class="card-body">
                <!-- Alert on set - Flashdata -->
                <?= $this->include("alert_box.php") ?>

                <form action="<?= base_url('user_Forgot_Password_check') ?>" id="forgot_Password_form" method="post" class="row needs-validation">
                    <div class="col-sm-12" style="text-align: center;">
                        
                        <div class="row justify-content-center mb-3">
                            <div class="col-8">
                                <div class="input-group ">
                                    <div class="input-group-prepend ">
                                        <div class="input-group-text"> Email <span class="text-danger" style="margin-left: 5px;">*</span></div>
                                    </div>
                                    <input type="text" name="email" class="form-control" id="inlineFormInputGroupUsername" required placeholder="Please Enter your Registered Email." />
                                    <input type="hidden" name="type" value="user" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row my-2 justify-content-center">
                            <div class="col-6" id="captcha_id">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-center">
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
                            <div class="col-6">
                                <label>Enter text shown in the image</label><br/>
                                <input type="text" class="form-control" name="client_captcha" required>
                            </div>
                        </div>
                        
                        <!-- google  re capchur alert  -->
                        <!-- <div class="alert alert-danger" style="display: none;" id="alert">Please fill the captcha!</div>
                        <div class="text-center" id="recaptcha">
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?= env('Google_your_site_key') ?>"></div>
                        </div> -->
                        <br>
                        <input type="submit" name="submit" class="btn btn_green_yellow" value="Retrieve Password">
                        <br>
                        <br>
                        <a class="text-green" href="<?= base_url('user/login') ?>">Back To Login</a>
                        <br>
                        <br>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    var recaptchachecked;
    // $("#alert").hide();

    // function recaptchaCallback() {
    //     recaptchachecked = true;
    //     if (recaptchachecked) {
    //         $("#alert").fadeOut("slow");
    //     }
    // }
    // $("#forgot_Password_form").submit(function(e) {
    //     if (recaptchachecked) {
    //         return true;
    //     } else {
    //         $("#alert").fadeIn("slow");
    //         return false;
    //     }
    // });
</script>

<?= $this->endSection() ?>
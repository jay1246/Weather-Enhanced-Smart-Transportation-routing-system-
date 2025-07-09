<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>
<style>
    .input-group-text{
        font-size: 24px;
        border-radius: 0px;
        border-bottom-left-radius: 8px;
        border-top-left-radius: 8px;
    }
    #notice_popup{
        background-color: rgba(0,0,0,0.3);
    }
</style>

<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 130%;">
    <span>
        <b> Welcome to the Skills Assessment Online Portal </b>
    </span>
</div>


<div class="container mt-4 mb-4">
    
    <div class="row justify-content-center">

        <div class="bg-white col-md-6 shadow card px-0 mx-0 my-auto">

            <div class="card-header text-center" style="font-size: 20px;">
                <b>Applicant/Agent Login</b>
            </div>
            <div class="card-body">
            
                <form action="<?= base_url('user_login_check') ?>" id="Login_form" method="post">
                    <input type="hidden" name="where" value="">
                    <input type="hidden" name="redayrect_url" value="<?= $redayrect_url ?>">

                    <!-- Alert on set - Flashdata -->
                    <?= $this->include("alert_box.php") ?>
                    <div class="row justify-content-center">
                        <div class="col-10">
                            <div class="row my-3">
                                <div class="col-12">
                                    <!--<div class="bg-warning p-2 mb-2 "style="width: 25.3rem;height: 8rem; border: black;border-radius: 10px;margin-left: 50px;">-->
                                             
                                    <!--        <b class="text-success text-center">-->
                                    <!--            <span style="font-size: 19px;";>Note:</span>-->
                                    <!--            <br>-->
                                    <!--             The web portal will be under maintenance from <br> 9:00pm (AEST) Wednesday,13th December 2023 to <br> 7:00am (AEST) Thursday 14th December 2023.</b>-->
                                    <!--        </div>-->
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="username" value="" class="form-control" id="inputText" required placeholder="Email"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-12">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="bi bi-key-fill"></i>
                                            </div>
                                        </div>
                                        <input type="password" value="" name="password" class="form-control" required placeholder="Password"/>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="<?= base_url('user/forgot_Password') ?>" class="text-danger float-end" style="margin-top: 5px;">Forgot Password ?</a>
                                </div>
                            </div>

                            
                            <!-- <div class="row my-2">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Captcha<span class="text-danger" style="margin-left: 5px;"> *</span> </div>
                                        </div>
                                        <input type="text" value="" name="client_captcha" class="form-control" required />
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="row my-2">
                                <div class="col-12">
                                
                                    <div class="alert alert-danger" style="display: none;" id="alert">Please fill the captcha!</div>
                                    <div class="text-center" id="recaptcha">
                                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                        <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?= env('Google_your_site_key') ?>"></div>
                                    </div>
                                </div>
                            </div> -->

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

                            <div class="row my-2">
                                <div class="col-12">
                                    <div class="text-center">
                                        <button class="btn btn_green_yellow w-50 login mb-4 " type="submit" id="login_btn" style="font-size: 18px;">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                </form>


                <div class="col-12 text-center " style="font: size 14px;">
                    <p class="text-center">
                        Don't have account?
                        <!-- <a href="https://at.aqato.com.au/LoginController/register" class="text-green"> -->
                        <a href="<?= base_url('create_an_account') ?>" class="text-green">
                            <b> Create an account </b>
                        </a>
                    </p>
                    <!-- <a href="<?= base_url('user/forgot_Password') ?>" class="text-danger">Forgot Password ?</a> -->
                    <div style="margin-bottom: 10px;"></div>
                </div>
            </div>

        </div>

    </div> <!-- row  -->
</div> <!-- container  -->
<div class="modal" id="notice_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #FFCC01;">
        <h5 class="modal-title text-uppercase" id="exampleModalLabel"><b>Important Notice</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="__close_popup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12 custom_text text-uppercase text-center" style="font-weight: bold; font-size: 15px;">
                <h5>
                THE PORTAL WILL BE UNDER maintenance FROM: <br/> <br/> <b>9:00 PM (AEST) Saturday, 23/03/2024  <br/> To <br/> 10:00 PM (AEST) Sunday, 24/03/2024</b>
                <br/>
                <br/>
                <span>WE APOLOGIZE FOR ANY INCONVENIENCE IT MAY CAUSE</span>
                <br/>
                <br/>
                </h5>
                <h6 style="font-weight: bold;">TEAM ATTC - AQATO</h6>
            </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

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
    // $("#Login_form").submit(function(e) {
    //     if (recaptchachecked) {
    //         return true;
    //     } else {
    //         $("#alert").fadeIn("slow");
    //         return false;
    //     }
    // });

    function __open_popup(){
        $("#notice_popup").css('display', 'block');
    }

    function __close_popup(){
        $("#notice_popup").css('display', 'none');
    }

    // __open_popup();

    // $("body").on("click", () => {
    //     __close_popup();
    //     console.log("Closed");
    // });

// $("#notice_popup").modal('show');
</script>

<?= $this->endSection() ?>
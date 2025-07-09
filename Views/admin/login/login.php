<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class="bg-green text-white text-center pb-1" style="font-size: 120%;">
    <span>
        <b> Welcome to the Admin Login </b>
    </span>
</div>

<div class="container mt-4 mb-4">

    <div class="row">

        <div class="col-md-3"></div>
        <div class="bg-white col-md-6 shadow ">
            <form action="<?= base_url('admin/logincheck') ?>" id="Login_form" method="post" class="row g-3">
                <h6 class="" style="padding: 10px;  font-size:24px"><i class="bi bi-shield-lock"></i> Admin Login </h6>
                <hr class="" style="margin: 0px;">

                <?= $this->include("alert_box.php") ?>

                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend" style="width: 25%;">
                            <div class="input-group-text">Email <span class="text-danger" style="margin: 5px;"> *</span> </div>
                        </div>
                        <input type="text" name="email" class="form-control" id="inputText" required />
                    </div>
                </div>
                <div class="col-sm-2"></div>

                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Password <span class="text-danger" style="margin: 5px;">*</span> </div>
                        </div>
                        <input type="password" name="password" class="form-control" required />
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
                <a href="<?= base_url('admin/forgot_password') ?>" class="text-danger">Forgot Password ?</a>
                <div style="margin-bottom: 10px;"></div>
            </div>
        </div>

        <div class="col-md-3"></div>

        <div class="col-md-12 mb-5 mt-5"></div>

    </div> <!-- row  -->
</div> <!-- container  -->


<!-- Modal -->
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
    // $("#Login_form").submit(function(e) {

    //         $("#alert").fadeIn("slow");

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
    
</script>
<?= $this->endSection() ?>
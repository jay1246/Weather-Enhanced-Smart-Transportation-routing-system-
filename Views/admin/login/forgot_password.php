<?= $this->extend('template/login_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class=" a mt-1 bg-green text-white text-center">
    <span class="a">
    </span>
</div>
<!-- inner heading  -->
<div class="bg-green text-white text-center pb-1" style="font-size: 120%;">
    <span>
        <b> Forgot Password</b>
    </span>
</div>


<div class="container mt-4 mb-4 ">

    <div class="row">
        <div class="col-md-3"></div>

        <div class="bg-white col-md-6 shadow">
            <!-- Alert Box  -->
            <?php if (!empty(session()->get('msg'))) {
            ?>
                <div class="alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                    <strong><?= session()->get('msg') ?> </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" fdprocessedid="ayilyi"></button>
                </div>
            <?php
            }
            if (!empty(session()->get('error_msg'))) {
            ?>
                <div class="alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
                    <strong id="text-mgs-danger"><?= session()->get('error_msg') ?> </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" fdprocessedid="ayilyi"></button>
                </div>
            <?php
            }
            ?>
            <form action="<?= base_url('admin/check_forgot_password') ?>" method="post" id="forgot_form" class="row g-3 needs-validation">
                <h6 class="" style="padding: 5px; margin-left:10px; font-weight:bold; "> Forgot Password ?</h6>
                <hr class="" style="margin: 0px;">
                <p class="text-center">Please Enter your Registered Email</p>

                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend" style="width: 25%;">
                            <div class="input-group-text"> Email <span class="text-danger" style="margin: 5px;">*</span></div>
                        </div>
                        <input type="text" name="email" class="form-control" id="inlineFormInputGroupUsername" placeholder="Please Enter your Registered Email..">
                        <input type="hidden" name="type" value="user" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2"></div>

                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="text-center">
                        <button class="btn btn_green_yellow w-50 login" type="submit">Retrieve Password</button>
                    </div>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-12 text-center" style="font: size 14px;">
                    <a href="<?= base_url('admin/login') ?>">Back To Login</a>
                    <div style="margin-bottom: 10px;"></div>
                </div>
            </form>

        </div>

        <div class="col-md-3"></div>

        <div class="col-md-12 mb-5 mt-5"></div>

    </div>
</div>
<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>


</script>

<?= $this->endSection() ?>
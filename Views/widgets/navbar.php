<style>
    .nav_img_css {
        max-width: 100%;
        max-height: 130px;
    }
    
    .dpn_item:hover {
         /*box-shadow: 5px 10px #888888 !important;*/
        color: #055837 !important;
        /*border-bottom: 3px solid red !important;*/
          /*box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);*/
          /*background-color: #e6ffe6;*/
 
    }
</style>
<!-- main logos  -->
<header class="bg-white text-center d-flex justify-content-center">
    <!-- PC navbar  -->
    <div style="object-fit:cover; " class="container">
        <img class="nav_img_css" src="<?= base_url('public/assets/image/header_logo.jpg') ?>">
    </div>
</header>

<!-- User Funtion  -->
<?php if (session()->has('name')) { ?>

    <nav class="d-flex justify-content-end bg-white ">
        <!-- use for developer  -->
        <span style="padding-right: 90px;">
            <a href="<?= base_url('Account_type_change') ?>">
                <!-- <?= session()->get('account_type'); ?> -->
            </a>
            <?php
            if (isset($ENC_pointer_id)) {
                // echo pointer_id_decrypt($ENC_pointer_id);
            }
            ?>
        </span>
        <!-- use for developer  -->

        <div class="dropdown mb-1">
            <?php
            $url = "";
            if(url_is("user/account_update")){
                $url ="#";
            }else{
                ?>
            <span style="padding-right: 10px;">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                <i class="bi bi-house-door-fill"></i> Dashboard
            </a>
            
              <!--<a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
              <!--  Dropdown link-->
              <!--</a>-->
            
              <ul class="dropdown-menu">
                <li><a class="dropdown-item dpn_item" href="<?=base_url()?>" style="text-decoration: none !important;"><i class="bi bi-house-door-fill"></i> Dashboard</a></li>
                <li><a class="dropdown-item dpn_item" href="<?=base_url("user/incomplete_application")?>" style="text-decoration: none !important;"><i class="bi-pencil-square "></i> Incomplete Application</a></li>
                <li><a class="dropdown-item dpn_item" href="<?=base_url("user/submitted_applications")?>" style="text-decoration: none !important;"><i class="bi bi-stickies-fill"></i> Submitted Applications</a></li>
               
               <?php
                    $pending_count_ = 0;
                     $user_id = session()->get("user_id");
                    $verfication_count_ = email_verification_count($user_id);
                    // $email_verification_ = emplo_email_verf($applicant->id);
                    // print_r($verfication_count_);exit;
                
                    foreach($verfication_count_ as $applicant_)
                  {
                //   print_r($applicant);exit;
                      $email_verification_ = emplo_email_verf($applicant_['id']);
                      if (!empty($email_verification_)) {
                          $pending_count_++;
                      }      
                  }
                   
                  if($pending_count_ == 0)
                      {
                          $display = "display:none!important";
                      }else{
                          $display = "";
                      
               
               ?>
               
               
                <li style=""><a class="dropdown-item dpn_item" href="<?=base_url("user/pending_verification")?>" style="text-decoration: none !important;"><i class="bi bi-exclamation-circle"></i> Employment Verification Pending</a></li>
<?php  }?>
              </ul>

            </span>
            
                <?php
            }
            
            ?>
            <!-- <= session()->get('last_name') ?> -->
            <a class="dropdown-toggle" style="margin-right: 20px;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (session()->has('name')) { ?>
                    Welcome - <b><?= session()->get('name') ?></b>
                    <a class="text-body nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <?php } else { ?>
                        Menu
                    <?php } ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                        <?php
                        if (isset($blablabla)) {
                            if (isset($_COOKIE['day_night_mode'])) { ?>
                                <?php if ($_COOKIE['day_night_mode'] == "night") { ?>
                                    <li>
                                        <a class="dropdown-item dpn_item" href="<?= base_url('day_night_mode/day') ?>">
                                            <i class="bi bi-brightness-high"></i> Day Mode
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ($_COOKIE['day_night_mode'] == "day") { ?>
                                    <li>
                                        <a class="dropdown-item dpn_item" href="<?= base_url('day_night_mode/night') ?>">
                                            <i class="bi bi-moon-fill"></i> Night Mode
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <li>
                                    <a class="dropdown-item dpn_item" href="<?= base_url('day_night_mode/night') ?>">
                                        <i class="bi bi-moon-fill"></i> Night Mode
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>


                        <?php if (session()->has('name')) { ?>
                            <li>
                                <a class="dropdown-item dpn_item" style="text-decoration: none !important;" href="<?= base_url('user/account_update') ?>">
                                    <i class="bi bi-pencil"></i> Update My Details
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item dpn_item" style="text-decoration: none !important;" href="<?= base_url('sing_out') ?>">
                                    <i class="bi bi-power"></i> Sign Out
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
        </div>

    </nav>

<?php } else {
} ?>
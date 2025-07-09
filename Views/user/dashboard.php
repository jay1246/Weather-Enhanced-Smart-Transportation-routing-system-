    <?= $this->extend('template/user_template') ?>
    <?= $this->section('main') ?>
    <?php
    
    //  print_r($_SESSION);exit;
    
    ?>
    
    <style>
        .g-recaptcha {
            display: inline-block;
        }
    
        body {
            background-color: #FFF !important;
        }
    </style>
    <hr>
    <div class="container mt-4 mb-4">
    
    
        <!-- Button UI  -->
        <style>
            .listing .nav-link:hover {
                background-color: var(--yellow) !important;
                color: var(--green) !important;
            }
            
            .hover_effect:hover .left_icon {
                position: absolute;
                line-height: 5;
                height: 91px;
                margin-left: -20px;
                margin-top: -24px;
                display: flex;
                justify-content: center;
                background-color: var(--green);
                color: var(--yellow);
                width: 63px;
            }
            
            .hover_effect:hover #right_icon
            {
                
                background-color: var(--green);
                color: var(--yellow);
                
            }
            
            .hover_effect:hover .vishal_ic{
                    font-size: 24px !important;
                    margin-top: -17px !important;
                    color: var(--yellow);
            }
            /*  .hover_effect:hover {*/
            /*    position: absolute;*/
            /*    line-height: 5;*/
            /*    height: 91px;*/
            /*    margin-left: -20px;*/
            /*    margin-top: -24px;*/
            /*    display: flex;*/
            /*    justify-content: center;*/
            /*    background-color: var(--green);*/
            /*    color: var(--yellow);*/
            /*    width: 63px;*/
            /*}*/
    
            .listing .nav-link:hover .icons:hover {
                background-color: var(--green);
            }
    
            .left_icon {
                position: absolute;
                line-height: 5;
                height: 91px;
                margin-left: -20px;
                margin-top: -24px;
                display: flex;
                justify-content: center;
                background-color: var(--yellow);
                color: var(--green);
                width: 63px;
            }
            
            
    
            .c_box {
                float: right;
                line-height: 6;
                height: 91px;
                width: 63px;
                margin-top: -67px;
                display: flex;
                justify-content: center;
                background-color: var(--yellow);
                color: var(--green);
            }
    
            .vishal_ic {
                font-size: 24px !important;
                margin-top: -17px !important;
                color: var(--green);
    
            }
    
            .tx {
                font-size: 20px !important;
                margin-top: -13px !important;
            }
            
            /*#pending_div{*/
            /* -webkit-box-shadow:0px 0px 44px 6px rgba(45,255,196,0.87);*/
            /* -moz-box-shadow: 0px 0px 44px 6px rgba(45,255,196,0.87);*/
            /* box-shadow: 0px 0px 44px 6px rgba(45,255,196,0.87);*/
            /*}*/
        </style>
    
    
        <div class="row">
            <div class="col-md-3"></div>
    
            <div class=" col-md-6" style="margin-top:65px">
                <?php
                if (is_Applicant()) {
                ?>
                    <style>
                        .sidebar-nav {
                            margin-top: 100px;
                        }
                    </style>
                <?php
                }
                ?>
                <?php 
                    // echo $any_running;
                    // echo $Incomplete_count;
                ?>
                <div class="sidebar-nav listing" id="sidebar-nav">
                    <!-- Alert on set - Flashdata -->
                    <?= $this->include("alert_box.php") ?>
    
                    <?php
                    $Create_New = false;
                    $count = 0;
                    if (is_Applicant()) {
                        $Create_New = false;
                        
                        if ($Incomplete_count == 0) {
                            // echo "fdfd";
                            $Create_New = true;
                        }
                        if($any_running > 0) {
                            // echo "fdfd";
                            $Create_New = false;
                        }
                    } else if (is_Agent()) {
                        $Create_New = true;
                    }
                    //  print_r($Create_New);
                    ?>
                    <?php if ($Create_New) { ?>
                        <div class="d-flex justify-content-center hover_effect" >
                            <div style="width: 445px;">
                                <a href="<?= base_url('user/create_new_application') ?>" class="nav-link text-light py-4 rounded" style="background-color:#055837;">
                                    <span class="left_icon px-4  rounded">
                                        <i class="bi vishal_ic bi-align-middle "></i>
                                    </span>
                                    <h5 style="padding-top: 11px;margin-left: 65px;">Create New Application</h5>
                                </a>
                            </div>
                        </div>
                        <br>
                    <?php } ?>
    
    
                    <?php
                    $Incomplete_Applications = false;
                    if (is_Applicant()) {
                        $Incomplete_Applications = false;
                        if ($Incomplete_count > 0) {
                            $Incomplete_Applications = true;
                        }
                    } else if (is_Agent()) {
                        $Incomplete_Applications = true;
                    }
                    ?>
    
                    <?php if ($Incomplete_Applications) { ?>
    
                        <div class="d-flex justify-content-center hover_effect">
                            <div style="width: 445px;">
                                <a class="nav-link text-light py-4 rounded" style=" background-color:#055837;" href="<?= base_url('user/incomplete_application') ?>">
                                    <span class="left_icon px-4  rounded"> <i class="bi vishal_ic bi-pencil-square  " style="margin: 10px;"></i></i> </span>
                                    <h5 class="" style=" padding-top: 11px;margin-left: 65px;">Incomplete Applications</h5>
                                    <span class="rounded c_box" id="right_icon">
                                        <b class="tx">
                                            <?= $Incomplete_count ?>
                                        </b>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <br>
                    <?php } ?>
    
    
    
                    <!-- Submitted_Applications  hide show by Login Type  -->
                    <?php
                    $Submitted_Applications = false;
                    if (is_Applicant()) {
                        $Submitted_Applications = false;
                        if ($submit_count > 0) {
                            $Submitted_Applications = true;
                        }
                    } else if (is_Agent()) {
                        $Submitted_Applications = true;
                    }
                    ?>
                    <?php if ($Submitted_Applications) { ?>
                        <div class="d-flex justify-content-center hover_effect">
                            <div style="width: 445px;">
                                <a class="nav-link text-light py-4 rounded" style="background-color:#055837;" href="<?= base_url('user/submitted_applications') ?>">
                                    <!-- <span class="mx-2"> <i class="bi bi-stickies-fill nav-link bg-warning  icons"></i> </span> -->
    
                                    <span class="left_icon px-4  rounded"> <i class="bi vishal_ic bi-stickies-fill " style="margin: 10px;"></i></i> </span>
                                    <h5 class="" style=" padding-top: 11px;margin-left: 65px;">Submitted Applications</h5>
                                    <span class="rounded c_box" id="right_icon">
                                        <b class="tx">
                                            <?= $submit_count ?>
                                        </b>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <br>
    
                    <?php } ?>
    
    
                  <!--//Employement Verifcation pending count-->
                     <?php
                    //   print_r($email_verification);exit;
                   $pending_count = 0;
                    foreach($email_verification as $applicant)
                   {
                    //   print_r($applicant);
                       
                    $isVerificationThere = isVerificationIsThereForStage2($applicant->id);
                    if(!$isVerificationThere){
                        continue;
                    }
                //   echo $pending_count;exit;
                      $email_verification = emplo_email_verf($applicant->id);
                      if (!empty($email_verification)) {
                          $pending_count++;
                      }      
                   }
                   
                   if($pending_count == 0)
                       {
                           $display = "display:none!important";
                       }else{
                           $display = "";
                       }
                       
                    //   echo $pending_count;exit;
                     ?>
    
               
                 
                   <div class="d-flex justify-content-center hover_effect" style="<?= $display ?>" >
                        <div style="width: 445px;" id="pending_div" >
                            <a class="nav-link text-light py-4 rounded" id="pending_decp" style="background-color:#055837;" href="<?= base_url('user/pending_verification') ?>">
                                <!-- <span class="mx-2"> <i class="bi bi-person-square nav-link bg-warning  icons"></i> </span> -->
                                <span class="left_icon px-4  rounded" id="pending_left" style="height: 91px!important"> <i class="bi vishal_ic bi-exclamation-circle" id="icon_left" style="margin: 10px;"></i></i> </span>
                                <!--<span class="left_icon px-4  rounded"> <img src="http://64.34.156.167/~aqato203/mvc/public/assets/icon/new_popup_.png" width="40px" style="padding-left: 10px;"> </span>-->
                                <h5 class="" style=" padding-top: 11px;margin-left: 65px;">Employment Verification  Pending</h5>
                                <span class="rounded c_box right_icon" id="right_icon">
                                    <b class="tx" id="txt_count">
                                     <?= $pending_count ?>
                                    </b>
                                </span>
                            </a>
                        </div>
                    </div>
                     
                 
                    <!--<div class="d-flex justify-content-center">-->
                    <!--    <div style="width: 400px;">-->
                    <!--        <a class="nav-link text-light py-4 rounded" style="background-color:#055837;" href="<?= base_url('user/account_update') ?>">-->
                                <!-- <span class="mx-2"> <i class="bi bi-person-square nav-link bg-warning  icons"></i> </span> -->
                    <!--            <span class="left_icon px-4  rounded"> <i class="bi vishal_ic  bi-person-square   " style="margin: 10px;"></i></i> </span>-->
                    <!--            <h5 class="" style=" padding-top: 11px;margin-left: 65px;">Update My Details</h5>-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <?php
                 if (is_Agent()) {
                    ?>
                    <br>
                    <?php
                     }
                    ?>
                        <div class="d-flex justify-content-center hover_effect"> 
                            <div style="width: 445px;">
                                <a class="nav-link text-light py-4 rounded" style="background-color:#055837;" href="<?= base_url('user/download_Form') ?>">
                                    <!-- <span class="mx-2"> <i class="bi bi-person-square nav-link bg-warning  icons"></i> </span> -->
                                    <span class="left_icon px-4 rounded mb-2"> <i class="bi vishal_ic  bi-folder2" style="margin: 6px;"></i></i> </span>
                                    <h5 class="" style=" padding-top: 10px;margin-left: 65px;"> Forms</h5>
                                </a>
                            </div>
                        </div>
                    
    
                </div>
                <br>
            </div>
    
            <div class="col-md-3"></div>
    
    
        </div> <!-- row  -->
    </div> <!-- container  -->
    <?= $this->endSection() ?>
    
    <!---------- custom_script -->
    <?= $this->section('custom_script') ?>
    
    <script>
        $('#login').on('click', function() {
    
            var response = grecaptcha.getResponse();
    
            if (response.replace(/ /g, '').length == 0) {
    
                alert('Please complete the Captcha below'); // 29 aug 2022 :- Vishal h patel
                return false;
            }
        });
        
        
        //windows onload toggle
        window.onload = function() {
            
            //toggle function calling
            toggle_color_change();
            
            
        };
        
            var isColor = true;
        function toggle_color_change()
        {
            if (isColor) {
                isColor = false;
              $('#pending_left').css("background-color", "#055837");
              $('#icon_left').css("color", "#FFCC01");
            //   $('.right_icon').css("background-color", "#055837");
            //   $('#txt_count').css("color", "#FFCC01");
            //   $('#pending_decp').css("background-color", "#FFCC01");
            } 
            else{
                
              $('#pending_left').css("background-color", "#FFCC01");
              $('#icon_left').css("color", "#055837");
            //   $('.right_icon').css("background-color", "#FFCC01");
            //   $('#txt_count').css("color", "#055837");
            //   $('#pending_decp').css("background-color", "#055837");
                isColor = true;
            }
            
            setTimeout(toggle_color_change, 500);
            
        }
        
    </script>
    
    <?= $this->endSection() ?>
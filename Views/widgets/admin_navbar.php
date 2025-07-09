
<style>
    * {
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
    }

    .logo_text_heading {
        padding: 10px;
        font-size: 24px;
        width: 100px;

        font-size: clamp(20px, 3vw, 24px);
    }

    .nav_div_css {
        padding: 13px;
        padding-bottom: 0px;
        max-width: 780px;
        text-align: center;
    }

    .nav_img_css {
        width: 100%;
    }

    .toggle-sidebar-btn {
        font-size: 32px;
        cursor: pointer;
        color: #012970;
    }

    .nav_img_css {
        max-width: 950px;
        /* max-height: 100px; */
    }

    .dropdown-menu:hover {
        color: green;
    }

    .out {
        /* padding: 2px !important; */
    }

    .out:hover {
        box-shadow: 5px 10px #888888 !important;
        color: red !important;
        border-bottom: 3px solid red !important;
    }
    
    .menu_wrapper{
                display: flex;
                }
  .menu_wrapper .menu_icon{
                width: 10%;
                }
</style>
<div style="box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
    width: 100%;
    position: fixed;
    z-index: 4;
    height: 112px;
    background: white;;
    position: fixed;z-index: 4; ">
    <!-- main logos  -->
    <!--<header class="bg-white text-center d-flex justify-content-center">-->
    <!--    <br> <img class="nav_img_css" src="<= base_url('public/assets/image/header_logo.jpg') ?>">-->
    <!--</header>-->
    <!-- User Funtion  -->
    
 
    <?php
     //print_r(session());
    
    if (session()->has('admin_name')) { ?>
        <nav class="bg-white row mx-0">
            <div class="col-lg-6 bg-white text-center d-flex  ">
                <img class="nav_img_css" src="<?= base_url('public/assets/image/header_logo.jpg') ?>" style="margin-left:50%">
            </div>
            
<?php 
if(session()->get('admin_name') == 'ATTC - QLD'){
 $style="position: absolute;top: -5px;right: 1;left: 77%;";   
}else{
   $style="position: absolute;top: -10px;right: 186px;"; 
   
}
//print_r($_SESSION);
 $notification_check=session()->get('notification');
 if($notification_check > 0){
     $notification =$notification_check;
     $style_notify='bg-danger';
 }else{
     $notification='';
     $style_notify='';
    
 }
   $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
   $parts = explode('/', trim(parse_url($current_url, PHP_URL_PATH), '/'));
if (isset($parts[0])) {
    if($parts[0] == 'application_transfer' || $parts[0] == 'Create_new_TRA_file'){
        $show='display:none';
    }else{
        $show="";
    }
}
   
if (session()->has('admin_account_type')) {
    //   print_r($_SESSION);
       $admin_account_type =  session()->get('admin_account_type');
     //  echo $admin_account_type;
       if($admin_account_type != 'admin'){
            $show='display:none';
       }else{
            $show="";
       }
  }   
  
?> 
            <div class="col-lg-6 dropdown d-flex justify-content-end mt-5">
                <div class="parent" style="display: flex;">
                    <div style="<?=$show?>">
                        <div style="position: relative;">
                                <img src="<?=base_url('public/assets/chat/chat_icon.png')?>" alt="avatar 3"  style="width: 48px; height: 67px; cursor: pointer; object-fit: cover;margin-top: -21px;" id="avatar" onclick="openchat()">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill " id="msg_count" style="margin-top: -6px;margin-left: -8px">
                            
                          </span> 
                        </div>
                    </div>
                    <div class="">
                        <a class="dropdown-toggle" style="text-decoration: none !important;margin-right: 10px; color:#012970" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        
                    <?php
                    // print_r(session());
                    if (session()->has('admin_name')) { ?>
                        <span class="ps-2" style="font-size: 14px; font-weight: 600;">
                            <!-- <?= session()->get('admin_email') ?> -->
                            <?= session()->get('admin_name') ?>
                        </span>
                        <a class="text-body nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <?php } ?>
                        </a>
                        <ul class="dropdown-menu shadow" style="min-width: 240px;" aria-labelledby="dropdownMenuButton1">

                            <!-- <?php if (isset($_COOKIE['day_night_mode'])) { ?>
                     <?php if ($_COOKIE['day_night_mode'] == "night") { ?>
                <li>
                    <a class="dropdown-item" href="<?= base_url('day_night_mode/day') ?>">
                        <i class="bi bi-brightness-high"></i> Day Mode
                    </a>
                </li>
                <?php } ?>
                <?php if ($_COOKIE['day_night_mode'] == "day") { ?>
                <li>
                    <a class="dropdown-item" href="<?= base_url('day_night_mode/night') ?>">
                        <i class="bi bi-moon-fill"></i> Night Mode
                    </a>
                </li>
                <?php } ?>
                <?php } else { ?>
                    <li>
                    <a class="dropdown-item" href="<?= base_url('day_night_mode/night') ?>">
                        <i class="bi bi-moon-fill"></i> Night Mode
                    </a>
                </li>
                <?php } ?> -->


                            <li class="dropdown-header">
                                <?php if (session()->has('admin_email')) { ?>
                                    <h6 class="text-black">
                                        Welcome - <?= session()->get('admin_name') ?>
                                    </h6>
                                    <hr>
                                    <a class="text-black out" href="<?= base_url('admin/logout') ?>">
                                        <center> <i class="bi bi-power"></i> Sign Out</center>
                                    </a>
                                <?php } ?>
                            </li>



                        </ul>
                        </a>
                        
                    </div>
                </div>
                
                
                
                
    
<!--             <div class="row">-->
                 
<!--                 <div class="col-1">-->
<!--                 <div style="<=$style?>">-->
<!--  <img src="<=base_url('public/assets/chat/chat_icon.png')?>" alt="avatar 3"  style="width: 48px; height: 67px; cursor: pointer; object-fit: cover;margin-top: -8px;" id="avatar" onclick="openchat()">-->
<!--<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill " id="msg_count" style="margin-top: 2px;margin-left: -9px">-->
    
<!--  </span> -->
<!--</div>-->
<!--</div>-->
             
<!--             <div class="col-5">-->
               
<!--                         </div>-->
<!--            </div>-->
            </div>
            </div>
        </nav>


    <?php } ?>
</div>
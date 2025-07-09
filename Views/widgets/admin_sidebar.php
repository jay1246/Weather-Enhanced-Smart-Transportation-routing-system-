<?php
if (isset($show_said_bar)) {
} else {
    $show_said_bar = true;
}
if ($show_said_bar) {
   

// print_r($_SESSION);
// echo "frwf";
// die;
?>

    <style>
        /*--------------------------------------------------------------
# Sidebar
--------------------------------------------------------------*/

        .nav-link {
            font-size: 15px !important;
            font-color: #055837;
        }

        .sidebar {
            margin-top:123px !important;
            height: 81%;
            position: fixed;
            left: 0;
            width: 100%;
            max-width: 300px !important;
            transition: all 0.3s;
            padding: 20px;
            scrollbar-width: thin;
            scrollbar-color: #aab7cf transparent;
            box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.1);
            background-color: #fff;
            border-radius: 8px;
        }

        @media (max-width: 1199px) {
            .sidebar {
                left: -300px;
            }
        }
       @media (min-width: 1801px) {
    .sidebar {
        margin-top: 137px !important;
        
    }
    
}

        .sidebar::-webkit-scrollbar {
            width: 5px;
            height: 8px;
            background-color: #fff;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #aab7cf;
        }

        @media (max-width: 1199px) {
            .toggle-sidebar .sidebar {
                left: 0;
            }
        }

        @media (min-width: 1200px) {

            .toggle-sidebar #main,
            .toggle-sidebar #footer {
                margin-left: 0;
            }

            .toggle-sidebar .sidebar {
                left: -300px;
            }
        }

        .active-newbar {
            /*font-weight:bold;*/
            /*background-color: #FFC107 !important;*/
            /*color: #055837 !important;*/

            background-color: #055837 !important;
            color: #fecc00 !important;
        }

        .sidebar-nav {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar-nav li {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 5px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            font-size: 15px;
            font-weight: 600;
            transition: 0.3;
            padding: 10px 15px;
            border-radius: 4px;
        }

        .sidebar-nav .nav-link i {
            font-size: 16px;
            margin-right: 10px;
        }

        .sidebar-nav .nav-link.collapsed {
            color: #055837;
        }

        .sidebar-nav .nav-link:hover {
            color: #055837;
            background: #fecc00;
        }

        #main {
            padding: 20px 30px;
            transition: all 0.3s;
            width: 100%;
            margin-top: 88px !important;
        }
       
        @media (min-width: 1200px) {

            #main,
            #footer {
                 margin-left: 303px; 
            }
        }
.section{
       /*margin-top: -2px !important;*/
}
.pagetitle{
        /*margin-top: 8px !important;*/
}
        
    </style>
    <?php
    
    $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>


    <aside id="sidebar" class="sidebar shadow mt-1">

        <ul class="sidebar-nav" id="sidebar-nav" style="z-index: 999 !important;margin-top: 23px ">
            <li class="nav-item">
               <?php 
               if (strpos($current_url, 'admin/dashboard')) {
                        $cal_activ_app = 'active-newbar';
                    } else {
                        $cal_activ_app = '';
                    }
               ?>
                <a   class="nav-link collapsed <?= $cal_activ_app ?>" href="<?= base_url('admin/dashboard') ?>/">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
                
            </li>
           
            <?php if (session()->get('admin_account_type') == 'admin' || session()->get('admin_account_type') == 'head_office') { 
            
            //  print_r($_SESSION);
            ?>
                <li class="nav-item">
                    
                    <?php
                    if (url_is("admin/application_manager") || url_is("admin/application_manager/view_application///tab1") || url_is("admin/application_manager/view_application///tab2") || url_is("admin/application_manager/view_application///")) {
                        $cal_activ_app = 'active-newbar';
                    } else {
                        $cal_activ_app = '';
                    }
                    if (strpos($current_url, 'admin/application_manager')) {
                        $cal_activ_app = 'active-newbar';
                    } else {
                        $cal_activ_app = '';
                    }
                    ?>
                     
                    <a   class="nav-link collapsed <?= $cal_activ_app ?> " href="<?= base_url("admin/application_manager") ?>">
                        <i class="bi-file-earmark-check-fill"></i>
                        <span>Application Manager </span>
                    </a>
                    

                </li><!-- End Login Page Nav -->
                
                <li class="nav-item">

                    <a   class="nav-link collapsed <?= url_is("admin/not_aqato_s3") ? 'active-newbar' : '' ?>   <?= url_is("admin/interview_booking") ? 'active-newbar' : '' ?> " href="<?= base_url("admin/interview_booking") ?>">
                        <i class="bi bi-calendar-check-fill "></i>
                        <span>
                            Interview Bookings
                        </span>
                    </a>
                </li>
                
                <li class="nav-item">

                    <a   class="nav-link collapsed  <?= url_is("admin/practical_booking") ? 'active-newbar' : '' ?> " href="<?= base_url("admin/practical_booking") ?>">
                        <i class="bi bi-calendar-check-fill "></i>
                        <span>
                            Practical Bookings
                        </span>
                    </a>
                </li>

                <?php if (session()->get('admin_account_type') == 'admin') {  ?>

                    <li class="nav-item">
                        <?php
                        if (url_is("admin/applicant_agent/applicant") || url_is("admin/applicant_agent/agent")) {
                            $cal_activ_ap_ag = 'active-newbar';
                        } else {
                            $cal_activ_ap_ag = '';
                        }
                        $cal_activ_ap_ag = '';
                        if(strpos($current_url, 'admin/applicant_agent')){
                            $cal_activ_ap_ag = 'active-newbar';
                        }
                        ?>

                        <a   class="nav-link collapsed  <?= $cal_activ_ap_ag ?>" href="<?= base_url('admin/applicant_agent/agent') ?>">
                            <i class="bi bi-person-check-fill "></i>
                            <span>Applicant / Agent</span>
                        </a>
                    </li>

                    
                    
                    <?php 
                    
                if(session()->get('admin_id') == '1'){
                    
                    if (strpos($current_url, 'admin/staff_management')) {
                        $cal_activ_app = 'active-newbar';
                    } else {
                        $cal_activ_app = "";
                    }
                    ?>

                    <li class="nav-item">
                        <a   class="nav-link collapsed <?= (session()->get('admin_account_type') == 'admin') ? '' : 'disabled' ?> <?= $cal_activ_app ?>" href="<?= base_url('admin/staff_management/aqato') ?>">
                            <i class="bi bi-person-fill "></i>
                            <span>Staff Management</span>
                        </a>
                    </li>
                    

                    <li class="nav-item">
                        <a   class="nav-link collapsed <?= (session()->get('admin_account_type') == 'admin') ? '' : 'disabled' ?> <?= url_is("admin/occupation_manager") ? 'active-newbar' : '' ?>" href="<?= base_url('admin/occupation_manager') ?>">
                            <i class="bi bi-briefcase-fill "></i>
                            <span>Occupation Manager</span>
                        </a>
                    </li>
                    
                    <?php 
                }
                    ?>


                    <li class="nav-item">
                        <?php
                        if (strpos($current_url, 'admin/verification')) {
                            $cal_activ_app = 'active-newbar';
                        } else {
                            $cal_activ_app = "";
                        }
                        ?>
                        <a  class="nav-link collapsed <?= $cal_activ_app ?>" href="<?= base_url("admin/verification/employment") ?>">
                            <!--<i class="bi bi-arrow-up-right-square-fill"></i>-->
                            <i class="bi bi-box-arrow-up-right"></i>
                            <span>Verification</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <?php
                        if (strpos($current_url, 'admin/Archive')) {
                            $cal_activ_app = 'active-newbar';
                        } else {
                            $cal_activ_app = "";
                        }
                        ?>
                        <a  class="nav-link collapsed <?= $cal_activ_app ?>" href="<?= base_url("admin/Archive") ?>">
                            <!--<i class="bi bi-arrow-up-right-square-fill"></i>-->
                            <i class="bi bi-archive-fill"></i>
                            <span>Archive</span>
                        </a>
                    </li>


                    <?php
                    if (strpos($current_url, 'admin/mail_template')) {
                        $cal_activ_app = 'active-newbar';
                    } else {
                        $cal_activ_app = "";
                    }
                    ?>
                    
                    <?php 
                        if(session()->get('admin_id') == '1'){
                    ?>
                    <li class="nav-item">
                        <a    class="nav-link collapsed <?= $cal_activ_app ?>" href="<?= base_url("admin/mail_template") ?>">
                            <strong></strong><i class="bi bi-envelope-fill"></i></strong>
                            <span>Mail Template</span>
                        </a>
                    </li><!-- End Mail Template -->

                    <li class="nav-item">
                        <?php
                        if (url_is("admin/offline_files/saq_file") || url_is("admin/offline_files/application_kit") || url_is("admin/offline_files/third_party")) {
                            $cal_activ = 'active-newbar';
                        } else {
                            $cal_activ = '';
                        }
                        ?>
                        <a    class="nav-link collapsed <?= $cal_activ ?>" href="<?= base_url("admin/offline_files/saq_file") ?>">
                            <i class="bi-file-earmark-check-fill "></i>
                            <span>Offline Files</span>
                        </a>
                    </li>
                    <?php } ?>
                <?php } ?>

            <?php } ?>
            
            <?php 
            if(session()->get('admin_account_type') == 'admin'){
            ?>
            <li class="nav-item">
                <?php
                $cal_activ = "";
                if (strpos($current_url, 'admin/admin_functions')) {
                    $cal_activ = 'active-newbar';
                }
                ?>
                <a    class="nav-link collapsed <?= $cal_activ ?>" href="<?= base_url("admin/admin_functions") ?>">
                    <i class="bi-file-earmark-check-fill "></i>
                    <span>Admin Functions</span>
                </a>
            </li>
            
            
            <li class="nav-item">
                <?php 
                if (url_is("admin/location/interview_location") || url_is("admin/location/pratical")) {
                    $cal_activ_loca = 'active-newbar';
                } else {
                    $cal_activ_loca = '';
                }
                ?>
                <a   class="nav-link collapsed <?= $cal_activ_loca ?>" href="<?= base_url("admin/location/interview_location") ?>">
                    <i class="bi bi-geo-alt-fill "></i>
                    <span> Locations</span>
                </a>
            </li>
                    
            <?php 
            }
            ?>
            
        </ul>

    </aside>
<?php } ?>
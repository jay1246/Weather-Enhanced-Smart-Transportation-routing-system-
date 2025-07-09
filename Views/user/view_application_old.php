 <?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>


<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 18px;">
    <!--<a type="btn">Ba</a>-->
    <b> Application Details </b>
</div> <!-- stage 3 Action Requad  -->


<style>
    .arrow {
        border-radius: 0px !important;
        clip-path: polygon(93% 0, 100% 50%, 93% 100%, 0% 100%, 6% 50%, 0% 0%);
    }

    a.active {
        background-color: var(--yellow) !important;
        color: var(--green) !important;
    }

    .active {
        border: 1px solid var(--yellow) !important; <!-- stage 3 Action Requad  -->

    }

    .staper_btn {
        max-width: 100%;
    }


    .mm {
        color: #055837;
        padding: 3px;
        border: 3px solid #fecc00;
        border-radius: 25px;
    }

    input[readonly] {
        background-color: #ebebeb;
    }
</style>


<!-- start body  -->
<div class="container-fluid mt-4 mb-4 p-4 bg-white shadow">
    <!-- View Submitted Application  -->
    <div class="row">
        <div class="col-sm-6">
            <!-- <h2 class="text-green"></h2> -->

            <table class="table">
                <tr>
                    <td>
                        <b>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                                PRN
                            </span>
                        </b>
                    </td>
                    <td>
                        <?= $portal_reference_no ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Application No. </b>
                    </td>
                    <td>
                        <?= $Unique_number ?>
                    </td>
                </tr>



                <tr>
                    <td>
                        <b> Applicant's Name </b>
                    </td>
                    <td>
                        <?= $Application_Details['name'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Occupation </b>
                    </td>
                    <td>
                        <?= $Application_Details['occupation'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Pathway </b>
                    </td>
                    <td>
                        <?= $Application_Details['pathway'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Program </b>
                    </td>
                    <td>
                        <?= $Application_Details['program'] ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6 d-flex align-items-center justify-content-center">
            <?php
            $show_img = false;
            $pic_full_url = "";
            $path = "";
            foreach ($documents as $key => $value) {
                if ($value['stage'] == "stage_1") {
                    if ($value['required_document_id'] == 1) {
                        $path = $value['document_path'] . "/" . $value['document_name'];
                        // echo $path;
                        $pic_full_url = base_url($value['document_path'] . "/" . $value['document_name']);
                        if (file_exists($path)) {
                            $show_img = true;
                        } else {
                            $show_img = false;
                        }
                    }
                }
            }
            ?>

            <?php if ($show_img) {
                $image_info = getimagesize($path);
                if ($image_info !== false) { ?>
                    <img src="<?= $pic_full_url ?>" width="150px" height="170px" class="shadow">
                <?php } else {  ?>
                    <img src="https://cdn-icons-png.flaticon.com/512/180/180658.png" width="170px" height="170px" class="shadow">
                <?php } ?>
            <?php } else { ?>
                <img src="https://cdn-icons-png.flaticon.com/512/180/180658.png" width="170px" height="170px" class="shadow">
            <?php } ?>

        </div>
    </div>


    <?php
    $stage_2_have_docs = false;
    $stage_3_have_docs = false;
    foreach ($documents as $key => $value) {
        if ($value['stage'] == "stage_2") {
            $stage_2_have_docs = true;
        }
        if ($value['stage'] == "stage_3") {
            $stage_3_have_docs = true;
        }
    }

    $s1_active = "disabled";
    $s1_selected = "false";
    $s1_show = "Q";

    $s2_active = "disabled";
    $s2_selected = "false";
    $s2_show = "Q";

    $s3_active = "disabled";
    $s3_selected = "false";
    $s3_show = "Q";

    $s4_active = "disabled";
    $s4_selected = "false";
    $s4_show = "Q";
    $s4_active ="disabled";
    
    $s3_R_active = "disabled";
    $s3_R_selected = "false";
    $s3_R_show = "Q";

    // stage 1 
    // echo $is_active;
    // echo $stage_index;
    if ($stage_index >= 2) {
        if ($is_active == "stage_1" || !$is_employe_add) {
            $s1_active = "active";
            $s1_selected = "true";
            $s1_show = "show active";
        }
    }

    // vishal 29-05-2023 
    // if ($stage_index >= 31) {
    //     $s1_active = "";
    //     $s1_active = "";
    //     $s1_show = "asdsad";

    //     $s2_active = "";
    //     $s2_show = "asdsad";

    //     $s3_active = "";
    //     $s3_show = "asdsad";

    //     $s4_active = "active";
    //     $s4_selected = "true";
    //     $s4_show = "show active";
    // }



    // stage 2 
    if ($is_employe_add) {  // continu stage 2
        // if ($stage_index == 5 || $stage_index >= 11 && $stage_index < 30) {
        // vishal 29-05-2023 
        if ($stage_index == 5 || $stage_index == 15 || $stage_index >= 11 && $stage_index < 30) {
            if ($is_active == "stage_2") {
                $s1_active = "";
                $s1_show = "asdsad";

                $s2_active = "active";
                $s2_selected = "true";
                $s2_show = "show active";
            }
        }
    }
// echo "gghgf";


    //if ($stage_3_have_docs) {

    // vishal 29-05-2023 
    // if ($stage_index == 15 || ($stage_index >= 21 && $stage_index < 30)) { 
    if ($stage_index >= 21 && $stage_index < 30 || $stage_index ==39) {
        if ($is_active == "stage_3") {
            $s1_active = "";
            $s1_show = "asdsad";

            $s2_active = "";
            $s2_show = "asdsad";
            
            $s3_active = "active";
            $s3_selected = "true";
            $s3_show = "show active";
        }
    }
    // echo $stage_index;
    // echo $s4_show;
    if ($stage_index >= 31 && $stage_index < 38) {
        if ($is_active == "stage_4") {
            $s1_active = "";
            $s1_show = "asdsad";

            $s2_active = "";
            $s2_show = "asdsad";
            
            $s3_active = "";
            $s3_show = "asdsad";
            

            $s4_active = "active";
            $s4_selected = "true";
            $s4_show = "show active";
            if($stage_3_R){
                $s3_R_active = "";
            $s3_R_show = "asdsad";

            }
    
        }
    }
    // echo $stage_index;
    if ($stage_index >= 40 && $stage_index < 48) {
        if ($is_active == "stage_3_R") {
            $s1_active = "";
            $s1_show = "asdsad";

            $s2_active = "";
            $s2_show = "asdsad";
            
            $s3_active = "";
            $s3_show = "asdsad";

            $s3_R_active = "active";
            $s3_R_selected = "true";
            $s3_R_show = "show active";
        }
    }
    // echo $is_active;
    // exit;
    // }
    // if ($stage_index == 27) {
    //     $s1_active = "";
    //     $s1_selected = "false";
    //     $s1_show = "Q";

    //     $s2_active = "";
    //     $s2_selected = "false";
    //     $s2_show = "Q";

    //     $s3_active = "active";
    //     $s3_selected = "true";
    //     $s3_show = "show active";
    //     $s4_active = "";
    // }
// echo "Dgsdgsd";
    // echo $s2_active;

    ?>
<!--echo $s3_active;-->

    <!-- all stage Stapper Button  -->
    <!--<= $stage_index ?>-->
    <div class="row nav nav-tabs" id="nav-tab" role="tablist">
        <?php if (!empty($s1_show)) { ?>
            <a href="" type="button" class=" staper_btn  <?= $s1_active ?> col-sm btn arrow bg-green text-yellow" id="stage_1-tab" data-bs-toggle="tab" data-bs-target="#stage_1" role="tab" aria-controls="stage_1" aria-selected="<?= $s1_selected ?>">
                Stage 1 - Self Assessment
            </a>
        <?php } ?>

        <?php if (!empty($s2_show)) { ?>
            <a href="" type="button" class="  staper_btn <?= $s2_active ?> col-sm btn arrow bg-green text-yellow" id="stage_2-tab" data-bs-toggle="tab" data-bs-target="#stage_2" role="tab" aria-controls="stage_2" aria-selected="<?= $s2_selected ?>">
                Stage 2 - Documentry Evidence
            </a>
        <?php } ?>

        <a href="" type="button" class="staper_btn <?= $s3_active ?> col-sm btn arrow bg-green text-yellow" id="stage_3-tab" data-bs-toggle="tab" data-bs-target="#stage_3" role="tab" aria-controls="stage_3" aria-selected="<?= $s3_selected ?>">
            Stage 3 - Technical Interview
        </a>
        <?php
        // echo $stage_index;
        // echo "here";
        if($stage_index == 39 || !empty($stage_3_R)){
        ?>
            <a href="" type="button" class="staper_btn <?= $s3_R_active ?> col-sm btn arrow bg-green text-yellow" id="stage_3_r-tab" data-bs-toggle="tab" data-bs-target="#stage_3_r" role="tab" aria-controls="stage_3_r" aria-selected="<?= $s3_R_selected ?>">
                Stage 3 - Technical Interview (Reassessment)
            </a>
        <?php } 
        ?>


        <?php
        $pathway = $Application_Details['pathway'];
        $occupation = $Application_Details['occupation'];
        ?>

        <?php 
        // akanksha 3 july 2023
        if($pathway == 'Pathway 1'){
        if($occupation == "Electrician (General)" || $occupation == "Plumber (General)") {
        if (!empty($s4_show)) { ?>
            <a href="" type="button" class="staper_btn <?= $s4_active ?> col-sm btn arrow bg-green text-yellow" id="stage_4-tab" data-bs-toggle="tab" data-bs-target="#stage_4" role="tab" aria-controls="stage_3" aria-selected="<?= $s3_selected ?>">
                Stage 4 - Practical Assessment
            </a>
        <?php } 
        }
        }?>

    </div>



    <!-- stage 1 TO stage 3  data  -->
    <div class="tab-content" id="nav-tabContent">

        <?php
        $show_Additional_Information_Request = false;
        $show_stage_4_addition_request = false;
        foreach ($additional_info_request as $key_1 => $value_1) {
            $stage = $value_1['stage'];
            $status = $value_1['status'];
            if ($stage == "stage_1" && $status == "send") {
                $show_Additional_Information_Request = true;
            }
            if ($stage == "stage_4" && $status == "send") {
                $show_stage_4_addition_request = true;
            }            
        }
        ?>


        <!-- stage 1  -->
        <?php if (!empty($s1_show)) { ?>
            <div class="tab-pane fade <?= $s1_show ?>  bg-white shadow- p-3" id="stage_1" role="tabpanel" aria-labelledby="stage_1-tab">
                <!-- 25-04-2023 vishal patel  -->
                <?php
                if (isset($stage_1['approved_date']) && !empty($stage_1['approved_date']) && $stage_1['approved_date'] != "0000-00-00 00:00:00" && $stage_1['approved_date'] != null) {
                    $Expired_date =  date('Y-m-d', strtotime('+60 days', strtotime($stage_1['approved_date'])));
                    $expiry_date_temp = strtotime($Expired_date);
                    $todays_date = strtotime(date('Y-m-d'));
                    $timeleft = $todays_date - $expiry_date_temp;
                    $day_remain = round((($timeleft / 86400)));
                } else {
                    $day_remain = -40;
                }

                ?>
                <div class="row mt-3">

                    <!-- left  -->
                    <div class="col-sm-6">

                        <table class="table">
                            <thead>
                                <!-- Submitted  -->
                                <?php
                                $show_qualification_verification = false;
                                $status_of_qualification_verification = "Pending";
                                if(isset($qualification_verification_stage_1)){
                                    $is_qualification_verification_done = $qualification_verification_stage_1['is_verification_done'];
                                    // echo "gdgdgc" .$is_qualification_verification_done;
                                    if ($is_qualification_verification_done != 1 && $stage_1['status'] == 'Submitted') {
                                    $status_of_qualification_verification == 'Pending';
                                    $show_qualification_verification =true;      
                                    } else {
                                        $status_of_qualification_verification = "Completed";
                                        $show_qualification_verification =  false;      
                                    }
                                    // echo $s/how_qualification_verification;
                                }
                                if (isset($stage_1['status']) && !empty($stage_1['status'])) { ?>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <td>
                                            <b>
                                                <?php 
                                                if($show_qualification_verification){
                                                    ?>
                                                    <a class="text-black" data-bs-toggle="modal" href="#exampleModalToggle_qualification" role="button">
                                                        Qualification Verification (<?= $status_of_qualification_verification ?>) <!-- 25-04-2023 Vishal Patel -->
                                                        <img id="myImage" src="<?= base_url('public/assets/icon/new_popup_.png') ?>" width="40px" style="padding-left: 10px;" onmouseover="hoverImage()" onmouseout="originalImage()">
                                                    </a>
                                                    <div class="modal fade" id="exampleModalToggle_qualification" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                        <div class="modal-dialog modal modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalToggleLabel_qualification">
                                                                        Qualification Verification
                                                                    </h5>
                                                                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick=hide_model_box('exampleModalToggle_qualification')></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <table style=" border: none !important; margin-top: 0px !important; font-size:90%" class="table">
                                                                        <tbody>
                                                                            <tr style="border: none !important;" class="bg-green text-white">
                                                                                <th>Sr.No.</th>
                                                                                <th>Email-Id</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <?php
                                                                                $is_verification_done = $qualification_verification_stage_1['is_verification_done'];
                                                                                 if ($is_verification_done == 1) {
                                                                                        $status = "Verified";
                                                                                        $status = '<span class="bg-green text-white p-2 rounded">' . $status . ' </span>';
                                                                                    } else {
                                                                                        $status = "Pending";
                                                                                        $status = '<span class="bg-yellow text-black p-2 rounded">' . $status . ' </span>';
                                                                                    }

                                                                                ?>
                                                                                <td style=" border: none !important; margin-top: 0px !important;">1</td>
                                                                                <td style=" border: none !important; margin-top: 0px !important;"><?=$qualification_verification_stage_1['verification_email_id'] ?></td>
                                                                                 <td style=" border: none !important; margin-top: 0px !important;  ">
                                                                                    <span class="bg-yellow text-black"> <b><?= $status ?></b> </span>
                                                                                </td>
                                                                                   
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                                }else{
                                                    // <!-- 25-04-2023 vishal patel  -->
                                                    if ($stage_1['status'] != "Expired") {
                                                        echo $stage_1['status'];
                                                    } else {
                                                        if ($day_remain >= 0) {
                                                            echo "Closed";
                                                        } else {
                                                            echo $stage_1['status'];
                                                        }
                                                    }
                                                }
                                                ?>

                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Date Submitted
                                        </th>
                                        <td>
                                            <?php
                                            if (!empty($stage_1['submitted_date']) && $stage_1['submitted_date'] != "0000-00-00 00:00:00" && $stage_1['submitted_date'] != null) {
                                                echo date("d/m/Y", strtotime($stage_1['submitted_date']));
                                            } ?>
                                        </td>
                                    </tr>
                                <?php } ?>




                                <!-- Lodged  date  -->
                                <?php //if (isset($stage_1['lodged_date']) && !empty($stage_1['lodged_date'])) { 
                                ?>
                                <!--    <tr>-->
                                <!--        <th>-->
                                <!--            Date Lodged-->
                                <!--        </th>-->
                                <!--        <td>-->
                                <?php
                                //if (!empty($stage_1['lodged_date']) && $stage_1['lodged_date'] != "0000-00-00 00:00:00" && $stage_1['lodged_date'] != null) {
                                //  echo date("d/m/Y", strtotime($stage_1['lodged_date']));
                                // } 
                                ?>
                                <!--        </td>-->
                                <!--    </tr>-->
                                <?php // } 
                                ?>
                                <?php //if (isset($stage_1['status']) && $stage_1['status'] == "Lodged") { 
                                ?>

                                <?php //} 
                                ?>


                                <!-- In Progress  date  -->
                                <?php //if (isset($stage_1['in_progress_date']) && !empty($stage_1['in_progress_date'])) { 
                                ?>
                                <!--    <tr>-->
                                <!--        <th>-->
                                <!--            Date In Progress-->
                                <!--        </th>-->
                                <!--        <td>-->
                                <!--            <?php
                                                //if (!empty($stage_1['in_progress_date']) && $stage_1['in_progress_date'] != "0000-00-00 00:00:00" && $stage_1['in_progress_date'] != null) {
                                                // echo date("d/m/Y", strtotime($stage_1['in_progress_date']));
                                                // } 
                                                ?>
                                <!--        </td>-->
                                <!--    </tr>-->
                                <?php //} 
                                ?>
                                <?php //if (isset($stage_1['status']) && $stage_1['status'] == "In Progress") { 
                                ?>

                                <?php //} 
                                ?>

                                <!-- Approved  date -->
                                <?php if (isset($stage_1['status']) && $stage_1['status'] == "Approved") {  ?>
                                <?php } ?>

                                <?php if (isset($stage_1['approved_date'])) {
                                    if (!empty($stage_1['approved_date']) && $stage_1['approved_date'] != "0000-00-00 00:00:00" && $stage_1['approved_date'] != null) {
                                ?>
                                        <tr>
                                            <th>
                                                Date Approved
                                            </th>
                                            <td>
                                                <?php
                                                if (!empty($stage_1['approved_date']) && $stage_1['approved_date'] != "0000-00-00 00:00:00" && $stage_1['approved_date'] != null) {
                                                    echo date("d/m/Y", strtotime($stage_1['approved_date']));
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <!-- Decline  date / Reason -->
                                <?php if (isset($stage_1['status']) && $stage_1['status'] == "Declined") { ?>
                                    <?php if (isset($stage_1['declined_date']) && !empty($stage_1['declined_date'])) {
                                        if (!empty($stage_1['declined_date']) && $stage_1['declined_date'] != "0000-00-00 00:00:00" && $stage_1['declined_date'] != null) { ?>
                                            <tr>
                                                <th>
                                                    Date Declined
                                                </th>
                                                <td>
                                                    <?php
                                                    if (!empty($stage_1['declined_date']) && $stage_1['declined_date'] != "0000-00-00 00:00:00" && $stage_1['declined_date'] != null) {
                                                        echo date("d/m/Y", strtotime($stage_1['declined_date']));
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($stage_1['declined_reason']) && !empty($stage_1['declined_reason']) && strlen($stage_1['declined_reason']) > 2) { ?>
                                        <tr>
                                            <th>
                                                Reason
                                            </th>
                                            <td>
                                                <?= $stage_1['declined_reason'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <!-- Withdrawn  date  -->
                                <?php if (isset($stage_1['status']) && $stage_1['status'] == "Withdrawn") { ?>
                                    <?php if (isset($stage_1['withdraw_date']) && !empty($stage_1['withdraw_date'])) {
                                        if (!empty($stage_1['withdraw_date']) && $stage_1['withdraw_date'] != "0000-00-00 00:00:00" && $stage_1['withdraw_date'] != null) {
                                    ?>
                                            <tr>
                                                <th>
                                                    Date Withdrawn
                                                </th>
                                                <td>
                                                    <?php
                                                    if (!empty($stage_1['withdraw_date']) && $stage_1['withdraw_date'] != "0000-00-00 00:00:00" && $stage_1['withdraw_date'] != null) {
                                                        echo date("d/m/Y", strtotime($stage_1['withdraw_date']));
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>


                                <!-- Expiry Date --> <!-- 25-04-2023 vishal patel  -->
                            
                                <?php 
                                if ($stage_index < 12) {  ?>
                                    <?php
                                    // echo $stage_index;
                                    // $expiry_date_temp = strtotime($stage_1['expiry_date']);
                                    $expiry_date_temp = strtotime(date('Y-m-d'));
                                    $approved_date_temp = strtotime($stage_1['approved_date']);
                                    $timeleft = $expiry_date_temp - $approved_date_temp;
                                    $day_remain_ = round((($timeleft / 86400))); // <!-- 25-04-2023 vishal patel  -->
                                    $day_remain_ = 29 - $day_remain_;
                                    ?>
                                    <?php if ($stage_1['status'] != "Expired") { ?>
                                        <?php if (isset($stage_1['status']) && $stage_1['status'] == "Approved" || $stage_1['status'] == "Archive" || $stage_1['status'] == "Expired") { ?>
                                            <?php if (isset($stage_1['expiry_date']) && !empty($stage_1['expiry_date'])) { ?>
                                                <?php if (!empty($stage_1['expiry_date']) && $stage_1['expiry_date'] != "0000-00-00 00:00:00" && $stage_1['expiry_date'] != null) { ?>
                                                    <?php if ($day_remain < -30) { ?>
                                                        <tr>
                                                            <th>
                                                                Expiry Date
                                                            </th>
                                                            <td> <!-- 25-04-2023 vishal patel  -->
                                                                <?= date('d/m/Y', strtotime('+30 days', strtotime($stage_1['approved_date'])));  ?>
                                                                <span class="text-danger"> (<?= $day_remain_ ?> Days Left) </span>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <th> <!-- 25-04-2023 vishal patel  -->
                                                Date
                                                <?php
                                                if ($day_remain >= 0) {
                                                    echo "Closed";
                                                } else  if ($day_remain > -30 && $day_remain < 0) {
                                                    echo "Expired";
                                                } else {
                                                    echo "Expired";
                                                }
                                                // echo $day_remain;
                                                ?>
                                            </th>
                                            <td> <!-- 25-04-2023 vishal patel  -->
                                            <?php 
                                            if ($day_remain >= 0) {
                                                    echo  date('d/m/Y', strtotime($stage_1['expiry_date']));
                                                }
                                                else{
                                                    echo date('d/m/Y', strtotime('+30 days', strtotime($stage_1['approved_date'])));
                                                }
                                            ?>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                    <!--  Archive / Expired-->
                                    <?php if (isset($stage_1['status']) && $stage_1['status'] == "Archive" || $stage_1['status'] == "Expired") { ?>

                                        <?php if ($day_remain >= -30  && $day_remain < 0) { ?> <!-- 25-04-2023 vishal patel  -->
                                            <tr>
                                                <td colspan="2">
                                                    <div class="p-2 bg-yellow rounded">
                                                        Kindly reach out on
                                                        <b><a href="mail:dilpreet.bagga@attc.org.au">dilpreet.bagga@attc.org.au</a></b>
                                                        or +61-401200991 to re-instate the application. The applications can only be re-instated within 60 days from the date of Stage 1 approval,
                                                        conditional to the applicant still meeting the eligibility requirements.
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                        <?php if ($day_remain >= 0) { ?> <!-- 25-04-2023 vishal patel  -->
                                            <tr>
                                                <td colspan="2">
                                                    <div class="p-2 bg-yellow rounded">
                                                        As the Stage 2 was not submitted within 60 days from the date of Stage 1 approval,
                                                        this application has now been closed. Please feel free to lodge a new application.
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    <?php } ?>

                                <?php } ?>





                                <?php if (!$show_Additional_Information_Request) { ?>
                                    <!-- stage 2 start alert box  -->
                                    <?php if (isset($stage_1['status']) && $stage_1['status'] == "Submitted" || $stage_1['status'] == "Lodged" ||  $stage_1['status'] == "In Progress") { ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="p-2 bg-yellow text-green rounded">
                                                    We shall contact you if any further documentation is required. In the meantime you may want to start preparing your stage 2 documentation.
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>



                            </thead>
                        </table>

                        <!-- Download Application Form Button  -->
                        <div class="col-sm-12">
                            <!-- <div class="bg-yellow rounded p-2">
                                We shall contact you if any further documentation is required. In the meantime you may want to start preparing your stage 2 documentation. Kindly download the Stage 2 document checklist below.
                            </div> -->
                            <div class="row">
                                <div class="col-sm-6 p-3">
                                    <a href="<?= $TRA_Application_Form_url ?> " class="btn btn_green_yellow w-100" download> Download Submitted Application <i class="bi bi-download"></i> </a>
                                </div>
                                <?php if (isset($stage_1['status']) && $stage_1['status'] != "Declined" && $stage_1['status'] != "Expired" && $stage_1['status'] != "Withdrawn") { ?>

                                    <div class="col-sm-6 p-3">
                                        <a href="<?= base_url('/public/assets/PDF/Stage%202%20Applicant%20Checklist.pdf') ?>" class="btn btn_green_yellow w-100" download>Download Stage 2 Checklist <i class="bi bi-download "></i></a>
                                    </div>

                                <?php } ?>
                                <?php if (isset($stage_1['status']) && $stage_1['status'] != "Declined" && $stage_1['status'] != "Expired" && $stage_1['status'] != "Withdrawn") { ?>
                                    <?php if (isset($Application_Details['pathway']) && $Application_Details['pathway'] == "Pathway 1") { ?>
                                       <?php
                                            $display_kit = '';
                                           if($Application_Details['occupation'] == 'Plumber (General)')
                                           {
                                               $display_kit = "display:none";
                                           }else{
                                               $display_kit = "";
                                           }
                                    
                                                //   print_r($Application_Details);
                                            if($Application_Details['occupation'] == "Electrician (General)"){
                                                ?>
                                                <div class="col-sm-12 p-3">
                                                    <a href="<?= base_url('public/assets/offline_file/third_party/UEE30820%20-%20Electrician%20(General)%20-%20Third%20Party%20Report.pdf')?>" 
                                                    class="btn btn_green_yellow w-100" style="" 
                                                    download="UEE30820 - Electrician (General) - Third Party Report" target="_blank">
                                                        Download Third Party Report 
                                                        <i class="bi bi-download"></i> 
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                       ?>
                                       
                                       
                                       <?php
                                       
                                       ?>
                                    
                                        <?php if (isset($stage_2_application_kit) && $stage_2_application_kit['application_kit_file_available'] && $Application_Details['occupation'] != "Electrician (General)") { ?>
                                            <div class="col-sm-12 p-3">

                                                <a href="<?php if (isset($stage_2_application_kit['File_full_path'])) {
                                                                echo base_url($stage_2_application_kit['File_full_path']);
                                                            } ?>" class="btn btn_green_yellow w-100" style="<?= $display_kit ?>" download="<?php if (isset($stage_2_application_kit['name'])) {
                                                                                                                    echo $stage_2_application_kit['name'];
                                                                                                                } ?>">Download Applicant Kit <i class="bi bi-download"></i> </a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($stage_index == 5) {  ?>

                                <?php } ?>
                            </div>
                        </div>

                        <!-- stage 2 start button in stage 1 -->
                        <?php if ($stage_index == 11 || $stage_index == 5) { ?>
                            <?php if (!$is_employe_add) { ?>
                                <div class="row mb-2">
                                    <!-- <h2> Start Documentry Evidence </h2> -->
                                    <!-- <div class="col-sm-6 mb-2">
                                        <a href="<?= base_url('public/assets/PDF/Stage%202%20Applicant%20Checklist.pdf') ?>" class="btn btn_green_yellow w-100" download="">Download Stage 2 Checklist <i class="bi bi-download "></i></a>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <?php if (isset($stage_2_application_kit) && $stage_2_application_kit['application_kit_file_available']) { ?>
                                            <a href="<?php if (isset($stage_2_application_kit['File_full_path'])) {
                                                            echo base_url($stage_2_application_kit['File_full_path']);
                                                        } ?>" class="btn btn_green_yellow w-100" download="<?php if (isset($stage_2_application_kit['name'])) {
                                                                                                                echo $stage_2_application_kit['name'];
                                                                                                            } ?>">Download Applicant Kit <i class="bi bi-download"></i> </a>
                                        <?php } ?>
                                    </div> -->

                                    <div class=" col-sm-12 mb-2">
                                        <a href="<?= base_url('user/stage_2/add_employment') ?>/<?= $ENC_pointer_id ?>" class="btn btn_yellow_green w-100">
                                            Start Stage 2 Submission
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                    </div>

                    <!-- stage 1 documents  -->
                    <div class="col-sm-6">

                        <!-- main parent DIV  -->
                        <div class="accordion" id="accordionExample">
                            <!-- comman container for 1 item  -->
                            <div class="accordion-item">
                                <!-- Clickebal Button  -->
                                <h2 class="accordion-header" id="s1_tital_div">
                                    <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;font-size:18px !important " type="button" data-bs-toggle="collapse" data-bs-target="#s1_tital_body_div" aria-expanded="false" aria-controls="s1_tital_body_div">
                                        <h5 class="text-green" style="font-size:18px"><b> Submitted Documents </b></h5>
                                    </button>
                                </h2>
                                <!-- collapseabal Div show all data / collapse Body  -->
                                <div id="s1_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s1_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th> Sr.No. </th>
                                                    <th> Document Name </th>
                                                    <!-- <td> Document </td> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($documents as $key => $value) {
                                                    if ($value['stage'] == "stage_1") {
                                                        if ($value['required_document_id'] > 0 && $value['required_document_id'] != 21 && $value['required_document_id'] != 50) {
                                                            $show_f = true;
                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                            if (!empty($documnet_request)) {
                                                                if (isset($documnet_request->status)) {
                                                                    if ($documnet_request->status == "send") {
                                                                        $show_f = false;
                                                                    }
                                                                }
                                                            }
                                                            if($show_f){
                                                            $i++;
                                                            $required_document_id = $value['required_document_id'];

                                                            ?>
                                                            <tr>
                                                                <td> <?= $i; ?> </td>
                                                                <td>
                                                                    <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">
                                                                        <?= $value['name']; ?>
                                                                    </a>
                                                                </td>
                                                                <!-- <td> <img src="<?= base_url($value['document_path'] . '/' . $value['document_name']) ?>" width="150px"> </td> -->
                                                            </tr>
                                                <?php
                                                            }
                                                        } // required_document_id
                                                    } // stage
                                                } // forech 
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- stage 1 Action Requad  -->
                    <?php if ($stage_index >= 2 && $stage_index <= 5) {  ?>

                        <?php if ($show_Additional_Information_Request) {

                        ?>
                            <!-- stage 1  -->
                            <div class="col-sm-12 mm">

                                <h2 class="text-green"><b>Action Required</b></h2>
                                <form action=""  class="add_info_req_stage" id="add_info_req_stage_1" method="post" >
                                    <table class="table table-striped table-hover ">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Sr.No.</th>
                                                <th style="width: 45%;">Comment</th>
                                                <th style="width: 25%;">Document Name</th>
                                                <th style="width: 25%;">Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 1;

                                        foreach ($additional_info_request as $key => $value) {
                                            $pointer_id = $value['pointer_id'];
                                            $document_id = $value['document_id'];
                                            $stage = $value['stage'];
                                            $reason = $value['reason'];
                                            $status = $value['status'];
                                            $update_date = $value['update_date'];
                                            if ($stage == "stage_1" && $status == "send") {
                                                $doc_info = documents_info($pointer_id, $document_id);
                                                // if (!empty($doc_info)) {
                                                // echo "jfgj";
                                                if (isset($doc_info['required_document_id'])) {
                                                    $doc_required_document_id = $doc_info['required_document_id'];
                                                } else {
                                                    $doc_required_document_id = 28;
                                                }
                                                if ($doc_info) {
                                                    $doc_id = $doc_info['id'];
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"  value="' . $doc_info['name'] . '" readonly>';
                                                } else {
                                                    $doc_id = '';
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"   required>';
                                                }
                                                $required_list = find_one_row('required_documents_list','id',$doc_required_document_id);
                                                // $allowed_type = $required_list->allowed_type;
                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                $accept = "";
                                                $accept_note = "";
                                                $CHECK_LOOP = 0;
                                                $brack_point = count($allowed_type) - 1;
                                                foreach ($allowed_type as $key => $value_1) {
                                                    $accept .= '.' . $value_1 . ',';
                                                    $accept_note .= ' .' . $value_1;
                                                    $CHECK_LOOP++;
                                                    if ($CHECK_LOOP <= $brack_point) {
                                                        $accept_note .=   ' /';
                                                    }
                                                }
                                               

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $reason ?></td>
                                                    <td><?= $doc_name ?></td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]" accept="<?=$accept?>" required />
                                                        <div class="text-danger col-sm-6 ">
                                                            Only : <?= $accept_note ?>
                                                        </div>
                                                          
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value['id'] ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value['send_by'] ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $doc_id ?>">
                                                        <input type="hidden" name="stage" value="stage_1">

                                                    </td>
                                                </tr>
                                        <?php

                                                $i++;
                                            } // if stage_1
                                        } // forech
                                        ?>
                                    </table>
                                    <div class="mb-3 text-center">
                                        <!-- <button type="button" class="btn btn_green_yellow" onclick="add_info_req('stage_1')">upload</button> -->
                                        <button type="submit"  class="btn btn_green_yellow add_info_req_upload">Submit Additional Information</button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>

                    <?php } ?>
                    <!-- stage 1 Action Requad  -->

                </div>
            </div>
        <?php  }  ?>
        <!-- stage 1  -->

        <!-- stage 2  -->
        <?php if (!empty($s2_show)) { ?>

           <div class="tab-pane fade <?= $s2_show ?> bg-white shadow p-3" id="stage_2" role="tabpanel" aria-labelledby="stage_2-tab">
                <div class="row mt-3">


                    <!--stage 2  status info  and button -->
                    <div class="col-sm-6">

                        <!-- info table  -->
                        <table class="table <?= (isset($stage_2) && empty($stage_2)) ? "d-none " : ""; ?>">
                            <thead>


                                <?php if (isset($stage_2['status']) && !empty($stage_2['status'])) { ?>
                                    <?php if ($stage_2['status'] == "Start") { ?>
                                        <?php if (isset($stage_1['status']) && $stage_1['status'] == "Approved" || $stage_1['status'] == "Archive") { ?>
                                            <?php if (isset($stage_1['expiry_date']) && !empty($stage_1['expiry_date'])) { ?>


                                                <?php
                                                // $expiry_date_temp = strtotime($stage_1['expiry_date']);
                                                $expiry_date_temp = strtotime(date('Y-m-d'));
                                                // $expiry_date_temp = strtotime(date('Y-m-d', strtotime('+30 days', strtotime($stage_1['approved_date']))));
                                                $approved_date_temp = strtotime($stage_1['approved_date']);

                                                $timeleft = $expiry_date_temp - $approved_date_temp;
                                                $day_remain_ = round((($timeleft / 86400)));
                                                $day_remain_ = 30 - $day_remain_;
                                                ?>
                                                <?php if ($day_remain != 0 && $day_remain > 0) { ?>
                                                    <tr>
                                                        <th>
                                                            Expiry Date
                                                        </th>
                                                        <td>
                                                            <?= date('d/m/Y', strtotime('-30 days', strtotime($stage_1['expiry_date'])));  ?>
                                                            <span class="text-danger"> (<?= $day_remain_ ?> Days Left) </span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            <?php } ?>
                                        <?php } ?>
                                        <?php if (isset($stage_1['status']) && $stage_1['status'] == "Archive") { ?>
                                            <!-- Date Archive  -->
                                            <?php if (isset($stage_1['archive_date']) && !empty($stage_1['archive_date'])) { ?>
                                                <tr>
                                                    <th>
                                                        Date Archive
                                                    </th>
                                                    <td>
                                                        <?= $stage_1['archive_date'] ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            <!-- Archive yellow alert box  -->
                                            <tr>
                                                <td colspan="2">
                                                    <div class="p-2 bg-yellow rounded">
                                                        Kindly reach out on <b><a href="tel:+61-401200991">+61-401200991</a></b> or
                                                        email to <b><a href="mail:dilpreet.bagga@attc.org.au">dilpreet.bagga@attc.org.au</a></b>
                                                        to re-instate the application. The applications can only be re-instated within
                                                        60 days from the date of Stage 1 approval, conditional to the applicant still
                                                        meeting the eligibility requirements.
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    <?php } ?>

                                    <!-- stage 2  status  start-->
                                <?php } ?>
                                <!-- stage 2 status -->

                                <!-- Employment Verification  true and false--> <!-- 25-04-2023 Vishal Patel  -->
                                <?php
                                $show_Employment_Verification = false;
                                $status_of_varification = "Pending";
                                $checck_panding = 0;
                                $checck_complated = 0;
                                $total = 0;

                                if (isset($stage_2['status']) && $stage_2['status'] == "Submitted") {
                                    // print_r($email_verification);

                                    foreach ($email_verification as $key => $value) {
                                        $total++;
                                        // echo "<pre>";
                                        // print_r($email_verification);
                                        // echo "</pre>";
                                        if ($value['verification_type'] == "Verification - Employment" || $value['verification_type'] == "Verification Email - Employment") {
                                            $verification_email_id = $value['verification_email_id'];
                                            $employer_id = $value['employer_id'];
                                            $is_verification_done = $value['is_verification_done'];

                                            if ($is_verification_done == 0) {
                                                $checck_panding++;
                                            } else {
                                                $checck_complated++;
                                            }
                                            $show_Employment_Verification = true;
                                        }
                                        // break; <!-- 25-04-2023 Vishal Patel  -->
                                    }
                                    if ($checck_panding == 0) {
                                        $status_of_varification = "Completed";
                                    } else {
                                        $status_of_varification = "Pending";
                                    }
                                } ?>


                                <?php if (isset($stage_2['status']) && !empty($stage_2['status'])) { ?>
                                    <?php if ($stage_2['status'] != "Start") { ?>
                                        <tr>
                                            <th>
                                                Status
                                            </th>
                                            <td>
                                                <?php if ($show_Employment_Verification) { ?>
                                                    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalToggleLabel">
                                                                        Employment Verification
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <table style=" border: none !important; margin-top: 0px !important; font-size:90%" class="table">
                                                                        <tbody>
                                                                            <tr style="border: none !important;" class="bg-green text-white">
                                                                                <th scope="col" style="width: 5;"> Sr.No. </th>
                                                                                <th scope="col" style="width: 25;"> Referee Name </th>
                                                                                <th scope="col" style="width: 30;"> Referee Email </th>
                                                                                <th scope="col" style="width: 30;"> Company/Organisation </th>
                                                                                <th scope="col" style="width: 10;"> Status </th>
                                                                            </tr>
                                                                            <?php
                                                                            $count = 0;

                                                                            foreach ($email_verification as $key => $value) {
                                                                                if ($value['verification_type'] == "Verification - Employment" || $value['verification_type'] == "Verification Email - Employment") {

                                                                                    // if ($value['verification_type'] == "Verification Email - Employment") {
                                                                                    $verification_email_id = $value['verification_email_id'];
                                                                                    $employer_id = $value['employer_id'];
                                                                                    $is_verification_done = $value['is_verification_done'];

                                                                                    if ($is_verification_done == 1) {
                                                                                        $status = "Verified";
                                                                                        $status = '<span class="bg-green text-white p-2 rounded">' . $status . ' </span>';
                                                                                    } else {
                                                                                        $status = "Pending";
                                                                                        $status = '<span class="bg-yellow text-black p-2 rounded">' . $status . ' </span>';
                                                                                    }

                                                                                    $stage_2_add_employment = find_one_row('stage_2_add_employment', 'id', $employer_id);


                                                                                    $count++; ?>

                                                                                    <tr>
                                                                                        <td style=" border: none !important; margin-top: 0px !important;"> <?= $count ?>
                                                                                        </td>
                                                                                        <td style=" border: none !important; margin-top: 0px !important;"> <?= (isset($stage_2_add_employment->referee_name) ? $stage_2_add_employment->referee_name : "") ?></td>
                                                                                        <td style=" border: none !important; margin-top: 0px !important;"> <?= (isset($stage_2_add_employment->referee_email) ? $stage_2_add_employment->referee_email:"") ?></td>
                                                                                        <td style=" border: none !important; margin-top: 0px !important;"><?= (isset($stage_2_add_employment->company_organisation_name) ? $stage_2_add_employment->company_organisation_name : "") ?></td>
                                                                                        <td style=" border: none !important; margin-top: 0px !important;  ">
                                                                                            <span class="bg-yellow text-black"> <b><?= $status ?></b> </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a class="text-black" data-bs-toggle="modal" href="#exampleModalToggle" role="button">
                                                        Employment Verification (<?= $status_of_varification ?>) <!-- 25-04-2023 Vishal Patel -->
                                                        <img id="myImage" src="<?= base_url('public/assets/icon/new_popup_.png') ?>" width="40px" style="padding-left: 10px;" onmouseover="hoverImage()" onmouseout="originalImage()">
                                                    </a>

                                                <?php } else { ?>
                                                    <b> <?php 
                                                    if(isset($stage_2["status"])){
                                                        if($stage_2['status'] == "Declined"){
                                                            echo "Unsuccessful";
                                                        }else{
                                                        echo $stage_2['status'];
                                                        }
                                                    }
                                                    ?></b>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Date Submitted
                                            </th>
                                            <td>
                                                <?= date("d/m/Y", strtotime($stage_2['submitted_date'])) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($show_Employment_Verification) { ?>
                                    <tr>
                                        <td colspan="2">


                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($show_Employment_Verification) { ?>
                                    <!-- </div>
                                    </div> -->
                                <?php } ?>




                                <!-- Approved  date -->
                                <?php if (isset($stage_2['approved_date']) && !empty($stage_2['approved_date'])) { ?>
                                    <tr>
                                        <th>
                                            Date Approved
                                        </th>
                                        <td>
                                            <?= date("d/m/Y", strtotime($stage_2['approved_date'])) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($stage_2['status']) && $stage_2['status'] == "Approved") { ?>

                                <?php } ?>

                                <!-- Decline  date / Reason -->
                                <?php if (isset($stage_2['status']) && $stage_2['status'] == "Declined") { ?>
                                    <?php if (isset($stage_2['declined_date']) && !empty($stage_2['declined_date'])) { ?>
                                        <tr>
                                            <th>
                                                Date Declined
                                                <!--Date Failed-->
                                            </th>
                                            <td>
                                                <?= date("d/m/Y", strtotime($stage_2['declined_date'])) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (isset($stage_2['declined_reason']) && !empty($stage_2['declined_reason']) && strlen($stage_2['declined_reason']) > 2) { ?>
                                        <tr>
                                            <th>
                                                Reason
                                            </th>
                                            <td>
                                                <?= $stage_2['declined_reason'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <!-- Withdrawn  date  -->
                                <?php if (isset($stage_2['status']) && $stage_2['status'] == "Withdrawn") { ?>
                                    <?php if (isset($stage_2['withdraw_date']) && !empty($stage_2['withdraw_date'])) { ?>
                                        <tr>
                                            <th>
                                                Date Withdrawn
                                            </th>
                                            <td>
                                                <?= date("d/m/Y", strtotime($stage_2['withdraw_date'])) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>


                                <?php if (isset($stage_2['archive_date']) && $stage_2['archive_date'] == 0) { ?>
                                    <tr>
                                        <th>
                                            Date archive_date
                                        </th>
                                        <td>
                                            <?= $stage_2['archive_date'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </thead>
                        </table>





                        <!-- <div class="d-flex align-items-center justify-content-center"> -->
                        <div class="col-sm-12">
                            <!-- stage 2  Continue and all Button pooja-->

                            <div class="row " >
                                <div class="col-sm-6  mb-2">
                                    <a href="<?= base_url('public/assets/PDF/Stage%202%20Applicant%20Checklist.pdf') ?>" class="btn btn_green_yellow w-100" download="">Download Stage 2 Checklist <i class="bi bi-download "></i></a>
                                </div>
                                    <?php
                                    if ($Application_Details['pathway'] == "Pathway 1") {
                                        
                                         $dispaly_kit = '';
                                       
                                        if($Application_Details['occupation'] == 'Plumber (General)' || $Application_Details['occupation'] == 'Electrician (General)')
                                        {
                                            $dispaly_kit = "display:none";
                                        }else{
                                            $dispaly_kit = '';
                                        }
                                         $offline_files=find_one_row('offline_file','id',58);
                                       //  print_r($offline_files);
                                          if (isset($offline_files)) { ?>
                                        <div class="col-sm-6  mb-2 ">
                                            <a href="<?php if (isset($offline_files)) {
                                                            echo base_url($offline_files->path_text);
                                                        } ?>" class="btn btn_green_yellow w-100" download="<?php if (isset($offline_files->name)) {
                                                                                                                echo $offline_files->name;
                                                                                                            } ?>" style="" >Download
                                                Third Party Report <i class="bi bi-download"></i> </a>
                                        </div>
                                        <?php } ?> 
                                        
                                        
                                        <?php 
                                        // print_r($stage_2_application_kit);
                                        if (isset($stage_2_application_kit) && $stage_2_application_kit['application_kit_file_available']) { ?>
                                        <div class="col-sm-6  mb-2" style="<?= $dispaly_kit?>" >
                                            <a href="<?php if (isset($stage_2_application_kit['File_full_path'])) {
                                                            echo base_url($stage_2_application_kit['File_full_path']);
                                                        } ?>" class="btn btn_green_yellow w-100" download="<?php if (isset($stage_2_application_kit['name'])) {
                                                                                                                echo $stage_2_application_kit['name'];
                                                                                                            } ?>" >Download
                                                Applicant Kit <i class="bi bi-download"></i> </a>
                                        </div>
                                        <?php } ?>   
                                        
                                        
                                        
                                        
                                        
                                        
                                    <?php } ?>
                                    <?php 
                                    // print_r($stage_2);
                                    // exit;
                                        if ($is_active == "stage_2") {
                                            if(isset($stage_2['status']) && $stage_2["status"] == "Declined"){?>
                                            <!-- show document for pathway 1 only  -->
                                            <!--<div class="row mt-2 mb-2">-->
                                                <?php 
                                                foreach ($stage_2_decline_documnets as $key => $value) {
                                                    // <!-- Outcome Letter -->
                                                    if ($value['required_document_id'] == 51) {  ?>
                                                        <div class="col-sm-6 mb-2">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php } 
                                                    //  Statement of Reasons 
                                                     if ($value['required_document_id'] == 52) { ?>
                                                        <div class="col-sm-6 mb-2">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php }
                                                }?>
                                            
                                        <?php }
                                            }
                                        ?>

                                <?php
                                // echo $stage_index;
                                if ($stage_index == 11 || $stage_index == 5) { ?>
                                    <div class="col-sm-12 mb-2">
                                        <a href="<?= base_url('user/stage_2/add_employment_document') ?>/<?= $ENC_pointer_id ?>" class="btn btn_yellow_green w-100">
                                            Continue Stage 2 Submission
                                        </a>
                                    </div>
                                <?php }?>


                                  <?php 
                                  //$country_aus=find_one_row('stage_1_contact_details','pointer_id',$pointer_id);
                                      
                                    
                                  
                                  ?>
                                <!-- Start Stage 3 Submission Button in stage 2  -->
                                <?php if ($stage_index == 15) {
                                    
                                    
                                      //print_r($country_aus->country);
                                    $pointer_id = pointer_id_decrypt($ENC_pointer_id);
                                    $data = check_stage_user_side('stage_3',$pointer_id);
                                    // print_r($data);
                                    if (!$data) {
                                        $value = "Start Stage 3 Submission";
                                    } else {
                                        $value = "Continue Stage 3 Submission";
                                    }
                                  $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
                                 
                                ?>
                                    <?php  if($stage_1_usi_avetmiss->currently_have_usi=='yes'){ ?>
                                   
                                    <div class="col-sm-12  mb-2 mt-3" style="max-width:670px;">
                                        <a href="<?= base_url('user/stage_3/receipt_upload_page__') ?>/<?= $ENC_pointer_id ?>" class="btn btn_yellow_green w-100">
                                            <?= $value ?>
                                        </a>
                                    </div>
                                   <?php }else{  ?>

                                    <div class="col-sm-12  mb-2 mt-3" style="max-width:670px;">
                                        <a href="<?= base_url('user/stage_3/receipt_upload') ?>/<?= $ENC_pointer_id ?>" class="btn btn_yellow_green w-100">
                                            <?= $value ?>
                                        </a>
                                    </div>
                                <?php
                                } 
                                }
                                ?>


                            </div>


                        </div>




                    </div>

                    <!-- stage 2 Submitted Documents  -->
                    <?php
                    // check stage 2 documant availebal to show 
                    $show_stage_2_documents = false;
                    foreach ($documents as $key => $value) {
                        if ($value['stage'] == "stage_2") {
                            if ($value['required_document_id'] > 0) {
                                $show_stage_2_documents = true;
                            }
                        }
                    }

                    // create employee name list for filter 
                    $total_employee = array();
                    $i = 0;
                    foreach ($documents as $key => $value) {
                        if ($value['stage'] == "stage_2") {
                            if ($value['required_document_id'] > 0) {
                                $i++;
                                $required_document_id = $value['required_document_id'];
                                $employee_id = $value['employee_id'];
                                $employment_info = stage_2_employment_info($employee_id);
                                if (!empty($employment_info)) {
                                    $data = [
                                        "id" => $employment_info['id'],
                                        "company_organisation_name" => $employment_info['company_organisation_name'],
                                    ];
                                    if (!in_array($data, $total_employee)) {
                                        $total_employee[] = $data;
                                    }
                                }
                            }
                        }
                    }
                    ?>

                    <!-- show stage 2 document -->
                    <?php if (isset($stage_2['status']) &&  $stage_2['status'] != "Start") { ?>
                        <?php if ($show_stage_2_documents) {  ?>
                            <div class="col-sm-6">
                                <!-- main parent DIV  -->
                                <div class="accordion" id="accordionExample">
                                    <!-- comman container for 1 item  -->
                                    <div class="accordion-item">
                                        <!-- Clickebal Button  -->
                                        <h2 class="accordion-header" id="s2_tital_div">
                                            <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s2_tital_body_div" aria-expanded="false" aria-controls="s2_tital_body_div">
                                                <h6 class="text-green" style="font-size:18px !important rohit"><b> Submitted Documents </b></h6>
                                            </button>
                                        </h2>
                                        <!-- collapseabal Div show all data / collapse Body  -->
                                        <div id="s2_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s1_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:200px;">

                                            <div class="card-body bg-white  w-100 col-sm-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th> Sr.No. </th>
                                                            <th> Document Name </th>
                                                            <!-- <td> Document </td> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Compony or employ  documents 
                                                        foreach ($total_employee as $key => $val) {
                                                            echo "<tr class='bg-light p-2'><td  colspan='2'>" . $val['company_organisation_name'] . "</td><tr>";
                                                            $i = 0;
                                                            foreach ($documents as $key => $value) {
                                                                if ($value['stage'] == "stage_2") {
                                                                    if ($value['required_document_id'] > 0) {
                                                                         $required_document_id = $value['required_document_id'];
                                                                        $employee_id = $value['employee_id'];
                                                                        if ($val['id'] == $employee_id) {
                                                                            $show_f = true;
                                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                            
                                                                            if (!empty($documnet_request)) {
                                                                                if (isset($documnet_request->status)) {
                                                                                    if ($documnet_request->status == "send") {
                                                                                        $show_f = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                           
                                                                           if (!($value['required_document_id'] == 18 || $value['required_document_id'] == 42)) {

                                        
                                                                               //print_r($value);
                                                                               if($value['is_additional'] ==''){
                                                                            if($show_f){
                                                            
                                                                                $i++;
    
                                                                                 $name = $value['name'];
                                                                                $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                if ($file_info['is_multiple']) {
                                                                                    $name = $file_info['document_name'];
                                                                                }
    
                                                                                echo '<tr>
                                                                                        <td> ' . $i . ' </td>
                                                                                        <td>
                                                                                            <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                            ' . $name . '
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>';
                                                                            }
                                                                           }
                                                                           $span_name = '<snap style="font-size:70%;color:black">(Additional Information)</snap>';
                                                                            if($value['is_additional'] == 'yes'){
                                                                            if($show_f){
                                                            
                                                                                $i++;
    
                                                                                 $name = $value['name'];
                                                                                $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                if ($file_info['is_multiple']) {
                                                                                    $name = $file_info['document_name'];
                                                                                }
    
                                                                                echo '<tr>
                                                                                        <td> ' . $i . ' </td>
                                                                                        <td>
                                                                                            <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                            ' . $name . '  ' . $span_name . ' 
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>';
                                                                            }
                                                                           }
                                                                
                                                                            }
                                                                            if($value['required_document_id']==18 ||$value['required_document_id']==42){
                                                                            if($show_f){
                                                            
                                                                                $i++;
    
                                                                                 $name = $value['name'];
                                                                                //$file_info = (!empty(getdatafromdocs__organisation(18)) ? required_documents_info(18) : "");
                                                                                // if ($file_info['is_multiple']) {
                                                                                //     $name = $file_info['document_name'];
                                                                                // }
    
                                                                                echo '<tr>
                                                                                        <td> ' . $i . ' </td>
                                                                                        <td>
                                                                                            <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                            ' . $name . '
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>';
                                                                            }
                                                                            }
                                                                        }
                                                                         
                                                                        
                                                                        
                                                                    } // required_document_id
                                                                } // stage
                                                            } // forech 
                                                            
                                                        } // forech 

                                                        // Assessment Documents
                                                        $i = 0;

                                                        echo "<tr class='bg-light p-2'><td  colspan='2'>  Assessment Documents  </td><tr>";
                                                        $supporting_docs = array();
                                                        $addtion_info_doc =array();
                                                        foreach ($documents as $key => $value) {
                                                           // print_r($value);
                                                            if($value['required_document_id']==17 AND $value['is_additional']==''){
                                                                // echo"<pre>";
                                                                 //print_r($value);
                                                           
                                                            if ($value['required_document_id'] == 16) {
                                                                array_push($supporting_docs, array('id' => $value['id'], 'path' => $value['document_path'], 'name' => $value['document_name']));
                                                            }
                                                            // elseif($value['required_document_id'] == 17){
                                                            //     // echo $value['required_document_id'];
                                                            //     // echo"hello";
                                                            //     // die;
                                                            // // array_push($addtion_info_doc, array('id' => $value['id'], 'path' => $value['document_path'], 'name' => $value['document_name']));
                                                            // }
                                                                if ($value['stage'] == "stage_2") {
                                                                    
                                                                     
                                                                    if ($value['required_document_id']== 15|| $value['required_document_id']==30 ||$value['required_document_id']==17|| $value['required_document_id']==34 || $value['required_document_id']==34) {
                                                                     
                                                                        $required_document_id = $value['required_document_id'];
                                                                        $employee_id = $value['employee_id'];
                                                                     
                                                                        if ($employee_id == 0 || empty($employee_id)) {
                                                                            $show_f = true;
                                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                             
                                                                            if (!empty($documnet_request)) {
                                                                                if (isset($documnet_request->status)) {
                                                                                    if ($documnet_request->status == "send") {
                                                                                        $show_f = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                            
                                                                            if($show_f){
                                                                           
                                                                                    $i++;
                                                                                    $name = $value['name'];
                                                                                    $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                    if ($file_info['is_multiple']) {
                                                                                        $name = $file_info['document_name'];
                                                                                    }
                                                                                    if ($value["name"] == "Verification Email - Employment" || $value["required_document_id"] == 21 || $value["required_document_id"] == 22) {
                                                                                        $i--;
                                                                                        continue;
                                                                                    }
                                                                                    echo '<tr>
                                                                                    <td> ' . $i . ' </td>
                                                                                    <td>
                                                                                        <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                        ' . $name . '
                                                                                        
                                                                                        </a>
                                                                                    </td
                                                                                    
                                                                                </tr>';
                                                                            }
                                                                        }
                                                                        }
                                                                    } // required_document_id
                                                                 // stage
                                                            } // forech 
                                                            
                                                             if($value['is_additional']=='' ||$value['is_additional']=='yes'){
                                                                
                                                           
                                                            if ($value['required_document_id'] == 16 ||$value['required_document_id'] == 17  ) {
                                                                array_push($supporting_docs, array('id' => $value['id'], 'path' => $value['document_path'], 'name' => $value['document_name']));
                                                            }
                                                            // elseif($value['required_document_id'] == 17){
                                                            //     // echo $value['required_document_id'];
                                                            //     // echo"hello";
                                                            //     // die;
                                                            // // array_push($addtion_info_doc, array('id' => $value['id'], 'path' => $value['document_path'], 'name' => $value['document_name']));
                                                            // }
                                                                if ($value['stage'] == "stage_2") {
                                                                    
                                                                    // echo $value['required_document_id'];
                                                                    if ($value['required_document_id']== 15|| $value['required_document_id']==30 ||$value['required_document_id']==17|| $value['required_document_id']==34 || $value['required_document_id']==53 ) {
                                                                       $required_document_id = $value['required_document_id'];
                                                                        $employee_id = $value['employee_id'];
                                                                        if ($employee_id == 0 || empty($employee_id)) {
                                                                            $show_f = true;
                                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                           
                                                                            
                                                                            if (!empty($documnet_request)) {
                                                                                if (isset($documnet_request->status)) {
                                                                                    if ($documnet_request->status == "send") {
                                                                                        $show_f = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                      //      print_r($value);
                                                                       if($required_document_id <>30){
                                                                            if($show_f){
                                                                          
                                                                                    $i++;
                                                                                    $name = $value['name'];
                                                                                    $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                    if ($file_info['is_multiple']) {
                                                                                        $name = $file_info['document_name'];
                                                                                         
                                                                                    }
                                                                                    if ($value["name"] == "Verification Email - Employment" || $value["required_document_id"] == 21 || $value["required_document_id"] == 22) {
                                                                                        $i--;
                                                                                        continue;
                                                                                    }
                                                                                    if($value['is_additional']=='yes'){
                                                                                        $span_name = '<snap style="font-size:70%;color:black">(Additional Information)</snap>';
                                                                                    echo '<tr>
                                                                                    <td> ' . $i . ' </td>
                                                                                    <td>
                                                                                        <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                        ' . $name . ' ' . $span_name . '
                                            
                                                                                        </a>
                                                                                    </td
                                                                                    
                                                                                </tr>';
                                                                            
                                                                            }else{
                                                                                echo '<tr>
                                                                                    <td> ' . $i . ' </td>
                                                                                    <td>
                                                                                        <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                        ' . $name . '
                                                                                        </a>
                                                                                    </td
                                                                                    
                                                                                </tr>'; 
                                                                            }
                                                                            }
                                                                        }
                                                                       if($required_document_id == 30){
                                                                            if($show_f){
                                                                          
                                                                                    $i++;
                                                                                    $name = $value['name'];
                                                                                    $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                    // if ($file_info['is_multiple']) {
                                                                                    //     $name = $file_info['document_name'];
                                                                                    // }
                                                                                    if ($value["name"] == "Verification Email - Employment" || $value["required_document_id"] == 21 || $value["required_document_id"] == 22) {
                                                                                        $i--;
                                                                                        continue;
                                                                                    }
                                                                                    if($value['is_additional']=='yes'){
                                                                                    echo '<tr>
                                                                                    <td> ' . $i . ' </td>
                                                                                    <td>
                                                                                        <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                        ' . $name . '
                                                                                        </a>
                                                                                    </td
                                                                                    
                                                                                </tr>';
                                                                            
                                                                            }else{
                                                                                echo '<tr>
                                                                                    <td> ' . $i . ' </td>
                                                                                    <td>
                                                                                        <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                        ' . $name . '
                                                                                        </a>
                                                                                    </td
                                                                                    
                                                                                </tr>'; 
                                                                            }
                                                                            }
                                                                        }     
                                                                        }
                                                                        }
                                                                    } // required_document_id
                                                                 // stage
                                                            }

                                                        }

                                                        ?>
                                                        
                                                        <?php
                                                         $additional_eve = getdataforsupporetingevidance($pointer_id);
                                                        if ($additional_eve) {
                                                            echo "<tr class='bg-light p-2'><td  colspan='2'>  Supporting Evidences for Application Kit  </td><tr>";
                                                            $i = 0;
                                                         
                                                         
                                                         
                                                             foreach ($additional_eve as $key => $value) {
                                                                 //print_r($value);
                                                                  $show_f = true;
                                                                  $documnet_request = find_one_row('documents', 'id', $value['document_id']);
                                                                  
                                                                    $path=$documnet_request->document_path;
                                                                    $docname = $documnet_request->document_name;
                                                                    $dname = $documnet_request->name;
                                                                    if($documnet_request->is_additional==''){
                                                                if($show_f){
                                                                   
                                                                    echo '<tr>
                                                                        <td> ' . ++$i . ' </td>
                                                                        <td>
                                                                            <a target="_blank" href="' . base_url($path . '/' . $docname) . '">
                                                                            ' . $dname . '
                                                                            </a>
                                                                            
                                                                        </td>
                                                                    </tr>';

                                                                }
                                                             } 
                                                             
                                                             if(!$additional_eve){
                                                                   
                                                                   
                                                                 $doc_id=16;
                                                                 $documnet_request_ = getdatafromdocs__($doc_id,$pointer_id);
                                                                 foreach($documnet_request_ as $documnet_request__){
                                                                     echo "<pre>";
                                                                 print_r($additional_eve);
                                                                //  die;
                                                                   $show_f = true;
                                                                     $path=$documnet_request__['document_path'];
                                                                     $docname = $documnet_request__['document_name'];
                                                                if($show_f){
                                                                   
                                                                    echo '<tr>
                                                                        <td> ' . ++$i . ' </td>
                                                                        <td>
                                                                            <a target="_blank" href="' . base_url($path . '/' . $docname) . '">
                                                                            ' . $documnet_request__['name'] . ' 
                                                                            </a>
                                                                            
                                                                        </td>
                                                                    </tr>';

                                                                } 
                                                                
                                                                 }
                                                               }
                                                              if($documnet_request->is_additional=='yes'){
                                                                  $span_name = '<snap style="font-size:70%;color:black">(Additional Information)</snap>';
                                                                if($show_f){
                                                                   
                                                                    echo '<tr>
                                                                        <td> ' . ++$i . ' </td>
                                                                        <td>
                                                                            <a target="_blank" href="' . base_url($path . '/' . $docname) . '">
                                                                            ' . $dname . '  ' . $span_name . '
                                                                            </a>
                                                                            
                                                                        </td>
                                                                    </tr>';

                                                                }
                                                             } 
                                                            }   // required_document_id
                                                               
                                                        } // forech 

                                                        // if (!empty($addtion_info_doc)) {
                                                        //     // print_r($addtion_info_doc);
                                                        //     echo "<tr class='bg-light p-2'><td  colspan='2'> Additional Information  </td><tr>";
                                                        //     $i = 0;
                                                        //     foreach ($addtion_info_doc as $key => $value) {
                                                        //         $show_f = true;
                                                        //         $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                        //         if (!empty($documnet_request)) {
                                                        //             if (isset($documnet_request->status)) {
                                                        //                 if ($documnet_request->status == "send") {
                                                        //                     $show_f = false;
                                                        //                 }
                                                        //             }
                                                        //         }
                                                        //         if($show_f){
                                                              
                                                        //             $i++;
                                                        //             echo '<tr>
                                                        //                 <td> ' . $i . ' </td>
                                                        //                 <td>
                                                        //                     <a target="_blank" href="' . base_url($value['path'] . '/' . $value['name']) . '">
                                                        //                     ' . $value['name'] . '
                                                        //                     </a>
                                                        //                 </td>
                                                        //             </tr>';

                                                        //         }
                                                        //         // required_document_id
                                                        //     }
                                                        // } // forech 





                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <!-- show stage 2 Additional Information Request -->
                    <?php
                    // echo "<pre>";
                    // print_r($additional_info_request);
                    $show_additional_info_request = false;
                    foreach ($additional_info_request as $key__ => $value__) {
                        $stage__ = $value__['stage'];
                        $status__ = $value__['status'];
                        if ($stage__ == "stage_2" && $status__ == "send") {
                            $show_additional_info_request = true;
                        }
                    }

                    $employ_show = false;
                    // group by
                    
                    foreach ($total_employee as $key_4 => $val_4) {
                           $employee_id = $val_4['id'];
                           $pointer_id;
                        // Override the Loop
                        // if(empty($employee_id )){
                        //   $additional_info_requestnull= getAdditionalInfoByEmp_idnull($pointer_id,$employee_id);
                        //     print_r($additional_info_requestnull);
                        //     die;
                         
                        // }else{
                        //       
                            
                        // }
                        
                       
                        $additional_info_request= getAdditionalInfoByEmp_id($pointer_id,$employee_id);
                        // print_r($additional_info_request);
                        // continue;
                        foreach ($additional_info_request as $key => $value) {
                            
                            $stage = $value['stage'];
                            $status = $value['status'];
                            if ($stage == "stage_2" && $status == "send") {
                                $request_document_id = $value['document_id'];
                                foreach ($documents as $key_2 => $val_2) {
                                    $doc_id = $val_2['id'];
                                    if ($doc_id == $request_document_id) {
                                        $request_employee_id = $val_2['employee_id'];
                                        if ($employee_id == $request_employee_id) {
                                            $employ_show = true;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    //   echo $show_additional_info_request;
                    if ($show_additional_info_request) {

                        $i = 0;
                    ?>
                        <!-- <span class="h2 text-danger">
                            Developer working on it. Please wait few minutes.
                        </span> -->

                        <!-- stage 2 Action Required by rohit-->
                        <div class="col-sm-12 mm">
                            <h2 class="text-green"><b>Action Required </b></h2> 
                            <form action="" class="add_info_req_stage" id="add_info_req_stage_2" method="post" enctype="multipart/form-data">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Sr.No.</th>
                                            <!-- <th>Company Organisation Name</th> -->
                                            <th style="width: 45%;">Comment</th>
                                            <th style="width: 25%;">Document Name</th>
                                            <th style="width: 25%;">Action</th>
                                        </tr>
                                    </thead>
                                    
                                    
                                    <?php
                                   
                                    // print_r($employ_show);
                                    if ($employ_show) { ?>

                                        <?php
                                        $new_list = array();
                                        
                                        foreach ($total_employee as $key_4 => $val_4) {
                                            $employee_id = $val_4['id'];
                                          $company_organisation_name = $val_4['company_organisation_name'];
                                          //print_r(  $company_organisation_name);
                                            foreach ($additional_info_request as $key => $value) {
                                                $stage = $value['stage'];
                                                $status = $value['status'];
                                                $add_req_id =  $value['id'];
                                                $send_by =  $value['send_by'];
                                                $update_date = $value['update_date'];
                                                if ($stage == "stage_2" && $status == "send") {
                                                    $pointer_id = $value['pointer_id'];
                                                    $reason = $value['reason'];
                                                    $request_document_id = $value['document_id'];

                                                    foreach ($documents as $key_2 => $val_2) {
                                                        $doc_id = $val_2['id'];
                                                        $required_document_id = $val_2['required_document_id'];


                                                        if ($doc_id == $request_document_id) {
                                                            $doc_id . " " . $request_document_id;


                                                            $request_employee_id = $val_2['employee_id'];
                                                            if ($employee_id == $request_employee_id) {

                                                                $doc_name = $val_2['name'];
                                                                $list_ = array();
                                                                $list_['company_organisation_name'] = $company_organisation_name;
                                                                $list_['doc_name'] = $doc_name;
                                                                $list_['reason'] = $reason;
                                                                $list_['pointer_id'] = $pointer_id;
                                                                $list_['send_by'] = $send_by;
                                                                $list_['add_req_id'] = $add_req_id;
                                                                $list_['doc_id'] = $doc_id;
                                                                $list_['employee_id'] = $employee_id;
                                                                $list_['required_document_id'] = $required_document_id;
                                                                $new_list[] = $list_;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        // new
 
                                        $company_names = array_unique(array_column($new_list, "company_organisation_name"));
                                       

                                        // company loop
                                        $new_array = array();

                                        foreach ($company_names as $company_name) {
                                            //
                                            $company_name_array = [];
                                            foreach ($new_list as $list) {
                                                if ($company_name == $list["company_organisation_name"]) {
                                                    array_push($company_name_array, $list);
                                                }
                                            }
                                            $new_array[$company_name] = $company_name_array;
                                            // array_push($new_array, $company_name_array);
                                        }
                                        // pre
                                        // echo "<pre>";
                                        // print_r($new_array);
                                        // echo "</pre>";
                                        // 

                                        // new array with only one record for each employee name
                                        // $new_array = array();

                                        // foreach ($new_list as $employee) {
                                        //     $name = $employee['company_organisation_name'];
                                        //     if (!isset($new_array[$name])) {
                                        //         $new_array[$name] = $employee;
                                        //     }
                                        // }
                                        // echo "<pre>";
                                        // print_r($new_array);
                                        // echo "</pre>";

                                        ?>




                                    <?php } ?>



                                    <?php
                                    
                                    $request_asses_doc =request_asses_doc__alternate($pointer_id);
                                    //  echo "<pre>";
                                    // print_r($request_asses_doc);
                                  
                                    if($request_asses_doc){
                                    echo "<tr class='bg-light p-2 rohit'><td  colspan='4'>  Assessment Documents </td><tr>";
                                    $custom_i = 0;
                                    foreach ($request_asses_doc as $value) {
                                        // if($value->document_id){
                                        //     continue;
                                        // }
                                        

                                        $stage = $value->stage;
                                        $status = $value->status;
                                        $update_date = $value->update_date;
                                        $custom_i++;
                                        // if ($stage == "stage_2" && $status == "send") {
                                            $pointer_id = $value->pointer_id;
                                              $reason = $value->reason;
                                            $request_document_id = $value->document_id;
                                            // echo $request_document_id;
                                        //  $doc_name = find_one_row('documents','id',$request_document_id);
                                        //  foreach($doc_name as $doc_)
                                        //  {
                                        //      echo $doc_->name;
                                        //  }
                                        //  print_r($doc_name);
                                        //  
                                            if(!empty($request_document_id)){
                                                // $data = "yes";
                                             $replace_doc=getdocumentsbyid($request_document_id);
                                             $replace_doc_name = '';
                                             foreach($replace_doc as $replace_doc_)
                                             {
                                                 $replace_doc_name = $replace_doc_['name'];
                                            //  echo $replace_doc_name;
                                             }
                                                $style='readonly';
                                            //  print_r($replace_doc);
                                            }else{
                                               $replace_doc_name = '';
                                                $style='';
                                            }
                                            // print_r($replace_doc);
                                            // die;
                                            // if (!empty($request_document_id)) {
                                                // print_r($documents);
                                                // exit;
                                                ?>
                                                <tr>
                                                    <td><?= $custom_i?></td>
                                                    <!-- <td></td> -->
                                                    <td style="text-align: justify;"><?= $reason ?></td>
                                                    <td>
                                                        <input type="text" name="doc_name[]" class="form-control mb-2" value="<?= $replace_doc_name ?>"  required <?=$style;?> >
                                                    </td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]" accept=".jpg,.jpeg,.png,.pdf,.xlsx,.mp4,video/mp4,video/x-m4v,video/*" value="" required />
                                                        <div class="text-danger col-sm-6 ">
                                                            Only :  .jpg / .jpeg / .png / .pdf / .xlsx / mp4                                                                        
                                                        </div>
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $value->document_id ?>">
                                                        <input type="hidden" name="stage" value="stage_2">
                                                        <input type="hidden" name="employee_id[]" value="">
                                                        <input type="hidden" name="support_evidance_status[]" value="">

                                                    </td>
                                                </tr>
                                                
                                                <?php
                                                
                                                foreach ($documents as $key_2 => $val_2) {
                                                    
                                                    if ($val_2['id'] == $request_document_id) {
                                                        $doc_name = $val_2['name'];
                                                        // $doc_name = "";
                                                        // if ($val_2['employee_id'] == 0 || $val_2['employee_id'] == "") {
                                                            // if($val_2['required_document_id'] == 15 || $val_2['required_document_id'] == 16 || $val_2['required_document_id'] == 30 || $val_2['required_document_id'] == 34){
                                                            if ($val_2['id']) {
                                                               $request_id =  $val_2['required_document_id'];
                                                                // echo "<pre>";
                                                                // print_r($val_2);
                                                                // echo '</pre>';
                                                                // exit;
                                                                $i++;
                                                                
                                                                
                                                                
                                                                if(empty($request_id)){
                                                                $request_id = 17;
                                                                }
                                                                
                                                                // print_r($request_id);
                                                                $required_list = find_one_row('required_documents_list','id',$request_id);
                                                                // print_r($required_list);
                                                                $allowed_type = $required_list->allowed_type;
                                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                                $accept = "";
                                                                $accept_note = "";
                                                                $CHECK_LOOP = 0;
                                                                $brack_point = count($allowed_type) - 1;
                                                                foreach ($allowed_type as $key => $valrew) {
                                                                    $accept .= '.' . $valrew . ',';
                                                                    $accept_note .= ' .' . $valrew;
                                                                    $CHECK_LOOP++;
                                                                    if ($CHECK_LOOP <= $brack_point) {
                                                                        $accept_note .=   ' /';
                                                                    }
                                                                }
                                                               
                                                    ?>
                                                               
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <!--<tr>-->
                                                                <!--    <td><?= $i ?></td>-->
                                                                    <!-- <td></td> -->
                                                                <!--    <td style="text-align: justify;"><?= $reason ?></td>-->
                                                                <!--    <td>-->
                                                                <!--        <input type="text" name="doc_name[]" value="<?= $doc_name ?>" class="form-control mb-2" readonly required />-->

                                                                        <!-- <input type="text" name="doc_name[]" class="form-control mb-2" required /> -->
                                                                <!--    </td>-->
                                                                <!--    <td>-->
                                                                <!--        <input type="file" class="form-control" name="file[]"accept="<?=$accept?>" required />-->
                                                                <!--        <div class="text-danger col-sm-6 ">-->
                                                                <!--            Only : <?= $accept_note ?>-->
                                                                <!--        </div>-->
                                                                <!--        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">-->
                                                                <!--        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">-->
                                                                <!--        <input type="hidden" name="document_id[]" value="">-->
                                                                <!--        <input type="hidden" name="stage" value="stage_2">-->
                                                                <!--    </td>-->
                                                                <!--</tr>-->
                                    <?php
                                                    //         }
                                                    //         }
                                                    //     }
                                                    }
                                                }
                                            }
                                            $i++;
                                        }
                                    } ?>

                                     <?php
                                    
                                    $request_support_evidance =request_support_evidance($pointer_id);
                                    // print_r($request_support_evidance);
                                    if($request_support_evidance){
                                    echo "<tr class='bg-light p-2 dddsgfdg'><td  colspan='4'> Supporting Evidences for Application Kit </td><tr>";
                                     $evidance_index = 0;
                                    foreach ($request_support_evidance as $value) {
                                        $evidance_index++;
                                        // print_r($value);exit;
                                        $stage = $value->stage;
                                        $status = $value->status;
                                        $update_date = $value->update_date;
                                        // if ($stage == "stage_2" && $status == "send") {
                                           $pointer_id = $value->pointer_id;
                                            $reason = $value->reason;
                                            $request_document_id = $value->document_id;
                                            if (!empty($request_document_id)) {
                                                // print_r($documents);
                                                // exit;
                                                
                                                foreach ($documents as $key_2 => $val_2) {
                                                    
                                                    if ($val_2['id'] == $request_document_id) {
                                                        $doc_name = $val_2['name'];
                                                        // $doc_name = "";
                                                        // if ($val_2['employee_id'] == 0 || $val_2['employee_id'] == "") {
                                                            // if($val_2['required_document_id'] == 15 || $val_2['required_document_id'] == 16 || $val_2['required_document_id'] == 30 || $val_2['required_document_id'] == 34){
                                                            if ($val_2['id']) {
                                                               $request_id =  $val_2['required_document_id'];
                                                                // echo "<pre>";
                                                                // print_r($val_2);
                                                                // echo '</pre>';
                                                                // exit;
                                                                $i++;
                                                                
                                                                
                                                                
                                                                
                                                                $request_id = 17;
                                                                
                                                                
                                                                // print_r($request_id);
                                                                $required_list = find_one_row('required_documents_list','id',$request_id);
                                                                // print_r($required_list);
                                                                $allowed_type = $required_list->allowed_type;
                                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                                $accept = "";
                                                                $accept_note = "";
                                                                $CHECK_LOOP = 0;
                                                                $brack_point = count($allowed_type) - 1;
                                                                foreach ($allowed_type as $key => $valrew) {
                                                                    $accept .= '.' . $valrew . ',';
                                                                    $accept_note .= ' .' . $valrew;
                                                                    $CHECK_LOOP++;
                                                                    if ($CHECK_LOOP <= $brack_point) {
                                                                        $accept_note .=   ' /';
                                                                    }
                                                                }
                                                               
                                                    ?>
                                                                <tr>
                                                                    <td><?= $evidance_index?></td>
                                                                     
                                                                    <td style="text-align: justify;"><?= $reason ?></td>
                                                                    <td>
                                                                        <input type="text" name="doc_name[]" value="<?= $doc_name ?>" class="form-control mb-2" readonly required />

                                                                         <!--<input type="text" name="doc_name[]" class="form-control mb-2" required /> -->
                                                                    </td>
                                                                    <td>
                                                                        <input type="file" class="form-control" name="file[]"  accept="<?=$accept?>" required />
                                                                        <div class="text-danger col-sm-6 ">
                                                                            Only : <?= $accept_note ?>
                                                                        </div>
                                                       
                                                                        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">
                                                                        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">
                                                                        <input type="hidden" name="document_id[]" value="<?= $value->document_id ?>">
                                                                        <input type="hidden" name="stage" value="stage_2">
                                                                        <input type="hidden" name="support_evidance_status[]" value="">
                                                                        <input type="hidden" name="employee_id[]" value="">

                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            } else {
                                                                
                                                            ?>
                                                                <tr>
                                                                    <td><?= $evidance_index ?></td>
                                                                    <!-- <td></td> -->
                                                                    <td style="text-align: justify;"><?= $reason?></td>
                                                                    <td>
                                                                        <input type="text" name="doc_name[]" value="<?= $doc_name ?>" class="form-control mb-2" readonly required />

                                                                        <!-- <input type="text" name="doc_name[]" class="form-control mb-2" required /> -->
                                                                    </td>
                                                                    <td>
                                                                        <input type="file" class="form-control" name="file[]"accept="<?=$accept?>" required />
                                                                        <div class="text-danger col-sm-6 ">
                                                                            Only : <?= $accept_note ?>
                                                                        </div>
                                                                        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">
                                                                        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">
                                                                        <input type="hidden" name="document_id[]" value="<?= $value->document_id ?>">
                                                                        <input type="hidden" name="stage" value="stage_2">
                                                                         <input type="hidden" name="support_evidance_status[]" value="">
                                                                         <input type="hidden" name="employee_id[]" value="">

                                                                        
                                                                    </td>
                                                                </tr>
                                    <?php
                                                    //         }
                                                    //         }
                                                    //     }
                                                    }
                                                }
                                                    
                                            }
                                        }
                                        else{
                                            ?>
                                            
                                            <tr>
                                                                    <td><?= $evidance_index ?></td>
                                                                    <!-- <td></td> -->
                                                                    <td style="text-align: justify;"><?= $reason?></td>
                                                                    <td>
                                                                        <input type="text" name="doc_name[]" value="" class="form-control mb-2"  required />

                                                                        <!-- <input type="text" name="doc_name[]" class="form-control mb-2" required /> -->
                                                                    </td>
                                                                    <td>
                                                                        <input type="file" class="form-control" name="file[]" required />
                                                                        <div class="text-danger col-sm-6 ">
                                                                            Only :  .jpg / .jpeg / .png / .pdf / .xlsx                                                                        </div>
                                                                        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">
                                                                        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">
                                                                        <input type="hidden" name="document_id[]" value="<?= $value->document_id ?>">
                                                                        <input type="hidden" name="stage" value="stage_2">
                                                                        <input type="hidden" name="support_evidance_status[]" value="<?= $value->support_evidance_status ?>">
                                                                        <input type="hidden" name="employee_id[]" value="">   
                                                                    </td>
                                                                </tr>

                                            <?php
                                        }
                                      }
                                    } ?>


                                    <!-- // aditional info rohit -->
                                    <?php
                                       $previousValue = null;
                                    // print_r($additional_info_request);
                                    $grp_by1= getAdditionalInfoBygrp($pointer_id);
                                    // print_r($grp_by1);
                                    // exit;
                                     foreach ($grp_by1 as $key_4 => $val_4) {
                                      //   print_r($total_employee);
                                       $employee_id = $val_4['s2_add_employment_id'];
                                      // Override the Loop
                                    //   $grp_by= getAdditionalInfoBygrp($employee_id);
                                       $grp_by = getAdditionalInfoByEmp_id($pointer_id,$employee_id);
                                    //   echo"<pre>";
                                    //   print_r($grp_by);
                                    //     echo"</pre>";
                                    //     die;
                                    if( $employee_id){
                                       $organisation = find_one_row(' stage_2_add_employment', 'id', $employee_id);
                                        $organisation_value=  $organisation->company_organisation_name;
                                      echo "<tr class='bg-light p-2'><td  colspan='4'>".$organisation_value." </td><tr>";
                                                   $previousValue = $organisation_value;
                                    }else{
                                         echo "<tr class='bg-light p-2'><td  colspan='4'>Assessment Documents</td><tr>";
                                    }
                                    
                                    $custom_i = 0;
                                    // if(count($grp_by) == 0){
                                    //     continue;
                                    // }
                                     foreach ($grp_by as $key => $value) {
                                        //  echo "<pre>";
                                        //  echo $organisation->company_organisation_name;
                                        // print_r($value);
                                        $custom_i++;
                                        $stage = $value['stage'];
                                        $status = $value['status'];
                                        $update_date = $value['update_date'];
                                        if ($stage == "stage_2" && $status == "send") {
                                            
                                            $pointer_id = $value['pointer_id'];
                                            $reason = $value['reason'];
                                             $request_document_id = $value['document_id'];
                                            // echo "<pre>";
                                            //  print_r($value['s2_add_employment_id']);
                                            //  echo $additional_info_request['s2_add_employment_id'];
                                            // echo '</pre>';
                                            
                                                $request_id = 17;
                                                
                                                
                                                // print_r($request_id);
                                                 $required_list = find_one_row('required_documents_list','id',$request_id);
                                                //  print_r($required_list);
                                                $allowed_type = $required_list->allowed_type;
                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                $accept = "";
                                                $accept_note = "";
                                                $CHECK_LOOP = 0;
                                                $brack_point = count($allowed_type) - 1;
                                                foreach ($allowed_type as $key => $valrew) {
                                                    $accept .= '.' . $valrew . ',';
                                                    $accept_note .= ' .' . $valrew;
                                                    $CHECK_LOOP++;
                                                    if ($CHECK_LOOP <= $brack_point) {
                                                        $accept_note .=   ' /';
                                                    }
                                                }
                                       $request_document_id = ($request_document_id == 0) ? "" : $request_document_id;
                                            if ($request_document_id != "") {
                                               $doc_info =getdocumentsbyid($request_document_id);
                                               
                                               foreach($doc_info as $doc_name)
                                               {
                                               
                                             
                                                   
                                               
                                              
                                      // $ organisation = find_one_row(' stage_2_add_employment', 'id', $value['s2_add_employment_id']); 
                                     //  print_r($organisation);
                                            // $organisation_value=  $organisation->company_organisation_name;
                                            // if ($organisation_value !== $previousValue) {
                                                

                                                $i++;
                                    ?>
                                                <tr>
                                                    <td><?= $custom_i?></td>
                                                    <!-- <td></td> -->
                                                    <td style="text-align: justify;"><?= $reason ?></td>
                                                    <td>
                                                        <input type="text" name="doc_name[]" class="form-control mb-2" value="<?=$doc_name['name'] ?>" required readonly />
                                                    </td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]"accept="<?=$accept?>" required />
                                                                        <div class="text-danger col-sm-6 ">
                                                                            Only : <?= $accept_note ?>
                                                                        </div>
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value['id'] ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value['send_by'] ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $value['document_id'] ?>">
                                                        <input type="hidden" name="stage" value="stage_2">
                                                        <input type="hidden" name="employee_id[]" value="<?= $value['s2_add_employment_id'] ?>">
                                                        <input type="hidden" name="support_evidance_status[]" value="">

                                                    </td>
                                                </tr>
                                    <?php 
                                               
                                            }
                                             }
                                             else{
                                                //  Addition information
                                                
                                                ?>
                                                 <tr>
                                                    <td><?= $custom_i?></td>
                                                    <!-- <td></td> -->
                                                    <td style="text-align: justify;"><?= $reason ?></td>
                                                    <td>
                                                        <input type="text" name="doc_name[]" class="form-control mb-2"  required >
                                                    </td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]"accept="<?=$accept?>" required />
                                                                       <div class="text-danger col-sm-6 ">
                                                                            Only :  .jpg / .jpeg / .png / .pdf / .xlsx                                                                        </div>
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value['id'] ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value['send_by'] ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $value['document_id'] ?>">
                                                        <input type="hidden" name="stage" value="stage_2">
                                                        <input type="hidden" name="employee_id[]" value="<?= $value['s2_add_employment_id'] ?>">
                                                        <input type="hidden" name="support_evidance_status[]" value="">

                                                    </td>
                                                </tr>
                                                <?php
                                                // end
                                             }
                                        }
                                    } }?>

                                </table>
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn_green_yellow" >Submit Additional Information</button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>



                </div>
                <!--- row --->
            </div>
        <?php } ?>





        <!-- stage 3  -->
        <?php if (!empty($s3_show)) { ?>
            <div class="tab-pane fade <?= $s3_show ?>  bg-white shadow- p-3" id="stage_3" role="tabpanel" aria-labelledby="stage_3-tab">
                <div class="row mt-3">
                    <!--stage 3  status info  and button -->
                    <div class="col-sm-6">
                        <!-- info table  -->
                        <?php if (isset($stage_3) && !empty($stage_3["status"] != "")) { ?>
                            <!-- stage 3 info  -->
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <td>
                                            <b><?php
                                                if(isset($stage_3["status"])){
                                                    if($stage_3['status'] == "Declined"){
                                                            echo "Unsuccessful";
                                                    }else{
                                                    echo $stage_3['status'];
                                                    }
                                                }
                                                    ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <?php if (!empty($stage_3['submitted_date']) && $stage_3['submitted_date'] != "0000-00-00 00:00:00" && $stage_3['submitted_date'] != null) { ?>
                                        <tr>
                                            <th>
                                                Date Submitted
                                            </th>
                                            <td>
                                                <?= (isset($stage_3["submitted_date"])) ? date("d/m/Y", strtotime($stage_3["submitted_date"])) : "" ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <!--  Date Lodged -->
                                    <?php if (isset($stage_3["status"]) &&  $stage_3["status"] == 'Lodged') { ?>
                                    <?php } ?>
                                    <?php if (!empty($stage_3['lodged_date']) && $stage_3['lodged_date'] != "0000-00-00 00:00:00" && $stage_3['lodged_date'] != null) { ?>

                                    <?php } ?>

                                    <!--  Date Scheduled -->
                                    <?php if (isset($stage_3["status"]) &&  $stage_3["status"] == 'Scheduled') { ?>
                                    <?php } ?>

                                    <?php if (!empty($stage_3['scheduled_date']) && $stage_3['scheduled_date'] != "0000-00-00 00:00:00" && $stage_3['scheduled_date'] != null) { ?>

                                    <?php } ?>

                                    <!--   Date Conducted -->
                                    <?php if (isset($stage_3["status"]) &&  $stage_3["status"] == 'Conducted') { ?>
                                        <!-- <tr>
                                            <th>
                                                Date Conducted
                                            </th>
                                            <td>
                                                <?= (isset($stage_3["conducted_date"])) ? date("d/m/Y", strtotime($stage_3["conducted_date"])) : "" ?>
                                            </td>
                                        </tr> -->
                                    <?php } ?>

                                    <!-- Date Approved -->
                                    <?php if (isset($stage_3["status"]) &&  $stage_3["status"] == 'Approved') { ?>
                                        <?php if (!empty($stage_3['approved_date']) && $stage_3['approved_date'] != "0000-00-00 00:00:00" && $stage_3['approved_date'] != null) { ?>

                                            <tr>
                                                <th>
                                                    Date Approved
                                                </th>
                                                <td>
                                                    <?= (isset($stage_3["approved_date"])) ? date("d/m/Y", strtotime($stage_3["approved_date"])) : "" ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>


                                    <!--   Date Declined -->
                                    <?php if (isset($stage_3["status"]) &&  $stage_3["status"] == 'Declined') { ?>
                                        <?php if (!empty($stage_3['declined_date']) && $stage_3['declined_date'] != "0000-00-00 00:00:00" && $stage_3['declined_date'] != null) { ?>
                                            <tr>
                                                <th>
                                                    Date Declined
                                                    <!--Date Failed-->
                                                </th>
                                                <td>
                                                    <?= (isset($stage_3["declined_date"])) ? date("d/m/Y", strtotime($stage_3["declined_date"])) : "" ?>
                                                </td>
                                            </tr>
                                        <?php } ?>


                                        <!--<tr>-->
                                        <!--    <th>-->
                                        <!--        Reason for Decline-->
                                        <!--    </th>-->
                                        <!--    <td>-->
                                        <!--        <= (isset($stage_3["declined_reason"])) ? $stage_3["declined_reason"] : "" ?>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                    <?php } ?>

                                    <!-- Date Withdrawn -->
                                    <?php if (isset($stage_3["status"]) &&  $stage_3["status"] == 'Withdrawn') { ?>
                                    <?php } ?>

                                    <?php if (!empty($stage_3['withdraw_date']) && $stage_3['withdraw_date'] != "0000-00-00 00:00:00" && $stage_3['withdraw_date'] != null) { ?>
                                        <tr>
                                            <th>
                                                Date Withdrawn
                                            </th>
                                            <td>
                                                <?= (isset($stage_3["withdraw_date"])) ? date("d/m/Y", strtotime($stage_3["withdraw_date"])) : "" ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </thead>
                            </table>


                        <?php } ?>

                        <div class="d-flex">
                            <!-- stage 2  Continue and all Button -->

                            <div class="row w-100 col-sm-12" style="max-width:600px;">

                                        <?php 
                                    // print_r($stage_2);
                                    // exit;
                                        // if ($is_active == "stage_3") {
                                            if(isset($stage_3['status']) && $stage_3["status"] == "Declined"){?>
                                            <!-- show document for pathway 1 only  -->
                                            <!--<div class="row mt-2 mb-2">-->
                                                <?php 
                                                foreach ($stage_3_decline_documnets as $key => $value) {
                                                    // <!-- Outcome Letter -->
                                                    if ($value['required_document_id'] == 23) {  ?>
                                                        <div class="col-sm-6 mb-2">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php } 
                                                    //  Statement of Reasons 
                                                     if ($value['required_document_id'] == 24) { ?>
                                                        <div class="col-sm-6 mb-2">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php }
                                                }?>
                                            
                                        <?php }
                                            // }
                                        ?>

                                <!-- Start Stage 4 Submission Button in stage 3  -->
                         <?php
                        //  echo $stage_index;
                        //         exit;
                                if ($stage_index == 27) {
                                    $pathway = $Application_Details['pathway'];
                                    $occupation = $Application_Details['occupation'];

                                    if ($pathway == "Pathway 1") {
                                        if ($occupation == "Electrician (General)" || $occupation == "Plumber (General)") {
                                        // echo "cgcgngdjg";
                                    $data = check_stage_user_side('stage_4',$pointer_id);
                                    // print_r($data);
                                    if (!$data) {
                                        $value = "Start Stage 4 Submission";
                                    } else {
                                        $value = "Continue Stage 4 Submission";
                                    }

                                ?>
                                            <hr class="mt-4">
                                            <div class="col-sm-12  mb-2 mt-3" style="max-width:600px;">
                                                <a href="<?= base_url('user/stage_4/receipt_upload') ?>/<?= $ENC_pointer_id ?>" class="btn btn_yellow_green w-100">
                                                    <?= $value ?>
                                                </a>
                                            </div>
                                <?php  }
                                    }
                                }
                                ?>

                                

                                <!-- Start Stage 3 Reassessment Submission Button in stage 3  -->
                                <?php if ($stage_index == 28) {
                                    if ($pathway == "Pathway 1") {
                                        if ($occupation == "Electrician (General)" || $occupation == "Plumber (General)") {
                                    
                                    $reassessment_data = check_stage_user_side('stage_3_reassessment',$pointer_id);
                                    if(empty($reassessment_data)){
                                    ?>
                                        <div class="row mt-2 mb-2">
                                        <hr>
                                            <div class="col-sm-12">
                                                <a class="btn btn_yellow_green w-100" id="button_for_apply" onclick="reassessment_stage_3()"> Apply for Reassessment </a>
                                            </div>
                                        </div>
                                    <?php 
                                    }
                                        }
                                    }
                                 } ?>

                                

                            </div>


                        </div>

                    </div>
                    <!-- stage 3
                    -->
                    <div class="col-sm-6">

                        <div class="card">

                            <!-- main parent DIV  -->
                            <div class="accordion" id="accordionExample">
                                <!-- comman container for 1 item  -->
                                <div class="accordion-item">
                                    <!-- Clickebal Button  -->
                                    <h2 class="accordion-header" id="s3_tital_div">
                                        <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s3_tital_body_div" aria-expanded="false" aria-controls="s3_tital_body_div">
                                            <h5 class="text-green"><b> Submitted Documents </b></h5>
                                        </button>
                                    </h2>
                                    <!-- collapseabal Div show all data / collapse Body  -->
                                    <div id="s3_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s3_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th> Sr.No. </th>
                                                        <th> Document Name  </th>
                                                        <!-- <td> Document </td> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($documents as $key => $value) {
                                                        // print_r($documents);
                                                        if ($value['stage'] == "stage_3") {
                                                            if ($value['required_document_id'] == 19 || $value['required_document_id'] == 29 || $value['required_document_id'] == 43 || $value['required_document_id'] == 55) {
                                                                $show_f = true;
                                                                $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                if (!empty($documnet_request)) {
                                                                    if (isset($documnet_request->status)) {
                                                                        if ($documnet_request->status == "send") {
                                                                            $show_f = false;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                                if ($value['required_document_id'] == 19 ||$value['required_document_id'] == 43 ||$value['required_document_id'] == 55) {
                                                                        $span='';
                                                                    }else{
                                                                        
                                                                         $span='<span style="font-size:70%; color:black;">(Additional Information)</span>';
                                                                        
                                                                    }
                                                                
                                                                if($show_f){
                                                            
                                                                $i++;
                                                                $required_document_id = $value['required_document_id'];

                                                                ?>
                                                                <tr>
                                                                    <td> <?= $i; ?> </td>
                                                                    <td>
                                                                        <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">
                                                                            <?= $value['name'].$span; ?>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                    <?php
                                                                }
                                                            } // required_document_id
                                                        } // stage
                                                    } // forech 
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Interview Schedule -->
                    <?php
                    if (isset($stage_3["status"])) {
                        if ($stage_3["status"] == 'Scheduled' || $stage_3["status"] == 'Conducted') {
                            if (isset($Interview_Schedule['is_booked']) && $Interview_Schedule['is_booked'] == 1) { ?>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <td style="width: 30%;border-bottom: 0px;margin-top:10px" colspan="2">
                                                <br>
                                                <u> <b style="color: #055837;"> Interview Booking Details</b></u> <br>
                                            </td>
                                        </tr>
                                        <tr style="background-color: #ffc107 !important;">
                                            <td colspan="2" style="background-color: #ffc107;">
                                                <div style="background-color: #ffc107;">
                                                    <style>
                                                        #sddsf td {
                                                            border: 0px;
                                                            color: #055837;
                                                        }
                                                    </style>
                                                    <table id="sddsf">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 150px;">
                                                                    <b> Day &amp; Date / Time</b>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    :
                                                                </td>
                                                                <td>
                                                                    <!-- time 1  -->
                                                                    <?php
                                                                    $time_date = date('Y-m-d H:i:s', $Interview_Schedule['tmsp']);
                                                                    $date = new DateTime($time_date, new DateTimeZone('Australia/Brisbane'));
                                                                    $time_date_n = $date->format('Y-m-d H:i:s');
                                                                    echo  $date->format('l, jS F Y') . ' / ' . $date->format('h:i A');
                                                                    ?>
                                                                    (Australia/Brisbane Time)
                                                                    <br>

                                                                    <!-- time 2  -->
                                                                    <?php
                                                                    if ($Interview_Schedule['venue'] != 'Australia/Brisbane') {
                                                                    ?>

                                                                        <?php
                                                                        $date->setTimezone(new DateTimeZone($Interview_Schedule['date_time_zone']));
                                                                        echo  $date->format('l, jS F Y') . ' / ' . $date->format('h:i A');
                                                                        ?>
                                                                        (<?= $Interview_Schedule['date_time_zone'] ?> Time)
                                                                        
                                                                    <?php } ?>

                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <b> Venue </b>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    :
                                                                </td>
                                                                <td>
                                                                    <?= $Interview_Schedule['venue'] ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if ($Interview_Schedule['venue']  != "Online (Via Zoom)") {
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <b> Location </b>
                                                                    </td>
                                                                    <td style="width: 20px;">
                                                                        :
                                                                    </td>
                                                                    <td>
                                                                        <?= $Interview_Schedule['office_address'] ?>,
                                                                        <?= $Interview_Schedule['country'] ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>

                                        </tr>

                                    </thead>
                                </table>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>


                    <!-- stage 3 Action Requad  -->
                    
                    <?php 
                     $stage_3_data=find_multiple_rows('additional_info_request','pointer_id',$pointer_id);
                    // echo $stage_index;
                    if ($stage_index >= 22 && $stage_index <= 26) {  ?>
                        <?php
                        $show_Additional_Information_Request = false;
                        foreach ($stage_3_data as $key_1 => $value_1) {
                            $stage = $value_1->stage;
                            $status = $value_1->status;
                            if ($stage == "stage_3" && $status == "send") {
                                $show_Additional_Information_Request = true;
                            }
                        }
                        
                        // echo $show_Additional_Information_Request;
                        ?>
                        <?php 
                          //print_r($stage_3_data);
                        if ($show_Additional_Information_Request) { ?>

                            <!-- stage 3 -->
                            <div class="col-sm-12 mm">
                                <h2 class="text-green"><b>Action Required</b></h2>
                                <form action="" id="add_info_req_stage_3" class="add_info_req_stage" method="post" enctype="multipart/form-data">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Sr.No.</th>
                                                <th style="width: 45%;">Comment</th>
                                                <th style="width: 25%;">Document Name</th>
                                                <th style="width: 25%;">Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 1;
                                        foreach ($stage_3_data as $key => $value) {
                                            $pointer_id = $value->pointer_id;
                                            $document_id = $value->document_id;
                                            $stage = $value->stage;
                                            $reason = $value->reason;
                                            $status = $value->status;
                                            $update_date = $value->update_date;
                                            if ($stage == "stage_3" && $status == "send") {
                                                $doc_info = documents_info($pointer_id, $document_id);
                                                if (isset($doc_info['required_document_id'])) {
                                                    $doc_required_document_id = $doc_info['required_document_id'];
                                                } else {
                                                    $doc_required_document_id = 29;
                                                }
                                                if ($doc_info) {
                                                    $doc_id = $doc_info['id'];
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"  value="' . $doc_info['name'] . '" readonly>';
                                                } else {
                                                    $doc_id = '';
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"   required>';
                                                }
                                                $required_list = find_one_row('required_documents_list','id',$doc_required_document_id);
                                                // $allowed_type = $required_list->allowed_type;
                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                $accept = "";
                                                $accept_note = "";
                                                $CHECK_LOOP = 0;
                                                $brack_point = count($allowed_type) - 1;
                                                foreach ($allowed_type as $key => $value_3) {
                                                    $accept .= '.' . $value_3 . ',';
                                                    $accept_note .= ' .' . $value_3;
                                                    $CHECK_LOOP++;
                                                    if ($CHECK_LOOP <= $brack_point) {
                                                        $accept_note .=   ' /';
                                                    }
                                                }
                                               
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $reason ?></td>
                                                    <td><?= $doc_name ?></td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]" accept="<?=$accept?>" required />
                                                        <div class="text-danger col-sm-6 ">
                                                            Only : <?= $accept_note ?>
                                                        </div>
                                                        
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $doc_id ?>">
                                                        <input type="hidden" name="stage" value="stage_3">

                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php  } ?>
                                        <?php   } ?>
                                    </table>
                                    <div class="mb-3 text-center">
                                        <button type="submit"  class="btn btn_green_yellow add_info_req_upload">Submit Additional Information</button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <!-- stage 3 Action Requad  -->

                </div>
                <?php 
        if (isset($stage_3["status"]) && $stage_3["status"] == "Declined") { 
            if($stage_3_R && isset($stage_3_R["status"]) && ($stage_3_R["status"] == "reassessment" || $stage_3_R["status"] == "start")){
                 $display = ""; 
            }elseif(empty($reassessment_data)){
                // echo "condition 1";
             $display = "display: none";   
            }if(empty($reassessment_data)){
                // echo "condition 1";
             $display = "display: none";   
            }
            ?>
                <hr class="mt-4">

                <div style="<?=$display?>" id= "start_stage_3">
                    <div style="display: none" id="note_stage_3_reassessment">
                        <p style="background-color: #ffc107 !important; color: #055837;padding: 15px;">
                        <b style="color: #055837;">Note :</b>
                        We have now sent an email to the <?=$user_account->account_type ?> Email with the payment instructions for reassessment. You will need the TRA reassessment payment receipt to proceed.
                        </p>
                    </div>
                    <?php 
                    // if($reassessment_data){
                        // print_r($reassessment_data);
                        // exit;
                    if($stage_3_R && isset($stage_3_R["exemption_yes_no"]) && $stage_3_R["exemption_yes_no"] == "" ){
                            $value_stage_3_R = "Start Stage 3 (Reassessment) Submission";
                    }elseif (isset($reassessment_data->exemption_yes_no) && !empty($reassessment_data->exemption_yes_no)=="") {
                        $value_stage_3_R = "Start Stage 3 (Reassessment) Submission";
                    } else {
                        $value_stage_3_R = "Continue Stage 3 (Reassessment) Submission";
                    }

                    ?>
                    
                    <?php 
                    
                     $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
                     if($stage_1_usi_avetmiss->currently_have_usi=='yes'){
                         
                     
                    ?>
                    <div class="col-sm-12  mb-2 mt-3" style="max-width:600px;">
                        <a href="<?= base_url('user/stage_3_reassessment/receipt_upload_page__') ?>/<?= $ENC_pointer_id ?>" id="value_3_R" class="btn btn_green_yellow w-100" >
                            <?= $value_stage_3_R ?>
                        </a>
                    </div>
                    <?php }else{ ?>
                        
                       <div class="col-sm-12  mb-2 mt-3" style="max-width:600px;">
                        <a href="<?= base_url('user/stage_3_reassessment/receipt_upload') ?>/<?= $ENC_pointer_id ?>" id="value_3_R" class="btn btn_green_yellow w-100" >
                            <?= $value_stage_3_R ?>
                        </a>
                    </div>   
                  <?php  } ?>
                    <?php
                    // }
                    ?>
                </div>
              <?php 
        
        }
    ?>
            </div>
        <?php } ?>
        <!-- stage 3  -->
        
        
        
        
        
        <!--akanksha 10 july 2023 -->
        <!-- stage 3 reassessment  -->
        <?php if (!empty($s3_R_show)) { ?>
            <div class="tab-pane fade <?= $s3_R_show ?>  bg-white shadow- p-3" id="stage_3_r" role="tabpanel" aria-labelledby="stage_3_r-tab">
                <div class="row mt-3">
                    <!--stage 3  status info  and button -->
                    <div class="col-sm-6">
                        <!-- info table  -->
                        
                        <?php
                        // print_r($stage_3_R);
                        // exit;
                        if (isset($stage_3_R) && !empty($stage_3_R["status"] != "")) { ?>
                            <!-- stage 3 info  -->
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <td>
                                            <b><?php
                                                if(isset($stage_3_R["status"])){
                                                    if($stage_3_R['status'] == "Declined"){
                                                            echo "Unsuccessful";
                                                    }else{
                                                    echo $stage_3_R['status'];
                                                    }
                                                }
                                                    ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <?php if (!empty($stage_3_R['submitted_date']) && $stage_3_R['submitted_date'] != "0000-00-00 00:00:00" && $stage_3_R['submitted_date'] != null) { ?>
                                        <tr>
                                            <th>
                                                Date Submitted
                                            </th>
                                            <td>
                                                <?= (isset($stage_3_R["submitted_date"])) ? date("d/m/Y", strtotime($stage_3_R["submitted_date"])) : "" ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <!--  Date Lodged -->
                                    <?php if (isset($stage_3_R["status"]) &&  $stage_3_R["status"] == 'Lodged') { ?>
                                    <?php } ?>
                                    <?php if (!empty($stage_3_R['lodged_date']) && $stage_3_R['lodged_date'] != "0000-00-00 00:00:00" && $stage_3_R['lodged_date'] != null) { ?>

                                    <?php } ?>

                                    <!--  Date Scheduled -->
                                    <?php if (isset($stage_3_R["status"]) &&  $stage_3_R["status"] == 'Scheduled') { ?>
                                    <?php } ?>

                                    <?php if (!empty($stage_3_R['scheduled_date']) && $stage_3_R['scheduled_date'] != "0000-00-00 00:00:00" && $stage_3_R['scheduled_date'] != null) { ?>

                                    <?php } ?>

                                    <!--   Date Conducted -->
                                    <?php if (isset($stage_3_R["status"]) &&  $stage_3_R["status"] == 'Conducted') { ?>
                                        <!-- <tr>
                                            <th>
                                                Date Conducted
                                            </th>
                                            <td>
                                                <?= (isset($stage_3_R["conducted_date"])) ? date("d/m/Y", strtotime($stage_3_R["conducted_date"])) : "" ?>
                                            </td>
                                        </tr> -->
                                    <?php } ?>

                                    <!-- Date Approved -->
                                    <?php if (isset($stage_3_R["status"]) &&  $stage_3_R["status"] == 'Approved') { ?>
                                        <?php if (!empty($stage_3_R['approved_date']) && $stage_3_R['approved_date'] != "0000-00-00 00:00:00" && $stage_3_R['approved_date'] != null) { ?>

                                            <tr>
                                                <th>
                                                    Date Approved
                                                </th>
                                                <td>
                                                    <?= (isset($stage_3_R["approved_date"])) ? date("d/m/Y", strtotime($stage_3_R["approved_date"])) : "" ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>


                                    <!--   Date Declined -->
                                    <?php if (isset($stage_3_R["status"]) &&  $stage_3_R["status"] == 'Declined') { ?>
                                        <?php if (!empty($stage_3_R['declined_date']) && $stage_3_R['declined_date'] != "0000-00-00 00:00:00" && $stage_3_R['declined_date'] != null) { ?>
                                            <tr>
                                                <th>
                                                    Date Declined
                                                    <!--Date Failed-->
                                                </th>
                                                <td>
                                                    <?= (isset($stage_3_R["declined_date"])) ? date("d/m/Y", strtotime($stage_3_R["declined_date"])) : "" ?>
                                                </td>
                                            </tr>
                                        <?php } ?>


                                        <!--<tr>-->
                                        <!--    <th>-->
                                        <!--        Reason for Decline-->
                                        <!--    </th>-->
                                        <!--    <td>-->
                                        <!--        <= (isset($stage_3_R["declined_reason"])) ? $stage_3_R["declined_reason"] : "" ?>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                    <?php } ?>

                                    <!-- Date Withdrawn -->
                                    <?php if (isset($stage_3_R["status"]) &&  $stage_3_R["status"] == 'Withdrawn') { ?>
                                    <?php } ?>

                                    <?php if (!empty($stage_3_R['withdraw_date']) && $stage_3_R['withdraw_date'] != "0000-00-00 00:00:00" && $stage_3_R['withdraw_date'] != null) { ?>
                                        <tr>
                                            <th>
                                                Date Withdrawn
                                            </th>
                                            <td>
                                                <?= (isset($stage_3_R["withdraw_date"])) ? date("d/m/Y", strtotime($stage_3_R["withdraw_date"])) : "" ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </thead>
                            </table>


                        <?php } ?>

                        <div class="d-flex">
                            <!-- stage 2  Continue and all Button -->

                            <div class="row w-100 col-sm-12" style="max-width:600px;">

                                        <?php 
                                    // print_r($stage_2);
                                    // exit;
                                        if ($is_active == "stage_3") {
                                            if(isset($stage_3_R['status']) && $stage_3_R["status"] == "Declined"){?>
                                            <!-- show document for pathway 1 only  -->
                                            <!--<div class="row mt-2 mb-2">-->
                                                <?php 
                                                foreach ($stage_3_reassement_decline_documnets as $key => $value) {
                                                    // <!-- Outcome Letter -->
                                                    if ($value['required_document_id'] == 23) {  ?>
                                                        <div class="col-sm-6 mb-2">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php } 
                                                    //  Statement of Reasons 
                                                     if ($value['required_document_id'] == 24) { ?>
                                                        <div class="col-sm-6 mb-2">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php }
                                                }?>
                                            
                                        <?php }
                                            }
                                        ?>

                                <!-- Start Stage 4 Submission Button in stage 3  -->

                                 <?php 
                                //  echo $stage_index;
                                // exit;
                                if ($stage_index == 46) {
                                    $pathway = $Application_Details['pathway'];
                                    $occupation = $Application_Details['occupation'];

                                    if ($pathway == "Pathway 1") {
                                        if ($occupation == "Electrician (General)" || $occupation == "Plumber (General)") {
                                        // echo "cgcgngdjg";
                                    $data = check_stage_user_side('stage_4',$pointer_id);
                                    // print_r($data);
                                    if (!$data) {
                                        $value = "Start Stage 4 Submission";
                                    } else {
                                        $value = "Continue Stage 4 Submission";
                                    }

                                ?>
                                            <hr class="mt-4">
                                            <div class="col-sm-12  mb-2 mt-3" style="max-width:600px;">
                                                <a href="<?= base_url('user/stage_4/receipt_upload') ?>/<?= $ENC_pointer_id ?>" class="btn btn_yellow_green w-100">
                                                    <?= $value ?>
                                                </a>
                                            </div>
                                <?php  }
                                    }
                                }
                                ?>



                            </div>


                        </div>

                    </div>
                    <!-- stage 3
                    -->
                    <div class="col-sm-6">

                        <div class="card">

                            <!-- main parent DIV  -->
                            <div class="accordion" id="accordionExample">
                                <!-- comman container for 1 item  -->
                                <div class="accordion-item">
                                    <!-- Clickebal Button  -->
                                    <h2 class="accordion-header" id="s3_tital_div">
                                        <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s3_tital_body_div" aria-expanded="false" aria-controls="s3_tital_body_div">
                                            <h5 class="text-green"><b> Submitted Documents </b></h5>
                                        </button>
                                    </h2>
                                    <!-- collapseabal Div show all data / collapse Body  -->
                                    <div id="s3_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s3_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th> Sr.No. </th>
                                                        <th> Document Name</th>
                                                        <!-- <td> Document </td> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($documents as $key => $value) {
                                                        if ($value['stage'] == "stage_3_R") {
                                                            if ($value['required_document_id'] == 19 || $value['required_document_id'] == 29 || $value['required_document_id'] == 43 || $value['required_document_id'] == 55 || $value['required_document_id'] == 53) {
                                                                $show_f = true;
                                                                $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                if (!empty($documnet_request)) {
                                                                    if (isset($documnet_request->status)) {
                                                                        if ($documnet_request->status == "send") {
                                                                            $show_f = false;
                                                                        }
                                                                    }
                                                                }
                                                                if($show_f){
                                                            
                                                                $i++;
                                                                $required_document_id = $value['required_document_id'];

                                                                ?>
                                                                <tr>
                                                                    <td> <?= $i; ?> </td>
                                                                    <td>
                                                                        <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">
                                                                            <?= $value['name']; ?>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                    <?php
                                                                }
                                                            } // required_document_id
                                                        } // stage
                                                    } // forech 
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Interview Schedule -->
                    <?php
                    if (isset($stage_3_R["status"])) {
                        if ($stage_3_R["status"] == 'Scheduled' || $stage_3_R["status"] == 'Conducted') {
                            if (isset($Interview_Schedule_R['is_booked']) && $Interview_Schedule_R['is_booked'] == 1) { ?>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <td style="width: 30%;border-bottom: 0px;margin-top:10px" colspan="2">
                                                <br>
                                                <u> <b style="color: #055837;"> Interview Booking Details</b></u> <br>
                                            </td>
                                        </tr>
                                        <tr style="background-color: #ffc107 !important;">
                                            <td colspan="2" style="background-color: #ffc107;">
                                                <div style="background-color: #ffc107;">
                                                    <style>
                                                        #sddsf td {
                                                            border: 0px;
                                                            color: #055837;
                                                        }
                                                    </style>
                                                    <table id="sddsf">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 150px;">
                                                                    <b> Day &amp; Date / Time</b>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    :
                                                                </td>
                                                                <td>
                                                                    <!-- time 1  -->
                                                                    <?php
                                                                    $time_date = date('Y-m-d H:i:s', $Interview_Schedule_R['tmsp']);
                                                                    $date = new DateTime($time_date, new DateTimeZone('Australia/Brisbane'));
                                                                    $time_date_n = $date->format('Y-m-d H:i:s');
                                                                    echo  $date->format('l, jS F Y') . ' / ' . $date->format('h:i A');
                                                                    ?>
                                                                    (Australia/Brisbane Time)
                                                                    <br>

                                                                    <!-- time 2  -->
                                                                    <?php
                                                                    if ($Interview_Schedule_R['venue'] != 'Australia/Brisbane') {
                                                                    ?>

                                                                        <?php
                                                                        $date->setTimezone(new DateTimeZone($Interview_Schedule_R['date_time_zone']));
                                                                        echo  $date->format('l, jS F Y') . ' / ' . $date->format('h:i A');
                                                                        ?>
                                                                        (<?= $Interview_Schedule_R['date_time_zone'] ?> Time)
                                                                    <?php } ?>

                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <b> Venue </b>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    :
                                                                </td>
                                                                <td>
                                                                    <?= $Interview_Schedule_R['venue'] ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if ($Interview_Schedule_R['venue']  != "Online (Via Zoom)") {
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <b> Location </b>
                                                                    </td>
                                                                    <td style="width: 20px;">
                                                                        :
                                                                    </td>
                                                                    <td>
                                                                        <?= $Interview_Schedule_R['office_address'] ?>,
                                                                        <?= $Interview_Schedule_R['country'] ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>

                                        </tr>

                                    </thead>
                                </table>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>


                    <!-- stage 3 Action Requad  -->
                    <?php
               $stage_3_ress_data=find_multiple_rows('additional_info_request','pointer_id',$pointer_id);
                       //print_r($stage_3_ress_data);
                      
                    if ($stage_index <= 42 && $stage_index <= 45) {  
                    
                       
                    
                    ?>
                        <?php
                      //   echo $stage_index;
                        $show_Additional_Information_Request = false;
                        foreach ($stage_3_ress_data as $key_1 => $value_1) {
                            $stage = $value_1->stage;
                            $status = $value_1->status;
                            if ($stage == "stage_3_R" && $status == "send") {
                                $show_Additional_Information_Request = true;
                            }
                        }
                        ?>
                        <?php if ($show_Additional_Information_Request) { 
                        
                        
                        ?>

                            <!-- stage 3 -->
                            <div class="col-sm-12 mm">
                                <h2 class="text-green"><b>Action Required</b></h2>
                                <form action="" id="add_info_req_stage_3_r" class="add_info_req_stage" method="post" enctype="multipart/form-data">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Sr.No.</th>
                                                <th style="width: 45%;">Comment</th>
                                                <th style="width: 25%;">Document Name</th>
                                                <th style="width: 25%;">Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 1;
                                        foreach ($stage_3_ress_data as $key => $value) {
                                           $pointer_id = $value->pointer_id;
                                            $document_id = $value->document_id;
                                            $stage = $value->stage;
                                            $reason = $value->reason;
                                            $status = $value->status;
                                            $update_date = $value->update_date;
                                            if ($stage == "stage_3_R" && $status == "send") {
                                                $doc_info = documents_info($pointer_id, $document_id);
                                                if (isset($doc_info['required_document_id'])) {
                                                    $doc_required_document_id = $doc_info['required_document_id'];
                                                } else {
                                                    $doc_required_document_id = 29;
                                                }
                                                if ($doc_info) {
                                                    $doc_id = $doc_info['id'];
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"  value="' . $doc_info['name'] . '" readonly>';
                                                } else {
                                                    $doc_id = '';
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"   required>';
                                                }
                                                $required_list = find_one_row('required_documents_list','id',$doc_required_document_id);
                                                // $allowed_type = $required_list->allowed_type;
                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                $accept = "";
                                                $accept_note = "";
                                                $CHECK_LOOP = 0;
                                                $brack_point = count($allowed_type) - 1;
                                                foreach ($allowed_type as $key => $value_3) {
                                                    $accept .= '.' . $value_3 . ',';
                                                    $accept_note .= ' .' . $value_3;
                                                    $CHECK_LOOP++;
                                                    if ($CHECK_LOOP <= $brack_point) {
                                                        $accept_note .=   ' /';
                                                    }
                                                }
                                               
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $reason ?></td>
                                                    <td><?= $doc_name ?></td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]" accept="<?=$accept?>" required />
                                                        <div class="text-danger col-sm-6 ">
                                                            Only : <?= $accept_note ?>
                                                        </div>
                                                        
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value->id ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value->send_by ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $doc_id ?>">
                                                        <input type="hidden" name="stage" value="stage_3_R">

                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php  } ?>
                                        <?php   } ?>
                                    </table>
                                    <div class="mb-3 text-center">
                                        <button type="submit"  class="btn btn_green_yellow add_info_req_upload">Submit Additional Information</button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <!-- stage 3 Action Requad  -->

                </div>
            </div>
        <?php } ?>
        <!-- stage 3 reassessment -->



        <!-- stage_4  -->
        <?php  if (!empty($s4_show)) { ?>
            <?php
            $pathway = $Application_Details['pathway'];
            $occupation = $Application_Details['occupation'];

            if ($pathway == "Pathway 1") {
                if ($occupation == "Electrician (General)" || $occupation == "Plumber (General)") {
                    if (!empty($stage_4)) {

                        //if ($stage_index == "Vishal") { 
            ?>
                        <!-- hide code  -->
                        <div class="tab-pane fade  <?= $s4_show ?>  bg-white shadow- p-3" id="stage_4" role="tabpanel" aria-labelledby="stage_4-tab">
                            <div class="row ">
                                <!--stage 4  status info  and button -->
                                <div class="col-sm-6">

                                    <table class="table">

                                        <tbody>
                                            <tr>
                                                <th style="width:50%;">Status</th>
                                                <td><b>
                                                    <?php
                                                    if(isset($stage_4["status"])){
                                                        if($stage_4['status'] == "Declined"){
                                                            echo "Unsuccessful";
                                                        }else{
                                                        echo $stage_4['status'];
                                                        }
                                                    } ?> </b> </td>
                                            </tr>

                                            <tr>
                                                <!-- <th style="width:50%;">Date Completed</th> -->
                                                <th style="width:50%;"> Date Submitted </th>
                                                <td> <?= (isset($stage_4["submitted_date"])) ?  date("d/m/Y", strtotime($stage_4['submitted_date'])) : "" ?>
                                                </td>
                                            </tr>

                                            <?php if (isset($stage_4["status"]) && $stage_4["status"] == "Approved") { ?>
                                                <tr>
                                                    <th style="width:50%;"> Date Approved </th>

                                                    <td> <?= (isset($stage_4["approved_date"])) ? date("d/m/Y", strtotime($stage_4["approved_date"]))  : "" ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <?php if (isset($stage_4["status"]) && $stage_4["status"] == "Declined") { ?>
                                                <tr>
                                                    <th style="width:50%;"> Date Declined </th>

                                                    <td> <?= (isset($stage_4["declined_date"])) ? date("d/m/Y", strtotime($stage_4["declined_date"]))  : "" ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>



                                        </tbody>
                                    </table>
                       
                                    <!-- show Approved admin 4 file  -->
                                    <?php if (isset($stage_4["status"]) && $stage_4["status"] == "Approved") { ?>
                                        <div class="row">
                                            <?php foreach ($documents as $key => $value) {
                                                if ($value['stage'] == "stage_4") {   ?>
                                                    <!-- Upload Qualifications for pathway 1 only -->
                                                        <?php if ($value['required_document_id'] == 47) {   ?>
                                                            <div class="col-sm-6">
                                                                <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($value['required_document_id'] == 48) {   ?>
                                                            <div class="col-sm-6">
                                                                <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                            </div>
                                                        <?php } ?>

                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <!-- show Declined admin 4 file  -->
                                    <?php if (isset($stage_4["status"]) && $stage_4["status"] == "Declined") { ?>
                                        <!-- show document for pathway 1 only  -->
                                        <div class="row">
                                            <?php foreach ($documents as $key => $value) {
                                                if ($value['stage'] == "stage_4") {   ?>
                                                    <!-- Outcome Letter -->
                                                    <?php if ($value['required_document_id'] == 45) {  ?>
                                                        <div class="col-sm-6">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- Statement of Reasons -->
                                                    <?php if ($value['required_document_id'] == 46) { ?>
                                                        <div class="col-sm-6">
                                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>


                                </div>
                                <!-- stage 4 submitted Documents -->
                                <div class="col-sm-6">

                                    <div class="card">

                                        <!-- main parent DIV  -->
                                        <div class="accordion" id="accordionExample">
                                            <!-- comman container for 1 item  -->
                                            <div class="accordion-item">
                                                <!-- Clickebal Button  -->
                                                <h2 class="accordion-header" id="s3_tital_div">
                                                    <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s3_tital_body_div" aria-expanded="false" aria-controls="s3_tital_body_div">
                                                        <h5 class="text-green"><b> Submitted Documents </b></h5>
                                                    </button>
                                                </h2>
                                                <!-- collapseabal Div show all data / collapse Body  -->
                                                <div id="s3_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s3_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                                                    <div class="card-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th> Sr.No. </th>
                                                                    <th> Document Name</th>
                                                                    <!-- <td> Document </td> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 0;
                                                                foreach ($documents as $key => $value) {
                                                                    if ($value['stage'] == "stage_4") {
                                                                        if ($value['required_document_id'] == 44 || $value['required_document_id'] == 49 ) {
                                                                            $show_f = true;
                                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                            if (!empty($documnet_request)) {
                                                                                if (isset($documnet_request->status)) {
                                                                                    if ($documnet_request->status == "send") {
                                                                                        $show_f = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                            
                                                                            
                                                                            if($value['required_document_id'] == 49){
                                                                                $span='<span style="font-size:70%; color:black;">(Additional Information)</span>';
                                                                            }else{
                                                                                $span='';
                                                                            }
                                                                            if($show_f){
                                                            
                                                                            $i++;
                                                                            $required_document_id = $value['required_document_id'];

                                                                ?>
                                                                            <tr>
                                                                                <td> <?= $i; ?> </td>
                                                                                <td>
                                                                                    <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">
                                                                                        <?= $value['name'].$span; ?>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                <?php
                                                                            }
                                                                        } // required_document_id
                                                                    } // stage
                                                                } // forech 
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            
                                 <?php if ($show_stage_4_addition_request) {
                                     $stage_4_data=find_multiple_rows_for_stage4($pointer_id);
                        ?>
                            <!-- stage 4  -->
                            <div class="col-sm-12 mm">

                                <h2 class="text-green"><b>Action Required</b></h2>
                                <form action="" class="add_info_req_stage" id="add_info_req_stage_4" method="post" >
                                    <table class="table table-striped table-hover ">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Sr.No.</th>
                                                <th style="width: 45%;">Comment</th>
                                                <th style="width: 25%;">Document Name</th>
                                                <th style="width: 25%;">Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $i = 1;
                                         //print_r($stage_4_data);
                                        foreach ($stage_4_data as $key => $value) {
                                            $pointer_id = $value['pointer_id'];
                                            $document_id = $value['document_id'];
                                            $stage = $value['stage'];
                                            $reason = $value['reason'];
                                            $status = $value['status'];
                                            $update_date = $value['update_date'];
                                            if ($stage == "stage_4" && $status == "send") {
                                                $doc_info = documents_info($pointer_id, $document_id);
                                                // if (!empty($doc_info)) {
                                                // echo "jfgj";
                                                if (isset($doc_info['required_document_id'])) {
                                                    $doc_required_document_id = $doc_info['required_document_id'];
                                                } else {
                                                    $doc_required_document_id = 49;
                                                }
                                                if ($doc_info) {
                                                    $doc_id = $doc_info['id'];
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"  value="' . $doc_info['name'] . '" readonly>';
                                                } else {
                                                    $doc_id = '';
                                                    $doc_name = '<input type="text" name="doc_name[]" class="form-control mb-2"   required>';
                                                }
                                                $required_list = find_one_row('required_documents_list','id',$doc_required_document_id);
                                                // $allowed_type = $required_list->allowed_type;
                                                $allowed_type = json_decode($required_list->allowed_type); // array data
                                                $accept = "";
                                                $accept_note = "";
                                                $CHECK_LOOP = 0;
                                                $brack_point = count($allowed_type) - 1;
                                                foreach ($allowed_type as $key => $value_4) {
                                                    $accept .= '.' . $value_4 . ',';
                                                    $accept_note .= ' .' . $value_4;
                                                    $CHECK_LOOP++;
                                                    if ($CHECK_LOOP <= $brack_point) {
                                                        $accept_note .=   ' /';
                                                    }
                                                }
                                                                        
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $reason ?></td>
                                                    <td><?= $doc_name ?></td>
                                                    <td>
                                                        <input type="file" class="form-control" name="file[]" accept="<?=$accept?>" required />
                                                        <div class="text-danger col-sm-6 ">
                                                            Only : <?= $accept_note ?>
                                                        </div>
                                                        
                                                        <input type="hidden" name="add_req_id[]" value="<?= $value['id'] ?>">
                                                        <input type="hidden" name="send_by" value="<?= $value['send_by'] ?>">
                                                        <input type="hidden" name="document_id[]" value="<?= $doc_id ?>">
                                                        <input type="hidden" name="stage" value="stage_4">

                                                    </td>
                                                </tr>
                                        <?php

                                                $i++;
                                            } // if stage_4
                                        } // forech
                                        ?>
                                    </table>
                                    <div class="mb-3 text-center">
                                        <button type="submit" class="btn btn_green_yellow add_info_req_upload">Submit Additional Information</button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
           
                            </div>
                             <?php
                    if (isset($stage_4["status"])) {
                        // echo $stage_4["status"];
                        if ($stage_4["status"] == 'Scheduled' || $stage_4["status"] == 'Conducted') {
                            // echo "dvgdsdx";
                            // print_r($practical_booking);
                            if (isset($practical_booking['is_booked']) && $practical_booking['is_booked'] == 1) {
                                                        // echo "dvgdsdx";
                                ?>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <td style="width: 30%;border-bottom: 0px;margin-top:10px" colspan="2">
                                                <br>
                                                <u> <b style="color: #055837;"> Pratical Booking Details</b></u> <br>
                                            </td>
                                        </tr>
                                        <tr style="background-color: #ffc107 !important;">
                                            <td colspan="2" style="background-color: #ffc107;">
                                                <div style="background-color: #ffc107;">
                                                    <style>
                                                        #sddsf td {
                                                            border: 0px;
                                                            color: #055837;
                                                        }
                                                    </style>
                                                    <table id="sddsf">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 150px;">
                                                                    <b> Day &amp; Date / Time</b>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    :
                                                                </td>
                                                                <td>
                                                                    <!-- time 1  -->
                                                                  <?php
                                                                        // print_r($practical_booking);
                                                                        // exit;
                                                                        
                                                                        $pointer_id = pointer_id_decrypt($ENC_pointer_id);
                                                                        // Mohsin Working
                                                                        $practical_booking__ = find_one_row('stage_4_practical_booking', 'pointer_id', $pointer_id);
                                                                        $date__1 = date("l, jS F Y", strtotime($practical_booking__->date_time));
                                                                        $date__2 = date("h:i A", strtotime($practical_booking__->date_time));
                                                                        echo  $date__1 . ' / ' . $date__2;
                                                                        if($practical_booking['location_id__'] == 16){
                                                                            $locadhsajhjg = "(Australia/Brisbane)";
                                                                        }
                                                                        else{
                                                                            $locadhsajhjg = "(Europe/London)";
                                                                        }
                                                                        ?>
                                                                        <?= $locadhsajhjg ?> 

                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <b> Venue </b>
                                                                </td>
                                                                <td style="width: 20px;">
                                                                    :
                                                                </td>
                                                                <td>
                                                                    <?= $practical_booking['venue'] ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if ($practical_booking['venue']  != "Online (Via Zoom)") {
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <b> Location </b>
                                                                    </td>
                                                                    <td style="width: 20px;">
                                                                        :
                                                                    </td>
                                                                    <td>
                                                                        <?= $practical_booking['office_address'] ?>,
                                                                        <?= $practical_booking['country'] ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>

                                        </tr>

                                    </thead>
                                </table>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                        </div>
                        
                        
                   
                <?php
                    }
                } ?>
        <?php }
        } ?>
        <!-- stage 4  -->



    </div>

</div>

<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
    var ENC_pointer_id = '<?= $ENC_pointer_id ?>';
    
    $(document).ready(function() {
        
        console.log("ready");
        $(".add_info_req_stage").submit(function(e) {
            e.preventDefault();
            $("#loader-please-wait").show();
            var formData = new FormData($(this)[0]);
            var stage = formData.get("stage"); 
            console.log(stage);
            
            custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit the additional information ? You will not be able to remove or change these documents after submission.", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
            $("#AJDSAKAJLD").click(function() {
                if (custom_alert_popup_close('AJDSAKAJLD')) {
                    $('#cover-spin').show(0);
                    $.ajax({
                    method: "POST",
                    url: "<?= base_url('user/additional_information_request') ?>/" + stage + '/' + ENC_pointer_id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        // return;
                        $('#cover-spin').hide();
                        window.location.reload();
    
                        // console.log("---------------------------" + res);
    
                    }
                })
                };
            });
        });
    });

    function add_info_req(stage) {
        // var stage = $(stage).val();
        console.log(stage);
        var id = '"#add_info_req_' + stage + '"';
        console.log(id);
        var formData = new FormData($(id)[0]);
        var formData = new FormData($(this)[0]);
        formData.get("username"); // Returns "Chris"

        console.log(formData);
        <?php
        // if(formData)
        // exit;?>
        return;
               
        // custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit the additional information ? You will not be able to remove or change these documents after submission.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit the additional information ? You will not be able to remove or change these documents after submission.", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        // //  custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit the additional information ? You will not be able to remove or change these documents after submission.", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // $("#AJDSAKAJLD").click(function() {
        //     if (custom_alert_popup_close('AJDSAKAJLD')) {
        //         $('#cover-spin').show(0);
        //         $.ajax({
        //             'url': "<= base_url('user/additional_information_request') ?>/" + stage + '/' + ENC_pointer_id,
        //             'data': formData,
        //             'type': 'post',
        //           success: function(data) {
        //                 $('#cover-spin').hide(0);
        //                 window.location = "<?= base_url('user/view_application/' . $ENC_pointer_id) ?>";
        //             }
        //         });
       
        //     } else {
        //             $('#cover-spin').hide(0);
        //             return false;
        //     };
        // });

    }
    function hide_model_box(id){
        var element = document.getElementById(id);

        element.classList.remove("show");
        element.style.display = "none";
        element.removeAttribute("role");
          element.removeAttribute("role");
          var backdrop = document.querySelector('.modal-backdrop.fade.show');

// Remove the backdrop element from the DOM
backdrop.parentNode.removeChild(backdrop);
        // .modal-backdrop

        var bodyElement = document.body;
        bodyElement.style = null;
// Get a reference to the <body> element

// Remove a class from the <body> element
bodyElement.classList.remove("modal-open");

// class="modal-open"
// style="overflow: hidden; padding-right: 0px;"
            // window.location.reload();
                // $("#"+id).hide();

    }
     
     
    // stage_3 reassessment akanksha 19 2023
    function reassessment_stage_3(){
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to initiate the Reassessment Application ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
        // check Btn click
        $("#stage_1_pop_btn").click(function() { 
            if (custom_alert_popup_close('stage_1_pop_btn')) {
                $('#cover-spin').show(0);
                 $.ajax({
                    'url': '<?= base_url('user/stage_3_reassessment/start/' . $ENC_pointer_id) ?>',
                    'type': 'post',
                    success: function(data) {
                        $('#cover-spin').hide(0);
                        $('#start_stage_3').show();
                        $('#note_stage_3_reassessment').show();
                        $('#button_for_apply').hide();
                        document.querySelector('#value_3_R').textContent = "Start Stage 3 Reassessment Submission"; 
                        // linkElement.textContent = "New Value";

                        // document.getElementById("value_3_R").value ="Start Stage 3 reassessment Submission";
                        // $('#value_3_R').value().
                        // window.location = "<= base_url('user/view_application/' . $ENC_pointer_id) ?>";
                        // 1 if( note in yellow )
                            
                        // button 
                        // Start Stage 3 (Reassessment) Submission   same as stage 3 -> stage 3 page -> if completed then on view application page                                        
                    }
                });
                return true;
            } else {
                $('#cover-spin').hide(0);
                return false;
            }    
            
        });
   }

</script>

<!--<script>-->
<!--    function hoverImage() {-->
<!--        document.getElementById("myImage").src = "<= base_url('public/assets/icon/new_popup.png') ?>";-->
<!--    }-->

<!--    function originalImage() {-->
<!--        document.getElementById("myImage").src = "<= base_url('public/assets/icon/new_popup_.png') ?>";-->
<!--    }-->
<!--</script>-->


<?= $this->endSection() ?>
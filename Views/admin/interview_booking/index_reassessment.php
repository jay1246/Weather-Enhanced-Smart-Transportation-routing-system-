 <?= $this->extend('template/admin_template') ?>

<?= $this->section('main') ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    input[type="datetime-local"]::-webkit-datetime-edit-seconds-field {
        display: none;
    }

    input[type="datetime-local"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .book_btn {
        position: absolute;
        right: 250px;
        top: 78px;
        z-index: 3
    }

    .nav-link {
        font-weight: bold;
        color: #055837;
    }

    .nav-link:hover {
        font-weight: bold;
        background-color: #FFC107 !important;
        color: #055837 !important;
    }

    .active_btn {
        font-weight: bold;
        background-color: #055837 !important;
        color: #FFC107 !important;
    }


    .active_btn:hover {
        font-weight: bold;
        background-color: #FFC107 !important;
        color: #055837 !important;
    }

    .btn_green {
        background-color: #055837 !important;
        color: #FFC107 !important;
    }

    .btn_green:hover {
        background-color: #FFC107 !important;
        color: #055837 !important;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h4 class="text-green">Interview Bookings</h4>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow px-0">

                <!-- End Add booking Modal-->

                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-agent-tab" href="<?= base_url() ?>/admin/interview_booking" role="tab" aria-controls="custom-tabs-agent" aria-selected="true">
                                AQATO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-applicant-tab" href="<?= base_url() ?>/admin/not_aqato_s3" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">
                                NON - AQATO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active_btn" id="custom-tabs-reassessment-tab" href="<?= base_url() ?>/admin/interview_booking_reassessment" role="tab" aria-controls="custom-tabs-reassessment" aria-selected="false">
                                AQATO - REASSESSMENT
                            </a>
                        </li>
                        
                    </ul>
                </div>
                <div class="card-body px-3">
                    <div class="modal" id="add_form">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <form id="add_data" action="" class="p-2" method="post">

                                    <div class="modal-header">
                                        <h5 class="modal-title text-center text-green">New Interview Booking (AQATO - REASSESSMENT)</h5>
                                    </div>
                                    <div class="modal-body">

                                        <!-- Applicant -->
                                        <div class="col-12 mt-2">
                                            <b> <label>Applicant <span class="text-danger">*</span></label></b>
                                            <select name="applicant_name_id" id="select_location_new" class="form-select md-4" required>
                                                <option value="">Select Applicant</option>
                                                <?php
                                                $num = 1;
                                                foreach ($applicants as $applicant) {
                                                    $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $applicant->pointer_id);
                                                    $s1 = find_one_row('stage_1', 'pointer_id', $applicant->pointer_id);
                                                    $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $applicant->pointer_id);
                                                    $occupation_list = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);
                                                ?>
                                                    <option value="<?= $applicant->id ?>"><?= "[#" . $s1->unique_id . "] " . $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " - " . $occupation_list->name . "" ?></option>
                                                <?php
                                                    $num++;
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Venue -->
                                        <div class="col-12 mt-2">
                                            <b> <label>Venue <span class="text-danger">*</span></label></b>
                                            <select name="venue" id="new_book_select_venue" class="form-select md-4" required>
                                                <option value="">Select Interview New Location</option>
                                                <?php $all_countries = countries();
                                                // print_r($all_countries);
                                                foreach ($all_countries as $country) {
                                                    if ($country->country != "Online") {
                                                ?>
                                                        <optgroup label="<?= $country->country ?>">
                                                            <?php
                                                            $num = 1;
                                                            foreach ($countries as $venue) {
                                                                if ($venue->country == $country->country) {
                                                                    if($venue->pratical == 0){
                                                            ?>
                                                                    <option value="<?= $venue->id ?>"><?= $venue->city_name ?></option>
                                                            <?php
                                                                    $num++;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </optgroup>

                                                <?php
                                                    }
                                                }
                                                ?>


                                                <?php $all_countries = countries();
                                                foreach ($all_countries as $country) {
                                                    if ($country->country == "Online") {
                                                ?>
                                                        <optgroup label="<?= $country->country ?>">
                                                            <?php
                                                            $num = 1;
                                                            foreach ($countries as $venue) {
                                                                if ($venue->country == $country->country) {
                                                                if($venue->pratical == 0){
                                                            ?>
                                                                    <option value="<?= $venue->id ?>"><?= $venue->city_name ?></option>
                                                            <?php
                                                                    $num++;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </optgroup>

                                                <?php
                                                    }
                                                }
                                                ?>


                                            </select>
                                        </div>

                                        <!-- Applicant Location -->
                                        <div class="col-12 mt-2" id="select_new_time_zone_div">
                                            <b> <label>Applicant Location <span class="text-danger">*</span></label> </b>
                                            <select id="select_new_time_zone" name="time_zone" class="">
                                                <option value="">Select Time zone</option>
                                                <?php
                                                foreach ($time_zone as $key => $get_na) {
                                                    $zone_name = $get_na['zone_name'];
                                                    echo '<option value="' . $zone_name . '">' . $zone_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Date -->
                                        <div class="col-12 mt-2 ">
                                            <b> <label>Date <span class="text-danger">*</span></label></b>
                                            <input name="date" id="new_book_date" type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control mb-4" />
                                        </div>

                                        <!-- Time (QLD) -->
                                        <div class="col-12 mt-2" id="new_book_time_div_id">
                                            <b> <label>Time (QLD) <span class="text-danger">*</span></label></b>
                                            <select name="time" class="form-select">
                                                <?php
                                                foreach ($stage_3_interview_booking_time_slots as $key => $value) {
                                                    $time = $value['time_start'];
                                                    $time =  str_replace(".", ":", $time);
                                                    $time =  str_replace("am", "AM", $time);
                                                    $time =  str_replace("pm", "PM", $time);
                                                    echo '<option value="' . $time . '">' . $time . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="text-end">
                                             <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('add_form')" data-bs-dismiss="modal">Close</button> 
                                            <!--<a  class="btn btn_yellow_green" data-bs-dismiss="modal"> Close </a>-->
                                            <button type="button" onclick="new_book_btn_submit()" id="new_book_btn_submit" class="btn btn_yellow_green">Book Interview</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="table table-responsive px-3">

                    <!--  Table with stripped rows starts -->
                    <a href="" data-bs-toggle="modal" data-bs-target="#add_form" class="btn btn_green_yellow book_btn">
                        <i class="bi bi-plus"></i>
                        New Booking
                    </a>
                    <table id="interview_booking_table" class="table table-striped datatable table-hover">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Application No. </th>
                                <th>Applicant Name</th>
                                <th>Occupation </th>
                                <th>Country</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Time(QLD)</th>
                                <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                    <th> Action </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // echo "<pre>";
                            // print_r($interview_bookings);
                            // exit;


                            // Custom comparison function
                            // function compareItemsByCreatedAt($a, $b)
                            // {
                            //     return strtotime($a->date_time) - strtotime($b->date_time);
                            // }

                            // Sort the items array using the custom comparison function
                            // usort($interview_bookings, 'compareItemsByCreatedAt');
                            // $interview_bookings = array_reverse($interview_bookings);


                            $count = 1;
                            foreach ($interview_bookings as $booking) {

                                $stage_3_reassessment = find_one_row('stage_3_reassessment', 'pointer_id', $booking->pointer_id);
                                if (isset($stage_3_reassessment->status) && ($stage_3_reassessment->status == "Lodged" || $stage_3_reassessment->status == "Scheduled" || $stage_3_reassessment->status == "Conducted")) {
                                    $time_city_zone = $booking->time_zone;
                                    $time_city_zone_aaa = explode("/", $time_city_zone);
                                    $time_city_zone_city = isset($time_city_zone_aaa[1]) ? $time_city_zone_aaa[1] : '';
                                    $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $booking->pointer_id);
                                    $s1 = find_one_row('stage_1', 'pointer_id', $booking->pointer_id);
                                    $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $booking->pointer_id);
                                    $occupation_list = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);
                                    $stage_1_contact_details = find_one_row('stage_1_contact_details', 'pointer_id', $booking->pointer_id);
                                    if (isset($booking->location_id) && !empty($booking->location_id)) {
                                    $s3_offline_location = find_one_row('stage_3_offline_location', 'id', $booking->location_id);
                                    $email_interview_location = find_one_row_2_field('email_interview_location','pointer_id',$booking->pointer_id,'stage','stage_3_R');
                                    if($email_interview_location){
                                        $meeting_id = $email_interview_location->meeting_id;
                                        $passcode = $email_interview_location->passcode;
                                        $email_cc = $email_interview_location->email_cc;
                                        $email_interview_location_id = $email_interview_location->id;
                                    }else{
                                        $meeting_id = "";
                                        $passcode = "";
                                        $email_interview_location_id = "";
                                        $email_cc ="";
                                    }
                                    
                            ?>
                                        <tr>
                                            <th><?= $count ?></th>
                                            <td><?= "[#" . $s1->unique_id . "]" ?></td>
                                            <td><a href="<?= base_url('admin/application_manager/view_application') ?>/<?= $booking->pointer_id ?>/view_edit" style="color:#009933"><?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?></a></td>
                                            <td><?= $occupation_list->name ?></td>
                                            <td>
                                                <?php
                                                // echo $time_city_zone_city;
                                                ?>
                                                <?php if (isset($s3_offline_location->country)) {
                                                    if ($s3_offline_location->country != "Online") {
                                                        echo $s3_offline_location->country;
                                                    } else {
                                                        // echo $stage_1_contact_details->country;
                                                        echo $time_city_zone_city;
                                                    }
                                                } ?></td>
                                            <td><?= (isset($s3_offline_location->city_name) ? $s3_offline_location->city_name : "") ?></td>
                                            <td><?= date('d/m/Y', strtotime($booking->date_time)) ?></td>
                                            <td style="padding-left: 15px;"> <?= date('h:i A', strtotime($booking->date_time)) ?></td>
                                            <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                                <td>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>
                                                    <?php 
                                                    if($s3_offline_location->venue =="AQATO"){
                                                        if($s3_offline_location->email){    
                                                            $disable = "";
                                                            $style = "";    
                                                        }else{
                                                            $disable = "disabled"; 
                                                            $style= "style='border:0px; background-color: #ffe475 !important; color:#055837 !important'";
                                                        }
                                                    }else{
                                                        $disable = "disabled"; 
                                                        $style= "style='border:0px; background-color: #ffe475 !important; color:#055837 !important'";
                                                    }
                                                    ?>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#mail_form<?= $count ?>" class="btn btn-sm btn_yellow_green <?=$disable?>" <?=$style?>> <i class="bi bi-forward"></i></a>
                                                   <a href="" data-bs-toggle="modal" data-bs-target="#delete_req<?= $count ?>" class="btn btn-sm btn-danger"> <i class="bi bi-x"></i></a>
                                                </td>
                                            <?php } ?>

                                        </tr>

                                        <!-- modal box for edit -->
                                        <div class="modal" id="edit_form<?= $count ?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <form class="edit_data" action="" method="post" id="edit_data<?= $booking->id ?>">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-center text-green">Reschedule Interview Booking</h5>

                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- < new add // -->
                                                            <input name="pointer_id" type="hidden" value="<?= $booking->pointer_id ?>" />
                                                            <input name="stage_3_interview_booking_id" type="hidden" value="<?= $booking->id ?>" />
                                                            <h5 class="modal-title text-center text-green"> <?= "[#" . $s1->unique_id . "] " . $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " - " . $occupation_list->name . "" ?></h5>

                                                            <!-- Venue -->
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Venue <span class="text-danger">*</span></label> </b>
                                                                <select name="venue" onchange="eddit(<?= $count ?>)" id="edite_book_select_venue<?= $count ?>" class="form-select md-4" required>
                                                                    <!-- <option value="<?= $booking->location_id ?>"><?= $s3_offline_location->city_name ?></option> -->
                                                                    <?php $all_countries = countries();
                                                                    foreach ($all_countries as $country) {
                                                                        if ($country->country != "Online") { ?>
                                                                            <optgroup label="<?= $country->country ?>">
                                                                                <?php
                                                                                foreach ($countries as $venue) {
                                                                                    if ($venue->country == $country->country) {
                                                                                        if($venue->pratical == 0){
                                                                                            if ($venue->id == $booking->location_id) {
                                                                                                echo ' <option selected value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            } else {
                                                                                                echo ' <option value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </optgroup>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    foreach ($all_countries as $country) {
                                                                        if ($country->country == "Online") { ?>
                                                                            <optgroup label="<?= $country->country ?>">
                                                                                <?php
                                                                                foreach ($countries as $venue) {
                                                                                    if ($venue->country == $country->country) {
                                                                                        if($venue->pratical == 0){
                                                                                            if ($venue->id == $booking->location_id) {
                                                                                                echo ' <option selected value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            } else {
                                                                                                echo ' <option value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </optgroup>

                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>

                                                            <!-- Applicant Location -->
                                                            <?php
                                                            $css = "";
                                                            if ($booking->location_id == 9) {
                                                                $css = 'style="display: block;"';
                                                            } else {
                                                                $css = 'style="display: none;"';
                                                            }
                                                            ?>
                                                            <div class="col-12 mt-2" id="select_edite_time_zone_div<?= $count ?>" <?= $css ?>>
                                                                <b> <label>Applicant Location <span class="text-danger">*</span></label></b>
                                                                <select name="time_zone" id="select_edite_time_zone<?= $count ?>" name="time_zone" class="form-select">
                                                                    <option value="">Select Time zone</option>
                                                                    <?php
                                                                    foreach ($time_zone as $key => $get_na) {
                                                                        $zone_name = $get_na['zone_name'];
                                                                        $select = "";
                                                                        if (trim($booking->time_zone) == trim($zone_name)) {
                                                                            $select = "selected";
                                                                        }

                                                                        echo '<option ' . $select . ' value="' . $zone_name . '">' . $zone_name . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <!-- Date -->
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Date <span class="text-danger">*</span></label> </b>
                                                                <input name="date" type="date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->date_time)) ?>" min="<?= date("Y-m-d") ?>">
                                                            </div>

                                                            <!-- Time (QLD) -->
                                                            <div class="col-12 mt-2" id="new_book_time_div_id">
                                                                <b> <label>Time (QLD) <span class="text-danger">*</span></label></b>
                                                                <select name="time" class="form-select">
                                                                    <?php
                                                                    foreach ($stage_3_interview_booking_time_slots as $key => $value) {
                                                                        $time = $value['time_start'];
                                                                        $time =  str_replace(".", ":", $time);
                                                                        $time =  str_replace("am", "AM", $time);
                                                                        $time =  str_replace("pm", "PM", $time);

                                                                        $old_time = $booking->date_time;
                                                                        $old_time = date('h:i A', strtotime($old_time));
                                                                        $select = "";

                                                                        if ($old_time == $time) {
                                                                            $select = "selected";
                                                                        }
                                                                        echo '<option ' . $select . ' value="' . $time . '">' . $time . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('edit_form<?= $count ?>')" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn_yellow_green" onclick="Reschedule_form('edit_data<?= $booking->id ?>')">Save & Reschedule</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--akanksha -->
                                        <!--13 july 2023-->
                                        <div class="modal" id="mail_form<?= $count ?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <form class="send_mail" action="" method="post" id="send_mail<?= $booking->id ?>">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-center text-green">Zoom Details</h5>

                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- < new add // -->
                                                            <input name="pointer_id" type="hidden" value="<?= $booking->pointer_id ?>" />
                                                            <input name="stage_3_interview_booking_id" type="hidden" value="<?= $booking->id ?>" />
                                                            <h5 class="modal-title text-center text-green"> <?= "[#" . $s1->unique_id . "] " . $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " - " . $occupation_list->name . "" ?></h5>

                                                            <!-- Venue -->
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Venue <span class="text-danger">*</span></label> </b>
                                                                <select name="venue" onchange="eddit(<?= $count ?>)" id="edite_book_select_venue<?= $count ?>" class="form-select md-4" disabled required>
                                                                    <!-- <option value="<?= $booking->location_id ?>"><?= $s3_offline_location->city_name ?></option> -->
                                                                    <?php $all_countries = countries();
                                                                    foreach ($all_countries as $country) {
                                                                        if ($country->country != "Online") { ?>
                                                                            <optgroup label="<?= $country->country ?>">
                                                                                <?php
                                                                                foreach ($countries as $venue) {
                                                                                    if ($venue->country == $country->country) {
                                                                                        if($venue->pratical == 0){
                                                                                            if ($venue->id == $booking->location_id) {
                                                                                                echo ' <option selected value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            } else {
                                                                                                echo ' <option value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </optgroup>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    foreach ($all_countries as $country) {
                                                                        if ($country->country == "Online") { ?>
                                                                            <optgroup label="<?= $country->country ?>">
                                                                                <?php
                                                                                foreach ($countries as $venue) {
                                                                                    if ($venue->country == $country->country) {
                                                                                        if($venue->pratical == 0){
                                                                                            if ($venue->id == $booking->location_id) {
                                                                                                echo ' <option selected value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            } else {
                                                                                                echo ' <option value="' . $venue->id . '">' . $venue->city_name . '</option>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </optgroup>

                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>

                                                            <!-- Applicant Location -->
                                                            <?php
                                                            $css = "";
                                                            if ($booking->location_id == 9) {
                                                                $css = 'style="display: block;"';
                                                            } else {
                                                                $css = 'style="display: none;"';
                                                            }
                                                            ?>
                                                            <div class="col-12 mt-2" id="select_edite_time_zone_div<?= $count ?>" <?= $css ?>>
                                                                <b> <label>Applicant Location <span class="text-danger">*</span></label></b>
                                                                <select name="time_zone" id="select_edite_time_zone<?= $count ?>" name="time_zone" class="form-select" disabled>
                                                                    <option value="">Select Time zone</option>
                                                                    <?php
                                                                    foreach ($time_zone as $key => $get_na) {
                                                                        $zone_name = $get_na['zone_name'];
                                                                        $select = "";
                                                                        if (trim($booking->time_zone) == trim($zone_name)) {
                                                                            $select = "selected";
                                                                        }

                                                                        echo '<option ' . $select . ' value="' . $zone_name . '">' . $zone_name . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <!-- Date -->
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Date <span class="text-danger">*</span></label> </b>
                                                                <input name="date" type="date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->date_time)) ?>" disabled>
                                                            </div>

                                                            <!-- Time (QLD) -->
                                                            <div class="col-12 mt-2" id="new_book_time_div_id">
                                                                <b> <label>Time (QLD) <span class="text-danger">*</span></label></b>
                                                                <select name="time" class="form-select" disabled>
                                                                    <?php
                                                                    foreach ($stage_3_interview_booking_time_slots as $key => $value) {
                                                                        $time = $value['time_start'];
                                                                        $time =  str_replace(".", ":", $time);
                                                                        $time =  str_replace("am", "AM", $time);
                                                                        $time =  str_replace("pm", "PM", $time);

                                                                        $old_time = $booking->date_time;
                                                                        $old_time = date('h:i A', strtotime($old_time));
                                                                        $select = "";

                                                                        if ($old_time == $time) {
                                                                            $select = "selected";
                                                                        }
                                                                        echo '<option ' . $select . ' value="' . $time . '">' . $time . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Meeting ID <span class="text-danger">*</span></label> </b>
                                                                <input name="meeting_id" type="text" class="form-control" value="<?=$meeting_id?>" required>
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Passcode <span class="text-danger">*</span></label> </b>
                                                                <input name="passcode" type="text" class="form-control" value="<?=$passcode?>" required>
                                                                <input name="email_interview_location_id" type="hidden" class="form-control" value="<?=$email_interview_location_id?>"  >
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Email ID  <span class="text-danger">*</span></label> </b>
                                                                <input name="email" type="email" class="form-control" value="<?=$s3_offline_location->email?>" disabled >
                                                                <input name="email" type="hidden" class="form-control" value="<?=$s3_offline_location->email?>"  >
                                                            </div>
                                                            <?php 
                                                            if($s3_offline_location->email_cc){
                                                            ?>
                                                            <div class="col-12">
                                                                
                                                            <b><label>CC - Email ID</label></b>
                                                                <?php
                                                                $list_email_cc =   explode(", ",$s3_offline_location->email_cc);
                                                                $count_cc = 50;
                                                                foreach($list_email_cc as $email_cc){
                                                                 ?>
                                                                    <input type="email" name="email_cc[]" id="email_cc"  value="<?=$email_cc?>"  style="margin-right: 20px;" class="form-control" disabled>
                                                                <br>
                                                                <?php
                                                                }
                                                                ?>
                                                            
                                                        </div>
                                                        <?php 
                                                            }
                                                        ?>
                                                        
                                                        </div>
                                                        <div class="row">
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('mail_form<?= $count ?>')" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn_yellow_green" onclick="Send_mail('send_mail<?= $booking->id ?>')">Save & Send</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <!--BY ROHIT -->
                                         <div class="modal" id="delete_req<?= $count ?>">
                                            <div class="modal-dialog  modal-lg" style="top: 5%;">
                                                <div class="modal-content" style="background-color: white;">
                                                    <form class="send_mail" action="" method="post" id="send_mail<?= $booking->id ?>">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-center text-green">Cancel Interview Booking</h5>

                                                        </div>
                                                       <div class="modal_body mb-4"> 
                                                            <h5 class="modal-title text-center text-green"> <?= "[#" . $s1->unique_id . "] " . $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " - " . $occupation_list->name . "" ?></h5>
                                                                <div class="col-12 mt-2">
                                                                    <b><label>Reason<span class="text-danger">*</span></label></b>
                                                                    <select id="options_<?=$booking->id?>" name="options" class="form-select md-4" onchange="__open_other_textarea(<?= $booking->id ?>)">
                                                                        <option disabled selected >Choose Reason</option>
                                                                        <option value="Requested by the Applicant/Agent">Requested by the Applicant/Agent</option>
                                                                        <option value="Requested by the Assessor">Requested by the Assessor</option>
                                                                        <option value="No Show">No Show</option>
                                                                        <option value="other">Other</option>
                                                                    </select>
                                                                 
                                                                </div>
                                                                <div class="col-12 mt-2" id="otherdiv_<?=$booking->id?>" style="display: none;">
                                                                    <b><label>Other Reason<span class="text-danger">*</span></label></b>
                                                                    <textarea class="form-control" id="comment_<?=$booking->id?>" name="comment" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                          <div class="row">
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Back</button>
                                                                <button type="button" class="btn btn-danger" onclick="delete_request('<?= $booking->id ?>')">Cancel Request</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
        
                </div>

                <!-- modal box for edit end -->


    <?php
                                    }

                                    $count++;
                                }
                            }  ?>

    </tbody>
    </table>

    <script>
        // online via zoom   Edite booking
        function eddit(id) {

            $('#select_edite_time_zone_div' + id).hide();
            var venu_id = $('#edite_book_select_venue' + id).val();
            if (venu_id == 9) {
                $('#select_edite_time_zone_div' + id).show(50);
                $("#select_edite_time_zone" + id).prop('required', true);
            } else {
                $('#select_edite_time_zone_div' + id).hide(50);
                $("#select_edite_time_zone" + id).prop('required', false);
            }
            new TomSelect("#select_edite_time_zone" + id, {
                plugins: ['dropdown_input']
            });
        }
    </script>
    <!-- End Table with stripped rows -->

            </div>

        </div>
        </div>
        </div>
        </div>
    </section>



</main>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>


<?= $this->endSection() ?>
<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>


   function __open_other_textarea(form_id){
        var optionsDropdown = document.getElementById("options_"+form_id);
        var otherDiv = document.getElementById("otherdiv_"+form_id);
        if (optionsDropdown.value === "other") {
            otherDiv.style.display = "block";
        } else {
            otherDiv.style.display = "none";
        }
    }
    function delete_request(form_id) {
        var options=document.getElementById('options_'+form_id).value;
        if(options == 'Choose Reason'){
            options="";
        }
        var comment = "";
        if(options == 'other'){
            comment=document.getElementById('comment_'+form_id).value;
            if (comment == "") {
                custom_alert_popup_show('', 'Please choose the reason.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'passcode_button');
                return false;
            }
        } 
        else{
            // console.log(options);
            // console.log(comment);
                // return ;
            if (options == "") {
                custom_alert_popup_show('', 'Please choose the reason.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'passcode_button');
                return false;
            }
        }
        custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to cancel Interview Booking ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                  url: "<?= base_url("admin/interview_booking/stage3_reass_interview_booking_cancle/") ?>",
                     data: {
                         id: form_id,
                        options: options,
                        comment: comment
                    },
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                        //res = JSON.parse(res);
                        if (res) {
                            //alert('bbbfg');
                         window.location = "<?= base_url("admin/interview_booking_reassessment") ?>";
                        } else {
                            $('#cover-spin').hide(0);
                            //alert(data["msg"]);
                        }
                    }
                });
            }
        });
    }
    $(document).ready(function() {
        $('#interview_booking_table').DataTable({
            "aaSorting": [],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }

        });
    });



    $('#new_book_time_div_id').hide();

    $('#new_book_date').on('change', function() {
        let val = $('#new_book_date').val();
        if (val != "") {
            $('#new_book_time_div_id').show();
        } else {
            $('#new_book_time_div_id').hide();
        }
    });

    $('#select_location_new').on('change', function() {
        console.log($('#select_location_new').val());
        let val = $('#select_location_new').val();
        if ($('#select_location_new').val() != "") {
            $.ajax({
                method: "POST",
                url: "<?= base_url("admin/interview_booking_reassessment/get_preference_location") ?>",
                data: {
                    'id': val
                },
                success: function(res) {
                    console.log(res);
                    if (res != "") {
                        $("#new_book_select_venue option:contains('" + res + "')").prop("selected", true);
                        console.log(res);
                        if(res == 'Online (Via Zoom)'){
                            $('#select_new_time_zone_div').show(50);
                            $("#select_new_time_zone").prop('required', true);
                            $.ajax({
                            method: "POST",
                            url: "<?= base_url("admin/interview_booking_reassessment/get_applicant_location") ?>",
                            data: {
                                'id': val
                            },
                            success: function(res) {
                                console.log(res);
                                if (res != "") {
                                    // Get a reference to the input field with ID "my-select-field"
                                    var selectField = document.getElementById("select_new_time_zone");
                                    
                                    // Destroy any existing TomSelect instance on the input field
                                    if (selectField.tomselect) {
                                      selectField.tomselect.destroy();
                                    }
                                    
                                    // Initialize a new TomSelect instance on the input field
                                    var timeSelect = new TomSelect(selectField);
                                    
                                    // Set the value of the TomSelect instance to "America/New_York"
                                    timeSelect.setValue(res);
                                // $("#select_new_time_zone").val(res);
                        //  $("#select_new_time_zone-ts-control data-value:contains('" + res + "')").prop("selected", true);
                                }
                            }
                            })
                        }
                    } else {
                        $("#new_book_select_venue option:contains('Select Interview New Location')").prop("selected", true);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("error");
                }
            });
        } else {
            console.log("data id empty");
        }



        if ($('#select_location_new').val() != "") {
            $('#new_book_btn_submit').show();

        } else {
            $('#new_book_btn_submit').hide();
        }
    });


    // online via zoom   new book
    $('#select_new_time_zone_div').hide();
    $('#new_book_select_venue').on('change', function() {
        var venu_id = this.value;
        if (venu_id == 9) {
            $('#select_new_time_zone_div').show(50);
            $("#select_new_time_zone").prop('required', true);
        } else {
            $('#select_new_time_zone_div').hide(50);
            $("#select_new_time_zone").prop('required', false);

        }
    });

    $("#new_book_btn_submit").click(function() {
        if($('#select_location_new').val()==""){
            custom_alert_popup_show(header = '', body_msg = "Please Select Applicant", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
        }
        if($('#new_book_select_venue').val()==""){
            custom_alert_popup_show(header = '', body_msg = "Please Select Venue", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
        }
        
        if($('#new_book_date').val()==""){
            custom_alert_popup_show(header = '', body_msg = "Please Select Date", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
        }
       
        custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to book interview ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {

                var formData = new FormData($('#add_data')[0]);

                if ($('#select_location_new').val() != "" && $('#new_book_select_venue').val() != "") {
                    $('#cover-spin').show(0);
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("admin/interview_booking_reassessment/insert") ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            console.log(res);
                            // return;
                            res = JSON.parse(res);
                            if (res) {
                                window.location = "<?= base_url("admin/interview_booking_reassessment") ?>"
                            } else {
                                $('#cover-spin').hide(0);
                                console.log(res);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            $('#cover-spin').hide(0);
                        }
                    });
                }
            }
        });
    });




    function Reschedule_form(form_id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to book interview ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {

                var formData = new FormData($('#' + form_id)[0]);
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/interview_booking_reassessment/update") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);

                        res = JSON.parse(res);
                        if (res) {
                            window.location = "<?= base_url("admin/interview_booking_reassessment") ?>";
                        } else {
                            $('#cover-spin').hide(0);
                            alert(data["msg"]);
                        }
                    }
                });
            }
        });
    }

    function status_data(id) {
        if (confirm("Are you sure you want to change the status?")) {
            $('#cover-spin').show(0);

            $.ajax({
                url: "<?= base_url("admin/interview_booking_reassessment/status") ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data["response"] == true) {
                        window.location = "<?= base_url("admin/interview_booking_reassessment") ?>";
                    } else {
                        $('#cover-spin').hide(0);
                        alert(data["msg"]);
                    }
                },
            });
        }
    }
    // akanksha 13 july 2023
    function Send_mail(form_id) {
        var formData = new FormData($('#' + form_id)[0]);
        formData.forEach(function(value, key) {
          var field = formData.get(key);
          console.log(key + ": " + value);
        });
        if (formData.get('email') === "") {
            console.log("email is null");
            custom_alert_popup_show('', 'Please enter Email from Location.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'passcode_button');
            return false;
        }
        if (formData.get('meeting_id') === "") {
            console.log("meeting_id is null");
            custom_alert_popup_show('', 'Please enter Meeting Id.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'meeting_id_button');
            return false;
        }
        
        if (formData.get('passcode') === "") {
            console.log("passcode is null");
            custom_alert_popup_show('', 'Please enter Passcode.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'passcode_button');
            return false;
        }
        custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to send Zoom Details ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {

                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/interview_booking_reassessment/send_mail_zoom_meet") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);

                        res = JSON.parse(res);
                        if (res) {
                            window.location = "<?= base_url("admin/interview_booking_reassessment") ?>";
                        } else {
                            $('#cover-spin').hide(0);
                            alert(data["msg"]);
                        }
                    }
                });
            }
        });
    }
    var count = 0;
    function add_more_input_(div_id) {
        var data = `<div id="wrapper-${div_id}-${count}" class="row mb-2"> 
                        <div class="col-11">
                            <input type="email" name="email_cc[]" id="email_cc" class="form-control">
                        </div>
                        <div class="col-1">
                            <button type="button" onclick="cancel('wrapper-${div_id}-${count}')" class="btn btn-danger delete_button float-end">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>`;

        count++;
        $("#" + div_id).prepend(data);
    }
    function cancel(id){
        var div = document.getElementById(id);
        div.parentNode.removeChild(div);

    }
    
</script>
<script>
    $(document).ready(function() {
        new TomSelect("#select_new_time_zone", {
            // create: true,
            // sortField: {
            //     field: "text",
            //     direction: "asc"
            // }
            plugins: ['dropdown_input']
        });


        $('.modal').on('hide.bs.modal', function() {
            // location.reload();
        });


    });
    
    
    function hide_model_box(id){
        var element = document.getElementById(id);

        element.classList.remove("show");
        element.style.display = "none";
        element.removeAttribute("role");
          element.removeAttribute("role");
        //   var backdrop = document.querySelector('.modal-backdrop.fade.show');

// Remove the backdrop element from the DOM
// backdrop.parentNode.removeChild(backdrop);
        // .modal-backdrop

        var bodyElement = document.body;
        bodyElement.style = null;
// Get a reference to the <body> element

// Remove a class from the <body> element
bodyElement.classList.remove("modal-open");

// class="modal-open"
// style="overflow: hidden; padding-right: 0px;"
            window.location.reload();
                $("#"+id).hide();

    }
    
</script>
<?= $this->endSection() ?>
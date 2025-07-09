<table id="interview_booking_table" class="table table-striped datatable table-hover">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Application No. </th>
            <th width="30%">Applicant Name</th>
            <th >Occupation </th>
            <th>Country</th>
            <th>Location</th>
            <th>Date</th>
            <th>Time(QLD)</th>
            <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                <th class="text-center"> Action </th>
            <?php } ?>
        </tr>
    </thead>
    <tbody id="pagination__table__body">

        <?php
        if(count($interview_bookings) == 0){
            ?>
            <tr>
                <td colspan="9" class="text-center">No Data Found</td>
            </tr>
            <?php
        }
        $count = 1;
        // print_r($interview_bookings);
        foreach ($interview_bookings as $booking) {

            $stage_3 = $booking;
            if (isset($stage_3->status) && ($stage_3->status == "Lodged" || $stage_3->status == "Scheduled" || $stage_3->status == "Conducted")) {

                $time_city_zone = $booking->time_zone;
                $time_city_zone_aaa = explode("/", $time_city_zone);
                // Mohsin - Added isset($time_city_zone_aaa[1]) ? $time_city_zone_aaa[1] : ''; this line
                $time_city_zone_city = isset($time_city_zone_aaa[1]) ? $time_city_zone_aaa[1] : '';
                $s1_personal_details = $booking;
                $s1 = $booking;
                $s1_occupation = $booking;
                $occupation_list = $booking;
                $stage_1_contact_details = $booking;
                if (isset($booking->location_id) && !empty($booking->location_id)) {

                $s3_offline_location = $booking;
                $email_interview_location = find_one_row_2_field('email_interview_location','pointer_id',$booking->pointer_id,'stage','stage_3');
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
                            <td style="padding: 5px 2px">
                                <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow" onclick="__storeData('#edit_form<?= $count ?>')"> <i class="bi bi-pencil-square"></i></a>
                                <?php 
                                if($s3_offline_location->venue =="AQATO"){
                                    if($s3_offline_location->email){    
                                        $disable = "";
                                        $style = "";    
                                    }else{
                                        $disable = "disabled"; 
                                        $style= "style='border:0px; background-color: #ffe475 !important; color:#055837 !important padding-right:5px'";
                                    }
                                }else{
                                    $disable = "disabled"; 
                                    $style= "style='border:0px; background-color: #ffe475 !important; color:#055837 !important padding-right:5px'";
                                }
                                ?>
                                
                                <a href="" data-bs-toggle="modal" data-bs-target="#mail_form<?= $count ?>"  class="btn btn-sm btn_yellow_green <?=$disable?>" <?=$style?> onclick="__storeData('#mail_form<?= $count ?>')"> <i class="bi bi-forward"></i></a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#delete_req<?= $count ?>" class="btn btn-sm btn-danger" onclick="__storeData('#delete_req<?= $count ?>')"> <i class="bi bi-x"></i></a>


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
                                                <div class="row modal-footer mx-0">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('edit_data<?= $booking->id ?>','edit_form','#edit_form<?= $count ?>')" data-bs-dismiss="modal">Close</button>
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
                                                <div class="row modal-footer mx-0">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('mail_form<?= $count ?>','zoom_form','#mail_form<?= $count ?>')" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn_yellow_green" onclick="Send_mail('send_mail<?= $booking->id ?>')">Save & Send</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!--MODAL FOR DELETE INTERVIEW REQUEST-->
                                <div class="modal" id="delete_req<?= $count ?>">
                                    <div class="modal-dialog  modal-lg" style="top: 5%;">
                                        <div class="modal-content" style="background-color: white; padding: 10px;">
                                            <form  action="" method="post" id="delete_request<?= $booking->id ?>">

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
                                                        <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal" onclick="hide_model_box(1, 'zoom_form', '#delete_req<?= $count ?>')">Back</button>
                                                        <button type="button" class="btn btn-danger" onclick="delete_request('<?= $booking->id ?>')">Cancel Request</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                    


                            </td>
                        <?php } ?>

                    </tr>
                    

                    <!-- modal box for edit -->
                    
                    
            <?php
                }

                $count++;
            }
        }  ?>
    </tbody>
</table>
<div class="main_bottom_pagination">
    <div class="sub_bottom_pagination">
        <?php 
        if($itemsPerPage == 0){
            $currentPage = 0;
        }
        ?>
        <span>Showing <?= $currentPage ?> to <?= $itemsPerPage ?> of <?= number_format($totalRows) ?> entries</span>
    </div>
    <?= $pager->links() ?>
</div>

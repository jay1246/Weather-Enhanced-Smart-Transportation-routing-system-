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
        top: 69px;
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
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link " id="custom-tabs-agent-tab" href="<?= base_url() ?>/admin/interview_booking" role="tab" aria-controls="custom-tabs-agent" aria-selected="true">
                                AQATO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active_btn" id="custom-tabs-applicant-tab" href="<?= base_url() ?>/admin/not_aqato_s3" role="tab" aria-controls="custom-tabs-applicant" aria-selected="false">
                                NON - AQATO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-agent-tab" href="<?= base_url() ?>/admin/interview_booking_reassessment" role="tab" aria-controls="custom-tabs-agent" aria-selected="false">
                                AQATO - REASSESSMENT
                            </a>
                        </li>
                        
                    </ul>
                </div>

                <!-- End Add booking Modal-->
                <br>
                <div class="table table-responsive px-3">

                    <!--  Table with stripped rows starts -->
                    <a href="" data-bs-toggle="modal" data-bs-target="#add_form" class="btn btn_green_yellow book_btn">
                        <i class="bi bi-plus"></i>
                        New Booking
                    </a>
                    <div class="modal " id="add_form">
                        <div class="modal-dialog  modal-lg ">
                            <div class=" modal-content bg-white">
                                <form id="add_data" action="" class="p-2" method="post">

                                    <div class="modal-header">
                                        <h5 class="modal-title text-center text-green">Add New Interview Booking (NON-AQATO)</h5>
                                    </div>
                                    <div class="modal-body">

                                        <!-- Applicant -->
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6 mt-2">
                                                    <b><label>Applicant Full Name <span class="text-danger">*</span></label></b>
                                                    <input type="text" name="full_name" value="" required class="form-control md-4" />
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <b> <label>Application No.<span class="text-danger">*</span></label></b>
                                                    <input type="text" name="unique_number" value="" required class="form-control md-4" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-6 mt-2">
                                                    <b> <label>Occupation <span class="text-danger">*</span></label></b>
                                                    <select name="occupation_name" id="select_location_new" class="form-select md-4" required>
                                                        <option value="">Select Occupation</option>
                                                        <?php
                                                        foreach ($occupation_list as $occupation) {
                                                        ?>
                                                            <option value="<?= $occupation->name ?>"><?= $occupation->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-6 mt-2">
                                                    <b> <label>Location <span class="text-danger">*</span></label> </b>
                                                    <select name="interview_location" id="new_book_select_venue" class="form-select md-4" required>
                                                        <option value="">Select Interview New Location</option>
                                                        <?php $all_countries = countries();
                                                        // print_r($all_countries);
                                                        foreach ($all_countries as $country) {
                                                            if ($country->country != "Online" && $country->country != "Australia" && $country->country != "Philippines" && $country->country != "New Zealand"  && $country->country != "United Kingdom" && $country->country != "South Africa") {
                                                        ?>
                                                                <optgroup label="<?= $country->country ?>">
                                                                    <?php
                                                                    $num = 1;
                                                                    foreach ($interview_locations as $venue) {
                                                                        if($venue->id != 12 || $venue->id != 13 || $venue->id != 14 || $venue->id != 15){
                                                                            if ($venue->country == $country->country) {
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
                                            <div class="col-6 mt-2">
                                                    <b> <label>Pathway <span class="text-danger">*</span></label> </b>
                                                    <select name="pathway" id="pathway" class="form-select md-4" required>
                                                       <option value="" selected>Select Pathway</option>
                                                        <option value="Pathway 1">Pathway 1</option>
                                                         <option value="Pathway 2">Pathway 2</option>
                                                    </select>
                                                </div>

                                                <div class="col-6 mt-2">
                                                    <b> <label>D.O.B <span class="text-danger">*</span></label> </b>
                                             <input type="date" class="form-control" id="dob" name="dob" required>  </input>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6 mt-2 ">
                                                    <b> <label>Date <span class="text-danger">*</span></label></b>
                                                    <input name="date" id="new_book_date" type="date" min="<?php echo date('Y-m-d') ?>" class="form-control mb-4" required />
                                                </div>

                                                
                                                <div class="col-6 mt-2" id="new_book_time_div_id">
                                                    <b> <label>Time (QLD) <span class="text-danger">*</span></label> </b>
                                                    <select name="time" class="form-select" required>
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-end">
                                            <!-- <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button> -->
                                         <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('add_form')" data-bs-dismiss="modal">Close</button> 

                                            <!--<a href="<?= base_url('admin/not_aqato_s3') ?>" class="btn btn_yellow_green" data-bs-dismiss="modal"> Close </a>-->
                                            <button type="submit" id="new_book_btn_submit" class="btn btn_yellow_green">Book Interview</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <table id="interview_booking_table" class="table table-striped datatable table-hover">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Applicant Name</th>
                                <th>Occupation</th>
                                <th>Application No.</th>
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
                            $count = 1;
                            foreach ($not_aqato_s3_model as $key => $value) {
                                $s3_offline_location = find_one_row('stage_3_offline_location', 'id', $value->interview_location);
                                $email_interview_location = find_one_row_2_field('email_interview_location','pointer_id',$value->id,'stage','non_aqato_stage_3');
                                    if($email_interview_location){
                                        $meeting_id = $email_interview_location->meeting_id;
                                        $passcode = $email_interview_location->passcode;
                                        $email_cc = $email_interview_location->email_cc;
                                        $email_interview_interview_location = $email_interview_location->id;
                                    }else{
                                        $meeting_id = "";
                                        $passcode = "";
                                        $email_interview_interview_location = "";
                                        $email_cc ="";
                                    }
                            ?>
                                <tr>
                                    <td> <?= $count ?> </td>
                                    <td> <?= $value->full_name ?> </td>
                                    <td> <?= $value->occupation_name ?> </td>
                                    <td> [#<?= $value->unique_number ?>] </td>
                                    <td> <?= $s3_offline_location->city_name ?> </td>
                                    <td> <?= date('d/m/Y', strtotime($value->interview_date)) ?> </td>
                                    <td> <?= date('h:i A', strtotime($value->interview_date)) ?> </td>
                                    <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                    <td>
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
                                
                                
                                
                                 <!--akanksha -->
                                        <!--13 july 2023-->
                                        <div class="modal" id="mail_form<?= $count ?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <form class="send_mail" action="" method="post" id="send_mail<?= $value->id ?>">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-center text-green">Zoom Details</h5>

                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- < new add // -->
                                                            <input name="not_aqato_s3_id" type="hidden" value="<?= $value->id ?>" />
                                                            <h5 class="modal-title text-center text-green"> <?= "[#" . $value->unique_number . "] " . $value->full_name . " - " . $value->occupation_name . "" ?></h5>

                                                            <!-- Venue -->
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Venue <span class="text-danger">*</span></label> </b>
                                                                <select name="venue" onchange="eddit(<?= $count ?>)" id="edite_book_select_venue<?= $count ?>" class="form-select md-4" disabled required>
                                                                    <!-- <option value="<?= $value->interview_location ?>"><?= $s3_offline_location->city_name ?></option> -->
                                                                    <?php $all_countries = countries();
                                                                    foreach ($all_countries as $country) {
                                                                        if ($country->country != "Online") { ?>
                                                                            <optgroup label="<?= $country->country ?>">
                                                                                <?php
                                                                                foreach ($countries as $venue) {
                                                                                    if ($venue->country == $country->country) {
                                                                                        if($venue->pratical == 0){
                                                                                            if ($venue->id == $value->interview_location) {
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
                                                                                            if ($venue->id == $value->interview_location) {
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
                                                            if ($value->interview_location == 9) {
                                                                $css = 'style="display: block;"';
                                                            } else {
                                                                $css = 'style="display: none;"';
                                                            }
                                                            ?>
                                                            <!-- Date -->
                                                            <div class="col-12 mt-2">
                                                                <b> <label>Date <span class="text-danger">*</span></label> </b>
                                                                <input name="date" type="date" class="form-control" value="<?= date('Y-m-d', strtotime($value->interview_date)) ?>" disabled>
                                                            </div>

                                                            <!-- Time (QLD) -->
                                                            <div class="col-12 mt-2" id="new_book_time_div_id">
                                                                <b> <label>Time (QLD) <span class="text-danger">*</span></label></b>
                                                                <select name="time" class="form-select" disabled>
                                                                    <?php
                                                                    foreach ($stage_3_interview_booking_time_slots as $key => $value_) {
                                                                        $time = $value_['time_start'];
                                                                        $time =  str_replace(".", ":", $time);
                                                                        $time =  str_replace("am", "AM", $time);
                                                                        $time =  str_replace("pm", "PM", $time);

                                                                        $old_time = $value->interview_date;
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
                                                                <input name="email_interview_interview_location" type="hidden" class="form-control" value="<?=$email_interview_interview_location?>"  >
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
                                                                <button type="button" class="btn btn_yellow_green" onclick="Send_mail('send_mail<?= $value->id ?>')">Save & Send</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
        <!--MODAL FOR DELETE INTERVIEW REQUEST BY ROHIT-->
                                        <div class="modal" id="delete_req<?= $count ?>">
                                            <div class="modal-dialog  modal-lg " style="top: 5%;" >
                                                <div class="modal-content" style="background-color: white;">
                                                    <form class="send_mail" action="" method="post" id="send_mail<?= $value->id ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-center text-green">Cancel Interview Booking</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- < new add // -->
                                                            <input name="not_aqato_s3_id" type="hidden" value="<?= $value->id ?>" />
                                                            <h5 class="modal-title text-center text-green"> <?= "[#" . $value->unique_number . "] " . $value->full_name . " - " . $value->occupation_name . "" ?></h5>                                                                <div class="col-12 mt-2">
                                                                    <b><label>Reason<span class="text-danger">*</span></label></b>
                                                                    <select id="options_<?=$value->id?>" name="options" class="form-select md-4" onchange="__open_other_textarea(<?= $value->id ?>)">
                                                                        <option disabled selected >Choose Reason</option>
                                                                        <option value="Requested by the Applicant/Agent">Requested by the Applicant/Agent</option>
                                                                        <option value="Requested by the Assessor">Requested by the Assessor</option>
                                                                        <option value="No Show">No Show</option>
                                                                        <option value="other">Other</option>
                                                                    </select>
                                                                 
                                                                </div>
                                                                <div class="col-12 mt-2" id="otherdiv_<?=$value->id?>" style="display: none;">
                                                                    <b><label>Other Reason<span class="text-danger">*</span></label></b>
                                                                    <textarea class="form-control" id="comment_<?=$value->id?>" name="comment" rows="2"></textarea>
                                                                </div>
                        
                                                        </div>
                                                        <div class="row">
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Back</button>
                                                                <button type="button" class="btn btn-danger" onclick="delete_request('<?= $value->id ?>')">Cancel Request</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                            <?php 
                            $count++;
                            }  ?>

                        </tbody>
                    </table>

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
 

    $(document).ready(function() {
        $('#interview_booking_table').DataTable({
            "aaSorting": [],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }

        });

        $(document).ready(function() {
            $("#add_data").submit(function(event) {
                event.preventDefault();
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
                                url: "<?= base_url("admin/not_aqato_s3/insert_booking") ?>",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    console.log(res);
                                    if (res == "ok") {
                                        window.location = "<?= base_url("admin/not_aqato_s3") ?>"
                                    } else {
                                        $('#cover-spin').hide(0);
                                        window.location = "<?= base_url("admin/not_aqato_s3") ?>"
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
        });




    });
    
    
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
                  url: "<?= base_url("admin/interview_booking/non_aquato_interview_booking_cancle/") ?>",
                     data: {
                         id: form_id,
                        options: options,
                        comment: comment
                    },
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                          window.location = "<?= base_url("admin/not_aqato_s3") ?>";
                        //res = JSON.parse(res);
                        if (res) {
                            //alert('bbbfg');
                         window.location = "<?= base_url("admin/not_aqato_s3") ?>";
                        } else {
                            $('#cover-spin').hide(0);
                            //alert(data["msg"]);
                        }
                    }
                });
            }
        });
    }
     // akanksha 15 july 2023
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
                    url: "<?= base_url("admin/not_aqato_s3/send_mail_non_aqato_zoom_meet") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);

                        res = JSON.parse(res);
                        if (res) {
                            window.location = "<?= base_url("admin/not_aqato_s3") ?>";
                        } else {
                            $('#cover-spin').hide(0);
                            alert(data["msg"]);
                        }
                    }
                });
            }
        });
    }
   
</script>
<?= $this->endSection() ?>
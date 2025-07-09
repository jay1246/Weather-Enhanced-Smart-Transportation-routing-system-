<div class="accordion" id="flip-view_stage_1">
    <div class="accordion-item">
        <h2 class="accordion-header" id="view_head_stage_1">
            <button class="accordion-button collapsed text-green" type="button" data-bs-toggle="collapse" data-bs-target="#view_stage_1" aria-expanded="false" aria-controls="view_stage_1" style="font-size:16px;font-weight:bold; font-style:Nunito,sans-serif">
                Stage 1 - Self Assessment
            </button>
        </h2>
        <style>
            #stage_1_hide_show_btn_team_name {
                height: 30px;
            }

            .hidden {
                display: none;
            }
        </style>
        <?php
        $Expiry_name = "Expiry";
        $Expired_date = "";
        if (!empty($stage_1->approved_date) && $stage_1->approved_date != "0000-00-00 00:00:00" && $stage_1->approved_date != null) {
            // $Expired_date =  ($stage_1->closure_date == "0000-00-00 00:00:00") ? $stage_1->expiry_date : $stage_1->closure_date;//date('Y-m-d', strtotime('+60 days', strtotime($stage_1->approved_date)));
            $Expired_date = $stage_1->expiry_date;
            // $Expired_date =  date('Y-m-d', strtotime('-61 days'));
            $expiry_date_temp = strtotime($Expired_date);
            $todays_date = strtotime(date('Y-m-d'));  // sempal
            // $todays_date = strtotime('2023-02-16');  // sempal
            $timeleft = $todays_date - $expiry_date_temp;
            $day_remain = round((($timeleft / 86400)));
            
            
            // 
            $date1 = new DateTime(date('Y-m-d', strtotime($Expired_date)));
            $date2 = new DateTime(date('Y-m-d'));
            $interval = $date1->diff($date2);
            $day_remain = $interval->days;
            if ($date2 > $date1) {
                // If $date2 is greater than $date1, make $day_remain_ negative
                $day_remain = -$day_remain;
            }
            // echo $day_remain."Mohsin";
            if ($day_remain > 0) {
                $Expiry_name =  "Expiry";
                // $Expired_date =  date('Y-m-d', strtotime('+30 days', strtotime($stage_1->approved_date)));
                $Expired_date =  date('Y-m-d', strtotime($stage_1->expiry_date));
            } else if ($day_remain >= -30 && $day_remain  < 0) {
                $Expiry_name =  "Expired";
                // $Expired_date =  date('Y-m-d', strtotime('+30 days', strtotime($stage_1->approved_date)));
                $Expired_date =  date('Y-m-d', strtotime($stage_1->expiry_date));
            } else if ($day_remain  <= -31) {
                $Expiry_name =  "Closed";
            }
        }
        ?>
        <div id="view_stage_1" class="accordion-collapse collapse" aria-labelledby="view_head_stage_1" data-bs-parent="#flip-view_stage_1">
            <div class="accordion-body">
                <form action="" id="stage_1_change_status" method="post">
                    <table class="table table-striped border table-hover">
                        <tbody>
                            <tr>
                                <td width="30%">
                                    <b>
                                        Current Status
                                    </b>
                                </td>
                                <td class="w-25">
                                    <b>
                                        <?php
                                        
                                        
                                        // $get_current_stage = find_one_row('application_pointer', 'id', $stage_1->pointer_id);
                                        // print_r($get_current_stage);
                                            // echo $application_pointer->stage;
                                            
                                            $increase_30_days = 0;
                                            
                                            $date1 = new DateTime(date('Y-m-d', strtotime('0 days', strtotime($stage_1->closure_date))));
                                            $date2 = new DateTime(date('Y-m-d'));
                                            $interval = $date1->diff($date2);
                                            // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                                            $day_remain_expiry_checker = $interval->days;
                                            if ($date2 > $date1) {
                                                // If $date2 is greater than $date1, make $day_remain_ negative
                                                $day_remain_expiry_checker = -$day_remain_expiry_checker;
                                            }
                                            if(empty($stage_1->closure_date) || $stage_1->closure_date == "0000-00-00 00:00:00"){
                                                // echo "hre";
                                                if ($stage_1->status == "Expired") {
                                                    if ($Expiry_name == "Closed") {
                                                        echo "Closed";
                                                        $increase_30_days = 30;
                                                    } else {
                                                        echo $stage_1->status;
                                                    }
                                                } else {
                                                    echo $stage_1->status;
                                                }
                                            }
                                            else{
                                                
                                                 if ($day_remain_expiry_checker < 0) {
                                                    if($application_pointer->stage == "stage_1"){
                                                        echo "Closed";
                                                    }   
                                                    else{
                                                        
                                                    echo $stage_1->status;
                                                    }
                                                    
                                                }
                                                else{
                                                    // echo "Closed";
                                                    echo $stage_1->status;
                                                    // echo "ds";
                                                    // echo $stage_1->status;
                                                    
                                                }
                                                // echo $day_remain;
                                            }
                                            

                                        ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Date Submitted
                                </td>
                                <td class="w-25"><?= date('d/m/Y', strtotime($stage_1->submitted_date)) ?></td>
                            </tr>
                            <?php $session= session();
                        if($session){
                        ?>
                        
                            <!-- Date Lodged -->
                            <?php if (!empty($stage_1->lodged_date) && $stage_1->lodged_date != "0000-00-00 00:00:00") { ?>
                                <tr>
                                    <td>Date Lodged</td>
                                    <td class="w-25">
                                        <?php if (!empty($stage_1->lodged_date) && $stage_1->lodged_date != "0000-00-00 00:00:00" && $stage_1->lodged_date != null) { ?>
                                            <?php echo date('d/m/Y', strtotime($stage_1->lodged_date)); ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <!-- Date In Progress -->
                            <?php if (!empty($stage_1->in_progress_date) && $stage_1->in_progress_date != "0000-00-00 00:00:00") { ?>
                                <tr>
                                    <td>Date In Progress</td>
                                    <td class="w-25">
                                        <?php if (!empty($stage_1->in_progress_date) && $stage_1->in_progress_date != "0000-00-00 00:00:00" && $stage_1->in_progress_date != null) { ?>
                                            <?php echo date('d/m/Y', strtotime($stage_1->in_progress_date)); ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php } ?>
                            <!-- Date Approved -->
                            <?php if ($stage_1->status == 'Approved') { ?>
                            <?php } ?>

                            <?php if (!empty($stage_1->approved_date) && $stage_1->approved_date != "0000-00-00 00:00:00" && $stage_1->approved_date != null) { ?>

                                <tr>
                                    <td>Date Approved


                                    </td>
                                    <td class="w-25">
                                        <?php echo date('d/m/Y', strtotime($stage_1->approved_date)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                            
                            
                            <!-- Date Omitted -->
                            
                            <?php if (!empty($stage_1->omitted_date) && $stage_1->omitted_date != "0000-00-00 00:00:00" && $stage_1->omitted_date != null) { ?>

                                <tr>
                                    <td>Date Omitted


                                    </td>
                                    <td class="w-25">
                                        <?php echo date('d/m/Y', strtotime($stage_1->omitted_date)); ?>
                                    </td>
                                </tr>
                            <?php } ?>


                            <!-- Expired Date -->
                            <?php if (empty($stage_2->status) || $stage_2->status == "Start") { ?>
                                <?php if (!empty($Expired_date)) { ?>
                                    <tr>
                                        <td style="width: 30%;"> <?php
                                                                    
                                                                    $date1 = new DateTime(date('Y-m-d', strtotime('0 days', strtotime($stage_1->expiry_date))));
                                                                    $date2 = new DateTime(date('Y-m-d'));
                                                                    $interval = $date1->diff($date2);
                                                                    // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                                                                    $day_remain = $interval->days;
                                                                    if ($date2 > $date1) {
                                                                        // If $date2 is greater than $date1, make $day_remain_ negative
                                                                        $day_remain = -$day_remain;
                                                                    }
                                        
                                                                    // echo $day_remain; //-210
                                                                    if ($day_remain >= 0) {
                                                                    // if ($Expiry_name == "Expiry") {
                                                                        echo "Expiry Date";
                                                                    } else if($day_remain < 0 && $day_remain > -31) {
                                                                        echo "Date Expired";
                                                                    }
                                                                    else{
                                                                        // echo $day_remain_expiry_checker;
                                                                        
                                                                        if(isset($day_remain_expiry_checker) && $day_remain_expiry_checker < 0 && $increase_30_days != 30){
                                                                            echo "Date Expired";
                                                                        }
                                                                        else{
                                                                            
                                                                         echo "Date Closed";
                                                                        }
                                                                    }
                                                                    ?>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y', strtotime("+".$increase_30_days." days", strtotime($Expired_date))); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>



                                <?php 
                        if ($stage_1->is_reinstated == 1) { ?>

                            <tr>

                                <td>Date Reinstated </td>

                                <td class="w-25">

                                    <?php if (!empty($stage_1->date_reinstate) && $stage_1->date_reinstate != "0000-00-00 00:00:00" && $stage_1->date_reinstate != null) { ?>

                                        <?php echo date('d/m/Y', strtotime($stage_1->date_reinstate)); ?>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php } ?>
                        
                        
                                <?php 
                                // echo $stage_1->closure_date;
                        if(!empty($stage_1->closure_date)){
                        if ($stage_1->closure_date != "0000-00-00 00:00:00" && !isset($stage_2)) { ?>

                            <tr>

                                <td>
                                    <?php 
                                    // echo $day_remain_expiry_checker;
                                    if($day_remain_expiry_checker < 0){
                                        ?>
                                        Date Closed
                                        <?php
                                    }
                                    else{
                                        ?>
                                        
                                        Closure Date
                                        <?php
                                    }
                                    ?>
                                </td>

                                <td class="w-25">

                                    <?php if (!empty($stage_1->closure_date) && $stage_1->date_reinstate != "0000-00-00 00:00:00" && $stage_1->closure_date != null) { ?>

                                        <?php echo date('d/m/Y', strtotime($stage_1->closure_date)); ?>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php } 
                        }
                        ?>




                            <?php if ($stage_1->status == 'Declined') { ?>
                                <tr>
                                    <td>Date Declined</td>
                                    <td class="w-25">
                                        <?php if (!empty($stage_1->declined_date) && $stage_1->declined_date != "0000-00-00 00:00:00" && $stage_1->declined_date != null) { ?>
                                            <?php echo date('d/m/Y', strtotime($stage_1->declined_date)); ?>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php }
                            if ($stage_1->status == 'Withdrawn') { ?>
                                <tr>
                                    <td>Date Withdrawn</td>
                                    <td class="w-25">
                                        <?php if (!empty($stage_1->withdraw_date) && $stage_1->withdraw_date != "0000-00-00 00:00:00" && $stage_1->withdraw_date != null) { ?>
                                            <?php echo date('d/m/Y', strtotime($stage_1->withdraw_date)); ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>

                           
                            <!-- Team Allocation Code -->
                            <tr id="allocate_team_member" style="display: none;">
                                <td> ATTC Team Member</td>
                                <td class="w-20">
                                    <!-- <div style="display: flex;" class="position-relative"> -->
                                    <div class="row">

                                        <?php
                                        $allocate_team_member_show = false;
                                        // if ($stage_1->status == "Lodged") {
                                        $allocate_team_member_show = true;
                                        // }
                                        if (session()->has('admin_account_type')) {
                                            $admin_account_type =  session()->get('admin_account_type');

                                            // if ($admin_account_type == "admin") {
                                            //     $allocate_team_member_show = true;
                                            // }
                                        }
                                        // if ($stage_1->status == "In Progress" || $stage_1->status == "Approved" || $stage_1->status == "Declined") {
                                        // }
                                        ?>

                                        <?php
                                        $allocate_team_member_name_data =   get_tb('allocate_team_member_name');
                                        if ($allocate_team_member_show) { ?>
                                            <div class="col-6">
                                                <select name="allocate_team_member_name" id="allocate_team_member_select_id" class="form-select" aria-label="Default select example" onchange="select_tab()">
                                                    <option value="" selected disabled> Select name</option>
                                                    <?php
                                                    $id_of_member = $stage_1->allocate_team_member_name;
                                                    foreach ($allocate_team_member_name_data as $key => $value) {
                                                    ?>
                                                        <?php
                                                        $selected = "";
                                                        if ($value['id'] == $id_of_member) {
                                                            $selected = "selected ";
                                                        }
                                                        ?>
                                                        <option <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <script>
                                                function select_tab(){
                                          var Assigned_Team_Memberid =document.getElementById("unique_no_stage_1").readOnly = false;
                                                 
                                                                                        }
                                            </script>
                                            <?php if ($admin_account_type == "admin") { ?>
                                            <?php } ?>
                                            <div class="col-4">

                                                <a id="stage_1_hide_show_btn_team_name_save" href="javascript:void(0)"  class="btn btn-sm btn_green_yellow my-auto hidden" style="display:none">
                                                    <i class='bi bi-check-circle' title='Save'></i>
                                                </a>
                                            </div>
                                            <script>
                                                document.getElementById("allocate_team_member_select_id").addEventListener("change", function() {
                                                    var uniqui_d="<?=$stage_1->unique_id?>";
                                                    if(uniqui_d != ""){
                                                        document.getElementById("stage_1_hide_show_btn_team_name_save").classList.remove("hidden");
                                                    }
                                                    
                                                });
                                            </script>

                                            <script>
                                                function stage_1_hide_show_btn_team_name_() {
                                                    event.preventDefault();
                                                    var selectedValue = $("#allocate_team_member_select_id").val();
                                                     var saveBtn = $("#stage_1_hide_show_btn_team_name_save");
                                         
                                                    var data = {
                                                        selectedValue: selectedValue
                                                    };
                                                    document.getElementById("stage_1_hide_show_btn_team_name_save").classList.remove("hidden");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?= base_url('admin/save_Assigned_Team_Member/' . $pointer_id) ?>",
                                                        data: data,
                                                        success: function(response) {
                                                            if (response == 1) {
                                                                saveBtn.hide();
                                                                window.location.reload();
                                                                document.getElementById("stage_1_hide_show_btn_team_name_save").classList.add("hidden");
                                                            }
                                                        },
                                                        error: function(jqXHR, textStatus, errorThrown) {
                                                            console.log("AJAX request failed:", textStatus, errorThrown);
                                                            document.getElementById("stage_1_hide_show_btn_team_name_save").classList.remove("hidden");
                                                        }
                                                    });
                                                }
                                            </script>
                                        <?php } else { ?>

                                            <?= (isset($stage_1->allocate_team_member_name) ? (isset(get_allocate_team_member_name($stage_1->allocate_team_member_name)->name) ? get_allocate_team_member_name($stage_1->allocate_team_member_name)->name : "N/A") : "N/A") ?>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>

                            <tr id="headoffice_no" style="display: none;">
                                <td>ATTC Ticket No.</td>
                                <td class="w-25">
                                    <div class="row">
                                        <div class="col-6">
                                            <input readonly  onchange="check_edit()" type="text" <?php if ($stage_1->status != "Lodged") {
                                                                    echo "readonly";
                                                                } ?> <?php if (!empty($stage_1->unique_id)) {
                                                                            echo "readonly";
                                                                        } ?> name="unique_id" id="unique_no_stage_1" class="form-control" value="<?= $stage_1->unique_id ?>" maxlength="20">
                                        </div>   
                                                 <div class="col-4 bbg-info my-auto">
                                            <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="readonlyInput('#unique_no_stage_1')">
                                                <?php if ($admin_account_type != "admin") { ?>
                                                    <?php if (!empty($stage_1->unique_id)) { ?>
                                                        <i class="bi bi-pencil-square" ></i>

                                                    <?php } else { ?>
                                                        <i class="bi bi-check-circle" title="Save"></i>

                                                    <?php } ?>

                                                <?php } else { ?>
                                                    <i class="bi bi-pencil-square" title="Save"></i>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    <script>
                                        function check_edit(){
                                          var selectid = document.getElementById("unique_no_stage_1").value;
                                           var Assigned_Team_Member__id =document.getElementById("allocate_team_member_select_id").value;
                                            var saveBtn = document.getElementById("stage_1_hide_show_btn");
                                            
                                       if (selectid === " " && Assigned_Team_Member__id !==0) {
                                            var iconElement = saveBtn.querySelector("i");
                                                if (iconElement) {
                                                    iconElement.classList.remove("bi-check-circle");
                                                    iconElement.classList.add("bi-pencil-square");
                                                    iconElement.title = "Save";
                                                }
                                    } else {
                                       var iconElement = saveBtn.querySelector("i");
                                    if (iconElement) {
                                        iconElement.classList.remove("bi-pencil-square");
                                        iconElement.classList.add("bi-check-circle");
                                        iconElement.title = "Save";
                                    }
                                    }
                                    
                                                                        }
                                        
                                    </script>
                                    </div>

                                </td>
                            </tr>





                            <!-- Status -->
                            <tr>
                                <td>Change Status</td>
                                <?php
                                $submit_btn_show = true;
                                $check = '';
                                $session = session();
                                // print_r($session);
                                $omi_active = '';
                                $dec_active = "";

                                if ($stage_1->status == "Submitted") {
                                    $log_active = "";
                                    $log_select = $pro_select = $app_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $pro_active = $app_active = $with_active = $rei_active = $disabled;
                                } else if ($stage_1->status == "Lodged") {
                                    $log_select = "";
                                    $pro_active = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $log_active = $app_active = $dec_active = $with_active = $rei_active = $disabled;
                                } else if ($stage_1->status == "In Progress") {
                                    $app_select = "";
                                    $dec_active = $with_active  = $app_active  = $rei_active  = "";
                                    $pro_select = $log_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $rei_active =   $with_active =    $log_active = $pro_active  = $disabled;
                                } else if ($stage_1->status == "Approved") {
                                    $app_select = "";
                                    $dec_active = $with_active = $rei_active  = "";
                                    $pro_select = $log_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $dec_active =  $rei_active =   $with_active =  $with_active =  $log_active = $app_active = $pro_active  = $disabled;
                                }
                                 else if ($stage_1->status == "Omitted") {
                                    $app_select = "";
                                    $dec_active = $with_active = $rei_active  = "";
                                    $pro_select = $log_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $dec_active =  $rei_active =   $with_active =  $with_active =  $log_active = $app_active = $pro_active  = $disabled;
                                }
                                else if ($stage_1->status == "Declined") {
                                    $log_select = "";
                                    $dec_active = $with_active = $rei_active  = $log_active = "";
                                    $dec_select =  $pro_select = $app_select =  $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    } else {
                                        $submit_btn_show = false;
                                    }
                                    $omi_active = $dec_active = $rei_active =   $with_active = $rei_active  = $log_active = $app_active = $pro_active   = $disabled;
                                } else if ($stage_1->status == "Withdrawn") {
                                    $with_select = "";
                                    $dec_active = $with_active = $rei_active  = $log_active = "";
                                    $pro_select = $app_select = $dec_select = $log_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    } else {
                                        $submit_btn_show = false;
                                    }
                                    $omi_active = $rei_active =   $with_active =    $dec_active = $with_active = $rei_active  = $log_active = $app_active = $pro_active   = $disabled;
                                } else if ($stage_1->status == "Reinstate") {
                                    $rei_select = "";
                                    $dec_active = $with_active = $rei_active  = $log_active = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $rei_active =   $with_active =    $app_active = $pro_active  = $disabled;
                                } else if ($stage_1->status == "Archive") {
                                    $rei_select = "";
                                    $rei_active  = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select =  $dec_active = $with_active = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $rei_active =   $with_active =    $app_active = $pro_active  = $log_active = "disabled";
                                } else if ($stage_1->status == "Expired") {
                                    $rei_select = "";
                                    $rei_active  = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select = $dec_active = $with_active = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $omi_active = $rei_active =   $with_active =   $app_active = $pro_active  = $log_active = $disabled;
                                } else {
                                    $rei_select = "";
                                    $rei_active  = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_id == "1") {
                                        $disabled = "";
                                    }
                                    $rei_active = $dec_active = $with_active =  $app_active = $pro_active  = $log_active = $disabled;
                                }
                                $check .= 'disabled';
                                // $rei_select = "disabled";
                                // // echo $day_remain;
                                
                                
                                // $date1 = new DateTime(date('Y-m-d', strtotime('0 days', strtotime($stage_1->expiry_date))));
                                // $date2 = new DateTime(date('Y-m-d'));
                                // $interval = $date1->diff($date2);
                                // // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                                // $day_remain = $interval->days;
                                // if ($date2 > $date1) {
                                //     // If $date2 is greater than $date1, make $day_remain_ negative
                                //     $day_remain = -$day_remain;
                                // }
                                
                                // // echo $day_remain;
                                // if($day_remain > 0){
                                //     $rei_select = "";
                                // }
                                // if($stage_1->closure_date != "0000-00-00 00:00:00"){
                                //     $rei_select = "disabled";
                                // }
                                // echo $day_remain;
                                
                                // Withdrwala
                                if($session->admin_account_type == "admin"){
                                    $rei_active = $rei_select = $with_active = $with_select = $dec_active =  "";
                                }
                                // END
                                ?>

                                <td class="w-25">
                                    <select required class="form-select stg_1_status_select" name="status" id="stage_1_status_drop" onchange="change_status(this.value)">
                                        <option selected disabled>Select Status</option>
                                        <option id="lodged" value="Lodged" <?= $log_active ." ". $log_select ?>>Lodged</option>
                                        <option id="in_progress" value="In Progress" <?= $pro_active ." ". $pro_select ?>>In Progress</option>
                                        <option id="approved" value="Approved" <?= $app_active ." ". $app_select ?>>Approved</option>
                                        <option id="omitted" value="Omitted" <?= $omi_active ?>>Omitted</option>
                                        <option id="declined" value="Declined" <?= $dec_active ." ". $dec_select ?>>Declined</option>
                                        <option id="Withdrawn" value="Withdrawn" <?= $with_active ." ". $with_select ?>>Withdrawn</option>
                                        <option id="Reinstate" value="Reinstate" <?= $rei_active ." ". $rei_select ?>>Reinstate</option>
                                    </select>
                                    <input type="hidden" name="pointer_id" value="<?= $stage_1->pointer_id ?>">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <input type="hidden" name="stage_1_id" value="<?= $stage_1->id ?>">
                                </td>
                            </tr>
                            
                            <!-- Approved comment Reason -->
                            <tr id="approval_comment_tr" style="display: <?= ($stage_1->status == 'Approved') ? '' : 'none' ?>;">
                                <td> Assessor Comments </td>
                                <td class="w-20">
                                    <div style="display: flex;" class="position-relative">
                                        <textarea class="form-control" <?php
                                                                        if ($stage_1->status == 'Approved') {
                                                                            echo "readonly";
                                                                        } else {
                                                                            echo 'required="not-required"';
                                                                        }
                                                                        ?> id="approval_comment_input" name="approval_comment" rows="3"><?php
                                                                                                                    if ($stage_1->status == 'Approved') {

                                                                                                                        echo $stage_1->approved_comment;
                                                                                                                        // }else if($stage_1->status == "Lodged"){
                                                                                                                        //     echo $stage_1->lodged_comment;
                                                                                                                    }
                                                                                                                    
                                                                                                                    ?> </textarea>

                                        <a href="javascript:void(0)" id="stage_1_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="showReadOnly('#approval_comment_input')">
                                            <i class="bi bi-pencil-square"></i> </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Declined Reason -->
                            <tr id="reason_tr" style="display: none;">
                                <td> Reason </td>
                                <td class="w-20">
                                    <div style="display: flex;" class="position-relative">
                                        <textarea class="form-control" <?php
                                                                        if ($stage_1->status == 'Declined') {
                                                                            echo "readonly";
                                                                        } else {
                                                                            echo 'required="not-required"';
                                                                        }
                                                                        ?> id="reason_input" name="reason" rows="3"><?php
                                                                                                                    if ($stage_1->status == 'Declined') {

                                                                                                                        echo $stage_1->declined_reason;
                                                                                                                        // }else if($stage_1->status == "Lodged"){
                                                                                                                        //     echo $stage_1->lodged_comment;
                                                                                                                    }
                                                                                                                    // An invalid form control with name='reason' is not focusable. <textarea class=​"form-control" id=​"reason_input" name=​"reason" rows=​"3" required=​"required">​</textarea>​
                                                                                                                    ?> </textarea>

                                        <a href="javascript:void(0)" id="stage_1_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInputs3('#reason_input')">
                                            <i class="bi bi-pencil-square"></i> </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <?php 
                            // $stage_1->expiry_date && !isset($stage_2)
                            if(empty($stage_1->closure_date) || $stage_1->closure_date == "0000-00-00 00:00:00"){
                            ?>
                            <!-- Change Expiry date -->
                            
                            <tr id="date_expiry_html" style="display: none;">
                                <td>
                                    Closure Date
                                </td>
                                <td>
                                    <input type="date" name="date_expiry" id="date_expiry" class="form-control" value="<?= date("Y-m-d",strtotime("+30 days", strtotime($stage_1->expiry_date))) ?>" min="<?= date("Y-m-d",strtotime("+30 days", strtotime($stage_1->expiry_date))) ?>" max="<?= date("Y-m-d",strtotime("+37 days", strtotime($stage_1->expiry_date))) ?>">
                                </td>
                            </tr>
                            <!-- END Change Expiry date -->
                            <?php } ?>

                            <!-- Omitted Date Deadline Date Picker -->
                            
                            <tr id="omitted_deadline_date_html" style="display: none;">
                                <td>
                                    Deadline Date
                                </td>
                                <td>
                                    <?php 
                                    $value_omitted_deadline = "";
                                    // if($stage_1->omitted_deadline_date){
                                    //     $value_omitted_deadline = date("Y-m-d", strtotime($stage_1->omitted_deadline_date));
                                    // }
                                    ?>
                                    <input type="date" name="omitted_deadline_date" id="omitted_deadline_date" class="form-control" value="<?= $value_omitted_deadline ?>" min="<?= date("Y-m-d") ?>">
                                </td>
                            </tr>
                            <!-- End Omitted Date Deadline Date Picker -->



                            <tr>
                                <td colspan="2" class="text-center">
                                    <?php if ($submit_btn_show) { ?>
                                        <button type="submit" class="btn btn_green_yellow">Update</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="accordion mt-1" id="flip-view_stage_1">
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
            $Expired_date =  date('Y-m-d', strtotime('+60 days', strtotime($stage_1->approved_date)));
            // $Expired_date =  date('Y-m-d', strtotime('-61 days'));
            $expiry_date_temp = strtotime($Expired_date);
            $todays_date = strtotime(date('Y-m-d'));  // sempal
            // $todays_date = strtotime('2023-02-16');  // sempal
            $timeleft = $todays_date - $expiry_date_temp;
            $day_remain = round((($timeleft / 86400)));
            if ($day_remain < -30) {
                $Expiry_name =  "Expiry";
                $Expired_date =  date('Y-m-d', strtotime('+30 days', strtotime($stage_1->approved_date)));
            } else if ($day_remain > -30 && $day_remain  < 0) {
                $Expiry_name =  "Expired";
                $Expired_date =  date('Y-m-d', strtotime('+30 days', strtotime($stage_1->approved_date)));
            } else if ($day_remain  >= 0) {
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
                                        if ($stage_1->status == "Expired") {
                                            if ($Expiry_name == "Closed") {
                                                echo "Closed";
                                            } else {
                                                echo $stage_1->status;
                                            }
                                        } else {
                                            echo $stage_1->status;
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

                            <!-- Expired Date -->
                            <?php if (empty($stage_2->status) || $stage_2->status == "Start") { ?>
                                <?php if (!empty($Expired_date)) { ?>
                                    <tr>
                                        <td style="width: 30%;"> <?php
                                                                    if ($Expiry_name == "Expiry") {
                                                                        echo "Expiry Date";
                                                                    } else {
                                                                        echo "Date " . $Expiry_name;
                                                                    } ?>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y', strtotime($Expired_date)); ?>
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
                                <td> Assigned Team Member</td>
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

                                                <!-- <a id="stage_1_hide_show_btn_team_name_save" href="javascript:void(0)"  class="btn btn-sm btn_green_yellow my-auto hidden" style="display:none">
                                                    <i class='bi bi-check-circle' title='Save'></i>
                                                </a> -->
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
                                            <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="readonlyInput('#unique_no_stage_1')">
                                                <php if ($admin_account_type != "admin") { ?>
                                                    <php if (!empty($stage_1->unique_id)) { ?>
                                                        <i class="bi bi-pencil-square" ></i>

                                                    <php } else { ?>
                                                        <i class="bi bi-check-circle" title="Save"></i>

                                                    <php } ?>

                                                <php } else { ?>
                                                    <i class="bi bi-pencil-square" title="Save"></i>
                                                <php } ?>
                                            </a> -->
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


                                if ($stage_1->status == "Submitted") {
                                    $log_active = "";
                                    $log_select = $pro_select = $app_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $pro_active = $app_active = $dec_active = $with_active = $rei_active = $disabled;
                                } else if ($stage_1->status == "Lodged") {
                                    $log_select = "";
                                    $pro_active = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $log_active = $app_active = $dec_active = $with_active = $rei_active = $disabled;
                                } else if ($stage_1->status == "In Progress") {
                                    $app_select = "";
                                    $dec_active = $with_active  = $app_active  = $rei_active  = "";
                                    $pro_select = $log_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $rei_active =   $with_active =    $log_active = $pro_active  = $disabled;
                                } else if ($stage_1->status == "Approved") {
                                    $app_select = "";
                                    $dec_active = $with_active = $rei_active  = "";
                                    $pro_select = $log_select = $dec_select = $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $dec_active =  $rei_active =   $with_active =  $with_active =  $log_active = $app_active = $pro_active  = $disabled;
                                } else if ($stage_1->status == "Declined") {
                                    $log_select = "";
                                    $dec_active = $with_active = $rei_active  = $log_active = "";
                                    $dec_select =  $pro_select = $app_select =  $with_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    } else {
                                        $submit_btn_show = false;
                                    }
                                    $rei_active =   $with_active = $rei_active  = $log_active = $app_active = $pro_active   = $disabled;
                                } else if ($stage_1->status == "Withdrawn") {
                                    $with_select = "";
                                    $dec_active = $with_active = $rei_active  = $log_active = "";
                                    $pro_select = $app_select = $dec_select = $log_select = $rei_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    } else {
                                        $submit_btn_show = false;
                                    }
                                    $rei_active =   $with_active =    $dec_active = $with_active = $rei_active  = $log_active = $app_active = $pro_active   = $disabled;
                                } else if ($stage_1->status == "Reinstate") {
                                    $rei_select = "";
                                    $dec_active = $with_active = $rei_active  = $log_active = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $rei_active =   $with_active =    $app_active = $pro_active  = $disabled;
                                } else if ($stage_1->status == "Archive") {
                                    $rei_select = "";
                                    $rei_active  = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select =  $dec_active = $with_active = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $rei_active =   $with_active =    $app_active = $pro_active  = $log_active = "disabled";
                                } else if ($stage_1->status == "Expired") {
                                    $rei_select = "";
                                    $rei_active  = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select = $dec_active = $with_active = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $rei_active =   $with_active =   $app_active = $pro_active  = $log_active = $disabled;
                                } else {
                                    $rei_select = "";
                                    $rei_active  = "";
                                    $pro_select = $app_select = $dec_select = $with_select = $log_select = "";
                                    $disabled = "disabled";
                                    if ($session->admin_account_type == "admin") {
                                        $disabled = "";
                                    }
                                    $rei_active = $dec_active = $with_active =  $app_active = $pro_active  = $log_active = $disabled;
                                }
                                $check .= 'disabled';
                                ?>

                                <td class="w-25">
                                    <select required class="form-select stg_1_status_select" aria-label="Default select example" name="status" id="stage_1_status_drop" onchange="change_status(this.value)">
                                        <option selected disabled>Select Status</option>
                                        <option id="lodged" value="Lodged" <?= $log_active . $log_select ?>>Lodged</option>
                                        <option id="in_progress" value="In Progress" <?= $pro_active . $pro_select ?>>In Progress</option>
                                        <option id="approved" value="Approved" <?= $app_active . $app_select ?>>Approved</option>
                                        <option id="declined" value="Declined" <?= $dec_active . $dec_select ?>>Declined</option>
                                        <option id="Withdrawn" value="Withdrawn" <?= $with_active . $with_select ?>>Withdrawn</option>
                                        <option id="Reinstate" value="Reinstate" <?= $rei_active . $rei_select ?>>Reinstate</option>
                                    </select>
                                    <input type="hidden" name="pointer_id" value="<?= $stage_1->pointer_id ?>">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <input type="hidden" name="stage_1_id" value="<?= $stage_1->id ?>">
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

                                        <!-- <a href="javascript:void(0)" id="stage_1_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInput('#reason_input')">
                                            <i class="bi bi-pencil-square"></i> </i>
                                        </a> -->
                                    </div>
                                </td>
                            </tr>




                            <tr>
                                <td colspan="2" class="text-center">
                                    <?php if ($submit_btn_show) { ?>
                                        <button type="submit" class="btn btn_green_yellow" disabled>Update</button>
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
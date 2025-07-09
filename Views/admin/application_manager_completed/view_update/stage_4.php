<div class="accordion mt-1" id="flip-view_stage_4">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed text-green text-center" type="button" data-bs-toggle="collapse" data-bs-target="#stage_4" aria-expanded="false" aria-controls="stage_4" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Stage 4 - Practical Assessment
            </button>
        </h2>

        <div id="stage_4" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#flip-view_stage_4">
            <div class="accordion-body">
                <form action="" id="stage_4_change_status" method="post">
                    <table class="table table-striped border table-hover">
                        <tr>
                            <td width="30%">
                                <b> Current Status
                                </b>
                            </td>
                            <td class="w-25">
                                <b> <?= $stage_4->status ?> </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Date Submitted </td>
                            <td class="w-25">
                                <?php if (!empty($stage_4->submitted_date) && $stage_4->submitted_date != "0000-00-00 00:00:00" && $stage_4->submitted_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_4->submitted_date)); ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if (!empty($stage_4->lodged_date) and $stage_4->lodged_date != "0000-00-00 00:00:00") { ?>
                        <?php $session= session();
                        if($session){
                        ?>
                        
                            <tr>
                                <td>Date Lodged </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_4->lodged_date) && $stage_4->lodged_date != "0000-00-00 00:00:00" && $stage_4->lodged_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_4->lodged_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo ($stage_4->lodged_date) ? date('d/m/Y  H:i:s', strtotime($stage_4->lodged_date)) : ''; ?> -->
                                </td>
                            </tr>
                            <?php } ?>
                        <?php }
                        if (!empty($stage_4->scheduled_date) && $stage_4->scheduled_date != "0000-00-00 00:00:00") {
                        ?>
                        <tr>
                            <td>Date Scheduled </td>
                            <td class="w-25">
                                <?php if (!empty($stage_4->scheduled_date) && $stage_4->scheduled_date != "0000-00-00 00:00:00" && $stage_4->scheduled_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_4->scheduled_date)); ?>
                                <?php } ?>
                                <!-- <?php echo ($stage_4->scheduled_date) ? date('d/m/Y  H:i:s', strtotime($stage_4->scheduled_date)) : ''; ?> -->
                            </td>
                        </tr>
                        <?php
                        }
                        if ($stage_4->status == 'Approved') { ?>
                            <tr>
                                <td>Date Approved </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_4->approved_date) && $stage_4->approved_date != "0000-00-00 00:00:00" && $stage_4->approved_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_4->approved_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }

                        if ($stage_4->status == 'Declined') { ?>
                            <tr>
                                <td>Date Declined </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_4->declined_date) && $stage_4->declined_date != "0000-00-00 00:00:00" && $stage_4->declined_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_4->declined_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                        if ($stage_4->status == 'Withdrawn') { ?>
                            <tr>
                                <td>Date Withdrawn </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_4->withdraw_date) && $stage_4->withdraw_date != "0000-00-00 00:00:00" && $stage_4->withdraw_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_4->withdraw_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Change Status</td>
                            <?php
                            $check = '';
                            $session = session();
                            if ($stage_4->status == "Submitted") {
                                $log_active_4 = $pro_active_4 = "";
                                $log_select_4 = $pro_select_4 = $app_select_4 = $dec_select_4 = $with_select_4 = $sch_select_4 = $con_select_4 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }
                                $log_active_4 =  $app_active_4 = $dec_active_4 = $with_active_4 = $sch_active_4 = $con_active_4 = $disabled;
                            } else if ($stage_4->status == "Lodged") {
                                $log_select_4 = "";
                                $pro_select_4 = $app_select_4 = $dec_select_4 = $with_select_4 = $sch_select_4 = $con_select_4 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }

                                $with_active_4 =   $log_active_4 = $app_active_4 = $dec_active_4 = $with_active_4 = $sch_active_4 = $con_active_4 =  $pro_active_4 = $disabled;
                                // }else if($stage_4->status=="In Progress"){
                                //     $log_select_4 ="";
                                //     $pro_select_4 =  $dec_select_4 = $with_select_4 = $sch_select_4 = $con_select_4=  $app_select_4="";
                                //     $pro_active_4 = $log_active_4 = $app_active_4  = $sch_active_4 = $con_active_4 =  $dec_active_4 = $with_active_4 = "disabled";
                            } else if ($stage_4->status == "Scheduled") {
                                $sch_select_4 = "";
                                $dec_active_4 = $with_active_4 = "";
                                $pro_select_4 = $app_select_4 = $dec_select_4 = $log_select_4 = $sch_active_4 = $con_select_4 = $with_select_4 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }

                                $with_active_4 =  $log_active_4 = $app_active_4  = $pro_active_4 = $con_active_4 =  $dec_active_4 = $with_active_4 =  $disabled;
                            } else if ($stage_4->status == "Conducted") {
                                $app_select_4 = "";
                                $dec_active_4 = $with_active_4 = $con_active_4 = $app_active_4 = "";
                                $pro_select_4 = $dec_select_4 = $log_select_4 = $sch_active_4 = $with_select_4 = $sch_select_4 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }

                                $with_active_4 =  $log_active_4 =  $pro_active_4 = $sch_select_4  = $con_select_4 = $disabled;
                            } else if ($stage_4->status == "Approved") {
                                $app_select_4 = "";
                                $dec_active_4 = $with_active_4 = "";
                                $pro_select_4 = $log_select_4 = $dec_select_4 = $with_select_4 = $sch_select_4 = $con_select_4 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }



                                $with_active_4 =    $log_active_4 = $app_active_4 = $pro_active_4  = $sch_active_4 = $con_active_4 = $disabled;
                            } else if ($stage_4->status == "Declined") {
                                $dec_select_4 = "";
                                $dec_active_4 = $with_active_4 =  $log_active_4 = "";
                                $pro_select_4 = $app_select_4 = $log_select_4 = $with_select_4 = $sch_select_4 = $con_select_4 =  "";

                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }
                                



                                $with_active_4 =  $pro_active_4  = $sch_active_4 = $con_active_4 = $app_active_4 =  $disabled;
                            } else if ($stage_4->status == "Withdrawn") {
                                $with_select_4 = "";
                                $dec_active_4 = $with_active_4 = $log_active_4 = "";
                                $pro_select_4 = $app_select_4 = $dec_select_4 = $log_select_4 = $sch_select_4 = $con_select_4 = "";


                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }




                                $with_active_4 =    $con_active_4 = $app_active_4 = $pro_active_4 = $sch_active_4 =  $disabled;
                            } else {
                                $with_select_4 = "";
                                $dec_active_4 = $with_active_4 = $log_active_4 = "";
                                $pro_select_4 = $app_select_4 = $dec_select_4 = $log_select_4 = $sch_select_4 = $con_select_4 = "";


                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_4 = $con_active_4 = $con_select_4 = $sch_active_4 = "disabled";
                                }


                                $with_active_4 =    $con_active_4 = $app_active_4 = $pro_active_4 = $sch_active_4 =  $disabled;
                            }
                            $check .= 'disabled';
                            // Access Permission
                            
                            if($session->admin_account_type == "head_office"){
                                $with_active_4 =    $con_active_4 = $app_active_4 = $pro_active_4 = $sch_active_4 = "disabled";    
                            }
                            
                            $stage__cheking = find_one_row("stage_1_occupation","pointer_id", $stage_3->pointer_id);
                            if($stage__cheking->pathway == "Pathway 1"){
                                if($stage__cheking->occupation_id == 7 || $stage__cheking->occupation_id == 18){
                                    if($session->admin_account_type == "head_office"){
                                        $dec_active_4 = $app_active_4 = "disabled";    
                                    }
                                }
                            }
                            

                            ?>
                            <td class="w-25">
                                <select required class="form-select mb-3 stg_4_status_select" aria-label="Default select example" name="status" id="stage_4_status_drop" onchange="change_status_4(this.value)">
                                    <option selected disabled>Select Status</option>
                                    <option id="lodged_4" value="Lodged" <?= $log_active_4 . $log_select_4 ?>>Lodged</option>
                                    <!-- <option id="in_progress_4" value="In Progress" <=$pro_active_4.$pro_select_4?> >In Progress</option> -->
                                    <option id="scheduled_4" value="Scheduled" disabled <?= $sch_active_4 . $sch_select_4 ?>>Scheduled</option>
                                    <option id="conducted_4" value="Conducted" disabled <?= $con_active_4 . $con_select_4 ?>>Conducted</option>
                                    <option id="approved_4" value="Approved" <?= $app_active_4 . $app_select_4 ?>>Approved</option>
                                    <option id="declined_4" value="Declined" <?= $dec_active_4 . $dec_select_4 ?>>Declined</option>
                                    <option id="Withdrawn_4" value="Withdrawn" disabled <?= $with_active_4 . $with_select_4 ?>>Withdrawn</option>
                                </select>
                                <input type="hidden" name="pointer_id" value="<?= $stage_4->pointer_id ?>">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="stage_4_id" value="<?= $stage_4->id ?>">

                            </td>
                        </tr>

                        <?php 
                            if($session->admin_account_type == "admin"){
                                ?>
                                
                        <tr>
                            <?php $preference_location= $stage_4->preference_location; ?> 
                            <td>Preferred Location</td>
                            <td>
                                <div class="row">
                                <div class="col-md-11">
                                    
                                <select id="preference_location_stage_4" class="form-select mb-3 stg_4_status_select" onchange="update_prefered_location_stage_4();" name="preference_location_stage_4" disabled="true" style="width:100%">

                            <option value="" selected> Select Location</option>

                            <?php foreach ($pratical_location as $key => $value) {  
                            //  print_r($pratical_location)
                            // print_r($value);
                                if($value){                         
                             ?>

                                    
                                    <optgroup label="<?= $key ?>">

                                        <?php foreach ($value as $key_ => $value_) {

                                            $selected = "";

                                            if ($preference_location == $value_['city_name']) {

                                                $selected = "selected";

                                            }  ?>


                                            <option value="<?= $value_['city_name'] ?>" <?= $selected ?>><?= $value_['city_name'].' - '.$value_['location'] ?></option>

                                        <?php  }  ?>
                                    </optgroup>


                                <?php  } } ?>

                        </select>
                        </div>
                        <div class="col-md-1">
                             <!-- <a href="javascript:void(0)" id="preference_location_edit_enable_stage_4" style="float: left" class="btn btn-sm btn_green_yellow " onclick="return enable_location_edit_btn_stage_4();"><i class="bi bi-pencil-square" ></i></a> -->

                             <!-- <a href="javascript:void(0)" id="prefered_location_edit_stage_4" style="display: none" class="btn btn-sm btn_green_yellow " onclick="return disable_location_edit_btn_stage_4();"><i class="bi bi-check-circle" ></i> -->
                        </a>
                        </div>
                        
                    </div>
                    </td>
                        </tr>
                        
                        
                    <tr id="comment_tr_4">
                        <td> Comments </td>
                        <td class="w-20">
                            <div style="display: flex;" class="position-relative">
                                <textarea class="form-control" readonly id="comment_input_4" name="comment" rows="3"><?php
                                                                                                                        if (!empty($stage_4->preference_comment)) {
                                                                                                                            echo $stage_4->preference_comment;
                                                                                                                        };
                                                                                                                        ?></textarea>
                                <?php 
                                    // Comment Hide mohsin
                                    if($session->admin_account_type == "admin"){
                                        ?>
                                <!-- <a href="javascript:void(0)" id="stage_4_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInput('#comment_input_4')">
                                    <i class="bi bi-pencil-square"></i> </i></a> -->
                                      <?php
                                    }
                                    ?>
                            </div>
                        </td>
                    </tr>
                                <?php
                            }
                        // 
                        if($session->admin_account_type == "head_office"){
                        // 
                           if($stage_4->status != "Submitted"){
                               ?>
                               
                    <tr id="comment_tr_4">
                        <td> Comments </td>
                        <td class="w-20">
                            <div style="display: flex;" class="position-relative">
                                <textarea class="form-control" readonly id="comment_input_4" name="comment" rows="3"><?php
                                                                                                                        if (!empty($stage_4->preference_comment)) {
                                                                                                                            echo $stage_4->preference_comment;
                                                                                                                        };
                                                                                                                        ?></textarea>
                                <?php 
                                    // Comment Hide mohsin
                                    if($session->admin_account_type == "admin"){
                                        ?>
                                <!-- <a href="javascript:void(0)" id="stage_4_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInput('#comment_input_4')">
                                    <i class="bi bi-pencil-square"></i> </i></a> -->
                                      <?php
                                    }
                                    ?>
                            </div>
                        </td>
                    </tr>
                               <?php
                           }
                        }
                        
                        ?>

                            
                        
                    </div>
                        <!---------------------- approved documnets for both pathway ----------------------->
                        <?php
                            $stage_4_approved_css_docs = "display: none;";
                            if($stage_4->status == "Approved"){
                            $stage_4_approved_css_docs = "";    
                            }
                        ?>
                        <tr id="s4_appr_tr_1_4" style="<?= $stage_4_approved_css_docs ?>">
                            <td>Upload Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                $stage_4_documents = json_decode(json_encode($stage_4_documents), true);

                                foreach ($stage_4_documents as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 47) { // Outcome Letter
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s4_show_upload_file('#s4_appr_path')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <div style="display: flex;">
                                        <input name="upload_outcome_file" <?php if ($Outcome_Letter_available) {
                                                                                echo 'style="display: none;"';
                                                                            } ?> id="s4_appr_path" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_appr_path_s4" onclick="s4_auto_file_upload('s4_appr_path','upload_outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for pathway 1 ----------------------->
                        <tr id="s4_appr_tr_2_4" style="<?= $stage_4_approved_css_docs ?>">
                            <td>Upload OTSR</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_4_documents as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 48) { // Upload OSTR
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s4_show_upload_file('#s4_appr_path_1')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <div style="display: flex;">
                                        <input name="upload_qualification_file" <?php if ($Outcome_Letter_available) {
                                                                                    echo 'style="display: none;"';
                                                                                } ?> id="s4_appr_path_1" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_s4" onclick="s4_auto_file_upload('s4_appr_path_1','upload_qualification_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for pathway 1 end----------------------->
                        <!---------------------- approved documnets end ----------------------->
                        <!---------------------- declined documnets ----------------------->
                        
                        <?php
                            $stage_4_decline_css_docs = "display: none;";
                            if($stage_4->status == "Declined"){
                            $stage_4_decline_css_docs = "";    
                            }
                        ?>
                        
                        <tr id="s4_reason_tr_1_4" style="<?= $stage_4_decline_css_docs ?>">
                            <td>Upload Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_4_documents as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 45) { // Outcome Letter
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s4_show_upload_file('#s4_dec_path_1')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;">
                                        <input name="outcome_file" <?php if ($Outcome_Letter_available) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="s4_dec_path_1" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_path_s4" onclick="s4_auto_file_upload('s4_dec_path_1','outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>

                            </td>
                        </tr>
                        <tr id="s4_reason_tr_2_4" style="<?= $stage_4_decline_css_docs ?>">
                            <td>Upload Statement of Reasons</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_4_documents as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 46) { // Outcome Letter
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s4_show_upload_file('#s4_dec_Statement_of_Reasons')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;">

                                        <input name="reason_file" <?php if ($Outcome_Letter_available) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="s4_dec_Statement_of_Reasons" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_Statement_of_Reasons_s4" onclick="s4_auto_file_upload('s4_dec_Statement_of_Reasons','reason_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- declined documnets end ----------------------->
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn_green_yellow" id="s4_update" name="s4_update" disabled>Update</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>

    function enable_location_edit_btn_stage_4(){
	$('#prefered_location_edit_stage_4').show();
	$('#preference_location_stage_4').attr('disabled',false);
	 	var location=$('#preference_location_stage_4').val();

	$('#preference_location_edit_enable_stage_4').hide();

}

function disable_location_edit_btn_stage_4(){
	$('#prefered_location_edit_stage_4').hide();
	$('#preference_location_stage_4').attr('disabled',true);
	$('#preference_location_edit_enable_stage_4').show();
	var location=$('#preference_location_stage_4').val();

}

function update_prefered_location_stage_4(){
 	var location=$('#preference_location_stage_4').val();
 	var real_location=$('#original_location_stage_4').val();
 	if(location == real_location){
 		   $('#prefered_location_edit_stage_4').hide();
 		   

 	}else{
 		  $('#prefered_location_edit_stage_4').show();
 	}

 		$('.online_docs').hide();
 
 	$('#preference_location_edit_enable_stage_4').hide();

}

  function enable_comment_edit_btn(){
	//$('#comment_edit_enable').show();
	$('#comment_input_4').attr('disabled',false);
	$('#comment_edit_disable').hide();

}

function disable_comment_edit_btn(){
	$('#comment_edit_enable').hide();
	$('#comment_input_4').attr('readonly',true);
	$('#comment_edit_disable').show();

}
  function comment_change(){
  		var original_comment=$('#preference_comment').val();

  	 	var comment=$('#comment_input_4').val();
  	 	if(comment!="" || comment!=" " || comment != original_comment){
  	 		  $('#comment_edit_enable').show();

  	 	}


  }

 

</script>
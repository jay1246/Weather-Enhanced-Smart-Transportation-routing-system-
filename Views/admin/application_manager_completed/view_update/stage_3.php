
<div class="accordion" id="flip-view_stage_3">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed text-green text-center" type="button" data-bs-toggle="collapse" data-bs-target="#stage_3" aria-expanded="false" aria-controls="stage_3" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Stage 3 - Technical Interview
            </button>
        </h2>

        <div id="stage_3" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#flip-view_stage_3">
            <div class="accordion-body">
                <form action="" id="stage_3_change_status" method="post">
                    <table class="table table-striped border table-hover">
                        <tr>
                            <td width="30%">
                                <b> Current Status
                                </b>
                            </td>
                            <td class="w-25">
                                <b> <?= $stage_3->status ?> </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Date Submitted </td>
                            <td class="w-25">
                                <?php if (!empty($stage_3->submitted_date) && $stage_3->submitted_date != "0000-00-00 00:00:00" && $stage_3->submitted_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_3->submitted_date)); ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if (!empty($stage_3->lodged_date) and $stage_3->lodged_date != "0000-00-00 00:00:00") { ?>
                        <?php $session= session();
                        if($session){
                        ?>
                        
                            <tr>
                                <td>Date Lodged </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3->lodged_date) && $stage_3->lodged_date != "0000-00-00 00:00:00" && $stage_3->lodged_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3->lodged_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo ($stage_3->lodged_date) ? date('d/m/Y  H:i:s', strtotime($stage_3->lodged_date)) : ''; ?> -->
                                </td>
                            </tr>
                            <?php } ?>
                        <?php }
                        if (!empty($stage_3->scheduled_date) && $stage_3->scheduled_date != "0000-00-00 00:00:00") {
                        ?>
                        <tr>
                            <td>Date Scheduled </td>
                            <td class="w-25">
                                <?php if (!empty($stage_3->scheduled_date) && $stage_3->scheduled_date != "0000-00-00 00:00:00" && $stage_3->scheduled_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_3->scheduled_date)); ?>
                                <?php } ?>
                                <!-- <?php echo ($stage_3->scheduled_date) ? date('d/m/Y  H:i:s', strtotime($stage_3->scheduled_date)) : ''; ?> -->
                            </td>
                        </tr>
                        <?php
                        }
                         if (!empty($stage_3_cancle_booking)) {
                        ?>
                        <tr>
                            <td>Date Cancelled </td>
                            <td class="w-25">
                                <?php if (!empty($stage_3_cancle_booking->interview_cancle_date) && $stage_3_cancle_booking->interview_cancle_date != "0000-00-00 00:00:00" && $stage_3_cancle_booking->interview_cancle_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_3_cancle_booking->interview_cancle_date)); ?>
                                <?php } ?>
                                <!-- <?php echo ($stage_3_cancle_booking->interview_cancle_date) ? date('d/m/Y  H:i:s', strtotime($stage_3_cancle_booking->interview_cancle_date)) : ''; ?> -->
                            </td>
                        </tr>
                        <?php
                        }
                        if ($stage_3->status == 'Approved') { ?>
                            <tr>
                                <td>Date Approved </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3->approved_date) && $stage_3->approved_date != "0000-00-00 00:00:00" && $stage_3->approved_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3->approved_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }

                        if ($stage_3->status == 'Declined') { ?>
                            <tr>
                                <td>Date Declined </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3->declined_date) && $stage_3->declined_date != "0000-00-00 00:00:00" && $stage_3->declined_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3->declined_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                        if ($stage_3->status == 'Withdrawn') { ?>
                            <tr>
                                <td>Date Withdrawn </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3->withdraw_date) && $stage_3->withdraw_date != "0000-00-00 00:00:00" && $stage_3->withdraw_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3->withdraw_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Change Status</td>
                            <?php
                            $check = '';
                            $session = session();
                            if ($stage_3->status == "Submitted") {
                                $log_active_3 = $pro_active_3 = "";
                                $log_select_3 = $pro_select_3 = $app_select_3 = $dec_select_3 = $with_select_3 = $sch_select_3 = $con_select_3 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }
                                $log_active_3 =  $app_active_3 = $dec_active_3 = $with_active_3 = $sch_active_3 = $con_active_3 = $disabled;
                            } else if ($stage_3->status == "Lodged") {
                                $log_select_3 = "";
                                $pro_select_3 = $app_select_3 = $dec_select_3 = $with_select_3 = $sch_select_3 = $con_select_3 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }

                                $with_active_3 =   $log_active_3 = $app_active_3 = $dec_active_3 = $with_active_3 = $sch_active_3 = $con_active_3 =  $pro_active_3 = $disabled;
                                // }else if($stage_3->status=="In Progress"){
                                //     $log_select_3 ="";
                                //     $pro_select_3 =  $dec_select_3 = $with_select_3 = $sch_select_3 = $con_select_3=  $app_select_3="";
                                //     $pro_active_3 = $log_active_3 = $app_active_3  = $sch_active_3 = $con_active_3 =  $dec_active_3 = $with_active_3 = "disabled";
                            } else if ($stage_3->status == "Scheduled") {
                                $sch_select_3 = "";
                                $dec_active_3 = $with_active_3 = "";
                                $pro_select_3 = $app_select_3 = $dec_select_3 = $log_select_3 = $sch_active_3 = $con_select_3 = $with_select_3 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }

                                $with_active_3 =  $log_active_3 = $app_active_3  = $pro_active_3 = $con_active_3 =  $dec_active_3 = $with_active_3 =  $disabled;
                            } else if ($stage_3->status == "Conducted") {
                                $app_select_3 = "";
                                $dec_active_3 = $with_active_3 = $con_active_3 = $app_active_3 = "";
                                $pro_select_3 = $dec_select_3 = $log_select_3 = $sch_active_3 = $with_select_3 = $sch_select_3 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }

                                $with_active_3 =  $log_active_3 =  $pro_active_3 = $sch_select_3  = $con_select_3 = $disabled;
                            } else if ($stage_3->status == "Approved") {
                                $app_select_3 = "";
                                $dec_active_3 = $with_active_3 = "";
                                $pro_select_3 = $log_select_3 = $dec_select_3 = $with_select_3 = $sch_select_3 = $con_select_3 = "";
                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }


                                $with_active_3 =    $log_active_3 = $app_active_3 = $pro_active_3  = $sch_active_3 = $con_active_3 = $disabled;
                            } else if ($stage_3->status == "Declined") {
                                $dec_select_3 = "";
                                $dec_active_3 = $with_active_3 =  $log_active_3 = "";
                                $pro_select_3 = $app_select_3 = $log_select_3 = $with_select_3 = $sch_select_3 = $con_select_3 =  "";

                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }



                                $with_active_3 =  $pro_active_3  = $sch_active_3 = $con_active_3 = $app_active_3 =  $disabled;
                            } else if ($stage_3->status == "Withdrawn") {
                                $with_select_3 = "";
                                $dec_active_3 = $with_active_3 = $log_active_3 = "";
                                $pro_select_3 = $app_select_3 = $dec_select_3 = $log_select_3 = $sch_select_3 = $con_select_3 = "";


                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }




                                $with_active_3 =    $con_active_3 = $app_active_3 = $pro_active_3 = $sch_active_3 =  $disabled;
                            } else {
                                $with_select_3 = "";
                                $dec_active_3 = $with_active_3 = $log_active_3 = "";
                                $pro_select_3 = $app_select_3 = $dec_select_3 = $log_select_3 = $sch_select_3 = $con_select_3 = "";


                                $disabled = "disabled";
                                if ($session->admin_account_type == "admin") {
                                    $disabled = "";
                                    $sch_select_3 = $con_active_3 = $con_select_3 = $sch_active_3 = "disabled";
                                }


                                $with_active_3 =    $con_active_3 = $app_active_3 = $pro_active_3 = $sch_active_3 =  $disabled;
                            }
                            $check .= 'disabled';
                            //
                            if($session->admin_account_type == "head_office"){
                                $with_active_3 =    $con_active_3 = $app_active_3 = $pro_active_3 = $sch_active_3 = $dec_active_3= "disabled";    
                            }
                            
                            $stage__cheking = find_one_row("stage_1_occupation","pointer_id", $stage_3->pointer_id);
                            if($stage__cheking->pathway == "Pathway 1"){
                                if($stage__cheking->occupation_id == 7 || $stage__cheking->occupation_id == 18){
                                    if($session->admin_account_type == "head_office"){
                                        $dec_active_3 = $app_active_3 = "";    
                                    }
                                }
                            }
                            
                            
                            ?>
                            <td class="w-25">
                                <select required class="form-select mb-3 stg_3_status_select" aria-label="Default select example" name="status" id="stage_3_status_drop" onchange="change_status_3(this.value)">
                                    <option selected disabled>Select Status</option>
                                    <option id="lodged_3" value="Lodged" <?= $log_active_3 . $log_select_3 ?>>Lodged</option>
                                    <!-- <option id="in_progress_3" value="In Progress" <=$pro_active_3.$pro_select_3?> >In Progress</option> -->
                                    <option id="scheduled_3" value="Scheduled" disabled <?= $sch_active_3 . $sch_select_3 ?>>Scheduled</option>
                                    <option id="conducted_3" value="Conducted" disabled <?= $sch_active_3 . $con_select_3 ?>>Conducted</option>
                                    <option id="approved_3" value="Approved">Approved</option>
                                    <option id="declined_3" value="Declined" <?= $dec_active_3 . $dec_select_3 ?>>Declined</option>
                                    <option id="Withdrawn_3" value="Withdrawn" <?= $with_active_3 . $with_select_3 ?>>Withdrawn</option>
                                </select>
                                <input type="hidden" name="pointer_id" value="<?= $stage_3->pointer_id ?>">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="stage_3_id" value="<?= $stage_3->id ?>">

                            </td>
                        </tr>
                          <input type="hidden" id="actype" value="<?=$session->admin_account_type?>">    



                            <?php 
                            
                            if ($session->admin_account_type == "admin") { ?>
                        <tr>
                            <?php $preference_location= $stage_3->preference_location; ?> 
                            <td>Preferred Location</td>
                            <td>
                                <div class="row">
                                <div class="col-md-11">
                                    
                                <select id="preference_location" class="form-select mb-3 stg_3_status_select" onchange="update_prefered_location();" name="preference_location" disabled="true" style="width:100%">

                            <option value="" selected> Select Location</option>

                            <?php foreach ($location as $key => $value) {  ?>

                                <?php if ($key != "Online") {  ?>

                                    <optgroup label="<?= $key ?>">

                                        <?php foreach ($value as $key_ => $value_) {

                                            $selected = "";

                                            if ($preference_location == $value_['city_name']) {

                                                $selected = "selected";

                                            }  ?>


                                            <option value="<?= $value_['city_name'] ?>" <?= $selected ?>><?= $value_['city_name'] ?></option>

                                        <?php  }  ?>
                                    </optgroup>

                                    <?php  }  ?>

                                <?php  }  ?>



                                 <?php foreach ($location as $key => $value) {  ?>

                                <?php if ($key == "Online") {  ?>

                                    <optgroup label="<?= $key ?>">

                                        <?php foreach ($value as $key_ => $value_) {

                                            $selected = "";

                                            if ($preference_location == $value_['city_name']) {

                                                $selected = "selected";

                                            }  ?>


                                            <option value="<?= $value_['city_name'] ?>" <?= $selected ?>><?= $value_['city_name'] ?></option>

                                        <?php  }  ?>
                                    </optgroup>

                                    <?php  }  ?>

                                <?php  }  ?>

                           

                                                                                                  
                        </select>
                        </div>
                        <div class="col-md-1">
                             <!-- <a href="javascript:void(0)" id="preference_location_edit_enable" style="float: left" class="btn btn-sm btn_green_yellow " onclick="return enable_location_edit_btn();"><i class="bi bi-pencil-square" ></i></a> -->

                             <!-- <a href="javascript:void(0)" id="stage_3_prefered_location_edit" style="display: none" class="btn btn-sm btn_green_yellow " onclick="return disable_location_edit_btn();"><i class="bi bi-check-circle" ></i> -->
                        </a>
                        </div>
                        
                    </div>
                    </td>
                        </tr>
                          <?php }?>
                        
 								<?php //echo "<pre>";
 								//print_r($stage_3); ?>

                        	<div class="form-group" id="online_docs" >

                        <tr  class="online_docs" style="display: none">
                        	<td><label>Time Zone</label></td>
                       	<td>   
                       	    <!--<div class="col-12 mt-2" id="select_new_time_zone_div">-->
                            <!--                <b> <label>Applicant Location <span class="text-danger">*</span></label> </b>-->
                            <!--                <select id="select_new_time_zone" name="time_zone" class="">-->
                            <!--                    <option value="">Select Time zone</option>-->
                                                <?php
                                                // foreach ($time_zone as $key => $get_na) {
                                                //     $zone_name = $get_na['zone_name'];
                                                //     echo '<option value="' . $zone_name . '">' . $zone_name . '</option>';
                                                // }
                                                ?>
                                            <!--</select>-->
                            <!--            </div>-->

                                      <!-- Aish Working -->
                       	    <!-- form-control -->
                       	 <select name="time_zone" id="time_zone" name="time_zone" style="border-radius: 2px;">
                                                                    <option value="">Select Time zone</option>
                                                                    <?php
                                                                    foreach ($time_zone as $key => $get_na) {
                                                                        $zone_name = $get_na['zone_name'];
                                                                        $select = "";
                                                                        if (trim($stage_3->time_zone) == trim($zone_name)) {
                                                                            $select = "selected";
                                                                        }

                                                                        echo '<option ' . $select . ' value="' . $zone_name . '">' . $zone_name . '</option>';
                                                                    }
                                                                    ?>
                                                               </select>
                  		
                        	</td>
                        </tr>
                       
                    </div>
                    
                            <input type="hidden" name="___stage_3_status" id="___stage_3_status" value="<?= $stage_3->status ?>">
                    	    <input type="hidden" name="___exemption_form" id="___exemption_form" value="<?= $stage_3->exemption_form ?>">
                    	    <input type="hidden" name="___pathway" id="___pathway" value="<?= $s1_occupation->pathway ?>">
                            <input type="hidden" name="__occupation" id="__occupation" value="<?= $s1_occupation->occupation_id ?>">
                             <?php 
                            $onshore__user = "";
                            $stage_1_usi_avetmiss = find_one_row('stage_1_usi_avetmiss', 'pointer_id', $stage_3->pointer_id);     
                            if($stage_1_usi_avetmiss->currently_have_usi=='yes'){
                                $onshore__user = "yes";
                            }
                         ?>
                         <input type="hidden" name="__onshore_user" id="__onshore_user" value="<?= $onshore__user ?>">
                             
                        <?php 
                        // if ($stage_3->status == "Submitted")
                        if ($stage_3->status == "Submitted" && $stage_3->exemption_yes_no=="no")
                        {
                            
                            $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$stage_3->pointer_id);
                            
                            $excemtion_label__ = "Exemption Form";
                            $required_id_exemption_form = 43;
                            if($stage_1_usi_avetmiss->currently_have_usi=='yes'){
                                $type__of__label = "";
                                $check__user__ = find_one_row('application_pointer','id',$stage_3->pointer_id);
                                if($check__user__){
                                    $check__user__1 = find_one_row('user_account','id',$check__user__->user_id);
                                    $type__of__label = $check__user__1->account_type;
                                }
                                
                                $excemtion_label__ = $type__of__label." TI Declaration";
                                    
                                $required_id_exemption_form = 55;
                            }
                            
                        ?>
                        <tr class="online_docs" style="display: none">
                        	<td><label><?= $excemtion_label__ ?></label></td>
                        	<td>
                   			<?php if($stage_3->exemption_form){
                   			    $documents_exception__ = find_one_row_3_field("documents","pointer_id", $pointer_id, "required_document_id", $required_id_exemption_form, "stage", "stage_3");
                   			  
                   			$document_full_name_ex = $document_path_ex = $document_name_ex = ""; 
                            if($documents_exception__){
                                $document_full_name_ex = (isset($documents_exception__->document_name) ? $documents_exception__->document_name : "");
                                $document_path_ex = (isset($documents_exception__->document_path) ? $documents_exception__->document_path : "");
                                $document_name_ex = (isset($documents_exception__->name) ? $documents_exception__->name : "");
                            }
                   			?>
                   				<a href="<?php echo base_url($document_path_ex).'/'.$document_full_name_ex?>" target="_blank"><?php echo $document_name_ex; ?></a>   <!--<a href="" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>  -->
                                   <a onclick="delete_exemption_file();" class="btn btn-sm btn-danger ml-2">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                   			<?php } ?>


							<?php if(!$stage_3->exemption_form){ ?>
                                    <div class="row">
                                        <div class="col-11">
                                            <input name="exemption_file" id="exemption_file" type="file" class="form-control" data-max-size="32154" accept=".pdf">
                                            <input name="pointer_id" type="hidden" class="form-control" value="<?= $pointer_id ?>">
                                        </div>
                                        <div class="col-1 my-auto">
                                            <button type="button" class="btn btn-sm btn_green_yellow" onclick="upload_exemption();" style="float:left"> <i class="bi bi-upload"></i> </button>
                                        </div>
                                    </div>
                   			<?php } ?>
	                        </td>
                        </tr>
                        <?php 
                        }
                        ?>
                        <tr id="comment_tr_3">
                            <td> Comments </td>
                            <td class="w-20">
                                <div style="display: flex;" class="position-relative">
                                    <textarea class="form-control" readonly id="comment_input_3" name="comment" rows="3"><?php
                                                                                                                            if (!empty($stage_3->preference_comment)) {
                                                                                                                                echo $stage_3->preference_comment;
                                                                                                                            };
                                                                                                                            ?></textarea>
                                    <?php 
                                    // Comment Hide mohsin
                                    if($session->admin_account_type == "admin"){
                                        ?>
                                        
                                        <!-- <a href="javascript:void(0)" id="stage_3_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInputs3('#comment_input_3')">
                                        <i class="bi bi-pencil-square"></i> </i></a> -->
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for both pathway ----------------------->
                        <tr id="appr_tr_1_3" style="display: none;">
                            <td>Upload Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_3_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 25) { // Outcome Letter
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
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="show_upload_file('#appr_path')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <div style="display: flex;">
                                        <input name="upload_outcome_file" <?php if ($Outcome_Letter_available) {
                                                                                echo 'style="display: none;"';
                                                                            } ?> id="appr_path" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_appr_path " onclick="auto_file_upload('appr_path','upload_outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for pathway 1 ----------------------->
                        <tr id="appr_tr_2_3" style="display: none;">
                            <td>Upload Qualifications Document</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_3_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 26) { // Upload Qualifications
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
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="show_upload_file('#appr_path_1')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <div style="display: flex;">
                                        <input name="upload_qualification_file" <?php if ($Outcome_Letter_available) {
                                                                                    echo 'style="display: none;"';
                                                                                } ?> id="appr_path_1" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload" onclick="auto_file_upload('appr_path_1','upload_qualification_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for pathway 1 end----------------------->
                        <!---------------------- approved documnets end ----------------------->
                        <!---------------------- declined documnets ----------------------->
                        <tr id="reason_tr_1_3" style="display: none;">
                            <td>Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_3_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 23) { // Outcome Letter
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
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="show_upload_file('#dec_path_1')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;">
                                        <input name="outcome_file" <?php if ($Outcome_Letter_available) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="dec_path_1" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_path_1" onclick="auto_file_upload('dec_path_1','outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>

                            </td>
                        </tr>
                        <tr id="reason_tr_2_3" style="display: none;">
                            <td>Statement of Reasons</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                foreach ($stage_3_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 24) { // Outcome Letter
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
                                                <!-- <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="show_upload_file('#dec_Statement_of_Reasons')"><i class="bi bi-pencil-square"></i></a> -->
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;">

                                        <input name="reason_file" <?php if ($Outcome_Letter_available) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="dec_Statement_of_Reasons" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_Statement_of_Reasons" onclick="auto_file_upload('dec_Statement_of_Reasons','reason_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- declined documnets end ----------------------->
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn_green_yellow" id="s3_update" name="s3_update" disabled>Update</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function enable_location_edit_btn(){
	$('#stage_3_prefered_location_edit').show();
	$('#preference_location').attr('disabled',false);
	 	var location=$('#preference_location').val();

		if(location=="Online (Via Zoom)"){
 		$('.online_docs').show();
 		$('#time_zone').attr('disabled',false);

 	}
 
	$('#preference_location_edit_enable').hide();

}

function disable_location_edit_btn(){
	$('#stage_3_prefered_location_edit').hide();
	$('#preference_location').attr('disabled',true);
	$('#preference_location_edit_enable').show();
	var location=$('#preference_location').val();

		if(location=="Online (Via Zoom)"){
 		$('.online_docs').show();
 		//$('#time_zone').attr('disabled',true);

 	}
 

}

 function update_prefered_location(){
 	var location=$('#preference_location').val();
 	var real_location=$('#original_location').val();
 	if(location == real_location){
 		   $('#stage_3_prefered_location_edit').hide();
 		   

 	}else{
 		  $('#stage_3_prefered_location_edit').show();
 	}

 	if(location=="Online (Via Zoom)"){
 		$('.online_docs').show();
 		$('#time_zone').attr('disabled',false);

 	}
 	else{
 		$('.online_docs').hide();
 	}
 	$('#preference_location_edit_enable').hide();

}

  function enable_comment_edit_btn(){
	//$('#comment_edit_enable').show();
	$('#comment_input_3').attr('disabled',false);
	$('#comment_edit_disable').hide();

}

function disable_comment_edit_btn(){
	$('#comment_edit_enable').hide();
	$('#comment_input_3').attr('readonly',true);
	$('#comment_edit_disable').show();

}
  function comment_change(){
  		var original_comment=$('#preference_comment').val();

  	 	var comment=$('#comment_input_3').val();
  	 	if(comment!="" || comment!=" " || comment != original_comment){
  	 		  $('#comment_edit_enable').show();

  	 	}


  }

    function upload_exemption(){
    //alert("Hii");
   // return;
   if($("#exemption_file").val()!=""){
        var time_zone=$('#time_zone').val();
   	  var file_data = $("#exemption_file").prop("files")[0]; // Getting the properties of file from file field
      var form_data = new FormData(); // Creating object of FormData class
      form_data.append("exemption_file", file_data) // Appending parameter named file with properties of file_field to form_data
      form_data.append("pointer_id", "<?php echo $stage_3->pointer_id; ?>") // Adding extra parameters to form_data
      form_data.append("time_zone", time_zone);
      console.log(form_data);
      //  var formData = new FormData(document.getElementById("upload_exemption_form"));
        $('#cover-spin').show(0);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/application_manager/upload_exemption_file") ?>",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                //data = JSON.parse(data);
                console.log(data);
                if (data) {

                    window.location.reload();
                } else {
                    alert("Something went wrong!!");
                }
            }
        });
   }else{
       alert("Select File to upload")
   }

    }


     function delete_exemption_file(){

        custom_alert_popup_show(header = '', body_msg = "Are you sure that you want to delete this file ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_exemption_btn');
        
        // return;
    //   $("#delete_exemption_btn").click(function() {
    //         if (custom_alert_popup_close('delete_exemption_btn')) {
        $("#delete_exemption_btn").click(function(){
            
                $('#cover-spin').show(0);
            $.ajax({
                method: "GET",
                url: "<?php echo base_url('admin/application_manager/delete_exemption_file').'/'.$stage_3->pointer_id; ?>",
                processData: false,
                contentType: false,
                success: function(data) {
                    //data = JSON.parse(data);
                    console.log(data);
                    if (data) {
    
                        window.location.reload();
                    } else {
                        alert("Something went wrong!!");
                    }
                }
            });
        });
//            }

//});
       
    }
    
    
</script>

<div class="accordion" id="flip-view_stage_3_reassessment">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed text-green text-center" type="button" data-bs-toggle="collapse" data-bs-target="#stage_3_reassessment" aria-expanded="false" aria-controls="stage_3_reassessment" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Stage 3 - Technical Interview (Reassessment)
            </button>
        </h2>

        <div id="stage_3_reassessment" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#flip-view_stage_3_reassessment">
            <div class="accordion-body">
                <form action="" id="stage_3_reassessment_change_status" method="post">
                    <table class="table table-striped border table-hover">
                        <tr>
                            <td width="30%">
                                <b> Current Status
                                </b>
                            </td>
                            <td class="w-25">
                                <b> <?= $stage_3_reassessment->status ?> </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Date Submitted </td>
                            <td class="w-25">
                                <?php if (!empty($stage_3_reassessment->submitted_date) && $stage_3_reassessment->submitted_date != "0000-00-00 00:00:00" && $stage_3_reassessment->submitted_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_3_reassessment->submitted_date)); ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if (!empty($stage_3_reassessment->lodged_date) and $stage_3_reassessment->lodged_date != "0000-00-00 00:00:00") { ?>
                        <?php $session= session();
                        if($session){
                        ?>
                        
                            <tr>
                                <td>Date Lodged </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3_reassessment->lodged_date) && $stage_3_reassessment->lodged_date != "0000-00-00 00:00:00" && $stage_3_reassessment->lodged_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3_reassessment->lodged_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo ($stage_3_reassessment->lodged_date) ? date('d/m/Y  H:i:s', strtotime($stage_3_reassessment->lodged_date)) : ''; ?> -->
                                </td>
                            </tr>
                            <?php } ?>
                        <?php }
                        if (!empty($stage_3_reassessment->scheduled_date) && $stage_3_reassessment->scheduled_date != "0000-00-00 00:00:00") {
                        ?>
                        <tr>
                            <td>Date Scheduled </td>
                            <td class="w-25">
                                <?php if (!empty($stage_3_reassessment->scheduled_date) && $stage_3_reassessment->scheduled_date != "0000-00-00 00:00:00" && $stage_3_reassessment->scheduled_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_3_reassessment->scheduled_date)); ?>
                                <?php } ?>
                                <!-- <?php echo ($stage_3_reassessment->scheduled_date) ? date('d/m/Y  H:i:s', strtotime($stage_3_reassessment->scheduled_date)) : ''; ?> -->
                            </td>
                        </tr>
                        <?php
                        }
                        if (!empty($stage_3_cancle_booking_reass)) {
                        ?>
                        <tr>
                            <td>Date Cancelled </td>
                            <td class="w-25">
                                <?php if (!empty($stage_3_cancle_booking_reass->interview_cancle_date) && $stage_3_cancle_booking_reass->interview_cancle_date != "0000-00-00 00:00:00" && $stage_3_cancle_booking_reass->interview_cancle_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_3_cancle_booking_reass->interview_cancle_date)); ?>
                                <?php } ?>
                                <!-- <?php echo ($stage_3_cancle_booking_reass->interview_cancle_date) ? date('d/m/Y  H:i:s', strtotime($stage_3_cancle_booking_reass->interview_cancle_date)) : ''; ?> -->
                            </td>
                        </tr>
                        <?php
                        }
                        if ($stage_3_reassessment->status == 'Approved') { ?>
                            <tr>
                                <td>Date Approved </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3_reassessment->approved_date) && $stage_3_reassessment->approved_date != "0000-00-00 00:00:00" && $stage_3_reassessment->approved_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3_reassessment->approved_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }

                        if ($stage_3_reassessment->status == 'Declined') { ?>
                            <tr>
                                <td>Date Declined </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3_reassessment->declined_date) && $stage_3_reassessment->declined_date != "0000-00-00 00:00:00" && $stage_3_reassessment->declined_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3_reassessment->declined_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                        if ($stage_3_reassessment->status == 'Withdrawn') { ?>
                            <tr>
                                <td>Date Withdrawn </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_3_reassessment->withdraw_date) && $stage_3_reassessment->withdraw_date != "0000-00-00 00:00:00" && $stage_3_reassessment->withdraw_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_3_reassessment->withdraw_date)); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Change Status</td>
                            <?php
                            $check = '';
                            $session = session();
                            if ($stage_3_reassessment->status == "Submitted") {
                                $log_active_3_reass = $pro_active_3_reass = "";
                                $log_select_3_reass = $pro_select_3_reass = $app_select_3_reass = $dec_select_3_reass = $with_select_3_reass = $sch_select_3_reass = $con_select_3_reass = "";
                                $disabled = "disabled";
                                
                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }
                                
                                $log_select_3_reass = $log_active_3_reass =  $app_active_3_reass = $dec_active_3_reass = $with_active_3_reass = $sch_active_3_reass = $con_active_3_reass = $disabled;
                                $log_select_3_reass = $log_active_3_reass = "";
                                
                            } else if ($stage_3_reassessment->status == "Lodged") {
                                $log_select_3_reass = "";
                                $pro_select_3_reass = $app_select_3_reass = $dec_select_3_reass = $with_select_3_reass = $sch_select_3_reass = $con_select_3_reass = "";
                                $disabled = "disabled";
                                
                                
                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }
                                       
                                $app_select_3_reass = $dec_select_3_reass = $with_active_3_reass =   $log_active_3_reass = $app_active_3_reass = $dec_active_3_reass = $with_active_3_reass = $sch_active_3_reass = $con_active_3_reass =  $pro_active_3_reass = $disabled;
                        

                            } else if ($stage_3_reassessment->status == "Scheduled") {
                                $sch_select_3_reass = "";
                                $dec_active_3_reass = $with_active_3_reass = "";
                                $pro_select_3_reass = $app_select_3_reass = $dec_select_3_reass = $log_select_3_reass = $sch_active_3_reass = $con_select_3_reass = $with_select_3_reass = "";
                                $disabled = "disabled";


                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }
                                
                                
                                $app_select_3_reass = $dec_select_3_reass = $with_active_3_reass =  $log_active_3_reass = $app_active_3_reass  = $pro_active_3_reass = $con_active_3_reass =  $dec_active_3_reass = $with_active_3_reass =  $disabled;
                                
                                
                                
                            } else if ($stage_3_reassessment->status == "Conducted") {
                                $app_select_3_reass = "";
                                $dec_active_3_reass = $with_active_3_reass = $con_active_3_reass = $app_active_3_reass = "";
                                $pro_select_3_reass = $dec_select_3_reass = $log_select_3_reass = $sch_active_3_reass = $with_select_3_reass = $sch_select_3_reass = "";
                                $disabled = "disabled";

                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }
                                
                                $with_active_3_reass =  $log_active_3_reass =  $pro_active_3_reass = $sch_select_3_reass  = $con_select_3_reass = $disabled;
                                
                                
                                
                            } else if ($stage_3_reassessment->status == "Approved") {
                                $app_select_3_reass = "";
                                $dec_active_3_reass = $with_active_3_reass = "";
                                $pro_select_3_reass = $log_select_3_reass = $dec_select_3_reass = $with_select_3_reass = $sch_select_3_reass = $con_select_3_reass = "";
                                $disabled = "disabled";


                                
                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }
                                
                                $with_active_3_reass =  $log_active_3_reass = $app_active_3_reass = $pro_active_3_reass  = $sch_active_3_reass = $con_active_3_reass = $dec_select_3_reass = $app_select_3_reass = $disabled;
                                
                                


                            } else if ($stage_3_reassessment->status == "Declined") {
                                $dec_select_3_reass = "";
                                $dec_active_3_reass = $with_active_3_reass =  $log_active_3_reass = "";
                                $pro_select_3_reass = $app_select_3_reass = $log_select_3_reass = $with_select_3_reass = $sch_select_3_reass = $con_select_3_reass =  "";

                                $disabled = "disabled";
                                
                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }
                                
                                
                                $with_active_3_reass =  $pro_active_3_reass  = $sch_active_3_reass = $con_active_3_reass = $app_active_3_reass = $log_select_3_reass = $app_select_3_reass = $dec_select_3_reass = $disabled;
                                


                            } else if ($stage_3_reassessment->status == "Withdrawn") {
                                $with_select_3_reass = "";
                                $dec_active_3_reass = $with_active_3_reass = $log_active_3_reass = "";
                                $pro_select_3_reass = $app_select_3_reass = $dec_select_3_reass = $log_select_3_reass = $sch_select_3_reass = $con_select_3_reass = "";


                                $disabled = "disabled";
                                
                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }


                                $with_active_3_reass =    $con_active_3_reass = $app_active_3_reass = $pro_active_3_reass = $sch_active_3_reass =  $disabled;
                                
                                


                            } else {
                                // $with_select_3_reass = "";
                                // $dec_active_3_reass = $with_active_3_reass = $log_active_3_reass = "";
                                // $pro_select_3_reass = $app_select_3_reass = $dec_select_3_reass = $log_select_3_reass = $sch_select_3_reass = $con_select_3_reass = "";


                                $disabled = "disabled";
                                if ($session->admin_id == "1") {
                                    $disabled = "";
                                    $sch_select_3_reass = $con_active_3_reass = $con_select_3_reass = $sch_active_3_reass = "disabled";
                                }


                                $with_active_3_reass =    $con_active_3_reass = $app_active_3_reass = $pro_active_3_reass = $sch_active_3_reass =  $disabled;
                            }
                            $check .= 'disabled';
                            //
                            if($session->admin_account_type == "head_office"){
                                $with_active_3_reass =    $con_active_3_reass = $app_active_3_reass = $pro_active_3_reass = $sch_active_3_reass = $dec_active_3= "disabled";    
                            }
                            
                            $stage__cheking = find_one_row("stage_1_occupation","pointer_id", $stage_3_reassessment->pointer_id);
                            if($stage__cheking->pathway == "Pathway 1"){
                                if($stage__cheking->occupation_id == 7 || $stage__cheking->occupation_id == 18){
                                    if($session->admin_account_type == "head_office"){
                                        $dec_active_3_reass = $app_active_3_reass = "";    
                                    }
                                }
                            }
                            
                            
                                // Withdrwala
                                if($session->admin_account_type == "admin"){
                                    $with_active_3_reass = $with_select_3_reass = "";
                                }
                                // END
                            
                            ?>
                            <td class="w-25">
                                <select required class="form-select mb-3 stg_3_status_select" aria-label="Default select example" name="status" id="stage_3_reass_status_drop" onchange="change_status_3_reassessment(this.value)">
                                    <option selected disabled>Select Status</option>
                                    <option id="lodged_3_reass" value="Lodged" <?= $log_active_3_reass ." ". $log_select_3_reass ?>>Lodged</option>
                                    <!-- <option id="in_progress_3_reass" value="In Progress" <=$pro_active_3.$pro_select_3?> >In Progress</option> -->
                                    <option id="scheduled_3_reass" value="Scheduled" disabled <?= $sch_active_3_reass ." ". $sch_select_3_reass ?>>Scheduled</option>
                                    <option id="conducted_3_reass" value="Conducted" disabled <?= $sch_active_3_reass ." ". $con_select_3_reass ?>>Conducted</option>
                                    <option id="approved_3_reass" value="Approved" <?= $app_active_3_reass ." ". $app_select_3_reass ?>>Approved</option>
                                    <option id="declined_3_reass" value="Declined" <?= $dec_active_3_reass ." ". $dec_select_3_reass ?>>Declined</option>
                                    <option id="Withdrawn_3_reass" value="Withdrawn" <?= $with_active_3_reass ." ". $with_select_3_reass ?>>Withdrawn</option>
                                </select>
                                <input type="hidden" name="pointer_id" value="<?= $stage_3_reassessment->pointer_id ?>">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="stage_3_r_id" value="<?= $stage_3_reassessment->id ?>">

                            </td>
                        </tr>
 <!--<tr  class="" style="">-->
 <!--                       	<td>     		<label>Exemption Form</label></td>-->
 <!--                       	<td>-->
 <!--                  			<?php if($stage_3_reassessment->exemption_form){ ?>-->
 <!--                  				<a href="<?php echo base_url('public/application/' . $pointer_id . '/stage_2/assessment_documents').'/'.$stage_3_reassessment->exemption_form?>"><?php echo $stage_3_reassessment->exemption_form; ?></a>-->
                   				   <!--<a href="" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>                                                   -->
                                            <!-- Delete  -->
 <!--                                  <a onclick="delete_exemption_file();" class="btn btn-sm btn-danger">-->
 <!--                                               <i class="bi bi-trash-fill"></i>-->
 <!--                                           </a>-->
                                         


 <!--                  			<?php } ?>-->


	<!--						<?php if(!$stage_3_reassessment->exemption_form){ ?>-->
 <!--                                   <div class="row">-->
 <!--                                       <div class="col-11">-->
 <!--                                           <input name="exemption_file" id="exemption_file" type="file" class="form-control" data-max-size="32154" accept=".pdf">-->
 <!--                                           <input name="pointer_id" type="hidden" class="form-control" value="<?= $pointer_id ?>">-->
 <!--                                       </div>-->
 <!--                                       <div class="col-1">-->
 <!--                                           <button type="button" class="btn btn-sm btn_green_yellow" onclick="upload_exemption();" style="float:left"> <i class="bi bi-upload"></i> </button>-->
 <!--                                       </div>-->
 <!--                                   </div>-->
 <!--                  			<?php } ?>-->
	<!--</td>-->
 <!--                       </tr>-->

                              
                            <?php if ($session->admin_account_type == "admin") { ?>
                        <tr>
                            <?php $preference_location= $stage_3_reassessment->preference_location; ?> 
                            <td>Preferred Location</td>
                            <td>
                                <div class="row">
                                <div class="col-md-11">
                                    
                                <select id="preference_location_r" class="form-select mb-3 stg_3_status_select" onchange="update_prefered_location_r();" name="preference_location" disabled="true" style="width:100%">

                            <option value="" selected> Select Location </option>

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
                             <a href="javascript:void(0)" id="preference_location_edit_enable_r" style="float: left" class="btn btn-sm btn_green_yellow " onclick="return enable_location_edit_btn_3_r();"><i class="bi bi-pencil-square" ></i></a>

                             <a href="javascript:void(0)" id="stage_3_reass_prefered_location_edit" style="display: none" class="btn btn-sm btn_green_yellow " onclick="return disable_location_edit_btn_3_r();"><i class="bi bi-check-circle" ></i>
                        </a>
                        </div>
                        
                    </div>
                    </td>
                        </tr>
                          <?php } ?>
 								<?php //echo "<pre>";
 								//print_r($stage_3_reassessment); ?>

                        	<div class="form-group" id="online_docs_r" >

                        <tr  class="online_docs_r" style="display: none">
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
                       	 <select name="time_zone" id="time_zone_r" name="time_zone" style="border-radius: 2px;">
                                                                    <option value="">Select Time zone</option>
                                                                    <?php
                                                                    foreach ($time_zone as $key => $get_na) {
                                                                        $zone_name = $get_na['zone_name'];
                                                                        $select = "";
                                                                        if (trim($stage_3_reassessment->time_zone) == trim($zone_name)) {
                                                                            $select = "selected";
                                                                        }

                                                                        echo '<option ' . $select . ' value="' . $zone_name . '">' . $zone_name . '</option>';
                                                                    }
                                                                    ?>
                                                               </select>
                  		
                        	</td>
                        </tr>
                       
                           <?php
                             
                           $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);  ?>
                              <?php if($stage_1_usi_avetmiss->currently_have_usi=='yes'){ 
                              
                              $user_id = find_one_row('application_pointer','id',$pointer_id)->user_id;
                              //agent data fetch
                              $agent=find_one_row('user_account','id',$user_id);
                              $acount_type=$agent->account_type;
                              if($acount_type == 'applicant'){
                                  $name="Applicant TI Declaration";
                              }else{
                                   $name="Agent TI Declaration";
                              }
                              
                              
                              
                              ?>
                               <tr class="online_docs_r" style="display:none">
                                	<?php if($stage_3_reassessment->status =='Submitted' && $stage_3_reassessment->preference_location !='Online (Via Zoom)'){ 
                                	
                                	?>
                          		<td><label> <?php echo $name; ?>      </label></td>
                          		<?php }  ?>
                        	<td>
							
                              <?php if($stage_3_reassessment->agent_applicant=='yes' && $stage_3_reassessment->preference_location !='Online (Via Zoom)'){
                                  
                                  
                   			    $documents_exception__ = find_one_row_3_field("documents","pointer_id", $pointer_id, "required_document_id", 55, "stage", "stage_3_R");
                   			  
                   			$document_full_name_ex = $document_path_ex = $document_name_ex = ""; 
                            if($documents_exception__){
                                 $documents_exception__->name=$name;
                                $document_full_name_ex = (isset($documents_exception__->document_name) ? $documents_exception__->document_name : "");
                                $document_path_ex = (isset($documents_exception__->document_path) ? $documents_exception__->document_path : "");
                                $document_name_ex = (isset($documents_exception__->name) ? $documents_exception__->name : "");
                            }
                   			?>
                   			<?php if($stage_3_reassessment->status =='Submitted'){ ?>
                   				<a href="<?php echo base_url($document_path_ex).'/'.$document_full_name_ex?>" target="_blank"><?php echo $document_name_ex; ?></a>   <!--<a href="" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>  -->
                                   <a onclick="delete_applicant_file();" class="btn btn-sm btn-danger ml-2">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                    <?php
                                    
                                    
                                    }  ?>
                                    
                   			<?php } ?>
                   			
	                        
	                       
                                   <?php if($stage_3_reassessment->agent_applicant== ''){  ?>
                          
                                         <?php if($stage_3_reassessment->status =='Submitted'){
                                             $required='required';
                                         }else{
                                               $required='';
                                         }
                                         
                                         
                                         ?>
                                    <div class="row">
                                        <div class="col-11">
                                            <input name="applicant_agent" id="applicant_agent" type="file" class="form-control" data-max-size="32154" accept=".pdf" <?=$required?>>
                                            <input name="pointer_id" type="hidden" class="form-control" value="<?= $pointer_id ?>">
                                        </div>
                                        <div class="col-1 my-auto">
                                            <button type="button" class="btn btn-sm btn_green_yellow" onclick="upload_applicant();" style="float:left"> <i class="bi bi-upload"></i> </button>
                                        </div>
                                    </div>
                   			
	                        </td>
	                        <?php } ?>
                        </tr>
                              
                          <?php }?>
                    
                    </div>
                    
                
                    
                    
                    
                        <tr id="comment_tr_3_reass">
                            <td> Comments </td>
                            <td class="w-20">
                                <div style="display: flex;" class="position-relative">
                                    <textarea class="form-control" readonly id="comment_input_3_reass" name="comment" rows="3"><?php
                                                                                                                            if (!empty($stage_3_reassessment->preference_comment)) {
                                                                                                                                echo $stage_3_reassessment->preference_comment;
                                                                                                                            };
                                                                                                                            ?></textarea>
                                    <?php 
                                    // Comment Hide mohsin
                                    if($session->admin_account_type == "admin"){
                                        ?>
                                        
                                        <a href="javascript:void(0)" id="stage_3_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInputs3('#comment_input_3_reass')">
                                        <i class="bi bi-pencil-square"></i> </i></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for both pathway ----------------------->
                        <tr id="appr_tr_1_3_reass" style="display: none;">
                            <td>Upload Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available_r = false;
                                foreach ($stage_3_reassessment_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 25) { // Outcome Letter
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available_r = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s3_r_show_upload_file('#appr_path_r')"><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <div style="display: flex;">
                                        <input name="upload_outcome_file" <?php if ($Outcome_Letter_available_r) {
                                                                                echo 'style="display: none;"';
                                                                            } ?> id="appr_path_r" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_appr_path_r" onclick="s3_r_auto_file_upload('appr_path_r','upload_outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for pathway 1 ----------------------->
                        <tr id="appr_tr_2_3_reass" style="display: none;">
                            <td>Upload Qualification Documents</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available_r = false;
                                foreach ($stage_3_reassessment_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 26) { // Upload Qualifications
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available_r = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s3_r_show_upload_file('#appr_path_1_r')"><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <div style="display: flex;">
                                        <input name="upload_qualification_file" <?php if ($Outcome_Letter_available_r) {
                                                                                    echo 'style="display: none;"';
                                                                                } ?> id="appr_path_1_r" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_r" onclick="s3_r_auto_file_upload('appr_path_1_r','upload_qualification_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- approved documnets for pathway 1 end----------------------->
                        <!---------------------- approved documnets end ----------------------->
                        <!---------------------- declined documnets ----------------------->
                        <tr id="reason_tr_1_3_reass" style="display: none;">
                            <td>Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available_r = false;
                                foreach ($stage_3_reassessment_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 23) { // Outcome Letter
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available_r = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s3_r_show_upload_file('#dec_path_1_r')"><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;">
                                        <input name="outcome_file" <?php if ($Outcome_Letter_available_r) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="dec_path_1_r" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_path_1_r" onclick="s3_r_auto_file_upload('dec_path_1_r','outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>

                            </td>
                        </tr>
                        <tr id="reason_tr_2_3_reass" style="display: none;">
                            <td>Statement of Reasons</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available_r = false;
                                foreach ($stage_3_reassessment_documents_vhp as $key => $value) { ?>
                                    <?php if ($value['required_document_id'] == 24) { // Outcome Letter
                                        $document_name = $value['document_name'];
                                        $document_path = $value['document_path'];
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $value['name'];
                                        $Outcome_Letter_available_r = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s3_r_show_upload_file('#dec_Statement_of_Reasons_r')"><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        <?php } ?>
                                    <?php  } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;">

                                        <input name="reason_file" <?php if ($Outcome_Letter_available_r) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="dec_Statement_of_Reasons_r" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_Statement_of_Reasons_r" onclick="s3_r_auto_file_upload('dec_Statement_of_Reasons_r','reason_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- declined documnets end ----------------------->
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn_green_yellow" id="s3_update" name="s3_update">Update</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function enable_location_edit_btn_3_r(){
	$('#stage_3_reass_prefered_location_edit').show();
	$('#preference_location_r').attr('disabled',false);
	 	var location=$('#preference_location_r').val();

		if(location=="Online (Via Zoom)"){
 		$('.online_docs_r').show();
 		$('#time_zone_r').attr('disabled',false);

 	}
 
	$('#preference_location_edit_enable_r').hide();

}

function disable_location_edit_btn_3_r(){
	$('#stage_3_reass_prefered_location_edit').hide();
	$('#preference_location_r').attr('disabled',true);
	$('#preference_location_edit_enable_r').show();
	var location=$('#preference_location_r').val();

		if(location=="Online (Via Zoom)"){
 		$('.online_docs_r').show();
 		//$('#time_zone').attr('disabled',true);

 	}
 

}

 function update_prefered_location_r(){
 	var location=$('#preference_location_r').val();
 	var real_location=$('#original_location').val();
 	if(location == real_location){
 		   $('#stage_3_reass_prefered_location_edit').hide();
 		   

 	}else{
 		  $('#stage_3_reass_prefered_location_edit').show();
 	}

 	if(location=="Online (Via Zoom)"){
 		$('.online_docs_r').show();
 		$('#time_zone_r').attr('disabled',false);

 	}
 	else{
 		$('.online_docs_r').hide();
 	}
 	$('#preference_location_edit_enable_r').hide();

}

  function enable_comment_edit_btn(){
	//$('#comment_edit_enable').show();
	$('#comment_input_3_reass').attr('disabled',false);
	$('#comment_edit_disable').hide();

}

function disable_comment_edit_btn(){
	$('#comment_edit_enable').hide();
	$('#comment_input_3_reass').attr('readonly',true);
	$('#comment_edit_disable').show();

}
  function comment_change(){
  		var original_comment=$('#preference_comment').val();

  	 	var comment=$('#comment_input_3_reass').val();
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
      form_data.append("pointer_id", "<?php echo $stage_3_reassessment->pointer_id; ?>") // Adding extra parameters to form_data
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
function upload_applicant(){
    //alert("Hii");
   // return;
   if($("#applicant_agent").val()!=""){
       
        var time_zone=$('#time_zone_r').val();
   	  var file_data = $("#applicant_agent").prop("files")[0]; // Getting the properties of file from file field
      var form_data = new FormData(); // Creating object of FormData class
      form_data.append("applicant_agent", file_data) // Appending parameter named file with properties of file_field to form_data
      form_data.append("pointer_id", "<?php echo $stage_3->pointer_id; ?>") // Adding extra parameters to form_data
      form_data.append("time_zone", time_zone);   
      console.log(form_data);
      //  var formData = new FormData(document.getElementById("upload_exemption_form"));
        $('#cover-spin').show(0);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/application_manager/upload_applicant__") ?>",
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
                url: "<?php echo base_url('admin/application_manager/delete_exemption_file').'/'.$stage_3_reassessment->pointer_id; ?>",
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
      function delete_applicant_file(){

        custom_alert_popup_show(header = '', body_msg = "Are you sure that you want to delete this file ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_exemption_btn');
        
        // return;
    //   $("#delete_exemption_btn").click(function() {
    //         if (custom_alert_popup_close('delete_exemption_btn')) {
        $("#delete_exemption_btn").click(function(){
            
                $('#cover-spin').show(0);
            $.ajax({
                method: "GET",
                url: "<?php echo base_url('admin/application_manager/delete_applicant_file').'/'.$stage_3_reassessment->pointer_id; ?>",
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
<div class="accordion mt-1" id="flip-view_stage_2">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed text-green text-center" type="button" data-bs-toggle="collapse" data-bs-target="#stage_2" aria-expanded="false" aria-controls="stage_2" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Stage 2 - Documentary Evidence
            </button>
        </h2>

        <div id="stage_2" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#flip-view_stage_2">
            <div class="accordion-body">
                <form action="" id="stage_2_change_status" method="post">
                    <table class="table table-striped border table-hover">
                        <tr>
                            <td width="30%">
                                <b> Current Status </b>
                            </td>
                            <td class="w-25">
                                <b> <?= $stage_2->status ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td>Date Submitted </td>
                            <td class="w-25">
                                <?php if (!empty($stage_2->submitted_date) || $stage_2->submitted_date != "0000-00-00 00:00:00" || $stage_2->submitted_date != null) { ?>
                                    <?php echo date('d/m/Y', strtotime($stage_2->submitted_date)); ?>
                                <?php } ?>
                                <!-- <?= date('d/m/Y  H:i:s', strtotime($stage_2->submitted_date)) ?> -->
                            </td>
                        </tr>
                        <?php $session= session();
                        if($session){
                        ?>
                        
                        <?php if (!empty($stage_2->lodged_date) && $stage_2->lodged_date != "0000-00-00 00:00:00") { ?>
                            <tr>
                                <td>Date Lodged </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_2->lodged_date) || $stage_2->lodged_date != "0000-00-00 00:00:00" || $stage_2->lodged_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->lodged_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo date('d/m/Y  H:i:s', strtotime($stage_2->lodged_date)); ?> -->
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($stage_2->in_progress_date) && $stage_2->in_progress_date != "0000-00-00 00:00:00") { ?>
                            <tr>
                                <td>Date In Progress</td>
                                <td class="w-25">
                                    <?php if (!empty($stage_2->in_progress_date) || $stage_2->in_progress_date != "0000-00-00 00:00:00" || $stage_2->in_progress_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->in_progress_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo date('d/m/Y', strtotime($stage_2->in_progress_date)); ?> -->
                                </td>
                            </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php if ($stage_2->status == 'Approved' || $stage_2->status == 'Closed') { ?>
                            <tr>
                                <td>Date Approved </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_2->approved_date) || $stage_2->approved_date != "0000-00-00 00:00:00" || $stage_2->approved_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->approved_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo date('d/m/Y  H:i:s', strtotime($stage_2->approved_date)); ?> -->
                                </td>
                            </tr>
                        <?php }
                        if ($stage_2->status == 'Expired') { ?>
                            <tr>
                                <td style="width: 30%;">Date Approved </td>
                                <td>
                                    <?php if (!empty($stage_2->approved_date) || $stage_2->approved_date != "0000-00-00 00:00:00" || $stage_2->approved_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->approved_date)); ?>
                                    <?php } ?>
                                    <!-- <?= date('d/m/Y  H:i:s', strtotime($stage_2->approved_date)); ?> -->
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Expired Date</td>
                                <td>

                                </td>
                            </tr>
                        <?php  }
                        if ($stage_2->status == 'Declined') { ?>
                            <tr>
                                <td>Date Declined </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_2->declined_date) || $stage_2->declined_date != "0000-00-00 00:00:00" || $stage_2->declined_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->declined_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo date('d/m/Y  H:i:s', strtotime($stage_2->declined_date)); ?> -->
                                </td>
                            </tr>
                        <?php }
                         if ($stage_2->status == 'Closed') { ?>
                            <tr>
                                <td>Date Closed </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_2->closed_date) || $stage_2->closed_date != "0000-00-00 00:00:00" || $stage_2->closed_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->closed_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo date('d/m/Y  H:i:s', strtotime($stage_2->closed_date)); ?> -->
                                </td>
                            </tr>
                        <?php }
                        if ($stage_2->status == 'Withdrawn') { ?>
                            <tr>
                                <td>Date Withdrawn </td>
                                <td class="w-25">
                                    <?php if (!empty($stage_2->withdraw_date) || $stage_2->withdraw_date != "0000-00-00 00:00:00" || $stage_2->withdraw_date != null) { ?>
                                        <?php echo date('d/m/Y', strtotime($stage_2->withdraw_date)); ?>
                                    <?php } ?>
                                    <!-- <?php echo date('d/m/Y  H:i:s', strtotime($stage_2->withdraw_date)); ?> -->
                                </td>
                            </tr>
                        <?php } ?>



                        <?php
                        $submit_btn_show = true;
                        $submit_select_show = true;
                        $check = '';
                        $session = session();
                        if ($stage_2->status == "Submitted") {
                            $log_active_2 = "";
                            $log_select_2 = $pro_select_2 = $app_select_2 = $dec_select_2 = $with_select_2 =  "";
                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            } else {
                                $submit_btn_show = false;
                                $submit_select_show = false;
                            }
                            $log_active_2 = $pro_active_2 = $app_active_2 = $dec_active_2 = $with_active_2 = $disabled;
                        } else if ($stage_2->status == "Lodged") {
                            $pro_select_2 = "";
                            $pro_select_2 = $app_select_2 = $dec_select_2 = $with_select_2 = $log_select_2 = $pro_active_2 = "";
                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            }
                            $log_active_2 = $app_active_2 = $dec_active_2 = $with_active_2 = $disabled;
                        } else if ($stage_2->status == "In Progress") {
                            $app_select_2 = "";
                            $dec_active_2 = $with_active_2 = "";
                            $pro_select_2 = $log_select_2 = $app_active_2 = $dec_select_2 = $with_select_2 =  "";
                            // $log_active_2 = $app_active_2 = $pro_active_2  = "disabled";
                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            }
                            $with_active_2 =   $log_active_2  = $pro_active_2  = $disabled;
                        } else if ($stage_2->status == "Approved") {
                            $app_select_2 = "";
                            $dec_active_2 = $with_active_2 = "";
                            $pro_select_2 = $log_select_2 = $dec_select_2 = $with_select_2 =  "";
                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            }
                            $dec_active_2 = $with_active_2 = $log_active_2 = $app_active_2 = $pro_active_2  = $disabled;
                        } else if ($stage_2->status == "Declined") {
                            $dec_select_2 = "";
                            $dec_active_2 = $with_active_2 = $log_active_2 = "";
                            $pro_select_2 = $app_select_2 = $log_select_2 = $with_select_2 =  "";
                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            } else {
                                $submit_btn_show = false;
                            }
                            $log_active_2 = $dec_active_2 = $with_active_2 = $log_active_2 = $app_active_2 = $pro_active_2  = $disabled;
                        } else if ($stage_2->status == "Withdrawn") {
                            $with_select_2 = "";
                            $dec_active_2 = $with_active_2 = $log_active_2 = "";
                            $pro_select_2 = $app_select_2 = $dec_select_2 = $log_select_2 =  "";
                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            } else {
                                $submit_btn_show = false;
                            }
                            $log_active_2 = $dec_active_2 = $with_active_2 = $log_active_2 = $app_active_2 = $pro_active_2  = $disabled;
                        }else {
                            $with_select_2 = "";
                            $dec_active_2 = $with_active_2 = $log_active_2 = "";
                            $pro_select_2 = $app_select_2 = $dec_select_2 = $log_select_2 =  "";

                            $disabled = "disabled";
                            if ($session->admin_account_type == "admin") {
                                $disabled = "";
                            }
                            $log_active_2 = $app_active_2 = $pro_active_2  =  $dec_active_2 = $with_active_2 =    $app_active_2 = $pro_active_2  = $disabled;
                        }
                        $check .= 'disabled';

                        ?>
                        <?php 
                     if ($session->admin_account_type == "admin") {
                         $noshow="";
                     }else{
                          $noshow="disabled";
                     }

                        //  if($stage_2->status == "Closed"){
                        //      $dsble='disabled';
                        //  }else{
                        //     $dsble=''; 
                        //  }
                        if ($submit_select_show) { ?>
                            <tr>
                                <td>Change Status</td>

                                <td class="w-25">
                                    <select required class="form-select stg_2_status_select" aria-label="Default select example" name="status" id="stage_2_status_drop" onchange="change_status_2(this.value)">
                                        <option selected disabled>Select Status</option>
                                        <option id="lodged_2" value="Lodged" <?= $log_active_2 . $log_select_2 ?>>Lodged</option>
                                        <option id="in_progress_2" value="In Progress" <?= $pro_active_2 . $pro_select_2 ?>>In Progress</option>
                                        <option id="approved_2" value="Approved" <?= $app_active_2 . $app_select_2 ?>>Approved</option>
                                        <option id="declined_2" value="Declined" <?= $dec_active_2 . $dec_select_2 ?>>Declined</option>
                                        <option id="Withdrawn_2" value="Withdrawn" <?= $with_active_2 . $with_select_2 ?>>Withdrawn</option>
                                        <option id="closed_2" value="Closed" <?=$noshow?>>Closed</option>

                                    </select>

                                    <input type="hidden" name="pointer_id" value="<?= $stage_2->pointer_id ?>">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <input type="hidden" name="stage_2_id" value="<?= $stage_2->id ?>">

                                </td>
                            </tr>
                        <?php } ?>
                        <!-- Reason -->
                        <!--<tr id="reason_tr_2" style="display: none;">-->
                        <!--    <td> Reason </td>-->
                        <!--    <td class="w-20">-->
                        <!--        <div style="display: flex;" class="position-relative">-->
                        <!--            <textarea class="form-control" <php-->
                        <!--                                            if ($stage_2->status == 'Declined') {-->
                        <!--                                                echo "readonly";-->
                        <!--                                            }-->
                        <!--                                            ?> id="reason_input_2" name="reason" rows="3"><php-->
                        <!--                                                                                            if ($stage_2->status == 'Declined') {-->
                        <!--                                                                                                echo $stage_2->declined_reason;-->
                        <!--                                                                                            } ?> </textarea>-->

                        <!--            <a href="javascript:void(0)" id="stage_2_hide_show_btn_reson" style="vertical-align: bottom;" class="btn btn-sm btn_green_yellow position-absolute bottom-0 end-0" onclick="readonlyInput('#reason_input_2')">-->
                        <!--                <i class="bi bi-pencil-square"></i> </i></a>-->
                        <!--        </div>-->
                        <!--    </td>-->
                        <!--</tr>-->
                        <!---------------------- declined documnets ----------------------->
                        <tr id="reason_tr_1_2" style="display: none;">
                            <td>Outcome Letter</td>
                            <td class="w-20">
                                <?php
                                $Outcome_Letter_available = false;
                                
                                // foreach ($stage_3_documents_vhp as $key => $value) { 
                                $outcome_letter = find_one_row_3_field('documents','stage','stage_2','pointer_id',$pointer_id,'required_document_id',51);
                                    if ($outcome_letter) { // Outcome Letter
                                        $document_name = $outcome_letter->document_name;
                                        $document_path = $outcome_letter->document_path;
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $outcome_letter->name;
                                        $Outcome_Letter_available = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name  ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <a id="stage_2_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s2_show_upload_file('#s2_outcome')"><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        <?php } ?>
                                    <div style="display: flex;">
                                        <input name="outcome_file" <?php 
                                        if ($Outcome_Letter_available) {
                                                                        echo 'style="display: none;"';
                                                                    } ?> id="s2_outcome" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_s2_outcome" onclick="s2_auto_file_upload('s2_outcome','outcome_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <tr id="reason_tr_2_2" style="display: none;">
                            <td>Statement of Reasons</td>
                            <td class="w-20">
                                <?php
                                // Statement of Reasons	
                                $Statement_of_Reasons_available = false;
                                $statement_of_reasons = find_one_row_3_field('documents','stage','stage_2','pointer_id',$pointer_id,'required_document_id',52);
                                // print_r($statement_of_reasons);
                                     if ($statement_of_reasons) { // Outcome Letter
                                        $document_name = $statement_of_reasons->document_name;
                                        $document_path = $statement_of_reasons->document_path;
                                        $file_path = $document_path . '/' . $document_name;
                                        $name = $statement_of_reasons->name;
                                        $Statement_of_Reasons_available = true;
                                    ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a target="_blank" href="<?= base_url($file_path) ?>"> <?= $name ?> </a>
                                            </div>
                                            <div class="col-4 bbg-info my-auto">
                                                <a id="stage_2_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="s2_show_upload_file('#s2_dec_Statement_of_Reasons')"><i class="bi bi-pencil-square"></i></a>
                                            </div>
                                        <?php } ?>
                                    <!-- // vishal 27-04-2023  -->
                                    <div style="display: flex;"
                                    >

                                        <input name="reason_file" <?php
                                        // echo "fgdg";
                                        // echo $Statement_of_Reasons_available;
                                        // echo "fgdg";
                                        if ($Statement_of_Reasons_available) {
                                                echo 'style="display: none;"';
                                                                    } ?> id="s2_dec_Statement_of_Reasons" type="file" class="form-control s1" />
                                        <button type="button" class="btn btn-sm btn_green_yellow auto_file_upload_dec_statement_reason_s2" onclick="s2_auto_file_upload('s2_dec_Statement_of_Reasons','reason_file')"> <i class="bi bi-file-earmark-arrow-up"></i> </button>
                                    </div>
                            </td>
                        </tr>
                        <!---------------------- declined documnets end ----------------------->
                        <tr>
                            <td colspan="2" class="text-center">
                                <?php if ($submit_btn_show) { ?>
                                    <button type="submit" class="btn btn_green_yellow" id="s2_update" name="s2_update" disabled>Update</button>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
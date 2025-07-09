<style>
    .tital_set {
        /* background-color: var(--gray); */
        background-color: #8b9fc6;
        font-size: 1.1rem;
        color: black !important;
        box-shadow: none;
    }
</style>

<?php
$show = true;
if (session()->get('admin_account_type') == 'head_office') {
    if ($stage_2->status == "Submitted") {
        $show = false;
    }
} ?>
<?php if ($show) { ?>
    <div class="accordion mt-1" id="document_stage_2">
        <div class="accordion-item">
            <h2 class="accordion-header" id="doc_head_stage_2">
                <button class="accordion-button collapsed  text-green" type="button" data-bs-toggle="collapse" data-bs-target="#doc_stage_2" aria-expanded="false" aria-controls="doc_stage_2" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold"> <i class="bi bi-folder-fill mx-2"></i>
                    Stage 2 Documents
                </button>
            </h2>

          <div id="doc_stage_2" class="accordion-collapse collapse" aria-labelledby="doc_head_stage_2" data-bs-parent="#document_stage_2">
                <div class="accordion-body">
                    <div class="row">
                        <div id="download_div" class="mb-3 col-10">
                            <a onclick="download_zip(<?= $pointer_id ?>,'stage_2')" class="btn_yellow_green btn disabled"> Download All Stage 2 Documents <i class="bi bi-download"></i></a>
                        </div>
                        <?php 
                        if (session()->get('admin_account_type') == 'admin') {
                            // print_r($application_pointer);exit;
                            $display = '';
                            if($application_pointer->status == 'Lodged')
                            {
                                $display = "display:none";
                            }
                            
                            
                            if($application_pointer->stage == "stage_2"){
                        ?>
                        <div id="delete_stage_2" class="mb-3 col-2" style="<?= $display ?>">
                            <a onclick="delete_stage_2('<?= $pointer_id ?>')" class="btn_green_yellow btn" style="float: right;"> Delete Stage 2 </a>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    // echo "<pre>";
                    // print_r($stage_2_ass_documents);
                    // echo "</pre>";

                    ?>

                    <form action="" id="reason_form_stage_2" method="post">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th style="width: 150px;text-align: center;">Action</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>

            <!---------------------------------------- assessment documents ----------------------------------------------------------------->
                                <tr class="tital_set">
                                    <td colspan="3" style="--bs-table-accent-bg:none">
                                        <!-- <i class="bi bi-briefcase-fill" style="padding-right: 5px;"></i>  -->
                                        <b> Assessment Documents</b>
                                    </td>
                                </tr>
                                
                                <?php
                                $stage_2_ass_documents =assessment_documents_($pointer_id);
                                 //
                                // die;
                                $sr_no = 1;
                                $verify_email_2 = 0;
                                    // print_r($stage_2_ass_documents);exit;
                                foreach ($stage_2_ass_documents as $s2_document_ass) {
                                    // print_r($s2_document_ass);
                                    // if ($s2_document_ass->employee_id = 17) {

                                    //print_r($s2_document_ass);
                                    $show_f2 = true;
                                    $employee_documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                    //print_r($employee_documnet_request_s2);die;
                                    if (!empty($employee_documnet_request_s2)) {
                                        if (isset($employee_documnet_request_s2->status)) {
                                            if ($employee_documnet_request_s2->status == "send") {
                                                $show_f2 = false;
                                            }
                                        }
                                    }


                                    
                                    
                                    
                                    
                                    if ($show_f2) {
                                ?>      
                                <?php
                                // if($s2_document_ass->required_document_id == 16||$s2_document_ass->required_document_id == 17){
                                    
                                        $span_name = '';
                                        
                                        if($s2_document_ass->is_additional == 'yes')
                                        {
                                            $span_name = '<snap style="font-size:70%;color:black">(Additional Information)</snap>';
                                            $chat_button_disabled = "disabled";
                                            // $span_name = 'yes';
                                        }else{
                                            $span_name = '';
                                            $chat_button_disabled = '';
                                        }
                                        
                                        
                                        
                                    $main_validator = check_file_closed($application_pointer, (array)$s2_document_ass);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];
                                  ?>

                                        <tr>
                                            <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                            <td class="w-50">
                                                <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s2_document_ass->name  ?> <?= $span_name ?></a>
                                            </td>
                                            <td style="text-align: center;">
                                                <!-- download  -->
                                                <a href="<?= $full_url  ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                                <!-- Delete  -->
                                                <a onclick="delete_document(<?= $s2_document_ass->id ?>)" href="javascript:void(0)" class="disabled btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                                <?php
                                                $s2_disabled_comment = "";
                                                if (isset($s2_document_ass->name)) {
                                                    if ($s2_document_ass->name  == "Verification - Employment" || $s2_document_ass->name  == "Verification Email - Employment") {
                                                        $s2_disabled_comment = "disabled";
                                                        $verify_email_2 = 1;
                                                    }
                                                }
                                                if ($s2_document_ass->required_document_id == 0) {
                                                    $s2_disabled_comment = "disabled";
                                                }
                                                // $documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                                // if (!empty($documnet_request_s2)) {
                                                //     $s2_disabled_comment = "disabled";
                                                // }
                                                ?>
                                                <!-- comment  -->
                                                <a href="javascript:void(0)" class="disabled btn <?= $s2_disabled_comment ?> <?= $chat_button_disabled ?>  btn-sm btn_green_yellow" id="Dbtn_s2_assessment<?= $sr_no ?>" onclick="show_input_s2('assessment<?= $sr_no ?>')">
                                                    <i class="bi bi-chat-left-dots"></i>
                                                </a>
                                                <a href="javascript:void(0)" style="display: none;" id="Xbtn_s2_assessment<?= $sr_no ?>" class="disabledbtn btn_yellow_green btn-sm" onclick="show_input_s2('assessment<?= $sr_no ?>')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_assessment<?= $sr_no ?>" class="form-control s1">
                                                <input type="hidden" name="document_id[]" value="<?= $s2_document_ass->id  ?>">
                                                <input type="hidden" name="pointer_id[]" value="<?= $s2_document_ass->pointer_id ?>">
                                                <input type="hidden" name="stage[]" value="<?= $s2_document_ass->stage ?>">
                                                <input type="hidden" name="reupload_emp_docs[]" value="">  
                                                <input type="hidden" name="support_evidance_status[]" value="">

                                                
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                <?php

                                        $sr_no++;
                                    // }
                                    // }
                                    }
                                }
                                ?>
                                
                               <!-- Additional Information pooja ----------------------->
                                <tr class="tital_set" style="background-color:white;font-size: 17px;color: #4154f1!important;" id="assmement_additional_row">
                                    <td style="color:black;">
                                         Additional Information 
                                    </td>
                                    <!-- background-color: #8b9fc600; -->
                                    <td style="text-align: center; ">
                                        <!-- download  -->
                                        <!-- download  -->
                                        <a herf="" id="add_more_button" class="disabled btn btn-sm btn_yellow_greenn " onclick="add_additional_inforamtion('',<?= $s2_document_ass->pointer_id ?>,'<?= $s2_document_ass->stage ?>','','assmement_additional_row', this,'','input_s2_new_Additional','show_input_s2_',0)" style=" border:0px; background-color: #dec45c; color:#055837 !important">
                                            <!--<i class="bi bi-download"></i></a>-->
                                            <i class="bi bi-plus"></i>
                                        </a>
                                        <!-- delete  -->
                                        <a class="disabled btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                        <!-- comment  -->
                                        <!--<a href="javascript:void(0)" class="btn btn-sm btn-sm btn_green_yellow pooja" id="DDbtn_s2_Additional" onclick="show_input_s2('Additional')">-->
                                        <a href="javascript:void(0)" class="disabled btn btn-sm btn-sm btn_green_yellow pooja" id="new_testing_Additional" onclick="show_input_s2_('Additional')">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </a>
                                        <!--<a href="javascript:void(0)" class="disabled btn btn-sm btn_yellow_green" style="display: none;" id="XXbtn_s2_Additional" onclick="show_input_s2('Additional')">-->
                                        <a href="javascript:void(0)" class="disabled btn btn-sm btn_yellow_green" style="display: none;" id="close_new_Additional" onclick="show_input_s2_('Additional')">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                        <input type="hidden" name="stage[]" value="stage_2">
                                       <input type="text" id="input_s2_new_Additional" style="display: none;" onkeyup=check_s2('add_more_button') class="form-control s1" name="reason[]">
                                       <input type="hidden" name="support_evidance_status[]" value="">
                                       <input type="hidden" name="document_id[]" value="">
                                       <input type="hidden" name="reupload_emp_docs[]" value="">  


                                       
                                    </td>
                                </tr>
                                <?php
                                $stage_2_ass_documentsa = Additional_Information_docs($pointer_id);
                                $sr_no = 1;

                                foreach ($stage_2_ass_documentsa as $s2_document_ass) {
                                    
                                    $documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                     //print_r($documnet_request_s2);exit;
                                    
                                    if($documnet_request_s2->support_evidance_status == "yes"){
                                        continue;
                                    }
                                    
                                    if($s2_document_ass->is_additional == 'yes')
                                        {
                                            $span_name = '<snap style="font-size:70%">(Additional Information)</snap>';
                                            // $span_name = 'yes';
                                        }else{
                                            $span_name = '';
                                        }   
                                    // if ($s2_document_ass->employee_id == "") {

                                        
                                    $main_validator = check_file_closed($application_pointer, (array)$s2_document_ass);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];
                                ?>
                                    <tr>
                                        <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                        <td class="w-50">
                                            <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s2_document_ass->name  ?> <?= $span_name ?> </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <!-- download  -->
                                            <a href="<?= $full_url  ?>/<?= $s2_document_ass->document_name  ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                            <!-- Delete  -->
                                            <a onclick="delete_document(<?= $s2_document_ass->id ?>)" href="javascript:void(0)" class="disabled btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <?php
                                            $s2_disabled_comment = "";
                                            if (isset($s2_document_ass->name)) {
                                                if ($s2_document_ass->id  == 22) {
                                                    $s2_disabled_comment = "disabled";
                                                    $verify_email_2 = 1;
                                                }
                                            }
                                            if ($s2_document_ass->required_document_id == 0) {
                                                $s2_disabled_comment = "disabled";
                                            }
                                            $documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                            if (!empty($documnet_request_s2)) {
                                                $s2_disabled_comment = "disabled";
                                            }
                                            ?>
                                            <!-- comment  -->
                                            <a href="javascript:void(0)" class="disabled btn <?= $s2_disabled_comment ?>  btn-sm btn_green_yellow" id="DDbtn_s2_<?= $sr_no ?>" onclick="show_input_s2('<?= $sr_no ?>')">
                                                <i class="bi bi-chat-left-dots"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="display: none;" id="XXbtn_s2_<?= $sr_no ?>" class="disabledbtn btn_yellow_green btn-sm" onclick="show_input_s2('<?= $sr_no ?>')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_<?= $sr_no ?>" class="form-control s1">
                                            <!--<input type="hidden" name="document_id[]" value="<?= $s2_document_ass->id  ?>">-->
                                            <input type="hidden" name="document_id[]" value="">
                                            <input type="hidden" name="pointer_id[]" value="<?= $s2_document_ass->pointer_id ?>">
                                            <input type="hidden" name="stage[]" value="<?= $s2_document_ass->stage ?>">  
                                            <input type="hidden" name="reupload_emp_docs[]" value="">
                                            <input type="hidden" name="support_evidance_status[]" value="">
                                            

                                        </td>
                                    </tr>
                                <?php
                                    $sr_no++;
                                    // }
                                }
                                ?>
                                <!-- <tr>
                                <td> -->
                                <?php
                                $stage_2_ass_documents = Additional_Information_docs($pointer_id);
                                // echo "<pre>";
                                // echo "s";
                                // print_r($stage_2_ass_documents);
                                // echo "</pre>";
                                ?>
                                <!-- </td>
                            </tr> -->

                      <!-- Additional Information end ----------------------->
                     
                                
                                
                                
                                
                                
            <!----------------------------- assessment documents end ------------------------------------------------------------------------->
            
            
            
            
                                
                                <!--supporting evidence applicant documents start-->
                                <?php   $stage_2_supp_documents = supporting_documents($pointer_id);
                                    if(!empty($stage_2_supp_documents) ){ 
                                    ?>
                                <tr class="tital_set">
                                    <td colspan="3" style="--bs-table-accent-bg:none">
                                        <!-- <i class="bi bi-briefcase-fill" style="padding-right: 5px;"></i>  -->
                                        <b> Supporting Evidence For Application Kit</b>
                                    </td>
                                </tr>
                                
                        

                                
                                
                                
                                <?php
                                $sr_no = 1;
                                $verify_email_2 = 0;

                                foreach ($stage_2_supp_documents as $s2_document_ass) {
                                     //print_r($s2_document_ass);
                                    // if ($s2_document_ass->employee_id = 17) {


                                    $show_f2 = true;
                                    $employee_documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                    if (!empty($employee_documnet_request_s2)) {
                                        if (isset($employee_documnet_request_s2->status)) {
                                            if ($employee_documnet_request_s2->status == "send") {
                                                $show_f2 = false;
                                            }
                                        }
                                    }
                                    $span_name = '';
                                    if($s2_document_ass->is_additional == 'yes')
                                        {
                                            $span_name = '<snap style="font-size:70%;color:black">(Additional Information)</snap>';
                                            // $span_name = 'yes';
                                            $s2_disabled_comment_ = "disabled";
                                        }else{
                                            $span_name = '';
                                            $s2_disabled_comment_ = "";
                                        }
                                    

                                    if ($show_f2) {

                                        
                                    $main_validator = check_file_closed($application_pointer, (array)$s2_document_ass);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];

                                ?>
                                        <tr>
                                            <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                            <td class="w-50">
                                                <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s2_document_ass->name  ?> <?= $span_name ?></a>
                                            </td>
                                            <td style="text-align: center;">
                                                <!-- download  -->
                                                <a href="<?= $full_url  ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                                <!-- Delete  -->
                                                <a onclick="delete_document(<?= $s2_document_ass->id ?>)" href="javascript:void(0)" class="disabled btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                                <?php
                                                $s2_disabled_comment = "";
                                                if (isset($s2_document_ass->name)) {
                                                    if ($s2_document_ass->name  == "Verification - Employment" || $s2_document_ass->name  == "Verification Email - Employment") {
                                                        $s2_disabled_comment = "disabled";
                                                        $verify_email_2 = 1;
                                                    }
                                                }
                                                if ($s2_document_ass->required_document_id == 0) {
                                                    $s2_disabled_comment = "disabled";
                                                }
                                                $documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                                if (!empty($documnet_request_s2)) {
                                                    $s2_disabled_comment = "disabled";
                                                }
                                                ?>
                                                <!-- comment  -->
                                                <a href="javascript:void(0)" class="disabled btn <?= $s2_disabled_comment_ ?>  btn-sm btn_green_yellow" id="Dbtn_s2_<?= $sr_no ?>" onclick="show_input_s2('<?= $sr_no ?>')">
                                                    <i class="bi bi-chat-left-dots"></i>
                                                </a>
                                                <a href="javascript:void(0)" style="display: none;" id="Xbtn_s2_<?= $sr_no ?>" class="disabledbtn btn_yellow_green btn-sm pp" onclick="show_input_s2('<?= $sr_no ?>')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_<?= $sr_no ?>" class="form-control s1">
                                                <input type="hidden" class="pooja" name="document_id[]" value="<?= $s2_document_ass->id ?>">
                                                <input type="hidden" name="pointer_id[]" value="<?= $s2_document_ass->pointer_id ?>">
                                                <input type="hidden" name="stage[]" value="<?= $s2_document_ass->stage ?>">
                                                <input type="hidden" name="reupload_emp_docs[]" value="">  
                                                <input type="hidden" name="support_evidance_status[]" value="yes">
                                                <!--<input type="hidden" id="input_s2_Additional_value" name="request_additional_value[]" value"">-->
                                            </td>
                                        </tr>
                                        
                                   <?php } ?>     
                                        
                                <?php

                                        $sr_no++;
                                    }
                                    // }
                                }
                                ?>
                                
                                <?php 
                                 if(!empty($stage_2_supp_documents) ){
                                
                                
                                ?>
                            <!-- Additional Information ----------------------->
                                <tr class="tital_set" style="background-color:white;font-size: 17px;color: #4154f1!important;" id="assmement_support_row">
                                    <td style="">
                                         Additional Information
                                    </td>
                                    <!-- background-color: #8b9fc600; -->
                                    <td style="text-align: center; ">
                                        <!-- download  -->
                                        <!-- download  -->
                                        <a herf="" id="add_more_button_" class="disabled btn btn-sm btn_yellow_greenn  " style="border: 0px;background-color: #dec45c ;color: #055837 !important;" 
                                        onclick="add_additional_inforamtion('',<?= $s2_document_ass->pointer_id ?>,'<?= $s2_document_ass->stage ?>','','assmement_support_row', this, 'yes','input_s2_Additional','show_input_s2',0)">
                                            <i class="bi bi-plus"></i></a>
                                        <!-- delete  -->
                                        <a class="disabled btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                        <!-- comment  -->
                                        <a href="javascript:void(0)" class="disabled btn btn-sm btn-sm btn_green_yellow" id="Dbtn_s2_Additional" onclick="show_input_s2('Additional')">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="disabled btn btn-sm btn_yellow_green" style="display: none;" id="Xbtn_s2_Additional" onclick="show_input_s2('Additional')">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                        <input type="hidden" name="stage[]" value="stage_2">
                                        <input type="text" id="input_s2_Additional" style="display: none;" onkeyup=check_s2('add_more_button_') class="form-control s1" name="reason[]">
                                        <input type="hidden" name="support_evidance_status[]" value="yes">
                                         <input type="hidden" name="document_id[]" value="">
                                         <input type="hidden" name="reupload_emp_docs[]" value="">  
                                         <input type="hidden" id="input_s2_Additional_value" name="request_additional_value[]" value="">



                                    </td>
                                </tr>
                                <?php
                                $stage_2_ass_documentsa = Additional_Information_docs($pointer_id);
                                $sr_no = 1;

                                foreach ($stage_2_ass_documentsa as $s2_document_ass) {
                                    // if ($s2_document_ass->employee_id == "") {
                                        
                                    $main_validator = check_file_closed($application_pointer, (array)$s2_document_ass);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];
                                ?>
                                    <tr>
                                        <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                        <td class="w-50">
                                            <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s2_document_ass->name  ?></a>
                                        </td>
                                        <td style="text-align: center;">
                                            <!-- download  -->
                                            <a href="<?= $full_url  ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                            <!-- Delete  -->
                                            <a onclick="delete_document(<?= $s2_document_ass->id ?>)" href="javascript:void(0)" class="disabled btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <?php
                                            $s2_disabled_comment = "";
                                            if (isset($s2_document_ass->name)) {
                                                if ($s2_document_ass->id  == 22) {
                                                    $s2_disabled_comment = "disabled";
                                                    $verify_email_2 = 1;
                                                }
                                            }
                                            if ($s2_document_ass->required_document_id == 0) {
                                                $s2_disabled_comment = "disabled";
                                            }
                                            $documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                            if (!empty($documnet_request_s2)) {
                                                $s2_disabled_comment = "disabled";
                                            }
                                            ?>
                                            <!-- comment  -->
                                            <a href="javascript:void(0)" class="disabled btn <?= $s2_disabled_comment ?>  btn-sm btn_green_yellow" id="Dbtn_s2_<?= $sr_no ?>" onclick="show_input_s2('<?= $sr_no ?>')">
                                                <i class="bi bi-chat-left-dots"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="display: none;" id="Xbtn_s2_<?= $sr_no ?>" class="disabled btn btn_yellow_green btn-sm" onclick="show_input_s2('<?= $sr_no ?>')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_<?= $sr_no ?>" class="form-control s1">
                                            <input type="hidden" name="document_id[]" value="">
                                            <input type="hidden" name="pointer_id[]" value="<?= $s2_document_ass->pointer_id ?>">
                                            <input type="hidden" name="stage[]" value="<?= $s2_document_ass->stage ?>">
                                            <input type="hidden" name="reupload_emp_docs[]" value="">  
                                            <input type="hidden" name="support_evidance_status[]" value="yes">                        
                                            <input type="hidden" id="input_s2_Additional_value" name="request_additional_value[]" value="">
                                        </td>
                                    </tr>
                                <?php
                                    $sr_no++;
                                    // }
                                }
                                ?>
                                <!-- <tr>
                                <td> -->
                                <?php
                                $stage_2_ass_documents = Additional_Information_docs($pointer_id);
                                // echo "<pre>";
                                // echo "s";
                                // print_r($stage_2_ass_documents);
                                // echo "</pre>";
                                ?>
                                <!-- </td>
                            </tr> -->

                      <!-- Additional Information end ----------------------->
                      <?php } ?>
                      
    <!-----------------------------------------------------Suprrot evidance end ----------------------------------------------------------------------->
                               
    <!-------------------------------------------- employees documents -------------------------------------------------------------------------------->
                                <?php
                                $sr = 1;
                                 
                                 if($count_company == 1)
                                 {
                                     $style = "disabled";
                                 }else{
                                     $style = "";
                                 }
                                $organization_row_count = 0;
                                foreach ($stage_2_add_employees as $stage_2_employee) { 
                                    $organization_row_count++;
                                //   print_r($stage_2_employee);exit;
                                
                                ?>
                                    <tr class="tital_set here mohsin">
                                        <td style="--bs-table-accent-bg:none">
                                            <!-- <i class="bi bi-briefcase-fill" style="padding-right: 5px;"></i> -->
                                            <?= $stage_2_employee->company_organisation_name ?>
                                        </td>
                                        <td style="--bs-table-accent-bg:none; text-align: center;">
                                            <!-- download  -->
                                            <a href="" class=" disabled disabled btn btn-sm btn_yellow_green " style=" border:0px; background-color: #ffe475 !important; color:black !important"><i class="bi bi-download"></i></a>

                                            <!-- Delete  -->
                                            <a onclick="delete_employe(<?= $stage_2_employee->id ?>)" href="javascript:void(0)"  class="disabled btn btn-sm btn-danger" <?= $style ?>>
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <!-- comment  -->
                                            <a href="javascript:void(0)" class="btn disabled btn-sm btn_green_yellow">
                                                <i class="bi bi-chat-left-dots"></i>
                                            </a>
                                                
                                        </td>
                                        <td style="--bs-table-accent-bg:none">
                                            
                                        </td>
                                    </tr>
                                    
                       

                                    
                                    
                                    
                                    <?php
                                    $stage_2_documents = find_multiple_row_3_field('documents', 'pointer_id', $pointer_id, 'stage', 'stage_2', 'employee_id', $stage_2_employee->id);
                                    $count = 1;
                                    
                                    foreach ($stage_2_documents as $s2_document) {
                                        // print_r($s2_document);
                                    
                                        // Mohsin Fixing
                                        // if ($s2_document->required_document_id != 17) {
                                            if (1==1) {
                                    ?>


                                            <?php
                                            $show_f2 = true;
                                            $employee_documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document->id);
                                            if (!empty($employee_documnet_request_s2)) {
                                                if (isset($employee_documnet_request_s2->status)) {
                                                    if ($employee_documnet_request_s2->status == "send") {
                                                        $show_f2 = false;
                                                    }
                                                }
                                            }
                                            if ($show_f2) {
                                                
                                                 $span_name = '';
                                        
                                                    if($s2_document->is_additional == 'yes')
                                                    {
                                                        $span_name = '<snap style="font-size:70%;color:black">(Additional Information)</snap>';
                                                        $chat_button_disabled = "disabled";
                                                        // $span_name = 'yes';
                                                    }else{
                                                        $span_name = '';
                                                        $chat_button_disabled = '';
                                                    }
                                        
                                                    
                                                    $main_validator = check_file_closed($application_pointer, (array)$s2_document);

                                                    $full_url = $main_validator["full_url"];
                                                    $full_url_target = $main_validator["full_url_target"];
                                            ?>
                                                <!-- All Basic Documents ----------------------------->
                                                <tr class="Here Employement">
                                                    <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                                    <td class="w-50">
                                                        <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s2_document->name  ?> <?= $span_name ?> </a>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <!-- download  -->
                                                        <a href="<?= $full_url  ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                                        <!-- Delete  -->
                                                        <a onclick="delete_document(<?= $s2_document->id ?>)" href="javascript:void(0)" class="disabled btn btn-sm btn-danger">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </a>
                                                        <!-- comment  -->

                                                        <a href="javascript:void(0)" class="disabled btn btn-sm  btn_green_yellow <?= $chat_button_disabled ?> " id="Dbtn_s2_<?= $sr . $count ?>" onclick="show_input_s2('<?= $sr . $count ?>')">
                                                            <i class="bi bi-chat-left-dots"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" style="display: none;" id="Xbtn_s2_<?= $sr . $count ?>" class="disabledbtn btn_yellow_green btn-sm" onclick="show_input_s2('<?= $sr . $count ?>')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_<?= $sr . $count ?>" class="form-control s1">
                                                        <input type="hidden" name="document_id[]" value="<?= $s2_document->id  ?>">
                                                        <input type="hidden" name="pointer_id[]" value="<?= $s2_document->pointer_id ?>">
                                                        <input type="hidden" name="stage[]" value="<?= $s2_document->stage ?>">
                                                        
                                                        <input type="hidden" name="reupload_emp_docs[]" value="<?= $stage_2_employee->id ?>"> 
                                                         <input type="hidden" name="support_evidance_status[]" value="">

                                                    </td>
                                                </tr>
                                <?php
                                            }
                                            $count++;
                                        }
                                        $sr++;
                                    }
                                     
                                    //  print_r($organization_row_count);exit;
                                    
                                    ?>
                                    
                                                                    <!-- Additional Information ----------------------->
                                <tr class="tital_set" style="background-color:white;font-size: 17px;color: #4154f1!important" id="organization_add_row<?= $organization_row_count ?>">
                                    <td style="color:black;">
                                         Additional Information
                                    </td>
                                    <!-- background-color: #8b9fc600; -->
                                    <td style="text-align: center; ">
                                        <!-- download  -->
                                        <!-- download  -->
                                        <a herf="" id="add_more_button__<?= $stage_2_employee->id ?>" class="disabled btn btn-sm btn_yellow_greenn "    onclick="add_additional_inforamtion('',<?= $s2_document->pointer_id ?>,'<?= $s2_document->stage ?>',<?= $stage_2_employee->id ?>,'organization_add_row<?= $organization_row_count ?>', this, '','input_s2_Additional_<?= $stage_2_employee->id ?>','add_show_input_s2', 1)"  style=" border: 0px;background-color: #dec45c;color: #055837 !important;">
                                            <i class="bi bi-plus"></i></a>
                                        <!-- delete  -->
                                        <a class="disabled btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                        <!-- comment  -->
                                        <a href="javascript:void(0)" class="disabled btn btn-sm btn-sm btn_green_yellow" id="Dbtn_s2_Additional_<?= $stage_2_employee->id ?>" onclick="add_show_input_s2('Additional','<?= $stage_2_employee->id ?>')">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="disabled btn btn-sm btn_yellow_green" style="display: none;" id="Xbtn_s2_Additional_<?= $stage_2_employee->id ?>" onclick="add_show_input_s2('Additional','<?= $stage_2_employee->id ?>')">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                        <input type="hidden" name="stage[]" value="stage_2">
                                        <input type="text" id="input_s2_Additional_<?= $stage_2_employee->id ?>" style="display: none;" onkeyup=check_s2('add_more_button__<?= $stage_2_employee->id ?>') class="form-control s1" name="reason[]">
                                        <!--<input type="hidden" id="input_s2_Additional_value" name="reason[]" value="">-->
                                        <input type="hidden" name="reupload_emp_docs[]" value="<?= $stage_2_employee->id ?>">
                                        <input type="hidden" name="document_id[]" value="">
                                        <input type="hidden" name="support_evidance_status[]" value="">


                                    </td>
                                </tr>
                                <?php
                                $stage_2_ass_documentsa = Additional_Information_docs($pointer_id);
                                $sr_no = 1;

                                foreach ($stage_2_ass_documentsa as $s2_document_ass) {
                                    $documnet_request_s2 = find_one_row('additional_info_request', 'document_id', $s2_document_ass->id);
                                    if($documnet_request_s2->support_evidance_status == "yes"){
                                        continue;
                                    }
                                    
                                    $main_validator = check_file_closed($application_pointer, (array)$s2_document_ass);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];
                                    // if ($s2_document_ass->employee_id == "") {
                                ?>
                                    <tr>
                                        <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                        <td class="w-50">
                                            <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s2_document_ass->name  ?> </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <!-- download  -->
                                            <a href="<?= $full_url ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                            <!-- Delete  -->
                                            <a onclick="delete_document(<?= $s2_document_ass->id ?>)" href="javascript:void(0)" class="disabled btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <?php
                                            $s2_disabled_comment = "";
                                            if (isset($s2_document_ass->name)) {
                                                if ($s2_document_ass->id  == 22) {
                                                    $s2_disabled_comment = "disabled";
                                                    $verify_email_2 = 1;
                                                }
                                            }
                                            if ($s2_document_ass->required_document_id == 0) {
                                                $s2_disabled_comment = "disabled";
                                            }
                                            
                                            if (!empty($documnet_request_s2)) {
                                                $s2_disabled_comment = "disabled";
                                            }
                                            ?>
                                            <!-- comment  -->
                                            <a href="javascript:void(0)" class="disabled btn <?= $s2_disabled_comment ?>  btn-sm btn_green_yellow" id="Dbtn_s2_<?= $sr_no ?>" onclick="show_input_s2('<?= $sr_no ?>')">
                                                <i class="bi bi-chat-left-dots"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="display: none;" id="Xbtn_s2_<?= $sr_no ?>" class="disabledbtn btn_yellow_green btn-sm" onclick="show_input_s2('<?= $sr_no ?>')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_<?= $sr_no ?>" class="form-control s1">
                                            <input type="hidden" name="document_id[]" value="">
                                            <input type="hidden" name="pointer_id[]" value="<?= $s2_document_ass->pointer_id ?>">
                                            <input type="hidden" name="stage[]" value="<?= $s2_document_ass->stage ?>">
                                            <input type="hidden" name="reupload_emp_docs[]" value="<?= $stage_2_employee->id ?>">  
                                            <input type="hidden" name="support_evidance_status[]" value="">

                                        </td>
                                    </tr>
                                <?php
                                    $sr_no++;
                                    // }
                                }
                                ?>
                                <!-- <tr>
                                <td> -->
                                <?php
                                $stage_2_ass_documents = Additional_Information_docs($pointer_id);
                                // echo "<pre>";
                                // echo "s";
                                // print_r($stage_2_ass_documents);
                                // echo "</pre>";
                                ?>
                                <!-- </td>
                            </tr> -->

                      <!-- Additional Information end ----------------------->
                                 <?php }
                                
                                
                                ?>
                                


                                
                                


    <!------------------------------------------------------------------ employees documents end -------------------------------------------------------->





                                  <?php 
                                $checks1=find_one_row('stage_2','pointer_id',$pointer_id);
                                //print_r($check);
                                if($checks1->status != 'Approved'){
                                
                                
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <button type="submit" class="btn btn_green_yellow" style="display: none; float:right" id="s2_doc_sub_btn">Request Additional Info</button>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </form>
                    <?php
                    if (session()->get('admin_account_type') == 'admin') {
                    ?>
                        <div class="row">
                            <?php
                            // echo "<pre>";
                            // print_r($stage_2_email_verification);
                            // echo "</pre>";
                            if (empty($stage_2_email_verification)) {
                            ?>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="Send_Employment_Verification_Email" class="btn btn_green_yellow" onclick="send_emp_email()"> Send Employment Verification Email </button>
                                        </div>
                                    </div>

                                </div>
                            <?php
                            }
                            if ($verify_email_2 != 1) {
                            ?>

                                <div class="col-sm-4 my-4">
                                    <form action="" id="verify_email_stage_2" method="post">
                                        <h5> Verification - Employment </h5>
                                        <div class="row">
                                            <div class="col-10">
                                                <input name="file" type="file" class="form-control s1" required>
                                                <input name="pointer_id" type="hidden" class="form-control s1" value="<?= $pointer_id ?>">
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn_green_yellow">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php } ?>
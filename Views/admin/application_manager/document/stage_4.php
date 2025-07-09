<?php
$show = true;
if (session()->get('admin_account_type') == 'head_office') {
    if ($stage_4->status == "Submitted") {
        $show = false;
    }
} ?>
<?php if ($show) { ?>
    <div class="accordion" id="document_stage_4">
        <div class="accordion-item">
            <h2 class="accordion-header" id="doc_head_stage_4">
                <button class="accordion-button collapsed  text-green" type="button" data-bs-toggle="collapse" data-bs-target="#doc_stage_4" aria-expanded="false" aria-controls="doc_stage_4" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold"> <i class="bi bi-folder-fill mx-2"></i>
                    Stage 4 Documents
                </button>
            </h2>

            <div id="doc_stage_4" class="accordion-collapse collapse" aria-labelledby="doc_head_stage_4" data-bs-parent="#document_stage_4">
                <div class="accordion-body">
                    <div id="download_div" class="mb-2">
                        <a onclick="download_zip(<?= $pointer_id ?>,'stage_4')" class="btn_yellow_green btn"> Download All Stage 4 Documents <i class="bi bi-download"></i></a>
                    </div>

                    <form action="" id="reason_form_stage_4" method="post">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th style="width: 150px;text-align: center;">Action</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                // print_r($stage_4_documents);
                                // Stage 3
                                
                                
                                $stage_3_documents = $stage_4_documents;
                                
                                foreach ($stage_3_documents as $s3_document) {
                                    $documnet_request_s3 = find_one_row('additional_info_request', 'document_id', $s3_document->id);
                                    $show = false;
                                    if (!empty($documnet_request_s3) && $documnet_request_s3->status == "send") {
                                        $s3_disabled_comment = "disabled";
                                        $show = false;
                                    } else {
                                        $show = true;
                                    }
                                    if($s3_document->required_document_id == 49){
                                        continue;
                                    }
                                    // $s3_document->required_document_id == 44 ||
                                      if ($s3_document->required_document_id == 44 || $s3_document->required_document_id == 43 ||$s3_document->required_document_id == 55 || $s3_document->required_document_id == 0) {
                                                
                                                $span='';
                                            }else{
                                                
                                                 $span='<span style="font-size:70%; color:black;">(Additional Information)</span>';
                                                
                                            }
                                    if ($show) {
                                ?>
                                        <!-- All Basic Documents ----------------------------->
                                        <tr>
                                            <td class="w-50">
                                                
                                                <a class="normal_link" target="_blank" href="<?= base_url() ?>/<?= $s3_document->document_path ?>/<?= $s3_document->document_name ?>"> <?= $s3_document->name .$span?> </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <!-- download  -->
                                                <a href="<?= base_url() ?>/<?= $s3_document->document_path  ?>/<?= $s3_document->document_name  ?>" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>
                                                <?php
                                                $s3_disabled_comment = "";
                                                if (isset($s3_document->name)) {
                                                    if ($s3_document->name  == "Verification Email - Qualification" || $s3_document->name  == "Verification Email - Employment") {
                                                        $s3_disabled_comment = "disabled";
                                                    }
                                                }
                                                if ($s3_document->required_document_id == 0) {
                                                    $s3_disabled_comment = "disabled";
                                                }

                                                ?>
                                                <!-- Delete  -->
                                                <a onclick="delete_document(<?= $s3_document->id ?>)" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                                <!-- comment  -->
                                                <a href="javascript:void(0)" class="btn <?= $s3_disabled_comment ?> btn-sm btn_green_yellow" id="Dbtn_s3_<?= $count ?>" onclick="show_input_s3('<?= $count ?>')">
                                                    <i class="bi bi-chat-left-dots"></i>
                                                </a>
                                                <a href="javascript:void(0)" style="display: none;" id="Xbtn_s3_<?= $count ?>" class="btn btn_yellow_green btn-sm" onclick="show_input_s3('<?= $count ?>')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <input type="text" name="reason[]" style="display: none;" onkeyup=check_s3() id="input_s3_<?= $count ?>" class="form-control s1">
                                                <input type="hidden" name="document_id[]" value="<?= $s3_document->id  ?>">
                                                <input type="hidden" name="pointer_id[]" value="<?= $s3_document->pointer_id ?>">
                                                <input type="hidden" name="stage[]" value="<?= $s3_document->stage ?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    $count++;
                                } ?>
                                
                                
                                
                                
                               
                               
                               <!--dsd-->
                               
                                <?php
                                $stage_4_addtion_reqs = find_multiple_row_3_field('documents','stage', 'stage_4','required_document_id','49','pointer_id',$pointer_id);
                                // print_r($stage_4_addtion_reqs);
                                // exit;
                                
                                $sr_no = 1;
                                              $span='<span style="font-size:70%; color:black;">(Additional Information)</span>';
                                foreach ($stage_4_addtion_reqs as $stage_4_add_req) {
                                ?>
                                    <tr>
                                        <!-- <td class="w-50" style="padding-left: 50px;"> -->
                                        <td class="w-50">
                                            <a class="normal_link" target="_blank" href="<?= base_url() ?>/<?= $stage_4_add_req->document_path ?>/<?= $stage_4_add_req->document_name ?>"> <?= $stage_4_add_req->name.$span ?> </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <!-- download  -->
                                            <a href="<?= base_url() ?>/<?= $stage_4_add_req->document_path  ?>/<?= $stage_4_add_req->document_name  ?>" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>

                                            <!-- Delete  -->
                                            <a onclick="delete_document(<?= $stage_4_add_req->id ?>)" href="javascript:void(0)" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <!-- comment  -->
                                            <a href="javascript:void(0)" class="btn disabled  btn-sm btn_green_yellow" id="Dbtn_s4_<?= $sr_no ?>" onclick="show_input_s4('<?= $sr_no ?>')">
                                                <i class="bi bi-chat-left-dots"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="display: none;" id="Xbtn_s4_<?= $sr_no ?>" class="btn btn_yellow_green btn-sm" onclick="show_input_s4('<?= $sr_no ?>')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input type="text" name="reason[]" style="display: none;" onkeyup=check_s2() id="input_s2_<?= $sr_no ?>" class="form-control s1">
                                            <input type="hidden" name="document_id[]" value="<?= $stage_4_add_req->id  ?>">
                                            <input type="hidden" name="pointer_id[]" value="<?= $stage_4_add_req->pointer_id ?>">
                                            <input type="hidden" name="stage[]" value="<?= $stage_4_add_req->stage ?>">
                                        </td>
                                        
                                    </tr>
                                    
                                
                                <?php
                                    $sr_no++;
                                }
                                ?>
                                    
                                     <!-- Additional Information (if admin want more information) ----------------------->
                                <tr>
                                    <td style="--bs-table-accent-bg:none">
                                        <b> Additional Information </b>
                                    </td>
                                    <!-- background-color: #8b9fc600; -->
                                    <td style="text-align: center; ">
                                        <!-- download  -->
                                        <!-- download  -->
                                        <a herf="" class="btn  btn-sm btn_yellow_green " style=" border:0px; background-color: #ffe475 !important; color:black !important"><i class="bi bi-download"></i></a>
                                        <!-- delete  -->
                                        <a class="btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                        <!-- comment  -->
                                        <a href="javascript:void(0)" class="btn btn-sm btn-sm btn_green_yellow" id="Dbtn_s4_Additional" onclick="show_input_s4('Additional')">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn_yellow_green" style="display: none;" id="Xbtn_s4_Additional" onclick="show_input_s4('Additional')">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                        <input type="hidden" name="stage[]" value="stage_4">
                                        <input type="text" id="input_s4_Additional" style="display: none;" onkeyup=check_s4() class="form-control s1" name="request_additional">
                                    </td>
                                </tr
                                   <?php 
                                         $checks1=find_one_row('stage_4','pointer_id',$pointer_id);
                                //print_r($check);
                                if($checks1->status != 'Approved'){
                                   
                                
                                     ?>
                                 <tr>
                                    <td colspan="3">
                                        <button type="submit" class="btn btn_green_yellow" style="display: none; float:right" id="s4_doc_sub_btn">Request Additional Info</button>
                                    </td>
                                </tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php } ?>
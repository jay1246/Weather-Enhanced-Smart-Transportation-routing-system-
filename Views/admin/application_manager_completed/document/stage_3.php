<?php
$show = true;
if (session()->get('admin_account_type') == 'head_office') {
    if ($stage_3->status == "Submitted") {
        $show = false;
    }
} ?>
<?php if ($show) { ?>
    <div class="accordion mt-1" id="document_stage_3">
        <div class="accordion-item">
            <h2 class="accordion-header" id="doc_head_stage_3">
                <button class="accordion-button collapsed  text-green" type="button" data-bs-toggle="collapse" data-bs-target="#doc_stage_3" aria-expanded="false" aria-controls="doc_stage_3" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold"> <i class="bi bi-folder-fill mx-2"></i>
                    Stage 3 Documents
                </button>
            </h2>

            <div id="doc_stage_3" class="accordion-collapse collapse" aria-labelledby="doc_head_stage_3" data-bs-parent="#document_stage_3">
                <div class="accordion-body">
                    <div id="download_div" class="mb-2">
                        <a onclick="download_zip(<?= $pointer_id ?>,'stage_3')" class="disabled btn_yellow_green btn"> Download All Stage 3 Documents <i class="bi bi-download"></i></a>
                    </div>

                    <form action="" id="reason_form_stage_3" method="post">
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
                                foreach ($stage_3_documents as $s3_document) {
                                    $documnet_request_s3 = find_one_row('additional_info_request', 'document_id', $s3_document->id);
                                    $show = false;
                                    if (!empty($documnet_request_s3) && $documnet_request_s3->status == "send") {
                                        $s3_disabled_comment = "disabled";
                                        $show = false;
                                    } else {
                                        $show = true;
                                    }
                                      if ($s3_document->required_document_id == 19 ||$s3_document->required_document_id == 43 ||$s3_document->required_document_id == 55) {
                                                
                                                $span='';
                                            }else{
                                                
                                                 $span='<span style="font-size:70%; color:black;">(Additional Information)</span>';
                                                
                                            }
                                    if ($show) {
                                        
                                    $main_validator = check_file_closed($application_pointer, (array)$s3_document);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];
                                ?>
                                        <!-- All Basic Documents ----------------------------->
                                        <tr>
                                            <td class="w-50">
                                                
                                                <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s3_document->name .$span?> </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <!-- download  -->
                                                <a href="<?= $full_url ?>" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>
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
                                                <a onclick="delete_document(<?= $s3_document->id ?>)" class="disabled btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                                <!-- comment  -->
                                                <a href="javascript:void(0)" class="disabled btn <?= $s3_disabled_comment ?> btn-sm btn_green_yellow" id="Dbtn_s3_<?= $count ?>" onclick="show_input_s3('<?= $count ?>')">
                                                    <i class="bi bi-chat-left-dots"></i>
                                                </a>
                                                <a href="javascript:void(0)" style="display: none;" id="Xbtn_s3_<?= $count ?>" class="disabled btn btn_yellow_green btn-sm" onclick="show_input_s3('<?= $count ?>')">
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
                                <!-- Additional Information (if admin want more information) ----------------------->
                                 <tr>
                                <td class="w-50">
                                    <b> Additional Information </b>
                                </td>
                                <td style="text-align: center;">
                                    <a herf="" class="btn btn-sm btn-warning disabled" ><i class="bi bi-download"></i></a>
                                    <a class="btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                    <a href="javascript:void(0)" class="disabled btn btn-sm btn-sm btn_green_yellow" id="Dbtn_s3_Additional" onclick="show_input_s3('Additional')">
                                        <i class="bi bi-chat-left-dots"></i>
                                    </a>
                                    <a href="javascript:void(0)"  class="disabled btn btn-sm btn_yellow_green" style="display: none;" id="Xbtn_s3_Additional" onclick="show_input_s3('Additional')">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="text" id="input_s3_Additional" style="display: none;" onkeyup=check_s3() class="form-control s1" name="request_additional">
                                    <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                    <input type="hidden" name="stage[]" value="stage_3">
                            
                                </td>
                            </tr>
                                <tr>
                                    <?php 
                                    $checks1=find_one_row('stage_3','pointer_id',$pointer_id);
                                //print_r($checks1);
                                if($checks1->status != 'Approved'){
                                    
                                
                                ?>
                                    <td colspan="3">
                                        <button type="submit" class="disabled btn btn_green_yellow" style="display: none; float:right" id="s3_doc_sub_btn" >Request Additional Info</button>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php } ?>
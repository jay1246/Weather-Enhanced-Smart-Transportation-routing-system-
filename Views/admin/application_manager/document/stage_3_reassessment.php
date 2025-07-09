<?php
$show = true;
if (session()->get('admin_account_type') == 'head_office') {
    if ($stage_3_reassessment->status == "Submitted") {
        $show = false;
    }
} ?>
<?php if ($show) { ?>
    <div class="accordion" id="document_stage_3_reassessment">
        <div class="accordion-item">
            <h2 class="accordion-header" id="doc_head_stage_3_reassessment">
                <button class="accordion-button collapsed  text-green" type="button" data-bs-toggle="collapse" data-bs-target="#doc_stage_3_reassessment" aria-expanded="false" aria-controls="doc_stage_3_reassessment" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold"> <i class="bi bi-folder-fill mx-2"></i>
                    Stage 3 (Reassessment) Documents
                </button>
            </h2>

            <div id="doc_stage_3_reassessment" class="accordion-collapse collapse" aria-labelledby="doc_head_stage_3_reassessment" data-bs-parent="#document_stage_3_reassessment">
                <div class="accordion-body">
                    <div id="download_div" class="mb-2">
                        <a onclick="download_zip(<?= $pointer_id ?>,'stage_3_R')" class="btn_yellow_green btn"> Download All Stage 3 (Reassessment) Documents <i class="bi bi-download"></i></a>
                    </div>

                    <form action="" id="reason_form_stage_3_reassessment" method="post">
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
                                foreach ($stage_3_reassessment_documents as $s3_document_r) {
                                    $documnet_request_s3_r = find_one_row('additional_info_request', 'document_id', $s3_document_r->id);
                                    $show = false;
                                    if (!empty($documnet_request_s3_r) && $documnet_request_s3_r->status == "send") {
                                        $s3_r_disabled_comment = "disabled";
                                        $show = false;
                                    } else {
                                        $show = true;
                                    }
                                    if ($show) {
                                ?>
                                        <!-- All Basic Documents ----------------------------->
                                        <tr>
                                            <td class="w-50">
                                                <a class="normal_link" target="_blank" href="<?= base_url() ?>/<?= $s3_document_r->document_path ?>/<?= $s3_document_r->document_name ?>"> <?= $s3_document_r->name  ?> </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <!-- download  -->
                                                <a href="<?= base_url() ?>/<?= $s3_document_r->document_path  ?>/<?= $s3_document_r->document_name  ?>" download="" class="btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>
                                                <?php
                                                $s3_r_disabled_comment = "";
                                                if (isset($s3_document_r->name)) {
                                                    if ($s3_document_r->name  == "Verification Email - Qualification" || $s3_document_r->name  == "Verification Email - Employment") {
                                                        $s3_r_disabled_comment = "disabled";
                                                    }
                                                }
                                                if ($s3_document_r->required_document_id == 0) {
                                                    $s3_r_disabled_comment = "disabled";
                                                }

                                                ?>
                                                <!-- Delete  -->
                                                <a onclick="delete_document(<?= $s3_document_r->id ?>)" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                                <!-- comment  -->
                                                <a href="javascript:void(0)" class="btn <?= $s3_r_disabled_comment ?> btn-sm btn_green_yellow" id="Dbtn_s3_r_<?= $count ?>" onclick="show_input_s3_r('<?= $count ?>')">
                                                    <i class="bi bi-chat-left-dots"></i>
                                                </a>
                                                <a href="javascript:void(0)" style="display: none;" id="Xbtn_s3_r_<?= $count ?>" class="btn btn_yellow_green btn-sm" onclick="show_input_s3_r('<?= $count ?>')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <input type="text" name="reason[]" style="display: none;" onkeyup=check_s3_r() id="input_s3_r_<?= $count ?>" class="form-control s1">
                                                <input type="hidden" name="document_id[]" value="<?= $s3_document_r->id  ?>">
                                                <input type="hidden" name="pointer_id[]" value="<?= $s3_document_r->pointer_id ?>">
                                                <input type="hidden" name="stage[]" value="<?= $s3_document_r->stage ?>">
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
                                    <a herf="" class="btn btn-sm btn_yellow_green disabled" ><i class="bi bi-download"></i></a>
                                    <a class="btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-sm btn_green_yellow" id="Dbtn_s3_Additional" onclick="show_input_s3_r('Additional')">
                                        <i class="bi bi-chat-left-dots"></i>
                                    </a>
                                    <a href="javascript:void(0)"  class="btn btn-sm btn_yellow_green" style="display: none;" id="Xbtn_s3_Additional" onclick="show_input_s3_r('Additional')">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="text" id="input_s3_Additional" style="display: none;" onkeyup=check_s3() class="form-control s1" name="request_additional">
                                    <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                    <input type="hidden" name="stage[]" value="stage_3">
                            
                                </td>
                            </tr>
                            <?php 
                               $checks1=find_one_row('stage_3_reassessment','pointer_id',$pointer_id);
                                //print_r($check);
                                if($checks1->status != 'Approved'){
                                    
                                 ?>
                                <tr>
                                    <td colspan="3">
                                        <button type="submit" class="btn btn_green_yellow" style="display: none; float:right" id="s3_r_doc_sub_btn">Request Additional Info</button>
                                    </td>
                                </tr>
                                <?php  }?>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="accordion mt-1" id="document_stage_1">
    <div class="accordion-item">
        <h2 class="accordion-header" id="doc_head_stage_1">
            <button class="accordion-button collapsed  text-green" type="button" data-bs-toggle="collapse" data-bs-target="#doc_stage_1" aria-expanded="false" aria-controls="doc_stage_1" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                <i class="bi bi-folder-fill mx-2"></i>
                Stage 1 Documents
            </button>
        </h2>

        <div id="doc_stage_1" class="accordion-collapse collapse" aria-labelledby="doc_head_stage_1" data-bs-parent="#document_stage_1">
            <div class="accordion-body">
                <div id="download_div" class="mb-2 ">
                    <a onclick="download_zip(<?= $pointer_id ?>,'stage_1')" class="btn_yellow_green btn disabled"> Download All Stage 1 Documents <i class="bi bi-download"></i></a>
                </div>

                <form action="" id="reason_form_stage_1" method="post">
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
                            $verify_email = 0;
                            
                            foreach ($stage_1_documents as $s1_document) {  ?>
                                <?php
                                $show_f = true;
                                $documnet_request = find_one_row('additional_info_request', 'document_id', $s1_document->id);
                                if (!empty($documnet_request)) {
                                    if (isset($documnet_request->status)) {
                                        if ($documnet_request->status == "send") {
                                            $show_f = false;
                                        }
                                    }
                                }
                                //     $s1_disabled_comment = "disabled";
                                // } else {
                                // if ($documnet_request->status != "send") {
                                if ($show_f) {
                                    
                                    $main_validator = check_file_closed($application_pointer, (array)$s1_document);

                                    $full_url = $main_validator["full_url"];
                                    $full_url_target = $main_validator["full_url_target"];
                                ?>
                                    <!-- All Basic Documents ----------------------------->
                                    
                                    <tr>
                                        <td class="w-50">
                                            <a class="normal_link" <?= $full_url_target ?> href="<?= $full_url ?>"> <?= $s1_document->name  ?> </a>
                                            <?php
                                            // echo $s1_document->required_document_id;
                                            if ($s1_document->required_document_id == 9) {
                                            ?>
                                                <snap style="font-size:70%">(Other Information)</snap>
                                            <?php
                                            } else  if ($s1_document->required_document_id == 28) {
                                            ?>
                                                <snap style="font-size:70%">(Additional Information)</snap>
                                            <?php }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <!-- download  -->
                                            <a href="<?= $full_url  ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a> 
                                            <?php
                                                $s1_disabled_comment = "";
                                                if (isset($s1_document->name)) {
                                                    if ($s1_document->name  == "Verification Email - Qualification" || $s1_document->name  == "Verification - Qualification") {
                                                        $s1_disabled_comment = "disabled";
                                                        $verify_email = 1;
                                                    }
                                                }
                                                if ($s1_document->required_document_id == 0) {
                                                    $s1_disabled_comment = "disabled";
                                                }
                                            
                                            $show = 0;
                                            if (session()->get('admin_account_type') == 'admin') {
                                                // echo $s1_document->required_document_id;
                                                if($s1_document->required_document_id == 1){
                                                ?>
                                                <!--<a href="<= base_url("admin/applicant_agent/agent")?>" class="btn btn-sm btn_green_yellow">-->
                                                <!--    <i class="bi bi-pencil-square"></i>-->
                                                <!--</a>-->
                                                <!-- Button trigger modal -->
                                                <button type="button" disabled class="btn btn-sm btn_green_yellow disabled" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                
                                                <!-- Modal -->

                                            <?php
                                                $show = 1;
                                                }
                                            }
                                            if($show == 0){
                                            ?>
                                            <!-- Delete  -->
                                            <a onclick="delete_document(<?= $s1_document->id ?>)" class="disabled btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <?php 
                                            }
                                            ?>
                                            <!-- comment  -->
                                            <a href="javascript:void(0)" class="disabled btn <?= $s1_disabled_comment ?> btn-sm btn_green_yellow" id="Dbtn_<?= $count ?>" onclick="show_input('<?= $count ?>')">
                                                <i class="bi bi-chat-left-dots"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="display: none;" id="Xbtn_<?= $count ?>" class="btn btn_yellow_green btn-sm" onclick="show_input('<?= $count ?>')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input type="text" name="reason[]" style="display: none;" onkeyup=check() id="input_<?= $count ?>" class="form-control s1">
                                            <input type="hidden" name="document_id[]" value="<?= $s1_document->id  ?>">
                                            <input type="hidden" name="pointer_id[]" value="<?= $s1_document->pointer_id ?>">
                                            <input type="hidden" name="stage[]" value="<?= $s1_document->stage ?>">
                                        </td>
                                    </tr>
                            <?php
                                    $count++;
                                }
                            } ?>
                            
                            <!--Agent Authorization form-->
                           <?php  if(!empty($agent_auth_form)){ ?>
                            <tr>
                                <td>
                                    <a class="normal_link" target="_blank" href="<?= base_url() . '/public/application/' . $pointer_id . '/AgentAuthorisationForm.pdf' ?>"> Agent Authorisation Form </a>


                                </td>
                                <td style="text-align: center;">
                                    <!-- download  -->
                                    <a href="<?= base_url() . '/public/application/' . $pointer_id . '/AgentAuthorisationForm.pdf' ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>
                                    <!-- delete  -->
                                    <a class="disabled btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                    <!-- comment  -->
                                        <a href="" class="btn btn-sm disabled btn_green_yellow"><i class="bi bi-chat-left-dots" disabled></i></a>
                                
                                </td>
                                <td></td>
                            </tr>
                           
                           
                            <?php }  ?>
                            
                            <!-- TRA Application Form ----------------------->
                            <tr>
                                <td>
                                    <a class="normal_link" target="_blank" href="<?= base_url() . '/public/application/' . $pointer_id . '/stage_1/TRA Application Form.pdf' ?>"> TRA Application Form </a>


                                </td>
                                <td style="text-align: center;">
                                    <!-- download  -->
                                    <a href="<?= base_url() . '/public/application/' . $pointer_id . '/stage_1/TRA Application Form.pdf' ?>" download="" class="disabled btn btn-sm btn_yellow_green"><i class="bi bi-download"></i></a>
                                    <!-- delete  -->
                                    <a class="disabled btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                    <!-- comment  -->
                                    <?php if (session()->get('admin_account_type') == 'admin') { ?>
                                        <!-- style="    padding: 2px 4px 0px 4px !important;" -->
                                        <a href="javascript:void(0)" class="btn btn-sm btn_green_yellow disabled" onclick='re_create_TRA()' data-bs-toggle="tooltip" data-bs-html="true" title=" Regenerate TRA Application Form">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>
                                        <!-- <a href="<?= base_url("user/stage_1/application_preview/" . pointer_id_encrypt($pointer_id)) ?>" class="btn btn-sm btn_green_yellow" data-bs-toggle="tooltip" data-bs-html="true" title=" Regenerate TRA Application Form">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a> -->

                                    <?php } else { ?>
                                        <a href="" class="btn btn-sm disabled btn_green_yellow"><i class="bi bi-chat-left-dots"></i></a>
                                    <?php } ?>
                                </td>
                                <td></td>
                            </tr>
                            <!-- Additional Information (if admin want more information) ----------------------->
                            <tr>
                                <td class="w-50">
                                    <b> Additional Information </b>
                                </td>
                                <td style="text-align: center;">
                                    <!-- download  -->
                                    <a herf="" class="btn disabled btn-sm btn_yellow_green " style=" border:0px; background-color: #ffe475 !important; color:black !important"><i class="bi bi-download"></i></a>
                                    <!-- delete  -->
                                    <a class="disabled btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                    <!-- comment  -->
                                    <a href="javascript:void(0)" class="disabled btn btn-sm btn-sm btn_green_yellow" id="Dbtn_Additional" onclick="show_input('Additional')">
                                        <i class="bi bi-chat-left-dots"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="disabled btn btn-sm btn_yellow_green" style="display: none;" id="Xbtn_Additional" onclick="show_input('Additional')">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="text" id="input_Additional" style="display: none;" onkeyup=check() class="form-control s1" name="request_additional">
                                    <input type="hidden" name="pointer_id[]" value="<?= $pointer_id ?>">
                                    <input type="hidden" name="stage[]" value="stage_1">

                                </td>
                            </tr>
                            <tr>
                                <?php 
                                $checks1=find_one_row('stage_1','pointer_id',$pointer_id);
                                //print_r($check);
                                if($checks1->status != 'Approved'){
                                   
                                
                                ?>
                                <td colspan="3">
                                    <button  class="btn btn_green_yellow" style="display: none; float:right" type="submit" id="s1_doc_sub_btn">Request Additional Info</button>
                                </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>

                </form>
                
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <form id="edit_passpost_photo">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Upload Passport Photo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick=remove_photo_file()></button>
                                                          </div>
                                                            <?php 
                                                            $required_list = find_one_row('required_documents_list','id',1);
                                                            $allowed_type = json_decode($required_list->allowed_type); // array data
                                                            $accept = "";
                                                            $accept_note = "";
                                                            $CHECK_LOOP = 0;
                                                            $brack_point = count($allowed_type) - 1;
                                                            foreach ($allowed_type as $key => $value) {
                                                                $accept .= '.' . $value . ',';
                                                                $accept_note .= ' .' . $value;
                                                                $CHECK_LOOP++;
                                                                if ($CHECK_LOOP <= $brack_point) {
                                                                    $accept_note .=   ' /';
                                                                }
                                                            }
                                                            $document= find_one_row_2_field('documents','pointer_id',$pointer_id,'required_document_id',1);
                                                            ?>
                                                          <div class="modal-body">
                                                              <!--<lable>Passpost Photo</lable>-->
                                                            <input name="file" type="file"  accept=<?= $accept ?> class="form-control s1" id="edit_passpost_photo_file" >
                                                            <input type="hidden" name="document_id"  class="form-control" id="edit_passpost_photo_document_id" value="<?= $document->id ?>">
                                                            <input type="hidden" name="document_old_name"  class="form-control" id="edit_passpost_photo_document_old_name" value="<?= $document->document_name ?>">
                                                            
                                                            <div class="text-danger col-sm-6 ">
                                                                Only : <?= $accept_note ?>
                                                            </div>
                                                          </div>
                                                          <div class="modal-footer">
                                                             <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal" onclick=remove_photo_file()>Close</button>
                                                            <button class="btn btn_green_yellow" onclick=edit_passpost_photo()>Upload</button>
                                                        
    
                                                            <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                                                            <!--<button type="submit" class="btn btn-primary">Save</button>-->
                                                          </div>
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>

                <?php
                if (session()->get('admin_account_type') == 'admin') {
                ?>
                        <div class="row">
                            <?php 
                            // if ($stage_2 == "") {
                            $qualification_email_verification = quali_email_verf($pointer_id);
                            // print_r($qualification_email_verification);
                            // // $verify_email = 1 ;
                            // $show_qulifaction = false;
                            
                            // if(empty($qualification_email_verification)){
                            //     $show_qulifaction = true;
                            //     echo "qualification_email_verification";
                            // }
                            // if($verify_email != 1){
                            //     $show_qulifaction = true;
                            //     echo "verify_email";
                            // }
                            // else{
                            //     $show_qulifaction = false;
                            // }
                            //  echo $verify_email;
                            if (empty($qualification_email_verification)  && $verify_email != 1) {
                            ?>
                            <div class="col-md-12">
                                <a href="" data-bs-toggle="modal" data-bs-target="#Send_Qualifiation_Verification_Email" class="btn btn_green_yellow"> 
                                    Send Qual Verification Email
                                </a>

                                <!--<button id="Send_Qualifiation_Verification_Email" class="btn btn_green_yellow" onclick="send_quali_verify_email()">  </button>-->
                            </div>
                               <div class="modal" id="Send_Qualifiation_Verification_Email" >
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center text-green">Qualification Verification</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" style="line-height:2">
                                                        <div class="col-12">
                                                            <label>PRN <span class="text-danger">*</span></label>
                                                            <input type="text" name="prn" disabled class="form-control" id="prn" value="<?= portal_reference_no($pointer_id);?>">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="name">Applicant Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" disabled class="form-control" id="name" value="<?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " "?>">
                                                        </div>
                                                    <form class="quali_verify_form"  id="quali_verify_form" action="" method="post" enctype="multipart/form-data">
                                                        <div class="col-12">
                                                            <label for="email">Email ID <span class="text-danger">*</span></label>
                                                            <input type="hidden" name="pointer_id"  class="form-control" id="pointer_id" value="<?= $pointer_id ?>">
                                                            <input type="email" name="email"  class="form-control" id="email" required list="email_master" autocomplete="off">
                                                        </div>
                                                        <div class="col-12 ">
                                                            <label for="office_address">CC - Email ID</label>
                                                                <div class="input-group mb-2" >
                                                                    <input type="email" name="email_cc[]" id="email_cc"  style="margin-right: 20px;" class="form-control" list="email_master" autocomplete="off">
                                                                    <div>
                                                                        <button type="button" onclick="add_more_input_('add_more_input_for_multiple')" class="btn btn_yellow_green add_button ml-3">
                                                                            <i class="bi bi-plus-lg"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            <div id="add_more_input_for_multiple">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <datalist id="email_master">
                                                           
                                                        <?php 
                                                        //helper
                                                         $email_master= get_tb('email_master');
                                                        foreach($email_master as $email){
                                                        ?>
                                                        <option value="<?= $email["email"] ?>" >
                                                        
                                                        <?php  
                                                        }
                                                        ?>
                                                          </datalist>
                                                            </div>
                                                        <div class="col-12">
                                                            <label for="contact_details">Qualification Docs </label>
                                                            <?php
                                                                $doc_qul = 1;
                                                                foreach ($stage_1_documents as $s1_document) { 
                                                                if($s1_document->required_document_id == 4 ){
                                                                ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="document_ids[]" class="qulification_doc_id" type="checkbox" value="<?= $s1_document->id ?>">
                                                                    <label class="form-check-label" for="<?= $s1_document->name  ?>">
                                                                        <a class="text-blue" href="<?= base_url($s1_document->document_path.'/'.$s1_document->document_name ) ?>" target="_blank"> <?= $s1_document->name  ?> </a>
                                                                    </label>
                                                                </div>
                                                            <?php
                                                            $doc_qul++;
                                                            }}
                                                            ?>
                                                        </div>
                                                    </form>
                                                </div>
                                                    <div class="row">
                                                        <label for="office_address">File</label>
                                                        <div class="col-10">
                                                            <input type="file" name="extra_file[]" class="form-control" multiple id="extra_file" accept="application/pdf">
                                                            <div class="text-danger">Only :  .pdf</div>
                                                            <div id="extra_doc">
                                                            <?php 
                                                            $extra_docs = find_multiple_row_2_field('documents','pointer_id',$pointer_id,'required_document_id',50);
                                                            if($extra_docs){
                                                                foreach($extra_docs as $extra_doc){
                                                            ?>
                                                                <div id="extr_doc-<?= $extra_doc->id ?>" class="row mb-2">
                                                                    <a class="text-blue col-11" target="_blank" style="color:var(--green)" href="<?= base_url() ?>/<?= $extra_doc->document_path ?>/<?= $extra_doc->document_name ?>"> <?= $extra_doc->document_name  ?> </a>
                                                                    <a onclick="delete_file_qualif_verfi_stafe_1(<?= $extra_doc->id ?>)" class="col-1 disabled btn btn-sm btn-danger">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </a>
                                                                </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                        <div class= "col-2">
                                                            <button onclick=file_upload() class="float-end btn btn_green_yellow">Upload</button>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding-top: 20px;">
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>
                                                            <button  class="btn btn_green_yellow" onclick=upload_form()>Send Mail</button>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                      <?php 
                            }
                            // }
                      ?>
                            <br>
                    <?php 
                    if ($verify_email != 1) {
                        ?>
                            <div class="col-sm-4 my-4">
                                <form action="" id="verify_email_stage_1" method="post">
                                    <h5> Verification - Qualification </h5>
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
                            
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
function remove_photo_file(){
    var fileInput = document.getElementById("edit_passpost_photo_file");
    fileInput.value = "";
 
}
    var count = 0;
    function add_more_input_(div_id) {
        var data = `<div id="wrapper-${count}" class="row mb-2"> 
                        <div class="col-11">
                            <input type="email" name="email_cc[]" id="email_cc" class="form-control" list="email_master" autocomplete="off">
                        </div>
                        <div class="col-1">
                            <button type="button" onclick="cancel('wrapper-${count}')" class="btn btn-danger delete_button float-end">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>`;

        count++;
        $("#" + div_id).prepend(data);
    }

    function cancel(id){
        var div = document.getElementById(id);
        div.parentNode.removeChild(div);

    }
    
    function file_upload() {
        var fileInput = document.getElementById("extra_file");

        var files = fileInput.files;
        
        if (files.length === 0) {
            custom_alert_popup_show(header = '', body_msg = "Please select a file.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
            return false;
        }
        
        var formData = new FormData();
        
        for (var i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }
        var pointer_id = '<?=$pointer_id?>';
        formData.append("pointer_id", pointer_id);
        $('#cover-spin').show();
        $.ajax({
            'url': '<?= base_url("admin/application_manager/qualification_verification_file") ?>',
            'type': 'POST',
            'data': formData,
            'contentType': false,
            'processData': false,
            success: function(data) {
            data = JSON.parse(data);
                if (data["response"] == true) {
                    $('#cover-spin').hide(0);
                    data['document_ids'];
                    console.log(data['document_ids']);
                    draw_doc(data['document_ids'])
                    
                } else {
                    alert(data["msg"]);
                    $('#cover-spin').hide(0);
                }
            }
        });
        
        // return;
    }
    
    var sr = 0;
    function draw_doc(doc_ids) {
        for (var i = 0; i < doc_ids.length; i++) {
            // console.log(doc_ids[i].id);
        var doc_id = doc_ids[i].id;
        var file_name = doc_ids[i].file_name;
        var file_path = doc_ids[i].file_path;
//        
        var data = `<div id="extr_doc-${doc_id}" class="row mb-2">
                        <a class="col-11 text-blue" target="_blank" style="color:var(--green)" href="<?= base_url() ?>/${file_path}">${file_name}</a>
                        
                        <a onclick="delete_file_qualif_verfi_stafe_1(${doc_id})" class="col-1 disabled btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </div>`;
        sr++;
        $("#extra_doc").prepend(data);
    }
    var fileInput = document.getElementById("extra_file");
    fileInput.value = "";
    }
    function delete_file_qualif_verfi_stafe_1(document_id){
        var document_id = document_id;
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_quali_verfi_file_delete');
        // check Btn click
        $("#stage_1_quali_verfi_file_delete").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_1_quali_verfi_file_delete')) {
            console.log(document_id);
       
                $('#cover-spin').show();
                $.ajax({
                    'url': '<?= base_url("admin/application_manager/delete_file_qulifiaction_verfication") ?>',
                    'type': 'POST',
                    'data': {
                        'document_id': document_id,
                    },
                    success: function(data) {
                    data = JSON.parse(data);
                        if (data["response"] == true) {
                            $('#cover-spin').hide(0);
                            data['document_ids'];
                            console.log(data['document_id']);
                            var id ="extr_doc-"+data['document_id'];
                            console.log(id);
                            var extra_files = document.getElementById(id);
                            if (extra_files) {
                              extra_files.remove();
                            }// var extr_doc = document.getElementById("extr_doc");
                            // extr_doc.remove();
                            // draw_doc(data['document_ids'])
                            
                        } else {
                            alert(data["msg"]);
                            $('#cover-spin').hide(0);
                        }
                    }
                });
            }
        });
    }
//     function draw_doc(doc_ids) {
//     for (var i = 0; i < doc_ids.length; i++) {
//         var file_name = doc_ids[i].file_name;
//         var file_path = doc_ids[i].file_path;
//         var data = `<div id="extr_doc-${sr}" class="row mb-2">
//                         <a class="text-blue" target="_blank" style="color:var(--green)" href="${file_path}/${file_name}">${file_name}</a>
//                     </div>`;
//         sr++;
//         $("#extra_doc").prepend(data);
//     }
// }


    function upload_form() {
        var form = document.getElementById("quali_verify_form");
        var formData = new FormData(form);
        var email = formData.get("email");
        var email_cc = formData.get("email_cc");
        var document_ids = formData.getAll("document_ids[]");
    
        if (!email) {
            custom_alert_popup_show('', 'Email is required.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'delete_pop_btn');
            return false;
        }
    
        var extra_files = false;
        var pointer_id = '<?= $pointer_id ?>';
    
        $.ajax({
            url: '<?= base_url("admin/application_manager/check_extra_files") ?>',
            type: 'POST',
            data: {
                pointer_id: pointer_id
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.response) {
                    extra_files = true;
                } else {
                    extra_files = false;
                }
    
                // Perform the validation after the AJAX request completes
                performValidation();
            },
            error: function() {
                // Handle error response from the server
            }
        });
    
        function performValidation() {
            console.log(extra_files);
            console.log(document_ids.length);
            if (!(extra_files) && document_ids.length === 0) {
                custom_alert_popup_show('', 'One document is required.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'delete_pop_btn');
                return false;
            }
    
            // Continue with further code execution if the validation passes
            custom_alert_popup_show('', 'Are you sure you want to Send Qualification Verification Email ?', 'No', 'btn-danger', true, 'Yes', 'btn_green_yellow', 'stage_1_quali_verfi_emil_pop_btn');
        
    
            // check Btn click
            $("#stage_1_quali_verfi_emil_pop_btn").click(function() {
                // if return true 
                if (custom_alert_popup_close('stage_1_quali_verfi_emil_pop_btn')) {
                    $('#cover-spin').show(0);
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("admin/application_manager/qualification_verification_form") ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = JSON.parse(data);
                            if (data.response) {
                                $('#cover-spin').hide(0);
                                window.location.reload();
                            } else {
                                alert(data.msg);
                                $('#cover-spin').hide(0);
                            }
                        }
                    });
                }
            });
        }    
    };

function edit_passpost_photo() {
    event.preventDefault();
    // console.log()
    var fileInput = document.getElementById("edit_passpost_photo_file");
    var document_id = document.getElementById("edit_passpost_photo_document_id").value;
    var document_old_name = document.getElementById("edit_passpost_photo_document_old_name").value;
    console.log(document_id);
    console.log(document_old_name);
    var file = fileInput.files[0];
    console.log(file);
    var formData = new FormData();
    formData.append('file', file);

    var pointer_id = '<?=$pointer_id?>';
    formData.append("pointer_id", pointer_id);
    formData.append("document_id", document_id);
    formData.append("document_old_name", document_old_name);
       
    if (!file) {
        custom_alert_popup_show('', 'Please select a file.', 'Ok', 'btn-danger', false, 'Yes', 'btn_green_yellow', 'file_edit_pop_btn');
        return false;
    }
   
    // if (custom_alert_popup_close('stage_1_edit_passpost_photo_pop_btn')) {
    //     // Rest of your code
    // }


        custom_alert_popup_show('', 'Are you sure you want to update passport photo ?', 'No', 'btn-danger', true, 'Yes', 'btn_green_yellow', 'stage_1_edit_passpost_photo_pop_btn');
        // return;
     $(document).on("click", "#stage_1_edit_passpost_photo_pop_btn", function(event) {
        event.preventDefault();

        // $("#stage_1_edit_passpost_photo_pop_btn").click(function() {
        // if return true 
            if (custom_alert_popup_close('stage_1_edit_passpost_photo_pop_btn')) {
                $('#cover-spin').show(0);
                    // $('#cover-spin').show();
                
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/edit_passpost_photo") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        
                    // 'url': '<= base_url("admin/application_manager/edit_passpost_photo") ?>',
                    // 'type': 'POST',
                    // 'data': formData,
                    // 'contentType': false,
                    // 'processData': false,
                    // success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            $('#cover-spin').hide(0);
                            window.location.reload();
                        } else {
                            alert(data["msg"]);
                            $('#cover-spin').hide(0);
                        }
                    }
                });
            }
        // });
        
     });
}

</script>

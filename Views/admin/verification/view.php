<?= $this->extend('template/admin_template') ?>

<?= $this->section('main') ?>
<main id="main" class="main">
    <div class="pagetitle">
            <?php if($applicant->stage == 'stage_2'){ ?>
        <h4 class="text-green">Referee Details</h4>
        <?php 
            }else{?>
        <h4 class="text-green">RTO Details</h4>
        <?php }?>
    </div><!-- End Page Title -->
    <?php
    //  $this->include("alert_box.php");
    ?>
    <style>
        tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }
    </style>
    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table ">
                            <tbody>
                               
                                <tr>
                                    <th width="25%"><b>PRN </b></th>
                                    <td>:</td>
                                    <td>
                                        <b><?php
                                            echo portal_reference_no($pointer_id);
                                            ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="25%"><b>Application No.</b></th>
                                    <td>:</td>  
                                    <td>
                                        <b><?php
                                            echo get_unique_number($pointer_id);
                                            ?></b>
                                    </td>
                                </tr>
                                
                                
                                <tr>
                                    <th width="25%"><b>Applicant Name</b></th>
                                    <td>:</td>
                                    <td><?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?></td>
                                </tr>
                                
                                <?php
                                   if($user_account->account_type == 'Agent')
                                  {
                                ?>
                                <tr>
                                    <th width="25%"><b>Agent Name</b></th>
                                    <td>:</td>
                                    <td>
                                        <?=
                                        $user_account->name . " " . $user_account->middle_name . " " . $user_account->last_name
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                                <?php
                                   if($user_account->account_type == 'Agent')
                                  {
                                ?>
                                <tr>
                                    <th width="25%"><b>Agency</b></th>
                                    <td>:</td>
                                    <td>
                                        <?=
                                        $user_account->business_name
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                                <?php
                                   if($user_account->account_type == 'Agent')
                                  {
                                ?>
                                
                                <tr>
                                    <th width="25%"><b>Agent Contact No.</b></th>
                                    <td>:</td>
                                    <td>
                                        <?php $mobile_code = find_one_row('country', 'id', $user_account->mobile_code);
                                        echo "+" . $mobile_code->phonecode . " " . $user_account->mobile_no ?>
                                    </td>
                                </tr>
                                <?php }else{ ?>
                                  <tr>
                                    <th width="25%"><b>Applicant Contact No.</b></th>
                                    <td>:</td>
                                    <td>
                                        <?php $mobile_code = find_one_row('country', 'id', $user_account->mobile_code);
                                        echo "+" . $mobile_code->phonecode . " " . $user_account->mobile_no ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if($applicant->stage == 'stage_2'){ ?>
                            <!--  Table with stripped rows starts -->
                            <table id="" class="table" style="background-color: #f6f6f6;">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Referee Name </th>
                                        <th>Referee Email ID</th>
                                        <th>Referee Contact No</th>
                                        <th>Company/Organisation Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($employs as $employ) { ?>
                                        <tr>
                                            <th><?= $count ?></th>
                                            <td><?= $employ->referee_name ?></td>
                                            <td><?= $employ->referee_email ?></td>
                                            <td>
                                                <?php
                                                // echo $employ->referee_mobile_number_code;
                                                $ref_mobile_code = find_one_row('country', 'id', $employ->referee_mobile_number_code);
                                                echo "+" . $ref_mobile_code->phonecode . " " . $employ->referee_mobile_number ?>
                                            </td>
    
                                            <td>
                                                <?= $employ->company_organisation_name ?>
                                            </td>
                                            <td>
    
    
                                                <?php
                                                $email_verification = find_one_row('email_verification', 'employer_id', $employ->id);
    
                                                if (isset($email_verification)) {
                                                    $verification_email_send = $email_verification->verification_email_send;
                                                    $is_verification_done = $email_verification->is_verification_done;
                                                } else {
                                                    $verification_email_send = 0;
                                                    $is_verification_done = 0;
                                                }
    
    
                                                if ($is_verification_done == 1) {
                                                    $url_Verified = base_url('admin/verification/Change_status/' . $pointer_id . '/' . $employ->id . '/Verified');
                                                ?>
                                                    <a onclick="update_data('<?= $url_Verified ?>')" id="ver_url">
                                                        <span class='text-green'>Verified</span>
                                                    </a>
    
                                                <?php
                                                } else
                                                if ($verification_email_send == 1) {
                                                    $url_Pending = base_url('admin/verification/Change_status/' . $pointer_id . '/' . $employ->id . '/Pending');
                                                ?>
                                                    <a onclick="update_data('<?php echo $url_Pending; ?>')" id="pending_url">
                                                        <span class='text-blue' style="color:blue !important">Pending</span>
                                                    </a>
                                                <?php
                                                } else {
                                                    echo "[#T.B.A]";
                                                }
                                                ?>
    
    
    
                                            </td>
    
                                            <td>
                                                <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>
                                            </td>
    
                                        </tr>
    
                                        <!-- modal box for edit -->
                                        <div class="modal" id="edit_form<?= $count ?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center text-green">Edit Referee Details</h5>
                                                    </div>
                                                    <div class="modal-body">
    
                                                        <!-- <form class="edit_data" id="edit_data<?= $pointer_id . $employ->id ?>" action="" method="post"> -->
                                                        <form class="edit_data" id='resend_form_<?= $pointer_id . $employ->id ?>' action="<?= base_url('admin/verification/edite_and_email_send/' . $pointer_id . '/' . $employ->id) ?>" method="post" autocomplete="off">
                                                            <div class="row">
                                                                <div>
                                                                    <label>Applicant Name <span class="text-danger">*</span></label>
                                                                    <input name="employer_name" type="text" class="form-control mb-2" value="<?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?>" disabled>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label>Company/Organisation Name <span class="text-danger">*</span></label>
                                                                    <input name="company_organisation_name" type="text" class="form-control mb-2" value="<?= $employ->company_organisation_name ?>" disabled>
                                                                    <input type="hidden" name="pointer_id" class="form-control mb-2" value="<?= $pointer_id ?>">
                                                                    <input type="hidden" name="employer_id" class="form-control mb-2" value="<?= $employ->id ?>">
                                                                </div>
                                                                <!-- vishal patel 28-04-2023  -->
                                                                <div class="col-12">
                                                                    <label>Select Document :</label>
                                                                    <?php
                                                                    foreach ($documents as $key => $value) {
                                                                        $document_id = $value->id;
                                                                        $employee_id = $value->employee_id;
                                                                        $required_document_id = $value->required_document_id;
                                                                        $document_name = $value->name;
                                                                        $document_file_name = $value->document_name;
                                                                        $document_path = $value->document_path;
    
                                                                        if ($employ->id == $employee_id) {
                                                                            if ($required_document_id != 10) {
                                                                                $email_verification = find_one_row('email_verification', 'employer_id', $employ->id);
                                                                                $document_ids_json =  isset($email_verification->document_ids) ? $email_verification->document_ids : "";
                                                                                $checked = "";
                                                                                if (!empty($document_ids_json)) {
                                                                                    if (!empty($required_document_id)) {
                                                                                        if (strpos($document_ids_json, $document_id) !== false) {
                                                                                            $checked = "checked";
                                                                                        }
                                                                                    }
                                                                                }
                                                                    ?>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" <?= $checked ?> name="document_ids[]" type="checkbox" value="<?= $document_id ?>" id="<?= $document_file_name ?>">
                                                                                    <label class="form-check-label" for="<?= $document_file_name ?>">
                                                                                        <a class="text-blue" href="<?= base_url($document_path . "/" . $document_file_name) ?>" target="_blank"> <?= $document_name ?> </a>
                                                                                    </label>
                                                                                </div>
                                                                    <?php  }
                                                                        }
                                                                        # code...
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <!--/ vishal patel 28-04-2023  -->
                                                                <div class="col-12">
                                                                    <label>Referee Name <span class="text-danger">*</span></label>
                                                                    <input name="referee_name" type="text" class="form-control mb-2" value="<?= $employ->referee_name ?>">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label>Referee Email ID <span class="text-danger">*</span></label>
                                                                    <input name="referee_email" type="email" class="form-control mb-2" autocomplete="false" value="<?= $employ->referee_email ?>" list="email_master" >
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
                                                            </div>
                                                            <div class="row">
                                                                <div class="text-end">
                                                                    <!--<button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>-->
                                                                    <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('resend_form_<?= $pointer_id . $employ->id ?>')" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" onclick="save_send('resend_form_<?= $pointer_id . $employ->id ?>');" class="btn btn_green_yellow">Save & Send</button>
    
                                                                    <!-- <button type="button" onclick="save_send('edit_data<?= $pointer_id . $employ->id  ?>');" class="btn btn_green_yellow">Save & Send</button> -->
                                                                </div>
                                                            </div>
    
                                                        </form>
    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- modal box for edit end -->
    
    
                                    <?php
                                        $count++;
                                    }  ?>
    
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        <?php 
                        } if($applicant->stage == 'stage_1'){?>
                            <table id="" class="table" style="background-color: #f6f6f6;">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Email ID</th>
                                    <th>CC - Email ID</th>
                                    <!--<th>Company/Organisation Name</th>-->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                        <?php
                                         $qualification_email_verification = quali_email_verf( $applicant->id);
                                            // print_r($qualification_email_verification);
                                            // exit;
                                            // $email_verification = find_one_row('email_verification', 'employer_id', $employ->id);
    
                                            if (isset($qualification_email_verification)) {
                                                $verification_email_send = $qualification_email_verification->verification_email_send;
                                                $is_verification_done = $qualification_email_verification->is_verification_done;
                                            } else {
                                                $verification_email_send = 0;
                                                $is_verification_done = 0;
                                            }
                                        ?>
                                    <td><?=$qualification_email_verification->verification_email_id ?></td>
                                    <td><?=$qualification_email_verification->email_cc_id ?></td>
                                    <td>
                                        <?php
                                        if($verification_email_send == 1) {
                                            // echo $is_verification_done ;
                                        if ($is_verification_done == 1) {
                                        ?>
                                            <a onclick="quli_update_data(<?= $qualification_email_verification->id?>,'Verified')">
                                                <span class='text-green'>Verified</span>
                                            </a>
                                        <?php
                                        } else{
                                        ?>
                                            <a onclick="quli_update_data(<?=$qualification_email_verification->id?>,'Pending')">
                                                <span class='text-blue' style="color:blue !important">Pending</span>
                                            </a>
                                        <?php
                                        } }else {
                                            echo "[#T.B.A]";
                                        }
                                        ?>



                                    </td>
                                    <td>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#edit_form_qualification" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>
                                    </td>
    
                                </tr>
    
                                <!-- modal box for edit for qualification -->
                                <div class="modal" id="edit_form_qualification">
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content" style="background-color: white;">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center text-green">Edit RTO Details</h5>
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
                                                    <form class="quali_verify_form"  id="quali_verify_form" action="" method="post" autocomplete="off">
                                                        <div class="col-12">
                                                            <label for="email">Email ID <span class="text-danger">*</span></label>
                                                            <input type="hidden" name="pointer_id"  class="form-control" id="pointer_id" value="<?= $pointer_id ?>">
                                                            <input type="hidden" name="email_id"  class="form-control"  value="<?= $qualification_email_verification->id ?>">
                                                            <input type="email" name="email"  class="form-control" id="email" value="<?=$qualification_email_verification->verification_email_id?>" list="email_master" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="office_address">CC - Email ID </label>
                                                            <?php
                                                            $list_email_cc =   explode(", ",$qualification_email_verification->email_cc_id);
                                                            // print_r($list_email_cc);
                                                            $count = 50;
                                                            foreach($list_email_cc as $email_cc){
                                                             ?>
                                                            <div id="wrapper-<?=$count?>" class="input-group mb-2" >
                                                                <input type="email" name="email_cc[]" id="email_cc"  value="<?=$email_cc?>" list="email_master"  style="margin-right: 20px;" class="form-control">
                                                            <?php
                                                            if($count == 50){
                                                                ?>
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
                                                                <div>
                                                                    <button type="button" onclick="add_more_input_('add_more_input_for_multiple')" class="btn btn_yellow_green add_button ml-3">
                                                                        <i class="bi bi-plus-lg"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }else{
                                                            ?>
                                                                <div>
                                                                    <button type="button" onclick="cancel('wrapper-<?=$count?>')" class="btn btn-danger delete_button ml-3">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }
                                                            $count++;
                                                            }
                                                            // echo $count++;
                                                            ?>
                                                            
                                                            <div id="add_more_input_for_multiple">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="contact_details">Qualification Docs </label>
                                                            <?php
                                                                $doc_qul = 1;
                                                                $checked = '';
                                                                foreach ($stage_1_documents as $s1_document) { 
                                                                if($s1_document->required_document_id == 4 ){
                                                                    $list_doc_email =   explode(", ",$qualification_email_verification->document_ids);
                                                                    // print_r($list_doc_email);
                                                                    // echo $s1_document->id;
                                                                    $checked = '';
                                                                    foreach($list_doc_email as $list){
                                                                        if ($list == $s1_document->id) {  // Use assignment operator '=' instead of comparison operator '=='
                                                                        $checked = 'checked';
                                                                        }
                                                                    }
                                                                
                                                                ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" <?=$checked?> name="document_ids[]" type="checkbox" value="<?= $s1_document->id ?>">
                                                                    <label class="form-check-label" for="<?= $s1_document->name ?>">
                                                                        <a class="text-blue" href="<?= base_url($s1_document->document_path.'/'.$s1_document->document_name ) ?>" target="_blank"> <?= $s1_document->name  ?> </a>
                                                                    </label>
                                                                </div>
                                                            <?php
                                                            $doc_qul++;
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </form>
                                                </div>
                                                    <div class="row">
                                                        <label for="office_address">Additional Document </label>
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
                                                                    <a onclick="delete_file_qualif_verfi_stafe_1(<?= $extra_doc->id ?>)" class="col-1 btn btn-sm btn-danger">
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
                                                 <button type="button" class="btn btn_yellow_green" onclick="hide_model_box('quali_verify_form')" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn_green_yellow" onclick=upload_form()>Save & Send</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal box for edit for qualification end -->
    
                                </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>



<?= $this->endSection() ?>
<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
    $(document).ready(function() {
        $('#employ_table').DataTable();
    });

    function update_data(url) {
        //c//onsole.log(url);
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to update the status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'update_btn');
        $("#update_btn").click(function() {

            if (custom_alert_popup_close('update_btn')) {
                // if (confirm("Are you sure you want to delete this Occupation?")) {  
                window.location = url;


            }
        });
    }
    function quli_update_data(id,status) {
        //c//onsole.log(url);
        console.log(id);
        console.log(status);
        // return;
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to update the status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'qual_update_btn');
        $("#qual_update_btn").click(function() {

            if (custom_alert_popup_close('qual_update_btn')) {
                $('#cover-spin').show(0);
                $.ajax({
                    'type': "POST",
                    'url': "<?= base_url("admin/verification/change_status_quali") ?>",
                    'data': {
                        'id': id,
                        'status': status,
                    },
                    success: function(data) {
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
        });
    }



    function save_send(data) {
        //c//onsole.log(url);
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to send the verification email ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'save_send_');
        $("#save_send_").click(function() {
            var myForm = document.getElementById(data);
            myForm.submit();
            $('#cover-spin').show(0);
            // console.log(data + "-------------------------------------------");
        });
    }


    function Alert() {
        var confirmation = confirm("Are you sure you want to change the status?");
        if (confirmation) {
            return true;
        }
        return false;
    }
    var count = 0;
    function add_more_input_(div_id) {

        var data = `<div id="wrapper-${count}" class="row mb-2"> 
                        <div class="col-11">
                            <input type="email" name="email_cc[]" id="email_cc" class="form-control">
                        </div>
                        <div class="col-1">
                            <button type="button" onclick="cancel('wrapper-${count}')" class="btn btn-danger delete_button float-end">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>`;

        count++;

        //$("#" + div_id).append(data);
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
    //hode closed button data
    //srart
    function hide_model_box(id){
        var element = document.getElementById(id);

        element.classList.remove("show");
        element.style.display = "none";
        element.removeAttribute("role");
          element.removeAttribute("role");
        //   var backdrop = document.querySelector('.modal-backdrop.fade.show');

// Remove the backdrop element from the DOM
// backdrop.parentNode.removeChild(backdrop);
        // .modal-backdrop

        var bodyElement = document.body;
        bodyElement.style = null;
// Get a reference to the <body> element

// Remove a class from the <body> element
bodyElement.classList.remove("modal-open");

// class="modal-open"
// style="overflow: hidden; padding-right: 0px;"
            window.location.reload();
                $("#"+id).hide();

    }
    //end 
    function upload_form(){
        var form = document.getElementById("quali_verify_form");
       var formData = new FormData(form);
        var email = formData.get("email");
        var email_cc = formData.get("email_cc");
        var document_ids = formData.getAll("document_ids[]");
     
        if (!$("#email").val()) {
            custom_alert_popup_show(header = '', body_msg = "email is required.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
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
    
        
            custom_alert_popup_show(header = '', body_msg = "Are you sure you want to Send Qualification Verification Email ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_quali_verfi_emil_pop_btn');
            // check Btn click
            $("#stage_1_quali_verfi_emil_pop_btn").click(function() {
                // if return true 
                if (custom_alert_popup_close('stage_1_quali_verfi_emil_pop_btn')) {
                    $('#cover-spin').show(0);
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("admin/verification/edit_qualification_verification_form") ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
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
            });
        }
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
                        <a onclick="delete_file_qualif_verfi_stafe_1(${doc_id})" class="col-1 btn btn-sm btn-danger">
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

    // $("#quali_verify_form").submit(function(e) {
    //     e.preventDefault();
    //     $("#loader-please-wait").show();
    //     var formData = new FormData($(this)[0]);
    //      custom_alert_popup_show(header = '', body_msg = "Are you sure you want to Send Qualification Verification Email ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_quali_verfi_emil_pop_btn');
    //     // check Btn click
    //     $("#stage_1_quali_verfi_emil_pop_btn").click(function() {
    //         // if return true 
    //         if (custom_alert_popup_close('stage_1_quali_verfi_emil_pop_btn')) {
    //             $('#cover-spin').show(0);
    //             $.ajax({
    //                 method: "POST",
    //                 url: "<?= base_url("admin/verification/edit_qualification_verification_form") ?>",
    //                 data: formData,
    //                 processData: false,
    //                 contentType: false,
    //                 success: function(data) {
    //                     data = JSON.parse(data);
    //                     if (data["response"] == true) {
    //                         $('#cover-spin').hide(0);
    //                         window.location.reload();
    //                     } else {
    //                         alert(data["msg"]);
    //                         $('#cover-spin').hide(0);
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });
    
</script>
<style>
    #cover-spin {
        position: fixed;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(251, 251, 251, 0.6);
        z-index: 9999;
        display: none;
    }

    #loader_img {
        position: fixed;
        left: 50%;
        top: 50%;
    }
</style>
<div id="cover-spin">
    <div id="loader_img">
        <img src="<?= base_url("public/assets/image/admin/loader.gif") ?>" style="width: 100px; height:auto">
    </div>
</div>
<?= $this->endSection() ?>
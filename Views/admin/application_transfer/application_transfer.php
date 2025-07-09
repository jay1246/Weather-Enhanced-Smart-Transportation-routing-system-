<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>


<div class="container" style="margin-top: 133px ">
    <div class="pagetitle">
        <h4 style="color: #055837;"> Application Transfer</h4>
    </div><!-- End Page Title -->

    <br>

    <div class="accordion-item">
        <h2 class="accordion-header" id="view_head_applicant_details">
            <button class="accordion-button collapsed text-green" type="button" data-bs-toggle="collapse" data-bs-target="#view_applicant_details" aria-expanded="false" aria-controls="view_applicant_details" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Applicant's Details
            </button>
        </h2>
        <div class="card shadow mt-1">
            <div class="card-body">
                <table class="table table-striped border table-hover rounded">
                    <tbody>
                        <tr>
                            <td width="30%">Applicant's Name</td>
                            <td class="w-25">
                                <!-- <?= $application_preferred_title ?>s -->
                                <?= $application_first_or_given_name ?>
                                <?= $application_middle_names ?>
                                <?= $application_surname_family_name ?>

                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Email Address</td>
                            <td class="w-25">
                                <?= $application_email ?>

                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Contact Number</td>
                            <td class="w-25">

                                +<?= $application_mobile_number_code ?> <?= $application_mobile_number ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Occupation</td>
                            <td class="w-25">
                                <?= $application_occupation_id ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Program</td>
                            <td class="w-25">
                                <?= $application_program ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Pathway</td>
                            <td class="w-25" id="pathway">
                                <?= $application_pathway ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="display: flex;" class="mt-3">
        <div class="col-sm-6" style="padding-right: 10px !important;">
            <div class="card shadow">
                <div class="card-body">
                    <span class=" collapsed text-green " style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                        From :
                    </span> <br>
                    <table class="table table-striped border table-hover rounded">
                        <tbody>
                            <tr>
                                <td width="30%">
                                    Name
                                </td>
                                <td class="w-25">
                                    <?= $old_user_account_name ?> <?= $old_user_account_middle_name ?> <?= $old_user_account_last_name ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">
                                    Business Name
                                </td>
                                <td class="w-25">
                                    <?= $old_user_account_business_name ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">
                                    Email
                                </td>
                                <td class="w-25">
                                    <?= $old_user_account_email ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">
                                    Account Type
                                </td>
                                <td class="w-25">
                                    <?= $old_user_account_account_type ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-6" style="padding-left: 10px !important;">
            <div class="card shadow">
                <div class="card-body" style="    height: 233px;">
                    <form id="form">
                    <span class=" collapsed text-green " style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                        To : </span>

                    <br>
                    <select name="new_agent" id="new_agent" class="mt-2 form-select" required>
                        
                        <?php
                        if($File_check == true){
                        ?>
                        <option selected value="<?=$old_user_account_id?>"><?= $old_user_account_name ?><?= $old_user_account_last_name ?>(<?= $old_user_account_email ?>)</option>
                        <?php
                        }else{
                          ?>
                            <option selected value="">Select Agent/Applicant</option>
                          <?php
                        }
                        foreach ($list_of_user as $kay => $val) {
                            $id =  $val['id'];
                            $name =  $val['name'];
                            $middle_name =  $val['middle_name'];
                            $last_name =  $val['last_name'];
                            $email =  $val['email'];
                        ?>
                            <option value="<?= $id ?>"> <?= $name ?> <?= $last_name ?> (<?= $email ?>) </option>
                        <?php
                            # code...
                        }
                        ?>
                    </select>
                    <br>
                    <span class=" collapsed text-green " style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                        Agent Authorisation Form
                    </span>
                        <br>
                        <br>
                        <?php
                        if($File_check == true){
                            ?>
                            <div class ="row">
                                <div class="col-6">
                            <a target="_blank" href="<?= base_url() ?>/<?= $File_document_path ?>/<?= $File_document_name ?>"> <?= $File_document_name  ?> </a>
                           </div>
                            <div class="col-6">
                           <a onclick="delete_document(<?=$File_id?>)"  class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a> 
                            </div>
                              </div>                  
                            <?php
                        }else{
                        ?>
                        <input type="file" id="file-input" name="file" class="form-control mt-2"  accept=".pdf" required>
                        <?php
                        }
                        ?>
                        
                </div>


            </div>
        </div>
    </div>
    <br>
    <div class="mt-4 text-center">

        <a href="javascript:void(0)" onclick="closs()" class="btn_green_yellow btn" style="margin-right: 20px;"> Back</a>
        <a href="javascript:void(0)" id="submit_next" type="submit" class="btn_yellow_green btn"> Next</a>
    </form>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>


<?= $this->endSection() ?>
<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
    function closs() {
        window.location = '<?= base_url() ?>/admin/application_manager/view_application/<?= $pointer_id ?>/view_edit';
    }

    function move_to_next_page() {
        var current_value = $('#new_agent').val();
                            $('#cover-spin').show();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('application_transfer_') ?>',
            data: {
                'user_id': current_value,
                'pointer_id': <?= $pointer_id ?>,
            },
            
            success: function(response) {
                console.log(response);
                if (response == "ok") {
                    window.location = '<?= base_url() ?>/Create_new_TRA_file/<?= $pointer_id ?>/' + current_value;
                } else {
                    $('#cover-spin').hide();
                }

                // Handle the response from the server
            },
            error: function(xhr, status, error) {
                $('#cover-spin').hide();
                // Handle any errors that occur during the AJAX request
            }
        });
    }

      function delete_document(id){
            custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete the file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
            $("#delete_pop_btn").click(function() {
                if (custom_alert_popup_close('delete_pop_btn')) { 
                    $('#cover-spin').show(0);   
                    $.ajax({
                        url: "<?= base_url('Create_new_TRA_file_delete_file_') ?>/" + id,
                        method: "POST",
                        data:{
                            "id" :id,
                        },
                        success: function(data) {
                            data = JSON.parse(data);
                            if (data["response"] == true) {
                                window.location.reload();
                                // window.location = "<?= base_url("Create_new_TRA_file_delete_file_") ?>/"+pointer_id+'/'+tab;
                            } else {
                                alert(data["msg"]);
                            }
                        },
                    });
                }
            });
        }
    

    function file_upload() {
        var new_agent = $('#new_agent').val();
        const fileInput = document.getElementById('file-input');
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('new_agent', new_agent);
        formData.append('pointer_id', <?= $pointer_id ?>);
        $('#cover-spin').show();
        $.ajax({
            url: '<?= base_url('Create_new_TRA_file_file_Upload_') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
            data = JSON.parse(data);
            if(data["response"] == true) {
     // console.log("Create_new_TRA_file_file_Upload_" + response);
                window.location = '<?= base_url() ?>/Create_new_TRA_file/<?= $pointer_id ?>/' + new_agent;
                // move_to_next_page();
            }},
            error: function(xhr, status, error) {
                console.error(error);
                $('#cover-spin').hide();

            }
        });
    }

    $(document).ready(function() {
        $('#submit_next').click(function() {
            // Get the current value of the dropdown
            var current_value = $('#new_agent').val();
            console.log(current_value);
            <?php 
             if($File_check == true){
            ?>
            window.location = '<?= base_url() ?>/Create_new_TRA_file/<?= $pointer_id ?>/' + <?=$old_user_account_id?>;
            <?php
            }else{?>
            if (current_value != "") {
                const fileInput = document.getElementById('file-input');
                
                if(fileInput && fileInput !="null"){
                    const file = fileInput.files[0];
                    console.log(fileInput);
                    console.log(file);
               
                // <php if (!$File_check) {  ?>
                //     const fileInput = document.getElementById('file-input');
                    file_upload();
                    // const file = fileInput.files[0];
                    // if (file) {
                    //     $('#cover-spin').show();
                    //     file_upload();
                    // } else {
                    //     custom_alert_popup_show(header = '', body_msg = "Please Add Agent Authorisation Form File.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                    // }
                // <php } else { ?>
                //     $('#cover-spin').show();
                //     move_to_next_page();
                // <php } ?>
                    
                    }else{
                    custom_alert_popup_show(header = '', body_msg = "Please Attach Agent Authorisation Form", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                    }
                
            }else{
                custom_alert_popup_show(header = '', body_msg = "Please select agent/applicant to assign application.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
            }
            <?php 
            }
            ?>
        });
    });
      
</script>
<?= $this->endSection() ?>
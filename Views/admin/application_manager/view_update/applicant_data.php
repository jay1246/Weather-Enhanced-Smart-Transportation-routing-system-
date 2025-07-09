<div class="accordion" id="flip-view_applicant_details">
    <div class="accordion-item">
        <h2 class="accordion-header" id="view_head_applicant_details">
            <button class="accordion-button collapsed text-green" type="button" data-bs-toggle="collapse" data-bs-target="#view_applicant_details" aria-expanded="false" aria-controls="view_applicant_details" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Applicant's Details
            </button>
        </h2>
        <style>
            .btn_yellow {
                background-color: #fecc00;
                color: #055837;
            }

            .btn_green {
                background-color: #055837;
                color: #fecc00;
            }
        </style>
        <div id="view_applicant_details" class="accordion-collapse collapse show" aria-labelledby="view_head_applicant_details" data-bs-parent="#flip-view_applicant_details">
            <div class="accordion-body">
                <form action="" method="post">
                    <table class="table table-striped border table-hover">
                        <tr>
                            <td width="30%">Applicant's Name</td>
                            <td class="w-25">
                                <?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name; ?>
                            </td>
                        </tr>
                         <tr>
                                <td width="30%">D.O.B</td>
                                <td class="w-25">
                                    <?php $date_of_birth=find_one_row("stage_1_personal_details",'pointer_id',$pointer_id)->date_of_birth;
                                    if (!empty($date_of_birth)) {
                                        echo $date_of_birth;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                        <tr>
                                <td width="30%">Email Address</td>
                                <td class="w-25">
                                    <?php
                                    if (!empty($s1_contact_details->email)) {
                                        echo $s1_contact_details->email;
                                    }
                                    ?>
                                </td>
                            </tr>
                           
                            <tr>
                                <td width="30%">Contact Number</td>
                                <td class="w-25">
                                    <?php
                                    if (!empty($s1_contact_details->mobile_number_code)) {
                                        $mobile_code = find_one_row('country', 'id', $s1_contact_details->mobile_number_code);
                                        echo "+" . $mobile_code->phonecode;
                                    }
                                    ?> <?= $s1_contact_details->mobile_number ?>
                                </td>
                            </tr>

                        <?php } ?>
                           <?php  $stage=application_stage_no($pointer_id);?>
                        <tr>
                            <td>Occupation</td>
                            <?php $occupation_details=find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);
                                 $chef_to_cook=chef_to_cook();
                               // print_r($chef_to_cook);
                            ?>
                            <td class="w-25">
                                <div class="row">
                                <div class="col-6">
                                    <?php if (session()->get('admin_account_type') == 'admin') { 
                                if($s1_occupation->occupation_id == 5 ||$s1_occupation->occupation_id ==6){
                                    
                                
                                    ?>
                                 
                           <select  name="occupation_" id="occupation_" class="form-select" aria-label="Default select example" onchange="hideshowopt()">
                                        <?php 
                                        $id_occupation = $occupation_details->id;
                                        foreach ($chef_to_cook as $key => $chef_to_cook_) {
                                            $occ_selected = "";
                                            if ($chef_to_cook_->id == $id_occupation) {
                                                $occ_selected = "selected ";
                                            }
                                        ?>
                                            <option <?= $occ_selected ?> value="<?= $chef_to_cook_->id ?>"><?= $chef_to_cook_->name ?></option>
                                        <?php } ?>
                                    </select>
                                   
                                    
                                    <?php }else{
                                        echo $occupation_details->name;
                                    }
                                    ?>
                                    <?php }else{
                                    echo $occupation_details->name;
                                    }?>
                                    
                                                       </div>
                                         <div class="col-md-6">
                                         <a id="ocp_show_hide" style="display:none"; href="javascript:void(0)" class="btn btn-sm btn_green_yellow mt-1" onclick="change_occupation()">
                                         <i id="saveicon" class="bi bi-check-circle" title="Save"></i>
                                         </a>
                                                           
                                         </div>
                                                    </div>
                                             
                                                </td>
                        </tr>
                     
                        <tr>
                            <td width="30%">Program</td>
                            <td class="w-25">
                                <div class="row">
                                <div class="col-6">
                                <?php if (session()->get('admin_account_type') == 'admin') {  
                                if($stage <= 11){
                                ?>
                                <select name="program_" id="program_" class="form-select" aria-label="Default select example" onchange="hideshowopt_program()">
                                <option value="TSS" <?= ($s1_occupation->program == 'TSS') ? 'selected' : '' ?>>TSS</option>
                                <option value="OSAP" <?= ($s1_occupation->program == 'OSAP') ? 'selected' : '' ?>>OSAP</option>
                                </select>
                                <?php }else{
                                echo $s1_occupation->program;
                                }?>
                                <?php }else{
                                
                               echo  $s1_occupation->program;       
                                }
                                ?>
                                </div>
                                <div class="col-md-6">
                                         <a id="ocp_show_hide_program" style="display:none"; href="javascript:void(0)" class="btn btn-sm btn_green_yellow mt-1" onclick="change_program()">
                                         <i id="saveicon" class="bi bi-check-circle" title="Save"></i>
                                         </a>
                                                           
                                         </div>
                                </div>
                            </td>
                        </tr>
                         <tr id="applicant_detail_pathway">
                            <td width="30%">Pathway</td>
                            <td class="w-25">
                                <div class="row">
                                <div class="col-6">
                                <?php
                                
                                ?>
                                                                <?php if (session()->get('admin_account_type') == 'admin') {  
                                        if($stage <= 11){?>
                                <select name="pathway_" id="pathway_" class="form-select" aria-label="Default select example" onchange="hideshowopt_pathway()">
                                <option value="Pathway 1" <?= ($s1_occupation->pathway == 'Pathway 1') ? 'selected' : '' ?>>Pathway 1</option>
                                <option value="Pathway 2" <?= ($s1_occupation->pathway == 'Pathway 2') ? 'selected' : '' ?>>Pathway 2</option>
                                </select>
                                <?php }else{
                                    echo $s1_occupation->pathway;
                                }?>
                                <?php }else{
                                echo $s1_occupation->pathway;
                                }?>
                                </div>
                                <div class="col-md-6">
                                         <a id="ocp_show_hide_pathway" style="display:none"; href="javascript:void(0)" class="btn btn-sm btn_green_yellow mt-1" onclick="change_pathway()">
                                         <i id="saveicon" class="bi bi-check-circle" title="Save"></i>
                                         </a>
                                                           
                                         </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Team Allocation Code -->
                                <?php if($stage_1->allocate_team_member_name != 0){ ?>
                            <tr id="allocate_team_member" style="display: none;">
                                 <td> ATTC Team Member</td>
                                 
                                <td class="w-20">
                                 <?php  }?>
                                    <!-- <div style="display: flex;" class="position-relative"> -->
                                    <div class="row">

                                        <?php
                                       // $allocate_team_member_show = false;
                                       //  if ($stage_1->status == "Lodged" ) {
                                        $allocate_team_member_show = true;
                                       //  }
                                        if (session()->has('admin_account_type')) {
                                            $admin_account_type =  session()->get('admin_account_type');

                                            // if ($admin_account_type == "admin") {
                                            //     $allocate_team_member_show = true;
                                            // }
                                        }
                                        // if ($stage_1->status == "In Progress" || $stage_1->status == "Approved" || $stage_1->status == "Declined") {
                                        // }
                                        ?>

                                        <?php
                                        $allocate_team_member_name_data =   get_tb('allocate_team_member_name');
                                        if ($stage_1->allocate_team_member_name != 0) { ?>
                                            <div class="col-6">
                                                <select name="allocate_team_member_name" id="allocate_team_member_select_id" class="form-select" aria-label="Default select example" onchange="check_select()">
                                                    <option value="" selected disabled> Select name</option>
                                                    <?php
                                                     $id_of_member = $stage_1->allocate_team_member_name;
                                                    foreach ($allocate_team_member_name_data as $key => $value) {
                                                    ?>
                                                        <?php
                                                        $selected = "";
                                                        if ($value['id'] == $id_of_member) {
                                                            $selected = "selected ";
                                                        }
                                                        ?>
                                                        <option  <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                          <script>
                                         function check_select() {
                                            var selectid = document.getElementById("allocate_team_member_select_id").value;
                                            var fetchid = "<?=$id_of_member?>";
                                            var saveBtn = document.getElementById("stage_1_hide_show_btn_team_name_save");
                                    
                                            if (selectid === fetchid) {
                                                saveBtn.style.display = "none";
                                            } else {
                                                saveBtn.style.display = "inline-block"; // or "inline" or any other display value you want
                                            }
                                        }
                                                                            </script>
                                                                                        </div>
                                            <?php if ($admin_account_type == "admin") { ?>
                                            <?php } ?>
                                            
                                            <div class="col-4">

                                            <a id="stage_1_hide_show_btn_team_name_save" class="btn btn-sm btn_green_yellow my-auto hidden" onclick="stage_1_hide_show_btn_team_name_()">
                                                <i class='bi bi-check-circle' title='Save'></i>
                                            </a>
                                            </div>
                                            <script>
                                                document.getElementById("allocate_team_member_select_id").addEventListener("change", function() {
                                                    document.getElementById("stage_1_hide_show_btn_team_name_save").classList.remove("hidden");
                                                });
                                            </script>

                                            <script>
                                                // function stage_1_hide_show_btn_team_name_() {
                                                //     var saveBtn = document.getElementById("stage_1_hide_show_btn_team_name_save");
                                                //     event.preventDefault();
                                                //     var selectedValue = $("#allocate_team_member_select_id").val();
                                                //     var data = {
                                                //         selectedValue: selectedValue
                                                //     };
                                                //     document.getElementById("stage_1_hide_show_btn_team_name_save").classList.remove("hidden");
                                                //     $.ajax({
                                                //         type: "POST",
                                                //         url: "<?= base_url('admin/save_Assigned_Team_Member/' . $pointer_id) ?>",
                                                //         data: data,
                                                //         success: function(response) {
                                                           
                                                //             if (response == 1) {
                                                //                 document.getElementById("stage_1_hide_show_btn_team_name_save").classList.add("hidden");
                                                                 
                                                //             }
                                                //         },
                                                //         error: function(jqXHR, textStatus, errorThrown) {
                                                //             console.log("AJAX request failed:", textStatus, errorThrown);
                                                //             document.getElementById("stage_1_hide_show_btn_team_name_save").classList.remove("hidden");
                                                //         }
                                                //     });
                                                // }
                                            </script>
                                        <?php } 
                       ?>
                                    </div>
                                </td>
                            </tr>
                                         <?php  if ($stage_1->unique_id != ""){ ?>
                            <tr id="headoffice_no" style="display: none;">
                                <td>ATTC Ticket No.</td>
                                <td class="w-25">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" <?php if ($stage_1->status != "Lodged") {
                                                                    echo "readonly";
                                                                } ?> <?php if (!empty($stage_1->unique_id)) {
                                                                            echo "readonly";
                                                                        } ?> name="unique_id" id="unique_no_stage_1" class="form-control" value="<?= $stage_1->unique_id ?>" maxlength="20" onkeyup="show_mark()">
                                        </div>
                                        <script>
                                            function show_mark(){
                                              
                                                    var inputValue = document.getElementById("unique_no_stage_1").value;
                                                    var fetchval="<?=$stage_1->unique_id?>";
                                                    var saveBtn = document.getElementById("stage_1_hide_show_btn");
                                            
                                       if (parseInt(inputValue) === parseInt(fetchval)) {
                                            var iconElement = saveBtn.querySelector("i");
                                                if (iconElement) {
                                                    iconElement.classList.remove("bi-check-circle");
                                                    iconElement.classList.add("bi-pencil-square");
                                                    iconElement.title = "Save";
                                                }
                                                    } else {
                                                       var iconElement = saveBtn.querySelector("i");
                                                    if (iconElement) {
                                                        iconElement.classList.remove("bi-pencil-square");
                                                        iconElement.classList.add("bi-check-circle");
                                                        iconElement.title = "Save";
                                                    }
                                                    }
                                              
                                            }
                                        </script>
                                        <div class="col-4 bbg-info my-auto">
                                            <a id="stage_1_hide_show_btn" href="javascript:void(0)" class="btn btn-sm btn_green_yellow" onclick="readonlyInputtt('#unique_no_stage_1')">
                                                <?php if ($admin_account_type != "admin") { ?>
                                                    <?php if (!empty($stage_1->unique_id)) { ?>
                                                        <i class="bi bi-pencil-square"></i>

                                                    <?php } else { ?>
                                                        <i class="bi bi-check-circle" title="Savem"></i>

                                                    <?php } ?>

                                                <?php } else { ?>
                                                    <i id="saveicon" class="bi bi-pencil-square" title="Save"></i>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <?php }?>
                        <!--                         
                        <tr>
                            <td>Assigned to</td>
                            <td class="w-25">
                                <select class="form-select mb-3" aria-label="Default select example" name="assigned_to">
                                    <option selected value="Self"> Self </option>
                                </select>
                            </td>
                        </tr> -->
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
  <?php if (session()->get('admin_account_type') == 'admin') {  ?>
<script>
     var check_to_cook_global = "<?=$occupation_details->id?>";
    function hideshowopt() {
        var occupation_id = document.getElementById("occupation_").value;
        var fetchval = check_to_cook_global;
         var saveBtn = document.getElementById("ocp_show_hide");

        if (parseInt(occupation_id) === parseInt(fetchval)) {
            saveBtn.style.display='none';
        }else{
            saveBtn.style.display='';
            
        }
    }
    osap_to_tss_global='<?=$s1_occupation->program?>';
    function hideshowopt_program() {
    var program = document.getElementById("program_").value;
    var saveBtn = document.getElementById("ocp_show_hide_program"); 
    var fetchval = osap_to_tss_global
    if(program === fetchval){
        saveBtn.style.display = 'none';
    } else {
        saveBtn.style.display = '';
    }
}
  pathway_global='<?=$s1_occupation->pathway?>';
    function hideshowopt_pathway() {
    var pathway = document.getElementById("pathway_").value;
    var saveBtn = document.getElementById("ocp_show_hide_pathway"); 
    var fetchval = pathway_global
    if(pathway === fetchval){
        saveBtn.style.display = 'none';
    } else {
        saveBtn.style.display = '';
    }
}

</script>
<?}?>
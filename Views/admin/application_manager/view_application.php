<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    .normal_link {
        color: #4154f1 !important;
    }

    .text-color {
        color: black;
        font-size: 18px;
    }

    .text-color:hover {
        color: black;
    }

    .tab {
        font-size: 18px !important;
        text-decoration: none;

    }

    .tab:hover {
        color: #055837;
        text-decoration: none;

    }

    .accordion-button {
        font-size: 16px;


    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: var(--yellow);
        color: var(--green);
    }

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

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;

    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: inherit;
        border-style: solid;
    }

    select :disabled {
        /* color: #f59595 !important; */
        background-color: #f2f2f3 !important;
    }

    /* .sidebar {
        height: 2500px !important;
    } */
</style>
<main id="main" class="main w-100" style="width: 82% !important">
    <!-- style="height: 4000px;" -->
    
    <div class="row">
        
        <div class="col-6">
        <div class="pagetitle">
        <h4 class="text-green mt-3" style="font-size:24px">View / Update  </h4>
        <b>
            <snap class="mt-2" style="font-size:16px"><?php

                                                        echo $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " ";
                                                        if (empty($stage_1->unique_id)) {
                                                            $unique_code = "[#T.B.A] - ";
                                                        } else {
                                                            $unique_code = " [#" . $stage_1->unique_id . "] - ";
                                                        }
                                                        echo $unique_code;
                                                        echo $s1_contact_details->state_proviance . ", ";
                                                        echo $s1_contact_details->country;
                                                        ?>


            </snap>
            <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                <br>


                <snap class="mt-1">
                    <?php
                    $mobile_code = find_one_row('country', 'id', $username->mobile_code);
                    echo  $username->name . " " . $username->middle_name . " " . $username->last_name . " - " . $username->business_name . " (+" . country_phonecode($username->mobile_code) . " " . $username->mobile_no . ")";
                    $info_name =  $username->name;
                    $info_middle_name =  " " . $username->middle_name;
                    $info_last_name =  " " . $username->last_name;
                    if (!empty($username->business_name)) {
                        $info_business_name =  " - " . $username->business_name;
                    } else {
                        $info_business_name = "";
                    }
                    $info_mobile = " (+" . country_phonecode($username->mobile_code) . " " . $username->mobile_no . ")";
                    // echo $info_name . $info_middle_name . $info_last_name . $info_business_name;
                    echo "<br>";
                     $user_ac_id = find_one_row('application_pointer', 'id', $s1_contact_details->pointer_id)->user_id;
                       echo $user_ac_email = find_one_row('user_account', 'id', $user_ac_id)->email;
                    ?>
                    <a href="<?= base_url('application_transfer/' . $pointer_id) ?>" title="Application Transfer." class="btn_green_yellow btn btn-sm p-0" style="font-size: 70%; padding-left: 3px !important; padding-right: 3px !important;">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                </snap>
            <?php } ?>

        </b>
    </div>
        </div>
        <!--<div class="col-5 d-flex justify-content-end  ms-5" style="margin-top:13px;">-->
        <!--<div >-->
        <!--     <php  $path = base_url($user_image['document_path']). '/'.$user_image['document_name'];?>-->
             
        <!--     <img  style="border-color:#f8f8ff;"class="border border-2" src="<=$path?>" height='150' width='150'>-->
        <!--</div>-->
        <!--</div-->
        </div>
    
    
    <!-- End Page Title -->

    <section class="section dashboard mt-3 shadow">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <?php
                 if ($tab == "view_edit") {
                    $color='#ffcc01';
                    $textcolor='#055837';
                    $view_tab = "active";
                    $document_tab = "";
                    $btn_view = "btn_yellow_green";
                    $btn_doc = "";
                    $notes="";
                    $hide='display:none';
                } elseif($tab == "all_documents"){
                    $color='#ffcc01';
                    $textcolor='#055837';
                    $view_tab = "";
                    $document_tab = "active";
                    $btn_view = "";
                    $btn_doc = "btn_green_yellow";
                    $notes="";
                    $hide='display:none';
                }else{
                 $color='#055837';
                 $textcolor='#ffcc01';
                 $notes='active';
                 $view_tab = "";
                    $document_tab = "";
                    $btn_view = "";
                    $btn_doc = "btn_green_yellow";
                    $hide=' ';
                }
                if($notes_count != 0){ 
                    $style_notes='';
                }else{
                    $style_notes='display:none;';
                }
                ?>
                <!-- ---------------tabs--------- -->
                <!-- Bordered Tabs Justified -->
                <ul class="nav nav-pills nav-fill" style="margin-right: 15px;margin-left: 15px;margin-top: 20px;width: 98%;">
                    <li class="nav-item">
                        <a class="nav-link text-center tab shadow-sm text-color <?= $view_tab ?>" id="tabs_view_edit" href="<?= base_url("admin/application_manager/view_application/" . $pointer_id . "/view_edit") ?>" role="tab" aria-controls="tabs_view_edit" aria-selected="true">View / Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  shadow-sm text-center tab text-color <?= $document_tab ?>" id="tabs_documents" href="<?= base_url("admin/application_manager/view_application/" . $pointer_id . "/all_documents") ?>" role="tab" aria-controls="tabs_documents" aria-selected="false">Submitted Documents</a>
                    </li>
                    <?php if (session()->get('admin_account_type') == 'admin') { 
                        
                    $stage_index = application_stage_no($pointer_id);
                    
                    $current_status = create_status_rename(create_status_format($stage_index),$pointer_id);
                    
                    if ($current_status == "Completed" || $current_status == "Closed"){
                        // Do Nothing access only to Admin -> 1
                        goto notes_option;
                        if(session()->get('admin_id') == 1){
                            // If 1 then Show Notes:- 
                            goto notes_option;
                        }
                    }
                    else{
                        notes_option:
                    ?>
                   
                    <li class="nav-item" class="ps-2">
                        <a class="nav-link shadow-sm text-center text-dark tab text-color <?=$notes?>"
                        id="notes_tab" href="<?= base_url("admin/application_manager/view_application/" . $pointer_id . "/notes") ?>" role="tab" aria-controls="notes_tab" aria-selected="false">Notes   <span style="padding: 0 10px;margin-left: 1%;border: 1 px solid;border: 1px solid <?=$color?>;background: <?=$color?>;color: <?=$textcolor?>; <?=$style_notes?>" id="notes_pointer_count" class="fw-bold  btn btn-secondary"><?=$notes_count?></span> 
  
</a>
                    </li>
                    <?php 
                    } // New Condition
                    
                    } ?>
                  </ul> 
  
 
            </div>
            <div class="tab-content">

                <!-- ------------view_edit tab starts--------- -->

                <div  class="tab-pane fade show <?= $view_tab ?>" id="view_view_edit" role="tabpanel" aria-labelledby="tabs_view_edit">
                    <!-- Table with stripped rows -->
                    <div class="card-body">
                        <!--  -------------------Applicant details ---------------- -->
                        
                        <?php
                        echo $this->include("admin/application_manager/view_update/applicant_data.php");
                        ?>
                        <!--  -------------------End Applicant details ---------------- -->

                        <!--  -------------------Stage 1 - Self Assessment ---------------- -->
                        <?php if ($stage_1 != "") {
                            echo $this->include("admin/application_manager/view_update/stage_1.php");
                        } ?>
                        <!--  -------------------End stage 1 self assesment ---------------- -->
                        <!-- -------------------Stage 2 - Documentary Evidence ---------------- -->
                        <?php
                        if ($stage_2 != "") {
                            if (!empty($stage_2->status) and $stage_2->status != 'Start') {
                                echo $this->include("admin/application_manager/view_update/stage_2.php");
                            }
                        } ?>
                        <!--  -------------------End stage 2 Documentary Evidence ---------------- -->
                        <!-- -------------------Stage 3 - Documentary Evidence ---------------- -->
                        <?php
                        if ($stage_3 != "") {
                            if (!empty($stage_3->status) and $stage_3->status != 'Start') {
                                echo $this->include("admin/application_manager/view_update/stage_3.php");
                            }
                        } ?>
                        <!--  -------------------End stage 3 Documentary Evidence ---------------- -->
                        
                        <!-- -------------------Stage 3 - Documentary Evidence ---------------- -->
                        <?php
                        if ($stage_3_reassessment != "") {
                            if (!empty($stage_3_reassessment->status) and $stage_3_reassessment->status != 'Start' and $stage_3_reassessment->status != 'reassessment') {
                                echo $this->include("admin/application_manager/view_update/stage_3_reassessment.php");
                            }
                        } ?>
                        <!--  -------------------End stage 3 Documentary Evidence ---------------- -->
                        
                           <!-- -------------------Stage 4 - Documentary Evidence ---------------- -->
                         <?php
                         if (!empty($stage_4)) {
                                  $pathway=$s1_occupation->pathway;
                                if($pathway=="Pathway 1"){
                                    if($s1_occupation->occupation_id==7||$s1_occupation->occupation_id==18){
                              
                                     echo $this->include("admin/application_manager/view_update/stage_4.php");
                                    }
                                }
                         }
                        // if ($stage_4 != "") {
                        //     if (!empty($stage_4->status)) {
                        //         $occupation= find_one_row('occupation_list', 'id', $s1_occupation->occupation_id)->name;
                        //         $pathway=$s1_occupation->pathway;
                        //         if($pathway=="Pathway"){
                        //             if($occupation=="Electrician (General)"||$occupation=="Plumber (General)"){
                        //              echo $this->include("admin/application_manager/view_update/stage_4.phpdd

                        //             }
                                    
                        //         }
                        //     }     
                        // } 
                        ?>
                           <!-- ------------------- end Stage 4 - Documentary Evidence ---------------- -->
                       
                    </div>
                </div>
                <!-- - -----view_edit tab ends------ -->

                <!-- ------documents tab starts------ -->

                <div   class="tab-pane fade  show <?= $document_tab ?>" id="view_documents" role="tabpanel" aria-labelledby="tabs_documents">

                    <div class="card-body">

                        <?php if (session()->has('zip_error')) { ?>
                            <br>
                            <div class="alert alert-danger alert-dismissible fade show mt-5 mb-3" role="alert" id="alert">
                                <p class="text-center"><?= session()->get('zip_error') ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <!-- ------------------stage 1 documents --------- -->
                        <?php if ($stage_1 != "") {
                            if (!empty($stage_1->status)) {
                                if ($stage_1->status != "Start") {
                                    echo $this->include("admin/application_manager/document/stage_1.php");
                                }
                            }
                        } ?>
                        <!-- ------------------stage 1 documents end --------- -->
                        <!-- ------------------stage 2 documents --------- -->
                        <?php if ($stage_2 != "") {
                            if (!empty($stage_2->status)) {
                                if ($stage_2->status != "Start") {
                                            echo $this->include("admin/application_manager/document/stage_2.php");
                                      
                                }
                            }
                        } ?>
                        <!-- ------------------stage 2 documents end --------- -->
                        <!-- ------------------stage 3 documents --------- -->
                        <?php
                        if ($stage_3 != "") {
                            if (!empty($stage_3->status)) {
                                if ($stage_3->status != "Start") {
                                    // echo $stage_3->status;
                                    // exit;
                                    echo $this->include("admin/application_manager/document/stage_3.php");
                                }
                            }
                        } ?>
                        <!-- ------------------stage 3 documents end --------- -->
                        <!-- ------------------stage 3 documents --------- -->
                        <?php
                        if ($stage_3_reassessment != "") {
                            if (!empty($stage_3_reassessment->status)) {
                                if ($stage_3_reassessment->status != "Start" and $stage_3_reassessment->status != "reassessment") {
                                    // echo $stage_3->status;
                                    // exit;
                                    echo $this->include("admin/application_manager/document/stage_3_reassessment.php");
                                }
                            }
                        } ?>
                        <!-- ------------------stage 3 documents end --------- -->

                            <!-- ------------------stage 4 documents --------- -->
                        <?php
                         if (!empty($stage_4)) {
                                  $pathway=$s1_occupation->pathway;
                                if($pathway=="Pathway 1"){
                                    if($s1_occupation->occupation_id==7||$s1_occupation->occupation_id==18){
                                    echo $this->include("admin/application_manager/document/stage_4.php");
                                    }
                                }
                         }
                    
                        ?>
                        <!-- ------------------stage 4 documents end --------- -->


                    </div>
                </div>
                <!-- Added for Notes Div in s1 -> 3490 -->
                </div>
                
         <?php 
        //  echo session()->get('admin_account_type');
         if (session()->get('admin_account_type') == 'admin') {  ?>
               <div style="<?=$hide?>" class="tab-pane fade  show <?= $notes ?>" id="notes" role="tabpanel" aria-labelledby="notes_tab">
        
                            <div class="card-body">
                 <?=  $this->include("admin/application_manager/view_update/notes.php");?>
                              
        
                            </div>
                        </div>
                        <?php  }?>
            </div>
        </div>
    </section>
    <div id="cover-spin">
        <div id="loader_img">
            <img src="<?= base_url("public/assets/image/admin/loader.gif") ?>" style="width: 100px; height:auto">
        </div>
    </div>
</main>

<!-- Modal Applicantion Team Member Select -->
<div class="modal" id="notice_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #FFCC01;">
        <h5 class="modal-title text-uppercase mx-auto" id="exampleModalLabel"><b>TEAM MEMBER ALLOCATION</b></h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="__close_popup()">-->
        <!--  <span aria-hidden="true">&times;</span>-->
        <!--</button>-->
      </div>
      <div class="modal-body text-center">
          <form id="team_member_allocation_form" action="" method="post">
              <input type="hidden" name="pointer_id" value="<?= $pointer_id ?>">
            <!--  <div class="row">-->
            <!--    <div class="col-12 custom_text text-uppercase text-center" style="font-weight: bold; font-size: 15px;">-->
            <!--        <h5>-->
            <!--            Fill in the team member information for this application.-->
            <!--        </h5>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="row my-3">
                <div class="col-12">
                    <!--<label>Team Member</label>-->
                    <select class="form-select" name="team_member" id="team_member" required>
                        <option value="">Select Team Member</option>
                        <?php 
                        $aqato_users = getTheAccounts("admin");
                        foreach($aqato_users as $aqato_user){
                            
                            $full_name = $aqato_user["first_name"]." ".$aqato_user["last_name"];
                            
                            ?>
                            <option value="<?= $aqato_user["id"] ?>"><?= $full_name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn_green_yellow">Save</button>
                </div>
            </div>
          </form>
            
      </div>
      <!--<div class="modal-footer" style="justify-content: flex-start;">-->
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <!--<button type="button" class="btn btn_green_yellow" onclick="hit_save_member()">Save</button>-->
      <!--</div>-->
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('custom_script') ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<!--stg_2_status_select-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<?= $this->include("admin/application_manager/team_member_logic_script") ?>
<!--stg_1_status_select-->
<script>
 $( document ).ready(function() {


    var location=$('#preference_location').val();
    var real_location=$('#original_location').val();
    if(location == real_location){
           $('#stage_3_prefered_location_edit').hide();

    }else{
         // $('#stage_3_prefered_location_edit').show();
    }

    if(location=="Online (Via Zoom)"){
        $('.online_docs').show();
    }
    else{
        $('.online_docs').hide();
    }
    
    
    var location=$('#preference_location_r').val();
    var real_location=$('#original_location').val();
    if(location == real_location){
           $('#stage_3_reass_prefered_location_edit').hide();

    }else{
         // $('#stage_3_reass_prefered_location_edit').show();
    }

    if(location=="Online (Via Zoom)"){
        $('.online_docs_r').show();
    }
    else{
        $('.online_docs_r').hide();
    }

});
    var pointer_id = <?= $pointer_id ?>;
    var tab = '<?= $tab ?>';

    // view updata ------------------------------  
    <?php
    if (isset($stage_1->unique_id) && !empty($stage_1->unique_id)) {
    ?>
        var read = false;
    <?php
    } else {
    ?>
        var read = true;
    <?php
    }
    ?>
    const readonlyInput= (element) => {
        var select_id = document.getElementById("unique_no_stage_1").value;
        
        
        var Assigned_Team_Memberid =document.getElementById("allocate_team_member_select_id").value;
        console.log(select_id+Assigned_Team_Memberid)
        // alert(select_id+Assigned_Team_Memberid); 
       // alert(select_id+Assigned_Team_Memberid)
         if(Assigned_Team_Memberid){
            $(element).removeAttr("readonly");
         }else{
            $(element).attr("readonly", true); 
         }
            if (Assigned_Team_Memberid == "") {
            custom_alert_popup_show(header = '', body_msg = "Select Assigned Team Member", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
        }
        if (select_id == "" && Assigned_Team_Memberid != "") {
            custom_alert_popup_show(header = '', body_msg = "Enter ATTC Ticket No.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
        }
    //       if (read === true) {
    //     // If true, remove the readonly attribute
    //     $(element).removeAttr("readonly");
    // } else {
       
    //     $(element).attr("readonly", true);
    // }
        console.log(read + "________________");
        if (read != "") {
            console.log('gngj');
           // $(element).attr("readonly", "true");
            read = false;
            if (element == "#unique_no_stage_1") {
             
               // $("#stage_1_hide_show_btn").html("<i class='bi bi-pencil-square'></i>");
            }
        } else {
            console.log('gj');
            $(element).removeAttr("readonly");
            read = true;
            if (element == "#unique_no_stage_1") {
                //$("#stage_1_hide_show_btn").html("<i class='bi bi-check-circle'title='Save'></i>");
            }
        }
        if(select_id != "" && Assigned_Team_Memberid !=""){
            
              update_unique_no_stage_1()
        }
          
    }
    const readonlyInputs3= (element) => {
        var select_id = document.getElementById("unique_no_stage_1").value;
        
        
        var Assigned_Team_Memberid =document.getElementById("allocate_team_member_select_id").value;
        console.log(select_id+Assigned_Team_Memberid)
        // alert(select_id+Assigned_Team_Memberid); 
       // alert(select_id+Assigned_Team_Memberid)
         if(Assigned_Team_Memberid){
            $(element).removeAttr("readonly");
         }else{
            $(element).attr("readonly", true); 
         }
            if (Assigned_Team_Memberid == "") {
            custom_alert_popup_show(header = '', body_msg = "Select Assigned Team Member", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
        }
        if (select_id == "" && Assigned_Team_Memberid != "") {
            custom_alert_popup_show(header = '', body_msg = "Enter ATTC Ticket No.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
        }
    //       if (read === true) {
    //     // If true, remove the readonly attribute
    //     $(element).removeAttr("readonly");
    // } else {
       
    //     $(element).attr("readonly", true);
    // }
        console.log(read + "________________");
        if (read != "") {
            console.log('gngj');
           // $(element).attr("readonly", "true");
            read = false;
            if (element == "#unique_no_stage_1") {
             
               // $("#stage_1_hide_show_btn").html("<i class='bi bi-pencil-square'></i>");
            }
        } else {
            console.log('gj');
            $(element).removeAttr("readonly");
            read = true;
            if (element == "#unique_no_stage_1") {
                //$("#stage_1_hide_show_btn").html("<i class='bi bi-check-circle'title='Save'></i>");
            }
        }
        if(select_id != "" && Assigned_Team_Memberid !=""){
            
              //update_unique_no_stage_1()
        }
          
    }
    
    function showReadOnly(element){
        var isread = $(element).attr("readonly");
        console.log(isread);
        if(isread){
            $(element).removeAttr("readonly");
        }
        else{
            $(element).attr("readonly", true);
        }
    }
    
    
    const readonlyInputtt = (element) => {
       
        console.log(read + "________________");
        if (read != "") {
            console.log('gngj');
           // $(element).attr("readonly", "true");
            read = false;
            if (element == "#unique_no_stage_1") {
             update_unique_no_stage_1()
                $("#stage_1_hide_show_btn").html("<i class='bi bi-pencil-square'></i>");
            }
        } else {
            console.log('gj');
            $(element).removeAttr("readonly");
            read = true;
            if (element == "#unique_no_stage_1") {
                //$("#stage_1_hide_show_btn").html("<i class='bi bi-check-circle'title='Save'></i>");
            }
        }
     
          
    }
    // view updata->stage 1 ----------------------------
    var status = '<?= $stage_1->status ?>';
    if (status == "Declined") {
        $("#reason_tr").show();
    } else {
        $("#reason_tr").hide();
    }


    if (status == "Submitted") {
        $("#headoffice_no").hide();
        $("#allocate_team_member").hide();

    } else {
        $("#headoffice_no").show();
        $("#allocate_team_member").show();
    }


    // if (status == "Lodged" || status == "Submitted") {
    //     $("#headoffice_no").hide();
    //     $("#allocate_team_member").hide();

    // } else {
    //     $("#headoffice_no").show();
    //     $("#allocate_team_member").show();
    // }




    $("#reason_input").removeAttr("required");
    const change_status = (val) => {
        console.log(val);
        
        // Approval
        if (val == "Omitted") {
            // $("#approval_comment_input").attr("required", "true");
            $("#omitted_deadline_date_html").show();
        } else {
            // $("#approval_comment_input").removeAttr("required");
            $("#omitted_deadline_date_html").hide();
            // $("#approval_comment_input").removeAttr("required");
        }
        
        
        
        // Approval
        if (val == "Approved") {
            // $("#approval_comment_input").attr("required", "true");
            $("#approval_comment_tr").show();
        } else {
            // $("#approval_comment_input").removeAttr("required");
            $("#approval_comment_tr").hide();
            // $("#approval_comment_input").removeAttr("required");
        }
        
        // end
        if (val == "Declined") {
            $("#reason_input").attr("required", "true");
            $("#reason_tr").show();
        } else {
            $("#reason_input").removeAttr("required");
            $("#reason_tr").hide();
            $("#reason_input").removeAttr("required");
        }

        if (val == "Lodged" || val == "In Progress") {
            $("#unique_no_stage_1").attr("required", "true");
            $("#headoffice_no").show();
            $("#allocate_team_member").show();

        } else {
            $("#unique_no_stage_1").removeAttr("required");
        }
        if (val == "Start" || val == "Submitted") {
            $("#unique_no_stage_1").removeAttr("required");
            $("#headoffice_no").hide();
            $("#allocate_team_member").hide();
        }

        if(val == "Reinstate"){
            $("#date_expiry_html").show();
            $("#date_expiry").attr("required", "true");
        }
        else{
            
            $("#date_expiry_html").hide();
            $("#date_expiry").removeAttr("required");
        }
        // if (val == "In Progress") {
        //     $("#unique_no_stage_1").attr("required", "true");
        //     $("#headoffice_no").show();
        //     $("#allocate_team_member").show();

        // } else {
        //     $("#unique_no_stage_1").removeAttr("required");
        //     $("#headoffice_no").hide();
        //     $("#allocate_team_member").hide();

        // }
    }
    // change unique no (head office no) stage 1 ----------------------------
    function update_unique_no_stage_1() {
     stage_1_hide_show_btn_team_name_();
        // Assigned Team Member
        var selectElement = document.getElementById("allocate_team_member_select_id");
        var Assigned_Team_Member_id = selectElement.value;

        // ATTC_Ticket_No
        var unique_head_office_no = $("#unique_no_stage_1").val();

        if (Assigned_Team_Member_id == "") {
            custom_alert_popup_show(header = '', body_msg = "Select Assigned Team Member", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
        }
        if (unique_head_office_no == "") {
            custom_alert_popup_show(header = '', body_msg = "Enter ATTC Ticket No.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
            return;
        }


        console.log(unique_head_office_no);
        // return;
        $.post("<?= base_url("admin/application_manager/update_unique_no/stage_1") ?>", {
            pointer_id,
            unique_head_office_no,
            Assigned_Team_Member_id,
        }, function(data) {
            // let data = JSON.parse(data);
             location.reload();
            // console.log(data.msg);
            console.log(JSON.parse(data).msg);
        });
    }
    // change status stage 1 ----------------------------
    $("#stage_1_change_status").submit(function(e) {
       // alert("sads");
        //return;
        
        e.preventDefault();
        var selectedValue;
        var selete_status;
        var status__now = '<?= $stage_1->status ?>';
        selectedValue = (status__now == "Submitted") ? "1" : "";
        // console.log(status__now);
        // return;
        if (selectedValue === "") {
            var selectElement = document.getElementById("allocate_team_member_select_id");
            if (selectElement) {
                var selectedValue = selectElement.value;
            }
        }
        var status_element = document.getElementById("stage_1_status_drop");
        if (status_element) {
            var selete_status = status_element.value;
        }
    
        console.log(selete_status);
        if (selectedValue !== "") {
            if (selete_status != "Select Status"){
                custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
                // check Btn click
                $("#stage_1_pop_btn").click(function() {
                    // if return true 
                    if (custom_alert_popup_close('stage_1_pop_btn')) {
                        // var formData = new FormData($(this)[0]);
                        var formData = new FormData(document.getElementById("stage_1_change_status"));
                        $('#cover-spin').show(0);
                        $.ajax({
                            method: "POST",
                            url: "<?php echo base_url('admin/application_manager/status_change/stage_1'); ?>",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                console.log(data);
                                data = JSON.parse(data);
                                if (data["response"] == true) {
                                    window.location.reload();
                                } else {
                                    alert(data["msg"]);
                                }
                            }
                        });
                    }
                });
            }else{
                custom_alert_popup_show(header = '', body_msg = "Please Select Status", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                return;
           
            }
        } else {
            // alert('Select Assigned Team Member');
            custom_alert_popup_show(header = '', body_msg = "Select Assigned Team Member", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
            // custom_alert_popup_show(header = '', body_msg = "Select allocated", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = false);
        }
    });

    // view updata->stage 1 end ----------------------------
    // view updata->stage 2 ----------------------------
    <?php if ($stage_2 != "") { ?>
        var status_2 = '<?= $stage_2->status ?>';
    <?php } else { ?>
        var status_2 = "";
    <?php } ?>
    if (status_2 == "Declined") {
        // $("#reason_tr_2").show();
        
        $("#reason_tr_1_2").show();
        $("#reason_tr_2_2").show();
        
    } else {
        // $("#reason_tr_2").hide();
        
        $("#reason_tr_1_2").hide();
        $("#reason_tr_2_2").hide();
    
    }
    $("#reason_input_2").removeAttr("required");
    const change_status_2 = (val) => {
        console.log(val);
        
        // Approval
        if (val == "Approved") {
            // $("#approval_comment_input_stage_2").attr("required", "true");
            $("#approval_comment_tr_stage_2").show();
        } else {
            // $("#approval_comment_input_stage_2").removeAttr("required");
            $("#approval_comment_tr_stage_2").hide();
            // $("#approval_comment_input_stage_2").removeAttr("required");
        }
        
        
        if (val == "Declined") {
            // $("#reason_input_2").attr("required", "true");
            // $("#reason_tr_2").show();
            <?php $outcome = 0;
            $statement_resone = 0;
            $outcome_letter = find_one_row_3_field('documents','stage','stage_2','pointer_id',$pointer_id,'required_document_id',51);
            if ($outcome_letter) {
                $outcome = 1;
                }// Outcome Letter
            $statement_of_reasons = find_one_row_3_field('documents','stage','stage_2','pointer_id',$pointer_id,'required_document_id',52);
                 if ($statement_of_reasons) {
                     $statement_resone = 1;
                     } // Outcome Letter
            ?>
            var outcome = <?=$outcome?>;
            var statement_resone = <?=$statement_resone?>;
            $("#reason_tr_1_2").show();
            $("#reason_tr_2_2").show();
            if(outcome==0){
            $("#s2_outcome").attr("required", "true");
            }
            if(statement_resone == 0){
            $("#s2_dec_Statement_of_Reasons").attr("required", "true");
            }
        } else {
            // $("#reason_input_2").removeAttr("required");
            // $("#reason_tr_2").hide();
            
            $("#reason_tr_1_2").hide();
            $("#reason_tr_2_2").hide();
            $("#s2_outcome").removeAttr("required");
            $("#s2_dec_Statement_of_Reasons").removeAttr("required");

        }
    }
       
    // change status stage 2 ----------------------------
    
    $("#stage_2_change_status").submit(function(e) {
    e.preventDefault();
    var selete_status ="";   
    var status_element = document.getElementById("stage_2_status_drop");
    if (status_element) {
        var selete_status = status_element.value;
    }
        if (selete_status != "Select Status"){

            custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_2_pop_btn');
            // check Btn click
            $("#stage_2_pop_btn").click(function() {
                // if return true 
                if (custom_alert_popup_close('stage_2_pop_btn')) {
                    var formData = new FormData(document.getElementById("stage_2_change_status"));
                    $('#cover-spin').show(0);
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("admin/application_manager/status_change/stage_2") ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = JSON.parse(data);
                            if (data["response"] == true) {
                                window.location.reload();
                            } else {
                                alert(data["msg"]);
                            }
                        }
                    });
                }
            })
        }else{
            custom_alert_popup_show(header = '', body_msg = "Please Select Status", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            // window.location.reload();

            // return;
           
            }
        
    }); // view updata->stage 2 end ----------------------------
    // view updata->stage 3 ----------------------------

    var pathway ="<?= $s1_occupation->pathway ?>";
    var ocupation_id = "<?=$s1_occupation->occupation_id?>"
    <?php if (!empty($stage_3)) { ?>
        var status_3 = '<?= $stage_3->status ?>';
    <?php } else { ?>
        var status_3 = "";
    <?php } ?>
    console.log(pathway);
    if (status_3 == "Declined") {
        $("#reason_tr_1_3").show();
        $("#reason_tr_2_3").show();
    } else {
        $("#reason_tr_1_3").hide();
        $("#reason_tr_2_3").hide();
    }
    
    if (status_3 == "Approved") {
        console.log(pathway);
            console.log(ocupation_id);
        if((ocupation_id == 7 || ocupation_id == 18) && pathway =='Pathway 1'){
            console.log("condition 1");
        }else{   
            console.log('condition 2');
            $("#appr_tr_1_3").show();
            $("#appr_path").attr("required", "true");
            if(pathway =='Pathway 1'){
                console.log('condition 3');
                $("#appr_path_1").attr("required", "true");  
                $("#appr_tr_2_3").show();
            }
        }
    }else{
        $("#appr_path").removeAttr("required");
        $("#appr_path_1").removeAttr("required");  
        $("#appr_tr_1_3").hide();
        $("#appr_tr_2_3").hide();
    }
    const change_status_3 = (val) => {
        console.log(val);
        // 3 july 2023
        
        // Approval
        if (val == "Approved") {
            // $("#approval_comment_input_stage_2").attr("required", "true");
            $("#approval_comment_tr_stage_3").show();
        } else {
            // $("#approval_comment_input_stage_2").removeAttr("required");
            $("#approval_comment_tr_stage_3").hide();
            // $("#approval_comment_input_stage_2").removeAttr("required");
        }
        <?php 
        // approved
        
        
        
        
        $appr_path_1 = 0;
        $appr_path = 0;
        $outcome_letter_3 = find_one_row_3_field('documents','stage','stage_3','pointer_id',$pointer_id,'required_document_id',26);
        if ($outcome_letter_3) {
            $appr_path_1 = 1;
            }
        $qualification_doc_3 = find_one_row_3_field('documents','stage','stage_3','pointer_id',$pointer_id,'required_document_id',25);
        if ($qualification_doc_3) {
             $appr_path = 1;
             } 
        // decline
        $dec_path_1 = 0;
        $dec_path_2 = 0;
        $dec_3_1 = find_one_row_3_field('documents','stage','stage_3','pointer_id',$pointer_id,'required_document_id',23);
        if ($dec_3_1) {
            $dec_path_1 = 1;
            }
        $dec_3_2 = find_one_row_3_field('documents','stage','stage_3','pointer_id',$pointer_id,'required_document_id',24);
        if ($dec_3_2) {
             $dec_path_2 = 1;
             } 
        
        ?>
        var dec_path_1 = <?=$dec_path_1?>;
        var dec_path_2 = <?=$dec_path_2?>;
        var appr_path = <?=$appr_path?>;
        var appr_path_1 = <?=$appr_path_1?>;
       
        if (val == "Declined") {
            $("#reason_tr_1_3").show();
            $("#reason_tr_2_3").show();
            if(dec_path_1 == 0){
            $("#dec_path_1").attr("required", "true");
            }
            if(dec_path_2 == 0){
            $("#dec_Statement_of_Reasons").attr("required", "true");
            }
        } else {
            
            $("#dec_path_1").removeAttr("required");
            $("#dec_Statement_of_Reasons").removeAttr("required");
            $("#reason_tr_1_3").hide();
            $("#reason_tr_2_3").hide();
        }
        // akanksha 28 june 2023
        if(val == "Approved"){
                console.log(pathway);
                console.log(ocupation_id);
            if((ocupation_id == 7 || ocupation_id == 18) && pathway =='Pathway 1'){
                console.log("condition 1");
            }else{   
                console.log('condition 2');
                $("#appr_tr_1_3").show();
                if(appr_path == 0){
                    $("#appr_path").attr("required", "true");
                }
                if(pathway =='Pathway 1'){
                    console.log('condition 3');
                    if(appr_path_1 == 0){
                    $("#appr_path_1").attr("required", "true");
                    }
                    $("#appr_tr_2_3").show();
                }
            }
        }else{
            $("#appr_path").removeAttr("required");
            $("#appr_path_1").removeAttr("required");  
            $("#appr_tr_1_3").hide();
            $("#appr_tr_2_3").hide();
        }
    }
    // stage 3 reassessment
    <?php if (!empty($stage_3_reassessment)) { ?>
        var status_3_r = '<?= $stage_3_reassessment->status ?>';
    <?php } else { ?>
        var status_3_r = "";
    <?php } ?>
    
    if (status_3_r == "Declined") {
        $("#reason_tr_1_3_reass").show();
        $("#reason_tr_2_3_reass").show();
    } else {
        $("#reason_tr_1_3_reass").hide();
        $("#reason_tr_2_3_reass").hide();
    }
    
    if (status_3_r == "Approved") {
        console.log(pathway);
            console.log(ocupation_id);
        if((ocupation_id == 7 || ocupation_id == 18) && pathway =='Pathway 1'){
            console.log("condition 1");
        }else{   
            console.log('condition 2');
            $("#appr_tr_1_3_reass").show();
            $("#appr_path_r").attr("required", "true");
            if(pathway =='Pathway 1'){
                console.log('condition 3');
                $("#appr_path_1_r").attr("required", "true");  
                $("#appr_tr_2_3_reass").show();
            }
        }
    }else{
        $("#appr_path_r").removeAttr("required");
        $("#appr_path_1_r").removeAttr("required");  
        $("#appr_tr_1_3_reass").hide();
        $("#appr_tr_2_3_reass").hide();
    }
    
    const change_status_3_reassessment = (val) => {
        console.log(val);
        // 3 july 2023
        <?php 
        // approved
        $appr_path_1_r = 0;
        $appr_path_r = 0;
        $outcome_letter_3_r = find_one_row_3_field('documents','stage','stage_3_R','pointer_id',$pointer_id,'required_document_id',26);
        if ($outcome_letter_3_r) {
            $appr_path_1_r = 1;
            }
        $qualification_doc_3_r = find_one_row_3_field('documents','stage','stage_3_R','pointer_id',$pointer_id,'required_document_id',25);
        if ($qualification_doc_3_r) {
            $appr_path_r = 1;
            } 
        // decline
        $dec_path_1_r = 0;
        $dec_path_2_r = 0;
        $dec_3_1_r = find_one_row_3_field('documents','stage','stage_3_R','pointer_id',$pointer_id,'required_document_id',23);
        if ($dec_3_1_r) {
            $dec_path_1_r = 1;
            }
        $dec_3_2_r = find_one_row_3_field('documents','stage','stage_3_R','pointer_id',$pointer_id,'required_document_id',24);
        if ($dec_3_2_r) {
            $dec_path_2_r = 1;
            } 
        
        ?>
        var dec_path_1_r = <?=$dec_path_1_r?>;
        var dec_path_2_r = <?=$dec_path_2_r?>;
        var appr_path_r = <?=$appr_path_r?>;
        var appr_path_1_r = <?=$appr_path_1_r?>;
   
        if (val == "Declined") {
            $("#reason_tr_1_3_reass").show();
            $("#reason_tr_2_3_reass").show();
            if(dec_path_1_r == 0){
            $("#dec_path_1_r").attr("required", "true");
            }
            if(dec_path_2_r == 0){
            $("#dec_Statement_of_Reasons_r").attr("required", "true");
            }
        } else {
            
            $("#dec_path_1_r").removeAttr("required");
            $("#dec_Statement_of_Reasons_r").removeAttr("required");
            $("#reason_tr_1_3_reass").hide();
            $("#reason_tr_2_3_reass").hide();
        }
        if(val == "Approved"){
                console.log(pathway);
                console.log(ocupation_id);
            if((ocupation_id == 7 || ocupation_id == 18) && pathway =='Pathway 1'){
                console.log("condition 1");
            }else{   
                console.log('condition 2');
                $("#appr_tr_1_3_reass").show();
                if(appr_path_r == 0){
                    $("#appr_path_r").attr("required", "true");
                }
                if(pathway =='Pathway 1'){
                    console.log('condition 3');
                    if(appr_path_1_r == 0){
                    $("#appr_path_1_r").attr("required", "true");
                    }
                    $("#appr_tr_2_3_reass").show();
                }
            }
        }else{
            $("#appr_path_r").removeAttr("required");
            $("#appr_path_1_r").removeAttr("required");  
            $("#appr_tr_1_3_reass").hide();
            $("#appr_tr_2_3_reass").hide();
        }
    }
    
    
    //stage 4
            const change_status_4 = (val) => {
        console.log(val);
         <?php 
    // approved
    $appr_path_1 = 0;
    $appr_path = 0;
    $outcome_letter_4 = find_one_row_3_field('documents','stage','stage_4','pointer_id',$pointer_id,'required_document_id',47);
    if ($outcome_letter_4) {
        $appr_path = 1;
        }
    $qualification_doc_4 = find_one_row_3_field('documents','stage','stage_4','pointer_id',$pointer_id,'required_document_id',48);
    if ($qualification_doc_4) {
        //  s4_appr_path_1
        $appr_path_1 = 1;
         } 
    // decline
    $s4_dec_path_1 = 0;
    $s4_dec_path_2 = 0;
    $dec_3_1 = find_one_row_3_field('documents','stage','stage_4','pointer_id',$pointer_id,'required_document_id',45);
    if ($dec_3_1) {
        $s4_dec_path_1 = 1;
        }
    $dec_3_2 = find_one_row_3_field('documents','stage','stage_4','pointer_id',$pointer_id,'required_document_id',46);
    if ($dec_3_2) {
         $s4_dec_path_2 = 1;
         } 
    // s4_dec_path_1
    ?>
    var s4_dec_path_1 = <?=$s4_dec_path_1?>;
    var s4_dec_path_2 = <?=$s4_dec_path_2?>;
    var s4_appr_path = <?=$appr_path?>;
    var s4_appr_path_1 = <?=$appr_path_1?>;
   
                        
        if (val == "Declined") {
            $("#s4_reason_tr_1_4").show();
            $("#s4_reason_tr_2_4").show();
            if(s4_dec_path_1 == 0){
            $("#s4_dec_path_1").attr("required", "true");
            }
            if(s4_dec_path_2 == 0){
            $("#s4_dec_path_2").attr("required", "true");
            }
        } else {
            $("#s4_dec_path_1").removeAttr("required");
            $("#s4_dec_path_2").removeAttr("required");
            $("#s4_reason_tr_1_4").hide();
            $("#s4_reason_tr_2_4").hide();

        }
        // code block
        if (val == "Approved") {
            $("#s4_appr_tr_1_4").show();
            // s4_appr_tr_2_4
            if(s4_appr_path == 0){
            $("#s4_appr_path").attr("required", "true");
            }
            if(s4_appr_path_1 == 0){
            $("#s4_appr_path_1").attr("required", "true");
            }
            $("#s4_appr_tr_2_4").show();
            
        } else {
            $("#s4_appr_path").removeAttr("required");
            $("#s4_appr_path_1").removeAttr("required");
            $("#s4_appr_tr_1_4").hide();
            $("#s4_appr_tr_2_4").hide();
        }
        
        
    }
    // change status stage 3 ----------------------------
    $("#stage_3_change_status").submit(function(e) {
        e.preventDefault();
    var selete_status ="";   
    var actype=document.getElementById("actype").value;
    var status_element = document.getElementById("stage_3_status_drop");
    if(actype == 'admin'){
     var preference_location = document.getElementById("preference_location");
    }else{
       preference_location=""; 
    }
    console.log(preference_location.value);
    var which_stage3 = $("#___stage_3_status").val();
    if(which_stage3 == "Submitted"){
        if(preference_location.value == "Online (Via Zoom)"){
          
            
            
            
            
            // console.log('timezone --->'+ time_zone);
            // return;
            
            
            var check_exemption_form = $("#___exemption_form").val();
            var check_pathway_form = $("#___pathway").val();
            var check_occupation_form = $("#__occupation").val();
            var __onshore_user = $("#__onshore_user").val();
            
            console.log(__onshore_user);
            console.log(check_exemption_form);
          // alert(check_pathway_form);
           //alert(check_occupation_form);
           
           
            if(!check_exemption_form){
                if (check_pathway_form !== 'Pathway 1' && (check_occupation_form !== 7 || check_occupation_form !== 18) && __onshore_user == "") {
                    custom_alert_popup_show(
                        header = '',
                        body_msg = "Please select exemption form.",
                        close_btn_text = 'Ok',
                        close_btn_css = 'btn-danger',
                        other_btn = false
                    );
                    return;
                }
                
                if(__onshore_user != ""){
                    custom_alert_popup_show(
                        header = '',
                        body_msg = "Please Select Agent / Applicant TI Declaration.",
                        close_btn_text = 'Ok',
                        close_btn_css = 'btn-danger',
                        other_btn = false
                    );
                    return;
                }
            }
           //  console.log('timezone --->'+ time_zone);
            
        }
    }

        if (status_element) {
            var selete_status = status_element.value;
        }
        if (selete_status != "Select Status"){
            if(preference_location.value == "Online (Via Zoom)"){
             var time_zone=$('#time_zone').val();
            if(time_zone == ''){
             custom_alert_popup_show(header = '', body_msg = "Please Select Time Zone", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
              return;
            }
            }

            custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_3_pop_btn');
            // check Btn click
            $("#stage_3_pop_btn").click(function() {
                // if return true 
                if (custom_alert_popup_close('stage_3_pop_btn')) {
                    $('#cover-spin').show(0);
                	$('#preference_location').attr('disabled',false);
                    var formData = new FormData(document.getElementById("stage_3_change_status"));
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("admin/application_manager/status_change/stage_3") ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            // return;
                            $('#cover-spin').hide(0);
                            console.log(data);
    
                            data = JSON.parse(data);
                            if (data["response"] == true) {
                                
                                window.location.reload();
                            } else {
                                // alert();
                                
                                custom_alert_popup_show(header = '', body_msg = data["msg"], close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                                return;
                            }
    
                        }
                    });
                    $('#preference_location').attr('disabled',true);
    
                }
            })
        }else{
            custom_alert_popup_show(header = '', body_msg = "Please Select Status", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
           
        }
        
    
    }); // view updata->stage 3 end ----------------------------
    
    
    
    // change status stage 3 reassessment ----------------------------
    $("#stage_3_reassessment_change_status").submit(function(e) {
        e.preventDefault();
    var selete_status ="";   
    var status_element = document.getElementById("stage_3_reass_status_drop");
        if (status_element) {
            var selete_status = status_element.value;
        }
        if (selete_status != "Select Status"){
            var preference_location_3r=$('#preference_location_r').val();
            //console.log(preference_location_3r);
            if(preference_location_3r == "Online (Via Zoom)"){
             var time_zone=$('#time_zone_r').val();
             if(time_zone == ''){
             custom_alert_popup_show(header = '', body_msg = "Please Select Time Zone", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
              return;
            }
            }

            custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_3_res_pop_btn');
            // check Btn click
            $("#stage_3_res_pop_btn").click(function() {
                // if return true 
                if (custom_alert_popup_close('stage_3_res_pop_btn')) {
                    $('#cover-spin').show(0);
                	$('#preference_location').attr('disabled',false);
                    var formData = new FormData(document.getElementById("stage_3_reassessment_change_status"));
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("admin/application_manager/status_change/stage_3_reassessment") ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            // return;
                            $('#cover-spin').hide(0);
                            console.log(data);

                            data = JSON.parse(data);
                            if (data["response"] == true) {
                                window.location.reload();
                            } else {
                                alert(data["msg"]);
                            }
    
                        }
                    });
                    $('#preference_location').attr('disabled',true);
    
                }
            })
        }else{
            custom_alert_popup_show(header = '', body_msg = "Please Select Status", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
           
        }
        
    
    }); // view updata->stage 3 reassessment end ----------------------------
    
    
        // change status stage 4 ----------------------------
    $("#stage_4_change_status").submit(function(e) {
        e.preventDefault();
        var selete_status =  $("#stage_4_status_drop").val();
        console.log(selete_status);
        if (selete_status == "Select Status" || selete_status == null){
             custom_alert_popup_show(header = '', body_msg = "Please Select Status", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
            return;
        }
         
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_4_pop_btn');
        // check Btn click
        $("#stage_4_pop_btn").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_4_pop_btn')) {
                $('#cover-spin').show(0);
            	$('#preference_location_stage_4').attr('disabled',false);
                var formData = new FormData(document.getElementById("stage_4_change_status"));
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/status_change/stage_4") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#cover-spin').hide(0);
                        console.log(data);
                        console.log("-------------------------------- vishal ---------------------------------------------------");

                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                        } else {
                            alert(data["msg"]);
                        }

                    }
                });
                $('#s4_preference_location').attr('disabled',true);

            }
        })
    }); 
    
        // view status 4 updata end ------------------------------

    
    
    
    
    
    // view updata end ------------------------------
    // Documnents ------------------------------

    // document->stage 1 ----------------------------
    function show_input(count_id) {
        if ($("#input_" + count_id).css("display") == "none") {
            $("#input_" + count_id).css("display", "block");
            $("#input_" + count_id).focus();
            $("#Dbtn_" + count_id).hide();
            $("#Xbtn_" + count_id).show();
            console.log("ch_3");
            check();
        } else {
            $("#input_" + count_id).val("");
            $("#input_" + count_id).css("display", "none")
            $("#Dbtn_" + count_id).show();
            $("#Xbtn_" + count_id).hide();
            $('#s1_doc_sub_btn').css("display", "block");
            console.log("check");
            check();
        }
    }

    function check() {
        var count_ = 0;
        var value = $('input[type="text"].s1').filter(function() {
            console.log(value);
            if (this.value.length > 0) {
                count_++;
            }
        });
        console.log(count_);
        if (count_ > 0) {
            $('#s1_doc_sub_btn').css("display", "block");
        } else {
            $('#s1_doc_sub_btn').hide();
        }
    }

    // comments function ---------------------------  
    // function reason_form_stage_1(){
    //     //  e.preventDefault();
    //     var formData = document.getElementById("reason_form_stage_1");
    //     console.log(formData);
    //     return;
        
    //     custom_alert_popup_show(header = '', body_msg = "Do you want to send  the additional info request ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_doc_1_pop_btn');
    //     // check Btn click
    //     $("#stage_doc_1_pop_btn").click(function() {
    //                 //  e.preventDefault();
    //         // if return true 
    //         if (custom_alert_popup_close('stage_doc_1_pop_btn')) {
    //     //         var form = document.getElementById("reason_form_stage_1");
        
                // var form = new FormData(document.getElementById("reason_form_stage_1"));
        //   $reasons = $this->request->getPost('reason');
        // $stages = $this->request->getPost('stage');
        // $pointer_ids = $this->request->getPost('pointer_id');
        // $document_ids = $this->request->getPost('document_id');
        // $request_additional = $this->request->getPost("request_additional");
    //       var formData = new FormData();
    // formData.append('file', file);

    // var pointer_id = '<?=$pointer_id?>';
    // formData.append("reason", reason);
    // formData.append("stage", stage);
    // formData.append("pointer_id", pointer_id);
    // formData.append("document_id", document_id);
    // formData.append("request_additional", request_additional);

        // var formData = new FormData(form);
        // var reason = formData.get("reason");
        // var stage = formData.get("stage");
        // var pointer_id = formData.get("pointer_id");
        // var document_id = formData.get("document_id");
        // var request_additional = formData.get("request_additional");
    //             $('#cover-spin').show(0);
    //             $.ajax({
    //                 method: "POST",
    //                 url: "<?= base_url("admin/application_manager/comment_document") ?>",
    //                 data: formData,
    //                 processData: false,
    //                 contentType: false,
    //                 success: function(data) {
    //                     data = JSON.parse(data);
    //                     if (data["response"] == true) {
    //                         window.location.reload();
    //                         // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+data['pointer_id']+tab;
    //                     } else {
    //                         alert(data["msg"]);
    //                     }
    //                 }
    //             });
    //         }
    //     })
    // }
    
    $("#reason_form_stage_1").submit(function(e) {
        e.preventDefault();
        custom_alert_popup_show(header = '', body_msg = "Do you want to send  the additional info request ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_doc_1_pop_btn');
        // check Btn click
        $("#stage_doc_1_pop_btn").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_doc_1_pop_btn')) {
                var formData = new FormData(document.getElementById("reason_form_stage_1"));
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/comment_document") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+data['pointer_id']+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    }
                });
            }
        })
    });

    $("#verify_email_stage_1").submit(function(e) {
        e.preventDefault();
        // custom_alert_popup_show(header = '', body_msg = "Are you sure you want to Add Employment Email Verification ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_verfi_emil_pop_btn');
        // // check Btn click
        // $("#stage_1_verfi_emil_pop_btn").click(function() {
        //     // if return true 
        //     if (custom_alert_popup_close('stage_1_verfi_emil_pop_btn')) {}
        // });
        $('#cover-spin').show(0);
        var formData = new FormData(document.getElementById("verify_email_stage_1"));
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/application_manager/verify_email_stage_1") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data["response"] == true) {
                    window.location.reload();
                } else {
                    alert(data["msg"]);
                    $('#cover-spin').hide(0);
                }
            }
        });

    });
    
    $("#quali_verify_form").submit(function(e) {
        e.preventDefault();
        $("#loader-please-wait").show();
        var formData = new FormData($(this)[0]);
         custom_alert_popup_show(header = '', body_msg = "Are you sure you want to Send Qualification Verification Email ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_quali_verfi_emil_pop_btn');
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
    });
    
    // document->stage 1 end ----------------------------
    // document->stage 2 ----------------------------
    function show_input_s2(count_id) {
        var add_doc_id =  add_doc_id;
        // console.log(add_doc_id);return;
        
        if ($("#input_s2_" + count_id).css("display") == "none") {
            $("#input_s2_" + count_id).css("display", "block");
            $("#input_s2_" + count_id).focus();
            $("#Dbtn_s2_" + count_id).hide();
            $("#Xbtn_s2_" + count_id).show();
            
            
            check_s2();
        } else {
            $("#input_s2_" + count_id).val("");
            $("#input_s2_" + count_id).css("display", "none")
            $("#Dbtn_s2_" + count_id).show();
            $("#Xbtn_s2_" + count_id).hide();
            // $("#new_testing_" + count_id).show();
            // $("#close_new_" + count_id).hide();
            $('#s2_doc_sub_btn').css("display", "block");
            check_s2();
        }
        //  $('#add_more_button').css('disabled', false);
        
    }
    
    
    
    function add_show_input_s2(count_id_,add_doc_id) {
        var add_doc_id =  add_doc_id;
        // console.log(add_doc_id);return;
        
        if ($("#input_s2_Additional_" + add_doc_id).css("display") == "none") {
            $("#input_s2_Additional_" + add_doc_id).css("display", "block");
            $("#input_s2_Additional_" + add_doc_id).focus();
            $("#Dbtn_s2_Additional_" + add_doc_id).hide();
            $("#Xbtn_s2_Additional_" + add_doc_id).show();
            
            
            check_s2();
        } else {
            $("#input_s2_Additional_" + add_doc_id).val("");
            $("#input_s2_Additional_" + add_doc_id).css("display", "none")
            $("#Dbtn_s2_Additional_" + add_doc_id).show();
            $("#Xbtn_s2_Additional_" + add_doc_id).hide();
            // $("#new_testing_" + count_id).show();
            // $("#close_new_" + count_id).hide();
            $('#s2_doc_sub_btn').css("display", "block");
            // check_s2();
        }
        //  $('#add_more_button').css('disabled', false);
        
    }
    
    function show_input_s2_(count_id)
    {
       
        if($("#input_s2_new_" + count_id).css("display") == "none")
        {
            // console.log('heyyy');return;
           
            $("#input_s2_new_" + count_id).css("display", "block");
            $("#new_testing_" + count_id).hide();
            $("#close_new_" + count_id).show();
            check_s2();
        }else{
            $("#input_s2_new_" + count_id).val("");
            $("#input_s2_new_" + count_id).css("display", "none");
             $("#new_testing_" + count_id).show();
            $("#close_new_" + count_id).hide();
        }
        
        
       
    }

    function check_s2(id) {
        var count_ = 0;
        var id = id;
        // console.log(id);return;

        var value = $('input[type="text"].s1').filter(function() {
            console.log(value);
            if (this.value.length > 0) {
                count_++;
            }
        });
        
       
        
        console.log(count_);
        if (count_ > 0) {
            $('#s2_doc_sub_btn').css("display", "block");
            $('#'+id).css('background-color', '#ffcc01');
            
            

        } else {
            $('#s2_doc_sub_btn').hide();
            //  $('#add_more_button').css('color', 'red');
        }
        //  var button = document.getElementById('add_more_button');
       
        //  button.classList.remove('disabled');
        
        
        //  $('#add_more_button').css("background-color", "#ffcc01 !important");
    }
    // comments function ---------------------------   
    $("#reason_form_stage_2").submit(function(e) {
        e.preventDefault();


        custom_alert_popup_show(header = '', body_msg = "Do you want to send  the additional info request ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_doc_2_pop_btn');
        // check Btn click
        $("#stage_doc_2_pop_btn").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_doc_2_pop_btn')) {
                var formData = new FormData(document.getElementById("reason_form_stage_2"));
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/comment_document_stage_2") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {

                        console.log(data);

                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+data['pointer_id']+tab;
                        } else {
                            $('#cover-spin').hide(0);

                            alert(data["msg"]);
                        }
                    }
                });
            }
        })
    });
    // send mail to employes function ---------------------------   
     function send_emp_email() {
        // creat alert box 
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to send Employment Verification Email ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDS');
        // check Btn click
        $("#AJDS").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDS')) {
                $('#cover-spin').show(100);
                $.ajax({
                    url: "<?= base_url('admin/application_manager/send_employ_email_stage_2') ?>",
                    method: "POST",
                    data: {
                        "pointer_id": pointer_id,
                    },
                    success: function(data) {
                        $('#cover-spin').hide(200);
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                        } else {
                            alert(data["msg"]);
                        }
                    }
                });
            }
        })
    }
    // verify employee mail function ---------------------------   
    $("#verify_email_stage_2").submit(function(e) {
        e.preventDefault();
        // custom_alert_popup_show(header = '', body_msg = "Are you sure you want to Add Employment Email Verification  ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_ver_emp_2_pop_btn');
        // check Btn click
        // $("#stage_ver_emp_2_pop_btn").click(function() {
        //     // if return true 
        //     if (custom_alert_popup_close('stage_ver_emp_2_pop_btn')) {}
        // });

        var formData = new FormData(document.getElementById("verify_email_stage_2"));
        $('#cover-spin').show(0);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/application_manager/verify_email_stage_2") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data["response"] == true) {
                    window.location.reload();
                } else {
                    alert(data["msg"]);
                }
            }
        });

    });
    // document->stage 2 end ----------------------------
    // document->stage 3 ----------------------------
    function show_input_s3(count_id) {
        
        if ($("#input_s3_" + count_id).css("display") == "none") {
            $("#input_s3_" + count_id).css("display", "block");
            $("#input_s3_" + count_id).focus();
            $("#Dbtn_s3_" + count_id).hide();
            $("#Xbtn_s3_" + count_id).show();
            console.log("hfjhg");
            check_s3();
        } else {
            $("#input_s3_" + count_id).val("");
            $("#input_s3_" + count_id).css("display", "none")
            $("#Dbtn_s3_" + count_id).show();
            $("#Xbtn_s3_" + count_id).hide();
            $('#s3_doc_sub_btn').css("display", "block");
            check_s3();
        }
    }
    
    function check_s3() {
       
        var count_ = 0;
        //alert(count_)
        var value = $('input[type="text"].s1').filter(function() {
            console.log(value);
            if (this.value.length > 0) {
                count_++;
            }
        });
        console.log(count_);
        if (count_ > 0) {
            $('#s3_doc_sub_btn').css("display", "block");
        } else {
            $('#s3_doc_sub_btn').hide();
        }
    }

    // comments function ---------------------------   
    $("#reason_form_stage_3").submit(function(e) {
        e.preventDefault();
        custom_alert_popup_show(header = '', body_msg = "Do you want to send  the additional info request ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_doc_3_pop_btn');
        // check Btn click
        $("#stage_doc_3_pop_btn").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_doc_3_pop_btn')) {
                var formData = new FormData(document.getElementById("reason_form_stage_3"));
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/comment_document") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+data['pointer_id']+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    }
                });
            }
        })
    });
    // document->stage 3 end ----------------------------
    // document->stage 3 reassessment ----------------------------
    function show_input_s3_r(count_id) {
       //alert('check33')
        if ($("#input_s3_r_" + count_id).css("display") == "none") {
            $("#input_s3_r_" + count_id).css("display", "block");
            $("#input_s3_r_" + count_id).focus();
            $("#Dbtn_s3_r_" + count_id).hide();
            $("#Xbtn_s3_r_" + count_id).show();
            console.log("hfjhg");
            check_s3_r();
        } else {
            $("#input_s3_r_" + count_id).val("");
            $("#input_s3_r_" + count_id).css("display", "none")
            $("#Dbtn_s3_r_" + count_id).show();
            $("#Xbtn_s3_r_" + count_id).hide();
            $('#s3_r_doc_sub_btn').css("display", "block");
            check_s3_r();
        }
    }
    
    function check_s3_r() {
        
        var count_ = 0;
        //alert(count_)
        var value = $('input[type="text"].s1').filter(function() {
            console.log(value);
            if (this.value.length > 0) {
                count_++;
            }
        });
        console.log(count_);
        if (count_ > 0) {
            $('#s3_r_doc_sub_btn').css("display", "block");
        } else {
            $('#s3_r_doc_sub_btn').hide();
        }
    }

    // comments function ---------------------------   
    $("#reason_form_stage_3_reassessment").submit(function(e) {
        e.preventDefault();
        custom_alert_popup_show(header = '', body_msg = "Do you want to send  the additional info request ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_doc_3_pop_btn');
        // check Btn click
        $("#stage_doc_3_pop_btn").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_doc_3_pop_btn')) {
                var formData = new FormData(document.getElementById("reason_form_stage_3_reassessment"));
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/comment_document") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+data['pointer_id']+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    }
                });
            }
        })
    });
    
    // document->stage 4 ----------------------------
    function show_input_s4(count_id) {
        if ($("#input_s4_" + count_id).css("display") == "none") {
            $("#input_s4_" + count_id).css("display", "block");
            $("#input_s4_" + count_id).focus();
            $("#Dbtn_s4_" + count_id).hide();
            $("#Xbtn_s4_" + count_id).show();
            console.log("hfjhg");
            check_s4();
        } else {
            $("#input_s4_" + count_id).val("");
            $("#input_s4_" + count_id).css("display", "none")
            $("#Dbtn_s4_" + count_id).show();
            $("#Xbtn_s4_" + count_id).hide();
            $('#s4_doc_sub_btn').css("display", "block");
            check_s4();
        }
    }

    function check_s4() {
        var count_ = 0;
        var value = $('input[type="text"].s1').filter(function() {
            console.log(value);
            if (this.value.length > 0) {
                count_++;
            }
        });
        console.log(count_);
        if (count_ > 0) {
            $('#s4_doc_sub_btn').css("display", "block");
        } else {
            $('#s4_doc_sub_btn').hide();
        }
    }
    
    // document->stage 4  ----------------------------
    $("#reason_form_stage_4").submit(function(e) {
        e.preventDefault();
        custom_alert_popup_show(header = '', body_msg = "Do you want to send  the additional info request ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_doc_4_pop_btn');
        // check Btn click
        $("#stage_doc_4_pop_btn").click(function() {
            // if return true 
            if (custom_alert_popup_close('stage_doc_4_pop_btn')) {
                var formData = new FormData(document.getElementById("reason_form_stage_4"));
                $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url("admin/application_manager/comment_document") ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+data['pointer_id']+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    }
                });
            }
        })
    });
    // document->stage 4 end ----------------------------
    
    
    // Common function --------------------------- 
    // table should not sort
    $(document).ready(function() {
        $('no_filter_table').DataTable({
            "columnDefs": [{
                    "orderable": false,
                    "aTargets": [0, 1, 2]
                },
                // { "bSearchable": false, "aTargets": [ 0, 1, 2 ] }
            ]
        });
    });

    // Delete function --------------------------- 
    function delete_document(id) {
        
         
        // var form = $("#reason_form_stage_3");
        // form.preventDefault();
        custom_alert_popup_show(header = '', body_msg = "Are you sure that you would like to permanently delete this file ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
        $("#delete_pop_btn").click(function() {
            if (custom_alert_popup_close('delete_pop_btn')) {
                $('#cover-spin').show(0);
                $.ajax({
                    url: "<?= base_url('admin/application_manager/delete_document') ?>/" + id,
                    method: "POST",
                    data: {
                        "id": id,
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+pointer_id+'/'+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        });
    }
    
    
    var count_company = '<?=$count_company?>';
    function delete_employe(id) {
        // if (count_company == 1){
        //      custom_alert_popup_show(header = '', body_msg = "The application have only one Organization.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
        //     return;
        // }
    
        // return;
        // var form = $("#reason_form_stage_3");
        // form.preventDefault();
        custom_alert_popup_show(header = '', body_msg = "Are you sure that you would like to permanently delete this Organization ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn_s2');
        $("#delete_pop_btn_s2").click(function() {
            if (custom_alert_popup_close('delete_pop_btn_s2')) {

                $('#cover-spin').show(0);
                $.ajax({
                    url: "<?= base_url('admin/application_manager/delete_company') ?>/" + id,
                    method: "POST",
                    data: {
                        "id": id,
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php base_url("admin/application_manager/view_application/") ?>/"+pointer_id+'/'+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });

            }
        });
    }
    // zip for all stage function --------------------------- 
    function download_zip(pointer_id, stage) {
        // creat alert box 
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to download all files?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $.ajax({
                    url: "<?= base_url('admin/application_manager/download_zip') ?>/" + pointer_id + '/' + stage,
                    type: "POST",
                    data: {
                        "pointer_id": pointer_id,
                        "stage": stage,
                    },
                    beforeSend: function() {},
                    success: function(data) {
                        console.log(data);

                        window.location = data;
                        
                        setTimeout(function() {
                              location.reload();
                            }, 5000);

                    // header("Refresh: 5; URL=http://example.com/newpage.php");

                    },
                });
            }
        })
    }
    // Common function end --------------------------- 
    // Documnents end ------------------------------
    var stage_level = '<?= $application_pointer->stage ?>';
    console.log(stage_level);
    if (stage_level == 'stage_1') {
        var element = document.getElementById("view_stage_1");
        element.classList.add('show')
        var element_1 = document.getElementById("doc_stage_1");
        element_1.classList.add('show')
    } else if (stage_level == 'stage_2') {
        var element = document.getElementById("stage_2");
        element.classList.add('show')
        var element_1 = document.getElementById("doc_stage_2");
        element_1.classList.add('show')
    } else if (stage_level == 'stage_3') {
        var element = document.getElementById("stage_3");
        element.classList.add('show')
        var element_1 = document.getElementById("doc_stage_3");
        element_1.classList.add('show')
    } else if (stage_level == 'stage_3_R') {
        var element = document.getElementById("stage_3_reassessment");
        element.classList.add('show')
        var element_1 = document.getElementById("doc_stage_3_reassessment");
        element_1.classList.add('show')
    } else if (stage_level == 'stage_4') {
        var element = document.getElementById("stage_4");
        element.classList.add('show')
        var element_1 = document.getElementById("doc_stage_4");
        element_1.classList.add('show')
    }
    
    // -------------------
    // Tab Change Here Code
    // -------------------


    // vishal patel  26-04-2023   &#9786;
    // stage 3 
    $('.auto_file_upload').hide();
    $('.auto_file_upload_appr_path').hide();
    // vishal 27-04-2023 
    $('.auto_file_upload_dec_path_1').hide();
    $('.auto_file_upload_dec_Statement_of_Reasons').hide();
    
    // stage 3 reassessment
    $('.auto_file_upload_r').hide();
    $('.auto_file_upload_appr_path_r').hide();
    // vishal 27-04-2023 
    $('.auto_file_upload_dec_path_1_r').hide();
    $('.auto_file_upload_dec_Statement_of_Reasons_r').hide();
    
    
    // Akanksha falle  5-7-2023
    // stage 4 
    $('.auto_file_upload_s4').hide();
    $('.auto_file_upload_appr_path_s4').hide();
    // vishal 27-04-2023 
    $('.auto_file_upload_dec_path_s4').hide();
    $('.auto_file_upload_dec_Statement_of_Reasons_s4').hide();

    // Akanksha falle  16-6-2023
    // stage 2 decline
    $('.auto_file_upload_dec_statement_reason_s2').hide();
    $('.auto_file_upload_s2_outcome').hide();
        function s2_show_upload_file(id) {
        var check = $(id).is(":hidden");
        if (check) {
            if (id == "#s2_outcome") {
                $('.auto_file_upload_s2_outcome').show();
            }
            if (id == "#s2_dec_Statement_of_Reasons") {
                $('.auto_file_upload_dec_statement_reason_s2').show();
            }
            $(id).show();
            $(id).prop('required', true);
            $('#s2_update').attr('disabled',true);

            var occupation= "<?php echo find_one_row('occupation_list', 'id', $s1_occupation->occupation_id)->name; ?>";
            var pathway="<?php echo  $s1_occupation->pathway; ?>";
            if(pathway=="Pathway 1"){
                if(occupation=="Electrician (General)"||occupation=="Plumber (General)"){
                    $(id).prop('required', false);
                }
            }
        } else {
            if (id == "#s2_outcome") {
                $('.auto_file_upload_s2_outcome').hide();
            }
            if (id == "#s2_dec_Statement_of_Reasons") {
                $('.auto_file_upload_dec_statement_reason_s2').hide();
            }
            $(id).hide();
            $(id).prop('required', false);
            $('#s2_update').attr('disabled',false);
        }
    }
    
    // vishal patel  26-04-2023   &#9786;
    function show_upload_file(id) {
        var check = $(id).is(":hidden");
        if (check) {
            if (id == "#appr_path") {
                $('.auto_file_upload_appr_path').show();
            }
            if (id == "#appr_path_1") {
                $('.auto_file_upload').show();
            }
            // vishal 27-04-2023 
            if (id == "#dec_path_1") {
                $('.auto_file_upload_dec_path_1').show();
            }
            if (id == "#dec_Statement_of_Reasons") {
                $('.auto_file_upload_dec_Statement_of_Reasons').show();
            }
            $(id).show();
            $(id).prop('required', true);
            $('#s3_update').attr('disabled',true);

            var occupation= "<?php echo find_one_row('occupation_list', 'id', $s1_occupation->occupation_id)->name; ?>";
            var pathway="<?php echo  $s1_occupation->pathway; ?>";
            if(pathway=="Pathway 1"){
                 if(occupation=="Electrician (General)"||occupation=="Plumber (General)"){
                            $(id).prop('required', false);

            }
           
            }
            
            

        } else {
            if (id == "#appr_path") {
                $('.auto_file_upload_appr_path').hide();
            }
            if (id == "#appr_path_1") {
                $('.auto_file_upload').hide();
            }
            // vishal 27-04-2023 
            if (id == "#dec_path_1") {
                $('.auto_file_upload_dec_path_1').hide();
            }
            if (id == "#dec_Statement_of_Reasons") {
                $('.auto_file_upload_dec_Statement_of_Reasons').hide();
            }
            $(id).hide();
            $(id).prop('required', false);
            $('#s3_update').attr('disabled',false);
        }
    }
    
    function s3_r_show_upload_file(id) {
        var check = $(id).is(":hidden");
        if (check) {
            if (id == "#appr_path_r") {
                $('.auto_file_upload_appr_path_r').show();
            }
            if (id == "#appr_path_1_r") {
                $('.auto_file_upload_r').show();
            }
            // vishal 27-04-2023 
            if (id == "#dec_path_1_r") {
                $('.auto_file_upload_dec_path_1_r').show();
            }
            if (id == "#dec_Statement_of_Reasons_r") {
                $('.auto_file_upload_dec_Statement_of_Reasons_r').show();
            }
            $(id).show();
            $(id).prop('required', true);
            $('#s3_update').attr('disabled',true);

            var occupation= "<?php echo find_one_row('occupation_list', 'id', $s1_occupation->occupation_id)->name; ?>";
            var pathway="<?php echo  $s1_occupation->pathway; ?>";
            if(pathway=="Pathway 1"){
                 if(occupation=="Electrician (General)"||occupation=="Plumber (General)"){
                            $(id).prop('required', false);

            }
           
            }
            
            

        } else {
            if (id == "#appr_path_r") {
                $('.auto_file_upload_appr_path_r').hide();
            }
            if (id == "#appr_path_1_r") {
                $('.auto_file_upload_r').hide();
            }
            // vishal 27-04-2023 
            if (id == "#dec_path_1_r") {
                $('.auto_file_upload_dec_path_1_r').hide();
            }
            if (id == "#dec_Statement_of_Reasons_r") {
                $('.auto_file_upload_dec_Statement_of_Reasons_r').hide();
            }
            $(id).hide();
            $(id).prop('required', false);
            $('#s3_update').attr('disabled',false);
        }
    }
    
    
    function s4_show_upload_file(id) {
        var check = $(id).is(":hidden");
        if (check) {
            if (id == "#s4_appr_path") {
                $('.auto_file_upload_appr_path_s4').show();
            }
            if (id == "#s4_appr_path_1") {
                $('.auto_file_upload_s4').show();
            }
            // vishal 27-04-2023 
            if (id == "#s4_dec_path_1") {
                $('.auto_file_upload_dec_path_s4').show();
            }
            if (id == "#s4_dec_Statement_of_Reasons") {
                $('.auto_file_upload_dec_Statement_of_Reasons_s4').show();
            }
            $(id).show();
            $(id).prop('required', true);
            $('#s4_update').attr('disabled',true);
            
            var occupation= "<?php echo find_one_row('occupation_list', 'id', $s1_occupation->occupation_id)->name; ?>";
            var pathway="<?php echo  $s1_occupation->pathway; ?>";
            if(pathway=="Pathway 1"){
                 if(occupation=="Electrician (General)"||occupation=="Plumber (General)"){
                            $(id).prop('required', false);

            }
           
            }
            
            

        } else {
            if (id == "#s4_appr_path") {
                $('.auto_file_upload_appr_path_s4').hide();
            }
            if (id == "#s4_appr_path_1") {
                $('.auto_file_upload_s4').hide();
            }
            // vishal 27-04-2023 
            if (id == "#s4_dec_path_1") {
                $('.auto_file_upload_dec_path_s4').hide();
            }
            if (id == "#s4_dec_Statement_of_Reasons") {
                $('.auto_file_upload_dec_Statement_of_Reasons_s4').hide();
            }
            $(id).hide();
            $(id).prop('required', false);
            $('#s4_update').attr('disabled',false);
        }
    }
// akanksha 16 june 2023
 function s2_auto_file_upload(file_id, file_upload_name) {
     console.log(file_upload_name);
    //  return;
        const fileData = $("#" + file_id)[0].files[0];
        const pointer_id = "<?= $pointer_id ?>";
        const formData = new FormData();
        formData.append("file", fileData);
        formData.append("pointer_id", pointer_id);
        formData.append("file_upload_name", file_upload_name);
        if (fileData && fileData.size > 0) {
            $('#cover-spin').show(0);

            $.ajax({
                url: "<?= base_url('admin/File_update_stage_2') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log("File uploaded successfully!");
                    console.log(response);
                    if (response == "ok") {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    $('#cover-spin').hide(0);
                    console.error("Error uploading file: " + error);
                    custom_alert_popup_show(header = '', body_msg = "Sorry, file is not uploaded.Successfully some technical issue was found.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

                }
            });
        } else {
            custom_alert_popup_show(header = '', body_msg = "Please select file then try to upload.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        }
    }
    
   
    // vishal patel  26-04-2023   &#9786;
    function auto_file_upload(file_id, file_upload_name) {
        const fileData = $("#" + file_id)[0].files[0];
        const pointer_id = "<?= $pointer_id ?>";
        const formData = new FormData();
        formData.append("file", fileData);
        formData.append("pointer_id", pointer_id);
        formData.append("file_upload_name", file_upload_name);
        // console.log(fileData);
        // console.log(pointer_id);
        // console.log(file_upload_name);
        // console.log("vishal:-------------");
        // return;
        if (fileData && fileData.size > 0) {
            $('#cover-spin').show(0);

            $.ajax({
                url: "<?= base_url('admin/File_update_stage_3') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log("File uploaded successfully!");
                    console.log(response);
                    if (response == "ok") {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    $('#cover-spin').hide(0);
                    console.error("Error uploading file: " + error);
                    custom_alert_popup_show(header = '', body_msg = "Sorry, file is not uploaded.Successfully some technical issue was found.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

                }
            });
        } else {
            custom_alert_popup_show(header = '', body_msg = "Please select file then try to upload.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        }
    }
    
    function s3_r_auto_file_upload(file_id, file_upload_name) {
        const fileData = $("#" + file_id)[0].files[0];
        const pointer_id = "<?= $pointer_id ?>";
        const formData = new FormData();
        formData.append("file", fileData);
        formData.append("pointer_id", pointer_id);
        formData.append("file_upload_name", file_upload_name);
        if (fileData && fileData.size > 0) {
            $('#cover-spin').show(0);

            $.ajax({
                url: "<?= base_url('admin/File_update_stage_3_R') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log("File uploaded successfully!");
                    console.log(response);
                    if (response == "ok") {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    $('#cover-spin').hide(0);
                    console.error("Error uploading file: " + error);
                    custom_alert_popup_show(header = '', body_msg = "Sorry, file is not uploaded.Successfully some technical issue was found.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

                }
            });
        } else {
            custom_alert_popup_show(header = '', body_msg = "Please select file then try to upload.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        }
    }
    
    
    function s4_auto_file_upload(file_id, file_upload_name) {
        
        const fileData = $("#" + file_id)[0].files[0];
        const pointer_id = "<?= $pointer_id ?>";
        const formData = new FormData();
        formData.append("file", fileData);
        formData.append("pointer_id", pointer_id);
        formData.append("file_upload_name", file_upload_name);
        // console.log(fileData);
        // console.log(pointer_id);
        // console.log(file_upload_name);
        // console.log("vishal:-------------");
        // return;
        if (fileData && fileData.size > 0) {
            $('#cover-spin').show(0);

            $.ajax({
                url: "<?= base_url('admin/File_update_stage_4') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log("File uploaded successfully!");
                    console.log(response);
                    if (response == "ok") {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    $('#cover-spin').hide(0);
                    console.error("Error uploading file: " + error);
                    custom_alert_popup_show(header = '', body_msg = "Sorry, file is not uploaded.Successfully some technical issue was found.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

                }
            });
        } else {
            custom_alert_popup_show(header = '', body_msg = "Please select file then try to upload.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        }
    }



    function re_create_TRA(noreload = "") {
        $.ajax({
            url: "<?= base_url('auto_save_download_PDF_admin/' . pointer_id_encrypt($pointer_id) . '/TRA%20Application%20Form'); ?>",
            type: "GET",
            beforeSend: function() {},
            success: function(data) {
                // console.log(data);
                // window.location = data;
                // Mohsin Code -> 1 Nov 2023
                if(noreload == ""){
                    location.reload();
                }
            },
        });
    }
    
        function eddit() {

            new TomSelect("#select_edite_time_zone", {
                plugins: ['dropdown_input']
            });
            
        }
        
        new TomSelect("#time_zone", {
            // create: true,
            // sortField: {
            //     field: "text",
            //     direction: "asc"
            // }
            plugins: ['dropdown_input']
        });
        new TomSelect("#time_zone_r", {
            // create: true,
            // sortField: {
            //     field: "text",
            //     direction: "asc"
            // }
            plugins: ['dropdown_input']
        });
        
          function delete_stage_2(pointer_id)
        {
            var pointer_id = pointer_id;
            
            
        custom_alert_popup_show(header = '', body_msg = "Are you sure that you would like to permanently delete this stage 2 ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_stage2_btn');
        $("#delete_stage2_btn").click(function() {
            if (custom_alert_popup_close('delete_stage2_btn')) {
                $('#cover-spin').show(0);
                $.ajax({
                    url: "<?= base_url('admin/application_manager/delete_stage2') ?>/" + pointer_id,
                    method: "POST",
                    data: {
                        "pointer_id": pointer_id,
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        if (data["response"] == true) {
                            window.location.reload();
                            // window.location = "<?php // base_url("admin/application_manager/view_application/") ?>/"+pointer_id+'/'+tab;
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        });
            
            
            
    }
    
    
    function add_additional_inforamtion(document_id,pointer_id,stage,empolyee_id,row_id, that, type ,input_id,onclick_btn_id,flow = 0)
    {
        var input_id = input_id;
        var count = 1;
        var empolyee_id = empolyee_id
        // console.log(input_id);return;
        var reason = $("#"+input_id).val();
        if(!reason)
        {
            return;
        }
        //console.log(stage);
        var random_no =  Math.floor((Math.random() * 100000) + 1);
        var extra_inputs = "";
        console.log(flow);
        var input_type_name = "request_additional[]";
        // if(flow == 1){
        //     // console.log("Hree");
        //     extra_inputs = `
        //     <input type="hidden" id="input_s2_Additional_value" name="request_additional_value[]" value="${empolyee_id}">
        //       <input type="hidden" name="reupload_emp_docs[]" value="${empolyee_id}">
        //     `;
        //     input_type_name = "request_additional_[]";
        // }
        
        
        var html = `<tr class="tital_set text_index_" style="background-color:white;font-size: 17px;color: #4154f1!important;" id="${row_id}${random_no}" >
                                    <td >
                                         Additional Information - 
                                    </td>
                                    
                                    <td style="text-align: center; ">
                                       
                                        <!----<a herf="" class="btn btn-sm btn_yellow_greenn" onclick="add_additional_inforamtion(${document_id},${pointer_id},'${stage}','${empolyee_id}','${row_id}${random_no}', this,'${type}','input_s2_new_Additional_${random_no}','${onclick_btn_id}',${flow})" style=" border:0px; background-color: #ffcc01 !important; color:black !important;" > -->
                                        <a herf="" class="btn btn-sm btn_yellow_greenn disabled" style=" border:0px; background-color: #ffcc01 !important; color:black !important;" >

                                           
                                            <i class="bi bi-download"></i></a>
                                            <!-- <i class="bi bi-plus"></i></a> -->
                                        
                                        <a class="btn btn-sm btn-danger disabled"><i class="bi bi-trash-fill"></i></a>
                                        <!-- comment  -->
                                        <!--<a href="javascript:void(0)" class="btn btn-sm btn-sm btn_green_yellow pooja" id="DDbtn_s2_Additional" onclick="show_input_s2('Additional_${random_no}')">-->
                                        <a href="javascript:void(0)" class="btn btn-sm btn-sm btn_green_yellow pooja" id="new_testing_Additional_${random_no}" onclick="show_input_s2_('Additional_${random_no}')">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </a>
                                        <!--<a href="javascript:void(0)" class="btn btn-sm btn_yellow_green" style="display: none;" id="XXbtn_s2_Additional" onclick="show_input_s2('Additional_${random_no}')">-->
                                        <a href="javascript:void(0)" class="btn btn-sm btn_yellow_green" style="display: none;" id="close_new_Additional_${random_no}" onclick="delete_row('${row_id}${random_no}')">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" name="document_id[]" value="${document_id}">
                                        <input type="hidden" name="pointer_id[]" value="${pointer_id}">
                                        <input type="hidden" name="stage[]" value="stage_2">
                                        
                                        <input type="text" id="input_s2_new_Additional_${random_no}" style="display: none;" onkeyup=check_s2() class="form-control s1 pooja" name="reason[]" value="${reason}">
                                                    
                                        <input type="hidden" id="input_s2_Additional_value" name="request_additional_value[]" value="${empolyee_id}">
                                        <input type="hidden" name="reupload_emp_docs[]" value="${empolyee_id}">
                                        <input type="hidden" name="support_evidance_status[]" value="${type}">
                                    </td>
                    </tr>`;
            // console.log(html); 
            // $(that).html("<i class='bi bi-download'></i>");
            // $(html).insertBefore("#"+row_id);
            
            
            
            $(html).insertAfter("#"+row_id);
             count++;
             console.log(count);
        //   $('#additonal_information_id').html(count);
            $("#"+input_id).val('');
            
            if(onclick_btn_id == 'show_input_s2_')
          {            
            show_input_s2_('Additional');
            show_input_s2_('Additional_'+random_no);
          }else if(onclick_btn_id == 'show_input_s2'){
              show_input_s2('Additional');
              show_input_s2_('Additional_'+random_no);
          }else if(onclick_btn_id == 'add_show_input_s2')  
          {
              add_show_input_s2('Additional',empolyee_id);
              show_input_s2_('Additional_'+random_no);
          }
          
            // show_input_s2_('Additional_'+${random_no});
            
            // $('#input_s2_new_Additional').reset();
           
            
            // $("#"+input_id).reset();
            // $(that).removeAttr("onclick");
            // $(that).html("<i class='bi bi-plus'></i>");
               
    }
    
    function delete_row(row)
    {
        $('#'+row).remove();
    }
    
     function delete_additional_req() {
    alert("I am here");
  }
  
</script>
<script>
//By Rohit 
function set_limit() {
    // var ocp_show_hide = document.getElementById("ocp_show_hide");
    var occupation_id_ = document.getElementById("occupation_");
    occupation_id_.style.border = "2px solid green";
//   ocp_show_hide.style.display = "none";
   setTimeout(function() {
    occupation_id_.style.border = "1px solid #ced4da";
}, 5000);
}
///change occupation rohit
      function change_occupation(){
           var ocp_show_hide = document.getElementById("ocp_show_hide");
          var occupation_id = document.getElementById("occupation_");
       custom_alert_popup_show(header = '', 'Are you sure you want to change the occupation?', close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
           $("#AJDSAKAJLD").click(function() {
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $('#cover-spin').show(0);
        
                $.ajax({
                    url: '<?= base_url('admin/application_manager/chef_to_cook/'. $pointer_id) ?>',
                    type: 'POST',
                    data: { occupation_id: occupation_id.value },
                    success: function(data) {
                        re_create_TRA("no_reload");
                       set_limit();
                        check_to_cook_global = occupation_id.value;
                         $('#cover-spin').hide(0);
                         ocp_show_hide.style.display = "none";
                          
                    },
                    error: function(error) {
                        $('#cover-spin').hide(0);
                        console.log(error);
                    }
                });
            } else {
                $('#cover-spin').hide(0);
                return false;
            }
        });

    }
    
//change program rohit
function set_limit_pragram() {
    // var prg_show_hide = document.getElementById("ocp_show_hide_program");
    var program_ = document.getElementById("program_");
    program_.style.border = "2px solid green";
//   prg_show_hide.style.display = "none";
   setTimeout(function() {
    program_.style.border = "1px solid #ced4da";
}, 5000);
}
      function change_program(){
           var prg_show_hide = document.getElementById("ocp_show_hide_program");
          var program = document.getElementById("program_");
       custom_alert_popup_show(header = '', 'Are you sure you want to change the program?', close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
           $("#AJDSAKAJLD").click(function() {
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $('#cover-spin').show(0);
        
                $.ajax({
                    url: '<?= base_url('admin/application_manager/osap_to_tss/'. $pointer_id) ?>',
                    type: 'POST',
                    data: { program: program.value },
                    success: function(data) {
                        re_create_TRA("no_reload");
                        set_limit_pragram(); 
                        osap_to_tss_global = program.value;
                         $('#cover-spin').hide(0);
                         prg_show_hide.style.display = "none";
                          
                    },
                    error: function(error) {
                        $('#cover-spin').hide(0);
                        console.log(error);
                    }
                });
            } else {
                $('#cover-spin').hide(0);
                return false;
            }
        });

    }
//change pathway rohit
//change program 
function set_limit_pathway() {
    // var path_show_hide = document.getElementById("ocp_show_hide_pathway");
    var pathway_ = document.getElementById("pathway_");
    pathway_.style.border = "2px solid green";
//   path_show_hide.style.display = "none";
   setTimeout(function() {
    pathway_.style.border = "1px solid #ced4da";
}, 5000);
}
      function change_pathway(){
          var path_show_hide = document.getElementById("ocp_show_hide_pathway");
          var pathway = document.getElementById("pathway_");
       custom_alert_popup_show(header = '', 'Are you sure you want to change the pathway?', close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
           $("#AJDSAKAJLD").click(function() {
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $('#cover-spin').show(0);
        
                $.ajax({
                    url: '<?= base_url('admin/application_manager/pathway_change/'. $pointer_id) ?>',
                    type: 'POST',
                    data: { pathway: pathway.value },
                    success: function(data) {
                        re_create_TRA("no_reload");
                        set_limit_pathway(); 
                        pathway_global = pathway.value;
                         $('#cover-spin').hide(0);
                          path_show_hide.style.display = "none";
                          
                    },
                    error: function(error) {
                        $('#cover-spin').hide(0);
                        console.log(error);
                    }
                });
            } else {
                $('#cover-spin').hide(0);
                return false;
            }
        });

    }
     


</script>

<?= $this->endSection() ?>
f<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>

<main id="main" class="main">
    <style>
        .flag_button_row {
            /*margin-right: 10px;*/
            /*width: 200px;*/
        }

        /*.flag_button {*/
        /*    padding: 0;*/
        /*    margin: 0;*/
        /* border-radius: 15px; */
        /*}*/

        /*.pull-up {*/
        /*    position: absolute;*/
        /*    margin-top: -48px;*/
        /*    text-align: right;*/
        /*    margin-left: 84%;*/
        /*}*/

        /*.dataTables_length {*/
        /*    margin-top: -48px;*/
        /*}*/
        table {
            table-layout: fixed;
            width: 100% !important;
        }



        .grn_btn {
            width: 70px;
            border-radius: 3px;
            height: 36.96px;
            position: absolute;
            right: 320px;
            /*right: 250px;*/
            top: 7px;
            z-index: 3;
        }


        .red_btn {
            width: 70px;
            height: 36.96px;
            border-radius: 3px;
            position: absolute;
            right: 240px;
            /*right: 250px;*/
            top: 7px;
            z-index: 3;
        }

        .grn_btn:hover {
            background-color: #EBFCDF;
        }

        .red_btn:hover {
            background-color: #FCE8E4;
        }


        /*.active_flag_green{*/
        /*    background-color:#EBFCDF;*/
        /*}*/
        /*.active_flag_red{*/
        /*   background-color:#FCE8E4; */
        /*}*/
        /*.active_flag {*/
        /*    background-image: linear-gradient(#ffde82, #fecc00);*/
        /*}*/

        .flag_img {
            width: 18px;
        }

        .filter_flag {
            height: 40px;
        }
    </style>
    <div class="pagetitle">
        <h4 class="text-green">
            <?= ($org->business_name) ? ($org->business_name) : ($org->name." ".$org->last_name) ?>
        </h4>
        <?php 
        $mobile_data = find_one_row("country","id", $org->mobile_code);
        ?>
        <?php 
        if($org->business_name){
        ?>
        <b class="text-green"><?=$org->name." ".$org->last_name?> - (+<?= $mobile_data->phonecode ." ".$org->mobile_no?>)</b>
        <?php 
        }
        else{
            ?>
        
            <b class="text-green"><?= "(+".$mobile_data->phonecode ." ".$org->mobile_no.")" ?></b>
            
            <?php
        }
        ?>
        <br/>
        <b class="text-green"><?=$org->email ?></b>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body" style="padding: 0px !important;">

                    <div class="table">

                        <!--  Table with stripped rows starts -->

                        <table id="staff_table" class="table table-striped datatable table-hover">
                            <div class="row flag_button_row float-end">
                                <button class="col-md flag_button grn_btn" id="green_flag_btn" type="button" style="border: 1px solid white;"><img id="id_flag_green" class="filter_flag" data-toggle="tooltip" data-placement="top" title="Additional Information Received" src="<?= base_url("public/assets/icon/flag-green.png") ?>"></button>
                                <button class="col-md flag_button red_btn" id="red_flag_btn" data-toggle="tooltip" data-placement="top" title="Additional Information Requested htfdh" type="button" style="border: 1px solid white;"><img id="id_flag_red" class="filter_flag" src="<?= base_url("public/assets/icon/flag-red.png") ?>"></button>
                            </div>
                            <thead>
                                <tr>
                                    <th style="width: 1%;"></th>
                                    <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                        <th style="width: 5%;">
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                                                PRN
                                            </span>
                                        </th>
                                    <?php } ?>
                                    <th style="width: 10%;">Applicant No.</th>
                                    <th style="width: 30%;">Applicant Name </th>
                                    <th style="width: 10%;">D.O.B </th>
                                    <th style="width: 15%;">Occupation</th>
                                    <th style="width: 10%;">Date Submitted</th>
                                    <th style="width: 10%;">Current Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                // echo "<pre>";
                                // print_r($all_list);
                                // echo "</pre>";
                                // exit;

                                // Custom comparison function
                                function compareItemsByCreatedAt($a, $b)
                                {
                                    return strtotime($a['submitted_date']) - strtotime($b['submitted_date']);
                                }

                                // Sort the items array using the custom comparison function
                                usort($all_list, 'compareItemsByCreatedAt');
                                $all_list = array_reverse($all_list);
                                $count = 1;
                                $session = session();

                                foreach ($all_list as $key => $value) {
                                    
                                     // Mohsin Code TF - 14 Jun 2023
                                    if($session->get('admin_account_type') == "head_office" && $value['unique_id'] == "[#T.B.A]" && $value['Current_Status'] == "Closed"){
                                        // echo $value['Current_Status'];
                                        continue;
                                    }
                                    
                                    $Expiry_name = "";
                                    // $approved_date = $value['approved_date'];
                                    $approved_date = isset($value['approved_date']) ? $value['approved_date'] : "";

                                    if (!empty($approved_date) && $approved_date != "0000-00-00 00:00:00" && $approved_date != null) {
                                        $Expired_date =  date('Y-m-d', strtotime('+60 days', strtotime($approved_date)));
                                        $expiry_date_temp = strtotime($Expired_date);
                                        $todays_date = strtotime(date('Y-m-d'));  // sempal
                                        // $todays_date = strtotime('2023-02-16');  // sempal
                                        $timeleft = $todays_date - $expiry_date_temp;
                                        $day_remain = round((($timeleft / 86400)));
                                        if ($day_remain < -30) {
                                            $Expiry_name =  "Expiry";
                                        } else if ($day_remain > -30 && $day_remain  < 0) {
                                            $Expiry_name =  "Expired";
                                        } else if ($day_remain  >= 0) {
                                            $Expiry_name =  "Closed";
                                        }
                                    }

                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $additional_info_request = $value['additional_info_request'];
                                            if ($value['Current_Status'] != "Closed" && $value['Current_Status'] != "Completed")
                                                if ($additional_info_request != "") {
                                                    
                                                    $admin_account_type = $session->get('admin_account_type');
                                                    $flag_show = true;
                                                    if ($admin_account_type == 'head_office' && $value['Current_Status'] == "S2 - Submitted") {
                                                        $flag_show = false;
                                                    }

                                                    if ($flag_show) {

                                            ?>
                                                    <?php if ($additional_info_request->status == "send") { ?>
                                                        <span style="font-size: 0px; position: absolute;">F_red</span>
                                                        <a href="" data-bs-toggle="modal" data-bs-target="#flag_model<?= $count ?>" onclick="__show_modal_box('#flag_model<?= $count ?>')">
                                                            <img class="flag_img" src="<?= base_url("public/assets/icon/flag-red.png") ?>">
                                                        </a>
                                                    <?php  } else if ($additional_info_request->status == "upload") { ?>
                                                        <span style="font-size: 0px;     position: absolute;">F_greeen</span>
                                                        <a href="" data-bs-toggle="modal" data-bs-target="#flag_model<?= $count ?>" onclick="__show_modal_box('#flag_model<?= $count ?>')">
                                                            <img class="flag_img" src="<?= base_url("public/assets/icon/flag-green.png") ?>">
                                                        </a>
                                                    <?php  } else if ($additional_info_request->status == "verified") { ?>
                                                        <!-- verified -->
                                                    <?php } ?>
                                                <?php } ?>
<?php                    $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $additional_info_request->pointer_id);
                                                    $s1 = find_one_row('stage_1', 'pointer_id', $additional_info_request->pointer_id);
                                                    $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $additional_info_request->pointer_id);
                                                    $occupation_list = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);  ?>
                                                <!-- model box for flag -->
                                                <div class="modal" id="flag_model<?= $count ?>">
                                                    <div class="modal-dialog  modal-xl" style="margin-top: 70px">
                                                        <div class="modal-content" style="background-color: white;">
                                                            <div class="modal-header">

                                                                <?php if ($additional_info_request->status == "send") { ?>
                                                                    <h4 class="modal-title text-center text-success"> Additional Information Requested</h4>
                                                                <?php  } else if ($additional_info_request->status == "upload") { ?>
                                                                    <h4 class="modal-title text-center text-success"> Additional Information Received</h4>
                                                                <?php } ?>
                                                      <?php if($additional_info_request->status == "send"){  ?> 
                                                   <a  onclick="delete_additional_req_all(<?=$additional_info_request->pointer_id;?>)" class="btn btn-sm btn-danger ms-auto">
                                                        <b>Delete Requests</b>  </a><?php }?>

                                                            </div>
                                                                                                                            <div class="modal-header">
       <h5 class="modal-title text-center text-green"> <?= "[#" . $s1->unique_id . "] " . $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name . " - " . $occupation_list->name . "" ?></h5>

                                                  </div>
                                                            <div class="modal-body">
                                                                <div class="table">
                                                                    <!--  Table with stripped rows starts -->
                                                                    <table class="table table-striped datatable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="col-lg-1"> Sr.No </th>
                                                                                <th class="col-lg-4"> Comments </th>
                                                                                <th class="col-lg-3"> Document Name</th>
                                                                                <th class="col-lg-2"> Date Requested </th>
                                                                                <th class="col-lg-2"> Date Received </th>
                                                                                <th class="col-lg-1"> Action </th>
                                                                               
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php  
                                                                            
                                                                             if($additional_info_request->stage=='stage_2'){   
                                                                                
                                                                           $assesment_additional = request_asses_doc__alternate_admin($additional_info_request->pointer_id);
                                                                           
                                                                          // print_r($assesment_additional);
                                                                            if($assesment_additional){
                                                                            ?>
                                                                            
                                                                             <tr>
                                                                             <?php $remove_h="remove_heading_".$additional_info_request->pointer_id; ?>
                                                                              <td colspan="6" class="text-success" id="<?=$remove_h?>"><b>Assessment Document</b></td>
                                                                            </tr>
                                                                            <?php
                                                                            }
                                                                            
                                                                             $i=0;
                                                                             $delete_id_for_refer=0;
                                                                                foreach($assesment_additional as $reason){
                                                                                    $i++;
                                                                                    $delete_id_for_refer++;
                                                                                    $tr_id = "delete_tr_".$delete_id_for_refer."_".$reason["id"];
                                                                                    $td_class = "rearrange_td__".$reason["pointer_id"];
                                                                               $assesment_docs= find_one_row('documents', 'id',$reason['document_id']);
                                                                             
                                                                             ?>
                                                                              <tr  id="<?= $tr_id ?>">
                                                                     <td class="<?= $td_class ?>"><?= $i ?></td>
                                                                            <td><?=$reason['reason']?></td>
                                                                             <td>
                                                                            <?php if (isset($assesment_docs->document_name)) : ?>
                                                                                <a href="<?= base_url($assesment_docs->document_path . '/' . $assesment_docs->document_name) ?>" target="_blank">
                                                                                    <?= $assesment_docs->name ?>
                                                                                </a>
                                                                            <?php else : ?>
                                                                                N/A
                                                                            <?php endif; ?>
                                                                        </td>
                                                                            <td><?= isset($reason['create_date']) ? date('d/m/Y', strtotime($reason['create_date'])) : 'N/A' ?></td>
                                                                            <?php if($reason['status'] == "upload"){ ?>
                                                                             <td><?= isset($reason['update_date']) ? date('d/m/Y', strtotime($reason['update_date'])) : 'N/A' ?></td>
                                                                              <?}else{?>
                                                                              <td> N/A</td>
                                                                              <?php }?>
                                                                              <?php if($reason['status'] == "send"){?>
                                                                                <td>
                                                     <a  onclick="delete_additional_req(<?=$reason['id']?>,'#<?= $tr_id ?>','.<?= $td_class ?>','#<?=$remove_h?>',<?=$reason['pointer_id']?>);" class="btn btn-sm btn-danger">
                                                                          <i class="bi bi-x"></i>
                                                                          </a>
                                                                          </td>
                                                                          <?php }else{?>
                                                                   <td>
                                                               <button class="btn btn-sm btn-danger" disabled><i class="bi bi-x"></i></a>
                                                                 </td>
                                                    <?php }?>

                                                                            </tr>
                                                                            <?php }?>
                                                                            
                                                                            <?php  $supportive_evidance = request_supportive_evidance_doc_($additional_info_request->pointer_id);
                                                                            if($supportive_evidance){
                                                                            ?>
                                                                            
                                                                            <!--for supporting evidance-->
                                                                            <tr>
                                                                                 <?php $remove_h="remove_heading_support".$additional_info_request->pointer_id; ?>
                                                                               <td colspan="6" class="text-success" id="<?=$remove_h?>"><b>Supporting Evidance</b></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                            <?php
                                                                            
                                                                             
                                                                             $index=0;
                                                                             $delete_id_for_refer_support=0;
                                                                                foreach($supportive_evidance as $reasons){
                                                                                    $index++;
                                                                               $supportive_evidance_docs= find_one_row('documents', 'id',$reasons['document_id']);
                                                                             
                                                                             $delete_id_for_refer_support++;
                                                                            $tr_id_support  = "delete_tr_".$delete_id_for_refer_support."_".$reasons["id"];
                                                                            $td_class_support = "rearrange_td_".$reasons["pointer_id"];
                                                                            ?>
                                                   
                                                
                                                                                 <tr  id="<?= $tr_id_support ?>">
                                                                                <td class="<?= $td_class_support ?>"><?= $index ?></td>
                                                                            <td><?=$reasons['reason']?></td>
                                                                      <td>
                                                                            <?php if (isset($supportive_evidance_docs->document_name)) : ?>
                                                                                <a href="<?= base_url($supportive_evidance_docs->document_path . '/' . $supportive_evidance_docs->document_name) ?>" target="_blank">
                                                                                    <?= $supportive_evidance_docs->name ?>
                                                                                </a>
                                                                            <?php else : ?>
                                                                                N/A
                                                                            <?php endif; ?>
                                                                        </td>
                                                                            <td><?= isset($reasons['create_date']) ? date('d/m/Y', strtotime($reasons['create_date'])) : 'N/A' ?></td>
                                                                            <?php if($reasons['status'] == "upload"){ ?>
                                                                             <td><?= isset($reasons['update_date']) ? date('d/m/Y', strtotime($reasons['update_date'])) : 'N/A' ?></td>
                                                                              <?}else{?>
                                                                              <td> N/A</td>
                                                                              <?php }?>
                                                                               <?php if($reasons['status'] == "send"){?>
                                                                              <td>
                                                                 <a onclick="delete_additional_req(<?=$reasons['id']?>,'#<?= $tr_id_support ?>','.<?= $td_class_support ?>','#<?=$remove_h?>',<?=$reasons['pointer_id']?>)" class="btn btn-sm btn-danger">
                                                                                  <i class="bi bi-x"></i>
                                                                                  </a>
                                                                                  </td>
                                                                                 <?php }else{?>
                                                                   <td>
                                                               <button class="btn btn-sm btn-danger" disabled><i class="bi bi-x"></i></a>
                                                                 </td>
                                                    <?php }?>
                                                                              
                                                                            </tr>
                                                                            <?php }?>
                                                                            <!--end supportive evidance-->
                                                                            <!--organisation srart-->
                                                                             <?php  
                                                                                 $organisation =organisation_by_pointerid($additional_info_request->pointer_id);
                                                                                  foreach($organisation as $organisation__){
                                                                                       
                                                                                  ?>
                                                                                  <tr>
                                                                                  <?php $remove_h="remove_heading_".$organisation__['id']; ?>
                                                                           <td colspan="6" class="text-success " id="<?=$remove_h?>"><b><?=$organisation__['company_organisation_name']?></b></td>
                                                                                  </tr>
                                                                                  <?php 
                                                                                  
                                                                                  
                                                                                  $suborganisation=getdatafororganisation($organisation__['id']);
                                                                               //   print_r($suborganisation);
                                                                                  $c=0;
                                                                                   $delete_id_for_refer=0;
                                                                                  foreach($suborganisation as $suborganisation__){
                                                                                    
                                                                             $suborganisation__docs= find_one_row('documents', 'id',$suborganisation__['document_id']);
                                                                                      $c++;
                                                                                 $delete_id_for_refer++;
                                                                                $tr_id = "delete_tr_".$delete_id_for_refer."_".$suborganisation__["id"];
                                                                                $td_class = "rearrange_td__".$suborganisation__["pointer_id"].$suborganisation__['s2_add_employment_id'];
                                                                                    ?>
                                                                             <tr data-id="<?=$c?>" id="<?= $tr_id ?>">
                                                                                <td class="<?= $td_class ?>"><?=$c?></td>
                                                                            <td><?=$suborganisation__['reason']?></td>
                                                                         
                                                                              <td>
                                                                                    <?php if (isset($suborganisation__docs->document_name)) : ?>
                                                                                        <a href="<?= base_url($suborganisation__docs->document_path . '/' . $suborganisation__docs->document_name) ?>" target="_blank">
                                                                                            <?= $suborganisation__docs->name ?>
                                                                                        </a>
                                                                                    <?php else : ?>
                                                                                        N/A
                                                                                    <?php endif; ?>
                                                                              </td> 
                                                                             <td><?= isset($suborganisation__['create_date']) ? date('d/m/Y', strtotime ($suborganisation__['create_date'])): 'N/A' ?></td>
                                                                           <?php if($suborganisation__['status'] == "upload"){ ?>
                                                                             <td><?= isset($suborganisation__['update_date']) ? date('d/m/Y', strtotime ($suborganisation__['update_date'])) : 'N/A' ?></td>
                                                                             <?php 
                                                                              }else{?>
                                                                              <td> N/A</td>
                                                                              <?php }?>
                                                                                  <?php if($suborganisation__['status'] == "send"){?>
                                                                             <td>
                                                                                                                     
                                                 <a  onclick="delete_additional_req(<?=$suborganisation__['id']?>,'#<?= $tr_id ?>','.<?= $td_class ?>','#<?=$remove_h?>',<?=$suborganisation__['pointer_id']?>)" class="btn btn-sm btn-danger">
                                                               
                                    
                                                                                      <i class="bi bi-x"></i>
                                                                                      </a>
                                                                                      </td>
                                                                                      <?php }else{?>
                                                                   <td>
                                                               <button class="btn btn-sm btn-danger" disabled><i class="bi bi-x"></i></a>
                                                                 </td>
                                                    <?php }?>
                                                                            </tr>
                                                                                  <?php
                                                                                  } 
                                                                                  }
                                                                            }elseif($additional_info_request->stage=='stage_1' || $additional_info_request->stage=='stage_3'){
                                                                                
                                                                            
                                                                            
                                                                                  ?>
                                                                             <!--end organisation -->
                                                                             
                                                                            
                                                                            <?php
                                                                            //   print_r($additional_info_request);
                                                                             
                                                                            $sr = 1;
                                                                            $delete_id_for_refer = 0;
                                                                          //  $additional_infos = find_multiple_rows('additional_info_request', 'pointer_id', $value['pointer_id']);
                                                                            $additional_infos=getdatafromaddition_stage1_3($value['pointer_id']);
                                                                            //print_r($additional_infos);
                                                                            foreach ($additional_infos as $val) {
                                                                               // print_r($additional_infos);
                                                                            $delete_id_for_refer++;
                                                                                    $tr_id = "delete_tr_".$delete_id_for_refer."_".$val["id"];
                                                                                    $td_class = "rearrange_td__".$val["pointer_id"];
                                                                                ?>
                                                                                 
                                                                                <tr data-record-id="<?=$sr?>" id="<?= $tr_id ?>">
                                                                                        <td class="<?= $td_class ?>"><?= $sr ?></td>
                                                                                    <td>

                                                                                        <?php
                                                                                        $employ_name = "";
                                                                                        if (isset($val->document_id)) {
                                                                                           // print_r($val);
                                                                                            $id = $val->document_id;
                                                                                            $stage = $val->stage;
                                                                                            $employee_id  = isset(find_one_row('documents', 'id', $id)->employee_id) ? find_one_row('documents', 'id', $id)->employee_id : "";
                                                                                            $required_document_id  = isset(find_one_row('documents', 'id', $id)->required_document_id) ? find_one_row('documents', 'id', $id)->required_document_id : "";
                                                                               
                                                                                            if($required_document_id==15||$required_document_id==16 ||$required_document_id==30 ){
                                                                                                  $employ_name = "<b class='text-success'>ASSESMENT DOCUMENTS</b><br>";
                                                                                            }
                                                                                            else if($required_document_id==17){
                                                                                                  $employ_name = "<b class='text-success'>ADDITIONAL INFORMATION</b><br>";
                                                                                            }
                                                                                            else{
                                                                                                if (!empty($employee_id) || $employee_id != 0) {

                                                                                                $company_organisation_name  = isset(find_one_row('stage_2_add_employment', 'id', $employee_id)->company_organisation_name) ? find_one_row('stage_2_add_employment', 'id', $employee_id)->company_organisation_name : "";

                                                                                                if (!empty($company_organisation_name)) {

                                                                                                    $employ_name = "<b class='text-success'>" . $company_organisation_name . "</b><br>";

                                                                                                }


                                                                                                }
                                                                                            }
                                                                                        }

                                                                                        ?>
                                                                                        <?= $employ_name ?> <?= $val['reason'] ?>

                                                                                    </td>
                                                                                    <td><?php
                                                                                        if (isset($val['document_id'])) {
                                                                                            $id = $val['document_id'];
                                                                                            if (isset(find_one_row('documents', 'id', $id)->document_name) || isset(find_one_row('documents', 'id', $id)->document_path)) {
                                                                                             $document_name = find_one_row('documents', 'id', $val['document_id'])->document_name;
                                                                                             $document_path = find_one_row('documents', 'id', $val['document_id'])->document_path;
                                                                                             $name = find_one_row('documents', 'id', $val['document_id'])->name;
                                                                                            
                                                                                                echo  '  <a href="' . base_url($document_path . '/' . $document_name) . '" target="_blank">' . $name . '</a>';
                                                                                            } else {
                                                                                                echo "N/A";
                                                                                            }
                                                                                        } else {
                                                                                            echo "N/A";
                                                                                        } ?></td>
                                                                             <td><?= isset($val['create_date']) ? date('d/m/Y', strtotime ($val['create_date'])): 'N/A' ?></td>
                                                                           <?php if($val['status'] == "upload"){ ?>
                                                                             <td><?= isset($val['update_date']) ? date('d/m/Y', strtotime ($val['update_date'])) : 'N/A' ?></td>
                                                                             <?php 
                                                                              }else{?>
                                                                              <td> N/A</td>
                                                                              <?php }?>
                                                                              <?php if($val['status'] == "send"){?>
                                                                             <td>
                                                                <a onclick="delete_additional_request(<?=$val['id']?>,<?=$sr?>, '#<?= $tr_id ?>','.<?= $td_class ?>',1,<?=$val['pointer_id']?>)" class="btn btn-sm btn-danger">
                                                                                  <i class="bi bi-x"></i>
                                                                                  </a>
                                                                                  </td>
                                                                                  <?php }else{?>
                                                                   <td>
                                                               <button class="btn btn-sm btn-danger" disabled><i class="bi bi-x"></i></a>
                                                                 </td>
                                                    <?php }?>
                                                                                </tr>
                                                                            <?php
                                                                                $sr++;
                                                                            }
                                                                            }else{
                                                                                //echo "stage4";
                                                                                
                                                                            //   print_//r($additional_info_request);
                                                                             
                                                                            $sr = 1;
                                                                            $delete_id_for_refer = 0;
                                                                          //  $additional_infos = find_multiple_rows('additional_info_request', 'pointer_id', $value['pointer_id']);
                                                                            $additional_infos=getdatafromaddition_stage4($value['pointer_id']);
                                                                            //print_r($additional_infos);
                                                                            foreach ($additional_infos as $val) {
                                                                               // print_r($additional_infos);
                                                                            
                                                                                        $delete_id_for_refer++;
                                                                                        $tr_id = "delete_tr_".$delete_id_for_refer."_".$val["id"];
                                                                                        $td_class = "rearrange_td__".$val["pointer_id"];
                                                                                    ?>
                                                                                     
                                                                                    <tr data-record-id="<?=$sr?>" id="<?= $tr_id ?>">
                                                                                            <td class="<?= $td_class ?>"><?= $sr ?></td>
                                                                                    <td>

                                                                                        <?php
                                                                                        $employ_name = "";
                                                                                        if (isset($val->document_id)) {
                                                                                           // print_r($val);
                                                                                            $id = $val->document_id;
                                                                                            $stage = $val->stage;
                                                                                            $employee_id  = isset(find_one_row('documents', 'id', $id)->employee_id) ? find_one_row('documents', 'id', $id)->employee_id : "";
                                                                                            $required_document_id  = isset(find_one_row('documents', 'id', $id)->required_document_id) ? find_one_row('documents', 'id', $id)->required_document_id : "";
                                                                               
                                                                                            if($required_document_id==15||$required_document_id==16 ||$required_document_id==30 ){
                                                                                                  $employ_name = "<b class='text-success'>ASSESMENT DOCUMENTS</b><br>";
                                                                                            }
                                                                                            else if($required_document_id==17){
                                                                                                  $employ_name = "<b class='text-success'>ADDITIONAL INFORMATION</b><br>";
                                                                                            }
                                                                                            else{
                                                                                                if (!empty($employee_id) || $employee_id != 0) {

                                                                                                $company_organisation_name  = isset(find_one_row('stage_2_add_employment', 'id', $employee_id)->company_organisation_name) ? find_one_row('stage_2_add_employment', 'id', $employee_id)->company_organisation_name : "";

                                                                                                if (!empty($company_organisation_name)) {

                                                                                                    $employ_name = "<b class='text-success'>" . $company_organisation_name . "</b><br>";

                                                                                                }


                                                                                                }
                                                                                            }
                                                                                        }

                                                                                        ?>
                                                                                        <?= $employ_name ?> <?= $val['reason'] ?>

                                                                                    </td>
                                                                                    <td><?php
                                                                                        if (isset($val['document_id'])) {
                                                                                            $id = $val['document_id'];
                                                                                            if (isset(find_one_row('documents', 'id', $id)->document_name) || isset(find_one_row('documents', 'id', $id)->document_path)) {
                                                                                             $document_name = find_one_row('documents', 'id', $val['document_id'])->document_name;
                                                                                             $document_path = find_one_row('documents', 'id', $val['document_id'])->document_path;
                                                                                             $name = find_one_row('documents', 'id', $val['document_id'])->name;
                                                                                            
                                                                                                echo  '  <a href="' . base_url($document_path . '/' . $document_name) . '" target="_blank">' . $name . '</a>';
                                                                                            } else {
                                                                                                echo "N/A";
                                                                                            }
                                                                                        } else {
                                                                                            echo "N/A";
                                                                                        } ?></td>
                                                                             <td><?= isset($val['create_date']) ? date('d/m/Y', strtotime ($val['create_date'])): 'N/A' ?></td>
                                                                           <?php if($val['status'] == "upload"){ ?>
                                                                             <td><?= isset($val['update_date']) ? date('d/m/Y', strtotime ($val['update_date'])) : 'N/A' ?></td>
                                                                             <?php 
                                                                              }else{?>
                                                                              <td> N/A</td>
                                                                              <?php }?>
                                                                              <?php if($val['status'] == "send"){?>
                                                                             <td>
                                                         <a  onclick="delete_additional_request(<?=$val['id']?>,<?=$sr?>, '#<?= $tr_id ?>','.<?= $td_class ?>',1,<?=$val['pointer_id']?>)" class="btn btn-sm btn-danger">
                                                                      <i class="bi bi-x"></i>
                                                                      </a>
                                                                      </td>
                                                                      <?php }else{?>
                                                                   <td>
                                                               <button class="btn btn-sm btn-danger" disabled><i class="bi bi-x"></i></a>
                                                                 </td>
                                                    <?php }?>
                                                                                </tr>
                                                                            <?php
                                                                                $sr++;
                                                                            }
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        
                                        
                                        
                                        <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                            <td>
                                                <?= $value['portal_reference_no'] ?>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <?= $value['unique_id'] ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/application_manager/view_application') ?>/<?= $value['pointer_id'] ?>/view_edit" style="color:#009933">
                                                <?= $value['Applicant_name'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?= $value['date_of_birth'] ?>
                                        </td>
                                        <td>
                                            <?= $value['occupation_name'] ?>
                                        </td>
                                        <td>
                                            <?= $value['submitted_date_format'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($value['Current_Status'] == "S1 - Expired") {
                                                if ($Expiry_name ==  "Closed") {
                                                    // if (stage_1_expired_day($value['pointer_id']) < -60) {
                                                    echo "Closed";
                                                } else {
                                                    echo $value['Current_Status'];
                                                }
                                            } else {
                                                echo $value['Current_Status'];
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php $count++;
                                } ?>
                            </tbody>
                        </table>




                        <!-- End Table with stripped rows -->

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
        var table = $('#staff_table').DataTable({
            "aaSorting": [],
            // order: [
            //     [5, 'asc']
            // ],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            },
            scrollX: false
        });
        console.log('staff_table');
        $('.dataTables_filter').addClass('pull-up');

        // document.getElementById("id_flag_red").addEventListener("click", function() {
        //         console.log('F_red');
        //         var red_flag = document.getElementById("red_flag_btn");
        //         if (red_flag.className == "col-md flag_button active_flag_red") {
        //             console.log('remove');
        //             red_flag.classList.remove("active_flag_red");
        //             table.column(0).search('').draw();
        //         } else {
        //             console.log('add');
        //             red_flag.classList.add("active_flag");

        //             var green_flag = document.getElementById("green_flag_btn");
        //             if (green_flag.className == "col-md flag_button active_flag_green") {
        //                 console.log('remove');
        //                 green_flag.classList.remove("active_flag_green");
        //             }
        //             table.column(0).search('F_red').draw();
        //         }
        //     }),
        //     document.getElementById("id_flag_green").addEventListener("click", function() {
        //         console.log('F_greeen');
        //         var green_flag = document.getElementById("green_flag_btn");
        //         var red_flag = document.getElementById("red_flag_btn");
        //         console.log(green_flag.className);
        //         if (green_flag.className == "col-md flag_button active_flag_green") {
        //             console.log('remove');
        //             green_flag.classList.remove("active_flag_green");
        //             table.column(0).search('').draw();
        //         } else {
        //             console.log('add');
        //             green_flag.classList.add("active_flag");
        //             var red_flag = document.getElementById("red_flag_btn");
        //             if (red_flag.className == "col-md flag_button active_flag_red") {
        //                 console.log('remove');
        //                 red_flag.classList.remove("active_flag_red");
        //             }
        //             table.column(0).search('F_greeen').draw();
        //         }

        //     })

        $('#green_flag_btn').click(function() {
            console.log('F_green');
            var green_flag = $('#green_flag_btn');
            var red_flag = $('#red_flag_btn');
            if (green_flag.attr('class') == "col-md flag_button grn_btn active_flag") {
                green_flag.removeClass("active_flag");
                green_flag.css("background-color", "#F0F0F0");
                table.column(0).search('').draw();
            } else {
                green_flag.addClass("active_flag");
                if (red_flag.attr('class') == "col-md flag_button red_btn active_flag") {
                    red_flag.removeClass("active_flag");
                    red_flag.css("background-color", "#F0F0F0");
                }
                red_flag.css("background-color", "#F0F0F0");
                table.column(0).search('F_greeen').draw();
                green_flag.css("background-color", "#EBFCDF");
            }

        });


        $('#red_flag_btn').click(function() {
            console.log('F_red');
            var green_flag = $('#green_flag_btn');
            var red_flag = $('#red_flag_btn');
            if (red_flag.attr('class') == "col-md flag_button red_btn active_flag") {
                red_flag.removeClass("active_flag");
                red_flag.css("background-color", "#F0F0F0");
                table.column(0).search('').draw();

            } else {
                red_flag.addClass("active_flag");
                if (green_flag.attr('class') == "col-md flag_button grn_btn active_flag") {
                    green_flag.removeClass("active_flag");
                    green_flag.css("background-color", "#F0F0F0");
                }
                table.column(0).search('F_red').draw();
                green_flag.css("background-color", "#F0F0F0");
                red_flag.css("background-color", "#FCE8E4");
            }

        });
    });
    $(document).ready(function() {
        $('#flag_table').DataTable({
            "aaSorting": []
        });

    });
   function delete_additional_req(id,selector, sequences,remove_id,pointer_id) {
                 //alert(pointer_id);

        custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to Cancel Request?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        $("#AJDSAKAJLD").click(function() {
            if (custom_alert_popup_close('AJDSAKAJLD')) {
               // $('#cover-spin').show(0);
                $.ajax({
                    method: "POST",
                 url: "<?= base_url('admin/application_manager/delete_request_new') ?>/" + id,
                     data: {
                         id: id,
                         pointer_id:pointer_id,
                    },
                    success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response["status"] == 1){
                        $(selector).remove();
                       arrangeSequence(sequences,remove_id);
                    }
                    if(response["reload"] == 1){
                    window.location.reload();
                    }
                },
                error: function () {
                    alert('Error in the Ajax request.');
                }
                });
            }
        });
    }
    
  
    function delete_additional_request(id, sr, selector, sequences,remove_id,pointer_id) {
        //alert(pointer_id);
                        // $(selector).remove();
                        // arrangeSequence(sequences);
                        // arrangeSequence(sequences,remove);
                        // return;
    custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to Cancel Request?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
    $("#AJDSAKAJLD").click(function() {
        if (custom_alert_popup_close('AJDSAKAJLD')) {
            // $('#cover-spin').show(0);
            $.ajax({
                method: "POST",
                url: "<?= base_url('admin/application_manager/delete_request_new') ?>/" + id,
                data: {
                    id: id,
                    pointer_id:pointer_id,
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response["status"] == 1){
                        $(selector).remove();
                        arrangeSequence(sequences,remove_id);
                    }
                    if(response["reload"] == 1){
                    window.location.reload();
                    }
                },
                error: function () {
                    alert('Error in the Ajax request.');
                }
            });
        }
    });
}

function arrangeSequence(sequences,remove_id){
    var tds = $(sequences);
    
if(tds.length === 0){
    $(remove_id).remove();
    //alert("here");
}
    
    // console.log(tds);
    // console.log("Selected elements:", tds);
    var count = 0;
    $(tds).each((td, value) => {
        count++;
        // console.log(value);
       $(value).text(count); 
    //   console.log("chal raha h");
    });
    
}

function delete_additional_req_all(deleteid){
    
   custom_alert_popup_show(header = '', body_msg = "Are you sure, you want to Cancel All Request?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
    $("#AJDSAKAJLD").click(function() {
        if (custom_alert_popup_close('AJDSAKAJLD')) {
            // $('#cover-spin').show(0);
            $.ajax({
                method: "POST",
                url: "<?= base_url('admin/application_manager/delete_additional_req_all') ?>/" + deleteid,
                data: {
                    id: deleteid,
                },
                success: function (response) {
                    
                    response = JSON.parse(response);
                    window.location.reload();
                },
                error: function () {
                    alert('Error in the Ajax request.');
                }
            });
        }
    }); 
    
}

function __show_modal_box(modal_id){
    $(modal_id).modal('show')
}
</script>

<?= $this->endSection() ?>
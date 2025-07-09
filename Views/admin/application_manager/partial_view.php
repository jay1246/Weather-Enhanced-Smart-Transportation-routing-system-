<style>
    .pagination {
    /* Style the container */
    padding: 10px;
    background-color: #ffffff;
    border-radius: 5px;
    justify-content: center;  /* Center the pagination items */
}
.pagination li {
    margin: 0 3px;  /* Add spacing between pagination items */
}

.pagination a {
    color: #212529;
    text-decoration: none !important;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;  /* Smooth transition for hover effects */
}

.pagination a:hover {
    /*background-color: #212529;*/
    /*color: #ffffff;*/
    
    
    background-color: #EFEFEF;
    color: black;
}


/* Active */
.pagination li.active a {
    /*background-color: #212529;*/
    /*color: #ffffff;*/
    
    
    background-color: #EFEFEF;
    color: black;
    border: none;
    pointer-events: none;  /* Disable click events on the active item */
}

.pagination li.disabled a {
    color: #cccccc;
    pointer-events: none;
    cursor: not-allowed;
}
/* find_one_row */

.main_bottom_pagination{
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    justify-items: center;
}
.sub_bottom_pagination{
    padding-top: 05px;
}
.flag_img {
    width: 18px;
}
</style>
<table class="table table-striped datatable table-hover dataTable no-footer" id="table">
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
            <th style="width: 5%;">P1/2</th>
            <th style="width: 10%;">Date Submitted</th>
            <th style="width: 10%;">Current Status</th>
            <?php 
            if (session()->get('admin_account_type') == 'admin'){
            ?>
            <th>
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Team Member">
                    TM
                </span>
            </th>
            <?php } ?>
            <!-- Add more columns headers as needed -->
        </tr>
    </thead>
    <tbody id="pagination__table__body">
        <?php 
        $count = 0;
        $session = session();
        if(count($data) == 0){
            ?>
            <tr>
                <td colspan="10" class="text-center">No Data Found</td>
            </tr>
            <?php
        }
        $flag___ = 0;
        foreach ($data as $item): ?>
            <?php 
            
            $s1_occupation_above = find_one_row('stage_1_occupation', 'pointer_id', $item->id);
            // print_r($value);
            // exit;
            $pathway_text = ($s1_occupation_above->pathway == "Pathway 1") ? "P1" : "P2"; 

            $count++;
            $unique_id = ($item->unique_id) ? "[#".$item->unique_id."]" : "[#T.B.A]";
            $full_name = (($item->first_or_given_name) ? $item->first_or_given_name : "")." ".(($item->middle_names) ? $item->middle_names : "")." ".(($item->surname_family_name) ? $item->surname_family_name : "");   
            
            $stage_index = application_stage_no($item->id);
            
            $current_status = create_status_rename(create_status_format($stage_index),$item->id);
            
            $additional_info_request = find_one_row_2_field_for_flag_pagination('additional_info_request', 'pointer_id', $item->id,'stage', $item->stage);

            
            $admin_account_type = $session->get('admin_account_type');

            if($search_flag){
                if($search_flag != $additional_info_request->status){
                    $flag___++;
                    continue;
                }
            }
            ?>
            <tr>
            
            <td>
                <?php
                    // print_r($additional_info_request);
                    if ($current_status != "Closed" && $current_status != "Completed")
                    if ($additional_info_request != "") {
                        
                        $flag_show = true;
                        if ($admin_account_type == 'head_office' && $current_status == "S2 - Submitted") {
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
                                    <!-- echo  -->
                                    <?php 
                                    // print_r($additional_info_request); 
                                    if ($additional_info_request->status == "send") { ?>
                                        <h4 class="modal-title text-center text-success"> Additional Information Requested</h4>
                                    <?php  } else if ($additional_info_request->status == "upload") { ?>
                                        <h4 class="modal-title text-center text-success"> Additional Information Received</h4>
                                    <?php } ?>
                                    
                                    <?php if($additional_info_request->status == "send"){
                                
                                    ?> 
                                    
                               <a  onclick="delete_additional_req_all(<?=$additional_info_request->pointer_id;?>)" class="btn btn-sm btn-danger ms-auto">
                                    <b>Delete Requests</b>
                                                  </a>
<?php }?>
                                   

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
                                                    <th class="col-lg-2"> Date Received  </th>
                                                    <th class="col-lg-2"> Action </th>
                                                    
                                                    

                                               </tr>
                                             
                                            </thead>
                                            <tbody>
                                            
                                        <tr>
      
                          </tr>   
                                                

                                                <?php  

                                                    if($additional_info_request->stage=='stage_2'){   
                                                    
                                                $assesment_additional = request_asses_doc__alternate_admin($additional_info_request->pointer_id);
                                                
                                            // print_r($assesment_additional);
                                                if($assesment_additional){
                                                   
                                                ?>
                                                
                                                    <tr>
                                                    <?php $remove_h="remove_heading_".$additional_info_request->pointer_id; ?>
                                                <td colspan="5" class="text-success" id="<?=$remove_h?>"><b>Assessment Document</b></td>
                                                </tr>
                                                <?php
                                                }
                                                
                                                    $i=0;
                                                    $delete_id_for_refer=0;
                                                    foreach($assesment_additional as $reason){
                                                        $i++;
                                                    $assesment_docs= find_one_row('documents', 'id',$reason['document_id']);
                                                     $delete_id_for_refer++;
                                                    $tr_id = "delete_tr_".$delete_id_for_refer."_".$reason["id"];
                                                    $td_class = "rearrange_td__".$reason["pointer_id"];
                                                 
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
                                                        $i=0;
                                                        foreach($organisation as $organisation__){
                                                            //print_r($organisation__);
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
                                                        $i++;
                                                        } 
                                                        }
                                                }elseif($additional_info_request->stage=='stage_1' || $additional_info_request->stage=='stage_3'){
                                                    
                                                
                                                
                                                        ?>
                                                    <!--end organisation -->
                                                    
                                                
                                                <?php
                                                //   print_r($additional_info_request);
                                                    
                                                $sr = 1;
                                                 $delete_id_for_refer = 0;
                                                //  $additional_infos = find_multiple_rows('additional_info_request', 'pointer_id', $item->id);
                                                $additional_infos=getdatafromaddition_stage1_3($item->id);
                                                //print_r($additional_infos);
                                                foreach ($additional_infos as $val) {
                                                    $delete_id_for_refer++;
                                                    $tr_id = "delete_tr_".$delete_id_for_refer."_".$val["id"];
                                                    $td_class = "rearrange_td__".$val["pointer_id"];
                                                    // print_r($additional_infos);
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
                                                //  $additional_infos = find_multiple_rows('additional_info_request', 'pointer_id', $item->id);
                                                $additional_infos=getdatafromaddition_stage4($item->id);
                                                //print_r($additional_infos);
                                                foreach ($additional_infos as $val) {
                                                    
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
                                                                        $employ_name = "<b class='text-success '>ASSESMENT DOCUMENTS</b><br>";
                                                                }
                                                                else if($required_document_id==17){
                                                                        $employ_name = "<b class='text-success '>ADDITIONAL INFORMATION</b><br>";
                                                                }
                                                                else{
                                                                    if (!empty($employee_id) || $employee_id != 0) {

                                                                    $company_organisation_name  = isset(find_one_row('stage_2_add_employment', 'id', $employee_id)->company_organisation_name) ? find_one_row('stage_2_add_employment', 'id', $employee_id)->company_organisation_name : "";

                                                                    if (!empty($company_organisation_name)) {

                                                                        $employ_name = "<b class='text-success '>" . $company_organisation_name . "</b><br>";

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
                                                    <?php if($val['status'] == "send"){
                                                    ?>
                                                                             <td>
                                                         <a  onclick="delete_additional_request(<?=$val['id']?>,<?=$sr?>, '#<?= $tr_id ?>','.<?= $td_class ?>',1,<?=$val['pointer_id']?>)" class="btn btn-sm btn-danger">
                                                          <i class="bi bi-x"></i>
                                                          </a>
                                                          </td>
                                                          <?php }else{?>
                                                                     <td>
                                                               <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></a>
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
                    <td><?= $item->application_number ?></td>
                <?php } ?>
                <td>
                    <?php 
                        $is_Show = getTheCurrentMessageStatusThere($item->id);
                        if($is_Show){
                    ?>
                    <a onclick="__openTheAlertMessage(<?= $item->id ?>)" class="onhover_pointer" style="color: #009933;">
                        
                        <?= $unique_id ?>
                    </a>
                    <?php }
                    else{
                        ?>
                        <?= $unique_id ?>
                        <?php
                    }?>
                </td>
                <td><a href="<?= base_url()."/admin/application_manager/view_application/".$item->id."/view_edit" ?>" style="color: #009933;"><?= $full_name ?></a></td>
                <td><?= $item->date_of_birth ?></td>
                <td><?= $item->name ?></td>
                <td><?= $pathway_text ?></td>
                <td><?= date("d/m/Y", strtotime($item->submitted_date)) ?></td>
                <td>
            <?php
            // echo $current_status;
            if($item->stage == "stage_1"){
                $Expiry_name = "";
                    if (!empty($item->approved_date) && $item->approved_date != "0000-00-00 00:00:00" && $item->approved_date != null) {
                        // $Expired_date =  ($item->closure_date == "0000-00-00 00:00:00") ? $item->expiry_date : $item->closure_date;
                        $Expired_date = $item->expiry_date;
                        
                        //date('Y-m-d', strtotime('+60 days', strtotime($item->approved_date)));
                        $expiry_date_temp = strtotime($Expired_date);
                        $todays_date = strtotime(date('Y-m-d'));  // sempal
                        // $todays_date = strtotime('2023-02-16');  // sempal
                        $timeleft = $todays_date - $expiry_date_temp;
                        $day_remain = round((($timeleft / 86400)));
                        // echo $day_remain."Mohsin";
                        if ($day_remain < 0) {
                            $Expiry_name =  "Expiry";
                        } else if ($day_remain <= 30 && $day_remain  < 0) {
                            $Expiry_name =  "Expired";
                        } else if ($day_remain  >= 30) {
                            $Expiry_name =  "Closed";
                        }
                    }
                    
                    if(empty($item->closure_date) || $item->closure_date == "0000-00-00 00:00:00"){
                        if ($current_status == "S1 - Expired") {
                            if ($Expiry_name ==  "Closed") {
                                // if (stage_1_expired_day($value['pointer_id']) < -60) {
                                echo "Closed";
                            } else {
                                echo $current_status;
                            }
                        } else {
                            echo $current_status;
                        }
                    }
                    else{
                        
                        $date1 = new DateTime(date('Y-m-d', strtotime('0 days', strtotime($item->closure_date))));
                        $date2 = new DateTime(date('Y-m-d'));
                        $interval = $date1->diff($date2);
                        // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                        $day_remain_expiry_checker = $interval->days;
                        if ($date2 > $date1) {
                            // If $date2 is greater than $date1, make $day_remain_ negative
                            $day_remain_expiry_checker = -$day_remain_expiry_checker;
                        }
                        // echo $day_remain;
                        if ($day_remain_expiry_checker < 0) {
                            
                            echo "Closed";
                        }
                        else{
                            // echo "ds";
                            // echo "Closed";
                            echo $current_status;
                            
                        }
                        // echo $day_remain;
                    }
            }
            else{
                echo $current_status;
            }
                ?>
            
            </td>
            <?php 
            if (session()->get('admin_account_type') == 'admin'){
            ?>
                <td>
                    <!-- Inital Names -->
                    <?php
                    echo getTheTeamMemberNameTBA($item->team_member);
                    ?>
                    <!---->
                </td>
                <?php 
            }
                ?>
                <!-- Add more columns data as needed -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="main_bottom_pagination">
    <div class="sub_bottom_pagination">
        <?php 
        $totalRows = $totalRows - $flag___;
        $itemsPerPage = $itemsPerPage - $flag___;
        
        if($itemsPerPage == 0){
            $currentPage = 0;
        }
        ?>
        <span>Showing <?= $currentPage ?> to <?= $itemsPerPage ?> of <?= number_format($totalRows) ?> entries</span>
    </div>
    <?= $pager->links() ?>
</div>

<!---->

<?php 
include "comment_popup_box_logic.php";
?>

<script>
    
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

<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>


<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Application Details </b>
</div>


<style>
    .arrow {
        border-radius: 0px !important;
        clip-path: polygon(93% 0, 100% 50%, 93% 100%, 0% 100%, 6% 50%, 0% 0%);
    }

    a.active {
        background-color: var(--yellow) !important;
        color: var(--green) !important;
    }

    .active {
        border: 1px solid var(--yellow) !important;

    }

    .staper_btn {
        max-width: 100%;
    }
</style>


<!-- start body  -->
<div class="container-fluid mt-4 mb-4 p-4 bg-white shadow">
    <!-- Application Details  -->
    <div class="row">
        <div class="col-sm-6">


            <table class="table">
                <tr>
                    <td>
                        <b> Portal Reference No. </b>
                    </td>
                    <td>
                        <?= $portal_reference_no ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Application No. </b>
                    </td>
                    <td>
                        <?= $Unique_number ?>
                    </td>
                </tr>



                <tr>
                    <td>
                        <b> Applicant's Name </b>
                    </td>
                    <td>
                        <?= $Application_Details['name'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Occupation </b>
                    </td>
                    <td>
                        <?= $Application_Details['occupation'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Pathway </b>
                    </td>
                    <td>
                        <?= $Application_Details['pathway'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b> Program </b>
                    </td>
                    <td>
                        <?= $Application_Details['program'] ?>
                    </td>
                </tr>

                <tr>
                    <!-- <th style="width:50%;">Date Completed</th> -->
                    <th style="width:50%;"> Date Submitted </th>
                    <td> <?= (isset($stage_1["submitted_date"])) ?  date("d/m/Y", strtotime($stage_1['submitted_date'])) : "" ?>
                    </td>
                </tr>

                <?php 
                    // print_r($stage_3_R);
                if($Application_Details['pathway'] == 'Pathway 1' && ($occupation_id == 7 || $occupation_id== 18)){
                    // echo $occupation_id;
                    // if(){
                    // echo "sffsvSF";
                    if (isset($stage_4["status"]) && $stage_4["status"] == "Approved") { ?>
                        <tr>
                            <th style="width:50%;"> Date Approved </th>
    
                            <td> <?=(isset($stage_4["approved_date"])) ? date("d/m/Y", strtotime($stage_4["approved_date"]))  : "" ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (isset($stage_4["status"]) && $stage_4["status"] == "Declined") { ?>
                        <tr>
                            <th style="width:50%;"> Date Declined </th>
    
                            <td> <?= (isset($stage_4["declined_date"])) ? date("d/m/Y", strtotime($stage_4["declined_date"]))  : "" ?>
                            </td>
                        </tr>
                    <?php }  ?>
        
                        <tr>
                            <th style="width:50%;">Status</th>
                            <td><b> <?php
                                    if(isset($stage_4["status"])){
                                        if($stage_4['status'] == "Declined"){
                                            echo "Unsuccessful";
                                        }else{
                                        echo $stage_4['status'];
                                        }
                                    } ?>
                                </b> </td>
                        </tr>
                    <?php
                    // }
                }else{
                    // echo "condition_2";
                    // print_r($stage_3_R);
                        if (isset($stage_3["status"]) && $stage_3["status"] == "Approved") { ?>
                            <tr>
                                <th style="width:50%;"> Date Approved </th>
        
                                <td> <?= (isset($stage_3["approved_date"])) ? date("d/m/Y", strtotime($stage_3["approved_date"]))  : "" ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (isset($stage_3["status"]) && $stage_3["status"] == "Declined") { ?>
                            <tr>
                                <th style="width:50%;"> Date Declined </th>
        
                                <td> <?= (isset($stage_3["declined_date"])) ? date("d/m/Y", strtotime($stage_3["declined_date"]))  : "" ?>
                                </td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <th style="width:50%;">Status</th>
                            <td><b> <?php
                                if(isset($stage_3["status"])){
                                    if($stage_3['status'] == "Declined"){
                                        echo "Unsuccessful";
                                    }else{
                                    echo $stage_3['status'];
                                    }
                                } ?></b> </td>
                        </tr>
                    <?php
                    
                 }?>

                </tbody>
            </table>

            <!-- show Approved admin 2 file  -->
            <?php
            if($Application_Details['pathway'] == 'Pathway 1' && ($occupation_id == 7 || $occupation_id== 18)){ ?>
                <div class="row mt-2 mb-2" style="line-height: 3;">
                        <div class="col-sm-6 mt-2">
                            <a href="<?= $TRA_Application_Form_url ?>" class="btn btn_green_yellow w-100" download> Download Submitted Application <i class="bi bi-download"></i> </a>
                        </div>
                        <?php if (isset($stage_4["status"]) && $stage_4["status"] == "Approved") { ?>
                        <?php foreach ($documents as $key => $value) {
                            if ($value['stage'] == "stage_4") {   
                                
                                // <!-- Upload ots	 -->
                                // echo $value['required_document_id'];
                                // echo "fdhdhg";
                                if ($value['required_document_id'] == 48) {   
                                    //   echo $value['id'];
                                    //   echo "</br>" ;
                               ?>
                                    <div class="col-sm-6 mt-2">
                                        <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                    </div>
                                <?php } 
                                 if ($value['required_document_id'] == 47) {   
                                  ?>
                                    <div class="col-sm-6 mt-2">
                                        <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php }
                        } ?>
                    
                <?php 
                if (isset($stage_4["status"]) && $stage_4["status"] == "Declined") { ?>
                    <!-- show document for pathway 1 only  -->
                    <!--<div class="row mt-2 mb-2">-->
                        <?php foreach ($documents as $key => $value) {
                            if ($value['stage'] == "stage_4") {  
                                // <!-- Outcome Letter -->
                                if ($value['required_document_id'] == 45) {  ?>
                                    <div class="col-sm-6">
                                        <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                    </div>
                                <?php } 
                                //  Statement of Reasons 
                                 if ($value['required_document_id'] == 46) { ?>
                                    <div class="col-sm-6">
                                        <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                    </div>
                                <?php } 
                            }
                        }?>
                    
                <?php }
                ?>
                </div>
                <?php
            }else{
                if(isset($stage_3_R)){
                        if (isset($stage_3["status"]) && $stage_3["status"] == "Declined") { ?>
                        <!-- show document for pathway 1 only  -->
                        <div class="row mt-2 mb-2">
                            <?php foreach ($documents as $key => $value) {
                                if ($value['stage'] == "stage_3") {   ?>
                                    <!-- Outcome Letter -->
                                    <?php if ($value['required_document_id'] == 23) {  ?>
                                        <div class="col-sm-6">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                    <!-- Statement of Reasons -->
                                    <?php if ($value['required_document_id'] == 24) { ?>
                                        <div class="col-sm-6">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php
                        }
                        // need to remove
                    
                }else{
                    if (isset($stage_3["status"]) && $stage_3["status"] == "Approved") { ?>
                        <div class="row mt-2 mb-2"style="line-height: 3;">
                            <div class="col-sm-6 mt-2">
                                <a href="<?= $TRA_Application_Form_url ?> " class="btn btn_green_yellow w-100" download> Download Submitted Application <i class="bi bi-download"></i> </a>
                            </div>
                            <?php foreach ($documents as $key => $value) {
                                if ($value['stage'] == "stage_3") {   ?>
                                    <!-- Upload Qualifications for pathway 1 only -->
                                    <?php if (isset($Application_Details['pathway']) && $Application_Details['pathway'] == "Pathway 1") {  ?>
                                        <?php if ($value['required_document_id'] == 26) {   ?>
                                            <div class="col-sm-6 mt-2">
                                                <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <!-- Upload Outcome Letter	 -->
                                    <?php if ($value['required_document_id'] == 25) {   ?>
                                        <div class="col-sm-6 mt-2">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
        
                    <!-- show Declined admin 2 file  -->
                    <?php if (isset($stage_3["status"]) && $stage_3["status"] == "Declined") { ?>
                        <!-- show document for pathway 1 only  -->
                        <div class="row mt-2 mb-2">
                            <?php foreach ($documents as $key => $value) {
                                if ($value['stage'] == "stage_3") {   ?>
                                    <!-- Outcome Letter -->
                                    <?php if ($value['required_document_id'] == 23) {  ?>
                                        <div class="col-sm-6">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                    <!-- Statement of Reasons -->
                                    <?php if ($value['required_document_id'] == 24) { ?>
                                        <div class="col-sm-6">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php
                            $pointer_id = pointer_id_decrypt($ENC_pointer_id);
                            $reassessment_data = check_stage_user_side('stage_3_reassessment',$pointer_id);
                        if(empty($reassessment_data)){
                        ?>
                            <div class="row mt-2 mb-2">
                            <hr>
                                <div class="col-sm-12">
                                    <?php
                                    $disabled = ""; 
                                    $onclick = "onclick='reassessment_stage_3()'";
                                    if($application_pointer->is_doc_deleted == 1){
                                        $disabled = "disabled";
                                        $onclick = "";
                                    }
                                    ?>
                                    <a class="<?= $disabled ?> btn btn_yellow_green w-100" id="button_for_apply" <?= $onclick ?>> Apply for Reassessment </a>
                                </div>
                            </div>
                        <?php 
                        }
                    }
                }
            }
            ?>
            <?php if(isset($stage_3_R) && isset($stage_3_R["status"]) && ($stage_3_R["status"] == "Approved" || $stage_3_R["status"] == "Declined")){
                if(empty($stage_4)){
                ?>
            <table class="table">
                <tr class="col-12 ">
                    <td colspan="2"style="background-color:#FFCC01;margin-bottom:0;"class="text-success text-center border rounded-3 my-2">
                       <b style="font-size:large;">Reassessment - Stage 3</b>
                    </td>
                    
                </tr>
                             <tr>
                                <th style="width:50%;">Date Submitted </th>
        
                                <td> <?= (isset($stage_3_R["submitted_date"])) ? date("d/m/Y", strtotime($stage_3_R["submitted_date"]))  : "" ?>
                                </td>
                            </tr>
                    <?php 
                        if (isset($stage_3_R["status"]) && $stage_3_R["status"] == "Approved") { ?>
                            <tr>
                                <th style="width:50%;"> Date Approved </th>
        
                                <td> <?= (isset($stage_3_R["approved_date"])) ? date("d/m/Y", strtotime($stage_3_R["approved_date"]))  : "" ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (isset($stage_3_R["status"]) && $stage_3_R["status"] == "Declined") { ?>
                            <tr>
                                <td style="width:50%;font-weight:bold;"> Date Declined </td>
        
                                <td> <?= (isset($stage_3_R["declined_date"])) ? date("d/m/Y", strtotime($stage_3_R["declined_date"]))  : "" ?>
                                </td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Status</td>
                            <td><b> <?php
                                if(isset($stage_3_R["status"])){
                                    if($stage_3_R['status'] == "Declined"){
                                        echo "Unsuccessful";
                                    }else{
                                    echo $stage_3_R['status'];
                                    }
                                } ?></b> </td>
                        </tr>
                
                </tbody>
            </table>
            <?php 
                    if (isset($stage_3_R["status"]) && $stage_3_R["status"] == "Approved") { ?>
                        <div class="row mt-2 mb-2"style="line-height: 3;">
                            <div class="col-sm-6 mt-2">
                                <a href="<?= $TRA_Application_Form_url ?> " class="btn btn_green_yellow w-100" download> Download Submitted Application <i class="bi bi-download"></i> </a>
                            </div>
                            <?php foreach ($documents as $key => $value) {
                                if ($value['stage'] == "stage_3_R") {   ?>
                                    <!-- Upload Qualifications for pathway 1 only -->
                                    <?php if (isset($Application_Details['pathway']) && $Application_Details['pathway'] == "Pathway 1") {  ?>
                                        <?php if ($value['required_document_id'] == 26) {   ?>
                                            <div class="col-sm-6 mt-2">
                                                <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <!-- Upload Outcome Letter	 -->
                                    <?php if ($value['required_document_id'] == 25) {   ?>
                                        <div class="col-sm-6 mt-2">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
        
                    <!-- show Declined admin 2 file  -->
                    <?php if (isset($stage_3_R["status"]) && $stage_3_R["status"] == "Declined") { ?>
                        <!-- show document for pathway 1 only  -->
                        <div class="row mt-2 mb-2">
                            <?php foreach ($documents as $key => $value) {
                                if ($value['stage'] == "stage_3_R") {   ?>
                                    <!-- Outcome Letter -->
                                    <?php if ($value['required_document_id'] == 23) {  ?>
                                        <div class="col-sm-6">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download>Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                    <!-- Statement of Reasons -->
                                    <?php if ($value['required_document_id'] == 24) { ?>
                                        <div class="col-sm-6">
                                            <a href=" <?= base_url($value['document_path'] . "/" . $value['document_name']) ?>" class="btn btn_green_yellow w-100" download> Download <?= $value['name'] ?> <i class="bi bi-download "></i></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        
        <!-- Submitted  -->
        <?php if (isset($stage_1['status']) && !empty($stage_1['status'])) {
            if (!empty($stage_1['submitted_date']) || $stage_1['submitted_date'] != "0000-00-00 00:00:00" || $stage_1['submitted_date'] != null) {
                //  echo date("d/m/Y", strtotime($stage_1['submitted_date']));
            }
        } ?>

        <!-- stage 1 documents  -->
        <div class="col-sm-6">

            <div class="text-center">

                <!-- // image  -->
                <?php
                $check = false;
                foreach ($documents as $key => $value) {
                    if ($value['stage'] == "stage_1") {
                        if ($value['required_document_id'] == 1) {
                            $check = true;
                            // print_r($value);

                ?>
                            <img src="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" width="170px" height="170px" class="shadow">

                <?php
                            break;
                        } // required_document_id
                    } // stage
                } // forech 
                ?>
                <?php if (!$check) { ?>
                    <img src="https://cdn-icons-png.flaticon.com/512/180/180658.png" width="170px" height="170px" class="shadow">
                <?php } ?>
                <!-- // image  -->

            </div>

            <br>
            <br>
            <br>


            <div class="accordion" id="accordionExample">

                <!-- stage 1 docs  -->
                <div>
                    <!-- comman container for 1 item  -->
                    <div class="accordion-item">
                        <!-- Clickebal Button  -->
                        <h2 class="accordion-header" id="s1_tital_div">
                            <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s1_tital_body_div" aria-expanded="false" aria-controls="s1_tital_body_div">
                                <h5 class="text-green p-2"><b>Stage 1 - Submitted Documents </b></h5>
                            </button>
                        </h2>
                        <!-- collapseabal Div show all data / collapse Body  -->
                        <div id="s1_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s1_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                            <div class="card-body">
                                <table class="table p-2">
                                    <thead>
                                        <tr>
                                            <th> Sr.No. </th>
                                            <th> Document Name </th>
                                            <!-- <td> Document </td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($documents as $key => $value) {
                                            if ($value['stage'] == "stage_1") {
                                                if ($value['required_document_id'] > 0 && $value['required_document_id'] != 21 && $value['required_document_id'] != 50) {
                                                    $i++;
                                                    $required_document_id = $value['required_document_id'];
                                                    

                                                    $main_validator = check_file_closed($application_pointer, $value);

                                                    $full_url = $main_validator["full_url"];
                                                    $full_url_target = $main_validator["full_url_target"];
                                        ?>
                                                    <tr>
                                                        <td> <?= $i; ?> </td>
                                                        <td>
                                                            <a href="<?= $full_url  ?>" <?php echo $full_url_target  ?>>
                                                                <?= $value['name']; ?>
                                                            </a>
                                                        </td>
                                                        <!-- <td> <img src="<?= base_url($value['document_path'] . '/' . $value['document_name']) ?>" width="150px"> </td> -->
                                                    </tr>
                                        <?php
                                                } // required_document_id
                                            } // stage
                                        } // forech 
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- stage 2 docs  -->
                <div>
                    <?php
                    // check stage 2 documant availebal to show 
                    $show_stage_2_documents = false;
                    foreach ($documents as $key => $value) {
                        if ($value['stage'] == "stage_2") {
                            if ($value['required_document_id'] > 0) {
                                $show_stage_2_documents = true;
                            }
                        }
                    }
                    // create employee name list for filter 
                    $total_employee = array();
                    $i = 0;
                    foreach ($documents as $key => $value) {
                        if ($value['stage'] == "stage_2") {
                            if ($value['required_document_id'] > 0) {
                                $i++;
                                $required_document_id = $value['required_document_id'];
                                $employee_id = $value['employee_id'];
                                $employment_info = stage_2_employment_info($employee_id);
                                if (!empty($employment_info)) {
                                    $data = [
                                        "id" => $employment_info['id'],
                                        "company_organisation_name" => $employment_info['company_organisation_name'],
                                    ];
                                    if (!in_array($data, $total_employee)) {
                                        $total_employee[] = $data;
                                    }
                                }
                            }
                        }
                    }
                    ?>

                    <!-- show stage 2 document -->
                    <?php if ($show_stage_2_documents) {  ?>
                        <div class="accordion-item">
                            <!-- Clickebal Button  -->
                            <h2 class="accordion-header" id="s2_tital_div">
                                <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s2_tital_body_div" aria-expanded="false" aria-controls="s2_tital_body_div">
                                    <h5 class="text-green p-2"><b>Stage 2 - Submitted Documents </b></h5>
                                </button>
                            </h2>
                            <!-- collapseabal Div show all data / collapse Body  -->
                            <div id="s2_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s2_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                                    <div class="card-body">
                                        <table class="table p-2">
                                            <thead>
                                                <tr>
                                                    <th> Sr.No. </th>
                                                    <th> Document Name </th>
                                                    <!-- <td> Document </td> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        // Compony or employ  documents 
                                                        foreach ($total_employee as $key => $val) {
                                                            echo "<tr class='bg-light p-2'><td  colspan='2'>" . $val['company_organisation_name'] . "</td><tr>";
                                                            $i = 0;
                                                            foreach ($documents as $key => $value) {
                                                                if ($value['stage'] == "stage_2") {
                                                                    
                                                                    if ($value['required_document_id'] > 0) {
                                                                        $required_document_id = $value['required_document_id'];
                                                                        $employee_id = $value['employee_id'];
                                                                        if ($val['id'] == $employee_id) {
                                                                            $show_f = true;
                                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                            if (!empty($documnet_request)) {
                                                                                if (isset($documnet_request->status)) {
                                                                                    if ($documnet_request->status == "send") {
                                                                                        $show_f = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($show_f){
                                                            
                                                                                $i++;
    
                                                                                $name = $value['name'];
                                                                                $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                if ($file_info['is_multiple']) {
                                                                                    $name = $file_info['document_name'];
                                                                                }

                                                                                $main_validator = check_file_closed($application_pointer, $value);

                                                                                $full_url = $main_validator["full_url"];
                                                                                $full_url_target = $main_validator["full_url_target"];
                                                                                
                                                                                
    
                                                                                echo '<tr>
                                                                                        <td> ' . $i . ' </td>
                                                                                        <td>
                                                                                            <a '.$full_url_target.' href="' . $full_url . '">
                                                                                            ' . $name . '
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>';
                                                                            }
                                                                        }
                                                                    } // required_document_id
                                                                } // stage
                                                            } // forech 
                                                        } // forech 

                                                        // Assessment Documents
                                                        $i = 0;

                                                        echo "<tr class='bg-light p-2'><td  colspan='2'>  Assessment Documents </td><tr>";
                                                        $supporting_docs = array();
                                                        $addtion_info_doc =array();
                                                        foreach ($documents as $key => $value) {
                                                            if ($value['required_document_id'] == 16) {
                                                                array_push($supporting_docs, array('id' => $value['id'], 'path' => $value['document_path'], 'name' => $value['document_name'],'namedoc' => $value['name']));
                                                            }elseif($value['required_document_id'] == 17){
                                                            array_push($addtion_info_doc, array('id' => $value['id'], 'path' => $value['document_path'], 'name' => $value['document_name']));
                                                            } else {

                                                                if ($value['stage'] == "stage_2") {
                                                                    // echo $value['required_document_id'];
                                                                    if ($value['required_document_id']== 15|| $value['required_document_id']==30 || $value['required_document_id']==34) {
                                                                        $required_document_id = $value['required_document_id'];
                                                                        $employee_id = $value['employee_id'];
                                                                        if ($employee_id == 0 || empty($employee_id)) {
                                                                            $show_f = true;
                                                                            $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                            if (!empty($documnet_request)) {
                                                                                if (isset($documnet_request->status)) {
                                                                                    if ($documnet_request->status == "send") {
                                                                                        $show_f = false;
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($show_f){
                                                            
                                                                                    $i++;
                                                                                    $name = $value['name'];
                                                                                    $file_info = (!empty(required_documents_info($required_document_id)) ? required_documents_info($required_document_id) : "");
                                                                                    if ($file_info['is_multiple']) {
                                                                                        $name = $file_info['document_name'];
                                                                                    }
                                                                                    if ($value["name"] == "Verification Email - Employment" || $value["required_document_id"] == 21 || $value["required_document_id"] == 22) {
                                                                                        $i--;
                                                                                        continue;
                                                                                    }
                                                                                    echo '<tr>
                                                                                    <td> ' . $i . ' </td>
                                                                                    <td>
                                                                                        <a target="_blank" href="' . base_url($value['document_path'] . '/' . $value['document_name']) . '">
                                                                                        ' . $name . '
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>';
                                                                            }
                                                                        }
                                                                    } // required_document_id
                                                                } // stage
                                                            } // forech 

                                                        }

                                                        ?>
                                                        <?php
                                                        if (!empty($supporting_docs)) {
                                                            // print_r($supporting_docs);
                                                            echo "<tr class='bg-light p-2'><td  colspan='2'>  Supporting Evidences for Application Kit  </td><tr>";
                                                            $i = 0;
                                                            foreach ($supporting_docs as $key => $value) {
                                                                $show_f = true;
                                                                $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                if (!empty($documnet_request)) {
                                                                    if (isset($documnet_request->status)) {
                                                                        if ($documnet_request->status == "send") {
                                                                            $show_f = false;
                                                                        }
                                                                    }
                                                                }
                                                                if($show_f){
                                                              
                                                                    $i++;
                                                                    echo '<tr>
                                                                        <td> ' . $i . ' </td>
                                                                        <td>
                                                                            <a target="_blank" href="' . base_url($value['path'] . '/' . $value['name']) . '">
                                                                            ' . $value['namedoc'] . '
                                                                            </a>
                                                                        </td>
                                                                    </tr>';

                                                                }
                                                                // required_document_id
                                                            }
                                                        } // forech 

                                                        if (!empty($addtion_info_doc)) {
                                                            // print_r($addtion_info_doc);
                                                            echo "<tr class='bg-light p-2'><td  colspan='2'> Additional Information  </td><tr>";
                                                            $i = 0;
                                                            foreach ($addtion_info_doc as $key => $value) {
                                                                $show_f = true;
                                                                $documnet_request = find_one_row('additional_info_request', 'document_id', $value['id']);
                                                                if (!empty($documnet_request)) {
                                                                    if (isset($documnet_request->status)) {
                                                                        if ($documnet_request->status == "send") {
                                                                            $show_f = false;
                                                                        }
                                                                    }
                                                                }
                                                                if($show_f){
                                                              
                                                                    $i++;
                                                                    echo '<tr>
                                                                        <td> ' . $i . ' </td>
                                                                        <td>
                                                                            <a target="_blank" href="' . base_url($value['path'] . '/' . $value['name']) . '">
                                                                            ' . $value['name'] . '
                                                                            </a>
                                                                        </td>
                                                                    </tr>';

                                                                }
                                                                // required_document_id
                                                            }
                                                        } // forech 


                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                <!--</div>-->
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- stage 3 docs  -->
                <div>
                    <div class="accordion-item">
                        <!-- Clickebal Button  -->
                        <h2 class="accordion-header" id="s3_tital_div">
                            <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s3_tital_body_div" aria-expanded="false" aria-controls="s3_tital_body_div">
                                <h5 class="text-green p-2"><b>Stage 3 - Submitted Documents </b></h5>
                            </button>
                        </h2>
                        <!-- collapseabal Div show all data / collapse Body  -->
                        <div id="s3_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s3_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Sr.No. </th>
                                            <th> Document Name </th>
                                            <!-- <td> Document </td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($documents as $key => $value) {
                                            if ($value['stage'] == "stage_3") {
                                                if ($value['required_document_id'] == 19 || $value['required_document_id'] == 29 || $value['required_document_id'] == 43 ||$value['required_document_id'] == 55) {
                                                    $i++;
                                                    $required_document_id = $value['required_document_id'];

                                                    $main_validator = check_file_closed($application_pointer, $value);

                                                    $full_url = $main_validator["full_url"];
                                                    $full_url_target = $main_validator["full_url_target"];
                                        ?>
                                                    <tr>
                                                        <td> <?= $i; ?> </td>
                                                        <td>
                                                            <a href="<?= $full_url  ?>" <?= $full_url_target ?>>
                                                                <?= $value['name']; ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                } // required_document_id
                                            } // stage
                                        } // forech 
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- Stage 3 docs end-->
                
                 <!-- stage 3 ress docs  -->
                 <?php 
                 if($stage_3_R){
                     
                    if($stage_3_R_documents){
                     ?>
                        <div>
                    <div class="accordion-item">
                        <!-- Clickebal Button  -->
                        <h2 class="accordion-header" id="s3_ress_tital_div">
                            <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s3_ress_tital_body_div" aria-expanded="false" aria-controls="s3_ress_tital_body_div">
                                <h5 class="text-green p-2"><b>Stage 3 - Submitted Documents (Reassessment)</b></h5>
                            </button>
                        </h2>
                        <!-- collapseabal Div show all data / collapse Body  -->
                        <div id="s3_ress_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s3_ress_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Sr.No. </th>
                                            <th> Document Name </th>
                                            <!-- <td> Document </td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        // print_r($documents);
                                        foreach ($documents as $key => $value) {
                                            if ($value['stage'] == "stage_3_R") {
                                                if ($value['required_document_id'] == 19 || $value['required_document_id'] == 29 || $value['required_document_id'] == 43 || $value['required_document_id'] == 55) {
                                                    $i++;
                                                    $required_document_id = $value['required_document_id'];

                                        ?>
                                                    <tr>
                                                        <td> <?= $i; ?> </td>
                                                        <td>
                                                            <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">
                                                                <?= $value['name']; ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                } // required_document_id
                                            } // stage
                                        } // forech 
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                    <?php 
                    }
                 }
                ?>
                <?php   
                    $occupation_name=$Application_Details['occupation'];
                    $pathway=$Application_Details['pathway'];
                    if($pathway=="Pathway 1"){
                    if($occupation_name=="Electrician (General)"||$occupation_name=="Plumber (General)"){
                ?>
                
                <!--Stage 4 docs-->
                
                <div>
                    <div class="accordion-item">
                        <!-- Clickebal Button  -->
                        <h2 class="accordion-header" id="s3_tital_div">
                            <button class="accordion-button collapsed" style="padding: 5px !important; padding-top: 10px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#s4_tital_body_div" aria-expanded="false" aria-controls="s3_tital_body_div">
                                <h5 class="text-green p-2"><b>Stage 4 - Submitted Documents </b></h5>
                            </button>
                        </h2>
                        <!-- collapseabal Div show all data / collapse Body  -->
                        <div id="s4_tital_body_div" class="accordion-collapse collapse" aria-labelledby="s4_tital_div" data-bs-parent="#accordionExample" style="overflow-y: scroll; height:400px;">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Sr.No. </th>
                                            <th> Document Name </th>
                                            <!-- <td> Document </td> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        // print_r($documents);
                                        foreach ($documents as $key => $value) {
                                            if ($value['stage'] == "stage_4") {
                                                if ($value['required_document_id'] == 44  || $value['required_document_id'] == 49) {
                                                    $i++;
                                                    $required_document_id = $value['required_document_id'];
                                                    
                                                    $main_validator = check_file_closed($application_pointer, $value);

                                                    $full_url = $main_validator["full_url"];
                                                    $full_url_target = $main_validator["full_url_target"];

                                        ?>
                                                    <tr>
                                                        <td> <?= $i; ?> </td>
                                                        <td>
                                                            <a href="<?= $full_url  ?>" <?= $full_url_target ?>>
                                                                <?= $value['name']; ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                } // required_document_id
                                            } // stage
                                        } // forech 
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                
                <!--Stage 4 docs end-->
                <?php  }
        }  ?>
            </div>
            
           
        </div>

    </div>
     <?php 
        if (isset($stage_3["status"]) && $stage_3["status"] == "Declined") { 
            if($stage_3_R && isset($stage_3_R["status"]) && ($stage_3_R["status"] == "reassessment" || $stage_3_R["status"] == "start")){
                 $display = ""; 
            }elseif(empty($reassessment_data)){
                // echo "condition 1";
             $display = "display: none";
            }else{
                // echo "condition 2";
                $display = ""; 
            }
            ?>
                <hr class="mt-4">

                <div style="<?=$display?>" id= "start_stage_3" class="col-6">
                    <div style="<?=$display?>" id="note_stage_3_reassessment">
                        <p style="background-color: #ffc107 !important;color: #055837;padding: 10px;border-radius: 7px;">
                        <b style="color: #055837;    padding-left: 12px;" class="row">Note :</b>
                        We have now sent an email with the payment instructions for reassessment. You will need the TRA reassessment payment receipt to proceed.
                        </p>
                    </div>
                    <?php 
                    // if($reassessment_data){
                        // print_r($reassessment_data);
                        // exit;
                    if($stage_3_R && isset($stage_3_R["exemption_yes_no"]) && $stage_3_R["exemption_yes_no"] == "" ){
                            $value_stage_3_R = "Start Stage 3 (Reassessment) Submission";
                    }elseif (isset($reassessment_data->exemption_yes_no) && !empty($reassessment_data->exemption_yes_no)=="") {
                        $value_stage_3_R = "Start Stage 3 (Reassessment) Submission";
                    } else {
                        $value_stage_3_R = "Continue Stage 3 (Reassessment) Submission";
                    }
               $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
                    ?>
                    
                     
                     <?php  if($stage_1_usi_avetmiss->currently_have_usi=='yes'){ ?>
                                    <hr class="mt-4">
                                   <div class="col-sm-12  mb-2 mt-3" style="max-width:600px;">
                        <a href="<?= base_url('user/stage_3_reassessment/receipt_upload_page__') ?>/<?= $ENC_pointer_id ?>" id="value_3_R" class="btn btn_green_yellow w-100" >
                            <?= $value_stage_3_R ?>
                        </a>
                    </div>
                    <?php }else{ ?>
                        
                       <div class="col-sm-12  mb-2 mt-3" style="max-width:600px;">
                        <a href="<?= base_url('user/stage_3_reassessment/receipt_upload') ?>/<?= $ENC_pointer_id ?>" id="value_3_R" class="btn btn_green_yellow w-100" >
                            <?= $value_stage_3_R ?>
                        </a>
                    </div>   
                    <?php
        }
                    // }
                    ?>
                </div>
              <?php 
        
        }
    ?>

</div>
<div id="cover-spin">
    <div id="loader_img">
        <img src="<?= base_url("public/assets/image/admin/loader.gif") ?>" style="width: 100px; height:auto">
    </div>
</div>

<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
   function reassessment_stage_3(){
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to initiate the Reassessment Application ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'stage_1_pop_btn');
        // check Btn click
        $("#stage_1_pop_btn").click(function() { 
            if (custom_alert_popup_close('stage_1_pop_btn')) {
                $('#cover-spin').show(0);
                 $.ajax({
                    'url': '<?= base_url('user/stage_3_reassessment/start/' . $ENC_pointer_id) ?>',
                    'type': 'post',
                    success: function(data) {
                        $('#cover-spin').hide(0);
                        $('#start_stage_3').show();
                        $('#note_stage_3_reassessment').show();
                        $('#button_for_apply').hide();
                        document.querySelector('#value_3_R').textContent = "Start Stage 3 (Reassessment) Submission"; 
                        // linkElement.textContent = "New Value";

                        // document.getElementById("value_3_R").value ="Start Stage 3 reassessment Submission";
                        // $('#value_3_R').value().
                        // window.location = "<= base_url('user/view_application/' . $ENC_pointer_id) ?>";
                        // 1 if( note in yellow )
                            
                        // button 
                        // Start Stage 3 (Reassessment) Submission   same as stage 3 -> stage 3 page -> if completed then on view application page                                        
                    }
                });
                return true;
            } else {
                $('#cover-spin').hide(0);
                return false;
            }    
            
        });
   }
</script>

<?= $this->endSection() ?>
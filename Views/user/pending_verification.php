<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<?php
//  print_r($_SESSION);exit;
 
?>
<style>
    .container-fluid {
        max-width: 1600px !important;
    }
</style>
<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b>Employment Verification</b>
</div>

<!-- start -->
<div class="container-fluid mt-4 mb-4  ">
    <!-- center div  -->
    <div class=" p-2 bg-white shadow p-3 ">

        <!-- Alert on set - Flashdata -->
        <?= $this->include("alert_box.php") ?>

        <table class="table table-striped table-hover" id="table">
            <thead>
                <?php
                  $account_type = session()->get("account_type");
                  if($account_type == 'Applicant')
                  {
                ?>
                <tr>
                    <th scope="col" style="width: 5%;">
                       <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                         PRN
                       </span>
                    </th>
                    <!--<th>Sr.No.</th>-->
                    <th>Application No. </th>
                    <th>Applicant Name</th>
                    <th>Applicant Contact No.</th>
                    <th>DOB</th>
                    <th>Occupation</th>
                    <th>Action</th>
                </tr>
                <?php }else {?>
                   <tr>
                    <th scope="col" style="width: 5%;">
                       <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                         PRN
                       </span>
                    </th>
                    <!--<th>Sr.No.</th>-->
                    <th>Application No. </th>
                    <th>Applicant Name</th>
                    <th>DOB</th>
                    <th>Occupation</th>
                    <!--<th>Agent Name</th>-->
                    <!--<th>Agent Contact No.</th>-->
                    <!--<th>Agency</th>-->
                    <th>Action</th>
                </tr>
                <?php } ?>
            </thead>
                
            <tbody>
                <?php
                $count = 1;
                   foreach($applications as $applicant)
                   {
                    //   print_r($applicant);exit;
                    $email_verification = emplo_email_verf($applicant->id);
                    // print_r($email_verification);
                    // echo '<br>';
                    // continue;
                    $isVerificationThere = isVerificationIsThereForStage2($applicant->id);
                    if(!$isVerificationThere){
                        continue;
                    }
                    
                ?>
                
                   <?php if (!empty($email_verification)) { 
                       
                       if($account_type == 'Applicant'){
                   ?>
                       
                        <tr>
                                                <?php
                                                $user_account = find_one_row('user_account', 'id', $applicant->user_id);
                                                $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $applicant->id);
                                                $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $applicant->id);
                                                $s1_occupation_name = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);

                                                ?>
                                                <td>
                                                    <?php echo  portal_reference_no($applicant->id); ?>
                                                </td>
                                                <!--<td><?php //$count ?></td>-->
                                                <td><?php
                                                    $stage_1 = find_one_row('stage_1', 'id', $applicant->id);
                                                    
                                                    if (empty($stage_1->unique_id)) {
                                                        $unique_code = "[#T.B.A]";
                                                    } else {
                                                        $unique_code = "[#" . $stage_1->unique_id . "]";
                                                    }
                                                    echo $unique_code ?>
                                                </td>
                                                <td><?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?></td>
                                                
                                                <td><?php
                                                    $mobile_code = find_one_row('country', 'id', $user_account->mobile_code);
                                                    echo "+" . $mobile_code->phonecode . " " . $user_account->mobile_no ?>
                                                </td>
                                                
                                                <td><?= $s1_personal_details->date_of_birth ?></td>
                                                 <td><?= $s1_occupation_name->name ?></td>

                                                
                                                <td>
                                                    <?php
                                                    $email_verification = find_multiple_rows('email_verification', 'pointer_id', $applicant->id);
                                                    $No_varification = 0;
                                                    $No_done_varification = 0;
                                                    foreach ($email_verification as $key => $value) {
                                                        $No_varification++;
                                                        if(!empty($value->employer_id)){
                                                            if ($value->is_verification_done == 1) {
                                                                $No_done_varification++;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $No_done_varification ?> / <?= $No_varification ?>" href="<?= base_url('user/pending_view') ?>/<?= $applicant->id ?>" class="btn btn-sm btn_green_yellow">
                                                        <i class="bi bi-eye-fill eye-open-click"></i>
                                                    </a>
                                                </td>

                                            </tr>

                   <?php $count++;  ?>

                                       
                    <?php } else{ ?>
                    
                      <tr>
                                                <?php
                                                $user_account = find_one_row('user_account', 'id', $applicant->user_id);
                                                $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $applicant->id);
                                                $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $applicant->id);
                                                $s1_occupation_name = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);
                                                // print_r($s1_occupation_name);exit;
                                                ?>
                                                <td>
                                                    <?php echo  portal_reference_no($applicant->id); ?>
                                                </td>
                                                <!--<td><?php //$count ?></td>-->
                                                <td><?php
                                                    $stage_1 = find_one_row('stage_1', 'id', $applicant->id);
                                                    // print_r($stage_1);exit;
                                                    if (empty($stage_1->unique_id)) {
                                                        $unique_code = "[#T.B.A]";
                                                    } else {
                                                        $unique_code = "[#" . $stage_1->unique_id . "]";
                                                    }
                                                    echo $unique_code ?>
                                                </td>
                                                <td><?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?></td>
                                                <td><?= $s1_personal_details->date_of_birth ?></td>
                                                <!--<td><?= $user_account->name . " " . $user_account->middle_name . " " . $user_account->last_name ?></td>-->
                                               
                                                <td><?= $s1_occupation_name->name ?></td>
                                                <td>
                                                    <?php
                                                    $email_verification = find_multiple_rows('email_verification', 'pointer_id', $applicant->id);
                                                    $No_varification = 0;
                                                    $No_done_varification = 0;
                                                    foreach ($email_verification as $key => $value) {
                                                        $No_varification++;
                                                        if(!empty($value->employer_id)){
                                                            if ($value->is_verification_done == 1) {
                                                                $No_done_varification++;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $No_done_varification ?> / <?= $No_varification ?>" href="<?= base_url('user/pending_view') ?>/<?= $applicant->id ?>" class="btn btn-sm btn_green_yellow">
                                                        <i class="bi bi-eye-fill eye-open-click"></i>
                                                    </a>
                                                </td>

                                            </tr>
                    
                    <?php } }?>
                
                
                <?php } 
                //   exit;
                ?>
            </tbody>
        </table>

    </div>
</div>


<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "aaSorting": [],
            "pageLength": 25,
            // order: [
            //     [6, 'desc']
            // ],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
</script>
<?= $this->endSection() ?>
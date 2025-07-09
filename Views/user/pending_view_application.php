<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<?php
// print_r($employs);exit;
$s1_personal_details ='';
$unique_code = '';
$pointer_id = '';
foreach ($employs as $employ) {
    // $user_account = find_one_row('user_account', 'id', $employ->user_id);
    $pointer_id = $employ->pointer_id;
    $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $employ->pointer_id);
    $stage_1 = find_one_row('stage_1', 'id', $employ->pointer_id);
    // print_r($stage_1);exit;
    if (empty($stage_1->unique_id))
    {
       $unique_code = "[ #T.B.A ]";
    } else {
         $unique_code = "[ #" . $stage_1->unique_id . " ]";
    }
}
// exit;
?>
<style>
    .container-fluid {
        max-width: 1600px !important;
    }
</style>
<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
   
    <!--<b>Employment Verification ( <?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?> - <?= $unique_code ?> )</b>-->
        <b>Employment Verification </b>

</div>

<!-- start -->
<div class="container-fluid mt-4 mb-4  ">
    <!-- center div  -->
    <div class=" p-2 bg-white shadow p-3 ">

        <!-- Alert on set - Flashdata -->
        <?= $this->include("alert_box.php") ?>
        
          <table class="table ">
                            <tbody>
                               
                                <tr>
                                    <th width="25%"><b>PRN</b></th>
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
                                            echo $unique_code;
                                            ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="25%"><b>Applicant Name</b></th>
                                    <td>:</td>
                                    <td><?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?></td>
                                </tr>
                                
                                
                              
                            </tbody>
                        </table>

        <table class="table table-striped table-hover" id="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Referee Name </th>
                    <th>Referee Email ID</th>
                    <th>Referee Contact No</th>
                    <th>Company/Organisation Name</th>
                    <th>Status</th>
                    
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
                                                ?>
                                                   <span class="bg-green text-white p-2 rounded">Verified </span>
                                                    <!--<a  id="ver_url">-->
                                                    <!--    <span class='text-green'>Verified</span>-->
                                                    <!--</a>-->
    
                                                <?php
                                                } else
                                                if ($verification_email_send == 1) {
                                                ?>
                                                    <span class="bg-yellow text-black p-2 rounded">Pending </span>
                                                    <!--<a  id="pending_url">-->
                                                    <!--    <span class='text-blue' style="color:blue !important">Pending</span>-->
                                                    <!--</a>-->
                                                <?php
                                                } else {
                                                    echo "[#T.B.A]";
                                                }
                                                ?>
    
    
    
                                            </td>
    
                                            
                                        </tr>
    
                                      
    
    
                                    <?php
                                        $count++;
                                    }  ?>
    
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
<?= $this->extend('template/admin_template') ?>

<?= $this->section('main') ?>

<style>
    .nav-tabs .nav-item .nav-link {
        color: black;
    }

    * {

        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
    }

    /* #main {
        margin-top: 100px;
    } */
    .pg_link{
        font-color:#009933;
    }

    .nav-link {
        font-weight:bold;
        color: #055837 ;
    }
    .nav-link:hover {
        font-weight:bold;
        background-color: #FFC107 !important;
        color: #055837 !important;
    }

    .active_btn {
        font-weight:bold;
        background-color: #055837 !important;
        color: #FFC107 !important;
    }


    .active_btn:hover {
        font-weight:bold;
        background-color: #FFC107 !important;
        color: #055837 !important;
    }

    .btn_green {
        background-color: #055837 !important;
        color: #FFC107 !important;
    }

    .btn_green:hover {
        background-color: #FFC107 !important;
        color: #055837 !important;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h4 class="text-green"> Verification</h4>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 border-bottom-0">
                <?php
                if ($tab == "employment") {
                    $qualification_class = "";
                    $employment_class = "active ";
                } else {
                    $employment_class = "";
                    $qualification_class = "active ";
                }
                ?>
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link <?= $employment_class ?>" id="custom-tabs-employment-tab" href="<?= base_url("admin/verification/employment") ?>" role="tab" aria-controls="custom-tabs-employment" aria-selected="true">Employment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $qualification_class ?>" id="custom-tabs-qualification-tab" href="<?= base_url("admin/verification/qualification") ?>" role="tab" aria-controls="custom-tabs-qualification" aria-selected="false">Qualification</a>
                    </li>
                    
                </ul>
            </div>
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show <?= $employment_class ?>" id="custom-tabs-employment" role="tabpanel" aria-labelledby="custom-tabs-employment-tab">
                    <div class="card-body">
                        <div class="table table-responsive">

                            <!--  Table with stripped rows starts -->

                            <table id="staff_table" class="table table-striped datatable">

                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 5%;">
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                                                PRN
                                            </span>
                                        </th>

                                        <!--<th>Sr.No.</th>-->
                                        <th>Application No. </th>
                                        <th>Applicant Name</th>
                                        <th>Agent Name</th>
                                        <th>Agent Contact No.</th>
                                        <th>Agency</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    
                                    foreach ($applications as $applicant) {
                                        // break;
                                        // $email_verification = emplo_email_verf($applicant->id);
                                        $email_verification = 1;
                                        
                                                $user_account = find_one_row('user_account', 'id', $applicant->user_id);
                                                if(!isset($user_account->name) || !isset($user_account->mobile_code)){
                                                    continue;
                                                }
                                                
                                                $mobile_code = find_one_row('country', 'id', $user_account->mobile_code);
                                                if(!isset($mobile_code)){
                                                    continue;
                                                }
                                                    
                                                
                                    ?>

                                        <?php if (!empty($email_verification)) { ?>
                                            <tr>
                                                <?php
                                                
                                                
                                                $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $applicant->id);
                                                
                                                $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $applicant->id);
                                                // print_r($s1_occupation);
                                                // die;
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
                                                    echo $unique_code;
                                                
                                                    ?>
                                                </td>
                                                <td><?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name ?></td>
                                                <?php if($user_account){ ?>
                                                <td><?= $user_account->name . " " . $user_account->middle_name . " " . $user_account->last_name ?></td>
                                                <?php }
                                                else{
                                                    ?>
                                                    
                                                    <td></td>
                                                    <?php
                                                }
                                                ?>
                                                <td><?php
                                                 
                                                    if($mobile_code){
                                                        echo "+" . $mobile_code->phonecode . " " . $user_account->mobile_no;
                                                    }
                                                        ?>
                                                    
                                                    
                                                    </td>
                                                <td><?= $user_account->business_name ?></td>
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
                                                    <a data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $No_done_varification ?> / <?= $No_varification ?>" href="<?= base_url('admin/verification/view_application') ?>/<?= $applicant->id ?>" class="btn btn-sm btn_green_yellow">
                                                        <i class="bi bi-eye-fill eye-open-click"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                            <?php $count++;   ?>

                                        
                                        <?php  } ?>

                                <?php  }  
                                              ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show <?= $qualification_class ?>" id="custom-tabs-qualification" role="tabpanel" aria-labelledby="custom-tabs-qualification-tab">
                    <div class="card-body">
                        <div class="table table-responsive">

                            <!--  Table with stripped rows starts -->

                            <table id="quali_table" class="table table-striped datatable">

                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 5%;">
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                                                PRN
                                            </span>
                                        </th>

                                        <!--<th>Sr.No.</th>-->
                                        <th>Application No. </th>
                                        <th>Applicant Name</th>
                                        <th>Agent Name</th>
                                        <th>Agent Contact No.</th>
                                        <th>Agency</th>
                                        <th>Action</th>
                                
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                   <?php
                                    $count = 1;
                                    foreach ($qualification_applications as $applicant) {
                                        $qualification_email_verification = quali_email_verf( $applicant->id);
                                    ?>

                                        <?php if (!empty($qualification_email_verification)) { ?>
                                            <tr>
                                                <?php
                                                $user_account = find_one_row('user_account', 'id', $applicant->user_id);
                                                $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $applicant->id);
                                                $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $applicant->id);
                                                ?>
                                                <td>
                                                    <?php echo  portal_reference_no($applicant->id); ?>
                                                </td>
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
                                                <td><?= $user_account->name . " " . $user_account->middle_name . " " . $user_account->last_name ?></td>
                                                <td><?php
                                                    $mobile_code = find_one_row('country', 'id', $user_account->mobile_code);
                                                    echo "+" . $mobile_code->phonecode . " " . $user_account->mobile_no ?></td>
                                                <td><?= $user_account->business_name ?></td>
                                                <td>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="right" title="" href="<?= base_url('admin/verification/view_application') ?>/<?= $applicant->id ?>" class="btn btn-sm btn_green_yellow">
                                                        <i class="bi bi-eye-fill eye-open-click"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                            <?php $count++;  ?>

                                        <?php  } ?>

                                    <?php  }  ?>
 
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
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
        $('#staff_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
        $('#quali_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
     $(document).ready(function() {

        const bbbb = document.querySelector('#custom-tabs-qualification-tab');
        if (bbbb.classList.contains('active')) {
            bbbb.classList.add('active_btn');
        }
        const aaa = document.querySelector('#custom-tabs-employment-tab');
        if (aaa.classList.contains('active')) {
            aaa.classList.add('active_btn');
        }
    });
</script>

<?= $this->endSection() ?>
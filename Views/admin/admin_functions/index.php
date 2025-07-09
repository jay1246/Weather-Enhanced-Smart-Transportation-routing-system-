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

<main id="main" class="main" style="width: 100%;">
    <div class="pagetitle">
        <h4 class="text-green">Admin Functions</h4>
    </div>
    <section class="section dashboard mt-3 shadow">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 border-bottom-0">
                <?php
                if ($tab == "applicant") {
                    $agent_class = "";
                    $applicant_class = "active";
                } else {
                    $applicant_class = "";
                    $agent_class = "active";
                }
                ?>
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                    <li class="nav-item">
                        <a class="  nav-link <?= $agent_class ?>" id="custom-tabs-agent-tab" href="<?= base_url("admin/applicant_agent/agent") ?>" role="tab" aria-controls="custom-tabs-agent" aria-selected="false">Reporting</a>
                    </li>
                    <li class="nav-item">
                        <a class="  nav-link <?= $applicant_class ?>" id="custom-tabs-applicant-tab" href="<?= base_url("admin/applicant_agent/applicant") ?>" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">Accounting</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="  nav-link <?= $applicant_class ?>" id="custom-tabs-applicant-tab" href="<?= base_url("admin/applicant_agent/applicant") ?>" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">Data Analysis</a>
                    </li>
                </ul>
            </div>


            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show <?= $applicant_class ?>" id="custom-tabs-applicant" role="tabpanel" aria-labelledby="custom-tabs-applicant-tab">
                    <div class="card-body table-responsive">
                        
                    </div>
                </div>

                <div class="tab-pane fade show <?= $agent_class ?>" id="custom-tabs-agent" role="tabpanel" aria-labelledby="custom-tabs-agent-tab">
                    <div class="card-body table-responsive">
                        <table class="table table-striped datatable" id="agent_table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">Sr.No.</th>
                                    <th style="width: 25%;">Agent Name</th>
                                    <th style="width: 25%;">Company Name</th>
                                    <th style="width: 15%;">Email</th>
                                    <th style="width: 15%;">Contact No.</th>
                                    <th style="width: 20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sr = 1;
                                // print_r($agents);
                                foreach ($agents as $agent) {
                                ?>
                                    <tr>
                                        <td><?= $sr ?></td>
                                        <td><?= $agent->name . " " . $agent->middle_name . " " . $agent->last_name ?></td>
                                        <td><a href="<?= base_url('admin/application_manager/company') ?>/<?= $agent->id ?>" style="color:#009933"><?= $agent->business_name ?></a></td>
                                        <td><?= $agent->email ?></td>
                                        <td>
                                            <?php
                                            if ($agent->mobile_code != "") {
                                                $mobile_code_ag = "+" . country_phonecode($agent->mobile_code);
                                            } else {
                                                $mobile_code_ag = " ";
                                            }
                                            ?>
                                            <?= $mobile_code_ag . " " . $agent->mobile_no ?></td>
                                        <td>
                                            <a href="<?= base_url("admin/applicant_agent/agent") . "/" . $agent->id ?>" class="btn btn-sm btn_green_yellow">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <?php
                                            $agent_dele = find_one_row('application_pointer', 'user_id', $agent->id);
                                            if (!empty($agent_dele)) {
                                                $dele_class_agent = "disabled";
                                            } else {
                                                $dele_class_agent = " ";
                                            }
                                            ?>
                                            <a type="submit" onclick="delete_data(<?= $agent->id ?>)" class="btn btn-sm btn-danger <?= $dele_class_agent ?>"> <i class="bi bi-trash-fill"></i></a>
                                        </td>

                                    </tr>



                                <?php
                                    $sr++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->endSection() ?>
<?= $this->section("custom_script") ?>

<?= $this->endSection() ?>
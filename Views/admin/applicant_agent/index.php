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
        <h4 class="text-green">Applicant / Agent</h4>
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
                        <a class="  nav-link <?= $agent_class ?>" id="custom-tabs-agent-tab" href="<?= base_url("admin/applicant_agent/agent") ?>" role="tab" aria-controls="custom-tabs-agent" aria-selected="false">Agent</a>
                    </li>
                    <li class="nav-item">
                        <a class="  nav-link <?= $applicant_class ?>" id="custom-tabs-applicant-tab" href="<?= base_url("admin/applicant_agent/applicant") ?>" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">Applicant</a>
                    </li>
                </ul>
            </div>


            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show <?= $applicant_class ?>" id="custom-tabs-applicant" role="tabpanel" aria-labelledby="custom-tabs-applicant-tab">
                    <div class="card-body table-responsive">
                        <table class="table table-striped datatable" id="applicant_table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th >Applicant Name</th>
                                    <!--<th >Company Name</th>-->
                                    <th >Email</th>
                                    <th >Contact No</th>
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $count = 1;
                                // print_r($applicants);
                                // exit;
                                foreach ($applicants as $applicant) {
                                ?>
                                    <tr>
                                        <td><?= $count ?></td>
                                        <!--<td><?php //$applicant->name . " " . $applicant->middle_name . " " . $applicant->last_name ?></td>-->
                                        <td><a href="<?= base_url('admin/applicant_agent/company') ?>/<?= $applicant->id ?>" style="color:#009933"><?= $applicant->name . " " . $applicant->middle_name . " " . $applicant->last_name ?></a>
</td>
                                        <!--<td><?php // $applicant->business_name ?></td>-->
                                        <td><?= $applicant->email ?></td>
                                        <?php
                                        $mobile_code = "";
                                        if ($applicant->mobile_code != "") {
                                            if (!empty(country_phonecode($applicant->mobile_code))) {
                                                $mobile_code = "+" . country_phonecode($applicant->mobile_code);
                                            }
                                        }
                                        $m_number =     $mobile_code . " " . $applicant->mobile_no;

                                        ?>
                                        <td><?php
                                            if (!empty($m_number)) {
                                                echo $m_number;
                                            }
                                            ?></td>

                                        <td>
                                            <a href="<?= base_url("admin/applicant_agent/applicant") . "/" . $applicant->id ?>" class="btn btn-sm btn_green_yellow">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <?php
                                            $appli_dele = find_one_row('application_pointer', 'user_id', $applicant->id);
                                            if (!empty($appli_dele)) {
                                                $dele_class_appli = "disabled";
                                            } else {
                                                $dele_class_appli = " ";
                                            }
                                            ?>
                                            <a type="submit" onclick="delete_data(<?= $applicant->id ?>)" class="btn btn-sm btn-danger <?= $dele_class_appli ?>"> <i class="bi bi-trash-fill"></i></a>
                                        </td>

                                    </tr>



                                <?php
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
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
                                        <td><a href="<?= base_url('admin/applicant_agent/company') ?>/<?= $agent->id ?>" style="color:#009933"><?= $agent->business_name ?></a></td>
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
<script>
    $(document).ready(function() {
        $('#agent_table').DataTable({
            "aaSorting": [],
            columnDefs: [
              {
                width: "08%",
                targets: 5,
                orderable: false,
              },
            ],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
    $(document).ready(function() {
        $('#applicant_table').DataTable({
            "aaSorting": [],
            columnDefs: [
                {
                    width: "08%",
                    targets: 4, // Target the 5th column (zero-based index)
                    orderable: false,
                },
            ],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
    var tab = '<?= $tab ?>';

    function delete_data(id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this user?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
        $("#delete_pop_btn").click(function() {
            if (custom_alert_popup_close('delete_pop_btn')) {

                // if (confirm("Are you sure you want to delete this user?")) {  
                $.ajax({
                    url: "<?= base_url("admin/applicant_agent/delete") ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data["response"] == true) {
                            window.location = "<?= base_url("admin/applicant_agent") ?>/" + tab;
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        });
    }
</script>

<script>
    $(document).ready(function() {

        const bbbb = document.querySelector('#custom-tabs-agent-tab');
        if (bbbb.classList.contains('active')) {
            bbbb.classList.add('active_btn');
        }
        const aaa = document.querySelector('#custom-tabs-applicant-tab');
        if (aaa.classList.contains('active')) {
            aaa.classList.add('active_btn');
        }
    });
</script>

<?= $this->endSection() ?>
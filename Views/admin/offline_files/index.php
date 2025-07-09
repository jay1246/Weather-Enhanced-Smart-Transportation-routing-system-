<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>
<style>
    .nav-tabs .nav-item .nav-link {
        color: black;
        font-weight: bold;
    }

    .nav-link:hover {

        background-color: #fecc00;
        color: #055837;
        font-weight: bold;
    }

    .active_btn {
        background-color: #055837 !important;
        color: #fecc00 !important;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h4 class="text-green">Offline Files</h4>
    </div>
    <section class="section dashboard mt-3 shadow">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 border-bottom-0">
                <?php
                if ($tab == "saq_file") {
                    $saq_act = "active";
                    $app_act = "";
                    $thir_act = "";
                    $saq_act1 = "active_btn";
                    $app_act1 = "";
                    $thir_act1 = "";
                } elseif ($tab == "application_kit") {
                    $app_act = "active";
                    $thir_act = "";
                    $saq_act = "";
                    $app_act1 = "active_btn";
                    $thir_act1 = "";
                    $saq_act1 = "";
                } else {
                    $thir_act = "active";
                    $app_act = "";
                    $saq_act = "";
                    $thir_act1 = "active_btn";
                    $app_act1 = "";
                    $saq_act1 = "";
                }
                ?>
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?= $saq_act ?> <?= $saq_act1 ?>" id="custom-tabs-saq_file-tab" href="<?= base_url("admin/offline_files/saq_file") ?>" role="tab" aria-controls="custom-tabs-saq_file" aria-selected="true">SAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $app_act ?> <?= $app_act1 ?>" id="custom-tabs-application_kit-tab" href="<?= base_url("admin/offline_files/application_kit") ?>" role="tab" aria-controls="custom-tabs-application_kit" aria-selected="false">Applicant Kit </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $thir_act ?> <?= $thir_act1 ?>" id="custom-tabs-third_party-tab" href="<?= base_url("admin/offline_files/third_party") ?>" role="tab" aria-controls="custom-tabs-third_party" aria-selected="false">Third Party Report</a>
                    </li>

                </ul>
            </div>
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show <?= $saq_act ?>" id="custom-tabs-saq_file" role="tabpanel" aria-labelledby="custom-tabs-saq_file-tab">
                    <div class="card-body">
                        <!--<div class="row card-header text-end">-->
                        <div class="text-end">
                            <a href="" data-bs-toggle="modal" data-bs-target="#add_file_saq" class="btn btn_green_yellow" style="position: absolute;
    right: 250px;
    top: 75px;z-index:3">
                                <i class="bi bi-plus"></i>
                                ADD SAQ
                            </a>
                        </div>
                        <!--</div>-->

                        <div class="row card-body">
                            <div class="col-12 table-responsive">
                                <?php
                                // echo "<pre>";
                                // print_r($offline_saq_files);
                                // echo "</pre>";
                                ?>
                                <table class="table table-striped datatable" id="offline_files_table">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Occupation</th>
                                            <!--<th>Name</th>-->
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($offline_saq_files as $offline_file_saq) {
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>

                                                <td><?= find_one_row('occupation_list', 'id', $offline_file_saq->occupation_id)->name ?></td>
                                                <!--<td><?php // $offline_file_saq->name 
                                                        ?></td>-->
                                                <td>
                                                    <?php $full_path = base_url($offline_file_saq->path_text); ?>
                                                    <a href="<?= $full_path ?>">
                                                        <?= $offline_file_saq->file_name ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#edit_saq_form<?= $count ?>" class="btn btn-sm btn_green_yellow">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <a onclick="delete_data(<?= $offline_file_saq->id ?>)" class="btn btn-sm btn-danger"> <i class="bi bi-trash-fill"></i></a>
                                                </td>

                                            </tr>

                                            <!-- modal box for edit -->
                                            <div class="modal" id="edit_saq_form<?= $count ?>">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit SAQ File</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" class="edit_data">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <label>Occupation
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select name="occupation" class="form-control md-2" id="occ_saq_edit">
                                                                            <option value="<?= $offline_file_saq->occupation_id ?>"><?= find_one_row('occupation_list', 'id', $offline_file_saq->occupation_id)->name ?></option>
                                                                            <?php
                                                                            $num = 1;
                                                                            $occupation_edit_saq_files = occupation_saq_app_thir('saq_file');
                                                                            // print_r($occupation_edit_saq_files);
                                                                            // exit;
                                                                            foreach ($occupation_edit_saq_files as $occupation_file_edit_saq) {
                                                                                if ($occupation_file_edit_saq->id != $offline_file_saq->occupation_id) {

                                                                            ?>
                                                                                    <option value="<?= $occupation_file_edit_saq->id ?>"><?= $occupation_file_edit_saq->name ?></option>

                                                                            <?php
                                                                                    $num++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <!--<label>Name-->
                                                                    <!--    <span class="text-danger">*</span>-->
                                                                    <!--</label>-->
                                                                    <input type="hidden" name="name" class="form-control md-2" id="text_saq_edit" value="<?= $offline_file_saq->name ?>">
                                                                    <input type="hidden" name="id" class="form-control md-2" value="<?= $offline_file_saq->id ?>">
                                                                    <input type="hidden" name="use_for" class="form-control md-2" value="saq_file">
                                                                    <div class="col-6">
                                                                        <label>File
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="file" name="file" class="form-control md-2" id="file_saq_edit">
                                                                        <a href="<?= base_url($offline_file_saq->path_text) ?>" target="_blank"><?= empty($offline_file_saq->file_name) ?> <?php echo $offline_file_saq->file_name ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="text-end">
                                                                        <button type="submit" class="btn btn_green_yellow">Save</button>
                                                                        <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal box for edit end -->

                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- modal box for add -->
                    <div class="modal" id="add_file_saq">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Add SAQ </h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" class="add_data">
                                        <div class="row">
                                            <div class="col-6">
                                                <label>Occupation
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="occupation" class="form-control md-2" id="occ_saq" required>
                                                    <option></option>
                                                    <?php
                                                    $occupation_add_saq_files = occupation_saq_app_thir('saq_file');
                                                    $num = 1;
                                                    foreach ($occupation_add_saq_files as $occupation_file_add_saq) {
                                                    ?>
                                                        <option value="<?= $occupation_file_add_saq->id ?>"><?= $occupation_file_add_saq->name ?></option>

                                                    <?php
                                                        $num++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!--<div class="col-6">-->
                                            <!--    <label>Name-->
                                            <!--        <span class="text-danger">*</span>-->
                                            <!--    </label>-->
                                            <input type="hidden" name="name" id="text_saq" class="form-control md-2" required>
                                            <input type="hidden" name="use_for" class="form-control md-2" value="saq_file">
                                            <!--</div>-->
                                            <div class="col-6">
                                                <label>File
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" name="file" id="file_saq" class="form-control md-2" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn_green_yellow">Save</button>
                                                <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal box for add end -->
                </div>
                <div class="tab-pane fade show <?= $app_act ?>" id="custom-tabs-application_kit" role="tabpanel" aria-labelledby="custom-tabs-application_kit-tab">
                    <div class="card-body">
                        <!--<div class="row card-header text-end">-->
                        <div class="text-end">
                            <a href="" data-bs-toggle="modal" data-bs-target="#add_file_app" class="btn btn_green_yellow" style="position: absolute; right: 250px; top: 75px;z-index:3">
                                <i class="bi bi-plus"></i>
                                ADD Applicant Kit
                            </a>
                        </div>
                        <!--</div>-->

                        <div class="row card-body">
                            <div class="col-12 table-responsive">

                                <table class="table table-striped datatable" id="application_table">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Occupation</th>
                                            <!--<th>Name</th>-->
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($offline_app_files as $offline_file_app) {
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= find_one_row('occupation_list', 'id', $offline_file_app->occupation_id)->name ?></td>
                                                <!--<td><?php // $offline_file_app->name 
                                                        ?></td>-->
                                                <td>
                                                    <?php $full_path = base_url($offline_file_app->path_text); ?>
                                                    <a href="<?= $full_path ?>">
                                                        <?= $offline_file_app->file_name ?>
                                                    </a>
                                                </td>
                                                <td>

                                                    <a href="" data-bs-toggle="modal" data-bs-target="#edit_app_form<?= $count ?>" class="btn btn-sm btn_green_yellow">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <a class="btn btn-sm btn-danger" onclick="delete_data(<?= $offline_file_app->id ?>)">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                            <!-- modal box for edit -->
                                            <div class="modal" id="edit_app_form<?= $count ?>">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Applicant Kit File</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" class="edit_data">
                                                                <div class="row">


                                                                    <div class="col-6">
                                                                        <label>Occupation
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select name="occupation" class="form-control md-2" id="occ_kit_edit">
                                                                            <option value="<?= $offline_file_app->occupation_id ?>"><?= find_one_row('occupation_list', 'id', $offline_file_app->occupation_id)->name ?></option>
                                                                            <?php
                                                                            $occupation_edit_app_files = occupation_saq_app_thir('application_kit');

                                                                            $num = 1;
                                                                            foreach ($occupation_edit_app_files as $occupation_file_edit_app) {
                                                                                if ($occupation_file_edit_app->id != $offline_file_app->occupation_id) {

                                                                            ?>
                                                                                    <option value="<?= $occupation_file_edit_app->id ?>"><?= $occupation_file_edit_app->name ?></option>

                                                                            <?php
                                                                                    $num++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <!--<div class="col-6">-->
                                                                    <!--    <label>Name-->
                                                                    <!--        <span class="text-danger">*</span>-->
                                                                    <!--    </label>-->
                                                                    <input type="hidden" name="name" class="form-control md-2" id="text_kit_edit" value="<?= $offline_file_app->name ?>">
                                                                    <input type="hidden" name="id" class="form-control md-2" value="<?= $offline_file_app->id ?>">
                                                                    <input type="hidden" name="use_for" class="form-control md-2" value="application_kit">

                                                                    <!--</div>-->
                                                                    <div class="col-6">
                                                                        <label>File
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="file" name="file" class="form-control md-2" id="file_kit_edit">
                                                                        <a href="<?= base_url($offline_file_app->path_text) ?>" target="_blank"><?= empty($offline_file_app->file_name) ?> <?php echo $offline_file_app->file_name ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="text-end">
                                                                        <button type="submit" class="btn btn_green_yellow">Save</button>
                                                                        <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal box for edit end -->

                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- modal box for add -->
                    <div class="modal" id="add_file_app">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Applicant Kit File </h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" class="add_data">
                                        <div class="row">
                                            <div class="col-6">
                                                <label>Occupation
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="occupation" class="form-control md-2" id="occ_kit" required>
                                                    <option></option>
                                                    <?php
                                                    $occupation_add_app_kit_files = occupation_saq_app_thir('application_kit');
                                                    $num = 1;
                                                    foreach ($occupation_add_app_kit_files as $occupation_file_add_kit) {
                                                    ?>
                                                        <option value="<?= $occupation_file_add_kit->id ?>"><?= $occupation_file_add_kit->name ?></option>

                                                    <?php
                                                        $num++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!--<div class="col-6">-->
                                            <!--    <label>Name-->
                                            <!--        <span class="text-danger">*</span>-->
                                            <!--    </label>-->
                                            <input type="hidden" name="name" id="text_kit" class="form-control md-2" required>
                                            <input type="hidden" name="use_for" class="form-control md-2" value="application_kit">
                                            <!--</div>-->
                                            <div class="col-6">
                                                <label>File
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="file" name="file" id="file_kit" class="form-control md-2" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn_green_yellow">Save</button>
                                                <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal box for add end -->
                </div>
                <div class="tab-pane fade show <?= $thir_act ?>" id="custom-tabs-third_party" role="tabpanel" aria-labelledby="custom-tabs-third_party-tab">
                    <div class="card-body">
                        <!--<div class="row card-header text-end">-->
                        <div class="text-end">
                            <a href="" data-bs-toggle="modal" data-bs-target="#add_file_thir" class="btn btn_green_yellow" style="position: absolute;
    right: 250px;
    top: 75px;z-index:3">
                                <i class="bi bi-plus"></i>
                                ADD Third Party Report
                            </a>
                        </div>
                        <!--</div>-->

                        <div class="row card-body">
                            <div class="col-12 table-responsive">

                                <table class="table table-striped datatable" id="third_table">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Occupation</th>
                                            <!--<th>Name</th>-->
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($offline_third_files as $offline_file_thir) {
                                        ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= find_one_row('occupation_list', 'id', $offline_file_thir->occupation_id)->name ?></td>
                                                <!--<td><?php // $offline_file_thir->name 
                                                        ?></td>-->
                                                <td><?= $offline_file_thir->file_name ?></td>
                                                <td>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#edit_third_form<?= $count ?>" class="btn btn-sm btn_yellow_green">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <a class="btn btn-sm btn-danger" onclick="delete_data(<?= $offline_file_thir->id ?>)">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                            <!-- modal box for edit -->
                                            <div class="modal" id="edit_third_form<?= $count ?>">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Third Party Report</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" class="edit_data">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <label>Occupation
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select name="occupation" class="form-control md-2" id="occ_party_edit">
                                                                            <option value="<?= $offline_file_thir->occupation_id ?>"><?= find_one_row('occupation_list', 'id', $offline_file_thir->occupation_id)->name ?></option>
                                                                            <?php
                                                                            $occupation_edit_third_files = occupation_saq_app_thir('third_party');
                                                                            $num = 1;
                                                                            foreach ($occupation_edit_third_files as $occupation_file_edit_third) {
                                                                                if ($occupation_file_edit_third->id != $offline_file_thir->occupation_id) {
                                                                            ?>
                                                                                    <option value="<?= $occupation_file_edit_third->id ?>"><?= $occupation_file_edit_third->name ?></option>

                                                                            <?php
                                                                                    $num++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <!--<div class="col-6">-->
                                                                    <!--    <label>Name-->
                                                                    <!--        <span class="text-danger">*</span>-->
                                                                    <!--    </label>-->
                                                                    <input type="hidden" name="name" class="form-control md-2" id="text_party_edit" value="<?= $offline_file_thir->name ?>">
                                                                    <input type="hidden" name="id" class="form-control md-2" value="<?= $offline_file_thir->id ?>">
                                                                    <input type="hidden" name="use_for" class="form-control md-2" value="third_party">
                                                                    <!--</div>-->

                                                                    <div class="col-6">
                                                                        <label>File
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="file" name="file" class="form-control md-2" id="file_party_edit">
                                                                        <a href="<?= base_url($offline_file_thir->path_text) ?>" target="_blank"><?= empty($offline_file_thir->file_name) ?> <?php echo $offline_file_thir->file_name ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="text-end">
                                                                        <button type="submit" class="btn btn_green_yellow">Save</button>
                                                                        <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal box for edit end -->

                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal box for add -->
                <div class="modal" id="add_file_thir">
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add Third Party Report </h4>
                            </div>
                            <div class="modal-body">
                                <form action="" class="add_data">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Occupation
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="occupation" class="form-control md-2" required id="occ_party">
                                                <option></option>
                                                <?php
                                                $occupation_edit_thir_files = occupation_saq_app_thir('third_party');
                                                $num = 1;
                                                foreach ($occupation_edit_thir_files as $occupation_file_edit_thir) {
                                                ?>
                                                    <option value="<?= $occupation_file_edit_thir->id ?>"><?= $occupation_file_edit_thir->name ?></option>

                                                <?php
                                                    $num++;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!--<div class="col-6">-->
                                        <!--    <label>Name-->
                                        <!--        <span class="text-danger">*</span>-->
                                        <!--    </label>-->
                                        <!--    <input type="text" name="name"  id="text_party" class="form-control md-2" required>-->
                                        <input type="hidden" name="use_for" class="form-control md-2" value="third_party">
                                        <!--</div>                    -->
                                        <div class="col-6">
                                            <label>File
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" name="file" id="file_party" class="form-control md-2" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn_green_yellow">Save</button>
                                            <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal box for add end -->
            </div>
        </div>
    </section>
</main>



<?= $this->endSection() ?>
<?= $this->section("custom_script") ?>
<script>
    var tab = '<?= $tab ?>';

    function clear_model_box() {
        console.log("hfhf");
        window.location = "<?= base_url("admin/offline_files") ?>/" + tab;
    }

    $(".add_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/offline_files/insert") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    window.location = "<?= base_url("admin/offline_files") ?>/" + tab;

                } else {
                    console.log(res);
                }
            }
        });
    });

    $(".edit_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/offline_files/update") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data["response"] == true) {
                    window.location = "<?= base_url("admin/offline_files") ?>/" + tab;
                } else {
                    alert(data["msg"]);
                }
            }
        });
    });

    function delete_data(id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $.ajax({
                    url: "<?= base_url("admin/offline_files/delete") ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data["response"] == true) {
                            window.location = "<?= base_url("admin/offline_files") ?>/" + tab;
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        })
    }
    $(document).ready(function() {
        $('#offline_files_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }

        });
    });





    $(document).ready(function() {
        $('#application_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });




    $(document).ready(function() {
        $('#third_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
</script>
<?= $this->endSection() ?>
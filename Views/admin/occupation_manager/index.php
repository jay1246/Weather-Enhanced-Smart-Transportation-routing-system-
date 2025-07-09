<?= $this->extend('template/admin_template') ?>

<?= $this->section('main') ?>
<main id="main" class="main">

    <div class="pagetitle">
        <h4 class="text-green">Occupation Manager</h4>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Add Occupation Modal -->
                    <!--<div class="row card-header text-end">-->
                    <!--    <div class="text-end">-->
                    <!--        <a href="" data-bs-toggle="modal" data-bs-target="#add_form" class="btn btn_green_yellow">-->
                    <!--            <i class="bi bi-plus"></i>-->
                    <!--            Add Occupation-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="modal" id="add_form">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center text-green">Add Occupation</h5>
                                </div>
                                <div class="modal-body">
                                    <form class="add_data" action="" method="post" id="add_data">
                                        <div class="row">
                                            <div class="col-6">
                                                <label>Occupation <span class="text-danger">*</span></label>
                                                <input name="name" type="text" class="form-control mb-2" required>
                                            </div>
                                            <div class="col-6">
                                                <label>Occupation Code <span class="text-danger">*</span></label>
                                                <input name="number" type="text" class="form-control mb-2" required>

                                            </div>
                                            <div class="col-6">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select class="form-select mb-3" aria-label="Default select example" name="status">
                                                    <option selected value="active">Active</option>
                                                    <option value="in_active">In Active</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="text-end">
                                                <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                                <button type="submit" class="btn btn_green_yellow">Add</button>

                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Occupation Modal-->

                    <div class="table table-responsive">

                        <!--  Table with stripped rows starts -->
                            <a href="" style="position: absolute;
    right: 270px;
    top: 24px;
    z-index: 3;" data-bs-toggle="modal" data-bs-target="#add_form" class="btn btn_green_yellow">
                                <i class="bi bi-plus"></i>
                                Add Occupation
                            </a>
                        <table id="staff_table" class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Occupation Name</th>
                                    <th> Number Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($occupations as $occupation) { ?>
                                    <tr>
                                        <th><?= $count ?></th>
                                        <td> <?= $occupation->name ?> </td>
                                        <td> <?= $occupation->number ?> </td>
                                        <td>

                                            <?php
                                            if ($occupation->status == "active") {
                                                $btn_class = "btn_green_yellow";
                                                $status = "Active";
                                            } else {
                                                $btn_class = "btn-danger";
                                                $status = "In Active";
                                            }
                                            ?>
                                            <a onclick="status_data(<?= $occupation->id ?>)" class="btn btn-sm <?= $btn_class ?>"><?= $status ?></a>

                                        </td>
                                        <td>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>
                                            <?php
                                            $occupation_dete = find_one_row('stage_1_occupation', 'occupation_id', $occupation->id);
                                            if (!empty($occupation_dete)) {
                                                $dele_class = "disabled";
                                            } else {
                                                $dele_class = " ";
                                            }
                                            ?>
                                            <a onclick="delete_data(<?= $occupation->id ?>)" class="btn btn-sm btn-danger <?= $dele_class ?>"> <i class="bi bi-trash-fill"></i></a>
                                        </td>

                                    </tr>
                                    <!-- modal box for edit -->
                                    <div class="modal" id="edit_form<?= $count ?>">
                                        <div class="modal-dialog  modal-lg">
                                            <div class="modal-content" style="background-color: white;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center text-green">Edit Occupation</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="edit_data" action="" method="post" id="edit_data">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>Occupation <span class="text-danger">*</span></label>
                                                                <input name="name" type="text" class="form-control mb-2" value="<?= $occupation->name ?>">
                                                                <input type="hidden" name="id" value="<?= $occupation->id ?>">
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Occupation Code <span class="text-danger">*</span></label>
                                                                <input name="number" type="text" class="form-control mb-2" value="<?= $occupation->number ?>">

                                                            </div>
                                                            <div class="col-6">
                                                                <label>Status <span class="text-danger">*</span></label>
                                                                <select class="form-select mb-3" aria-label="Default select example" name="status">
                                                                    <?php
                                                                    if ($occupation->status == 'active') {
                                                                    ?>
                                                                        <option selected value="active">Active</option>
                                                                        <option value="in_active">In Active</option>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <option value="active">Active</option>
                                                                        <option selected value="in_active">In Active</option>
                                                                    <?php
                                                                    } ?>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn_yellow_green" onclick="clear_model_box()">Close</button>
                                                                <button type="submit" class="btn btn_green_yellow">Update</button>

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
                                }  ?>

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
    function clear_model_box() {
        console.log("hfhf");
        window.location = "<?= base_url("admin/occupation_manager") ?>";
    }
    $(document).ready(function() {
        $('#staff_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            },
            columnDefs: [
              {
                width: "08%",
                targets: 4,
                orderable: false,
              },
            ],
            
        });
    });

    $("#add_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/occupation_manager/insert") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    window.location = "<?= base_url("admin/occupation_manager") ?>"
                } else {
                    console.log(res);
                }
            }
        });
    });

    $("#edit_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/occupation_manager/update") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    window.location = "<?= base_url("admin/occupation_manager") ?>";
                } else {
                    alert(data["msg"]);
                }
            }
        });
    });

    function delete_data(id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this Occupation?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
        $("#delete_pop_btn").click(function() {
            if (custom_alert_popup_close('delete_pop_btn')) {
                // if (confirm("Are you sure you want to delete this Occupation?")) {  
                $.ajax({
                    url: "<?= base_url("admin/occupation_manager/delete") ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data["response"] == true) {
                            window.location = "<?= base_url("admin/occupation_manager") ?>";
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        });
    }

    function status_data(id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to change the status?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
        $("#delete_pop_btn").click(function() {
            if (custom_alert_popup_close('delete_pop_btn')) {

                // if (confirm("Are you sure you want to change the status?")) {  
                $.ajax({
                    url: "<?= base_url("admin/occupation_manager/status") ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data["response"] == true) {
                            window.location = "<?= base_url("admin/occupation_manager") ?>";
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
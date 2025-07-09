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
        <h4 class="text-green">Staff Management</h4>
    </div><!-- End Page Title -->

    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow p-0">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <?php
                        if ($tab == "aqato") {
                            // 
                            $aqato__class = "active active_btn";
                            $attc__class = "";
                        } else {
                            // 
                            $aqato__class = "";
                            $attc__class = "active active_btn";
                            
                        }
                    ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $aqato__class ?>" id="custom-tabs-agent-tab" href="<?= base_url("admin/staff_management/aqato") ?>" role="tab" aria-controls="custom-tabs-agent" aria-selected="false">AQATO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $attc__class ?>" id="custom-tabs-applicant-tab" href="<?= base_url("admin/staff_management/attc") ?>" role="tab" aria-controls="custom-tabs-applicant" aria-selected="true">ATTC</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="modal" id="add_form">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center text-green">Add Staff</h5>
                                </div>
                                <div class="modal-body">
                                    <form class="add_data" action="" method="post">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row g-0">
                                                    <div class="col-2">
                                                        <label class="ml-1">Inital</label>
                                                        <input name="inital_name" type="text" class="form-control mb-2" required>
                                                    </div>
                                                    <div class="col-10">
                                                        <label>First Name <span class="text-danger">*</span></label>
                                                        <input name="first_name" type="text" class="form-control mb-2" required>  
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label>Middle Name</label>
                                                <input name="middle_name" type="text" class="form-control mb-2">
                                            </div>

                                            <div class="col-6">

                                                <label>Last Name <span class="text-danger">*</span></label>
                                                <input name="last_name" type="text" class="form-control mb-2" required>
                                            </div>

                                            <div class="col-6">
                                                <label>Mobile No</label>
                                                <div class="input-group mb-2">
                                                    <select class="input-group-text" name="mobile_code" style="width: 150px;">
                                                        <?php $aus_code = find_one_row('country', 'name', 'Australia');
                                                        ?>
                                                        <option value="<?= $aus_code->id ?>"><?= $aus_code->name . "(" . $aus_code->phonecode . ")" ?></option>
                                                        <?php
                                                        foreach ($countries as $country) {
                                                            // echo $country->id;
                                                            // exit;
                                                            if ($aus_code->id != $country->id) {
                                                        ?>
                                                                <option value="<?= $country->id ?>"><?= $country->name . "(" . $country->phonecode . ")" ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input name="mobile_no" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input name="email" type="email" class="form-control mb-2" autocomplete="false" required>
                                            </div>

                                            <div class="col-6">
                                                <label>Password <span class="text-danger">*</span></label>
                                                <div class="input-group mb-3">
                                                    <input name="password" type="password" class="form-control mb-2" autocomplete="false" id="password-0" required />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" onclick="password_show_hide(0);">
                                                            <i class="bi bi-eye-fill eye-open-click" id="show_eye-0"></i>
                                                            <i class="bi bi-eye-slash-fill eye-open-click d-none" id="hide_eye-0"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label>User Role <span class="text-danger">*</span></label>
                                                <select class="form-select mb-3" aria-label="Default select example" name="account_type">
                                                    <option value="admin">Admin</option>
                                                    <option selected value="head_office">Head Office</option>
                                                </select>
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
                    <!-- End Add Staff Modal-->

                    <div class="table table-responsive">

                        <!--  Table with stripped rows starts -->
                            <a href="" style="position: absolute;
    right: 270px;
    top: 61px;
    z-index: 3;" data-bs-toggle="modal" data-bs-target="#add_form" class="btn btn_green_yellow">
                                <i class="bi bi-plus"></i>
                                Add Staff
                            </a>
                        <table id="staff_table" class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Full Name </th>
                                    <th>Email-Id</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($staffs as $staff) { ?>
                                    <tr>
                                        <th><?= $count ?></th>
                                        <td><?= $staff->first_name . " " . $staff->middle_name . " " . $staff->last_name ?></td>
                                        <td><?= $staff->email ?></td>

                                        <td>
                                            <?php
                                            if ($staff->status == "active") {
                                                $btn_class = "btn_green_yellow";
                                                $status = "Active";
                                            } else {
                                                $btn_class = "btn-danger";
                                                $status = "In Active";
                                            }
                                            ?>
                                            <a onclick="status_data(<?= $staff->id ?>)" class="btn btn-sm <?= $btn_class ?>" style="width: 35%;"><?= $status ?></a>

                                        </td>

                                        <td>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>

                                            <a onclick="delete_data(<?= $staff->id ?>)" class="btn btn-sm btn-danger"> <i class="bi bi-trash-fill"></i></a>
                                        </td>

                                    </tr>

                                    <!-- modal box for edit -->
                                    <div class="modal" id="edit_form<?= $count ?>">
                                        <div class="modal-dialog  modal-lg">
                                            <div class="modal-content" style="background-color: white;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center text-green">Edit Staff</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="edit_data" action="" method="post">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="row g-0">
                                                                    <div class="col-2">
                                                                        <label class="ml-1">Inital</label>
                                                                        <input name="inital_name" type="text" class="form-control mb-2" required value="<?= $staff->inital_name ?>">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <label>First Name <span class="text-danger">*</span></label>
                                                                        <input name="first_name" type="text" class="form-control mb-2" value="<?= $staff->first_name ?>">
                                                                        <input type="hidden" name="id" class="form-control mb-2" value="<?= $staff->id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="col-6">
                                                                <label>Middle Name</label>
                                                                <input name="middle_name" type="text" class="form-control mb-2" value="<?= $staff->middle_name ?>">
                                                            </div>

                                                            <div class="col-6">

                                                                <label>Last Name <span class="text-danger">*</span></label>
                                                                <input name="last_name" type="text" class="form-control mb-2" value="<?= $staff->last_name ?>">
                                                            </div>

                                                            <div class="col-6">
                                                                <label>Mobile No</label>
                                                                <div class="input-group  mb-2">
                                                                    <select class="input-group-text" name="mobile_code" style="width: 150px;">
                                                                        <?php $aus_code = find_one_row('country', 'id', $staff->mobile_code); 
                                                                        // print_r($aus_code);
                                                                        // exit;
                                                                        if($aus_code){
                                                                        ?>
                                                                        <option value="<?= $aus_code->id ?>"><?= $aus_code->name . "(" . $aus_code->phonecode . ")" ?></option>
                                                                        <?php
                                                                        }
                                                                        //End of IF
                                                                        
                                                                        foreach ($countries as $country) {
                                                                            if ($aus_code->id != $country->id) {
                                                                        ?>
                                                                                <option value="<?= $country->id ?>"><?= $country->name . "(" . $country->phonecode . ")" ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <input name="mobile_no" type="text" class="form-control" value="<?= $staff->mobile_no ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <label>Email <span class="text-danger">*</span></label>
                                                                <input name="email" type="email" class="form-control mb-2" autocomplete="false" value="<?= $staff->email ?>">
                                                            </div>


                                                            <div class="col-6">
                                                                <label>Password <span class="text-danger">*</span></label>
                                                                <div class="input-group mb-3">
                                                                    <input name="password" type="password" class="form-control mb-2" autocomplete="false" id="password-<?= $count ?>" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text" onclick="password_show_hide(<?= $count ?>);">
                                                                            <i class="bi bi-eye-fill eye-open-click" id="show_eye-<?= $count ?>"></i>
                                                                            <i class="bi bi-eye-slash-fill eye-open-click d-none" id="hide_eye-<?= $count ?>"></i>
                                                                        </span>
                                                                    </div>
                                                                    <p class="my-0 text-danger">As New Security added so only change of password is possible</p>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <label>User Role <span class="text-danger">*</span></label>
                                                                <select class="form-select mb-3" aria-label="Default select example" name="account_type">
                                                                    <?php
                                                                    if ($staff->account_type == 'admin') {
                                                                    ?>
                                                                        <option selected value="admin">AQATO</option>
                                                                        <option value="head_office">ATTC</option>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <option selected value="head_office">ATTC</option>
                                                                        <option value="admin">AQATO</option>
                                                                    <?php
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Status <span class="text-danger">*</span></label>
                                                                <select class="form-select mb-3" aria-label="Default select example" name="status">
                                                                    <?php
                                                                    if ($staff->status == 'active') {
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

    function clear_model_box() {
        console.log("hfhf");
        location.reload();
        // window.location = "<= base_url("admin/staff_management") ?>";
    }

    $(".add_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/staff_management/insert") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    location.reload();
                    // window.location = "<= base_url("admin/staff_management") ?>"
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
            url: "<?= base_url("admin/staff_management/update") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    location.reload();
                    // window.location = "<?= base_url("admin/staff_management") ?>";
                } else {
                    alert(data["msg"]);
                }
            }
        });
    });

    function delete_data(id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this account?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
        $("#delete_pop_btn").click(function() {
            if (custom_alert_popup_close('delete_pop_btn')) {

                // if (confirm("Are you sure you want to delete this account?")) {  
                $.ajax({
                    url: "<?= base_url("admin/staff_management/delete") ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data["response"] == true) {
                            location.reload();
                            // window.location = "<= base_url("admin/staff_management") ?>";
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
                    url: "<?= base_url("admin/staff_management/status") ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data["response"] == true) {
                            location.reload();
                            // window.location = "<= base_url("admin/staff_management") ?>";
                        } else {
                            alert(data["msg"]);
                        }
                    },
                });
            }
        });
    }

    function password_show_hide(num) {
        var x = document.getElementById("password-" + num);
        var show_eye = document.getElementById("show_eye-" + num);
        var hide_eye = document.getElementById("hide_eye-" + num);
        hide_eye.classList.remove("d-none");
        // console.log(num);
        // console.log(x);
        // console.log(show_eye);
        // console.log(hide_eye);
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }
</script>

<?= $this->endSection() ?>
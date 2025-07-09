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
        <h4 class="text-green">Locations</h4>
    </div><!-- End Page Title -->

    <section class="section dashboard mt-3 shadow">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 border-bottom-0">
                <?php
                if ($tab == "interview_location") {
                    $pratical_class = "";
                    $interview_class = "active";
                } else {
                    $interview_class = "";
                    $pratical_class = "active";
                }
                ?>
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                    <li class="nav-item">
                        <a class="  nav-link <?=  $interview_class ?>" id="custom-tabs-agent-tab" href="<?= base_url("admin/location/interview_location") ?>" role="tab" aria-controls="custom-tabs-agent" aria-selected="true">Interview</a>
                    </li>
                    <li class="nav-item">
                        <a class="  nav-link <?=$pratical_class ?>" id="custom-tabs-applicant-tab" href="<?= base_url("admin/location/pratical") ?>" role="tab" aria-controls="custom-tabs-applicant" aria-selected="false">Pratical</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show <?= $interview_class ?>" id="custom-tabs-applicant" role="tabpanel" aria-labelledby="custom-tabs-applicant-tab">
            
                    <div class="card-body">
                        <div class="table table-responsive">

                            <!--  Table with stripped rows starts -->

                            <table id="interview_table" class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>City </th>
                                        <th>Country</th>
                                        <th>Venue</th>
                                        <th>Address</th>
                                        <?php 
                                        if(session()->get('admin_id') == '1'){
                                        ?>
                                        <th>Action</th>
                                        <?php 
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($interview_locations as $location) { ?>
                                        <tr>
                                            <th><?= $count ?></th>
                                            <td> <?= $location->city_name ?> </td>
                                            <td> <?= $location->country ?> </td>
                                            <td> <?= $location->venue ?> </td>
                                            <td> <?= $location->office_address ?> </td>
                                            <?php 
                                        if(session()->get('admin_id') == '1'){
                                        ?>
                                            <td>
                                                <?php 
                                                if(session()->get('admin_id') == '1'){
                                                ?>
                                                <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>
                                                <?php 
                                                }
                                                ?>
                                            </td>
                                        <?php 
                                        }
                                        ?>
                                        </tr>

                                        <!-- modal box for edit -->
                                        <div class="modal" id="edit_form<?= $count ?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center text-green">Interview Location Change</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!--<form class="quali_verify_form"  id="quali_verify_form" action="" method="post" enctype="multipart/form-data">-->
                                                        <form class="edit_data" action="" method="post" enctype="multipart/form-data">
                                                            <div class="mb-3 row">
                                                                <label for="Name" class="col-sm-2"><strong>City</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="city_name" value="<?= $location->city_name ?>" class="form-control" id="Name" required>
                                                                    <input type="hidden" name="id" value="<?= $location->id ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="country" class="col-sm-2"><strong>Country</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <select class="form-select" name="country" id="country" aria-label="Default select example">
                                                                        <option disabled selected> Select City</option>
                                                                        <?php foreach ($countries as $country) { ?>
                                                                            <?php if ($location->country ==  $country->name) { ?>
                                                                                <option value="<?= $country->name ?>" selected> <?= $country->name ?> </option>
                                                                            <?php } else { ?>
                                                                                <option value="<?= $country->name ?>"> <?= $country->name ?> </option>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="venue" class="col-sm-2"><strong>Venue</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="venue" value="<?= $location->venue ?>" class="form-control" id="venue" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="email" class="col-sm-2"><strong>Email</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="email" value="<?= $location->email ?>" class="form-control" id="email" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="email_cc" class="col-sm-2"><strong>CC - Email ID </strong></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="email_cc" id="email_cc"  value="<?=$location->email_cc?>"  style="margin-right: 20px;" class="form-control">
                                                                    <?php
                                                                    // $list_email_cc =   explode(", ",$location->email_cc);
                                                                    // $count_cc = 50;
                                                                    // foreach($list_email_cc as $email_cc){
                                                                     ?>
                                                                    <!--<div id="wrapper-<=$count_cc?>" class="input-group mb-2" >-->
                                                                    <!--    <input type="email" name="email_cc[]" id="email_cc"  value="<=$email_cc?>"  style="margin-right: 20px;" class="form-control">-->
                                                                        <?php
                                                                        // if($count_cc == 50){
                                                                            ?>
                                                                            <!--<div>-->
                                                                            <!--    <button type="button" onclick="add_more_input_('add_more_input_for_multiple_<= $count ?>')" class="btn btn_yellow_green add_button ml-3">-->
                                                                            <!--        <i class="bi bi-plus-lg"></i>-->
                                                                            <!--    </button>-->
                                                                            <!--</div>-->
                                                                        <?php
                                                                        // }else{
                                                                            ?>
                                                                            <!--<div>-->
                                                                            <!--    <button type="button" onclick="cancel('wrapper-<=$count_cc?>')" class="btn btn-danger delete_button ml-3">-->
                                                                            <!--        <i class="bi bi-x-lg"></i>-->
                                                                            <!--    </button>-->
                                                                            <!--</div>-->
                                                                        <?php
                                                                        // }
                                                                        ?>
                                                                    <!--</div>-->
                                                                    <?php
                                                                    // $count_cc++;
                                                                    // }
                                                                    ?>
                                                                    <!--<div id="add_more_input_for_multiple_<?= $count ?>" class="add_more_input_for_multiple">-->
                                                                    <!--</div>-->
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="mb-3 row">
                                                                <label for="office_address" class="col-sm-2"><strong>Address</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="office_address" id="office_address" rows="3"><?= $location->office_address ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="contact_details" class="col-sm-2"><strong>Contact Details</strong></label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="contact_details" id="contact_details" rows="3"><?= $location->contact_details ?></textarea>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                            $session = session();
                                                            
                                                            if($session->admin_id == 1 && $location->venue == "AQATO"):
                                                            ?>
                                                            <div class="mb-3 row">
                                                                <label for="cost" class="col-sm-2"><strong>Cost</strong></label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="cost" id="cost" rows="3"><?= $location->cost ?></textarea>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                            endif;
                                                            ?>
                                                            <div class="row">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>
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
                <div class="tab-pane fade show <?= $pratical_class ?>" id="custom-tabs-agent" role="tabpanel" aria-labelledby="custom-tabs-agent-tab">
                    <div class="card-body">
                        <div class="table table-responsive">

                            <!--  Table with stripped rows starts -->

                            <table id="interview_table" class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>City </th>
                                        <th>Country</th>
                                        <th>Venue</th>
                                        <th>Address</th>
                                        <?php 
                                        if(session()->get('admin_id') == '1'){
                                        ?>
                                        <th>Action</th>
                                        <?php 
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($praticals as $pratical) { ?>
                                        <tr>
                                            <th><?= $count ?></th>
                                            <td> <?= $pratical->city_name ?> </td>
                                            <td> <?= $pratical->country ?> </td>
                                            <td> <?= $pratical->venue ?> </td>
                                            <td> <?= $pratical->office_address ?> </td>
                                            
                                            <?php 
                                            if(session()->get('admin_id') == '1'){
                                            ?>
                                            <td>
                                                <a href="" data-bs-toggle="modal" data-bs-target="#edit_pratical<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>

                                            </td>
                                            <?php 
                                            }
                                            ?>

                                        </tr>

                                        <!-- modal box for edit -->
                                        <div class="modal" id="edit_pratical<?= $count ?>">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content" style="background-color: white;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center text-green">Interview pratical Change</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="edit_data" action="" method="post">
                                                            <input type="hidden" name="id" value="<?= $pratical->id ?>">
                                                            <div class="mb-3 row">

                                                                <label for="Name" class="col-sm-2"><strong>City</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="city_name" value="<?= $pratical->city_name ?>" class="form-control" id="Name">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="country" class="col-sm-2"><strong>Country</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <select class="form-select" name="country" id="country" aria-label="Default select example">
                                                                        <option disabled selected> Select City</option>
                                                                        <?php foreach ($countries as $country) { ?>
                                                                            <?php if ($pratical->country ==  $country->name) { ?>
                                                                                <option value="<?= $country->name ?>" selected> <?= $country->name ?> </option>
                                                                            <?php } else { ?>
                                                                                <option value="<?= $country->name ?>"> <?= $country->name ?> </option>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="venue" class="col-sm-2"><strong>Venue</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="venue" value="<?= $pratical->venue ?>" class="form-control" id="venue">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="venue" class="col-sm-2"><strong>Email</strong></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="email" value="<?= $pratical->email ?>" class="form-control" id="email">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mb-3 row">
                                                                <label for="office_address" class="col-sm-2"><strong>Address</strong> <span class="text-danger">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="office_address" id="office_address" rows="3"><?= $pratical->office_address ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="contact_details" class="col-sm-2"><strong>Contact Details</strong></label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" name="contact_details" id="contact_details" rows="3"><?= $pratical->contact_details ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>
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

<div id="cover-spin">
    <div id="loader_img">
        <img src="<?= base_url("public/assets/image/admin/loader.gif") ?>" style="width: 100px; height:auto">
    </div>
</div>

</main>



<?= $this->endSection() ?>
<!---------- custom_script -->
<?= $this->section('custom_script') ?>
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
    $(document).ready(function() {
        $('#interview_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }

        });
    });

    $(".edit_data").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
    
        // var emailCCFields = form.find("input[name='email_cc[]']");
        // var emailCCValues = [];
        // emailCCFields.each(function(index, element) {
        //     emailCCValues.push(element.value);
        // });
    
        // Add the dynamically created email_cc values to the form data
        // formData.append("email_cc", emailCCValues.join(", "));
    
        $('#cover-spin').show();
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/location/update") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    $('#cover-spin').hide();
                    window.location.reload();
                } else {
                    $('#cover-spin').hide();
                    alert(data["msg"]);
                }
            }
        });
    });

    // function update_details(id){
    //     var form = document.getElementById(id);
    //     var formData = new FormData(form);
    //     $('#cover-spin').show();
    //     $.ajax({
    //         method: "POST",
    //         url: "<?= base_url("admin/location/update") ?>",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(res) {
    //             res = JSON.parse(res);
    //             if (res) {
    //                 // window.location = "?= base_url("admin/location/") ?>";
    //                 $('#cover-spin').hide();
    //                 window.location.reload();
    //             } else {
    //                 $('#cover-spin').hide();
    //                 alert(data["msg"]);
    //             }
    //         }
    //     });
    // }

    
    var count = 0;
    function add_more_input_(div_id) {
        var data = `<div id="wrapper-${div_id}-${count}" class="row mb-2"> 
                        <div class="col-11">
                            <input type="email" name="email_cc[]" class="form-control">
                        </div>
                        <div class="col-1">
                            <button type="button" onclick="cancel('wrapper-${div_id}-${count}')" class="btn btn-danger delete_button float-end">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>`;

        count++;
        $("#" + div_id).prepend(data);
    }
    function cancel(id){
        var div = document.getElementById(id);
        div.parentNode.removeChild(div);

    }
    
</script>

<?= $this->endSection() ?>
<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<style>
    label {
        margin-bottom: 0px !important;
        margin-bottom: 1px !important;
    }
</style>

<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Stage 2 - Documentary Evidence <?= helper_get_applicant_full_name($ENC_pointer_id); ?>
    </b>
</div>

<!-- start -->
<div class="container-fluid mt-4 mb-4">
    <div class="row">

        <!-- center div  -->
        <div class="col-md-12 bg-white shadow pb-0 p-0">

            <!-- sub tital  -->
            <div class="row p-2">
                <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                    Add Employment Details
                </h5>
                <!-- <div class="col-md-6 text-green" style="font-size: 23px;">
                    Add Employment Details
                </div> -->
                <div class="text-end"> Application No. : <?= $Unique_number ?></div>
            </div>


            <!-- Alert on set - Flashdata -->
            <?= $this->include("alert_box.php") ?>

            <!-- Instructions  -->
            <div class="col-lg-12 bg-warning rounded p-2">
                <h4 class="">Instructions :</h4>
                <ul>
                    <li class="">Only include Employment related to your nominated occupation</li> <!-- 29-Aug-2022 / vishal h patel  -->
                    <li class="">Only include Employment for which you will be submitting supporting documents.</li> <!-- 29-Aug-2022 / vishal h patel  -->
                </ul>
            </div>

            <!-- form start  -->
            <div class="bg-light p-4">
                <form id="add_employers_form" class="row" action="<?= base_url('user/stage_2_add_employment_/' . $ENC_pointer_id) ?>" method="post">

                    <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>">

                    <div class="col-md-6">
                        <label for="Name" class="form-label"> Company/Organisation Name <span style="color:red">*</span></label>
                        <input type="text" onchange="check_company_availebal()" class="form-control" name="company_organisation_name" id="Company_Name" value="" required />
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label"> Employment Type <span style="color:red">*</span> </label> <!-- 29-Aug-2022 / vishal h patel  -->
                        <!--<select class="form-select mb-3" aria-label="Default select example" name="employment_type" id="type_drop" required="">-->
                        <!--    <option disabled="" selected="">Select</option>-->
                        <!--    <option selected="">Full time</option>-->
                        <!--    <option>Part time</option>-->
                        <!--    <option> Casual</option>-->
                        <!--    <option>Self employed</option>-->
                        <!--</select>-->
                         <select class="form-select mb-3" aria-label="Default select example" name="employment_type" id="type_drop" required="">
                            <option selected="" value="">Select</option>
                            <option >Full time/ Part time/ Casual </option>
                            <!--<option>Part time</option>-->
                            <!--<option> Casual</option>-->
                            <option>Self employed</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="Name" class="form-label"> Referee Name <span style="color:red">*</span> </label> <!-- 29-Aug-2022 / vishal h patel  -->
                        <input type="text" class="form-control" name="referee_name" id="Assessment" value="" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" style="">
                            Referee Contact No.<span class="text-danger">*</span>
                        </label>
                        <br>
                        <div class="row">
                            <div class="col-sm-5" style="padding-right:0px;">
                                <select onchange="upload_auto(this.form)" class="form-control txbox" id="mobile_code_refry1" required name="referee_mobile_number_code">
                                    <option selected disabled value="">Select Country Code</option>
                                    <?php foreach ($country_TB as $key => $value) {
                                        $selected = "";
                                        if ($value['id'] == 13) {
                                            $selected = "selected";
                                        }
                                    ?>
                                        <option <?= $selected ?> value="<?= $value['id'] ?>"> <?= $value['name'] ?> (+<?= $value['phonecode'] ?>) </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-7">
                                <input type="number" class="form-control txbox" name="referee_mobile_number" id="mobile_no" value="" required />
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 mt-3">
                        <label for="Name" class="form-label">Referee Email <span style="color:red">*</span> </label> <!-- 29-Aug-2022 / vishal h patel  -->
                        <input type="email" class="form-control" onclick="aler_onemail()" name="referee_email" id="Referee_Email" value="" required="" onchange="validEmailCheck(this)" />
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="Name" class="form-label">Confirm Referee Email <span style="color:red">*</span> </label> <!-- 29-Aug-2022 / vishal h patel  -->
                        <input type="email" onchange="checkemail(this)" class="form-control" name="Confirm_referee_email" id="Confirm_Email" value="" onpaste="return false;" ondrop="return false;" autocomplete="off" required />
                        <span style="color: red;" id="Referee_Email_alert"></span>
                    </div>

                    <script>
                        function aler_onemail() {
                            return;
                            var A = document.getElementById('Referee_Email').value;
                            if (A == "") {
                                // creat alert box 
                                custom_alert_popup_show(header = '', body_msg = "Kindly ensure the email address is correct. Incorrect emails can lead to delays in application processing.", close_btn_text = 'Ok', close_btn_css = 'btn_green_yellow', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                                // // check Btn click
                                // $("#AJDSAKAJLD").click(function() {
                                //     // if return true 
                                //     if (custom_alert_popup_close('AJDSAKAJLD')) {

                                //     }
                                // });
                                // confirm('Kindly ensure the email address is correct. Incorrect emails can lead to delays in application processing.');
                            }
                        }
                        var email_error = false;

                        function validEmailCheck(input) {
                            document.getElementById("Confirm_Email").value = "";
                            $(input).next().remove();
                            if (input.value != "") {
                                var validRegex = /\S+@\S+\.\S+/;
                                if (input.value.match(validRegex)) {
                                    $(input).css("border", "1px solid #ced4da");
                                    $(input).next().remove();
                                    var email_error = false;
                                    $("#Confirm_Email").prop('disabled', false);
                                    // document.getElementById("Confirm_Email").disabled = false;
                                    // document.getElementById("add_employers_form_submit_btn").disabled = false;
                                } else {
                                    $(input).css("border", "1px solid red");
                                    $(input).after(`<span style="color: red;">Invalid Email !</span>`);
                                    email_error = true;
                                    $("#Confirm_Email").prop('disabled', true);
                                    // document.getElementById("add_employers_form_submit_btn").disabled = false;

                                    // document.getElementById("Confirm_Email").disabled = true;
                                }
                            } else {
                                $(input).css("border", "1px solid #ced4da");
                                $(input).next().remove();
                                document.getElementById('Confirm_Email').value = "";
                            }
                            checkemail(document.getElementById("Confirm_Email"));
                        }

                        function checkemail(that) {
                            var A = document.getElementById('Referee_Email').value;
                            var B = document.getElementById('Confirm_Email').value;
                            if (B == "") {
                                document.getElementById("Referee_Email_alert").innerHTML = "";
                                $(that).css("border", "1px solid #ced4da");
                                return;
                            }
                            if (A != "") {
                                if (A != B) {
                                    document.getElementById("Referee_Email_alert").innerHTML = "Email did not match !";
                                    email_error = true;
                                    $(that).css("border", "1px solid red");
                                } else {
                                    email_error = false;
                                    document.getElementById("Referee_Email_alert").innerHTML = "";
                                    $(that).css("border", "1px solid #198754");
                                }
                            } else {
                                document.getElementById("Referee_Email_alert").innerHTML = "";
                                $(that).css("border", "1px solid #ced4da");
                            }
                        }
                        $(document).ready(function() {
                            new TomSelect("#mobile_code_refry", {
                                plugins: ['dropdown_input'],
                            });
                        });
                    </script>

                    <div class="col-md-12" style="text-align: center;">
                        <button id="add_employers_form_submit_btn" class="btn btn_green_yellow" style="margin-top: 30px;">Add</button>
                        <b>
                            <label for="Name" class="form-label " style="margin-top: 30px;color:red" id="company_alert"></label> <!-- 29-Aug-2022 / vishal h patel  -->
                        </b>
                    </div>

                </form><!-- End Multi Columns Form -->
            </div>

            <!-- list  -->
            <div class="col-lg-12  p-2">
                <?php if (count($add_employment_TB) > 0) { ?>
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Company / Organisation Name</th>
                                <th>Employment Type</th>
                                <th>Referee Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                            foreach ($add_employment_TB as $key => $value) {
                                $i++; ?>
                                <tr id="tr_<?= $value['id'] ?>">
                                    <th scope="row">
                                        <?= $i ?>
                                    </th>
                                    <td>
                                        <?= $value['company_organisation_name'] ?>
                                    </td>
                                    <td>
                                        <?= $value['employment_type'] ?>
                                    </td>
                                    <td>
                                        <?= $value['referee_email'] ?>
                                    </td>
                                    <td>
                                        <!-- Eddit btn trigger modal -->
                                        <button type="button" class="btn btn_green_yellow btn-sm" data-bs-toggle="modal" data-bs-target="#modal_<?= $i ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal_<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg ">
                                                <div class="modal-content">
                                                    <form id="edite_employe_info" class="row p-3" action="<?= base_url('user/stage_2_edite_employment_/' . $ENC_pointer_id) ?>" method="post">
                                                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>">
                                                        <input type="hidden" name="employe_id" value="<?= $value['id'] ?>">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Employment Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body ">
                                                            <div class="row mt-2">
                                                                <div class="col-sm-3"> Referee Name </div>
                                                                <div class="col-sm-9">

                                                                    <input type="text" class="form-control" name="referee_name" value="<?= ucwords(strtolower($value['referee_name'])) ?>" required />
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">

                                                                <div class="col-sm-3"> Referee Email </div>
                                                                <div class="col-sm-9">
                                                                    <input type="email" class="form-control" onclick="aler_onemail()" name="referee_email" value="<?= $value['referee_email'] ?>" onchange="validEmailCheck(this)" required />
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">

                                                                <div class="col-sm-3"> Referee Contact</div>
                                                                <div class="col-sm-9" style="display: flex;">

                                                                    <select onchange="upload_auto(this.form)" class="form-control txbox" required name="referee_mobile_number_code">
                                                                        <?php foreach ($country_TB as $key_ => $country_list) { ?>
                                                                            <?php
                                                                            $selected = "";
                                                                            if ($value['referee_mobile_number_code'] ==  $country_list['id']) {
                                                                                $selected = "selected";
                                                                            } ?>
                                                                            <option <?= $selected ?> value="<?= $country_list['id'] ?>"> <?= $country_list['name'] ?> (+<?= $country_list['phonecode'] ?>) </option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    <input type="number" style="    margin-left: calc(var(--bs-gutter-x) * .5);" class="form-control" name="referee_mobile_number" value="<?= $value['referee_mobile_number'] ?>" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn_green_yellow">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delet btn trigger ajax  -->
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_employe('<?= $value['id'] ?>','tr_<?= $value['id'] ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                            <?php  }  ?>
                        </tbody>
                    </table>
                <?php  }  ?>

                <form action="<?= base_url('user/stage_2/add_employment_document/' . $ENC_pointer_id) ?>" id="saveForm">

                    <?php if (count($add_employment_TB) > 0) { ?>
                        <div class="form-check mx-3 mt-5 mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="all_check" name="add_emp" required />
                                I have finished adding employers.
                            </label>
                        </div>
                    <?php  }  ?>


                    <div class="d-flex justify-content-center mt-4 mb-4">
                        <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_green_yellow" id="save"> Back</a>
                        <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green mx-3" id="save_exit">Save &amp; Exit</a>
                        <?php if (count($add_employment_TB) > 0) { ?>
                            <button type="submit" class="btn btn_green_yellow" id="save">Next</button>
                        <?php  }  ?>

                    </div>
                </form>

            </div>


        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script type="text/javascript">

    // $('#table').DataTable();
    $(document).ready(function() {
        $("#add_employers_form").submit(function(e) {
            //   e.preventDefault(); 
            console.log("Ready !!!");
        });
    });
    $('#add_employers_form').submit(function() {
        if (email_error) {
            alert('First resolve the issue.');
            return false;
        }
    });





    function check_company_availebal() { // vishal 10-11-2022
        let data = $('#add_employers_form').serialize();
        $.ajax({
            data: data,
            type: 'post',
            url: 'https://at.aqato.com.au/Stage2Controller/add_employers_form_ajax_check',
            beforeSend: function() {

            },
            success: function(data, textStatus, jqXHR) {
                data = data.replace(/^\s+|\s+$/gm, '');
                if (data == "not_ok") {
                    $("#add_employers_form_submit_btn").hide();
                    $("#company_alert").show();
                    // $('#company_alert').text("It is not permitted to add a company or organisation name more than once.");
                    $('#company_alert').text("Multiple additions of the same company or organisation name are not allowed.");
                }
                if (data == "ok") {
                    $("#add_employers_form_submit_btn").show();
                    $("#company_alert").hide();
                    $('#company_alert').text("");
                }
            },
            error: function(restResponse) {

            }
        });
    }

    function load_edite_form(employe_id) { // vishal 10-11-2022
        $.ajax({
            type: 'post',
            url: 'https://at.aqato.com.au/Stage2Controller/',
            beforeSend: function() {

            },
            success: function(data, textStatus, jqXHR) {

            },
            error: function(restResponse) {

            }
        });
    }

    function delete_employe(employe_id, tr_id) { // vishal 10-11-2022

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this employer ?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {

            $.ajax({
                data: {
                    'employe_id': employe_id,
                },
                type: 'post',
                url: '<?= base_url('user/stage_2_employe_Docs_check/' . $ENC_pointer_id) ?>',
                beforeSend: function() {},
                success: function(data, textStatus, jqXHR) {
                    console.log('success');
                    if (data == '1') {
                        final_delet_after_check(employe_id, tr_id);
                    } else {
                        custom_alert_popup_show(header = '', body_msg = "Make sure to remove all of the files that were uploaded to this Company/Organisation.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                    }
                },
                error: function(restResponse) {
                    console.log('error');
                }
            });
        });
    }

    function final_delet_after_check(employe_id, tr_id) {
        $.ajax({
            data: {
                'employe_id': employe_id,
            },
            type: 'post',
            url: '<?= base_url('user/stage_2_delete_employe_/' . $ENC_pointer_id) ?>',
            beforeSend: function() {},
            success: function(data, textStatus, jqXHR) {
                console.log('success');
                if (data == '1') {
                    $('#' + tr_id).hide(500);
                    after_delet();
                }
            },
            error: function(restResponse) {
                console.log('error');

            }
        });
    }

    function after_delet() {
        var table = document.getElementById('table');
        if (table != null) {
            var rowCount = table.rows.length - 1; // exclude header row
            var dataRowCount = 1;
            for (var i = 0; i < rowCount; i++) { // exclude header row
                if (table.rows[i].style.display === 'none') {
                    dataRowCount++;
                }
            }
            console.log('Number of data rows: ' + rowCount);
            console.log('Number of hidden data rows: ' + dataRowCount);
            if (rowCount == dataRowCount) {
                console.log('hide btn');
                location.reload();

            }
        }
    }
    
    
    <?php 
        $session = session();
        $isShowCommentBox = $session->isShowCommentBox;
        $session->remove("isShowCommentBox");
    ?>
    var isShowPopup = '<?= isset($isShowCommentBox) ? $isShowCommentBox : '' ?>';
    
    setTimeout(() => {
        getTheCurrentStageComment("<?= $ENC_pointer_id ?>","stage_1", isShowPopup);
    },200);

</script>

<?= $this->endSection() ?>
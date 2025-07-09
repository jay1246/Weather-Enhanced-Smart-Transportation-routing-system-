<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<style>
    label {
        margin-bottom: 0px !important;
        margin-bottom: 1px !important;
    }
</style>

<!-- inner heading  -->
<div class="bg-green text-white text-center">
    Stage 2 - Add Employe Document
</div>

<!-- start -->
<div class="container mt-4 mb-4">

    <!-- Alert on set - Flashdata -->
    <?= $this->include("alert_box.php") ?>

    <!-- center div  -->
    <div class="col-md-12">
        <div class="row">
            <!-- Employment Documents -->
            <div class="col-sm-6">
                <h4 class="text-green"> <b> Employment Documents </b> </h4>
                <div class="col-sm-12 p-4 bg-white shadow">
                    <select class="form-select" name="Employe_id" onchange="GET_employment_document_list(this.value)">
                        <option selected disabled>Select Company/Organisation</option>
                        <?php foreach ($add_employment_TB as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['company_organisation_name'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="col-sm-12 mt-3" id="employe_document_list">
                    </div>
                    <div class="col-sm-12 mt-3" id="employe_document_info">
                    </div>
                </div>
            </div>

            <!-- Assessment Documents -->
            <div class="col-sm-6">
                <h4 class="text-green"> <b> Assessment Documents </b> </h4>
                <div class="col-sm-12 p-4 bg-white shadow">
                    <div class="col-sm-12" id="assessment_documents_list">
                    </div>
                    <div class="col-sm-12 mt-3" id="assessment_documents_info">
                    </div>
                </div>
            </div>

            <!-- Documents list  -->
            <div class="com-sm-12 mt-4">
                <div class="row">
                    <!-- Employment Documents list -->
                    <div class="col-sm-6 ">
                        <!-- <h5 class="text-green"> <b> Employment Documents List</b> </h5> -->
                        
                        
                        
                        <div class="m-1 bg-white shadow" id="employment_documents_list_tb">
                            
                            
                            
                            <div id="accordion">

                                <?php
                                foreach ($add_employment_TB as $key_1 => $value_1) {
                                    $employee_id_1 = $value_1['id'];
                                    $company_organisation_name = $value_1['company_organisation_name'];
                                ?>
                                    <?php
                                    $employment_documents_list_tb = false;
                                    foreach ($documents_TB as $key => $value) {
                                        if ($employee_id_1 == $value['employee_id']) {
                                            $employment_documents_list_tb = true;
                                        }
                                    }
                                    ?>

                                    <?php if ($employment_documents_list_tb) { ?>

                                        <div class="card">
                                            <a class="collapsed btn w-100 text-start btn-light" data-bs-toggle="collapse" href="#collapseTwo<?= $employee_id_1 ?>">
                                                <h5> <?= $company_organisation_name ?></h5>

                                            </a>
                                            <div id="collapseTwo<?= $employee_id_1 ?>" class="collapse" data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    <table class="w-100">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Sr.No.</th>
                                                                <!-- <th>Company/Organisation</th> -->
                                                                <!-- 29-Aug-2022 / vishal h patel  -->
                                                                <th style="width: 85%;">Document Name</th> <!-- 29-Aug-2022 / vishal h patel  -->
                                                                <!-- <th>Status</th> -->
                                                                <th class="text-center" style="width: 5%;">
                                                                    Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($documents_TB as $key => $value) {
                                                                $employee_id = $value['employee_id'];
                                                                if ($employee_id_1 == $employee_id) {

                                                                    $i++; ?>
                                                                    <tr id="tr_<?= $value['id'] ?>">
                                                                        <td>
                                                                            <?= $i ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $value['name'] ?>

                                                                            <!-- <?= $value['document_path'] ?> <?= $value['document_name'] ?> -->
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" onclick="delete_file('<?= $value['id'] ?>','tr_<?= $value['id'] ?>')" class="btn btn-sm btn-danger"> X </button>
                                                                        </td>
                                                                    </tr>

                                                                <?php  } ?>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                <?php } ?>

                            </div>

                        </div>
                    </div>

                    <?php
                    $assessment_documents_list_tb = false;

                    foreach ($documents_TB as $key => $value) {
                        if ($value['employee_id'] == 0 || $value['employee_id'] == "") {
                            $assessment_documents_list_tb = true;
                        }
                    }
                    ?>
                    <?php if ($assessment_documents_list_tb) { ?>
                        <!-- Assessment Documents list -->
                        <div class="col-sm-6 ">
                            <div class="m-1 bg-white shadow" id="assessment_documents_list_tb">
                                <div class="mb-2 p-2">
                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">Sr.No.</th>
                                                <th style="width: 85%;">Document Name</th> <!-- 29-Aug-2022 / vishal h patel  -->
                                                <th class="text-center" style="width: 5%;">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($documents_TB as $key => $value) {
                                                if ($value['employee_id'] == 0 || $value['employee_id'] == "") {
                                                    $i++; ?>
                                                    <tr id="tr_<?= $value['id'] ?>">
                                                        <td>
                                                            <?= $i ?>
                                                        </td>
                                                        <td>
                                                            <?= $value['name'] ?>
                                                            <!-- <?= $value['document_path'] ?> <?= $value['document_name'] ?> -->
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" onclick="delete_file('<?= $value['id'] ?>','tr_<?= $value['id'] ?>')" class="btn btn-sm btn-danger"> X </button>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="form-check  mx-3 mt-3">
                <input class="form-check-input" value="" type="checkbox" id="all_check" name="all_check" required />
                <label class="form-check-label" for="all_check">
                    I understand &amp; agree that once I submit the documents, I will not be able to remove or change these documents.
                </label>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <a href="<?= base_url('user/stage_2/add_employment/' . $ENC_pointer_id) ?>" class="btn btn_green_yellow" id="save"> Back</a>
                <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green mx-3" id="save_exit">Save &amp; Exit</a>
                <button type="button" class="btn btn_green_yellow" onclick="stage_2_document_varification()">Submit Stage 2 Application </button>
            </div>


        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<!-- Employment Documents  // file list auto change with Employment Type  -->
<script type="text/javascript">
    function GET_employment_document_list(employer_id) {
        $.ajax({
            url: '<?= base_url("user/stage_2/add_employment_document_list_/" . $ENC_pointer_id) ?>',
            type: 'post',
            data: {
                'employer_id': employer_id,
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
            },
            beforeSend: function() {
                document.getElementById('employe_document_list').innerHTML = "Loading.... ";
            },
            success: function(data, textStatus, jqXHR) {
                document.getElementById('employe_document_list').innerHTML = JSON.parse(data);
            },
            error: function(restResponse) {
                document.getElementById('employe_document_list').innerHTML = "";
            }

        });
    }

    function GET_employment_document_info(document_id, employer_id) {
        $.ajax({
            url: '<?= base_url("user/stage_2/add_employment_document_info_/" . $ENC_pointer_id) ?>',
            type: 'post',
            data: {
                'document_id': document_id,
                'employer_id': employer_id,
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
            },
            beforeSend: function() {
                document.getElementById('employe_document_info').innerHTML = "Loading.... ";
            },
            success: function(data, textStatus, jqXHR) {
                console.log(data);
                document.getElementById('employe_document_info').innerHTML = JSON.parse(data);
            },
            error: function(restResponse) {
                document.getElementById('employe_document_info').innerHTML = "";
            }

        });
    }

    function file_select_() {
        $('#employe_document_btn').show();
    }


    function GET_assessment_documents_list(employer_id) {
        console.log("GET_assessment_documents_list");
        $.ajax({
            url: '<?= base_url("user/stage_2/assessment_documents_list_/" . $ENC_pointer_id) ?>',
            type: 'post',
            data: {
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
            },
            beforeSend: function() {
                document.getElementById('assessment_documents_list').innerHTML = "Loading.... ";
            },
            success: function(data, textStatus, jqXHR) {
                document.getElementById('assessment_documents_list').innerHTML = JSON.parse(data);
                console.log("GET_assessment_documents_list: ---- ok");
            },
            error: function(restResponse) {
                document.getElementById('assessment_documents_list').innerHTML = "";
            }

        });
    }
    GET_assessment_documents_list();

    function GET_assessment_documents_info(document_id) {
        $.ajax({
            url: '<?= base_url("user/stage_2/assessment_documents_info_/" . $ENC_pointer_id) ?>',
            type: 'post',
            data: {
                'document_id': document_id,
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
            },
            beforeSend: function() {
                document.getElementById('assessment_documents_info').innerHTML = "Loading.... ";
            },
            success: function(data, textStatus, jqXHR) {
                console.log(data);
                document.getElementById('assessment_documents_info').innerHTML = JSON.parse(data);
            },
            error: function(restResponse) {
                document.getElementById('assessment_documents_info').innerHTML = "";
            }

        });
    }

    function delete_file(id, tr_id) {
        // creat alert box 
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to remove that file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {


                $.ajax({
                    url: '<?= base_url("user/stage_2/documents_info_delete_file_/" . $ENC_pointer_id) ?>',
                    type: 'post',
                    data: {
                        'document_id': id,
                        'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
                    },
                    beforeSend: function() {},
                    success: function(data, textStatus, jqXHR) {
                        if (data == "ok") {
                            $('#' + tr_id).hide(500);
                            // reload list 
                            GET_assessment_documents_list();
                        }
                    },
                    error: function(restResponse) {
                        $('#' + tr_id).show();
                    }
                });


            }
        })
    }
</script>

<!-- multy file upload  add HTML remove HTML -->
<script>
    var count = 0;

    function add_more_input_(div_id) {
        var data = `<div id="wrapper-${count}" class="pt-2"> <div class="row">
                             <div class="col-sm-6">
                                                                                                <input class="form-control " type="text"  name="file_name[]" required />
                                                                                                </div>
                                                                                                <div class="col-sm-5">
                                                                                                    <input class="form-control col-sm-4" onchange="file_select_()" type="file"  name="files[]" accept=".jpg,.jpeg,.png,.pdf,.elex," required  />
                                                                                                </div>
                                                                                                <div class="col-sm-1">
                                                                                                    <button type="button" onclick="delete_div(\'#wrapper-${count}\')"  class="btn btn-danger ml-3">
                                                                                                    <i class="bi bi-x-lg"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>`;
        count++;
        $("#" + div_id).append(data);
    }

    function delete_div(element) {
        count = count - 1;
        $(element).remove();
    }
</script>

<!-- submit stage 2 and varify  -->
<script>
    function stage_2_document_varification() {
        var userValidation = $("#all_check")[0].checkValidity();
        let isChecked = $('#all_check').is(':checked');

        $.ajax({
            url: '<?= base_url('user/stage_2/add_employment_document_verify_/' . $ENC_pointer_id) ?>',
            success: function(result) {
                console.log(result);
                if (result == "0") {
                    custom_alert_popup_show(header = '', body_msg = "Please upload all the required documents", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                }
                if (result == "1") {
                    if (isChecked) {
                        submit_stage_2();
                    } else {
                        $("#all_check")[0].setCustomValidity("Please enter at least 5 characters.");
                        $('#all_check')[0].reportValidity();
                    }
                }
            },
            beforeSend: function(xhr) {
                console.log('file_validate Start.......');
            }
        });
    }

    function submit_stage_2() {
        // creat alert box 
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit the application ? You will not be able to remove or change these documents after submission.", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $.ajax({
                    url: '<?= base_url('user/stage_2/submit_application_/' . $ENC_pointer_id) ?>',
                    success: function(result) {
                        console.log("submit_stage_1:- " + result);
                        // close loading popup 
                        custom_alert_popup_close('null');

                        if (result == "1") { // Simulate an HTTP redirect :
                            window.location.replace("<?= base_url('user/view_application/' . $ENC_pointer_id) ?>");
                        } else {
                            custom_alert_popup_show(header = '', body_msg = "Submitting the Application is Not Working; <br> Please try again later. If not, kindly contact us at skills@aqato.com.au.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                        }

                    },
                    beforeSend: function(xhr) {
                        custom_alert_popup_show(header = '', body_msg = "loading.....", close_btn_text = 'No', close_btn_css = 'btn-danger d-none', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                        console.log('submit_stage_2 start .......');
                    }

                });

            }
        });
    }
</script>

<?= $this->endSection() ?>
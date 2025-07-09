<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>



<style>
    .Hi_Lite {
        background-color: var(--offgray);
    }

    .id_row {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
    }

    .file_name_link {
        width: 100% !important;
        display: block;
        padding: 10px;
        margin-top: 4px;
        border-radius: 5px;
        background-color: var(--offgray);
    }

    .collapse_box {
        /* margin-top: 3px; */
        /* border: 4px solid var(--offgray); */
        border-radius: 5px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        padding-top: 10px;
        margin-bottom: 20px;
    }

    .file_icon {
        margin-right: 20px;
    }
</style>

<!-- stepper -->
<?php include("stepper.php") ?>

<!-- start -->
<div class="container-fluid  mt-1 mb-4">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12" id="load_data">

            <!--Red NOTE instruction div starts -->
            <div class=" rounded p-2 mb-2" style="background-color: #ebebeb;">
                <h4 class="">Instructions for upload</h4>
                <ul>
                    <li class="">The maximum size of a file must not exceed 5 MB</li>
                    <li class="">All uploaded documents need to be high quality colour scans of the original documents.</li>
                    <!-- <li class=""> Kindly ensure that the awarded certificate and transcript for that qualification are uploaded as a single PDF file.</li>
                                <li class="">Kindly only includes qualification relevant to your qualification</li> -->
                    <li class="">Make sure you upload your relevant documents under the relevant category</li>
                    <li class="mb-2">Click on the document category to upload the relevant document(s).</li>
                </ul>
            </div>


            <!-- Dropdown --------------------->
            <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>">
            <div class=" bg-white shadow mt-3 p-4">
                <!-- auto load data from backend -->
                <div id="accordionExample" class="accordion">

                </div>


                <!-- submit back save btn  -->
                <div class="form-check mx-3 mt-3">
                    <input class="form-check-input" value="" type="checkbox" id="all_check" name="all_check" required />
                    <label class="form-check-label" for="all_check">
                        I understand &amp; agree that once I submit the documents, I will not be able to remove or change these documents.
                    </label>
                </div>
                <div class="mt-4 mb-3 text-center">
                    <a href="<?= base_url('user/stage_1/applicant_declaration/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green">Back</a>
                    <a href="<?= base_url('user/dashboard') ?>" class="btn btn_green_yellow"> Save & Exit </a>
                    <button type="button" id="submit" href="" onclick="file_validate()" class="btn btn_yellow_green">Submit Application</button>
                </div>




            </div>


        </div>
    </div>
</div>


<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    function multy_upload_file(doc_name) {
        var Select_file_div = doc_name + '-select';
        var selected_file = doc_name + '-file';
        var select_file_name = doc_name + '-file_name';
        var multy_file_form_id = doc_name + '-multy_file_form';

        var progreshBar_div = doc_name + '-File_uploading';
        var progressbar_text = doc_name + '-progressbar_text';
        var progreshBar = doc_name + '-progressbar';
        var progreshBar_cansel = doc_name + '-BTN_cansel';
        console.log(multy_file_form_id);

        var formData = new FormData(document.getElementById(multy_file_form_id));
        // var formData = new FormData();
        // formData.append('file', "asdsad");
        $.ajax({
            type: 'POST',
            url: '<?= base_url('user/stage_1/upload_documents/multy_file_upload_'); ?>',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        //start progress bar
                        var percentVal = percentComplete + '%';
                        $('#' + progreshBar).width(percentVal);
                        $('#' + progressbar_text).html(percentVal + ' Uploading ...');
                        // complate progress bar
                        if (percentComplete === 100) {
                            $('#' + progressbar_text).html(' File Uploaded. ');
                        }
                    }
                }, false);
                return xhr;
            },
            beforeSend: function() {
                $('#' + Select_file_div).hide(100); // file forum hide
                $('#' + progreshBar_div).show(50); // progress bar show
            },
            success: function(Response) {
                console.log(Response);
                return;
                const data = JSON.parse(Response);
                status = data.status
                msg = data.msg
                if (status == "1") {
                    file_name = data.file_name
                    file_url = data.file_url
                    file_id = data.file_id

                    // create file link 
                    // View_file_div File_link_div

                    var html_code = ` <!-- file view link auto add by js  -->
                                                <div class="col-sm-11" id="` + doc_name + `-File_link">
                                                <a href="` + file_url + `" target="_blank" class="p-3"> ` + file_name + `</a> 
                                                </div>
                                                <!-- file delet button  -->
                                                <div class="col-sm-1 text-end">
                                                <button type="button" id="` + doc_name + `-BTN_delet" onclick="Delet_file_singal('` + doc_name + `','` + file_id + `')" class="btn btn-danger">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div> `;


                    $('#' + View_file_div).html(html_code);
                    // $('#' + File_link_div).html(' <a href="' + file_url + '" target="_blank" class="p-3"> ' + file_name + '</a> <br>');

                    // hide show 
                    $('#' + progreshBar_div).hide(500); // progress bar hide
                    $('#' + Note_div).hide(500); // view file link  hide
                    $('#' + View_file_div).show(500); // view file link 

                    // File icon after done
                    $('#' + tital_icon).html('  <i class="bi bi-check-circle-fill"></i>');
                } else {
                    hide_view_file(doc_name);

                    // $('#' + progreshBar_div).hide(505); // progress bar hide
                    // $('#' + View_file_div).hide(500); // view file link  hide
                    // $('#' + Note_div).show(500); // view file link  hide
                    // $('#' + Select_file_div).show(550); // file forum show
                    // // File icon befor
                    // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                    alert(msg);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                // $('#' + progreshBar_div).hide(505); // progress bar hide
                // $('#' + View_file_div).hide(500); // view file link  hide
                // $('#' + Note_div).show(500); // view file link  hide
                // $('#' + Select_file_div).show(550); // file forum show

                // // File icon befor
                // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                hide_view_file(doc_name);

                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

            }
        });



    }

    function upload_file(doc_name) {
        var tital_icon = doc_name + '-file_icon';
        var Note_div = doc_name + '-Note';

        var Select_file_div = doc_name + '-select';
        var selected_file = doc_name + '-file';
        var select_file_name = doc_name + '-file_name';
        var required_document_name = doc_name + '-required_document';


        var progreshBar_div = doc_name + '-File_uploading';
        var progressbar_text = doc_name + '-progressbar_text';
        var progreshBar = doc_name + '-progressbar';
        var progreshBar_cansel = doc_name + '-BTN_cansel';

        var View_file_div = doc_name + '-View_file';
        var File_link_div = doc_name + '-File_link';
        var View_file_BTN_delet = doc_name + '-BTN_delet';
        // check is not empty 
        if ($('input[name=' + selected_file + ']').val() != "") {

            // get file data and file name 
            var file = $('input[name=' + selected_file + ']').prop('files')[0];
            var file_name = $('input[name=' + select_file_name + ']').val();
            var ENC_pointer_id = $('input[name=ENC_pointer_id').val();
            var required_document_id = $('input[name=' + required_document_name + ']').val();
            
            // vishal 29-05-2023
            // Check if the file format is accepted
            var acceptedFormats = $('input[name=' + selected_file + ']').attr('accept').split(',');
            var fileExt = file ? '.' + file.name.split('.').pop() : '';
            if (file && !acceptedFormats.includes(fileExt.toLowerCase())) {
                var msg_v = 'Invalid file format. Accepted formats are: ' + acceptedFormats.join(', ');
                custom_alert_popup_show(header = '', body_msg = msg_v, close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'update_btn');
                // Clear the selected file
                fileInput.val('');
                return;
            }
            //-------------------------

            
            // Validate file size and type
            if (validImageTypeSize(file, doc_name)) {
                return;
            }

            // create form to upload in backend
            var form_data = new FormData();
            form_data.append('file', file);
            form_data.append('name', file_name);
            form_data.append('ENC_pointer_id', ENC_pointer_id);
            form_data.append('required_document_id', required_document_id);


            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            //start progress bar
                            var percentVal = percentComplete + '%';
                            $('#' + progreshBar).width(percentVal);
                            $('#' + progressbar_text).html(percentVal + ' Uploading ...');
                            // complate progress bar
                            if (percentComplete === 100) {
                                $('#' + progressbar_text).html(' File Uploaded. ');
                            }
                        }
                    }, false);
                    return xhr;
                },
                url: '<?= base_url('user/stage_1/upload_documents_') ?>', // <-- point to server-side PHP script 
                dataType: 'text', // <-- what to expect back from the PHP script, if anything
                data: form_data,
                type: 'post',
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#' + Select_file_div).hide(100); // file forum hide
                    $('#' + progreshBar_div).show(50); // progress bar show
                },
                success: function(Response) {
                    const data = JSON.parse(Response);
                    status = data.status
                    msg = data.msg
                    if (status == "1") {
                        file_name = data.file_name
                        file_url = data.file_url
                        file_id = data.file_id

                        // create file link 
                        // View_file_div File_link_div

                        var html_code = ` <!-- file view link auto add by js  -->
                                                <div class="col-sm-11" id="` + doc_name + `-File_link">
                                                <a href="` + file_url + `" target="_blank" class="p-3"> ` + file_name + `</a> 
                                                </div>
                                                <!-- file delet button  -->
                                                <div class="col-sm-1">
                                                <button type="button" id="` + doc_name + `-BTN_delet" onclick="Delet_file_singal('` + doc_name + `','` + file_id + `')" class="btn btn-danger">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div> `;


                        $('#' + View_file_div).html(html_code);
                        // $('#' + File_link_div).html(' <a href="' + file_url + '" target="_blank" class="p-3"> ' + file_name + '</a> <br>');

                        // hide show 
                        $('#' + progreshBar_div).hide(500); // progress bar hide
                        $('#' + Note_div).hide(500); // view file link  hide
                        $('#' + View_file_div).show(500); // view file link 

                        // File icon after done
                        $('#' + tital_icon).html('  <i class="bi bi-check-circle-fill"></i>');
                    } else {
                        hide_view_file(doc_name);

                        // $('#' + progreshBar_div).hide(505); // progress bar hide
                        // $('#' + View_file_div).hide(500); // view file link  hide
                        // $('#' + Note_div).show(500); // view file link  hide
                        // $('#' + Select_file_div).show(550); // file forum show
                        // // File icon befor
                        // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                        alert(msg);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // $('#' + progreshBar_div).hide(505); // progress bar hide
                    // $('#' + View_file_div).hide(500); // view file link  hide
                    // $('#' + Note_div).show(500); // view file link  hide
                    // $('#' + Select_file_div).show(550); // file forum show

                    // // File icon befor
                    // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                    hide_view_file(doc_name);

                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                }
            });
        } else {
            alert('Select File First.');
        }

    }

    function upload_file_multy_file(doc_name) {
        var tital_icon = doc_name + '-file_icon';
        var Note_div = doc_name + '-Note';
        var all_link_div = doc_name + '-all_link_div';
        var Select_file_div = doc_name + '-select';
        var selected_file = doc_name + '-file';
        var select_file_name = doc_name + '-file_name';
        var required_document_name = doc_name + '-required_document';


        var progreshBar_div = doc_name + '-File_uploading';
        var progressbar_text = doc_name + '-progressbar_text';
        var progreshBar = doc_name + '-progressbar';
        var progreshBar_cansel = doc_name + '-BTN_cansel';

        var View_file_div = doc_name + '-View_file';
        var File_link_div = doc_name + '-File_link';
        var View_file_BTN_delet = doc_name + '-BTN_delet';
        // check is not empty 
        if ($('input[name=' + select_file_name + ']').val() != "") {
            if ($('input[name=' + selected_file + ']').val() != "") {

                // get file data and file name 
                var file = $('input[name=' + selected_file + ']').prop('files')[0];
                var file_name = $('input[name=' + select_file_name + ']').val();
                var ENC_pointer_id = $('input[name=ENC_pointer_id').val();
                var required_document_id = $('input[name=' + required_document_name + ']').val();

                // Validate file size and type
                if (validImageTypeSize(file, doc_name)) {
                    return;
                }
                
                 if(file_name.trim() == ''){
                 custom_alert_popup_show('', "Please enter the documnet name.", 'Ok', 'btn-danger', false); 
                  return;
                 }

                // create form to upload in backend
                var form_data = new FormData();
                form_data.append('file', file);
                form_data.append('name', file_name);
                form_data.append('ENC_pointer_id', ENC_pointer_id);
                form_data.append('required_document_id', required_document_id);


                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                //start progress bar
                                var percentVal = percentComplete + '%';
                                $('#' + progreshBar).width(percentVal);
                                $('#' + progressbar_text).html(percentVal + ' Uploading ...');
                                // complate progress bar
                                if (percentComplete === 100) {
                                    $('#' + progressbar_text).html(' File Uploaded. ');
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    url: '<?= base_url('user/stage_1/upload_documents_') ?>', // <-- point to server-side PHP script 
                    dataType: 'text', // <-- what to expect back from the PHP script, if anything
                    data: form_data,
                    type: 'post',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#' + Select_file_div).hide(100); // file forum hide
                        $('#' + progreshBar_div).show(50); // progress bar show
                    },
                    success: function(Response) {
                        const data = JSON.parse(Response);
                        status = data.status
                        msg = data.msg
                        if (status == "1") {
                            file_name = data.file_name
                            file_url = data.file_url
                            file_id = data.file_id

                            // create file link 
                            // View_file_div File_link_div

                            var html_code = `
                                         <div class="row m-1" id="` + file_id + `-link_div"> 
                                              <!-- file view link auto add by js  -->
                                             <div class="col-sm-11" id="a` + doc_name + `-File_link"> 
                                                     <a href="` + file_url + `" target="_blank" class="p-3"> ` + file_name + `</a> 
                                                </div>
                                                <!-- file delet button  -->
                                                <div class="col-sm-1 text-end">
                                                    <button type="button" id="` + doc_name + `-BTN_delet" onclick="Delet_file_multy_file('` + doc_name + `','` + file_id + `')" class="btn btn-danger">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>

                                                </div> 
                                            </div> 
                                         </div> `;



                            $('#' + all_link_div).append(html_code);




                            // hide show 
                            $('#' + progreshBar_div).hide(500); // progress bar hide
                            $('#' + Note_div).hide(500); // view file link  hide
                            $('#' + View_file_div).show(500); // view file link 
                            $('#' + Select_file_div).show(100); // file forum hide
                            $('input[name=' + selected_file + ']').val(null);
                            $('input[name=' + select_file_name + ']').val(null);

                            // File icon after done
                            $('#' + tital_icon).html('  <i class="bi bi-check-circle-fill"></i>');
                        } else {
                            // hide_view_file(doc_name);

                            // $('#' + progreshBar_div).hide(505); // progress bar hide
                            // $('#' + View_file_div).hide(500); // view file link  hide
                            // $('#' + Note_div).show(500); // view file link  hide
                            // $('#' + Select_file_div).show(550); // file forum show
                            // // File icon befor
                            // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                            alert(msg);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // $('#' + progreshBar_div).hide(505); // progress bar hide
                        // $('#' + View_file_div).hide(500); // view file link  hide
                        // $('#' + Note_div).show(500); // view file link  hide
                        // $('#' + Select_file_div).show(550); // file forum show

                        // // File icon befor
                        // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                        // hide_view_file(doc_name);

                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                    }
                });
            } else {
                alert('Select File First.');
            }
        } else {
            alert('Add File Name First.');
        }

    }


    function Delet_file_multy_file(doc_name, file_id) {
        // if (confirm("Are you sure you want to remove this file?") != true) {
        //     return;
        // }

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to remove this file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_files');
        $("#delete_files").click(function() {
            if (custom_alert_popup_close('delete_files')) {
                var tital_icon = doc_name + '-file_icon';
                var Note_div = doc_name + '-Note';
                var link_div = file_id + '-link_div';

                $.ajax({
                    url: '<?= base_url('user/stage_1/delet_file_') ?>',
                    data: {
                        'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
                        'file_id': file_id,
                    },
                    type: 'post',
                    success: function(result) {
                        if (result == "ok") {
                            // hide_view_file(doc_name);
                            $('#' + link_div).hide(100);
                            $('#' + Note_div).show(500); // view file link  hide
                            $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                        }
                    },
                    beforeSend: function(xhr) {
                        console.log('loading.......');
                    }
                });
            }
        });





    }

    function Delet_file_singal(doc_name, file_id) {
        // if (confirm("Are you sure you want to remove this file?") != true) {
        //     return;
        // }

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to remove this file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'update_btn');
        $("#update_btn").click(function() {
            if (custom_alert_popup_close('update_btn')) {
                $.ajax({
                    url: '<?= base_url('user/stage_1/delet_file_') ?>',
                    data: {
                        'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
                        'file_id': file_id,
                    },
                    type: 'post',
                    success: function(result) {
                        if (result == "ok") {
                            hide_view_file(doc_name);
                        } else {
                            console.log('Result: ' + result);
                        }
                    },
                    beforeSend: function(xhr) {
                        console.log('loading.......');
                    }
                });
            }
        });


    }

    function hide_view_file(doc_name) {
        console.log('Hide view File:- ' + doc_name);
        var tital_icon = doc_name + '-file_icon';
        var Note_div = doc_name + '-Note';
        var Select_file_div = doc_name + '-select';
        var selected_file = doc_name + '-file';
        var select_file_name = doc_name + '-file_name';
        var progreshBar_div = doc_name + '-File_uploading';
        var View_file_div = doc_name + '-View_file';

        $('#' + progreshBar_div).hide(500); // progress bar hide
        $('#' + View_file_div).hide(500); // view file link  hide
        $('#' + Note_div).show(500); // view file link  hide
        $('#' + Select_file_div).show(500); // file forum show

        // clear file selection or name 
        $('#' + selected_file).val('').clone(true); // view file link  hide
        $('#' + select_file_name).val('').clone(true); // view file link  hide
        // File icon befor
        $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
    }

    // image validation 
    function validImageTypeSize(file, doc_name) {
        if (file.size > 1048576 * 5) {
            alert('The file size is too large and can not be uploaded. Please reduce the size of the file and try again.The maximum file size is upto 5MB');
            return false;
        }
    }

    // load all file 
    $(document).ready(function() {
        $.ajax({
            url: '<?= base_url('user/stage_1/required_documents_list_/' . $ENC_pointer_id) ?>',
            type: 'post',
            success: function(result) {
                // console.log(result);
                $("#accordionExample").html(JSON.parse(result));
            },
            beforeSend: function(xhr) {
                console.log('loading.......');
                $("#accordionExample").html("loading.....");
            }
        });
    });

    function file_validate() {
        var userValidation = $("#all_check")[0].checkValidity();
        let isChecked = $('#all_check').is(':checked');


        $.ajax({
            url: '<?= base_url('user/stage_1/upload_documents_file_validate_/' . $ENC_pointer_id) ?>',
            success: function(result) {
                if (result == "0") {
                    custom_alert_popup_show(header = '', body_msg = "Please upload all the required documents", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                }
                if (result == "1") {
                    if (isChecked) {
                        submit_stage_1();
                    } else {
                        $("#all_check")[0].setCustomValidity("Please check the checkbox.");
                        $('#all_check')[0].reportValidity();
                    }
                }
            },
            beforeSend: function(xhr) {
                console.log('file_validate loading.......');
            }
        });
    }

    function submit_stage_1() {
        // creat alert box 

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit the application ? You will not be able to remove or change these documents after submission.", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $.ajax({
                    url: '<?= base_url('user/stage_1/upload_documents_submit_stage_1_/' . $ENC_pointer_id) ?>',
                    success: function(result) {
                        console.log("submit_stage_1:- " + result);
                        Create_TRA_file_to_stage_1_folder_in_BG();
                        custom_alert_popup_close('null');
                        if (result == "1") {
                            // Simulate an HTTP redirect:
                            window.location.replace("<?= base_url('user/view_application/' . $ENC_pointer_id) ?>");
                        } else {
                            custom_alert_popup_show(header = '', body_msg = "Submitting the Application is Not Working; <br> Please try again later. If not, Kindly contact us at skills@aqato.com.au <br><br> " + result, close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                            $('#cover-spin').hide(0);
                        }
                    },
                    beforeSend: function(xhr) {
                        // custom_alert_popup_show(header = '', body_msg = "loading.......", close_btn_text = 'No', close_btn_css = 'btn-danger d-none', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                        // console.log('submit_stage_1 loading.......');
                        $('#cover-spin').show(0);

                    }
                });

            }
        });
    }

    function Create_TRA_file_to_stage_1_folder_in_BG() {
        // creat alert box 
        $.ajax({
            url: '<?= base_url('auto_save_download_PDF_/' . $ENC_pointer_id . '/TRA Application Form/') ?>',
            success: function(result) {
                console.log('Create_TRA_file_to_stage_1_folder_in_BG Done.......');
            },
            beforeSend: function(xhr) {
                console.log('Create_TRA_file_to_stage_1_folder_in_BG loading.......');
            }
        });
    }
</script>


<?= $this->endSection() ?>
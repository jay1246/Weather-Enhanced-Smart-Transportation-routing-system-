<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<style>
    label {
        margin-bottom: 0px !important;
        margin-bottom: 1px !important;
    }

    .Comments::placeholder {
        color: #e3e3e3;
    }
</style>

<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">

    <b> Stage 4 - Practical Assessment <?= helper_get_applicant_full_name($ENC_pointer_id); ?></b>
</div>

<!-- start -->
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-1"></div>

        <!-- center div  -->
        <div class="col-md-10 bg-white shadow pb-5">



            <!-- Alert on set - Flashdata -->
            <?= $this->include("alert_box.php") ?>
            <div class="mt-5" id="card_style">
                <div class="card-body" style="margin-left:10%">


                    <?php
                    if ($file_uploaded) {
                        $disabled = "disabled";
                    } else {
                        $disabled = "";
                    }
                    if($preference_location){
                        $address_div = "";
                    }else{
                        $address_div = "display:none";
                    }
                    ?>

                    <form action="<?= base_url('user/stage_4/receipt_upload_action/' . $ENC_pointer_id) ?>" method="post" enctype="multipart/form-data" style="margin-left: 10%;" id="">
                        <b> Preferred Practical Location <span class="text-danger">*</span></b>
                        <select id="preference_location" required class="form-select w-75" <?= $disabled?> onchange="get_addresh(this.value)" name="preference_location">
                            <option value="" selected> Select Location</option>
                            <?php foreach ($location as $key => $value) {
                            
                                $occ_id =  getOccupationID($ENC_pointer_id,"yes");
                                
                            ?>

                                <optgroup label="<?= $key ?>">
                                    <?php foreach ($value as $key_ => $value_) {
                                        
                                        // Electrician
                                       if($occ_id == 7 && $value_["id"] == 20){
                                           continue;
                                       }
                                       
                                    //   Plumber
                                    if($occ_id == 18 && $value_["id"] == 16){
                                           continue;
                                       }
                                       
                                        $selected = "";
                                        if ($preference_location == $value_['city_name']) {
                                            $selected = "selected";
                                        }  ?>

                                        <option value="<?= $value_['city_name'] ?>" <?= $selected ?>><?= $value_['city_name'].' - '.$value_['location'] ?></option>
                                    <?php  }  ?>

                                <?php  }

                                ?>

                        </select>
                        <div class=" rounded mb-3 w-75" id="ads_auto" style="<?= $address_div ?>"></div>

                        <b> Comments </b>
                      <textarea id="preference_comment" onchange="save_Preferred_info_()" name="preference_comment" class="Comments form-control  w-75" placeholder="Examples: 
* The applicant would need 2 weeks notice for the interview. 
* The applicant is currently away, kindly schedule the interview after DD/MM/YYYY."rows="6" class="form-control  disabled__field" name="preference_comment"><?= $preference_comment ?></textarea>

                      </br>
                        <b> TRA Payment Receipt Number <span class="text-danger">*</span></b>
                        <input type="number"  autocomplete="off" onchange="save_Preferred_info_()" value="<?= $receipt_number ?>" class="form-control mb-3 w-75 disabled__field" name="recipt_number" id="recipt_number" required />
                        <b> Payment Date (dd/mm/yyyy) <span class="text-danger">*</span> </b>
                        <!-- <input type="date" class="form-control mb-3 w-75 datepicker  disabled__field" value="" name="payment_date" id="date1" placeholder="dd/mm/yyyy" required=""> <br> -->

                        <input type="text" onchange="save_Preferred_info_()"  autocomplete="off" class="form-control mb-4 w-75 datepicker" value="<?= $payment_date ?>" name="payment_date" id="payment_date" placeholder="dd/mm/yyyy" maxlength="10" required="">

                        <div style="display: flex;" class="w-75">
                            <div class="col-10" >
                                <input type="file" <?= $disabled ?> class="form-control "  accept="application/pdf" name="recipt" id="file_receipt" required="">
                                <div class="text-danger">Only : .pdf</div>
                            </div>
                            <div class="col-2">
                                <button <?= $disabled ?> class="btn btn_green_yellow  float-end"  id="" type="submit">Upload</button>
                            </div>
                        </div>
                        <?php if ($file_uploaded) { ?>
                            <div style="margin-top: -22px; margin-left: 119px;">
                                <a href="<?= base_url($document_path . '/' . $document_full_name); ?>">
                                    <?= $document_name ?>
                                </a>
                                <a onclick="delete_file()" class="text-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </div>
                        <?php } ?>
                        
                        
                        
            <!-- Comment Basic END -->
            <div class="major_class">
             <?php 
            $is_extra_image_checker = true;
            foreach($comment_store_documents as $comment_store_document){
                $docs = [];
                $disabled = "";
                if($comment_store_document["document_id"] == 0){
                    $is_extra_image_checker = false;
                }
                if($comment_store_document["document_id"] != 0){
                    $disabled = "disabled";
                    $docs = find_one_row("documents", "id", $comment_store_document["document_id"]);
                // print_r($docs->name);
                }
                
            ?>
            <!-- Make Comment File Uploader here -->
            <div id="comment_area_<?= $comment_store_document["id"] ?>" style="">
            <b><?= $comment_store_document["name"] ?> <span class="text-danger">*</span></b>
                <div style="display: flex;" class="w-75">
                    <div class="col-sm-10">
                        <input <?= $disabled ?> type="file" class="form-control " name="comment_files[<?= $comment_store_document["id"] ?>][]" id="comment_file_<?= $comment_store_document["id"] ?>" accept="application/pdf">
                        <div class="text-danger">Only :  .pdf</div>
                    </div>
                    <div class="col-sm-2">
                        <?php 
                        if($disabled){
                            ?>
                            <a type="button" class="btn btn_green_yellow float-end disabled" style="padding-left:10px;padding-right:10px">Upload</a>
                            <?php
                        }
                        else{
                           ?>
                            <a type="button" class="btn btn_green_yellow float-end" style="padding-left:10px;padding-right:10px" onclick="upload_a_file_comment('#comment_file_<?= $comment_store_document["id"] ?>',<?= $comment_store_document["id"] ?>, <?= $comment_store_document["pointer_id"] ?>)">Upload</a>
                            <?php
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
            <?php 
            if($docs){
            ?>
                <div style="margin-left: 119px;margin-top: -22px;">
                    <a href="<?= base_url()."/".$docs->document_path."/".$docs->document_name ?>" target="/blank">
                        <?= $docs->name ?>
                    </a>
                    <a onclick="delete_file_using_comment(<?= $comment_store_document["id"] ?>,<?= $docs->id ?>)" class="text-danger">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            <?php
            }
            ?>
            
            <!-- END Make Comment File Uploader here -->
            <?php 
            }
            ?>
                        
            
            </div>
            <!-- END -->
                        
                    </form>
                </div>
            </div>
            



            <!-- -----------------table---------------- -->
            <?php if ($file_uploaded && $is_extra_image_checker) { ?>
                <div class="mt-1" style="margin-left:10%">
                    <!--  onsubmit="return validateForm()" -->
                    <form action="<?= base_url('user/stage_4/submit_/' . $ENC_pointer_id) ?>" method="post" id="s4_submit_stage">
                        <div class="form-check " style="margin-left:-30px;  margin-top: 30px;">
                            <input class="form-check-input" type="checkbox" id="all_check" required />
                            <label class="form-check-label" for="all_check">
                                I understand &amp; agree that once I submit the documents, I will not be able to remove or change these documents.
                            </label>
                        </div>


                        <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green" style="margin-left:35%;" id="back_btn" > Back</a>

                        <a class="btn btn_green_yellow" style="margin-left:1%;" onclick="validateForm()">Submit</a>
                    </form>
                </div>
            <?php } ?>

        </div>

        <?php if (!$file_uploaded) { ?>
            <br>
            <br>
            <div class="mt-4" style="margin-left:10%">
                <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green" style="margin-left:35%;     padding-left: 20px !important;
    padding-right: 20px !important;" id="back_btn" > Back</a>

            </div>
            <br> <br>
            <br> <br>
            <br>
        <?php } ?>
    </div>
</div>
<style>
    #loader_img {
        position: fixed;
        left: 50%;
        top: 50%;
        pointer-events: none;
    }

    #cover-spin {
        position: fixed;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(251, 251, 251, 0.6);
        z-index: 9999;
        display: none;
    }
</style>
<div id="cover-spin" style="display: none;">
    <div id="loader_img">
        <img src="https://attc.aqato.com.au/public/assets/image/admin/loader.gif" style="width: 100px; height:auto">
    </div>
</div>
<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>

    
    function delete_file_using_comment(comment_id, document_id){
        
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn_small_1');
        $("#delete_pop_btn_small_1").click(function() {
            // console.log("Here");
            // return;
            if (custom_alert_popup_close('delete_pop_btn_small_1')) {
                // console.log(documnet_id);
                // return;
                $('#cover-spin').show();
                $.ajax({
                    url: "<?= base_url("user/comments/deleteDocumentAndComments") ?>",
                    type: "POST",
                    data: {
                        comment_id,
                        document_id,
                    },
                    success: function(res) {
                        //  window.location.reload();
                        $('#cover-spin').hide();

                        window.location.reload();


                        console.log("---------------------------" + res);

                    }

                    //  dataType: "JSON",
                    // success: function(data) {
                    //     $('#cover-spin').hide();
                    //     if (data["response"] == true) {
                    //             window.location.reload();
                    //     } else {
                    //         alert(data["msg"]);
                    //     }
                    //  },            
                });
            }
        });
        
        
    }
    
    function upload_a_file_comment(file_select, id, pointer_id){
        // console.log(file);
        var fd = new FormData(); 
        var files = $(file_select)[0].files[0];
        // console.log(files);
        
        if(files == undefined){
            $(file_select)[0].setCustomValidity("Please Upload a file.");
            $(file_select)[0].reportValidity();
            return;
        }
        
        $('#cover-spin').show();
        
        fd.append('file', files); 
        fd.append('id', id); 
        fd.append('pointer_id', pointer_id); 
        
        $.ajax({ 
            url: '<?= base_url("user/stage_4/receipt_upload/comment_file_upload") ?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                if(response){
                    $('#cover-spin').hide();
                    location.reload();
                }
            }, 
        });
    }

    function validateForm() {
           var userValidation = $("#all_check")[0].checkValidity();

        let isChecked = $('#all_check').is(':checked');
        console.log(isChecked);
        if(!isChecked){
            
            $("#all_check")[0].setCustomValidity("Please check the checkbox.");

            $('#all_check')[0].reportValidity();
            
            return false;
        }

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to submit stage 4 Application?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                $('#cover-spin').show(0);
                
                $("#s4_submit_stage").submit();
                return true;
            } else {
                $('#cover-spin').hide(0);
                return false;

            }
        });
       
    }


    //on change
    function get_addresh(value) {

        $('#ads_auto').html('');
        $.ajax({
            'url': '<?= base_url('user/stage_4/get_addresh_') ?>',
            'type': 'post',
            'data': {
                'city_name': value,
            },
            success: function(data) {
               if(value == ""){
                    // Get Varaible -> 
                    console.log("Empty Field");
                    // End
                    return;
                }
                console.log("Here");
                
                // 
                if (value != "") {
                    data = JSON.parse(data);
                    html = '<div class="row"> <div class="col-3"><b>Venue :</b> </div> <div class="col-9"> ' + data['venue'] + '</div>  <div class="col-3"><b> Address : </b> </div>  <div class="col-9">  ' + data['office_address'] + '</div></div><br> <b >  Are you sure you want to choose the above venue for the practical assessment ? </b>  ';
                    custom_alert_popup_show(header = '', html, close_btn_text = 'Cancel', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Confirm', other_btn_class = 'btn-success', other_btn_id = 'ouiouhasdasd' , cancel_id="close_alert");
                    $("#ouiouhasdasd").click(function() {
                        if (custom_alert_popup_close('ouiouhasdasd')) {
                            $("#ads_auto").show();

                            $('#ads_auto').html('<div class="mt-3 p-2" style="background-color:#ffc107;border-radius:5px" > <b> Address : </b> <br>' + data['office_address'] + '</div>');
                            save_Preferred_info_();
                        }
                    });
                    $('#close_alert').click(function() {
                          if (custom_alert_popup_close('ouiouhasdasd')) {
                            $('#cover-spin').show();
                            window.location.reload();
                         }
                    });
                    
                } else {
                    save_Preferred_info_();

                }
            }

        });
    }
    
    // save on change 
    function save_Preferred_info_() {
        $.ajax({
            'url': '<?= base_url('user/stage_4/save_Preferred_info_/' . $ENC_pointer_id) ?>',
            'type': 'post',
            'data': {
              'preference_location': $('#preference_location').val(),
                'preference_comment': $('#preference_comment').val(),
                'recipt_number' :$('#recipt_number').val(),
                'payment_date' :$('#payment_date').val(),
            },
            success: function(data) {
                console.log("---------------------------" + data);
            }
        });
    }

    // on load page check old data
    <?php if (isset($preference_location) && !empty($preference_location)) { ?>
        $('#ads_auto').html('');
        $.ajax({
            'url': '<?= base_url('user/stage_4/get_addresh_') ?>',
            'type': 'post',
            'data': {
                'city_name': '<?= $preference_location ?>',
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#ads_auto').html('<div class="mt-3 p-2" style="background-color:#ffc107;border-radius:5px" > <b> Address : </b> <br>' + data['office_address'] + '</div>');
            }
        });
    <?php } ?>




    $(".datepicker").datepicker({
        dateFormat: "dd/mm/yy",
        maxDate: new Date()
    });
    
    
    function delete_file(documnet_id) {
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this file?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
        $("#delete_pop_btn").click(function() {
            // console.log("Here");
            // return;
            if (custom_alert_popup_close('delete_pop_btn')) {
                // console.log(documnet_id);
                // return;
                $('#cover-spin').show();
                $.ajax({
                    url: "<?= base_url('user/stage_4/receipt_upload_delete/' . $ENC_pointer_id) ?>",
                    type: "POST",
                    success: function(res) {
                        //  window.location.reload();
                        $('#cover-spin').hide();

                        window.location.reload();


                        console.log("---------------------------" + res);

                    }

                    //  dataType: "JSON",
                    // success: function(data) {
                    //     $('#cover-spin').hide();
                    //     if (data["response"] == true) {
                    //             window.location.reload();
                    //     } else {
                    //         alert(data["msg"]);
                    //     }
                    //  },            
                });
            }
        });
    }
    
    
    
    <?php 
        $session = session();
        $isShowCommentBox = $session->isShowCommentBox;
        $session->remove("isShowCommentBox");
    ?>
    var isShowPopup = '<?= isset($isShowCommentBox) ? $isShowCommentBox : '' ?>';
    
    setTimeout(() => {
        getTheCurrentStageComment("<?= $ENC_pointer_id ?>","stage_3", isShowPopup);
    },200);


</script>

<?= $this->endSection() ?>
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
 <b>Stage 3 (Reassessment) - Technical Interview <?= helper_get_applicant_full_name($ENC_pointer_id); ?> </b> 
</div>

<!-- start -->
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-1"></div>

        <!-- center div  -->
        <div class="col-md-10 bg-white shadow pb-5">


            <div class="rounded p-2 mb-2 rounded" style="padding: 30px;background-color: #ebebeb;">

                <!--<div class="row">-->
                <h4 class=""><u>Note:</u></h4>
                <!--<h5 class="text-green text-center mt-4 mb-4" style="font-size: 20px;">EXEMPTION REQUEST:</h5>-->
                <!--</div>-->
                         <p>
                As per the recent changes in the TRA guidelines, applicants in Australia can now choose to complete the Technical Interview from their own preferred location such as their home or their agent’s office etc. conditional to the following terms:
                <ul>
                    <li>The location has consistent internet signal (preferably WIFI and not mobile Data).</li>
                   <li>The location is quiet and private (applicant’s need to be alone throughout the interview).
</li>
                  <li>Their device has high quality audio and video capabilities <b>and has been tested prior to the interview session</b>.</li>
                    </ul>
                </p>
            </div>
            <div class=" rounded p-2 mb-2 bg-warning" >
                <h4 class=""><u>Important:</u></h4>
                 <ul>
                     <?php  $user_type = session()->get('account_type'); 
                        if ($user_type =="Applicant"){
                     ?>
                     <li class=""><b>If you are unsure of meeting the above criteria, it is highly recommended you opt to attend an <a href="https://attc.org.au/wp-content/uploads/2024/03/ATTC-Assesssment-Location-List_v3.3-1.pdf" style="color:blue;" target="_blank"><u>Approved Assessment Centre</u></a> to complete your Technical Interview.</b></li>
                     <?php }else{  ?>
                      <li class=""><b>If the Applicant is unsure of meeting the above criteria, it is highly recommended they opt to attend an <a href="https://attc.org.au/wp-content/uploads/2024/03/ATTC-Assesssment-Location-List_v3.3-1.pdf" style="color:blue;" target="_blank"><u>Approved Assessment Centre</u></a> to complete their Technical Interview. </b></li>
                     <?php } ?>
                    <li class=""><b>If the Technical Interview cannot proceed due to poor audio or video quality or connection issues, applicants will be recommended “Unsuccessful” and they will need to apply for a reassessment for their technical interview at a cost of $450.00 (Pathway 2) or $1,000 (Pathway 1). There may also be a 2-4 week wait for another appointment, depending on assessor’s availability.</b></li>
                </ul>
            </div>
            <!-- Alert on set - Flashdata -->
            <?= $this->include("alert_box.php") ?>
            <!--<div class="mt-5" id="card_style">-->
            <!--    <div class="card-body" style="margin-left:10%">-->


            <?php
             
            if ($file_uploaded) {
                // vishal 29-05-2023 change
                if ($exemption_yes_no == "no") {
                    $disabled = "disabled";
                    $button = "disabled";
                } else {
                    $disabled = "";
                    $button = "";
                }

                $ex_show_show = "";
            } else {
                $disabled = "";
                $button = "";

                $ex_show_show = "display: none";
            }
            $disabled_ex = "";
            if ($preference_location) {
                if ($file_uploaded_ex) {
                    $disabled_ex = "disabled";
                }
            }

            // vishal 29-05-2023  add
            if ($file_uploaded) {
                                        $disabled = "disabled";
                if ($document_id_ex) {
                    if ($exemption_yes_no == "yes") {
                        $button = "disabled";
                        $disabled_ex = "disabled";
                    }
                }
            }



            ?>


            <form action="" method="post" enctype="multipart/form-data" id="tra_form">
                <div class="row p-2 mb-2" style="padding: 30px;" <?= $disabled ?>>
                    <h4 class="text-center p-2 text-success" style="font-size: 20px;">
                        <?php
                         $user_type = session()->get('account_type');
                     if ($user_type =="Applicant"){
                       echo "Do you wish to proceed with the option of completing the technical interview from your preferred location instead of attending an Approved Assessment Centre ?";
                     }else{
                        echo "Does the applicant wish to proceed with the option of completing the technical interview from their preferred location instead of attending an Approved Assessment Centre ?";
                 }
                  // echo "Do you confirm that you have discussed the above mentioned criteria & the consequences  with <br> the applicant and the applicant wishes to proceed with the option of completing the  technical <br> interview from the their preferred location ?";
                    ?>
                    
                  
                    </h4>
                </div>
                <div class="form_col row" id="postal_row_fields" style="padding: 10px;" <?= $disabled ?>>
                    <div class="form_col col-6" style="text-align: end;">
                        <label class="form_col form-check-label form-control" style="padding-left: 0px; border: 0;">
                            <?php
                            //   echo $exemption_yes_no;
                            if ($exemption_yes_no == "yes") {
                                // echo "fhfxfb";
                                $exemption_yes = 'checked';
                                $disabled_ex_upload = '';
                            } else {
                                $exemption_yes = '';
                                $disabled_ex_upload = "disabled";
                            }
                            if ($exemption_yes_no == "no") {
                                $exemption_no = 'checked';
                            } else {
                                $exemption_no = '';
                            }

                            ?>

                            <input onclick="postal_hide(this.value)" class="form-check-input" type="radio" name="exemption_yes_no" value="yes" <?= $disabled ?> <?= ($exemption_yes)  ?>>
                            <span>Yes</span>
                        </label>
                    </div>
                    <div class="form_col col-6" style="    text-align: start;">
                        <label class="form_col form-check-label form-control" for="known_by_any_name" style="margin-left: 15px;border: 0;">
                            <input onclick="postal_hide(this.value)" class="form-check-input" type="radio" name="exemption_yes_no" value="no" <?= $disabled ?> <?= ($exemption_no) ?>>
                            <span>No</span>
                        </label>
                    </div>
                </div>
                <?php
                if ($exemption_yes_no == "yes") {
                    
                    $address_div = "display:none";
                    $is_select_yes = true;
                    $postal_box = '';
                    // echo $enroll_stage_4;
                    // if($download_ex_form == 1){
                    //     $postal_box = 'display:none';
                    // }else{
                    //     $postal_box = '';
                    // }
                } else {
                    $postal_box = 'display:none';
                    $address_div = "";
                    $is_select_yes =false;
                }
                // echo $enroll_stage_4;
                // echo "fhfhfd";
                // echo $receipt_number;
                // exit;
                if($enroll_stage_4 == 1 || $receipt_number){
                    $postal_box = 'display:none';
                    $is_select_yes =false;
                }
                // echo $postal_box;
                ?>
                <div id="postal_box" style="display:none">
                   
                    <br>
                    <!--<div class="form_col row bg-warning rounded" style="padding: 30px;">-->
                    <!--<p>If granted an exemption, the applicant must complete the online Technical Assessment from their country of residence, as shown on their Application Form. If the applicant’s location has changed since submitting the application with ATTC, please notify via email on dilpreet.bagga@attc.org.au with the new address details.</p>-->
                    <!--</div>-->

                </div>
                    <?php
                                    // exit;

                    // echo $exemption_yes_no.$download_ex_form;
                if ($exemption_yes_no !="") {
                    if($exemption_yes_no =='yes'){
                        
                        // if($download_ex_form != 1){
                        //         $upload_form = 'display:none';
                        // }else{
                        // $upload_form = "";
                        // }
                        
                        $upload_form = "";
                    }else{
                    $upload_form = "";
                    }
                 } else {
                    $upload_form = 'display:none';
                }
                
                if($enroll_stage_4 == 1 && $exemption_yes_no){
                    $upload_form = "";
                }
// $upload_form = "";
                // echo $upload_form;
                
 ?>
                <div style="padding-left: 10%;padding-right:10%; <?=$upload_form?>" id="upload_form">

                    <div class="" id="form_data" style="<?=$upload_form?>">
                        <b>Preferred Interview Location  <?php
                                                        unset($location["Online"]);
                                                        // echo "<pre>";
                                                        // print_r($location);
                                                        $select_field_disabled = $option_disabled = "";
                                                        if ($preference_location == "Online (Via Zoom)") {
                                                            $select_field_disabled = "disabled";
                                                            $option_disabled = "<option selected>" . $preference_location . "</option>";
                                                        }
                                                        ?> <span class="text-danger">*</span></b>
                        <select id="preference_location" required class="form-select " onchange="get_addresh(this.value)" name="preference_location" <?= $button ?> <?= $select_field_disabled ?>>
                            <option value="" selected> Select Location</option>
                            <?php foreach ($location as $key => $value) {  ?>

                                <optgroup label="<?= $key ?>">
                                    <?php foreach ($value as $key_ => $value_) {
                                        $selected = "";
                                        if ($preference_location == $value_['city_name']) {
                                            $selected = "selected";
                                        }  ?>

                                        <option value="<?= $value_['city_name'] ?>" <?= $selected ?>><?= $value_['city_name'] ?></option>
                                    <?php  }  ?>

                                <?php  }
                            echo $option_disabled;

                                ?>

                        </select>
                        <!---->
                        <div class=" rounded mb-3" id="ads_auto" style="<?= $address_div ?>"></div>
                        <b> Comments </b>
                        <!-- // vishal 29-05-2023 add  -->
                        <textarea onchange="save_Preferred_info_()" name="preference_comment" id="preference_comment" class="Comments form-control  mb-3" placeholder="Examples: 
                                * The applicant would need 2 weeks notice for the interview. 
                               * The applicant is currently away, kindly schedule the interview after DD/MM/YYYY."rows="6" class="form-control  disabled__field" name="preference_comment"><?= $preference_comment ?></textarea>

                        <b> TRA Payment Receipt Number <span class="text-danger">*</span> </b>
                        <!--disabled-->
                        <input type="number" onchange="save_Preferred_info_()" autocomplete="off" value="<?= $receipt_number ?>" class="form-control  disabled__field mb-3" name="recipt_number" id="recipt_number" required />

                        <b> Payment Date (dd/mm/yyyy) <span class="text-danger">*</span> </b>
                        <!-- <input type="date" class="form-control mb-3  datepicker  disabled__field" value="" name="payment_date" id="date1" placeholder="dd/mm/yyyy" required=""> <br> -->
                        <!--<= $disabled ?>-->
                        
                        <input type="text" autocomplete="off" onchange="save_Preferred_info_()" class="form-control mb-4  datepicker" value="<?= $payment_date ?>" name="payment_date" id="payment_date" placeholder="dd/mm/yyyy" maxlength="10" required="">
          
                        <?php
                        if (!$file_uploaded) {
                            $input = "";
                        } else {
                            $input = "disabled";
                        }
                        ?>

                        <b>TRA Payment Receipt <span class="text-danger">*</span></b>
                        <div style="display: flex;">
                            <div class="col-sm-10">
                                <input type="file" <?= $input ?> class="form-control " name="recipt" id="file_receipt" required="" accept="application/pdf">
                                <div class="text-danger">Only :  .pdf</div>
                                <br>
                            </div>
                            <!--<div >-->
                            <?php
                            $button = "";
                            // if($exemption_yes_no =='no'){
                            if ($file_uploaded) {
                                $button = "disabled";
                            } else {
                                $button = "";
                            }

                            // }
                            ?>
                            <div class="col-sm-2">
                                <button <?= $button ?> class="btn btn_green_yellow  float-end" style="padding-left:10px;padding-right:10px" id="" type="submit">Upload</button>
                                <!--</div>-->
                            </div>
                        </div>
            </form>

            <?php if ($file_uploaded) { ?>
                <div style="margin-top: -21px; margin-left: 119px;">
                    <a href="<?= base_url($document_path . '/' . $document_full_name); ?>" target="/blank">
                        <?= $document_name ?>
                    </a>
                    <a onclick="delete_file(<?= $document_id ?>)" class="text-danger">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            <?php } ?>

            <?php
            
            $value = "";
            if ($exemption_yes_no == 'no') {
                // echo "ghghfg";
                $value = 'display: none';
            }
            if (!$file_uploaded_ex) {
                $value = 'display: none';
            }
            ?>
            <?php 
            if($enroll_stage_4 != 1){
            ?>
            <div id="exemption_form_file" style="<?= $value ?>">
                <?php
                if (!$document_id_ex) {
                    $exe_input = "";
                    $button_ex = "";  // vishal 29-05-2023  add
                } else {
                    $exe_input = "disabled";
                    $button_ex = "disabled";  // vishal 29-05-2023  add
                }
                //  echo $document_id_ex;
                // echo $document_id_ex;

                // vishal 29-05-2023   hide code
                // if ($document_id_ex) {
                //     $button_ex = "disabled";
                // } else {
                //     $button_ex = "";
                // }
                // echo $button_ex;
                ?>
                <!--<b>Exemption Form <span class="text-danger">*</span></b>-->
                <!--<div style="display: flex;">-->
                <!--    <div class="col-sm-10">-->
                <!--        <input type="file" <?= $exe_input ?> class="form-control " name="file_exemption" id="file_exemption" accept="application/pdf">-->
                <!--        <div class="text-danger">Only :  .pdf</div>-->
                <!--    </div>-->
                <!--    <div class="col-sm-2" >-->
                <!--        <a class="btn btn_green_yellow <?= $exe_input ?>  float-end" style="padding-left:10px;padding-right:10px" id="" onclick="exeption_form()">Upload</a>-->
                <!--    </div>-->
                <!--</div>-->
                <?php
                // echo "hgdhghgfh";
                // print_r($document_id_ex);
                if ($document_id_ex) { ?>
                <!--    <div style="margin-left: 119px;margin-bottom: 20px;">-->
                <!--        <a href="<?= base_url($document_path_ex . '/' . $document_full_name_ex); ?>" target="/blank">-->
                <!--            <?= $document_name_ex ?>-->
                <!--        </a>-->
                <!--        <a onclick="delete_file(<?= $document_id_ex ?>)" class="text-danger">-->
                <!--            <i class="bi bi-trash-fill"></i>-->
                <!--        </a>-->
                <!--    </div>-->
                <?php } ?>
            </div>
            <?php 
            }
            ?>
        </div>
    </div>
</div>

<?php
$show_check_box = false;
 $sub_buton = "disabled";
//   echo $document_id;
if ($document_id) {
    if ($exemption_yes_no == "no") {
        $show_check_box = true;
        $sub_buton = "";
    } 
    else {
            $show_check_box = true;
                $sub_buton = "";
        
    }
    if($enroll_stage_4){
         $show_check_box = true;
        $sub_buton = "";

    }
    
    
    
}
?>
<?php if ($show_check_box) { ?>
    <div class="mt-1" style="margin-left:10%">
        <!--<form action="" method="post" id="s3_submit_stage">-->
            <div class="form-check " style="margin-left:-30px;  margin-top: 30px;">
                <input class="form-check-input" type="checkbox" id="all_check" required />
                <label class="form-check-label" for="all_check">
                    I understand &amp; agree that once I submit the documents, I will not be able to remove or change these documents.
                </label>
            </div>
            <!--<a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green" style="margin-left:35%;" id="back_btn" onclick="history.back()"> Back</a>-->
            <!--<a class="btn btn_green_yellow" style="margin-left:1%;" onclick="validateForm()">Submit</a>-->
        <!--</form>-->
    </div>
<?php } ?>

<div class="text-center" style="padding: 30px;">
    <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" id="cancel" class="btn btn_yellow_green back_btn_id">Back</a>
    <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" type="submit" class="btn btn_green_yellow" id="action_validation_btn">Save & Exit</a>
    <button type="submit" id="next" <?=$sub_buton?> class="btn btn_yellow_green" id="action_validation_btn_submit" onclick="backend_data()">Submit</button>
    <!--<a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" id="cancel" class="btn btn_yellow_green " <?= $button ?>>Next</a>-->
     
</div>

</div>
 <!--//<button onclick="storepdf()">Click me</button>-->


<!-- -----------------table---------------- -->

<!--  onsubmit="return validateForm()" -->


</div>

<!--    <?php if (!$file_uploaded) { ?>-->
<!--        <br>-->
<!--        <br>-->
<!--        <div class="mt-4" style="margin-left:10%">-->
<!--            <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green" style="margin-left:35%;     padding-left: 20px !important;-->
<!--padding-right: 20px !important;" id="back_btn" onclick="history.back()"> Back</a>-->
<!--        </div>-->
<!--        <br> <br>-->
<!--        <br> <br>-->
<!--        <br>-->
<!--    <?php } ?>-->

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
<div class="modal fade" id="myModalpopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-green text-white text-center pt-1 pb-1">
                                            <h5 style="margin: 0 auto;">Important</h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <h5 style="text-align: justify">Exemption criteria for onshore applicants has changed.So,kindly read the instructions carefully before submitting the Stage 3.</h5>
                                        <div style="display: flex; justify-content: center;margin-top: 20px;">
                                            <button style="text-align: center;" type="button" onclick="hide_model()" class="btn btn_yellow_green" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    // jQuery('#next').addClass('disabled');

    function __show_Form() {
        $('#postal_box').hide();
        //console.log("dfgdfh");
        $("#upload_form").show();
        $('#form_data').show();
        var download_ex_form = 1;
        var exemption_yes_no = document.querySelector('input[name="exemption_yes_no"]:checked');
         $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/exemption_data/' . $ENC_pointer_id) ?>',
            'type': 'post',
            'data': {
                'download_ex_form': 1,
                'exemption_yes_no': exemption_yes_no.value,
                'preference_location': $('#preference_location').val(),
                'preference_comment': $('#preference_comment').val(),
                'recipt_number' :$('#recipt_number').val(),
                'payment_date' :$('#payment_date').val(),
            },
             success: function(data) {
            // console.log($('#payment_date').val());
            // return;
                 let inputElement = document.getElementById("download_ex_form");
                inputElement.value = 1;

                // console.log("---------------------------" + data);
            }
        });
       
    }
    
      // save on change 
    function save_Preferred_info_() {
        var exemption_yes_no = document.querySelector('input[name="exemption_yes_no"]:checked');
        // console.log(exemption_yes_no.value);
        // return;    
        // var selectedValue = selectedGender.value;

       // var download_ex_form = document.getElementById("download_ex_form").value;

        $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/exemption_data/' . $ENC_pointer_id) ?>',
            'type': 'post',
            'data': {
                
                'exemption_yes_no': exemption_yes_no.value,
                'preference_location': $('#preference_location').val(),
                'preference_comment': $('#preference_comment').val(),
                'recipt_number' :$('#recipt_number').val(),
                'payment_date' :$('#payment_date').val(),
            },
            success: function(data) {
            // console.log($('#payment_date').val());
            // return;
                // $("#download_ex_form").
                let inputElement = document.getElementById("download_ex_form");
                inputElement.value = 1;

                // console.log("---------------------------" + data);
            }
        });
    }


// Mohsin Coding Here 
    // //     var enroll_stage4 = < ($enroll_stage_4) ? $enroll_stage_4 : 0 ?>;
    // //     console.log(enroll_stage4);
    ////   if(enroll_stage4 == 1){
    ////           $("#upload_form").show(); 
    // //         }
    // //         else{
                
    //         //   $("#postal_box").hide(); 
            // // }
        // 

    function postal_hide(data) {
        // $("#postal_box").hide(); 
        var value = data;
        var inputElement = document.getElementById("preference_comment");
        
        // Check For P1 - E/P
        
        
        
        // End
        if (data == 'yes') {
                        //   $("#upload_form").show(); 

            // vishal 29-05-2023 
            $('#preference_comment').attr('placeholder', `Examples: 
    * The applicant would need 2 weeks notice for the interview. 
    * The applicant is currently away, kindly schedule the interview after DD/MM/YYYY.`);

            // $('#file_exemption').prop('required', true);

            $("#upload_form").hide();
            $("#ads_auto").hide();
            //
            __show_Form();
             var enroll_stage4 = <?= ($enroll_stage_4) ? $enroll_stage_4 : 0 ?>;
             console.log(enroll_stage4);
            if(enroll_stage4 == 1){
               $("#upload_form").show(); 
            }
            // 
            if(enroll_stage4 != 1){
                document.getElementById('postal_box').style.display = 'block';
            }else{
                document.getElementById('postal_box').style.display = 'none';
            }
            // console.log("Here");
            $('#preference_location').append(`<option>Online (Via Zoom)</option>`);
            // $('#preference_location option[value=Online (Via Zoom)]').attr('selected','selected');
            $('#preference_location').val('Online (Via Zoom)');
            $("#preference_location").attr("disabled", true);
            if(enroll_stage4 != 1){
                $("#file_exemption").attr("required");
                $("#exemption_form_file").show();

            }
            
            //  inputElement.placeholder = "Examples: * Applicant is travelling from WA to the NSW centre, so he/she would need 2 weeks notice for the interview. * The applicant is currently away, kindly schedule the interview after DD/MM/YYYY.";

        } else {
            $("#postal_box").hide();
                //   $postal_box = 'display:none';

            // vishal 29-05-2023 
            $('#preference_comment').attr('placeholder', `Examples:  
    * The applicant would need 2 weeks notice for the interview. 
    * The applicant is currently away, kindly schedule the interview after DD/MM/YYYY.`);
    document.getElementById('postal_box').style.display = 'none';

            $("#upload_form").show();
            $("#exemption_form_file").hide();
            $("#file_exemption").removeAttr("required");
            $("#preference_location option:contains('Online (Via Zoom')").remove();
            $("#preference_location").removeAttr("disabled", false);

            //   inputElement.placeholder = "New Placeholder";


        }

        document.getElementById('form_data').style.display = 'block';

        $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/exemption_data/' . $ENC_pointer_id) ?>',
            'type': 'post',
            'data': {
                'exemption_yes_no': data,
                'preference_location': $('#preference_location').val(),
                'preference_comment': $('#preference_comment').val(),
                'recipt_number' :$('#recipt_number').val(),
                'payment_date' :$('#payment_date').val(),
            },
            success: function(data) {
            }
            
        });
        
    }

    function validateForm() {
       
       
        //  working
               var user_type = '<?php echo session()->get('account_type'); ?>'; 
            //   console.log(user_type);
               if (user_type == 'Applicant') {
                   var body_msg= 'Do you confirm that you have read & understood the criteria and consequences and wish to submit Stage 3 Application ?';// Code to execute if user_type is 'applicant'
                } else {
                  var body_msg= 'Do you confirm that you have discussed the criteria and consequences with the applicant and wish to submit Stage 3 Application ?';
                  // Code to execute if user_type is not 'applicant'
                }
                var userValidation = $("#all_check")[0].checkValidity();
        
                let isChecked = $('#all_check').is(':checked');
        
                if (!isChecked) {
        
                    $("#all_check")[0].setCustomValidity("Please check the checkbox.");
        
                    $('#all_check')[0].reportValidity();
        
                    return false;
                }
        
                custom_alert_popup_show(header = '', body_msg, close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes & Submit', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                // check Btn click
                $("#AJDSAKAJLD").click(function() {
                    // if return true 
                    if (custom_alert_popup_close('AJDSAKAJLD')) {
                        $('#cover-spin').show(0);
                         $.ajax({
                            'url': '<?= base_url('user/stage_3_reassessment/submit_pageseconds3/' . $ENC_pointer_id) ?>',
                            'type': 'post',
                            success: function(data) {
                                    $('#cover-spin').hide(0);
                                //   return data;
                                    window.location = "<?= base_url('user/view_application/' . $ENC_pointer_id) ?>";
                                    
                            }
                            
                        });
       
                                            // window.location = "<?= base_url('user/stage_3/submit_/' . $ENC_pointer_id) ?>";
                        // $("#s3_submit_stage").submit();
                        return true;
                    } else {
                        $('#cover-spin').hide(0);
                        return false;
        
                    }
                });

    }

function backend_data(){
     $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/valication/' . $ENC_pointer_id) ?>',
            'type': 'post',
            success: function(result) {
                result = JSON.parse(result);
                if (result["error"] == "1") {
                    custom_alert_popup_show(header = '', body_msg = result["msg"], close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);
                }

              if (result["error"] == "0") {


                        validateForm(); 
                         storepdf();

                

                }

            },

            beforeSend: function(xhr) {

                console.log('file_validate Start.......');

            }

        });

    }


    //on change
    function get_addresh(value) {
    console.log(value);
        $('#ads_auto').html('');
        $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/get_addresh_') ?>',
            'type': 'post',
            'data': {
                'city_name': value,
            },
            success: function(data) {
                // Check for No Change
                
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
                    html = '<div class="row"> <div class="col-3"><b>Venue :</b> </div> <div class="col-9"> ' + data['venue'] + '</div>  <div class="col-3"><b> Address : </b> </div>  <div class="col-9">  ' + data['office_address'] + '</div></div><br> <b >  Are you sure you want to choose the above venue for the technical interview ? </b>  ';
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

    function exeption_form() {

        var fileInput = document.getElementById("file_exemption");

        if (!$("#file_exemption").val()) {
            custom_alert_popup_show(header = '', body_msg = "Please select a file.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
            return false;
        }

        var file = fileInput.files[0];

        var formData = new FormData();
        formData.append("file_exemption", file);

        $('#cover-spin').show();
    

        $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/exemption_form/' . $ENC_pointer_id) ?>',
            'type': 'POST',
            'data': formData,
            'contentType': false,
            'processData': false,
            success: function(data) {
                console.log(data);
                $('#cover-spin').hide();
                    // console.log("SOS");
                    // return;
                window.location.reload();
                // console.log("---------------------------" + data);
            }
        });
        
        // return;
    }

  
    // on load page check old data -- back here mohsin
    <?php if (isset($preference_location) && !empty($preference_location) && $enroll_stage_4 == 0) { ?>
        $('#ads_auto').html('');
        $.ajax({
            'url': '<?= base_url('user/stage_3_reassessment/get_addresh_') ?>',
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

    //  function loader(){
    //     $('#cover-spin').show();
    //       setTimeout(() => {
    //                   $('#cover-spin').hide();
    //         },10000); 
    //  }

    var pointer_id = "<?= $ENC_pointer_id ?>";
    var pointerid= "<?= $pointer_id ?>";;

    $(document).ready(function() {
        console.log("ready");
        $("#tra_form").submit(function(e) {
            e.preventDefault();
            $("#loader-please-wait").show();
            var formData = new FormData($(this)[0]);
            $('#cover-spin').show();
            $.ajax({
                method: "POST",
                url: "<?= base_url('user/stage_3_reassessment/receipt_upload_action') ?>/" + pointer_id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // return;
                    $('#cover-spin').hide();
                    window.location.reload();

                    // console.log("---------------------------" + res);

                }
            })
        });
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
                    url: "<?= base_url("user/stage_3_reassessment/receipt_upload_delete") ?>/" + pointer_id + "/" + documnet_id,
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
</script>
<script type="text/javascript">
    function hide_model() {
        $('#myModalpopup').modal('hide');
    }
    $(window).on('load', function() {
        
        // $('#myModalpopup').modal('show');
        <?php 
        $session = session();
        ?>
        var __isShow = <?= ($session->__show_popup) ? $session->__show_popup : 0 ?>;
        console.log(__isShow);
        if(__isShow){
            $('#myModalpopup').modal('show');
        }
        <?php
        $session->set('__show_popup', false);
        ?>
    });
</script>
<script>
 function storepdf() {
    // Replace 'your_parameter' with the actual value you want to pass to the route
          var selectElement = document.getElementById("preference_location");
            var selectedValue = selectElement.value;

    // Make an AJAX GET request to the CodeIgniter route
    $.ajax({
        url: '<?= base_url('user/stage_3_reassessment/storepdf/') ?>/' + pointerid,
        type: 'GET',
         data: { locations: selectedValue },
        beforeSend: function() {},
        success: function(data) {
            // Handle the response data if needed
            console.log(data);
        },
        error: function(xhr, status, error) {
            // Handle errors if the request fails
            console.error(xhr.responseText);
        }
    });
}

</script>
<?= $this->endSection() ?>
<?= $this->extend('template/user_template') ?>

<?= $this->section('main') ?>

<style>
    label {

        margin-bottom: 0px !important;

        margin-bottom: 1px !important;

    }
    .doc_link{
        text-decoration: none !important;
        color: var(--green);
    }

    .doc_link:hover{
        cursor: pointer;
    }



    .delete_button {

        height: 25px !important;

        width: 25px !important;

        padding: 0px;

    }

#required_text{
    color:red;
}


    select option:before {

        content: "*" !important;

        /* Insert star symbol */

        margin-right: 5px !important;

        /* Add some space between the star and text */

        color: red !important;

        /* Color the star symbol in red */

    }



    select option {

        color: black !important;

        /* Color the select option text in black */

    }

    .company {
        border-style: solid;
        border-color: #055837;
        border-radius: 5px;

    }
</style>



<!-- inner heading  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">

    <b> Stage 2 - Documentary Evidence <?= helper_get_applicant_full_name($ENC_pointer_id); ?>

    </b>

</div>



<!-- start -->

<div class="container-fluid mt-4 mb-4">



    <!-- Alert on set - Flashdata -->





    <!-- center div  -->

    <div class="col-md-12">

        <div class="row">

            <div class="col-6">
                <div class="row">

                
            <!-- Employment Documents -->

            <div class="col-sm-12">

                <span class="text-green" style="font-size: 23px;"> Employment Documents </span>

                <div class="col-sm-12 p-4 bg-white shadow">

                    <select class="form-select" id="Employe_id" name="Employe_id" onchange="GET_employment_document_list(this.value)">

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

                <!-- END Employe Documnet -->

                                
            <div class="col-sm-12 my-2">

<!-- Sample-->

<div class="accordion accordion-flush" id="accordionFlushExample">

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

                <div class="accordion-item">

                    <h2 class="accordion-header company rounded" id="flush-headingOne">

                        <button class="accordion-button collapsed shadow rounded " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?= $employee_id_1 ?>" aria-expanded="false" aria-controls="flush-collapseOne" style="">

                            <?php
                            $i = 0;
                            foreach ($documents_TB as $key => $value) {


                                $employee_id = $value['employee_id'];

                                if ($employee_id_1 == $employee_id) {

                                    $i++;
                                }
                            }
                            ?>


                            <?= $company_organisation_name ?> (<?php echo $i; ?>)

                        </button>

                    </h2>
                    </br>
                    <div id="flush-collapseOne<?= $employee_id_1 ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                        <div class="accordion-body">

                            <table class="table w-100">

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

                                                    <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">

                                                        <?= $value['name'] ?></a>




                                                    <!-- <?= $value['document_path'] ?> <?= $value['document_name'] ?> -->

                                                </td>

                                                <td class="text-center">

                                                    <button type="button" onclick="delete_file('<?= $value['id'] ?>','tr_<?= $value['id'] ?>')" class="btn btn-sm btn-danger" style="margin-bottom:10px" style="margin-bottom:10px"> <i class="bi bi-trash"></i></button>

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


<!-- End Empployee Document -->



                </div> <!-- Row END -->
            </div>
            <div class="col-6">

                <div class="row">
                
                
            <!-- Assessment Documents -->

            <div class="col-sm-12">

                <span class="text-green" style="font-size: 23px;"> Assessment Documents </span>

                <div class="col-sm-12 p-4 bg-white shadow">

                    <div class="col-sm-12" id="assessment_documents_list">

                    </div>

                    <div class="col-sm-12 mt-3" id="assessment_documents_info">

                    </div>

                </div>

                </div>

                <!-- END Assesment Doument List -->


                
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

    <div class="col-sm-12 my-2">

        <div class="col-sm-12">

            <div class="bg-white shadow" id="assessment_documents_list_tb">

                <div class="mb-2 p-4">

                    
                    <table class="table w-100">

                        <thead>

                            <tr>

                                <th style="width: 10%;">Sr.No.</th>

                                <th style="width: 85%;">Document Name</th> <!-- 29-Aug-2022 / vishal h patel  -->

                                <th class="text-left" style="width: 5%;">

                                    Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $i = 0;
                            echo "</pre>";
                            $supporting_docs=array();
                            foreach ($documents_TB as $key => $value) {
                                if($value['required_document_id']==16){
                                    array_push($supporting_docs,array('id'=>$value['id'],'path'=>$value['document_path'],'name'=>$value['document_name'],'name_'=>$value['name']));

                                
                                }
                                else{
                                
                                if ($value['employee_id'] == 0 || $value['employee_id'] == "") {

                                    $i++; ?>

                                    <tr id="tr_<?= $value['id'] ?>">

                                        <td>

                                            <?= $i ?>

                                        </td>

                                        <td>
                                            <a href="<?= base_url() . "/" . $value['document_path'] . '/' . $value['document_name']  ?>" target="_blank">

                                                <?= $value['name'] ?></a>

                                            <!-- <?= $value['document_path'] ?> <?= $value['document_name'] ?> -->

                                        </td>

                                        <td class="text-center">

                                            <button type="button" onclick="delete_file('<?= $value['id'] ?>','tr_<?= $value['id'] ?>')" class="btn btn-sm btn-danger"> <i class="bi bi-trash"></i></button>

                                        </td>

                                    </tr>
                                
                                <?php } } ?>
                                
                            <?php } ?>
                           
                                 <?php if(!empty($supporting_docs)){
                                // print_r($supporting_docs);?>
                                 
                                     
                             
                           
                                    <tr id="tr_<?= $value['id'] ?>">

                                        <td style="width:10%;text-align:top" VALIGN=TOP>

                                            <?= $i+1 ?>

                                        </td>

                                        <td style="width:85%;">
                                          

                                 <b style="font-size=11px">Supporting Evidence For Application Kit </b></br>
                                 <ol type="a"	>
                                       <?php
                            foreach ($supporting_docs as $key => $value) {
                          //  print_r($value);

                                 ?>
                                        <li> 
                                        <div class="row">
                                            <div class="col-md-10">
                                         <a href="<?= base_url() . "/" . $value['path'] . '/' . $value['name']  ?>" target="_blank"> <?= $value['name_'] ?></a>
                                               
                                            </div>
                                            <div class="col-md-2">
                                             <button type="button" onclick="delete_file('<?= $value['id'] ?>','tr_<?= $value['id'] ?>')" class="btn btn-sm btn-danger" style="margin-bottom:02px;"> <i class="bi bi-trash"></i></button>
                                           
                                            </div>
                                        </div>

                                    

</li>   
                                            <!-- <?= $value['path'] ?> <?= $value['name'] ?> -->

                                                                                                <?php  } ?>
                                        </ol>

                                        </td>

                                        <td class="text-center" style="width:5%;">
                                        <?php foreach ($supporting_docs as $key=>$value ) { ?>
                                        <?php } ?>
                                        </td>

                                    </tr>

                               <?php       } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

<?php } ?>


<!-- End Assesment document List -->



                </div> <!-- End Of Row -->


            </div>

            


            <div class="form-check  mx-3 mt-3">

                <input class="form-check-input" value="" type="checkbox" id="all_check" name="all_check" required />

                <label class="form-check-label" for="all_check">

                    I understand &amp; agree that once I submit the documents, I will not be able to remove or change these documents.

                </label>

            </div>

            <div class="d-flex justify-content-center mt-4 mb-4">

                <a href="<?= base_url('user/stage_2/add_employment/' . $ENC_pointer_id) ?>" class="btn btn_green_yellow" id="save"> Back</a>

                <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green mx-3" id="save_exit">Save &amp; Exit</a>

                <button type="button" class="btn btn_green_yellow" onclick="stage_2_document_varification()">Submit</button>

            </div>





        </div>

    </div>

</div>



<?= $this->endSection() ?>



<!---------- custom_script -->

<?= $this->section('custom_script') ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("Document ready");

        // Assuming the form is loaded dynamically via AJAX
        $(document).on('submit', 'form', function(event) {
            event.preventDefault();
            $('#cover-spin').show(0);
            console.log('Submit Assessment_Documents_form');
            
            // You can add additional logic or AJAX submission here if needed
        });
    });
</script>

<!-- Employment Documents  // file list auto change with Employment Type  -->

<script type="text/javascript">
    const MAX_FILE_SIZE = 30 * 1024 * 1024; // 30 MB in bytes


    


    // function checkFileSize() {

    //     const fileInput = document.getElementById('file-input');

    //     if (fileInput.files.length > 0) {

    //         const fileSize = fileInput.files[0].size;

    //         if (fileSize > MAX_FILE_SIZE) {

    //             alert('File size is too large. Maximum allowed size is 30 MB.');

    //             return false;

    //         }

    //     }

    //     return true;

    // }



    // const form = document.getElementById('stage_2_employe_form');

    // form.addEventListener('submit', function(e) {

    //     if (!checkFileSize()) {

    //         e.preventDefault(); // prevent form submission

    //     }

    // });











    var employment_prevoius_select_value = ""; 

    function GET_employment_document_list(employer_id) {

        
        if(is_uploading_file){
            $("#Employe_id").val(employment_prevoius_select_value);
            custom_alert_popup_show(header = '', body_msg = "File upload in progress.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
            return;
        }
        
        if(is_attach_file){
            $("#Employe_id").val(employment_prevoius_select_value);            
            custom_alert_popup_show(header = '', body_msg = "Complete Attaching the Files.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
            return;
        }

        employment_prevoius_select_value = employer_id;
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



    function file_select_(input) {

        if (input) {

            checkFileSize(input);

        }

        // $('#employe_document_btn').show();

    }





    function GET_assessment_documents_list(employer_id) {

        console.log("GET_assessment_documents_list");
//return;
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
                
                $('select option[value="34"]').insertAfter($('select option[value="15"]'));

            },

            error: function(restResponse) {

                document.getElementById('assessment_documents_list').innerHTML = "";

            }



        });

    }

    GET_assessment_documents_list();

    // 
    // stage_2_employe_form

    // $("#stage_2_employe_form").submit((e) => {
    //   e.preventDefault();
    //   console.log("Here");
    // });




    var prevoius_select_assessment = "";
    function GET_assessment_documents_info(document_id) {
        
        
        if(is_uploading_file){
            $("#assessment_docs_type").val(prevoius_select_assessment);            
            custom_alert_popup_show(header = '', body_msg = "File upload in progress.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
            return;
        }
        
        
        if(is_attach_file){
            $("#assessment_docs_type").val(prevoius_select_assessment);            
            custom_alert_popup_show(header = '', body_msg = "Complete Attaching the Files.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
            return;
        }

        prevoius_select_assessment = document_id;

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

                // console.log(data);

                document.getElementById('assessment_documents_info').innerHTML = JSON.parse(data);

            },

            error: function(restResponse) {

                document.getElementById('assessment_documents_info').innerHTML = "";

            }



        });

    }

    var is_attach_file = 0;
    function __attach_the_files(){
        location.reload();
    }

    function delete_file(id, tr_id, no_reload = "") {

        if(!no_reload){
            
            if(is_uploading_file){            
                custom_alert_popup_show(header = '', body_msg = "File upload in progress.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
                return;
            }
            
            if(is_attach_file){            
                custom_alert_popup_show(header = '', body_msg = "Complete Attaching the Files.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
                return;
            }
        }

        // creat alert box 

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this file? ", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');



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

                            if(no_reload == 1){
                                $('#' + tr_id).remove();
                                __attach_btn();
                                return;    
                            }

                            $('#' + tr_id).hide(500);

                            location.reload();
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
          
         if(div_id == 'add_more_input_for_multiple_Assessment'){
            var input='<input class="form-control " type="hidden" id="sopportive_evidance" value="sopportive_evidance"/>';
         }else{
            var input="";
         }


        var data = `<div id="wrapper-${count}" class="pt-2"> <div class="row">

                             <div class="col-sm-6">

                                                                                              <input class="form-control " type="text"  name="file_name[]" required /><span id="required_text"></span>
                                                                                              ${input}
                                                                                                </div>

                                                                                                <div class="col-sm-5" style="padding-left: 0px;">

                                                                                                 <input class="form-control col-sm-4" onchange="file_select_()" type="file"  name="files[]" accept=".jpg,.jpeg,.heif,.mp4,.mkv,.pdf" required  />
                                                                                               
                                                                                                </div>

                                                                                                <div class="col-sm-1" style="padding-left: 0px;">

                                                                                                    <button type="button" onclick="delete_div(\'#wrapper-${count}\')"  class="btn btn-danger delete_button ml-3 align-middle  align-self-center" style="  font-size:90%;  margin-top: 5px;" id="btn-cross-${count}">

                                                                                                    <i class="bi bi-x-lg"></i>

                                                                                                    </button>

                                                                                                </div>

                                                                                            </div>

                                                                                    </div>`;

        count++;

      //  $("#" + div_id).append(data);
         $("#" + div_id).prepend(data);


    }
    
     var sr = 0;
     var sr_ = 1;
function add_more_input__(div_id) {
    console.log(sr);
    console.log(sr_);
          var className = 'add_more_input_for_multiple_Assessment';
         if(div_id == 'add_more_input_for_multiple_Assessment'){
            var input='<input class="form-control " type="hidden" id="sopportive_evidance" value="sopportive_evidance"/>';
         }else{
            var input="";
         }
           
// var btn = document.getElementById("btn-plus");
// btn.innerHTML = '<button type="button" onclick="delete_div(\'#wrapper' + count + '\')" class="btn btn-danger delete_button ml-3 align-middle align-self-center" style="font-size:90%; margin-top: 5px;" id="btn_add' + count + '"><i class="bi bi-x-lg"></i></button>';

        var data = `<div id="wrapper-${sr_}" class="pt-2"> <div class="row mb-2">

                             <div class="col-sm-6">

                                                                                              <input class="form-control"  type="text" onchange="file_select_(this)"  name="file_name[]" required /><span id="required_text"></span>
                                                                                               ${input}
                                                                                                </div>

                                                                                                <div class="col-sm-5" style="padding-left: 0px;">

                                                                                                 <input class="form-control col-sm-4" onchange="file_select_(this)" type="file"  name="files[]" accept=".jpg,.jpeg,.heif,.mp4,.mkv,.pdf" required  />
                                                                                               
                                                                                                </div>

                                                                                                <div class="col-sm-1" style="padding-left: 0px;">

                                                                                                    <button type="button" onclick="delete_div(\'#wrapper-${sr}\')"  class="btn btn-danger delete_button ml-3 align-middle  align-self-center" style="  font-size:90%;  margin-top: 5px;" id="btn_add-${sr}" value="sr-${sr}">

                                                                                                    <i class="bi bi-x-lg"></i>

                                                                                                    </button>

                                                                                                </div>

                                                                                            </div>

                                                                                    </div>`;



      //  $("#" + div_id).append(data);
         //$("#" + div_id).prepend(data);
             $("." + className).prepend(data);
             
             
   var btnPlus = document.getElementById("btn-plus");
   var btncross = document.getElementById("btn_add-" + sr);

//alert(btncross.value);
if(btnPlus){
    var buttonHTML = '<button type="button" onclick="delete_div(\'#wrapper-' + sr + '\')" class="btn btn-danger delete_button ml-3 align-middle align-self-center" style="font-size:90%; margin-top: 5px;" id="btn_add-' + sr + '" value="sr-' + sr + '"><i class="bi bi-x-lg"></i></button>';
    var newBtn = document.createElement("div");
    newBtn.innerHTML = buttonHTML;
    btnPlus.parentNode.insertBefore(newBtn, btnPlus);
    btnPlus.style.display = "none"; 
    
}
if(btncross){
  var add_more = '<button style="margin-top: 5px;" type="button" onclick="add_more_input__(\'add_more_input_for_multiple_Assessment\')" class="btn btn-danger delete_button ml-3 align-middle align-self-center" id="btn-plus" value="addbtn"><i class="bi bi-plus-lg"></i></button>';
    var newBtn_ = document.createElement("div");
    newBtn_.innerHTML = add_more;
    btncross.parentNode.insertBefore(newBtn_, btncross);
    btncross.style.display = "none";
}
sr++;
sr_++;

}


    function delete_div(element) {
      
       var idNumber = parseInt(element.split('-')[1]);
       var idNumber_ = parseInt(element.split('-')[1]);
         $(element).remove();
     
   
    }
    
   
</script>



<!-- submit stage 2 and varify  -->

<script>
    function stage_2_document_varification() {

        if(is_uploading_file){
            custom_alert_popup_show(header = '', body_msg = "File upload in progress.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
            return;
        }

        if(is_attach_file){            
            custom_alert_popup_show(header = '', body_msg = "Complete Attaching the Files.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD1221');
            return;
        }

        var userValidation = $("#all_check")[0].checkValidity();

        let isChecked = $('#all_check').is(':checked');



        $.ajax({

            url: '<?= base_url('user/stage_2/add_employment_document_verify_/' . $ENC_pointer_id) ?>',

            success: function(result) {



                result = JSON.parse(result);

                // console.log(result);

                // return;

                if (result["error"] == "1") {

                    // custom_alert_popup_show(header = '', body_msg = "Please upload all the required documents", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);



                    custom_alert_popup_show(header = '', body_msg = result["msg"], close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);

                }

                if (result["error"] == "0") {

                    if (isChecked) {

                        submit_stage_2();

                    } else {

                        $("#all_check")[0].setCustomValidity("Please check the checkbox.");

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
           $('#cover-spin').show(0);
                $.ajax({

                    url: '<?= base_url('user/stage_2/submit_application_/' . $ENC_pointer_id) ?>',

                    success: function(result) {

                        // console.log("submit_stage_1:- " + result);

                        // return;

                        // close loading popup 

                        custom_alert_popup_close('null');



                        if (result == "1") { // Simulate an HTTP redirect :

                            window.location.replace("<?= base_url('user/view_application/' . $ENC_pointer_id) ?>");

                        } else {

                            custom_alert_popup_show(header = '', body_msg = "Submitting the Application is Not Working; <br> Please try again later. If not, kindly contact us at skills@aqato.com.au.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false);

                            $('#cover-spin').hide(0);

                        }



                    },

                    beforeSend: function(xhr) {

                        // custom_alert_popup_show(header = '', body_msg = "loading.....", close_btn_text = 'No', close_btn_css = 'btn-danger d-none', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

                        // console.log('submit_stage_2 start .......');

                        $('#cover-spin').show(0);

                    }



                });



            }

        });

    }


    function checkFileSize(input) {
        $('#employe_document_btn').show();
        var check_type=document.getElementById("assessment_docs_type").value;
        var check_supportive = document.getElementById('sopportive_evidance') ? document.getElementById('sopportive_evidance').value : '';
      // alert(check_supportive)
      console.log(check_type);
        if (input.files && input.files[0]) {
       if(check_supportive == 'sopportive_evidance' && check_type == 16){
     if (input.files[0].size >  1024 * 1024 * 100) {
                custom_alert_popup_show(header = '', body_msg = "File size cannot exceed 100MB.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');
                input.value = '';

                $('#employe_document_btn').hide();

                return;

            }
}else{
   if (input.files[0].size > 1024 * 1024 * 20) {
  custom_alert_popup_show(header = '', body_msg = "File size cannot exceed 20MB.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

                input.value = '';

                $('#employe_document_btn').hide();

                return;

            }

        }
        }

        checkFileType(input);
        
        
        // 
        
        // Select the input element using its name attribute
        var inputFile = document.querySelectorAll('input[name="file_name[]"]');
        
        // Check if any file has been selected
        if (inputFile.length > 0) {
            // Iterate over the files
            for (var i = 0; i < inputFile.length; i++) {
                // Check if the file is empty
                var file_name = inputFile[i].value;
                if(file_name.trim() == ''){
                    $('#employe_document_btn').hide();
                }
                
            }
        } else {
            console.log("No files selected.");
        }
        
        // 
        
        

    }



    function checkFileType(input) {

        if (input.files && input.files[0]) {

            const file = input.files[0];

            const validTypes = input.accept.split(",");

            const fileType = "." + file.name.split(".").pop();

            if (!validTypes.includes(fileType)) {

                alert("Invalid file type. Only " + validTypes.join(", ") + " are allowed.");

                input.value = '';

                $('#employe_document_btn').hide();

                return;

            }

        }

    }

    function __attach_btn(){
        var li_length = $("#render_support_evidence_output li").length;
                
        $("#attach_support_evidence_btn").hide();
        is_attach_file = 0;
        if(li_length > 0){
            is_attach_file = 1;
            $("#attach_support_evidence_btn").show();
        }
        //
    }

    
    function checkSupportEvidenceFileSize(input_id, limit = 100){
        // console.log(input_id);
        var input = document.getElementById(input_id);
        if (input.files[0].size >=  (1024 * 1024 * limit)) {
                custom_alert_popup_show(header = '', body_msg = "File size cannot exceed "+limit+"MB.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD100ds');
                input.value = '';

            }
    }
    
    var is_uploading_file = 0;

    function __addSupportEvidenceForm(Label, File, required_document_id){
        var label_input = $('#'+Label).val();
        label_input = label_input.trim();
        
        
        let file_input = document.getElementById(File).files[0];
        // var file_input = $(File).val();
        var ENC_pointer_id = '<?= $ENC_pointer_id ?>';
        // console.log(pointer_id);
        // return;
        if(!label_input){
            custom_alert_popup_show(header = '', body_msg = "Fill the File Name.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD12');
            return;
        }
        if(!file_input){
            custom_alert_popup_show(header = '', body_msg = "Choose the file.", close_btn_text = 'Ok', close_btn_css = 'btn-danger', other_btn = false, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD12');
            return;
        }

        is_uploading_file = 1;
        var formData = new FormData();
        formData.append("name", label_input);
        formData.append("file", file_input);
        formData.append("ENC_pointer_id", ENC_pointer_id);
        formData.append("required_document_id", required_document_id);
        $(".progress").show();
        
        // var formData = new FormData();
        // formData.append('file', "asdsad");
        $.ajax({
            type: 'POST',
            url: '<?= base_url('user/stage_2/add_employment_document/upload_support_evidence_docs'); ?>',
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
                        $('#a4-progressbar').width(percentVal);
                        $('#a4-progressbar').html(percentVal + ' Uploading ...');
                        // complate progress bar
                        if (percentComplete === 100) {
                            $('#a4-progressbar').html(' File Uploaded. ');
                        }
                    }
                }, false);
                return xhr;
            },
            beforeSend: function() {
                $('#a4-progressbar').hide(100); // file forum hide
                $('#a4-progressbar').show(50); // progress bar show
            },
            success: function(Response) {
                $(".progress").hide();
                is_uploading_file = 0;
                console.log(Response);
                var data_file = JSON.parse(Response);
                console.log(data_file);
                var pre_li = $("#render_support_evidence_output").html();
                var li = `
                    <li style="margin: 5px 0px;" id="support_doc_${data_file["file_id"]}">
                        <a class="doc_link" href="${data_file["file_url"]}" target="_blank">${data_file["file_name"]} </a><button onclick="delete_file('`+data_file["file_id"]+`','support_doc_`+data_file["file_id"]+`',1)" type="button" class="btn btn-sm btn-danger" style="float: right; font-size: 10px;"><i class="bi bi-x bi-sm"></i></button>
                    </li>
                `;

                // Reset
                $('#'+Label).val('');
                $('#'+File).val('');
                // 
                var ul_html = pre_li+li;
                $("#render_support_evidence_output").html(ul_html);
                
                __attach_btn(); 

            },
            error: function(xhr, ajaxOptions, thrownError) {
                // $('#' + progreshBar_div).hide(505); // progress bar hide
                // $('#' + View_file_div).hide(500); // view file link  hide
                // $('#' + Note_div).show(500); // view file link  hide
                // $('#' + Select_file_div).show(550); // file forum show

                // // File icon befor
                // $('#' + tital_icon).html('<i class="bi bi-file-earmark-medical-fill"></i>');
                // hide_view_file(doc_name);

                // console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

            }
        });

        // END
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
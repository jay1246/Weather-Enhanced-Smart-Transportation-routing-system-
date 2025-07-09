<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>
<?php 
// print_r($_SESSION);exit;
?>
<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Forms </b>
</div>

<style>

</style>

<!-- start -->
<div class="container-fluid  mt-4 mb-4">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">


            <!-- form start  -->
            <div class="row mt-5">
                <div class="col-sm-12">


                    <div class="container">

                        <div class="row" style="text-align: center;">


                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <table class="table">
                                    <tr>

                                        <td>
                                            <b> Applicant Declaration </b>
                                        </td>
                                         <td>
                                            <a href="<?= base_url('DS_applicant_declaration_pdf__') ?>" class="btn_green_yellow btn">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <b> Information Release Form</b>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('public/assets/PDF/InformationReleaseForm.pdf') ?>"  class="btn btn_green_yellow" target="_blank">
                                                <i class="bi bi-download"></i>
                                                  </a>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                       $account_type = session()->get("account_type");
                                       $display = '';
                                       if($account_type == 'Applicant')
                                       {
                                           $display = "display : none";
                                       }else{
                                           $display = "";
                                       }
                                    
                                    ?>
                                    <tr style="<?= $display ?>">

                                        <td>
                                            <b> Change of Agent - Authorization Form</b>
                                        </td>
                                        <td>
                                            <a href="https://attc.aqato.com.au/public/assets/PDF/Agent%20Authorisation%20Form_New.pdf" class="btn btn_green_yellow" target="_blank">
                                                <i class="bi bi-download"></i>   </a>
                                        </td>
                                    </tr>
                                    
                                    <tr>

                                        <td>
                                            <b> OSAP/TSS Employment Evidence Template</b>
                                        </td>
                                        <td>
                                            <a href="https://attc.aqato.com.au/public/assets/PDF/OSAP%20Employment%20Evidence%20Template.pdf" class="btn btn_green_yellow" target="_blank">
                                                <i class="bi bi-download"></i>   </a>
                                        </td>
                                    </tr>
                                    
                                    <?php 
                                    $session = session();
                                    if($session->account_type == "Agent"){
                                    ?>
                                    
                                    <tr>

                                        <td>
                                            <b>Stage - 1 Checklist</b>
                                        </td>
                                        <td>
                                            <a href="https://attc.aqato.com.au/public/assets/PDF/Stage 1 Applicant Checklist.pdf" class="btn btn_green_yellow" target="_blank" >
                                                <i class="bi bi-download"></i>   </a>
                                        </td>
                                        
                                    </tr>
                                       <tr>

                                        <td>
                                            <b>Stage - 2  Checklist</b>
                                        </td>
                                        <td>
                                            <a href="https://attc.aqato.com.au/public/assets/PDF/Stage 2 Applicant Checklist.pdf" class="btn btn_green_yellow" target="_blank" >
                                                <i class="bi bi-download"></i>   </a>
                                        </td>
                                        
                                    </tr>
                                    <?php 
                                    }
                                    else{
                                    ?>
                                    
                                  <tr>

                                        <td>
                                            <b>Stage - 1 Checklist</b>
                                        </td>
                                        <td>
                                            <a href="https://attc.aqato.com.au/public/assets/PDF/Stage 1 Applicant Checklist.pdf" class="btn btn_green_yellow" target="_blank" >
                                                <i class="bi bi-download"></i>   </a>
                                        </td>
                                        
                                    </tr>
                                       <tr>

                                        <td>
                                            <b>Stage - 2  Checklist</b>
                                        </td>
                                        <td>
                                            <a href="https://attc.aqato.com.au/public/assets/PDF/Stage 2 Applicant Checklist.pdf" class="btn btn_green_yellow" target="_blank" >
                                                <i class="bi bi-download"></i>   </a>
                                        </td>
                                        
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                    
                                </table>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>


                        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-green">Note:-</h4>
                                    </div>
                                    <div class="modal-body">
                                        <br>These forms are there for your convenience in case they are required after the application lodgement. We encourage you to download & use the forms generated while creating a new application.
                                        <br>
                                        <br>
                                        <div style="display: flex; justify-content: center;">
                                            <button style="text-align: center;" type="button" onclick="hide_model()" class="btn btn_yellow_green" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>





                        <div class="text-center mt-3 mb-3 ">
                            <a href="<?= base_url() ?>" class="btn btn_yellow_green">
                                <b>Back</b>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>

</script>
<script type="text/javascript">
    function hide_model() {
        $('#myModal').modal('hide');
    }
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>
<?= $this->endSection() ?>
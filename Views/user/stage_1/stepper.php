<style>
    .progressbar {
        counter-reset: step;
        padding-left: 0px !important;
    }

    .progressbar li {
        list-style-type: none;
        float: left;
        width: clamp(70px, 200px, 120px);
        position: relative;
        text-align: center;
        color: var(--green);
    }

    .progressbar li a:hover{
        cursor: default;
        text-decoration: none !important;
    }

    .progressbar li:before {
        content: counter(step);
        counter-increment: step;
        line-height: 28px;
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        display: block;
        text-align: center;
        margin: 0 auto 30px auto;
        border-radius: 50%;
        background-color: #fff;
    }

    .progressbar li:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 5px;
        background-color: #ddd;
        top: 15px;
        left: -50%;
        z-index: -1;

    }

    .progressbar li:first-child::after {
        content: none;

    }

    .progressbar li.activei {
        color: var(--green);

    }

    .progressbar li::before {
        border-color: var(--green);

    }

    .progressbar li.activei+li:after {
        background-color: var(--green);
    }

    li.activei::before {
        background-color: var(--yellow);
        color: var(--green);
        font-weight: bold;
    }
</style>


<div class=" bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Stage 1 - Self Assessment <?= helper_get_applicant_full_name($ENC_pointer_id); ?>
    </b>
</div>


<?php


$table_name = 'stage_1_occupation';
$occupation_check = helper_Stepper($ENC_pointer_id, $table_name);
$table_name = 'stage_1_personal_details';
$personal_details_check = helper_Stepper($ENC_pointer_id, $table_name);
$table_name = 'stage_1_contact_details';
$contact_details_check = helper_Stepper($ENC_pointer_id, $table_name);
$table_name = 'stage_1_identification_details';
$identification_details_check = helper_Stepper($ENC_pointer_id, $table_name);
$table_name = 'stage_1_usi_avetmiss';
$usi_details_check = helper_Stepper($ENC_pointer_id, $table_name);
$table_name = 'stage_1_education_and_employment';
$education_and_employment_check = helper_Stepper($ENC_pointer_id, $table_name);


// Applicant_Declaration
// Review_Confirm
// Information_Release_Form
$colum_name = 'review_confirm_pdf_download';
$Review_Confirm_check = Stepper_Applicant_Declaration($ENC_pointer_id, $colum_name);

$colum_name = 'applicant_declaration_file_download';
$Applicant_Declaration_check = Stepper_Applicant_Declaration($ENC_pointer_id, $colum_name);


?>

<div class="containerprogress d-flex justify-content-center mt-2">

    <ul class="progressbar">

        <!-- Occupation -->
        <?php
        $URL_Occupation = base_url('user/stage_1/occupation/' . $ENC_pointer_id);
        $URL_Occupation_url_is = 'user/stage_1/occupation/' . $ENC_pointer_id;
        $class_Occupation = url_is($URL_Occupation_url_is) ? 'text-warning' : 'text-green';
        ?>
        <li class="<?= ($occupation_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_Occupation ?>" href="javascript:void(0)">
                Occupation
            </a>
        </li>


        <!-- Personal_Details -->
        <?php
        $URL_Personal_Details = base_url('user/stage_1/personal_details/' . $ENC_pointer_id);
        $URL_Personal_Details_url_is = 'user/stage_1/personal_details/' . $ENC_pointer_id;
        $class_Personal = url_is($URL_Personal_Details_url_is) ? 'text-warning' : 'text-green ';
        $class_Personal .= ($occupation_check == 1) ? "" : " disabled";

        ?>
        <li class="<?= ($personal_details_check == 1) ? 'activei' : '' ?>">
            <a class=" <?= $class_Personal ?>" href="javascript:void(0)">
                Personal Details
            </a>
        </li>


        <!-- contact_details -->
        <?php
        $URL_Contact_Details = base_url('user/stage_1/contact_details/' . $ENC_pointer_id);
        $URL_Contact_Details_url_is = 'user/stage_1/contact_details/' . $ENC_pointer_id;
        $class_Contact_Details = url_is($URL_Contact_Details_url_is) ? 'text-warning' : 'text-green ';
        $class_Contact_Details .= ($personal_details_check == 1) ? "" : " disabled";
        ?>
        <li class="<?= ($contact_details_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_Contact_Details ?>" href="javascript:void(0)">
                Contact Details
            </a>
        </li>


        <!-- identification -->
        <?php
        $URL_identification = base_url('user/stage_1/identification_details/' . $ENC_pointer_id);
        $URL_identification_url_is = 'user/stage_1/identification_details/' . $ENC_pointer_id;
        $class_identification = url_is($URL_identification_url_is) ? 'text-warning' : 'text-green';
        $class_identification .= ($contact_details_check == 1) ? "" : " disabled";
        ?>
        <li class="<?= ($identification_details_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_identification ?>" href="javascript:void(0)">
                Identification
            </a>
        </li>


        <!-- Unique Student Identifier (USI) -->
        <?php
        $URL_USI = base_url('user/stage_1/usi_avetmiss/' . $ENC_pointer_id);
        $URL_USI_url_is = 'user/stage_1/usi_avetmiss/' . $ENC_pointer_id;
        $class_USI = url_is($URL_USI_url_is) ? 'text-warning' : 'text-green';
        $class_USI .= ($identification_details_check == 1) ? "" : " disabled";
        ?>
        <li class="<?= ($usi_details_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_USI ?>" href="javascript:void(0)">
                USI & Avetmiss
            </a>
        </li>


        <!-- Education & Employment -->
        <?php
        $URL_education_employment_details = base_url('user/stage_1/education_employment_details/' . $ENC_pointer_id);
        $URL_education_employment_details_url_is = 'user/stage_1/education_employment_details/' . $ENC_pointer_id;
        $class_education_employment_details = url_is($URL_education_employment_details_url_is) ? 'text-warning' : 'text-green';
        $class_education_employment_details .= ($usi_details_check == 1) ? "" : " disabled";
        ?>
        <li class="<?= ($education_and_employment_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_education_employment_details ?>" href="javascript:void(0)">
                Education & <br> Employment
            </a>
        </li>


        <!-- Review & Confirm -->
        <?php
        $URL_application_preview = base_url('user/stage_1/application_preview/' . $ENC_pointer_id);
        $URL_application_preview_url_is = 'user/stage_1/application_preview/' . $ENC_pointer_id;
        $class_application_preview = url_is($URL_application_preview_url_is) ? 'text-warning' : 'text-green';
        $class_application_preview .= ($education_and_employment_check == 1) ? "" : " disabled";
        ?>
        <li class="<?= ($Review_Confirm_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_application_preview ?>" href="javascript:void(0)">
                Review & Confirm
            </a>
        </li>


        <?php
        $URL_applicant_declaration = base_url('user/stage_1/applicant_declaration/' . $ENC_pointer_id);
        $URL_applicant_declaration_url_is = 'user/stage_1/applicant_declaration/' . $ENC_pointer_id;
        $class_applicant_declaration = url_is($URL_applicant_declaration_url_is) ? 'text-warning' : 'text-green';
        $class_applicant_declaration .= ($Review_Confirm_check == 1) ? "" : " disabled";
        ?>
        <li class="<?= ($Applicant_Declaration_check == 1) ? 'activei' : '' ?>">
            <a class="<?= $class_applicant_declaration ?>" href="javascript:void(0)">
                Applicant Declaration
            </a>
        </li>



        <li class="<?= (Stepper_isComplete("documents", $ENC_pointer_id) == 1) ? 'activei' : '' ?>">
            <a href="javascript:void(0)">Upload Documents </a>
        </li>



    </ul>

</div>
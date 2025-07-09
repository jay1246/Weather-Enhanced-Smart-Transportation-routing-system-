<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>


<div class="container">

    <!--  Page Title -->
    <div class="pagetitle">
        <h4 style="color: #055837;"> Application Transfer</h4>
    </div><!-- End Page Title -->


    <style>
        .Hi_Lite {
            background-color: var(--offgray);
        }

        .id_row {
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
        }

        .lable_2 {
            font-size: 10px;
            margin-top: 0px;
            margin-bottom: 0px;
        }
    </style>
    <style>
        * {
            max-width: 100%;
            font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        }

        .form_header {
            position: absolute;
            width: 100%;
        }

        .photo {
            width: 200px;
        }

        .stage1,
        .footer,
        .save {
            background-color: #055837;
        }

        .profile_image {
            margin-left: 55%;
            padding: 5% 2% 5% 2%;
            border: 1px solid;
            min-height: 100px;
            min-width: 80px;
            max-height: 200px;
            max-width: 180px;
            float: right;

        }

        .next:hover {
            background-color: #055837;
            color: #fff;
        }

        .back:hover {
            background-color: #055837;
            color: #fff;
        }

        .mt-3 {
            margin-top: 0rem !important;
        }

        .btn-success {
            background-color: #055837 !important;
        }

        .text-success {
            color: #055837 !important;
        }

        .row {
            --bs-gutter-x: 1.5rem !important;
            --bs-gutter-y: 0 !important;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.0 * var(--bs-gutter-x)) !important;
            margin-left: calc(-.0 * var(--bs-gutter-x)) !important;
        }
    </style>


    <!-- pdf data -->
    <div class="container-fluid mb-4 " style="margin-top:90px !important;">
        <!-- Alert on set - Flashdata -->
        <div class="card shadow mt-1">
            <div class="card-body">
                <div id="my_pdf_data">
                    <style>
                        .w-25 {
                            width: 50% !important;
                        }

                        .w-10 {
                            width: 10% !important;
                        }

                        .w-40 {
                            width: 50% !important;

                        }

                        table.print-friendly tr td,
                        table.print-friendly tr th {
                            page-break-inside: avoid;
                        }

                        td.w-40 {
                            padding-left: 20px;
                        }
                    </style>
                    <br>

                    <!-- center div  -->
                    <div class="col-md-12 bg-white  p-0">

                        <h5 class=" text-center text-success Occupation " style="font-size: 23px;">Occupation Details</h5>
                        <div class="d-flex justify-content-center">
                            <table class="table table-borderless table-hover w-80 table-striped print-friendly">

                                <?php if (!empty($occupation['occupation_id'])) { ?>
                                    <tr>
                                        <td class="w-40" class="">Occupation</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?php
                                                            $occupation_id =  $occupation['occupation_id'];
                                                            $occupation_list = find_one_row('occupation_list', 'id', $occupation_id);
                                                            echo $occupation_list->name;  ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($occupation['program'])) { ?>
                                    <tr>
                                        <td class="w-40">Skills Assessment Program</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $occupation['program'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($occupation['pathway'])) { ?>
                                    <tr>
                                        <td class="w-40">Pathway</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $occupation['pathway'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($occupation['currently_in_australia'])) { ?>
                                    <tr>
                                        <td class="w-40">Are you currently in Australia ?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $occupation['currently_in_australia'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($occupation['currently_on_bridging_visa'])) { ?>
                                    <tr>
                                        <td class="w-40">Are you currently on a bridging Visa ?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $occupation['currently_on_bridging_visa'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($occupation['current_visa_category'])) { ?>
                                    <tr>
                                        <td class="w-40">Current Visa Category & Subclass</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $occupation['current_visa_category'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($occupation['visa_expiry'])) { ?>
                                    <tr>
                                        <td class="w-40">Visa Expiry Date </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= date('d/m/Y', strtotime($occupation['visa_expiry']));  ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($occupation['conjunction_with_skills_assessment'])) { ?>
                                    <tr>
                                        <td class="w-40">Which visa do you intend to apply for in conjunction with this skills assessment ?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $occupation['conjunction_with_skills_assessment'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <hr style="text-align: center;" width="100%">

                        <!-- -------------table 2 personal ------------ -->
                        <div class=" justify-content-center Personal_Details">
                            <h5 class="text-center text-success" style="font-size: 23px;">Personal Details (As per Passport)</h5>

                            <table class="table table-borderless table-hover w-100 table-striped print-friendly">
                                <?php if (!empty($personal_details['preferred_title'])) { ?>
                                    <tr>
                                        <td class="w-40">Preferred Title</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $personal_details['preferred_title'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($personal_details['surname_family_name'])) { ?>
                                    <tr>
                                        <td class="w-40">Surname or family Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">
                                            <?php
                                            if (!empty($personal_details['surname_family_name'])) {
                                                echo $personal_details['surname_family_name'];
                                            } else {
                                                echo "Not Applicable";
                                            }  ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($personal_details['first_or_given_name'])) { ?>
                                    <tr>
                                        <td class="w-40">First or given Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25 "><?= $personal_details['first_or_given_name'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($personal_details['middle_names'])) { ?>
                                    <tr>
                                        <td class="w-40">Middle Name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25 "><?= $personal_details['middle_names'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($personal_details['known_by_any_name'])) {
                                    if ($personal_details['known_by_any_name'] == 'no') {
                                ?>
                                        <tr>
                                            <td class="w-40">Are you known by any other Name</td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $personal_details['known_by_any_name'] ?></td>
                                        </tr>
                                    <?php } else {  ?>
                                        <?php if (!empty($personal_details['previous_surname_or_family_name'])) { ?>
                                            <tr>
                                                <td class="w-40">Previous Surname or Family Name</td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $personal_details['previous_surname_or_family_name'] ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($personal_details['previous_names'])) { ?>
                                            <tr>
                                                <td class="w-40">Previous First or given Name</td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $personal_details['previous_names'] ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($personal_details['previous_Middle_names'])) { ?>
                                            <tr>
                                                <td class="w-40">Previous Middle Name</td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $personal_details['previous_Middle_names'] ?>
                                                </td>
                                            </tr>
                                        <?php } ?>


                                <?php }
                                } ?>




                                <!-- 
                                <?php if (!empty($personal_details['other_name'])) { ?>
                                    <tr>
                                        <td class="w-40">Previous first or given name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25">
                                            <?php
                                            if (!empty($personal_details['other_name'])) {
                                                echo $personal_details['other_name'];
                                            } else {
                                                echo "Not Applicable";
                                            }  ?>
                                        </td>
                                    </tr>
                                <?php } ?> -->
                                <?php if (!empty($personal_details['gender'])) { ?>
                                    <tr>
                                        <td class="w-40">Gender</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $personal_details['gender'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($personal_details['date_of_birth'])) { ?>
                                    <tr>
                                        <td class="w-40">Date of Birth</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $personal_details['date_of_birth'] ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </div>
                        <hr style="text-align: center;page-break-after: always;" width="100%">

                        <!-- -----------table 3 contact-------- -->
                        <h5 class=" text-center text-success Contact_Details" style="font-size: 23px;">Contact Details</h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-hover w-100  table-striped print-friendly">
                                <tr>
                                    <td class="w-40">Email</td>
                                    <td class="w-10">:</td>
                                    <td class="w-25"> <?= $contact_details['email'] ?></td>
                                </tr>
                                <?php if (!empty($contact_details['alternate_email'])) { ?>
                                    <tr>
                                        <td class="w-40"> Alternate Email</td>
                                        <td class="w-10">:</td>
                                        <td class="w-25"> <?= $contact_details['alternate_email'] ?></td>
                                    </tr>
                                <?php  } ?>
                                <tr>
                                    <td class="w-40">Mobile Number</td>
                                    <td class="w-10">:</td>
                                    <td class="w-25"> +<?= country_phonecode($contact_details['mobile_number_code']) ?> <?= $contact_details['mobile_number'] ?></td>
                                </tr>
                                <?php if (!empty($contact_details['alter_mobile'])) { ?>
                                    <tr>
                                        <td class="w-40">Alternate Mobile Number
                                        </td>
                                        <td class="w-10">:</td>
                                        <td class="w-25"> +<?= country_phonecode($contact_details['alter_mobile_code']) ?> <?= $contact_details['alter_mobile'] ?> </td>
                                    </tr>
                                <?php  } ?>
                                <tr>
                                    <td colspan="3" class="w-40">
                                        <h5><b> Residential Address </b></h5>
                                    </td>
                                </tr>
                                <?php if (!empty($contact_details['unit_flat_number'])) { ?>
                                    <tr>
                                        <td class="w-40">Unit / Flat Number</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $contact_details['unit_flat_number'] ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="w-40">Street / lot Number </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $contact_details['street_lot_number'] ?></td>
                                </tr>
                                <!-- <?php if (!empty($contact_details['building_prop_name'])) { ?>
                                    <tr>
                                        <td class="w-40">Building / Prop.name</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $contact_details['building_prop_name'] ?></td>
                                    </tr>
                                <?php } ?> -->
                                <tr>
                                    <td class="w-40">Street Name </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $contact_details['street_name'] ?></td>
                                </tr>

                                <tr>
                                    <td class="w-40"> Suburb / City</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $contact_details['suburb'] ?></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Postcode</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $contact_details['postcode'] ?></td>
                                </tr>
                                <tr>
                                    <td class="w-40">State / Province </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $contact_details['state_proviance'] ?></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Country </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $contact_details['country'] ?></td>
                                </tr>


                                <?php if ($contact_details['postal_address_is_different'] == "yes") { ?>
                                    <tr>
                                        <td class="">Postal Address is same as Residential Address </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $contact_details['postal_address_is_different'] ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="3" class="w-40">
                                            <h5><b> Postal Address </b></h5>
                                        </td>
                                    </tr>

                                    <?php if (!empty($contact_details['postal_unit_flat_number'])) { ?>
                                        <tr>
                                            <td class="w-40">Unit / Flat Number</td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_unit_flat_number'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- <?php if (!empty($contact_details['postal_building_prop_name'])) { ?>
                                        <tr>
                                            <td class="">Building / Prop.name</td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_building_prop_name'] ?></td>
                                        </tr>
                                    <?php } ?> -->
                                    <?php if (!empty($contact_details['postal_street_lot_number'])) { ?>
                                        <tr>
                                            <td class="w-40">Street / lot Number </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_street_lot_number'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($contact_details['postal_street_name'])) { ?>
                                        <tr>
                                            <td class="w-40">Street Name </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_street_name'] ?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (!empty($contact_details['postal_suburb'])) { ?>
                                        <tr>
                                            <td class="w-40"> Suburb / City</td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_suburb'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($contact_details['postal_postcode'])) { ?>
                                        <tr>
                                            <td class="w-40">Postcode</td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_postcode'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($contact_details['postal_state_proviance'])) { ?>
                                        <tr>
                                            <td class="w-40">State / Province </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['postal_state_proviance'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($contact_details['Postal_country'])) { ?>
                                        <tr>
                                            <td class="w-40">Country </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $contact_details['Postal_country'] ?></td>
                                        </tr>
                                    <?php } ?>


                                <?php } ?>

                                <?php if (!empty($contact_details['emergency_mobile']) or !empty($contact_details['first_name']) or !empty($contact_details['surname']) or !empty($contact_details['relationship'])) { ?>
                                    <tr>
                                        <td colspan="3" class="w-40">
                                            <h5><b> Emergency Contact Details </b></h5>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($contact_details['first_name'])) { ?>
                                    <tr>
                                        <td class="w-40">First Name </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $contact_details['first_name'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($contact_details['surname'])) { ?>
                                    <tr>
                                        <td class="w-40">Surname </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $contact_details['surname'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($contact_details['relationship'])) { ?>
                                    <tr>
                                        <td class="w-40">Relationship </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $contact_details['relationship'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($contact_details['emergency_mobile'])) { ?>
                                    <tr>
                                        <td class="w-40">Mobile Number </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> +<?= country_phonecode($contact_details['emergency_mobile_code']) ?> <?= $contact_details['emergency_mobile'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <hr style="text-align: center;page-break-after: always;" width="100%">


                        <!-- -----------table 3 Identification Details ---------->
                        <h5 class="text-center text-success Identification_Details" style="font-size: 23px;">Identification Details</h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-striped  w-100 table-striped print-friendly">

                                <tr>
                                    <td class="w-40">Passport Country</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $identification_details['country_of_birth'] ?></td>
                                </tr>


                                <tr>
                                    <td class="w-40">Place of Issue / Issuing Authority</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> <?= $identification_details['place_of_issue'] ?></td>
                                </tr>

                                <tr>
                                    <td class="w-40">Passport Number</td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $identification_details['passport_number'] ?></td>
                                </tr>

                                <tr>
                                    <td class="w-40"> Passport Expiry Date </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"> <?= $identification_details['expiry_date'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <hr style="text-align: center;" width="100%">



                        <!-- -----------table 3 Representative / Agent Details ---------->
                        <h5 class=" text-center text-success USI" style="font-size: 23px;"> Unique Student Identifier (USI)</h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">


                                <?php if (isset($usi_details['currently_have_usi'])) {
                                    if ($usi_details['currently_have_usi'] == "yes") { ?>
                                        <?php if (!empty($usi_details['usi_no'])) { ?>
                                            <tr>
                                                <td class="w-40">USI No.</td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= $usi_details['usi_no'] ?></td>
                                            </tr>
                                        <?php } ?>


                                        <?php if (!empty($usi_details['have_usi_transcript'])) { ?>
                                            <tr>
                                                <td class="w-40"> Do you have a USI Transcript </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= $usi_details['have_usi_transcript'] ?></td>
                                            </tr>
                                            <?php if ($usi_details['have_usi_transcript'] == 'no') { ?>
                                                <tr>
                                                    <td colspan="3" class="w-40">
                                                        <style>
                                                            .bg-warning {
                                                                background-color: #ffc107 !important;
                                                            }

                                                            element.style {}

                                                            .p-2 {
                                                                padding: 0.5rem !important;
                                                            }

                                                            .mb-5,
                                                            .my-5 {
                                                                margin-bottom: 3rem !important;
                                                            }

                                                            .rounded {
                                                                border-radius: 0.25rem !important;
                                                            }
                                                        </style>
                                                        <div class=" instruction col-lg-12 bg-warning rounded p-2 ">
                                                            <b>Note:</b>
                                                            It is a mandatory requirement to verify qualifications for any Skills Assessment Application. If the USI Transcripts are unavailable, we will have to manually verify the qualifications from the RTO which has awarded the qualification.
                                                        </div>
                                                    </td>

                                                </tr>


                                            <?php } ?>
                                        <?php } ?>



                                        <?php if (!empty($usi_details['permission_access_usi_transcripts'])) { ?>
                                            <tr>
                                                <td class="w-40"> I have assigned ATTC permission to access USI Transcripts </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= $usi_details['permission_access_usi_transcripts'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else {
                                    ?>
                                        <tr>
                                            <td class="w-40">I am offshore (outside of Australia) - Do not need any USI </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?php
                                                                if ($usi_details['currently_have_usi'] == "no") {
                                                                    echo "Yes";
                                                                } ?></td>
                                        </tr>
                                <?php
                                    }
                                } ?>


                            </table>
                        </div>
                        <hr style="text-align: center;" width="100%">


                        <h5 class=" text-center text-success USI" style="font-size: 23px;"> Marketing</h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">
                                <tr>
                                    <td class="w-40" style="text-align: justify;"> I give Australian Trade Training College permission to use photos/ images in public material and social media (including any photos/ images where I may be recognised or participating in workplace activities) for current and future marketing and business purposes. I understand that I retain the right to withdraw my consent at any time via email to tra@attc.org.au. </td>
                                    <td class="w-10"><span class="">:</span></td>
                                    <td class="w-25"><?= $usi_details['marketing'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <hr style="text-align: center;page-break-after: always;" width="100%">

                        <!-- hide from applicant  -->
                        <?php if (!is_Agent()) { ?>
                        <?php } else { ?>
                        <?php } ?>

                        <h5 class="text-center text-success Representative_Details" style="font-size: 23px;">Representative Details</h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-striped  w-100 table-striped print-friendly">
                                <?php if (!empty($register_user['name'])) { ?>
                                    <tr>
                                        <td class="w-40">Name of Agent or Representative</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $register_user['name'] ?> <?= $register_user['last_name'] ?> </td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['business_name'])) { ?>
                                    <tr>
                                        <td class="w-40">Company Name (if applicable)</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $register_user['business_name'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['email'])) { ?>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $register_user['email'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['mobile_code'])) { ?>
                                    <tr>
                                        <td class="w-40">Mobile</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> +<?= country_phonecode($register_user['mobile_code']) ?> <?= $register_user['mobile_no'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['tel_code']) && !empty($register_user['tel_no'])) { ?>
                                    <tr>
                                        <td class="w-40">Telephone</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> +<?= country_phonecode($register_user['tel_code']) ?> <?php if (!empty($register_user['area_code'])) {
                                                                                                                    echo $register_user['tel_area_code'];
                                                                                                                } ?> <?= $register_user['tel_no'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['unit_flat'])) { ?>
                                    <tr>
                                        <td class="w-40"> Unit / Flat Number </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> <?= $register_user['unit_flat'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['street_lot'])) { ?>
                                    <tr>
                                        <td class="w-40"> Street / Lot number </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> <?= $register_user['street_lot'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['street_name'])) { ?>
                                    <tr>
                                        <td class="w-40"> Street Name </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> <?= $register_user['street_name'] ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if (!empty($register_user['suburb_city'])) { ?>
                                    <tr>
                                        <td class="w-40"> Suburb / City </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> <?= $register_user['suburb_city'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['state_province'])) { ?>
                                    <tr>
                                        <td class="w-40"> State / Province </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> <?= $register_user['state_province'] ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (!empty($register_user['postcode'])) { ?>
                                    <tr>
                                        <td class="w-40"> postcode </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"> <?= $register_user['postcode'] ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if (isset($register_user['postal_ad_same_physical_ad_check'])) { ?>
                                    <?php if ($register_user['postal_ad_same_physical_ad_check'] == 1) { ?>
                                        <tr>
                                            <td class="w-40">Postal Address Same As Physical Address </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"> Yes</td>
                                        </tr>
                                    <?php } else {  ?>
                                        <tr>
                                            <td colspan="3" class="w-40">
                                                <h5><b> Postal Address </b></h5>
                                            </td>
                                        </tr>
                                        <?php if (!empty($register_user['postal_unit_flat'])) { ?>
                                            <tr>
                                                <td class="w-40"> Unit / Flat Number </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $register_user['postal_unit_flat'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($register_user['postal_street_lot'])) { ?>
                                            <tr>
                                                <td class="w-40"> Street / Lot number </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $register_user['postal_street_lot'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($register_user['postal_street_name'])) { ?>
                                            <tr>
                                                <td class="w-40"> Street Name </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $register_user['postal_street_name'] ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php if (!empty($register_user['postal_suburb_city'])) { ?>
                                            <tr>
                                                <td class="w-40"> Suburb / City </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $register_user['postal_suburb_city'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($register_user['postal_state_province'])) { ?>
                                            <tr>
                                                <td class="w-40"> State / Province </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $register_user['postal_state_province'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($register_user['postal_postcode'])) { ?>
                                            <tr>
                                                <td class="w-40"> Postcode </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"> <?= $register_user['postal_postcode'] ?></td>
                                            </tr>
                                        <?php } ?>



                                <?php
                                    }
                                } ?>

                            </table>
                        </div>


                        <h5 class=" text-center text-success " style="font-size: 23px;"> Avetmiss Details </h5>
                        <div class="d-flex justify-content-center mt">

                            <?php
                            // echo "<pre>";
                            // print_r($usi_details);
                            // echo "</pre>";
                            ?>
                            <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">

                                <?php if (!empty($identification_details['country_of_birth'])) { ?>
                                    <tr>
                                        <td class="w-40"> Country of birth </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $identification_details['country_of_birth'] ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if (!empty($usi_details['speak_english_at_home'])) { ?>
                                    <tr>
                                        <td class="w-40">Do you speak a language other than English at home?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $usi_details['speak_english_at_home'] ?></td>
                                    </tr>
                                    <?php if ($usi_details['speak_english_at_home'] == 'yes') { ?>
                                        <?php if (!empty($usi_details['specify_language'])) { ?>
                                            <tr>
                                                <td class="w-40"> Specify Language </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= $usi_details['specify_language'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($usi_details['proficiency_in_english'])) { ?>
                                            <tr>
                                                <td class="w-40">Proficiency in Spoken English?</td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= $usi_details['proficiency_in_english'] ?></td>
                                            </tr>
                                        <?php } ?>


                                    <?php } ?>
                                <?php } ?>

                                <?php if (!empty($usi_details['are_you_aboriginal'])) { ?>
                                    <tr>
                                        <td class="w-40">Are you of Aboriginal or Torres Strait Islander Origin?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $usi_details['are_you_aboriginal'] ?></td>
                                    </tr>
                                    <?php if ($usi_details['are_you_aboriginal'] == 'yes') { ?>
                                        <?php if (!empty($usi_details['choose_origin'])) { ?>
                                            <tr>
                                                <td class="w-40"> Choose Origin Option </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?php // aboriginal  //   // 
                                                                    if ($usi_details['choose_origin'] == "aboriginal") {
                                                                        echo "Aboriginal";
                                                                    }
                                                                    if ($usi_details['choose_origin'] == "torres_strait_islander") {
                                                                        echo "Torres strait islander";
                                                                    }  ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>








                                <?php if (!empty($usi_details['have_any_disability'])) { ?>
                                    <tr>
                                        <td class="w-40">Do you consider yourself to have a disability, impairment or long-term condition?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $usi_details['have_any_disability'] ?></td>
                                    </tr>
                                    <?php if ($usi_details['have_any_disability'] == 'yes') { ?>
                                        <?php if (!empty($usi_details['indicate_area'])) { ?>
                                            <tr>
                                                <td class="w-40"> Please Indicate Area </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= $usi_details['indicate_area'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>


                                <?php if (!empty($usi_details['Please_indicate_area_NOTE'])) { ?>
                                    <tr>
                                        <td class="w-40"> Please specify Indicate Area </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= preg_replace('/[^A-Za-z0-9\-]/', ' ', $usi_details['Please_indicate_area_NOTE']) ?></td>
                                    </tr>
                                <?php } ?>




                                <?php if (!empty($usi_details['require_additional_support'])) { ?>
                                    <tr>
                                        <td class="w-40">Will you require additional support to participate in this Skills Assessment?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $usi_details['require_additional_support'] ?></td>
                                    </tr>
                                    <?php if ($usi_details['require_additional_support'] == 'yes') { ?>
                                        <!-- <?php if (!empty($usi_details['note'])) { ?> -->
                                        <tr>
                                            <td class="w-40"> Please specify the support </td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= preg_replace('/[^A-Za-z0-9\-]/', ' ', $usi_details['note']) ?></td>
                                        </tr>
                                        <!-- <?php } ?> -->
                                    <?php } ?>
                                <?php } ?>




                            </table>
                        </div>
                        <hr style="text-align: center;page-break-after: always;" width="100%">



                        <h5 class=" text-center text-success" style="font-size: 23px;"> Education Details </h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">

                                <?php if (!empty($education_and_employment['highest_completed_school_level'])) { ?>
                                    <tr>
                                        <td class="w-40"> What is your highest COMPLETED school level ?</td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $education_and_employment['highest_completed_school_level'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">
                                            Are you still enrolled in secondary or senior secondary
                                            education ?
                                        </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= $education_and_employment['still_enrolled_in_secondary_or_senior_secondary_education'] ?></td>
                                    </tr>

                                    <?php if (!empty($education_and_employment['completed_any_qualifications'])) { ?>
                                        <tr>
                                            <td class="w-40">Have you SUCCESSFULLY completed any qualifications ?</td>
                                            <td class="w-10"><span class="">:</span></td>
                                            <td class="w-25"><?= $education_and_employment['completed_any_qualifications'] ?></td>
                                        </tr>
                                        <?php if ($education_and_employment['completed_any_qualifications'] == 'yes') { ?>
                                            <?php if (!empty($education_and_employment['applicable_qualifications'])) { ?>
                                                <tr>
                                                    <td class="w-40"> Applicable Qualifications </td>
                                                    <td class="w-10"><span class="">:</span></td>
                                                    <td class="w-25"><?= str_replace('_', ' ', $education_and_employment['applicable_qualifications']);  ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>


                                <?php } ?>


                            </table>
                        </div>



                        <h5 class=" text-center text-success " style="font-size: 23px;"> Employment Details </h5>
                        <div class="d-flex justify-content-center mt">
                            <table class="table table-borderless table-hover  table-striped  w-100 print-friendly">

                                <?php if (!empty($education_and_employment['current_employment_status'])) { ?>
                                    <tr>
                                        <td class="w-40"> What is your current employment status ? </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= str_replace('_', ' ', $education_and_employment['current_employment_status']); ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if (!empty($education_and_employment['reason_for_undertaking_this_skills_assessment'])) { ?>
                                    <tr>
                                        <td class="w-40"> What BEST describes your main reason for undertaking this skills assessment ? </td>
                                        <td class="w-10"><span class="">:</span></td>
                                        <td class="w-25"><?= str_replace('_', ' ', $education_and_employment['reason_for_undertaking_this_skills_assessment']); ?></td>
                                    </tr>
                                    <?php if ($education_and_employment['reason_for_undertaking_this_skills_assessment'] == 'Other_reasons') { ?>
                                        <?php if (!empty($education_and_employment['other_reason_for_undertaking'])) { ?>
                                            <tr>
                                                <td class="w-40"> Please specify the reason </td>
                                                <td class="w-10"><span class="">:</span></td>
                                                <td class="w-25"><?= str_replace('_', ' ', $education_and_employment['other_reason_for_undertaking']);  ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>


                            </table>
                        </div>
                        <hr style="text-align: center;" width="100%">


                    </div> <!-- my_pdf_data -->



                </div>
            </div>
        </div>







    </div>



    <!-- save back btn -->
    <div class="mt-4 text-center">
        <a href="<?= base_url('application_transfer/' . $pointer_id) ?>" class="btn_yellow_green btn" style="margin-right: 20px;"> Back</a>
        <a href="javascript:void(0)" onclick="closs()" class="btn_green_yellow btn" style="margin-right: 20px;"> Exit</a>
        <a href="javascript:void(0)" id="submit_next" onclick="Finsh()" class="btn_yellow_green btn"> Complete Transfer </a>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>



<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>


<script>
    function closs() {
        window.location = '<?= base_url() ?>/admin/application_manager/view_application/<?= $pointer_id ?>/view_edit';
    }

    function Finsh() {
        console.log('Button clicked!');
        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to transfer the application?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'delete_pop_btn');
            $("#delete_pop_btn").click(function() {
                if (custom_alert_popup_close('delete_pop_btn')) { 
                    $('#cover-spin').show(0);   
                     pdf_html_code_();
                }
            });
        // $('#cover-spin').show();
       
    }

    function pdf_html_code_() {
        console.log("PDF html loading.......");

        var htmlString = $('#my_pdf_data').html();
        Form_data = htmlString.replace('style="font-size: 23px;"', '');

        $.ajax({
            data: {
                'ENC_pointer_id': '<?= $ENC_pointer_id ?>',
                'pdf_html_code': Form_data,
            },
            type: 'post',
            url: '<?= base_url('Create_new_TRA_file_pdf_html_code_'); ?>',
            error: function() {
                alert('technical error.');
                $('#cover-spin').hide();
            },
            success: function(data) {
                console.log("PDF html updateed");
                Create_TRA_file_to_stage_1_folder_in_BG();
            }
        });
    }

    function Create_TRA_file_to_stage_1_folder_in_BG() {
        console.log('PDF loading.......');
        $.ajax({
            url: '<?= base_url('Create_new_TRA_file_auto_save_download_PDF_/' . $ENC_pointer_id . '/TRA Application Form/') ?>',
            success: function(result) {
                console.log(' PDF Done.......' + result);
                Send_email();
            },
            error: function() {
                alert('PDF Create Error.');
                $('#cover-spin').hide();
            }
        });
    }

    function Send_email() {
        console.log('Send_email loading.......');
        $.ajax({
            url: '<?= base_url('Create_new_TRA_file_Send_email_') ?>/<?= $pointer_id ?>/<?= $user_id ?>',
                success: function(data) {
                    data = JSON.parse(data);
                    if (data["response"] == true) {
                // console.log(' Send_email Done.......' + data);
                // if (data == "ok") {
                    window.location = '<?= base_url() ?>/admin/application_manager/view_application/<?= $pointer_id ?>/view_edit';
                }
            },
            error: function() {
                alert('Send Email Error.');
                $('#cover-spin').hide();
            }
        });
    }

    var strNewString = $('body').html().replace(/yes/g, 'Yes').replace(/\bno\b/g, 'No');
    $('body').html(strNewString);
</script>

<?= $this->endSection() ?>
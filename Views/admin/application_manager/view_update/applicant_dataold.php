<div class="accordion" id="flip-view_applicant_details">
    <div class="accordion-item">
        <h2 class="accordion-header" id="view_head_applicant_details">
            <button class="accordion-button collapsed text-green" type="button" data-bs-toggle="collapse" data-bs-target="#view_applicant_details" aria-expanded="false" aria-controls="view_applicant_details" style="font-size:16px; font-style:Nunito,sans-serif;font-weight:bold">
                Applicant's Details
            </button>
        </h2>
        <style>
            .btn_yellow {
                background-color: #fecc00;
                color: #055837;
            }

            .btn_green {
                background-color: #055837;
                color: #fecc00;
            }
        </style>
        <div id="view_applicant_details" class="accordion-collapse collapse show" aria-labelledby="view_head_applicant_details" data-bs-parent="#flip-view_applicant_details">
            <div class="accordion-body">
                <form action="" method="post">
                    <table class="table table-striped border table-hover">
                        <tr>
                            <td width="30%">Applicant's Name</td>
                            <td class="w-25">
                                <?= $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name; ?>
                            </td>
                        </tr>
                        <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                            <tr>
                                <td width="30%">Email Address</td>
                                <td class="w-25">
                                    <?php
                                    if (!empty($s1_contact_details->email)) {
                                        echo $s1_contact_details->email;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Contact Number</td>
                                <td class="w-25">
                                    <?php
                                    if (!empty($s1_contact_details->mobile_number_code)) {
                                        $mobile_code = find_one_row('country', 'id', $s1_contact_details->mobile_number_code);
                                        echo "+" . $mobile_code->phonecode;
                                    }
                                    ?> <?= $s1_contact_details->mobile_number ?>
                                </td>
                            </tr>

                        <?php } ?>
                        <tr>
                            <td>Occupation</td>
                            <td class="w-25"><?= find_one_row('occupation_list', 'id', $s1_occupation->occupation_id)->name ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Program</td>
                            <td class="w-25">
                                <?php
                                echo  $s1_occupation->program;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Pathway</td>
                            <td class="w-25" id="pathway">
                                <?php
                                echo  $s1_occupation->pathway;
                                ?>
                            </td>
                        </tr>
                        <!--                         
                        <tr>
                            <td>Assigned to</td>
                            <td class="w-25">
                                <select class="form-select mb-3" aria-label="Default select example" name="assigned_to">
                                    <option selected value="Self"> Self </option>
                                </select>
                            </td>
                        </tr> -->
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
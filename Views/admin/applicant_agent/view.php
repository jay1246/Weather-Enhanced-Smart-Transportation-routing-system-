<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>

<main id="main" class="main">
    <style>
        .form_col {
            background-color: var(--offgray);
        }

        .lable_2 {
            font-size: 10px;
            margin-top: -20px !important;
            margin-bottom: 5px !important;
        }
    </style>
    <div class="pagetitle">
        <h4 class="text-green">
            <?= $user->account_type; ?>
        </h4>
    </div>

    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow bg-white">
                <div class="card-body" style="padding:0;">
                    <form id="edit_data" action="" class="edit_data">
                        <div class="form_col row" style="padding: 10px;">
                            <div class="col-4">
                                <lable> First Name <span class="text-danger">*</span></lable>
                                <input type="text" name="name" class="form-control mb-2" value="<?= $user->name ?>">
                                <input type="hidden" name="id" class="form-control mb-2" value="<?= $user->id ?>">
                            </div>
                            <div class="col-4">
                                <lable> Middle Name </lable>
                                <input type="text" name="middle_name" class="form-control mb-2" value="<?= $user->middle_name ?>">
                            </div>
                            <div class="col-4">
                                <lable> Last Name <span class="text-danger">*</span></lable>
                                <input type="text" name="last_name" class="form-control mb-2" value="<?= $user->last_name ?>">
                            </div>
                         <?php if($user->account_type=='Agent'){?>

                            <div class="col-4">
                                <lable> Business Name <span class="text-danger">*</span></lable>
                                <input type="text" name="business_name" class="form-control mb-2" value="<?= $user->business_name ?>">
                            </div>
                            <div class="col-4" style="margin-top: 30px; text-align: center;">
                                <div class="row">
                                    <?php
                                    if ($user->are_u_mara_agent == 'yes') {
                                        $check_box_mara = 'checked';
                                    } else {
                                        $check_box_mara = '';
                                    }
                                    ?>

                                    <lable class="col-md"> Are you MARA Agent </lable>
                                    <input type="checkbox" class="col-md" name="are_u_mara_agent" value="yes" <?php echo ($check_box_mara) ?>>
                                </div>

                            </div>
                            <div class="col-4">
                                <lable> MARA No </lable>
                                <input type="text" name="mara_no" class="form-control mb-4" value="<?= $user->mara_no ?>">
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <h5 class="text-green text-center mt-4 mb-4" style="font-size: 20px;">Contact Details</h5>
                        </div>
                        <div class="form_col row" style="padding: 10px;">
                            <div class="col-md-6">
                                <lable> Phone No <span class="text-danger">*</span></lable>
                                <!-- <div class="input-group  mb-2"> -->
                                <div class="row">
                                    <div class="col-sm-5" style="padding-right:0px;">
                                        <span class="lable_2"> Country code </span>
                                        <select class="form-control" name="mobile_code">
                                            <?php $aus_code = find_one_row('country', 'id', $user->mobile_code);
                                            if ($aus_code != "") {
                                            ?>
                                                <option value="<?= $aus_code->id ?>"><?= $aus_code->name . " (+" . $aus_code->phonecode . ")" ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value=""></option>
                                            <?php
                                            }
                                            foreach ($countries as $country) {
                                            ?>
                                                <option value="<?= $country->id ?>"><?= $country->name . " (+" . $country->phonecode . ")" ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-7" style="padding-right:0px;">
                                        <span class="lable_2"> Number </span>
                                        <input name="mobile_no" type="text" class="form-control" value="<?= $user->mobile_no ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <lable> Telephone </lable>
                                <!-- <div class="input-group mb-4"> -->
                                <div class="row">
                                    <div class="col-sm-5" style="padding-right:0px;">
                                        <span class="lable_2"> Country code </span>
                                        <select class="form-control mb-2" name="tel_code">
                                            <?php $aus_code = find_one_row('country', 'id', $user->tel_code);
                                            if ($aus_code != "") {
                                            ?>
                                                <option value="<?= $aus_code->id ?>"><?= $aus_code->name . " (+" . $aus_code->phonecode . ")" ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value=""></option>
                                            <?php
                                            }
                                            foreach ($countries as $country) {
                                            ?>
                                                <option value="<?= $country->id ?>"><?= $country->name . " (+" . $country->phonecode . ")" ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2" style="padding-right:0px;">
                                        <span class="lable_2"> Area Code </span>
                                        <input name="tel_area_code" type="text" class="form-control" value="<?= $user->tel_area_code ?>">
                                    </div>
                                    <div class="col-sm-5" style="padding-right:0px;">
                                        <span class="lable_2"> Number </span>
                                        <input name="tel_no" type="text" class="form-control " value="<?= $user->tel_no ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <lable> Email <span class="text-danger">*</span></lable>
                                <input type="text" name="email" class="form-control mb-2" value="<?= $user->email ?>">
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-green text-center mt-4 mb-4" style="font-size: 20px;">Address Details</h5>
                        </div>
                        <div class="form_col row" style="padding: 10px;">
                            <!--<div class="col-4">-->
                            <!--    <lable> Address </lable>-->
                            <!--    <input type="text" name="address" class="form-control mb-2" value="<?= $user->address ?>">-->
                            <!--</div>-->
                            <div class="col-4">
                                <lable> Unit Flat </lable>
                                <input type="text" name="unit_flat" class="form-control mb-2" value="<?= $user->unit_flat ?>">
                            </div>
                            <div class="col-4">
                                <lable> Street Lot Number <span class="text-danger">*</span></lable>
                                <input type="text" name="street_lot" class="form-control mb-2" value="<?= $user->street_lot ?>">
                            </div>
                            <div class="col-4">
                                <lable> Street Name <span class="text-danger">*</span></lable>
                                <input type="text" name="street_name" class="form-control mb-2" value="<?= $user->street_name ?>">
                            </div>
                            <div class="col-4">
                                <lable> Suburb City <span class="text-danger">*</span></lable>
                                <input type="text" name="suburb_city" class="form-control mb-2" value="<?= $user->suburb_city ?>">
                            </div>
                            <div class="col-4">
                                <lable> State/Province <span class="text-danger">*</span></lable>
                                <input type="text" name="state_province" class="form-control mb-2" value="<?= $user->state_province ?>">
                            </div>
                            <div class="col-4">
                                <lable> Postcode <span class="text-danger">*</span></lable>
                                <input type="text" name="postcode" class="form-control mb-4" value="<?= $user->postcode ?>">
                            </div>
                        </div>
                        <div class="form_col row" style="padding-bottom: 10px;">
                            <div class="col-4" style=" text-align: center;">
                                <div class="row">
                                    <?php
                                    if ($user->postal_ad_same_physical_ad_check == 1) {
                                        $check_box = 'checked';
                                    } else {
                                        $check_box = '';
                                    }
                                    ?>
                                    <lable class="col-md"> If Postal Address Is Same </lable>
                                    <input type="checkbox" class="col-md" value="1" name="postal_ad_same_physical_ad_check" id="postal_ad_same_physical_ad_check" onclick="hide_postal()" <?php echo ($check_box) ?>>
                                </div>

                            </div>
                        </div>
                        <div class="row" id="postal_row_name">
                            <h5 class="text-green text-center mt-4 mb-4" style="font-size: 20px;">Postal Address Details</h5>
                        </div>
                        <div class="form_col row" id="postal_row_fields" style="padding: 10px;">
                            <!--<div class="col-4">-->
                            <!--    <lable> Postal Address </lable>-->
                            <!--    <input type="text" name="postal_address" class="form-control mb-2" value="<= $user->postal_address ?>">-->
                            <!--</div>-->
                            <div class="col-4">
                                <lable> Postal Unit Flat </lable>
                                <input type="text" name="postal_unit_flat" class="form-control mb-2" value="<?= $user->postal_unit_flat ?>">
                            </div>
                            <div class="col-4">
                                <lable> Postal Street Lot Number</lable>
                                <input type="text" name="postal_street_lot" class="form-control mb-2" value="<?= $user->postal_street_lot ?>">
                            </div>
                            <div class="col-4">
                                <lable> Postal Street Name </lable>
                                <input type="text" name="postal_street_name" class="form-control mb-2" value="<?= $user->postal_street_name ?>">
                            </div>
                            <div class="col-4">
                                <lable> Postal Suburb City </lable>
                                <input type="text" name="postal_suburb_city" class="form-control mb-2" value="<?= $user->postal_suburb_city ?>">
                            </div>
                            <div class="col-4">
                                <lable> Postal State/Province </lable>
                                <input type="text" name="postal_state_province" class="form-control mb-2" value="<?= $user->postal_state_province ?>">
                            </div>
                            <div class="col-4">
                                <lable> Postal Postcode </lable>
                                <input type="text" name="postal_postcode" class="form-control mb-2" value="<?= $user->postal_postcode ?>">
                            </div>
                        </div>
                        <div class="text-center" style="padding: 30px;">
                            <a href="<?= base_url('admin/applicant_agent/agent') ?>" id="cancel" class="btn btn_yellow_green">Back</a>
                            <button type="submit" class="btn btn_green_yellow" id="action_validation_btn">Update</button>
                            <a href="<?= base_url('admin/applicant_agent/agent') ?>" id="cancel" class="btn btn_yellow_green">Cancel</a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
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

        #loader_img {
            position: fixed;
            left: 50%;
            top: 50%;
            pointer-events: none;
        }
    </style>
    <div id="cover-spin">
        <div id="loader_img">
            <img src="https://attc.aqato.com.au/public/assets/image/admin/loader.gif" style="width: 100px; height:auto">
        </div>
    </div>
</main>

<?= $this->endSection() ?>
<?= $this->section("custom_script") ?>
<script>
    hide_postal();

    $("#edit_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $('#cover-spin').show();
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/applicant_agent/update") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res);
                if (JSON.parse(res).response == true) {
                    // window.location = "<?= base_url("admin/applicant_agent/") ?>";
                    location.reload(true);
                    $('#cover-spin').hiden();

                } else {
                    $('#cover-spin').hiden();

                    // alert();
                }
            }
        });
    });

    function hide_postal() {
        var check = document.getElementById("postal_ad_same_physical_ad_check");
        if (check.checked == true) {
            var check_val = document.getElementById("postal_ad_same_physical_ad_check").value;
            $('#postal_row_fields').css('display', 'none');
            $('#postal_row_name').css('display', 'none');
            console.log('true');
        } else {
            console.log('false');
            $('#postal_row_fields').show()
            $('#postal_row_name').show()
        }

    }
</script>
<?= $this->endSection() ?>
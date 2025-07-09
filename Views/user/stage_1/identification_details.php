<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>



<!-- stepper -->
<?php include("stepper.php")
?>


<style>
    .Hi_Lite {
        background-color: var(--offgray);
    }

    .id-row {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
    }

    .pl {
        padding-left: 8px;
    }
</style>

<!-- start -->
<div class="container-xxl  mt-4 mb-4">
    <div class="row">
        <!-- center div  -->
        <div class="col-md-12 bg-white shadow">

            <h5 class="text-success mt-3 mb-3 text-center" style="font-size: 25px;">
                Identification Details
            </h5>
            <h5 class="text-end" style="font-size: 15px;">
                Portal Reference No. : <b> <?= $portal_reference_no ?> </b>
            </h5>


            <!-- form start  -->
            <div class="row mt-5 ">
                <div class="col-sm-12">
                    <form action="<?= base_url('user/identification_details_') ?>" method="post" class="row g-3 d-flex justify-content-center" id="Identification_Details">
                        <input type="hidden" name="ENC_pointer_id" value="<?= $ENC_pointer_id ?>" />

                        <!-- Country of birth -->
                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5">
                                    <label for="occupation" class="col-form-label">
                                        <b>Country of Birth </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7 ">
                                    <select class="form-select" required aria-label="Default select example" onchange="upload_auto(this.form)" name="country_of_birth">
                                        <?php
                                        if (isset($identification_details['country_of_birth'])) {
                                            if (!empty($identification_details['country_of_birth'])) {
                                                echo '<option value="' . $identification_details['country_of_birth'] . '" > ' . $identification_details['country_of_birth'] . '</option>';
                                            } else {
                                                echo ' <option value="" selected disable > Select Country</option>';
                                            }
                                        }
                                        ?>
                                        <?php foreach ($country_list as $result) { ?>
                                            <option value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Passport Country  -->
                        <div id="">
                            <div class="row pl">
                                <div class="col-sm-5 ">
                                    <label for="occupation" class="col-form-label">
                                        <b> Passport Country </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-select" required aria-label="Default select example" onchange="upload_auto(this.form)" name="passport_country">
                                        <?php
                                        if (isset($identification_details['passport_country'])) {
                                            if (!empty($identification_details['passport_country'])) {
                                                echo '<option value="' . $identification_details['passport_country'] . '" > ' . $identification_details['passport_country'] . '</option>';
                                            } else {
                                                echo ' <option value="" selected disable > Select Country</option>';
                                            }
                                        }
                                        ?>
                                        <?php foreach ($country_list as $result) { ?>
                                            <option value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Place of Issue / Issuing Authority -->
                        <div id="">
                            <div class="row Hi_Lite pl">
                                <div class="col-sm-5 ">
                                    <label for="occupation" class="col-form-label">
                                        <b> Place of Issue / Issuing Authority</b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" autocomplete="off" class="form-control" id="inputNanme4" onchange="upload_auto(this.form)" value="<?= $identification_details['place_of_issue'] ?>" name="place_of_issue" required />
                                </div>
                            </div>
                        </div>

                        <!-- Passport Number -->
                        <div id="">
                            <div class="row pl">
                                <div class="col-sm-5 ">
                                    <label for="occupation" class="col-form-label">
                                        <b> Passport Number </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" autocomplete="off" class="form-control" id="passport_number" onchange="upload_auto(this.form)" value="<?= $identification_details['passport_number'] ?>" name="passport_number" required />
                                </div>
                            </div>
                        </div>

                        <!-- Passport Expiry Date (dd/mm/yyyy)  -->
                        <div id="">
                            <div class="row  Hi_Lite pl">
                                <div class="col-sm-5 ">
                                    <label for="occupation" class="col-form-label">
                                        <b> Passport Expiry Date (dd/mm/yyyy) </b>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" maxlength="10" required class="form-control datepicker" name="expiry_date" onchange="upload_auto(this.form)" value="<?= $identification_details['expiry_date'] ?>" id="expiry_date" required />
                                </div>
                            </div>
                        </div>



                        <div class="col-12 mt-5 text-center">
                            <label for="inputNanme4" style="background-color: #055837;color:#ffc107;font-size:17px" class="form-label text-center  w-75 py-2">Note :- A valid current passport is required before technical interview is conducted</label>
                        </div>



                        <!-- buttons -->
                        <div class="text-center mt-4 mb-3">
                            <a href="<?= base_url('user/stage_1/contact_details/' . $ENC_pointer_id) ?>" class="btn btn_yellow_green">Back</a>
                            <a href="<?= base_url('user/dashboard') ?>" class="btn btn_green_yellow">Save & Exit</a>
                            <input type="submit" name="submit" class="btn btn_yellow_green" value="Next" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
    $('#passport_number').bind('input', function() {
        var c = this.selectionStart,
            r = /[^a-zA-Z0-9]/gi,
            v = $(this).val();
        if (r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
        }
        this.setSelectionRange(c, c);
    });
</script>
<script>
    $(".datepicker").datepicker({
        dateFormat: "dd/mm/yy"
    });
</script>




<script type="text/javascript">
    function upload_auto(Form_data) {
        let ssss = $('#Identification_Details').serialize();
        $.ajax({
            data: ssss,
            type: 'post',
            url: '<?php echo base_url('user/identification_details_'); ?>',
            error: function() {
                //   alert('Auto Upload is OFF ');
            },
            success: function(data, textStatus, jqXHR) {
                // alert(data);
                // alert("Add");
            }
        });
    }
</script>
<?= $this->endSection() ?>
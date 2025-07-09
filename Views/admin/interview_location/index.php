<?= $this->extend('template/admin_template') ?>

<?= $this->section('main') ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h4 class="text-green">Interview Locations</h4>
    </div><!-- End Page Title -->

    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table table-responsive">

                        <!--  Table with stripped rows starts -->

                        <table id="interview_table" class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>City </th>
                                    <th>Country</th>
                                    <th>Venue</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($interview_locations as $location) { ?>
                                    <tr>
                                        <td><b><?= $count ?></b></td>
                                        <td> <?= $location->city_name ?> </td>
                                        <td> <?= $location->country ?> </td>
                                        <td> <?= $location->venue ?> </td>
                                        <td> <?= $location->office_address ?> </td>

                                        <td>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#edit_form<?= $count ?>" class="btn btn-sm btn_green_yellow"> <i class="bi bi-pencil-square"></i></a>

                                        </td>

                                    </tr>

                                    <!-- modal box for edit -->
                                    <div class="modal" id="edit_form<?= $count ?>">
                                        <div class="modal-dialog  modal-lg">
                                            <div class="modal-content" style="background-color: white;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center text-green">Interview Location Change</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="edit_data" action="" method="post">
                                                        <input type="hidden" name="id" value="<?= $location->id ?>">
                                                        <div class="mb-3 row">

                                                            <label for="Name" class="col-sm-2"><strong>City</strong> <span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="city_name" value="<?= $location->city_name ?>" class="form-control" id="Name">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="country" class="col-sm-2"><strong>Country</strong> <span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <select class="form-select" name="country" id="country" aria-label="Default select example">
                                                                    <option disabled selected> Select City</option>
                                                                    <?php foreach ($countries as $country) { ?>
                                                                        <?php if ($location->country ==  $country->name) { ?>
                                                                            <option value="<?= $country->name ?>" selected> <?= $country->name ?> </option>
                                                                        <?php } else { ?>
                                                                            <option value="<?= $country->name ?>"> <?= $country->name ?> </option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="venue" class="col-sm-2"><strong>Venue</strong> <span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="venue" value="<?= $location->venue ?>" class="form-control" id="venue">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="office_address" class="col-sm-2"><strong>Address</strong> <span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" name="office_address" id="office_address" rows="3"><?= $location->office_address ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="contact_details" class="col-sm-2"><strong>Contact Details</strong> <span class="text-danger">*</span></label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" name="contact_details" id="contact_details" rows="3"><?= $location->contact_details ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn_yellow_green" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn_green_yellow">Update</button>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal box for edit end -->


                                <?php
                                    $count++;
                                }  ?>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>
        </div>
    </section>


</main>



<?= $this->endSection() ?>
<!---------- custom_script -->
<?= $this->section('custom_script') ?>
<script>
    $(document).ready(function() {
        $('#interview_table').DataTable({
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }

        });
    });

    $(".edit_data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            method: "POST",
            url: "<?= base_url("admin/interview_location/update") ?>",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res);
                if (res) {
                    window.location = "<?= base_url("admin/interview_location") ?>";
                } else {
                    alert(data["msg"]);
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>

<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b>Incomplete Applications </b>
</div>


<!-- start -->
<div class="container-fluid  mt-4 mb-4  ">
    <!-- center div  -->
    <div class=" bg-white shadow p-3 ">
        <!-- Alert on set - Flashdata -->
        <?= $this->include("alert_box.php") ?>
        <table class="table table-striped table-hover" id="table">
            <thead>
                <tr>
                    <th scope="col" style="width: 10%;">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                            PRN
                        </span>
                    </th>
                   
                    <th scope="col" style="width: 40%;">Applicant Name</th>
                    <th scope="col" style="width: 5%;">D.O.B</th>
                    <th scope="col" style="width: 20%;">Occupation</th>
                    <th scope="col" style="width: 11%;">Date Created</th>
                    <th scope="col" style="width: 7%;">Action</th>
                </tr>
            </thead>

            <tbody>

                <?php


                $i = 0;
                foreach ($table_data as $res) {
                    $i++;
                    $ENC_pointer_id = $res['ENC_pointer_id'];
                ?>
                    <tr>
                        <th>
                            <?= $res['portal_reference_no'] ?>
                        </th>
                        <td>
                            <?= $res['first_or_given_name'] ?> <?= $res['surname_family_name'] ?>
                        </td>
                        <td>
                            <?= $res['date_of_birth'] ?>
                        </td>
                        <td>
                            <?= $res['occupation'] ?>
                        </td>
                        <td>
                            <?= $res['created_at_format'] ?>

                        </td>
                        <td>

                            <a href=" <?= base_url('user/incomplete_application_/' . $ENC_pointer_id) ?>" class="btn btn-sm btn_green_yellow ">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger text-white" onclick="delet('<?= $ENC_pointer_id ?>')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>

</div>



<?= $this->endSection() ?>

<!---------- custom_script -->
<?= $this->section('custom_script') ?>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "aaSorting": [],
            "pageLength": 25,
             "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
</script>


<script>
    function delet(ENC_pointer_id) {

        custom_alert_popup_show(header = '', body_msg = "Are you sure you want to delete this item?", close_btn_text = 'No', close_btn_css = 'btn-danger', other_btn = true, other_btn_name = 'Yes', other_btn_class = 'btn_green_yellow', other_btn_id = 'AJDSAKAJLD');

        // check Btn click
        $("#AJDSAKAJLD").click(function() {
            // if return true 
            if (custom_alert_popup_close('AJDSAKAJLD')) {
                let url = "<?= base_url('user/incomplete_application_delete') ?>/" + ENC_pointer_id;
                window.location.href = url;
            }
        });
    }
</script>
<?= $this->endSection() ?>
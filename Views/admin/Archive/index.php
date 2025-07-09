<?= $this->extend('template/admin_template') ?>
<?= $this->section('main') ?>
<main id="main" class="main">
    <style>
        .flag_button_row {
            margin-right: 10px;
            width: 200px;
        }

        .flag_button {
            padding: 0;
            margin: 0;
            /* border-radius: 15px; */
        }

        .active_flag {
            background-image: linear-gradient(#ffde82, #fecc00);
        }

        .flag_img {
            width: 18px;
        }

        .filter_flag {
            height: 40px;
        }
    </style>
    <div class="pagetitle">
        <h4 class="text-green">Archive</h4>
    </div><!-- End Page Title -->
    <section class="section dashboard mt-3 shadow">
        <div class="row">
            <div class="card shadow">
                <div class="card-body" style="padding: 0px !important;">

                    <div class="table table-responsive">

                        <!--  Table with stripped rows starts -->

                        <table id="staff_table" class="table table-striped datatable table-hover">

                            <thead>
                                <tr>
                                    <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                        <th style="width: 5%;">
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                                                PRN
                                            </span>
                                        </th>
                                    <?php } ?>
                                    <th>Applicant No.</th>
                                    <th>Applicant Name </th>
                                    <th>D.O.B </th>
                                    <th>Occupation</th>
                                    <th>Date Submitted</th>
                                    <th>Current Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                // Custom comparison function
                                function compareItemsByCreatedAt($a, $b)
                                {
                                    return strtotime($a['submitted_date']) - strtotime($b['submitted_date']);
                                }

                                // Sort the items array using the custom comparison function
                                usort($all_list, 'compareItemsByCreatedAt');
                                $all_list = array_reverse($all_list);
                                $count = 1;

                                // echo "<pre>";
                                // print_r($all_list);
                                // echo "</pre>";

                                foreach ($all_list as $key => $value) {

                                    $approved_date = $value['expiry_date'];
                                    if (!empty($approved_date) && $approved_date != "0000-00-00 00:00:00" && $approved_date != null) {
                                        $Expired_date = $approved_date; //date('Y-m-d', strtotime('+60 days', strtotime($approved_date)));
                                        $expiry_date_temp = strtotime($Expired_date);
                                        $todays_date = strtotime(date('Y-m-d'));  // sempal
                                        // $todays_date = strtotime('2023-02-16');  // sempal
                                        $timeleft = $todays_date - $expiry_date_temp;
                                        $day_remain = round((($timeleft / 86400)));
                                        // echo $day_remain." P - ".$value["pointer_id"]."<br/>";
                                        // continue;
                                        $date1 = new DateTime(date('Y-m-d', strtotime($Expired_date)));
                                        $date2 = new DateTime(date('Y-m-d'));
                                        $interval = $date1->diff($date2);
                                        $day_remain = $interval->days;
                                        if ($date2 > $date1) {
                                            // If $date2 is greater than $date1, make $day_remain_ negative
                                            $day_remain = -$day_remain;
                                        }
                                        
                                        if ($day_remain >= -30 && $day_remain  < 0) {

                                ?>

                                            <tr>
                                                <?php if (session()->get('admin_account_type') == 'admin') {  ?>
                                                    <td>
                                                        <?= $value['portal_reference_no'] ?>
                                                    </td>
                                                <?php } ?>
                                                <td>

                                                    <?php
                                                    // $todays_date = strtotime(date('Y-m-d'));
                                                    // $expiry_date_temp = strtotime(date('Y-m-d'));
                                                    // $expiry_date_temp = strtotime($value['expiry_date']);
                                                    // $timeleft = $todays_date - $expiry_date_temp;
                                                    // $day_remain = round((($timeleft / 86400)));
                                                    // // $day_remain = 30 - $day_remain;
                                                    // echo $day_remain;
                                                    ?>
                                                    <?= $value['unique_id'] ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('admin/application_manager/view_application') ?>/<?= $value['pointer_id'] ?>/view_edit" style="color:#009933">
                                                        <?= $value['Applicant_name'] ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= $value['date_of_birth'] ?>
                                                </td>
                                                <td>
                                                    <?= $value['occupation_name'] ?>
                                                </td>
                                                <td>
                                                    <?= $value['submitted_date_format'] ?>
                                                </td>
                                                <td>
                                                    <?= $value['Current_Status'] ?>
                                                </td>

                                            </tr>
                                <?php $count++;
                                        }
                                    }
                                } ?>


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
        var table = $('#staff_table').DataTable({
            "aaSorting": [],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
        console.log('staff_table'),

            document.getElementById("id_flag_red").addEventListener("click", function() {
                console.log('F_red');
                var red_flag = document.getElementById("red_flag_btn");
                if (red_flag.className == "col-md flag_button active_flag") {
                    console.log('remove');
                    red_flag.classList.remove("active_flag");
                    table.column(0).search('').draw();
                } else {
                    console.log('add');
                    red_flag.classList.add("active_flag");

                    var green_flag = document.getElementById("green_flag_btn");
                    if (green_flag.className == "col-md flag_button active_flag") {
                        console.log('remove');
                        green_flag.classList.remove("active_flag");
                    }
                    table.column(0).search('F_red').draw();
                }
            }),
            document.getElementById("id_flag_green").addEventListener("click", function() {
                console.log('F_greeen');
                var green_flag = document.getElementById("green_flag_btn");
                console.log(green_flag.className);
                if (green_flag.className == "col-md flag_button active_flag") {
                    console.log('remove');
                    green_flag.classList.remove("active_flag");
                    table.column(0).search('').draw();
                } else {
                    console.log('add');
                    green_flag.classList.add("active_flag");
                    var red_flag = document.getElementById("red_flag_btn");
                    if (red_flag.className == "col-md flag_button active_flag") {
                        console.log('remove');
                        red_flag.classList.remove("active_flag");
                    }
                    table.column(0).search('F_greeen').draw();
                }

            })
    });
    $(document).ready(function() {
        $('#flag_table').DataTable({
            "aaSorting": []
        });

    });
</script>

<?= $this->endSection() ?>
<table class="table table-striped table-hover" id="table">
    <thead class="table-light">
        <tr>
            <th scope="col" style="width: 10%;">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                    PRN
                </span>
            </th>
            <th scope="col" style="width: 12%;">Application No.</th>
            <th scope="col" style="width: 28%;">Applicant Name</th>
            <th scope="col" style="width: 5%;">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Date of Birth.">
                    D.O.B
                </span>
            </th>
            <th scope="col" style="width: 19%;">Occupation</th>
            <th scope="col" style="width: 11%;">Date Created</th>
            <th scope="col" style="width: 12%;">Current Status</th>
            <th scope="col" style="width: 5%;">Action</th>
        </tr>
    </thead>

    <tbody>

        <?php
        $i = 0;

        if(count($table_data) == 0){
            $currentPage = 0;
            ?>
            <tr>
                <td colspan="8" class="text-center">No matching records found</td>
            </tr>
            <?php
        }

        foreach ($table_data as $key => $res) {
            //  print_r($table_data);
            $i++;
            $ENC_pointer_id = pointer_id_encrypt($res['pointer_id']);
            $pointer_id = $res['pointer_id'];

            $status_format = create_status_format(application_stage_no($pointer_id));

            $status =  create_status_rename($status_format, $pointer_id);

            $submitted_date_format = date("d/m/Y", strtotime($res["submitted_date"]));
            $approved_date_format = date("d/m/Y", strtotime($res["approved_date"]));

            $unique_id = ($res['unique_id']) ? "[#".$res['unique_id']."]" : "[#T.B.A]";

        ?>
            <tr>
                <td>
                    <b>
                        <?= $res['application_number'] ?>
                    </b>
                </td>
                <td>
                    <b>
                        <?= $unique_id ?>
                    </b>
                </td>
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
                    <?= $submitted_date_format ?>
                </td>
                <td>
                    <!-- 25-04-2023 vishal  -->
                    <?php
                    if (isset($approved_date_format) && !empty($approved_date_format) && $approved_date_format != "0000-00-00 00:00:00" && $approved_date_format != null) {
                        $Expired_date =  date('Y-m-d', strtotime('+60 days', strtotime($approved_date_format)));
                        $expiry_date_temp = strtotime($Expired_date);
                        $todays_date = strtotime(date('Y-m-d'));
                        $timeleft = $todays_date - $expiry_date_temp;
                        $day_remain = round((($timeleft / 86400)));
                    } else {
                        $day_remain = -40;
                    }
                    if ($status == "S1 - Expired") {
                        if ($day_remain >= 0) {
                            $status = "Closed";
                        }
                    }
                    // echo $day_remain;
                    ?>


                    <?php
                    if ($status == "S1 - Expired") {
                        if (stage_1_expired_day($pointer_id) < -60) {
                            echo "Closed";
                        } else {
                            echo $status;
                        }
                    } else {
                        echo $status;
                    }
                    
                    // echo $status;exit;
                    ?>

                </td>
                <td>
                    <?php if ($status != 'Completed') { ?>
                        <a href="<?= base_url('user/view_application/' . $ENC_pointer_id) ?>" class="btn btn-sm btn_green_yellow ">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    <?php } else { ?>
                        <a href="<?= base_url('user/Finish_application/' . $ENC_pointer_id) ?>" class="btn btn-sm btn_green_yellow ">
                            <i class="bi bi-eye-fill"></i>
                        </a>

                        
                    <?php  }
                        
                        
                        ?>

                    
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
<div class="main_bottom_pagination">
    <div class="sub_bottom_pagination">
        <span>Showing <?= $currentPage ?> to <?= $itemsPerPage ?> of <?= number_format($totalRows) ?> entries</span>
    </div>
    <?= $pager->links() ?>
</div>
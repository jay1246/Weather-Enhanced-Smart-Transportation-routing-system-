<?= $this->extend('template/user_template') ?>
<?= $this->section('main') ?>

<style>
    .container-fluid {
        max-width: 1600px !important;
    }
</style>
<!-- inner heading  -->
<div class="bg-green text-white text-center pt-1 pb-1" style="font-size: 120%;">
    <b> Submitted Applications</b>
</div>

<!-- start -->
<div class="container-fluid mt-4 mb-4  ">
    <!-- center div  -->
    <div class=" p-2 bg-white shadow p-3 ">

        <!-- Alert on set - Flashdata -->
        <?= $this->include("alert_box.php") ?>

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
                // array_reverse($table_data);
                // print_r($table_data);

                //    echo "<pre>";
                //    print_r($table_data);
                //    exit;


                // Custom comparison function
                function compareItemsByCreatedAt($a, $b)
                {
                    return strtotime($a['submitted_date']) - strtotime($b['submitted_date']);
                }

                // Sort the items array using the custom comparison function
                usort($table_data, 'compareItemsByCreatedAt');
                $table_data = array_reverse($table_data);





                $count = 1;

                foreach ($table_data as $key => $res) {
                    $i++;
                    $ENC_pointer_id = $res['ENC_pointer_id'];
                    $pointer_id = $res['pointer_id'];
                    //$status="";
                    //if(!empty($table)){
                    // print_r($res['status_format']);
                          $status =  create_status_rename($res['status_format'],$pointer_id);

                   // }
                ?>
                    <tr>
                        <td>
                            <b>
                                <?= $res['portal_reference_no'] ?>
                            </b>
                        </td>
                        <td>
                            <b>
                                <?= $res['application_mo'] ?>
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
                            <?= $res['submitted_date_format'] ?>
                        </td>
                        <td>
                            <!-- 25-04-2023 vishal  -->
                            <?php
                            if (isset($res['approved_date']) && !empty($res['approved_date']) && $res['approved_date'] != "0000-00-00 00:00:00" && $res['approved_date'] != null) {
                                // $Expired_date = ($res["closure_date"] == "0000-00-00 00:00:00") ? $res['expiry_date'] : $res["closure_date"];
                                $Expired_date = $res['expiry_date'];
                                $Expired_date_closure_date = $res["closure_date"];
                                $expiry_date_temp = strtotime($Expired_date);
                                $todays_date = strtotime(date('Y-m-d'));
                                $timeleft = $todays_date - $expiry_date_temp;
                                $day_remain = round((($timeleft / 86400)));
                            } else {
                                $day_remain = -40;
                            }
                            // echo $day_remain."Mohsin";
                            // if ($status == "S1 - Expired") {
                            //     if ($day_remain >= 30) {
                            //         $status = "Closed";
                            //     }
                            // }
                            // echo $day_remain;
                            ?>


                            <?php
                            if ($status == "S1 - Expired") {
                                // echo "Here";
                                if(empty($res["closure_date"]) || $res["closure_date"] == "0000-00-00 00:00:00"){
                                    // echo stage_1_expired_day_new($pointer_id);
                                   
                                     $date1 = new DateTime(date('Y-m-d', strtotime($Expired_date)));
                                        $date2 = new DateTime(date('Y-m-d'));
                                        $interval = $date1->diff($date2);
                                        $day_remain = $interval->days;
                                        if ($date2 > $date1) {
                                            // If $date2 is greater than $date1, make $day_remain_ negative
                                            $day_remain = -$day_remain;
                                        }
                                    
                                        if ($day_remain > 0) {
                                            $Expiry_name =  "Expiry";
                                        } else if ($day_remain >= -30 && $day_remain  < 0) {
                                            $Expiry_name =  "Expired";
                                        } else if ($day_remain  <= -31) {
                                            $Expiry_name =  "Closed";
                                        }
                                   if($Expiry_name == "Closed"){
                                    echo "Closed";
                                   }
                                    else {
                                        echo $status;
                                    }
                                }
                                else{
                                    $date1 = new DateTime(date('Y-m-d', strtotime('0 days', strtotime($Expired_date_closure_date))));
                                    $date2 = new DateTime(date('Y-m-d'));
                                    $interval = $date1->diff($date2);
                                    // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                                    $day_remain_expiry_checker = $interval->days;
                                    if ($date2 > $date1) {
                                        // If $date2 is greater than $date1, make $day_remain_ negative
                                        $day_remain_expiry_checker = -$day_remain_expiry_checker;
                                    }
                                    // echo $day_remain;
                                    // exit;
                                    // stage_1_expired_day($pointer_id);
                                    
                                    // echo $day_remain_expiry_checker .". -- .".$day_remain;
                                    // echo $day_remain;
                                    if ($day_remain_expiry_checker < 0) {
                                        
                                        echo "Closed";
                                    }
                                    else{
                                        // echo "ds";
                                        // echo "Closed";
                                        echo $status;
                                        
                                    }
                                    // echo $day_remain;
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
            // order: [
            //     [6, 'desc']
            // ],
            "language": {
                "lengthMenu": '_MENU_ ',
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": "Search",
            }
        });
    });
</script>
<?= $this->endSection() ?>
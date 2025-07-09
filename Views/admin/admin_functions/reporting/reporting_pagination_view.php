<table class="table table-striped datatable table-hover dataTable no-footer">
    <thead>
        <tr>
            <td style="width: 5%;">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                    <b>PRN</b>
                </span>
            </td>
            <td style="width: 10%;"><b>Applicant No.</b></td>
            <td style="width: 25%;"><b>Applicant Name </b></td>
            <td style="width: 10%;"><b>D.O.B </b></td>
            <td style="width: 15%;"><b>Occupation</b></td>
            <td style="width: 10%;"><b>Pathway </b></td>
            <?php 
            if($__stage__ && $status_db){
                ?>
                <td style="width: 15%;"><b>Date <?= ($status_db) ? $status_db : "Submitted" ?></b></td>
                <?php
            }
            else{
                ?>
                <td style="width: 15%;"><b>Date Submitted</b></td>
                <?php
            }
            ?>
            <td style="width: 20%;"><b>Current Status</b></td>
            <!-- Add more columns headers as needed -->
        </tr>
    </thead>
    <tbody id="pagination__table__body">
        <?php 
        $count = 0;
        $session = session();
        if(count($data) == 0){
            ?>
            <tr>
                <td colspan="8" class="text-center">No Data Found</td>
            </tr>
            <?php
        }
        $flag___ = 0;
        foreach ($data as $item): ?>
            <?php 
            $count++;
            $unique_id = ($item->unique_id) ? "[#".$item->unique_id."]" : "[#T.B.A]";
            $full_name = (($item->first_or_given_name) ? $item->first_or_given_name : "")." ".(($item->middle_names) ? $item->middle_names : "")." ".(($item->surname_family_name) ? $item->surname_family_name : "");   
            
            $stage_index = application_stage_no($item->id);
            
            $current_status = create_status_rename(create_status_format($stage_index),$item->id);
            
            $additional_info_request = find_one_row_2_field_for_flag_pagination('additional_info_request', 'pointer_id', $item->id,'stage', $item->stage);

            
            $admin_account_type = $session->get('admin_account_type');

            if($search_flag){
                if($search_flag != $additional_info_request->status){
                    $flag___++;
                    continue;
                }
            }
            ?>
            <tr>
                <td><?= $item->application_number ?></td>
                <td><?= $unique_id ?></td>
                <td><a href="<?= base_url()."/admin/application_manager/view_application/".$item->id."/view_edit" ?>" style="color: #009933;"><?= $full_name ?></a></td>
                <td><?= $item->date_of_birth ?></td>
                <td><?= $item->name ?></td>
                <td><?= $item->pathway ?></td>
                <td>
                <?php 
                if($__stage__ && $status_db){
                    $stage_date__ =find_one_row($__stage__, "pointer_id", $item->id);
                    echo date("d/m/Y", strtotime($stage_date__->{$status."_date"}));
                }
                else{
                    ?>
                    <?= date("d/m/Y", strtotime($item->submitted_date)) ?>
                    <?php
                }
                ?>
                </td>
                <td>
            <?php
            $Expiry_name = "";
                if (!empty($item->approved_date) && $item->approved_date != "0000-00-00 00:00:00" && $item->approved_date != null) {
                    $Expired_date =  date('Y-m-d', strtotime('+60 days', strtotime($item->approved_date)));
                    $expiry_date_temp = strtotime($Expired_date);
                    $todays_date = strtotime(date('Y-m-d'));  // sempal
                    // $todays_date = strtotime('2023-02-16');  // sempal
                    $timeleft = $todays_date - $expiry_date_temp;
                    $day_remain = round((($timeleft / 86400)));
                    if ($day_remain < -30) {
                        $Expiry_name =  "Expiry";
                    } else if ($day_remain > -30 && $day_remain  < 0) {
                        $Expiry_name =  "Expired";
                    } else if ($day_remain  >= 0) {
                        $Expiry_name =  "Closed";
                    }
                }

                if ($current_status == "S1 - Expired") {
                    if ($Expiry_name ==  "Closed") {
                        // if (stage_1_expired_day($value['pointer_id']) < -60) {
                        echo "Closed";
                    } else {
                        echo $current_status;
                    }
                } else {
                    echo $current_status;
                }

                ?>
            
            </td>
                
                <!-- Add more columns data as needed -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="main_bottom_pagination">
    <div class="sub_bottom_pagination">
        <span>Showing <?= (count($data) == 0) ? 0 : $currentPage ?> to <?= $itemsPerPage ?> of <?= number_format($totalRows) ?> entries</span>
    </div>
    <?= $pager->links() ?>
</div>


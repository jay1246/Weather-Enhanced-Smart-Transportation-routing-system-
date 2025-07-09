<style>
    .pagination {
    /* Style the container */
    padding: 10px;
    background-color: #ffffff;
    border-radius: 5px;
    justify-content: center;  /* Center the pagination items */
}
.pagination li {
    margin: 0 3px;  /* Add spacing between pagination items */
}

.pagination a {
    color: #212529;
    text-decoration: none !important;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;  /* Smooth transition for hover effects */
}

.pagination a:hover {
    /*background-color: #212529;*/
    /*color: #ffffff;*/
    
    background-color: #EFEFEF;
    color: black;
}


/* Active */
.pagination li.active a {
    /*background-color: #212529;*/
    /*color: #ffffff;*/
    
    background-color: #EFEFEF;
    color: black;
    border: none;
    pointer-events: none;  /* Disable click events on the active item */
}

.pagination li.disabled a {
    color: #cccccc;
    pointer-events: none;
    cursor: not-allowed;
}
/* find_one_row */

.main_bottom_pagination{
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    justify-items: center;
}
.sub_bottom_pagination{
    padding-top: 05px;
}
.flag_img {
    width: 18px;
}
</style>
<table class="table table-striped datatable table-hover dataTable no-footer">
    <thead>
        <tr>
            <th style="width: 5%;">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                    PRN
                </span>
            </th>
            <th style="width: 10%;">Applicant No.</th>
            <th style="width: 30%;">Applicant Name </th>
            <th style="width: 10%;">D.O.B </th>
            <th style="width: 15%;">Occupation</th>
            <?php 
            if($__stage__ && $status_db){
                ?>
                <th style="width: 15%;">Date <?= ($status_db) ? $status_db : "Submitted" ?></th>
                <?php
            }
            else{
                ?>
                <th style="width: 15%;">Date Submitted</th>
                <?php
            }
            ?>
            <th style="width: 15%;">Current Status</th>
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
        <span>Showing <?= $currentPage ?> to <?= $itemsPerPage ?> of <?= number_format($totalRows) ?> entries</span>
    </div>
    <?= $pager->links() ?>
</div>


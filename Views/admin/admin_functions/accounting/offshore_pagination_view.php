<table class="table table-striped datatable table-hover dataTable no-footer">
    <thead>
        <tr>
            <td style="width: 10%;"><b>Applicant No.</b></td>
            <td style="width: 20%;"><b>Applicant Name </b></td>
            <td style="width: 10%;"><b>D.O.B </b></td>
            <td style="width: 15%;"><b>Occupation</b></td>
            <td><b>Pathway</b></td>
            <td style="width: 15%;"><b>Interview Location</b></td> 
            <td><b>Interview Date</b></td> 
            <td style="width: 5%;"  class="text-center"><b>Amount</b></td>
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
        $subtotal = 0;
        foreach ($data as $item): ?>
            <?php 
            $subtotal+= find_one_row("stage_3_offline_location","id", $item->s3_interview_location)->cost;
            $count++;
            $unique_id = ($item->unique_id) ? "[#".$item->unique_id."]" : "[#T.B.A]";
            $full_name = (($item->first_or_given_name) ? $item->first_or_given_name : "")." ".(($item->middle_names) ? $item->middle_names : "")." ".(($item->surname_family_name) ? $item->surname_family_name : "");   
            
            
            $additional_info_request = find_one_row_2_field_for_flag_pagination('additional_info_request', 'pointer_id', $item->id,'stage', $item->stage);

            
            $admin_account_type = $session->get('admin_account_type');

            if($search_flag){
                if($search_flag != $additional_info_request->status){
                    $flag___++;
                    continue;
                }
            }
            $price__ = 0;
            if($item->pathway == "Pathway 1"){
                $price__ = 800;
            }

            else if($item->pathway == "Pathway 2"){
                $price__ = 450;
            }
            $profile_link = "javascript:void(0)";
            if($item->id){
                $profile_link = base_url()."/admin/application_manager/view_application/".$item->id."/view_edit";
            }
            ?>
            <tr>
                <td><?= $unique_id ?></td>
                <td><a href="<?= $profile_link ?>" style="color: #009933;"><?= $full_name ?></a></td>
                <td>
                    <?php 
                    $date_dob_checker = $item->date_of_birth;
                    if(strtotime($date_dob_checker)){
                      // it's a date
                      $date_dob_checker = date("d/m/Y", strtotime($date_dob_checker));
                    }
                    ?>
                    <?= $date_dob_checker ?>
                </td>
                <td><?= $item->name ?></td>
                <td><?= $item->pathway ?></td>
                <td>
                    <?php 
                    $s3_location = find_one_row("stage_3_offline_location","id", $item->s3_interview_location);
                    echo $s3_location->city_name." - ".$s3_location->country;
                    
                    ?>
                </td>
                <td><?= date("d/m/Y", strtotime($item->s3_interview_date)) ?></td>
                <td class="text-center"><?= number_format($s3_location->cost) ?></td>
                
                <!-- Add more columns data as needed -->
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-center"><b>SubTotal</b></td>
            <td class="text-center"><?= number_format($subtotal) ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-center"><b>Total</b></td>
            <td class="text-center"><?= number_format($total__payment) ?></td>
        </tr>
    </tfoot>
</table>
<div class="main_bottom_pagination">
    <div class="sub_bottom_pagination">
        <span>Showing <?= (count($data) == 0) ? 0 : $currentPage ?> to <?= $itemsPerPage ?> of <?= number_format($totalRows) ?> entries</span>
    </div>
    <?= $pager->links() ?>
</div>


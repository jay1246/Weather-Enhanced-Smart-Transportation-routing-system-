<table class="table table-striped datatable table-hover dataTable no-footer">
    <thead>
        <tr>
            <td style="width: 10%;"><b>Applicant No.</b></td>
            <td style="width: 20%;"><b>Applicant Name </b></td>
            <td style="width: 10%;"><b>D.O.B </b></td>
            <td style="width: 15%;"><b>Occupation</b></td>
            <td><b>Pathway</b></td>
            <td style="width: 15%;"><b>Payment Date</b></td> 
            <td><b>Date Lodged</b></td> 
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
            $price__ = 0;
            if($item->pathway == "Pathway 1"){
                $price__ = 800;
            }

            else if($item->pathway == "Pathway 2"){
                $price__ = 450;
            }

            $subtotal += $price__;
            ?>
            <tr>
                <td><?= $unique_id ?></td>
                <td><a href="<?= base_url()."/admin/application_manager/view_application/".$item->id."/view_edit" ?>" style="color: #009933;"><?= $full_name ?></a></td>
                <td><?= $item->date_of_birth ?></td>
                <td><?= $item->name ?></td>
                <td><?= $item->pathway ?></td>
                <td>
                <?php 
                $payment_date = find_one_row("stage_3", "pointer_id", $item->id)->payment_date;
                ?>
                    <?= date("d/m/Y", strtotime($payment_date)) ?>
                </td>
                <td><?= date("d/m/Y", strtotime($item->s3_lodged_date)) ?></td>
                <td class="text-center"><?= number_format($price__) ?></td>
                
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


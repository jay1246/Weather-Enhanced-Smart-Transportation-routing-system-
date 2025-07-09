<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Archive extends BaseController
{
    public function index()
    {
        $data['page_name'] = 'Archive';
         $data['page']="Archive";

        $status_list = ['Archive', 'Expired'];
        $all_list = array();
        $application_pointer_model = $this->application_pointer_model->asObject()->orWhereIn('status', $status_list)->orderby('create_date', 'DESC')->findAll();
        $i = 0;
        $aaa = array();
        foreach ($application_pointer_model as $stage) {
            $pointer_id = $stage->id;
            $stage_1 = find_one_row('stage_1', 'pointer_id', $pointer_id);
            $list_array['expiry_date']  = $stage_1->expiry_date;
            $expiry_date = $stage_1->expiry_date;
            $Todays_date = strtotime(date('Y-m-d'));
            $approved_date_temp = strtotime($expiry_date);
            $timeleft = $Todays_date - $approved_date_temp;
            $day_remain = round((($timeleft / 86400)));
            $day_remain = 30 - $day_remain;


            if ($day_remain < -30 && $day_remain > -60) {
            }
            $i++;
            $asdasd = $stage->stage . " " . $stage->status;
            if (!in_array($asdasd, $aaa)) {
                $aaa[] = $asdasd;
            }


            $list_array = array();

            $pointer_id = $stage->id;
            $list_array['pointer_id'] = $pointer_id;
            $list_array['unique_id'] = application_mo($pointer_id);
            $list_array['portal_reference_no'] = portal_reference_no($pointer_id);

            $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $pointer_id);
            $list_array['Applicant_name'] =   $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name;




            $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $pointer_id);
            $Pathway =  (isset($s1_occupation->pathway) ? $s1_occupation->pathway : "");
            if ($Pathway == "Pathway 2") {
                $list_array['Pathway'] = 'p2';
            } else {
                $list_array['Pathway'] = 'p1';
            }
            $occupation_list = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);
            $list_array['occupation_name'] =  (isset($occupation_list->name) ? $occupation_list->name : "");

            $stage_1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $pointer_id);
            $list_array['date_of_birth'] =  (isset($stage_1_personal_details->date_of_birth) ? $stage_1_personal_details->date_of_birth : "");

            $stage_1 = find_one_row('stage_1', 'pointer_id', $pointer_id);
            $stage_index = application_stage_no($pointer_id);
            $list_array['approved_date']  =  $stage_1->approved_date;
            $list_array['expiry_date']  =  $stage_1->expiry_date;


            $list_array['Current_Status'] =  create_status_rename(create_status_format($stage_index),$pointer_id);

            if (create_status_format($stage_index) == 'S2 - Start') {
                $stage_status = 'S1 - ' . $stage->status;
            } else if (create_status_format($stage_index) == 'S3 - Start') {
                $stage_status = 'S2 - ' . find_one_row('stage_2', 'pointer_id', $stage->id)->status;
            } else {
                $stage_status = create_status_format($stage_index);
            }
            $list_array['application_status'] =  substr($stage_status, 0, 2);



            $stage_ = explode(" ", create_status_format($stage_index));

            if ($stage_[0] == 'S1') {
                $get_submit_date = $stage_1->submitted_date;
            } else if (create_status_format($stage_index) == 'S2 - Start') {
                $get_submit_date =  $stage_1->submitted_date;
            } else if ($stage_[0] == 'S2') {
                // $get_submit_date = find_one_row('stage_2', 'pointer_id', $pointer_id)->submitted_date;
                $get_submit_date =  $stage_1->submitted_date;
            } else if (create_status_format($stage_index) == 'S3 - Start') {
                // $get_submit_date = find_one_row('stage_2', 'pointer_id', $pointer_id)->submitted_date;
                $get_submit_date =  $stage_1->submitted_date;
            } else if ($stage_[0] == 'S3') {
                // $get_submit_date = find_one_row('stage_3', 'pointer_id', $pointer_id)->submitted_date;
                $get_submit_date =  $stage_1->submitted_date;
            } else {
                // $get_submit_date = (isset(find_one_row('stage_3', 'pointer_id', $pointer_id)->submitted_date)) ? find_one_row('stage_3', 'pointer_id', $pointer_id)->submitted_date : "";
                $get_submit_date =  $stage_1->submitted_date;
            }
            if (!empty($get_submit_date)) {
                $list_array['submitted_date'] = $get_submit_date;
                $list_array['submitted_date_format'] = date('d/m/Y', strtotime($get_submit_date));
            } else {
                $list_array['submitted_date'] =  "";
                $list_array['submitted_date_format'] =  "";
            }



            $additional_info_request = find_one_row('additional_info_request', 'pointer_id', $pointer_id);
            $list_array['additional_info_request'] =  $additional_info_request;

            $all_list[] = $list_array;
        }
        // }


        $data['all_list'] = $all_list;
        // echo "<pre>";
        // print_r($data);
        // exit;


        return view('admin/Archive/index', $data);
    }
}

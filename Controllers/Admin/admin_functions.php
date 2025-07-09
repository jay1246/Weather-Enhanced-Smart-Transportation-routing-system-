<?php

namespace App\Controllers\Admin;
use Dompdf\Dompdf;
use Dompdf\Options;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;



use App\Controllers\BaseController;
use stdClass;

class admin_functions extends BaseController
{

    public $finding_status__ = [
        "submitted" => "Submitted",
        "in_progress" => "In Progress",
        "lodged" => "Lodged",
        "approved" => "Approved",
        "omitted" => "Omitted",
        "declined" => "Declined",
        "closed" => "Expired",
        "scheduled" => "Scheduled",
        "conducted" => "Conducted"
    ];

    function reporting_view(){
        $data["occupations"] = $this->occupation_list_model->orderBy("name")->findAll();
        $data["agents"] = $this->user_account_model->orderBy("email")->findAll();
        $data["page"] = "Reporting";
        return view("admin/admin_functions/reporting/reporting_view",$data);
    }

    function accounting(){
        $data["occupations"] = $this->occupation_list_model->orderBy("name")->findAll();
        $data["agents"] = $this->user_account_model->orderBy("email")->findAll();
        $data["page"] = "Referral Fees";
        return view("admin/admin_functions/accounting/accounting_view",$data);
    }

    
    function offshore(){
        $data["occupations"] = $this->occupation_list_model->orderBy("name")->findAll();
        $data["agents"] = $this->user_account_model->orderBy("email")->findAll();
        $data["page"] = "Offshore Fees";
        $data["locations"] = $this->__getOfflineOffshoresLocation();
        return view("admin/admin_functions/accounting/offshore_view",$data);
    }

    
    
    public function fetch_application_records__accounting(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }



        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }

        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }

        // check wheter stage and status is selected
        if($stage && $status){
            $make_join .= " INNER JOIN ".$stage." date_find_filter ON date_find_filter.pointer_id = ap.id ";
            if($from_date){
                $filter_search .= " and date_find_filter.".$status."_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.".$status."_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date, date_find_filter.lodged_date as s3_lodged_date
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY date_find_filter.lodged_date DESC 
                      LIMIT ?, ?";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery, [$offset, $itemsPerPage])->getResult();
        
        // print_r($dataResult);
        // exit
        // Set up pagination
        $pager = service('pager');
        $pager->makeLinks($currentPage, $itemsPerPage, $totalRows);
        // echo $currentPage." - ".$itemsPerPage." - ".$totalRows;
        // exit;

        // Calculate the start and end number of entries for the current page:
        $start = ($currentPage - 1) * $itemsPerPage + 1;
        $end = min($currentPage * $itemsPerPage, $totalRows);

        // Craft the message:
        // $message = "Showing $start to $end of $totalRows entries";

        // Check number of total here

        // Fetch paginated data
        $dataQuery_total = "SELECT COUNT(CASE WHEN s1_occ.pathway = 'Pathway 1' THEN 1 ELSE NULL END) as count_p1, COUNT(CASE WHEN s1_occ.pathway = 'Pathway 2' THEN 1 ELSE NULL END) as count_p2
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY s1.submitted_date DESC";

        // echo $dataQuery;
        // exit;
        
        $dataResult_total = $db->query($dataQuery_total)->getRow();
        // end


        $total__p1 = $dataResult_total->count_p1 * 800;
        $total__p2 = $dataResult_total->count_p2 * 450;
        
        $total__payment = $total__p1 + $total__p2;

        // Return to view
        return view('admin/admin_functions/accounting/accounting_pagination_view', [
            'data' => $dataResult,
            'pager' => $pager,
            'currentPage' => $start,
            'itemsPerPage' => $end, 
            'totalRows' => $totalRows, 
            'search_flag' => $search_flag,
            '__stage__' => $stage,
            'status_db' => $status_db,
            'status' => $status,
            'total__payment' => $total__payment,
        ]);

    }

    public function __getSpecificColumnDataLocation($column){
        
        $offline_locations_offshores_original = $this->__getOfflineOffshoresLocation();
        
        $offline_locations_offshores = array_column($offline_locations_offshores_original, $column);
        $offline_locations_offshores = implode("', '", $offline_locations_offshores);
        return "'".$offline_locations_offshores."'";
    }


    
    public function fetch_application_records_offshore(){
        $db = db_connect();
        // echo "here";
        // exit;
        $offline_locations_offshores = $this->__getSpecificColumnDataLocation("id");

        // $offline_locations_offshores_time_zone = $this->__getSpecificColumnDataLocation("date_time_zone");

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = $non_aqato_filter = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }



        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }

        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");
        
        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        
        // If location filter is present
        $interview_location = trim($this->request->getVar('interview_location') ?? "");

        if($interview_location){
            $offline_locations_offshores = $interview_location; 
        }

        $make_join__ = "";

        // check wheter stage and status is selected
        if($stage && $status){
            $make_join .= " INNER JOIN stage_3_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";

            $make_join__ .= " INNER JOIN stage_3_reassessment_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";

            $filter_search .= " and date_find_filter.location_id IN (".$offline_locations_offshores.")";
            // $filter_search .= " and (date_find_filter.location_id IN (".$offline_locations_offshores.") OR date_find_filter.time_zone IN (".$offline_locations_offshores_time_zone."))";

            $non_aqato_filter .= " and interview_location IN (".$offline_locations_offshores.")";


            if($from_date){
                $filter_search .= " and date_find_filter.date_time >= '".$from_date."'";

                $non_aqato_filter .= " and interview_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.date_time <= '".$to_date."'";

                $non_aqato_filter .= " and interview_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT  date_find_filter.time_zone as s3_time_zone, date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ";

        

        // echo $dataQuery;
        // echo "<br><br>";
        // exit;
        
        // $dataResult = $db->query($dataQuery, [$offset, $itemsPerPage])->getResult();

        
        // Fetch paginated data
        $dataQuery__reassement = "SELECT date_find_filter.time_zone as s3_time_zone, date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join__."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ";

        

        // echo $dataQuery__reassement;
        // echo "<br><br>";
        
        // $dataResult__reassements = $db->query($dataQuery__reassement, [$offset, $itemsPerPage])->getResult();

        // print_r($dataResult__reassements);
        // exit;


        $dataQuery_non_aqato = "SELECT 
        NULL as s3_time_zone,
        interview_date as s3_interview_date,
        interview_location as s3_interview_location,
        NULL as user_name,
        pathway as pathway, 
        NULL as user_middle_name,
        NULL as user_last_name, 
        NULL as id,
        NULL as stage,
        NULL as status,
        NULL as application_number,
        full_name as first_or_given_name, 
        NULL as middle_names, 
        NULL as surname_family_name, 
        unique_number as unique_id, 
        dob as date_of_birth, 
        occupation_name as name, 
        NULL as submitted_date, 
        NULL as approved_date 
        FROM `not_aqato_s3` where 1=1 ".$non_aqato_filter." ";
        // echo $dataQuery_non_aqato;
        // echo "<br><br>";


        $overall_query = "
                SELECT *
                FROM (
                    ".$dataQuery."
                    UNION ALL 
                    ".$dataQuery__reassement."
                    UNION ALL 
                    ".$dataQuery_non_aqato."
                    ) AS combined_result
                ORDER BY s3_interview_date DESC
            ";
            $dataResult_totals = $db->query($overall_query)->getResult();
            $totalRows = count($dataResult_totals);
            // echo $overall_query;

            // Fetch Pagination Limit

            $new_pagination_query = $overall_query." limit ?, ?";
            // echo $new_pagination_query;
            // exit;
            $dataResult = $db->query($new_pagination_query, [$offset, $itemsPerPage])->getResult();

        // exit;

        $pager = service('pager');
        $pager->makeLinks($currentPage, $itemsPerPage, $totalRows);
        // echo $currentPage." - ".$itemsPerPage." - ".$totalRows;
        // exit;

        // Calculate the start and end number of entries for the current page:
        $start = ($currentPage - 1) * $itemsPerPage + 1;
        $end = min($currentPage * $itemsPerPage, $totalRows);

        
        
        $total__ = 0;
        foreach($dataResult_totals as $dataResult_total){
            $total__ += find_one_row("stage_3_offline_location","id", $dataResult_total->s3_interview_location)->cost;
        }

        // Return to view
        return view('admin/admin_functions/accounting/offshore_pagination_view', [
            'data' => $dataResult,
            'pager' => $pager,
            'currentPage' => $start,
            'itemsPerPage' => $end, 
            'totalRows' => $totalRows, 
            'search_flag' => $search_flag,
            '__stage__' => $stage,
            'status_db' => $status_db,
            'status' => $status,
            'total__payment' => $total__,
        ]);

    }

    public function fetch_application_records_offshore_old(){
        $db = db_connect();
        // echo "here";
        // exit;
        $offline_locations_offshores = $this->__getSpecificColumnDataLocation("id");

        // $offline_locations_offshores_time_zone = $this->__getSpecificColumnDataLocation("date_time_zone");

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = $non_aqato_filter = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }



        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }

        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");
        
        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        
        // If location filter is present
        $interview_location = trim($this->request->getVar('interview_location') ?? "");

        if($interview_location){
            $offline_locations_offshores = $interview_location; 
        }

        $make_join__ = "";

        // check wheter stage and status is selected
        if($stage && $status){
            $make_join .= " INNER JOIN stage_3_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";

            $make_join__ .= " INNER JOIN stage_3_reassessment_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";

            $filter_search .= " and date_find_filter.location_id IN (".$offline_locations_offshores.")";
            // $filter_search .= " and (date_find_filter.location_id IN (".$offline_locations_offshores.") OR date_find_filter.time_zone IN (".$offline_locations_offshores_time_zone."))";

            $non_aqato_filter .= " and interview_location IN (".$offline_locations_offshores.")";


            if($from_date){
                $filter_search .= " and date_find_filter.date_time >= '".$from_date."'";

                $non_aqato_filter .= " and interview_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.date_time <= '".$to_date."'";

                $non_aqato_filter .= " and interview_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);

        
        // Count total rows
        $countQuery__reassement = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join__."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery__reassement;
        // exit;
        $countResult__reassement = $db->query($countQuery__reassement)->getResult();
        $totalRows__reassement = count($countResult__reassement);

        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT  date_find_filter.time_zone as s3_time_zone, date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY date_find_filter.date_time DESC 
                      LIMIT ?, ?";

        

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery, [$offset, $itemsPerPage])->getResult();

        
        // Fetch paginated data
        $dataQuery__reassement = "SELECT date_find_filter.time_zone as s3_time_zone, date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join__."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY date_find_filter.date_time DESC 
                      LIMIT ?, ?";

        

        // echo $dataQuery__reassement;
        // exit;
        
        $dataResult__reassements = $db->query($dataQuery__reassement, [$offset, $itemsPerPage])->getResult();

        // print_r($dataResult__reassements);
        // exit;


        $dataQuery_non_aqato = "SELECT * FROM `not_aqato_s3` where 1=1 ".$non_aqato_filter." ORDER BY interview_date DESC LIMIT ?, ?";
        echo $dataQuery_non_aqato;
        exit;

        $dataQuery_non_aqato_total = "SELECT * FROM `not_aqato_s3` where 1=1 ".$non_aqato_filter." ORDER BY interview_date DESC";



        $dataResult_non_aqatos = $db->query($dataQuery_non_aqato, [$offset, $itemsPerPage])->getResult();

        $dataResult_non_aqatos_total = count($db->query($dataQuery_non_aqato_total)->getResult());

        // print_r($dataResult_non_aqatos);
        // exit;
        $non_aqato_total = 0;
        foreach($dataResult_non_aqatos as $dataResult_non_aqato){
            
            $new_array = [
                "s3_interview_date" => $dataResult_non_aqato->interview_date,
                "s3_interview_location" => $dataResult_non_aqato->interview_location,
                "user_name" => "Mohsin",
                "pathway" => ($dataResult_non_aqato->pathway) ? $dataResult_non_aqato->pathway : "---",
                "user_middle_name" => "",
                "user_last_name" => "Doe",
                "id" => "",
                "stage" => "stage_4",
                "status" => "Approved",
                "application_number" => "23AQ01295",
                "first_or_given_name" => $dataResult_non_aqato->full_name,
                "middle_names" => "",
                "surname_family_name" => "",
                "unique_id" => $dataResult_non_aqato->unique_number,
                "date_of_birth" => ($dataResult_non_aqato->dob) ? date("d/m/Y", strtotime($dataResult_non_aqato->dob)) : "---",
                "name" => $dataResult_non_aqato->occupation_name,
                "submitted_date" => "2023-10-09 18:08:34",
                "approved_date" => "2023-10-09 19:20:30",
            ];
            $stdClassObject = new stdClass();

            foreach ($new_array as $key => $value) {
                $stdClassObject->$key = $value;
            }

            array_push($dataResult, $stdClassObject);
            $non_aqato_total += find_one_row("stage_3_offline_location","id", $dataResult_non_aqato->interview_location)->cost;
        }
        
        // print_r($dataResult__reassements);
        // exit;
        $total__reassement = 0;
        foreach($dataResult__reassements as $dataResult__reassement){

            // if($dataResult__reassement->s3_interview_location == 9){
            //     $dataResult__reassement->s3_interview_location = find_one_row("stage_3_offline_location", "date_time_zone", $dataResult__reassement->s3_time_zone)->id;
            // }

            $new_array = [
                "s3_interview_date" => $dataResult__reassement->s3_interview_date,
                "s3_interview_location" => $dataResult__reassement->s3_interview_location,
                "user_name" => $dataResult__reassement->user_name,
                "pathway" => $dataResult__reassement->pathway,
                "user_middle_name" => $dataResult__reassement->user_middle_name,
                "user_last_name" => $dataResult__reassement->user_last_name,
                "id" => $dataResult__reassement->id,
                "stage" => $dataResult__reassement->stage,
                "status" => $dataResult__reassement->status,
                "application_number" => $dataResult__reassement->application_number,
                "first_or_given_name" => $dataResult__reassement->first_or_given_name,
                "middle_names" => $dataResult__reassement->middle_names,
                "surname_family_name" => $dataResult__reassement->surname_family_name,
                "unique_id" => $dataResult__reassement->unique_id,
                "date_of_birth" => $dataResult__reassement->date_of_birth,
                "name" => $dataResult__reassement->name,
                "submitted_date" => $dataResult__reassement->submitted_date,
                "approved_date" => $dataResult__reassement->approved_date,
            ];
            $stdClassObject = new stdClass();

            foreach ($new_array as $key => $value) {
                $stdClassObject->$key = $value;
            }

            array_push($dataResult, $stdClassObject);
            $total__reassement += find_one_row("stage_3_offline_location","id", $dataResult__reassement->s3_interview_location)->cost;
        }



        // Sort the array by "s3_interview_date" in descending order
        usort($dataResult, [$this, 'sortByInterviewDateDesc']);

        $dataResult = array_slice($dataResult,0,$itemsPerPage);
        // exit;

        // echo "<pre>";
        // print_r($dataResult);
        // exit;
        // Set up pagination

        $totalRows = $totalRows + $dataResult_non_aqatos_total + $totalRows__reassement;

        $pager = service('pager');
        $pager->makeLinks($currentPage, $itemsPerPage, $totalRows);
        // echo $currentPage." - ".$itemsPerPage." - ".$totalRows;
        // exit;

        // Calculate the start and end number of entries for the current page:
        $start = ($currentPage - 1) * $itemsPerPage + 1;
        $end = min($currentPage * $itemsPerPage, $totalRows);

        // Craft the message:
        // $message = "Showing $start to $end of $totalRows entries";

        // Check number of total here

        // Fetch paginated data
        $dataQuery_total = "SELECT date_find_filter.*
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                        ";

        // echo $dataQuery;
        // exit;
        
        $dataResult_totals = $db->query($dataQuery_total)->getResult();
        $total__ = 0;
        foreach($dataResult_totals as $dataResult_total){
            $total__ += find_one_row("stage_3_offline_location","id", $dataResult_total->location_id)->cost;
        }
        $total__ += $non_aqato_total + $total__reassement;
        // print_r($total__);
        // exit;
        // end

        // Return to view
        return view('admin/admin_functions/accounting/offshore_pagination_view', [
            'data' => $dataResult,
            'pager' => $pager,
            'currentPage' => $start,
            'itemsPerPage' => $end, 
            'totalRows' => $totalRows, 
            'search_flag' => $search_flag,
            '__stage__' => $stage,
            'status_db' => $status_db,
            'status' => $status,
            'total__payment' => $total__,
        ]);

    }

    // Define a comparison function to sort by "s3_interview_date" in descending order
    private function sortByInterviewDateDesc($a, $b) {
        $dateA = strtotime($a->s3_interview_date);
        $dateB = strtotime($b->s3_interview_date);

        if ($dateA == $dateB) {
            return 0;
        }

        return ($dateA > $dateB) ? -1 : 1;
    }

    public function fetch_application_records(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        
        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            if(!$from_date && !$to_date){
                $filter_search .= " and ap.stage = '".$stage."'";
            }
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }



        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");
        // echo $pathway;
        // exit;
        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            // echo $status;
            // exit;
            $status_db = $this->finding_status__[$status];
            // echo $status_db;
            // exit;
            
            if(!$from_date && !$to_date){
                $filter_search .= " and ap.status = '".$status_db."'";
            }
        }

        
        $current_status = trim($this->request->getVar('current_status') ?? "");

        if($current_status){
            $filter_search .= " and ap.stage = '".$stage."'";
            
            $status_db_current = $this->finding_status__[$current_status];

            $filter_search .= " and ap.status = '".$status_db_current."'";
        }

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        // echo $from_date;
        // exit;
        // check wheter stage and status is selected
        $set_order_by_filter = " ORDER BY s1.submitted_date DESC ";
        if($stage && $status){
            $make_join .= " INNER JOIN ".$stage." date_find_filter ON date_find_filter.pointer_id = ap.id ";
            $set_order_by_filter = " ORDER BY date_find_filter.".$status."_date DESC ";
            if($from_date){
                $filter_search .= " and date_find_filter.".$status."_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.".$status."_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired', 'Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved','Omitted', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT 
                        user.name as user_name, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date, s1_occ.pathway
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ".$set_order_by_filter."
                      LIMIT ?, ?";

        // echo $dataQuery;
        // exit;

        
        $dataResult = $db->query($dataQuery, [$offset, $itemsPerPage])->getResult();
        
        // print_r($dataResult);
        // exit
        // Set up pagination
        $pager = service('pager');
        $pager->makeLinks($currentPage, $itemsPerPage, $totalRows);
        // echo $currentPage." - ".$itemsPerPage." - ".$totalRows;
        // exit;

        // Calculate the start and end number of entries for the current page:
        $start = ($currentPage - 1) * $itemsPerPage + 1;
        $end = min($currentPage * $itemsPerPage, $totalRows);

        // Craft the message:
        // $message = "Showing $start to $end of $totalRows entries";

        // Return to view
        return view('admin/admin_functions/reporting/reporting_pagination_view', [
            'data' => $dataResult,
            'pager' => $pager,
            'currentPage' => $start,
            'itemsPerPage' => $end, 
            'totalRows' => $totalRows, 
            'search_flag' => $search_flag,
            '__stage__' => $stage,
            'status_db' => $status_db,
            'status' => $status,
        ]);

    }
    public function fetch_application_records_agent__accounting(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        // $agent_id = trim($this->request->getVar('agent_id') ?? "");
        // if($agent_id){
        //     $filter_search .= " and ap.user_id = '".$agent_id."'";
        // }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }


        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        // echo $status;
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }
        // echo $filter_search;
        // exit;
        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        // check wheter stage and status is selected
        if($stage && $status){
            $make_join .= " INNER JOIN ".$stage." date_find_filter ON date_find_filter.pointer_id = ap.id ";
            if($from_date){
                $filter_search .= " and date_find_filter.".$status."_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.".$status."_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT user.*, count(ap.id) as agent_count
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      GROUP BY ap.user_id ORDER BY user.account_type,user.business_name,user.name ASC";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery)->getResult();

        echo json_encode($dataResult);
    }

    
    public function fetch_application_records_agent_offshore(){
        $db = db_connect();


        
        $offline_locations_offshores = $this->__getOfflineOffshoresLocation();
        $offline_locations_offshores = array_column($offline_locations_offshores, "id");
        $offline_locations_offshores = implode(",", $offline_locations_offshores);


        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        // $agent_id = trim($this->request->getVar('agent_id') ?? "");
        // if($agent_id){
        //     $filter_search .= " and ap.user_id = '".$agent_id."'";
        // }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }


        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        // echo $status;
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }
        // echo $filter_search;
        // exit;
        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        
        // If location filter is present
        $interview_location = trim($this->request->getVar('interview_location') ?? "");

        if($interview_location){
            $offline_locations_offshores = $interview_location; 
        }

        // check wheter stage and status is selected
        if($stage && $status){
            $make_join .= " INNER JOIN stage_3_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";
            
            $filter_search .= " and location_id IN (".$offline_locations_offshores.")";


            if($from_date){
                $filter_search .= " and date_time >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_time <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT user.*, count(ap.id) as agent_count
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      GROUP BY ap.user_id ORDER BY user.account_type,user.business_name,user.name ASC";

        // echo $dataQuery;
        // exit;

        $dataResult = $db->query($dataQuery)->getResult();

        echo json_encode($dataResult);
    }

    public function __getOfflineOffshoresLocation(){
        return $this->stage_3_offline_location_model->where("venue", "AQATO")->orderBy("city_name", "ASC")->findAll();
    }

    public function fetch_application_records_agent(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        
        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            
            if(!$from_date && !$to_date){
                $filter_search .= " and ap.stage = '".$stage."'";
            }
        }

        
        // $agent_id = trim($this->request->getVar('agent_id') ?? "");
        // if($agent_id){
        //     $filter_search .= " and ap.user_id = '".$agent_id."'";
        // }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }


        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        // echo $status;
        if($status){
            $status_db = $this->finding_status__[$status];
            if(!$from_date && !$to_date){
            $filter_search .= " and ap.status = '".$status_db."'";
            }
        }
        
        $current_status = trim($this->request->getVar('current_status') ?? "");

        if($current_status){
            $filter_search .= " and ap.stage = '".$stage."'";
            
            $status_db_current = $this->finding_status__[$current_status];

            $filter_search .= " and ap.status = '".$status_db_current."'";

        }
        // echo $filter_search;
        // exit;

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }

        // check wheter stage and status is selected
        if($stage && $status){
            $make_join .= " INNER JOIN ".$stage." date_find_filter ON date_find_filter.pointer_id = ap.id ";
            if($from_date){
                $filter_search .= " and date_find_filter.".$status."_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.".$status."_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved',  'Omitted','Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved',  'Omitted','Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT user.*, count(ap.id) as agent_count
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      GROUP BY ap.user_id ORDER BY user.account_type,user.business_name,user.name ASC";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery)->getResult();

        echo json_encode($dataResult);
    }

    public function view_template_report(){
        return view("admin/admin_functions/reporting/view_template_report");
    }

    
    public function view_template_report__accounting(){
        return view("admin/admin_functions/accounting/view_template_accounting");
    }
    
    public function view_template_report__offshore(){
        return view("admin/admin_functions/accounting/view_template_offshore");
    }

    
    public function ajax_fetch_application(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        
        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            if(!$from_date && !$to_date){
                $filter_search .= " and ap.stage = '".$stage."'";
            }
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }


        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }

        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            if(!$from_date && !$to_date){
                $filter_search .= " and ap.status = '".$status_db."'";
            }
        }

            
        $current_status = trim($this->request->getVar('current_status') ?? "");

        if($current_status){
            
            $filter_search .= " and ap.stage = '".$stage."'";
            
            $status_db_current = $this->finding_status__[$current_status];

            $filter_search .= " and ap.status = '".$status_db_current."'";
        }


        // ?mohsin

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }

        // check wheter stage and status is selected
        $set_order_by_filter = " ORDER BY s1.submitted_date DESC ";
        if($stage && $status){
            $make_join .= " INNER JOIN ".$stage." date_find_filter ON date_find_filter.pointer_id = ap.id ";
            
            $set_order_by_filter = " ORDER BY date_find_filter.".$status."_date DESC ";
            
            if($from_date){
                $filter_search .= " and date_find_filter.".$status."_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.".$status."_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT ap.user_id as user_id, user.name as user_name, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date, s1_occ.pathway
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ".$set_order_by_filter."
                      ";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery)->getResult();
        return $dataResult;
    }

    
    public function ajax_fetch_application__accounting(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }

        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }

        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }

        // check wheter stage and status is selected
        $set_order_by_filter = " ORDER BY s1.submitted_date DESC ";
        if($stage && $status){
            $make_join .= " INNER JOIN ".$stage." date_find_filter ON date_find_filter.pointer_id = ap.id ";
            
            $set_order_by_filter = " ORDER BY date_find_filter.".$status."_date DESC ";
            
            if($from_date){
                $filter_search .= " and date_find_filter.".$status."_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.".$status."_date <= '".$to_date."'";
            }

        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data mohsin
        $dataQuery = "SELECT ap.user_id as user_id, user.name as user_name, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date, s1_occ.pathway,  date_find_filter.lodged_date as s3_lodged_date
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ".$set_order_by_filter."
                      ";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery)->getResult();

        
        // Fetch paginated data
        $dataQuery_total = "SELECT COUNT(CASE WHEN s1_occ.pathway = 'Pathway 1' THEN 1 ELSE NULL END) as count_p1, COUNT(CASE WHEN s1_occ.pathway = 'Pathway 2' THEN 1 ELSE NULL END) as count_p2
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY s1.submitted_date DESC";

        // echo $dataQuery;
        // exit;
        
        $dataResult_total = $db->query($dataQuery_total)->getRow();
        // end


        $total__p1 = $dataResult_total->count_p1 * 800;
        $total__p2 = $dataResult_total->count_p2 * 450;
        
        $total__payment = $total__p1 + $total__p2;
        $data__['dataResult'] = $dataResult;
        $data__['total__payment'] = $total__payment;

        return $data__;
    }    

    public function ajax_fetch_application__offshore(){
        $db = db_connect();

        $offline_locations_offshores = $this->__getOfflineOffshoresLocation();
        $offline_locations_offshores = array_column($offline_locations_offshores, "id");
        $offline_locations_offshores = implode(",", $offline_locations_offshores);

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = $non_aqato_filter = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }

        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }

        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        
        // If location filter is present
        $interview_location = trim($this->request->getVar('interview_location') ?? "");

        if($interview_location){
            $offline_locations_offshores = $interview_location; 
        }

        // check wheter stage and status is selected
        $make_join__ = "";
        $set_order_by_filter = " ORDER BY s1.submitted_date DESC ";
        if($stage && $status){
            $make_join .= " INNER JOIN stage_3_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";
            
            $make_join__ .= " INNER JOIN stage_3_reassessment_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";

            $filter_search .= " and date_find_filter.location_id IN (".$offline_locations_offshores.")";

            $non_aqato_filter .= " and interview_location IN (".$offline_locations_offshores.")";


            if($from_date){
                $filter_search .= " and date_find_filter.date_time >= '".$from_date."'";

                $non_aqato_filter .= " and interview_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.date_time <= '".$to_date."'";

                $non_aqato_filter .= " and interview_date <= '".$to_date."'";
            }


        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        
        // Fetch paginated data
        $dataQuery = "SELECT  date_find_filter.time_zone as s3_time_zone, date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ";

        

        // echo $dataQuery;
        // echo "<br><br>";
        // exit;
        
        // $dataResult = $db->query($dataQuery, [$offset, $itemsPerPage])->getResult();

        
        // Fetch paginated data
        $dataQuery__reassement = "SELECT date_find_filter.time_zone as s3_time_zone, date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join__."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ";

        

        // echo $dataQuery__reassement;
        // echo "<br><br>";
        
        // $dataResult__reassements = $db->query($dataQuery__reassement, [$offset, $itemsPerPage])->getResult();

        // print_r($dataResult__reassements);
        // exit;


        $dataQuery_non_aqato = "SELECT 
        NULL as s3_time_zone,
        interview_date as s3_interview_date,
        interview_location as s3_interview_location,
        NULL as user_name,
        pathway as pathway, 
        NULL as user_middle_name,
        NULL as user_last_name, 
        NULL as id,
        NULL as stage,
        NULL as status,
        NULL as application_number,
        full_name as first_or_given_name, 
        NULL as middle_names, 
        NULL as surname_family_name, 
        unique_number as unique_id, 
        dob as date_of_birth, 
        occupation_name as name, 
        NULL as submitted_date, 
        NULL as approved_date 
        FROM `not_aqato_s3` where 1=1 ".$non_aqato_filter." ";
        // echo $dataQuery_non_aqato;
        // echo "<br><br>";


        $overall_query = "
            SELECT *
            FROM (
                ".$dataQuery."
                UNION ALL 
                ".$dataQuery__reassement."
                UNION ALL 
                ".$dataQuery_non_aqato."
                ) AS combined_result
            ORDER BY s3_interview_date DESC
        ";

        // echo $overall_query;
        // exit;
        $dataResult_totals = $db->query($overall_query)->getResult();
        
        // print_r($dataResult_totals);
        // exit;
        $total__ = 0;
        foreach($dataResult_totals as $dataResult_total){
            $total__ += find_one_row("stage_3_offline_location","id", $dataResult_total->s3_interview_location)->cost;
        }


        $data__['dataResult'] = $dataResult_totals;
        $data__['total__payment'] = $total__;

        return $data__;
    }
    
    public function ajax_fetch_application__offshore_old(){
        $db = db_connect();

        $offline_locations_offshores = $this->__getOfflineOffshoresLocation();
        $offline_locations_offshores = array_column($offline_locations_offshores, "id");
        $offline_locations_offshores = implode(",", $offline_locations_offshores);

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
        // $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        $filter_search = $non_aqato_filter = "";
        // if(count($new_search_array) > 0){
        //     foreach($new_search_array as $single_search){
        //         // Check with Unique Id
        //         $single_search = str_replace("[#", "", $single_search);
        //         $single_search = str_replace("]", "", $single_search);

        //         // 
        //         $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
        //     }
        // }
        
        // From date Filter
        

        $stage = trim($this->request->getVar('stage') ?? "");
        if($stage){
            // $filter_search .= " and ap.stage = '".$stage."'";
        }

        
        $agent_id = trim($this->request->getVar('agent_id') ?? "");
        if($agent_id){
            $filter_search .= " and ap.user_id = '".$agent_id."'";
        }

        $prn = trim($this->request->getVar('prn') ?? "");
        if($prn){
            $filter_search .= " and ap.application_number like '%".$prn."%'";
        }

        $d_o_b = trim($this->request->getVar('d_o_b') ?? "");

        if($d_o_b){
            $d_o_b = date("d/m/Y", strtotime($d_o_b));
            $filter_search .= " and s1_p.date_of_birth like '%".$d_o_b."%'";
        }

        
        $pathway = trim($this->request->getVar('pathway') ?? "");

        if($pathway){
            $filter_search .= " and s1_occ.pathway = '".$pathway."'";
        }

        $occupation = trim($this->request->getVar('occupation') ?? "");
        // echo $occupation;
        // exit;
        if($occupation){
            $filter_search .= " and s1_occ.occupation_id = '".$occupation."'";
        }

        $applicant_no = trim($this->request->getVar('applicant_no') ?? "");
        if($applicant_no){
            if($applicant_no == "[#T.B.A]"){

                $filter_search .= " and s1.unique_id = ''";

            }
            else{
                $applicant_no = str_replace("[#", "", $applicant_no);
                $applicant_no = str_replace("]", "", $applicant_no);
                $filter_search .= " and s1.unique_id like '%".$applicant_no."%'";
            }
            
        }


        $status = trim($this->request->getVar('status') ?? "");
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
            // $filter_search .= " and ap.status = '".$status_db."'";
        }

        // Make Inner Join Functions
        $make_join = "";
        $from_date = trim($this->request->getVar('from_date') ?? "");
        $to_date = trim($this->request->getVar('to_date') ?? "");

        if($from_date && $to_date){
            // $from_date = date("Y-m-d", strtotime($from_date." -1 day"));
            $to_date = date("Y-m-d", strtotime($to_date." +1 day"));
            
            // $from_date = $from_date;
            $to_date = $to_date;
        }
        
        // If location filter is present
        $interview_location = trim($this->request->getVar('interview_location') ?? "");

        if($interview_location){
            $offline_locations_offshores = $interview_location; 
        }

        // check wheter stage and status is selected
        $make_join__ = "";
        $set_order_by_filter = " ORDER BY s1.submitted_date DESC ";
        if($stage && $status){
            $make_join .= " INNER JOIN stage_3_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";
            
            $make_join__ .= " INNER JOIN stage_3_reassessment_interview_booking date_find_filter ON date_find_filter.pointer_id = ap.id ";

            $filter_search .= " and date_find_filter.location_id IN (".$offline_locations_offshores.")";

            $non_aqato_filter .= " and interview_location IN (".$offline_locations_offshores.")";


            if($from_date){
                $filter_search .= " and date_find_filter.date_time >= '".$from_date."'";

                $non_aqato_filter .= " and interview_date >= '".$from_date."'";
            }

            
            if($to_date){
                $filter_search .= " and date_find_filter.date_time <= '".$to_date."'";

                $non_aqato_filter .= " and interview_date <= '".$to_date."'";
            }


        }
        else{
            
            if($from_date){
                $filter_search .= " and s1.submitted_date >= '".$from_date."'";
            }
            if($to_date){
                $filter_search .= " and s1.submitted_date <= '".$to_date."'";
            }
        }
        // end
        

        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        // END

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       ".$make_join."
                       INNER JOIN user_account user ON user.id = ap.user_id
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter;
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;

        

        // print_r($dataResult__reassements);
        // exit;



        // exit;
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated data
        $dataQuery = "SELECT date_time as s3_interview_date,location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY date_find_filter.date_time DESC";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery)->getResult();


        
        // Fetch paginated data
        $dataQuery__reassement = "SELECT date_find_filter.date_time as s3_interview_date,date_find_filter.location_id as s3_interview_location, user.name as user_name,s1_occ.pathway, user.middle_name as user_middle_name, user.last_name as user_last_name, ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date
                      FROM application_pointer ap 
                      ".$make_join__."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                      ORDER BY date_find_filter.date_time DESC";

        

        // echo $dataQuery__reassement;
        // exit;
        
        $dataResult__reassements = $db->query($dataQuery__reassement)->getResult();



        $dataQuery_non_aqato = "SELECT * FROM `not_aqato_s3` where 1=1 ".$non_aqato_filter." ORDER BY interview_date DESC";
        // echo $dataQuery_non_aqato;
        // exit;

        $dataResult_non_aqatos = $db->query($dataQuery_non_aqato)->getResult();

        // print_r($dataResult_non_aqatos);
        $non_aqato_total = 0;
        foreach($dataResult_non_aqatos as $dataResult_non_aqato){
            
            $new_array = [
                "s3_interview_date" => $dataResult_non_aqato->interview_date,
                "s3_interview_location" => $dataResult_non_aqato->interview_location,
                "user_name" => "Mohsin",
                "pathway" => ($dataResult_non_aqato->pathway) ? $dataResult_non_aqato->pathway : "---",
                "user_middle_name" => "",
                "user_last_name" => "Doe",
                "id" => "",
                "stage" => "stage_4",
                "status" => "Approved",
                "application_number" => "23AQ01295",
                "first_or_given_name" => $dataResult_non_aqato->full_name,
                "middle_names" => "",
                "surname_family_name" => "",
                "unique_id" => $dataResult_non_aqato->unique_number,
                "date_of_birth" => ($dataResult_non_aqato->dob) ? date("d/m/Y", strtotime($dataResult_non_aqato->dob)) : "---",
                "name" => $dataResult_non_aqato->occupation_name,
                "submitted_date" => "2023-10-09 18:08:34",
                "approved_date" => "2023-10-09 19:20:30",
            ];
            $stdClassObject = new stdClass();

            foreach ($new_array as $key => $value) {
                $stdClassObject->$key = $value;
            }

            array_push($dataResult, $stdClassObject);

            // Total Cost

            $non_aqato_total += find_one_row("stage_3_offline_location","id", $dataResult_non_aqato->interview_location)->cost;
        }
        
        $total__reassement = 0;

        foreach($dataResult__reassements as $dataResult__reassement){
            $new_array = [
                "s3_interview_date" => $dataResult__reassement->s3_interview_date,
                "s3_interview_location" => $dataResult__reassement->s3_interview_location,
                "user_name" => $dataResult__reassement->user_name,
                "pathway" => $dataResult__reassement->pathway,
                "user_middle_name" => $dataResult__reassement->user_middle_name,
                "user_last_name" => $dataResult__reassement->user_last_name,
                "id" => $dataResult__reassement->id,
                "stage" => $dataResult__reassement->stage,
                "status" => $dataResult__reassement->status,
                "application_number" => $dataResult__reassement->application_number,
                "first_or_given_name" => $dataResult__reassement->first_or_given_name,
                "middle_names" => $dataResult__reassement->middle_names,
                "surname_family_name" => $dataResult__reassement->surname_family_name,
                "unique_id" => $dataResult__reassement->unique_id,
                "date_of_birth" => $dataResult__reassement->date_of_birth,
                "name" => $dataResult__reassement->name,
                "submitted_date" => $dataResult__reassement->submitted_date,
                "approved_date" => $dataResult__reassement->approved_date,
            ];
            $stdClassObject = new stdClass();

            foreach ($new_array as $key => $value) {
                $stdClassObject->$key = $value;
            }

            array_push($dataResult, $stdClassObject);

            $total__reassement += find_one_row("stage_3_offline_location","id", $dataResult__reassement->s3_interview_location)->cost;

        }


        // Sort the array by "s3_interview_date" in descending order
        usort($dataResult, [$this, 'sortByInterviewDateDesc']);

        // print_r($dataResult);
        // exit;
        
        // Fetch paginated data
        $dataQuery_total = "SELECT date_find_filter.*
                      FROM application_pointer ap 
                      ".$make_join."
                      INNER JOIN user_account user ON user.id = ap.user_id
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter."
                        ";

        // echo $dataQuery;
        // exit;
        
        $dataResult_totals = $db->query($dataQuery_total)->getResult();
        $total__ = 0;
        foreach($dataResult_totals as $dataResult_total){
            $total__ += find_one_row("stage_3_offline_location","id", $dataResult_total->location_id)->cost;
        }

        $total__ += $non_aqato_total + $total__reassement;

        $data__['dataResult'] = $dataResult;
        $data__['total__payment'] = $total__;

        return $data__;
    }

    public function download_report_spreadsheet(){
        
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        // Comment for error code
        $htmlString = $this->__make_struct_report("yes");
        
        require 'vendor/autoload.php';
        libxml_use_internal_errors(true); // Suppress DOMDocument warnings

        // Create a temporary file and write the HTML content to it
        $tempFile = tempnam(sys_get_temp_dir(), 'html');
        file_put_contents($tempFile, $htmlString);

        // Create a new Spreadsheet and a new HTML reader
        $reader = new Html();

        // Load the HTML string into PhpSpreadsheet from the temporary file
        $spreadsheet = $reader->load($tempFile);

        libxml_use_internal_errors(false); // Re-enable errors if desired

        // Clean up the temporary file
        unlink($tempFile);

        // Save the Excel file
        $writer = new Xlsx($spreadsheet);
        $file_path = "public/Reporting.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporting.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save($file_path);

        echo base_url()."/".$file_path;


    }

    
    public function download_report_spreadsheet__accounting(){
        
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        // Comment for error code
        $htmlString = $this->__make_struct_report__accounting("yes");
        
        require 'vendor/autoload.php';
        libxml_use_internal_errors(true); // Suppress DOMDocument warnings

        // Create a temporary file and write the HTML content to it
        $tempFile = tempnam(sys_get_temp_dir(), 'html');
        file_put_contents($tempFile, $htmlString);

        // Create a new Spreadsheet and a new HTML reader
        $reader = new Html();

        // Load the HTML string into PhpSpreadsheet from the temporary file
        $spreadsheet = $reader->load($tempFile);

        libxml_use_internal_errors(false); // Re-enable errors if desired

        // Clean up the temporary file
        unlink($tempFile);

        // Save the Excel file
        $writer = new Xlsx($spreadsheet);
        $file_path = "public/Referral-Fees.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Referral-Fees.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save($file_path);

        echo base_url()."/".$file_path;


    }

    
    public function download_report_spreadsheet_offshore(){
        
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        // Comment for error code
        $htmlString = $this->__make_struct_report__offshore("yes");
        
        require 'vendor/autoload.php';
        libxml_use_internal_errors(true); // Suppress DOMDocument warnings

        // Create a temporary file and write the HTML content to it
        $tempFile = tempnam(sys_get_temp_dir(), 'html');
        file_put_contents($tempFile, $htmlString);

        // Create a new Spreadsheet and a new HTML reader
        $reader = new Html();

        // Load the HTML string into PhpSpreadsheet from the temporary file
        $spreadsheet = $reader->load($tempFile);

        libxml_use_internal_errors(false); // Re-enable errors if desired

        // Clean up the temporary file
        unlink($tempFile);

        // Save the Excel file
        $writer = new Xlsx($spreadsheet);
        $file_path = "public/Offshores-Fees.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Offshores-Fees.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save($file_path);

        echo base_url()."/".$file_path;


    }


    public function download_report_offshore(){

        // echo $html;
        // exit;
        $html = $this->__make_struct_report__offshore();
        // echo $html;
        // exit;
        require_once "dompdf/autoload.inc.php";
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Changed 'portrait' to 'landscape'
        $dompdf->set_option("isPhpEnabled", true); //
        $dompdf->render();

        $sss = "public/Offshores-Fees.pdf";
        file_put_contents($sss, $dompdf->output());
        echo base_url()."/".$sss;
        // Stream the PDF to the browser
        // $dompdf->stream("Reporting.pdf");

    }

    public function download_report__accounting(){

        // echo $html;
        // exit;
        $html = $this->__make_struct_report__accounting();
        // echo $html;
        // exit;
        require_once "dompdf/autoload.inc.php";
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Changed 'portrait' to 'landscape'
        $dompdf->set_option("isPhpEnabled", true); //
        $dompdf->render();

        $sss = "public/Referral-Fees.pdf";
        file_put_contents($sss, $dompdf->output());
        echo base_url()."/".$sss;
        // Stream the PDF to the browser
        // $dompdf->stream("Reporting.pdf");

    }
    
    public function download_report(){

        // echo $html;
        // exit;
        $html = $this->__make_struct_report();
        require_once "dompdf/autoload.inc.php";
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadhtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Changed 'portrait' to 'landscape'
        $dompdf->set_option("isPhpEnabled", true); //
        $dompdf->render();

        $sss = "public/Reporting.pdf";
        file_put_contents($sss, $dompdf->output());
        echo base_url()."/".$sss;
        // Stream the PDF to the browser
        // $dompdf->stream("Reporting.pdf");

    }

    public function getTheCountry(){
        $id = $this->request->getPost("country_id");
        $country = $this->country_model->find($id);
        echo json_encode($country);
    }

    
    function __make_struct_report__offshore($isExcel = ""){
        
        $__stage__ = trim($this->request->getVar('stage') ?? "");
        
        $status = trim($this->request->getVar('status') ?? "");
        
        
        $to_date = trim($this->request->getVar('to_date') ?? "");
        
        
        $from_date = trim($this->request->getVar('from_date') ?? "");
        
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
        }


        $html = file_get_contents(base_url("admin/admin_functions/accounting/view_template_report_offshore"));
        
        if($isExcel){
            $html = '
                                    
                    <table class="table table-striped datatable table-hover dataTable no-footer">
                    <thead>
                        <tr class="header_section_sticky">
                            <th colspan="9" style="background-color: #a0cd63; text-align: center; font-weight: bold;">
                                Offshore Interviews Sheet
                            </th>
                        </tr>
                        %filters_dates%
                        <tr>
                        </tr>
                        <tr>
                            <th style="width: 5%;background-color: #d9d9d9;"><b>Sr.No.</b></th>
                            <th style="width: 10%; text-align: left;background-color: #d9d9d9;"><b>Applicant No.</b></th>
                            <th style="width: 25%;background-color: #d9d9d9;"><b>Applicant Name </b></th>
                            <th style="width: 10%;background-color: #d9d9d9;"><b>D.O.B </b></th>
                            <th style="width: 15%;background-color: #d9d9d9;"><b>Occupation</b></th>
                            <th style="background-color: #d9d9d9;"><b>Pathway</b></th>
                            <th style="width: 15%;background-color: #d9d9d9;"><b>Interview Location</b></th> 
                            <th style="background-color: #d9d9d9;"><b>Interview Date</b></th> 
                            <th style="width: 5%;background-color: #d9d9d9;"  class="text-center"><b>Amount (AUD)</b></th>
                            
                        </tr>
                    </thead>
                    %tbody%
                    </table>
            
            ';
        }

        $results = $this->ajax_fetch_application__offshore();
        // print_r($results);
        // exit;
        $tbody = "";
        $flag___ = $count = 0;
        $tbody .= '<tbody>';
        foreach ($results["dataResult"] as $item){
            $count++;
            

            $unique_id = ($item->unique_id) ? "[#".$item->unique_id."]" : "[#T.B.A]";
            $full_name = (($item->first_or_given_name) ? $item->first_or_given_name : "")." ".(($item->middle_names) ? $item->middle_names : "")." ".(($item->surname_family_name) ? $item->surname_family_name : "");   


            $s3_location = find_one_row("stage_3_offline_location","id", $item->s3_interview_location);
            $full_locations = $s3_location->city_name." - ".$s3_location->country;
            
            $date_dob_checker = $item->date_of_birth;
            if(strtotime($date_dob_checker)){
              // it's a date
              $date_dob_checker = date("d/m/Y", strtotime($date_dob_checker));
            }

            $tbody .= '
                
            <tr>
                <td style="text-align: left;">'.$count.'</td>
                <td style="text-align: left;">'.$unique_id.'</td>
                <td style="text-align: left;"><a style="color: #009933;">'. trim($full_name) .'</a></td>
                <td style="text-align: left;">'. $date_dob_checker .'</td>
                <td style="text-align: left;">'. $item->name .'</td>
                <td style="text-align: left;">'. $item->pathway .'</td>
                <td style="text-align: left;">
                    '. $full_locations .'
                </td>
                <td style="text-align: left;">'. date("d/m/Y", strtotime($item->s3_interview_date)) .'</td>
                <td style="text-align: left;">$'. number_format($s3_location->cost, 2) .'</td>
                
            </tr>
            ';
        }
        $tbody .= '</tbody';
        $tbody .= '
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center" style="font-weight: bold;background-color: #fffd54;"><b>Total</b></td>
                <td class="text-center" style="font-weight: bold;background-color: #fffd54;">$'.number_format($results["total__payment"],2).'</td>
            </tr>
        </tfoot>
        
        ';

        // 
        $date_filters = "";
        
        
        if($from_date && $to_date){
            $date_filters .= date("d/m/Y", strtotime($from_date)).' to '.date("d/m/Y", strtotime($to_date));
        }
        
        $html_tr = "";
        if($date_filters){
            $html_tr = '<tr>
                            <th colspan="9" style="background-color: #a0cd63; text-align: center; font-weight: bold;">
                                '.$date_filters.'
                            </th>
                        </tr>';
        }
        
        $html = str_replace("%filters_dates%",$html_tr,$html);
        
        $html = str_replace("%date_filter%",$date_filters,$html);
        

        $html = str_replace("%tbody%", $tbody, $html);
        // echo $html;
        // exit;
        return $html;
    }

    function __make_struct_report__accounting($isExcel = ""){
        
        $__stage__ = trim($this->request->getVar('stage') ?? "");
        
        $status = trim($this->request->getVar('status') ?? "");
        
        
        $to_date = trim($this->request->getVar('to_date') ?? "");
        
        
        $from_date = trim($this->request->getVar('from_date') ?? "");
        
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
        }


        $html = file_get_contents(base_url("admin/admin_functions/accounting/view_template_report"));
        
        if($isExcel){
            $html = '
                    <table class="table table-striped datatable table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th colspan="9" style="background-color: #a0cd63; text-align: center; font-weight: bold;">
                                Referral Fees Sheet
                            </th>
                        </tr>
                        %filters_dates%
                        <tr>
                            <th colspan="9"></th>
                        </tr>
                        <tr>
                            <th style="width: 5%;background-color: #d9d9d9;"><b>Sr.No.</b></th>
                            <th style="background-color: #d9d9d9;"><b>Applicant No.</b></th>
                            <th style="column-width: 50px; background-color: #d9d9d9;"><b>Applicant Name </b></th>
                            <th style="background-color: #d9d9d9;"><b>D.O.B </b></th>
                            <th style="background-color: #d9d9d9;"><b>Occupation</b></th>
                            <th style="background-color: #d9d9d9;"><b>Pathway</b></th>
                            <th style="background-color: #d9d9d9;"><b>Payment Date</b></th> 
                            <th style="background-color: #d9d9d9;"><b>Date Lodged</b></th> 
                            <th style="background-color: #d9d9d9;"  class="text-center"><b>Amount (AUD)</b></th>
                            
                        </tr>
                    </thead>
                    %tbody%
                    </table>
            
            ';
        }

        $results = $this->ajax_fetch_application__accounting();
        // print_r($results);
        // exit;
        $tbody = "";
        $flag___ = $count = 0;
        $tbody .= '<tbody>';
        foreach ($results["dataResult"] as $item){
            $count++;
            

            $unique_id = ($item->unique_id) ? "[#".$item->unique_id."]" : "[#T.B.A]";
            $full_name = (($item->first_or_given_name) ? $item->first_or_given_name : "")." ".(($item->middle_names) ? $item->middle_names : "")." ".(($item->surname_family_name) ? $item->surname_family_name : "");   
        
            $additional_info_request = find_one_row_2_field_for_flag_pagination('additional_info_request', 'pointer_id', $item->id,'stage', $item->stage);

            $price__ = 0;
            if($item->pathway == "Pathway 1"){
                $price__ = 800;
            }

            else if($item->pathway == "Pathway 2"){
                $price__ = 450;
            }

            $payment_date = find_one_row("stage_3", "pointer_id", $item->id)->payment_date;

            $tbody .= '
                
            <tr>
                <td style="text-align: left;">'.$count.'</td>
                <td style="text-align: left;">'.$unique_id.'</td>
                <td style="text-align: left;"><a style="color: #009933;">'. trim($full_name) .'</a></td>
                <td style="text-align: left;">'. $item->date_of_birth .'</td>
                <td style="text-align: left;">'. $item->name .'</td>
                <td style="text-align: left;">'. $item->pathway .'</td>
                <td style="text-align: left;">
                    '. date("d/m/Y", strtotime($payment_date)) .'
                </td>
                <td style="text-align: left;">'. date("d/m/Y", strtotime($item->s3_lodged_date)) .'</td>
                <td style="text-align: left;">$'. number_format($price__, 2) .'</td>
                
            </tr>
            ';
        }
        $tbody .= '</tbody';
        $tbody .= '
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center" style="font-weight: bold;background-color: #fffd54;"><b>Total</b></td>
                <td class="text-center" style="font-weight: bold;background-color: #fffd54;">$'.number_format($results["total__payment"], 2).'</td>
            </tr>
        </tfoot>
        
        ';
        
        // Applying Header
        $date_filters = "";
        
        if($from_date && $to_date){
            $date_filters .= date("d/m/Y", strtotime($from_date)).' to '.date("d/m/Y", strtotime($to_date));
        }
        
        
        $html_tr = "";
        if($date_filters){
            $html_tr = '<tr>
                            <th colspan="9" style="background-color: #a0cd63; text-align: center; font-weight: bold;">
                                '.$date_filters.'
                            </th>
                        </tr>';
        }
        
        $html = str_replace("%filters_dates%",$html_tr,$html);
        
        $html = str_replace("%date_filter%",$date_filters,$html);

        $html = str_replace("%tbody%", $tbody, $html);
        // echo $html;
        // exit;
        return $html;
    }

    
    function __make_struct_report($isExcel = ""){
        
        $__stage__ = trim($this->request->getVar('stage') ?? "");
        
        $status = trim($this->request->getVar('status') ?? "");
        
        
        $to_date = trim($this->request->getVar('to_date') ?? "");
        
        
        $from_date = trim($this->request->getVar('from_date') ?? "");
        
        $status_db = "";
        if($status){
            $status_db = $this->finding_status__[$status];
        }


        $html = file_get_contents(base_url("admin/admin_functions/view_template_report"));

        if($isExcel){
            $html = '
                <table class="table table-striped datatable table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th colspan="9" style="background-color: #a0cd63; text-align: center; font-weight: bold;">
                            Reporting
                        </th>
                    </tr>
                    <tr>
                        <th colspan="9"></th>
                    </tr>
                    <tr>
                        <th style="width: 5%;background-color: #d9d9d9;">
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Portal Reference No.">
                                Sr.No.
                            </span>
                        </th>
                        <th style="width: 5%;background-color: #d9d9d9;"><b>PRN</b></th>
                        <th style="background-color: #d9d9d9;">Applicant No.</th>
                        <th style="background-color: #d9d9d9;">Applicant Name </th>
                        <th style="background-color: #d9d9d9;">D.O.B </th>
                        <th style="background-color: #d9d9d9;">Occupation</th>
                        <td style="background-color: #d9d9d9;"><b>Pathway </b></td>
                        <th style="background-color: #d9d9d9;">Date %__date_stage__%</th>
                        <th style="background-color: #d9d9d9;">Current Status</th>
                        %__agent_name__%
                    </tr>
                </thead>
                <tbody>
                    %tbody%
                </tbody>
                </table>
            
            ';
        }

        $results = $this->ajax_fetch_application();

        $tbody = "";
        $flag___ = $count = 0;
        foreach ($results as $item){
            $count++;
            $unique_id = ($item->unique_id) ? "[#".$item->unique_id."]" : "[#T.B.A]";
            $full_name = (($item->first_or_given_name) ? $item->first_or_given_name : "")." ".(($item->middle_names) ? $item->middle_names : "")." ".(($item->surname_family_name) ? $item->surname_family_name : "");   
            
            $stage_index = application_stage_no($item->id);
            
            $current_status = create_status_rename(create_status_format($stage_index),$item->id);
            
            $additional_info_request = find_one_row_2_field_for_flag_pagination('additional_info_request', 'pointer_id', $item->id,'stage', $item->stage);


            $current_status__ = "";
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
                            $current_status__ = "Closed";
                    } else {
                        $current_status__ = $current_status;
                    }
                } else {
                    $current_status__ =  $current_status;
                }

                $date_to_show = date("d/m/Y", strtotime($item->submitted_date));
                if($__stage__ && $status_db){
                    $stage_date__ =find_one_row($__stage__, "pointer_id", $item->id);
                    $date_to_show =  date("d/m/Y", strtotime($stage_date__->{$status."_date"}));
                }
                $tbody__ = "";
                // print_r($item);
                // exit;
                if($__stage__ == "stage_2" && $status == "approved"){
                    $user_details = find_one_row("user_account", "id", $item->user_id);
                    $full_name__ = "";
                    // print_r($user_details);
                    // exit;
                    if($user_details->business_name){
                        $full_name__ = $user_details->business_name;
                    }else{
                        $full_name__ = (($user_details->name) ? $user_details->name." " : "").(($user_details->last_name) ? $user_details->last_name : "");
                    }
                    $tbody__ = "<td>".$full_name__."</td>";
                }

            $tbody .= '
            <tr>
                <td>'.$count.'</td>
                <td>'.$item->application_number.'</td>
                <td>'.$unique_id.'</td>
                <td><a style="color: #009933;">'.$full_name.'</a></td>
                <td>'.$item->date_of_birth.'</td>
                <td>'.$item->name.'</td>
                <td>'.$item->pathway.'</td>
                <td>'.$date_to_show.'</td>
                <td>'.$current_status__.'</td>
                '.$tbody__.'
            </tr>
            ';
        }


        $date__string = "Submitted";
        
        if($__stage__ && $status_db){
            $date__string = $status_db;
        }
        $agent_name = "";
        if($__stage__ == "stage_2" && $status == "approved"){
            $agent_name = "<th>Agent / Applicant Name<th>";
        }
        // 
        $date_filters = "";
        
        if($from_date && $to_date){
            $date_filters .= date("d/m/Y", strtotime($from_date)).' to '.date("d/m/Y", strtotime($to_date));
        }

        
        $html = str_replace("%date_filter%",$date_filters,$html);
        
        $html = str_replace("%__agent_name__%",$agent_name,$html);

        $html = str_replace("%__date_stage__%", $date__string, $html);
        $html = str_replace("%tbody%", $tbody, $html);
        return $html;
    }

}

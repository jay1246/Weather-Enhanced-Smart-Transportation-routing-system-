<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class submitted_applications extends BaseController
{
    public function submitted_applications()
    {

        $data["page_name"] = "Submitted Applications";
        $user_id = session()->get("user_id");
        $application_pointer = $this->application_pointer_model->where(['user_id' => $user_id])->orderby('create_date', 'desc')->find();

        $table_data = array();
        foreach ($application_pointer as $res) {
            $pointer_id = $res['id'];

            // stage_1 = 1 to 10  index
            // stage_2 = 11 to 20  index
            // stage_3 = 21 to 30  index

            // helper call 
            $stage_index = application_stage_no($pointer_id);

            if ($stage_index >= 2) {

                $singal_table_data = array();
                // helper call
                $singal_table_data['ENC_pointer_id'] =  pointer_id_encrypt($res['id']);
                // helper call
                $singal_table_data['status_format'] =   create_status_format($stage_index);
                // helper call
                $singal_table_data['application_mo'] =  application_mo($pointer_id);
                $singal_table_data['portal_reference_no'] =  portal_reference_no($pointer_id);

                $singal_table_data['pointer_id'] =  $res['id'];



                // date format
                $created_at = $res['create_date'];
                $singal_table_data['created_at'] = $created_at;
                $created_at = strtotime($created_at);
                $created_at =  date("d/m/Y", $created_at);
                $singal_table_data['created_at_format'] =  empty($created_at) ? '--//--' : $created_at;



                // table 1
                $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->first();
                $singal_table_data['first_or_given_name'] = empty($personal_details['first_or_given_name']) ? '--//--' : $personal_details['first_or_given_name'];
                $singal_table_data['surname_family_name'] = empty($personal_details['surname_family_name']) ? '' : $personal_details['surname_family_name'];
                $singal_table_data['date_of_birth'] = empty($personal_details['date_of_birth']) ? '--//--' : $personal_details['date_of_birth'];
                // table 2 
                $occupation_application = $this->stage_1_occupation_model->where(['pointer_id' => $pointer_id])->first();

                $occupation_id = $occupation_application['occupation_id'];

                $occupation_list = $this->occupation_list_model->where(['id' => $occupation_id])->first();

                $singal_table_data['occupation'] =   empty($occupation_list['name']) ? '--//--' : $occupation_list['name'];
                // creat mainaray 


                // 25-04-2023 vishal
                $stage_1 = find_one_row('stage_1', 'pointer_id', $pointer_id);
                $submitted_date = $stage_1->submitted_date;
                $approved_date = $stage_1->approved_date;
                $singal_table_data['submitted_date'] = $submitted_date;
                $singal_table_data['approved_date'] = $approved_date;
                $singal_table_data['expiry_date'] = $stage_1->expiry_date;
                $singal_table_data['closure_date'] = $stage_1->closure_date;
                

                $submitted_date = strtotime($submitted_date);
                $submitted_date =  date("d/m/Y", $submitted_date);
                $submitted_date = empty($submitted_date) ? '--//--' : $submitted_date;
                $singal_table_data['submitted_date_format'] = $submitted_date;



                $table_data[] = $singal_table_data;
            }
        }


        $data['table_data'] = $table_data;
        $data['page'] = "Submitted Applications";
        return view('user/submitted_applications', $data);
    }
    
    public function submitted_applications_pagination()
    {

        $data["page_name"] = "Submitted Applications";
        $data['page'] = "Submitted Applications";
        return view('user/submitted_applications_pagination', $data);
    }


    
    private function date_filter_logic($search_input){
        $date_string = explode("/",$search_input);
        // print_r($date_string);
        // exit;
        if(count($date_string) > 1)
        {
            if(count($date_string) == 2){
                $date_string = $date_string[1]."-".$date_string[0];
            }else if(count($date_string) == 3){
                $date_string = $date_string[2]."-".$date_string[1]."-".$date_string[0];
            }
        }
        else{
            $date_string = "";
        }            
        
        $add_date_filter = "";
        if($date_string){
            $add_date_filter = " OR s1.submitted_date like '%".$date_string."%'";
        }
        return $add_date_filter;      
    }

    private function name_filter_logic($search_input){

        $search_input = trim($search_input);
        $new_search_array = explode(" ", $search_input);
        // Making Foreach Loop to check each word
        // print_r($new_search_array);
        // die;
        $filter_search = "";
        if(count($new_search_array) > 0){
            foreach($new_search_array as $single_search){
                // Check with Unique Id
                $single_search = str_replace("[#", "", $single_search);
                $single_search = str_replace("]", "", $single_search);

                // 
                $filter_search .= " 
                AND pd.first_or_given_name like '%".$single_search."%' 
                OR pd.middle_names like '%".$single_search."%' 
                OR pd.surname_family_name like '%".$single_search."%' 
                ";
            }
        }
        return $filter_search;

    }


    private function getShortcutLogic($search_input){
        $new_search_array = explode("-", $search_input);
        $stage = strtolower(trim($new_search_array[0]));
        
        $stage = stageFinder($stage);
        
        $filter_search = "";

        // $name == "S1 - Declined" || $name == "S1 - Withdrawn"    || $name == "S2 - Withdrawn" - Closed

        // else  if ($name == "S3 - Approved"   || $name == "S3 - Declined" || $name == "S3 - Withdrawn") - Completed

        // else  if ($name == "S3 - Approved (R)"   || $name == "S3 - Declined (R)" || $name == "S3 - Withdrawn (R)") { - Completed
        

        // } else  if ($name == "S4 - Approved" || $name == "S4 - Declined" || $name == "S4 - Withdrawn") { - Completed

        // Closed
        if($search_input == "Closed" || $search_input == "closed"){
            $stage = "stage_1";
            $status = "Expired";
            $filter_search .= " 
                OR (ap.stage = 'stage_1' and (ap.status like '%Declined%' OR ap.status like '%Withdrawn%' OR ap.status like '%Expired%'))";
            return $filter_search;
            exit;
        }
        // 

        
        // Completed
        if($search_input == "Completed" || $search_input == "completed"){
            $stage = "stage_1";
            $status = "Expired";
            $filter_search .= " 
                OR ((ap.stage = 'stage_3' OR ap.stage = 'stage_4') and (ap.status like '%Approved%' OR ap.status like '%Declined%' OR ap.status like '%Withdrawn%'))";
            return $filter_search;
            exit;
        }
        // 


        // For the Stage adding Filter
        if($stage != ""){
            $filter_search .= "
            OR ( ap.stage like '%".$stage."%' 
            ";
        }

        

        // For the Status adding Filter
        if(count($new_search_array) == 2){
            $status = trim($new_search_array[1]);
            // $status = strtolower($status);
            $status = str_replace(" ", "_", $status);
            
            $filter_search .= " 
                AND ap.status like '%".$status."%' 
                ";
            
        }

        
        // For the Stage adding Filter
        if($stage != ""){
            $filter_search .= "
                )
            ";
        }

        // echo $filter_search;
        // exit;
        
        return $filter_search;

        // echo $stage;
        // exit;
    }



    public function submitted_applications_fetch_data(){
        
        $db = db_connect();

        $session = session();
        
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;

        $search_input = trim($this->request->getVar('search_input') ?? "");

        // echo $search_input;
        // exit;

        $apply_filter = "";

        if($search_input){

            // Str replace
            $search_input = str_replace("[#", "", $search_input);
            $search_input = str_replace("]", "", $search_input);

            // For the date Logic
            $add_date_filter = $this->date_filter_logic($search_input);
            // End

            // Name Logic
            $add_name_filter = $this->name_filter_logic($search_input);
            // end

            // Shortcuts Logics 
            $add_shortcut_filter = $this->getShortcutLogic($search_input);
            // echo $add_shortcut_filter;
            // END



            $apply_filter .= " and( ( 1=1
            ".$add_name_filter."
             OR s1.unique_id like '%".$search_input."%'
             OR occ.name like '%".$search_input."%'
             ".$add_date_filter.") ) ".$add_shortcut_filter."";

            //  echo $apply_filter;
            //  exit;   
        }



        $sql_query = '
        SELECT 
        ap.application_number  as application_number,
        s1.unique_id as unique_id,
        pd.first_or_given_name as first_or_given_name,
        pd.middle_names as middle_names,
        pd.surname_family_name as surname_family_name,
        pd.date_of_birth as date_of_birth,
        occ.name as occupation,
        ap.create_date as create_date,
        s1.pointer_id as pointer_id,
        s1.submitted_date as submitted_date,
        s1.approved_date as approved_date
        FROM 
        application_pointer ap 
        INNER JOIN stage_1 s1 ON s1.pointer_id = ap.id
        INNER JOIN stage_1_personal_details pd ON pd.pointer_id = s1.pointer_id
        INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id = s1.pointer_id
        INNER JOIN occupation_list occ ON occ.id = s1_occ.occupation_id
        WHERE 
        ap.user_id = '.$session->user_id.' 
        AND NOT (ap.stage = "stage_1" AND ap.status = "Start")
        '.$apply_filter.'
        ORDER BY ap.create_date DESC
        ';

        // echo $sql_query;
        // exit;

        
        $countResult = $db->query($sql_query)->getResult();
        $totalRows = count($countResult);

        $new_sql_query = $sql_query." LIMIT ?, ?";

        
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        
        $dataResult = $db->query($new_sql_query, [$offset, $itemsPerPage])->getResultArray();
        
        $pager = service('pager');
        $pager->makeLinks($currentPage, $itemsPerPage, $totalRows);
        
        // Calculate the start and end number of entries for the current page:
        $start = ($currentPage - 1) * $itemsPerPage + 1;
        $end = min($currentPage * $itemsPerPage, $totalRows);


        return view("user/fetch_submitted_applications", [
            'table_data' => $dataResult,
            'pager' => $pager,
            'currentPage' => $start,
            'itemsPerPage' => $end, 
            'totalRows' => $totalRows, 
        ]);
    }

}

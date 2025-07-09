<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use DateTime as GlobalDateTime;
use DateTime;
use DateTimeZone;
class admin extends BaseController
{

    public function stage_3_date_vishal()
    {
        echo "<pre>";
        $stage_3 = $this->stage_3_model->asObject()->find();
        foreach ($stage_3 as $key => $value) {
            $status = $value->status;

            $in_progress_date = '0000-00-00 00:00:00';
            $lodged_date = $value->lodged_date;
            $approved_date = $value->approved_date; if($stage_[0] == 'S4'){
                    $get_submit_date = find_one_row('stage_4', 'pointer_id', $pointer_id)->lodged_date;
                }
            $declined_date = $value->declined_date;
            if ($status == "Submitted") {
                $declined_date =  $approved_date =  $lodged_date = '0000-00-00 00:00:00';
            } elseif ($status == "Lodged") {
                $declined_date =  $approved_date   = '0000-00-00 00:00:00';
            } elseif ($status == "Approved") {
                $declined_date  = '0000-00-00 00:00:00';
            }
            print_r($value);

            echo "<br>" . $lodged_date;
            echo "<br>" . $in_progress_date;
            echo "<br>" . $approved_date;
            $pointer_id = $value->pointer_id;
            echo $this->stage_3_model->where(['pointer_id' => $pointer_id])->set(['lodged_date' => $lodged_date, 'in_progress_date' => $in_progress_date, 'approved_date' => $approved_date])->update();
            echo "<hr>";
        }
    }
    // -------------- dashboard ----------------

  public function dashboard($operation = "")
    {
        $show_oly = "Submitted";
        $stage_only = "";
        if (session()->get('admin_account_type') == 'admin') {
            $show_oly = "Submitted";
            $stage_only = ['stage_1','stage_2','stage_3','stage_3_R','stage_4'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $show_oly = "Lodged";
            $stage_only = ['stage_1','stage_2'];
        } else {
            // $this->session->destroy();
            return redirect()->to(base_url('admin/logout'));
        }

        $data['application_pointers'] = $this->application_pointer_model->asObject()->where('status',$show_oly)->whereIn('stage', $stage_only)->orderby('update_date', 'ASC')->findAll();

        $all_list = array();
        $application_pointer_model = $this->application_pointer_model->asObject()->where('status',$show_oly)->whereIn('stage', $stage_only)->orderby('update_date', 'ASC')->findAll();
        // Check for Particular Logins If are from admin
        $data["filter_active"] = $operation;
        foreach ($application_pointer_model as $stage) {
            
            // 
            // Check if Comment is there
            if($operation){
                if(!getTheCurrentMessageStatusThere($stage->id)){
                    continue;
                }
            }
            
            
            // END
            
            if (session()->get('admin_account_type') == 'admin'){
                if(session()->get('admin_id') != '1'){
                    if($stage->team_member != session()->get('admin_id')){
                        continue;
                    }
                }
            }
            
            // End
            
            
            $list_array = array();

            $pointer_id = $stage->id;
            $list_array['pointer_id'] = $pointer_id;
        
            $list_array['team_member'] = $stage->team_member;
            $list_array['unique_id'] = application_mo($pointer_id);
            $list_array['portal_reference_no'] = portal_reference_no($pointer_id);

            $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $pointer_id);
            $list_array['Applicant_name'] =  "";
            if (!empty($s1_personal_details)) {
                $list_array['Applicant_name'] =   $s1_personal_details->first_or_given_name . " " . $s1_personal_details->middle_names . " " . $s1_personal_details->surname_family_name;
            } else {
                // echo "pointer : " . $pointer_id . "<br>";
                // echo "stage_1_personal_details is empty  <br>";
                // exit;
            }

            $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $pointer_id);
            $occupation_list = find_one_row('occupation_list', 'id', $s1_occupation->occupation_id);
            $list_array['occupation_name'] =  $occupation_list->name;
            $list_array['pointer_stage'] = $stage->stage;

            $stage_1 = find_one_row('stage_1', 'pointer_id', $pointer_id);
            $stage_index = application_stage_no($pointer_id);
                // echo "<pre>";
            if (create_status_format($stage_index) == 'S2 - Start') {
                $stage_status = 'S1 - ' . $stage->status;
            } else if (create_status_format($stage_index) == 'S3 - Start') {
                $stage_status = 'S2 - ' . find_one_row('stage_2', 'pointer_id', $stage->id)->status;
            } else {
                $stage_status = create_status_format($stage_index);
            }
            
            // echo $stage_status;
            // echo $stage_index;
            // echo "<br>";
            $stage_status_format = substr($stage_status, 0, 2);
            if($stage_index >= 40 && $stage_index <= 48){
                $stage_status_format = $stage_status_format." (R)";
            }
            $list_array['application_status'] =  $stage_status_format;


            if (session()->get('admin_account_type') == 'head_office') {

                $stage_ = explode(" ", create_status_format($stage_index));
                if ($stage_[0] == 'S1') {
                    $get_submit_date = $stage_1->lodged_date;
                } else if (create_status_format($stage_index) == 'S2 - Start') {
                    $get_submit_date =  $stage_1->lodged_date;
                } else if ($stage_[0] == 'S2') {
                    $get_submit_date = find_one_row('stage_2', 'pointer_id', $pointer_id)->lodged_date;
                } else if (create_status_format($stage_index) == 'S3 - Start') {
                    $get_submit_date = find_one_row('stage_2', 'pointer_id', $pointer_id)->lodged_date;
                } 
                else if (create_status_format($stage_index) == 'S3 - Submitted (R)') {
                    $get_submit_date = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id)->lodged_date;
                }
                else if ($stage_[0] == 'S3_R') {
                    $get_submit_date = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id)->lodged_date;
                }
                else if ($stage_[0] == 'S3') {
                    $get_submit_date = find_one_row('stage_3', 'pointer_id', $pointer_id)->lodged_date;
                }else if($stage_[0] == 'S4'){
                    $get_submit_date = find_one_row('stage_4', 'pointer_id', $pointer_id)->lodged_date;
                }
                $list_array['submitted_date'] = $get_submit_date;
                $list_array['submitted_date_format'] = date('d/m/Y', strtotime($get_submit_date));
            } else {

                $stage_ = explode(" ", create_status_format($stage_index));
                if ($stage_[0] == 'S1') {
                    $get_submit_date = $stage_1->submitted_date;
                } else if (create_status_format($stage_index) == 'S2 - Start') {
                    $get_submit_date =  $stage_1->submitted_date;
                } else if ($stage_[0] == 'S2') {
                    //$get_submit_date = find_one_row('stage_2', 'pointer_id', $pointer_id)->submitted_date;
                    $get_submit_date = isset(find_one_row('stage_2', 'pointer_id', $pointer_id)->submitted_date) ? find_one_row('stage_2', 'pointer_id', $pointer_id)->submitted_date : null;

                } 
                else if (create_status_format($stage_index) == 'S3 - Submitted (R)') {
                    $get_submit_date = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id)->submitted_date;
                }
                else if ($stage_[0] == 'S3_R') {
                    $get_submit_date = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id)->submitted_date;
                }  
                else if (create_status_format($stage_index) == 'S3 - Start') {
                    $get_submit_date = find_one_row('stage_2', 'pointer_id', $pointer_id)->submitted_date;
                } else if ($stage_[0] == 'S3') {
                    $get_submit_date__ = find_one_row('stage_3', 'pointer_id', $pointer_id);
                   $get_submit_date = isset($get_submit_date__->submitted_date) ? $get_submit_date__->submitted_date : 'Default Value';

                }
                else if($stage_[0] == 'S4'){
                    $get_submit_date = find_one_row('stage_4', 'pointer_id', $pointer_id)->submitted_date;
                }
                $list_array['submitted_date'] = $get_submit_date;
                $list_array['submitted_date_format'] = date('d/m/Y', strtotime($get_submit_date));
            }


            $additional_info_request = find_one_row_2_field_for_flag('additional_info_request', 'pointer_id', $pointer_id,'stage', $stage->stage);
            $list_array['additional_info_request'] =  $additional_info_request;

            $all_list[] = $list_array;
        }


        $data['all_list'] = $all_list;




        return view('admin/dashboard', $data);
    }
    // -------------- dashboard end ----------------

    // -------------- interview_calendar ----------------

    public function  interview_calendar()
    {
        $data['title'] = "interview_calendar";

        return view('admin/interview_calendar/index', $data);
    }
    // -------------- interview_calendar end ----------------

    // -------------- interview_location end ----------------
    // public function interview_location()
    // {
    //     $data['interview_locations'] = $this->stage_3_offline_location_model->asObject()->findAll();
    //     $data['countries'] = $this->country_model->asObject()->findAll();

    //     return view('admin/interview_location/index', $data);
    // }

    // public function update()
    // {
    //     $data = $this->request->getvar();

    //     $id = $data['id'];

    //     $details = array(
    //         'city_name' => $data['city_name'],
    //         'country' => $data['country'],
    //         'venue' => $data['venue'],
    //         'office_address' => $data['office_address'],
    //         'contact_details' => $data['contact_details'],
    //         'reg_date' =>  date("Y-m-d H:i:s")
    //     );
    //     if ($this->stage_3_offline_location_model->update($id, $details)) {
    //         $callback = array(
    //             "color" => "success",
    //             "msg" => "update recode",
    //             "response" => true,
    //         );
    //     } else {
    //         $callback = array(
    //             "msg" => "unable to update record",
    //             "color" => "danger",
    //             "response" => false,
    //         );
    //     }
    //     echo json_encode($callback);
    // }
    // -------------- interview_location end ----------------

    // -------------- interview_booking ----------------
    public function interview_booking()
    {
        $data['interview_bookings'] = $this->stage_3_interview_booking_model->where('is_temp',1)->orderby('date_time','ASC')->asObject()->findAll();
        $query = $this->stage_3_interview_booking_model->getLastQuery();
        // echo $query;
        $data['countries'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['applicants'] = $this->stage_3_model->where('status', 'Lodged')->asObject()->findAll();
        $data['page']="Interview Bookings";
    //   print_r($data['applicants'] );
    //   die;
        $data['time_zone'] = $this->time_zone_model->groupBy('zone_name')->findAll();

        $data['stage_3_interview_booking_time_slots'] = $this->stage_3_interview_booking_time_slots_model->find();
        return view('admin/interview_booking/index', $data);

        // time_zone
    }
    
    
    public function interview_booking_pagination()
    {
        $date_logic = __getFromToDate();

        $data['interview_bookings'] = $this->stage_3_interview_booking_model->where('is_temp',1)->orderby('date_time','ASC')->asObject()->findAll();
        $query = $this->stage_3_interview_booking_model->getLastQuery();
        // echo $query;
        $data['countries'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['applicants'] = $this->stage_3_model->where('status', 'Lodged')->asObject()->findAll();
        $data['page']="Interview Bookings";
    
        $data['time_zone'] = $this->time_zone_model->groupBy('zone_name')->findAll();

        $data['stage_3_interview_booking_time_slots'] = $this->stage_3_interview_booking_time_slots_model->find();
        return view('admin/interview_booking/pagination', $data);

         
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
            $add_date_filter = " OR s3_bookings.date_time like '%".$date_string."%'";
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

    public function fetch_application_records_interview_booking(){
        
        // Pagination details
        $itemsPerPage = (int)$this->request->getVar('itemsPerPage') ?? 10;

        $search_input = $this->request->getVar('search_input') ?? "";
        
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

            $apply_filter .= " and ( 1=1
            ".$add_name_filter."
             OR s1.unique_id like '%".$search_input."%'
             OR occ.name like '%".$search_input."%'
             OR (s3_off_loc.country like '%".$search_input."%'
             OR s3_off_loc.city_name like '%".$search_input."%')
             ".$add_date_filter."
              OR (s3_bookings.location_id = 9 and s3_bookings.time_zone like '%".$search_input."%') )";

            //  echo $apply_filter;
            //  exit;
        }
        
        //DB
        $db = db_connect();
        // Count total rows
        $countQuery = "
        SELECT s1.unique_id, 
        pd.first_or_given_name,
        pd.middle_names,
        pd.surname_family_name,
        occ.name as name,
        s3_off_loc.country,
        s3_bookings.time_zone,
        s3_off_loc.city_name,
        s3_off_loc.venue,
        s3_bookings.date_time,
        s3_off_loc.email,
        s3_off_loc.email_cc,
        s3_bookings.id,
        s3_bookings.pointer_id,
        s3_bookings.location_id,
        s3.status,
        s1_occ.occupation_id
        FROM 
        stage_3_interview_booking s3_bookings 
        INNER JOIN stage_3 s3 ON s3.pointer_id = s3_bookings.pointer_id 
        INNER JOIN stage_1_personal_details pd ON pd.pointer_id = s3.pointer_id
        INNER JOIN stage_1 s1 ON s1.pointer_id = pd.pointer_id
        INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id = s1.pointer_id
        INNER JOIN occupation_list occ ON occ.id = s1_occ.occupation_id
        INNER JOIN stage_1_contact_details s1_contact ON s1_contact.pointer_id = s1.pointer_id
        INNER JOIN stage_3_offline_location s3_off_loc ON s3_off_loc.id = s3_bookings.location_id
        WHERE (s3.status = 'Lodged' OR s3.status = 'Scheduled' OR s3.status = 'Conducted') ".$apply_filter." 
        ORDER BY DATE(s3_bookings.date_time) ASC, TIME(s3_bookings.date_time) ASC
        ";
        // echo $countQuery;
        // exit;
        $countResult = $db->query($countQuery)->getResult();
        $totalRows = count($countResult);
        // echo $totalRows;
        // exit;
        
        // $itemsPerPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;
        
        // Fetch paginated data
        $dataQuery = "SELECT s1.unique_id, 
        pd.first_or_given_name,
        pd.middle_names,
        pd.surname_family_name,
        occ.name as name,
        s3_off_loc.country,
        s3_bookings.time_zone,
        s3_off_loc.city_name,
        s3_off_loc.venue,
        s3_bookings.date_time,
        s3_off_loc.email,
        s3_off_loc.email_cc,
        s3_bookings.id,
        s3_bookings.pointer_id,
        s3_bookings.location_id,
        s3.status,
        s1_occ.occupation_id
        FROM 
        stage_3_interview_booking s3_bookings 
        INNER JOIN stage_3 s3 ON s3.pointer_id = s3_bookings.pointer_id 
        INNER JOIN stage_1_personal_details pd ON pd.pointer_id = s3.pointer_id
        INNER JOIN stage_1 s1 ON s1.pointer_id = pd.pointer_id
        INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id = s1.pointer_id
        INNER JOIN occupation_list occ ON occ.id = s1_occ.occupation_id
        INNER JOIN stage_1_contact_details s1_contact ON s1_contact.pointer_id = s1.pointer_id
        INNER JOIN stage_3_offline_location s3_off_loc ON s3_off_loc.id = s3_bookings.location_id
        WHERE (s3.status = 'Lodged' OR s3.status = 'Scheduled' OR s3.status = 'Conducted') ".$apply_filter." 
        ORDER BY DATE(s3_bookings.date_time) ASC, TIME(s3_bookings.date_time) ASC
        LIMIT ?, ?";

        // echo $dataQuery;
        // exit;
        
        $dataResult = $db->query($dataQuery, [$offset, $itemsPerPage])->getResult();
        
        // print_r($dataResult);
        // exit;
        // Set up pagination
        $pager = service('pager');
        $pager->makeLinks($currentPage, $itemsPerPage, $totalRows);
        // echo $currentPage." - ".$itemsPerPage." - ".$totalRows;
        // exit;

        // Calculate the start and end number of entries for the current page:
        $start = ($currentPage - 1) * $itemsPerPage + 1;
        $end = min($currentPage * $itemsPerPage, $totalRows);

        
        // echo $query;
        $countries = $this->stage_3_offline_location_model->asObject()->findAll();
        // $applicants = $this->stage_3_model->where('status', 'Lodged')->asObject()->findAll();

        $time_zone = $this->time_zone_model->groupBy('zone_name')->findAll();

        $stage_3_interview_booking_time_slots = $this->stage_3_interview_booking_time_slots_model->find();

        // Return to view
        return view('admin/interview_booking/interview_booking_pagination_view', [
            'interview_bookings' => $dataResult,
            'pager' => $pager,
            'currentPage' => $start,
            'itemsPerPage' => $end, 
            'totalRows' => $totalRows, 
            'countries' => $countries,
            // 'applicants' => $applicants,
            // 'applicants' => $applicants,
            'time_zone' => $time_zone,
            'stage_3_interview_booking_time_slots' => $stage_3_interview_booking_time_slots,
        ]);


    }



    
    public function get_preference_location()
    {
        $data = "";
        $id = $_POST['id'];
        $stage_3 =  $this->stage_3_model->where('id', $id)->first();
        if (!empty($stage_3)) {
            $data = isset($stage_3['preference_location']) ? $stage_3['preference_location'] : "";
        }
        return $data;
    }
    
    
    public function get_preference_location_stage4()
    {
        $data = [];
        $id = $_POST['id'];
        $stage_3 =  $this->stage_4_model->where('id', $id)->first();
        if (!empty($stage_3)) {
            $data["preference_location"] = isset($stage_3['preference_location']) ? $stage_3['preference_location'] : "";
            
            // mo
            $current_occ = $this->stage_1_occupation_model->where('pointer_id', $stage_3["pointer_id"])->first();
            $data["occ_id"] = $current_occ["occupation_id"];
            
            // Get the Dropdown Location
            
            $offline_locations = $this->stage_3_offline_location_model->where('pratical',1)->find();
                $country = array();
                foreach ($offline_locations as $key => $value) {
                    if (!in_array($value['country'], $country)) {
                        $country[] = $value['country'];
                    }
                }
                
            
            $location = array();
                foreach ($country as $key => $value) {
                    $offline_location = $this->stage_3_offline_location_model->where(['country' => $value,'pratical'=>1])->find();
                    $location[$value] = $offline_location;
                }
                // echo "<pre>";
                // print_r($location);
                // exit;
    
            // $data['location'] =  $location;
            
            // Final Loop
            
            $occ_id =  getOccupationID($stage_3["pointer_id"],"No");
            $options = '<option value="" selected> Select Location</option>';
            foreach ($location as $key => $value) { 

                    $options .= '<optgroup label="'.$key.'">';
                        foreach ($value as $key_ => $value_) {
                            $selected = "";
                             // Electrician
                               if($occ_id == 7 && $value_["id"] == 20){
                                   continue;
                               }
                               
                            //   Plumber
                            if($occ_id == 18 && $value_["id"] == 16){
                                   continue;
                               }
                            

                            $options .= '<option value="'.$value_['city_name'].'" '.$selected.'>'.$value_['city_name'].' - '.$value_['location'].'</option>';
                            
                        } 

                    }
            $data["options"] = $options;
            // End
            
            
        }
        return json_encode($data);
    }
    
    public function get_applicant_location()
    {
        $data = "";
        $id = $_POST['id'];
        $stage_3 =  $this->stage_3_model->where('id', $id)->first();
        if (!empty($stage_3)) {
            $data = isset($stage_3['time_zone']) ? $stage_3['time_zone'] : "";
        }
        return $data;
    }
    
    
    public function get_applicant_location_stage4()
    {
        $data = "";
        $id = $_POST['id'];
        $stage_3 =  $this->stage_4_model->where('id', $id)->first();
        if (!empty($stage_3)) {
            $data = isset($stage_3['time_zone']) ? $stage_3['time_zone'] : "";
        }
        return $data;
    }

    public function insert_booking()
    {
        $database_check = 0;
        $database_check_1 = 0;
        $mail_check = 0;

        $stage_3_id = $this->request->getPost("applicant_name_id");
        $location_id = $this->request->getPost("venue");
        // $date = $this->request->getPost("date");


        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $date = $datetime->format('Y-m-d H:i:s');


        $time_zone = (isset($_POST['time_zone'])) ? $_POST['time_zone'] : "";
        $stage_3 = find_one_row('stage_3', 'id', $stage_3_id);
        $pointer_id = $stage_3->pointer_id;
        $details = array(
            'pointer_id' => $pointer_id,
            'location_id' => $location_id,
            'date_time' => $date,
            'is_booked' => 1,
            'is_temp' => 1,
            'time_zone' => $time_zone,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' =>  date("Y-m-d H:i:s")
        );
        
        // check if already exist
        
        if($this->stage_3_interview_booking_model->where("pointer_id", $pointer_id)->first()){
        
        $callback = array(
                "msg" => "Already Existing Record",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
         echo json_encode($callback);
         exit;
        }

        if ($this->stage_3_interview_booking_model->insert($details)) {
            $database_check = 1;
        }
           $this->stage3_cancle_interview_booking->where('pointer_id',$pointer_id)->delete();
           
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $user_account = find_one_row('user_account', 'id', $application_pointer->user_id);

        $Applicant_email = [];
        $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_contact_details_)) {
            $Applicant_email[] = $stage_1_contact_details_['email'];
        }

        // print_r($Applicant_email);
        // exit;



        // location_id == 9     Online (Via Zoom)
        if ($location_id == 9) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_agent_online_scheduled
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '89'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                // This is for Exception Online Zoom
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $to = $user_account->email;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                } else {
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                }
            }
            if ($client_type == "Applicant") {

                //s3_online_scheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '82'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }


            //s3_admin_online_scheduled checking for 96
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '96'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($check_1 == 1 && $check == 1) {
                $mail_check = 1;
            }
        } else {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_scheduled_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '36'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                // Applicant Email
                $to = $user_account->email;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                } else {
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                }
            }
            if ($client_type == "Applicant") {
                //s3_scheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '84'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }

            //s3_scheduled_admin
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '98'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($check_1 == 1 && $check == 1) {
                $mail_check = 1;
            }
            
            // Location
            $this->sendToTheOffshoreLocationMail($pointer_id, $location_id);
            // End
        }

        //database record for mail 3 
        $admin_status = [
            'status' => "Scheduled",
            'scheduled_date' => date("Y-m-d H:i:s"),
            'scheduled_by' => session()->get('admin_id'),
            'update_date' => date("Y-m-d H:i:s")
        ];
        // if ($this->stage_3_model->update($stage_3_id, $admin_status)) {
        if ($this->stage_3_model->where('id', $stage_3_id)->set($admin_status)->update()) {
            $database_check_1 = 1;
        }
        $pointer_data = [
            'stage' => 'stage_3',
            'status' => 'Scheduled',
            'update_date' => date("Y-m-d H:i:s")
        ];
        $this->application_pointer_model->where('id', $pointer_id)->set($pointer_data)->update();
    
        // $this->application_pointer_model->update($pointer_id, $pointer_data);
        //database record for mail 3 end
        if ($mail_check == 1 || $database_check == 1 || $database_check_1 == 1) {
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    }
    
    
    public function sendToTheOffshoreLocationMail($pointer_id, $location_id){
        // Mohsin
        $s3_locs = $this->stage_3_offline_location_model->asObject()->find($location_id);
        // 
        if($s3_locs->venue == "AQATO"){
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '221'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $message = mail_tag_replace($mail_temp_3->body, $pointer_id);
            
            $to = $s3_locs->email;
    
            $email_cc = $s3_locs->email_cc;
    
            $mail_cc = array_map('trim', explode(', ', $email_cc));
    
           
            if(empty($email_cc)){
                $mail_cc = [];
            }
           
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
        }   
    }
    
    
    public function update_booking()
    {

        $stage_3_interview_booking_id =  $this->request->getPost('stage_3_interview_booking_id');
        $pointer_id = $this->request->getPost("pointer_id");
        $location_id = $this->request->getPost("venue");
        $time_zone = (isset($_POST['time_zone'])) ? $_POST['time_zone'] : "";

        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $date = $datetime->format('Y-m-d H:i:s');


        // table 1 update --------------------------------------
        $details = array(
            'pointer_id' => $pointer_id,
            'location_id' => $location_id,
            'date_time' => $date,
            'is_booked' => 1,
            'is_temp' => 1,
            'time_zone' => $time_zone,
            'update_date' => date("Y-m-d H:i:s"),
            'zoom_reminder_status'=>null
        );
        // $stage_3_interview_booking_update =  $this->stage_3_interview_booking_model->update($stage_3_interview_booking_id, $details);
        // Getting Old Data Before Update
        $stage_3_interview_booking_update_old =  $this->stage_3_interview_booking_model->where('id', $stage_3_interview_booking_id)->first();
        
        
        // Deleting the Zoom Data
        $this->zoomDataDelete($pointer_id, "stage_3", $stage_3_interview_booking_update_old["date_time"]);
        
        
        $stage_3_interview_booking_update =  $this->stage_3_interview_booking_model->where('id', $stage_3_interview_booking_id)->set($details)->update();
        

        // table 2 update --------------------------------------
        $admin_status = [
            'status' => "Scheduled",
            'scheduled_date' => date("Y-m-d H:i:s"),
            'scheduled_by' => session()->get('admin_id'),
            'update_date' => date("Y-m-d H:i:s")
        ];
        // $stage_3_update = $this->stage_3_model->update($stage_3_id, $admin_status);
        $stage_3_update =  $this->stage_3_model->where('pointer_id', $pointer_id)->set($admin_status)->update();


        // table 3 update --------------------------------------
        $pointer_data = [
            'stage' => 'stage_3',
            'status' => 'Scheduled',
            'update_date' => date("Y-m-d H:i:s")
        ];
        $this->application_pointer_model->where('id', $pointer_id)->set($pointer_data)->update();

        $Email_send_check = 0;

        // Email Send ---------------------------------------------------- 
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $user_account = find_one_row('user_account', 'id', $application_pointer->user_id);

        $Applicant_email = [];
        $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_contact_details_)) {
            $Applicant_email[] = $stage_1_contact_details_['email'];
        }



        // location_id == 9     Online (Via Zoom)
        if ($location_id == 9) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //   s3_agent_online_rescheduled
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '90'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);

                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                } else {
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                }
            }

            if ($client_type == "Applicant") {
                //   s3_online_rescheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '81'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                }
            }

            //   s3_admin_online_rescheduled
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '97'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($Email_send_check == 1 && $Email_send_check_2 == 1) {
                $Email_send_check = 1;
            }
        } else {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //   s3_re_scheduled_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '53'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                } else {
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                }
            }

            if ($client_type == "Applicant") {
                //   s3_rescheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '83'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                }
            }

            //   s3_rescheduled_admin
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '99'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($Email_send_check == 1 && $Email_send_check_2 == 1) {
                $Email_send_check = 1;
            }
            
            
            // Location
            $this->sendToTheOffshoreLocationMail($pointer_id, $location_id);
            // End
        }
        
        

        //database record for mail 3 end
        if ($Email_send_check || $stage_3_interview_booking_update && $stage_3_update) {
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    }
    
    
    public function getAqatoLocationIds(){
        
        $alls = $this->stage_3_offline_location_model->where("venue", "AQATO")->findAll();
        $main_array = [];
        
        foreach($alls as $all){
            $main_array[] = $all["id"];    
        }
        
        return $main_array;
    }
    
    
    
    public function zoomDataDelete($pointer_id, $stage, $date){
        
        $where_data = [
                        'pointer_id' => $pointer_id,
                        'stage' => $stage,
                    ];
        
        // Find If record is filled or not
        // $is_email_zoom = $this->email_interview_location_model->where($where_data)->first();
        // if($is_email_zoom){
            
            
            // Deleting the Stuff Off
            $check_record = $this->email_interview_location_model->where($where_data)->delete();
            // End
            // if($check_record){
                
                
                // Send the Mail
                if($stage == "stage_3_R"){
                    $stage_3_interview_booking = find_one_row('stage_3_reassessment_interview_booking', 'pointer_id', $pointer_id);
                }
                else{
                    $stage_3_interview_booking = find_one_row('stage_3_interview_booking', 'pointer_id', $pointer_id);
                }
                if (isset($stage_3_interview_booking->location_id)) {
                    
                    // echo $stage_3_interview_booking->location_id;
                    // exit;
                   $allowedLocationIds = $this->getAqatoLocationIds();
                  //if (in_array($location_id, $allowedLocationIds)
                  if(in_array($stage_3_interview_booking->location_id, $allowedLocationIds) ){
                      
                    
                    
                    
                    $stage_3_offline_location_id = (isset($stage_3_interview_booking->location_id)) ? $stage_3_interview_booking->location_id : "Null";
                    $date_time = (isset($stage_3_interview_booking->date_time)) ? $stage_3_interview_booking->date_time : "";
            
                    $s3_interview_day_and_date = "";
                    $s3_interview_time_A = "";
                    if (!empty($date_time)) {
                        $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
                        $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
                    }
            
                    $stage_3_offline_location = find_one_row('stage_3_offline_location', 'id', $stage_3_offline_location_id);
                    if ($stage_3_offline_location_id == 9) {
                        $date_time_zone = (isset($stage_3_interview_booking->time_zone)) ? $stage_3_interview_booking->time_zone : "";
                    } else {
                        $date_time_zone = (isset($stage_3_offline_location->date_time_zone)) ? $stage_3_offline_location->date_time_zone : "";
                    }
            
                    $s3_interview_venue = (isset($stage_3_offline_location->venue)) ? $stage_3_offline_location->venue : "";
                    $s3_interview_address = (isset($stage_3_offline_location->office_address)) ? $stage_3_offline_location->office_address : "";
            
                    $s3_interview_time_B = "";
                    $new_date_generated_one = "";
                    if (!empty($date_time_zone)) {
                        if (!empty($date_time)) {
                            $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
                            $date->setTimezone(new DateTimeZone($date_time_zone));
                            $s3_interview_time_B = $date->format('h:i A') . " (" . $date_time_zone . " Time)";
                            
                            // If the dates are different
                            $new_date_added = strtotime($date->format('Y-m-d'));
                            $original_date = strtotime(date('Y-m-d', strtotime($date_time)));
                            // echo $new_date_added." - ".$original_date;
                                if($new_date_added != $original_date){
                                    // Dates are differents
                                    $new_date_generated_one = " / ".date('l, jS F Y', $new_date_added);
                                    $s3_interview_day_and_date .= $new_date_generated_one; 
                                }
                            // end
                            
                            
                        }
                    }
                    
                    //   
                    $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '216'])->first();
                    $mail_text = $mail_temp_3->body;
                    $mail_text = str_replace('%s3_interview_day_and_date_cancel%', $s3_interview_day_and_date, $mail_text);
                    $mail_text = str_replace('%s3_interview_time_cancel%', $s3_interview_time_A . " / " . $s3_interview_time_B, $mail_text);
                    $mail_text = str_replace('%s3_interview_venue_cancel%', $s3_interview_venue, $mail_text);
                    $mail_text = str_replace('%s3_interview_address_cancel%', $s3_interview_address, $mail_text);

                
                    $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                    $day_time = mail_tag_replace($mail_text, $pointer_id);
                    
                    $is_email_zoom = $this->email_interview_location_model->where($where_data)->first();
                    $email_cc = [];
                    if($is_email_zoom){
                        $to = $is_email_zoom["email"];
                    }
                    else{
                        // 
                        $stage_3_offline_location_model_db = $this->stage_3_offline_location_model->find($stage_3_interview_booking->location_id);
                        $to = $stage_3_offline_location_model_db["email"];
                        if($stage_3_offline_location_model_db["email_cc"] != ""){
                            $email_cc[] = $stage_3_offline_location_model_db["email_cc"];
                        }
                        
                        
                    }
                    // print_r($email_cc);
                    
                    // exit;
                    
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $day_time, [], [], $email_cc, []);

                // END Mail
                
                  }
            }
        
        // } // $check_record
        
        //END
    
            
            
        
        // } // $is_email_zoom
    }
    
     public function send_mail_zoom_meet()
    {
        $stage_3_interview_booking_id =  $this->request->getPost('stage_3_interview_booking_id');
        $pointer_id = $this->request->getPost("pointer_id");
        // $email_cc = $this->request->getPost('email_cc');
        $meeting_id = $this->request->getPost('meeting_id');
        $passcode = $this->request->getPost('passcode');
        $email_interview_location_id = $this->request->getPost('email_interview_location_id');
        
            // echo $email_cc;
            // exit;
        $stage_3_interview = $this->stage_3_interview_booking_model->where('id', $stage_3_interview_booking_id)->asobject()->first();
        $location_id = $stage_3_interview->location_id;
        if($location_id){
            $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        }
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '161'])->first();
        $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
        $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
        $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($stage_3_interview->date_time)), $day_time);
        $date_time = str_replace('%s3_interview_time%', date('H:i', strtotime($stage_3_interview->date_time)), $get_slot_time);
        $meeting_id_change = str_replace('%meeting_id%', $meeting_id, $date_time);
        $message = str_replace('%passcode%', $passcode, $meeting_id_change);
        $to = $location->email;

        $email_cc = $location->email_cc;

        $mail_cc = array_map('trim', explode(', ', $email_cc));

        // $string_email_cc = explode(', ', $email_cc);
        
        //  $string_email_cc = implode(', ', $email_cc);
        // $array_cc = explode(", ", $string_email_cc);  // Convert string to array
        // $uniqueArray_cc = array_unique($array_cc);  // Remove duplicates from the array
        // $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
        
        
        // array()
        // $string_email_cc = array();
        // echo $string_email_cc;
        // $array_cc = explode(", ", $string_email_cc);  // Convert string to array
        // $uniqueArray_cc = array_unique($string_email_cc);  // Remove duplicates from the array
        // $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
        
        if(empty($email_cc)){
            $mail_cc = [];
        }
       
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
        // ZOOM DETAILS - TECHNICAL INTERVIEW
                // 'pointer_id','stage','meeting_id', 'passcode', 'email','email_cc','email_type','submitted_date', 'update_date', 'create_date',
        
        if($email_interview_location_id){
            $data_verf = array(
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3',
                'meeting_id' => $meeting_id,
                'passcode' => $passcode,
                'email'=>$to,
                'email_cc' => $email_cc,
                'email_type' => 'Zoom Details',
                'submitted_date' => date("Y-m-d H:i:s"),
                'update_date' => date("Y-m-d H:i:s"),
            );
            $database = $this->email_interview_location_model->update($email_interview_location_id,$data_verf);  
    
        }else{
          $data_verf = array(
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3',
                'meeting_id' => $meeting_id,
                'passcode' => $passcode,
                'email'=>$to,
                'email_cc' => $email_cc,
                'email_type' => 'Zoom Details',
                'submitted_date' => date("Y-m-d H:i:s"),
                'update_date' => date("Y-m-d H:i:s"),
                'create_date' => date("Y-m-d H:i:s")
            );
            $database = $this->email_interview_location_model->insert($data_verf);  
        }    
        if($check == 1 && $database == 1){
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
 
    }
   
    public function interview_booking_reassessment()
    {
        $data['interview_bookings'] = $this->stage_3_reassessment_interview_booking_model->where('is_temp',1)->orderby('date_time','ASC')->asObject()->findAll();
        $query = $this->stage_3_reassessment_interview_booking_model->getLastQuery();
        // echo $query;
        $data['countries'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['applicants'] = $this->stage_3_reassessment_model->where('status', 'Lodged')->asObject()->findAll();


        $data['time_zone'] = $this->time_zone_model->groupBy('zone_name')->findAll();

        $data['stage_3_interview_booking_time_slots'] = $this->stage_3_interview_booking_time_slots_model->find();
        return view('admin/interview_booking/index_reassessment', $data);

        // time_zone
    }

    
    public function get_preference_location_reassessment()
    {
        $data = "";
        $id = $_POST['id'];
        $stage_3_reass =  $this->stage_3_reassessment_model->where('id', $id)->first();
        if (!empty($stage_3_reass)) {
            $data = isset($stage_3_reass['preference_location']) ? $stage_3_reass['preference_location'] : "";
        }
        return $data;
    }
    
    public function get_applicant_location_reassessment()
    {
        $data = "";
        $id = $_POST['id'];
        $stage_3_reass =  $this->stage_3_reassessment_model->where('id', $id)->first();
        if (!empty($stage_3_reass)) {
            $data = isset($stage_3_reass['time_zone']) ? $stage_3_reass['time_zone'] : "";
        }
        return $data;
    }

    public function insert_booking_reassessment()
    {
        $database_check = 0;
        $database_check_1 = 0;
        $mail_check = 0;

        $stage_3_reass_id = $this->request->getPost("applicant_name_id");
        $location_id = $this->request->getPost("venue");
        // $date = $this->request->getPost("date");


        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $date = $datetime->format('Y-m-d H:i:s');


        $time_zone = (isset($_POST['time_zone'])) ? $_POST['time_zone'] : "";
        $stage_3_reass = find_one_row('stage_3_reassessment', 'id', $stage_3_reass_id);
        $pointer_id = $stage_3_reass->pointer_id;
        $details = array(
            'pointer_id' => $pointer_id,
            'location_id' => $location_id,
            'date_time' => $date,
            'is_booked' => 1,
            'is_temp' => 1,
            'time_zone' => $time_zone,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' =>  date("Y-m-d H:i:s")
        );

        if ($this->stage_3_reassessment_interview_booking_model->insert($details)) {
            $database_check = 1;
        }
        $this->stage3_reass_cancle_interview_booking->where('pointer_id',$pointer_id)->delete();
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $user_account = find_one_row('user_account', 'id', $application_pointer->user_id);

        $Applicant_email = [];
        $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_contact_details_)) {
            $Applicant_email[] = $stage_1_contact_details_['email'];
        }

        // print_r($Applicant_email);
        // exit;



        // location_id == 9     Online (Via Zoom)
        if ($location_id == 9) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_agent_online_scheduled
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '166'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                // This is for Exception Online Zoom
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $to = $user_account->email;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                } else {
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                }
            }
            if ($client_type == "Applicant") {

                //s3_online_scheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '179'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }


            //s3_admin_online_scheduled checking for 96
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '186'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($check_1 == 1 && $check == 1) {
                $mail_check = 1;
            }
        } else {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_scheduled_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '163'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                // Applicant Email
                $to = $user_account->email;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                } else {
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                }
            }
            if ($client_type == "Applicant") {
                //s3_scheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '197'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }

            //s3_scheduled_admin
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '184'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($check_1 == 1 && $check == 1) {
                $mail_check = 1;
            }
            
            // Location
            $this->sendToTheOffshoreLocationMail($pointer_id, $location_id);
            // End
        }

        //database record for mail 3 
        $admin_status = [
            'status' => "Scheduled",
            'scheduled_date' => date("Y-m-d H:i:s"),
            'scheduled_by' => session()->get('admin_id'),
            'update_date' => date("Y-m-d H:i:s")
        ];
        // if ($this->stage_3_reassessment_model->update($stage_3_reass_id, $admin_status)) {
        if ($this->stage_3_reassessment_model->where('id', $stage_3_reass_id)->set($admin_status)->update()) {
            $database_check_1 = 1;
        }
        $pointer_data = [
            'stage' => 'stage_3_R',
            'status' => 'Scheduled',
            'update_date' => date("Y-m-d H:i:s")
        ];
        $this->application_pointer_model->where('id', $pointer_id)->set($pointer_data)->update();
      
        // $this->application_pointer_model->update($pointer_id, $pointer_data);
        //database record for mail 3 end
        if ($mail_check == 1 || $database_check == 1 || $database_check_1 == 1) {
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    }

    public function update_booking_reassessment()
    {

        $stage_3_reass_interview_booking_id =  $this->request->getPost('stage_3_interview_booking_id');
        $pointer_id = $this->request->getPost("pointer_id");
        $location_id = $this->request->getPost("venue");
        $time_zone = (isset($_POST['time_zone'])) ? $_POST['time_zone'] : "";

        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $date = $datetime->format('Y-m-d H:i:s');


        // table 1 update --------------------------------------
        $details = array(
            'pointer_id' => $pointer_id,
            'location_id' => $location_id,
            'date_time' => $date,
            'is_booked' => 1,
            'is_temp' => 1,
            'time_zone' => $time_zone,
            'update_date' => date("Y-m-d H:i:s"),
            'zoom_reminder_status'=>null

        );
        
        $stage_3_interview_booking_update_old =  $this->stage_3_reassessment_interview_booking_model->where('id', $stage_3_reass_interview_booking_id)->first();
        
        // Deleting the Zoom Data
        $this->zoomDataDelete($pointer_id, "stage_3_R", $stage_3_interview_booking_update_old["date_time"]);
        
        
        // $stage_3_reass_interview_booking_update =  $this->stage_3_reassessment_interview_booking_model->update($stage_3_reass_interview_booking_id, $details);
        $stage_3_reass_interview_booking_update =  $this->stage_3_reassessment_interview_booking_model->where('id', $stage_3_reass_interview_booking_id)->set($details)->update();

        // table 2 update --------------------------------------
        $admin_status = [
            'status' => "Scheduled",
            'scheduled_date' => date("Y-m-d H:i:s"),
            'scheduled_by' => session()->get('admin_id'),
            'update_date' => date("Y-m-d H:i:s")
        ];
        // $stage_3_reass_update = $this->stage_3_reassessment_model->update($stage_3_reass_id, $admin_status);
        
        
        
        $stage_3_reass_update =  $this->stage_3_reassessment_model->where('pointer_id', $pointer_id)->set($admin_status)->update();


        // table 3 update --------------------------------------
        $pointer_data = [
            'stage' => 'stage_3_R',
            'status' => 'Scheduled',
            'update_date' => date("Y-m-d H:i:s")
        ];
        $this->application_pointer_model->where('id', $pointer_id)->set($pointer_data)->update();

        $Email_send_check = 0;

        // Email Send ---------------------------------------------------- 
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $user_account = find_one_row('user_account', 'id', $application_pointer->user_id);

        $Applicant_email = [];
        $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_contact_details_)) {
            $Applicant_email[] = $stage_1_contact_details_['email'];
        }



        // location_id == 9     Online (Via Zoom)
        if ($location_id == 9) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //   s3_agent_online_rescheduled
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '167'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);

                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                } else {
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                }
            }

            if ($client_type == "Applicant") {
                //   s3_online_rescheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '178'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                }
            }

            //   s3_admin_online_rescheduled
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '187'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($Email_send_check == 1 && $Email_send_check_2 == 1) {
                $Email_send_check = 1;
            }
        } else {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //   s3_re_scheduled_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '164'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                } else {
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                }
            }

            if ($client_type == "Applicant") {
                //   s3_rescheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '180'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                }
            }

            //   s3_rescheduled_admin
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '185'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            $message = str_replace('%s3_interview_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
            if ($Email_send_check == 1 && $Email_send_check_2 == 1) {
                $Email_send_check = 1;
            }
            
            // Location
            $this->sendToTheOffshoreLocationMail($pointer_id, $location_id);
            // End
        }

        

        //database record for mail 3 end
        if ($Email_send_check || $stage_3_reass_interview_booking_update && $stage_3_reass_update) {
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    }
    
     public function send_mail_zoom_meet_reassessment()
    {
        $stage_3_reass_interview_booking_id =  $this->request->getPost('stage_3_interview_booking_id');
        $pointer_id = $this->request->getPost("pointer_id");
        // $email_cc = $this->request->getPost('email_cc');
        $meeting_id = $this->request->getPost('meeting_id');
        $passcode = $this->request->getPost('passcode');
        $email_interview_location_id = $this->request->getPost('email_interview_location_id');
        
            // echo $email_cc;
            // exit;
        $stage_3_reass_interview = $this->stage_3_reassessment_interview_booking_model->where('id', $stage_3_reass_interview_booking_id)->asobject()->first();
        $location_id = $stage_3_reass_interview->location_id;
        if($location_id){
            $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        }
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '161'])->first();
        $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
        $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
        $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($stage_3_reass_interview->date_time)), $day_time);
        $date_time = str_replace('%s3_interview_time%', date('H:i', strtotime($stage_3_reass_interview->date_time)), $get_slot_time);
        $meeting_id_change = str_replace('%meeting_id%', $meeting_id, $date_time);
        $message = str_replace('%passcode%', $passcode, $meeting_id_change);
        // print_r($message);
        // exit;
        $to = $location->email;

        $email_cc = $location->email_cc;

        $mail_cc = array_map('trim', explode(', ', $email_cc));

        // $string_email_cc = explode(', ', $email_cc);
        
        //  $string_email_cc = implode(', ', $email_cc);
        // $array_cc = explode(", ", $string_email_cc);  // Convert string to array
        // $uniqueArray_cc = array_unique($array_cc);  // Remove duplicates from the array
        // $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
        
        
        // array()
        // $string_email_cc = array();
        // echo $string_email_cc;
        // $array_cc = explode(", ", $string_email_cc);  // Convert string to array
        // $uniqueArray_cc = array_unique($string_email_cc);  // Remove duplicates from the array
        // $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
        
        if(empty($email_cc)){
            $mail_cc = [];
        }
       
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
        // ZOOM DETAILS - TECHNICAL INTERVIEW
                // 'pointer_id','stage','meeting_id', 'passcode', 'email','email_cc','email_type','submitted_date', 'update_date', 'create_date',
        
        if($email_interview_location_id){
            $data_verf = array(
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3_R',
                'meeting_id' => $meeting_id,
                'passcode' => $passcode,
                'email'=>$to,
                'email_cc' => $email_cc,
                'email_type' => 'Zoom Details',
                'submitted_date' => date("Y-m-d H:i:s"),
                'update_date' => date("Y-m-d H:i:s"),
            );
            $database = $this->email_interview_location_model->update($email_interview_location_id,$data_verf);  
    
        }else{
          $data_verf = array(
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3_R',
                'meeting_id' => $meeting_id,
                'passcode' => $passcode,
                'email'=>$to,
                'email_cc' => $email_cc,
                'email_type' => 'Zoom Details',
                'submitted_date' => date("Y-m-d H:i:s"),
                'update_date' => date("Y-m-d H:i:s"),
                'create_date' => date("Y-m-d H:i:s")
            );
            $database = $this->email_interview_location_model->insert($data_verf);  
        }    
        if($check == 1 && $database == 1){
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
 
    }
   
   // -------------- interview_booking end ----------------

    // akanksha 19 june 2023
    public function File_update_stage_2()
    {
        if (isset($_POST['file_upload_name'])) {
            $file_upload_name  = $_POST['file_upload_name'];
            $pointer_id  = $_POST['pointer_id'];
            if (!empty($file_upload_name) && !empty($pointer_id)) {
                if (isset($_FILES['file'])) {
                    $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();
                    $name = $s1_personal_details->first_or_given_name;
                    $target_file =  'public/application/' . $pointer_id . '/stage_2/approved';
                    $file  = $_FILES['file'];
                    $file  = $this->request->getFile('file');
                    $Files = $file->getName();
                    if (!empty($Files)) {
                        $file_extension = explode(".", $Files);
                        $file_extension = $file_extension[count($file_extension) - 1];
                        $target_file =  'public/application/' . $pointer_id . '/stage_2/declined';
                        $file_name = $Files;  // temp
                        $user_view_name = ""; // temp
                        $required_document_id = ""; // temp
                        if ($file_upload_name == "outcome_file") { 
                            $file_name = 'Skills Assessment Result - '.$name.'.'. $file_extension;
                            // $file_name = 'Unsuccessful_outcome_letter.' . $file_extension;
                            $required_document_id = 52;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "reason_file") {  
                            $file_name = 'Statement Of Reason - '.$name.'.'. $file_extension;
                            // $file_name = 'Statement_of_reason.' . $file_extension;
                            $required_document_id = 53;
                            $user_view_name = 'Statement Of Reason';
                        }
                        // echo $file_upload_name;
                        // echo $file_name;
                        // echo $required_document_id;
                        // echo $user_view_name;
                        // exit;
                        if ($file->move($target_file, $file_name, true)) {
                            if (!empty($user_view_name) && !empty($required_document_id)) {
                                $data = array(
                                    'pointer_id' => $pointer_id,
                                    'stage' => 'stage_2',
                                    'required_document_id' => $required_document_id,
                                    'name' => $user_view_name,
                                    'document_name' => $file_name,
                                    'document_path' => $target_file,
                                    'status' => 1,
                                    'update_date' => date("Y-m-d H:i:s"),
                                    // 'create_date' => date("Y-m-d H:i:s")
                                );
                                $check_documents_model = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => $required_document_id])->first();
                                if (empty($check_documents_model)) {
                                    // insert 
                                    if ($this->documents_model->insert($data)) {
                                        echo "ok";
                                    }
                                } else {
                                    // update
                                    if ($this->documents_model->set($data)->where(['pointer_id' => $pointer_id, 'required_document_id' => $required_document_id])->update()) {
                                        echo "ok";
                                    }
                                }
                            } else {
                                echo "data missing doc id and pointer";
                            }
                        } else {
                            echo "sorry file not move";
                        }
                    } // file not empty
                } // isset file 
            }
        }
    }
    
    // vishal patel 26/04/2023 update akanksha 19 june 2023
    // stage 3 file upload withaut mail   
    // stage 3 file upload withaut mail   
    public function File_update_stage_3()
    {
        // vishal patel 26/04/2023
       
        if (isset($_POST['file_upload_name'])) {
          $file_upload_name  = $_POST['file_upload_name'];
          
            $pointer_id  = $_POST['pointer_id'];
            if (!empty($file_upload_name) && !empty($pointer_id)) {
                if (isset($_FILES['file'])) {
                    $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();
                    $name = $s1_personal_details->first_or_given_name;
                    $target_file =  'public/application/' . $pointer_id . '/stage_3/approved';
                    $file  = $_FILES['file'];
                    $file  = $this->request->getFile('file');
                    $Files = $file->getName();
                    // akanksha 19 june 2023
                    if (!empty($Files)) {
                        $file_extension = explode(".", $Files);
                        $file_extension = $file_extension[count($file_extension) - 1];
                        $file_name = $Files;  // temp
                        $user_view_name = ""; // temp
                        $required_document_id = ""; // temp
                        if ($file_upload_name == "upload_qualification_file") {
                            $file_name = 'Qualification Documents -' . $name . "." . $file_extension;
                            $required_document_id = 26;
                            $user_view_name = 'Qualification Documents';
                        } else if ($file_upload_name == "upload_outcome_file" || $file_upload_name == "upload_outcome_file") {
                            $file_name = 'Skills Assessment Result - ' . $name . "." . $file_extension;
                            $required_document_id = 25;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "outcome_file") { // <!-- // vishal patel 27-04-2023  -->
                            $target_file =  'public/application/' . $pointer_id . '/stage_3/declined';
                            $file_name = 'Skills Assessment Result - '. $name . "." . $file_extension;
                            $required_document_id = 23;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "reason_file") {   // <!-- // vishal patel 27-04-2023  -->
                            $target_file =  'public/application/' . $pointer_id . '/stage_3/declined';
                            $file_name = 'Statement Of Reason - ' . $name . "." . $file_extension;
                            $required_document_id = 24;
                            $user_view_name = 'Statement Of Reason';
                        }
                        if ($file->move($target_file, $file_name, true)) {
                            if (!empty($user_view_name) && !empty($required_document_id)) {
                                $qualification_data = array(
                                    'pointer_id' => $pointer_id,
                                    'stage' => 'stage_3',
                                    'required_document_id' => $required_document_id,
                                    'name' => $user_view_name,
                                    'document_name' => $file_name,
                                    'document_path' => $target_file,
                                    'status' => 1,
                                    'update_date' => date("Y-m-d H:i:s"),
                                    'create_date' => date("Y-m-d H:i:s")
                                );
                                $check_documents_model = $this->documents_model->where(['pointer_id' => $pointer_id, 'stage'=>'stage_3', 'required_document_id' => $required_document_id])->first();
                                if (empty($check_documents_model)) {
                                    // insert 
                                    if ($this->documents_model->insert($qualification_data)) {
                                        echo "ok";
                                    }
                                } else {
                                    // update
                                    if ($this->documents_model->set($qualification_data)->where(['pointer_id' => $pointer_id, 'stage'=>'stage_3', 'required_document_id' => $required_document_id])->update()) {
                                        echo "ok";
                                    }
                                }
                            } else {
                                echo "data missing doc id and pointer";
                            }
                        } else {
                            echo "sorry file not move";
                        }
                    } // file not empty
                } // isset file 
            }
        }
    }
    
    // akanksha 18 july 2023
    public function File_update_stage_3_R()
    {
        // vishal patel 26/04/2023
        if (isset($_POST['file_upload_name'])) {
            $file_upload_name  = $_POST['file_upload_name'];
            $pointer_id  = $_POST['pointer_id'];
            if (!empty($file_upload_name) && !empty($pointer_id)) {
                if (isset($_FILES['file'])) {
                    $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();
                    $name = $s1_personal_details->first_or_given_name;
                    $target_file =  'public/application/' . $pointer_id . '/stage_3_R/approved';
                    $file  = $_FILES['file'];
                    $file  = $this->request->getFile('file');
                    $Files = $file->getName();
                    // akanksha 19 june 2023
                    if (!empty($Files)) {
                        $file_extension = explode(".", $Files);
                        $file_extension = $file_extension[count($file_extension) - 1];
                        $file_name = $Files;  // temp
                        $user_view_name = ""; // temp
                        $required_document_id = ""; // temp
                        if ($file_upload_name == "upload_qualification_file") {
                            $file_name = 'Qualification Documents -' . $name . "." . $file_extension;
                            $required_document_id = 26;
                            $user_view_name = 'Qualification Documents';
                        } else if ($file_upload_name == "upload_outcome_file" || $file_upload_name == "upload_outcome_file") {
                            $file_name = 'Skills Assessment Result - ' . $name . "." . $file_extension;
                            $required_document_id = 25;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "outcome_file") { // <!-- // vishal patel 27-04-2023  -->
                            $target_file =  'public/application/' . $pointer_id . '/stage_3_R/declined';
                            $file_name = 'Skills Assessment Result - '. $name . "." . $file_extension;
                            $required_document_id = 23;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "reason_file") {   // <!-- // vishal patel 27-04-2023  -->
                            $target_file =  'public/application/' . $pointer_id . '/stage_3_R/declined';
                            $file_name = 'Statement Of Reason - ' . $name . "." . $file_extension;
                            $required_document_id = 24;
                            $user_view_name = 'Statement Of Reason';
                        }
                        if ($file->move($target_file, $file_name, true)) {
                            if (!empty($user_view_name) && !empty($required_document_id)) {
                                $qualification_data = array(
                                    'pointer_id' => $pointer_id,
                                    'stage' => 'stage_3_R',
                                    'required_document_id' => $required_document_id,
                                    'name' => $user_view_name,
                                    'document_name' => $file_name,
                                    'document_path' => $target_file,
                                    'status' => 1,
                                    'update_date' => date("Y-m-d H:i:s"),
                                    'create_date' => date("Y-m-d H:i:s")
                                );
                                $check_documents_model = $this->documents_model->where(['pointer_id' => $pointer_id,'stage'=>'stage_3_R', 'required_document_id' => $required_document_id])->first();
                                if (empty($check_documents_model)) {
                                    // insert 
                                    if ($this->documents_model->insert($qualification_data)) {
                                        echo "ok";
                                    }
                                } else {
                                    // update
                                    if ($this->documents_model->set($qualification_data)->where(['pointer_id' => $pointer_id, 'stage'=>'stage_3_R', 'required_document_id' => $required_document_id])->update()) {
                                        echo "ok";
                                    }
                                }
                            } else {
                                echo "data missing doc id and pointer";
                            }
                        } else {
                            echo "sorry file not move";
                        }
                    } // file not empty
                } // isset file 
            }
        }
    }
    
    // Mohsin -> 2 Jun 2023 update akanksha 19 june 2023
    // stage 4 file upload withaut mail   
    public function File_update_stage_4()
    {
        if (isset($_POST['file_upload_name'])) {
            $file_upload_name  = $_POST['file_upload_name'];
            $pointer_id  = $_POST['pointer_id'];
            if (!empty($file_upload_name) && !empty($pointer_id)) {
                if (isset($_FILES['file'])) {
                    $s1_personal_details = $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();
                    $name = $s1_personal_details->first_or_given_name;
                    $target_file =  'public/application/' . $pointer_id . '/stage_4/approved';
                    $file  = $_FILES['file'];
                    $file  = $this->request->getFile('file');
                    $Files = $file->getName();
                    // akanksha 19 june 2023
                    if (!empty($Files)) {
                        $file_extension = explode(".", $Files);
                        $file_extension = $file_extension[count($file_extension) - 1];
                        $file_name = $Files;  // temp
                        $user_view_name = ""; // temp
                        $required_document_id = ""; // temp
                        if ($file_upload_name == "upload_qualification_file") {
                            $file_name = 'OTSR'.$name.'.' . $file_extension;
                            $required_document_id = 48;
                            $user_view_name = 'OTSR';
                        } else if ($file_upload_name == "upload_outcome_file" || $file_upload_name == "upload_outcome_file") {
                            $file_name = 'Pratical Assessment Result - ' . $name . "." . $file_extension;
                            $required_document_id = 47;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "outcome_file") { 
                            $target_file =  'public/application/' . $pointer_id . '/stage_4/declined';
                            $file_name = 'Skills Assessment Result - '.$name.'.'. $file_extension;
                            $required_document_id = 45;
                            $user_view_name = 'Skills Assessment Result';
                        } else if ($file_upload_name == "reason_file") {  
                            $target_file =  'public/application/' . $pointer_id . '/stage_4/declined';
                            $file_name = 'Statement Of Reason - ' . $name . "." . $file_extension;
                            $required_document_id = 46;
                            $user_view_name = 'Statement Of Reason';
                        }

                        if ($file->move($target_file, $file_name, true)) {
                            if (!empty($user_view_name) && !empty($required_document_id)) {
                                $qualification_data = array(
                                    'pointer_id' => $pointer_id,
                                    'stage' => 'stage_4',
                                    'required_document_id' => $required_document_id,
                                    'name' => $user_view_name,
                                    'document_name' => $file_name,
                                    'document_path' => $target_file,
                                    'status' => 1,
                                    'update_date' => date("Y-m-d H:i:s"),
                                    'create_date' => date("Y-m-d H:i:s")
                                );
                                $check_documents_model = $this->documents_model->where(['pointer_id' => $pointer_id, 'required_document_id' => $required_document_id])->first();
                                if (empty($check_documents_model)) {
                                    // insert 
                                    if ($this->documents_model->insert($qualification_data)) {
                                        echo "ok";
                                    }
                                } else {
                                    // update
                                    if ($this->documents_model->set($qualification_data)->where(['pointer_id' => $pointer_id, 'required_document_id' => $required_document_id])->update()) {
                                        echo "ok";
                                    }
                                }
                            } else {
                                echo "data missing doc id and pointer";
                            }
                        } else {
                            echo "sorry file not move";
                        }
                    } // file not empty
                } // isset file 
            }
        }
    }
     //code by rohit 
  public function interview_booking_cancle(){
   
      
         $id=$this->request->getPost('id');
        $stage_interview_booking=find_one_row('stage_3_interview_booking','id',$id);
        $pointer_id=$stage_interview_booking->pointer_id;
        $application_pointer=find_one_row('application_pointer','id',$pointer_id)->user_id;
        $email_ver=find_one_row('email_interview_location','pointer_id',$pointer_id);
      if (isset($email_ver->stage) && $email_ver->stage == 'stage_3') {
            $meeting_id=$email_ver->meeting_id;
            $passcode=$email_ver->passcode;
      }else{
          $meeting_id="N/A";
            $passcode="N/A";
      }
        $agent=find_one_row('user_account','id',$application_pointer);
        $acount_type=$agent->account_type;
        $location_id=$stage_interview_booking->location_id;
        $date_time=$stage_interview_booking->date_time;
        $time_zone=$stage_interview_booking->time_zone;
        
        $stage_1_contactdetails=find_one_row('stage_1_contact_details','pointer_id',$pointer_id);
        $stage_3_offline_location=find_one_row('stage_3_offline_location','id',$location_id);
        $email_location=$stage_3_offline_location->email;
        $email_location_cc=$stage_3_offline_location->email_cc;
        $applicant_email=$stage_1_contactdetails->email;
        $agent_email=$agent->email;
        $option=$this->request->getPost('options');
        $comment=$this->request->getPost('comment');
        if($option == 'other'){
          $option= $comment;
        }
         $details = array(
            'pointer_id' => $pointer_id,
            'location_id' => $location_id,
            'date_time' => $date_time,
            'is_booked' => 0,
            'interview_comment'=> $option,
            'interview_cancle_date'=>date("Y-m-d H:i:s"),
            'is_temp' => 1,
            'time_zone' => $time_zone,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' =>  date("Y-m-d H:i:s")
        );
        $insert_stage3_cancle_req= $this->stage3_cancle_interview_booking->set($details)->insert();
         $update_data = [ 'status'=>'Lodged'];
         $update_interview_comment= $this->stage_3_model->where('pointer_id', $pointer_id)->set($update_data)->update();
        if($update_interview_comment){
        $application_p=['status'=>'Lodged' ];
        $application_update=$this->application_pointer_model->where('id', $pointer_id)->set($application_p)->update();
        
           
      
   
   ///MAIL SEND START
       if($acount_type == 'applicant'){
         $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '208'])->first();
         $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
         $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking% ', $option, $mail_body_reason);
         $to=$applicant_email;
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body, [],[],[],[]);
        }
        if($acount_type == 'Agent'){
         $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '207'])->first();
         $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
          $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking% ', $option, $mail_body_reason);
         $to=$agent_email;
         $email_cc = $applicant_email;
         if(empty($email_cc)){
            $mail_cc = [];
         }
        $mail_cc = array_map('trim', explode(', ', $email_cc));
          $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body, [], [],$mail_cc,[]);
        }
        
        
        

        if($location_id){
            $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        }
        
        $s3_interview_day_and_date = "";
        $s3_interview_time_A = "";
        $date_time = $stage_interview_booking->date_time;
        if (!empty($date_time)) {
            $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
            $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
        }
        $date_time_zone = (isset($location->date_time_zone)) ? $location->date_time_zone : "";
        
        $s3_interview_time_B = "";
        if (!empty($date_time_zone)) {
            if (!empty($date_time)) {
                $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
                $date->setTimezone(new DateTimeZone($date_time_zone));
                $s3_interview_time_B = $date->format('h:i A') . " (" . $date_time_zone . " Time)";
            }
        }
               $allowedLocationIds = $this->getAqatoLocationIds();
          //if (in_array($location_id, $allowedLocationIds)
          if(in_array($location_id, $allowedLocationIds) ){
        // if($location_id){
            
         $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '205'])->first();
         $mail_subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_3->body, $pointer_id);
         $get_slot_time = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $mail_body_reason);
         $date_time = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $get_slot_time);
         $meeting_id_change = str_replace('%s3_interview_venue%', $meeting_id, $date_time);
         $message = str_replace('%s3_interview_address%', $passcode, $meeting_id_change);
          
        $to = $location->email;
        $email_cc = $location->email_cc;
        $mail_cc = array_map('trim', explode(', ', $email_cc));
        if(empty($email_cc)){
            $mail_cc = [];
        }
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $message, [], [], $mail_cc, []);
        
            
        // } //Location_id Close
          }
    //FOR ADMIN AND HEAD_OFFICE
           $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '206'])->first();
           $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
           $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
           $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking% ', $option, $mail_body_reason);
           $to = env('ADMIN_EMAIL');
           $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
           $to = env('HEADOFFICE_EMAIL');
           $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
           //for delete req
          $stage_3_interview_del = $this->stage_3_interview_booking_model->where('pointer_id', $pointer_id)->asobject()->delete();
        $email_interview_location = $this->email_interview_location_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_3'])->asObject()->delete();
        if($Email_send_check_2 && $Email_send_check && $check &&$email_interview_location){
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
   }
  }  
  
//Code By Rohit
public function stage3_reass_interview_booking_cancle(){
    
        $id=$this->request->getPost('id');
        $stage_reass_interview_booking=find_one_row('stage_3_reassessment_interview_booking','id',$id);
        $pointer_id=$stage_reass_interview_booking->pointer_id;
        $application_pointer=find_one_row('application_pointer','id',$pointer_id)->user_id;
        $agent=find_one_row('user_account','id',$application_pointer);
        $acount_type=$agent->account_type;
        $email_ver = $this->email_interview_location_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_3_R'])->get();
//if(!empty($email_ver)){   
      if (isset($email_ver->stage) && $email_ver->stage == 'stage_3_R') {
            $meeting_id=$email_ver->meeting_id;
            $passcode=$email_ver->passcode;
      }else{
           $meeting_id="N/A";
        $passcode="N/A";
      }
        
        $location_id=$stage_reass_interview_booking->location_id;
        $date_time=$stage_reass_interview_booking->date_time;
        $time_zone=$stage_reass_interview_booking->time_zone;
        $stage_1_contactdetails=find_one_row('stage_1_contact_details','pointer_id',$pointer_id);
        $stage_3_offline_location=find_one_row('stage_3_offline_location','id',$location_id);
        $email_location=$stage_3_offline_location->email;
        $email_location_cc=$stage_3_offline_location->email_cc;
        $applicant_email=$stage_1_contactdetails->email;
        $agent_email=$agent->email;
        $option=$this->request->getPost('options');
        $comment=$this->request->getPost('comment');
        if($option == 'other'){
          $option= $comment;
        }
  
        $details = array(
            'pointer_id' => $pointer_id,
            'location_id' => $location_id,
            'date_time' => $date_time,
            'is_booked' => 0,
            'interview_comment'=> $option,
            'interview_cancle_date'=>date("Y-m-d H:i:s"),
            'is_temp' => 1,
            'time_zone' => $time_zone,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' =>  date("Y-m-d H:i:s")
        );
        $insert_stage3_cancle_req= $this->stage3_reass_cancle_interview_booking->set($details)->insert();
        
        
         $update_data = [ 'status'=>'Lodged'];
         $update_interview_comment= $this->stage_3_reassessment_model->where('pointer_id', $pointer_id)->set($update_data)->update();
        if($update_interview_comment){
         $application_p=[
           'status'=>'Lodged',
           ];
           $application_update=$this->application_pointer_model->where('id', $pointer_id)->set($application_p)->update();
   
       
       //MAIL SENDING 
       if($acount_type == 'applicant'){
         $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '208'])->first();
         $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
         $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking% ', $option, $mail_body_reason);
         $to=$applicant_email;
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body, [], [],[]);
        }
        if($acount_type == 'Agent'){
         $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '207'])->first();
         $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
          $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking% ', $option, $mail_body_reason);
         $to=$agent_email;
         $email_cc = $applicant_email;
         if(empty($email_cc)){
            $mail_cc = [];
         }
        $mail_cc = array_map('trim', explode(', ', $email_cc));
         $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body, [], [],$mail_cc,[]);
        }

   if($location_id){
            $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        }
        $s3_interview_day_and_date = "";
        $s3_interview_time_A = "";
        $date_time = $stage_reass_interview_booking->date_time;
        if (!empty($date_time)) {
            $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
            $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
        }
        $date_time_zone = (isset($location->date_time_zone)) ? $location->date_time_zone : "";
        
        $s3_interview_time_B = "";
        if (!empty($date_time_zone)) {
            if (!empty($date_time)) {
                $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
                $date->setTimezone(new DateTimeZone($date_time_zone));
                $s3_interview_time_B = $date->format('h:i A') . " (" . $date_time_zone . " Time)";
            }
        }
          $allowedLocationIds = $this->getAqatoLocationIds();
    
          if(in_array($location_id, $allowedLocationIds)){
        // if($location_id){
         $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '205'])->first();
         $mail_subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_3->body, $pointer_id);
         $get_slot_time = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $mail_body_reason);
         $date_time = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $get_slot_time);
         $meeting_id_change = str_replace('%s3_interview_venue%', $meeting_id, $date_time);
         $message = str_replace('%s3_interview_address%', $passcode, $meeting_id_change);
          
        $to = $location->email;
        $email_cc = $location->email_cc;
        $mail_cc = array_map('trim', explode(', ', $email_cc));
        if(empty($email_cc)){
            $mail_cc = [];
        }
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $message, [], [], $mail_cc, []);
        
            
        // } // Location ID
          }
        
    //FOR ADMIN AND HEAD_OFFICE
           $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '206'])->first();
           $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
           $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
           $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking% ', $option, $mail_body_reason);
           $to = env('ADMIN_EMAIL');
           $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
           $to = env('HEADOFFICE_EMAIL');
           $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
             $stage_3_interview_del = $this->stage_3_reassessment_interview_booking_model->where('pointer_id', $pointer_id)->asobject()->delete();
         $email_interview_location = $this->email_interview_location_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_3_R'])->asObject()->delete();
       
        if($Email_send_check_2 && $Email_send_check && $check){
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
   
      
        }
}

//non_aquato_by rohit
// public function non_aquato_interview_booking_cancle(){
    

//         $id=$this->request->getPost('id');
//         $not_aqato_s3=find_one_row('not_aqato_s3','id',$id);
//         $pointer_id=$not_aqato_s3->id;
//         $location_id=$not_aqato_s3->interview_location;
//         $full_name=$not_aqato_s3->full_name;
//         $occupation=$not_aqato_s3->occupation_name;
//         $unique_no=$not_aqato_s3->unique_number;
        
//         $email_interview_location_model_=find_one_row('email_interview_location','pointer_id',$location_id);
//         $location__ = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
//         $email_=$location__->email;
//         $email_cc=$location__->email_cc;
//         $meeting_id=$location__->venue;
//         $passcode=$location__->office_address;
//         // print_r($email_interview_location_model_);
//         // die;
//         if($email_interview_location_model_){
//         $applicant_email=$email_interview_location_model_->email_cc;
//         $agent_email=$email_interview_location_model_->email;
//         }
//         $option=$this->request->getPost('options');
//         $comment=$this->request->getPost('comment');
//         if($option == 'other'){
//           $option= $comment;
//         }
//         // if(!empty($applicant_email)){
//         $stage_3_interview = $this->not_aqato_s3_model->where('id', $id)->asobject()->first();
//         $location_id = $stage_3_interview->interview_location;
//         if($location_id){
//             $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
//         }
        
//         $s3_interview_day_and_date = "";
//         $s3_interview_time_A = "";
//         $date_time = $stage_3_interview->interview_date;
//         if (!empty($date_time)) {
//             $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
//             $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
//         }
//         $date_time_zone = (isset($location->date_time_zone)) ? $location->date_time_zone : "";
        
//         $s3_interview_time_B = "";
//         if (!empty($date_time_zone)) {
//             if (!empty($date_time)) {
//                 $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
//                 $date->setTimezone(new DateTimeZone($date_time_zone));
//                 $s3_interview_time_B = $date->format('h:i A') . " (" . $date_time_zone . " Time)";
//             }
//         }
//         $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '212'])->first();
//         $name = str_replace('%full_name%',$full_name, $mail_temp_3->subject);
       
//         $occupation_ = str_replace('%occupation_name%',$occupation, $name);
//          $subject = str_replace('%unique_number%',"[#" .$unique_no. "]", $occupation_);
        
//         $s3_interview_venue = str_replace('%s3_interview_venue%', $location->venue, $mail_temp_3->body);
//         $s3_interview_address = str_replace('%s3_interview_address%', $location->office_address, $s3_interview_venue);
        
//         $get_slot_time = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $s3_interview_address);
//         $date_time = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $get_slot_time);
//         $meeting_id_change = str_replace('%s3_interview_venue%', $meeting_id, $date_time);
//          $message = str_replace('%s3_interview_address%', $passcode, $meeting_id_change);
//         $to = $location->email;
//         $email_cc = $location->email_cc;
//         $mail_cc = array_map('trim', explode(', ', $email_cc));
//         if(empty($email_cc)){
//             $mail_cc = [];
//         }
//         $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
//     //FOR ADMIN AND HEAD_OFFICE
//           $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '211'])->first();
//           //$subject = $mail_temp_1->subject;
//           $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
//           $first_name= str_replace('%full_name%', $full_name, $mail_subject);
//           $occupation_= str_replace('%occupation_name%',$occupation, $first_name);
//           $mail_subject= str_replace('%unique_number%', $unique_no, $occupation_);
//         // $mail_body_ = mail_tag_replace($mail_temp_1->body, $pointer_id);
//           $mail_body_ = $mail_temp_1->body;
//           $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking%',$option,$mail_body_);
//          $to = env('ADMIN_EMAIL');
//          $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body);
//          $to = env('HEADOFFICE_EMAIL');
//          $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body);
//          $not_aqato_s3= $this->not_aqato_s3_model->where('id', $pointer_id)->asobject()->delete();
//          $email_interview_location = $this->email_interview_location_model->where(['pointer_id' => $pointer_id, 'stage' => 'non_aqato_stage_3'])->asObject()->delete();
//         if($not_aqato_s3) {
//          $insert_data = [
//         'non_aquato_id'=>$id,
//         'interview_comment' => $option,
//         'interview_cancle_date'=>date('Y,m,d')
//          ];
//          $insert_interview_comment= $this->not_aqato_s3_cancle_req_model->set($insert_data)->insert();
//         }
//         if($Email_send_check_2){
//             $callback = array(
//                 "color" => "success",
//                 "msg" => "mail send succesfully",
//                 "response" => true,
//                 'pointer_id' => $id,
//             );
//         } else {
//             $callback = array(
//                 "msg" => "mail not send",
//                 "color" => "danger",
//                 "response" => false,
//                 'pointer_id' => $id,
//             );
//         }
//         echo json_encode($callback);
//   }
public function non_aquato_interview_booking_cancle(){
    

        $id=$this->request->getPost('id');
        $not_aqato_s3=find_one_row('not_aqato_s3','id',$id);
        $pointer_id=$not_aqato_s3->id;
        $location_id=$not_aqato_s3->interview_location;
        $full_name=$not_aqato_s3->full_name;
        $occupation=$not_aqato_s3->occupation_name;
        $unique_no=$not_aqato_s3->unique_number;
        
        $email_interview_location_model_=find_one_row('email_interview_location','pointer_id',$location_id);
        $location__ = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        $email_=$location__->email;
        $email_cc=$location__->email_cc;
        $meeting_id=$location__->venue;
        $passcode=$location__->office_address;
        // print_r($email_interview_location_model_);
        // die;
        if($email_interview_location_model_){
        $applicant_email=$email_interview_location_model_->email_cc;
        $agent_email=$email_interview_location_model_->email;
        }
        $option=$this->request->getPost('options');
        $comment=$this->request->getPost('comment');
        if($option == 'other'){
          $option= $comment;
        }
        // if(!empty($applicant_email)){
        $stage_3_interview = $this->not_aqato_s3_model->where('id', $id)->asobject()->first();
        $location_id = $stage_3_interview->interview_location;
        if($location_id){
            $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        }
        
        $s3_interview_day_and_date = "";
        $s3_interview_time_A = "";
        $date_time = $stage_3_interview->interview_date;
        if (!empty($date_time)) {
            $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
            $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
        }
        $date_time_zone = (isset($location->date_time_zone)) ? $location->date_time_zone : "";
        
        $s3_interview_time_B = "";
        if (!empty($date_time_zone)) {
            if (!empty($date_time)) {
                $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
                $date->setTimezone(new DateTimeZone($date_time_zone));
                $s3_interview_time_B = $date->format('h:i A') . " (" . $date_time_zone . " Time)";
            }
        }
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '209'])->first();
        $name = str_replace('%full_name%',$full_name, $mail_temp_3->subject);
       
        $occupation_ = str_replace('%occupation_name%',$occupation, $name);
         $subject = str_replace('%unique_number%',"[#" .$unique_no. "]", $occupation_);
        
        $s3_interview_venue = str_replace('%s3_interview_venue%', $location->venue, $mail_temp_3->body);
        $s3_interview_address = str_replace('%s3_interview_address%', $location->office_address, $s3_interview_venue);
        
        $get_slot_time = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $s3_interview_address);
        $date_time = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $get_slot_time);
        $meeting_id_change = str_replace('%s3_interview_venue%', $meeting_id, $date_time);
         $message = str_replace('%s3_interview_address%', $passcode, $meeting_id_change);
        $to = $location->email;
        $email_cc = $location->email_cc;
        $mail_cc = array_map('trim', explode(', ', $email_cc));
        if(empty($email_cc)){
            $mail_cc = [];
        }
      $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
    //FOR ADMIN AND HEAD_OFFICE
          $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '210'])->first();
          $subject = $mail_temp_1->subject;
        //  $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
          $first_name= str_replace('%full_name%', $full_name, $subject);
          $occupation_= str_replace('%occupation_name%',$occupation, $first_name);
           $mail_subject= str_replace('%unique_number%', $unique_no, $occupation_);
        // $mail_body_ = mail_tag_replace($mail_temp_1->body, $pointer_id);
           $mail_body_ = $mail_temp_1->body;
           $mail_body = str_replace('%occupation_reason_for_decline_stage_3_interview_booking%',$option,$mail_body_);
         $to = env('ADMIN_EMAIL');
         $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
         $to = env('HEADOFFICE_EMAIL');
         $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
         $not_aqato_s3= $this->not_aqato_s3_model->where('id', $pointer_id)->asobject()->delete();
         $email_interview_location = $this->email_interview_location_model->where(['pointer_id' => $pointer_id, 'stage' => 'non_aqato_stage_3'])->asObject()->delete();
        if($not_aqato_s3) {
         $insert_data = [
        'non_aquato_id'=>$id,
        'interview_comment' => $option,
        'interview_cancle_date'=>date('Y,m,d')
         ];
         $insert_interview_comment= $this->not_aqato_s3_cancle_req_model->set($insert_data)->insert();
        }
        if($Email_send_check_2){
            $callback = array(
                "color" => "success",
                "msg" => "mail send succesfully",
                "response" => true,
                'pointer_id' => $id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $id,
            );
        }
        echo json_encode($callback);
   }
}

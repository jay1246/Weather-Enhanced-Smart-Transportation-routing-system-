<?php

namespace App\Controllers\Admin\Application_manager;


use PHPMailer\PHPMailer\PHPMailer; // if using phpmailer use this 3 namespaces writen below only
use PHPMailer\PHPMailer\Exception;

use App\Controllers\BaseController;
use ZipArchive;
use DateTime as GlobalDateTime;
use DateTime;
use DateTimeZone;
class application_manager extends BaseController
{

    // ---------------admin  Application Manager ---------------- 

        
    public function index_new(){
        $db = db_connect();
        $session = session();
        // $session->destroy();
        $__search_input = isset($session->__search_input) ? $session->__search_input : "";
        $data["__search_input"] = $db->escapeString($__search_input);
        $data['page']="Application Manager";
        // exit;
        // echo "Hey";
        return view('admin/application_manager/index_new', $data);
    }
    
    
    public function fetch_application_records(){
        $db = db_connect();

        $search_input = trim($this->request->getVar('search_input') ?? "");
        $search_input = $db->escapeString($search_input);
        
        $session = session();

        $session->set('__search_input', $search_input);

        // echo $status_list;
        // exit;
        // Checking for First Last Middle One By One
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
                $filter_search .= " and (s1_p.first_or_given_name like '%".$single_search."%' OR s1_p.middle_names like '%".$single_search."%' OR s1_p.surname_family_name like '%".$single_search."%' OR ap.application_number like '%".$single_search."%' OR s1.unique_id like '%".$single_search."%')";
            }
        } 




        // Adding Flag Filter Logic
        $search_flag = trim($this->request->getVar('search_flag') ?? "");
        // Creating Filter Var
        // echo $search_flag;
        // die;
        $inner_join_flag_filter = "";
        $where_flag_filter = "";
        if($search_flag){
        $inner_join_flag_filter = " INNER JOIN additional_info_request add_info ON add_info.pointer_id = s1_p.pointer_id ";
        $where_flag_filter = " and add_info.stage = ap.stage and ((ap.status <> 'Closed' OR ap.status <> 'Completed') AND NOT (ap.stage ='stage_3_R' AND ap.status = 'Approved') AND NOT (ap.stage = 'stage_1' AND ap.status = 'Declined') AND NOT (ap.stage = 'stage_1' AND ap.status = 'Withdrawn') AND NOT (ap.stage = 'stage_2' AND ap.status = 'Withdrawn')) and add_info.status = '".$search_flag."' ";

        }
        // END
        
        
        // Add Comment Filter
        
        $add_comment_filter = trim($this->request->getVar('add_comment_filter') ?? "");
        $where_comment_filter = "";
        $inner_join_comment_filter = "";
        if($add_comment_filter){
            
            $inner_join_comment_filter = " 
            LEFT JOIN stage_2 s2 ON s2.pointer_id = ap.id 
            LEFT JOIN stage_3 s3 ON s3.pointer_id = ap.id
            ";
            
            $where_comment_filter = "
                AND
                (s1.approved_comment <> '' OR s2.approved_comment <> '' OR s3.approved_comment <> '')
            ";
        }
        
        
        // 

        
        // Access Config
        $access_status_filter = "";
        if (session()->get('admin_account_type') == 'admin') {
            $access_status_filter = " and not (ap.stage = 'stage_1' AND ap.status = 'Start') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Withdrawn', 'Expired','Closed') ";
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired','Closed'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Expired') ";
            if($search_flag){
            $access_status_filter = "  and not (ap.stage = 'stage_1' AND ap.status = 'Start') and not (ap.stage = 'stage_1' AND ap.status = 'Declined') and not (ap.stage = 'stage_1' AND ap.status = 'Submitted') and not (ap.stage = 'stage_2' AND ap.status = 'Submitted') and ap.status IN ('Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Expired') ";
            }
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Expired'];
        } else {
            exit;
        }
        $status_list = implode(",", $status_list);

        // Count total rows
        $countQuery = "SELECT ap.id as total_rows 
                       FROM application_pointer ap 
                       INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                       INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                       INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                       INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter.$inner_join_comment_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter.$where_comment_filter." group by ap.id ";
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
        $dataQuery = "SELECT s1.closure_date,s1.expiry_date,ap.team_member,ap.id,ap.stage,ap.status,ap.application_number,s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date, s1.approved_date 
                      FROM application_pointer ap 
                      INNER JOIN stage_1_personal_details s1_p on ap.id = s1_p.pointer_id 
                      INNER JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id 
                      INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id 
                      INNER JOIN stage_1 s1 on s1.pointer_id=s1_p.pointer_id ".$inner_join_flag_filter.$inner_join_comment_filter." where 1=1 ".$access_status_filter.$filter_search.$where_flag_filter.$where_comment_filter."
                      group by ap.id
                      ORDER BY s1.submitted_date DESC 
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
        return view('admin/application_manager/partial_view', ['data' => $dataResult, 'pager' => $pager, 'currentPage' => $start, 'itemsPerPage' => $end, 'totalRows' => $totalRows, 'search_flag' => $search_flag]);

    }


    public function fetch_application_records_old(){
        // echo "Hey";
        
        // You might want to add logic here to determine the current page and number of items per page
        $data = $this->application_pointer_model->paginate(10); // e.g., 10 items per page
        $pager = $this->application_pointer_model->pager;


        // SELECT s1_p.first_or_given_name, s1_p.middle_names, s1_p.surname_family_name, s1.unique_id, s1_p.date_of_birth, occ_list.name, s1.submitted_date FROM application_pointer ap INNER JOIN`stage_1_personal_details` s1_p on ap.id = s1_p.pointer_id inner JOIN stage_1_occupation s1_occ ON s1_occ.pointer_id=s1_p.pointer_id INNER JOIN occupation_list occ_list on occ_list.id = s1_occ.occupation_id INNER join stage_1 s1 on s1.pointer_id=s1_p.pointer_id ORDER by s1.submitted_date DESC limit 10;




        echo view('admin/application_manager/partial_view', ['data' => $data, 'pager' => $pager]); // A view file for your paginated data
        // return view('admin/application_manager/index_new');
    }


    public function index()
    {
        $data['page_name'] = 'Application Manager';
        $status_list = "";
        if (session()->get('admin_account_type') == 'admin') {
            $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired'];
        } else if (session()->get('admin_account_type') == 'head_office') {
            $status_list = ['Start','Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted','Declined', 'Expired'];
        } else {
            exit;
        }
        //    $data['stage_1'] = $this->stage_1_model->asObject()->orWhereIn('status', $status_list)->orderby('submitted_date', 'DESC')->findAll();



        $all_list = array();
        $application_pointer_model = $this->application_pointer_model->asObject()->orWhereIn('status', $status_list)->orderby('create_date', 'DESC')->findAll();
        $lastQuery = $this->application_pointer_model->getLastQuery();

        // Display the last executed query
        // echo $lastQuery;
        $i = 0;
        $aaa = array();
        foreach ($application_pointer_model as $stage) {
            // echo "<pre>";
            // print_r($stage);
            // echo "</pre>";
            // exit;

            $show = true;
            if ($stage->stage == "stage_1") {
                if ($stage->status == "Start") {
                    $show = false;
                }
                if (session()->get('admin_account_type') == 'head_office') {
                    if ($stage->status == "Start" || $stage->status == "Submitted") {
                        $show = false;
                    }
                }
            }
            if ($show) {
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



            $additional_info_request = find_one_row_2_field_for_flag('additional_info_request', 'pointer_id', $pointer_id,'stage', $stage->stage);
                $list_array['additional_info_request'] =  $additional_info_request;

                $all_list[] = $list_array;
            }
        }


        $data['all_list'] = $all_list;



        return view('admin/application_manager/index', $data);
    }

    // ---------------admin Application Manager -> view/update ----------------

    public function test_email(){
        

    require_once 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    // try {
        $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

        $mail->CharSet = "UTF-8";
        
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
        $mail->SMTPAuth = true;
        //to view proper logging details for success and error messages
        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
        $mail->Username = 'mohsin@techflux.in';   //email
        $mail->Password = 'iieqkziwvhxlhxrh';   //16 character obtained from app password created
        $mail->Port = 465;                    //SMTP port
        $mail->SMTPSecure = "ssl";
        
        
        $mail->setFrom('mohsin@techflux.in', "Test");
        $mail->addAddress("mohsin@techflux.in");
        $mail->addAddress("sohel@techflux.in");
        $mail->addAddress("hr@techflux.in");
        $mail->isHTML(true);                                  //Set email format to HTML

        $mail->Subject =  "Eveining Test";
        $mail->Body    =  "Body Test";
        $mail->send();
        echo "<pre>";
        print_r($mail);
        // echo true;
    // } catch (Exception $e) {
    //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    // }
    }

    public function change_team_member(){
        $pointer_id = $this->request->getPost("pointer_id");
        $team_member = $this->request->getPost("team_member");
        echo $this->application_pointer_model->update($pointer_id, ["team_member" => $team_member]);
        // echo $this->application_pointer_model->getLastQuery();
    }
    
    public function getTheExistingSession(){
        $session = session();
        return $session->admin_id;
    }
    
    public function change_team_member_show(){
        $data["admin_login_id"] = $this->getTheExistingSession();
        $data["team_members"] = getTheAccountsForAdmin("admin");
        $pointer_id = $this->request->getPost("pointer_id");
        $data["main_data"] = $this->application_pointer_model->find($pointer_id);
        // $data["main_data"]["team_member_name"] = "";
        if($data["main_data"]["team_member"] != 0){
        $admin_data = $this->admin_account_model->find($data["main_data"]["team_member"]);
        $data["main_data"]["team_member_name"] = $admin_data["first_name"]." ".$admin_data["last_name"];
        }
        echo json_encode($data);
    }

    public function view_application($pointer_id, $tab)
    {
        // $this->test_email();
        // exit;
        $get_id = find_one_row('application_pointer', 'id', $pointer_id);
        $data["app_table"] = $get_id;
    
        $user_id = $get_id->user_id;
      
        if (session()->get('admin_account_type') == 'admin') {
            $data['stage_1'] = $this->stage_1_model->asObject()->where('pointer_id', $pointer_id, 'status', ['Submitted', 'Lodged', 'In Progress', 'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            $data['stage_2'] = $this->stage_2_model->asObject()->where('pointer_id', $pointer_id, 'status', ['Submitted', 'Lodged', 'In Progress', 'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            //    echo  $this->stage_2_model->getLastQuery();
            $data['stage_3'] = $this->stage_3_model->asObject()->where('pointer_id', $pointer_id, 'status', ['Submitted', 'Lodged', 'In Progress', 'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            $data['stage_3_reassessment'] = $this->stage_3_reassessment_model->asObject()->where('pointer_id', $pointer_id, 'status', ['Submitted', 'Lodged', 'In Progress', 'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
             $data['stage_4'] = $this->stage_4_model->asObject()->where('pointer_id', $pointer_id, 'status', ['Submitted', 'Lodged', 'In Progress', 'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();

            
        } else {
            $data['stage_1'] = $this->stage_1_model->asObject()->where('pointer_id', $pointer_id, 'status', ['In Progress', 'Lodged',  'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            $data['stage_2'] = $this->stage_2_model->asObject()->where('pointer_id', $pointer_id, 'status', ['In Progress', 'Lodged',  'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            $data['stage_3'] = $this->stage_3_model->asObject()->where('pointer_id', $pointer_id, 'status', ['In Progress', 'Lodged',  'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            $data['stage_3_reassessment'] = $this->stage_3_reassessment_model->asObject()->where('pointer_id', $pointer_id, 'status', ['In Progress', 'Lodged',  'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();
            $data['stage_4'] = $this->stage_4_model->asObject()->where('pointer_id', $pointer_id, 'status', ['In Progress', 'Lodged',  'Approved', 'Declined', 'Withdrawn', 'Expired'])->first();

        }
        
        $data['username'] =  $this->user_account_model->asObject()->find($user_id);
        $data['s1_personal_details'] =  $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();
       
        $data['s1_contact_details'] =  $this->stage_1_contact_details_model->asObject()->where('pointer_id', $pointer_id)->first();
        $data['s1_occupation'] =  $this->stage_1_occupation_model->asObject()->where('pointer_id', $pointer_id)->first();
        $data['additional_info_request'] = $this->additional_info_request_model->asObject()->where('pointer_id', $pointer_id)->first();
        
        $data['stage_1_documents'] = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_1'])->whereNotIn('required_document_id', [50])->orderby('required_document_id', 'ASC')->findAll();
        $data['stage_3_documents'] = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3'])->whereNotIn('required_document_id', [23, 24, 25, 26])->findAll();
        $data['stage_3_reassessment_documents'] = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3_R'])->whereNotIn('required_document_id', [23, 24, 25, 26])->findAll();
        $data['stage_4_documents'] = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_4'])->whereNotIn('required_document_id', [23, 24, 25, 26])->findAll();
        // print_r($data['stage_4_documents']);
        // exit;
        $data['stage_2_add_employees'] = $this->stage_2_add_employment_model->asObject()->where('pointer_id', $pointer_id)->findAll();
        $data['application_pointer'] = $this->application_pointer_model->asObject()->where('id', $pointer_id)->first();
        $count_company = count_company($pointer_id);
        // print_r($count_company);
        // echo $count_company->number;
        // exit;
        $data['count_company'] = $count_company->number;
        // Comment Code Due to SQL
        // $data['stage_2_email_verification'] = $this->email_verification_model->asObject()->where(['pointer_id'=> $pointer_id])->where(['verification_type' => 'Verification - Employment','verification_type'=>'Verification Email - Employment'])->orWhere(['verification_type'=>'Verification Email - Employment'])->findAll();
        
        // Taking From Helper
        $data['stage_2_email_verification'] = __employment_email_verification($pointer_id);
        // echo $this->email_verification_model->getLastQuery();
        // exit;
        $data['stage_3_documents_vhp'] = $this->documents_model->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3'])->findAll();
        $data['stage_3_reassessment_documents_vhp'] = $this->documents_model->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3_R'])->findAll();


        $data['pointer_id'] = $pointer_id;
        $data['user_id'] = $user_id;
        $data['tab'] = $tab;
        $data['is_uploaded_admin_doc'] =  $this->email_verification_model->asObject()->where('pointer_id', $pointer_id)->first();
        $data['stage_3_cancle_booking'] = find_one_row("stage3_cancle_interview_booking", 'pointer_id', $pointer_id);
        $data['stage_3_cancle_booking_reass'] = find_one_row("stage3_reass_cancle_interview_booking", 'pointer_id', $pointer_id);
             $offline_locations = $this->stage_3_offline_location_model->find();

            $country = array();

            foreach ($offline_locations as $key => $value) {

                if (!in_array($value['country'], $country)) {

                    $country[] = $value['country'];

                }

            }


         $location = array();

            foreach ($country as $key => $value) {

                $offline_location = $this->stage_3_offline_location_model->where(['country' => $value, 'pratical'=>0])->find();

                $location[$value] = $offline_location;

            }
            $pratical_location = array();

            foreach ($country as $key => $value) {

                $prat_location = $this->stage_3_offline_location_model->where(['country' => $value, 'pratical'=>1])->find();

                $pratical_location[$value] = $prat_location;

            }



            $data['location']=$location;
            $data['pratical_location']=$pratical_location;
            
            $data['time_zone'] = $this->time_zone_model->groupBy('zone_name')->findAll();
            if($get_id->is_doc_deleted == 1){
                return view('admin/application_manager_completed/view_application', $data);
                exit;
            }
            $notes_count=$count = $this->notes->where('pointer_id', $pointer_id)->countAllResults();
            $data['notes_count']=$notes_count;
            $where=array('required_document_id'=>1,
                          'pointer_id' => $pointer_id
            );
            $user_image =$this->documents_model->where($where)->first();
            $data['user_image'] = $user_image; 
            // print_r($user_image);
            // die;
            
        return view('admin/application_manager/view_application', $data);
    }
    // ---------------admin  Application Manager -> view/update -> stage 1 -> update Head Office Unique Number----------------
    public function update_unique_no()
    {

        $pointer_id = $this->request->getVar('pointer_id');
        $unique_head_office_no = $this->request->getVar('unique_head_office_no');
        $allocate_team_member_name = $this->request->getVar('Assigned_Team_Member_id');

        $output = $this->stage_1_model->where(['pointer_id' => $pointer_id])->set(['unique_id' => $unique_head_office_no, 'allocate_team_member_name' => $allocate_team_member_name])->update();
        $json = ["error" => 1];
        if ($output) {
            $json = [
                "error" => 0,
                "msg"   => "Successfully",
            ];
        }

        echo json_encode($json);
    }
    
    public function save_Assigned_occupation()
    {

        $pointer_id = $this->request->getVar('pointer_id');
        $selectedValue = $this->request->getVar('selectedValue');
        $allocate_occupation = $this->request->getVar('allocate_occupation');
       //  echo $pointer_id; die;
        //stage_1_occupation
        $response = $this->db->table('stage_1_occupation')->set('occupation_id', $selectedValue)->where('pointer_id', $pointer_id)->update();
      //  $output = $this->stage_1_model->where(['pointer_id' => $pointer_id])->set(['unique_id' => $unique_head_office_no, 'allocate_team_member_name' => $allocate_team_member_name])->update();
        $json = ["error" => 1];
        if ($response) {
        $json = 1;
        }

        echo json_encode($json);
    }
    
    // ---------------admin Application Manager -> documents ->comments for all stages ----------------
    public function comments_for_document()
    {
        $reasons = $this->request->getPost('reason');
        $stages = $this->request->getPost('stage');
        $pointer_ids = $this->request->getPost('pointer_id');
        $document_ids = $this->request->getPost('document_id');
        $request_additional = $this->request->getPost("request_additional");
        $admin_id =  session()->get('admin_id');

        if (!empty($request_additional)) {
            $addition_data = array(
                'pointer_id' => $pointer_ids[0],
                'stage' => $stages[0],
                'reason' => $request_additional,
                'status' => 'send',
                'send_by' => session()->get('admin_id')

            );
            $this->additional_info_request_model->insert($addition_data);
             //for insert docs in note module
            $this->for_insert_notes_documents($request_additional, $pointer_ids[0]); 
        }


        if ($reasons != "") {
            foreach ($reasons as $key => $value) {
               // echo $reason; 
                if ($value) {
                    $reason = $value;
                    $stage =  $stages[$key];
                    $pointer_id =  $pointer_ids[$key];
                    $document_id =  $document_ids[$key];

                    $data = array(
                        'pointer_id' => $pointer_id,
                        'stage' => $stage,
                        'document_id' => $document_id,
                        'reason' => $reason,
                        'status' => 'send',
                        'send_by' => session()->get('admin_id')
                    );
                    $this->additional_info_request_model->insert($data);
                     //for insert notes
                  //echo 'fsbdv2222222222';
               $this->for_insert_notes_documents($reason,$pointer_id); 
                }
                $key++;
           
            }
        }
        $pointer_id = $pointer_ids[0];
        $user_id = find_one_row("application_pointer", "id", $pointer_id)->user_id;
        $user_data = find_one_row("user_account", "id", $user_id);
            // stage 1
        if ($stages[0] == 'stage_1' && $user_data->account_type == "Agent") {
            // s1_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '16'])->first();
        } elseif ($stages[0] == 'stage_1' && $user_data->account_type == "Applicant") {
            // s1_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '61'])->first();
            // stage 2
        } elseif ($stages[0] == 'stage_2' && $user_data->account_type == "Agent") {
            // s2_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '18'])->first();
        } elseif ($stages[0] == 'stage_2' && $user_data->account_type == "Applicant") {
            // s2_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '72'])->first();
            // stage 3
        } elseif ($stages[0] == 'stage_3') {
            // s3_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '33'])->first();
            // stage 3 reassessment
        } elseif ($stages[0] == 'stage_3_R') {
            // s3_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '198'])->first();
            // stage 4
        } elseif ($stages[0] == 'stage_4' && $user_data->account_type == "Agent") {
            // s4_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '139'])->first();
        } elseif ($stages[0] == 'stage_4' && $user_data->account_type == "Applicant") {
            // s4_request_additional_applicant
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '148'])->first();
        }
        
        $user_email  = $user_data->email;
        $subject = mail_tag_replace($mail_temp->subject, $pointer_id);
        $message = mail_tag_replace($mail_temp->body, $pointer_id);
        $to = $user_email;

        // print_r($message);
        // print_r($subject);
        // exit;
        $addReplyTo_array = [];
        if (session()->get('admin_account_type') == "head_office") {
            $addBCC_array = [env('ADMIN_EMAIL')];
        } else {
            $addBCC_array = [];
        }
        $addCC_array = [];
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, $addReplyTo_array, $addBCC_array, $addCC_array, []);


        if ($check == 1) {
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

//code for stage 2 ddditional req

public function comment_document_stage_2()
    {
         // print_r($_POST);exit;
        $reasons = $this->request->getPost('reason');
        $stages = $this->request->getPost('stage');
        $pointer_ids = $this->request->getPost('pointer_id');
        $document_ids = $this->request->getPost('document_id');
        // $request_additional = $this->request->getPost("request_additional");
        // $request_additional_value_ = $this->request->getPost("request_additional_");
        $request_additional_data = $this->request->getPost('request_additional_value');
        $reupload_emp_docs = $this->request->getPost('reupload_emp_docs');
        $support_evidance_status = $this->request->getPost('support_evidance_status');
        // print_r($support_evidance_status);exit;
        
        $request_additional_support = $this->request->getPost('request_additional_support');
        
      
        // echo $impload_data;exit;
        
    //   exit;
        
        // if(!empty($request_additional_value_))
        // {
        //     // echo "yes";
        //     $additional_data = '';
        // //  foreach($request_additional_data as $request_additional_data_)
        // //  {
        // //      $additional_data = $request_additional_data_;
        // //  }
        //     // echo $additional_data;exit;
            
        //  foreach($request_additional_value_ as $key=>$request_additional_)
        // {
            
        //     // print_r($request_additional_);
            
        //     // If Reason There Then Add
        //         if($request_additional_){
        //             $reason = $request_additional_;
                    
        //             $stage =  $stages[$key];
        //             $pointer_id =  $pointer_ids[$key];
        //             $support_evidance_status_ = $support_evidance_status[$key];
                    
                    
        //              $addition_data = array(
        //                 'pointer_id' => $pointer_id,
        //                 'stage' => $stage,
                        
        //                 'reason' => $reason,
        //                 'status' => 'send',
        //                 'send_by' => session()->get('admin_id'),
        //                 's2_add_employment_id' => $request_additional_data[$key]
        //              );
            
        //           $this->additional_info_request_model->insert($addition_data);
                    
                    
                    
        //         //     $addition_data_value = array(
        //         //         'pointer_id' => $pointer_ids[0],
        //         //         'stage' => $stages[0],
        //         //         'reason' => $reason,
        //         //         'status' => 'send',
        //         //         'send_by' =>session()->get('admin_id'),
        //         //         's2_add_employment_id' => $request_additional_data[$key]
        //         //         );
        //         //         echo "<pre>";
        //         //         print_r($addition_data_value);continue;
                       
        //         }
        //          // $this->additional_info_request_model->insert($addition_data_value);
        //     }
            
                
                
        // }
        
        // exit;
        // if (!empty($request_additional[0])) {
        //     $addition_data = array(
        //         'pointer_id' => $pointer_ids[0],
        //         'stage' => $stages[0],
        //         'reason' => $request_additional[0],
        //         'status' => 'send',
        //         'send_by' => session()->get('admin_id')
                

        //     );
            
        //     $this->additional_info_request_model->insert($addition_data);
        // }
        
        
        // if(!empty($request_additional))
        // {
        //     foreach($request_additional as $key => $value)
        //     {
        //         if($value)
        //         {
        //             $reason = $value;
        //             $stage =  $stages[$key];
        //             $pointer_id =  $pointer_ids[$key];
        //             $support_evidance_status_ = $support_evidance_status[$key];
                    
                    
                    
        //             $addition_data = array(
        //                 'pointer_id' => $pointer_id,
        //                 'stage' => $stage,
        //                 'support_evidance_status' => $support_evidance_status_,
        //                 'reason' => $reason,
        //                 'status' => 'send',
        //                 'send_by' => session()->get('admin_id')
        //              );
            
        //           $this->additional_info_request_model->insert($addition_data);
        //         }
        //     }
        // }
        
        // if (!empty($request_additional[1])) {
        //     $addition_data = array(
        //         'pointer_id' => $pointer_ids[0],
        //         'stage' => $stages[0],
        //         'reason' => $request_additional[1],
        //         'status' => 'send',
        //         'support_evidance_status' => 'yes',
        //         'send_by' => session()->get('admin_id')
                

        //     );
            
        //     $this->additional_info_request_model->insert($addition_data);
        // }
        
        
        // if(!empty($request_additional_support))
        // {
        //     $addition_data = array(
        //         'pointer_id' => $pointer_ids[0],
        //         'stage' => $stages[0],
        //         'reason' => $request_additional_support[0],
        //         'status' => 'send',
        //         'send_by' => session()->get('admin_id')
                

        //     );
            
        //     $this->additional_info_request_model->insert($addition_data);
        // }

        
        if ($reasons != "") {
            foreach ($reasons as $key => $value) {
                if ($value) {
                    // print_r($reasons);
                    $reason = $value;
                    $stage =  $stages[$key];
                    $pointer_id =  $pointer_ids[$key];
                    $document_id =  $document_ids[$key];
                    $support_evidance_status_col = NULL;
                  if(isset($support_evidance_status[$key])  && $support_evidance_status[$key] != ""){
                      $support_evidance_status_col = "yes";
                  }
                  

                    $data = array(
                        'pointer_id' => $pointer_id,
                        'stage' => $stage,
                        'document_id' => $document_id,
                        'reason' => $reason,
                        'status' => 'send',
                        'support_evidance_status' => $support_evidance_status_col,
                        's2_add_employment_id' => $reupload_emp_docs[$key],
                        'send_by' => session()->get('admin_id')
                    );
                    // print_r($data);
                    $this->additional_info_request_model->insert($data);
                    
                    //for insert notes
                   // echo $reason;
                    if(!empty($reason )){
                        $this->for_insert_notes_documents($reason,$pointer_id);  
                    }
                   
                }
                $key++;
                 
            }
        }
        // exit;
        $pointer_id = $pointer_ids[0];
        $user_id = find_one_row("application_pointer", "id", $pointer_id)->user_id;
        $user_data = find_one_row("user_account", "id", $user_id);
            // stage 1
        if ($stages[0] == 'stage_1' && $user_data->account_type == "Agent") {
            // s1_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '16'])->first();
        } elseif ($stages[0] == 'stage_1' && $user_data->account_type == "Applicant") {
            // s1_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '61'])->first();
            // stage 2
        } elseif ($stages[0] == 'stage_2' && $user_data->account_type == "Agent") {
            // s2_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '18'])->first();
        } elseif ($stages[0] == 'stage_2' && $user_data->account_type == "Applicant") {
            // s2_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '72'])->first();
            // stage 3
        } elseif ($stages[0] == 'stage_3') {
            // s3_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '33'])->first();
            // stage 3 reassessment
        } elseif ($stages[0] == 'stage_3_R') {
            // s3_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '198'])->first();
            // stage 4
        } elseif ($stages[0] == 'stage_4' && $user_data->account_type == "Agent") {
            // s4_request_additional_agent
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '139'])->first();
        } elseif ($stages[0] == 'stage_4' && $user_data->account_type == "Applicant") {
            // s4_request_additional_applicant
            $mail_temp = $this->mail_template_model->asObject()->where(['id' => '148'])->first();
        }
        
        $user_email  = $user_data->email;
        $subject = mail_tag_replace($mail_temp->subject, $pointer_id);
        $message = mail_tag_replace($mail_temp->body, $pointer_id);
        $to = $user_email;

        // print_r($message);
        // print_r($subject);
        // exit;
        $addReplyTo_array = [];
        if (session()->get('admin_account_type') == "head_office") {
            $addBCC_array = [env('ADMIN_EMAIL')];
        } else {
            $addBCC_array = [];
        }
        $addCC_array = [];
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, $addReplyTo_array, $addBCC_array, $addCC_array, []);


        if ($check == 1) {
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


//end stage2 
    // ---------------admin Application Manager -> documents -> documents delete for all stages ----------------
    public function delete_document($id)
    {
        $document = find_one_row("documents", "id", $id);
        $file = $document->document_path . '/' . $document->document_name;
        if(file_exists($file)){
            unlink($file);
        }
        // unlink($file);
        if ($this->documents_model->where('id', $id)->delete()) {
            $callback = array(
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
    
    
    // Admin stage 2 delete
    public function delete_stage_2_($pointer_id)
    {
        
        
        // print_r($pointer_id);exit;
        $this->stage_2_model->where('pointer_id',$pointer_id)->delete();
        $this->stage_2_add_employment_model->where('pointer_id',$pointer_id)->delete();
        $this->email_verification_model->where('pointer_id',$pointer_id)->delete();
        $this->documents_model->where('pointer_id',$pointer_id)->where('stage','stage_2')->delete();
        $this->additional_info_request_model->where('pointer_id',$pointer_id)->where('stage','stage_2')->delete();
        
        // delete_files('public/application/'.$pointer_id.'/stage_2', true);
        
        //delete document folder and database data
        // $documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2'])->findAll();
        // if(isset($documents)){
        //     foreach($documents as $document){
        //         $file = $document->document_path;
        //         // echo $file;exit; 
               
        //         if($this->documents_model->where('id', $document->id)->delete()){
        //             // echo "document ".$document->id." deleted";
        //             // echo "\n";
        //         };
        //     }
        // }
          $stage_1=$this->stage_1_model->where('pointer_id',$pointer_id)->first();
            $approved_date=$stage_1['approved_date'];
            $dateapprovedDatabase = new GlobalDateTime($approved_date);
            $statuschange = clone $dateapprovedDatabase;
            $statuschange->modify('+30days');
            $currentDate = new GlobalDateTime();
            //convert_date 31days
            $update="";
        //  if ($currentDate->format('Y-m-d') >= $statuschange->format('Y-m-d') ) {
             
        //  $stage_update=$this->application_pointer_model->where('id',$pointer_id)->set(['stage'=>'stage_1','status' => 'Expired','update_date'=> date('Y-m-d H:i:s')])->update();
        //  $stage_1_update=$this->stage_1_model->where('pointer_id',$pointer_id)->set(['status' => 'Expired','update_date'=> date('Y-m-d H:i:s')])->update();
        //     }else{
        //     $update= $this->application_pointer_model->where('id',$pointer_id)->set(['stage'=>'stage_1','status' => 'Approved','update_date'=> date('Y-m-d H:i:s')])->update();
        //     $stage_1_update=$this->stage_1_model->where('pointer_id',$pointer_id)->set(['status' => 'Expired','update_date'=> date('Y-m-d H:i:s')])->update();
        //     }
            
            
            
            $update= $this->application_pointer_model->where('id',$pointer_id)->set(['stage'=>'stage_1','status' => 'Approved','update_date'=> date('Y-m-d H:i:s')])->update();
            $stage_1_update=$this->stage_1_model->where('pointer_id',$pointer_id)->set(['status' => 'Approved','update_date'=> date('Y-m-d H:i:s')])->update();
            
            
           //Document Delete folder
           $folder_path = 'public/application/'.$pointer_id.'/stage_2';
           $this->deleteDir($folder_path);    
        
        
        

        $callback = array(
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
         echo json_encode($callback);
    }
    
    
    //Delete document folder
    public function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
   }
    
    public function delete_company($id)
    {
        // stage_2_add_employment
       $employ = $this->stage_2_add_employment_model->asObject()->where('id', $id)->first();
       $documents = $this->documents_model->asObject()->where('employee_id',$id)->findAll();
       $number = count($documents);
       $name = $employ->company_organisation_name;
       $verfication = $this->email_verification_model->asObject()->where('employer_id', $id)->first();
       $company_organisation_name =  $employ->company_organisation_name;
       $company_organisation_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_organisation_name); // Removes special chars.
       $company_organisation_name = trim(str_replace(' ', '_', $company_organisation_name));
       $folder_path = 'public/application/' . $employ->pointer_id . '/stage_2/' . $company_organisation_name;

       $count = 0;
       if($documents){
       foreach($documents as $document){
        //   $document = find_one_row("documents", "id", $id);
            $file = $document->document_path . '/' . $document->document_name;
            unlink($file);
            if ($this->documents_model->where('id', $document->id)->delete()) {
               $count++;
            }
       }
       }
    //   echo $path_folder;
        $delete_folder = false;
        if($number == $count){
       $folderPath = $folder_path;

        function deleteFolder($folderPath) {
            if (!is_dir($folderPath)) {
                return;
            }
        
            $files = array_diff(scandir($folderPath), ['.', '..']);
        
            foreach ($files as $file) {
                $filePath = $folderPath . '/' . $file;
        
                if (is_dir($filePath)) {
                    deleteFolder($filePath);
                } else {
                    unlink($filePath);
                }
            }
        
            rmdir($folderPath);
        }

 
        //   unlink($folder_path);
            if($this->stage_2_add_employment_model->where('id', $id)->delete()){
                   $delete_folder = true;
            }
            if(!empty($verfication)){
               if($this->email_verification_model->where('employer_id', $id)->delete()){
                       $verfication_delete = true;
               }
            }

        
        }
       if($delete_folder){ 
           
           $callback = array(
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
            }
        echo json_encode($callback);
     
    }
   
    
// Stage 3 EXEMPTION FILE METHODS 
    public function  upload_exemption_file(){


    $pointer_id = $this->request->getPost('pointer_id');
 
    $time_zone = $this->request->getPost('time_zone');

    $preference_location = "Online (Via Zoom)";//$this->request->getPost('preference_location');


        $file = $this->request->getFile('exemption_file');

        //  print_r($file);
       //  exit;

        $uploaded_filename =  $file->getName();

        $File_extention = $file->getClientExtension();
        
        $stage_1_usi_avetmiss = find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
        
        if($stage_1_usi_avetmiss->currently_have_usi=='yes'){
            // Agent Or appplicant
            $user_find = find_one_row('application_pointer','id',$pointer_id);
            $user_name__find = "";
            if($user_find->user_id){
                
                $user_name__find = find_one_row('user_account','id',$user_find->user_id)->account_type;
            }
            $full_name_pdf = $user_name__find." TI Declaration";
            // end
            $file_exemption_required = $this->required_documents_list_model->where(["id" =>55])->first();
    
            $original_file_name = str_replace($uploaded_filename, $full_name_pdf.'.' . $File_extention, $uploaded_filename);
            
            $target = 'public/application/' . $pointer_id . '/stage_3/';
            
            $file_exemption_required["document_name"] = $full_name_pdf.'.' . $File_extention;
        }
        else{
        
        $file_exemption_required = $this->required_documents_list_model->where(["stage" =>"stage_3",'category'=>'exemption_form'])->first();

        $original_file_name = str_replace($uploaded_filename, 'Exemption Form.' . $File_extention, $uploaded_filename);

        $target = 'public/application/' . $pointer_id . '/stage_3';
        }
        
        $file->move($target, $original_file_name, true);



        $data = array(
            'exemption_form' => $file_exemption_required["document_name"],
            'preference_location'=>$preference_location,
            'time_zone'=>$time_zone
           
        );
        $update =   $this->stage_3_model->where('pointer_id', $pointer_id)->set($data)->update();


        if($update) {
            
            
            $file_exemption_document = [
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3',
                'required_document_id' => $file_exemption_required['id'],
                'name' => $file_exemption_required["document_name"],
                'document_name' => $original_file_name,
                'document_path' => $target,
                'document_type' => '',
                'status' => 1
            ];
          $this->documents_model->insert($file_exemption_document);
            

            $callback = array(

                "color" => "success",

                "msg" => "file uploaded succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "mail not send",

            //     "color" => "danger",

            //     "response" => false,

            //     'pointer_id' => $pointer_id,

            // );

        }


   

}
    // ---------------admin Application Manager -> exemption file -> exemption file delete ----------------
 public function delete_exemption_file($id)

    {
        $pointer_id=$id;
        //echo $pointer_id;
        $exemption_file=$this->stage_3_model->where('pointer_id', $id)->find();
        // print_r($exemption_file) ;
        //exit;

       $file = $exemption_file[0]['exemption_form'];//$document->document_path . '/' . $document->document_name;

        //unlink($file);
      // $data = array('exemption_form' =>'' );
        $update= $this->stage_3_model->where('pointer_id',$pointer_id)->set(['exemption_form'=>NULL])->update();

        if($update){
            
            $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
                                     
            $required_docs_id = 43;
            if($stage_1_usi_avetmiss->currently_have_usi == 'yes'){
                $required_docs_id = 55;    
            }
            
            
            $documents_exception = $this->documents_model->where(["pointer_id" => $pointer_id, 'required_document_id' => $required_docs_id, 'stage' => 'stage_3'])->delete();

            $callback = array(

                "color" => "success",

                "msg" => "Delete recode",

                "response" => true,
            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "unable to delete record",

            //     "color" => "danger",

            //     "response" => false,

            // );

        }


    }
    public function delete_applicant_file($id)

    {
        $pointer_id=$id;
        $pointer_id;
        
        $exemption_file=$this->stage_3_reassessment_model->where('pointer_id', $id)->find();
        $file_exemption_required = $this->required_documents_list_model->where(["id" =>55])->first();
    
        $aplicant_file=$file_exemption_required['document_name'];
        
        $file = $exemption_file[0]['applicant_agent_form'];//$document->document_path . '/' . $document->document_name;
       
        $file2 = base_url('public/application/' . $pointer_id . '/' . $aplicant_file);
        if (file_exists($file2)) {
            unlink($file2);
        }
        
      // $data = array('exemption_form' =>'' );
      //  $update= $this->stage_3_reassessment_model->where('pointer_id',$pointer_id)->set(['applicant_agent_form'=>''])->update();
        
                               $updateData = [
                                'applicant_agent_form' =>'',
                                'agent_applicant' => ''
                            ];
 $update = $this->stage_3_reassessment_model->where('pointer_id', $pointer_id)->set($updateData)->update();
        if($update){
            
            $stage_1_usi_avetmiss=find_one_row('stage_1_usi_avetmiss','pointer_id',$pointer_id);
                                     
            $required_docs_id = 55;
           
            
            
            $documents_exception = $this->documents_model->where(["pointer_id" => $pointer_id, 'required_document_id' => $required_docs_id, 'stage' => 'stage_3_R'])->delete();
             if($documents_exception){
                 echo "delete success";
             }
            $callback = array(

                "color" => "success",

                "msg" => "Delete recode",

                "response" => true,
            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "unable to delete record",

            //     "color" => "danger",

            //     "response" => false,

            // );

        }


    }
    //STAGE 4 EXEMPTION FILE METHODS
    public function  stage4_upload_exemption_file(){



  $pointer_id = $this->request->getPost('pointer_id');
    $time_zone = $this->request->getPost('time_zone');

    $preference_location = "Online (Via Zoom)";//$this->request->getPost('preference_location');


        $file = $this->request->getFile('exemption_file');

         print_r($file);
       //  exit;

        $uploaded_filename =  $file->getName();

        $File_extention = $file->getClientExtension();

        $original_file_name = str_replace($uploaded_filename, 'Exemption form.' . $File_extention, $uploaded_filename);

        $target = 'public/application/' . $pointer_id . '/stage_4/assessment_documents';
 
        $file->move($target, $original_file_name, true);



        $data = array(


            'exemption_form' => $original_file_name,
            'preference_location'=>$preference_location,
            'time_zone'=>$time_zone
        );
        $update =   $this->stage_4_model->where('pointer_id', $pointer_id)->set($data)->update();


        if($update) {

            $callback = array(

                "color" => "success",

                "msg" => "file uploaded succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "mail not send",

            //     "color" => "danger",

            //     "response" => false,

            //     'pointer_id' => $pointer_id,

            // );

        }


   

}
    // ---------------admin Application Manager -> exemption file -> exemption file delete ----------------
 public function stage_4_delete_exemption_file($id)

    {
        $pointer_id=$id;
        //echo $pointer_id;
        $exemption_file=$this->stage_3_model->where('pointer_id', $id)->find();
        // print_r($exemption_file) ;
        //exit;

       $file = $exemption_file[0]['exemption_form'];//$document->document_path . '/' . $document->document_name;

        //unlink($file);
      // $data = array('exemption_form' =>'' );
        $update= $this->stage_4_model->where('pointer_id',$pointer_id)->set(['exemption_form'=>NULL])->update();

        if($update){

            $callback = array(

                "color" => "success",

                "msg" => "Delete recode",

                "response" => true,
            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "unable to delete record",

            //     "color" => "danger",

            //     "response" => false,

            // );

        }


    }




    // ---------------admin Application Manager -> documents -> documents zip for all stages ----------------
    public function download_zip($pointer_id, $stage)
    {
        $dirs = [];
        $s1_personal_details =  $this->stage_1_personal_details_model->asObject()->where('pointer_id', $pointer_id)->first();
        $name = $s1_personal_details->first_or_given_name . ' ' . $s1_personal_details->middle_names . ' ' . $s1_personal_details->surname_family_name;
        $all_file_array = array();
        $target = "public/application/" . $pointer_id . '/' . $stage;
        if ($stage == "stage_1") {
            $zip_file = str_replace("stage_1", "Stage 1 - ", $stage) . "" . $name . ".zip";
            $zipname =  $target . "/" . $zip_file;
            // $stage_1_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_1'])->findAll();
            $stage_1_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_1'])->whereNotIn('required_document_id', [50])->findAll();
            foreach ($stage_1_documents as $stage_1_document) {
                $single_file_array = array();
                $single_file_array['document_path'] = $stage_1_document->document_path;
                $single_file_array['document_name'] = $stage_1_document->document_name;
                $all_file_array[] = $single_file_array;
            }
        } else if ($stage == "stage_2") {
            $zip_file = str_replace("stage_2", "Stage 2 - ", $stage) . "" . $name . ".zip";
            $zipname =  $target . "/" . $zip_file;
            // $stage_2_documents = $this->documents_model->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_2'])->find();
            $stage_2_documents = $this->documents_model->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_2'])->whereNotIn('required_document_id', [52,51])->findAll();

            foreach ($stage_2_documents as $key => $value) {
                 $value['document_path']= $value['document_path'];
                $array_path = explode("/", $value['document_path']);
                if (isset($array_path[4])) {
                    $company_folder_name = $array_path[4];
                    $single_file_array = array();
                    if ($company_folder_name == "assessment_documents") {
                        if($value['required_document_id'] ==16){
                           
                            $company_folder_name = "Supporting evidences for Application Kit";
                           // $value['document_path']=$value['document_path']."/Supporting evidences for Application Kit";

                        }
                        else{
                         $company_folder_name = "Assessment Documents";

                        }
                    }
                    $single_file_array['company_folder_name'] = $company_folder_name;
                    $single_file_array['document_path'] = $value['document_path'];
                    $single_file_array['document_name'] = $value['document_name'];
                    $all_file_array[] = $single_file_array;
                } else {
                    $single_file_array = array();
                    $single_file_array['company_folder_name'] = 'Additional Information';
                    $single_file_array['document_path'] = $value['document_path'];
                    $single_file_array['document_name'] = $value['document_name'];
                    $all_file_array[] = $single_file_array;
                }
            }


            // foreach ($stage_2_documents as $stage_2_document) {
            //     $single_file_array = array();
            //     $single_file_array['document_path'] = $stage_2_document['document_path'];
            //     $single_file_array['document_name'] = $stage_2_document['document_name'];
            //     $all_file_array[] = $single_file_array;
            // }
        } else if ($stage == "stage_3") {
            $zip_file = str_replace("stage_3", "Stage 3 - ", $stage) . "" . $name . ".zip";
            $zipname =  $target . "/" . $zip_file;
            $stage_3_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3'])->whereNotIn('required_document_id',[23,24,25,26])->findAll();
            // $stage_3_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3'])->findAll();
            foreach ($stage_3_documents as $stage_3_document) {
                $single_file_array = array();
                $single_file_array['document_path'] = $stage_3_document->document_path;
                $single_file_array['document_name'] = $stage_3_document->document_name;
                $all_file_array[] = $single_file_array;
            }
        } else if ($stage == "stage_3_R") {
            $zip_file = str_replace("stage_3_R", "Stage 3 (Reassessment) - ", $stage) . "" . $name . ".zip";
            $zipname =  $target . "/" . $zip_file;
            $stage_3_r_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3_R'])->whereNotIn('required_document_id',[23,24,25,26])->findAll();
            // $stage_3_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_3'])->findAll();
            foreach ($stage_3_r_documents as $stage_3_r_document) {
                $single_file_array = array();
                $single_file_array['document_path'] = $stage_3_r_document->document_path;
                $single_file_array['document_name'] = $stage_3_r_document->document_name;
                $all_file_array[] = $single_file_array;
            }
        } else if ($stage == "stage_4") {
            $zip_file = str_replace("stage_4", "Stage 4 - ", $stage) . "" . $name . ".zip";
            $zipname =  $target . "/" . $zip_file;
            // $stage_4_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_4'])->findAll();
            $stage_4_documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'status' => 1, 'stage' => 'stage_4'])->whereNotIn('required_document_id',[45,46,47,48])->findAll();
            foreach ($stage_4_documents as $stage_4_document) {
                $single_file_array = array();
                $single_file_array['document_path'] = $stage_4_document->document_path;
                $single_file_array['document_name'] = $stage_4_document->document_name;
                $all_file_array[] = $single_file_array;
            }
        }

        $zip = new ZipArchive;
        if ($zip->open($zipname, ZIPARCHIVE::CREATE | ZipArchive::OVERWRITE) === false) {
            die("An error occurred creating your ZIP file.");
        } else {
            if ($stage == "stage_2") {
                foreach ($all_file_array as $key => $value) {
                    $path =  $value['document_path'];
                    $document_name =  $value['document_name'];
                    // for folder data 
                    if (isset($value['company_folder_name'])) {
                        $company_folder_name =  $value['company_folder_name'];
                        $zip->addFile($path . "/" . $document_name, $company_folder_name . '/' . $document_name);
                    } else {
                        // for off folder data 
                        $zip->addFile($path . "/" . $document_name, $document_name);
                    }
                } // for loop
            } else {
                //  for stage 1 and stage 3 
                foreach ($all_file_array as $key => $value) {
                    $path =  $value['document_path'];
                    $document_name =  $value['document_name'];
                    if (!strpos($path, 'Photos_Videos')) {
                        if (!strpos($document_name, 'PV_')) {
                            // echo $path ."/". $document_name;
                            // echo $document_name;
                            $zip->addFile($path . "/" . $document_name, $document_name);
                        }
                    }
                    if ($stage == "stage_1") {
                        $zip->addFile($path . "/TRA Application Form.pdf", "TRA Application Form.pdf");
                    }
                    if (strpos($path, 'Photos_Videos')) {
                        if (strpos($document_name, 'PV_')) {
                            $zip->addFile($path . "/" . $document_name, "Photos_Videos/" . $document_name);
                        }
                    }
                }
            }
            $zip->close();
        }

        $zipname = str_replace("index.php/", "", $zipname);
        echo base_url() . "/" . $zipname;
    }


    // ---------------admin Application Manager -> documents ->stage 1 -> Verification Email - Qualification ---------------
    public function verify_email_stage_1()
    {
        $pointer_id = $this->request->getPost('pointer_id');
        $file = $this->request->getFile('file');

        $uploaded_filename =  $file->getName();
        $File_extention = $file->getClientExtension();
        $original_file_name = str_replace($uploaded_filename, 'Verification - Qualification.' . $File_extention, $uploaded_filename);
        $target = 'public/application/' . $pointer_id . '/stage_1';

        $file->move($target, $original_file_name, true);

        $addition_data = array(
            'pointer_id' => $pointer_id,
            'stage' => 'stage_1',
            'required_document_id' => 21,
            'name' => 'Verification - Qualification',
            'document_name' => $original_file_name,
            'document_path' => $target,
            'status' => 1,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' => date("Y-m-d H:i:s")
        );
        if ($this->documents_model->insert($addition_data)) {
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
    
 // --------------- 6 june 2023 akanksha ---------------
    public function check_extra_files(){
    $pointer_id = $this->request->getPost('pointer_id');            
    $extra_files = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 50,'stage' => 'stage_1'])->findAll();
        if($extra_files){
            $callback = array(
                "color" => "success",
                "msg" => "file uploaded succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "file not uploaded",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    
    }
    // ---------------admin Application Manager -> documents ->stage 1 ->upload extra file Qualification Verification ---------------
    public function qualification_verification_file()
    {        
        $pointer_id = $this->request->getPost('pointer_id');
        $files = $this->request->getFileMultiple('files');
        
        $database =0;
         $count = 1;
         $pass_data = [];
        if($this->request->getFileMultiple('files')[0]->getName()){
            foreach ($this->request->getFileMultiple('files') as $file){ 
                if ($file && $file->isValid()) {
                    $uploaded_filename =  $file->getName();
                    $File_extention = $file->getClientExtension();
                    $file_name = explode('.',$uploaded_filename);
                    $target = 'public/application/' . $pointer_id . '/stage_1';
                    $file->move($target, $uploaded_filename, true);
                    $addition_data = array(
                        'pointer_id' => $pointer_id,
                        'stage' => 'stage_1',
                        'required_document_id' => 50,
                        'employee_id' => 0,
                        'name' => $file_name[0],
                        'document_name' => $uploaded_filename,
                        'document_path' => $target,
                        'status' => 1,
                        'update_date' => date("Y-m-d H:i:s"),
                        'create_date' => date("Y-m-d H:i:s")
                    );
                    if ($this->documents_model->insert($addition_data)) {
                       $database = 1;
                       $lastInsertedId = $this->documents_model->insertID();
                        // $documentData = $this->documents_model->where('id',$lastInsertedId); // Assuming you have a method in the model to retrieve document data by ID
                        $pass_data[]= [
                        'id' =>$lastInsertedId,
                        'file_path' => $target . "/" . $uploaded_filename,
                        'file_name' => $uploaded_filename
                    ];
                    }
                }
            }
        }
        if ($database >= 1) {
            $callback = array(
                'document_ids'=>$pass_data,
                "color" => "success",
                "msg" => "file uploaded succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "file not uploaded",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    
        
    }
    // ---------------admin Application Manager -> documents ->stage 1 ->upload extra file Qualification Verification end ---------------
    // ---------------admin Application Manager -> documents ->stage 1 ->detete extra file Qualification Verification ----------------
    public function delete_file_qulifiaction_verfication()
    {
        $id = $this->request->getPost('document_id');
        $pass_data = [];
        $document = find_one_row("documents", "id", $id);
        $pointer_id = $document->pointer_id;
        $file = $document->document_path . '/' . $document->document_name;
        if($file){
        unlink($file);
        }
        if ($this->documents_model->where('id', $id)->delete()) {
            // $extra_doc = find_multiple_row_2_field('documents','pointer_id',$pointer_id,'required_document_id',50);
            // // print_r($extra_doc);
            // if($extra_doc){
            //     foreach($extra_doc as $doc){
            //         $pass_data[]= [
            //             'id' =>$doc->id,
            //             'file_path' => $doc->document_path . "/" . $doc->document_name,
            //             'file_name' => $doc->document_name
            //         ];
            //     }    
            // }
            $callback = array(
                'document_id'=>$id,
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
    
    // ---------------admin Application Manager -> documents ->stage 1 ->Send Email Qualification Verification ---------------
    
    public function qualification_verification_form()
    {
        $pointer_id = $this->request->getPost('pointer_id');
        $prn = portal_reference_no($pointer_id);
        $email_to = $this->request->getPost('email');
        $email_cc = $this->request->getPost('email_cc');
        $post_document_ids = $this->request->getPost('document_ids');
        // $file = $this->request->getFile('extra_file');
        // echo $prn;
        // exit;
        
        
        // call helper
         _check_email_exist_master("email_master",$email_to);
         foreach($email_cc as $email_cc_single){
             if($email_cc_single){ 
		        _check_email_exist_master("email_master",$email_cc_single);
             }
         }
        $addAttachment = [];
        // echo "SDSfds";
        $array_documnet_id = [];
        if($post_document_ids){
            foreach($post_document_ids as $document_id){
               $array_documnet_id[] = $document_id;
            }
        }
            // echo "fdzd";
            // if($file['error'] === UPLOAD_ERR_OK) {
        // if ($file && $file->isValid()) {

        // // if($file){
        //     // echo "sdvgdv";
        //     $uploaded_filename =  $file->getName();
        //     $File_extention = $file->getClientExtension();
        //     // $original_file_name = str_replace($uploaded_filename, 'Verification - Employment.' . $File_extention, $uploaded_filename);
        //     $target = 'public/application/' . $pointer_id . '/stage_1';
    
        //     $file->move($target, $uploaded_filename, true);
            
        //     $addition_data = array(
        //         'pointer_id' => $pointer_id,
        //         'stage' => 'stage_1',
        //         'required_document_id' => 50,
        //         'employee_id' => 0,
        //         'name' => 'Extra file with email qualification',
        //         'document_name' => $uploaded_filename,
        //         'document_path' => $target,
        //         'status' => 1,
        //         'update_date' => date("Y-m-d H:i:s"),
        //         'create_date' => date("Y-m-d H:i:s")
        //     );
        //     if ($this->documents_model->insert($addition_data)) {
        //         $lastInsertedId = $this->documents_model->insertID();
        //         // echo "Last inserted ID: " . $lastInsertedId;
        //         $array_documnet_id[] =  $lastInsertedId;
        //         $addAttachment[] =
        //             [
        //                 'file_path' => $target . "/" . $uploaded_filename,
        //                 'file_name' => $uploaded_filename
        //             ];
        //     }
            
        // }
        $user = find_one_row('application_pointer', 'id', $pointer_id);

        // email send data ------------
        $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '149'])->first();
        $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
        $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);
        $mail_check = 0;
        $database_check = 0;
            // email send ------------
            $subject = str_replace('%PRN%', $prn, $mail_subject);
            $message = $mail_body;
            $to = $email_to;
            // print_r($to);exit;
            if (isset($post_document_ids)) {
                foreach ($post_document_ids as $post_doc_id) {
                    $document = $this->documents_model->asObject()->where(['id' => $post_doc_id, 'stage' => 'stage_1'])->first();
                    if (!empty($document)) {
                        $document_name = $document->document_name;
                        $document_path = $document->document_path;
                        $file_name = $document->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] =
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                }
            }
            $extra_files = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 50,'stage' => 'stage_1'])->findAll();
            foreach ($extra_files as $extra_file) {
                if (!empty($extra_file)) {
                    $document_name = $extra_file->document_name;
                    $document_path = $extra_file->document_path;
                    $file_name = $extra_file->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                    $array_documnet_id[] = $extra_file->id;
                        $addAttachment[] =
                        [
                            'file_path' => $document_path . "/" . $document_name,
                            'file_name' => $document_name
                        ];
                    }
                }
            }
            $fix_document = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 6])->first();
            if (!empty($fix_document)) {
                $document_name = $fix_document->document_name;
                $document_path = $fix_document->document_path;
                $file_name = $fix_document->name;
                if (file_exists($document_path . "/" . $document_name)) {
                    $array_documnet_id[] = $fix_document->id;
                    $addAttachment[] = [
                        'file_path' => $document_path . "/" . $document_name,
                        'file_name' => $document_name
                    ];
                }
            }
            // print_r($array_documnet_id);
            // $result .= implode(', ', $array1);

            $string_documnet_ids = implode(', ', $array_documnet_id);
            $string_email_cc = implode(', ', $email_cc);
            $array_cc = explode(", ", $string_email_cc);  // Convert string to array
            $uniqueArray_cc = array_unique($array_cc);  // Remove duplicates from the array
            $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
            
            if(empty($string_email_cc)){
                // echo "fhfdh";
                $uniqueArray_cc = [];
            }
           
            $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $uniqueArray_cc, $addAttachment, $pointer_id);
            $database_entry = 0;
            if ($check == 1) {
                $data_verf = array(
                    'pointer_id' => $pointer_id,
                    'verification_type' => 'Verification - Qualification',
                    'verification_email_id' => $email_to,
                    'verification_email_subject' => $subject,
                    'email_cc_id'=>$unique_string_email_cc,
                    'verification_email_send' => 1,
                    'document_ids' => $string_documnet_ids,
                    'verification_email_send_date' => date("Y-m-d H:i:s"),
                    'update_date' => date("Y-m-d H:i:s"),
                    'create_date' => date("Y-m-d H:i:s")
                );
                // print_r($data_verf);
                // exit;
                if ($this->email_verification_model->insert($data_verf)) {
                    $database_entry = 1;
                }
            }// check email send
            if($database_entry ==1){
                $callback = array(
                    'mail_check' => $check,
                    'database_check' => $database_entry,
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
    
    
    
    public function qualification_verification_form_old()
    {
        $pointer_id = $this->request->getPost('pointer_id');
        $prn =portal_reference_no($pointer_id);
        $email_to = $this->request->getPost('email');
        $email_cc = $this->request->getPost('email_cc');
        $post_document_ids = $this->request->getPost('document_ids');
        // $file = $this->request->getFile('extra_file');
        // echo $prn;
        // exit;
        
        
        // call helper
         _check_email_exist_master("email_master",$email_to);
         foreach($email_cc as $email_cc_single){
             if($email_cc_single){ 
		        _check_email_exist_master("email_master",$email_cc_single);
             }
         }
        $addAttachment = [];
        // echo "SDSfds";
        $array_documnet_id = [];
        if($post_document_ids){
            foreach($post_document_ids as $document_id){
               $array_documnet_id[] = $document_id;
            }
        }
            // echo "fdzd";
            // if($file['error'] === UPLOAD_ERR_OK) {
        // if ($file && $file->isValid()) {

        // // if($file){
        //     // echo "sdvgdv";
        //     $uploaded_filename =  $file->getName();
        //     $File_extention = $file->getClientExtension();
        //     // $original_file_name = str_replace($uploaded_filename, 'Verification - Employment.' . $File_extention, $uploaded_filename);
        //     $target = 'public/application/' . $pointer_id . '/stage_1';
    
        //     $file->move($target, $uploaded_filename, true);
            
        //     $addition_data = array(
        //         'pointer_id' => $pointer_id,
        //         'stage' => 'stage_1',
        //         'required_document_id' => 50,
        //         'employee_id' => 0,
        //         'name' => 'Extra file with email qualification',
        //         'document_name' => $uploaded_filename,
        //         'document_path' => $target,
        //         'status' => 1,
        //         'update_date' => date("Y-m-d H:i:s"),
        //         'create_date' => date("Y-m-d H:i:s")
        //     );
        //     if ($this->documents_model->insert($addition_data)) {
        //         $lastInsertedId = $this->documents_model->insertID();
        //         // echo "Last inserted ID: " . $lastInsertedId;
        //         $array_documnet_id[] =  $lastInsertedId;
        //         $addAttachment[] =
        //             [
        //                 'file_path' => $target . "/" . $uploaded_filename,
        //                 'file_name' => $uploaded_filename
        //             ];
        //     }
            
        // }
        $user = find_one_row('application_pointer', 'id', $pointer_id);

        // email send data ------------
        $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '149'])->first();
        $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
        $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);
        $mail_check = 0;
        $database_check = 0;
            // email send ------------
            $subject = str_replace('%PRN%', $prn, $mail_subject);
            $message = $mail_body;
            $to = $email_to;
            if (isset($post_document_ids)) {
                foreach ($post_document_ids as $post_doc_id) {
                    $document = $this->documents_model->asObject()->where(['id' => $post_doc_id, 'stage' => 'stage_1'])->first();
                    if (!empty($document)) {
                        $document_name = $document->document_name;
                        $document_path = $document->document_path;
                        $file_name = $document->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] =
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                }
            }
            $extra_files = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 50,'stage' => 'stage_1'])->findAll();
            foreach ($extra_files as $extra_file) {
                if (!empty($extra_file)) {
                    $document_name = $extra_file->document_name;
                    $document_path = $extra_file->document_path;
                    $file_name = $extra_file->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                    $array_documnet_id[] = $extra_file->id;
                        $addAttachment[] =
                        [
                            'file_path' => $document_path . "/" . $document_name,
                            'file_name' => $document_name
                        ];
                    }
                }
            }
            $fix_document = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 6])->first();
            if (!empty($fix_document)) {
                $document_name = $fix_document->document_name;
                $document_path = $fix_document->document_path;
                $file_name = $fix_document->name;
                if (file_exists($document_path . "/" . $document_name)) {
                    $array_documnet_id[] = $fix_document->id;
                    $addAttachment[] = [
                        'file_path' => $document_path . "/" . $document_name,
                        'file_name' => $document_name
                    ];
                }
            }
            // print_r($array_documnet_id);
            // $result .= implode(', ', $array1);

            $string_documnet_ids = implode(', ', $array_documnet_id);
            $string_email_cc = implode(', ', $email_cc);
            $array_cc = explode(", ", $string_email_cc);  // Convert string to array
            $uniqueArray_cc = array_unique($array_cc);  // Remove duplicates from the array
            $unique_string_email_cc = implode(", ", $uniqueArray_cc);  // Convert array back to a string
            
            if(empty($string_email_cc)){
                // echo "fhfdh";
                $uniqueArray_cc = [];
            }
           
            $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $uniqueArray_cc, $addAttachment, $pointer_id);
            $database_entry = 0;
            if ($check == 1) {
                $data_verf = array(
                    'pointer_id' => $pointer_id,
                    'verification_type' => 'Verification - Qualification',
                    'verification_email_id' => $email_to,
                    'verification_email_subject' => $subject,
                    'email_cc_id'=>$unique_string_email_cc,
                    'verification_email_send' => 1,
                    'document_ids' => $string_documnet_ids,
                    'verification_email_send_date' => date("Y-m-d H:i:s"),
                    'update_date' => date("Y-m-d H:i:s"),
                    'create_date' => date("Y-m-d H:i:s")
                );
                // print_r($data_verf);
                // exit;
                if ($this->email_verification_model->insert($data_verf)) {
                    $database_entry = 1;
                }
            }// check email send
            if($database_entry ==1){
                $callback = array(
                    'mail_check' => $check,
                    'database_check' => $database_entry,
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
    
    public function edit_passpost_photo(){
        $pointer_id = $this->request->getPost('pointer_id');
        $document_id = $this->request->getPost('document_id');
        $document_old_name = $this->request->getPost('document_old_name');
        // echo "pointer_id".$pointer_id;
        // echo "document_id".$document_id;
        // echo "document_old_name".$document_old_name;
        // $required_id = $this->request->getPost('required_id');
        // $doc_name = $this->request->getPost('doc_name');
        $file = $this->request->getFile('file');
        
        $required_doc = find_one_row('required_documents_list','id',1);
        $database = 0;
        // if ($file && $file->isValid()) {
            $uploaded_filename =  $file->getName();
            $File_extention = $file->getClientExtension();
            $target = 'public/application/' . $pointer_id . '/stage_1';
            $original_file_name = str_replace($uploaded_filename, $required_doc->document_name.'.' . $File_extention, $uploaded_filename);
            $old_file = $target . '/' . $document_old_name;
            // if($document_old_name){
                unlink($old_file);
            // }
            $file->move($target, $original_file_name, true);

            $addition_data = array(
                'document_name' => $original_file_name,
                'status' => 1,
                'update_date' => date("Y-m-d H:i:s"),
            );
            // $this->stage_1_model->where(['pointer_id' => $pointer_id])->set(['allocate_team_member_name' => $team_id])->update();
                    // $update = $this->stage_3_model->where('pointer_id', $pointer_id)->set($data)->update();
            $update = $this->documents_model->where('id',$document_id)->set($addition_data)->update();
            if ($update) {
                // print_r($update);
            $callback = array(
                "color" => "success",
                "msg" => "file uploaded succesfully",
                "response" => true,
                'pointer_id' => $pointer_id,
            );
        } else {
            $callback = array(
                "msg" => "file not uploaded",
                "color" => "danger",
                "response" => false,
                'pointer_id' => $pointer_id,
            );
        }
        echo json_encode($callback);
    
    }
   
    // attc
    // ---------------admin Application Manager -> documents ->stage 2 -> Send -> Email to All Employees ---------------
     public function send_email_employ_stage_2()
    {
         $pointer_id = $this->request->getPost('pointer_id');
        $user = find_one_row('application_pointer', 'id', $pointer_id);
        $user_deitails = find_one_row('user_account','id',$user->user_id);
        
        
        // account_type = Agent 
        $account_type = $user_deitails->account_type;
  
       if($account_type == 'Applicant'){
            
        //Application mail sending
        $mail_temp_3_ = $this->mail_template_model->asObject()->where(['id' => '200'])->first();
        $mail_subject_ref = mail_tag_replace($mail_temp_3_->subject, $pointer_id);
        $mail_body_ref = mail_tag_replace($mail_temp_3_->body, $pointer_id);
        $employes_ref = find_one_row('stage_2_add_employment', 'pointer_id', $pointer_id);
        // bug $to_ref = $employes_ref->referee_email;
        $to_applicant = $user_deitails->email;
        $check_reff = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to_applicant, $mail_subject_ref, $mail_body_ref, [], [], [], []);
       }    
        
        ////Agent mail sending
         
        if($account_type == 'Agent'){
        
        $mail_temp_agent_ = $this->mail_template_model->asObject()->where(['id' => '199'])->first();
        $mail_subject_agent = mail_tag_replace($mail_temp_agent_->subject, $pointer_id);
        $mail_body_agent = mail_tag_replace($mail_temp_agent_->body, $pointer_id);
        $to_agent = $user_deitails->email;
        $check_agent = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to_agent, $mail_subject_agent, $mail_body_agent, [], [], [], []);
      }    
        
        

        // email send data ------------
        // s2_send_email_employee
        // $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '45'])->first();
        $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '102'])->first();
        $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
        $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);
        // echo $mail_subject;exit;
        $employes = find_multiple_rows('stage_2_add_employment', 'pointer_id', $pointer_id);
        
        $mail_check = 0;
        $database_check = 0;
        foreach ($employes as $employe) {
            // email send ------------
            $subject = str_replace('%add_employment_company_name%', $employe->company_organisation_name, $mail_subject);
            $message = str_replace('%add_employment_referee_name%', $employe->referee_name, $mail_body);
            $to = $employe->referee_email;
            
            $employe_id = $employe->id;
            $check_exist =    $this->email_verification_model->where(['verification_email_send' => 1, 'pointer_id' => $pointer_id, 'employer_id' => $employe->id])->first();
            if (empty($check_exist)) {
                $documents = $this->documents_model->asObject()->where(['employee_id' => $employe_id, 'pointer_id' => $pointer_id, 'required_document_id' => 10])->first();
                $addAttachment = [];
                if (!empty($documents)) {
                    $document_name = $documents->document_name;
                    $document_path = $documents->document_path;
                    $file_name = $documents->name;
                    if (file_exists($document_path . "/" . $document_name)) {
                        $addAttachment = array(
                            [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ]
                        );
                    }
                }
                $document_2 = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'required_document_id' => 6])->first();
                    if (!empty($document_2)) {
                        $document_name = $document_2->document_name;
                        $document_path = $document_2->document_path;
                        $file_name = $document_2->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] = [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                    
                // $document_3 = $this->documents_model->asObject()->where(['pointer_id' => $employe_id, 'required_document_id' => 35])->first();
                $document_3 = $this->documents_model->asObject()->where(['employee_id' => $employe_id, 'pointer_id' => $pointer_id, 'required_document_id' => 35])->first();

                    if (!empty($document_3)) {
                        $document_name = $document_3->document_name;
                        $document_path = $document_3->document_path;
                        $file_name = $document_3->name;
                        if (file_exists($document_path . "/" . $document_name)) {
                            $addAttachment[] = [
                                'file_path' => $document_path . "/" . $document_name,
                                'file_name' => $document_name
                            ];
                        }
                    }
                        
                $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment, $pointer_id);
                // echo $check;
                // exit;
                $currentDateTime = date("Y-m-d H:i:s");
                if ($check == 1) {
                    $mail_check++;
                    
                    $data = array(
                        'pointer_id' => $pointer_id,
                        'verification_type' => 'Verification - Employment',
                        'employer_id' => $employe->id,
                        'verification_email_id' => $employe->referee_email,
                        'verification_email_subject' => $subject,
                        'verification_email_send' => 1,
                        'verification_email_send_date' => date("Y-m-d H:i:s"),
                        'update_date' => date("Y-m-d H:i:s"),
                        'create_date' => date("Y-m-d H:i:s"),
                        'email_reminder_date' => $currentDateTime
                    );

                    if ($this->email_verification_model->insert($data)) {
                        $database_check++;
                    }
                } // check email send
                //this code by rohit 04oct
                $stage_2_reminder=find_one_row('stage_2', 'pointer_id', $pointer_id);
        //print_r($stage_2_reminder);
        //for update stage_2 1 refree
          if ($stage_2_reminder->email_reminder_date === null) {
           echo  $currentDateTime = date("Y-m-d H:i:s");
              $data = [
                    'email_reminder_date' => $currentDateTime,
                    
                  ];
                  
               $update_reminder =  $this->stage_2_model->where(['id' => $stage_2_reminder->id,'pointer_id'=>$pointer_id])->set($data)->update();
    
        }
            }
        } // loop

        // echo $mail_check;
        // echo $database_check;
        // exit;
        if ($mail_check > 0 || $database_check > 0) {
            $callback = array(
                'mail_check' => $mail_check,
                'database_check' => $database_check,
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
    // attc

    // ---------------admin Application Manager -> documents ->stage 2 -> Verification Email - Employment ---------------
    public function verify_email_stage_2()
    {
        $pointer_id = $this->request->getPost('pointer_id');
        $file = $this->request->getFile('file');

        $uploaded_filename =  $file->getName();
        $File_extention = $file->getClientExtension();
        $original_file_name = str_replace($uploaded_filename, 'Verification - Employment.' . $File_extention, $uploaded_filename);
        $target = 'public/application/' . $pointer_id . '/stage_2/assessment_documents';

        $file->move($target, $original_file_name, true);
        
        $addition_data = array(
            'pointer_id' => $pointer_id,
            'stage' => 'stage_2',
            'required_document_id' => 22,
            'employee_id' => 0,
            'name' => 'Verification - Employment',
            'document_name' => $original_file_name,
            'document_path' => $target,
            'status' => 1,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' => date("Y-m-d H:i:s")
        );
        // print_r($addition_data);
        // exit;
        if ($this->documents_model->insert($addition_data)) {
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
    // ---------------admin Applicant and Agent -> applicant name or agent company name -> Application Manager filter by user id---------------
    public function filter_company($id = "", $operation = "")
    {

        $user_id = $id;

        $data['page_name'] = 'Application Manager';

        $status_list = ['Start', 'Submitted', 'Lodged', 'In Progress', 'Scheduled', 'Conducted', 'Approved', 'Omitted', 'Declined', 'Withdrawn', 'Expired'];
        $data['org'] = $this->user_account_model->where("id", $user_id) ->orderBy('create_date', 'ASC') ->asObject() ->first();
        $org=$data['org'];
        // print_r($org);
        // exit;
        $data['page']=($org->business_name) ? ($org->business_name) : ($org->name." ".$org->last_name);
        $all_list = array();
        $application_pointer_model = $this->application_pointer_model->asObject()->orWhereIn('status', $status_list)->where("user_id", $user_id)->orderby('create_date', 'DESC')->findAll();

        $i = 0;
        $aaa = array();
        // echo $id.$operation;
        // exit;
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
            
            $show = true;
            if ($stage->stage == "stage_1") {
                if ($stage->status == "Start") {
                    $show = false;
                }
            }
            if ($show) {
                $i++;
                $asdasd = $stage->stage . " " . $stage->status;
                if (!in_array($asdasd, $aaa)) {

                    $aaa[] = $asdasd;
                }



                $list_array = array();

                $pointer_id = $stage->id;
                $list_array['pointer_id'] = $pointer_id;
                $list_array['team_member'] = $stage->team_member;
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
                if($Pathway == "Pathway 1"){
                    // Old Code Test going by Mohsin 
                    // if($list_array['occupation_name']=="Electrician (General)"||$list_array['occupation_name']=="Plumber (General)"){
                    //                 $list_array['Current_Status'] =create_status_format($stage_index);

                    // }
                    
                    $list_array['Current_Status'] =create_status_format($stage_index);
                }
                else{
                                    $list_array['Current_Status'] =  create_status_rename(create_status_format($stage_index), $user_id);

                    
                }
                

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
        }


        $data['all_list'] = $all_list;

    // print_r($data);
    // exit;

        return view('admin/application_manager/index', $data);
    }

    public function save_Assigned_Team_Member($pointer_id)
    {
        if (!empty($pointer_id)) {
            $team_id = $_POST['selectedValue'];
            echo $this->stage_1_model->where(['pointer_id' => $pointer_id])->set(['allocate_team_member_name' => $team_id])->update();
        }
    }
    public function exemption_form($pointer_id)
    
    {
        $data['title'] = "exemption form";
         return view('admin/application_manager/exemption_form', $data);

    }
    
     public function delete_stage_2($pointer_id)
    {
        $application =  $this->application_pointer_model->asObject()->where('id', $pointer_id)->first();
        $stage_2_add_employees = $this->stage_2_add_employment_model->asObject()->where('pointer_id', $pointer_id)->findAll();
        $update = false;
        // echo "<pre>";
        // print_r($stage_2_add_employees);
        // echo "<pre>";
        if(isset($stage_2_add_employees)){
            foreach($stage_2_add_employees as $employ){
                $company_organisation_name =  $employ->company_organisation_name;
                $company_organisation_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_organisation_name); // Removes special chars.
                $company_organisation_name = trim(str_replace(' ', '_', $company_organisation_name));
                $folderPath = 'public/application/' . $employ->pointer_id . '/stage_2/' . $company_organisation_name;
                // echo $folderPath;
                // echo "\n";
                if($this->stage_2_add_employment_model->where('id', $employ->id)->delete()){
                    // echo "stage_2_emplyment ".$employ->id." deleted";
                    // echo "\n";
                };
            }
        }
        $documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2'])->findAll();
        if(isset($documents)){
            foreach($documents as $document){
                $file = $document->document_path . '/' . $document->document_name;
                unlink($file);
                if($this->documents_model->where('id', $document->id)->delete()){
                    // echo "document ".$document->id." deleted";
                    // echo "\n";
                };
            }
        }
        $stage_2 = $this->stage_2_model->asObject()->where('pointer_id', $pointer_id)->first();
            if(isset($stage_2)){
                $folderPath = 'public/application/' . $pointer_id . '/stage_2';
                // echo $folderPath;
                // echo "\n";
                //     echo $folderPath;
                    // exit;

                if (is_dir($folderPath)) {
                    $folders = glob($folderPath . '/*', GLOB_ONLYDIR);
                
                    foreach ($folders as $folder) {
                        customDeleteDirectory($folder);
                    }
                
                    // Delete the main folder and its contents
                    customDeleteDirectory($folderPath);
                
                    // echo "Folders and their contents deleted.";
                } else {
                    // echo "Folder does not exist.";
                }
                
                function customDeleteDirectory($dir) {
                    if (!is_dir($dir)) {
                        return;
                    }
                
                    $files = glob($dir . '/*');
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        } elseif (is_dir($file)) {
                            customDeleteDirectory($file);
                        }
                    }
                
                    rmdir($dir);
                }

                if($this->stage_2_model->where('id', $stage_2->id)->delete()){
                    // echo "stage_2 ".$stage_2->id." deleted";
                    // echo "\n";
                };
            }
        $stage_1 = $this->stage_1_model->asObject()->where('pointer_id', $pointer_id)->first();
        $data = array(
            'stage' => 'stage_1',
            'status'=>$stage_1->status,
        );

        if($this->application_pointer_model->where('id', $pointer_id)->set($data)->update()){
            // echo "application_pointer ".$pointer_id." updated";
            // echo "\n";
            $update = true;
        };
        
        
        if($update){ 
           
           $callback = array(
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
            }
        echo json_encode($callback);
     
            
    }
     public function  upload_applicant(){

    

     $pointer_id = $this->request->getPost('pointer_id');
      $time_zone = $this->request->getPost('time_zone');
      $preference_location = "Online (Via Zoom)";//$this->request->getPost('preference_location');


         $file = $this->request->getFile('applicant_agent');


        

        $uploaded_filename =  $file->getName();

         $File_extention = $file->getClientExtension();
        
        
        $file_exemption_required = $this->required_documents_list_model->where(["stage" =>"stage_3",'category'=>'upload_documents','id'=>55])->first();
        
         $original_file_name = str_replace($uploaded_filename, 'Applicant_Agent_TI_Declaration.' . $File_extention, $uploaded_filename);

        echo $target = 'public/application/' . $pointer_id . '/stage_3/';
         
         $file->move($target, $original_file_name, true);
          


        $data = array(
            'applicant_agent_form' => $file_exemption_required["document_name"],
            'preference_location'=>$preference_location,
            'time_zone'=>$time_zone,
             'agent_applicant'=>'yes'
        );
        $update =   $this->stage_3_model->where('pointer_id', $pointer_id)->set($data)->update();
        // print_r($update);
        
        if($update) {
            $file_exemption_document = [
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3',
                'required_document_id' => $file_exemption_required['id'],
                'name' => $file_exemption_required["document_name"],
                'document_name' => $original_file_name,
                'document_path' => $target,
                'document_type' => '',
                'status' => 1
            ];
          $this->documents_model->insert($file_exemption_document);
            

            $callback = array(

                "color" => "success",

                "msg" => "file uploaded succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "mail not send",

            //     "color" => "danger",

            //     "response" => false,

            //     'pointer_id' => $pointer_id,

            // );

        }


   

}

public function  upload_applicant__(){

    

      $pointer_id = $this->request->getPost('pointer_id');
      $time_zone = $this->request->getPost('time_zone');
      $preference_location = "Online (Via Zoom)";//$this->request->getPost('preference_location');


         $file = $this->request->getFile('applicant_agent');


        

        $uploaded_filename =  $file->getName();

         $File_extention = $file->getClientExtension();
        
        
         $file_exemption_required = $this->required_documents_list_model->where(["stage" =>"stage_3",'category'=>'upload_documents','id'=>55])->first();
        
         

          $user_id = find_one_row('application_pointer','id',$pointer_id)->user_id;
                              //agent data fetch
                              $agent=find_one_row('user_account','id',$user_id);
                              $acount_type=$agent->account_type;
                              if($acount_type == 'applicant'){
                                  $name="Applicant TI Declaration";
                                 $name_ext="Applicant TI Declaration.";
                                  
                              }else{
                                   $name="Agent TI Declaration";
                                   $name_ext="Agent TI Declaration.";
                              }

    $original_file_name = str_replace($uploaded_filename,$name_ext.$File_extention, $uploaded_filename);
         $target = 'public/application/' . $pointer_id . '/stage_3_R/';
         $file->move($target, $original_file_name, true);
        $data = array(
            'applicant_agent_form' => $name,
            'preference_location'=>$preference_location,
            'time_zone'=>$time_zone,
            'agent_applicant'=>'yes'
        );
        $update =   $this->stage_3_reassessment_model->where('pointer_id', $pointer_id)->set($data)->update();
        // print_r($update);
        
        if($update) {
            $file_exemption_document = [
                'pointer_id' => $pointer_id,
                'stage' => 'stage_3_R',
                'required_document_id' => $file_exemption_required['id'],
                'name' => $name,
                'document_name' => $original_file_name,
                'document_path' => $target,
                'document_type' => '',
                'status' => 1
            ];
          $this->documents_model->insert($file_exemption_document);
            

            $callback = array(

                "color" => "success",

                "msg" => "file uploaded succesfully",

                "response" => true,

                'pointer_id' => $pointer_id,

            );
                    echo json_encode($callback);


        } else {

            // $callback = array(

            //     "msg" => "mail not send",

            //     "color" => "danger",

            //     "response" => false,

            //     'pointer_id' => $pointer_id,

            // );

        }


   

}

function delete_request_new($id){
    $pointer_id = $this->request->getPost('pointer_id');
    $is_additional_data =  $this->additional_info_request_model->where(['id'=>$id ,'status'=>'send'])->first();
    $admin_id =  session()->get('admin_id');
     $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
    if ($admin_ac->id == 1 || $admin_ac->id == 2) {
        $user_name = $admin_ac->first_name;
    } else {
        $user_name = $admin_ac->first_name . $admin_ac->last_name;
    }
    $reply_color = $this->request->getVar('reply_color');
    $color = $admin_ac->color;
    $profileimg_path = $admin_ac->profileimg_path;
      $data_insert = [
                    'message' => $is_additional_data['reason'],
                    'documents' => '',
                    'is_send_doc_request'=>'send',
                    'documents_path'=>'',
                    'pointer_id' => $pointer_id,
                    'admin_id' => $admin_id,
                    'user_name'=>$user_name,
                    'color'=>$color,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                         ];
    $insert = $this->notes->insert($data_insert);
    if($insert){
    $deleted = $this->additional_info_request_model->where('id',$id)->delete();
    }
    $json = [];
     $reload = false;
        $send = $this->additional_info_request_model->where(['pointer_id'=>$pointer_id ,'status'=>'send'])->find();
        if(empty($send)){
              $reload = true;
        }
    // end
    if ($deleted) {
        $json = ['status' => 1, 'message' => 'Record deleted successfully', 'reload' => $reload];
    } else {
        $json = ['status' => 0, 'message' => 'Failed to delete record', 'reload' => $reload];
    }
    echo json_encode($json);
}

function delete_additional_req_all($pointer_id){
    
    
    $is_additional_data_all = $this->additional_info_request_model->where('pointer_id',$pointer_id,'status','send')->orderBy('id', 'ASC')->findAll();
    foreach($is_additional_data_all as $is_additional_data){
        
    $admin_id =  session()->get('admin_id');
    $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
    if ($admin_ac->id == 1 || $admin_ac->id == 2) {
        $user_name = $admin_ac->first_name;
    } else {
        $user_name = $admin_ac->first_name . $admin_ac->last_name;
    }
    $reply_color = $this->request->getVar('reply_color');
    $color = $admin_ac->color;
    $profileimg_path = $admin_ac->profileimg_path;
      $data_insert = [
                    'message' => $is_additional_data['reason'],
                    'documents' => '',
                    'is_send_doc_request'=>'send',
                    'documents_path'=>'',
                    'pointer_id' => $pointer_id,
                    'admin_id' => $admin_id,
                    'user_name'=>$user_name,
                    'color'=>$color,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                         ];
    $insert = $this->notes->insert($data_insert);
    }
 
    $deleted = $this->additional_info_request_model->where('pointer_id', $pointer_id)->where('status', 'send')->delete();

    $json = [];
    if ($deleted) {
        $json = ['status' => 1, 'message' => 'Record deleted successfully'];
    } else {
        $json = ['status' => 0, 'message' => 'Failed to delete record'];
    }
    echo json_encode($json);
   }
   
   
   
     // by rohit
function chef_to_cook($pointer_id){
 $occupation_id=$this->request->getPost('occupation_id'); 
 $update=$this->stage_1_occupation_model->where('pointer_id',$pointer_id)->set('occupation_id',$occupation_id)->update();
  if($update){
      $json=[
          'response'=>'success'];
  }
  echo json_encode($json);
}   
function osap_to_tss($pointer_id){
 $program=$this->request->getPost('program'); 
  $update=$this->stage_1_occupation_model->where('pointer_id',$pointer_id)->set('program',$program)->update();
  if($update){
      $json=[
          'response'=>'success'];
  }
  echo json_encode($json);
} 
 function pathway_change($pointer_id){
 $pathway=$this->request->getPost('pathway'); 
 $stage=application_stage_no($pointer_id);
 $pathway_fetch=find_one_row('stage_1_occupation','pointer_id',$pointer_id)->pathway;
$json = [];
 $documents = $this->documents_model->asObject()->where('pointer_id', $pointer_id)->where('stage', 'stage_2')->whereIn('required_document_id',[16,30,34,53,56,57])->findAll();
if($documents){
foreach($documents as $documents_){
    if($pathway_fetch == 'Pathway 1'){
  $folder_path = 'public/application/' . $pointer_id . '/stage_2/assessment_documents/';
  $doc_name=$documents_->document_name;
  $file_path = $folder_path . $doc_name;
 if (file_exists($file_path)) {
        unlink($file_path);
        echo "File $doc_name removed successfully.";
    } else {
        echo "File $doc_name does not exist.";
    }
  $document_model = $this->documents_model ->where('pointer_id', $pointer_id)->where('stage','stage_2')->whereIn('required_document_id',[16,30,34,53,56,57])->delete();
  $update=$this->stage_1_occupation_model->where('pointer_id',$pointer_id)->set('pathway',$pathway)->update();
  $json=['response'=>'success'];
    }else{
     $update=$this->stage_1_occupation_model->where('pointer_id',$pointer_id)->set('pathway',$pathway)->update(); 
     $json=[
           'response'=>'success']; 
    }

}
}else{
    $update=$this->stage_1_occupation_model->where('pointer_id',$pointer_id)->set('pathway',$pathway)->update(); 
     $json=[
           'response'=>'success']; 
}
  echo json_encode($json);

}
      
      
      
      
      
      
      
  function notes($id){
          $tab = "view_edit"; 
     
          if ($tab == "view_edit") {
          $view_tab = "active";
          $document_tab = "";
          $btn_view = "btn_yellow_green";
          $btn_doc = "";
          $notes = "";
          $data = array();

   }      elseif ($tab == "all_documents") {
          $view_tab = "";
          $document_tab = "active";
          $btn_view = "";
          $btn_doc = "btn_green_yellow";
          $notes = "";
    } else {
          $notes = 'active';
          $view_tab = "";
          $document_tab = "";
          $btn_view = "";
          $btn_doc = "btn_green_yellow";
   }
          $data['tab'] = $tab;
          $data['view_tab'] = $view_tab;
          $data['document_tab'] = $document_tab;
          $data['btn_view'] = $btn_view;
          $data['btn_doc'] = $btn_doc;
          $data['notes'] = $notes;
    
     return view('admin/application_manager/view_application/notes',$data);  
   }

   
    //for insert notes  
 function for_insert_notes_documents($message, $pointer_id) {
    $admin_id =  session()->get('admin_id');
    $admin_ac = $this->admin_account_model->where('id', $admin_id)->get()->getRow();
    $user_name = ($admin_ac->id == 1) ? $admin_ac->first_name : $admin_ac->first_name . " " . $admin_ac->last_name;
    $color = $admin_ac->color; 
    // echo "edkjfbskhjfvgkhdscf";
    // die;
    $data_insert = [
        'message' => $message,
        'pointer_id' => $pointer_id,
        'is_send_doc_request'=>'send',
        'admin_id' => $admin_id,
        'user_name' => $user_name,
        'color' => $color,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];
    //  print_r($data_insert);
    //  die;
     $insert = $this->notes->insert($data_insert);
}
 


}

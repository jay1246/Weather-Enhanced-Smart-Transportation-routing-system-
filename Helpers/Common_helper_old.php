<?php


//-------------- flag ------------- stage ---------- aditional requst check
function s1_Additional_Info($user_id, $application_id)
{
    $db = db_connect();
    $requst_file_count = 0;
    $all_list_array = array();
    $file = array();

    // stage 1 uploaded file
    $reason_for_delete = $db->table('reason_for_delete')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
    foreach ($reason_for_delete as $key => $value) {
        if ($value['user_action'] == 0) {
            $singal_file = array();
            $singal_file['file'] = $value['deleted_document_name'];
            $singal_file['reason'] = $value['reason'];
            $file[] = $singal_file;
            $requst_file_count++;
        } else {
        }
    }


    // stage 1 admin requst to  agent for other file upload 
    $request_additional_information = $db->table('request_additional_information')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
    foreach ($request_additional_information as $key => $value) {
        if ($value['new_file_request'] == 1) {
            $singal_file = array();
            $singal_file['file'] = 'Additional Information';
            $singal_file['reason'] = $value['reason'];
            $file[] = $singal_file;
            // $file[] = 'Additional Information';
            $requst_file_count++;
        } else {
        }
    }


    if ($requst_file_count == 0) {
        $reason_for_delete = $db->table('reason_for_delete')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
        foreach ($reason_for_delete as $key => $value) {
            if ($value['user_action'] == 0) {
            } elseif (!empty($value['deleted_document_name'])) {
                $singal_file = array();
                $singal_file['file'] = $value['deleted_document_name'];
                $singal_file['reason'] = $value['reason'];
                $file[] = $singal_file;
            }
        }

        $request_additional_information = $db->table('request_additional_information')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
        foreach ($request_additional_information as $key => $value) {
            if ($value['new_file_request'] == 1) {
            } else {
                if (!empty($value['document_name'])) {
                    $singal_file = array();
                    $singal_file['file'] = $value['document_name'];
                    $singal_file['reason'] = $value['reason'];
                    $file[] = $singal_file;
                }
            }
        }
    }




    $all_list_array['file_name'] = $file;
    $all_list_array['requst_file_count'] = $requst_file_count;
    return json_encode($all_list_array);
}

function s2_Additional_Info($user_id, $application_id)
{
    $db = db_connect();
    // stage 2 uploaded file
    $requst_file_count = 0;
    $all_list_array = array();
    $file = array();

    $employer_documents = $db->table('employer_documents')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
    foreach ($employer_documents as $key => $value) {
        if ($value['new_file_request'] == 1) {
            $singal_file = array();
            $singal_file['file'] = $value['document_name'];
            $singal_file['reason'] = $value['reason'];
            $file[] = $singal_file;
            $requst_file_count++;
        } else {
        }
    }


    // stage 2 employ upload file 
    $stage_2_documents = $db->table('stage_2_documents')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
    foreach ($stage_2_documents as $key => $value) {
        if ($value['new_file_request'] == 1) {
            $singal_file = array();
            $singal_file['file'] =  $value['employer_name'] . ":- " . $value['document_name'];
            $singal_file['reason'] = $value['reason'];
            $file[] = $singal_file;
            $requst_file_count++;
        } else {
        }
    }


    // stage 2 admin requst to  agent for other file upload 
    $request_additional_information = $db->table('request_additional_information')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
    foreach ($request_additional_information as $key => $value) {
        if ($value['new_file_request'] == 1) {
            // $file[] = $value['document_name'];
            $singal_file = array();
            $singal_file['file'] = 'Additional Information';
            $singal_file['reason'] = $value['reason'];
            $file[] = $singal_file;
            $requst_file_count++;
        } else {
        }
    }


    if ($requst_file_count == 0) {
        $employer_documents = $db->table('employer_documents')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
        foreach ($employer_documents as $key => $value) {
            if ($value['new_file_request'] == 1) {
            } else {
                if (!empty($value['user_role'])) {
                    $singal_file = array();
                    $singal_file['file'] =  $value['document_name'];
                    $singal_file['reason'] = $value['reason'];
                    $file[] = $singal_file;
                }
            }
        }

        $stage_2_documents = $db->table('stage_2_documents')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
        foreach ($stage_2_documents as $key => $value) {
            if ($value['new_file_request'] == 1) {
            } else {
                if (!empty($value['user_role'])) {
                    $singal_file = array();
                    $singal_file['file'] =  $value['employer_name'] . ":- " . $value['document_name'];
                    $singal_file['reason'] = $value['reason'];
                    $file[] = $singal_file;
                }
            }
        }

        $request_additional_information = $db->table('request_additional_information')->where(['user_id' => $user_id, 'application_id' => $application_id])->get()->getresultarray();
        foreach ($request_additional_information as $key => $value) {
            if ($value['new_file_request'] == 1) {
            } else {
                if (!empty($value['user_role'])) {
                    $singal_file = array();
                    $singal_file['file'] =   $value['document_name'];
                    $singal_file['reason'] = $value['reason'];
                    $file[] = $singal_file;
                }
            }
        }
    }


    $all_list_array['file_name'] = $file;
    $all_list_array['requst_file_count'] = $requst_file_count;

    return json_encode($all_list_array);
}







function add_employers_where($user_id, $application_id)
{
    $db = db_connect();
    $add_employers_where = $db->table('add_employers')->where(['user_id' => $user_id, 'application_id' => $application_id])->orderby('id', 'DESC')->get()->getresultarray();
    return $add_employers_where;
}
function check_company_file_uploadded_if_its_delet($user_id, $application_id, $employer_name)
{
    $db = db_connect();
    $stage_2_documents = $db->table('stage_2_documents')->where(['user_id' => $user_id, 'application_id' => $application_id, 'employer_name' => $employer_name])->orderby('id', 'DESC')->get()->getrowarray();
    if (empty($stage_2_documents)) {
        return true;
    } else {
        return false;
    }
}

function get_data($table, $application_id, $user_id)
{

    $db = db_connect();
    $query = "select * from " . $table . " where application_id = " . $application_id . " and user_id = " . $user_id . " ";
    $sql = $db->query($query);
    $res = $sql->getRow();
    return  $res;
}

function isComplete($table, $application_id, $user_id)
{

    $db = db_connect();
    $query = "select status from " . $table . " where application_id = " . $application_id . " and user_id = " . $user_id . " order by id desc limit 1";
    $sql = $db->query($query);
    $res = $sql->getRow();


    if ($res != "") {
        $status = $res->status;
    } else {
        $status  = 0;
    }
    return $status;
    // echo  $db->getLastQuery();
}



// ---------for admin --------- key is column name and value is user id






function findReviewisDownload($user_id, $application_id)
{
    $db = db_connect();
    $query = "select * from education_and_employment where user_id = " . $user_id . " and application_id = '" . $application_id . "'";
    $sql = $db->query($query);
    $res = $sql->getRow();
    if ($res->is_downloaded != "") {
        $output = 1;
    } else {
        $output = 0;
    }
    return $output;
}
function findStageData($table, $user_id, $application_id)
{
    $db     = db_connect();
    $query = "select * from " . $table . " where user_id = " . $user_id . " and application_id = " . $application_id;
    // echo $query;
    // exit;
    $sql = $db->query($query);
    return $sql->getRow();
}

function findEveryData($table, $key, $value)
{
    $db = db_connect();
    $query = "select * from " . $table . " where " . $key . " = '" . $value . "' order by " . $key . " desc limit 1";
    $sql = $db->query($query);
    $res = $sql->getRow();
    return $res;
}




function preDownload($user_id, $application_id)
{
    $db = db_connect();
    $query = "select * from uploaded_documents where user_id = " . $user_id . " and application_id = " . $application_id;

    $sql = $db->query($query);
    $res = $sql->getResult();
    return $res;
    // foreach ($res as $document) {
    //     // echo $document->path . "<br>";
    //     // echo $document->doc_image . "<br>";
    //     _Download(base_url() . "/" . $document->path, $document->doc_image);
    //     // echo $return;
    // }
    // sql foreach -> location / file_name
    // _Download(location, fname);
}
function _Download($f_location, $f_name)
{
    $File = $f_location . "/" . $f_name;
    // echo $File;
    // exit;
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($File) . '"');
    header('Content-Transfer-Encoding: binary');
    readfile($File);
    // $file = uniqid() . basename($f_name);
    // // $file = "";
    // file_put_contents($file, file_get_contents($f_location));

    // header('Content-Description: File Transfer');
    // header('Content-Type: application/octet-stream');
    // header('Content-Length: ' . filesize($file));
    // header('Content-Disposition: attachment; filename=' . basename($f_name));

    // readfile($file);
    // exit;
}



function find_dob($table, $feild_name, $value)
{
    $db = db_connect();
    $query = "select * from " . $table . " where " . $feild_name . " = '" . $value . "'";
    $sql = $db->query($query);
    $res = $sql->getRow();
    return $res;
}


// --------for admin dashboard----------

function submitted_list($table, $feild, $user_id)
{
    $db = db_connect();
    $query = "select * from " . $table . " where " . $feild . " = '" . $user_id . "'";
    $sql = $db->query($query);
    $res = $sql->getRow();
    return $res;
}

function delete_notice($table, $application_id, $user_id) //when deleting any doc from admin the user get notice of deleted documents 
{

    $db = db_connect();
    $query = "select * from " . $table . " where " . $user_id . " = '" . $application_id . "'";
    $sql = $db->query($query);
    $res = $sql->getResult();
    return $res;
}

function testing($data)
{
    return $data;
}

// ---------for admin --------- 


function Find_All_Data($table, $feild, $value, $app, $app_id)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $feild . " = '" . $value . "' " . "and " . $app . "='" . $app_id . "'";
    $sql = $db->query($query);
    $res = $sql->getResultArray();
    return $res;
}

function helpmeinOccupation($occupation)
{
    $db     =   db_connect();
    $sql    =   "select * from avilable_slots where occupation like '" . $occupation . "'";
    $res    =   $db->query($sql);
    return $res->getResult();
}

function stage3interview($occupation)
{
    $db = db_connect();
    $sql = "select * from avilable_slots where occupation = '" . $occupation . "'";
    $res = $db->query($sql);
    return $res->getResult();
}

function stage3interview_temp($occupation)
{
    $db = db_connect();
    $sql = "select * from avilable_slots where temp='1' and occupation = '" . $occupation . "'";
    $res = $db->query($sql);
    return $res->getResult();
}

function findDataByTable($table)
{

    $db = db_connect();
    $sql = "select * from " . $table;
    $res = $db->query($sql);
    return $res->getResult();
}




// new use in MVC 
function Applicant_Declaration($ENC_pointer_id, $colum_name)
{

    $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    $db = db_connect();
    $agent_details = $db->table('stage_1_review_confirm')->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->get()->getrowarray();

    if (!empty($agent_details)) {
        if ($colum_name == "review_confirm_pdf_download") {
            $check = $agent_details['review_confirm_pdf_download'];
            if (!empty($check)) {
                return 1;
            } else {
                return 0;
            }
        } else if ($colum_name == "applicant_declaration_file_download") {
            $file_1 = $agent_details['information_release_file_download'];
            $file_2 = $agent_details['applicant_declaration_file_download'];
            if (!empty($file_1) && !empty($file_2)) {
                return 1;
            } else {
                return 0;
            }
        }
    } else {
        return 0;
    }
    return 0;
}

// new use in MVC 
function Stepper_isComplete($table, $ENC_pointer_id)
{
    $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    $db = db_connect();
    $query = "select status from " . $table . " where pointer_id = " . $pointer_id . " order by id desc limit 1";
    $sql = $db->query($query);
    $res = $sql->getRow();

    if ($res != "") {
        $status = $res->status;
    } else {
        $status  = 0;
    }

    return $status;
    // echo  $db->getLastQuery();
}

// new use in MVC 
function Stepper_Applicant_Declaration($ENC_pointer_id, $colum_name)
{
    $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    //Helper call 

    $db = db_connect();
    $agent_details = $db->table('stage_1_review_confirm')->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->get()->getrowarray();

    if (!empty($agent_details)) {
        if ($colum_name == "review_confirm_pdf_download") {
            $check = $agent_details['review_confirm_pdf_download'];
            if (!empty($check)) {
                return 1;
            } else {
                return 0;
            }
        } else if ($colum_name == "applicant_declaration_file_download") {
            $file_1 = $agent_details['information_release_file_download'];
            $file_2 = $agent_details['applicant_declaration_file_download'];
            if (!empty($file_1) && !empty($file_2)) {
                return 1;
            } else {
                return 0;
            }
        }
    } else {
        return 0;
    }
    return 0;
}


// new use in MVC 
function helper_Stepper($ENC_pointer_id, $table_name)
{
    $db = db_connect();

    $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    //Helper call 
    $pointer_data = get_User_ApplicationID($pointer_id);
    if (!empty($pointer_data)) {


        $agent_details = $db->table($table_name)->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->get()->getrowarray();

        // return $agent_details;
        // Applicant_Declaration
        // Review_Confirm

        // $data_file_download = Applicant_Declaration(session()->get('user_id'), session()->get('application_id'));
        if (!empty($agent_details)) {
            $check = $agent_details['status'];
            if (!empty($check)) {
                return 1;
                echo "not empty";
            } else {
                return 0;
                echo "empty";
            }
        } else {
            return 0;
        }
    } else {
        return 0;
        // session()->setFlashdata('error_msg', 'Sorry! Invalid Application ID');
        // return redirect()->to(base_url("user/dashboard"));
    }
    return 0;
}

// new use in MVC 
function get_User_ApplicationID($pointer_id)
{
    $db = db_connect();
    $sql = "select * from application_pointer where id = " . $pointer_id;
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (count($data)) {
        return $data;
    } else {
        return "";
    }
}

// new use in MVC 
function get_PointerID($user_id, $application_id)
{
    // $user_id = 23;
    // $application_id = 232;

    $db = db_connect();
    $sql = "select * from application_pointer where user_id = " . $user_id . " and application_id = " . $application_id;
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (count($data)) {
        return $data;
    } else {
        return "";
    }
}

// new use in MVC 
function pointer_id_encrypt($pointer_id)
{
    $encrypter = \Config\Services::encrypter();
    $encrypt = 'awqinnVishaljd' . $pointer_id . 'asTdsa';
    $encrypt = urlencode(bin2hex($encrypter->encrypt($encrypt)));
    return $encrypt;
}

// new use in MVC 
function pointer_id_decrypt($pointer_id)
{
    $encrypter = \Config\Services::encrypter();
    try {
        $decrypt =  $encrypter->decrypt(hex2bin(urldecode($pointer_id)));
        $decrypt = str_replace("awqinnVishaljd", "", $decrypt);
        $decrypt = str_replace("asTdsa", "", $decrypt);
        return $decrypt;
    } catch (Exception $e) {
        header('Location:' . base_url());
    }
}



// new use in MVC 
function is_Applicant()
{
    $Applicant_ = false;
    if (session()->get('account_type') == "Applicant") {
        $Applicant_ = true;
    }
    return $Applicant_;
}
// new use in MVC 
function is_Agent()
{
    $Agent_ = false;
    if (session()->get('account_type') == "Agent") {
        $Agent_ = true;
    }
    return $Agent_;
}

// new use in MVC 
function clean_URL($string)
{
    // $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    $string =  preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.

    return $string;
}


//stage 1 upload docs
function check_document_uploaded($stage, $pointer_id, $required_document_id)
{
    // return json_encode($stage . '_' . $pointer_id . '_' . $required_document_id);
    $db = db_connect();
    $sql = "select * from documents where stage like '" . $stage . "' and pointer_id = " . $pointer_id . " and required_document_id = " . $required_document_id;
    $res = $db->query($sql);

    return $res->getResultArray();
    // return $res->getRowArray();
}

// new use in MVC 
function application_stage_no($pointer_id)
{
    // stage_1 = 1 to 10  index 
    // stage_2 = 11 to 20  index
    // stage_3 = 21 to 30  index

    $db = db_connect();
    $sql = "select * from application_pointer where id = " . $pointer_id;
    $res = $db->query($sql);
    $row = $res->getRowArray();
    $stage_index = 0;
    if (!empty($row)) {
        $stage = $row['stage'];
        $status = $row['status'];
        if ($stage == "stage_1" && $status == "Start") {
            $stage_index = 1;
        } else if ($stage == "stage_1" && $status == "Submitted") {
            $stage_index = 2;
        } else  if ($stage == "stage_1" && $status == "Lodged") {
            $stage_index = 3;
        } else  if ($stage == "stage_1" && $status == "In Progress") {
            $stage_index = 4;
        } else  if ($stage == "stage_1" && $status == "Approved") {
            $stage_index = 5;
        } else  if ($stage == "stage_1" && $status == "Declined") {
            $stage_index = 6;
        } else  if ($stage == "stage_1" && $status == "Withdrawn" || $status == "Withdrawal") {
            $stage_index = 7;
        } else  if ($stage == "stage_1" && $status == "Reinstate") {
            $stage_index = 8;
        } else  if ($stage == "stage_1" && $status == "Expired") {
            $stage_index = 9;
        } else if ($stage == "stage_2" && $status == "Start") {
            $stage_index = 11;
        } else if ($stage == "stage_2" && $status == "Submitted") {
            $stage_index = 12;
        } else  if ($stage == "stage_2" && $status == "Lodged") {
            $stage_index = 13;
        } else  if ($stage == "stage_2" && $status == "In Progress") {
            $stage_index = 14;
        } else  if ($stage == "stage_2" && $status == "Approved") {
            $stage_index = 15;
        } else  if ($stage == "stage_2" && $status == "Declined") {
            $stage_index = 16;
        } else  if ($stage == "stage_2" && $status == "Withdrawn" || $status == "Withdrawal") {
            $stage_index = 17;
        } else  if ($stage == "stage_2" && $status == "Reinstate") {
            $stage_index = 18;
        } else if ($stage == "stage_3" && $status == "Start") {
            $stage_index = 21;
        } else if ($stage == "stage_3" && $status == "Submitted") {
            $stage_index = 22;
        } else  if ($stage == "stage_3" && $status == "Lodged") {
            $stage_index = 23;
        } else  if ($stage == "stage_3" && $status == "In Progress") {
            $stage_index = 24;
        } else  if ($stage == "stage_3" && $status == "Scheduled") {
            $stage_index = 25;
        } else  if ($stage == "stage_3" && $status == "Conducted") {
            $stage_index = 26;
        } else  if ($stage == "stage_3" && $status == "Approved") {
            $stage_index = 27;
        } else  if ($stage == "stage_3" && $status == "Declined") {
            $stage_index = 28;
        } else  if ($stage == "stage_3" && $status == "Withdrawn" || $status == "Withdrawal") {
            $stage_index = 29;
        } else  if ($stage == "stage_1" && $status == "Archive") {
            $stage_index = 102;
        }
    }
    return $stage_index;
}

// new use in MVC 
function create_status_rename($name)
{
    // || $name == "S1 - Expired"
    // return $name;
    if ($name == "S1 - Declined" || $name == "S1 - Withdrawn"  || $name == "S2 - Declined"  || $name == "S2 - Withdrawn") {
        return "Closed";
    } else  if ($name == "S3 - Approved"   || $name == "S3 - Declined" || $name == "S3 - Withdrawn") {
        return "Completed";
    } else  if ($name == "S3 - Start") {
        return "S2 - Approved";
    } else  if ($name == "S2 - Start") {
        return "S1 - Approved";
    } else {
        return $name;
    }
}


function create_status_format($stage_index)
{
    $status_format = "";
    if ($stage_index == 2) {
        $status_format = "S1 - Submitted";
    } else  if ($stage_index == 3) {
        $status_format = "S1 - Lodged";
    } else  if ($stage_index == 4) {
        $status_format = "S1 - In Progress";
    } else  if ($stage_index == 5) {
        $status_format = "S1 - Approved";
    } else  if ($stage_index == 6) {
        $status_format = "S1 - Declined";
    } else  if ($stage_index == 7) {
        $status_format = "S1 - Withdrawn";
    } else  if ($stage_index == 8) {
        $status_format = "S1 - Reinstate";
    } else  if ($stage_index == 9) {
        $status_format = "S1 - Expired";
    } else  if ($stage_index == 11) {
        $status_format = "S2 - Start";
    } else  if ($stage_index == 12) {
        $status_format = "S2 - Submitted";
    } else  if ($stage_index == 13) {
        $status_format = "S2 - Lodged";
    } else  if ($stage_index == 14) {
        $status_format = "S2 - In Progress";
    } else  if ($stage_index == 15) {
        $status_format = "S2 - Approved";
    } else  if ($stage_index == 16) {
        $status_format = "S2 - Declined";
    } else  if ($stage_index == 17) {
        $status_format = "S2 - Withdrawn";
    } else  if ($stage_index == 18) {
        $status_format = "S2 - Reinstate";
    } else  if ($stage_index == 21) {
        $status_format = "S3 - Start";
    } else  if ($stage_index == 22) {
        $status_format = "S3 - Submitted";
    } else  if ($stage_index == 23) {
        $status_format = "S3 - Lodged";
    } else  if ($stage_index == 24) {
        $status_format = "S3 - In Progress";
    } else  if ($stage_index == 25) {
        $status_format = "S3 - Scheduled";
    } else  if ($stage_index == 26) {
        $status_format = "S3 - Conducted";
    } else  if ($stage_index == 27) {
        $status_format = "S3 - Approved";
    } else  if ($stage_index == 28) {
        $status_format = "S3 - Declined";
    } else  if ($stage_index == 29) {
        $status_format = "S3 - Withdrawn";
    } else  if ($stage_index == 102) {
        $status_format = "S1 - Archive";
    } else {
        $status_format = "--//--";
    }
    return $status_format;
}

// new use in MVC 
function documents_info($pointer_id, $id)
{
    $db = db_connect();
    $sql = "select * from documents where id = '" . $id . "' and pointer_id = '" . $pointer_id . "'";
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (!empty($data) && count($data)) {
        return $data;
    } else {
        return "";
    }
}

// new use in MVC 
function required_documents_info($id)
{
    $db = db_connect();
    $sql = "select * from required_documents_list where id = '" . $id . "'";
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (!empty($data) && count($data)) {
        return $data;
    } else {
        return "";
    }
}

// new use in MVC 
function stage_2_employment_info($id)
{
    $db = db_connect();
    $sql = "select * from stage_2_add_employment where id = '" . $id . "'";
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (!empty($data) && count($data)) {
        return $data;
    } else {
        return "";
    }
}



// new use in MVC 
function get_unique_number($pointer_id)
{
    $db = db_connect();
    $sql = "select * from stage_1 where pointer_id = '" . $pointer_id . "'";
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (!empty($data) && count($data)) {
        if (empty($data['unique_id'])) {
            $id =  "[#T.B.A]";
        } else {
            $id =  "[#" . $data['unique_id'] . "]";
        }
    } else {
        $id = "[#T.B.A]";
    }

    return $id;
}


function application_mo($pointer_id)
{
    $db = db_connect();
    $sql = "select * from stage_1 where pointer_id = '" . $pointer_id . "'";
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (!empty($data) && count($data)) {
        if (empty($data['unique_id'])) {
            $id =  "[#T.B.A]";
        } else {
            $id =  "[#" . $data['unique_id'] . "]";
        }
    } else {
        $id = "[#T.B.A]";
    }

    return $id;
}

function portal_reference_no($pointer_id)
{
    $db = db_connect();
    $sql1 = "select * from application_pointer where id = '" . $pointer_id . "'";
    $res1 = $db->query($sql1);
    $data1 = $res1->getRowArray();
    if (!empty($data1['application_number'])) {
        $id = $data1['application_number'];
    } else {
        $id =  "AQ_____";
    }

    return $id;
}



function helper_get_applicant_full_name($ENC_pointer_id)
{

    $pointer_id = pointer_id_decrypt($ENC_pointer_id);

    $db = db_connect();
    $agent_details = $db->table('stage_1_personal_details')->where(['pointer_id' => $pointer_id])->orderby('id', 'DESC')->get()->getrowarray();
    $preferred_title = $agent_details['preferred_title'] . " ";
    $first_or_given_name = $agent_details['first_or_given_name'] . " ";
    $middle_names = $agent_details['middle_names'] . " ";
    $surname_family_name = $agent_details['surname_family_name'];
    //$full_name = $preferred_title . $first_or_given_name . $middle_names . $surname_family_name;
    $full_name = $first_or_given_name . $middle_names . $surname_family_name;

    echo " (" . $full_name . ") ";
}


// page end-------------------------



//------------
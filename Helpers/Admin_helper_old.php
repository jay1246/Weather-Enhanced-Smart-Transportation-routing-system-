<?php
// ---------for admin --------- 

function stage_1_expired_day($pointer_id)
{
    $db = db_connect();
    $sql = "select * from stage_1 where pointer_id = " . $pointer_id;
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (count($data)) {
        $expiry_date = $data['expiry_date'];
        $Todays_date = strtotime(date('Y-m-d'));
        $approved_date_temp = strtotime($expiry_date);
        $timeleft = $Todays_date - $approved_date_temp;
        $day_remain = round((($timeleft / 86400)));
        return $day_remain = 30 - $day_remain;
    }
    return 0;
}
function check_stage_3($pointer_id)
{
    $db = db_connect();
    $query = "SELECT * FROM `stage_3` WHERE pointer_id =".$pointer_id." ORDER BY `id`  DESC";
    $sql = $db->query($query);
    return $sql->getRow();
}

function is_Agent_Applicant($pointer_id)
{
    $db = db_connect();
    $sql = "select * from application_pointer where id = " . $pointer_id;
    $res = $db->query($sql);
    $data = $res->getRowArray();
    if (count($data)) {
        $user_id = $data['user_id'];
        $sql = "select * from user_account where id = " . $user_id;
        $res = $db->query($sql);
        $data = $res->getRowArray();
        if (count($data)) {
            return  trim($data['account_type']);
        } else {
            return "";
        }
    } else {
        return "";
    }
}

function get_tb($table)
{
    $db = db_connect();
    $query = "select * from " . $table;
    $sql = $db->query($query);
    return  $sql->getResultarray();
}

function get_allocate_team_member_name($id)
{
    $db = db_connect();
    $query = "select * from allocate_team_member_name where id = " . $id;
    $sql = $db->query($query);
    return  $sql->getRow();
}

function find_one_row($table, $field, $value)
{
    $db = db_connect();
    $query = "select * from " . $table . " where " . $field . " = '" . $value . "'ORDER BY " . $table . ".`id` DESC";
    $sql = $db->query($query);
    return  $sql->getRow();
}
function find_multiple_rows($table, $field, $value)
{
    $db = db_connect();
    $query = "select * from " . $table . " where " . $field . " = '" . $value . "'ORDER BY " . $table . ".`id` DESC";
    $sql = $db->query($query);
    return  $sql->getResult();
}
function find_one_row_2_field($table, $field, $value, $field_2, $value_2)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $field . " = '" . $value . "' " . "and " . $field_2 . "='" . $value_2 . "'";
    $sql = $db->query($query);
    return $sql->getRow();
}

function find_multiple_row_2_field($table, $field, $value, $field_2, $value_2)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $field . " = '" . $value . "' " . "and " . $field_2 . "='" . $value_2 . "'";
    $sql = $db->query($query);
    return  $sql->getResult();
}
function find_multiple_row_3_field($table, $field, $value, $field_2, $value_2, $field_3, $value_3)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $field . " = '" . $value . "' " . "and " . $field_2 . "='" . $value_2 . "'" . "and " . $field_3 . "='" . $value_3 . "'";
    $sql = $db->query($query);
    return  $sql->getResult();
}
//  admin ->application_manger

function stage_status_app_mag($stage_tab, $field_1, $val_1, $field_2, $val_2, $field_3, $val_3)
{
    $db = db_connect();
    if ($stage_tab == 3) {
        $sql = "select * from " . $field_3 . " where " . $field_1 . "=" . $val_1 . " and " . $field_2 . "=" . $val_2 . " ORDER BY " . $val_3 . "  DESC";
        //    print_r($sql);
    } elseif ($stage_tab == 2) {
        $sql = "select * from stage_2_submitted_documents where " . $field_2 . "=" . $val_2 . " and " . $field_3 . "=" . $val_3 . " and " . $field_1 . " IN ('" . $val_1[0] . "','" . $val_1[1] . "','" . $val_1[2] . "','" . $val_1[3] . "')";
    } else {
        $sql = "select * from " . $stage_tab . " where " . $field_1 . "=" . $val_1 . " and " . $field_2 . "=" . $val_2 . " and " . $field_3 . "=" . $val_3;
        //    echo $sql;
    }
    $res = $db->query($sql);
    // return $res->getResult();
    return $res->getRow();
}
function occupation_saq_app_thir($val_offline)
{
    //    count($val);
    $db = db_connect();
    //   SELECT * FROM `occupation_file` WHERE id NOT IN (58,43);";
    $sql = "SELECT * FROM `occupation_list` WHERE id NOT IN (SELECT occupation_id FROM `offline_file` where use_for='" . $val_offline . "') and status ='active'";
    // print_r($sql);
    // exit;
    $res = $db->query($sql);
    return $res->getResult();
}
function mail_name()
{
    $db = db_connect();
    $sql = "SELECT * FROM `mail_template_name_keyword` WHERE id NOT IN (SELECT name FROM `mail_template`)";
    $res = $db->query($sql);
    return $res->getResult();
}

function country_phonecode($id)
{
    $db = db_connect();
    $sql = "SELECT * FROM `country` WHERE id = $id";
    $res = $db->query($sql);
    $data = $res->getRow();
    if (isset($data) && !empty($data)) {
        return $data->phonecode;
    } else {
        return "";
    }
}

function mail_tag_replace($mail_text, $pointer_id)
{
    $s1_personal_details = find_one_row('stage_1_personal_details', 'pointer_id', $pointer_id);
    $application_pointer =  find_one_row('application_pointer', 'id', $pointer_id);
    $user_account = find_one_row('user_account', 'id', $application_pointer->user_id);

    $s1_occupation = find_one_row('stage_1_occupation', 'pointer_id', $pointer_id);
    $occupation_list = find_one_row('occupation_list', 'id',  $s1_occupation->occupation_id);

    $stage_1 = find_one_row('stage_1', 'pointer_id', $pointer_id);
    $stage_2 = find_one_row('stage_2', 'pointer_id', $pointer_id);
    $stage_3 = find_one_row('stage_3', 'pointer_id', $pointer_id);

    $signature_mail = find_one_row('mail_template', 'name', '18');
    $aqato_signature = $signature_mail->body;

    if ($s1_occupation->pathway == "Pathway 1") {
        $pathway = "P1";
    } else {
        $pathway = "P2";
    }

    // stage 3 
    $stage_3_interview_booking = find_one_row('stage_3_interview_booking', 'pointer_id', $pointer_id);
    if (isset($stage_3_interview_booking->location_id)) {
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
        if (!empty($date_time_zone)) {
            if (!empty($date_time)) {
                $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
                $date->setTimezone(new DateTimeZone($date_time_zone));
                $s3_interview_time_B = $date->format('h:i A') . " (" . $date_time_zone . " Time)";
            }
        }

        $mail_text = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $mail_text);
        $mail_text = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $mail_text);
        $mail_text = str_replace('%s3_interview_venue%', $s3_interview_venue, $mail_text);
        $mail_text = str_replace('%s3_interview_address%', $s3_interview_address, $mail_text);
    }


    // $mail_text = str_replace('%occupation_reason_for_decline_stage_1%', isset($stage_1->declined_reason) ? $stage_1->declined_reason : "", $mail_text);
    // $mail_text = str_replace('%occupation_reason_for_decline_stage_2%', isset($stage_2->declined_reason) ? $stage_2->declined_reason : "", $mail_text);
    // $mail_text = str_replace('%occupation_reason_for_decline_stage_3%', isset($stage_3->declined_reason) ? $stage_3->declined_reason : "", $mail_text);
// if(isset($stage_3)){
//     if(!empty($stage_3)){
//         $mail_text = str_replace('%preference_location%', $stage_3->preference_location, $mail_text);
//     $mail_text = str_replace('%time_zone%', $stage_3->time_zone, $mail_text);
//     $mail_text = str_replace('%preference_comment%', $stage_3->preference_comment, $mail_text);

//     }
    
 
// }


//  $mail_text = str_replace('%preference_location%', $stage_3->preference_location, $mail_text);
//     $mail_text = str_replace('%time_zone%', $stage_3->time_zone, $mail_text);
//     $mail_text = str_replace('%preference_comment%', $stage_3->preference_comment, $mail_text);

    $mail_text = str_replace('%personal_details_first_name%',trim($s1_personal_details->first_or_given_name)." ", $mail_text);
    $mail_text = str_replace('%personal_details_middle_name%', trim($s1_personal_details->middle_names)." ", $mail_text);
    $mail_text = str_replace('%personal_details_surname_name%', trim($s1_personal_details->surname_family_name), $mail_text);

    $mail_text = str_replace('%email_first_name%', $user_account->name, $mail_text);
    $mail_text = str_replace('%email_surname_name%',  $user_account->last_name, $mail_text);

    $mail_text = str_replace('%occupation_occupation%', $occupation_list->name, $mail_text);
    $mail_text = str_replace('%occupation_program%', $s1_occupation->program, $mail_text);

    $mail_text = str_replace('%pathway%', $pathway, $mail_text);

    $mail_text = str_replace('[#%unique_id%]', (!empty($stage_1->unique_id) ? "[#" . $stage_1->unique_id . "]" : ""), $mail_text);
    $mail_text = str_replace('%unique_id%', (!empty($stage_1->unique_id) ? "[#" . $stage_1->unique_id . "]" : ""), $mail_text);

    $mail_text = str_replace('%email_signature%', $aqato_signature, $mail_text);
    
    return $mail_text;
}


function countries()
{
    $db = db_connect();
    $sql = "SELECT DISTINCT country FROM `stage_3_offline_location` ORDER BY `stage_3_offline_location`.`country` ASC;";
    $res = $db->query($sql);
    return $res->getResult();
}

function assessment_documents($value)
{
    $db = db_connect();
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and ( employee_id=0 or  employee_id is NULL) AND required_document_id IN (15, 34,22,30, 21)";
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}


function supporting_documents($value)
{
    $db = db_connect();
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and  required_document_id=16";
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}


function Additional_Information_docs($value)
{
    $db = db_connect();
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and required_document_id=17";
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}


function Assissment_docs_($docid)
{
    $db = db_connect();
    echo $query = "SELECT * FROM `additional_info_request` where support_evidance_status is Null AND document_id=".$docid;
    // die;
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getRowArray();
}


// ---------------admin Applicant and Agent -> applicant name or agent company name -> Application Manager filter by user id---------------

function filter_company($id)
{
    $db = db_connect();
    $query =  "SELECT * FROM `stage_1` WHERE status IS NOT NULL and id IN (SELECT id FROM `application_pointer` where user_id =" . $id . ") ORDER BY `pointer_id` ASC";
    // print_r($query);
    $sql = $db->query($query);
    //  print_r($sql);
    // exit;
    return  $sql->getResult();
}

<?php

// 

function getOccupationID($pointer_id, $is_encrypted = "no"){
    if($is_encrypted == "yes"){
        $pointer_id = pointer_id_decrypt($pointer_id);
    }
    $db = db_connect();
    $query = "SELECT occupation_id FROM `stage_1_occupation` where pointer_id = ".$pointer_id;
    $sql = $db->query($query);
    $row = $sql->getRowarray();
    return $row["occupation_id"];
    
}

// 


function getTheCurrentMessageStatusThere($pointer_id){
    
    $stage_1_comment = getTheStageCommentBystage($pointer_id, "stage_1");
    if($stage_1_comment){
        return $stage_1_comment;
    }
    
    
    $stage_2_comment = getTheStageCommentBystage($pointer_id, "stage_2");
    if($stage_2_comment){
        return $stage_2_comment;
    }
    
    
    $stage_3_comment = getTheStageCommentBystage($pointer_id, "stage_3");
    if($stage_3_comment){
        return $stage_3_comment;
    }
    
    return "";
    
}

function getTheStageCommentBystage($pointer_id, $stage){
    
    $db = db_connect();
    // $query = "SELECT approved_comment FROM ".$stage." where pointer_id = ".$pointer_id." and approved_date >= '2024-03-09'";
    $query = "SELECT approved_comment FROM ".$stage." where pointer_id = ".$pointer_id;
    $sql = $db->query($query);
    $row = $sql->getRowarray();
    if($row){
        return $row["approved_comment"];
    }
}


function getTheSkillsBCCMember($pointer_id){
    
    if(!trim($pointer_id)){
        return '';
    }
    
    $db = db_connect();
    $query = "SELECT * FROM `application_pointer` where id = ".$pointer_id;
    $sql = $db->query($query);
    $row = $sql->getRowarray();
    $email = "";
    if($row["team_member"] != 0 && $row["team_member"] != 1){
        $query = "SELECT * FROM `admin_account` where id = ".$row["team_member"];
        $sql = $db->query($query);
        $row = $sql->getRowarray();
        $email = $row["email"];
    }
    
    return $email;
}


function getTheAbsoluteTeamMemberID(){
    
    $db = db_connect();
    $query = "SELECT * FROM `config` where type = 'allocation_team_cycle'";
    $sql = $db->query($query);
    $row = $sql->getRowarray();
    // print_r($row);
    $user_account_id = $row["data"];
    
    // Data
    $query = "SELECT * FROM `admin_account` where id <> 1 and account_type = 'admin' and status = 'active' and id > ".$user_account_id." limit 1";
    $sql = $db->query($query);
    $row = $sql->getRowarray();
    // Restrat the Rows
    if(!$row){
        // Data
        $query = "SELECT * FROM `admin_account` where id <> 1 and account_type = 'admin' and status = 'active' and id > 1 limit 1";
        $sql = $db->query($query);
        $row = $sql->getRowarray();
    }
    
    
    $query = "Update `config` set data=".$row["id"]." where type = 'allocation_team_cycle'";
    $sql = $db->query($query);
    
    return $row["id"];
}

function getTheTeamMemberNameTBA($team_member){
    // echo $team_member;
    $default_inital = "[T.B.A]";
    $full_name = "";
    if($team_member != 0){
        $user_allocated = find_one_row("admin_account", "id", $team_member);
        // print_r(count($user_allocated));
        // exit;
        if($user_allocated){
            if(!$user_allocated->inital_name){
                $default_inital = substr($user_allocated->first_name, 0 ,1);
                if($user_allocated->last_name){
                    $default_inital .= strtoupper(substr($user_allocated->last_name, 0 ,1));
                }
                else{
                    $default_inital = strtoupper(substr($user_allocated->first_name, 0 ,2));
                }
            }
            else{
                $default_inital = $user_allocated->inital_name;
            }
            $full_name = $user_allocated->first_name." ".$user_allocated->last_name;
        }
    }
    return "<span data-bs-toggle='tooltip' title='".$full_name."'>".$default_inital."</span>";
}

function getTheAccounts($role){
    
    $db = db_connect();
    $query = "select * from admin_account where status = 'active' and account_type = '".$role."'";
    $sql = $db->query($query);
    return  $sql->getResultarray();
}

function getTheAccountsForAdmin($role){
    
    $db = db_connect();
    $query = "select * from admin_account where account_type = '".$role."'";
    $sql = $db->query($query);
    return  $sql->getResultarray();
}

// ---------for admin --------- 


function __getFromToDate(){

    $s_currentDate = date("Y-m-")."01";
    $s_currentDate = date("Y-m-t", strtotime($s_currentDate." -1 month"));
    
    $e_currentDate = date("Y-m-t");
    $e_currentDate = date("Y-m-d", strtotime($e_currentDate." +1 day"));
    
    $data["s_date"] = $s_currentDate;
    $data["e_date"] = $e_currentDate;

    return $data;
}

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
function stage_1_expired_day_new($pointer_id)
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
        return $day_remain = 0 - $day_remain;
    }
    return 0;
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


function _check_email_exist_master($table,$email_to)
{
    $db = db_connect();
    $query = "select * from ". $table." where email ='".$email_to."'";
    $sql = $db->query($query);
    if ($sql->getNumRows() == 0) {
     $query_insert = "INSERT INTO $table (`email`) VALUES ('$email_to')";
     $db->query($query_insert);
  }

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
function find_one_row_2_field_for_flag($table, $field, $value, $field_2, $value_2)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $field . " = '" . $value . "' " . "and " . $field_2 . "='" . $value_2 . "'ORDER BY " . $table . ".`status` ASC";
    $sql = $db->query($query);
    return $sql->getRow();
}

function find_one_row_2_field_for_flag_pagination($table, $field, $value, $field_2, $value_2)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $field . " = '" . $value . "' and " . $field_2 . "='" . $value_2 . "' and status <> 'verified' ORDER BY " . $table . ".status ASC";
    // exit;
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
function find_one_row_3_field($table, $field, $value, $field_2, $value_2, $field_3, $value_3)
{
    $db = db_connect();
    $query =  "select * from " . $table . " where " . $field . " = '" . $value . "' " . "and " . $field_2 . "='" . $value_2 . "'" . "and " . $field_3 . "='" . $value_3 . "'";
    // echo $query;exit;
    $sql = $db->query($query);
    return  $sql->getRow();
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
function check_stage_user_side($stage,$pointer_id)
{
    $db = db_connect();
    $query = "SELECT * FROM `".$stage."` WHERE pointer_id =".$pointer_id." ORDER BY `id`  DESC";
    $sql = $db->query($query);
    return $sql->getRow();
}

function check_stage_4($pointer_id)
{
    $db = db_connect();
    $query = "SELECT * FROM `stage_4` WHERE pointer_id =".$pointer_id." ORDER BY `id`  DESC";
    $sql = $db->query($query);
    return $sql->getRow();
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
    $stage_3_r = find_one_row('stage_3_reassessment', 'pointer_id', $pointer_id);
    $stage_4 = find_one_row('stage_4', 'pointer_id', $pointer_id);

    $signature_mail = find_one_row('mail_template', 'name', '18');
    $aqato_signature = $signature_mail->body;

    if ($s1_occupation->pathway == "Pathway 1") {
        $pathway = "P1";
    } else {
        $pathway = "P2";
    }


// $stage_4_practical_booking=find_one_row('stage_4_practical_booking', 'pointer_id', $pointer_id);
// echo $application_pointer->stage;
// exit;
    if($application_pointer->stage == "stage_3_R"){
        $stage_3_reassessment_interview_booking = find_one_row('stage_3_reassessment_interview_booking', 'pointer_id', $pointer_id);
        if (isset($stage_3_reassessment_interview_booking->location_id)) {
            $stage_3_offline_location_id = (isset($stage_3_reassessment_interview_booking->location_id)) ? $stage_3_reassessment_interview_booking->location_id : "Null";
            $date_time = (isset($stage_3_reassessment_interview_booking->date_time)) ? $stage_3_reassessment_interview_booking->date_time : "";
    
            $s3_interview_day_and_date = "";
            $s3_interview_time_A = "";
            if (!empty($date_time)) {
                $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
                $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
            }
    
            $stage_3_offline_location = find_one_row('stage_3_offline_location', 'id', $stage_3_offline_location_id);
            if ($stage_3_offline_location_id == 9) {
                $date_time_zone = (isset($stage_3_reassessment_interview_booking->time_zone)) ? $stage_3_reassessment_interview_booking->time_zone : "";
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

    }else{
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
    
            $mail_text = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $mail_text);
            $mail_text = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $mail_text);
            $mail_text = str_replace('%s3_interview_venue%', $s3_interview_venue, $mail_text);
            $mail_text = str_replace('%s3_interview_address%', $s3_interview_address, $mail_text);
        }
    }

    // $mail_text = str_replace('%occupation_reason_for_decline_stage_1%', isset($stage_1->declined_reason) ? $stage_1->declined_reason : "", $mail_text);
    // $mail_text = str_replace('%occupation_reason_for_decline_stage_2%', isset($stage_2->declined_reason) ? $stage_2->declined_reason : "", $mail_text);
    // $mail_text = str_replace('%occupation_reason_for_decline_stage_3%', isset($stage_3->declined_reason) ? $stage_3->declined_reason : "", $mail_text);s
    
    
    //stage 4 mail tags
//     if(!empty($stage_4)){
//     if(!empty($stage_4_practical_booking)){
//       if (isset($stage_4_practical_booking->location_id)) {
//         $stage_4_offline_location_id = (isset($stage_4_practical_booking->location_id)) ? $stage_4_practical_booking->location_id : "Null";
//         $date_time = (isset($stage_4_practical_booking->date_time)) ? $stage_4_practical_booking->date_time : "";

//         $s4_practical_day_and_date = "";
//         $s4_practical_time_A = "";
//         if (!empty($date_time)) {
//             $s4_practical_day_and_date = date('l, jS F Y', strtotime($date_time));
//             $s4_practical_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
//         }

//         $s4_date_time_zone="Australia/Brisbane";
//         $s4_practical_time_B = "";
//         if (!empty($date_time_zone)) {
//             if (!empty($date_time)) {
//                 $date = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
//                 $date->setTimezone(new DateTimeZone($date_time_zone));
//                 $s3_practical_time_B = $date->format('h:i A') . " (" . $s4_date_time_zone . " Time)";
//             }
//         }

//         $mail_text = str_replace('%s4_practical_day_and_date%', $s4_practical_day_and_date, $mail_text);
//         $mail_text = str_replace('%s4_practical_time%', $s4_practical_time_A . " / " . $s4_practical_time_B, $mail_text);
       
//     }
//     }
// } //stage 4
// echo $application_pointer->stage;
//  if($application_pointer->stage == 'stage_3'){
     if(!$stage_4){
if(isset($stage_3)){
    if(!empty($stage_3)){
        $mail_text = str_replace('%preference_location%', $stage_3->preference_location, $mail_text);
    $mail_text = str_replace('%time_zone%', $stage_3->time_zone, $mail_text);
    $mail_text = str_replace('%preference_comment%', $stage_3->preference_comment, $mail_text);

    }
} 
 
}


//  $mail_text = str_replace('%preference_location%', $stage_3->preference_location, $mail_text);
//     $mail_text = str_replace('%time_zone%', $stage_3->time_zone, $mail_text);
//     $mail_text = str_replace('%preference_comment%', $stage_3->preference_comment, $mail_text);

        if($s1_personal_details->middle_names){
            $middle_name = $s1_personal_details->middle_names;
        }else{
            $middle_name = "";
        }
    $mail_text = str_replace('%personal_details_first_name%',trim($s1_personal_details->first_or_given_name," ")." ", $mail_text);
    // if($s1_personal_details->middle_names){
    $mail_text = str_replace('%personal_details_middle_name%', trim($middle_name)." ", $mail_text);
    // }
    $mail_text = str_replace('%personal_details_surname_name%', trim($s1_personal_details->surname_family_name," "), $mail_text);
    $mail_text = str_replace('  ', " ", $mail_text);
    
    $mail_text = str_replace('%email_first_name%', $user_account->name, $mail_text);
    $mail_text = str_replace('%email_surname_name%',  $user_account->last_name, $mail_text);

    $mail_text = str_replace('%occupation_occupation%', $occupation_list->name, $mail_text);
    $mail_text = str_replace('%occupation_program%', $s1_occupation->program, $mail_text);

    $mail_text = str_replace('%pathway%', $pathway, $mail_text);

    $mail_text = str_replace('[#%unique_id%]', (!empty($stage_1->unique_id) ? "[#" . $stage_1->unique_id . "]" : ""), $mail_text);
    $mail_text = str_replace('%unique_id%', (!empty($stage_1->unique_id) ? "[#" . $stage_1->unique_id . "]" : ""), $mail_text);
    $mail_text = str_replace('%prn_no%', $application_pointer->application_number, $mail_text);


    // berupiya find ------------------------------
    // 
    // 
    // Ignore CODE
    
    // $mail_text = str_replace('%email_signature%', $aqato_signature, $mail_text);
    
    
    //$aqato_email_signature='<div style="font-family: Arial, Helvetica, sans-serif;"><span id="docs-internal-guid-a55a4f32-7fff-89fd-d652-8c89da4febd6"><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Dilpreet Singh Bagga</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Director (AQATO)</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(M): +61-401200991</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">--</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">ATTC/AQATO India Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Office No. S-04, Regus Harmony, Level 4, Tower-A, Godrej Eternia,</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Plot Number 70, Industrial Area 1, Chandigarh - 160002</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +91-172-4071505 (M): +91-9888286702</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><br></span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">ATTC Australia Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">294 Scarborough Road, Scarborough, QLD - 4020</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +61-7-3414 5908 (F): +61-7-3880 4339</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><br></span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">AQATO Australia Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">13 Villellla Drive, Pakenham, VIC - 3810</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +61-3-59184617 (M): +61-401200991</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.attc.org.au" style="background-color: rgb(255, 255, 255);"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;"><br></span></a></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.attc.org.au" style="background-color: rgb(255, 255, 255);"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">www.attc.org.au</span></a><br></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.aqato.com.au" style="text-decoration: none;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">www.aqato.com.au</span></a></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; color: rgb(51, 122, 183); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;"><span style="border: none; display: inline-block; overflow: hidden; width: 319px; height: 313px;"><img src="https://attc.aqato.com.au/public/Logos/Aqato_logo.png" width="319" height="313" style="margin-left: 0px; margin-top: 0px;"></span></span></p><pre style="font-family: var(--bs-font-monospace); margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><span id="docs-internal-guid-b296c628-7fff-4b72-8d6f-5552d91f4e2a"><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><b style="font-weight:normal;" id="docs-internal-guid-f1581e39-7fff-3061-9190-6c78ceee0d68"><br></b></p><p dir="ltr" style="line-height:2.38464;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial, Helvetica, sans-serif;color:#000000;background-color:#ffffff;font-weight:700;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Disclaimer :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"></p><p dir="ltr" style="line-height:2.38464;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial, Helvetica, sans-serif;color:#afb5b9;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">This email is intended only for the person(s) named in the message header. Unless otherwise indicated, it contains information that is confidential, privileged and/or exempt from disclosure under applicable law. If you have received this message in error, please notify the sender of the error and delete the message.</span></p></span></pre></span></div>';
     $aqato_email_signature='<img src="https://attc.aqato.com.au/public/Logos/Aqato_logo.png" width="120px" height="50px" style="margin-left: 0px; margin-top: 0px;">';

    // $attc_email_signature='<div style="font-family: Arial, Helvetica, sans-serif;"><span id="docs-internal-guid-a55a4f32-7fff-89fd-d652-8c89da4febd6"><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Dilpreet Singh Bagga</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Director (AQATO)</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(M): +61-401200991</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">--</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">ATTC/AQATO India Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Office No. S-04, Regus Harmony, Level 4, Tower-A, Godrej Eternia,</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Plot Number 70, Industrial Area 1, Chandigarh - 160002</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +91-172-4071505 (M): +91-9888286702</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><br></span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">ATTC Australia Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">294 Scarborough Road, Scarborough, QLD - 4020</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +61-7-3414 5908 (F): +61-7-3880 4339</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><br></span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">AQATO Australia Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">13 Villellla Drive, Pakenham, VIC - 3810</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +61-3-59184617 (M): +61-401200991</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.attc.org.au" style="background-color: rgb(255, 255, 255);"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;"><br></span></a></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.attc.org.au" style="background-color: rgb(255, 255, 255);"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">www.attc.org.au</span></a><br></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.aqato.com.au" style="text-decoration: none;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">www.aqato.com.au</span></a></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; color: rgb(51, 122, 183); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;"><span style="border: none; display: inline-block; overflow: hidden; width: 319px; height: 313px;"><img src="https://attc.aqato.com.au/public/Logos/ATTC_logo.png" width="319" height="313" style="margin-left: 0px; margin-top: 0px;"></span></span></p><pre style="font-family: var(--bs-font-monospace); margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><span id="docs-internal-guid-b296c628-7fff-4b72-8d6f-5552d91f4e2a"><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><b style="font-weight:normal;" id="docs-internal-guid-f1581e39-7fff-3061-9190-6c78ceee0d68"><br></b></p><p dir="ltr" style="line-height:2.38464;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial, Helvetica, sans-serif;color:#000000;background-color:#ffffff;font-weight:700;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Disclaimer :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"></p><p dir="ltr" style="line-height:2.38464;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial, Helvetica, sans-serif;color:#afb5b9;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">This email is intended only for the person(s) named in the message header. Unless otherwise indicated, it contains information that is confidential, privileged and/or exempt from disclosure under applicable law. If you have received this message in error, please notify the sender of the error and delete the message.</span></p></span></pre></span></div>';
    $attc_email_signature='<img src="https://attc.aqato.com.au/public/Logos/ATTC_logo.png"  width="120px" height="50px" style="margin-left: 0px; margin-top: 0px;">';
    $attc_banner_email_signature='<div style="font-family: Arial, Helvetica, sans-serif;"><span id="docs-internal-guid-a55a4f32-7fff-89fd-d652-8c89da4febd6"><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Dilpreet Singh Bagga</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Director (AQATO)</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(M): +61-401200991</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">--</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">ATTC/AQATO India Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Office No. S-04, Regus Harmony, Level 4, Tower-A, Godrej Eternia,</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">Plot Number 70, Industrial Area 1, Chandigarh - 160002</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +91-172-4071505 (M): +91-9888286702</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><br></span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">ATTC Australia Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">294 Scarborough Road, Scarborough, QLD - 4020</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +61-7-3414 5908 (F): +61-7-3880 4339</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;"><br></span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">AQATO Australia Office :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">13 Villellla Drive, Pakenham, VIC - 3810</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; vertical-align: baseline; white-space: pre-wrap;">(P): +61-3-59184617 (M): +61-401200991</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.attc.org.au" style="background-color: rgb(255, 255, 255);"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;"><br></span></a></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.attc.org.au" style="background-color: rgb(255, 255, 255);"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">www.attc.org.au</span></a><br></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><a href="https://attc.aqato.com.au/admin/mail_template/edit/www.aqato.com.au" style="text-decoration: none;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">www.aqato.com.au</span></a></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12pt; color: rgb(51, 122, 183); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;"><span style="border: none; display: inline-block; overflow: hidden; width: 319px; height: 313px;"><img src="https://attc.aqato.com.au/public/Logos/Attc_banner.png" width="319" height="313" style="margin-left: 0px; margin-top: 0px;"></span></span></p><pre style="font-family: var(--bs-font-monospace); margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><span id="docs-internal-guid-b296c628-7fff-4b72-8d6f-5552d91f4e2a"><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"><b style="font-weight:normal;" id="docs-internal-guid-f1581e39-7fff-3061-9190-6c78ceee0d68"><br></b></p><p dir="ltr" style="line-height:2.38464;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial, Helvetica, sans-serif;color:#000000;background-color:#ffffff;font-weight:700;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Disclaimer :</span></p><p dir="ltr" style="margin-top: 0pt; margin-bottom: 0pt; line-height: 1.9872;"></p><p dir="ltr" style="line-height:2.38464;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10pt;font-family:Arial, Helvetica, sans-serif;color:#afb5b9;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">This email is intended only for the person(s) named in the message header. Unless otherwise indicated, it contains information that is confidential, privileged and/or exempt from disclosure under applicable law. If you have received this message in error, please notify the sender of the error and delete the message.</span></p></span></pre></span></div>';
    
    // berupiya find ------------------------------
    // 
    // 
    // Ignore CODE
    
    // $mail_text = str_replace('%email_signature_Team_AQATO_Admin%', $aqato_email_signature, $mail_text);
    // $mail_text = str_replace('%email_signature_Team_ATTC_Admin%', $attc_email_signature, $mail_text);
    $mail_text = str_replace('%attc_banner_email_signature%', $attc_banner_email_signature, $mail_text);


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
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and ( employee_id=0 or  employee_id is NULL) AND required_document_id IN (15,16,22,30,34,53,17)";
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}
function assessment_documents_($value)
{
    $db = db_connect();
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and ( employee_id=0 or  employee_id is NULL) AND required_document_id IN (15,22,30,34,53,17,56,57)";
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}
function supporting_documents($value)
{
    $db = db_connect();
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and  required_document_id=16";
    // echo $query;
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}


function Additional_Information_docs($value)
{
    $db = db_connect();
    $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2' and required_document_id=17 and status = 'upload' and (employee_id is NULL OR employee_id = 0)";
    // $query =  "SELECT * FROM `documents` WHERE pointer_id = '" . $value . "'  and stage = 'stage_2'";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}


function Assissment_docs_($docid)
{
    $db = db_connect();
    $query = "SELECT * FROM `additional_info_request` where support_evidance_status is Null AND document_id=".$docid;
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
// admin->verification->email_stage_2
function emplo_email_verf($value)
{
    $db = db_connect();
    $query = "select * from email_verification where pointer_id = '" . $value . "' AND employer_id IS NOT NULL";
    // echo $query;
    $sql = $db->query($query);
    return  $sql->getResult();
}
function quali_email_verf($value)
{
    $db = db_connect();
    $query = "select * from email_verification where pointer_id = '" . $value . "'  and `verification_type` = 'Verification - Qualification'";
    $sql = $db->query($query);
    return  $sql->getRow();
}

function __employment_email_verification($pointer_id){
    
    $db = db_connect();
    $query = "SELECT * FROM `email_verification` WHERE `pointer_id` = ".$pointer_id." and (`verification_type` = 'Verification Email - Employment' OR `verification_type` = 'Verification - Employment')";
    $sql = $db->query($query);
    return  $sql->getResult();
}


function request_asses_doc__alternate($pointer_id)
{
    
    $db = db_connect();
    // $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and document_id IN (SELECT id FROM `documents` where required_document_id in (15,30,34) ) and status ='send' and stage = 'stage_2'";
    $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and ( s2_add_employment_id is NULL Or s2_add_employment_id = 0  )  
    and status = 'send'  and (support_evidance_status is NULL Or support_evidance_status = '')";
    $sql = $db->query($query);
    return  $sql->getResult();
    
}


//for asssisment docs
function request_asses_doc__alternate_admin($pointer_id)
{
    
    $db = db_connect();
    
    
    $sql_ = "SELECT * FROM application_pointer WHERE id = $pointer_id ";
    $res_ = $db->query($sql_);
    $data_ = $res_->getRowArray();
    $stage=$data_['stage'];
    
    // $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and document_id IN (SELECT id FROM `documents` where required_document_id in (15,30,34) ) and status ='send' and stage = 'stage_2'";
    $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and ( s2_add_employment_id is NULL Or s2_add_employment_id = 0)  
      and (support_evidance_status is NULL Or support_evidance_status = '') and status <> 'verified' and stage='$stage'";
    $sql = $db->query($query);
    return  $sql->getResultarray();
    
}
//for supporting evidance docs 
function request_supportive_evidance_doc_($pointer_id)
{
    
    $db = db_connect();
    
    $sql_ = "SELECT * FROM application_pointer WHERE id = $pointer_id ";
    $res_ = $db->query($sql_);
    $data_ = $res_->getRowArray();
    $stage=$data_['stage'];
    // $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and document_id IN (SELECT id FROM `documents` where required_document_id in (15,30,34) ) and status ='send' and stage = 'stage_2'";
    $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and ( s2_add_employment_id is NULL Or s2_add_employment_id = 0)  
      and support_evidance_status='yes' and stage='$stage' and status <> 'verified'";
     $sql = $db->query($query);
    return  $sql->getResultarray();
    
}
//for organisation 
function request_organisation_doc_($pointer_id)
{
    
    $db = db_connect();
    // $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and document_id IN (SELECT id FROM `documents` where required_document_id in (15,30,34) ) and status ='send' and stage = 'stage_2'";
    $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and s2_add_employment_id <> 0";
    $sql = $db->query($query);
    return  $sql->getResultarray();
    
}
function request_asses_doc($pointer_id)
{
    
    $db = db_connect();
    $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and document_id IN (SELECT id FROM `documents` where required_document_id in (15,30,34) ) and status ='send' and stage = 'stage_2'";
    $sql = $db->query($query);
    return  $sql->getResult();
    
}
function request_support_evidance($pointer_id)
{
    
    $db = db_connect();
    // $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and document_id IN (SELECT id FROM `documents` where required_document_id in (16) ) and status ='send' and stage = 'stage_2'";
    // echo $query;exit;
        $query = "SELECT * FROM `additional_info_request` WHERE pointer_id ='" . $pointer_id . "' and support_evidance_status = 'yes' and status ='send' and stage = 'stage_2'";

    $sql = $db->query($query);
    return  $sql->getResult();
    // die;
}
// akanksha 5 july 2023
function update_pointer_id_cron_job()
{
      $db = db_connect();
    $query = "SELECT * FROM application_pointer WHERE id IN (SELECT pointer_id FROM stage_1 WHERE expiry_date < CURDATE()) AND stage = 'stage_2' and status in ('start')";
    $sql = $db->query($query);
    return  $sql->getResult();

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

function count_company($pointer_id){ 
    $db = db_connect();
    $query = "SELECT COUNT(*) AS number FROM `stage_2_add_employment` WHERE pointer_id = '" . $pointer_id . "'";
    $sql = $db->query($query);
    return  $sql->getRow();

}
function chef_to_cook(){
    $db = db_connect();
    $query = "SELECT * FROM `occupation_list` where id in(5,6)";
    $sql = $db->query($query);
    return  $sql->getResult();
    
}
function admin_data(){
     $db = db_connect();
    $query = "SELECT * FROM `admin_account` where status='active'";
    $sql = $db->query($query);
    return  $sql->getResultArray();
}

<?php
// cron_jobs.php

namespace App\Controllers;
use DateTime as GlobalDateTime;
use DateTime;
use DateTimeZone;
class Cron_jobs extends BaseController
{
    
    
    
    public function call_the_mail_queue(){
        $db = db_connect();
        
        $query = "select * from mail_queue where is_send = 0";
        $sql = $db->query($query);
        $rows =   $sql->getResultarray();
        foreach($rows as $row){
            $id = $row["id"];
            $setFrom = $row["server_email"];
            $setFrom_name = $row["server_from_email"];
            $addAddress = $row["to_send"];
            $Subject = $row["subject"];
            $Body = $row["message"];
            $addReplyTo_array = json_decode($row["add_reply_to_array"]);
            $addBCC_array = json_decode($row["add_bcc_array"]);
            $addCC_array = json_decode($row["add_cc_array"]);
            $addAttachment_array = json_decode($row["add_attachment_array"]);
            $pointer_id = $row["pointer_id"];
            $send_email = $row["helper_function"];
            $output = "";
            if($send_email == "send_email"){
                $output = send_email($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array, $addBCC_array, $addCC_array, $addAttachment_array, $pointer_id, false);
            }
            else if($send_email == ""){
                $output = verification_($setFrom, $setFrom_name, $addAddress, $Subject, $Body, $addReplyTo_array, $addBCC_array, $addCC_array, $addAttachment_array, $pointer_id, false);
            }
            
            
            // if mail send 
            
            if($output){
                $query = "update mail_queue set is_send = 1 where id = ".$id;
                $sql = $db->query($query);
            }
            
        }
        // Foreach Loop END
    }
    
    public function check_auto_logout(){
        // 
        // echo "Here";
        $admins = $this->admin_account_model->where(["is_active" => "yes", "is_active_timestamp <>" => NULL])->findAll();
        foreach($admins as $admin){
            // print_r($admin);
            $history_date = $admin["is_active_timestamp"];
            $current_date = date("Y-m-d H:i:s");
            $minutes = $this->getTheTimeDifference($current_date, $history_date);
            // echo $minutes;
            if($minutes >= 10){
                // Make Logout
                $this->admin_account_model->set(["is_active" => "", "is_active_timestamp" => NULL])->where(["id" => $admin["id"]])->update();
                // echo $this->admin_account_model->getLastQuery();
                // 
            }
        }
        // 
    }
    
    public function make_date_store_init(){
        $session = session();
        $data = [
            "is_active" => "yes",
            "is_active_timestamp" => date("Y-m-d H:i:s")
            ];
        if(isset($session->admin_id)){
            $this->admin_account_model->set($data)->where(["id" => $session->admin_id])->update();
        }
    }
    
    public function getTheTimeDifference($current_date, $history_date){
        
        // Declare and define two dates
        $date1 = strtotime($history_date);
        $date2 = strtotime($current_date);
        
        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);
        
        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365*60*60*24));
        
        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365*60*60*24)
        								/ (30*60*60*24));
        
        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365*60*60*24 -
        			$months*30*60*60*24)/ (60*60*24));
        
        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365*60*60*24
        		- $months*30*60*60*24 - $days*60*60*24)
        									/ (60*60));
        
        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
        $minutes = floor(($diff - $years * 365*60*60*24
        		- $months*30*60*60*24 - $days*60*60*24
        							- $hours*60*60)/ 60);
        
        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes
        $seconds = floor(($diff - $years * 365*60*60*24
        		- $months*30*60*60*24 - $days*60*60*24
        				- $hours*60*60 - $minutes*60));
        
        // Print the result
        // printf("%d years, %d months, %d days, %d hours, "
        // 	. "%d minutes, %d seconds", $years, $months,
        // 			$days, $hours, $minutes, $seconds);
        
        return $minutes;
    }
    
    
    public function closed_expire_application(){
        
        // deleteCompletedApplication();
        // exit;

    }
      // application_expiry_checker
    //   7 Days code is committed
    public function stage_1_expired()
    {
        // $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_1'])->find();
        $db = db_connect();
        $sql = "SELECT * FROM `application_pointer` WHERE (`stage` = 'stage_1' AND `status` = 'Approved') OR (`stage` = 'stage_2' AND `status` = 'Start') OR (`stage` = 'stage_1' AND `status` = 'Expired')";
        $res = $db->query($sql);
        $application_pointers = $res->getResultArray();
        // $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_1'])->orWhere(['stage' => 'stage_2', 'status' => 'Start'])->find();
        foreach ($application_pointers as $key => $value) {
            $pointer_id = $value['id'];
            $stage_1 = $this->stage_1_model->where(['pointer_id' => $pointer_id])->wherein('status', ['Approved', 'Expired'])->first();
            if (!empty($stage_1)) { // validation check 
                $approved_date = $stage_1['approved_date'];
                $closure_date = $stage_1['closure_date'];
                $expiry_date = $stage_1['expiry_date'];
                $expiry_date_closure_date = $stage_1['closure_date'];
                $agent_id = $value['user_id'];
                $reminder_email_send = $stage_1['reminder_email_send'];
                $archive_email_send = $stage_1['archive_email_send'];
                $expiry_email_send = $stage_1['expiry_email_send'];
                $stage_2_add_employment = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->first();
                if (1==1) { // validation check 
                    $user_account_ = $this->user_account_model->where(['id' => $agent_id])->first();
                    if (!empty($user_account_)) { // validation check 
                        $user_email = $user_account_['email'];
                        if (!empty($user_email)) { // validation check 

                            $reminder_date =  date('Y-m-d', strtotime('+27 days', strtotime($approved_date)));
                            // $archive_date =  date('Y-m-d', strtotime('+30 days', strtotime($approved_date)));
                            
                            $archive_date =  date('Y-m-d');
                            
                            // $expiry_date =  date('Y-m-d', strtotime('+60 days', strtotime($approved_date)));

                            $Expired_date =  date('Y-m-d', strtotime('+60 days', strtotime($approved_date)));
                            $expiry_date_temp = strtotime($Expired_date);
                            $todays_date = strtotime(date('Y-m-d'));
                            $timeleft = $todays_date - $expiry_date_temp;
                            $day_remain = round((($timeleft / 86400)));
                            
                            // New Code -> 20 DEC 
                            
                            $date1 = new DateTime(date('Y-m-d', strtotime($expiry_date)));
                            $date2 = new DateTime(date('Y-m-d'));
                            $interval = $date1->diff($date2);
                            
                            // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                            $day_remain = $interval->days;
                            if ($date2 > $date1) {
                                // If $date2 is greater than $date1, make $day_remain_ negative
                                $day_remain = -$day_remain;
                            }
                            
                            
                            // echo $pointer_id." - ".$day_remain."<br/>";
                            // continue;
                            
                            
                            // Closure Date
                            
                            
                            $date1_closure_date = new DateTime(date('Y-m-d', strtotime($expiry_date_closure_date)));
                            $date2_closure_date = new DateTime(date('Y-m-d'));
                            $interval_closure_date = $date1_closure_date->diff($date2_closure_date);
                            
                            // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                            $day_remain_closure_date = $interval_closure_date->days;
                            if ($date2_closure_date > $date1_closure_date) {
                                // If $date2 is greater than $date1, make $day_remain_ negative
                                $day_remain_closure_date = -$day_remain_closure_date;
                            }
                            
                            // echo "Pointer Id - ".$pointer_id." Day -> ";
                            // echo $day_remain." -> ";
                            // echo $day_remain_closure_date;
                            // echo "<br/>";
                            // echo "<br/>";
                            // continue;
                            // check reminder and send email and update database
                            
                            if((!empty($closure_date) || $closure_date != "0000-00-00 00:00:00") && $day_remain_closure_date == -1){
                                goto LastExpiryDate;
                            }
                            
                            if ($day_remain == 7) {
                                if ($reminder_email_send != 1 && (empty($closure_date) || $closure_date == "0000-00-00 00:00:00")) {

                                    // s1_expiry_reminder_agent
                                    $mail_temp_4 = $this->mail_template_model->where(['id' => '46'])->first();
                                    if (!empty($mail_temp_4)) { // validation check 
                                        $subject = $mail_temp_4['subject'];
                                        $message = $mail_temp_4['body'];

                                        $archive_date_format =  date('d/m/Y', strtotime($expiry_date));
                                        $message = str_replace('%Expiry_Date%', $archive_date_format, $message);

                                        $subject = mail_tag_replace($subject, $pointer_id);
                                        $message = mail_tag_replace($message, $pointer_id);
                                        $check = 0;
                                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_email, $subject, $message);
                                        if ($check == 1) { // validation check 
                                            $data = [
                                                'reminder_email_send' => 1
                                            ];
                                            $this->stage_1_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                                            echo "email send reminder alert " . $pointer_id . " <br>";
                                        }
                                    }
                                    echo "<hr>";
                                } else {
                                    echo "Reminder Email is Already sended " . $pointer_id . "<br>";
                                }
                            } else if ($day_remain == -1) {
                              //echo $pointer_id;
                                if ($archive_email_send != 1 && (empty($closure_date) || $closure_date == "0000-00-00 00:00:00")) { // validation check 
                                    
                                    //  s1_expiry_archive_agent
                                    $mail_temp_4 = $this->mail_template_model->where(['id' => '47'])->first();
                                    if (!empty($mail_temp_4)) {

                                        $subject = $mail_temp_4['subject'];
                                        $message = $mail_temp_4['body'];

                                        $archive_date_format =  date('d/m/Y', strtotime($expiry_date));
                                        $message = str_replace('%Expiry_Date%', $archive_date_format, $message);

                                        $subject = mail_tag_replace($subject, $pointer_id);
                                        $message = mail_tag_replace($message, $pointer_id);
                                        $check = 0;

                                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_email, $subject, $message);
                                        if ($check == 1) {
                                            $data = [
                                                'status' => 'Expired',
                                                'archive_date' => $archive_date,
                                                // 'expiry_date' => $expiry_date,
                                                'archive_email_send' => 1,
                                            ];
                                            $this->stage_1_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                                            $this->application_pointer_model->where(['id ' => $pointer_id])->set(['status' => 'Expired','stage'=>'stage_1'])->update();
                                            echo "email send archive " . $pointer_id . " <br>";
                                        } // email send check
                                    } // email template check


                                    echo "<hr>";
                                    
                                } else {
                                    echo "Archiv email is Already sended " . $pointer_id . "<br>";
                                }
                            } else if ($day_remain  == -31) {
                                if ($expiry_email_send != 1 && (empty($closure_date) || $closure_date == "0000-00-00 00:00:00")) { // validation check 
                                    //   s1_expiry_expiry_agent
                                    LastExpiryDate: 
                                    if($expiry_email_send != 1){
                                        $mail_temp_4 = $this->mail_template_model->where(['id' => '48'])->first();
                                        if (!empty($mail_temp_4)) {
                                            $subject = $mail_temp_4['subject'];
                                            $message = $mail_temp_4['body'];
    
                                            $archive_date_format =  date('d/m/Y', strtotime($expiry_date));
                                            $message = str_replace('%Expiry_Date%', $archive_date_format, $message);
    
                                            $subject = mail_tag_replace($subject, $pointer_id);
                                            $message = mail_tag_replace($message, $pointer_id);
                                            $check = 0;
    
    
                                            // Email send 
                                            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $user_email, $subject, $message);
                                            if ($check == 1) {
    
    
                                                // head office email 
                                                $mail_temp_4 = $this->mail_template_model->where(['id' => '49'])->first();
                                                if (!empty($mail_temp_4)) {
                                                    $subject = $mail_temp_4['subject'];
                                                    $message = $mail_temp_4['body'];
    
                                                    $archive_date_format =  date('d/m/Y', strtotime('+30 days', strtotime($approved_date)));
                                                    $message = str_replace('%Expiry_Date%', $archive_date_format, $message);
    
                                                    $subject = mail_tag_replace($subject, $pointer_id);
                                                    $message = mail_tag_replace($message, $pointer_id);
                                                    $check = 0;
                                                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), env('HEADOFFICE_EMAIL'), $subject, $message);
                                                    echo "email send  head office " . $pointer_id . "  <br>";
                                                }
    
                                                // sql update
                                                $data = [
                                                    'status' => 'Expired',
                                                    // 'expiry_date' => date('y-m-d h:m:i'),
                                                    'expiry_email_send' => 1,
                                                ];
                                                $this->stage_1_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                                                $this->application_pointer_model->where(['id ' => $pointer_id])->set(['status' => 'Expired','stage'=>'stage_1'])->update();
                                                echo "email send Expired " . $pointer_id . "  <br>";
                                            }
                                        }
                                    }
                                    echo "<hr>";
                                } else {
                                    echo "Expired email is Already sended " . $pointer_id . "<br>";
                                }
                            }
                        } else {
                            echo "<br> valid email check";
                        } // valid email check
                    } else {
                        echo "<br>  get Applicant Agent email";
                    }  // get Applicant Agent email
                }
            } //  application  exist check
        } //  Loop foreach
        
        // $this->stage_2_expired();
    }
//stage2 expired
function deleteDirectory($dir) {
                        if (is_dir($dir)) {
                            $objects = scandir($dir);
                            foreach ($objects as $object) {
                                if ($object != "." && $object != "..") {
                                    $object_path = $dir . '/' . $object;
                                    if (is_file($object_path)) {
                                        unlink($object_path);
                                    } elseif (is_dir($object_path)) {
                                        deleteDirectory($object_path);
                                    }
                                }
                            }
                            rmdir($dir);
                        }
                    }
public function stage_2_expired()
    {
        
        $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_1', 'status' => 'Expired'])->find();
        foreach ($application_pointers as $key => $value) {
            
            $pointer_id = $value['id'];
            $stage_1 = $this->stage_1_model->where(['pointer_id' => $pointer_id])->wherein('status', ['Expired','Approved'])->first();
            if (!empty($stage_1)) {
              
                $expiry_date = $stage_1['approved_date'];
                $dateTime = new DateTime($expiry_date);
                $dateTime->modify('+31 day');
                $formattedDate = $dateTime->format('Y-m-d');
                $currentDate = date('Y-m-d');
                
                //echo $pointer_id."The expiry date 31 days from {$expiry_date} is {$formattedDate}. Today is {$currentDate}.";

              if($formattedDate == $currentDate){

                 // $stage_2_delete=$this->stage_2_model->where('pointer_id', $pointer_id)->delete();
                  $stage_2_employment=$this->stage_2_add_employment_model->where('pointer_id',$pointer_id)->delete();
                  if($stage_2_employment){
                       
                $folder_path = 'public/application/' . $pointer_id . '/stage_2';
                if (is_dir($folder_path)) {
                // Open the directory
                 if ($dir_handle = opendir($folder_path)) {
                    // Loop through the directory
                    while (($file = readdir($dir_handle)) !== false) {
                        if ($file != "." && $file != "..") {
                            $file_path = $folder_path . '/' . $file;
            
                            // Check if it's a file or directory
                            if (is_file($file_path)) {
                                // Delete the file
                                unlink($file_path);
                            } elseif (is_dir($file_path)) {
                                // Delete the subdirectory (recursive call)
                                 
                                $this->deleteDirectory($file_path);
                            }
                        }
                    }
                    closedir($dir_handle);
                    rmdir($folder_path);
                     $document_model = $this->documents_model->where('pointer_id', $pointer_id)->where('stage','stage_2')->delete();
                
                    echo 'Directory deleted successfully and Record Delete successfully'.$pointer_id;
                } else {
                    echo 'Unable to open directory.';
                }
            } 
                 
              }else{
                 echo " false";
              }
              
                     
                 
            }
            
        } 
    }
    }
    
    // stage_3_set_Conducted_status  Done
    public function stage_3_auto_Conducted()
    {
        $count = 0;
        $count_update = 0;

        $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_3', 'status' => 'Scheduled'])->find();
        
        foreach ($application_pointers as $key => $value) {
            $pointer_id = $value['id'];
            $stage_3_interview_booking = $this->stage_3_interview_booking_model->where(['pointer_id' => $pointer_id])->first();
            if(!$stage_3_interview_booking){
                // echo $pointer_id."<br/>";
                continue;
            }
            $date_time = $stage_3_interview_booking['date_time'];
            $date = strtotime($date_time);
            // todays date not calculat
            if (date('Y-m-d') != date('Y-m-d', $date)) {
                // get past date only 
                if ($date <  strtotime(date('Y-m-d H:i:s'))) {
                    $count++;
                    // check stage_3 availabel
                    $stage_3 = $this->stage_3_model->where(['pointer_id' => $pointer_id])->first();
                    if (!empty($stage_3)) {
                        // update stage 3 status 
                        $data = [
                            'status' => 'Conducted',
                            'conducted_date' => date('Y-m-d H:i:s'),
                        ];
                        echo "pointer_id :- " . $pointer_id . "<br>";
                        echo "Database pointer Update :- " . $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->set(['status' => 'Conducted'])->update();
                        echo "Database stage 3 Update :- " . $check_is_update = $this->stage_3_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                        echo "<br>";
                        $check_is_update = 1;
                        if ($check_is_update) {
                            $count_update++;
                        }
                    }
                }
            }
        }

        echo "<h1>" . $count . ' out of ' . $count_update . "Application Scheduled to Conducted.</h1>";
    }

    // stage_3_Reassessmnet_set_Conducted_status  Done
    public function stage_3_R_auto_Conducted()
    {
        $count = 0;
        $count_update = 0;

        $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_3_R', 'status' => 'Scheduled'])->find();
        foreach ($application_pointers as $key => $value) {
            $pointer_id = $value['id'];
            $stage_3_interview_booking = $this->stage_3_reassessment_interview_booking_model->where(['pointer_id' => $pointer_id])->first();
            $date_time = $stage_3_interview_booking['date_time'];
            $date = strtotime($date_time);
            // todays date not calculat
            if (date('Y-m-d') != date('Y-m-d', $date)) {
                // get past date only 
                if ($date <  strtotime(date('Y-m-d H:i:s'))) {
                    $count++;
                    // check stage_3 availabel
                    $stage_3 = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->first();
                    if (!empty($stage_3)) {
                        // update stage 3 status 
                        $data = [
                            'status' => 'Conducted',
                            'conducted_date' => date('Y-m-d H:i:s'),
                        ];
                        echo "pointer_id :- " . $pointer_id . "<br>";
                        echo "Database pointer Update :- " . $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->set(['status' => 'Conducted'])->update();
                        echo "Database stage 3 Reassessment Update :- " . $check_is_update = $this->stage_3_reassessment_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                        echo "<br>";
                        $check_is_update = 1;
                        if ($check_is_update) {
                            $count_update++;
                        }
                    }
                }
            }
        }

        echo "<h1>" . $count . ' out of ' . $count_update . "Application Scheduled to Conducted.</h1>";
    }

    
    // stage_4_set_Conducted_status  Done
    public function stage_4_auto_Conducted()
    {
        $count = 0;
        $count_update = 0;

        $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_4', 'status' => 'Scheduled'])->find();
        // print_r($application_pointers);
        // exit;
        foreach ($application_pointers as $key => $value) {
            $pointer_id = $value['id'];
            // echo $pointer_id;
            // exit;
            $stage_4_interview_booking = $this->stage_4_practical_booking_model->where(['pointer_id' => $pointer_id])->first();
            $date_time = $stage_4_interview_booking['date_time'];
            $date = strtotime($date_time);
            // todays date not calculat
            if (date('Y-m-d') != date('Y-m-d', $date)) {
                
                // get past date only 
                if ($date <  strtotime(date('Y-m-d H:i:s'))) {
                    
                    $count++;
                    // check stage_4 availabel
                    $stage_4 = $this->stage_4_model->where(['pointer_id' => $pointer_id])->first();
                    if (!empty($stage_4)) {
                        // update stage 3 status 
                        $data = [
                            'status' => 'Conducted',
                            'conducted_date' => date('Y-m-d H:i:s'),
                        ];
                        echo "pointer_id :- " . $pointer_id . "<br>";
                        echo "Database pointer Update :- " . $application_pointer = $this->application_pointer_model->where(['id' => $pointer_id])->set(['status' => 'Conducted'])->update();
                        echo "Database stage 3 Update :- " . $check_is_update = $this->stage_4_model->where(['pointer_id' => $pointer_id])->set($data)->update();
                        echo "<br>";
                        $check_is_update = 1;
                        if ($check_is_update) {
                            $count_update++;
                        }
                    }
                }
            }
        }

        echo "<h1>" . $count . ' out of ' . $count_update . "Application Scheduled to Conducted.</h1>";
    }

    
    // read_email_and_Update   Done
    public function google_api()
    {
        
        /* Connecting Gmail server with IMAP */
        $imap = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'verification@aqato.com.au', 'Dilpreet@Singh!Bagga@2023!') or die('Cannot connect to Gmail: ' . imap_last_error());
        // $imap = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'mohsin@techflux.in', 'Mohsin@123') or die('Cannot connect to Gmail: ' . imap_last_error());
        // print_r($connection);
        if ($imap) {
    // Calculate the date for two months ago
    $twoMonthsAgo = date('d-M-Y', strtotime('-2 days'));

    // Search for emails received within the last two months
    $search = 'SINCE "' . $twoMonthsAgo . '"';

    // Get the message IDs of matching emails
    $messageIds = imap_search($imap, $search);
 if ($messageIds) {
        $repliedEmails = array();

        // Fetch the overview information of the emails
        $emailOverviews = imap_fetch_overview($imap, implode(',', $messageIds), 0);
foreach ($messageIds as $messageId) {
            // Fetch the complete email headers
            $header = imap_headerinfo($imap, $messageId);
            
            $subject_class = isset($header->subject) ? $header->subject : "";
            
            // exit;
            if(isset($header->from[0]->mailbox)){
                // print_r();
                
                // print_r($header["senderaddress"]);
                // print_r($header);
                if(isset($header->sender[0]->mailbox)){
                    
            //          print_r($subject_class);
            // exit;
                    // Test if string contains the word 
                    if(strpos((string)$subject_class, "Employment Verification") !== false){
                    
                    
                        $emailData = array(
                            'from_email' => $header->from[0]->host,
                            'from_email_2' => $header->sender[0]->mailbox."@".$header->sender[0]->host,
                            'from_name' => $header->fromaddress,
                            'subject' => imap_utf8($header->subject),
                        );
        
                        $repliedEmails[$messageId] = $emailData;
                    
                    }
                    // End Of IF
                }
            }
            continue;
        }
    } else {
        echo 'No emails found within the last two days.';
    }

    // Close the IMAP connection
    imap_close($imap);
} else {
    echo 'Failed to connect to the IMAP server.';
    exit;
}
// echo "<pre>";
// print_r($repliedEmails);
// exit;

$all_email_data_array = $repliedEmails;
      
        if (count($all_email_data_array) > 0) {


            $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_2', 'status' => 'Submitted'])->find();
            foreach ($application_pointers as $key => $value_1) {
                $pointer_id = $value_1['id'];

                $add_employers = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();
                if (!empty($add_employers)) {
                    foreach ($add_employers as $key => $value) {
                        $employment_id = $value['id'];
                        $email_verification = $this->email_verification_model->where(['employer_id' => $employment_id])->first();
                        if (!empty($email_verification)) {


                            $id = $email_verification['id'];
                            $pointer_id = $email_verification['pointer_id'];

                            $verification_email_send = $email_verification['verification_email_send'];
                            $verification_email_received = $email_verification['verification_email_received'];
                            $is_verification_done = $email_verification['is_verification_done'];



                            if ($is_verification_done == 0) {

                                if ($verification_email_send == 1) {

                                    if ($verification_email_received == 0) {


                                        $verification_email_id = $email_verification['verification_email_id'];
                                        $verification_email_subject = $email_verification['verification_email_subject'];
                                        $email_subject = $verification_email_subject;
                                        $send_Email = $verification_email_id;

                                        if (!empty($email_subject)) {
                                            foreach ($all_email_data_array as $key_2 => $valu_2) {
                                                $subject = $valu_2['subject'];
                                                $from_name = $valu_2['from_name'];

                                                // mach employers data with email data
                                                $check = 0;

                                                // check 1  with Re: 
                                                echo "<br> email_1 subject:- " . $subject;
                                                echo "<br> email_2 email_subject:- " . $email_subject;
                                                $email_1 = str_replace(" ", "", $subject);
                                                $email_2 =   "Re: " . $email_subject;
                                                $email_2 =  str_replace(" ", "", $email_2);
                                                // echo "<br> email_2:- ". $email_2;
                                                $subject_mach = 0;

                                                if (urlencode(strtoupper($email_1)) == urlencode(strtoupper($email_2))) {
                                                    echo "<br>Subject mach check 1";
                                                    $subject_mach = 1;
                                                } else {
                                                    // check 2   withaut Re: 
                                                    $email_1 = str_replace(" ", "", $subject);
                                                    $email_2 =   "" . $email_subject;
                                                    $email_2 =  str_replace(" ", "", $email_2);
                                                    if (urlencode(strtoupper($email_1)) == urlencode(strtoupper($email_2))) {
                                                        echo "<br>Subject mach New Check 2";
                                                        $subject_mach = 1;
                                                    }
                                                }
                                                $check += $subject_mach;


                                                echo "<br> from_email:- " . $valu_2['from_email'];
                                                echo "<br> send_Email:- " . $send_Email;
                                                if (isset($valu_2['from_email'])) {
                                                    $from_email = $valu_2['from_email'];
                                                    $from_email_2 = $valu_2['from_email_2'];
                                                    $email_mach = 0;
                                                    if (urlencode(strtoupper($from_email)) == urlencode(strtoupper($send_Email))) {
                                                        echo "<br>email mach 1";
                                                        $email_mach = 1;
                                                    } else if (urlencode(strtoupper($from_email_2)) == urlencode(strtoupper($send_Email))) {
                                                        echo "<br>email mach 2";
                                                        $email_mach = 1;
                                                    }
                                                    $check += $email_mach;
                                                    // echo "<h1> email_mach = " . $check . "</h2>";
                                                }


                                                // if employers data mach with email data than store in SQL
                                                if ($check > 1) {
                                                    echo "<br>" . $key_2;
                                                    echo "<br> from_email:- " . $valu_2['from_email'];
                                                    echo "<br> from_email_2:- " . $valu_2['from_email_2'];
                                                    echo "<br> send_Email:- " . $send_Email;
                                                    $details = [
                                                        'is_verification_done' => 1,
                                                        'verification_email_received' => 1,
                                                    ];
                                                    echo "<br> Data update :- " .  $email_verification = $this->email_verification_model->where(['id' => $id, 'pointer_id' => $pointer_id])->set($details)->update();
                                                    echo "<br> ok";
                                                    echo "<hr>";


                                                    $email_verification_select = $this->email_verification_model->where(['pointer_id' => $pointer_id, 'employer_id<>' => ''])->findAll();
                                                    //  echo $this->email_verification_model->getLastQuery();
                                                    $total_employ = 0;
                                                    $is_verification_check = 0;
                                                    // echo "mohsin";
                                                    // print_r($email_verification_select);
                                                    foreach ($email_verification_select as $key => $value) {
                                                        $total_employ++;
                                                        $is_verification_done = $value['is_verification_done'];
                                                        if ($is_verification_done == 1) {
                                                            $is_verification_check++;
                                                        }
                                                    }
                                                    if ($total_employ == $is_verification_check) {
                                                        // s2_ Employee_verification_Complete_admin
                                                        $mail_temp_4 = $this->mail_template_model->where(['id' => '114'])->first();
                                                        if (!empty($mail_temp_4)) { // validation check 
                                                            $subject = $mail_temp_4['subject'];
                                                            $message = $mail_temp_4['body'];
                                                            $subject = mail_tag_replace($subject, $pointer_id);
                                                            $message = mail_tag_replace($message, $pointer_id);
                                                            $check = 0;
                                                            $to =  env('ADMIN_EMAIL');
                                                            
                                                            $isSend = verification_(env('verification_SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                                                            
                                                            if($isSend){
                                                                echo "Final Verfication Completed Mail DONE!!!";
                                                            }
                                                            
                                                        }
                                                    } else {
                                                        echo "<br> final Email is Pending to send";
                                                    }
                                                    // $email_verification_select = $this->email_verification_model->where(['pointer_id' => $pointer_id])->find();


                                                } else {
                                                    // echo "Not mach <br>";
                                                    // echo $verification_email_id . "<br>";
                                                }
                                            } // email loop

                                        } // id subject not empty


                                    } // checl valid data
                                } // checl valid data
                            } // checl valid data




                        } else {
                            echo "empty employ ";
                        } // empty employ 
                    }
                }
            }
        }
    }
    
    
    
    // read_email_and_Update   Done
    public function google_api__Old()
    {
        // imap_open("{mail.domain.com:993/imap/ssl/novalidate-cert}INBOX", 'verification@aqato.com.au', 'a{vlv@q8I(lkfe\$I') or die('Cannot connect: ' . print_r(imap_errors(), true));

        $Client_ID = env('Client_ID');
        // $Client_ID = "970011920556-29uuon2n9qr9h1nkbg9kp23fjtus35l7.apps.googleusercontent.com";

        $Client_secret = env('Client_secret');
        // $Client_secret = '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';

        $API_Keys = env('API_Keys');
        // $API_Keys = 'AIzaSyBenEnEXo6zA8_SGYbGdOPoZDNe_to14j0';


        // Pre Search

        
        $token = $this->token_model->orderBy("id", "DESC")->first();
        
        $real_token_id__ = "";
        if(isset($token["id"])){
         $real_token_id__ = $token["id"];   
        }
        
        // echo $real_token_id__;
        // exit;



        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://accounts.google.com/o/oauth2/token';
            $params = array(
                "code" => $code,
                "client_id" => $Client_ID,
                "client_secret" => $Client_secret,
                "redirect_uri" => base_url('read_email_and_Update'),
                "grant_type" => "authorization_code",
                "access_type" => "offline",
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, constant("CURLOPT_" . 'URL'), $url);
            curl_setopt($ch, constant("CURLOPT_" . 'POST'), true);
            curl_setopt($ch, constant("CURLOPT_" . 'POSTFIELDS'), $params);
            $result = json_decode(curl_exec($ch), true);
            curl_close($ch);
// if(isset($_GET)){
    // print_r($ch);
    // echo "<pre>";
    // print_r($result);
    // exit;
// }


            if (isset($result['access_token'])) {
                if (isset($result['id_token'])) {
                    if (isset($result['expires_in'])) {
                        $access_token = $result['access_token'];
                        // OLD
                        // $refresh_token = $result['refresh_token'];
                        // New Update
                        $refresh_token = $result['id_token'];
                        $expires_in = time() + $result['expires_in'];

                        $details = [
                            'access_token' => $access_token,
                            'refresh_token' => $refresh_token,
                            'expires_in' => $expires_in
                        ];
                        $token = $this->token_model->where(['id' => $real_token_id__])->first();
                        if (!empty($token)) {
                            
                            $this->token_model->where(['id' => $real_token_id__])->set($details)->update();
                        } else {
                            $this->token_model->save($details);
                        }
                    }
                }
            }
            return redirect()->to(base_url('read_email_and_Update'));
        }

        $all_email_data_array = array();
        $token = $this->token_model->where(['id' => $real_token_id__])->first();
        // print_r($token);
        // exit;
        if (!empty($token)) {
            $access_token = $token['access_token'];
            $refresh_token = $token['refresh_token'];
            $expires_in = $token['expires_in'];

            if (time() > $expires_in) {
                $url_token = 'https://www.googleapis.com/oauth2/v4/token';
                // echo $refresh_token;
                $curlPost = 'client_id=' . $Client_ID . '&client_secret=' . $Client_secret . '&refresh_token=' . $refresh_token . '&grant_type=refresh_token';
                // print_r($curlPost);
                $ch_4 = curl_init();
                // print_r($ch_4);
                // exit;
                curl_setopt($ch_4, CURLOPT_URL, $url_token);
                curl_setopt($ch_4, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch_4, CURLOPT_POST, 1);
                curl_setopt($ch_4, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch_4, CURLOPT_POSTFIELDS, $curlPost);
                $http_code = curl_getinfo($ch_4, CURLINFO_HTTP_CODE);
                // echo $url_token;
                // echo $http_code;
                // exit;
                // if ($http_code != 200) {
                //     $data = json_decode(curl_exec($ch_4), true);

                //     echo "<pre>";
                //     print_r($http_code);
                //     echo "</pre>";
                //     exit;
                //     // throw new Exception('Error : Failed to refresh access token');
                // } else {
                // }
                // print_r(curl_exec($ch_4));
                $data = json_decode(curl_exec($ch_4), true);
                
                if(isset($data["error"])){
                    if($data["error"] == "invalid_grant"){
                        // print_r($data);
                        if($this->token_model->truncate()){
                            
                            return redirect()->to(base_url('read_email_and_Update'));
                            exit;   
                        }
                    }
                }
                $expires_in = time() + $data['expires_in'];
                $access_token = $data['access_token'];
                $details = [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token,
                    'expires_in' => $expires_in
                ];
                $token = $this->token_model->where(['id' => $real_token_id__])->first();
                if (!empty($token)) {
                    $this->token_model->where(['id' => $real_token_id__])->set($details)->update();
                } else {
                    $this->token_model->save($details);
                }
            }

            // $all_mail_list = "https://gmail.googleapis.com/gmail/v1/users/verification%40aqato.com.au/messages?key=" . $API_Keys;
            $all_mail_list = "https://gmail.googleapis.com/gmail/v1/users/verification@aqato.com.au/messages?key=" . $API_Keys;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $all_mail_list);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
            $headers = array();
            $headers[] = 'Authorization: Bearer ' . $access_token;
            $headers[] = 'Accept: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = json_decode(curl_exec($ch));

            if (!isset($result->error)) {
                $all_msg_list = "";
                if (isset($result->messages)) {
                    $all_msg_list = $result->messages;
                }



                $read_no = 0;
                foreach ($all_msg_list as $key => $value_1) {
                    $read_no++;
                    $m_id = $value_1->id;
                    // singal array for email data
                    $email_data_array = array();
                    // API requst for singal email data
                    $mail_info_url = "https://gmail.googleapis.com/gmail/v1/users/verification@aqato.com.au/messages/" . $m_id;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $mail_info_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
                    $headers = array();
                    $headers[] = 'Authorization: Bearer ' . $access_token;
                    $headers[] = 'Accept: application/json';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = json_decode(curl_exec($ch));



                    // read only inboox email
                    if (in_array("INBOX", $result->labelIds)) {
                        $data = $result->payload->headers;
                        foreach ($data as $key => $value) {



                            // find email id from long string 
                            if (trim($value->name) == "ARC-Authentication-Results") {
                                if (isset(explode("smtp.mailfrom=", $value->value)[1])) {
                                    $text = explode("smtp.mailfrom=", $value->value)[1];
                                    $arr = explode(";", $text, 2);
                                    $email_data_array['from_email'] = $arr[0];
                                } else {
                                    $email_data_array['from_email'] = "_";
                                }
                            }

                            if ($value->name == "Authentication-Results") {
                                if (isset(explode("smtp.mailfrom=", $value->value)[1])) {
                                    $text = explode("smtp.mailfrom=", $value->value)[1];
                                    $arr = explode(";", $text, 2);
                                    $email_data_array['from_email_2'] = $arr[0];
                                } else {
                                    $email_data_array['from_email_2'] = "_";
                                }
                            }


                            if ($value->name == "From") {
                                $email_data_array['from_name'] = $value->value;
                            }
                            if ($value->name == "Subject") {
                                $email_data_array['subject'] = $value->value;
                            }
                            if ($value->name == "snippet") {
                                $email_data_array['massage'] = $value->value;
                            }
                            // add in singal array
                            $all_email_data_array[$m_id] = $email_data_array;
                        }
                    }

                    // limitation for read email from email list
                    if ($read_no == 20) {
                        break;
                    }
                }
            } else {
                echo "<pre>Error :- ";
                print_r($result);
                echo "</pre>";
            }
        } else {
            // if email ist not found than call new tokan page
            $params = array(
                "access_type" => "offline",
                "response_type" => "code",
                "client_id" => $Client_ID,
                "redirect_uri" => base_url('read_email_and_Update'),
                "scope" => "https://mail.google.com https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me"
            );
            $url = "https://accounts.google.com/o/oauth2/auth";
            $request_to = $url . '?' . http_build_query($params);
            return redirect()->to($request_to);
        }
        echo "<pre>";
        print_r($all_email_data_array);
        exit;
        if (count($all_email_data_array) > 0) {


            $application_pointers = $this->application_pointer_model->where(['stage' => 'stage_2', 'status' => 'Submitted'])->find();
            foreach ($application_pointers as $key => $value_1) {
                $pointer_id = $value_1['id'];

                $add_employers = $this->stage_2_add_employment_model->where(['pointer_id' => $pointer_id])->find();
                if (!empty($add_employers)) {
                    foreach ($add_employers as $key => $value) {
                        $employment_id = $value['id'];
                        $email_verification = $this->email_verification_model->where(['employer_id' => $employment_id])->first();
                        if (!empty($email_verification)) {


                            $id = $email_verification['id'];
                            $pointer_id = $email_verification['pointer_id'];

                            $verification_email_send = $email_verification['verification_email_send'];
                            $verification_email_received = $email_verification['verification_email_received'];
                            $is_verification_done = $email_verification['is_verification_done'];



                            if ($is_verification_done == 0) {

                                if ($verification_email_send == 1) {

                                    if ($verification_email_received == 0) {


                                        $verification_email_id = $email_verification['verification_email_id'];
                                        $verification_email_subject = $email_verification['verification_email_subject'];
                                        $email_subject = $verification_email_subject;
                                        $send_Email = $verification_email_id;

                                        if (!empty($email_subject)) {
                                            foreach ($all_email_data_array as $key_2 => $valu_2) {
                                                $subject = $valu_2['subject'];
                                                $from_name = $valu_2['from_name'];

                                                // mach employers data with email data
                                                $check = 0;

                                                // check 1  with Re: 
                                                echo "<br> email_1 subject:- " . $subject;
                                                echo "<br> email_2 email_subject:- " . $email_subject;
                                                $email_1 = str_replace(" ", "", $subject);
                                                $email_2 =   "Re: " . $email_subject;
                                                $email_2 =  str_replace(" ", "", $email_2);
                                                // echo "<br> email_2:- ". $email_2;
                                                $subject_mach = 0;

                                                if (urlencode(strtoupper($email_1)) == urlencode(strtoupper($email_2))) {
                                                    echo "<br>Subject mach check 1";
                                                    $subject_mach = 1;
                                                } else {
                                                    // check 2   withaut Re: 
                                                    $email_1 = str_replace(" ", "", $subject);
                                                    $email_2 =   "" . $email_subject;
                                                    $email_2 =  str_replace(" ", "", $email_2);
                                                    if (urlencode(strtoupper($email_1)) == urlencode(strtoupper($email_2))) {
                                                        echo "<br>Subject mach New Check 2";
                                                        $subject_mach = 1;
                                                    }
                                                }
                                                $check += $subject_mach;


                                                echo "<br> from_email:- " . $valu_2['from_email'];
                                                echo "<br> send_Email:- " . $send_Email;
                                                if (isset($valu_2['from_email'])) {
                                                    $from_email = $valu_2['from_email'];
                                                    $from_email_2 = $valu_2['from_email_2'];
                                                    $email_mach = 0;
                                                    if (urlencode(strtoupper($from_email)) == urlencode(strtoupper($send_Email))) {
                                                        echo "<br>email mach 1";
                                                        $email_mach = 1;
                                                    } else if (urlencode(strtoupper($from_email_2)) == urlencode(strtoupper($send_Email))) {
                                                        echo "<br>email mach 2";
                                                        $email_mach = 1;
                                                    }
                                                    $check += $email_mach;
                                                    // echo "<h1> email_mach = " . $check . "</h2>";
                                                }


                                                // if employers data mach with email data than store in SQL
                                                if ($check > 1) {
                                                    echo "<br>" . $key_2;
                                                    echo "<br> from_email:- " . $valu_2['from_email'];
                                                    echo "<br> from_email_2:- " . $valu_2['from_email_2'];
                                                    echo "<br> send_Email:- " . $send_Email;
                                                    $details = [
                                                        'is_verification_done' => 1,
                                                        'verification_email_received' => 1,
                                                    ];
                                                    echo "<br> Data update :- " .  $email_verification = $this->email_verification_model->where(['id' => $id, 'pointer_id' => $pointer_id])->set($details)->update();
                                                    echo "<br> ok";
                                                    echo "<hr>";



                                                    $email_verification_select = $this->email_verification_model->where(['pointer_id' => $pointer_id])->find();
                                                    $total_employ = 0;
                                                    $is_verification_check = 0;
                                                    foreach ($email_verification_select as $key => $value) {
                                                        $total_employ++;
                                                        $is_verification_done = $value['is_verification_done'];
                                                        if ($is_verification_done == 1) {
                                                            $is_verification_check++;
                                                        }
                                                    }
                                                    if ($total_employ == $is_verification_check) {
                                                        // s2_ Employee_verification_Complete_admin
                                                        $mail_temp_4 = $this->mail_template_model->where(['id' => '114'])->first();
                                                        if (!empty($mail_temp_4)) { // validation check 
                                                            $subject = $mail_temp_4['subject'];
                                                            $message = $mail_temp_4['body'];
                                                            $subject = mail_tag_replace($subject, $pointer_id);
                                                            $message = mail_tag_replace($message, $pointer_id);
                                                            $check = 0;
                                                            $to =  env('ADMIN_EMAIL');
                                                            verification_(env('verification_SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                                                        }
                                                    } else {
                                                        echo "<br> final Email is panding to send";
                                                    }
                                                    // $email_verification_select = $this->email_verification_model->where(['pointer_id' => $pointer_id])->find();


                                                } else {
                                                    // echo "Not mach <br>";
                                                    // echo $verification_email_id . "<br>";
                                                }
                                            } // email loop

                                        } // id subject not empty


                                    } // checl valid data
                                } // checl valid data
                            } // checl valid data




                        } else {
                            echo "empty employ ";
                        } // empty employ 
                    }
                }
            }
        }
    }
    
    // 5 july 2023 akanksha
    // public function update_pointer_id_s1_closed(){
    //     echo "Not Used";
    //     exit;
    //   $application_ids = update_pointer_id_cron_job();
    //     echo "<pre>";
    //     print_r($application_ids);
    //     echo "<pre>";
    //     if(isset($application_ids)){
    //       foreach($application_ids as $application){
    //           if(isset($application)){
    //                 $pointer_id = $application->id;
    //                 $stage_2_add_employees = $this->stage_2_add_employment_model->asObject()->where('pointer_id', $pointer_id)->findAll();
    //                 echo "<pre>";
    //                 print_r($stage_2_add_employees);
    //                 echo "<pre>";
    //                 if(isset($stage_2_add_employees)){
    //                     foreach($stage_2_add_employees as $employ){
    //                         $company_organisation_name =  $employ->company_organisation_name;
    //                         $company_organisation_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_organisation_name); // Removes special chars.
    //                         $company_organisation_name = trim(str_replace(' ', '_', $company_organisation_name));
    //                         $folderPath = 'public/application/' . $employ->pointer_id . '/stage_2/' . $company_organisation_name;
    //                         echo $folderPath;
    //                         echo "\n";
    //                         // exit;
    //                         // if(is_dir($folderPath)){
    //                         //     function deleteFolder($folderPath) {
    //                         //         if (!is_dir($folderPath)) {
    //                         //             return;
    //                         //         }
                                
    //                         //         $files = array_diff(scandir($folderPath), ['.', '..']);
                                
    //                         //         foreach ($files as $file) {
    //                         //             $filePath = $folderPath . '/' . $file;
                                
    //                         //             if (is_dir($filePath)) {
    //                         //                 deleteFolder($filePath);
    //                         //             } else {
    //                         //                 unlink($filePath);
    //                         //             }
    //                         //         }
                                
    //                         //         rmdir($folderPath);
    //                         //     }
    //                         // }
    //                         if($this->stage_2_add_employment_model->where('id', $employ->id)->delete()){
    //                             echo "stage_2_emplyment ".$employ->id." deleted";
    //                             echo "\n";
    //                         };
    //                     }
    //                 }
    //                 $documents = $this->documents_model->asObject()->where(['pointer_id' => $pointer_id, 'stage' => 'stage_2'])->findAll();
    //                 if(isset($documents)){
    //                     foreach($documents as $document){
    //                         $file = $document->document_path . '/' . $document->document_name;
    //                         // unlink($file);
    //                         if($this->documents_model->where('id', $document->id)->delete()){
    //                             echo "document ".$document->id." deleted";
    //                             echo "\n";
    //                         };
    //                     }
    //                 }
    //                 $stage_2 = $this->stage_2_model->asObject()->where('pointer_id', $pointer_id)->first();
    //                     if(isset($stage_2)){
    //                         $folderPath = 'public/application/' . $pointer_id . '/stage_2';
    //                         echo $folderPath;
    //                         echo "\n";
    //                         // if(is_dir($folderPath)){
    //                         //     function deleteFolder_2($folderPath) {
    //                         //         if (!is_dir($folderPath)) {
    //                         //             return;
    //                         //         }
                                
    //                         //         $files = array_diff(scandir($folderPath), ['.', '..']);
                                
    //                         //         foreach ($files as $file) {
    //                         //             $filePath = $folderPath . '/' . $file;
                                
    //                         //             if (is_dir($filePath)) {
    //                         //                 deleteFolder_2($filePath);
    //                         //             } else {
    //                         //                 unlink($filePath);
    //                         //             }
    //                         //         }
                                
    //                         //         rmdir($folderPath);
    //                         //     }
    //                         // }
    //                             echo $folderPath;
    //                             // exit;
    //                         if (is_dir($folderPath)) {
    //                             $folders = glob($folderPath . '/*', GLOB_ONLYDIR);
                            
    //                             foreach ($folders as $folder) {
    //                                 customDeleteDirectory($folder);
    //                             }
                            
    //                             // Delete the main folder and its contents
    //                             customDeleteDirectory($folderPath);
                            
    //                             echo "Folders and their contents deleted.";
    //                         } else {
    //                             echo "Folder does not exist.";
    //                         }
                            
                            
        
    //                         if($this->stage_2_model->where('id', $stage_2->id)->delete()){
    //                             echo "stage_2 ".$stage_2->id." deleted";
    //                             echo "\n";
    //                         };
    //                     }
    //                 $data = array(
    //                     'stage' => 'stage_1',
    //                     'status'=>'Expired',
    //                 );
            
    //                 if($this->application_pointer_model->where('id', $pointer_id)->set($data)->update()){
    //                     echo "application_pointer ".$pointer_id." updated";
    //                     echo "\n";
                
    //                 };
    //                 $data_2 = array(
    //                     'status'=>'Expired',
    //                 );
    //                 if($this->stage_1_model->where('pointer_id', $pointer_id)->set($data_2)->update()){
    //                     echo "stage_1 ".$pointer_id." updated";
    //                     echo "\n";
    //                 }

    //           }else{
    //                 echo "nothing to update";
    //           }
    //         } 
    //     }else{
    //         echo "nothing to update";
    //     }
    // }

    //code by rohit 
 public function check_email_reminder(){
     //echo "check_email_reminder";
             $secondsIn5Days = 5 * 24 * 60 * 60; // 5 days in seconds
             $secondsIn10Days = 10 * 24 * 60 * 60;
             $secondsIn15Days = 15 * 24 * 60 * 60;
          $stage2_data = $this->stage_2_model->where(['status' => 'Submitted'])->findAll();
             //$email_verification = $this->email_verification_model->where(['is_verification_done' => 0, 'verification_email_send' => 1])->groupBy("pointer_id")->findAll();
             $email_verification = $this->email_verification_model->where(['is_verification_done' => 0, 'verification_email_send' => 1])->findAll();
              foreach($stage2_data as $stage2_item){
                 $pointer_id=$stage2_item['pointer_id'];
                 $status=$stage2_item['status'];
                 $email_reminder_date = $stage2_item['email_reminder_date'];
                 $emailReminderDateTimestamp = strtotime($stage2_item['email_reminder_date']);  
                  //$email_reminder_datta= $this->email_verification_model->where(['email_reminder_date !=' => '0000-00-00 00:00:00.000000','is_verification_done' => 0, 'verification_email_send' => 1])
              $email_reminder_datta= $this->email_verification_model->where(['pointer_id' => $pointer_id,'verification_type' => 'Verification Email - Employment', 'email_reminder_date !=' => NULL,'is_verification_done' => 0, 'verification_email_send' => 1])
                  ->groupBy("pointer_id")->first();
             echo $this->email_verification_model->getLastQuery();
             exit;
             if($email_reminder_datta['verification_email_send'] == 1 && $email_reminder_datta['is_verification_done'] == 0){
                if (!empty($email_reminder_date) && $email_reminder_date != null) {
            
                        $email_reminder_date = $stage2_item['email_reminder_date'];
                        $emailReminderDateTimestamp = strtotime($email_reminder_date);
                        $givenDate = new GlobalDateTime("@$emailReminderDateTimestamp");
                        $currentDate = new GlobalDateTime();
                        $differenceInDays = $currentDate->diff($givenDate)->days; 
                 if($differenceInDays === 15){
                                    $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '201'])->first();
                                    $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
                                    $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);
                                    $to =env('ADMIN_EMAIL');
                if ($stage2_item["email_status_cronjob"] !=15) {
                 $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body, [],[],[],[], $pointer_id); 
                   
                     $data = [
                    'email_status_cronjob' => 15,
                    
                  ];
              $update_reminder =  $this->stage_2_model->where(['pointer_id'=>$pointer_id])->set($data)->update();
                         echo "admin email send succesfully".$pointer_id."days:"."15"."<br>";
                         
                                } 
                     
                 }
          }
          }
         }
          
          foreach($email_verification as $email_verification__){
              //print_r($email_verification__);
            $pointer_id=$email_verification__['pointer_id'];
             $user = find_one_row('application_pointer', 'id', $pointer_id);
             $user_deitails = find_one_row('user_account','id',$user->user_id);
             $account_type = $user_deitails->account_type;
             $doc_ids_json = $email_verification__['document_ids'];
         
            $stage2_data__= $this->stage_2_model->where(['pointer_id' => $pointer_id, 'status' => 'Submitted'])->first();
            if ($stage2_data__ !== null && isset($stage2_data__['email_reminder_date'])) {
              $email_reminder_date = $stage2_data__['email_reminder_date'];    
        
      
             if($email_verification__['is_verification_done'] == 0 && $email_verification__['verification_email_send']== 1){
              if (!empty($email_reminder_date) && $email_reminder_date != null) {
              //echo $email_reminder_date;
                    //   $email_reminder_date = $stage2_data__['email_reminder_date'];
                    //     $emailReminderDateTimestamp = strtotime($email_reminder_date);
                    //     $givenDate = new GlobalDateTime("@$emailReminderDateTimestamp");
                    //     $currentDate = new GlobalDateTime();
                    //     echo $differenceInDays = $currentDate->diff($givenDate)->days;
                    //     echo "<br>";
                    //      if ($differenceInDays === 4) { 
                    //         echo $send_email_status=5;
                    //         echo $pointer_id;
                    //      }elseif($differenceInDays === 9){
                    //         $send_email_status=10;
                    //      }else{
                    //          $send_email_status='';
                    //      }
                        $email_reminder_date = $stage2_data__['email_reminder_date'];
                        $emailReminderDateTimestamp = strtotime($email_reminder_date);
                        $givenDate = new DateTime("@$emailReminderDateTimestamp");
                        $currentDate = new DateTime();
                        $differenceInDays = $currentDate->diff($givenDate)->days;
                      // echo "Difference in days: $differenceInDays";
                        if ($differenceInDays == 5) {
                          echo  $pointer_id."Refrees days:".$send_email_status = 5;
                        } elseif ($differenceInDays == 10) {
                          echo  $pointer_id."Refrees days:".$send_email_status = 10;
                        } else {
                            $send_email_status = '';
                        }
 
        //     if($account_type == 'Applicant'){
        //     //Application mail sending
        //     $mail_temp_3_ = $this->mail_template_model->asObject()->where(['id' => '200'])->first();
        //     $mail_subject_ref = mail_tag_replace($mail_temp_3_->subject, $pointer_id);
        //     $mail_body_ref = mail_tag_replace($mail_temp_3_->body, $pointer_id);
        //     $employes_ref = find_one_row('stage_2_add_employment', 'pointer_id', $pointer_id);
        //     $to_ref = $employes_ref->referee_email;
        //      if($send_email_status == '5'){
        //       $check_reff = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to_ref, $mail_subject_ref, $mail_body_ref, [], [], [], []);
        //     }elseif($send_email_status == '10'){
        //         $check_reff = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to_ref, $mail_subject_ref, $mail_body_ref, [], [], [], []);
        //     }else{
        //         $send_email_status='';
        //     }
            
        //   }    
          if($send_email_status == 5 || $send_email_status == 10){
             $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '102'])->first();
             $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
             $mail_body = mail_tag_replace($mail_temp_1->body, $pointer_id);
          }
            // echo $mail_subject;exit;
           
             $employes = find_multiple_rows('stage_2_add_employment', 'pointer_id', $pointer_id);
             
             $mail_check = 0;
             $database_check = 0;
          if($send_email_status == 5 || $send_email_status == 10){
            foreach ($employes as $employe) {
                // email send ------------
              // print_r($employe);
                
                $subject = str_replace('%add_employment_company_name%', $employe->company_organisation_name, $mail_subject);
                $message = str_replace('%add_employment_referee_name%', $employe->referee_name, $mail_body);
                $to = $employe->referee_email;
                
                $employe_id = $employe->id;
                $check_exist =$this->email_verification_model->where(['verification_email_send' => 1,'is_verification_done' => 0, 'pointer_id' => $pointer_id, 'employer_id' => $employe->id])->first();
                //print_r($check_exist);
               
                if(!empty($check_exist)){
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
                        
                         // Check if the JSON data is valid
                if ($doc_ids_json !== null) {
                    // Decode the JSON string into an array and ensure all elements are strings
                    $doc_ids = json_decode($doc_ids_json, true);
                    //print_r($doc_ids);
                    if(is_array($doc_ids) && !empty($doc_ids)) {
                    foreach($doc_ids as $doc_ids__){
                        $documents__= $this->documents_model->where('id', $doc_ids__)->first();
                      //  echo "<pre>".$pointer_id;
                      // print_r($documents__);
                         if (!empty($documents__)) {
                            $document_name = $documents__['document_name'];
                            $document_path = $documents__['document_path'];
                            $file_name = $documents__['name'];
                            if (file_exists($document_path . "/" . $document_name)) {
                                $addAttachment[] = [
                                    'file_path' => $document_path . "/" . $document_name,
                                    'file_name' => $document_name
                                ];
                            }
                        }
                        
                    }
                    }
                   
                } 
            if($send_email_status == '5'){
                if ($stage2_data__["email_status_cronjob"] !=5) {
                $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);
                    
           
              $data = [
                    'email_status_cronjob' => 5,
                    
                  ];
                  
              $update_reminder =  $this->stage_2_model->where(['pointer_id'=>$pointer_id])->set($data)->update();
    
        }
            }elseif($send_email_status == '10'){
                 if ($stage2_data__["email_status_cronjob"] !=10) {
                 $check = verification_(env('SERVER_EMAIL'), env('verification_SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], [], $addAttachment);  
                 
                  $data = [
                    'email_status_cronjob' => 10,
                    
                  ];
                  
              $update_reminder =  $this->stage_2_model->where(['pointer_id'=>$pointer_id])->set($data)->update();
            }
            }   
            }
        }
          }
      }
             }
             
          }
          
          }
          
}
//code by rohit 29 sep 2023 and remodified 27/10/23

public function zoom_reminder(){
   // echo "hello";
        
        
        // $result now contains the combined data from both tables
          $stage_3_interview = $this->stage_3_interview_booking_model
        ->join('email_interview_location', 'email_interview_location.pointer_id = stage_3_interview_booking.pointer_id', 'inner')
        ->select('stage_3_interview_booking.id as stage_3_id')
        ->select('email_interview_location.id as email_location_id')
        ->select('stage_3_interview_booking.*')
        ->select('email_interview_location.*')
        ->asObject()
        ->findAll();
         foreach ($stage_3_interview as $stage_3_interview__){
             $location_id=$stage_3_interview__->location_id;
            
          $allowedLocationIds = [1, 2, 3, 4,10, 17, 11,9];
          
          //if (in_array($location_id, $allowedLocationIds)
          if(in_array($location_id, $allowedLocationIds) && $stage_3_interview__->stage == 'stage_3'){
              
              
            //   echo "<pre>";
            //   print_r($stage_3_interview__);
          
         $stage_3_interview_booking_id =$stage_3_interview__->stage_3_id;
         $pointer_id = $stage_3_interview__->pointer_id;
        // $email_cc = $this->request->getPost('email_cc');
         if(!empty($stage_3_interview__->meeting_id)){
              $meeting_id =$stage_3_interview__->meeting_id;
         }else{
              $meeting_id ='N/A';
         }
          if(!empty($stage_3_interview__->passcode)){
              $passcode = $stage_3_interview__->passcode; 
         }else{
              $passcode = 'N/A'; 
         }
         $email_interview_location_id =$stage_3_interview__->email_location_id;
        
             $date = $stage_3_interview__->date_time;
            // Convert the string to a DateTime object
            $dateTimeFromDatabase = new GlobalDateTime($date);
            $oneDayBefore = clone $dateTimeFromDatabase;
            $oneDayBefore->modify('-1 day');
            // Get the current date
             $currentDate = new GlobalDateTime();
              $currentDate->format('Y-m-d');
            // Compare dates without the time part
            if ($oneDayBefore->format('Y-m-d') == $currentDate->format('Y-m-d')) {
              $send_mail=1;
              echo $pointer_id."stage3";
            } else {
                $send_mail=0;
            }
        if($send_mail==1){
        $stage_3_interview = $this->stage_3_interview_booking_model->where('id', $stage_3_interview_booking_id)->asobject()->first();
        $location_id = $stage_3_interview->location_id;
        if($location_id){
            $location = $this->stage_3_offline_location_model->where('id', $location_id)->asobject()->first();
        }
        
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '202'])->first();
        $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
        $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
        $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d' , strtotime($stage_3_interview->date_time)), $day_time);
        $date_time = str_replace('%s3_interview_time%', date('H:i', strtotime($stage_3_interview->date_time)), $get_slot_time);
        $meeting_id_change = str_replace('%meeting_id%', $meeting_id, $date_time);
        $message = str_replace('%passcode%', $passcode, $meeting_id_change);
        $to = $location->email;
    
        $email_cc = $location->email_cc;

        $mail_cc = array_map('trim', explode(', ', $email_cc));

        if(empty($email_cc)){
            $mail_cc = [];
        }
       if($stage_3_interview->zoom_reminder_status == NULL){
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
        $data = ['zoom_reminder_status' => 1];
        $this->stage_3_interview_booking_model->where(['pointer_id'=>$pointer_id])->set($data)->update();
            
        }
        
            }
             
             
         }
         }
        
        //srart stage3 reassesement
        
         $s3_reassesement = $this->stage_3_reassessment_interview_booking_model
        ->join('email_interview_location', 'email_interview_location.pointer_id = stage_3_reassessment_interview_booking.pointer_id', 'inner')
        ->select('stage_3_reassessment_interview_booking.id as stage_3_reassessment_id')
        ->select('email_interview_location.id as email_location_id')
        ->select('stage_3_reassessment_interview_booking.*')
        ->select('email_interview_location.*')
        ->asObject()
        ->findAll();
        foreach($s3_reassesement as $s3_reassesement__){
            //print_r($s3_reassesement__);
          $location_id=$s3_reassesement__->location_id;
             $allowedLocationIds = [1, 2, 3, 4,10, 17, 11,9];
            if(in_array($location_id, $allowedLocationIds) && $s3_reassesement__->stage== 'stage_3_R'){
                
          $stage_3_reass_interview_booking_id =$s3_reassesement__->id;
          $pointer_id =$s3_reassesement__->pointer_id;
        //   echo "<pre>";
        // print_r($s3_reassesement__);
        // $email_cc = $this->request->getPost('email_cc');
         $meeting_id = $s3_reassesement__->meeting_id;
         $passcode =$s3_reassesement__-> passcode;
         $email_interview_location_id = $s3_reassesement__->email_location_id;
         $date = $s3_reassesement__->date_time;
         
            // Convert the string to a DateTime object
            $dateTimeFromDatabase = new GlobalDateTime($date);
            $oneDayBefore = clone $dateTimeFromDatabase;
            $oneDayBefore->modify('-1 day');
            // Get the current date
            $currentDate = new GlobalDateTime();
            // Compare dates without the time part
             $oneDayBefore->format('Y-m-d');
             $currentDate->format('Y-m-d');
            if ($oneDayBefore->format('Y-m-d') == $currentDate->format('Y-m-d')) {
              $send_mail=1;
             echo $pointer_id."s3_reassesement__";
            } else {
              $send_mail=0;
            }
             
    if( $send_mail == 1){
       
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '204'])->first();
        
        // print_r($mail_temp_3);
        // die;
        $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
        $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
        $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($s3_reassesement__->date_time)), $day_time);
        $date_time = str_replace('%s3_interview_time%', date('H:i', strtotime($s3_reassesement__->date_time)), $get_slot_time);
        $meeting_id_change = str_replace('%meeting_id%', $meeting_id, $date_time);
        $message = str_replace('%passcode%', $passcode, $meeting_id_change);
        $to = $s3_reassesement__->email;
        $email_cc = $s3_reassesement__->email_cc;
        $mail_cc = array_map('trim', explode(', ', $email_cc));
        if(empty($email_cc)){
            $mail_cc = [];
        }
       if($s3_reassesement__->zoom_reminder_status == NULL){
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
      $data = ['zoom_reminder_status' => 1];
        $this->stage_3_reassessment_interview_booking_model->where(['pointer_id'=>$pointer_id])->set($data)->update();
      
       }
        
        }
        
        }
        
        }
        
        //start non-aquato
        //$non_aquato=$this->not_aqato_s3_model->asObject()->findAll();
        $non_aquato = $this->not_aqato_s3_model
        ->join('email_interview_location', 'email_interview_location.pointer_id = not_aqato_s3.id', 'inner')
        ->select('not_aqato_s3.id as not_aqato_s3_id')
        ->select('email_interview_location.id as email_location_id')
        ->select('not_aqato_s3.*')
        ->select('email_interview_location.*')
        ->asObject()
        ->findAll();
        
        foreach($non_aquato as $non_aquato__){
            {
               
                $location_id=$non_aquato__->interview_location;
                 $allowedLocationIds = [1, 2, 3, 4,9,10,11,17];
            if(in_array($location_id, $allowedLocationIds) && $non_aquato__->stage== 'non_aqato_stage_3'){
         //if($non_aquato__->interview_location == 9 && $non_aquato__->stage =='non_aqato_stage_3' ){
        //   echo "<pre>";
        //     print_r($non_aquato__);
        $not_aqato_s3_id =$non_aquato__->not_aqato_s3_id;
        $pointer_id =$non_aquato__->id;
        // $email_cc = $this->request->getPost('email_cc');
        $meeting_id = $non_aquato__->meeting_id;
        $passcode = $non_aquato__->passcode;
        $email_cc = $non_aquato__->email_cc;
        $email_interview_interview_location = $non_aquato__->id;                             
        $date=$non_aquato__->interview_date;
            // echo $email_cc;
            $dateTimeFromDatabase = new GlobalDateTime($date);
            $oneDayBefore = clone $dateTimeFromDatabase;
            $oneDayBefore->modify('-1 day');
            // Get the current date
             $currentDate = new GlobalDateTime();
            // Compare dates without the time part
            if ($oneDayBefore->format('Y-m-d') == $currentDate->format('Y-m-d')) {
              $send_mail=1;
              echo $pointer_id."non_aquato";
            } else {
                $send_mail=0;
            }
            
            if($send_mail==1 ){
        $stage_3_interview = $this->not_aqato_s3_model->where('id', $not_aqato_s3_id)->asobject()->first();
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
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '203'])->first();
        $name = str_replace('%name%',$stage_3_interview->full_name, $mail_temp_3->subject);
        $occupation = str_replace('%occupation%',$stage_3_interview->occupation_name, $name);
        // "[#" . $stage_1->unique_id . "]"
        $subject = str_replace('%unique_id%',"[#" .$stage_3_interview->unique_number. "]", $occupation);
        
        $s3_interview_venue = str_replace('%s3_interview_venue%', $location->venue, $mail_temp_3->body);
        $s3_interview_address = str_replace('%s3_interview_address%', $location->office_address, $s3_interview_venue);
        
        $get_slot_time = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $s3_interview_address);
        $date_time = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $get_slot_time);

        
        // $get_slot_time = str_replace('%s3_interview_day_and_date%', date('Y-m-d', strtotime($stage_3_interview->interview_date)), $s3_interview_address);
        // $date_time = str_replace('%s3_interview_time%', date('H:i', strtotime($stage_3_interview->interview_date)), $get_slot_time);
        $meeting_id_change = str_replace('%meeting_id%', $meeting_id, $date_time);
        $message = str_replace('%passcode%', $passcode, $meeting_id_change);
        $to = $location->email;

        $email_cc = $location->email_cc;

        $mail_cc = array_map('trim', explode(', ', $email_cc));

 
        
        if(empty($email_cc)){
            $mail_cc = [];
        }
        if($non_aquato__->zoom_reminder_status == NULL){
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $mail_cc, []);
        $data = ['zoom_reminder_status' => 1];
        $this->not_aqato_s3_model->where(['id'=>$not_aqato_s3_id])->set($data)->update();
      
       }
        
        
         
            }
 
    }
        }
        }
      
        
        
        
        
    
        
    
    
    
    }





        
        
        
        
    
        
    
    
    

    // read_email_and_Update   Done
// public function google_api()
// {
//     $Client_ID = env('Client_ID');
//     $Client_secret = env('Client_secret');
//     $API_Keys = env('API_Keys');

//     // Pre Search

//     $token = $this->token_model->orderBy("id", "DESC")->first();
//     $real_token_id__ = "";
//     if (isset($token["id"])) {
//         $real_token_id__ = $token["id"];
//     }

//     if (isset($_GET['code'])) {
//         $code = $_GET['code'];
//         $url = 'https://accounts.google.com/o/oauth2/token';
//         $params = array(
//             "code" => $code,
//             "client_id" => $Client_ID,
//             "client_secret" => $Client_secret,
//             "redirect_uri" => base_url('read_email_and_Update'),
//             "grant_type" => "authorization_code",
//             "access_type" => "offline",
//         );

//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
//         $result = json_decode(curl_exec($ch), true);
//         curl_close($ch);

//         if (isset($result['access_token'])) {
//             if (isset($result['id_token'])) {
//                 if (isset($result['expires_in'])) {
//                     $access_token = $result['access_token'];
//                     $refresh_token = $result['id_token'];
//                     $expires_in = time() + $result['expires_in'];

//                     $details = [
//                         'access_token' => $access_token,
//                         'refresh_token' => $refresh_token,
//                         'expires_in' => $expires_in
//                     ];
//                     $token = $this->token_model->where(['id' => $real_token_id__])->first();
//                     if (!empty($token)) {
//                         $this->token_model->where(['id' => $real_token_id__])->set($details)->update();
//                     } else {
//                         $this->token_model->save($details);
//                     }
//                 }
//             }
//         }
//         return redirect()->to(base_url('read_email_and_Update'));
//     }

//     $all_email_data_array = array();
//     $token = $this->token_model->where(['id' => $real_token_id__])->first();
//     if (!empty($token)) {
//         $access_token = $token['access_token'];
//         $refresh_token = $token['refresh_token'];
//         $expires_in = $token['expires_in'];

//         if (time() > $expires_in) {
//             $url_token = 'https://www.googleapis.com/oauth2/v4/token';
//             $curlPost = 'client_id=' . $Client_ID . '&client_secret=' . $Client_secret . '&refresh_token=' . $refresh_token . '&grant_type=refresh_token';
//             $ch_4 = curl_init();
//             curl_setopt($ch_4, CURLOPT_URL, $url_token);
//             curl_setopt($ch_4, CURLOPT_RETURNTRANSFER, 1);
//             curl_setopt($ch_4, CURLOPT_POST, 1);
//             curl_setopt($ch_4, CURLOPT_SSL_VERIFYPEER, FALSE);
//             curl_setopt($ch_4, CURLOPT_POSTFIELDS, $curlPost);
//             $http_code = curl_getinfo($ch_4, CURLINFO_HTTP_CODE);
//             $data = json_decode(curl_exec($ch_4), true);
            
//             if (isset($data["error"])) {
//                 if ($data["error"] == "invalid_grant") {
//                     return redirect()->to(base_url('google_api_logout'));
//                 }
//             }
            
//             if (isset($data['access_token'])) {
//                 $access_token = $data['access_token'];
//                 $expires_in = time() + $data['expires_in'];
//                 $refresh_token = $token['refresh_token'];

//                 $details = [
//                     'access_token' => $access_token,
//                     'refresh_token' => $refresh_token,
//                     'expires_in' => $expires_in
//                 ];
//                 $this->token_model->where(['id' => $real_token_id__])->set($details)->update();
//             } else {
//                 return redirect()->to(base_url('google_api_logout'));
//             }
//         }

//         $url_profile = "https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=$access_token";
//         $ch_3 = curl_init();
//         curl_setopt($ch_3, CURLOPT_URL, $url_profile);
//         curl_setopt($ch_3, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch_3, CURLOPT_SSL_VERIFYPEER, FALSE);
//         $data_profile = json_decode(curl_exec($ch_3), true);
//         curl_close($ch_3);

//         $user_id = $data_profile["id"];

//         $google_email_data = $this->application_pointer_model->where(['user_id' => $user_id])->orderBy("id", "DESC")->first();

//         if (!empty($google_email_data)) {
//             $response = array(
//                 "status" => true,
//                 "google_email_data" => $google_email_data,
//             );
//             return $response;
//         } else {
//             $application_pointer_data = array(
//                 "user_id" => $user_id,
//                 "pointer_id" => 1,
//             );
//             $insert = $this->application_pointer_model->save($application_pointer_data);

//             if ($insert) {
//                 $application_pointer_data_id = $this->application_pointer_model->getInsertID();

//                 $details = array(
//                     "application_pointer_id" => $application_pointer_data_id,
//                     "user_id" => $user_id,
//                 );
//                 $application_pointer_data = array(
//                     "user_id" => $user_id,
//                     "pointer_id" => $application_pointer_data_id,
//                 );
//                 $update = $this->application_pointer_model->where(['id' => $application_pointer_data_id])->set($details)->update();

//                 if ($update) {
//                     $application_pointer_data = $this->application_pointer_model->where(['id' => $application_pointer_data_id])->orderBy("id", "DESC")->first();
//                     $response = array(
//                         "status" => true,
//                         "google_email_data" => $application_pointer_data,
//                     );
//                     return $response;
//                 } else {
//                     $response = array(
//                         "status" => false,
//                         "message" => "Not Updated",
//                     );
//                     return $response;
//                 }
//             } else {
//                 $response = array(
//                     "status" => false,
//                     "message" => "Not Inserted",
//                 );
//                 return $response;
//             }
//         }
//     } else {
//         $authUrl = 'https://accounts.google.com/o/oauth2/auth?client_id=' . $Client_ID . '&response_type=code&scope=https://mail.google.com&redirect_uri=' . base_url('read_email_and_Update') . '&approval_prompt=force&access_type=offline';
//         return redirect()->to($authUrl);
//     }
// }

}


// end----------------------- Vishal Patel
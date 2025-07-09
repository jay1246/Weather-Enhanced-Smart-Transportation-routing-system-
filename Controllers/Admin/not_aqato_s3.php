<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use DateTime;
use DateTimeZone;

class not_aqato_s3 extends BaseController
{

    public function index()
    {
        // vishal patel 28-04-2023

        // echo $e_currentDate;
        // exit;
        $date_logic = __getFromToDate();

        // print_r($date_logic);
        // exit;

        $data['interview_locations'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['occupation_list'] = $this->occupation_list_model->asObject()->findAll();
        $data['stage_3_interview_booking_time_slots'] = $this->stage_3_interview_booking_time_slots_model->find();
        $data['not_aqato_s3_model'] =   $this->not_aqato_s3_model->asObject()->where(["interview_date >= " => $date_logic['s_date']])->orderby('interview_date', 'ASC')->findAll();
        $data['countries'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['time_zone'] = $this->time_zone_model->groupBy('zone_name')->findAll();

        return view('admin/interview_booking/not_aqato_s3', $data);
    }


    // -------------- interview_location end ----------------
    // public function interview_location()
    // {
    //     return view('admin/interview_location/index', $data);
    // }

    // admin/not_aqato_s3/insert_booking // vishal patel 28-04-2023
    public function insert_booking()
    {
        
        $date_logic = __getFromToDate();

        $full_name = $_POST['full_name'];
        $occupation_name = $_POST['occupation_name'];
        $unique_number = $_POST['unique_number'];
        $interview_location = $_POST['interview_location'];
        $dob=$_POST['dob'];
        $pathway=$_POST['pathway'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $interview_date = $datetime->format('Y-m-d H:i:s');

        $details = array(
            'full_name' => $full_name,
            'occupation_name' => $occupation_name,
            'unique_number' => $unique_number,
            'interview_date' => $interview_date,
            'interview_location' => $interview_location,
             'dob'=>$dob,
             'pathway'=>$pathway,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' =>  date("Y-m-d H:i:s")
        );

        $not_aqato_s3_Check = $this->not_aqato_s3_model->where(['unique_number' => $unique_number, "interview_date >= " => $date_logic['s_date']])->first();
        if (empty($not_aqato_s3_Check)) {
            if ($this->not_aqato_s3_model->insert($details)) {


                // vishal patel 28-04-2023

                // NON_AQATO_admin_head_office
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '115'])->first();
                if (!empty($mail_temp_3)) {
                    $subject = $mail_temp_3->subject;
                    $body = $mail_temp_3->body;

                    $subject = str_replace('%full_name%', $full_name, $subject);
                    $subject = str_replace('%occupation_name%', $occupation_name, $subject);
                    $subject = str_replace('%unique_number%', $unique_number, $subject);

                    // stage 3 
                    if (isset($interview_location)) {
                        $stage_3_offline_location_id = $interview_location;
                        $date_time = $interview_date;

                        $s3_interview_day_and_date = "";
                        $s3_interview_time_A = "";
                        if (!empty($date_time)) {
                            $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
                            $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
                        }

                        $stage_3_offline_location = find_one_row('stage_3_offline_location', 'id', $stage_3_offline_location_id);

                        $date_time_zone = (isset($stage_3_offline_location->date_time_zone)) ? $stage_3_offline_location->date_time_zone : "";


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

                        $body = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $body);
                        $body = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $body);
                        $body = str_replace('%s3_interview_venue%', $s3_interview_venue, $body);
                        $body = str_replace('%s3_interview_address%', $s3_interview_address, $body);
                    }



                    // Applicant Email
                    $to = env('HEADOFFICE_EMAIL');
                    $mail_check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $body);
                    $to = env('ADMIN_EMAIL');
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $body);
                    if ($mail_check == 1) { // vishal patel 28-04-2023
                        echo "ok";
                    }
                }
                
                $this->sendToTheOffshoreLocationMail($full_name,$occupation_name,$unique_number,$interview_location,$interview_date);
            }
        } else {
            echo "exist not add";
        }
    }

    public function insert_booking_edite()
    {

        $full_name = $_POST['full_name'];
        $occupation_name = $_POST['occupation_name'];
        $unique_number = $_POST['unique_number'];
        $interview_location = $_POST['interview_location'];

        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $interview_date = $datetime->format('Y-m-d H:i:s');

        $details = array(
            'full_name' => $full_name,
            'occupation_name' => $occupation_name,
            'unique_number' => $unique_number,
            'interview_date' => $interview_date,
            'interview_location' => $interview_location,
            'update_date' => date("Y-m-d H:i:s"),
            'create_date' =>  date("Y-m-d H:i:s")
        );

        $not_aqato_s3_Check = $this->not_aqato_s3_model->where(['unique_number' => $unique_number])->first();
        if (!empty($not_aqato_s3_Check)) {
            if ($this->not_aqato_s3_model->set($details)->where(['unique_number' => $unique_number])->update()) {
                echo "ok";
                return redirect()->to(base_url('admin/not_aqato_s3'));
            }
        }
    }
    
    
    
    public function send_mail_non_aqato_zoom_meet()
    {
        $not_aqato_s3_id =  $this->request->getPost('not_aqato_s3_id');
        $pointer_id = $this->request->getPost("not_aqato_s3_id");
        // $email_cc = $this->request->getPost('email_cc');
        $meeting_id = $this->request->getPost('meeting_id');
        $passcode = $this->request->getPost('passcode');
        $email_interview_location_id = $this->request->getPost('email_interview_location_id');
        
            // echo $email_cc;
            // exit;
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

        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '192'])->first();
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
                'pointer_id' => $not_aqato_s3_id,
                'stage' => 'non_aqato_stage_3',
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
                'pointer_id' => $not_aqato_s3_id,
                'stage' => 'non_aqato_stage_3',
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
                'not_aqato_s3_id' => $not_aqato_s3_id,
            );
        } else {
            $callback = array(
                "msg" => "mail not send",
                "color" => "danger",
                "response" => false,
                'not_aqato_s3_id' => $not_aqato_s3_id,
            );
        }
        echo json_encode($callback);
 
    }
    
    public function sendToTheOffshoreLocationMail($full_name, $occupation_name, $unique_number, $interview_location, $interview_date){
                    
                // echo $interview_location;
                // exit;
                $stage_3_offline_location = find_one_row('stage_3_offline_location', 'id', $interview_location);
                if($stage_3_offline_location->venue == "AQATO"){
                // NON_AQATO_admin_head_office
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '222'])->first();
                if (!empty($mail_temp_3)) {
                    $subject = $mail_temp_3->subject;
                    $body = $mail_temp_3->body;

                    $subject = str_replace('%full_name%', $full_name, $subject);
                    $subject = str_replace('%occupation_name%', $occupation_name, $subject);
                    $subject = str_replace('%unique_number%', $unique_number, $subject);

                    // stage 3 
                    if (isset($interview_location)) {
                        $stage_3_offline_location_id = $interview_location;
                        $date_time = $interview_date;

                        $s3_interview_day_and_date = "";
                        $s3_interview_time_A = "";
                        if (!empty($date_time)) {
                            $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
                            $s3_interview_time_A = date('h:i A', strtotime($date_time)) . " (Australia/Brisbane Time)";
                        }

                        $stage_3_offline_location = find_one_row('stage_3_offline_location', 'id', $stage_3_offline_location_id);
                        

                        $date_time_zone = (isset($stage_3_offline_location->date_time_zone)) ? $stage_3_offline_location->date_time_zone : "";


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

                        $body = str_replace('%s3_interview_day_and_date%', $s3_interview_day_and_date, $body);
                        $body = str_replace('%s3_interview_time%', $s3_interview_time_A . " / " . $s3_interview_time_B, $body);
                        $body = str_replace('%s3_interview_venue%', $s3_interview_venue, $body);
                        $body = str_replace('%s3_interview_address%', $s3_interview_address, $body);
                    }
                    
                    $to = $stage_3_offline_location->email;
    
                    $email_cc = $stage_3_offline_location->email_cc;
            
                    $mail_cc = array_map('trim', explode(', ', $email_cc));
            
                   
                    if(empty($email_cc)){
                        $mail_cc = [];
                    }
                   
                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $body, [], [], $mail_cc, []);
                    }
                } //end of if
    }
    
}

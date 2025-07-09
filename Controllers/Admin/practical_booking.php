<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use DateTime as GlobalDateTime;
use DateTime;
use DateTimeZone;

class practical_booking extends BaseController
{

 // -------------- Practical_calendar ----------------

    public function  practical_calendar()
    {
        $data['title'] = "interview_calendar";

        return view('admin/interview_calendar/index', $data);
    }
    // -------------- Practical_calendar end ----------------

    // -------------- Practical_location end ----------------
    public function practical_location()
    {
        $data['interview_locations'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['countries'] = $this->country_model->asObject()->findAll();
       
        return view('admin/interview_location/index', $data);
    }

    public function update()
    {
        $data = $this->request->getvar();

        $id = $data['id'];

        $details = array(
            'city_name' => $data['city_name'],
            'country' => $data['country'],
            'venue' => $data['venue'],
            'office_address' => $data['office_address'],
            'contact_details' => $data['contact_details'],
            'reg_date' =>  date("Y-m-d H:i:s")
        );
        if ($this->stage_3_offline_location_model->update($id, $details)) {
            $callback = array(
                "color" => "success",
                "msg" => "update recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to update record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
    // -------------- Practical_location end ----------------
    
    
  public function practical_booking_cancle(){
   
      
         $id=$this->request->getPost('id');
        $stage_interview_booking=find_one_row('stage_4_practical_booking','id',$id);
        $pointer_id=$stage_interview_booking->pointer_id;
        $application_pointer=find_one_row('application_pointer','id',$pointer_id)->user_id;
       
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
        $insert_stage3_cancle_req= $this->stage4_cancle_interview_booking->set($details)->insert();
         $update_data = [ 'status'=>'Lodged'];
         $update_interview_comment= $this->stage_4_model->where('pointer_id', $pointer_id)->set($update_data)->update();
        if($update_interview_comment){
        $application_p=['status'=>'Lodged' ];
        $application_update=$this->application_pointer_model->where('id', $pointer_id)->set($application_p)->update();
        
           
      
   
   ///MAIL SEND START
       if($acount_type == 'applicant'){
         $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '231'])->first();
         $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
         $mail_body = str_replace('%occupation_reason_for_decline_stage_4_interview_booking% ', $option, $mail_body_reason);
         $to=$applicant_email;
        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body, [],[],[],[]);
        }
        if($acount_type == 'Agent'){
         $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '230'])->first();
         $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
         $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
          $mail_body = str_replace('%occupation_reason_for_decline_stage_4_interview_booking% ', $option, $mail_body_reason);
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
        
    //FOR ADMIN AND HEAD_OFFICE
           $mail_temp_1 = $this->mail_template_model->asObject()->where(['id' => '229'])->first();
           $mail_subject = mail_tag_replace($mail_temp_1->subject, $pointer_id);
           $mail_body_reason = mail_tag_replace($mail_temp_1->body, $pointer_id);
           $mail_body = str_replace('%occupation_reason_for_decline_stage_4_interview_booking% ', $option, $mail_body_reason);
           $to = env('ADMIN_EMAIL');
           $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
           $to = env('HEADOFFICE_EMAIL');
           $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $mail_subject, $mail_body,[],[],[],[],$pointer_id);
           //for delete req
          $stage_3_interview_del = $this->stage_4_practical_booking_model->where('pointer_id', $pointer_id)->asobject()->delete();
        // $email_interview_location = $this->email_interview_location_model->where(['pointer_id' => $pointer_id, 'stage' => 'stage_4'])->asObject()->delete();
        if($Email_send_check_2 && $Email_send_check){
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

    // -------------- Practical_booking ----------------
    public function practical_booking()
    {
        $data['practical_bookings'] = $this->stage_4_practical_booking_model->asObject()->findAll();
        $data['countries'] = $this->stage_3_offline_location_model->asObject()->findAll();
        $data['applicants'] = $this->stage_4_model->where('status', 'Lodged')->asObject()->findAll();


        $data['time_zone'] = $this->time_zone_model->groupBy('zone_name')->findAll();

        $data['stage_4_practical_booking_time_slots'] = $this->stage_3_interview_booking_time_slots_model->find();
        
        
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

        $data['location'] =  $location;
 $data['page']="Practical Bookings";

        
        return view('admin/practical_booking/index', $data);

        // time_zone
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

    public function insert_booking()
    {
        
        $database_check = 0;
        $database_check_1 = 0;
        $mail_check = 0;

        $stage_4_id = $this->request->getPost("applicant_name_id");
        $location_name = $this->request->getPost("venue");
        // $date = $this->request->getPost("date");

        $stage_3_offline_location = find_one_row('stage_3_offline_location', 'city_name', $location_name);
        $location_id = $stage_3_offline_location->id;
        $venue__ = $stage_3_offline_location->venue;
        $address__ = $stage_3_offline_location->office_address;
        
        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = \DateTime::createFromFormat('Y-m-d h:i A', $date . ' ' . $time);
        $date = $datetime->format('Y-m-d H:i:s');


        $time_zone = (isset($_POST['time_zone'])) ? $_POST['time_zone'] : "";
        $stage_4 = find_one_row('stage_4', 'id', $stage_4_id);
        $pointer_id = $stage_4->pointer_id;
        
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
        
        
        if ($this->stage_4_practical_booking_model->insert($details)) {
            $database_check = 1;
        }
        
        // print_r($database_check);
        // exit;    
        $application_pointer = find_one_row('application_pointer', 'id', $pointer_id);
        $user_account = find_one_row('user_account', 'id', $application_pointer->user_id);

        $Applicant_email = [];
        $stage_1_contact_details_ = $this->stage_1_contact_details_model->where(['pointer_id' => $pointer_id])->first();
        if (!empty($stage_1_contact_details_)) {
            $Applicant_email[] = $stage_1_contact_details_['email'];
        }

        // print_r($Applicant_email);
        // exit;

        // Time Converting
        
        $date_time = $date;
        $date_time_zone = $stage_3_offline_location->date_time_zone;
        
        // 
        $s3_interview_time_A = "";
        $date__ = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
        // $date__->setTimezone(new DateTimeZone($date_time_zone));
        $s3_interview_time_A = $date__->format('h:i A') . " (" . $date_time_zone . " Time)";
        
        // END

        $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
        // if($location_id == 16){
        //      $s3_interview_time_A = date('h:i A', strtotime($date)) . " (Australia/Brisbane Time)";
        // }else{
        //      $s3_interview_time_A = date('h:i A', strtotime($date)) . " (Europe/London)";
        // }
           

        // location_id == 9     Online (Via Zoom)
        if ($location_id == 9) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") { // Applicant
                // s3_agent_online_scheduled
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '131'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                // This is for Exception Online Zoom
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
                $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                $to = $user_account->email;

                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                } else {
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                }
            }
            if ($client_type == "Applicant") {

                //s3_online_scheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '131'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
                $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }


            //s3_admin_online_scheduled checking for 96
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '123'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
            $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            if ($check_1 == 1 && $check == 1) {
                $mail_check = 1;
            }
        } else {
            $client_type =  is_Agent_Applicant($pointer_id);
            
            if ($client_type == "Agent") { // Applicant
                // s3_scheduled_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '131'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
                $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                $message = str_replace('%s4_practical_venue%', $venue__, $message);
                $message = str_replace('%s4_practical_address%',$address__ , $message);
                
                // echo $message;
                // exit;
                // Applicant Email
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                } else {
                    $mail_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[], $pointer_id);
                }
            }
            if ($client_type == "Applicant") {
                //s4_scheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '144'])->first();
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                
                
                
                
                $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
                $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                $message = str_replace('%s4_practical_venue%', $venue__, $message);
                $message = str_replace('%s4_practical_address%',$address__ , $message);
                $to = $user_account->email;
                $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                if ($check == 1) {
                    $mail_check = 1;
                }
            }

            //s4_scheduled_admin
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '123'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
            $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
            $message = str_replace('%s4_practical_venue%', $venue__, $message);
            $message = str_replace('%s4_practical_address%',$address__ , $message);
            $to = env('ADMIN_EMAIL');
            $check_1 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            if ($check_1 == 1 && $check == 1) {
                $mail_check = 1;
            }
        }

        //database record for mail 3 
        $admin_status = [
            'status' => "Scheduled",
            'scheduled_date' => date("Y-m-d H:i:s"),
            'scheduled_by' => session()->get('admin_id'),
            'update_date' => date("Y-m-d H:i:s")
        ];
        // if ($this->stage_3_model->update($stage_3_id, $admin_status)) {
        if ($this->stage_4_model->where('id', $stage_4_id)->set($admin_status)->update()) {
            $database_check_1 = 1;
        }
        $pointer_data = [
            'stage' => 'stage_4',
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


    // Reschdule
    public function update_booking()
    {
        $stage_4_interview_booking_id =  $this->request->getPost('stage_3_interview_booking_id');
        $pointer_id = $this->request->getPost("pointer_id");
        $location_id = $this->request->getPost("venue");
        $time_zone = (isset($_POST['time_zone'])) ? $_POST['time_zone'] : "";
        $stage_3_offline_location = find_one_row('stage_3_offline_location', 'id', $location_id);
       // $location_id = $stage_3_offline_location->id;
        $venue__ = $stage_3_offline_location->venue;
        $address__ = $stage_3_offline_location->office_address;
        
        
        
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
        );
        // $stage_4_interview_booking_update =  $this->stage_4_interview_booking_model->update($stage_4_interview_booking_id, $details);
        $stage_4_practical_booking_update =  $this->stage_4_practical_booking_model->where('id', $stage_4_interview_booking_id)->set($details)->update();

        // table 2 update --------------------------------------
        $admin_status = [
            'status' => "Scheduled",
            'scheduled_date' => date("Y-m-d H:i:s"),
            'scheduled_by' => session()->get('admin_id'),
            'update_date' => date("Y-m-d H:i:s")
        ];
        // $stage_4_update = $this->stage_4_model->update($stage_3_id, $admin_status);
        $stage_4_update =  $this->stage_4_model->where('pointer_id', $pointer_id)->set($admin_status)->update();


        // table 3 update --------------------------------------
        $pointer_data = [
            'stage' => 'stage_4',
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

        // echo $location_id;
        // exit;
        
        
        
        // Time Converting
        
        $date_time = $date;
        $date_time_zone = $stage_3_offline_location->date_time_zone;
        
        // Time Convert
        $s3_interview_time_A = "";
        $date__ = new DateTime(date('Y-m-d H:i:s', strtotime($date_time)));
        // $date__->setTimezone(new DateTimeZone($date_time_zone));
        $s3_interview_time_A = $date__->format('h:i A') . " (" . $date_time_zone . " Time)";
        // END
        
        
        

            $s3_interview_day_and_date = date('l, jS F Y', strtotime($date_time));
            //     if($location_id == 16){
            //      $s3_interview_time_A = date('h:i A', strtotime($date)) . " (Australia/Brisbane Time)";
            // }else{
            //      $s3_interview_time_A = date('h:i A', strtotime($date)) . " (Europe/London)";
            // }
                //$s3_interview_time_A = date('h:i A', strtotime($date)) . " (Australia/Brisbane Time)";
        // location_id == 9     Online (Via Zoom)
        if ($location_id == 9) {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //   s4_agent_online_rescheduled
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '132'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
                $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);

                
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                } else {
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                }
            }

            if ($client_type == "Applicant") {
                //   s4_online_rescheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '132'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s4_practical_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s4_practical_time%', date('H:i', strtotime($date)), $get_slot_time);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                }
            }

            //   s4_admin_online_rescheduled
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '124'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
            $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            if ($Email_send_check == 1 && $Email_send_check_2 == 1) {
                $Email_send_check = 1;
            }
        } else {
            $client_type =  is_Agent_Applicant($pointer_id);
            if ($client_type == "Agent") {
                //   s3_re_scheduled_agent
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '132'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                // 
                // 
                $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
                $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
              //  $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                    $message = str_replace('%s4_practical_venue%', $venue__, $message);
                    $message = str_replace('%s4_practical_address%',$address__ , $message);
                // 
                // echo $message;
                // exit;
                
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message, [], [], $Applicant_email,[], $pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                } else {
                    $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                }
            }

            if ($client_type == "Applicant") {
                //   s3_rescheduled_applicant
                $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '132'])->first();
                $to = $user_account->email;
                $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
                $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
                $get_slot_time = str_replace('%s4_practical_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
                $message = str_replace('%s4_practical_time%', date('H:i', strtotime($date)), $get_slot_time);
               // $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                    $message = str_replace('%s4_practical_venue%', $venue__, $message);
                    $message = str_replace('%s4_practical_address%',$address__ , $message);
                $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
                if ($Email_send_check == 1) {
                    $Email_send_check = 1;
                }
            }

            //   s3_scheduled_admin
            $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => '124'])->first();
            $subject = mail_tag_replace($mail_temp_3->subject, $pointer_id);
            $day_time = mail_tag_replace($mail_temp_3->body, $pointer_id);
            
            
            $get_slot_time = str_replace('%s4_practical_day_and_date%', $s3_interview_day_and_date, $day_time);
            $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
           // $message = str_replace('%s4_practical_time%', $s3_interview_time_A, $get_slot_time);
                    $message = str_replace('%s4_practical_venue%', $venue__, $message);
                    $message = str_replace('%s4_practical_address%',$address__ , $message);
            
            // $get_slot_time = str_replace('%s4_practical_day_and_date%', date('Y-m-d', strtotime($date)), $day_time);
            // $message = str_replace('%s4_practical_time%', date('H:i', strtotime($date)), $get_slot_time);
            $to = env('ADMIN_EMAIL');
            $Email_send_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            // new add on 04-04-2023 by vishal as par clint call
            $to = env('HEADOFFICE_EMAIL');
            $Email_send_check_2 = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message,[],[],[],[],$pointer_id);
            if ($Email_send_check == 1 && $Email_send_check_2 == 1) {
                $Email_send_check = 1;
            }
        }


        //database record for mail 3 end
        if ($Email_send_check || $stage_4_practical_booking_update && $stage_4_update) {
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

    // -------------- Practical_booking end ----------------
}
?>

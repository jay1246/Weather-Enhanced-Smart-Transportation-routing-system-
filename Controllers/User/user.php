<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class user extends BaseController
{
    public function dashboard_page()
    {
        $Incomplete_count = 0;
        $submit_count = 0;

        $data = $this->application_pointer_model->where('user_id', session()->get('user_id'))->find();

        foreach ($data as $key => $value) {
            $stage_index = application_stage_no($value['id']);
            if ($stage_index == 1) {
                $Incomplete_count++;
            }
            if ($stage_index > 1) {
                $submit_count++;
            }
        }


        $any_running = 0;
        $i = 0;
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



                $stage_1 = find_one_row('stage_1', 'pointer_id', $pointer_id);
                $submitted_date = $stage_1->submitted_date;
                $singal_table_data['submitted_date'] = $submitted_date;

                $submitted_date = strtotime($submitted_date);
                $submitted_date =  date("d/m/Y", $submitted_date);
                $submitted_date = empty($submitted_date) ? '--//--' : $submitted_date;
                $singal_table_data['submitted_date_format'] = $submitted_date;



                $table_data[] = $singal_table_data;
            }
        }
        foreach ($table_data as $key => $res) {
            $pointer_id = $res['pointer_id'];
            $status =  trim(create_status_rename($res['status_format'],$pointer_id));
            if ($status == "S1 - Expired") {
                if (stage_1_expired_day_new($pointer_id) <= -31) {
                    $status = "Closed";
                }
            }
            // echo $status;
            if ($status != 'Completed' and $status != 'Closed') {
                $any_running++;
            }
        }

        $data = [
            'Incomplete_count' => $Incomplete_count,
            'submit_count' => $submit_count,
            'page' => 'User Dashboard',
            'any_running' => $any_running,
            'any_running_' => 'vishal',

        ];
        // echo "<pre>";
        // print_r($data);
        // exit;
        
        // $user_id = session()->get('user_id');
        // $get_user_id = $this->application_pointer_model->where(['user_id' => $user_id])->find();
        // foreach($get_user_id as $user_data)
        //  {
        //     //  print_r($user_data);exit;
        //     $pointer_id = $user_data['id'];
        //     $data['email_verification'] = $this->email_verification_model->where(['pointer_id' => $pointer_id, 'is_verification_done' => 0])->find();

             
            
        //  }
        
        $data['email_verification'] = $this->application_pointer_model->asObject()->where(['stage' => 'stage_2', 'status' => 'Submitted','user_id'=>$user_id])->findAll();

        
        return view('user/dashboard', $data);
    }

    public function download_Form()
    {
        $data = [
            'page' => 'User Dashboard',

        ];
        return view('user/download_Form', $data);
    }




    public function account_update_page()
    {
        $register_user = $this->user_account_model->where('id', session()->get('user_id'))->first();
        $country_code_list = $this->country_model->find();
        $data = [
            'register_user' => $register_user,
            'country_code_list' => $country_code_list,
            'page' => 'User Account Update'
        ];
        return view('user/account_update', $data);
    }

    //Pending Verfication
    public function pending_verification()
    {
        //getting application pointer id 
        $table_data = array();
        $user_id = session()->get('user_id');
       // $get_user_id = $this->application_pointer_model->where(['user_id' => $user_id])->findAll();
        
        $data['applications'] = $this->application_pointer_model->asObject()->where(['stage' => 'stage_2', 'status' => 'Submitted','user_id'=>$user_id])->findAll();
        
        // print_r($data);
        // exit;
        // $data['applications'] = $this->application_pointer_model->asObject()->where(['stage' => 'stage_2', 'user_id'=>$user_id])->findAll();

        // echo  $this->application_pointer_model->getLastQuery();
        // exit;
        
         //getting application data
        //  foreach($get_user_id as $user_data)
        //  {
        //     //  print_r($user_data);exit;
        //     $pointer_id = $user_data['id'];
            
            
        //     $table['email_verification'] = $this->email_verification_model->where(['pointer_id' => $pointer_id, "is_verification_done"=> 0])->find();
            
        //     // echo $pointer_id;exit;
        //     $table['portal_reference_no'] =  portal_reference_no($pointer_id);
        //     $personal_details = $this->stage_1_personal_details_model->where(['pointer_id' => $pointer_id])->first();
        //     // print_r($personal_details);exit;
        //     $table['first_or_given_name'] = $personal_details['first_or_given_name']; 
        //     $table['surname_family_name'] = $personal_details['surname_family_name']; 
        //     // print_r($personal_details);exit;
        //     // print_r($table);exit;
            
        //     $table_data[] = $table;
            
        //     $data['table_data'] = $table_data;
        //     // print_r($data);exit;
        //     // print_r($data['email_verification']);exit;
            
        //  }
         
        return view('user/pending_verification', $data);
        
    }


    public function pending_view($pointer_id)
    {
        $data['employs'] =  $this->stage_2_add_employment_model->asObject()->where(['pointer_id' => $pointer_id])->findAll();
        $data['applications'] = $this->application_pointer_model->asObject()->where(['id' => $pointer_id])->findAll();
         
        // $data['applicant_name'] = $this->user_account_model->asObject()->where(['id' => $pointer_id])->findAll();

        return view('user/pending_view_application', $data);
    }
   
    public function account_update_()
    {
        $session = session();
        $data = $this->request->getvar();
        if (isset($data['postal_ad_same_physical_ad_check'])) {
            if ($data['postal_ad_same_physical_ad_check'] == '1') {
                $Postal_unit_flat_number =  (isset($data['unit_flat'])) ? $data['unit_flat'] : '';
                $Postal_street_lot_number =  (isset($data['street_lot'])) ? $data['street_lot'] : '';
                $Postal_street_name =  (isset($data['street_name'])) ? $data['street_name'] : '';
                $Postal_suburb_City = (isset($data['suburb_city'])) ? $data['suburb_city'] : '';
                $Postal_state_proviance = (isset($data['state_province'])) ? $data['state_province'] : '';
                $Postal_postcode = (isset($data['postcode'])) ? $data['postcode'] : '';
            }
        } else {
            $Postal_unit_flat_number =  (isset($data['postal_unit_flat'])) ? $data['postal_unit_flat'] : '';
            $Postal_street_lot_number =  (isset($data['postal_street_lot'])) ? $data['postal_street_lot'] : '';
            $Postal_street_name =  (isset($data['postal_street_name'])) ? $data['postal_street_name'] : '';
            $Postal_suburb_City = (isset($data['postal_suburb_city'])) ? $data['postal_suburb_city'] : '';
            $Postal_state_proviance = (isset($data['postal_state_province'])) ? $data['postal_state_province'] : '';
            $Postal_postcode = (isset($data['postal_postcode'])) ? $data['postal_postcode'] : '';
        }

        $user_id = $data['user_id'];
        $details = [
            'name' => (isset($data['name'])) ? $data['name'] : '',
            'last_name' => (isset($data['last_name'])) ? $data['last_name'] : '',
            'business_name' => (isset($data['business_name'])) ? $data['business_name'] : '',
            'mara_no' => (isset($data['mara_no'])) ? $data['mara_no'] : '',
            'email' => (isset($data['email'])) ? $data['email'] : '',
            'postal_ad_same_physical_ad_check' => (isset($data['postal_ad_same_physical_ad_check'])) ? $data['postal_ad_same_physical_ad_check'] : '',
            'unit_flat' => (isset($data['unit_flat'])) ? $data['unit_flat'] : '',
            'street_lot' => (isset($data['street_lot'])) ? $data['street_lot'] : '',
            'street_name' => (isset($data['street_name'])) ? $data['street_name'] : '',
            'suburb_city' => (isset($data['suburb_city'])) ? $data['suburb_city'] : '',
            'state_province' => (isset($data['state_province'])) ? $data['state_province'] : '',
            'postcode' => (isset($data['postcode'])) ? $data['postcode'] : '',
            'mobile_code' => (isset($data['mobile_code'])) ? $data['mobile_code'] : '',
            'mobile_no' => (isset($data['mobile_no'])) ? $data['mobile_no'] : '',
            'tel_code' => (isset($data['tel_code'])) ? $data['tel_code'] : '',
            'tel_area_code' => (isset($data['tel_area_code'])) ? $data['tel_area_code'] : '',
            'tel_no' => (isset($data['tel_no'])) ? $data['tel_no'] : '',
            'postal_unit_flat' => $Postal_unit_flat_number,
            'postal_street_lot' => $Postal_street_lot_number,
            'postal_street_name' =>  $Postal_street_name,
            'postal_suburb_city' =>  $Postal_suburb_City,
            'postal_state_province' =>  $Postal_state_proviance,
            'postal_postcode' =>  $Postal_postcode,
        ];


        $session->set('name', $data['name']);
        $session->set('last_name', $data['last_name']);
        $register_user_check = $this->user_account_model->where('id', $user_id)->set($details)->update();
        if ($register_user_check) {
            echo "Updated";
            $this->session->setFlashdata('msg', 'Profile Updated Successfully');
            return redirect()->to(base_url('user/dashboard'));
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Profile Not Updated');
            return redirect()->to(base_url('user/account_update'));
        }
    }
    public function account_update_pass_reset()
    {
        $user_id = session()->get('user_id');
        $database = $this->db->table('user_account')->where('id', $user_id)->get()->getrowarray();

        if (!empty($database)) {
            $old_pass = bin2hex(trim($_POST['old_pass']));
            $New_pass = $_POST['New_pass'];
            $conf_pas = $_POST['conf_pas'];

            if ($New_pass == $conf_pas) {
                if ($database['password'] == $old_pass) {
                    $details = [
                        'password' => bin2hex(trim($New_pass)),
                    ];
                    $update_check  =  $this->db->table('user_account')->where('id', session()->get('user_id'))->set($details)->update();
                    if ($update_check) {
                        $this->session->setFlashdata('msg', 'New Password Reset.');
                        $subject = "Password Reset Successful";
                        $message = '<body style=" font-family: Calibri">
                                    <b>
                                    Dear  ' . $database['name'] . ' ' . $database['last_name'] . ' ,
                                    </b>
                                    <br>
                                    <br>
                                    You have successfully reset the password. You can now login through the
                                    <b> <a href="' . base_url() . '"> online portal</a> </b>
                                     with the following credentials to access your account.
                                    <br>
                                    <br>
                                    <b>
                                        Email :  ' . $database['email'] . '
                                    <br>Password : ' . $New_pass . '
                                    </b>
                                    <br>
                                    <br>
                                    Kind Regards,
                                    <br>
                                    <br>
                                    Team AQATO 
                                    <br>
                                    <br>
                                    <img width="200px" src="' . base_url('public/assets/image/aqato_logo.png') . '">
                                    <br>
                                    <br>
                                    <b>Note : </b>
                                    <br>For customer and technical support please contact at <a href="mailto:skills@aqato.com.au">skills@aqato.com.au</a> 
                                    <br>
                                    <br>
                                    <b>Disclaimer: </b>
                                    <br>This email is intended only for the person(s) named in the message header. Unless otherwise indicated, it contains information that is confidential, privileged and/or exempt from disclosure under applicable law. If you have received this message in error, please notify the sender of the error and delete the message.
                                    <br>
                                    <br>
                                </body>
                                ';
                        $to =  $database['email'];     //Add a recipient
                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
                        if ($check == 1) {
                            $this->session->setFlashdata('msg', 'New Login Credentials have been Emailed to You');
                        } else {
                            echo "Sorry Email Not Send,";  // exit;
                        }

                        return redirect()->back();
                    }
                } else {
                    $this->session->setFlashdata('error_msg', 'Sorry! invalid Password.');
                    return redirect()->back();
                }
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! New Password and confirm Password not matching');
                return redirect()->back();
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Login Session Expired');
            return redirect()->to();
        }
    }
}

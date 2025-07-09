<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class login extends BaseController
{
    public function login_page()
    {
        
        // // the message
        // $msg = "First line of text\nSecond line of text";
        
        // // use wordwrap() if lines are longer than 70 characters
        // $msg = wordwrap($msg,70);
        
        // // send email
        // mail("mohsin@techflux.in","My subject",$msg);
        // exit;
        
        $security_string = __randomString("ALPHANUM", 100);
              $password = bin2hex(trim('rohit45@techflux.in'));
        // $encrypt_password =  __encryptPassword("rohit45@techflux.in", $security_string);
        //  echo "security_string =".$security_string;
        //  echo "<br/>encrypt_password =".$encrypt_password;
         //exit;
        
        $session = session();
        
        if(isset($session->admin_id)){
            header("location: ".base_url()."/admin/dashboard");
            exit;
        }
        $data = ['page' => 'Admin Login'];
        return view('admin/login/login', $data);
    }
    
    public function member_allocation(){
        $applications = $this->application_pointer_model->findAll();
        foreach($applications as $application){
            $id_team = getTheAbsoluteTeamMemberID();
            $this->application_pointer_model->update($application["id"], ["team_member" => $id_team]);
        }
        echo "Done";
    }
    public function team_allocation(){
        $id = getTheAbsoluteTeamMemberID();
        echo $id;
        exit;
    }
    public function forgot_password_page()
    {
        $data = ['page' => 'Forgotten password'];
        return view('admin/login/forgot_password', $data);
    }
    
    public function check_user_login_ajax(){
        $user_checker = false;
        if (session()->has('admin_id')) {
            $user_checker = true;
        }
        
        echo json_encode($user_checker);
    }
    
    
     public function logincheck()
    {
        $session = session();
        $user_data = $this->request->getpost();
        $email = trim($user_data['email']);
        $password = trim($user_data['password']);
        $database = $this->admin_account_model->where(['email' => $email])->first();
        

        if ($database) {
            if (__verifyPassword($password . $database["security_string"], $database["password"])) {
            $admin_name = $database['first_name'] . " " . $database['middle_name'] . " " . $database['last_name'];
            $session = session();

            $session->set('admin_name', $admin_name);
            $session->set('admin_account_type', $database['account_type']);
            $session->set('admin_email', $database['email']);
            $session->set('admin_id', $database['id']);
            $session->set('notification', $database['notification']);
            $session->set('admin_id', $database['id']);
            if (session()->has('user_id')) {
                $session->remove('user_id');
            }
            $login_id=$database["id"];
            $data_update = array('is_active' => 'yes', 'is_active_timestamp' => date("Y-m-d H:i:s"));
            $update_status= $this->admin_account_model->set($data_update)->where('id', $login_id)->update();
            
            $session->setFlashdata('msg', 'Login Successfully');
            return redirect()->to(base_url('admin/dashboard'));
            }else{
             $session->setFlashdata('error_msg', 'Invalid Username Or Password');
            return redirect()->to(base_url('admin/login'));
             
            }
        } else {
            $session->setFlashdata('error_msg', 'Invalid Username Or Password');
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function check_forgot_password()
    {
        $data = $this->request->getvar();

        // forgot password for Admin ---------------------
        $database = $this->admin_account_model->where('email', $data['email'])->first();
        if (isset($database)) {
            // echo "check true";

            // email encrypt 
            $encrypter = \Config\Services::encrypter();
            $ciphertext = $encrypter->encrypt($data['email']);
            // reset password URL 
            $url =  base_url("admin/new_password/" . bin2hex($ciphertext));
            // email Funtion
            $to = $data['email'];
            $subject = 'Create a  New Password AQATO';
            $message = '<p>Admin > Create a New Password </p><hr>
                        <p>
                            <a href="' . $url . '">
                                Click here to Reset your Password !
                            </a>
                        </p> ';
            $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
            // email send check
            if ($check == 1) {
                // echo "send email";
                // exit;
                $this->session->setFlashdata("msg", ' Create New Password Link send to your Email Id, Please check your email ');
                return redirect()->to(base_url('admin/forgot_password'));
            } else {
                // echo "could not be sent email";
                // exit;
                $this->session->setFlashdata("error_msg", 'Sorry Email could not be sent.');
                return redirect()->to(base_url('admin/forgot_password'));
            }
        } else { // if user not found 
            //             echo "valid Email";
            // exit;
            $this->session->setFlashdata("error_msg", 'Please Enter valid Email Id ');
            return redirect()->to(base_url('admin/forgot_password'));
        }
    }
    public function New_password_page($encode_data)
    {
        $encrypter = \Config\Services::encrypter();

        // Encoded Sring check 
        if (ctype_xdigit($encode_data) && strlen($encode_data) % 2 == 0) {

            $h2b = hex2bin($encode_data);
            $data_a =  $encrypter->decrypt($h2b);
            // reset password for Admin ---------
            $database = $this->admin_account_model->where('email', $data_a)->first();
            if (isset($database)) {
                $data = [
                    'tokan' => $encode_data,
                    'ad' => '1',
                    'page' => 'Create New Password',
                ];
                return view('New_password_page', $data);
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! User Not Found.');
                return redirect()->to(base_url('admin/login'));
            }
        }
    }
    public function logout()
    {
            $login_id= session()->get('admin_id');
            $data_update = array('is_active' => '');
            $update_status= $this->admin_account_model->set($data_update)->where('id', $login_id)->update();
        $this->session->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}

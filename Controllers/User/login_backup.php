<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class login extends BaseController
{

    public function login_page($redayrect_url = null)
    {
        if (session()->has('user_id')) {
            return redirect()->to(base_url('user/dashboard'));
        }
        $data = [
            'page' => 'Applicant/Agent Login',
            'redayrect_url' => $redayrect_url,
        ];
        return view('user/login', $data);
    }

    public function email_html_tem()
    {
        return view('email_html_tem');
    }
    
    public function generate_captcha(){
        
        $captcha_code = '';
        $captcha_image_height = 50;
        $captcha_image_width = 130;
        $total_characters_on_image = 6;
        
        //The characters that can be used in the CAPTCHA code.
        //avoid all confusing characters and numbers (For example: l, 1 and i)
        $possible_captcha_letters = 'bcdfghjkmnpqrstvwxyz23456789';
        $captcha_font = '/monofont.ttf';
        
        $random_captcha_dots = 50;
        $random_captcha_lines = 25;
        $captcha_text_color = "0x142864";
        $captcha_noise_color = "0x142864";
        
        
        $count = 0;
        while ($count < $total_characters_on_image) { 
        $captcha_code .= substr(
        	$possible_captcha_letters,
        	mt_rand(0, strlen($possible_captcha_letters)-1),
        	1);
        $count++;
        }
        
        $captcha_font_size = $captcha_image_height * 0.65;
        $captcha_image = @imagecreate(
        	$captcha_image_width,
        	$captcha_image_height
        	);
        
        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate(
        	$captcha_image,
        	255,
        	255,
        	255
        	);
        
        $array_text_color = $this->hextorgb($captcha_text_color);
        $captcha_text_color = imagecolorallocate(
        	$captcha_image,
        	$array_text_color['red'],
        	$array_text_color['green'],
        	$array_text_color['blue']
        	);
        
        $array_noise_color = $this->hextorgb($captcha_noise_color);
        $image_noise_color = imagecolorallocate(
        	$captcha_image,
        	$array_noise_color['red'],
        	$array_noise_color['green'],
        	$array_noise_color['blue']
        	);
        
        /* Generate random dots in background of the captcha image */
        for( $count=0; $count<$random_captcha_dots; $count++ ) {
        imagefilledellipse(
        	$captcha_image,
        	mt_rand(0,$captcha_image_width),
        	mt_rand(0,$captcha_image_height),
        	2,
        	3,
        	$image_noise_color
        	);
        }
        
        /* Generate random lines in background of the captcha image */
        for( $count=0; $count<$random_captcha_lines; $count++ ) {
        imageline(
        	$captcha_image,
        	mt_rand(0,$captcha_image_width),
        	mt_rand(0,$captcha_image_height),
        	mt_rand(0,$captcha_image_width),
        	mt_rand(0,$captcha_image_height),
        	$image_noise_color
        	);
        }
        
        /* Create a text box and add 6 captcha letters code in it */
        $text_box = imagettfbbox(
        	$captcha_font_size,
        	0,
        	$captcha_font,
        	$captcha_code
        	); 
        $x = ($captcha_image_width - $text_box[4])/2;
        $y = ($captcha_image_height - $text_box[5])/2;
        imagettftext(
        	$captcha_image,
        	$captcha_font_size,
        	0,
        	$x,
        	$y,
        	$captcha_text_color,
        	$captcha_font,
        	$captcha_code
        	);
        
        /* Show captcha image in the html page */
        // defining the image type to be shown in browser widow
        header('Content-Type: image/jpeg'); 
        imagejpeg($captcha_image); //showing the image
        imagedestroy($captcha_image); //destroying the image instance
        // $_SESSION['captcha'] = $captcha_code;

    }
    
    public function hextorgb ($hexstring){
      $integar = hexdec($hexstring);
      return array("red" => 0xFF & ($integar >> 0x10),
                   "green" => 0xFF & ($integar >> 0x8),
                   "blue" => 0xFF & $integar);
	}

    public function generate_captcha_old(){
        $rand_num=rand(11111,99999);

        // pass to session
        $session = session();
        
        $session->set('server_captcha', $rand_num);


        $layer=imagecreatetruecolor(60,30);
        $captcha_bg=imagecolorallocate($layer,255,160,120);
        imagefill($layer,0,0,$captcha_bg);
        $captcha_text_color=imagecolorallocate($layer,0,0,0);
        imagestring($layer,5,5,5,$rand_num,$captcha_text_color);
        header('Content-Type:image/jpeg');
        imagejpeg($layer,null,100);
    }

    public function user_login_check()
    {
        $client_captcha = $this->request->getPost("client_captcha");
        echo $client_captcha;
        exit;
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];

            $secretKey = env('Google_your_secret_key');
            // echo $ip = $_SERVER['REMOTE_ADDR'];
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);
            // should return JSON with success as true
            if ($responseKeys["success"]) {
                $session = session();
                $data = $this->request->getPost();
                $username = $data['username'];
                $where = $data['where'];
                $redirect = base64_decode($data['redayrect_url']);
                $password = bin2hex(trim($data['password']));

                $database = $this->user_account_model->where('email', $username)->where('password', $password)->first();
                if ($database) {
                    if ($database['status'] == "active") {
                        $session->set('name', $database['name']);
                        $session->set('last_name', $database['last_name']);  // vishal
                        $session->set('account_type', $database['account_type']); // vishal
                        $session->set('user_id', $database['id']);
                        $session->set('noCallBackPages', false);


                        if (empty($database['address'])  && empty($database['mobile_no'])) {
                            // Redirect
                            $session->set('noCallBackPages', true);
                            return redirect()->to(base_url('user/account_update'));
                        } else {
                            return redirect()->to(base_url('user/dashboard'));
                        }
                    } else {
                        $session->setFlashdata('error_msg', 'Sorry! your account is not verified yet please check your email');
                        return redirect()->to(base_url('user/login'));
                    }
                } else {
                    $session->setFlashdata('error_msg', 'Invalid Username Or Password');
                    return redirect()->to(base_url('user/login'));
                }
            } else {  // Google check
                $this->session->setFlashdata('error_msg', 'Sorry! Detection of Spamming Activity');
                return redirect()->to(base_url('user/login'));
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Please check the the captcha form.');
            return redirect()->to(base_url('user/login'));
        }
    }

    public function create_an_account_page()
    {
        $data = ['page' => 'Creat New Account'];
        return view('user/create_an_account', $data);
    }
    // new account creat by user 
       public function create_an_account_code()
    {
        $session = \Config\Database::connect();
        $session = session();
        $data = $this->request->getvar();
        $email = (isset($data['email']) ? $data['email'] : "");
        if (!empty($email)) {
            $database = $this->user_account_model->where('email', $email)->first();
            if (empty($database)) {
                $password = "ajsjdksajkdjlsajjdklajsd";
                // check confirm Password mach to password
                $a = trim($data['cpassword']);
                $b = trim($data['password']);
                if ($a == $b) {
                    $password = bin2hex(trim($data['password']));
                } else {
                    // Password not match
                    $session->setFlashdata('error_msg', 'Sorry! Password not match.');
                    return redirect()->back();
                }


                $mara_agent = '';
                if (isset($data['agent_or_not'])) {
                    if ($data['agent_or_not'] == 'Yes') {
                        $mara_agent =  (isset($data['migration-number']) ? $data['migration-number'] : "");
                    }
                }
                $business_name = (isset($data['business-name']) ? $data['business-name'] : "");
                $are_u_mara_agent = (isset($data['agent_or_not']) ? $data['agent_or_not'] : "");

                // Send Email to user and creat account 
                $ciphertext = $this->encrypter->encrypt($data['email']);
                $given_name = $data['given-name'];
                $surname = $data['surname'];
                $Verification_encode_URL =  base_url("Verification/" . bin2hex($ciphertext));
                $IMG_aqato_logo = base_url('public/assets/image/aqato_logo.png');
                $account_type = (isset($data['account_type']) ? $data['account_type'] : "");

                // create_account_email_Verification
                $mail_temp_4 = $this->mail_template_model->where(['id' => '24'])->first();
                if (!empty($mail_temp_4)) {
                    $to = $data['email'];
                    $subject = $mail_temp_4['subject'];
                    $message = $mail_temp_4['body'];
                    $message = str_replace("%given_name%", $given_name, $message);
                    $message = str_replace("%surname%", $surname, $message);
                    $message = str_replace("%Verification_encode_URL%", $Verification_encode_URL, $message);
                    $message = str_replace("%IMG_aqato_logo%", $IMG_aqato_logo, $message);
                    $email_check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);

                    if ($email_check == 1) {
                        // user add in Sql
                        $data = [
                            'email' => $email,
                            'password' => $password,
                            'account_type' => $account_type,
                            'name' => trim($given_name),
                            'last_name' => trim($surname),
                            'business_name' => $business_name,
                            'are_u_mara_agent' => $are_u_mara_agent,
                            'mara_no' => $mara_agent,
                            'status' => 'not_verified'
                        ];
                        $this->user_account_model->save($data);
                    } else {
                        // email not send _ account not creat
                        $session->setFlashdata('error_msg', 'Sorry! email service is not working, please contact us at skills@aqato.com.au for assistance.');
                        return redirect()->back();
                    }
                }

                $session->setFlashdata('msg', 'Thank you for creating an account <br> An email has been sent to your nominated email address with your account activation link. <br> Please check your Inbox/Junk Mail and follow the link to activate your account. <br> If you do not receive a notification email from us within the next 15 minutes,please contact us at skills@aqato.com.au for assistance.');
                return redirect()->to(base_url('user/login'));
            } else {
                $session->setFlashdata('error_msg', 'Sorry! Your Email is already registered, Try to Forgot Password ?');
                return redirect()->to(base_url('user/login'));
            }
        } else {
            $session->setFlashdata('error_msg', 'Sorry! Email Not Found.');
            return redirect()->back();
        }
    }

    // email veryfication code 
    public function Verification($data)
    {
        $data =  $this->encrypter->decrypt(hex2bin($data));
        // read get data
        $database = $this->user_account_model->where('email', $data)->first();
        if (!empty($database)) {
            $business_name = "";
            if ($database['business_name']) {
                $business_name = "Business Name: " . $database['business_name'];
            }
            $Account_type = "Agent/Applicant:";
            if ($database['account_type'] == "Agent") {
                $Account_type = "Agent";
            } else {
                $Account_type = "Applicant";
            }

            $name = "";
            if ($database['name']) {
                $name = $database['name'];
            }

            $last_name = "";
            if ($database['last_name']) {
                $last_name = $database['last_name'];
            }

            if (isset($database['status'])) {
                if ($database['status'] == "active") {
                    $this->session->setFlashdata('msg', 'Your Email is Already Verified, <br> Please login with your credentials,');
                    return redirect()->to(base_url('login'));
                }
            }


            $is_Update =   $this->user_account_model->where('email', $data)->set('status', 'active')->update();
            if ($is_Update) {

                $name =   $database['name'];
                $last_name =   $database['last_name'];
                $my_email =  $database['email'];
                $plain_pass =  hex2bin($database['password']);
                $aqato_logo = base_url('public/assets/Image/aqato_logo.png');

                // account_login_credentials
                $mail_temp_4 = $this->mail_template_model->where(['id' => '104'])->first();
                if (!empty($mail_temp_4)) {
                    $to = $database['email'];
                    if (!empty($to)) {
                        $subject = $mail_temp_4['subject'];
                        $message = $mail_temp_4['body'];
                        $message =    str_replace("%name%", $name, $message);
                        $message =    str_replace("%last_name%", $last_name, $message);
                        $message =    str_replace("%my_email%", $my_email, $message);
                        $message =    str_replace("%plain_pass%", $plain_pass, $message);
                        $message =    str_replace("%aqato_logo%", $aqato_logo, $message);
                        $message =    str_replace("%Account_type%", $Account_type, $message);
                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
                        if ($check == 1) {
                            echo "mail 1 send";
                        } else {
                            echo "Sorry Email Not Send,";
                            exit;
                        }
                    }
                }

                // new_account_created_admin
                $mail_temp_4 = $this->mail_template_model->where(['id' => '105'])->first();
                if (!empty($mail_temp_4)) {
                    $subject = $mail_temp_4['subject'];
                    $message = $mail_temp_4['body'];
                    $message =    str_replace("%name%", $name, $message);
                    $message =    str_replace("%last_name%", $last_name, $message);
                    $message =    str_replace("%aqato_logo%", $aqato_logo, $message);
                    $message =    str_replace("%Account_type%", $Account_type, $message);

                    $message =    str_replace("%business_name%", $business_name, $message);
                    $to = env('ADMIN_EMAIL');
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
                    echo "mail 2 send";
                    if ($check == 1) {
                    } else {
                        echo "Sorry Email Not Send,";
                        exit;
                    }
                }


                $this->session->setFlashdata('msg', 'Your account has been verified, <br> Please login with your credentials,');
                return redirect()->to(base_url());
            } else {
                echo "Sorry ! Email Verification Failed";
                exit;
            }
        }
    }



    public function forgot_Password_page()
    {
        $data = ['page' => 'Forgotten password'];
        return view('user/forgot_Password', $data);
    }
    /* 
     check valid user
     lsend email with reset password link
     2 type of user  admin and local_user 
     */
    public function user_Forgot_Password_check()
    {
        // forgot password for Admin & User

        $data = $this->request->getvar();

        $database = $this->user_account_model->where('email', $data['email'])->first();
        if (isset($database)) {
            // email encrypt 
            $ciphertext = $this->encrypter->encrypt($data['email']);
            // reset password URL 
            $url = base_url("New_password/" . bin2hex($ciphertext) . "/NOT_admin");

            // create_new_password
            $mail_temp_4 = $this->mail_template_model->where(['id' => '106'])->first();
            if (!empty($mail_temp_4)) {
                $to = $data['email'];
                if (!empty($to)) {
                    $subject = $mail_temp_4['subject'];
                    $message = $mail_temp_4['body'];
                    $message = str_replace("%Create_New_Password_url%", $url, $message);
                    $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
                    if ($check == 1) {
                        $this->session->setFlashdata('msg', 'Please check your email for the Create New Password Link that was sent to it.');
                    } else {
                        $this->session->setFlashdata('error_msg', 'Sorry Email could not be sent.');
                    }
                }
            }


            return redirect()->to(base_url());
        } else { // if user not found 
            $this->session->setFlashdata('error_msg', 'Please Enter valid Email Id.');
            return redirect()->to(base_url());
        } // if email exist

        // }
    }
    // reset password page open after link open by email 
    public function New_password_page($encode_data, $b)
    {
        // Encoded Sring check 
        if (ctype_xdigit($encode_data) && strlen($encode_data) % 2 == 0) {

            $h2b = hex2bin($encode_data);
            $data_a =  $this->encrypter->decrypt($h2b);

            $database = $this->user_account_model->where('email', $data_a)->first();
            if (isset($database)) {
                $data = [
                    'tokan' => $encode_data,
                    'page' => 'Create New Password',
                ];
                return view('New_password_page', $data);
            } else {
                $this->session->setFlashdata('error_msg', 'Sorry! User Not Found.');
                return redirect()->to(base_url('user/login'));
            }
            // }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Reset Password Link Expired.');
            return redirect()->to(base_url());
        }
    }
    // reset password  Funtion
    public function New_password_check()
    {
        $data = $this->request->getvar();
        $encrypter = \Config\Services::encrypter();
        $email =  $encrypter->decrypt(hex2bin($data['tokan']));

        // for noraml user ---------------
        $database = $this->user_account_model->where('email', $email)->first();
        if (!empty($database)) {
            $New_pass = $data["Pass_1"];
            $details = [
                'password' => bin2hex($New_pass),
            ];
            $update_pass = $this->user_account_model->where('email', $email)->set($details)->update();
            if ($update_pass) {
                $database = $this->user_account_model->where('email', $email)->first();

                $to =  $database['email'];     //Add a recipient
                // $subject = "Password Reset Successful";
                $name = $database['name'];
                $last_name = $database['last_name'];
                $email = $database['email'];
                $plain_pass = hex2bin($database['password']);
                $aqato_logo =   base_url('public/assets/Image/aqato_logo.png');


                // password_reset_successful
                $mail_temp_4 = $this->mail_template_model->where(['id' => '107'])->first();
                if (!empty($mail_temp_4)) {
                    if (!empty($to)) {
                        $subject = $mail_temp_4['subject'];
                        $message = $mail_temp_4['body'];
                        $message =    str_replace("%name%", $name, $message);
                        $message =    str_replace("%last_name%", $last_name, $message);
                        $message =    str_replace("%aqato_logo%", $aqato_logo, $message);
                        $message =    str_replace("%plain_pass%", $plain_pass, $message);
                        $message =    str_replace("%email%", $email, $message);
                        $check = send_email(env('SERVER_EMAIL'), env('SERVER_FROM_EMAIL'), $to, $subject, $message);
                        if ($check == 1) {
                            $this->session->setFlashdata('msg', 'successfully Resetting a Password');
                        } else {
                            $this->session->setFlashdata('error_msg', 'Sorry! Set New Password Failde');
                        }
                    }
                }


                return redirect()->to(base_url());
            }
        } else {
            $this->session->setFlashdata('error_msg', 'Sorry! Invalid User');
            return redirect()->to(base_url());
        }
    }




    public function sing_out()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }

    public function day_night_mode($mode)
    {
        setcookie("day_night_mode", "", time() - 3600); // set the expiration date to one hour ago
        setcookie("day_night_mode", $mode, time() + (86400 * 30), "/"); // 86400 = 1 day 
        return redirect()->back();
    }




    //----------
}

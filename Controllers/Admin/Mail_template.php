<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Mail_template extends BaseController
{
    public function index()
    {
        $data["mail_templates"] = $this->mail_template_model->asObject()->orderBy("id", "DESC")->findAll();
         $data['page']="Mail Template";

        return view("admin/mail_template/index", $data);
    }
    public function edit($id)
    {
        $data["mail_template"] = $this->mail_template_model->find($id);
        return view("admin/mail_template/edit", $data);
    }
    public function edit_action()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost('name');
        $subject = $this->request->getPost('subject');
        $body = $this->request->getPost('body');
        $data = array(
            "name" => $name,
            "subject" => $subject,
            "body" => $body,
            'update_by' => session()->get('admin_id'),
            "update_at" => date("Y-m-d H:i:s")
        );
        echo json_encode($this->mail_template_model->set($data)->where('id', $id)->update());
    }

    public function add()
    {
        return view("admin/mail_template/add");
    }

    public function add_action()
    {
        $name = $this->request->getPost('name');
        $subject = $this->request->getPost('subject');
        $body = $this->request->getPost('body');
        $data = array(
            "name" => $name,
            "subject" => $subject,
            "body" => $body,
            "created_by" => session()->get('admin_id'),
            'created_at' => date("Y-m-d H:i:s"),
            'update_by' => session()->get('admin_id'),
            "update_at" => date("Y-m-d H:i:s")
        );
        $check = $this->mail_template_model->insert($data);
        $data = [];
        if ($check) {
            $data = $this->mail_template_model->orderBy("id", "desc")->limit(1)->first();
        }
        echo json_encode($data);
    }

    public function name_keywords()
    {
        $data["name_keywords"] = $this->mail_template_name_keyword_model->asObject()->orderBy("id", "desc")->findAll();
        return view("admin/mail_template/name_keywords", $data);
    }

    public function add_name_keyword()
    {
        $posts = $this->request->getPost();
        $check = $this->mail_template_name_keyword_model->insert($posts);
        $data = [];
        if ($check) {
            $data = $this->mail_template_name_keyword_model->orderBy("id", "desc")->limit(1)->first();
        }
        echo json_encode($data);
    }

    public function edit_name_keyword()
    {
        $id = $this->request->getPost("id");
        $posts = $this->request->getPost();
        echo json_encode($this->mail_template_name_keyword_model->where('id', $id)->set($posts)->update());
    }

    public function test_email()
    {
        // exit;
        $id = $_POST['id'];
        $mail_temp_3 = $this->mail_template_model->asObject()->where(['id' => $id])->first();
        $subject = $mail_temp_3->subject;
        $message = $mail_temp_3->body;

        $pointer_id = "8";
        $subject = mail_tag_replace($subject, $pointer_id);
        $message = mail_tag_replace($message, $pointer_id);


        // // for stage 3
        // $stage_3_ = $this->stage_3_model->where(['pointer_id' => $pointer_id])->first();
        // $preference_location_comment = "";
        // if (!empty($stage_3_)) {
        //     $preference_location = trim($stage_3_['preference_location']);
        //     $preference_comment = trim($stage_3_['preference_comment']);
        //     $preference_comment = trim($preference_comment, "\xC2\xA0");

        //     $preference_comment = str_replace("&nbsp;", '', $preference_comment);
        //     if (!empty($preference_location)) {
        //         $preference_location_comment .= "<b>Applicant's Preferred Venue: " . $preference_location;
        //     }
        //     if (!empty($preference_comment)) {
        //         $preference_location_comment .= "<br><br><u> Comments: </u><br><i>\"" . $preference_comment . "\"</i></b>";
        //     }
        // }
        // $message = str_replace('%preference_location_comment%', $preference_location_comment, $message);


        // // login info 
        // $database = $this->user_account_model->where('email', "khatritilak4@gmail.com")->first();
        // if (!empty($database)) {
        //     $business_name = "";
        //     if ($database['business_name']) {
        //         $business_name = "Business Name: " . $database['business_name'];
        //     }
        //     $Account_type = "Agent/Applicant:";
        //     if ($database['account_type'] == "Agent") {
        //         $Account_type = "Agent";
        //     } else {
        //         $Account_type = "Applicant";
        //     }

        //     $name = "";
        //     if ($database['name']) {
        //         $name = $database['name'];
        //     }

        //     $last_name = "";
        //     if ($database['last_name']) {
        //         $last_name = $database['last_name'];
        //     }

        //     $message =    str_replace("%name%", $name, $message);
        //     $message =    str_replace("%last_name%", $last_name, $message);
        //     $message =    str_replace("%Account_type%", $Account_type, $message);
        //     $message =    str_replace("%business_name%", $business_name, $message);
        // }




        if (isset($_POST['email'])) {
            $to = $_POST['email'];
            if (!empty($to)) {
                $this->session->set('test_email', $to);

                echo  $check = test_send_email("test@oyebhangarwala.com", "test@oyebhangarwala.com", $to, $subject, $message);
                echo "<br> send";
                // return redirect()->back();
            } else {
                if (session()->has('test_email')) {
                    $to = session()->get('test_email');
                    echo $check = test_send_email("test@oyebhangarwala.com", "test@oyebhangarwala.com", $to, $subject, $message);
                    echo "<br> send to " . $to;
                }
            }
        }
    }
}

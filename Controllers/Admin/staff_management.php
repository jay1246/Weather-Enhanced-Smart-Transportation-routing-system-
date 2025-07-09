<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
 
class staff_management extends BaseController 
{
    protected $name_resloved = [
        "aqato" => "admin",
        "attc" => "head_office",
    ];
    public function index($page)
    {
        if(!isset($this->name_resloved[$page])){
            return redirect()->back();
        }
        $access_level = $this->name_resloved[$page];

        // 

        $data['staffs'] = $this->admin_account_model->where("account_type", $access_level)->asObject()->findAll();

        $data['title'] = 'Staff Management';

        $data['countries'] = $this->country_model->asObject()->findAll();
        $data['page']="Staff Management";
        $data['tab']= $page;

        return view('admin/staff_management/index', $data);
    }

    public function insert()
    {
        $data = $this->request->getVar();

        
        // ENCRYPT PASSWORD 
        $encrypt_password = "";
        if($data["password"]){
            
            $security_string = __randomString("ALPHANUM", 100);
    
            $encrypt_password =  __encryptPassword($data["password"], $security_string);
        }
        
        $details = array(
            'inital_name' => $data['inital_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],           
            'mobile_code' => $data['mobile_code'],
            'mobile_no' => $data['mobile_no'],
            'email' => $data['email'],
            'account_type' => $data['account_type'],             
            'status' => $data['status']
        );

        if($encrypt_password){
            $details["password"] = $encrypt_password;
            $details["security_string"] = $security_string;
        }
        
        if($this->admin_account_model->insert($details)){
        $callback = array(
            "color" => "success",
            "msg" => "inserted recode",
            "response" => true,
        );
    }else{
        $callback = array(
            "msg" => "unable to insert record",
            "color" => "danger",
            "response" => false,
        );     
    }
        echo json_encode($callback);
    }


    public function update()
    {
        $data = $this->request->getvar();

        $id = $data['id'];
        
        // ENCRYPT PASSWORD 
        $encrypt_password = "";
        if($data["password"]){
            
            $security_string = __randomString("ALPHANUM", 100);
    
            $encrypt_password =  __encryptPassword($data["password"], $security_string);
        }
        
        $details = array(
            'inital_name' => $data['inital_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],           
            'mobile_code' => $data['mobile_code'],
            'mobile_no' => $data['mobile_no'],
            'email' => $data['email'],
            'account_type' => $data['account_type'],             
            'status' => $data['status']
        );
        if($encrypt_password){
            $details["password"] = $encrypt_password;
            $details["security_string"] = $security_string;
        }
        
        if($this->admin_account_model->update($id,$details)){
            $callback = array(
                "color" => "success",
                "msg" => "update recode",
                "response" => true,
            );
        }else{
            $callback = array(
                "msg" => "unable to update record",
                "color" => "danger",
                "response" => false,
            );
    
        }
        echo json_encode($callback);
    }

    public function delete($id)
    {
       if($this->admin_account_model->where('id', $id)->delete()){
        $callback = array(
            "color" => "success",
            "msg" => "Delete recode",
            "response" => true,
        );
        }else{
            $callback = array(                
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
 
        }
        echo json_encode($callback);

    }

    public function status($id)
    {
        $status = $this->admin_account_model->where('id',$id)->asObject()->first();
       if($status->status == "active"){
            $change_status ="inactive";
       }else{
        $change_status ="active";
       }
       $data = array(
        'status'=>$change_status
       );
       if($this->admin_account_model->update($id,$data)){
        $callback = array(
            "color" => "success",
            "msg" => "update status",
            "response" => true,
        );
        }else{
            $callback = array(                
                "msg" => "unable to update status",
                "color" => "danger",
                "response" => false,
            );
 
        }
        echo json_encode($callback);

    }


}
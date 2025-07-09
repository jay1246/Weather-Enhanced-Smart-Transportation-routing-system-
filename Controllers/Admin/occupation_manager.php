<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
 
class occupation_manager extends BaseController  
{
    public function index()
    {
        $data['occupations'] = $this->occupation_list_model->asObject()->findAll();

        $data['title'] = 'Occupation manager';
         $data['page']="Occupation Manager";

        
        return view('admin/occupation_manager/index', $data);
    }

    public function insert() 
    {
        $data = $this->request->getVar();

        $details = array(
            'name' => $data['name'],
            'number' => $data['number'],            
            'status' => $data['status']
        );

        if($this->occupation_list_model->insert($details)){
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

        $details = array(
            'name' => $data['name'],
            'number' => $data['number'],            
            'status' => $data['status']
        );
        if($this->occupation_list_model->update($id,$details)){
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
       if($this->occupation_list_model->where('id', $id)->delete()){
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
        $status = $this->occupation_list_model->where('id',$id)->asObject()->first();
       if($status->status == "active"){
            $change_status ="inactive";
       }else{
        $change_status ="active";
       }
       $data = array(
        'status'=>$change_status
       );
       if($this->occupation_list_model->update($id,$data)){
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
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class offline_files extends BaseController
{
    public function index($tab = "")
    {
        $data["tab"] = $tab;
        // echo $tab;
        $data['title'] = "offline_file";
        $data["offline_saq_files"] = $this->offline_file_model->asObject()->where('use_for', 'saq_file')->orderBy("id", "desc")->findAll();
        $data["offline_app_files"] = $this->offline_file_model->asObject()->where('use_for', 'application_kit')->orderBy("id", "desc")->findAll();
        $data["offline_third_files"] = $this->offline_file_model->asObject()->where('use_for', 'third_party')->orderBy("id", "desc")->findAll();
        $data['page']="Offline Files";


        return view('admin/offline_files/index', $data);
    }

    public function insert()
    {
        $use_for = $this->request->getPost("use_for");
        $occupation = $this->request->getPost("occupation");
        $name = $this->request->getPost("name");
        $file = $this->request->getFile("file");
        $find_data = find_one_row_2_field('offline_file', 'use_for', $use_for, 'occupation_id', $occupation);
        // print_r($find_data);
        // exit;
        if ($file == "") {
        } else {
            if ($use_for == "saq_file") {
                $target_file = "public/assets/offline_file/saq/";
            } elseif ($use_for == "application_kit") {
                $target_file = "public/assets/offline_file/app_kit/";
            } else {
                $target_file = "public/assets/offline_file/third_party/";
            }

            $file_basename = $file->getName();
            $file_extension = explode(".", $file_basename);
            $occupation_name = find_one_row("occupation_list", "id", $occupation)->name;
            $type = $file_extension[count($file_extension) - 1];
            $file_name = $file_basename . "." . $type;
            $file->move($target_file, $file_name);
            $file_path = $target_file . $file_name;
        }
        $data = array(
            "use_for" => $use_for,
            "occupation_id" => $occupation,
            "name" => $name,
            "type" => $type,
            'path_text' => $file_path,
            'file_name' => $file_name,
            "reg_date" => date("Y-m-d H:i:s")
        );
        if ($find_data) {
            $data = 0;
        } else {
            $callback = "the data already exsits";
        }

        if ($this->offline_file_model->insert($data)) {
            $callback = array(
                "color" => "success",
                "msg" => "inserted recode",
                "response" => true,
            );
        } else {
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
        $id = $this->request->getPost("id");
        $use_for = $this->request->getPost("use_for");
        $occupation = $this->request->getPost("occupation");
        $name = $this->request->getPost("name");
        $file = $this->request->getFile("file");
        
        if ($file == "") {
        } else {
            if ($use_for == "saq_file") {
                $target_file = "public/assets/offline_file/saq/";
            } elseif ($use_for == "application_kit") {
                $target_file = "public/assets/offline_file/app_kit/";
            } else {
                $target_file = "public/assets/offline_file/third_party/";
            }
            $file_basename = $file->getName();
            $file_extension = explode(".", $file_basename);
            $occupation_name = find_one_row("occupation_list", "id", $occupation)->name;
            $type = $file_extension[count($file_extension) - 1];
            $file_name = $file_basename . "." . $type;
            $file_path = $target_file . $file_name;
            $old_file = find_one_row("offline_file", "id", $id)->path_text;

            if ($old_file) {
                if(file_exists($old_file)){
                    unlink($old_file);
                }
            }

            $file->move($target_file, $file_name);
        }
        // echo "Here";
        // exit;
        $data = array(
            "use_for" => $use_for,
            "occupation_id" => $occupation,
            "name" => $name,
            "type" => $type,
            'path_text' => $file_path,
            'file_name' => $file_name,
            "reg_date" => date("Y-m-d H:i:s")
        );

        if ($this->offline_file_model->update($id, $data)) {
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

    public function delete($id)
    {
        $file = find_one_row("offline_file", "id", $id)->path_text;

        unlink($file);
        if ($this->offline_file_model->where('id', $id)->delete()) {
            $callback = array(
                "color" => "success",
                "msg" => "Delete recode",
                "response" => true,
            );
        } else {
            $callback = array(
                "msg" => "unable to delete record",
                "color" => "danger",
                "response" => false,
            );
        }
        echo json_encode($callback);
    }
}

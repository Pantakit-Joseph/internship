<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request_internship_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = new stdClass();
        $user_id = $this->session->user_id;
        $sql = $this->db->query(
            "SELECT * FROM `request_internship` 
            LEFT JOIN `users_student` ON `users_student`.`user_id`=`request_internship`.`user_id`
            WHERE `request_internship`.`user_id`=?",
            array($user_id)
        );
        $data = $sql->row();

        
        return $data;
    }

    public function data_print()
    {
        $data = new stdClass();
        $user_id = $this->session->user_id;
        $std = $this->db->query(
            "SELECT 
                `users_student`.*,
                `college`.`name` AS college_name, 
                `department`.`name` AS dpm_name,
                `edulevel`.`name` as edulevel
            FROM `users_student`
            LEFT JOIN `college` ON `college`.`id`=`users_student`.`college_id`
            LEFT JOIN `department` ON `department`.`id`=`users_student`.`department_id`
            LEFT JOIN `edulevel` ON .`edulevel`.`id`=`users_student`.`edulevel`
            WHERE `users_student`.`user_id` = ?",
            array($user_id)
        );
        $data->student = $std->row();

        $internship = $this->db->query(
            "SELECT * FROM `internship` WHERE `id`=?",
            array($data->student->internship_id)
        );
        $data->internship = $internship->row();

        $company = $this->db->query(
            "SELECT * FROM `company` WHERE `id`=?",
            array($data->student->company_id)
        );
        $data->company = $company->row();

        return $data;
    }

    public function data_form()
    {
        $data = new stdClass();
        $user_id = $this->session->user_id;
        $request_internship = $this->db->query(
            "SELECT * FROM `request_internship` 
            WHERE `request_internship`.`user_id`=?",
            array($user_id)
        );
        $data->request_internship = $request_internship->row();

        $std = $this->db->query(
            "SELECT 
                `users_student`.*,
                `college`.`name` AS college_name, 
                `department`.`name` AS dpm_name,
                `edulevel`.`name` as edulevel
            FROM `users_student`
            LEFT JOIN `college` ON `college`.`id`=`users_student`.`college_id`
            LEFT JOIN `department` ON `department`.`id`=`users_student`.`department_id`
            LEFT JOIN `edulevel` ON .`edulevel`.`id`=`users_student`.`edulevel`
            WHERE `users_student`.`user_id` = ?",
            array($user_id)
        );
        $data->student = $std->row();

        if (!empty($data->student)) {
            $internship = $this->db->query(
                "SELECT * FROM `internship` WHERE `id`=?",
                array($data->student->internship_id)
            );
            $data->internship = $internship->row();

            $company = $this->db->query(
                "SELECT * FROM `company` WHERE `id`=?",
                array($data->student->company_id)
            );
            $data->company = $company->row();
        }

        return $data;
    }

    public function form_submit()
    {
        $user_id = $this->session->user_id;
        $check = $this->db->query(
            "SELECT * FROM `request_internship` WHERE `user_id`=?",
            array($user_id)
        );

        if ($check->num_rows() == 0) {
            $this->db->query(
                "INSERT INTO `request_internship`(`user_id`, `supervisor`, `advisor`, `status`) 
            VALUES (?,?,?,?)",
                array($user_id, 0, 0, 0)
            );
        }
    }

    public function advisor()
    {
        $sql = $this->db->query(
            "SELECT * FROM `request_internship` 
            INNER JOIN `users_student` ON `users_student`.`user_id`=`request_internship`.`user_id` AND`users_student`.`advisor_id`=?",
            array($this->session->user_id)
        );
        $data = $sql->result();

        return $data;
    }

    public function advisor_approve($status, $std_id)
    {
        $this->db->query(
            "UPDATE `request_internship` SET `supervisor`=? WHERE `user_id`=?",
            array($status, $std_id)
        );
    }
}

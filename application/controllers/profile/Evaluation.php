<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper(array(
            'form',
            'url'
        ));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        
        $this->executeRedirection();
    }
    
    private function executeRedirection(){
        $profile = $this->profile_lib->getData();
        if($profile->user_type=="advisor"){
            redirect('/advisor/');
        }else if($profile->user_type=="trainer"){
            redirect('/trainer/');
        }else if($profile->user_type=="staff"){
            redirect('/staff/');
        }
    }

    public function index()
    {
        if (! $this->tank_auth->is_logged_in()) { // not logged in or not activated
            redirect('/auth/login/');
        } else {
            if($this->profile_lib->checkNotChooseInternship()){
                $this->load->view('nav');
                $this->load->view('student/changeprofile');
                $this->load->view('footer');
            } else {
                
                $profile = $this->profile_lib->getData();
                $student_id = $profile->user_id;
                
                $time_items = array();
                $activity_items = array();
                
                // TIME
                $sql = "SELECT * FROM time WHERE user_id={$student_id} ";
                $query = $this->db->query($sql);
                $time_items = $query->result();
                
                // ACTIVITY
                $sql = "SELECT * FROM activity WHERE user_id={$student_id} ";
                $query = $this->db->query($sql);
                $activity_items = $query->result();
                
                $data = array();
                $data['leftmenu'] = $this->load->view('trainer/menu', '', true);
                $data['time_items'] = $time_items;
                $data['activity_items'] = $activity_items;
                
                $this->load->view('nav');
                $this->load->view('student/evaluation',$data);
                $this->load->view('footer');
            }
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activity extends CI_Controller
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
    }
    
    public function index()
    {
        $profile = $this->profile_lib->getData();
        $user_id = $this->input->get_post('user_id', 0);
        $internship_id = $profile->internship_id;
        
        $data = array();
        $data['items'] = $this->activity_lib->getItems($user_id);
        $data['file_items'] = $this->activity_lib->getFileItems($user_id, $internship_id);
        $data['photo_items'] = $this->activity_lib->getPhotoItems($user_id, $internship_id);
        $data['profile'] = $profile;
        
        $this->load->view('nav');
        $this->load->view('preview/activity', $data);
        $this->load->view('footer');
    }

    public function form()
    {
        
        $profile = $this->profile_lib->getData();
        $week = $this->input->get_post('week', 1);
        $day = $this->input->get_post('day', 1);
        $user_id = $this->input->get_post('user_id', 0);
        
        $this->form_validation->set_rules('activity', 'กิจกรรม/งานที่ปฏิบัติ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('problem', 'ปัญหาและอุปสรรค', 'trim|required|xss_clean');
        $this->form_validation->set_rules('advantage', 'ประโยชน์ที่ได้รับ', 'trim|required|xss_clean');
        
        $data['errors'] = array();
        if ($this->form_validation->run()) { // validation ok
            if ($this->activity_lib->save(array(
                'user_id' => $profile->user_id,
                'day' => $day,
                'week' => $week,
                'activity' => $this->form_validation->set_value('activity'),
                'problem' => $this->form_validation->set_value('problem'),
                'advantage' => $this->form_validation->set_value('advantage')
            ))) { // success
                redirect('preview/activity/?user_id='.$user_id);
            } else { // fail
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v)
                    $data['errors'][$k] = $this->lang->line($v);
            }
        }
            
        $data = array();
        $data['item'] = $this->activity_lib->getItem($profile->user_id, $day, $week);
        $data['file_items'] = $this->activity_lib->getFileItems($profile->user_id, $profile->internship_id);
        $data['photo_items'] = $this->activity_lib->getPhotoItems($profile->user_id, $profile->internship_id);
        $data['day'] = $day;
        $data['week'] = $week;
        
        $this->load->view('nav');
        $this->load->view('preview/activity_form', $data);
        $this->load->view('footer');
    }
    
    public function file_remove()
    {
        $id = $this->input->get('id',0);
        $week = $this->input->get('week',0);
        $day = $this->input->get('day',0);
        if ($this->activity_lib->removeFile($id)) { // success
            redirect('preview/activity/form/?week='.$week.'&day='.$day);
        }
    }
    
    public function photo_remove()
    {
        $id = $this->input->get('id',0);
        $week = $this->input->get('week',0);
        $day = $this->input->get('day',0);
        if ($this->activity_lib->removePhoto($id)) { // success
            redirect('preview/activity/form/?week='.$week.'&day='.$day);
        }
    }
}

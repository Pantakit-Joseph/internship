<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class AdminUsers extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/adminusers_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->adminusers_model->getPagination();
        $data['items'] = $this->adminusers_model->getItems();
        
        $this->load->view('nav');
        $this->load->view('admin/users/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_type', 'ประเภทผู้ใช้', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->adminusers_model->save()) {
                redirect('/admin/users/');
            }
        }
            
        $id = $this->input->get_post('id',0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->adminusers_model->getPagination();
        $data['item'] = $this->adminusers_model->getItem($id);
        
        $this->load->view('nav');
        $this->load->view('admin/users/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id',0);
        $this->adminusers_model->publish($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id',0);
        $this->adminusers_model->unpublish($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id',0);
        $this->adminusers_model->trash($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id',0);
        $this->adminusers_model->delete($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id',0);
        $this->adminusers_model->restore($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/users/?per_page='.$per_page);
    }
}
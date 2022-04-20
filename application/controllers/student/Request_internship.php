<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request_internship extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Request_internship_model', 'request_internship');
    }

    public function index()
    {
        $data = array();
        $data['data'] = $this->request_internship->index();

        $this->load->view('nav');
        $this->load->view('student/request_internship', $data);
        $this->load->view('footer');
    }

    public function print_doc()
    {
        $data = array();
        $data['data'] = $this->request_internship->data_print();
        $this->load->library('Sawasdee');
        $this->load->view('student/request_internship_print', $data);
    }

    public function form()
    {
        if (!empty($this->input->post())) {
            $this->request_internship->form_submit();
            redirect('student/Request_internship');
            exit();
        }
        $data = array();
        $data['data'] = $this->request_internship->data_form();
        $this->load->view('nav');
        $this->load->view('student/request_internship_form', $data);
        $this->load->view('footer');
    }

}

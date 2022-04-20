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
        $data['data'] = $this->request_internship->advisor();

        $data['leftmenu'] = $this->load->view('advisor/menu', '', true);
        $this->load->view('nav');
        $this->load->view('advisor/request_internship/index', $data);
        $this->load->view('footer');
    }

    public function approve()
    {
        $s = $this->input->get('s');
        $std = $this->input->get('std');
        if (isset($s) && isset($std)) {
            $this->request_internship->advisor_approve(
                $s,
                $std
            );
        }

        redirect('advisor/request_internship');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {
        $this->load->view('nav');
        $this->load->view('home');
        $this->load->view('footer');
    }

    public function about()
    {
        $this->load->view('nav');
        $this->load->view('about');
        $this->load->view('footer');
    }

    public function contact()
    {
        $this->load->view('nav');
        $this->load->view('contact');
        $this->load->view('footer');
    }

    public function help()
    {
        $this->load->view('nav');
        $this->load->view('help');
        $this->load->view('footer');
    }
    public function admin_restricted_access(){
        echo "คุณไม่ได้รับอนุญาติให้เข้าใช้งาน /admin/ <br/><br/>";
        echo '<a href="/">กลับหน้าหลัก</a>';
    }
}

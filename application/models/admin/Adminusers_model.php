<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminusers_model extends BaseModel
{

    public $table = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Users');
        $this->table->setStatusKey('activated');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/users/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 10
        ));
    }

    public function pre_save(){
        //if password empty, set nothing
        $hidden_hash_password = $this->ci->input->post('hidden_hash_password');
        $plain_password = $this->ci->input->post('password');

        $hasher = new PasswordHash(
            $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
            $this->ci->config->item('phpass_hash_portable', 'tank_auth'));

        //enter new password
        if( !empty($plain_password) ){
            // Hash new password using phpass
			$hashed_password = $hasher->HashPassword($plain_password);
            $_POST['password'] = $hashed_password;
        }else{
            //add new user, set default password
            if(empty($hidden_hash_password)){
                $hidden_hash_password = $hasher->HashPassword('123456');
            }
            $_POST['password'] = $hidden_hash_password;
        }

        return $this->save();
    }
    
    public function checkEmailExists($email=''){
        $sql = "SELECT * FROM users WHERE email='".$email."'";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return count($items);
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT * FROM users WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function bypass_login($user_id = 0)
    {
        $this->table->load($user_id);
        return $this->ci->auth_lib->bypass_login(array(
            'user_id'	=> $this->table->id,
            'username'	=> $this->table->username,
            'email'	    => $this->table->email,
            'firstname'	=> $this->table->firstname,
            'lastname'	=> $this->table->lastname,
            'user_type'	=> $this->table->user_type,
            'thumbnail'	=> $this->table->thumbnail,
            'bypass'	=> 1,
            'status'	=> $this->table->activated
        ));
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('users_filter_search');
        $filter_user_type = $this->ci->input->get_post('users_filter_user_type');
        $filter_status = $this->ci->input->get_post('users_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "activated IN({$filter_status_value})";
        
        
        // filter: user_type
        if ($filter_user_type != "") {
            $filter_user_type_value = $filter_user_type;
            $wheres[] = "user_type='{$filter_user_type_value}'";
        }
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "(firstname LIKE '%{$filter_search_value}%' OR lastname LIKE '%{$filter_search_value}%' OR email LIKE '%{$filter_search_value}%')";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }

}

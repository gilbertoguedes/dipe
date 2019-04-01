<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CUsuarios extends REST_Controller
{
    function __construct() {
        parent::__construct();

    }

    public function do_login_post()
    {
        $result = array();
        $email 		= $this->input->post('email');
        $password 	= $this->input->post('password');

        if($this->user_auth->is_logged())
        {
            $result['result'] = '2';
            $result['message'] = 'Error, el usuario ya esta autenticado';

            $this->response($result,201);
        }
        else if ( $email == '' || $password == ''  || $this->user_auth->login($email, $password) === FALSE){
            $result['result'] = '2';
            $result['message'] = 'Error de autentificacion';
        }
        else
        {
            $data = array();
            $data['customer_id'] = $this->session->userdata('customer_id');
            $data['customer_name'] = $this->session->userdata('customer_name');
            $data['customer_email'] = $this->session->userdata('customer_email');
            $result['result'] = '1';
            $result['data'] = $data;
            $result['pagination'] = false;
        }

        $this->response($result,201);
    }

    public function logout_get()
    {
        $result = array();
        if ($this->user_auth->logout()) {
            $result['result'] = '1';
            $result['message'] = 'Correcto';
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'Error';
        }
        $this->response($result,201);
    }



}

?>
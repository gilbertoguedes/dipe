<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class CUsuarios extends MY_Controller
{
    function __construct() {
        parent::__construct();

    }

    public function do_login_post()
    {
        $email = $this->post('email'); //Username Posted
        echo $email;die();
        $password = $this->post('password'); //Pasword Posted
        $kunci = $this->config->item('thekey');

        $user = $this->user_auth->login_app($email, $password);
        if($user === FALSE)
        {
            $result['result'] = '2';
            $result['message'] = 'Credenciales invalidas';

            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        }
        else
        {
            $token['customer_id'] = $user['customer_id'];  //From here
            $token['customer_name'] = $user['customer_name'];
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
            $output['token'] = JWT::encode($token,$kunci ); //This is the output token

            $result['result'] = '1';
            $result['data'] = $output;

            $this->set_response($result, REST_Controller::HTTP_OK); //This is the respon if success
        }


        /*$val = $this->M_main->get_user($q)->row(); //Model to get single data row from database base on username*/
        /*if($this->M_main->get_user($q)->num_rows() == 0){$this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);}
        $match = $val->password;   //Get password for user from database
        if($p == $match){  //Condition if password matched
            $token['id'] = $val->id;  //From here
            $token['username'] = $u;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
            $output['token'] = JWT::encode($token,$kunci ); //This is the output token
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }*/
    }

    /*public function do_login_post()
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
    }*/



}

?>
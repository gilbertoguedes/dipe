<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CComprar extends MY_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }


    public function comprar_post()
    {

        $theCredential = $this->user_data;
        $result['result'] = '1';
        $result['data'] = $theCredential;
        $this->response($result, 200); // OK (200) being the HTTP response code
    }

}
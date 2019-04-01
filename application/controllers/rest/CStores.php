<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CStores extends REST_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('Stores');
    }

    public function stores_all_get()
    {
        $stores = $this->Stores->store_list();

        $result = array();

        if($stores)
        {
            $result['result'] = '1';
            $result['data'] = $stores;
            $result['pagination'] = false;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen tiendas';
        }

        $this->response($result,201);
    }

    public function store_default_get()
    {
        $store = $this->Stores->store_default();

        $result = array();

        if($store)
        {
            $result['result'] = '1';
            $result['data'] = $store;
            $result['pagination'] = false;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen tienda';
        }

        $this->response($result,201);
    }
}

?>
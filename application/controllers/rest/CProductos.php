<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CProductos extends REST_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->library('website/Lcategory');
        $this->load->model('website/Categories');
        $this->load->model('Stores');
    }

    public function category_product_search_url_get($store_id,$product_name,$cat_id)
    {
        if($product_name=="all_products")
        {
            $product_name = '';
        }
        else
        {
            $product_name = str_replace("%20"," ",$product_name);
        }

        $config["total_rows"] 	= $this->Categories->retrieve_category_product_count($cat_id,$product_name,$store_id);
        $config["per_page"] 	= 20;

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $products = $this->Categories->retrieve_category_product($cat_id,$product_name,$store_id,$config["per_page"],$page);

        $result = array();

        if($products)
        {
            $result['result'] = '1';
            $result['data'] = $products;
            $result['totals_rows'] = $config["total_rows"];
            $result['pagination'] = true;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen productos';
        }

        $this->response($result,201);
    }

    public function get_products_by_category_get($store_id,$category_id)
    {
        $config["total_rows"] 	= $this->Categories->cat_product_list_count($category_id,$store_id);
        $config["per_page"] 	= 20;

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $products = $this->Categories->category_product($category_id,$config["per_page"],$page,$store_id);

        $result = array();

        if($products)
        {
            $result['result'] = '1';
            $result['data'] = $products;
            $result['totals_rows'] = $config["total_rows"];
            $result['pagination'] = true;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen productos';
        }

        $this->response($result,201);
    }


    public function get_products_new_get($store_id)
    {
        $config["total_rows"] 	= ($this->Categories->product_new_count($store_id)<=100) ? $this->Categories->product_new_count($store_id):100;
        $config["per_page"] 	= 20;

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $products = $this->Categories->product_new($config["per_page"],$page,$store_id);

        $result = array();

        if($products)
        {
            $result['result'] = '1';
            $result['data'] = $products;
            $result['totals_rows'] = $config["total_rows"];
            $result['pagination'] = true;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen productos';
        }

        $this->response($result,201);
    }


    public function get_products_recomend_get($store_id)
    {
        $config["total_rows"] 	= $this->Categories->product_recomend_count($store_id);
        $config["per_page"] 	= 20;

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $products = $this->Categories->product_recomend($config["per_page"],$page,$store_id);

        $result = array();

        if($products)
        {
            $result['result'] = '1';
            $result['data'] = $products;
            $result['totals_rows'] = $config["total_rows"];
            $result['pagination'] = true;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen productos';
        }

        $this->response($result,201);
    }

    public function get_products_ofert_get($store_id)
    {
        $config["total_rows"] 	= $this->Categories->product_oferts_count($store_id);
        $config["per_page"] 	= 20;

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $products = $this->Categories->product_oferts($config["per_page"],$page,$store_id);

        $result = array();

        if($products)
        {
            $result['result'] = '1';
            $result['data'] = $products;
            $result['totals_rows'] = $config["total_rows"];
            $result['pagination'] = true;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen productos';
        }

        $this->response($result,201);
    }

}

?>
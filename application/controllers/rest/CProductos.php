<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CProductos extends REST_Controller
{
    public function category_product_search_url_get($store_id,$product_name,$cat_id)
    {
        $this->load->model('website/Categories');
        $this->load->model('Stores');

        $config["base_url"] 	= base_url('api_category_product_search_url/'.$store_id.'/'.$product_name.'/'.$cat_id);
        if($product_name=="all_products")
        {
            $product_name = '';
        }
        else
        {
            $product_name = str_replace("%20"," ",$product_name);
        }

        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;

        #
        #pagination starts
        #
        //echo $product_name;die();
        $config["total_rows"] 	= $this->Categories->retrieve_category_product_count($cat_id,$product_name,$store_id);
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 5;
        $config["num_links"] 	= 5;

        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #

        $products = $this->Categories->retrieve_category_product($cat_id,$product_name,$store_id,$config["per_page"],$page);

        $this->response($products,201);
    }
}

?>
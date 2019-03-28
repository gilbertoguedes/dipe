<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CProductos extends REST_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->library('website/Lcategory');
        $this->load->model('website/Categories');
        $this->load->model('website/Products_model');
        $this->load->model('Stores');

        /*$this->load->library('website/Lhome');
        $this->load->library('Lorder');
        $this->load->library('paypal_lib');
        $this->load->model('website/Homes');
        $this->load->model('website/Homes');
        $this->load->model('Subscribers');
        $this->qrgenerator();
        $this->load->model('Customer_dashboards');
        $this->load->model('website/Products_model');
        $this->load->model('website/Settings');*/
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

    public function prueba_get()
    {
        if($this->session->userdata('num')>0)
        {
            $num = $this->session->userdata('num');
            $num = $num + 1;
            $this->session->set_userdata('num',$num);
        }
        else
        {
            $this->session->set_userdata('num',1);
        }
        $this->response($num,201);
    }

    public function get_product_by_id_get($product_id,$store_id)
    {
        $product = $this->Products_model->product_info($product_id);

        $stock = $this->Products_model->store_stock_report_single_item_by_store($product_id,$store_id);

        $related_product = $this->Products_model->related_product($product->category_id,$product_id,$store_id);

        $result = array();
        $data = array();

        if($product)
        {
            $data['product'] = $product;
            $data['stock'] = $stock;
            $data['related'] = $related_product;

            $result['result'] = '1';
            $result['data'] = $data;
            $result['pagination'] = false;
        }
        else
        {
            $result['result'] = '2';
            $result['message'] = 'No existen productos';
        }

        $this->response($result,201);
    }

    //Add to cart for details
    /*public function add_to_cart_details(){

        $product_id = $this->input->post('product_id');
        $qnty 		= $this->input->post('qnty');
        $variant    = $this->input->post('variant');

        $discount = 0;
        $onsale_price = 0;
        $cgst = 0;
        $cgst_id = 0;

        $sgst = 0;
        $sgst_id = 0;

        $igst = 0;
        $igst_id = 0;

        if ($product_id) {
            $product_details = $this->Homes->product_details($product_id);

            //CGST product tax
            $this->db->select('*');
            $this->db->from('tax_product_service');
            $this->db->where('product_id',$product_details->product_id);
            $this->db->where('tax_id','H5MQN4NXJBSDX4L');
            $tax_info = $this->db->get()->row();

            if (!empty($tax_info)) {
                if (($product_details->onsale == 1)) {
                    $cgst = ($tax_info->tax_percentage * $product_details->onsale_price)/100;
                    $cgst_id = $tax_info->tax_id;
                }else{
                    $cgst = ($tax_info->tax_percentage * $product_details->price)/100;
                    $cgst_id = $tax_info->tax_id;
                }
            }

            if ($product_details->onsale) {
                $price = $product_details->onsale_price ;
                $onsale_price = $product_details->onsale_price ;
                $discount = $product_details->price - $product_details->onsale_price;
            }else{
                $price = $product_details->price ;
            }

            //SGST product tax
            $this->db->select('*');
            $this->db->from('tax_product_service');
            $this->db->where('product_id',$product_details->product_id);
            $this->db->where('tax_id','52C2SKCKGQY6Q9J');
            $tax_info = $this->db->get()->row();

            if (!empty($tax_info)) {
                if (($product_details->onsale == 1)) {
                    $sgst = ($tax_info->tax_percentage * $product_details->onsale_price)/100;
                    $sgst_id = $tax_info->tax_id;
                }else{
                    $sgst = ($tax_info->tax_percentage * $product_details->price)/100;
                    $sgst_id = $tax_info->tax_id;
                }
            }

            //IGST product tax
            $this->db->select('*');
            $this->db->from('tax_product_service');
            $this->db->where('product_id',$product_details->product_id);
            $this->db->where('tax_id','5SN9PRWPN131T4V');
            $tax_info = $this->db->get()->row();

            if (!empty($tax_info)) {
                if (($product_details->onsale == 1)) {
                    $igst = ($tax_info->tax_percentage * $product_details->onsale_price)/100;
                    $igst_id = $tax_info->tax_id;
                }else{
                    $igst = ($tax_info->tax_percentage * $product_details->price)/100;
                    $igst_id = $tax_info->tax_id;
                }
            }

            //Shopping cart validation
            $flag = TRUE;
            $dataTmp = $this->cart->contents();

            foreach ($dataTmp as $item) {
                if (($item['product_id'] == $product_id) && ($item['variant'] == $variant)) {
                    $data = array(
                        'rowid' => $item['rowid'],
                        'qty'   => $item['qty'] + $qnty
                    );
                    $this->cart->update($data);
                    $flag = FALSE;
                    break;
                }
            }

            if ($flag) {
                $data = array(
                    'id'      => $this->generator(15),
                    'product_id'      => $product_details->product_id,
                    'qty'     => $qnty,
                    'price'   => $price,
                    'actual_price'   => $product_details->price,
                    'supplier_price' => $product_details->supplier_price,
                    'onsale_price'   => $onsale_price,
                    'name'    => $product_details->product_name,
                    'discount'=> $discount,
                    'variant' => $variant,
                    'options' => array(
                        'image' => $product_details->image_thumb,
                        'model' => $product_details->product_model,
                        'cgst' 	=> $cgst,
                        'sgst' 	=> $sgst,
                        'igst' 	=> $igst,
                        'cgst_id' 	=> $cgst_id,
                        'sgst_id' 	=> $sgst_id,
                        'igst_id' 	=> $igst_id,
                    )
                );
                $result = $this->cart->insert($data);
            }
            echo "1";
        }
    }*/

}

?>
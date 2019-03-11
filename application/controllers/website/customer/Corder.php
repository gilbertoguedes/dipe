<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Corder extends CI_Controller {
	
	function __construct() {
      	parent::__construct();
      	$this->user_auth->check_customer_auth();
      	$this->load->library('website/customer/Lorder');
      	$this->load->model('website/customer/Orders');
    }

    //Index page load first
	public function index()
	{
		$content = $this->lorder->order_add_form();
		$this->template->full_customer_html_view($content);
	}

	//Add new order
	public function new_order()
	{
		$content = $this->lorder->order_add_form();
		$this->template->full_customer_html_view($content);
	}

    //Add new order
    public function show_order($order_id)
    {
        $content = $this->lorder->order_show_data($order_id);
        $this->template->full_customer_html_view($content);
    }

	//Insert order
	public function insert_order()
	{
		$order_id = $this->Orders->order_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		$this->order_inserted_data($order_id);
		redirect(base_url('website/customer/Corder/manage_order'));
	}

	//Retrive right now inserted data to cretae html
	public function order_inserted_data($order_id)
	{
		$content = $this->lorder->order_html_data($order_id);		
		$this->template->full_customer_html_view($content);
	}

	// Retrive product data
	public function retrieve_product_data()
	{
		$product_id 	= $this->input->post('product_id');
		$product_info 	= $this->Orders->get_total_product($product_id);
		echo json_encode($product_info);
	}

	//Stock available check
	public function available_stock(){

		$product_id = $this->input->post('product_id');
		$variant_id = $this->input->post('variant_id');
		$store_id 	= $this->input->post('store_id');

		$this->db->select('SUM(a.quantity) as total_purchase');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.product_id',$product_id);
		$this->db->where('a.variant_id',$variant_id);
		$this->db->where('a.store_id',$store_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.product_id',$product_id);
		$this->db->where('b.variant_id',$variant_id);
		$this->db->where('b.store_id',$store_id);
		$total_sale = $this->db->get()->row();

		echo $total_purchase->total_purchase - $total_sale->total_sale;
	}

	//Manage order
	public function manage_order()
	{
        $content = $this->lorder->order_list();
		$this->template->full_customer_html_view($content);
	}
}
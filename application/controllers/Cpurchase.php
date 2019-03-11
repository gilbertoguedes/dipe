<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cpurchase extends CI_Controller {
	
	function __construct() {
      	parent::__construct();
    }

    //Default index function loading
	public function index()
	{	
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$content = $CI->lpurchase->purchase_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Purchase Add Form
	public function manage_purchase()
	{
		$CI =& get_instance();
   		//$CI->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$CI->load->model('Purchases');
        $content = $CI->lpurchase->purchase_list();
		$this->template->full_admin_html_view($content);
	}
	//Insert Purchase and uload
	public function insert_purchase()
	{
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->model('Purchases');
		$CI->Purchases->purchase_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-purchase'])){
			redirect(base_url('Cpurchase/manage_purchase'));
		}elseif(isset($_POST['add-purchase-another'])){
			redirect(base_url('Cpurchase'));
		}
	}
	//Purchase Update Form
	public function purchase_update_form($purchase_id)
	{	
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$content = $CI->lpurchase->purchase_edit_data($purchase_id);
		$this->template->full_admin_html_view($content);
	}
	//Purchase Update
	public function purchase_update()
	{
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->model('Purchases');
		$CI->Purchases->update_purchase();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('Cpurchase/manage_purchase'));
	}
	// Purchase delete 
	public function purchase_delete($purchase_id)
	{	
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->model('Purchases');
		$CI->Purchases->delete_purchase($purchase_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect('Cpurchase/manage_purchase');
	}
	//Purchase item by search
	public function purchase_item_by_search()
	{
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$supplier_id = $this->input->post('supplier_id');			
        $content = $CI->lpurchase->purchase_by_search($supplier_id);
		$this->template->full_admin_html_view($content);
	}
	//Purchase search by supplier id
	public function product_search_by_supplier(){

		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$CI->load->model('Suppliers');
		$supplier_id = $this->input->post('supplier_id');			
		$product_name = $this->input->post('product_name');
        $store_id = $this->input->post('store_id');
        $product_info = $CI->Suppliers->product_search_store_item($supplier_id,$product_name,$store_id);

		$list[''] = "";
		foreach ($product_info as $value) {
			$json_product[] = array('label'=>$value['product_name'],'value'=>$value['product_id']);
		} 
        echo json_encode($json_product);
	}
	// Retrieve Purchase Data
	public function retrieve_product_data()
	{
		$CI =& get_instance();
		//$this->auth->check_admin_auth();
		$CI->load->model('Purchases');
		$product_id = $this->input->post('product_id');
		$product_info = $CI->Purchases->get_total_product($product_id);
		echo json_encode($product_info);
	}
	//Retrive right now inserted data to cretae html
	public function purchase_details_data($purchase_id)
	{	
		$CI =& get_instance();
		//$CI->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$content = $CI->lpurchase->purchase_details_data($purchase_id);	
		$this->template->full_admin_html_view($content);
	}
	//Stock in available
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

	//Wearhouse available stock check
	public function wearhouse_available_stock(){

		$product_id 	= $this->input->post('product_id');
		$variant_id 	= $this->input->post('variant_id');
		$store_id 		= $this->input->post('store_id');
		$wearhouse_id 	= $this->input->post('wearhouse_id');
		$purchase_to 	= $this->input->post('purchase_to');

		if ($purchase_to == 1) {
			$this->db->select('SUM(a.quantity) as total_purchase');
			$this->db->from('product_purchase_details a');
			$this->db->where('a.product_id',$product_id);
			$this->db->where('a.variant_id',$variant_id);
			$this->db->where('a.wearhouse_id',$wearhouse_id);
			$total_purchase = $this->db->get()->row();
			echo $total_purchase->total_purchase;
		}else{
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
	}
}
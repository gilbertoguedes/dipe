<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Corder extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
    }
	public function index()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('Lorder');
		$content = $CI->lorder->order_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Add new order
	public function new_order()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('Lorder');
		$content = $CI->lorder->order_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert product and upload
	public function insert_order()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('Orders');
		$order_id = $CI->Orders->order_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		$this->order_inserted_data($order_id);

		if(isset($_POST['add-order'])){
			redirect(base_url('Corder/manage_order'));
		}elseif(isset($_POST['add-order-another'])){
			redirect(base_url('Corder'));
		}
	}
	//Retrive right now inserted data to cretae html
	public function order_inserted_data($order_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('Lorder');
		$content = $CI->lorder->order_html_data($order_id);	
		$this->template->full_admin_html_view($content);
	}

	//Retrive right now inserted data to cretae html
	public function order_details_data($order_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('Lorder');
		$content = $CI->lorder->order_details_data($order_id);	
		$this->template->full_admin_html_view($content);
	}

	//Manage order
	public function manage_order()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('Lorder');
		$CI->load->model('Orders');

        $content = $CI->lorder->order_list();
		$this->template->full_admin_html_view($content);
	}
	
	//order Update Form
	public function order_update_form($order_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('Lorder');
		$content = $CI->lorder->order_edit_data($order_id);
		$this->template->full_admin_html_view($content);
	}
	//Search Inovoice Item
	public function search_inovoice_item()
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('Lorder');
		
		$customer_id = $this->input->post('customer_id');
        $content = $CI->lorder->search_inovoice_item($customer_id);
		$this->template->full_admin_html_view($content);
	}
	// order Update
	public function order_update()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('Orders');
		$order_id = $CI->Orders->update_order();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		$this->order_inserted_data($order_id);
	}
	// order paid data
	public function order_paid_data($order_id){
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('Orders');
		$order_id = $CI->Orders->order_paid_data($order_id);
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		redirect('Corder/manage_order');
	}

	// retrieve_product_data
	public function retrieve_product_data()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Orders');
		$product_id = $this->input->post('product_id');
		$product_info = $CI->Orders->get_total_product($product_id);
		echo json_encode($product_info);
	}
	// product_delete
	public function order_delete($order_id)
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Orders');
		$result = $CI->Orders->delete_order($order_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Corder/manage_order');
		}	
	}
	//AJAX order STOCKs
	public function product_stock_check($product_id)
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Orders');

		$purchase_stocks = $CI->Orders->get_total_purchase_item($product_id);	
		$total_purchase = 0;		
		if(!empty($purchase_stocks)){	
			foreach($purchase_stocks as $k=>$v){
				$total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
			}
		}
		$sales_stocks = $CI->Orders->get_total_sales_item($product_id);
		$total_sales = 0;	
		if(!empty($sales_stocks)){	
			foreach($sales_stocks as $k=>$v){
				$total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
			}
		}
		
		$final_total = ($total_purchase - $total_sales);
		return $final_total ;
	}

	//Search product by product name and category
	public function search_product(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Orders');
		$product_name = $this->input->post('product_name');
		$category_id  = $this->input->post('category_id');
		$product_search = $this->Orders->product_search($product_name,$category_id);
        if ($product_search) {
            foreach ($product_search as $product) {
            echo "<div class=\"col-xs-6 col-sm-4 col-md-2 col-p-3\">";
                echo "<div class=\"panel panel-bd product-panel select_product\">";
                    echo "<div class=\"panel-body\">";
                        echo "<img src=\"$product->image_thumb\" class=\"img-responsive\" alt=\"\">";
                        echo "<input type=\"hidden\" name=\"select_product_id\" class=\"select_product_id\" value='".$product->product_id."'>";
                    echo "</div>";
                    echo "<div class=\"panel-footer\">$product->product_model - $product->product_name</div>";
                echo "</div>";
            echo "</div>";
        	}
        }else{
        	echo "420";
        }
	}

	//Insert new customer
	public function insert_customer(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Orders');

		$customer_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'customer_id' 		=> $customer_id,
			'customer_name' 	=> $this->input->post('customer_name'),
			'customer_mobile' 	=> $this->input->post('mobile'),
			'customer_email' 	=> $this->input->post('email'),
			'status' 			=> 1
			);

		$result=$this->Orders->customer_entry($data);
		
		if ($result == TRUE) {		
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			redirect(base_url('Corder/pos_order'));
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Corder/pos_order'));
		}
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("1","2","3","4","5","6","7","8","9");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,8);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}

    //Add new order
    public function store_show_order($order_id)
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('Lorder');
        $CI->load->model('Orders');
        $content = $CI->lorder->order_show_data($order_id);
        $this->template->full_admin_html_view($content);
    }
}
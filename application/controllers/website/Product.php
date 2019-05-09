<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('website/Lproduct');
		$this->load->model('website/Products_model');
		$this->load->model('Subscribers');
    }

	//Default loading for Product Index.
	public function index()
	{
		$content = $this->lproduct->Product_page();
		$this->template->full_website_html_view($content);
	}	

	//Default loading for Product Details.
	public function product_details($p_id)
	{
        $store_id = $this->session->userdata('store_id');
		$content = $this->lproduct->store_product_details($p_id,$store_id);
		$this->template->full_website_html_view($content);
	}	

	//Check variant wise stock
	public function check_variant_wise_stock()
	{
		$variant_id = $this->input->post('variant_id');
		$product_id = $this->input->post('product_id');
		$stock = $this->Products_model->check_variant_wise_stock($variant_id,$product_id);

		if ($stock > 0) {
			echo "1";
		}else{
			echo "2";
		}
	}
	//Submit a subscriber.
	public function add_subscribe()
	{
		$data=array(
			'subscriber_id' => $this->generator(15),
			'apply_ip' 		=> $this->input->ip_address(),
			'email' 		=> $this->input->post('sub_email'),
			'status' 		=> 1
		);

		$result=$this->Subscribers->subscriber_entry($data);

		if ($result) {
			echo "2";
		}else{
			echo "3";
		}
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,34);
			$rand_number=$number["$rand_value"];
		
			if(empty($con)){ 
				$con=$rand_number;
			}
			else{
				$con="$con"."$rand_number";
			}
		}
		return $con;
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchases extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Count purchase
	public function count_purchase()
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		return $query=$this->db->get()->num_rows();
	}
	//purchase List
	public function purchase_list()
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Select All Supplier List
	public function select_all_supplier()
	{
		$query = $this->db->select('*')
					->from('supplier_information')
					->where('status','1')
					->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Purchase Search  List
	public function purchase_by_search($supplier_id)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('b.supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Purchase entry
	public function purchase_entry()
	{
		//Generator purchase id
		$purchase_id = $this->auth->generator(15);
		
		$p_id 		 = $this->input->post('product_id');
		$supplier_id = $this->input->post('supplier_id');
		$quantity 	= $this->input->post('product_quantity');
		
		//Supplier & product id relation ship checker.
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_id = $p_id[$i];
			$value 		= $this->product_supplier_check($product_id,$supplier_id);
			if($value == 0){
			  	$this->session->set_userdata(array('message'=> display("product_and_supplier_did_not_match")));
			  	redirect(base_url('Cpurchase'));
			}
		}



		//Add Product To Purchase Table
		$data=array(
			'purchase_id'			=>	$purchase_id,
			'invoice_no'			=>	$this->input->post('invoice_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'store_id'				=>	$this->input->post('store_id'),
			'wearhouse_id'			=>	$this->input->post('wearhouse_id'),
			'grand_total_amount'	=>	$this->input->post('grand_total_price'),
			'purchase_date'			=>	$this->input->post('purchase_date'),
			'purchase_details'		=>	$this->input->post('purchase_details'),
			'user_id'				=>	$this->session->userdata('user_id'),
			'status'				=>	1
		);
		$this->db->insert('product_purchase',$data);
		
		//Add Product To Supplier Ledger
		$ledger=array(
			'transaction_id'		=>	$this->auth->generator(15),
			'purchase_id'			=>	$purchase_id,
			'invoice_no'			=>	$this->input->post('invoice_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'amount'				=>	$this->input->post('grand_total_price'),
			'date'					=>	$this->input->post('purchase_date'),
			'description'			=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);

		$this->db->insert('supplier_ledger',$ledger);
		
		//Product Purchase Details
		$rate 		= $this->input->post('product_rate');
		$t_price 	= $this->input->post('total_price');
		
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $t_price[$i];
			$variant = $variant_id[$i];
			
			$data1 = array(
				'purchase_detail_id'	=>	$this->auth->generator(15),
				'purchase_id'			=>	$purchase_id,
				'product_id'			=>	$product_id,
				'wearhouse_id'			=>	$this->input->post('wearhouse_id'),
				'store_id'				=>	$this->input->post('store_id'),
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'total_amount'			=>	$total_price,
				'status'				=>	1
			);

			if(!empty($quantity))
			{
				$this->db->insert('product_purchase_details',$data1);
			}

			// Purchase to wearhouse
			if ($this->input->post('purchase_to') == 1) {
				$wearhouse=array(
					'transfer_id'	=>	$this->auth->generator(15),
					'purchase_id'	=>	$purchase_id,
					'warehouse_id'	=>	$this->input->post('wearhouse_id'),
					'product_id'	=>	$product_id,
					'date_time'		=>	$this->input->post('purchase_date'),
					'quantity'		=>	$product_quantity,
					'status'		=> 5
				);

				if(!empty($quantity))
				{
					$result = $this->db->select('*')
										->from('transfer')
										->where('warehouse_id',$wearhouse['warehouse_id'])
										->where('product_id',$wearhouse['product_id'])
										->get()
										->num_rows();

					if ($result > 0) {
						$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
						$this->db->set('status', '5', FALSE);
						$this->db->where('warehouse_id',$wearhouse['warehouse_id']);
						$this->db->where('product_id',$product_id);
						$this->db->update('transfer');
					}else{
						$this->db->insert('transfer',$wearhouse);
					}
				}
			}

			//Store product purchase
			elseif ($this->input->post('purchase_to') == 2){
				$store=array(
					'transfer_id'	=>	$this->auth->generator(15),
					'purchase_id'	=>	$purchase_id,
					'store_id'		=>	$this->input->post('store_id'),
					'product_id'	=>	$product_id,
					'date_time'		=>	$this->input->post('purchase_date'),
					'quantity'		=>	$product_quantity,
					'status'		=>  3
				);

				if(!empty($quantity))
				{
					$result = $this->db->select('*')
										->from('transfer')
										->where('store_id',$store['store_id'])
										->where('product_id',$product_id)
										->get()
										->num_rows();

					if ($result > 0) {
						$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
						$this->db->set('status', '5', FALSE);
						$this->db->where('store_id',$store['store_id']);
						$this->db->where('product_id',$product_id);
						$this->db->update('transfer');
					}else{
						$this->db->insert('transfer',$store);
					}
				}
			}
		}
		return true;
	}
	//Retrieve purchase Edit Data
	public function retrieve_purchase_editdata($purchase_id)
	{
		$this->db->select('a.*,b.*,c.product_id,c.product_name,c.product_model,d.supplier_id,d.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('product_purchase_details b','b.purchase_id =a.purchase_id');
		$this->db->join('product_information c','c.product_id =b.product_id');
		$this->db->join('supplier_information d','d.supplier_id = a.supplier_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$this->db->order_by('a.purchase_details','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update Purchase
	public function update_purchase()
	{
		//Generator purchase id
		$purchase_id = $this->input->post('purchase_id');
		
		$p_id 		 = $this->input->post('product_id');
		$supplier_id = $this->input->post('supplier_id');
		
		//Supplier & product id relation ship checker.
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_id = $p_id[$i];
			$value 		= $this->product_supplier_check($product_id,$supplier_id);
			if($value == 0){
			  	$this->session->set_userdata('error_message' , display("product_and_supplier_did_not_match"));
			  	redirect(base_url('Cpurchase'));
			}
		}

		//Update Product Purchase Table
		$data=array(
			'purchase_id'			=>	$purchase_id,
			'invoice_no'			=>	$this->input->post('invoice_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'store_id'				=>	$this->input->post('store_id'),
			'wearhouse_id'			=>	$this->input->post('wearhouse_id'),
			'grand_total_amount'	=>	$this->input->post('grand_total_price'),
			'purchase_date'			=>	$this->input->post('purchase_date'),
			'purchase_details'		=>	$this->input->post('purchase_details'),
			'user_id'				=>	$this->session->userdata('user_id'),
			'status'				=>	1
		);

		$this->db->where('purchase_id',$purchase_id);
		$result = $this->db->delete('product_purchase');

		if ($result) {
			$this->db->insert('product_purchase',$data);
		}

		//Add Product To Supplier Ledger
		$ledger=array(
			'invoice_no'			=>	$this->input->post('invoice_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'amount'				=>	$this->input->post('grand_total_price'),
			'date'					=>	$this->input->post('purchase_date'),
			'description'			=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);
		$this->db->where('purchase_id',$purchase_id);
		$this->db->update('supplier_ledger',$ledger);

		//Delete old purchase details info
		if (!empty($purchase_id)) {
			$this->db->where('purchase_id',$purchase_id);
			$this->db->delete('product_purchase_details'); 

			//Delete transfer data from transfer
			$this->db->where('purchase_id',$purchase_id);
			$this->db->delete('transfer');
		}
		
		//Product Purchase Details
		$rate 				= $this->input->post('product_rate');
		$quantity 			= $this->input->post('product_quantity');
		$t_price 			= $this->input->post('total_price');
		$purchase_detail_id = $this->input->post('purchase_detail_id');

		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$total_price 	  = $t_price[$i];
			
			$data1 = array(
				'purchase_detail_id'	=>	$this->auth->generator(15),
				'purchase_id'			=>	$purchase_id,
				'product_id'			=>	$product_id,
				'store_id'				=>	$this->input->post('store_id'),
				'wearhouse_id'			=>	$this->input->post('wearhouse_id'),
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'total_amount'			=>	$total_price,
				'status'				=>	1
			);

			if(!empty($quantity))
			{
				$this->db->insert('product_purchase_details',$data1);
			}

			// Purchase to wearhouse
			if ($this->input->post('purchase_to') == 1) {
				$wearhouse=array(
					'transfer_id'	=>	$this->auth->generator(15),
					'purchase_id'	=>	$purchase_id,
					'warehouse_id'	=>	$this->input->post('wearhouse_id'),
					'product_id'	=>	$product_id,
					'date_time'		=>	$this->input->post('purchase_date'),
					'quantity'		=>	$product_quantity,
					'status'		=> 	5
				);

				$this->db->insert('transfer',$wearhouse);
			}
			//Store product purchase
			elseif ($this->input->post('purchase_to') == 2){
				$store=array(
					'transfer_id'	=>	$this->auth->generator(15),
					'purchase_id'	=>	$purchase_id,
					'store_id'		=>	$this->input->post('store_id'),
					'product_id'	=>	$product_id,
					'date_time'		=>	$this->input->post('purchase_date'),
					'quantity'		=>	$product_quantity,
					'status'		=>  3
				);

				$this->db->insert('transfer',$store);
			}
		}
		return true;
	}

	//Get total product
	public function get_total_product($product_id){

		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where(array('product_information.product_id' => $product_id,'product_information.status' => 1)); 
		$product_information = $this->db->get()->row();

		$html = "";
		if ($product_information->variants) {
			$exploded = explode(',',$product_information->variants);
			$html .="<select id=\"variant_id\" class=\"form-control variant_id\" required=\"\" style=\"width:200px\">
	                    <option value=\"\">".display('select_variant')."</option>";
	        foreach ($exploded as $elem) {
		        $this->db->select('*');
		        $this->db->from('variant');
		        $this->db->where('variant_id',$elem);
		        $this->db->order_by('variant_name','asc');
		        $result = $this->db->get()->row();

		        $html .="<option value=".$result->variant_id.">".$result->variant_name."</option>";
	    	}
	    	$html .="</select>";
	    }

		$data2 = array( 
			'product_id' 		=> $product_information->product_id, 
			'supplier_price'    => $product_information->supplier_price, 
			'variant'    		=> $html, 
		);

		return $data2;
	}
	//Retrieve company Edit Data
	public function retrieve_company()
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete purchase Item
	public function delete_purchase($purchase_id)
	{
		//Delete product_purchase table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase'); 
		//Delete product_purchase_details table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase_details');
		//Delete transer info table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('transfer');
		return true;
	}
	public function purchase_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('purchases a');
		$this->db->join('purchase_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('purchase_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve purchase_details_data
	public function purchase_details_data($purchase_id)
	{
		$this->db->select('a.*,b.*,c.*,e.purchase_details,d.product_id,d.product_name,d.product_model,f.variant_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('product_purchase e','e.purchase_id = c.purchase_id');
		$this->db->join('variant f','f.variant_id = c.variant_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//This function will check the product & supplier relationship.
	public function product_supplier_check($product_id,$supplier_id)
	{
	 	$this->db->select('*');
	  	$this->db->from('product_information');
	  	$this->db->where('product_id',$product_id);
	  	$this->db->where('supplier_id',$supplier_id);	
	  	$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;	
		}
		return 0;
	}
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,61);
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
}
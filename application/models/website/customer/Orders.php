<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('User_auth');
		$this->user_auth->check_customer_auth();
	}

	//Order List
	public function order_list()
	{
		$customer_id = $this->session->userdata('customer_id');
		$this->db->select('a.*,b.customer_name');
		$this->db->from('order a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('b.customer_id',$customer_id);
		$this->db->order_by('a.order','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Order List Count
	public function total_customer_order($customer_id)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('order a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('b.customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}

	//Order entry
	public function order_entry()
	{
		//Order information
		$order_id 			= $this->auth->generator(15);
		$quantity 			= $this->input->post('product_quantity');
		$available_quantity = $this->input->post('available_quantity');
		$product_id 		= $this->input->post('product_id');

		//Stock availability check
		$result = array();
		foreach($available_quantity as $k => $v)
		{
		    if($v < $quantity[$k])
		    {
		       $this->session->set_userdata(array('error_message'=>display('you_can_not_buy_greater_than_available_cartoon')));
		       redirect('Corder');
		    }
		}

		//Product existing check
		if ($product_id == null) {
			$this->session->set_userdata(array('error_message'=>display('please_select_product')));
			redirect('Corder');
		}

		//Customer existing check
		if (($this->input->post('customer_name_others') == null) && ($this->input->post('customer_id') == null )) {
			$this->session->set_userdata(array('error_message'=>display('please_select_customer')));
			redirect(base_url().'Corder');
		}
		
		//Customer data Existence Check.
		if($this->input->post('customer_id') == "" ){

			$customer_id=$this->auth->generator(15);
		  	//Customer  basic information adding.
			$data=array(
				'customer_id' 	=> $customer_id,
				'customer_name' => $this->input->post('customer_name_others'),
				'customer_address_1' 	=>$this->input->post('customer_name_others_address'),
				'customer_mobile' 	=> "NONE",
				'customer_email' 	=> "NONE",
				'status' 			=> 1
				);
		
			$result = $this->Customers->customer_entry($data);
			if ($result == false) {
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect('Corder/manage_order');
			}
		  	//Previous balance adding -> Sending to customer model to adjust the data.
			$this->Customers->previous_balance_add(0,$customer_id);
		}
		else{
			$customer_id=$this->input->post('customer_id');
		}

		//Data inserting into order table
		$data=array(
			'order_id'			=>	$order_id,
			'customer_id'		=>	$this->input->post('customer_id'),
			'date'				=>	$this->input->post('invoice_date'),
			'total_amount'		=>	$this->input->post('grand_total_price'),
			'order'				=>	$this->number_generator_order(),
			'total_discount' 	=> 	$this->input->post('total_discount'),
			'order_discount' 	=> 	$this->input->post('invoice_discount') + $this->input->post('total_discount'),
			'service_charge' 	=> 	$this->input->post('service_charge'),
			'store_id'			=>	$this->input->post('store_id'),
			'paid_amount'		=>	$this->input->post('paid_amount'),
			'due_amount'		=>	$this->input->post('due_amount'),
			'status'			=>	1
		);
		$this->db->insert('order',$data);

		//Order details info
		$rate 		= $this->input->post('product_rate');
		$p_id 		= $this->input->post('product_id');
		$total_amount = $this->input->post('total_price');
		$discount 	= $this->input->post('discount');
		$variants 	= $this->input->post('variant_id');

		//Order details entry
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$discount_rate    = $discount[$i];
			$total_price      = $total_amount[$i];
			$variant_id       = $variants[$i];
			$supplier_rate    = $this->supplier_rate($product_id);
			
			$order_details = array(
				'order_details_id'	=>	$this->auth->generator(15),
				'order_id'			=>	$order_id,
				'product_id'		=>	$product_id,
				'variant_id'		=>	$variant_id,
				'store_id'			=>	$this->input->post('store_id'),
				'quantity'			=>	$product_quantity,
				'rate'				=>	$product_rate,
				'supplier_rate'     =>	$supplier_rate[0]['supplier_price'],
				'total_price'       =>	$total_price,
				'discount'          =>	$discount_rate,
				'status'			=>	1
			);

			if(!empty($quantity))
			{
				$result = $this->db->select('*')
									->from('order_details')
									->where('order_id',$order_id)
									->where('product_id',$product_id)
									->where('variant_id',$variant_id)
									->get()
									->num_rows();
				if ($result > 0) {
					$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
					$this->db->set('total_price', 'total_price+'.$total_price, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('product_id', $product_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('order_details');
				}else{
					$this->db->insert('order_details',$order_details);
				}
			}
		}

		//Tax info
		$cgst = $this->input->post('cgst');
		$sgst = $this->input->post('sgst');
		$igst = $this->input->post('igst');
		$cgst_id = $this->input->post('cgst_id');
		$sgst_id = $this->input->post('sgst_id');
		$igst_id = $this->input->post('igst_id');

		//Tax collection summary for three
		//CGST tax info
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$cgst_summary = array(
				'order_tax_col_id'	=>	$this->auth->generator(15),
				'order_id'		=>	$order_id,
				'tax_amount' 		=> 	$cgst_tax, 
				'tax_id' 			=> 	$cgst_tax_id,
				'date'				=>	$this->input->post('invoice_date'),
			);
			if(!empty($cgst[$i])){
				$result= $this->db->select('*')
							->from('order_tax_col_summary')
							->where('order_id',$order_id)
							->where('tax_id',$cgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->update('order_tax_col_summary');
				}else{
					$this->db->insert('order_tax_col_summary',$cgst_summary);
				}
			}
		}

		//SGST tax info
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			
			$sgst_summary = array(
				'order_tax_col_id'	=>	$this->auth->generator(15),
				'order_id'		=>	$order_id,
				'tax_amount' 		=> 	$sgst_tax, 
				'tax_id' 			=> 	$sgst_tax_id,
				'date'				=>	$this->input->post('invoice_date'),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('order_tax_col_summary')
							->where('order_id',$order_id)
							->where('tax_id',$sgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->update('order_tax_col_summary');
				}else{
					$this->db->insert('order_tax_col_summary',$sgst_summary);
				}
			}
		}

		//IGST tax info
       	for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			
			$igst_summary = array(
				'order_tax_col_id'	=>	$this->auth->generator(15),
				'order_id'		=>	$order_id,
				'tax_amount' 		=> 	$igst_tax, 
				'tax_id' 			=> 	$igst_tax_id,
				'date'				=>	$this->input->post('invoice_date'),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('order_tax_col_summary')
							->where('order_id',$order_id)
							->where('tax_id',$igst_tax_id)
							->get()
							->num_rows();

				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->update('order_tax_col_summary');
				}else{
					$this->db->insert('order_tax_col_summary',$igst_summary);
				}
			}
		}
		//Tax collection summary for three


		//Tax collection details for three
		//CGST tax info
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax 	 = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$cgst_details = array(
				'order_tax_col_de_id'=>	$this->auth->generator(15),
				'order_id'			=>	$order_id,
				'amount' 			=> 	$cgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$cgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date'),
			);
			if(!empty($cgst[$i])){

				$result= $this->db->select('*')
							->from('order_tax_col_details')
							->where('order_id',$order_id)
							->where('tax_id',$cgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('order_tax_col_details');
				}else{
					$this->db->insert('order_tax_col_details',$cgst_details);
				}
			}
		}

		//SGST tax info
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$sgst_summary = array(
				'order_tax_col_de_id'	=>	$this->auth->generator(15),
				'order_id'			=>	$order_id,
				'amount' 			=> 	$sgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$sgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date'),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('order_tax_col_details')
							->where('order_id',$order_id)
							->where('tax_id',$sgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('order_tax_col_details');
				}else{
					$this->db->insert('order_tax_col_details',$sgst_summary);
				}
			}
		}

		//IGST tax info
		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax 	 = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$igst_summary = array(
				'order_tax_col_de_id'=>	$this->auth->generator(15),
				'order_id'			=>	$order_id,
				'amount' 			=> 	$igst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$igst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date'),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('order_tax_col_details')
							->where('order_id',$order_id)
							->where('tax_id',$igst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$igst_tax, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('order_tax_col_details');
				}else{
					$this->db->insert('order_tax_col_details',$igst_summary);
				}
			}
		}
		//Tax collection details for three
		return $order_id;
	}
	//Get Supplier rate of a product
	public function supplier_rate($product_id)
	{
		$this->db->select('supplier_price');
		$this->db->from('product_information');
		$this->db->where(array('product_id' => $product_id)); 
		$query = $this->db->get();
		return $query->result_array();
	
	}

	//Retrieve order_html_data
	public function retrieve_order_html_data($order_id)
	{
		$this->db->select('
			a.*,
			b.*,
			c.*,
			d.product_id,
			d.product_name,
			d.product_details,
			d.product_model,d.unit,
			e.unit_short_name,
			f.variant_name,
			a.details
			');
		$this->db->from('order a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('order_details c','c.order_id = a.order_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('unit e','e.unit_id = d.unit','left');
		$this->db->join('variant f','f.variant_id = c.variant_id','left');
		$this->db->where('a.order_id',$order_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
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

		//Get total product
	public function get_total_product($product_id){

		$this->db->select('
			product_name,
			product_id,
			supplier_price,
			price,
			supplier_id,
			unit,
			variants,
			product_model,
			onsale,
			onsale_price,
			unit.unit_short_name
			');
		$this->db->from('product_information');
		$this->db->join('unit','unit.unit_id = product_information.unit','left');
		$this->db->where(array('product_id' => $product_id,'status' => 1)); 
		$product_information = $this->db->get()->row();

		$html = "";
		if (!empty($product_information->variants)) {
			$exploded = explode(',',$product_information->variants);
			$html .="<option>".display('select_variant')."</option>";
	        foreach ($exploded as $elem) {
		        $this->db->select('*');
		        $this->db->from('variant');
		        $this->db->where('variant_id',$elem);
		        $this->db->order_by('variant_name','asc');
		        $result = $this->db->get()->row();

		        $html .="<option value=".$result->variant_id.">".$result->variant_name."</option>";
	    	}
	    }

		$this->db->select('tax.*,tax_product_service.product_id,tax_percentage');
		$this->db->from('tax_product_service');
		$this->db->join('tax','tax_product_service.tax_id = tax.tax_id','left');
		$this->db->where('tax_product_service.product_id',$product_id);
		$tax_information = $this->db->get()->result();

		//New tax calculation for discount
		if(!empty($tax_information)){
			foreach($tax_information as $k=>$v){
			   if ($v->tax_id == 'H5MQN4NXJBSDX4L') {
			   		$tax['cgst_tax'] 	= ($v->tax_percentage)/100;
			   		$tax['cgst_name']	= $v->tax_name; 
			   		$tax['cgst_id']	 	= $v->tax_id; 
			   }elseif($v->tax_id == '52C2SKCKGQY6Q9J'){
			   		$tax['sgst_tax'] 	= ($v->tax_percentage)/100;
			   		$tax['sgst_name']	= $v->tax_name; 
			   		$tax['sgst_id']	 	= $v->tax_id; 
			   }elseif($v->tax_id == '5SN9PRWPN131T4V'){
			   		$tax['igst_tax'] 	= ($v->tax_percentage)/100;
			   		$tax['igst_name']	= $v->tax_name; 
			   		$tax['igst_id']		= $v->tax_id; 
			   }
			}
		}

		$purchase = $this->db->select("SUM(quantity) as totalPurchaseQnty")
							->from('product_purchase_details')
							->where('product_id',$product_id)
							->get()
							->row();

		$sales = $this->db->select("SUM(quantity) as totalSalesQnty")
						->from('invoice_details')
						->where('product_id',$product_id)
						->get()
						->row();
		$stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;

		$discount = "";
		if ($product_information->onsale == 1) {
			$discount = ($product_information->price - $product_information->onsale_price);
		}

		$data2 = array(
			'total_product'	=> $stock, 
			'supplier_price'=> $product_information->supplier_price, 
			'price' 		=> $product_information->price, 
			'variant_id' 	=> $product_information->variants, 
			'supplier_id' 	=> $product_information->supplier_id, 
			'product_name' 	=> $product_information->product_name, 
			'product_model' => $product_information->product_model, 
			'product_id' 	=> $product_information->product_id, 
			'variant' 		=> $html, 
			'discount' 		=> $discount, 
			'sgst_tax' 		=> (!empty($tax['sgst_tax'])?$tax['sgst_tax']:null), 
			'cgst_tax' 		=> (!empty($tax['cgst_tax'])?$tax['cgst_tax']:null), 
			'igst_tax' 		=> (!empty($tax['igst_tax'])?$tax['igst_tax']:null), 
			'cgst_id' 		=> (!empty($tax['cgst_id'])?$tax['cgst_id']:null), 
			'sgst_id' 		=> (!empty($tax['sgst_id'])?$tax['sgst_id']:null), 
			'igst_id' 		=> (!empty($tax['igst_id'])?$tax['igst_id']:null), 
			'unit' 			=> $product_information->unit_short_name, 
			);

		return $data2;
	}
	//NUMBER GENERATOR
	public function number_generator()
	{
		$this->db->select_max('invoice', 'invoice_no');
		$query = $this->db->get('invoice');	
		$result = $query->result_array();	
		$order_no = $result[0]['invoice_no'];
		if ($order_no !='') {
			$order_no = $order_no + 1;	
		}else{
			$order_no = 1000;
		}
		return $order_no;		
	}

	//NUMBER GENERATOR FOR ORDER
	public function number_generator_order()
	{
		$this->db->select_max('order', 'order_no');
		$query = $this->db->get('order');	
		$result = $query->result_array();	
		$order_no = $result[0]['order_no'];
		if ($order_no !='') {
			$order_no = $order_no + 1;	
		}else{
			$order_no = 1000;
		}
		return $order_no;		
	}

    //Retrieve order Edit Data
    public function retrieve_order_editdata($order_id)
    {
        $this->db->select('
                a.*,
                b.customer_name,
                c.*,
                c.product_id,
                d.product_name,
                d.product_model,
                a.status
            ');



        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id');
        $this->db->join('order_details c','c.order_id = a.order_id');
        $this->db->join('product_information d','d.product_id = c.product_id');
        $this->db->where('a.order_id',$order_id);
        $query = $this->db->get();




        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
} 

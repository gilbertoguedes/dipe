<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('lcustomer');
		$this->load->library('session');
		$this->load->model('Customers');
	}
	//Count order
	public function count_order()
	{
		return $this->db->count_all("order");
	}
	//order List
	public function order_list()
	{
		$this->db->select('a.*,b.customer_name,o.state');
		$this->db->from('order a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
        $this->db->join('order_state o','o.id = a.order_state_id');
		$this->db->order_by('a.order','desc');
		/*$this->db->limit('500');*/
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

    public function order_state()
    {
        $this->db->select('a.*');
        $this->db->from('order_state a');
        $this->db->order_by('a.id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function update_order_state($order_id,$data)
    {
        $this->db->where('order_id', $order_id);
        $this->db->update('order',$data);
        return true;
    }

    public function order_by_id($idOrder)
    {
        $this->db->select('a.*,b.tax_amount,s.store_address,s.zip,s.store_name');
        $this->db->from('order a');
        $this->db->join('order_tax_col_summary b','b.order_id = a.order_id','left');
		$this->db->join('store_set s','s.store_id = a.store_id','left');
        $this->db->where('a.order_id',$idOrder);
        $order = $this->db->get()->row();



        if ($order!=null) {
            //$this->db->select('a.*,b.product_name,b.price,b.product_id,b.unit,c.amount');
            $this->db->select('a.*,b.product_name,b.price,b.product_id,b.clave_interna,b.unit,b.category_clave,u.unit_name');
            $this->db->from('order_details a');
            //$this->db->join('order_tax_col_details c','a.product_id = c.product_id','left');
            $this->db->join('product_information b','b.product_id = a.product_id','left');
			$this->db->join('unit u','u.unit_id = b.unit','left');

            $this->db->where('a.order_id',$idOrder);
            //$this->db->group_by('c.product_id');
            $orderDetails = $this->db->get()->result_array();

            for($i=0;$i<count($orderDetails);$i++)
            {
                $this->db->select('a.amount');
                $this->db->from('order_tax_col_details a');

                $this->db->where('a.order_id',$orderDetails[$i]['order_id']);
                $this->db->where('a.product_id',$orderDetails[$i]['product_id']);

                $tax = $this->db->get()->result_array();

                if($tax)
                {
                    $orderDetails[$i]['amount'] = $tax[0]['amount'];
                }
                else
                {
                    $orderDetails[$i]['amount'] = null;
                }
            }

            $datos = array();
            $datos['order'] = $order;
            $datos['order_details'] = $orderDetails;

            return $datos;
        }
        return false;
    }

	//Stock Report by date
	public function stock_report_bydate($product_id)
	{
		$this->db->select("
				SUM(d.quantity) as 'totalSalesQnty',
				SUM(b.quantity) as 'totalPurchaseQnty',
				(sum(b.quantity) - sum(d.quantity)) as stock
			");

		$this->db->from('product_information a');
		$this->db->join('product_purchase_details b','b.product_id = a.product_id','left');
		$this->db->join('order_details d','d.product_id = a.product_id','left');
		$this->db->join('product_purchase e','e.purchase_id = b.purchase_id','left');
		$this->db->group_by('a.product_id');
		$this->db->order_by('a.product_name','asc');

		if(empty($product_id))
		{
			$this->db->where(array('a.status'=>1));
		}else{
			//Single product information 
			$this->db->where('a.product_id',$product_id);	
		}
		$query = $this->db->get();
		return $query->row();
	}

	//order Search Item
	public function search_inovoice_item($customer_id)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('order a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('b.customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//POS order entry
	public function pos_order_setup($product_id){
		$product_information = $this->db->select('*')
						->from('product_information')
						->where('product_id',$product_id)
						->get()
						->row();

		if ($product_information != null) {

			$this->db->select('SUM(a.quantity) as total_purchase');
			$this->db->from('product_purchase_details a');
			$this->db->where('a.product_id',$product_id);
			$total_purchase = $this->db->get()->row();

			$this->db->select('SUM(b.quantity) as total_sale');
			$this->db->from('order_details b');
			$this->db->where('b.product_id',$product_id);
			$total_sale = $this->db->get()->row();

			

			$data2 = (object)array(
				'total_product' => ($total_purchase->total_purchase - $total_sale->total_sale), 
				'supplier_price' => $product_information->supplier_price, 
				'price' 		 => $product_information->price, 
				'supplier_id' 	 => $product_information->supplier_id, 
				'tax'			 => $product_information->tax, 
				'product_id'	 => $product_information->product_id, 
				'product_name'	 => $product_information->product_name, 
				'product_model'	 => $product_information->product_model, 
				'unit'			 => $product_information->unit, 
				);

			return $data2;
		}else{
			return false;
		}
	}
	//POS customer setup
	public function pos_customer_setup(){
		$query= $this->db->select('*')
						->from('customer_information')
						->where('customer_name','Walking Customer')
						->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}else{
			return false;
		}
	}
	//POS customer list
	public function customer_list(){
		$query= $this->db->select('*')
						->from('customer_information')
						->where('customer_name !=','Walking Customer')
						->order_by('customer_name','asc')
						->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}else{
			return false;
		}
	}
	//Customer entry
	public function customer_entry($data){

		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_name',$data['customer_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('customer_information',$data);
		
			$this->db->select('*');
			$this->db->from('customer_information');
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_customer[] = array('label'=>$row->customer_name,'value'=>$row->customer_id);
			}
			$cache_file ='./my-assets/js/admin_js/json/customer.json';
			$customerList = json_encode($json_customer);
			file_put_contents($cache_file,$customerList);
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			return TRUE;
		}
	}

	//order entry
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
			'customer_id'		=>	$customer_id,
			'date'				=>	$this->input->post('invoice_date'),
			'total_amount'		=>	$this->input->post('grand_total_price'),
			'order'				=>	$this->number_generator_order(),
			'total_discount' 	=> 	$this->input->post('total_discount'),
			'order_discount' 	=> 	$this->input->post('invoice_discount') + $this->input->post('total_discount'),
			'service_charge' 	=> 	$this->input->post('service_charge'),
			'user_id'			=>	$this->session->userdata('user_id'),
			'store_id'			=>	$this->input->post('store_id'),
			'details'			=>	$this->input->post('details'),
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

    public function update_timbre($order_id,$data)
    {
        $this->db->where('order_id',$order_id);
        $this->db->update('order',$data);

        return true;
    }

	//update_order
	public function update_order()
	{
		//Order information
		$order_id  	 = $this->input->post('order_id');
		$customer_id = $this->input->post('customer_id');
		
		if($order_id!='')
		{
			//Data update into order table
			$data=array(
				'order_id'			=>	$order_id,
				'customer_id'		=>	$customer_id,
				'date'				=>	$this->input->post('invoice_date'),
				'total_amount'		=>	$this->input->post('grand_total_price'),
				'order'				=>	$this->input->post('order'),
				'total_discount' 	=> 	$this->input->post('total_discount'),
				'order_discount' 	=> 	$this->input->post('invoice_discount') + $this->input->post('total_discount'),
				'service_charge' 	=> 	$this->input->post('service_charge'),
				'user_id'			=>	$this->session->userdata('user_id'),
				'store_id'			=>	$this->input->post('store_id'),
				'paid_amount'		=>	$this->input->post('paid_amount'),
				'due_amount'		=>	$this->input->post('due_amount'),
				'status'			=>	$this->input->post('status'),
			);

			$this->db->where('order_id',$order_id);
			$result = $this->db->delete('order');

			if ($result) {
				$this->db->insert('order',$data);
			}
		}

		//Order details info
		$rate 		= $this->input->post('product_rate');
		$p_id 		= $this->input->post('product_id');
		$total_amount = $this->input->post('total_price');
		$discount 	= $this->input->post('discount');
		$variants 	= $this->input->post('variant_id');
		$order_d_id = $this->input->post('order_details_id');
		$quantity 	= $this->input->post('product_quantity');

		//Delete old invoice info
		if (!empty($order_id)) {
			$this->db->where('order_id',$order_id);
			$this->db->delete('order_details'); 
		}

		//Order details for entry
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$discount_rate 	  = $discount[$i];
			$total_price 	  = $total_amount[$i];
			$variant_id 	  = $variants[$i];
			$supplier_rate    = $this->supplier_rate($product_id);
			
			$order_details = array(
				'order_details_id'	=>	$this->auth->generator(15),
				'order_id'		=>	$order_id,
				'product_id'	=>	$product_id,
				'variant_id'	=>	$variant_id,
				'quantity'		=>	$product_quantity,
				'rate'			=>	$product_rate,
				'store_id'		=>	$this->input->post('store_id'),
				'supplier_rate' =>	$supplier_rate[0]['supplier_price'],
				'total_price'   =>	$total_price,
				'discount'      =>	$discount_rate,
				'status'		=>	1
			);

			if(!empty($p_id))
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

		//Delete all tax  from summary
		$this->db->where('order_id',$order_id);
		$this->db->delete('order_tax_col_summary');

		//CGST Tax Summary
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$cgst_summary = array(
				'order_tax_col_id'	=>	$this->auth->generator(15),
				'order_id'			=>	$order_id,
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

		//SGST Tax Summary
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			
			$sgst_summary = array(
				'order_tax_col_id'	=>	$this->auth->generator(15),
				'order_id'			=>	$order_id,
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

		//IGST Tax Summary
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

		//Delete all tax  from summary
		$this->db->where('order_id',$order_id);
		$this->db->delete('order_tax_col_details');

		//CGST Tax Details
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

		//SGST Tax Details
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$sgst_summary = array(
				'order_tax_col_de_id'	=>	$this->auth->generator(15),
				'order_id'		=>	$order_id,
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

		//IGST Tax Details
		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax 	 = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$igst_summary = array(
				'order_tax_col_de_id'=>	$this->auth->generator(15),
				'order_id'		=>	$order_id,
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
		//End tax details
		return $order_id;
	}
	//order paid to invoice
	public function order_paid_data($order_id){

		$invoice_id = $this->auth->generator(15);
		$result=$this->db->select('*')
					->from('order')
					->where('order_id',$order_id)
					->get()
					->row();
		if ($result) {

			$data = array(
				'invoice_id' 	=> $invoice_id,
				'order_id' 		=> $result->order_id, 
				'customer_id' 	=> $result->customer_id, 
				'store_id' 		=> $result->store_id, 
				'user_id' 		=> $result->user_id, 
				'date' 			=> $result->date, 
				'total_amount' 	=> $result->total_amount, 
				'invoice'       => $this->number_generator(),
				'total_discount'=> $result->total_discount, 
				'invoice_discount' => $result->order_discount, 
				'service_charge' => $result->service_charge, 
				'paid_amount' 	=> $result->paid_amount, 
				'due_amount' 	=> $result->due_amount, 
				'status' 		=> $result->status, 
			);
			$this->db->insert('invoice',$data);


			//Update to customer ledger Table 
			$data2 = array(
				'transaction_id'	=>	$this->auth->generator(15),
				'customer_id'		=>	$result->customer_id,
				'invoice_no'		=>	$invoice_id,
				'order_no' 			=>  $result->order_id, 
				'date'				=>	$result->date,
				'amount'			=>	$result->total_amount,
				'status'			=>	1
			);
			$ledger = $this->db->insert('customer_ledger',$data2);
		}


		if ($ledger) {

			//order update
			$this->db->set('status','2');
			$this->db->where('order_id',$order_id);
			$order = $this->db->update('order');

			$order_details=$this->db->select('*')
							->from('order_details')
							->where('order_id',$order_id)
							->get()
							->result();

			if ($order_details) {
				foreach ($order_details as $details) {
					$invoice_details = array(
						'invoice_details_id' => $this->auth->generator(15), 
						'invoice_id' 		 => $invoice_id, 
						'product_id' 		 => $details ->product_id, 
						'variant_id'		 => $details ->variant_id, 
						'store_id'		 	 => $details ->store_id, 
						'quantity'			 => $details ->quantity, 
						'rate'				 => $details ->rate, 
						'supplier_rate'		 => $details ->supplier_rate, 
						'total_price'		 => $details ->total_price, 
						'discount'			 => $details ->discount, 
						'status'			 => $details ->status, 
					);

					$order_details = $this->db->insert('invoice_details',$invoice_details);
				}
			}
		}

		//Tax summary entry start
		$this->db->select('*');
		$this->db->from('order_tax_col_summary');
		$this->db->where('order_id',$order_id);
		$query = $this->db->get();
		$tax_summary = $query->result();

		if ($tax_summary) {
			foreach ($tax_summary as $summary) {
				$tax_col_summary = array(
				 	'tax_collection_id' => $summary->order_tax_col_id,
				 	'invoice_id' 		=> $invoice_id,
				 	'tax_id' 			=> $summary->tax_id,
				 	'tax_amount' 		=> $summary->tax_amount,
				 	'date' 				=> $summary->date,
				);
				$this->db->insert('tax_collection_summary',$tax_col_summary);
			}
		}
		//Tax summary entry end

		//Tax details entry start
		$this->db->select('*');
		$this->db->from('order_tax_col_details');
		$this->db->where('order_id',$order_id);
		$query = $this->db->get();
		$tax_details = $query->result();

		if ($tax_details) {
			foreach ($tax_details as $details) {
				$tax_col_details = array(
				 	'tax_col_de_id' 	=> $details->order_tax_col_de_id,
				 	'invoice_id' 		=> $invoice_id,
				 	'product_id' 		=> $details->product_id,
				 	'variant_id' 		=> $details->variant_id,
				 	'tax_id' 			=> $details->tax_id,
				 	'amount' 			=> $details->amount,
				 	'date' 				=> $details->date,
				);
				$this->db->insert('tax_collection_details',$tax_col_details);
			}
		}
		//Tax details entry end
		return true;
	}
	//Store List
	public function store_list()
	{
		$this->db->select('*');
		$this->db->from('store_set');
		$this->db->order_by('store_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Terminal List
	public function terminal_list()
	{
		$this->db->select('*');
		$this->db->from('terminal_payment');
		$this->db->order_by('terminal_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
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
				d.clave_interna,
				e.unit_short_name,
				a.status,
				o.state
			');

		$this->db->from('order a');
        $this->db->join('order_state o','o.id = a.order_state_id');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('order_details c','c.order_id = a.order_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
        $this->db->join('unit e','e.unit_id = d.unit');
		$this->db->where('a.order_id',$order_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
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
			f.variant_name
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
	// Delete order Item
	public function retrieve_product_data($product_id)
	{
		$this->db->select('supplier_price,price,supplier_id,tax');
		$this->db->from('product_information');
		$this->db->where(array('product_id' => $product_id,'status' => 1)); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
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
	// Delete order Item
	public function delete_order($order_id)
	{	
		//Delete order table
		$this->db->where('order_id',$order_id);
		$this->db->delete('order'); 
		//Delete order_details table
		$this->db->where('order_id',$order_id);
		$this->db->delete('order_details'); 
		//Order tax summary delete
		$this->db->where('order_id',$order_id);
		$this->db->delete('order_tax_col_summary'); 
		//Order tax details delete
		$this->db->where('order_id',$order_id);
		$this->db->delete('order_tax_col_details'); 
		return true;
	}
	public function order_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('orders a');
		$this->db->join('order_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('order_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL PURCHASE PRODUCT
	public function get_total_purchase_item($product_id)
	{
		$this->db->select('SUM(quantity) as total_purchase');
		$this->db->from('product_purchase_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL SALES PRODUCT
	public function get_total_sales_item($product_id)
	{
		$this->db->select('SUM(quantity) as total_sale');
		$this->db->from('order_details');
		$this->db->where('product_id',$product_id);
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
	//NUMBER GENERATOR
	public function number_generator()
	{
		$this->db->select_max('invoice', 'invoice_no');
		$query 		= $this->db->get('invoice');	
		$result 	= $query->result_array();	
		$order_no 	= $result[0]['invoice_no'];
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
	//Product List
	public function product_list()
	{
		$query=$this->db->select('
					supplier_information.*,
					product_information.*,
					product_category.category_name
				')

				->from('product_information')
				->join('supplier_information', 'product_information.supplier_id = supplier_information.supplier_id','left')
				->join('product_category','product_category.category_id = product_information.category_id','left')
				->group_by('product_information.product_id')
				->order_by('product_information.product_name','asc')
				->get();

		if ($query->num_rows() > 0) {
		 	return $query->result();	
		}
		return false;
	}
	//Category List
	public function category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}else{
			return false;
		}
	}

	//Product Search
	public function product_search($product_name,$category_id)
	{

		$this->db->select('*');
		$this->db->from('product_information');
		if (!empty($product_name)) {
			$this->db->like('product_name', $product_name, 'both');
		}
		
		if (!empty($category_id)) {
			$this->db->where('category_id',$category_id);
		}

		$this->db->where('status',1);
		$this->db->order_by('product_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}else{
			return false;
		}
	}
} 

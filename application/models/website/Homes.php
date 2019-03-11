<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homes extends CI_Model {

	private $table  = "language";
    private $phrase = "phrase";

	public function __construct()
	{
		parent::__construct();
	}
	//Parent Category List
	public function parent_category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('cat_type',1);
		$this->db->where('status',1);
		$this->db->order_by('menu_pos');
		/*$this->db->limit('9');*/
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}

    //Department List
    public function popular_category_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('status',1);
        $this->db->where('nivel',3);
        $this->db->where('popular',2);
        $this->db->order_by('category_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

	//Category list
	public function category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
        $this->db->where('nivel',3);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

    //Category list
    public function category_sub_family_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('nivel',3);
        $this->db->order_by('category_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

	//Best sales list
	public function best_sales()
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('best_sale','1');
		$this->db->order_by('id','desc');
		$this->db->limit('6');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Footer block
	public function footer_block()
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->order_by('position');
		$this->db->limit('2');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		
	//Add Wishlist
	public function add_wishlist($data)
	{

		$user_id 	= $data['user_id'];
		$product_id = $data['product_id'];

		$this->db->select('*');
		$this->db->from('wishlist');
		$this->db->where('user_id',$data['user_id']);
		$this->db->where('product_id',$data['product_id']);
		$this->db->where('status',1);
		$query = $this->db->get();
		$r = $query->num_rows();

		if ($r > 0) {
			return false;
		}else{
			$result = $this->db->insert('wishlist',$data);
			return true;
		}
	}	

	//Add Review
	public function add_review($data)
	{
		$reviewer_id = $data['reviewer_id'];
		$product_id  = $data['product_id'];

		$this->db->select('*');
		$this->db->from('product_review');
		$this->db->where('reviewer_id',$data['reviewer_id']);
		$this->db->where('product_id',$data['product_id']);
		$this->db->where('status',1);
		$query = $this->db->get();
		$r = $query->num_rows();

		if ($r > 0) {
			return false;
		}else{
			$this->db->insert('product_review',$data);
			return true;
		}
	}

	//Currency info
	public function currency_info()
	{
		$this->db->select('*');
		$this->db->from('currency_info');
		$this->db->order_by('currency_name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Selected currency info
	public function selected_currency_info()
	{
		$cur_id = $this->session->userdata('currency_id');
		if (!empty($cur_id)) {
			$this->db->select('*');
			$this->db->from('currency_info');
			$this->db->where('currency_id',$cur_id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->row();	
			}else{
				return false;
			}
		}else{
			$this->db->select('*');
			$this->db->from('currency_info');
			$this->db->where('default_status','1');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->row();	
			}else{
				return false;
			}
		}
		return false;
	}	

	//Selecte country info
	public function selected_country_info()
	{
		$this->db->select('*');
		$this->db->from('countries');
		$this->db->order_by('id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Selecte district info
	public function select_district_info($country_id)
	{
		$this->db->select('*');
		$this->db->from('states');
		$this->db->where('country_id',$country_id);
		$this->db->order_by('id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Selecte shipping method
	public function select_shipping_method()
	{
		$this->db->select('*');
		$this->db->from('shipping_method');
		$this->db->order_by('position');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Ship And Bill Entry
	public function ship_and_bill_entry($data)
	{
		$bill = $this->db->insert('customer_information',$data);
		if ($bill) {
			$result = $this->db->insert('shipping_info',$data);
			return true;	
		}
		return false;
	}	

	//Billing Entry
	public function billing_entry($data)
	{
		$bill = $this->db->insert('customer_information',$data);
		if ($bill) {
			return true;	
		}
		return false;
	}	

	//Shipping Entry
	public function shipping_entry($data)
	{
		$result = $this->db->insert('shipping_info',$data);
		if ($result) {
			return true;	
		}
		return false;
	}		

	//Select state by country
	public function select_state_country()
	{

		$country_id = $this->session->userdata('country');

		$this->db->select('*');
		$this->db->from('states');
		$this->db->where('country_id',$country_id);
		$this->db->order_by('name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;

		$result = $this->db->insert('shipping_info',$data);
		if ($result) {
			return true;	
		}
		return false;
	}		

	//Select ship state by country
	public function select_ship_state_country()
	{

		$ship_country = $this->session->userdata('ship_country');

		$this->db->select('*');
		$this->db->from('states');
		$this->db->where('country_id',$ship_country);
		$this->db->order_by('name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;

		$result = $this->db->insert('shipping_info',$data);
		if ($result) {
			return true;	
		}
		return false;
	}	

	//Customer existing check
	public function check_customer($email){
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_email',$email);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}	

	//Select home adds
	public function select_home_adds(){
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('add_page','home');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	

	//Product Details
	public function product_details($product_id){
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}

	//Order entry
	public function order_entry($customer_id,$order_id,$store_id){

        //Retrive default store
		$default_store = $this->db->select('store_id')
									->from('store_set')
									->where('default_status','1')
									->get()
									->row();

		$payment_method = $this->session->userdata('payment_method');

        if ($payment_method == 1) {
			//Data inserting into order table
			$data=array(
				'order_id'			=>	$order_id,
				'customer_id'		=>	$customer_id,
				'store_id'			=>	$store_id/*(!empty($default_store->store_id)?$default_store->store_id:null)*/,
				'date'				=>	date("m-d-Y"),
				'total_amount'		=>	$this->session->userdata('cart_total'),
				'order'				=>	$this->number_generator_order(),
				'total_discount' 	=> 	$this->session->userdata('total_discount'),
				'order_discount' 	=> 	$this->session->userdata('total_discount'),
				'due_amount' 		=> 	$this->session->userdata('cart_total'),
				'service_charge' 	=> 	$this->session->userdata('cart_ship_cost'),
				'status'			=>	1
			);
			$this->db->insert('order',$data);
		}else{
			//Data inserting into order table for payment gateway
			$data=array(
				'order_id'			=>	$order_id,
				'customer_id'		=>	$customer_id,
				'store_id'			=>	$store_id/*(!empty($default_store->store_id)?$default_store->store_id:null)*/,
				'date'				=>	date("m-d-Y h:i:s A"),
				'total_amount'		=>	$this->session->userdata('cart_total'),
				'order'				=>	$this->number_generator_order(),
				'total_discount' 	=> 	$this->session->userdata('total_discount'),
				'order_discount' 	=> 	$this->session->userdata('total_discount'),
				'due_amount' 		=> 	$this->session->userdata('cart_total'),
				'service_charge' 	=> 	$this->session->userdata('cart_ship_cost'),
				'status'			=>	1,
                'customer_env_name' 	=> 	$this->session->userdata('customer_name'),
                'customer_env_phone_number' 	=> 	$this->session->userdata('customer_phone_number'),
                'customer_env_street' 	=> 	$this->session->userdata('customer_street'),
                'customer_env_exter_number' 	=> 	$this->session->userdata('customer_exter_number'),
                'customer_env_inter_number' 	=> 	$this->session->userdata('customer_inter_number'),
                'customer_env_between1' 	=> 	$this->session->userdata('customer_between1'),
                'customer_env_between2' 	=> 	$this->session->userdata('customer_between2'),
                'customer_env_colony' 	=> 	$this->session->userdata('customer_colony'),
                'customer_env_delegation' 	=> 	$this->session->userdata('customer_delegation'),
                'customer_env_state' 	=> 	$this->session->userdata('customer_state'),
                'customer_env_zip' 	=> 	$this->session->userdata('customer_zip'),
                'customer_env_refer' 	=> 	$this->session->userdata('customer_refer'),
                'metodo_pago' 	=> 	$this->session->userdata('payment_method'),
                'variante_entrega' 	=> 	$this->session->userdata('customer_variant'),

			);
			$this->db->insert('order',$data);

        }

		//Delivery method entry
		/*$data = array(
			'order_delivery_id' => $this->auth->generator(15), 
			'delivery_id' 		=> $this->session->userdata('method_id'), 
			'order_id' 			=> $order_id, 
			'details'			=> $this->session->userdata('delivery_details'), 
		);



        $this->db->insert('order_delivery',$data);*/

        //Delivery order payment entry
		/*$data = array(
			'order_payment_id' => $this->auth->generator(15), 
			'payment_id' 	=> $this->session->userdata('payment_method'), 
			'order_id' 		=> $order_id, 
			'details'		=> $this->session->userdata('payment_details'), 
		);
		$this->db->insert('order_payment',$data);*/

        //Insert order to order details
		if ($this->cart->contents()) {
			foreach ($this->cart->contents() as $items){
				$order_details = array(
					'order_details_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'product_id'		=>	$items['product_id'],
					/*'variant_id'		=>	$items['variant'],*/
					'store_id'			=>	$store_id/*(!empty($default_store->store_id)?$default_store->store_id:null)*/,
					'quantity'			=>	$items['qty'],
					'rate'				=>	$items['actual_price'],
					'supplier_rate'     =>	$items['supplier_price'],
					'total_price'       =>	$items['actual_price'] * $items['qty'],
					'discount'          =>	$items['discount'],
					'status'			=>	1
				);

				if(!empty($items))
				{
					$this->db->insert('order_details',$order_details);
				}

				//CGST Tax summary
				$cgst_summary = array(
					'order_tax_col_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'tax_amount' 		=> 	$items['options']['cgst'] * $items['qty'], 
					'tax_id' 			=> 	$items['options']['cgst_id'],
					'date'				=>	date("m-d-Y"),
				);

				if(!empty($items['options']['cgst_id'])){
					$result= $this->db->select('*')
								->from('order_tax_col_summary')
								->where('order_id',$order_id)
								->where('tax_id',$items['options']['cgst_id'])
								->get()
								->num_rows();

					if ($result > 0) {
						$this->db->set('tax_amount', 'tax_amount+'.$items['options']['cgst'] * $items['qty'], FALSE);
						$this->db->where('order_id', $order_id);
						$this->db->where('tax_id',$items['options']['cgst_id']);
						$this->db->update('order_tax_col_summary');
					}else{
						$this->db->insert('order_tax_col_summary',$cgst_summary);
					}
				}
				//CGST Summary End

				//IGST Tax summary
				$igst_summary = array(
					'order_tax_col_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'tax_amount' 		=> 	$items['options']['igst'] * $items['qty'], 
					'tax_id' 			=> 	$items['options']['igst_id'],
					'date'				=>	date("m-d-Y"),
				);

				if(!empty($items['options']['igst_id'])){
					$result= $this->db->select('*')
								->from('order_tax_col_summary')
								->where('order_id',$order_id)
								->where('tax_id',$items['options']['igst_id'])
								->get()
								->num_rows();
				
					if ($result > 0) {
						$this->db->set('tax_amount', 'tax_amount+'.$items['options']['igst'] * $items['qty'], FALSE);
						$this->db->where('order_id', $order_id);
						$this->db->where('tax_id',$items['options']['igst_id']);
						$this->db->update('order_tax_col_summary');
					}else{
						$this->db->insert('order_tax_col_summary',$igst_summary);
					}
				}
				//IGST Tax summary end

				//SGST Tax summary
				$sgst_summary = array(
					'order_tax_col_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'tax_amount' 		=> 	$items['options']['sgst'] * $items['qty'], 
					'tax_id' 			=> 	$items['options']['sgst_id'],
					'date'				=>	date("m-d-Y"),
				);

				if(!empty($items['options']['sgst_id'])){
					$result= $this->db->select('*')
								->from('order_tax_col_summary')
								->where('order_id',$order_id)
								->where('tax_id',$items['options']['sgst_id'])
								->get()
								->num_rows();
				
					if ($result > 0) {
						$this->db->set('tax_amount', 'tax_amount+'.$items['options']['sgst'] * $items['qty'], FALSE);
						$this->db->where('order_id', $order_id);
						$this->db->where('tax_id',$items['options']['sgst_id']);
						$this->db->update('order_tax_col_summary');
					}else{
						$this->db->insert('order_tax_col_summary',$sgst_summary);
					}
				}
				//SGST Tax summary end

				//CGST Details
				$cgst_details = array(
					'order_tax_col_de_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'amount' 			=> 	$items['options']['cgst'] * $items['qty'], 
					'product_id' 		=> 	$items['product_id'], 
					'tax_id' 			=> 	$items['options']['cgst_id'],
					/*'variant_id'		=>	$items['variant'],*/
					'date'				=>	date("m-d-Y"),
				);

				if(!empty($items['options']['cgst_id'])){
					$this->db->insert('order_tax_col_details',$cgst_details);
				}
				//CGST Details End

				//IGST Details
				$igst_details = array(
					'order_tax_col_de_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'amount' 			=> 	$items['options']['igst'] * $items['qty'], 
					'product_id' 		=> 	$items['product_id'], 
					'tax_id' 			=> 	$items['options']['igst_id'],
					/*'variant_id'		=>	$items['variant'],*/
					'date'				=>	date("m-d-Y"),
				);
				if(!empty($items['options']['igst_id'])){
					$this->db->insert('order_tax_col_details',$igst_details);
				}
				//IGST Details End

				//SGST Details
				$sgst_details = array(
					'order_tax_col_de_id'	=>	$this->auth->generator(15),
					'order_id'			=>	$order_id,
					'amount' 			=> 	$items['options']['sgst'] * $items['qty'], 
					'product_id' 		=> 	$items['product_id'], 
					'tax_id' 			=> 	$items['options']['sgst_id'],
					/*'variant_id'		=>	$items['variant'],*/
					'date'				=>	date("m-d-Y"),
				);
				if(!empty($items['options']['sgst_id'])){
					$this->db->insert('order_tax_col_details',$sgst_details);
				}
				//SGST Details End
			}
		}

        return $order_id;
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
			a.details
			');
		$this->db->from('order a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('order_details c','c.order_id = a.order_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('unit e','e.unit_id = d.unit','left');
		/*$this->db->join('variant f','f.variant_id = c.variant_id','left');*/
		$this->db->where('a.order_id',$order_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
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

	//Retrive all language
	public function languages()
    { 
        if ($this->db->table_exists($this->table)) { 

            $fields = $this->db->field_data($this->table);

            $i = 1;
            foreach ($fields as $field)
            {  
                if ($i++ > 2)
                $result[$field->name] = ucfirst($field->name);
            }

            if (!empty($result)) return $result;
 
        } else {
            return false; 
        }
    }

    //Payment status
    public function payment_status($id = null){
    	return $payeer_result= $this->db->select('*')
	                            ->from('payment_gateway')
	                            ->where('id',$id)	
	                            ->get()
	                            ->row();

    }
}
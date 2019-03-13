<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('website/Lhome');
        $this->load->library('Lorder');
		$this->load->library('paypal_lib'); 
		$this->load->model('website/Homes');
        $this->load->model('website/Homes');
		$this->load->model('Subscribers');
		$this->qrgenerator();
		$this->load->model('Customer_dashboards');
        $this->load->model('website/Products_model');
        $this->load->model('website/Settings');
    }

	//Default loading for Home Index.
	public function index()
	{
		$content = $this->lhome->home_page();
		$this->template->full_website_html_view($content);
	}

	//Submit a subcriber.
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

	//Add to cart 
	public function add_to_cart(){

		$data = array(
	        'id'      => $this->input->post('product_id'),
	        'qty'     => $this->input->post('qnty'),
	        'price'   => $this->input->post('price'),
	        'supplier_price'   => $this->input->post('supplier_price'),
	        'name'    => $this->input->post('name'),
	        'discount'=> $this->input->post('discount'),
	        'options' => array(
	        	'image' => $this->input->post('image'), 
	        	'model' => $this->input->post('model'),
	        	'cgst' 	=> $this->input->post('cgst'),
	        	'sgst' 	=> $this->input->post('sgst'),
	        	'igst' 	=> $this->input->post('igst'),
	        	'cgst_id' 	=> $this->input->post('cgst_id'),
	        	'sgst_id' 	=> $this->input->post('sgst_id'),
	        	'igst_id' 	=> $this->input->post('igst_id'),
	        )
		);
		$result = $this->cart->insert($data);
		if ($result) {
			echo "1";
		}
	}	

	//Add to cart for details
	public function add_to_cart_details(){

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
			 	$price = $product_details->onsale_price /*- $cgst*/;
			 	$onsale_price = $product_details->onsale_price /*- $cgst*/;
			 	$discount = $product_details->price - $product_details->onsale_price;
			}else{
				$price = $product_details->price /*- $cgst*/;
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
	}

    public function add_to_cart_one_details(){

        $product_id = $this->input->post('product_id');
        $qnty 		= $this->input->post('qnty');
        $variant    = $this->input->post('variant');
        $store_id    = $this->input->post('store_id');

        $stock = $this->Products_model->store_stock_report_single_item_by_store($product_id,$store_id);

        if($qnty>$stock)
        {
            echo "2";
            return;
        }

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
                $price = $product_details->onsale_price /*- $cgst*/;
                $onsale_price = $product_details->onsale_price /*- $cgst*/;
                $discount = $product_details->price - $product_details->onsale_price;
            }else{
                $price = $product_details->price /*- $cgst*/;
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
    }

	//Delete item on your cart
	public function delete_cart(){
		$rowid = $this->input->post('row_id');
		$result = $this->cart->remove($rowid);
		if ($result) {
			echo "1";
		}
	}	


	//Delete item on your cart
	public function delete_cart_by_click($rowid){
		$result = $this->cart->remove($rowid);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_updated')));
			redirect('view_cart');
		}
	}	

	//Update your cart
	public function update_cart(){

		$inputs = $this->input->post();
		$this->cart->update($inputs);
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect('view_cart');
	}	

	//Set ship cost to cart
	public function set_ship_cost_cart(){

		$shipping_cost  = $this->input->post('shipping_cost');
		$ship_cost_name = $this->input->post('ship_cost_name');
		$method_id 		= $this->input->post('method_id');

        $this->session->set_userdata(
        						array(
							        	'cart_ship_cost' => $shipping_cost, 
							        	'cart_ship_name' => $ship_cost_name, 
							        	'method_id' 	 => $method_id, 
							        )
    							);
	}	

	//account_type_save
	public function account_type_save(){
		$account_type 	= $this->input->post('account_type');
		$this->session->set_userdata('account_info',$account_type);
	}

	//Account info save
	public function account_info_save($account_id){

        $payment_details  = $this->input->post('payment_details');
        $customer_variant  = $this->input->post('customer_variant');
        $payment_method  = $this->input->post('payment_method');
        $delivery_details  = $this->input->post('delivery_details');

        if($customer_variant=="2")
        {
            $customer_name  = $this->input->post('customer_name');
            $customer_phone_number  = $this->input->post('customer_phone_number');
            $customer_street  = $this->input->post('customer_street');
            $customer_exter_number  = $this->input->post('customer_exter_number');
            $customer_inter_number  = $this->input->post('customer_inter_number');
            $customer_between1  = $this->input->post('customer_between1');
            $customer_between2  = $this->input->post('customer_between2');
            $customer_colony  = $this->input->post('customer_colony');
            $customer_delegation  = $this->input->post('customer_delegation');
            $customer_state  = $this->input->post('customer_state');
            $customer_zip  = $this->input->post('customer_zip');
            $customer_refer  = $this->input->post('customer_refer');
        }
        else
        {
            $customer_name  = "";
            $customer_phone_number  = "";
            $customer_street  = "";
            $customer_exter_number  = "";
            $customer_inter_number  = "";
            $customer_between1  = "";
            $customer_between2  = "";
            $customer_colony  = "";
            $customer_delegation  = "";
            $customer_state  = "";
            $customer_zip  = "";
            $customer_refer  = "";
        }

        $this->session->set_userdata(
            array(
                'account_info' => $account_id,
                'customer_variant' => $customer_variant,
                'customer_name' => $customer_name,
                'customer_phone_number' => $customer_phone_number,
                'customer_street' => $customer_street,
                'customer_exter_number' => $customer_exter_number,
                'customer_inter_number' => $customer_inter_number,
                'customer_between1' => $customer_between1,
                'customer_between2' => $customer_between2,
                'customer_colony' => $customer_colony,
                'customer_delegation' => $customer_delegation,
                'customer_state' => $customer_state,
                'customer_zip' => $customer_zip,
                'customer_refer' => $customer_refer,
                'payment_method' => $payment_method,
                'delivery_details' => $delivery_details,
                'payment_details' => $payment_details,
            )
        );

        /*if ($ship_and_bill == 1) {

			$this->session->set_userdata(
				array(
				 	'account_info' => $account_id, 
				 	'first_name'   => $first_name, 
				 	'last_name'    => $last_name, 
				 	'customer_email'  => $customer_email, 
				 	'customer_mobile' => $customer_mobile, 
				 	'customer_address_1'  => $customer_address_1, 
				 	'customer_address_2'  => $customer_address_2, 
				 	'company'  	=> $company, 
				 	'city'  	=> $city, 
				 	'zip'  		=> $zip, 
				 	'country'  	=> $country, 
				 	'state'  	=> $state, 
				 	'password'  => $password,
				 	'ship_and_bill'  => $ship_and_bill, 
				 	'privacy_policy' => $privacy_policy, 

				 	'ship_first_name'=> $first_name,  
				 	'ship_last_name' => $last_name,  
				 	'ship_company' 	 => $company,  
				 	'ship_mobile' 	 => $customer_mobile,  
				 	'ship_address_1' => $customer_address_1,  
				 	'ship_address_2' => $customer_address_2,  
				 	'ship_city' 	 => $city,  
				 	'ship_zip' 		 => $zip,  
				 	'ship_country' 	 => $country,  
				 	'ship_state' 	 => $state,  
				 	'payment_method' => $payment_method,  
				 	'delivery_details' => $delivery_details, 
				 	'payment_details' => $payment_details, 
				)
			);
			
		}else{
			$this->session->set_userdata(
				array(
				 	'account_info' => $account_id, 
				 	'first_name'   => $first_name, 
				 	'last_name'    => $last_name, 
				 	'customer_email'  => $customer_email, 
				 	'customer_mobile' => $customer_mobile, 
				 	'customer_address_1'  => $customer_address_1, 
				 	'customer_address_2'  => $customer_address_2, 
				 	'company'  	=> $company, 
				 	'city'  	=> $city, 
				 	'zip'  		=> $zip, 
				 	'country'  	=> $country, 
				 	'state'  	=> $state, 
				 	'password'  => $password, 
				 	'ship_and_bill'  => $ship_and_bill, 
				 	'privacy_policy' => $privacy_policy, 
				 	'ship_first_name'=> '',  
				 	'ship_last_name' => '',  
				 	'ship_company' 	 => '',  
				 	'ship_mobile' 	 => '',  
				 	'ship_address_1' => '',  
				 	'ship_address_2' => '',  
				 	'ship_city' 	 => '',  
				 	'ship_zip' 		 => '',  
				 	'ship_country' 	 => '',  
				 	'ship_state' 	 => '',  
				 	'payment_method' => '',  
				 	'delivery_details' => $delivery_details, 
				 	'payment_details' => $payment_details, 
				)
			);
		}*/
	}

	//Apply Coupon
	public function apply_coupon(){

		$this->form_validation->set_rules('coupon_code', display('coupon_code'), 'required');
		if ($this->form_validation->run() == FALSE){
            $this->session->set_userdata(array('error_msg'=>  validation_errors()));
	        redirect('view_cart');
        }else{
        	$coupon_code = $this->input->post('coupon_code');
			$result = $this->db->select('*')
								->from('coupon')
								->where('coupon_discount_code',$coupon_code)
								->where('status',1)
								->get()
								->row();

			if ($result) {
				$diff = abs(strtotime($result->end_date) - strtotime($result->start_date));
				$years 	= floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days 	= floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				if ((!empty($days) || !empty($months) || !empty($years))) {

					if ($result->discount_type == 1) {

						$this->db->set('status', '2');
						$this->db->where('coupon_discount_code', $result->coupon_discount_code);
						$this->db->update('coupon');

						$this->session->unset_userdata('coupon_amnt');
				    	$this->session->set_userdata('coupon_amnt',$result->discount_amount); 
				    	$this->session->set_userdata('message','Your coupon is used'); 
						redirect('view_cart');
					}elseif ($result->discount_type == 2) {
						$this->db->set('status', '2');
						$this->db->where('coupon_discount_code', $result->coupon_discount_code);
						$this->db->update('coupon');

						$total_dis = ($this->cart->total() * $result->discount_percentage)/100;
						$this->session->unset_userdata('coupon_amnt');
				    	$this->session->set_userdata('coupon_amnt',$total_dis); 
				    	$this->session->set_userdata('message',display('your_coupon_is_used')); 
						redirect('view_cart');
					}

				}else{
					$this->session->set_userdata('error_msg', display('coupon_is_expired'));
					redirect('view_cart');
				}
			}else{
				$this->session->set_userdata('error_msg',display('your_coupon_is_used')); 
				redirect('view_cart');
			}
        }
	}

	//Add Wish list
	public function add_wishlist(){

		if (!$this->user_auth->is_logged()) {
			echo '3';
		}else{
			$data = array(
				'wishlist_id'=> $this->generator(15),
				'user_id'	 => $this->input->post('customer_id'), 
				'product_id' => $this->input->post('product_id'), 
				'status' 	 => '1', 
			);
			$add_wishlist 	= $this->Homes->add_wishlist($data);

			if ($add_wishlist) {
				echo '1';
			}else{
				echo '2';
			}	
		}
	}		

	//Add Review
	public function add_review(){

		if (!$this->user_auth->is_logged()) {
			echo '3';
		}else{
			$data = array(
				'product_review_id'	=> $this->generator(15),
				'reviewer_id'	 	=> $this->input->post('customer_id'), 
				'product_id' 		=> $this->input->post('product_id'), 
				'comments' 	 		=> $this->input->post('review_msg'), 
				'rate' 	 			=> $this->input->post('rate'), 
				'status' 	 		=> '0', 
			);
			$add_review 	= $this->Homes->add_review($data);
			if ($add_review) {
				echo '1';
			}else{
				echo '2';
			}	
		}
	}	

	//Change Language
	public function change_language(){
		$language = $this->input->post('language');
		if ($language) {
			$this->session->unset_userdata('language');
			$this->session->set_userdata('language',$language);
			echo '2';
		}else{
			echo '3';
		}
	}

    //Change Language
    public function change_store(){
        $store_id = $this->input->post('store_id');
        $this->session->set_userdata('store_id',$store_id);
        $this->cart->destroy();
        echo '2';
    }

	//Change Currency
	public function change_currency(){
		$currency_id = $this->input->post('currency_id');
		if ($currency_id) {
			$this->session->unset_userdata('currency_new_id');
			$this->session->set_userdata('currency_new_id',$currency_id);
			echo '2';
		}else{
			echo '3';
		}
	}	

	//View Cart
	public function view_cart(){
		$content = $this->lhome->view_cart();
		$this->template->full_website_html_view($content);
	}	

	//Retrive district
	public function retrive_district(){
		$country_id = $this->input->post('country_id');

		if ($country_id) {
			$select_district_info = $this->Homes->select_district_info($country_id);

			$html = "";
			if ($select_district_info) {
				$html .= "<select name=\"zone_id\" id=\"input-payment-zone\" class=\"form-control\" required=\"\">";
				foreach ($select_district_info as $district) {
					$html .= "<option value=".$district->name.">$district->name</option>";
				}
				$html .= "</select>";
				echo $html;
			}
		}
	}

	//Checkout
	public function checkout(){
		if ($this->user_auth->is_logged())
		{
			$content = $this->lhome->checkout();
			$this->template->full_website_html_view($content);
		}
		else
		{
			redirect('login');
		}
	}

    //Checkout
    public function checkout_invoice($idOrder){
        if ($this->user_auth->is_logged())
        {
            $texto = "";
            $texto .= '<div>APRECIABLE SR. Juana María</div>';

            $path_pdf = FCPATH.'assets/timbrados/YWQ6R1JDSHDZU7K.xml';

            $path_pdf = array();
            $path_pdf[0] = FCPATH.'assets/timbrados/YWQ6R1JDSHDZU7K.xml';
            $path_pdf[1] = FCPATH.'assets/timbrados/YWQ6R1JDSHDZU7K.pdf';

            $this->Settings->send_mail_file("ajborgeslag@gmail.com",'Confirmación de facturación', $texto, $path_pdf);

            $content = $this->lhome->checkout_invoice($idOrder);
            $this->template->full_website_html_view($content);
        }
        else
        {
            redirect('login');
        }
    }

    public function submit_checkout_invoice(){
		
		$this->load->library('facturacion/Facturacion');
		
		/*$this->facturacion->facturar();
		
		die();*/

        $idOrder = $this->input->post('idOrder');
        $order  = $this->lorder->order_by_id($idOrder);

        if($this->input->post('customer_variant')==1)
        {
            $nombreReceptor = $this->input->post('customer_name').' '.$this->input->post('customer_first_lastname').' '.$this->input->post('customer_secon_lastname');
        }
        else if($this->input->post('customer_variant')==2)
        {
            $nombreReceptor = $this->input->post('customer_social_reason');
        }

        $rfcReceptor = $this->input->post('customer_rfc');

        $rfcFacUso = $this->input->post('fac_uso');

        $receptor = array();
        $receptor['nombreReceptor'] = $nombreReceptor;
        $receptor['rfcReceptor'] = $rfcReceptor;
        $receptor['rfcFacUso'] = $rfcFacUso;

        $formaPago = $this->input->post('fac_fp');
        $metodoPago = $this->input->post('fac_mp');

        $comprobante = array();
        $comprobante['formaPago'] = $formaPago;
        $comprobante['metodoPago'] = $metodoPago;

        if ($this->user_auth->is_logged())
        {
            if($this->input->post('customer_save_data')=="1")
            {
                $data=array(
                    'customer_information_invoice_data_id' => $this->auth->generator(20),
                    'customer_id' => $this->session->userdata('customer_id'),
                    'customer_social_reason' 		=> $this->input->post('customer_social_reason'),
                    'customer_name' 		=> $this->input->post('customer_name'),
                    'customer_first_lastname' 		=> $this->input->post('customer_first_lastname'),
                    'customer_secon_lastname' 		=> $this->input->post('customer_secon_lastname'),
                    'customer_rfc' 		=> $this->input->post('customer_rfc'),
                    'customer_variant' 		=> $this->input->post('customer_variant')
                );

                $this->Customer_dashboards->insert_invoice_data($data);
            }

            if($this->facturacion->facturar($order,$receptor,$comprobante))
			{
                $CI =& get_instance();
                $CI->load->model('Orders');
                $data = array();
                $data['timbrado'] = 1;
                $CI->Orders->update_timbre($idOrder,$data);

                redirect('/customer/order/manage_order');
			}
			else
			{
				$this->session->set_userdata('error_message', "Error al realizar el timbrado electrónico, revice los datos de facturación");
            	redirect('/checkout_invoice/'.$idOrder);
			}
        }
        else
        {
            redirect('login');
        }
    }

	//Submit checkout
	public function submit_checkout(){
        //For page settings start
		$this->load->model('website/Homes');
		$this->load->model('Web_settings');
		$this->load->model('Soft_settings');
		$this->load->model('Blocks');

        $parent_category_list 	= $this->Homes->parent_category_list();
		$pro_category_list 		= $this->Homes->category_list();
		$best_sales 			= $this->Homes->best_sales();
		$footer_block 			= $this->Homes->footer_block();
		$slider_list 			= $this->Web_settings->slider_list();
		$block_list 			= $this->Blocks->block_list(); 
		$currency_details 		= $this->Soft_settings->retrieve_currency_info();
		$Soft_settings 			= $this->Soft_settings->retrieve_setting_editdata();
		$languages 				= $this->Homes->languages();
		$currency_info 			= $this->Homes->currency_info();
		$selected_currency_info = $this->Homes->selected_currency_info();
		$select_home_adds 		= $this->Homes->select_home_adds();

		//Settings code start
    	$data['category_list'] 	= $parent_category_list;
    	$data['pro_category_list'] 	= $pro_category_list;
    	$data['slider_list'] 	= $slider_list;
    	$data['block_list'] 	= $block_list;
    	$data['best_sales'] 	= $best_sales;
    	$data['footer_block'] 	= $footer_block;
    	$data['languages'] 		= $languages;
    	$data['currency_info'] 	= $currency_info;
    	$data['select_home_adds'] 	= $select_home_adds;
    	$data['selected_cur_id'] 	= (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:"");
    	$data['Soft_settings'] 	= $Soft_settings;
    	$data['currency'] 		= $currency_details[0]['currency_icon'];
    	$data['position'] 		= $currency_details[0]['currency_position'];
		//Setting code end

		//Payment method
		$order_id 		= $this->auth->generator(15);
		$payment_method = $this->session->userdata('payment_method');

        //Customer existing check
		$email 					 = $this->input->post('customer_email');
		$customer_existing_check = $this->Homes->check_customer($email);

        if ($customer_existing_check) {
            $customer_id = $customer_existing_check->customer_id;

            if($this->input->post('customer_save_data')=="1" && $this->input->post('customer_variant')=="2")
            {
                $data=array(
                    'customer_information_send_data_id' => $this->auth->generator(20),
                    'customer_id' => $customer_id,
                    'customer_name' 		=> $this->input->post('customer_name'),
                    'customer_phone_number' 		=> $this->input->post('customer_phone_number'),
                    'customer_street' 		=> $this->input->post('customer_street'),
                    'customer_inter_number' 		=> $this->input->post('customer_inter_number'),
                    'customer_exter_number' 		=> $this->input->post('customer_exter_number'),
                    'customer_colony' 		=> $this->input->post('customer_colony'),
                    'customer_delegation' 		=> $this->input->post('customer_delegation'),
                    'customer_state' 		=> $this->input->post('customer_state'),
                    'customer_between1' 		=> $this->input->post('customer_between1'),
                    'customer_between2' 		=> $this->input->post('customer_between2'),
                    'customer_refer' 		=> $this->input->post('customer_refer'),
                    'customer_zip' 		=> $this->input->post('customer_zip'),
                );

                $this->Customer_dashboards->insert_send_data($data);
            }
            //Shipping data entry
    		$ship_country_id = $this->session->userdata('ship_country');
    		$ship_country 	 = $this->db->select('*')
			        				->from('countries')
			        				->where('id',$ship_country_id)
			        				->get()
			        				->row();
    		//$ship_short_address = $this->session->userdata('ship_city').','.$this->session->userdata('ship_state').','.$ship_country->name.','.$this->session->userdata('ship_zip');
            $ship_short_address = $this->input->post('customer_street').', entre '.$this->input->post('customer_between1').' y '.$this->input->post('customer_between2').','.
                $this->input->post('customer_zip');

    		//New customer shipping entry
    		$shipping=array(
				'customer_id' 	=> $customer_id,
				'customer_name' => $this->input->post('customer_name'),
				'first_name' 	=> $this->input->post('customer_first_lastname'),
				'last_name' 	=> $this->input->post('customer_secon_lastname'),
				'customer_short_address'=> $ship_short_address,
				'state' 		=> $this->input->post('customer_state'),
				'zip' 			=> $this->input->post('customer_zip'),
				'customer_mobile'=> $this->input->post('customer_phone_number'),
				'customer_email' => $this->input->post('customer_email'),
			);

			//Shipping information entry
    		$this->Homes->shipping_entry($shipping);

        }

        //Cash on delivery
    	if ($payment_method == 1) {

    		//Order entry
            $return_order_id = $this->Homes->order_entry($customer_id,$order_id);
    		$result   		 = $this->order_inserted_data($return_order_id);
    		if ($result) {
    			$this->session->sess_destroy();
    			redirect('home');
    		}
    	}

		//Payment method for bitcoin
    	if ($payment_method == 3) {

			#========================================================#
			#========================================================#
			#============ Bit coin payment method  start ============#
			#========================================================#
			#========================================================#

        	// Generated order id
			$gateway 		= $this->db->select('*')->from('payment_gateway')->where('id',1)->where('status',1)->get()->row();

            $message    	= "";
            // require_once APPPATH.'libraries/cryptobox/cryptobox.class.php';
           	require_once APPPATH.'libraries/cryptobox/cryptobox.class.php';
            $userID         = $customer_id; // place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
                                            // you don't need to use userID for unregistered website visitors
                                            // if userID is empty, system will autogenerate userID and save in cookies
            $userFormat     = "COOKIE";     // save userID in cookies (or you can use IPADDRESS, SESSION)
            $orderID        = $order_id;    	// invoice number 22
            $amountUSD      = $this->session->userdata('cart_total');         // invoice amount - 2.21 USD
            $period         = "NOEXPIRY";   // one time payment, not expiry
            $def_language   = "en";         // default Payment Box Language
            $public_key     = @$gateway->public_key;;   // from gourl.io
            $private_key    = @$gateway->private_key;;  // from gourl.io

            /** PAYMENT BOX **/
            $options = array(
                "public_key"  => $public_key,        // your public key from gourl.io
                "private_key" => $private_key,       // your private key from gourl.io
                "webdev_key"  =>  "DEV1124G19CFB313A993D68G453342148",                 // optional, gourl affiliate key
                "orderID"     => $orderID,           // order id or product name
                "userID"      => $userID,            // unique identifier for every user
                "userFormat"  => $userFormat,        // save userID in COOKIE, IPADDRESS or SESSION
                "amount"      => 0,                  // product price in coins OR in USD below
                "amountUSD"   => $amountUSD,         // we use product price in USD
                "period"      => $period,            // payment valid period
                "language"    => $def_language       // text on EN - english, FR - french, etc
            );

            // Initialise Payment Class
            $box = new Cryptobox ($options);

            // Coin name
            $coinName = $box->coin_name();

            // Payment Received
            if ($box->is_paid()) 
            { 
                $text  = "User will see this message during ".$period." period after payment has been made!"; // Example
                $text .= "<br>".$box->amount_paid()." ".$box->coin_label()."  received<br>";

            }else {
                $text  = "The payment has not been made yet";
            }

            // Notification when user click on button 'Refresh'
            if (isset($_POST["cryptobox_refresh_"]))
            {
                $message = "<div class='gourl_msg'>";
                if (!$box->is_paid()) $message .= '<div style="margin:50px" class="well"><i class="fa fa-info-circle fa-3x fa-pull-left fa-border" aria-hidden="true"></i> '.str_replace(array("%coinName%", "%coinNames%", "%coinLabel%"), array($box->coin_name(), ($box->coin_label()=='DASH'?$box->coin_name():$box->coin_name().'s'), $box->coin_label()), json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE]["msg_not_received"])."</div>";
                elseif (!$box->is_processed())
                {
                    // User will see this message one time after payment has been made
                    $message .= '<div style="margin:70px" class="alert alert-success" role="alert"> '.str_replace(array("%coinName%", "%coinLabel%", "%amountPaid%"), array($box->coin_name(), $box->coin_label(), $box->amount_paid()), json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE][($box->cryptobox_type()=="paymentbox"?"msg_received":"msg_received2")])."</div>";
                    $box->set_status_processed();
                }
                $message .="</div>";
            }


            //Payment received confirm
            $payment = $box->get_json_values();
            if ($payment['status'] == 'payment_received') {
            	//Order entry
                $return_order_id = $this->Homes->order_entry($customer_id,$order_id);
    			$result   		 = $this->order_inserted_data($return_order_id);
    			$this->cart->destroy();
            }


            //Customizeable code
            $data = array(

            	//Settings code start
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'select_home_adds' => $select_home_adds,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'Soft_settings' => $Soft_settings,
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
				//Setting code end

				//Bitcoin code
				'u1'=> $box->cryptobox_json_url(),
                'u2'=> intval($box->is_paid()),
                'u3'=> base_url('bitcoin-plug/'),
                'u4'=> base_url("#"),

                'coin_name'	=>	$box->coin_name(),
                'message'	=>	$message,
                'text'		=>	$text,
                'title'		=> display('bitcoin_payment'),
			);

        	#========================================================#
			#========================================================#
			#============ Bit coin payment method end ===============#
			#========================================================#
			#========================================================#

			$content = $this->parser->parse('website/payment',$data,true);
        	$this->template->full_website_html_view($content);
        }

        //Payment method for payeer
        if ($payment_method == 4) {

	        $date = new DateTime();
			$comment = $customer_id.'/buy/'.$order_id.'/'.$date->format('Y-m-d H:i:s');

			/**************************
			* Payeer
			**************************/
			$gateway = $this->db->select('*')->from('payment_gateway')->where('id',2)->where('status',1)->get()->row();

			$data['m_shop'] 	= @$gateway->shop_id;
		    $data['m_orderid'] 	= $order_id;
		    $data['m_amount'] 	= number_format($this->session->userdata('cart_total'), 2, '.', '');
		    $data['m_curr'] 	= 'USD';
		    $data['m_desc'] 	= base64_encode($comment);
		    $data['m_key'] 		= @$gateway->secret_key;
		    $data['user_id']    = @$customer_id;
		    $data['title']    	= display('payeer_payment');

		    $arHash = array(
		        $data['m_shop'],
		        $data['m_orderid'],
		        $data['m_amount'],
		        $data['m_curr'],
		        $data['m_desc']
		    );

			$arHash[] = $data['m_key'];
		    $data['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));

		    $content = $this->parser->parse('website/payment',$data,true);
        	$this->template->full_website_html_view($content);
        }

        //Payment method for paypal
        if ($payment_method == 5) {
            $appSetting = $this->Web_settings->setting();

        	// ---------------------
            //Set variables for paypal form
            $returnURL = base_url('website/home/success/'.$order_id.'/'.$customer_id); //payment success url

            //echo $returnURL;die();

            $cancelURL = base_url("website/home/cancel/"); //payment cancel url
            $notifyURL = base_url('website/home/ipn/'); //ipn url

            //set session token
            $this->session->unset_userdata('_tran_token');
            $this->session->set_userdata(array('_tran_token'=>$order_id));

            $token = $this->session->userdata('_tran_token');

            // set form auto fill data
            $this->paypal_lib->add_field('return', $returnURL);
            $this->paypal_lib->add_field('cancel_return', $cancelURL);
            $this->paypal_lib->add_field('notify_url', $notifyURL);

            // item information
            $this->paypal_lib->add_field('item_number', $order_id);
            $this->paypal_lib->add_field('item_name', 'None');
            $this->paypal_lib->add_field('amount',$this->session->userdata('cart_total'));  
            $this->paypal_lib->add_field('quantity', '1');    
            $this->paypal_lib->add_field('discount_amount', '0');   

            // additional information 
            $this->paypal_lib->add_field('custom', 'test');
            $this->paypal_lib->image(base_url($appSetting[0]['logo']));
			
			// generates auto form
            $this->paypal_lib->paypal_auto_form();
        }
	}

	public function payeerSuccess() 
	{
		//Redirect value from get method
		$request  = $this->input->get();
		$order_id = $request['m_orderid'];
		// $order_id = explode('_', $orderID);

		//Order entry
		$customer_id 	 = $this->session->userdata('customer_id');
	    $return_order_id = $this->Homes->order_entry($customer_id,$order_id);
	   	$result   		 = $this->order_inserted_data($return_order_id);

	   	if ($result) {
	   		$this->cart->destroy();
			$this->session->set_userdata('message', display('product_successfully_order'));
			redirect("website/customer/home/");
	   	}

 //    [m_operation_id] => 474205085
 //    [m_operation_ps] => 2609
 //    [m_operation_date] => 25.01.2018 12:43:58
 //    [m_operation_pay_date] => 25.01.2018 12:44:11
 //    [m_shop] => 474181962
 //    [m_orderid] => invoice1516873427
 //    [m_amount] => 0.13
 //    [m_curr] => USD
 //    [m_desc] => VGVzdA==
 //    [m_status] => success
 //    [m_sign] => CF5AE9EEDE210CE7657275C101A86F2A1D9DB92E747A2984B79B998D525579CF
 //    [lang] => en

	}

	//Payeer fail
	public function payeerFail() 
	{
		$this->session->set_userdata('error_message', display('order_cancel'));
		redirect("website/customer/home/");
	}

	//Paypal success
	public function success()
    {
        $data['title'] = display('order');
        #--------------------------------------
        //get the transaction data
        // $paypalInfo = $this->input->get();

        //Get order id and customer id
        $order_id = $this->uri->segment('4');
        $customer_id = $this->uri->segment('5');
        $store_id = $this->session->userdata('store_id');

        //session token
        $token = $this->session->userdata('_tran_token');

        /*if ($token != $order_id)
        {
            redirect('website/home/cancel');
        }*/

        //pass the transaction data to view
    	$return_order_id = $this->Homes->order_entry($customer_id,$order_id,$store_id);
        $result   		 = $this->order_inserted_data($return_order_id);
		if ($result) {
			$this->cart->destroy();
			$this->session->set_userdata('message',display('product_successfully_order'));
			//redirect('/customer/order/manage_order');
            redirect('/checkout_invoice/'.$order_id);
        }
    }

    //Paypal cancel
    public function cancel($order_id = null)
    {  
       $this->session->set_userdata('error_message',display('transaction_faild'));
       redirect('/customer/order/manage_order');
    }

    /*
    * Add this ipn url to your paypal account
    * Profile and Settings > My selling tools > 
    * Instant Payment Notification (IPN) > update 
    * Notification URL: (eg:- http://domain.com/website/home/ipn/)
    * Receive IPN messages (Enabled) 
    */
    public function ipn()
    {
        //paypal return transaction details array
        $paypalInfo    = $this->input->post(); 

        $data['user_id']        = $paypalInfo['custom'];
        $data['product_id']     = $paypalInfo["item_number"];
        $data['txn_id']         = $paypalInfo["txn_id"];
        $data['payment_gross']  = $paypalInfo["mc_gross"];
        $data['currency_code']  = $paypalInfo["mc_currency"];
        $data['payer_email']    = $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
        
        //check whether the payment is verified
        if(preg_match("/VERIFIED/i",$result)){
            //insert the transaction data into the database
            $this->load->model('paypal_model');
            $this->paypal_model->insertTransaction($data);
        }
    }


	//Retrive right now inserted data to create html
	public function order_inserted_data($order_id)
	{	
		$CI =& get_instance();
		$CI->load->library('website/Lhome');
		return $content = $CI->lhome->order_html_data($order_id,$this->session->userdata('customer_between1'));
	}

	//QR-Code Generator
	public function qrgenerator(){
		$this->load->library('ciqrcode');
		$config['cacheable']    = true; //boolean, the default is true
		$config['cachedir']     = ''; //string, the default is application/cache/
		$config['errorlog']     = ''; //string, the default is application/logs/
		$config['quality']      = true; //boolean, the default is true
		$config['size']         = '1024'; //interger, the default is 1024
		$config['black']        = array(224,255,255); // array, default is array(255,255,255)
		$config['white']        = array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);
		//Create QR code image create

		$params['data']  = 'https://play.google.com/store/apps/details?id=com.dipepsa&site='.base_url().'&valid=Dipepsa';
		$params['level'] = 'H';
		$params['size']  = 10;
		$image_name 	 = 'dipepsa_qr.png';
		$params['savename'] = FCPATH.'my-assets/image/qr/'.$image_name;
		$this->ciqrcode->generate($params);
		return true;
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,34);
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_dashboard extends CI_Controller {
	
	function __construct() {
      	parent::__construct();
	  	$this->load->model('Soft_settings');
	  	$this->load->model('Customers');
	  	$this->load->model('Products');
	  	$this->load->model('Suppliers');
	  	$this->load->model('Invoices');
	  	$this->load->model('Purchases');
	  	$this->load->model('Reports');
	  	$this->load->model('Accounts');
	  	$this->load->model('Users');
	  	$this->load->library('lreport');
	  	$this->load->library('occational');
	  	$this->load->library('luser');
    }
    //Default index page loading
    public function index(){

		if (!$this->auth->is_logged() )
		{
			$this->output->set_header("Location: ".base_url().'admin', TRUE, 302);
		}
		$this->auth->check_admin_store_auth();
	   
	    $total_customer 	= $this->Customers->count_customer();
	    $total_product 		= $this->Products->count_product();
	    $total_suppliers 	= $this->Suppliers->count_supplier();
	    $total_sales 		= $this->Invoices->count_invoice();
	    $total_store_invoice= $this->Invoices->total_store_invoice();
	    $total_purchase 	= $this->Purchases->count_purchase();

	    $this->Accounts->accounts_summary(1);
      	$total_expese 		= $this->Accounts->sub_total;
      	$monthly_sales_report = $this->Reports->monthly_sales_report();
	    $sales_report 		= $this->Reports->todays_total_sales_report();
	    $purchase_report 	= $this->Reports->todays_total_purchase_report();
	    $discount_report 	= $this->Reports->todays_total_discount_report();
		
		$currency_details 	= $this->Soft_settings->retrieve_currency_info();

	    $data = array(
	    	'title' 			=> display('dashboard'),
	    	'total_customer' 	=> $total_customer,
	    	'total_product' 	=> $total_product,
	    	'total_suppliers' 	=> $total_suppliers,
	    	'total_sales' 		=> $total_sales,
	    	'total_purchase' 	=> $total_purchase,
	    	'total_store_invoice' 	=> $total_store_invoice,
	    	'sales_amount' 		=> number_format($sales_report[0]['total_sale'], 2, '.', ','),
	    	'purchase_amount' 	=> number_format($purchase_report[0]['total_purchase'], 2, '.', ','),
	    	'discount_amount' 	=> number_format($discount_report[0]['total_discount'], 2, '.', ','),
	    	'total_expese' 		=> $total_expese,
	    	
	    	'monthly_sales_report' => $monthly_sales_report,
	    	'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],
	    	);

		$content = $this->parser->parse('include/admin_home',$data,true);
		$this->template->full_admin_html_view($content);
    }

	#==============Todays_sales_report============#
	public function todays_sales_report()
	{
		// if ($this->session->userdata('user_type') == '2') {
  //           $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
  //           redirect('Admin_dashboard');
  //       }
		// $this->auth->check_admin_auth();
		// $content = $this->lreport->todays_sales_report();
		// $this->template->full_admin_html_view($content);


		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		$CI =& get_instance();
		$CI->load->library('lreport');
		$this->auth->check_admin_auth();

		#
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/todays_sales_report/');
        $config["total_rows"] = $this->Reports->todays_sales_report_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        # 

		$content = $CI->lreport->todays_sales_report($links,$config["per_page"],$page);
		$this->template->full_admin_html_view($content);
	}

	#==============Transfer Report============#
	public function transfer_report()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		$this->auth->check_admin_auth();

		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$content = $this->lreport->transfer_report($from_date,$to_date);
		$this->template->full_admin_html_view($content);
	}		

	#==============Store To Store Transfer============#
	public function store_to_store_transfer()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');
		$to_date 	= $this->input->post('to_date');
		$from_store = $this->input->post('from_store');
		$to_store 	= $this->input->post('to_store');

		$content = $this->lreport->store_to_store_transfer($from_date,$to_date,$from_store,$to_store);
		$this->template->full_admin_html_view($content);
	}		
	#==============Store To Wearhouse============#
	public function store_to_warehouse_transfer()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }

		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		$from_store = $this->input->post('from_store');
		$t_wearhouse 	= $this->input->post('t_wearhouse');

		$content = $this->lreport->store_to_warehouse_transfer($from_date,$to_date,$from_store,$t_wearhouse);
		$this->template->full_admin_html_view($content);
	}		

	#==============Wearhouse To Store============#
	public function warehouse_to_store_transfer()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		$wearhouse = $this->input->post('wearhouse');
		$t_store   = $this->input->post('t_store');

		$content = $this->lreport->warehouse_to_store_transfer($from_date,$to_date,$wearhouse,$t_store);
		$this->template->full_admin_html_view($content);
	}		
	#==============Wearhouse To Wearhouse============#
	public function warehouse_to_warehouse_transfer()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		$wearhouse = $this->input->post('wearhouse');
		$t_wearhouse   = $this->input->post('t_wearhouse');

		$content = $this->lreport->warehouse_to_warehouse_transfer($from_date,$to_date,$wearhouse,$t_wearhouse);
		$this->template->full_admin_html_view($content);
	}	
	#==============Tax Report============#
	public function tax_report_product_wise()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
	
		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$content = $this->lreport->tax_report($from_date,$to_date);
		$this->template->full_admin_html_view($content);
	}	

	#==============Tax Report Invoice Wise============#
	public function tax_report_invoice_wise()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$content = $this->lreport->tax_report_invoice_wise($from_date,$to_date);
		$this->template->full_admin_html_view($content);
	}	
	#=============Total profit report===================#
	public function total_profit_report(){
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		#
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/total_profit_report/');
        $config["total_rows"] = $this->Reports->total_profit_report_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content =$this->lreport->total_profit_report($links,$config["per_page"],$page);

		$this->template->full_admin_html_view($content);
	}
	#==============Date wise profit report=============#
	public function retrieve_dateWise_profit_report()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$start_date = $this->input->post('from_date');		
		$end_date = $this->input->post('to_date');	
        $content = $this->lreport->retrieve_dateWise_profit_report($start_date,$end_date);
		$this->template->full_admin_html_view($content);
	}
	#============Date wise sales report==============#
	public function retrieve_dateWise_SalesReports()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');	
        $content = $CI->lreport->retrieve_dateWise_SalesReports($from_date,$to_date);
		$this->template->full_admin_html_view($content);
	}
	#================todays_purchase_report========#
	public function todays_purchase_report()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		$CI =& get_instance();
		$CI->load->library('lreport');
		$this->auth->check_admin_auth();

		#
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/todays_purchase_report/');
        $config["total_rows"] = $this->Reports->todays_sales_report_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        # 

		$content = $CI->lreport->todays_purchase_report($links,$config["per_page"],$page);
		$this->template->full_admin_html_view($content);
	}	
	#==============Date wise purchase report=============#
	public function retrieve_dateWise_PurchaseReports()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$start_date = $this->input->post('from_date');		
		$end_date = $this->input->post('to_date');	
        $content = $this->lreport->retrieve_dateWise_PurchaseReports($start_date,$end_date);
		$this->template->full_admin_html_view($content);
	}
	#==============Product sales search reports============#
	public function product_sales_search_reports()
	{
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
		
		$this->auth->check_admin_auth();
		$from_date = $this->input->post('from_date');		
		$to_date = $this->input->post('to_date');	
        $content = $this->lreport->get_products_search_report( $from_date,$to_date );
		$this->template->full_admin_html_view($content);
	}
	#============User login=========#
	public function login()
	{	
		if ($this->auth->is_logged() )
		{
			$this->output->set_header("Location: ".base_url().'Admin_dashboard', TRUE, 302);
		}
		$data['title'] = "Admin Login Area";
        $content = $this->parser->parse('user/admin_login_form',$data,true);
		$this->template->full_admin_html_view($content);
	}
	#==============Valid user check=======#
	public function do_login()
	{
		$error = '';
		$setting_detail = $this->Soft_settings->retrieve_setting_editdata(); 

		if ($setting_detail[0]['captcha'] == 0 && $setting_detail[0]['secret_key'] != null && $setting_detail[0]['site_key'] != null) {

			$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
			$this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata(array('error_message'=>display('please_enter_valid_captcha')));
				$this->output->set_header("Location: ".base_url().'admin', TRUE, 302);
			}else{
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				if ( $username == '' || $password == '' || $this->auth->login($username, $password) === FALSE ){
					$error = display('wrong_username_or_password');
				}
				if ( $error != '' ){
					$this->session->set_userdata(array('error_message'=>$error));
					$this->output->set_header("Location: ".base_url().'admin', TRUE, 302);
				}else{
					$this->output->set_header("Location: ".base_url('admin'), TRUE, 302);
		        }
			}
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ( $username == '' || $password == '' || $this->auth->login($username, $password) === FALSE ){
				$error = display('wrong_username_or_password');
			}
			if ( $error != '' ){
				$this->session->set_userdata(array('error_message'=>$error));
				$this->output->set_header("Location: ".base_url().'admin', TRUE, 302);
			}else{
				$this->output->set_header("Location: ".base_url('admin'), TRUE, 302);
	        }
		}
	}

	//Valid captcha check
	function validate_captcha() { 
		$setting_detail = $this->Soft_settings->retrieve_setting_editdata(); 
	  	$captcha = $this->input->post('g-recaptcha-response'); 
	  	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$setting_detail[0]['secret_key'].".&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']); 
	  	if ($response . 'success' == false) { return FALSE; } else { return TRUE; } 
	}

	#===============Logout=======#
	public function logout()
	{	
		if ($this->auth->logout())
		$this->output->set_header("Location: ".base_url().'admin', TRUE, 302);
	}
	#=============Edit Profile======#
	public function edit_profile()
	{
		$this->auth->check_admin_store_auth();
		$content = $this->luser->edit_profile_form();
		$this->template->full_admin_html_view($content);
	}
	#=============Update Profile========#
	public function update_profile()
	{
		$this->auth->check_admin_store_auth();
		$this->Users->profile_update();
		$this->session->set_userdata(array('message'=> display('successfully_updated')));
		redirect(base_url('Admin_dashboard/edit_profile'));
	}
	#=============Change Password=========# 
	public function change_password_form()
	{
		$this->auth->check_admin_store_auth();
		$content = $this->parser->parse('user/change_password',array('title'=>"Change Password"),true);
		$this->template->full_admin_html_view($content);
	}
	#============Change Password===========#
	public function change_password()
	{
		$this->auth->check_admin_store_auth();
		$error 			= '';
		$email 			= $this->input->post('email');
		$old_password 	= $this->input->post('old_password');
		$new_password 	= $this->input->post('password');
		$repassword 	= $this->input->post('repassword');

		if ( $email == '' || $old_password == '' || $new_password == '')
		{
			$error = display('blank_field_does_not_accept');
		}else if($email != $this->session->userdata('user_email')){
			$error = display('you_put_wrong_email_address');
		}else if(strlen($new_password)<6 ){
			$error = display('new_password_at_least_six_character');
		}else if($new_password != $repassword ){
			$error = display('password_and_repassword_does_not_match');
		}else if($this->Users->change_password($email,$old_password,$new_password) === FALSE ){
			$error = display('you_are_not_authorised_person');
		}

		if ( $error != '' )
		{
			$this->session->set_userdata(array('error_message'=>$error));
			$this->output->set_header("Location: ".base_url().'Admin_dashboard/change_password_form', TRUE, 302);
		}else{
			$this->session->set_userdata(array('message'=>display('successfully_changed_password')));
			$this->output->set_header("Location: ".base_url().'Admin_dashboard/change_password_form', TRUE, 302);
        }
	}
}
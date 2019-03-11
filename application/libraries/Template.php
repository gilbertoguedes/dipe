<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template {

	//Admin Html View....
	public function full_admin_html_view($content){
	
		$CI =& get_instance();
		$logged_info='';
		
		if ($CI->auth->is_admin())
		{
			$log_info = array(
					'email'  => $CI->session->userdata('user_name'),
					'logout' => base_url('Admin_dashboard/logout')
				); 
			$logged_info = $CI->parser->parse('include/admin_header',$log_info,true);
		}
		$CI->load->model('Products');
		$company_info=$CI->Products->retrieve_company();
		$data = array (
				'logindata' 	=> $logged_info,
				'content' 		=> $content,
				'company_info' 	=> $company_info
			);
		$content = $CI->parser->parse('admin_html_template',$data);
	}

	//Website Html View....
	public function full_website_html_view($content){
	
		$CI =& get_instance();
		$CI->load->model('Products');
		$company_info=$CI->Products->retrieve_company();
		$data = array (
				'content' 		=> $content,
				'company_info' 	=> $company_info
			);
		$content = $CI->parser->parse('website/website_html_template',$data);
	}	

	//Customer Html View....
	public function full_customer_html_view($content){
		$CI =& get_instance();
		$CI->load->model('Products');
		//$company_info=$CI->Products->retrieve_company();
		$data = array (
				'content' 		=> $content,
				//'company_info' 	=> $company_info
			);
		$content = $CI->parser->parse('website/customer/customer_html_template',$data);
	}
}
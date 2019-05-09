<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csoft_setting extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('lsoft_setting');
		$this->load->model('Soft_settings');
		$this->auth->check_admin_auth();

		//User validation check
		if ($this->session->userdata('user_type') == '2') {
            $this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
            redirect('Admin_dashboard');
        }
    }

	//Default loading for Category system.
	public function index()
	{
		$content = $this->lsoft_setting->setting_add_form();
		$this->template->full_admin_html_view($content);
	}

	// Setting Update
	public function update_setting()
	{
		if ($_FILES['logo']['name']) {
			$config['upload_path']          = 'my-assets/image/logo/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
	        $config['max_size']             = "1024";
	        $config['max_width']            = "*";
	        $config['max_height']           = "*";
	        $config['encrypt_name'] 		= TRUE;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('logo'))
	        {
	            $error = array('error' => $this->upload->display_errors());
	            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
	            redirect(base_url('Csoft_setting'));
	        }
	        else
	        {
	        	$image =$this->upload->data();
	        	$logo = base_url()."my-assets/image/logo/".$image['file_name'];
	        }
		}

		if ($_FILES['favicon']['name']) {
			$config['upload_path']          = 'my-assets/image/logo/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
	        $config['max_size']             = "1024";
	        $config['max_width']            = "*";
	        $config['max_height']           = "*";
	        $config['encrypt_name'] 		= TRUE;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('favicon'))
	        {
	            $error = array('error' => $this->upload->display_errors());
	            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
	            redirect(base_url('Csoft_setting'));
	        }
	        else
	        {
	        	$image =$this->upload->data();
	        	$favicon = base_url()."my-assets/image/logo/".$image['file_name'];
	        }
		}

		if ($_FILES['invoice_logo']['name']) {
			$config['upload_path']          = 'my-assets/image/logo/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
	        $config['max_size']             = "1024";
	        $config['max_width']            = "*";
	        $config['max_height']           = "*";
	        $config['encrypt_name'] 		= TRUE;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('invoice_logo'))
	        {
	            $error = array('error' => $this->upload->display_errors());
	            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
	            redirect(base_url('Csoft_setting'));
	        }
	        else
	        {
	        	$image =$this->upload->data();
	        	$invoice_logo = base_url()."my-assets/image/logo/".$image['file_name'];
	        }
		}

		$old_logo 	 = $this->input->post('old_logo');
		$old_invoice_logo = $this->input->post('old_invoice_logo');
		$old_favicon = $this->input->post('old_favicon');

		$language = $this->input->post('language');
		$this->session->set_userdata('language',$language);

		$data=array(
			'logo' 			=> (!empty($logo)?$logo:$old_logo),
			'invoice_logo' 	=> (!empty($invoice_logo)?$invoice_logo:$old_invoice_logo),
			'favicon' 		=> (!empty($favicon)?$favicon:$old_favicon),
			'footer_text'	=> $this->input->post('footer_text'),
			'language' 		=> $language,
			'rtr' 			=> $this->input->post('rtr'),
			'captcha' 		=> $this->input->post('captcha'),
			'site_key' 		=> $this->input->post('site_key'),
			'secret_key' 	=> $this->input->post('secret_key'),
			);

		$this->Soft_settings->update_setting($data);
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('Csoft_setting'));
	}

	//Email Configuration
	public function email_configuration(){
		$content = $this->lsoft_setting->email_configuration_form();
		$this->template->full_admin_html_view($content);
	}
	
	//Update email configuration
	public function update_email_configuration()
	{
		
	
		$data=array(
			'protocol' 		=> $this->input->post('protocol'),
			'mailtype'		=> $this->input->post('mailtype'),
			'smtp_host' 	=> $this->input->post('smtp_host'),
			'smtp_port' 	=> $this->input->post('smtp_port'),
			'sender_email' 	=> $this->input->post('sender_email'),
			'password' 		=> $this->input->post('password'),
		);

		$this->Soft_settings->update_email_config($data);
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('Csoft_setting/email_configuration'));
	}

	//Payment Configuration
	public function payment_gateway_setting(){
		$content = $this->lsoft_setting->payment_configuration_form();
		$this->template->full_admin_html_view($content);
	}

	//Update payment configuration
	public function update_payment_gateway_setting($id = null)
	{
		if ($id == 2) {
			$data=array(
				'shop_id' 		=> $this->input->post('shop_id'),
				'secret_key'	=> $this->input->post('secret_key'),
				'status' 		=> $this->input->post('status'),
			);
			$this->Soft_settings->update_payment_gateway_setting($data,$id);
		}else if ($id == 1){
			$data=array(
				'public_key' => $this->input->post('public_key'),
				'private_key'=> $this->input->post('private_key'),
				'status' 	 => $this->input->post('status'),
			);

			$this->Soft_settings->update_payment_gateway_setting($data,$id);
		}else if ($id == 3){
			$data=array(
				'paypal_email' => $this->input->post('paypal_email'),
				'paypal_client_id' => $this->input->post('client_id'),
				'currency'	   => $this->input->post('currency'),
				'status' 	   => $this->input->post('status'),
			);

			$this->Soft_settings->update_payment_gateway_setting($data,$id);
		}
		
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('Csoft_setting/payment_gateway_setting'));
	}


}
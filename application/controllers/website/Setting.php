<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends CI_Controller {

	function __construct() {
      	parent::__construct();
      	$this->load->model('website/Settings');
		$this->load->library('website/Lsetting');
		$this->load->library('website/customer/User_auth');
	}

	//Default loading for Setting Index.
	public function index()
	{
		$content = $this->lsetting->setting_page();
		$this->template->full_website_html_view($content);
	}
	
	

	//About us
	public function about_us()
	{
		$content = $this->lsetting->about_us('1');
		$this->template->full_website_html_view($content);
	}
	
	//About us
	public function user_registered()
	{
		$content = $this->lsetting->user_registered('1');
		$this->template->full_website_html_view($content);
	}

	//About us info
	public function activate_user($user_id)
	{
        $activate_user = $this->user_auth->check_user_id($user_id);

		if ($activate_user)
		{
            $this->user_auth->login_password_cripto($activate_user[0]['customer_email'],$activate_user[0]['password']);
			$this->session->set_userdata(array('message'=>display('login_successfully')));
			$this->output->set_header("Location: ".base_url(), TRUE, 302);
		}
		else
		{
			redirect(base_url('home'), 'refresh');
		}
	}

	//Delivery info us
	public function delivery_info()
	{
		$content = $this->lsetting->delivery_info('3');
		$this->template->full_website_html_view($content);
	}	

	//Privacy info us
	public function privacy_policy()
	{
		$content = $this->lsetting->privacy_policy('4');
		$this->template->full_website_html_view($content);
	}	

	//Terms and conditon
	public function terms_condition()
	{
		$content = $this->lsetting->terms_condition('5');
		$this->template->full_website_html_view($content);
	}		

	//Help
	public function help()
	{
		$content = $this->lsetting->help('6');
		$this->template->full_website_html_view($content);
	}		

	//Contact Us
	public function contact_us()
	{
		$content = $this->lsetting->contact_us();
		$this->template->full_website_html_view($content);
	}	

	//Submit Contact Us
	public function submit_contact()
	{

		$this->form_validation->set_rules('first_name', display('first_name'), 'trim|required');
		$this->form_validation->set_rules('last_name', display('last_name'), 'trim|required');
		$this->form_validation->set_rules('email', display('email'), 'trim|required');
		$this->form_validation->set_rules('message', display('details'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        { 
        	$this->session->set_userdata(array('error_message'=>validation_errors()));
        	redirect('contact_us');
        }else{

			$data=array(
				'id' 			=> $this->auth->generator(15),
				'first_name' 	=> $this->input->post('first_name'),
				'last_name' 	=> $this->input->post('last_name'),
				'email'			=> $this->input->post('email'),
				'message'		=> $this->input->post('message'),
			);

			$result=$this->Settings->submit_contact($data);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_added')));
				redirect(base_url('submit_contact'));
			}else{
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect(base_url('submit_contact'));
			}
        }
	}	

	//Default loading for Setting Details.
	public function setting_details($p_id)
	{
		$content = $this->lsetting->setting_details($p_id);
		$this->template->full_website_html_view($content);
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
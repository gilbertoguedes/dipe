<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccustomer extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('lcustomer');
		$this->load->model('Customers');
		$this->auth->check_admin_store_auth();
        $this->load->model('website/customer/Signups');
        $this->load->model('website/Settings');
    }

	//Default loading for Customer System.
	public function index()
	{
		$content = $this->lcustomer->customer_add_form();
		$this->template->full_admin_html_view($content);
	}

	//customer_search_item
	public function customer_search_item()
	{
		$customer_id = $this->input->post('customer_id');			
		$content = $this->lcustomer->customer_search_item($customer_id);
		$this->template->full_admin_html_view($content);
	}

	//Manage customer
	public function manage_customer()
	{
		$this->load->model('Customers');
		$content = $this->lcustomer->customer_list();
		$this->template->full_admin_html_view($content);;
	}
	
	//Insert Product and upload
	public function insert_customer()
	{
		$customer_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'customer_id' 		=> $customer_id,
			'customer_name' 	=> $this->input->post('customer_name'),
			'customer_mobile' 	=> $this->input->post('mobile'),
			'customer_email' 	=> $this->input->post('email'),
			'customer_short_address' => $this->input->post('address'),
			'customer_address_1' => $this->input->post('customer_address_1'),
			'customer_address_2' => $this->input->post('customer_address_2'),
			'city' 				=> $this->input->post('city'),
			'state' 			=> $this->input->post('state'),
			'country' 			=> $this->input->post('country'),
			'zip' 				=> $this->input->post('zip'),
			'status' 			=> 1
			);

		$result=$this->Customers->customer_entry($data);
		
		if ($result == TRUE) {		
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			if(isset($_POST['add-customer'])){
				redirect(base_url('Ccustomer/manage_customer'));
				exit;
			}elseif(isset($_POST['add-customer-another'])){
				redirect(base_url('Ccustomer'));
				exit;
			}
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Ccustomer'));
		}
	}

	//customer Update Form
	public function customer_update_form($customer_id)
	{	
		$content = $this->lcustomer->customer_edit_data($customer_id);
		$this->template->full_admin_html_view($content);
	}

	public function customer_send_code($customer_id)
    {
        $customer = $this->Customers->customer_by_id($customer_id);
        $email = $customer[0]['customer_email'];

        if($this->Signups->user_exist($email))
        {
            $password_code = $this->auth->generator(15);
            $data = array(
                'reset_password_code'=> $password_code
            );

            $customer_id = $this->Signups->user($email);
            if($this->Signups->update_reset_password_code($customer_id,$data))
            {
                $this->Settings->send_mail($email,'Código: ', $password_code);
                $this->session->set_userdata(array('message'=>'Código de activación enviado'));
                redirect(base_url('/Ccustomer/manage_customer'));
            }
            else
            {
                $this->session->set_userdata(array('error_message'=>'Error al generar el código de restablecer contraseña'));
                redirect(base_url('/Ccustomer/manage_customer'));
            }

        }
        $this->session->set_userdata(array('error_message'=>'No existe el correo de usuario'));
        redirect(base_url('/Ccustomer/manage_customer'));
    }

	// customer Update
	public function customer_update()
	{
		$this->load->model('Customers');
		$customer_id  = $this->input->post('customer_id');

	  	//Customer  basic information adding.
		$data=array(
			'customer_name' 	=> $this->input->post('customer_name'),
			'customer_mobile' 	=> $this->input->post('mobile'),
			'customer_email' 	=> $this->input->post('email'),
			'customer_short_address' => $this->input->post('address'),
			'customer_address_1' => $this->input->post('customer_address_1'),
			'customer_address_2' => $this->input->post('customer_address_2'),
			'city' 				=> $this->input->post('city'),
			'state' 			=> $this->input->post('state'),
			'country' 			=> $this->input->post('country'),
			'zip' 				=> $this->input->post('zip'),
			'status' 			=> 1
			);

		$this->Customers->update_customer($data,$customer_id);
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect('Ccustomer/manage_customer');
	}

	//Select city by country id
	public function select_city_country_id()
	{
		$country_id = $this->input->post('country_id');
		$states = $this->Customers->select_city_country_id($country_id);

		$html ="";
		if ($states) {
			$html .="<select class=\"form-control select2\" id=\"country\" name=\"country\" style=\"width: 100%\">
					<option value=\"\">".display('select_one')."</option>";
			foreach ($states as $state) {
            $html .="<option value='".$state->name."'>".$state->name."</option>";
			}
			$html .="</select>";
		}
		echo $html;
	}	

	//Credit Customer Form
	public function credit_customer()
	{
		$this->load->model('Customers');
		
		$content = $this->lcustomer->credit_customer_list();
		$this->template->full_admin_html_view($content);;
	}
	
	//Paid Customer list. The customer who will pay 100%.
	public function paid_customer()
	{
		$this->load->model('Customers');
		$content = $this->lcustomer->paid_customer_list();
		$this->template->full_admin_html_view($content);;
	}
			
	//Customer Ledger
	public function customer_ledger($customer_id)
	{	
		$content = $this->lcustomer->customer_ledger_data($customer_id);
		$this->template->full_admin_html_view($content);
	}

	//Customer Ledger Report
	public function customer_ledger_report()
	{	
		$customer_id = $this->input->post('customer_id');
		$content = $this->lcustomer->customer_ledger_report($customer_id);
		$this->template->full_admin_html_view($content);
	}
	
	//Customer Final Ledger
	public function customerledger($customer_id)
	{
		$content = $this->lcustomer->customerledger_data($customer_id);
		$this->template->full_admin_html_view($content);
	}	
	//Customer Previous Balance
	public function previous_balance_form()
	{	
		$content = $this->lcustomer->previous_balance_form();
		$this->template->full_admin_html_view($content);
	}
	// product_delete
	public function customer_delete($customer_id)
	{	
		$this->load->model('Customers');
		$this->Customers->delete_customer($customer_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect('Ccustomer/manage_customer');
	}			
}
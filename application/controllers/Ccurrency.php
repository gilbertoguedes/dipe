<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccurrency extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('lcurrency');
		$this->load->model('Currencies');
		$this->auth->check_admin_auth();
    }
	//Default loading for currency system.
	public function index()
	{
		$content = $this->lcurrency->currency_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert currency
	public function insert_currency()
	{
		$this->form_validation->set_rules('currency_name', display('currency_name'), 'trim|required');
		$this->form_validation->set_rules('currency_icon', display('currency_icon'), 'trim|required');
		$this->form_validation->set_rules('currency_position', display('currency_position'), 'trim|required');
		$this->form_validation->set_rules('conversion_rate', display('conversion_rate'), 'trim|required');
		$this->form_validation->set_rules('default_status', display('default_status'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_currency')
			);
        	$content = $this->parser->parse('currency/add_currency',$data,true);
			$this->template->full_admin_html_view($content);
        }else{

			$data=array(
				'currency_id' 	=> $this->auth->generator(15),
				'currency_name' => $this->input->post('currency_name'),
				'currency_icon' => $this->input->post('currency_icon'),
				'currency_position' => $this->input->post('currency_position'),
				'convertion_rate'=> $this->input->post('conversion_rate'),
				'default_status' => $this->input->post('default_status'),
			);

			$result=$this->Currencies->currency_entry($data);

			//This code for default status set in session start
			$this->db->select('*');
			$this->db->from('currency_info');
			$this->db->where('default_status',1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$ses = $query->row();

				$sess_data = array(
				    'currency_id'  		=> $ses->currency_id,
				    'currency_position' => $ses->currency_position,
				);
				$this->session->unset_userdata('currency_id','currency_position');
				$this->session->set_userdata($sess_data);
			}else{
				$this->session->unset_userdata('currency_id','currency_position');
			}
			//This code for default status set in session end

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-currency'])){
					redirect(base_url('Ccurrency/manage_currency'));
				}elseif(isset($_POST['add-currency-another'])){
					redirect(base_url('Ccurrency'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('default_status_already_exists')));
				redirect('Ccurrency');
			}
        }
	}
	//Manage currency
	public function manage_currency()
	{
        $content =$this->lcurrency->currency_list();
		$this->template->full_admin_html_view($content);;
	}
	//Currency Update Form
	public function currency_update_form($currency_id)
	{	
		$content = $this->lcurrency->currency_edit_data($currency_id);
		$this->template->full_admin_html_view($content);
	}
	// Currency Update
	public function currency_update($currency_id=null)
	{
		$this->form_validation->set_rules('currency_name', display('currency_name'), 'trim|required');
		$this->form_validation->set_rules('currency_icon', display('currency_icon'), 'trim|required');
		$this->form_validation->set_rules('currency_position', display('currency_position'), 'trim|required');
		$this->form_validation->set_rules('conversion_rate', display('conversion_rate'), 'trim|required');
		$this->form_validation->set_rules('default_status', display('default_status'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_currency')
			);
        	$content = $this->parser->parse('currency/add_currency',$data,true);
			$this->template->full_admin_html_view($content);
        }else{

			$data=array(
				'currency_name' => $this->input->post('currency_name'),
				'currency_icon' => $this->input->post('currency_icon'),
				'currency_position' => $this->input->post('currency_position'),
				'convertion_rate'=> $this->input->post('conversion_rate'),
				'default_status' => $this->input->post('default_status'),
				);

			$result=$this->Currencies->update_currency($data,$currency_id);

			//This code for default status set in session start
			$this->db->select('*');
			$this->db->from('currency_info');
			$this->db->where('default_status',1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$ses = $query->row();

				$sess_data = array(
				    'currency_id'  		=> $ses->currency_id,
				    'currency_position' => $ses->currency_position,
				);
				$this->session->unset_userdata('currency_id','currency_position');
				$this->session->set_userdata($sess_data);
			}else{
				$this->session->unset_userdata('currency_id','currency_position');
			}
			//This code for default status set in session end

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Ccurrency/manage_currency');
			}else{
				$this->session->set_userdata(array('error_message'=>display('default_status_already_exists')));
				redirect('Ccurrency/manage_currency');
			}
        }
	}
	// Currency Delete
	public function currency_delete($currency_id)
	{
		$currency = $this->Currencies->delete_currency($currency_id);

		if ($currency) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Ccurrency/manage_currency');
		}else{
			$this->session->set_userdata(array('error_message'=>display('you_cant_delete_this_is_default_currency')));
			redirect('Ccurrency/manage_currency');
		}
	}
}
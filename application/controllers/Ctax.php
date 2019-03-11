<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ctax extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('ltax');
		$this->load->model('Taxs');
		$this->auth->check_admin_auth();
    }
	//Default loading for tax system.
	public function index()
	{
		$data = array(
			'title' => display('add_tax')
		);
        $content = $this->parser->parse('tax/tax_product_service',$data,true);
		$this->template->full_admin_html_view($content);
	}
	//Insert tax product service
	public function insert_tax_product_service()
	{
		$this->form_validation->set_rules('tax_id', display('tax_name'), 'trim|required');
		$this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');
		$this->form_validation->set_rules('tax_percentage', display('tax_percentage'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_tax')
			);
        	$content = $this->parser->parse('tax/tax_product_service',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {
			$data=array(
				't_p_s_id' 		=> $this->auth->generator(15),
				'product_id' 	=> $this->input->post('product_id'),
				'tax_id' 		=> $this->input->post('tax_id'),
				'tax_percentage' => $this->input->post('tax_percentage'),
				);

			$result=$this->Taxs->tax_product_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));
				if(isset($_POST['add-tax'])){
					redirect(('Ctax/manage_tax'));
				}elseif(isset($_POST['add-tax-another'])){
					redirect(('Ctax/tax_product_service'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect(('Ctax/tax_product_service'));
			}
        }
	}
	//Manage tax
	public function manage_tax()
	{
        $content =$this->ltax->tax_list();
		$this->template->full_admin_html_view($content);
	}
	//tax Update Form
	public function tax_product_update_form($tax_id)
	{	
		$content = $this->ltax->tax_product_update_form($tax_id);
		$this->template->full_admin_html_view($content);
	}
	// tax Update
	public function tax_update($t_p_s_id=null)
	{

		$this->form_validation->set_rules('tax_id', display('tax_name'), 'trim|required');
		$this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');
		$this->form_validation->set_rules('tax_percentage', display('tax_percentage'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_tax')
			);
        	$content = $this->parser->parse('tax/add_tax',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'product_id' 	=> $this->input->post('product_id'),
				'tax_id' 		=> $this->input->post('tax_id'),
				'tax_percentage' => $this->input->post('tax_percentage'),
				);

			$result=$this->Taxs->tax_product_update($data,$t_p_s_id);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));
				redirect('Ctax/manage_tax');
			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect(('Ctax/tax_product_service'));
			}
        }
	}
	//Tax product service
	public function tax_product_service(){
		$content =$this->ltax->tax_product_service();
		$this->template->full_admin_html_view($content);
	}
	// tax Delete
	public function tax_delete($t_p_s_id)
	{
		$this->Taxs->delete_tax($t_p_s_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect('Ctax/manage_tax');
	}

	//Tax setting
	public function tax_setting(){
		$content =$this->ltax->tax_setting();
		$this->template->full_admin_html_view($content);
	}

	//Tax inactive
	public function inactive_tax(){
		$tax_id 	= $this->input->post('tax_id');
		$tax_name 	= $this->input->post('tax_name');

		$tax_inactive = $this->db->set('tax_name',$tax_name)
								->set('status',0)
								->where('tax_id',$tax_id)
								->update('tax');

		if ($tax_inactive) {
			echo "1";
		}
	}	
	//Tax active
	public function active_tax(){
		$tax_id 	= $this->input->post('tax_id');
		$tax_name 	= $this->input->post('tax_name');

		$tax_active = $this->db->set('tax_name',$tax_name)
								->set('status',1)
								->where('tax_id',$tax_id)
								->update('tax');

		if ($tax_active) {
			echo "1";
		}
	}

	//Tax update
	public function update_tax(){
		$tax_id 	= $this->input->post('id');
		$tax_name 	= $this->input->post('value');

		$result = $this->db->set('tax_name',$tax_name)
								->where('tax_id',$tax_id)
								->update('tax');

		if ($result) {
			echo $tax_name;
		}
	}	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cvariant extends CI_Controller {

	function __construct() {
      parent::__construct();
		$this->load->library('lvariant');
		$this->load->model('Variants');
		$this->auth->check_admin_auth();
    }
	//Default loading for variant system.
	public function index()
	{
		$content = $this->lvariant->variant_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert variant
	public function insert_variant()
	{

		$this->form_validation->set_rules('variant_name', display('variant_name'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_variant')
			);
        	$content = $this->parser->parse('variant/add_variant',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'variant_id' 	=> $this->auth->generator(15),
				'variant_name' 	=> $this->input->post('variant_name'),
				'status' 		=> 1
				);

			$result=$this->Variants->variant_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-variant'])){
					redirect(base_url('Cvariant/manage_variant'));
				}elseif(isset($_POST['add-variant-another'])){
					redirect(base_url('Cvariant'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect(base_url('Cvariant'));
			}
        }
	}
	//Manage variant
	public function manage_variant()
	{
        $content =$this->lvariant->variant_list();
		$this->template->full_admin_html_view($content);;
	}
	//variant Update Form
	public function variant_update_form($variant_id)
	{	
		$content = $this->lvariant->variant_edit_data($variant_id);
		$this->menu=array('label'=> 'Edit variant', 'url' => 'Ccustomer');
		$this->template->full_admin_html_view($content);
	}
	// variant Update
	public function variant_update($variant_id=null)
	{

		$this->form_validation->set_rules('variant_name', display('variant_name'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('variant_edit')
			);
        	$content = $this->parser->parse('variant/edit_variant',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {
			$data=array(
				'variant_name' 	=> $this->input->post('variant_name'),
				'status' 		=> $this->input->post('status'),
				);

			$result=$this->Variants->update_variant($data,$variant_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cvariant/manage_variant');
			}else{
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cvariant/manage_variant');
			}
        }
	}
	// Variant Delete
	public function variant_delete($variant_id)
	{	
		$result = $this->Variants->delete_variant($variant_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Cvariant/manage_variant');
		}
	}
}
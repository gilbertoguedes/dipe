<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cunit extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('lunit');
		$this->load->model('Units');
		$this->auth->check_admin_auth();
    }
	//Default loading for unit system.
	public function index()
	{
		$content = $this->lunit->unit_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert unit
	public function insert_unit()
	{
		$this->form_validation->set_rules('unit_name', display('unit_name'), 'trim|required');
		$this->form_validation->set_rules('unit_short_name', display('unit_short_name'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_unit')
			);
        	$content = $this->parser->parse('unit/add_unit',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'unit_id' 		=> $this->auth->generator(15),
				'unit_name' 	=> $this->input->post('unit_name'),
				'unit_short_name' => $this->input->post('unit_short_name'),
				);

			$result=$this->Units->unit_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));
				if(isset($_POST['add-unit'])){
					redirect(('Cunit/manage_unit'));
				}elseif(isset($_POST['add-unit-another'])){
					redirect(('Cunit'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect(('Cunit'));
			}
        }
	}
	//Manage unit
	public function manage_unit()
	{
        $content =$this->lunit->unit_list();
		$this->template->full_admin_html_view($content);;
	}
	//unit Update Form
	public function unit_update_form($unit_id)
	{	
		$content = $this->lunit->unit_edit_data($unit_id);
		$this->template->full_admin_html_view($content);
	}
	// unit Update
	public function unit_update($unit_id=null)
	{

		$this->form_validation->set_rules('unit_name', display('unit_name'), 'trim|required');
		$this->form_validation->set_rules('unit_short_name', display('unit_short_name'), 'trim|required');


		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_unit')
			);
        	$content = $this->parser->parse('unit/add_unit',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'unit_name' 	=> $this->input->post('unit_name'),
				'unit_short_name' 	=> $this->input->post('unit_short_name'),
				);

			$result=$this->Units->update_unit($data,$unit_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cunit/manage_unit');
			}else{
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cunit/manage_unit');
			}
        }
	}
	// unit Delete
	public function unit_delete($unit_id)
	{	
		$result = $this->Units->delete_unit($unit_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Cunit/manage_unit');
		}	
	}
}
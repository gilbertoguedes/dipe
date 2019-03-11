<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cweb_footer extends CI_Controller {

	function __construct() {
     	parent::__construct();
		$this->load->library('lweb_footer');
		$this->load->model('Web_footers');
		$this->auth->check_admin_auth();
    }
	//Default loading for web_footer system.
	public function index()
	{
		$content = $this->lweb_footer->web_footer_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert web_footer
	public function insert_web_footer()
	{

		$this->form_validation->set_rules('headlines', display('headlines'), 'trim|required');
		$this->form_validation->set_rules('details', display('details'), 'trim|required');
		$this->form_validation->set_rules('position', display('position'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_web_footer'),
			);
        	$content = $this->parser->parse('web_footer/add_web_footer',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {
			$data=array(
				'footer_section_id' => $this->auth->generator(15),
				'headlines' => $this->input->post('headlines'),
				'details' 	=> $this->input->post('details'),
				'position' 	=> $this->input->post('position'),
				'status' 	=> 1,
			);

			$result=$this->Web_footers->web_footer_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-web_footer'])){
					redirect(base_url('Cweb_footer/manage_web_footer'));
				}elseif(isset($_POST['add-web_footer-another'])){
					redirect(base_url('Cweb_footer'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect(base_url('Cweb_footer'));
			}
        }
	}
	//Manage web_footer
	public function manage_web_footer()
	{
        $content =$this->lweb_footer->web_footer_list();
		$this->template->full_admin_html_view($content);;
	}
	//web_footer Update Form
	public function web_footer_update_form($footer_section_id)
	{	
		$content = $this->lweb_footer->web_footer_edit_data($footer_section_id);
		$this->template->full_admin_html_view($content);
	}
	// web_footer Update
	public function web_footer_update($footer_section_id=null)
	{

		$this->form_validation->set_rules('headlines', display('headlines'), 'trim|required');
		$this->form_validation->set_rules('details', display('details'), 'trim|required');
		$this->form_validation->set_rules('position', display('position'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_web_footer'),
			);
        	$content = $this->parser->parse('web_footer/add_web_footer',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {
			$data=array(
				'headlines' => $this->input->post('headlines'),
				'details' 	=> $this->input->post('details'),
				'position' 	=> $this->input->post('position'),
			);

			$result=$this->Web_footers->update_web_footer($data,$footer_section_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cweb_footer/manage_web_footer');
			}else{
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect('Cweb_footer/manage_web_footer');
			}
        }
	}
	// web_footer Delete
	public function web_footer_delete($footer_section_id)
	{
		$this->Web_footers->delete_web_footer($footer_section_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect('Cweb_footer/manage_web_footer');
	}

	//Inactive
	public function inactive($id){
		$this->db->set('status', 0);
		$this->db->where('footer_section_id',$id);
		$this->db->update('web_footer');
		$this->session->set_userdata(array('error_message'=>display('successfully_inactive')));
		redirect(base_url('Cweb_footer/manage_web_footer'));
	}
	//Active 
	public function active($id){
		$this->db->set('status', 1);
		$this->db->where('footer_section_id',$id);
		$this->db->update('web_footer');
		$this->session->set_userdata(array('message'=>display('successfully_active')));
		redirect(base_url('Cweb_footer/manage_web_footer'));
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csubscriber extends CI_Controller {

	function __construct() {
      parent::__construct();
		$this->load->library('lsubscriber');
		$this->load->model('Subscribers');
		$this->auth->check_admin_auth();
    }
	//Default loading for subscriber system.
	public function index()
	{
		$content =$this->lsubscriber->subscriber_list();
		$this->template->full_admin_html_view($content);
	}
	//Insert subscriber
	public function insert_subscriber()
	{

		$this->form_validation->set_rules('email', display('email'), 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_subscriber')
			);
        	$content = $this->parser->parse('subscriber/add_subscriber',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {
			$data=array(
				'subscriber_id' => $this->auth->generator(15),
				'apply_ip' 		=> $this->input->ip_address(),
				'email' 		=> $this->input->post('email'),
				'status' 		=> 1
			);

			$result=$this->Subscribers->subscriber_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-subscriber'])){
					redirect(base_url('Csubscriber/manage_subscriber'));
				}elseif(isset($_POST['add-subscriber-another'])){
					redirect(base_url('Csubscriber'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect(base_url('Csubscriber'));
			}
        }
	}
	//Manage subscriber
	public function manage_subscriber()
	{
        $content =$this->lsubscriber->subscriber_list();
		$this->template->full_admin_html_view($content);
	}
	//subscriber Update Form
	public function subscriber_update_form($subscriber_id)
	{	
		$content = $this->lsubscriber->subscriber_edit_data($subscriber_id);
		$this->template->full_admin_html_view($content);
	}
	// subscriber Update
	public function subscriber_update($subscriber_id=null)
	{

		$this->form_validation->set_rules('email', display('email'), 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_subscriber')
			);
        	$content = $this->parser->parse('subscriber/add_subscriber',$data,true);
			$this->template->full_admin_html_view($content);
        }
        else
        {
        
			$data=array(
				'email' 		=> $this->input->post('email')
			);

			$result=$this->Subscribers->update_subscriber($data,$subscriber_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Csubscriber/manage_subscriber');
			}else{
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Csubscriber/manage_subscriber');
			}
        }
	}
	// subscriber Delete
	public function subscriber_delete($subscriber_id)
	{
		$this->Subscribers->delete_subscriber($subscriber_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));	
		redirect('Csubscriber/manage_subscriber');
	}

	//Inactive
	public function inactive($id){
		$this->db->set('status', 0);
		$this->db->where('subscriber_id',$id);
		$this->db->update('subscriber');
		$this->session->set_userdata(array('error_message'=>display('successfully_inactive')));
		redirect(base_url('Csubscriber/manage_subscriber'));
	}
	//Active 
	public function active($id){
		$this->db->set('status', 1);
		$this->db->where('subscriber_id',$id);
		$this->db->update('subscriber');
		$this->session->set_userdata(array('message'=>display('successfully_active')));
		redirect(base_url('Csubscriber/manage_subscriber'));
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cabout_us extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('labout_us');
		$this->load->model('About_us');
		$this->auth->check_admin_auth();
    }
	//Default loading for about_us system.
	public function index()
	{
		$content = $this->labout_us->about_us_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert about_us
	public function insert_about_us()
	{

		$favicon 	 = $this->input->post('favicon');
		$lang_id 	 = $this->input->post('language_id');
		$headlines 	 = $this->input->post('headlines');
		$details 	 = $this->input->post('details');
		$position 	 = $this->input->post('position');

		//Link page add
		for ($i=0, $n=count($lang_id); $i < $n; $i++) {

			$language_id = $lang_id[$i];
			$head_line 	 = $headlines[$i];
			$detail		 = $details[$i];

			$data = array(
				'language_id' 	=> 	$language_id, 
				'headline' 		=> 	$head_line,
				'icon' 			=> 	$favicon,
				'details' 		=> 	$detail,
				'position' 		=> 	$position,
				'status'		=>	'1',
			);


			$pos_res = $this->db->select('*')
								->from('about_us')
								->where('position',$position)
								->where('language_id',$language_id)
								->get()
								->num_rows();

			if ($pos_res > 0) {
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect(base_url('Cabout_us'));
			}else{
				$result = $this->About_us->about_us_entry($data);
			}
		}

		if ($result == TRUE) {
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			if(isset($_POST['add-about_us'])){
				redirect(base_url('Cabout_us/manage_about_us'));
			}elseif(isset($_POST['add-about_us-another'])){
				redirect(base_url('Cabout_us'));
			}
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Cabout_us'));
		}
	}
	//Manage about_us
	public function manage_about_us()
	{
        $content =$this->labout_us->about_us_list();
		$this->template->full_admin_html_view($content);;
	}
	//about_us Update Form
	public function about_us_update_form($content_id)
	{	
		$content = $this->labout_us->about_us_edit_data($content_id);
		$this->template->full_admin_html_view($content);
	}

	// about_us Update
	public function about_us_update($position=null)
	{

		$favicon 	 = $this->input->post('favicon');
		$lang_id 	 = $this->input->post('language_id');
		$headlines 	 = $this->input->post('headlines');
		$details 	 = $this->input->post('details');
		$pos 	 	 = $this->input->post('position');

		//Link page add
		for ($i=0, $n=count($lang_id); $i < $n; $i++) {

			$language_id = $lang_id[$i];
			$head_line 	 = $headlines[$i];
			$detail		 = $details[$i];

			$pos_res = $this->db->select('*')
								->from('about_us')
								->where('position',$pos)
								->get()
								->num_rows();

			if ($pos_res > 0) {
				$new = array(
						'headline' 		=> 	$head_line,
						'icon' 			=> 	$favicon,
						'details' 		=> 	$detail,
					);

				$result = $this->About_us->update_about_us($new,$position,$language_id);
			}else{
				$u_pos = array(
					'headline' 		=> 	$head_line,
					'icon' 			=> 	$favicon,
					'details' 		=> 	$detail,
					'position' 		=> 	$pos,
				);
				$result = $this->About_us->update_about_us($u_pos,$position,$language_id);
			}
		}

		if ($result == TRUE) {
			$this->session->set_userdata(array('message'=>display('successfully_updated')));
			redirect(base_url('Cabout_us/manage_about_us'));
		}else{
			$this->session->set_userdata(array('error_message'=>display('position_already_exists')));
			redirect(base_url('Cabout_us/manage_about_us'));
		}
	}
	// about_us Delete
	public function about_us_delete($about_us_id)
	{
		$this->About_us->delete_about_us($about_us_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect('Cabout_us/manage_about_us');
	}

	//Inactive
	public function inactive($id){
		$this->db->set('status', 0);
		$this->db->where('content_id',$id);
		$this->db->update('about_us');
		$this->session->set_userdata(array('error_message'=>display('successfully_inactive')));
		redirect(base_url('Cabout_us/manage_about_us'));
	}
	//Active 
	public function active($id){
		$this->db->set('status', 1);
		$this->db->where('content_id',$id);
		$this->db->update('about_us');
		$this->session->set_userdata(array('message'=>display('successfully_active')));
		redirect(base_url('Cabout_us/manage_about_us'));
	}
}
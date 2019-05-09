<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cblock extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('lblock');
		$this->load->model('Blocks');
		$this->auth->check_admin_auth();
    }
	//Default loading for block system.
	public function index()
	{
		$content = $this->lblock->block_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert block
	public function insert_block()
	{
		$this->form_validation->set_rules('block_cat_id', display('category'), 'trim|required');
		$this->form_validation->set_rules('block_position', display('block_position'), 'trim|required');
		$this->form_validation->set_rules('block_style', display('block_style'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_block')
			);
        	$content = $this->parser->parse('block/add_block',$data,true);
			$this->template->full_admin_html_view($content);
        }else{

			if ($_FILES['block_image']['name']) {

				$config['upload_path']          = './my-assets/image/block_image/';
		        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
		        $config['max_size']             = "10024";
		        $config['max_width']            = "0";
		        $config['max_height']           = "0";
		        $config['encrypt_name'] 		= TRUE;

		        $this->load->library('upload', $config);
		        if ( ! $this->upload->do_upload('block_image'))
		        {
		            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
		            redirect(base_url('Cblock'));
		        }
		        else
		        {
		        	$image =$this->upload->data();
		        	$block_image = base_url()."my-assets/image/block_image/".$image['file_name'];
		        }
			}

			$data=array(
				'block_id' 		=> $this->auth->generator(15),
				'block_cat_id' 	=> $this->input->post('block_cat_id'),
				'block_css' 	=> $this->input->post('block_css'),
				'block_position'=> $this->input->post('block_position'),
				'block_style'	=> $this->input->post('block_style'),
				'block_image' 	=> (!empty($block_image)?$block_image:null),
				'status' 		=> 1
				);

			$result=$this->Blocks->block_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-block'])){
					redirect(base_url('Cblock/manage_block'));
				}elseif(isset($_POST['add-block-another'])){
					redirect(base_url('Cblock'));
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect(base_url('Cblock'));
			}
        }
	}
	//Manage block
	public function manage_block()
	{
        $content =$this->lblock->block_list();
		$this->template->full_admin_html_view($content);;
	}
	//block Update Form
	public function block_update_form($block_id)
	{	
		$content = $this->lblock->block_edit_data($block_id);
		$this->template->full_admin_html_view($content);
	}
	// block Update
	public function block_update($block_id=null)
	{

		$this->form_validation->set_rules('block_cat_id', display('category'), 'trim|required');
		$this->form_validation->set_rules('block_position', display('block_position'), 'trim|required');
		$this->form_validation->set_rules('block_style', display('block_style'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_block')
			);
        	$content = $this->parser->parse('block/add_block',$data,true);
			$this->template->full_admin_html_view($content);
        }else{
			if ($_FILES['block_image']['name']) {

				$config['upload_path']          = './my-assets/image/block_image/';
		        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
		        $config['max_size']             = "10024";
		        $config['max_width']            = "0";
		        $config['max_height']           = "0";
		        $config['encrypt_name'] 		= TRUE;

		        $this->load->library('upload', $config);
		        if ( ! $this->upload->do_upload('block_image'))
		        {
		            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
		            redirect(base_url('Cblock'));
		        }
		        else
		        {
		        	$image =$this->upload->data();
		        	$block_image = base_url()."my-assets/image/block_image/".$image['file_name'];
		        }
			}
			$old_image = $this->input->post('old_image');

			$data=array(
				'block_id' 		=> $this->auth->generator(15),
				'block_cat_id' 	=> $this->input->post('block_cat_id'),
				'block_css' 	=> $this->input->post('block_css'),
				'block_position'=> $this->input->post('block_position'),
				'block_style'	=> $this->input->post('block_style'),
				'block_image' 	=> (!empty($block_image)?$block_image:$old_image),
				'status' 		=> 1
				);

			$result=$this->Blocks->update_block($data,$block_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cblock/manage_block');
			}else{
				$this->session->set_userdata(array('error_message'=>display('already_exists')));
				redirect('Cblock/manage_block');
			}
        }
	}
	// block Delete
	public function block_delete($block_id)
	{
		$this->Blocks->delete_block($block_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect('Cblock/manage_block');
	}
	//Inactive
	public function inactive($id){
		$this->db->set('status', 0);
		$this->db->where('block_id',$id);
		$this->db->update('block');
		$this->session->set_userdata(array('error_message'=>display('successfully_inactive')));
		redirect(base_url('Cblock/manage_block'));
	}
	//Active 
	public function active($id){
		$this->db->set('status', 1);
		$this->db->where('block_id',$id);
		$this->db->update('block');
		$this->session->set_userdata(array('message'=>display('successfully_active')));
		redirect(base_url('Cblock/manage_block'));
	}
}
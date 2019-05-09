<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_settings extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//Retrieve Data
	public function retrieve_setting_editdata()
	{
		$this->db->select('*');
		$this->db->from('web_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Submit contact form
	public function submit_contact_form($data)
	{
		$this->db->insert('contact',$data);
		return true;
	}

	//Submit contact form
	public function manage_contact_form()
	{
		$this->db->select('*');
		$this->db->from('contact');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Contact update form
	public function contact_update_form($id)
	{
		$this->db->select('*');
		$this->db->from('contact');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update contact form
	public function update_contact_form($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('contact',$data);
		return true;
	}		

	//Delete contact form
	public function delete_contact($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('contact');
		return true;
	}

	//Setting
	public function setting()
	{
		$this->db->select('*');
		$this->db->from('web_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Map Info
	public function map_info()
	{
		$this->db->select('*');
		$this->db->from('web_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Update web setting form
	public function update_web_settings($id,$data)
	{
		$this->db->where('setting_id',$id);
		$this->db->update('web_setting',$data);
		return true;
	}	

	//Slider entry
	public function slider_entry($data)
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('slider_position',$data['slider_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('slider',$data);
			return TRUE;
		}
	}

	//Slider list
	public function slider_list()
	{
		$this->db->select('*');
		$this->db->from('slider');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Slider edit data
	public function slider_edit_data($id)
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('slider_id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update Slider
	public function update_slider($data,$slider_id)
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('slider_position',$data['slider_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('slider_image',$data['slider_image']);
			$this->db->set('slider_link',$data['slider_link']);
			$this->db->where('slider_id',$slider_id);
			$this->db->update('slider');
			return false;	
		}else{
			$this->db->where('slider_id',$slider_id);
			$this->db->update('slider',$data);
			return true;
		}
	}

	//Insert add
	public function insert_add($data)
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('add_page',$data['add_page']);
		$this->db->where('adv_position',$data['adv_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('advertisement',$data);
			return TRUE;
		}
	}

	//Add list
	public function add_list()
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Slider edit data
	public function add_edit_data($id)
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('adv_id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update Add
	public function update_add($data,$id)
	{

		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('add_page',$data['add_page']);
		$this->db->where('adv_position',$data['adv_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('adv_code',$data['adv_code']);
			$this->db->set('adv_type',$data['adv_type']);
			$this->db->where('adv_id',$id);
			$this->db->update('advertisement');
			return false;	
		}else{
			$this->db->where('adv_id',$id);
			$this->db->update('advertisement',$data);
			return true;
		}
	}
}
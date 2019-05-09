<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Parent List
	public function category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Parent category List
	public function parent_category()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Parent category family List
	public function parent_category_family()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('cat_type',1);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Department List
	public function department_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('nivel',1);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}



	//Family List
	public function family_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('nivel',2);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Sub Family List
	public function subfamily_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('nivel',3);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	/*//family List
	public function family_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('nivel',2);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}*/

	//Son of parent List
	public function son_of_parent_list($parent)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('parent_category_id',$parent);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function son_of_parent_list2($subparent,$parent)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('parent_category_id',$subparent);
		$this->db->where('parent_category_nivel2',$parent);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}

	//Parent category List
	public function parent_category_list($category_id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where_not_in('category_id',$category_id);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Parent category List
	public function family_parent_category_list($category_id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('parent_category_id',$category_id);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Parent category List
	public function subfamily_parent_category_list($category_id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('status',1);
		$this->db->where('parent_category_id',$category_id);
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Category Search Item
	public function category_search_item($category_id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function category_entry($data)
	{
		$this->db->insert('product_category',$data);
		return TRUE;
	}
	//Retrieve customer Edit Data
	public function retrieve_category_editdata($category_id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Categories
	public function update_category($data,$category_id)
	{
		$this->db->where('category_id',$category_id);
		$this->db->update('product_category',$data);
		return true;
	}
	// Delete customer Item
	public function delete_category($category_id)
	{
		$this->db->where('category_id',$category_id);
		$this->db->delete('product_category'); 	
		return true;
	}
}
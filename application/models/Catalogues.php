<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Catalogues extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//unit List
	public function catalogue_list()
	{
		$this->db->select('*');
		$this->db->from('catalogue');
		$this->db->order_by('catalogue_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

    public function product($catalogue_id)
    {

        $query=$this->db->select('
                    catalogue_products.catalogue_product_id,
					product_information.*,
					product_category.category_name,
				')
            ->from('catalogue_products')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left')
            ->join('product_category','product_category.category_id = product_information.category_id','left')
            ->where('catalogue_products.catalogue_id',$catalogue_id)
            ->order_by('product_information.product_name','asc')
            ->group_by('product_information.product_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function products_recomend($store_id)
    {
        $query=$this->db->select('
                    product_information.*')
            ->from('catalogue_products')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->where('store_set.store_id',$store_id)
            ->where('product_information.recomend',2)
            ->order_by('product_information.product_name','asc')
            ->group_by('product_information.product_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function products_new($store_id)
    {
        $query=$this->db->select('
                    product_information.*')
            ->from('catalogue_products')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->where('store_set.store_id',$store_id)
            ->where('product_information.date !=',Null)
            ->order_by('product_information.date','desc')
            ->group_by('product_information.product_id')
            ->limit('30')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function products_ofert($store_id)
    {
        $query=$this->db->select('
                    product_information.*')
            ->from('catalogue_products')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->where('store_set.store_id',$store_id)
            ->where('product_information.onsale',1)
            ->order_by('product_information.date','desc')
            ->group_by('product_information.product_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

	//unit Search Item
	public function unit_search_item($unit_id)
	{
		$this->db->select('*');
		$this->db->from('unit');
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Insert unit
	public function catalogue_entry($data)
	{
        $this->db->select('*');
		$this->db->from('catalogue');
		$this->db->where('catalogue_name',$data['catalogue_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('catalogue',$data);
			return TRUE;
		}
	}

    //Insert unit
    public function catalogue_product_entry($data)
    {
        $this->db->select('*');
        $this->db->from('catalogue_products');
        $this->db->where('catalogue_id',$data['catalogue_id']);
        $this->db->where('product_id',$data['product_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        }else{
            $this->db->insert('catalogue_products',$data);
            return TRUE;
        }
    }

	//Retrieve unit Edit Data
	public function retrieve_catalogue_editdata($catalogue_id)
	{
		$this->db->select('*');
		$this->db->from('catalogue');
		$this->db->where('catalogue_id',$catalogue_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Units
	public function update_catalogue($data,$catalogue_id)
	{
		$this->db->where('catalogue_id',$catalogue_id);
		$result = $this->db->update('catalogue',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete unit Item
	public function delete_catalogue($catalogue_id)
	{
		$this->db->where('catalogue_id',$catalogue_id);
		$this->db->delete('catalogue');
		return true;
	}

    public function catalogue_product_delete($catalogue_product_id)
    {
        $this->db->where('catalogue_product_id',$catalogue_product_id);
        $this->db->delete('catalogue_products');
        return true;
    }
}
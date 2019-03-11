<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//Category product 
	public function category_product($cat_id,$per_page,$page,$store_id)
	{
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id);
        $this->db->where('product_information.category_id',$cat_id);
        $this->db->limit($per_page,$page)
            ->order_by('product_information.product_name','asc')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    //Category product
    public function product_new($per_page,$page,$store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id)
            ->where('product_information.date !=',Null);
        $this->db->limit($per_page,$page)
            ->order_by('product_information.date','desc')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Category product
    public function popular_category()
    {
        $this->db->select('
                product_category.*,
            ')
            ->from('product_category');
        $this->db->where('product_category.nivel',3)
            ->where('product_category.popular',2)
            ->order_by('product_category.category_name','desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Category product
    public function product_new_count($store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id)
            ->where('product_information.date !=',Null)
            ->order_by('product_information.date','desc')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;

    }

    //Category product
    public function product_oferts($per_page,$page,$store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id)
            ->where('product_information.onsale',1);
        $this->db->limit($per_page,$page)
            ->order_by('rand()')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    //Category product
    public function product_oferts_count($store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id)
            ->where('product_information.onsale',1)
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;

    }

    //Category product
    public function product_recomend($per_page,$page,$store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id)
            ->where('product_information.recomend',2);
        $this->db->limit($per_page,$page)
            ->order_by('rand()')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    //Category product
    public function product_recomend_count($store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id)
            ->where('product_information.recomend',2)
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;

    }

	//Category wise product 
	public function category_wise_product($cat_id,$per_page,$page)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('category_id',$cat_id);
		$this->db->limit($per_page,$page);
		$this->db->order_by('product_name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	

	//Category price range product
	public function cat_price_range_pro($min,$max,$cat_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('category_id',$cat_id);
		$this->db->where('price >=', $min);
		$this->db->where('price <=', $max);
		$this->db->order_by('product_name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	

	//Category wise product count
	public function category_wise_product_count($cat_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('category_id',$cat_id);
		$this->db->order_by('product_name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}

	//Select single category  
	public function select_single_category($cat_id)
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		

	//Category product list count
	public function cat_product_list_count($cat_id,$store_id)
	{


        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id);
        $this->db->where('product_information.category_id',$cat_id)
            ->order_by('product_information.product_name','asc')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;

	}


	//Retrive category product
	public function retrieve_category_product($cat_id,$product_name,$store_id,$per_page,$page)
	{
		$this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id);
        if ($cat_id != 'all') {
            $this->db->where('product_information.category_id',$cat_id);
        }
        $this->db->like('product_information.product_name', $product_name, 'both')
            ->limit($per_page,$page)
            ->order_by('product_information.product_name','asc')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        /*echo $query->num_rows();
        die();*/

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
	}

    //Retrive category product
    public function retrieve_category_product_count($cat_id,$product_name,$store_id)
    {
        $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id);
        if ($cat_id != 'all') {
            $this->db->where('product_information.category_id',$cat_id);
        }
        $this->db->like('product_information.product_name', $product_name, 'both')
            ->order_by('product_information.product_name','asc')
            ->group_by('product_information.product_id');
        $query = $this->db->get();

        /*echo $query->num_rows();
        die();*/

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

	//Retrive category product ajax
	public function category_product_search_ajax($cat_id,$product_name,$store_id)
	{

        $this->db->select('
                product_information.*,
            ')
        ->from('catalogue_products')
        ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
        ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left');
        $this->db->where('store_set.store_id',$store_id);
        if ($cat_id != 'all') {
            $this->db->where('product_information.category_id',$cat_id);
        }
        $this->db->like('product_information.product_name', $product_name, 'both')
        ->order_by('product_information.product_name','asc')
        ->group_by('product_information.product_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    //Retrive category product ajax
    public function catalogue_category_product_search_ajax($cat_id,$product_name)
    {
        $this->db->select('*');
		$this->db->from('product_information');
		if ($cat_id != 'all') {
			$this->db->where('category_id',$cat_id);
		}
		$this->db->like('product_name', $product_name, 'both');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
    }

	//Select max value of product
	public function select_max_value_of_pro($cat_id)
	{
		$this->db->select_max('price');
		$this->db->from('product_information');
		$this->db->where('product_information.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		
	//Select min value of product
	public function select_min_value_of_pro($cat_id)
	{
		$this->db->select_min('price');
		$this->db->from('product_information');
		$this->db->where('product_information.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		

	//Select categories product
	public function select_category_product()
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('add_page','category');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//Product info
	public function product_info($p_id)
	{
		$this->db->select('product_information.*,product_category.category_name');
		$this->db->from('product_information');
		$this->db->join('product_category','product_information.category_id = product_category.category_id','LEFT');
		$this->db->where('product_id',$p_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}	
	//Product gallery image
	public function product_gallery_img($p_id)
	{
		$this->db->select('*');
		$this->db->from('image_gallery');
		$this->db->where('product_id',$p_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}

	//Stock Report Single Product
	public function stock_report_single_item($p_id)
	{
		$this->db->select("
				sum(d.quantity) as totalSalesQnty,
				sum(b.quantity) as totalPurchaseQnty,
			");

		$this->db->from('product_information a');
		$this->db->join('product_purchase_details b','b.product_id = a.product_id','left');
		$this->db->join('invoice_details d','d.product_id = a.product_id','left');
		$this->db->join('product_purchase e','e.purchase_id = b.purchase_id','left');
		$this->db->where('a.product_id',$p_id);
		$this->db->order_by('a.product_name','asc');
		$this->db->where(array('a.status'=>1));
		$query = $this->db->get();
		return $query->result();
	}

	//Stock Report By Store
    public function stock_report_single_item_by_store($p_id)
    {

        $result = $this->db->select('*')
            ->from('store_set')
            ->where('default_status','1')
            ->get()
            ->row();
        if ($result) {
            $purchase = $this->db->select("SUM(quantity) as totalPurchaseQnty")
                ->from('product_purchase_details')
                ->where('product_id',$p_id)
                /*->where('store_id',$result->store_id)*/
                ->get()
                ->row();
            /*echo $p_id;
            die();*/
            $sales = $this->db->select("SUM(quantity) as totalSalesQnty")
                ->from('invoice_details')
                ->where('product_id',$p_id)
                /*->where('store_id',$result->store_id)*/
                ->get()
                ->row();

            return $stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;
        }else{
            return "none";
        }
    }

    //Stock Report By Store
    public function store_stock_report_single_item_by_store($p_id,$store_id)
    {

        $result = $this->db->select('*')
            ->from('store_set')
            ->where('store_id',$store_id)
            ->get()
            ->row();
        if ($result) {
            $purchase = $this->db->select("SUM(quantity) as totalPurchaseQnty")
                ->from('product_purchase_details')
                ->where('product_id',$p_id)
                ->where('store_id',$result->store_id)
                ->get()
                ->row();
            /*echo $p_id;
            die();*/
            $sales = $this->db->select("SUM(quantity) as totalSalesQnty")
                //->from('invoice_details')
                ->from('order_details')
                ->where('product_id',$p_id)
                ->where('store_id',$result->store_id)
                ->get()
                ->row();

            return $stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;
        }else{
            return "none";
        }
    }

	//Check variant wise stock
	public function check_variant_wise_stock($variant_id,$product_id)
	{
		$result = $this->db->select('*')
								->from('store_set')
								->where('default_status','1')
								->get()
								->row();

		$purchase = $this->db->select("SUM(quantity) as totalPurchaseQnty")
							->from('product_purchase_details')
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->where('store_id',$result->store_id)
							->get()
							->row();

		$sales = $this->db->select("SUM(quantity) as totalSalesQnty")
						->from('invoice_details')
						->where('product_id',$product_id)
						->where('variant_id',$variant_id)
						->where('store_id',$result->store_id)
						->get()
						->row();

		return $stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;
	}	




	//Category wise related product
	public function related_product($cat_id,$p_id,$store_id)
	{
		/*$query = $this->db->select('*')
							->from('product_information')
							->where('category_id',$cat_id)
							->where_not_in('product_id',$p_id)
							->get()
							->result();
		return $query;*/

        $query = $this->db->select('
                product_information.*,
            ')
            ->from('catalogue_products')
            ->join('store_set', 'store_set.catalogue_id = catalogue_products.catalogue_id','left')
            ->join('product_information', 'product_information.product_id = catalogue_products.product_id','left')
            ->join('product_category', 'product_category.category_id = product_information.category_id','left')
            ->where('product_category.category_id',$cat_id)
            ->where('store_set.store_id',$store_id)
            ->where_not_in('product_information.product_id',$p_id)
            ->get()
            ->result();

        return $query;
    }
}
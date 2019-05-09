<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signups extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

    public function user_exist($email)
    {
        $query = $this->db->select('*')
                ->from('customer_information')
                ->where('customer_email',$email)
                ->get();

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function user($email)
    {
        $query = $this->db->select('*')
            ->from('customer_information')
            ->where('customer_email',$email)
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['customer_id'];
        }
        return false;
    }

    public function valid_code($email,$code)
    {
        $query = $this->db->select('*')
            ->from('customer_information')
            ->where('customer_email',$email)
            ->where('reset_password_code',$code)
            ->get();

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

	//Insert user signup
	public function user_signup($data)
	{
		$result = $this->db->insert('customer_information',$data);
		if ($result) {
			$this->db->select('*');
			$this->db->from('customer_information');
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_customer[] = array('label'=>$row->customer_name,'value'=>$row->customer_id);
			}
			$cache_file ='./my-assets/js/admin_js/json/customer.json';
			$customerList = json_encode($json_customer);
			file_put_contents($cache_file,$customerList);
			return TRUE;	
		}
		return false;
	}

	//public function user_ex

		//Patent Category List
	public function parent_category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('cat_type',1);
		$this->db->where('status',1);
		$this->db->order_by('menu_pos');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Category list
	public function category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Best sales list
	public function best_sales()
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('best_sale','1');
		$this->db->limit('6');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Footer block
	public function footer_block()
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->order_by('position');
		$this->db->limit('4');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}

    public function update_reset_password_code($customer_id,$data)
    {
        $this->db->where('customer_id',$customer_id);
        $this->db->update('customer_information',$data);

        return true;
    }
}
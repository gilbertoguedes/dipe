<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_dashboards extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//Retruve profile data
	public function profile_edit_data()
	{
		$customer_id = $this->session->userdata('customer_id');
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}

    public function edit_profile_send_data($customer_information_send_data_id)
    {
        $this->db->select('*');
        $this->db->from('customer_information_send_data');
        $this->db->where('customer_information_send_data_id',$customer_information_send_data_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function edit_profile_invoice_data($customer_information_invoice_data_id)
    {
        $this->db->select('*');
        $this->db->from('customer_information_invoice_data');
        $this->db->where('customer_information_invoice_data_id',$customer_information_invoice_data_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function admin_profile_send_data()
    {
        $customer_id = $this->session->userdata('customer_id');
        $this->db->select('*');
        $this->db->from('customer_information_send_data');
        $this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function admin_profile_send_data_list_count()
    {
        $customer_id = $this->session->userdata('customer_id');
        $this->db->select('*');
        $this->db->from('customer_information_send_data');
        $this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function admin_profile_send_data_list()
    {
        $customer_id = $this->session->userdata('customer_id');
        $this->db->select('*');
        $this->db->from('customer_information_send_data');
        $this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function customer()
    {
        $customer_id = $this->session->userdata('customer_id');
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function admin_profile_invoice_data_list()
    {
        $customer_id = $this->session->userdata('customer_id');
        $this->db->select('*');
        $this->db->from('customer_information_invoice_data');
        $this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
	//Update Customer Profile
	public function profile_update()
	{
		$this->load->library('upload');
	    if (($_FILES['image']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1024';
            $config['max_width']     = '*';
            $config['max_height']    = '*';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']  = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('customer_dashboard/edit_profile');
            } else {
                $view =$this->upload->data();
                $image=base_url($config['upload_path'].$view['file_name']);
            }
        }

       	$old_image 	 = $this->input->post('old_image');
       	$customer_id = $this->session->userdata('customer_id');

		$data = array(
			'first_name' 		=> $this->input->post('first_name'),
			'last_name'  		=> $this->input->post('last_name'),
			'customer_email'  	=> $this->input->post('email'),
			'customer_mobile'  	=> $this->input->post('customer_mobile'),
			'customer_short_address' => $this->input->post('customer_short_address'),
			'customer_address_1'=> $this->input->post('customer_address_1'),
			'customer_address_2'=> $this->input->post('customer_address_2'),
			'city'  			=> $this->input->post('city'),
			'state'  			=> $this->input->post('state'),
			'country'  			=> $this->input->post('country'),
			'zip'  				=> $this->input->post('zip'),
			'company'  			=> $this->input->post('company'),
			'image'  		    => (!empty($image)?$image:$old_image),
		);

		$this->db->where('customer_id',$customer_id);
		$this->db->update('customer_information',$data);

		return true;
	}

    public function insert_send_data($data)
    {
        $this->db->insert('customer_information_send_data',$data);
        return true;
    }

    public function insert_invoice_data($data)
    {
        $this->db->insert('customer_information_invoice_data',$data);
        return true;
    }

    public function update_send_data($customer_information_send_data_id,$data)
    {
        $this->db->where('customer_information_send_data_id',$customer_information_send_data_id);
        $this->db->update('customer_information_send_data',$data);
        return true;
    }

    public function delete_send_data($customer_information_send_data_id)
    {
        $this->db->where('customer_information_send_data_id',$customer_information_send_data_id);
        $this->db->delete('customer_information_send_data');
        return true;
    }

    public function update_invoice_data($customer_information_invoice_data_id,$data)
    {
        $this->db->where('customer_information_invoice_data_id',$customer_information_invoice_data_id);
        $this->db->update('customer_information_invoice_data',$data);
        return true;
    }

    public function delete_invoice_data($customer_information_invoice_data_id)
    {
        $this->db->where('customer_information_invoice_data_id',$customer_information_invoice_data_id);
        $this->db->delete('customer_information_invoice_data');
        return true;
    }

	//Change Password
	public function change_password($email,$new_password)
	{
		$password 	= md5("gef".$new_password);
        $this->db->where(array('customer_email'=>$email,'status'=>1));
		$query = $this->db->get('customer_information');
		$result =  $query->result_array();
		
		if (count($result) == 1)
		{	
			$this->db->set('password',$password);
			$this->db->where('customer_email',$email);
			$this->db->update('customer_information');

			return true;
		}
		return false;
	}
}
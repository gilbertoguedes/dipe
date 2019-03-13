<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//About info
	public function about_info($page_id)
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->where('page_id',$page_id);
		$this->db->where('language_id',$language);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		

	//About_us Content Info
	public function about_content_info()
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

        $this->db->select('*');
		$this->db->from('about_us');
		$this->db->where('language_id',$language);
		$this->db->order_by('position');
		$this->db->limit('6');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Our Location Content Info
	public function our_location_info()
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

        $this->db->select('*');
		$this->db->from('our_location');
		$this->db->where('language_id',$language);
		$this->db->order_by('position');
		$this->db->limit('2');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//About info
	public function contact_us($page_id)
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->where('page_id',$page_id);
		$this->db->where('language_id',$language);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//About info
	public function submit_contact($data)
	{
		$result = $this->db->insert('contact',$data);
		if ($result) {
			return true;
		}
		return false;
	}

	public function send_mail($to_email, $subject, $message)
	{
		$email_config = Array(
			'protocol'  => $this->config->item('protocol'),
			'smtp_host' => $this->config->item('smtp_host'),
			'smtp_port' => $this->config->item('smtp_port'),
			'smtp_user' => $this->config->item('smtp_user'),
			'smtp_pass' => $this->config->item('smtp_pass'),
			'smtp_crypto'=>$this->config->item('smtp_ssl'),
			'newline'   => "\r\n",
			'mailtype'  => 'html'
			/*'starttls'  => true,
			'newline'   => "\r\n"*/
		);

		$this->load->library('email',$email_config);
		$this->email->from($this->config->item('smtp_user'), 'dipepsa.mx');
        $this->email->to($to_email);
        $this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}

    public function send_mail_file($to_email, $subject, $message, $file_path)
    {
        $email_config = Array(
            'protocol'  => $this->config->item('protocol'),
            'smtp_host' => $this->config->item('smtp_host'),
            'smtp_port' => $this->config->item('smtp_port'),
            'smtp_user' => $this->config->item('smtp_user'),
            'smtp_pass' => $this->config->item('smtp_pass'),
            'smtp_crypto'=>$this->config->item('smtp_ssl'),
            'newline'   => "\r\n",
            'mailtype'  => 'html'
            /*'starttls'  => true,
            'newline'   => "\r\n"*/
        );

        $this->load->library('email',$email_config);
        $this->email->from($this->config->item('smtp_user'), 'dipepsa.mx');
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        for($i=0;$i<count($file_path);$i++)
        {
            $this->email->attach($file_path[$i]);
        }
        $this->email->send();
    }

}
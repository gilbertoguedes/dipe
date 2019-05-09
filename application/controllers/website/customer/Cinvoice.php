<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cinvoice extends CI_Controller {
	
	function __construct() {
      	parent::__construct();
      	$this->load->library('website/customer/linvoice');
      	$this->user_auth->check_customer_auth();
    }

    //Cinvoice default index load
	public function index()
	{
		$content = $this->linvoice->invoice_add_form();
		$this->template->full_customer_html_view($content);
	}

	//Manage invoice 
	public function manage_invoice()
	{	
        $content = $this->linvoice->invoice_list();
		$this->template->full_customer_html_view($content);
	}

	//Retrive right now inserted data to cretae html
	public function invoice_inserted_data($invoice_id)
	{	
		$content = $this->linvoice->invoice_html_data($invoice_id);		
		$this->template->full_customer_html_view($content);
	}
}
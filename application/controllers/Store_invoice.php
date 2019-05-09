<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_invoice extends CI_Controller {
	
	function __construct() {
      	parent::__construct();
      	$this->load->library('lstore_invoice');
      	$this->load->model('Store_invoices');
      	$this->auth->check_store_auth();
    }
    //Default invoice add from loading
	public function index()
	{
		$content = $this->lstore_invoice->invoice_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Add new invoice
	public function new_invoice()
	{
		$content = $this->lstore_invoice->invoice_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Insert new invoice
	public function insert_invoice()
	{
		$invoice_id = $this->Store_invoices->invoice_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		$this->invoice_inserted_data($invoice_id);
	}
	//Manage invoice
	public function manage_invoice()
	{
        $content = $this->lstore_invoice->invoice_list();
		$this->template->full_admin_html_view($content);
	}
	//Invoice Update Form
	public function invoice_update_form($invoice_id)
	{	
		$content = $this->lstore_invoice->invoice_edit_data($invoice_id);
		$this->template->full_admin_html_view($content);
	}
	// Invoice Update
	public function invoice_update()
	{
		$invoice_id = $this->Store_invoices->update_invoice();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		$this->invoice_inserted_data($invoice_id);
	}
	//Retrive right now inserted data to cretae html
	public function invoice_inserted_data($invoice_id)
	{	
		$content = $this->lstore_invoice->invoice_html_data($invoice_id);		
		$this->template->full_admin_html_view($content);
	}

	//POS invoice page load
	public function pos_invoice(){
		$content = $this->lstore_invoice->pos_invoice_add_form();
		$this->template->full_admin_html_view($content);
	}

	//Insert pos invoice
	public function insert_pos_invoice()
	{
		$product_id = $this->input->post('product_id');
		$stok_report = $this->Store_invoices->stock_report_bydate_pos($product_id);

		if ($stok_report > 0 ) {

			$product_details = $this->Store_invoices->get_total_product($product_id);


			$html = "";
			if ($product_details['variant_id']) {
				$exploded = explode(',',$product_details['variant_id']);
				$html .="<option>Select Variant</option>";
		        foreach ($exploded as $elem) {
			        $this->db->select('*');
			        $this->db->from('variant');
			        $this->db->where('variant_id',$elem);
			        $this->db->order_by('variant_name','asc');
			        $result = $this->db->get()->row();

			        $html .="<option value=".$result->variant_id.">".$result->variant_name."</option>";
		    	}
		    }

			$tr 	= " ";
			$order 	= " ";
			$bill 	= " ";
			if (!empty($product_details)){
				$product_id = $this->auth->generator(5);
				$tr .= "<tr id='".$product_id."'>
			            <th id=\"product_name_".$product_id."\">".$product_details['product_name']."</th>

			            <td>
			            	<script>
			            	    $(\"select.form-control:not(.dont-select-me)\").select2({
							        placeholder: \"Select option\",
							        allowClear: true
							    });
			            	</script>
			            	<input type=\"hidden\" class=\"sl\" value=".$product_id.">
			            	<input type=\"hidden\" class=\"product_id_".$product_id."\" value=".$product_details['product_id'].">
				            <select name=\"variant_id[]\" id=\"variant_id_".$product_id."\" class=\"form-control variant_id\" required=\"\" style=\"width: 60px\">".$html."</select>
			            </td>
			            <td width=\"\">
			            	<input type=\"hidden\" class=\"form-control product_id_".$product_id."\" name=\"product_id[]\" value = '".$product_details['product_id']."' id=\"product_id_".$product_id."\"/>

			            	<input type=\"text\" name=\"product_rate[]\" value='".$product_details['price']."' id=\"price_item_".$product_id."\" class=\"price_item".$product_id." form-control text-right\" min=\"0\" readonly=\"readonly\" style=\"width:60px\"/>

			            	<input type=\"hidden\" name=\"available_quantity[]\" id=\"\" class=\"form-control text-right available_quantity_".$product_id."\" value=\"0\" readonly=\"readonly\" />

			            	<input type=\"hidden\" name=\"\" id=\"\" class=\"form-control text-right unit_".$product_id."\" value='".$product_details['unit']."' readonly=\"readonly\" />

			            	<input type=\"hidden\" name=\"discount[]\" id=\"discount_".$product_id."\" class=\"form-control text-right\" value ='".$product_details['discount']."' min=\"0\"/>
			            </td>
			            <td scope=\"row\">
			                <input type=\"number\" name=\"product_quantity[]\" onkeyup=\"quantity_calculate('".$product_id."');\" onchange=\"quantity_calculate('".$product_id."');\" id=\"total_qntt_".$product_id."\" class=\"form-control text-right\" value=\"1\" min=\"1\" style=\"width:50px\"/>
			            </td>
			            <td width=\"\">
			            	<input class=\"total_price form-control text-right\" type=\"text\" name=\"total_price[]\" id=\"total_price_".$product_id."\" value='".$product_details['price']."'  readonly=\"readonly\" style=\"width:70px\"/>
			            </td>

			            <td width:\"300\">";

    $this->db->select('*');
    $this->db->from('tax');
    $this->db->order_by('tax_name','asc');
    $tax_information = $this->db->get()->result();

    if(!empty($tax_information)){
        foreach($tax_information as $k=>$v){
           if ($v->tax_id == 'H5MQN4NXJBSDX4L') {
                $tax['cgst_name']= $v->tax_name; 
                $tax['cgst_id']  = $v->tax_id; 
                $tax['cgst_status']  = $v->status; 
           }elseif($v->tax_id == '52C2SKCKGQY6Q9J'){
                $tax['sgst_name']= $v->tax_name; 
                $tax['sgst_id']  = $v->tax_id; 
                $tax['sgst_status']  = $v->status; 
           }elseif($v->tax_id == '5SN9PRWPN131T4V'){
                $tax['igst_name']   = $v->tax_name; 
                $tax['igst_id']     = $v->tax_id; 
                $tax['igst_status'] = $v->status; 
           }
        }
    }

	if ($tax['cgst_status'] ==1) {

		$tr .="<input type=\"hidden\" id=\"cgst_".$product_id."\" class=\"cgst\" value='".$product_details['cgst_tax']."'/>
		<input type=\"hidden\" id=\"total_cgst_".$product_id."\" class=\"total_cgst\" name=\"cgst[]\" value='".$product_details['cgst_tax'] * $product_details['price']."'/>
		<input type=\"hidden\" name=\"cgst_id[]\" id=\"cgst_id_".$product_id."\" value='".$product_details['cgst_id']."'/>";
	}
	if ($tax['sgst_status'] ==1) { 

		$tr .="<input type=\"hidden\" id=\"sgst_".$product_id."\" class=\"sgst\" value='".$product_details['sgst_tax']."'/>
		<input type=\"hidden\" id=\"total_sgst_".$product_id."\" class=\"total_sgst\" name=\"sgst[]\" value='".$product_details['sgst_tax'] * $product_details['price']."'/>
		<input type=\"hidden\" name=\"sgst_id[]\" id=\"sgst_id_".$product_id."\" value='".$product_details['sgst_id']."'/>";
	}
	if ($tax['igst_status'] ==1) { 

		$tr .= "<input type=\"hidden\" id=\"igst_".$product_id."\" class=\"igst\" value='".$product_details['igst_tax']."'/>
		<input type=\"hidden\" id=\"total_igst_".$product_id."\" class=\"total_igst\" name=\"igst[]\" value='".$product_details['igst_tax'] * $product_details['price']."'/>
		<input type=\"hidden\" name=\"igst_id[]\" id=\"igst_id_".$product_id."\" value='".$product_details['igst_id']."'/>";
	}

						$tr .="<input type=\"hidden\" id=\"total_discount_".$product_id."\" class=\"\" />
							<input type=\"hidden\" id=\"all_discount_".$product_id."\" class=\"total_discount\"/>
	                


			                <a href=\"#\" class=\"ajax_modal btn btn-primary btn-xs m-r-2\" data-toggle=\"modal\" data-target=\"#myModal\"><i class=\"fa fa-pencil\" data-toggle=\"tooltip\" data-placement=\"left\" title='".display('edit')."'></i></a>

			                <a href=\"#\" class=\"btn btn-danger btn-xs\" data-toggle=\"tooltip\" data-placement=\"top\" title='".display('delete')."' onclick=\"deletePosRow('".$product_id."')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>
			            </td>
			        </tr>";

			    $order .= "<tr class='".$product_id."' data-item-id='".$product_id."'>
				                <td>0</td>
				                <td>".$product_details['product_model']."-".$product_details['product_name']."</td>
				                <td id='quantity_".$product_id."'>[ 1 ]</td>
				            </tr>";

	            $bill .= "<tr class='".$product_id."' data-item-id='".$product_id."'>
	            				<td>0</td>
		                        <td colspan=\"2\" class=\"no-border\">".$product_details['product_model']."-".$product_details['product_name']."</td>
		                        <td class='qnt_price_".$product_id."'>(1 x ".$product_details['price'].")</td>
		                        <td style=\"text-align:right;\" class='total_price_bill_".$product_id."'>".$product_details['price']."</td>
		                    </tr>";

		        echo json_encode(array(
		        	'item' 	=> $tr,
		        	'order' => $order,
		        	'bill'	=> $bill,
		        	'product_id' => $product_id
		        ));
	    	}
			else{
				echo json_encode(array(
		        	'item' 	=> 0
		        ));
			}
		}else{
			echo json_encode(array(
	        	'item' 	=> 0
	        ));
		}
	}

	//Insert new customer
	public function insert_customer(){
		$this->load->model('Store_invoices');

		$customer_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'customer_id' 		=> $customer_id,
			'customer_name' 	=> $this->input->post('customer_name'),
			'customer_mobile' 	=> $this->input->post('mobile'),
			'customer_email' 	=> $this->input->post('email'),
			'status' 			=> 1
			);

		$result=$this->Store_invoices->customer_entry($data);
		
		if ($result == TRUE) {		
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			redirect(base_url('Store_invoice/pos_invoice'));
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Store_invoice/pos_invoice'));
		}
	}

	//Retrive right now inserted data to cretae html
	public function pos_invoice_inserted_data($invoice_id)
	{	
		$content = $this->lstore_invoice->pos_invoice_html_data($invoice_id);		
		$this->template->full_admin_html_view($content);
	}
	
	// Retrieve product data
	public function retrieve_product_data()
	{	
		$product_id = $this->input->post('product_id');
		$product_info = $this->Store_invoices->get_total_product($product_id);
		echo json_encode($product_info);
	}

	//Stock report variant wise
	public function stock_report(){
		
		$today 	= date('m-d-Y');

		$from_date   = $this->input->post('from_date')?$this->input->post('from_date'):"";
		$to_date  	 = $this->input->post('to_date')?$this->input->post('to_date'):"";
		$store_id  	 = $this->session->userdata('store_id');

		
		#
        #pagination starts
        #
        $config["base_url"] 	= base_url('Store_invoice/stock_report/');
        $config["total_rows"] 	= $this->Store_invoices->stock_report_variant_bydate_count($from_date,$to_date,$store_id);
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 3;
        $config["num_links"] 	= 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open']  = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']   = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content =$this->lstore_invoice->stock_report_variant_wise($from_date,$to_date,$store_id,$links,$config["per_page"],$page);
		$this->template->full_admin_html_view($content);
	}

	// Invoice Delete
	public function invoice_delete($invoice_id)
	{	
		$result = $this->Store_invoices->delete_invoice($invoice_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Store_invoice/manage_invoice');
		}
	}
	//AJAX INVOICE STOCK Check
	public function product_stock_check($product_id)
	{

		$purchase_stocks = $this->Store_invoices->get_total_purchase_item($product_id);	
		$total_purchase = 0;		
		if(!empty($purchase_stocks)){	
			foreach($purchase_stocks as $k=>$v){
				$total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
			}
		}
		$sales_stocks = $this->Store_invoices->get_total_sales_item($product_id);
		$total_sales = 0;	
		if(!empty($sales_stocks)){	
			foreach($sales_stocks as $k=>$v){
				$total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
			}
		}
		
		$final_total = ($total_purchase - $total_sales);
		return $final_total ;
	}

	//Search product by product name and category
	public function search_product(){
		$product_name = $this->input->post('product_name');
		$category_id  = $this->input->post('category_id');
		$product_search = $this->Store_invoices->product_search($product_name,$category_id);
        if ($product_search) {
            foreach ($product_search as $product) {
            echo "<div class=\"col-xs-6 col-sm-4 col-md-2 col-p-3\">";
                echo "<div class=\"panel panel-bd product-panel select_product\">";
                    echo "<div class=\"panel-body\">";
                        echo "<img src=\"$product->image_thumb\" class=\"img-responsive\" alt=\"\">";
                        echo "<input type=\"hidden\" name=\"select_product_id\" class=\"select_product_id\" value='".$product->product_id."'>";
                    echo "</div>";
                    echo "<div class=\"panel-footer\">$product->product_name - ($product->product_model)</div>";
                echo "</div>";
            echo "</div>";
        	}
        }else{
        	echo "420";
        }
	}

	//Update status
	public function update_status($invoice_id){

		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Soft_settings');

	  	//Update invoice status
		$this->db->set('invoice_status',$this->input->post('invoice_status'));
		$this->db->where('invoice_id',$invoice_id);
		$result = $this->db->update('invoice');
		
		if ($result == TRUE) {		

			$setting_detail = $CI->Soft_settings->retrieve_email_editdata();

			$subject = display("invoice_status");
			$message = $this->input->post('add_note');

		    $config = Array(
		      	'protocol' 		=> $setting_detail[0]['protocol'],
		      	'smtp_host' 	=> $setting_detail[0]['smtp_host'],
		      	'smtp_port' 	=> $setting_detail[0]['smtp_port'],
		      	'smtp_user' 	=> $setting_detail[0]['sender_email'], 
		      	'smtp_pass' 	=> $setting_detail[0]['password'], 
		      	'mailtype' 		=> $setting_detail[0]['mailtype'],
		      	'charset' 		=> 'utf-8'
		    );
		    
		    $CI->load->library('email', $config);
		    $CI->email->set_newline("\r\n");
		    $CI->email->from($setting_detail[0]['sender_email']);
		    $CI->email->to($this->input->post('customer_email'));
		    $CI->email->subject($subject);
		    $CI->email->message($message);

		   	$email = $this->test_input($this->input->post('customer_email'));
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    if($CI->email->send())
			    {
			      	$CI->session->set_userdata(array('message'=>display('email_send_to_customer')));
			      	redirect(base_url('Store_invoice/manage_invoice'));
			    }else{
			     	$CI->session->set_userdata(array('error_message'=> display('email_not_send')));
			     	redirect(base_url('Store_invoice/manage_invoice'));
			    }
			}else{
				$CI->session->set_userdata(array('message'=>display('successfully_updated')));
			    redirect(base_url('Store_invoice/manage_invoice'));
			}
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Store_invoice/manage_invoice'));
		}
	}

	//Email testing for email
	public function test_input($data) {
	  	$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	//Search Inovoice Item
	public function search_inovoice_item()
	{
		$customer_id = $this->input->post('customer_id');
        $content 	 = $this->lstore_invoice->search_inovoice_item($customer_id);
		$this->template->full_admin_html_view($content);
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("1","2","3","4","5","6","7","8","9");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,8);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}
}
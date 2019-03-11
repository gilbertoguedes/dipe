<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cinvoice extends CI_Controller {
	
	function __construct() {
      	parent::__construct();
    }
    //Default invoice add from loading
	public function index()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->invoice_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Add new invoice
	public function new_invoice()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->invoice_add_form();
		$this->template->full_admin_html_view($content);
	}
	//Manage invoice
	public function manage_invoice()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$CI->load->model('Invoices');

        $content = $CI->linvoice->invoice_list();
		$this->template->full_admin_html_view($content);
	}

	//Insert new invoice
	public function insert_invoice()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('Invoices');
		$invoice_id = $CI->Invoices->invoice_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		$this->invoice_inserted_data($invoice_id);
	}
	//Invoice Update Form
	public function invoice_update_form($invoice_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->invoice_edit_data($invoice_id);
		$this->template->full_admin_html_view($content);
	}
	// Invoice Update
	public function invoice_update()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('Invoices');
		$invoice_id = $CI->Invoices->update_invoice();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		$this->invoice_inserted_data($invoice_id);
	}
	//Retrive right now inserted data to cretae html
	public function invoice_inserted_data($invoice_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->invoice_html_data($invoice_id);		
		$this->template->full_admin_html_view($content);
	}

	//POS invoice page load
	public function pos_invoice(){
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->pos_invoice_add_form();
		$this->template->full_admin_html_view($content);
	}

	//Insert pos invoice
	public function insert_pos_invoice()
	{
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->model('Invoices');

		$product_id = $this->input->post('product_id');
		$stok_report = $CI->Invoices->stock_report_bydate_pos($product_id);

		if ($stok_report > 0 ) {

			$product_details = $CI->Invoices->get_total_product($product_id);

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
				            <select name=\"variant_id[]\" id=\"variant_id_".$product_id."\" class=\"form-control variant_id\" required=\"\" style=\"width: 80px\">".$html."</select>
			            </td>
			            <td>
			            	<input type=\"text\" name=\"available_quantity[]\" id=\"\" class=\"form-control text-right available_quantity_".$product_id."\" value=\"0\" readonly=\"readonly\" style=\"width: 60px\"/>
			            </td>
			            <td width=\"\">
			            	<input type=\"hidden\" class=\"form-control product_id_".$product_id."\" name=\"product_id[]\" value = '".$product_details['product_id']."' id=\"product_id_".$product_id."\"/>

			            	<input type=\"text\" name=\"product_rate[]\" value='".$product_details['price']."' id=\"price_item_".$product_id."\" class=\"price_item".$product_id." form-control text-right\" min=\"0\" readonly=\"readonly\" style=\"width:60px\"/>

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
	//Retrive right now inserted data to cretae html
	public function pos_invoice_inserted_data($invoice_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->pos_invoice_html_data($invoice_id);		
		$this->template->full_admin_html_view($content);
	}
	
	// Retrieve product data
	public function retrieve_product_data()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');
		$product_id = $this->input->post('product_id');
		$product_info = $CI->Invoices->get_total_product($product_id);
		echo json_encode($product_info);
	}
	// Invoice Delete
	public function invoice_delete($invoice_id)
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');
		$result = $CI->Invoices->delete_invoice($invoice_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Cinvoice/manage_invoice');
		}
	}
	//AJAX INVOICE STOCK Check
	public function product_stock_check($product_id)
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');

		$purchase_stocks = $CI->Invoices->get_total_purchase_item($product_id);	
		$total_purchase = 0;		
		if(!empty($purchase_stocks)){	
			foreach($purchase_stocks as $k=>$v){
				$total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
			}
		}
		$sales_stocks = $CI->Invoices->get_total_sales_item($product_id);
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
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');
		$product_name = $this->input->post('product_name');
		$category_id  = $this->input->post('category_id');
		$product_search = $this->Invoices->product_search($product_name,$category_id);
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

	//Insert new customer
	public function insert_customer(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');

		$customer_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'customer_id' 		=> $customer_id,
			'customer_name' 	=> $this->input->post('customer_name'),
			'customer_mobile' 	=> $this->input->post('mobile'),
			'customer_email' 	=> $this->input->post('email'),
			'status' 			=> 1
			);

		$result=$this->Invoices->customer_entry($data);
		
		if ($result == TRUE) {		
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			redirect(base_url('Cinvoice/pos_invoice'));
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Cinvoice/pos_invoice'));
		}
	}	

	//Update status
	public function update_status($invoice_id){
		$this->auth->check_admin_auth();
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
			      	redirect(base_url('Cinvoice/manage_invoice'));
			    }else{
			     	$CI->session->set_userdata(array('error_message'=> display('email_not_send')));
			     	redirect(base_url('Cinvoice/manage_invoice'));
			    }
			}else{
				$CI->session->set_userdata(array('message'=>display('successfully_updated')));
			    redirect(base_url('Cinvoice/manage_invoice'));
			}
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Cinvoice/manage_invoice'));
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
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('linvoice');
		
		$customer_id = $this->input->post('customer_id');
        $content = $CI->linvoice->search_inovoice_item($customer_id);
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
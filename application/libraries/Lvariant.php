<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lvariant {
	//Add variant
	public function variant_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Variants');
		$data = array(
				'title' => display('add_variant')
			);
		$customerForm = $CI->parser->parse('variant/add_variant',$data,true);
		return $customerForm;
	}

	//Retrieve  variant List	
	public function variant_list()
	{
		$CI =& get_instance();
		$CI->load->model('Variants');
		$variant_list = $CI->Variants->variant_list(); 

		$i=0;
		if(!empty($variant_list)){	
			foreach($variant_list as $k=>$v){$i++;
			   $variant_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_variant'),
				'variant_list' => $variant_list,
			);
		$customerList = $CI->parser->parse('variant/variant',$data,true);
		return $customerList;
	}

	//variant Edit Data
	public function variant_edit_data($variant_id)
	{
		$CI =& get_instance();
		$CI->load->model('Variants');
		$variant_details = $CI->Variants->retrieve_variant_editdata($variant_id);
	
		$data=array(
			'title' 		=> display('variant_edit'),
			'variant_id' 	=> $variant_details[0]['variant_id'],
			'variant_name' 	=> $variant_details[0]['variant_name'],
			'status' 		=> $variant_details[0]['status']
			);
		$chapterList = $CI->parser->parse('variant/edit_variant',$data,true);
		return $chapterList;
	}
}
?>
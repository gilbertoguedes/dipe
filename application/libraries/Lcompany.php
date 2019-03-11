<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcompany {

	#==============Company list================#
	public function company_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('Companies');
		$company_list = $CI->Companies->company_list($limit,$page);
		$i=$page;
		if(!empty($company_list)){	
			foreach($company_list as $k=>$v){$i++;
			   $company_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_company'),
				'company_list' => $company_list,
				'links' => $links
			);
		$companyList = $CI->parser->parse('company/company',$data,true);
		return $companyList;
	}

	#===============Company edit form==============#
	public function company_edit_data($company_id)
	{
		$CI =& get_instance();
		$CI->load->model('Companies');
		$company_detail = $CI->Companies->retrieve_company_editdata($company_id);
		$data=array(
			'title'			=> display('company_edit'),
			'company_id' 	=> $company_detail[0]['company_id'],
			'company_name' 	=> $company_detail[0]['company_name'],
			'email' 		=> $company_detail[0]['email'],
			'address' 		=> $company_detail[0]['address'],
			'mobile' 		=> $company_detail[0]['mobile'],
			'website' 		=> $company_detail[0]['website'],
			'status' 		=> $company_detail[0]['status']
			);
	
		$companyEdit = $CI->parser->parse('company/edit_company_form',$data,true);
		return $companyEdit;
	}
}
?>
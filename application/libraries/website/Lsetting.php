<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsetting {

	//About us info
	public function about_us($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
        $CI->load->model('Stores');


        $stores = $CI->Stores->store_list();

        $store_default = $CI->Stores->store_default()->store_id;
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);
		$about_content_info 	= $CI->Settings->about_content_info();

		$data = array(
				'title' 		=> display('about_us'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'about_content_info' => $about_content_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
                'stores'        => $stores,
                'store_default' => $store_default
			);
		$HomeForm = $CI->parser->parse('website/about_us',$data,true);
		return $HomeForm;
	}	

	//About us info
	public function user_registered()
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
        $CI->load->model('Stores');
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);
		$about_content_info 	= $CI->Settings->about_content_info();

        $store_default = $CI->Stores->store_default()->store_id;
        $storeId = "";
        if($CI->session->has_userdata('store_id'))
        {
            $storeId = $CI->session->userdata('store_id');
        }
        else
        {
            $storeId = $store_default;
            $CI->session->set_userdata('store_id',$storeId);
        }

        $stores = $CI->Stores->store_list();

		$data = array(
				'title' 		=> display('link_user_registered'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'about_content_info' => $about_content_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
                'stores'        => $stores,
                'store_default' => $store_default
			);
		$HomeForm = $CI->parser->parse('website/user_registered',$data,true);
		return $HomeForm;
	}

	//About us info
	public function activate_user($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);
		$about_content_info 	= $CI->Settings->about_content_info();

		$data = array(
				'title' 		=> display('link_user_registered'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'about_content_info' => $about_content_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('website/user_registered',$data,true);
		return $HomeForm;
	}

	//Delivery info
	public function delivery_info($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('delivery_info'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('website/delivery_info',$data,true);
		return $HomeForm;
	}	

	//Privacy Policy
	public function privacy_policy($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
        $CI->load->model('Stores');

        $stores = $CI->Stores->store_list();

        $store_default = $CI->Stores->store_default()->store_id;

		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('privacy_policy'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
                'stores'        => $stores,
                'store_default' => $store_default
			);
		$HomeForm = $CI->parser->parse('website/privacy_policy',$data,true);
		return $HomeForm;
	}	

	//Terms and condition
	public function terms_condition($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
        $CI->load->model('Stores');

        $stores = $CI->Stores->store_list();

        $store_default = $CI->Stores->store_default()->store_id;
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);


		$data = array(
				'title' 		=> display('terms_condition'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
                'stores'        => $stores,
                'store_default' => $store_default
			);
		$HomeForm = $CI->parser->parse('website/terms_condition',$data,true);
		return $HomeForm;
	}	

	//Help
	public function help($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('help'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('website/help',$data,true);
		return $HomeForm;
	}	

	//Contact us
	public function contact_us()
	{
		$CI =& get_instance();
		$CI->load->model('website/customer/Logins');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$CI->load->model('website/Settings');
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$map_info 				= $CI->web_settings->map_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$our_location_info 		= $CI->Settings->our_location_info();

		$data = array(
				'title' 		=> display('contact_us'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'map_info' 		=> $map_info,
				'our_location_info' => $our_location_info,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('website/contact_us',$data,true);
		return $HomeForm;
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lproduct {

	//Product Details Page Load Here
    public function product_details($p_id)
    {
        $CI =& get_instance();
        $CI->load->model('website/Products_model');
        $CI->load->model('Products');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');

        $pro_category_list 		= $CI->Homes->category_list();
        $parent_category_list 	= $CI->Homes->parent_category_list();
        $best_sales 			= $CI->Homes->best_sales();
        $footer_block 			= $CI->Homes->footer_block();
        $slider_list 			= $CI->web_settings->slider_list();
        $block_list 			= $CI->Blocks->block_list();
        $product_info 			= $CI->Products_model->product_info($p_id);
        /*$product_tax 			= $CI->Products->retrieve_product_editdata($p_id);*/

        $stock_report_single_item 	= $CI->Products_model->stock_report_single_item_by_store($p_id);

        $product_gallery_img 	= $CI->Products_model->product_gallery_img($p_id);
        $category_id 			= $product_info->category_id;
        $product_id 			= $product_info->product_id;

        $related_product 		= $CI->Products_model->related_product($category_id,$product_id);
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $stores = $CI->Stores->store_list();

        $store_default = $CI->Stores->store_default()->store_id;

        $data = array(
            'title' 		=> display('product_details'),
            'category_list' => $parent_category_list,
            'slider_list' 	=> $slider_list,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'product_name' 	=> $product_info->product_name,
            'category_clave' 	=> $product_info->category_clave,
            'product_id' 	=> $product_info->product_id,
            'product_details' => $product_info->product_details,
            'product_model' => $product_info->product_model,
            'type' 			=> $product_info->type,
            'price' 		=> $product_info->price,
            'onsale' 		=> $product_info->onsale,
            'onsale_price' 	=> $product_info->onsale_price,
            /*'product_tax'  => $product_tax[0]['tax_percentage'],*/
            'image_thumb' 	=> $product_info->image_thumb,
            'variant' 		=> $product_info->variants,
            'category_name' => $product_info->category_name,
            'category_id' 	=> $category_id,
            'stok' 			=> $stock_report_single_item,
            'related_product' 		=> $related_product,
            'image_large_details' 	=> $product_info->image_large_details,
            'product_gallery_img' 	=> $product_gallery_img,
            'review' 		=> $product_info->review,
            'description' 	=> $product_info->description,
            'tag' 			=> $product_info->tag,
            'specification' => $product_info->specification,
            'pro_category_list' => $pro_category_list,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'stores'        => $stores,
            'store_default' => $store_default
        );

        $HomeForm = $CI->parser->parse('website/details',$data,true);
        return $HomeForm;
    }

    //Product Details Page Load Here
    public function store_product_details($p_id,$store_id)
    {
        $CI =& get_instance();
        $CI->load->model('website/Products_model');
        $CI->load->model('Products');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');

        $pro_category_list 		= $CI->Homes->category_list();
        $parent_category_list 	= $CI->Homes->parent_category_list();
        $best_sales 			= $CI->Homes->best_sales();
        $footer_block 			= $CI->Homes->footer_block();
        $slider_list 			= $CI->web_settings->slider_list();
        $block_list 			= $CI->Blocks->block_list();
        $product_info 			= $CI->Products_model->product_info($p_id);
        $product_tax 			= $CI->Products->retrieve_product_editdata($p_id);

        $stock_report_single_item 	= $CI->Products_model->store_stock_report_single_item_by_store($p_id,$store_id);

        $product_gallery_img 	= $CI->Products_model->product_gallery_img($p_id);
        $category_id 			= $product_info->category_id;
        $product_id 			= $product_info->product_id;

        $related_product 		= $CI->Products_model->related_product($category_id,$product_id,$store_id);
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $stores = $CI->Stores->store_list();

        $data = array(
            'title' 		=> display('product_details'),
            'category_list' => $parent_category_list,
            'slider_list' 	=> $slider_list,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'product_name' 	=> $product_info->product_name,
            'category_clave' 	=> $product_info->category_clave,
            'product_id' 	=> $product_info->product_id,
            'product_details' => $product_info->product_details,
            'product_model' => $product_info->product_model,
            'type' 			=> $product_info->type,
            'price' 		=> $product_info->price,
            'onsale' 		=> $product_info->onsale,
            'onsale_price' 	=> $product_info->onsale_price,
            'product_tax'  => $product_tax[0]['tax_percentage'],
            'image_thumb' 	=> $product_info->image_thumb,
            'variant' 		=> $product_info->variants,
            'category_name' => $product_info->category_name,
            'category_id' 	=> $category_id,
            'stok' 			=> $stock_report_single_item,
            'related_product' 		=> $related_product,
            'image_large_details' 	=> $product_info->image_large_details,
            'product_gallery_img' 	=> $product_gallery_img,
            'review' 		=> $product_info->review,
            'description' 	=> $product_info->description,
            'tag' 			=> $product_info->tag,
            'specification' => $product_info->specification,
            'pro_category_list' => $pro_category_list,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'stores'        => $stores
        );

        $HomeForm = $CI->parser->parse('website/details',$data,true);
        return $HomeForm;
    }
}
?>
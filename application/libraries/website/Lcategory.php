<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcategory {

	//Category product
	public function category_product($cat_id,$links,$per_page,$page,$store_id,$stores,$store_default)
	{
		$CI =& get_instance();
		$CI->load->model('website/Categories');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
        $CI->load->model('Stores');

        $category_product= $CI->Categories->category_product($cat_id,$per_page,$page,$store_id);
		$category 		= $CI->Categories->select_single_category($cat_id);
		$categoryList 	= $CI->Homes->parent_category_list();
		$pro_category_list= $CI->Homes->category_list();
		$best_sales 	= $CI->Homes->best_sales();
		$footer_block 	= $CI->Homes->footer_block();
		$block_list 	= $CI->Blocks->block_list(); 
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();

		$data = array(
				'title' 		=> "Productos",
				'category_product' => $category_product,
				'pro_category_list' => $pro_category_list,
				'category_list' => $categoryList,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'category_name' => $category[0]['category_name'],
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
				'links' 		=> $links,
                'stores'        => $stores,
                'store_default' => $store_default
			);
		$HomeForm = $CI->parser->parse('website/category',$data,true);
		return $HomeForm;
	}


    public function product_new($links,$per_page,$page,$store_id,$stores,$store_default)
    {
        $CI =& get_instance();
        $CI->load->model('website/Categories');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');

        $category_product= $CI->Categories->product_new($per_page,$page,$store_id);
        $categoryList 	= $CI->Homes->parent_category_list();
        $pro_category_list= $CI->Homes->category_list();
        $best_sales 	= $CI->Homes->best_sales();
        $footer_block 	= $CI->Homes->footer_block();
        $block_list 	= $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $data = array(
            'title' 		=> "Nuevos Productos",
            'category_product' => $category_product,
            'pro_category_list' => $pro_category_list,
            'category_list' => $categoryList,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'category_name' => "Nuevos Productos",
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'links' 		=> $links,
            'stores'        => $stores,
            'store_default' => $store_default
        );
        $HomeForm = $CI->parser->parse('website/category',$data,true);
        return $HomeForm;
    }

    public function all_category($store_id,$stores,$store_default)
    {
        $CI =& get_instance();
        $CI->load->model('website/Categories');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');

        $categoryList 	= $CI->Homes->parent_category_list();
        $pro_category_list= $CI->Homes->category_list();
        $best_sales 	= $CI->Homes->best_sales();
        $footer_block 	= $CI->Homes->footer_block();
        $block_list 	= $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $data = array(
            'title' 		=> "Categorías",
            /*'category_product' => $category_product,*/
            'pro_category_list' => $pro_category_list,
            'category_list' => $categoryList,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'category_name' => "Categorías",
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'stores'        => $stores,
            'store_default' => $store_default
        );
        $HomeForm = $CI->parser->parse('website/all_category',$data,true);
        return $HomeForm;
    }

    public function popular_category($store_id,$stores,$store_default)
    {
        $CI =& get_instance();
        $CI->load->model('website/Categories');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');


        $popular_category = $CI->Categories->popular_category();
        $categoryList 	= $CI->Homes->parent_category_list();
        $pro_category_list= $CI->Homes->category_list();
        $best_sales 	= $CI->Homes->best_sales();
        $footer_block 	= $CI->Homes->footer_block();
        $block_list 	= $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $data = array(
            'title' 		=> "Categorías Populares",
            'popular_category' => $popular_category,
            'pro_category_list' => $pro_category_list,
            'category_list' => $categoryList,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'category_name' => "Categorías Populares",
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'stores'        => $stores,
            'store_default' => $store_default
        );

        $HomeForm = $CI->parser->parse('website/popular_category',$data,true);
        return $HomeForm;
    }

    public function product_oferts($links,$per_page,$page,$store_id,$stores,$store_default)
    {
        $CI =& get_instance();
        $CI->load->model('website/Categories');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');

        $category_product= $CI->Categories->product_oferts($per_page,$page,$store_id);
        $categoryList 	= $CI->Homes->parent_category_list();
        $pro_category_list= $CI->Homes->category_list();
        $best_sales 	= $CI->Homes->best_sales();
        $footer_block 	= $CI->Homes->footer_block();
        $block_list 	= $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $data = array(
            'title' 		=> "En Ofertas",
            'category_product' => $category_product,
            'pro_category_list' => $pro_category_list,
            'category_list' => $categoryList,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'category_name' => "En Ofertas",
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'links' 		=> $links,
            'stores'        => $stores,
            'store_default' => $store_default
        );
        $HomeForm = $CI->parser->parse('website/category',$data,true);
        return $HomeForm;
    }

    public function product_recomend($links,$per_page,$page,$store_id,$stores,$store_default)
    {
        $CI =& get_instance();
        $CI->load->model('website/Categories');
        $CI->load->model('website/Homes');
        $CI->load->model('web_settings');
        $CI->load->model('Soft_settings');
        $CI->load->model('Blocks');
        $CI->load->model('Stores');

        $category_product= $CI->Categories->product_recomend($per_page,$page,$store_id);
        $categoryList 	= $CI->Homes->parent_category_list();
        $pro_category_list= $CI->Homes->category_list();
        $best_sales 	= $CI->Homes->best_sales();
        $footer_block 	= $CI->Homes->footer_block();
        $block_list 	= $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
        $languages 				= $CI->Homes->languages();
        $currency_info 			= $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();

        $data = array(
            'title' 		=> "Recomendaciones",
            'category_product' => $category_product,
            'pro_category_list' => $pro_category_list,
            'category_list' => $categoryList,
            'block_list' 	=> $block_list,
            'best_sales' 	=> $best_sales,
            'footer_block' 	=> $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' 	=> $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
            'category_name' => "Recomendaciones",
            'currency' 		=> $currency_details[0]['currency_icon'],
            'position' 		=> $currency_details[0]['currency_position'],
            'links' 		=> $links,
            'stores'        => $stores,
            'store_default' => $store_default
        );
        $HomeForm = $CI->parser->parse('website/category',$data,true);
        return $HomeForm;
    }

	//Category wise product
	public function category_wise_product($cat_id,$links,$per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model('website/Categories');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');

		$category_wise_product 	= $CI->Categories->category_wise_product($cat_id,$per_page,$page);
		$category 		= $CI->Categories->select_single_category($cat_id);

		$categoryList 	= $CI->Homes->parent_category_list();
		$best_sales 	= $CI->Homes->best_sales();
		$footer_block 	= $CI->Homes->footer_block();
		$block_list 	= $CI->Blocks->block_list(); 
		$pro_category_list= $CI->Homes->category_list();
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$max_value = $CI->Categories->select_max_value_of_pro($cat_id);
		$min_value = $CI->Categories->select_min_value_of_pro($cat_id);
		$select_category_product = $CI->Categories->select_category_product();

		$data = array(
				'title' 		=> display('category_wise_product'),
				'category_wise_product' => $category_wise_product,
				'category_name' => $category[0]['category_name'],
				'category_id' => $category[0]['category_id'],
				'category_list' => $categoryList,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'pro_category_list' => $pro_category_list,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'select_category_product' => $select_category_product,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'max_value' 	=> $max_value[0]['price'],
				'min_value' 	=> $min_value[0]['price'],
				'category_name' => $category[0]['category_name'],
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
				'links' 		=> $links,
			);
		$HomeForm = $CI->parser->parse('website/category_product',$data,true);
		return $HomeForm;
	}
	
	//Retrieve  category List	
	public function category_list()
	{
		$CI =& get_instance();
		$CI->load->model('website/Categories');
		$category_list = $CI->Categories->category_list();  //It will get only Credit categorys
		$i=0;
		$total=0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
			   $category_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' 		=> 'Categories List',
				'category_list' => $category_list,
			);
		$categoryList = $CI->parser->parse('category/category',$data,true);
		return $categoryList;
	}

	//category Edit Data
	public function category_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('website/Categories');
		$category_detail = $CI->Categories->retrieve_category_editdata($category_id);
		$data=array(
			'category_id' 	=> $category_detail[0]['category_id'],
			'category_name' => $category_detail[0]['category_name'],
			'status' 		=> $category_detail[0]['status']
			);
		$chapterList = $CI->parser->parse('category/edit_category_form',$data,true);
		return $chapterList;
	}	
	//Category product search
	public function category_product_search($cat_id,$product_name,$storeId,$links,$per_page,$page,$stores,$store_default)
	{
        $CI =& get_instance();
		$CI->load->model('website/Categories');
		$CI->load->model('website/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
        $CI->load->model('Stores');

        $category_product = $CI->Categories->retrieve_category_product($cat_id,$product_name,$storeId,$per_page,$page);

		$category 		= $CI->Categories->select_single_category($cat_id);
		$categoryList 	= $CI->Homes->parent_category_list();
		$best_sales 	= $CI->Homes->best_sales();
		$footer_block 	= $CI->Homes->footer_block();
		$block_list 	= $CI->Blocks->block_list(); 
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$pro_category_list= $CI->Homes->category_list();

		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();

		if ($cat_id == 'all') {
			$category_name =  "ALL";
		}else{
			$category_name = $category[0]['category_name'];
		}

        $data = array(
				'title' 		=> display('category_product_search'),
				'category_product' => $category_product,
				'category_list' => $categoryList,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'pro_category_list' => $pro_category_list,
				'category_name' => $category_name,
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
                'stores' => $stores,
                'store_default' => $store_default,
                'links' => $links
			);


		$categoryList = $CI->parser->parse('website/category',$data,true);
		return $categoryList;
	}
}
?>
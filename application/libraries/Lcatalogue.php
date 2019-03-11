<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcatalogue {
	//Add unit
	public function catologue_add_form()
	{
        $CI =& get_instance();
		$CI->load->model('Catalogues');
		$data = array(
				'title' => display('catalogue_unit')
			);
		$customerForm = $CI->parser->parse('catalogue/add_catalogue',$data,true);
		return $customerForm;
	}

	//Retrieve unit List	
	public function catalogue_list()
	{
		$CI =& get_instance();
		$CI->load->model('Catalogues');
        $catalogue_list = $CI->Catalogues->catalogue_list();

        $i=0;
		if(!empty($catalogue_list)){
			foreach($catalogue_list as $k=>$v){$i++;
                $catalogue_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_catalogue'),
				'catalogue_list' => $catalogue_list,
                'category_department_list' => $category_department_list
			);
		$customerList = $CI->parser->parse('catalogue/catalogue',$data,true);
		return $customerList;
	}

    public function product($catalogue_id)
    {
        $CI =& get_instance();
        $CI->load->model('Catalogues');
        $CI->load->model('Categories');
        $product_list = $CI->Catalogues->product($catalogue_id);
        $category_department_list 	=	$CI->Categories->department_list();

        $i=0;
        if(!empty($product_list)){
            foreach($product_list as $k=>$v){$i++;
                $product_list[$k]['sl']=$i;
            }
        }

        $data = array(
            'title' => "Productos del Catálogo",
            'catalogue_list' => $product_list,
            'category_department_list' => $category_department_list,
            'catalogue_id' => $catalogue_id,
            'product_list' => $product_list
        );
        $customerList = $CI->parser->parse('catalogue/product',$data,true);
        return $customerList;
    }

	//unit Edit Data
	public function catalogue_edit_data($catalogue_id)
	{
		$CI =& get_instance();
		$CI->load->model('Catalogues');
		$catalogue_details = $CI->Catalogues->retrieve_catalogue_editdata($catalogue_id);

		$data=array(
			'title' 		=> display('catalogue_edit'),
			'catalogue_id' 		=> $catalogue_details[0]['catalogue_id'],
			'catalogue_name' 	=> $catalogue_details[0]['catalogue_name'],
			'catalogue_short_name' 	=> $catalogue_details[0]['catalogue_short_name'],
            'catalogue_description' 	=> $catalogue_details[0]['catalogue_description'],
			);
		$chapterList = $CI->parser->parse('catalogue/edit_catalogue',$data,true);
		return $chapterList;
	}
}
?>
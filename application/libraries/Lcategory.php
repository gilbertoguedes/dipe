<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcategory {
	//Retrieve  category List	
	public function category_list()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_list = $CI->Categories->category_list(); 
		$total=0;
		$i = 0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
			   $category_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_category'),
				'category_list' => $category_list,
				
			);
		$categoryList = $CI->parser->parse('category/category',$data,true);
		return $categoryList;
	}

	//Retrieve  category department List	
	public function category_list_department()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_list = $CI->Categories->department_list();
		$total=0;
		$i = 0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
			   $category_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_category_department'),
				'category_list' => $category_list,
				
			);
		$categoryList = $CI->parser->parse('category/category_department',$data,true);
		return $categoryList;
	}

	//Retrieve  category family List	
	public function category_list_family()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_list = $CI->Categories->family_list();
		$total=0;
		$i = 0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
			   $category_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_category_family'),
				'category_list' => $category_list,
				
			);
		$categoryList = $CI->parser->parse('category/category_family',$data,true);
		return $categoryList;
	}

	//Retrieve  category sub family List	
	public function category_list_subfamily()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_list = $CI->Categories->subfamily_list();
		$total=0;
		$i = 0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
			   $category_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_category_subfamily'),
				'category_list' => $category_list,
				
			);
		$categoryList = $CI->parser->parse('category/category_subfamily',$data,true);
		return $categoryList;
	}


	//Category Add
	public function category_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$parent_category = $CI->Categories->parent_category();

		$data = array(
				'title' => display('add_category'),
				'category_list' => $parent_category
			);
		$categoryForm = $CI->parser->parse('category/add_category_form',$data,true);
		return $categoryForm;
	}

	//Category Department Add
	public function category_department_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$parent_category = $CI->Categories->parent_category();

		$data = array(
				'title' => display('add_category_department')
			);
		$categoryForm = $CI->parser->parse('category/add_category_department_form',$data,true);
		return $categoryForm;
	}

	//Category Department Add
	public function category_family_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$parent_category_family = $CI->Categories->parent_category_family();

		$data = array(
				'title' => display('add_category_family'),
				'category_family_list' => $parent_category_family
			);
		$categoryForm = $CI->parser->parse('category/add_category_family_form',$data,true);
		return $categoryForm;
	}

	//Category Department Add
	public function category_subfamily_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_department_list = $CI->Categories->parent_category_family();

		$data = array(
				'title' => display('add_category_subfamily'),
				'category_department_list' => $category_department_list
			);
		$categoryForm = $CI->parser->parse('category/add_category_subfamily_form',$data,true);
		return $categoryForm;
	}

	//Category Department Edit Data
	public function category_department_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_detail = $CI->Categories->retrieve_category_editdata($category_id);
		$parent_category_list = $CI->Categories->parent_category_list($category_id);


		$data=array(
			'title'			=> display('category_edit'),
			'category_id' 	=> $category_detail[0]['category_id'],
			'category_name' => $category_detail[0]['category_name'],
			'menu_pos' 		=> $category_detail[0]['menu_pos'],
			'status' 		=> $category_detail[0]['status'],
			'top_menu' 		=> $category_detail[0]['top_menu'],
			'cat_image' 	=> $category_detail[0]['cat_image'],
			'cat_favicon' 	=> $category_detail[0]['cat_favicon'],
			'category_clave' => $category_detail[0]['category_clave']
			);
		$categoryEdit = $CI->parser->parse('category/edit_category_department_form',$data,true);
		return $categoryEdit;
	}

	//Category Family Edit Data
	public function category_family_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_detail = $CI->Categories->retrieve_category_editdata($category_id);
		$parent_category_family_list = $CI->Categories->parent_category_family($category_id);


		$data=array(
			'title'			=> display('category_edit'),
			'category_id' 	=> $category_detail[0]['category_id'],
			'category_name' => $category_detail[0]['category_name'],
			'menu_pos' 		=> $category_detail[0]['menu_pos'],
			'status' 		=> $category_detail[0]['status'],
			'top_menu' 		=> $category_detail[0]['top_menu'],
			'cat_image' 	=> $category_detail[0]['cat_image'],
			'cat_favicon' 	=> $category_detail[0]['cat_favicon'],
			'parent_category_family_id' => $category_detail[0]['parent_category_id'],
			'category_family_list'	=> $parent_category_family_list,
			'category_clave' => $category_detail[0]['category_clave']
			);
		$categoryEdit = $CI->parser->parse('category/edit_category_family_form',$data,true);
		return $categoryEdit;
	}

	//Category Family Edit Data
	public function category_subfamily_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_detail = $CI->Categories->retrieve_category_editdata($category_id);
		$category_department_list = $CI->Categories->department_list();
		/*Get list of family*/
		$parent_category = $CI->Categories->retrieve_category_editdata($category_detail[0]['parent_category_id']);
		$son_of_parent = $CI->Categories->son_of_parent_list($parent_category[0]['parent_category_id']);
		/**/
		/*Get list of apartment*/
		$department_list = $CI->Categories->department_list();
		$parent_department = $category_detail[0]['parent_category_nivel2'];
		/**/


		$data=array(
			'title'			=> display('category_edit'),
			'category_id' 	=> $category_detail[0]['category_id'],
			'category_name' => $category_detail[0]['category_name'],
			'menu_pos' 		=> $category_detail[0]['menu_pos'],
			'status' 		=> $category_detail[0]['status'],
			'top_menu' 		=> $category_detail[0]['top_menu'],
			'cat_image' 	=> $category_detail[0]['cat_image'],
			'cat_favicon' 	=> $category_detail[0]['cat_favicon'],
			'category_clave' => $category_detail[0]['category_clave'],
			'parent_category_family_id' => $category_detail[0]['parent_category_id'],
			'parent_category_family_list'	=> $son_of_parent,
			'department_list' => $department_list,
			'parent_department' => $parent_department,
            'popular'           => $category_detail[0]['popular'],
			);
		$categoryEdit = $CI->parser->parse('category/edit_category_subfamily_form',$data,true);
		return $categoryEdit;
	}

	//Category Edit Data
	public function category_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('Categories');
		$category_detail = $CI->Categories->retrieve_category_editdata($category_id);
		$parent_category_list = $CI->Categories->parent_category_list($category_id);


		$data=array(
			'title'			=> display('category_edit'),
			'category_id' 	=> $category_detail[0]['category_id'],
			'category_name' => $category_detail[0]['category_name'],
			'menu_pos' 		=> $category_detail[0]['menu_pos'],
			'status' 		=> $category_detail[0]['status'],
			'top_menu' 		=> $category_detail[0]['top_menu'],
			'cat_image' 	=> $category_detail[0]['cat_image'],
			'cat_favicon' 	=> $category_detail[0]['cat_favicon'],
			'parent_category_id' => $category_detail[0]['parent_category_id'],
			'category_list'	=> $parent_category_list,
			);
		$categoryEdit = $CI->parser->parse('category/edit_category_form',$data,true);
		return $categoryEdit;
	}

	

}
?>
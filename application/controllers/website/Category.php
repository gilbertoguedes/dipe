<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller {

	function __construct() {
      	parent::__construct();
		$this->load->library('website/Lcategory');
		$this->load->model('website/Categories');
        $this->load->model('Stores');
    }

	//Default loading for Home Index.
	// public function index()
	// {
	// 	$content = $this->lcategory->category_product();
	// 	$this->template->full_website_html_view($content);
	// }	

	//Single category product

    //Category wise product search.
    public function category_product_search()
    {
       // echo $store_id;die();

        $cat_id         = $this->input->post('category_id');
        $product_name   = $this->input->post('product_name');
        $store_id   = $this->input->post('store_id');

        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;

        #
        #pagination starts
        #
        $config["base_url"] 	= base_url('category_product_search');
        $config["total_rows"] 	= $this->Categories->retrieve_category_product_count($cat_id,$product_name,$store_id);
        $config["per_page"] 	= 100;
        $config["uri_segment"] 	= 2;
        $config["num_links"] 	= 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #

        $content        = $this->lcategory->category_product_search($cat_id,$product_name,$store_id,$links,$config["per_page"],$page,$stores,$store_default);
        $this->template->full_website_html_view($content);
    }

    public function category_product_search_url($store_id,$product_name,$cat_id)
    {
        /*$cat_id         = $this->input->post('category_id');
        $product_name   = $this->input->post('product_name');
        $store_id   = $this->input->post('store_id');*/
        $config["base_url"] 	= base_url('category_product_search_url/'.$store_id.'/'.$product_name.'/'.$cat_id);
        if($product_name=="all_products")
        {
            $product_name = '';
        }
        else
        {
            $product_name = str_replace("%20"," ",$product_name);
        }

        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;

        #
        #pagination starts
        #
        //echo $product_name;die();
        $config["total_rows"] 	= $this->Categories->retrieve_category_product_count($cat_id,$product_name,$store_id);
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 5;
        $config["num_links"] 	= 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #

        $content        = $this->lcategory->category_product_search($cat_id,$product_name,$store_id,$links,$config["per_page"],$page,$stores,$store_default);
        $this->template->full_website_html_view($content);
    }


    public function category_product($cat_id)
	{
        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;


        if($this->session->has_userdata('store_id'))
        {
            $store_id = $this->session->userdata('store_id');
        }
        else
        {
            $store_id = $store_default;
            $this->session->set_userdata('store_id',$store_id);
        }

        #
        #pagination starts
        #
        $config["base_url"] 	= base_url('category/'.$cat_id);
        $config["total_rows"] 	= $this->Categories->cat_product_list_count($cat_id,$store_id);
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 3;
        $config["num_links"] 	= 5; 
	    /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Anterior';
        $config['next_link'] = 'Siguiente';
        $config['last_link'] = 'Último';
        $config['first_link'] = 'Primero';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lcategory->category_product($cat_id,$links,$config["per_page"],$page,$store_id,$stores,$store_default);
		$this->template->full_website_html_view($content);
	}

    public function product_new()
    {
        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;


        if($this->session->has_userdata('store_id'))
        {
            $store_id = $this->session->userdata('store_id');
        }
        else
        {
            $store_id = $store_default;
            $this->session->set_userdata('store_id',$store_id);
        }

        #
        #pagination starts
        #
        $config["base_url"] 	= base_url('product_new');
        $config["total_rows"] 	= ($this->Categories->product_new_count($store_id)<=100) ? $this->Categories->product_new_count($store_id):100;
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 2;
        $config["num_links"] 	= 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Anterior';
        $config['next_link'] = 'Siguiente';
        $config['last_link'] = 'Último';
        $config['first_link'] = 'Primero';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #
        $content = $this->lcategory->product_new($links,$config["per_page"],$page,$store_id,$stores,$store_default);
        $this->template->full_website_html_view($content);
    }

    public function all_category()
    {
        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;


        if($this->session->has_userdata('store_id'))
        {
            $store_id = $this->session->userdata('store_id');
        }
        else
        {
            $store_id = $store_default;
            $this->session->set_userdata('store_id',$store_id);
        }

        $content = $this->lcategory->all_category($store_id,$stores,$store_default);
        $this->template->full_website_html_view($content);

    }

    public function popular_category()
    {
        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;


        if($this->session->has_userdata('store_id'))
        {
            $store_id = $this->session->userdata('store_id');
        }
        else
        {
            $store_id = $store_default;
            $this->session->set_userdata('store_id',$store_id);
        }

        $content = $this->lcategory->popular_category($store_id,$stores,$store_default);
        $this->template->full_website_html_view($content);

    }

    public function product_oferts()
    {
        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;


        if($this->session->has_userdata('store_id'))
        {
            $store_id = $this->session->userdata('store_id');
        }
        else
        {
            $store_id = $store_default;
            $this->session->set_userdata('store_id',$store_id);
        }

        #
        #pagination starts
        #
        $config["base_url"] 	= base_url('product_oferts');
        $config["total_rows"] 	= $this->Categories->product_oferts_count($store_id);
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 2;
        $config["num_links"] 	= 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Anterior';
        $config['next_link'] = 'Siguiente';
        $config['last_link'] = 'Último';
        $config['first_link'] = 'Primero';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #
        $content = $this->lcategory->product_oferts($links,$config["per_page"],$page,$store_id,$stores,$store_default);
        $this->template->full_website_html_view($content);
    }

    public function product_recomend()
    {
        $stores = $this->Stores->store_list();

        $store_default = $this->Stores->store_default()->store_id;


        if($this->session->has_userdata('store_id'))
        {
            $store_id = $this->session->userdata('store_id');
        }
        else
        {
            $store_id = $store_default;
            $this->session->set_userdata('store_id',$store_id);
        }

        #
        #pagination starts
        #
        $config["base_url"] 	= base_url('product_recomend');
        $config["total_rows"] 	= $this->Categories->product_recomend_count($store_id);
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 2;
        $config["num_links"] 	= 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Anterior';
        $config['next_link'] = 'Siguiente';
        $config['last_link'] = 'Último';
        $config['first_link'] = 'Primero';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #
        $content = $this->lcategory->product_recomend($links,$config["per_page"],$page,$store_id,$stores,$store_default);
        $this->template->full_website_html_view($content);
    }

	//Category wise product
	public function category_wise_product($cat_id)
	{
		#
        #pagination starts
        #
        $config["base_url"] 	    = base_url('category_product/'.$cat_id);
        $config["total_rows"] 	    = $this->Categories->category_wise_product_count($cat_id);
        $config["per_page"] 	    = 16;
        $config["uri_segment"] 	    = 3;
        $config["num_links"] 	    = 5; 
	    /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] 	= "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] 	= "</ul>";
        $config['num_tag_open'] 	= "<li class='page-item'>";
        $config['num_tag_close'] 	= '</li>';
        $config['cur_tag_open'] 	= "<li class='page-item'><a href='#'>";
        $config['cur_tag_close'] 	= "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] 	= "<li class='page-item'>";
        $config['next_tag_close'] 	= "</li>";
        $config['prev_tag_open'] 	= "<li class='page-item'>";
        $config['prev_tagl_close'] 	= "</li>";
        $config['first_tag_open'] 	= "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] 	= "<li class='page-item'>";
        $config['last_tagl_close'] 	= "</li>";
        $config['prev_link'] 		= 'Previous';
        $config['next_link'] 		= 'Next';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  

		$content = $this->lcategory->category_wise_product($cat_id,$links,$config["per_page"],$page);
		$this->template->full_website_html_view($content);
	}

	//Category and price range product
	public function category_price_wise_product(){

		$this->load->model('Soft_settings');
		$min = $this->input->post('new_min');
		$max = $this->input->post('new_max');
		$category_id = $this->input->post('category_id');

		$cat_price_range_pro = $this->Categories->cat_price_range_pro($min,$max,$category_id);
		$currency_details = $this->Soft_settings->retrieve_currency_info();

		$currency = $currency_details[0]['currency_icon'];
		$position = $currency_details[0]['currency_position'];

        //Currency wise price change
        $default_currency_id =  $this->session->userdata('currency_id');
        $currency_new_id     =  $this->session->userdata('currency_new_id');

        if (empty($currency_new_id)) {
            $result  =  $cur_info = $this->db->select('*')
                                ->from('currency_info')
                                ->where('default_status','1')
                                ->get()
                                ->row();
            $currency_new_id = $result->currency_id;
        }

        if (!empty($currency_new_id)) {
            $cur_info = $this->db->select('*')
                                ->from('currency_info')
                                ->where('currency_id',$currency_new_id)
                                ->get()
                                ->row();

            $target_con_rate = $cur_info->convertion_rate;
            $position1 = $cur_info->currency_position;
            $currency1 = $cur_info->currency_icon;
        }
        //Currency wise price change

		$html = "";
		if ($cat_price_range_pro) {
			foreach ($cat_price_range_pro as $product) {

			$html.="<div class=\"col-lg-3 col-sm-6 single_product_item\">
                    <div class=\"item item_category\">
                        <div class=\"item_inner\">
                            <div class=\"item_image\">
	                            <a href='".base_url('product_details/'.$product->product_id)."'>
	                                <img src='".$product->image_thumb."' alt=\"product-image\">
	                            </a>
                            </div>
                            <div class=\"item_info\">
                                <h6>$product->product_name</h6>
                                <div class=\"rating_area\">
                                    <div class=\"rate-container\">";
                                                                      
                                    $result = $this->db->select('sum(rate) as rates')
                                                        ->from('product_review')
                                                        ->where('product_id',$product->product_id)
                                                        ->get()
                                                        ->row();

                                    $rater = $this->db->select('rate')
                                                        ->from('product_review')
                                                        ->where('product_id',$product->product_id)
                                                        ->get()
                                                        ->num_rows();

                                    if ($result->rates != null) {
                                        $total_rate = $result->rates/$rater;
                                        if (gettype($total_rate) == 'integer') {
                                            for ($t=1; $t <= $total_rate; $t++) {
                                               $html .="<i class=\"fa fa-star\"></i>";
                                            }
                                            for ($tt=$total_rate; $tt < 5; $tt++) { 
                                                $html .="<i class=\"fa fa-star-o\"></i>";
                                            }
                                        }elseif (gettype($total_rate) == 'double') {
                                            $pieces = explode(".", $total_rate);
                                            for ($q=1; $q <= $pieces[0]; $q++) {
                                               $html .="<i class=\"fa fa-star\"></i>";
                                               if ($pieces[0] == $q) {
                                                   $html .="<i class=\"fa fa-star-half-o\"></i>";
                                                   for ($qq=$pieces[0]; $qq < 4; $qq++) { 
                                                        $html .="<i class=\"fa fa-star-o\"></i>";
                                                    }
                                               }
                                            }

                                        }else{
                                            for ($w=0; $w <= 4; $w++) {
                                               $html .="<i class=\"fa fa-star-o\"></i>";
                                            }
                                        }
                                    }else{
                                        for ($o=0; $o <= 4; $o++) {
                                           $html .="<i class=\"fa fa-star-o\"></i>";
                                        }
                                    }
                                
                                $html.="</div>";
                            $html.="</div>";

                            if ($product->onsale == 1 && !empty($product->onsale_price)) {
                            $html.="<div class=\"product_cost\">";
                                $html.="<p class=\"current\">";
                                    if ($target_con_rate > 1) {
                                        $price = $product->onsale_price * $target_con_rate;
                                        $html.=(($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $product->onsale_price * $target_con_rate;
                                        $html.=(($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }
                                $html.="</p>";

                                $html.="<p class=\"previous\">";

                                    if ($target_con_rate > 1) {
                                        $price = $product->price * $target_con_rate;
                                        $html.=(($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $product->price * $target_con_rate;
                                        $html.=(($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }
                                $html.="</p>";
                            $html.="</div>";

                            }else{

                            $html.="<div class=\"product_cost\">
                                    <p class=\"current\">";
                                        if ($target_con_rate > 1) {
                                            $price = $product->price * $target_con_rate;
                                                $html.= (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                            }

                                        if ($target_con_rate <= 1) {
                                            $price = $product->price * $target_con_rate;
                                            $html.= (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        } 
                                $html.="</p>
                                </div>";
                            }

                        $html.="</div>
                            <div class=\"item_hover\">
                                <ul class=\"nav\">
                                    <li>
                                        <a href=\"#\" class=\"wishlist\" name='".$product->product_id."'><i class=\"fa fa-heart\"></i></a>
                                    </li>
                                    <li>
                                        <a href=".$product->image_thumb." data-lightbox=\"image-1\"><i class=\"fa fa-search\"></i></a>
                                    </li>
                                    <li>
                                        <a href=".base_url('category_product/'.$product->category_id)."><i class=\"fa fa-arrows\"></i></a>
                                    </li>
                                </ul>
                                <div class=\"addtocard\">
                                    <form action=\"\" method=\"post\">";

                                    $html .="<input type=\"hidden\" id=\"sst\" value=\"1\">";
                                        
                                    $html .="<a href=".base_url('product_details/'.$product->product_id)."><button type=\"button\" class=\"cart_button\">".display("add_to_cart")."</button></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
			}
			echo @$html;
		}
	}



    //Category wise product search by ajax.
	public function category_product_search_ajax()
	{
		$category_id 	= $this->input->post('category_id');
		$product_name 	= $this->input->post('product_name');
		$product_info   = $this->Categories->category_product_search_ajax($category_id,$product_name);

        if(!empty($product_info)) {
            echo "<style>";
            if (count($product_info) < 8) {
                echo ".scrollbar{float: left;height: auto;overflow-y: scroll;}.force-overflow{
                min-height: auto;}";
            }else{
                echo ".scrollbar{float: left;height: 250px;overflow-y: scroll;}.force-overflow{
                min-height: 250px;}";
            }
            echo "#style-1::-webkit-scrollbar-track{
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-radius: 0;
                background-color: #F5F5F5;
            }
            #style-1::-webkit-scrollbar{
                width: 5px;
                background-color: #F5F5F5;
            }

            #style-1::-webkit-scrollbar-thumb{
                border-radius: 0;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #00a652;
            }</style>";
            echo  '<ul class="search_results_inner force-overflow">';
            $i=1;
            foreach ($product_info as $value) {
            echo '<li class="single_results"><a href="'.base_url().'product_details/'.$value->product_id.'">'.$value->product_name.' ('.$value->product_model.')</a></li>';
            }
            echo '<ul>';
        }
	}

	//Submit a subcriber.
	public function add_subscribe()
	{
		$data=array(
			'subscriber_id' => $this->generator(15),
			'apply_ip' 		=> $this->input->ip_address(),
			'email' 		=> $this->input->post('sub_email'),
			'status' 		=> 1
		);

		$result=$this->Subscribers->subscriber_entry($data);

		if ($result) {
			echo "2";
		}else{
			echo "3";
		}
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,34);
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


    //Category wise product search by ajax.
    public function catalogue_category_product_search_ajax()
    {
        $category_id 	= $this->input->post('category_id');
        $catalogue_id 	= $this->input->post('catalogue_id');
        $product_name 	= $this->input->post('product_name');
        $product_info   = $this->Categories->catalogue_category_product_search_ajax($category_id,$product_name);

        if(!empty($product_info)) {
            echo "<style>";
            if (count($product_info) < 8) {
                echo ".scrollbar{float: left;height: auto;overflow-y: scroll;}.force-overflow{
                min-height: auto;}";
            }else{
                echo ".scrollbar{float: left;height: 250px;overflow-y: scroll;}.force-overflow{
                min-height: 250px;}";
            }
            echo "#style-1::-webkit-scrollbar-track{
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-radius: 0;
                background-color: #F5F5F5;
            }
            #style-1::-webkit-scrollbar{
                width: 5px;
                background-color: #F5F5F5;
            }

            #style-1::-webkit-scrollbar-thumb{
                border-radius: 0;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #00a652;
            }</style>";
            echo  '<ul class="search_results_inner force-overflow">';
            $i=1;
            foreach ($product_info as $value) {
                echo '<li class="single_results"><a href="'.base_url().'Ccatalogue/catalogue_add_product/'.$catalogue_id.'/'.$value->product_id.'">'.$value->product_name.'</a></li>';
            }
            echo '<ul>';
        }
    }

}
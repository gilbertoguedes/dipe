<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $CI->load->model('Companies');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
    $company_info  = $CI->Companies->company_list();
?>
<!--====== Header Area ======-->
<header>
    <!-- Main Header Area -->
    <div class="header_main">
        <div class="container">
            <nav class="navbar navbar-toggleable-md row m0 navbar-light">
                <button class="navbar-toggler navbar-toggler-right" id="open">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="<?php echo base_url()?>">
                    <img src="<?php if (isset($Web_settings[0]['logo'])) {echo $Web_settings[0]['logo']; }?>">
                </a>
                <div class="navbar-collapse justify-content-end" id="navbarNavDropdown">
					<!--<?php if ( $this->user_auth->is_logged()) { ?>
                    <div class="hidden-md-down">
                        <h4><?php echo display('welcome'); ?> : <?php echo $this->session->userdata('customer_name'); ?></h4>
                    </div>
					<?php } ?>-->
                    <!--========= Account Box start =========-->
                    <?php if (! $this->user_auth->is_logged()) { ?>
					<div class="account_area hidden-md-down">
                        <a href="#" class="account_btn" data-toggle="modal" data-target="#login_box"><i class="fa fa-user-o"></i></a>
                        <div class="modal fade" id="login_box" >
                            <div class="modal-dialog">
                                <a class="hiddenanchor" id="toregister"></a>
                                <a class="hiddenanchor" id="tologin"></a>
                                <div id="login_inner">
                                    <div id="login" class="animate form">
                                        <h2 class="box_heading"><?php echo display('login')?></h2>

                                        <form action="<?php echo base_url('do_login')?>" method="post">

                                            <div class="input_area"> 
                                                <label for="email" class="uname" data-icon="u" >
                                                    <i class="fa fa-envelope"></i>
                                                </label>
                                                <input type="email" placeholder="<?php echo display('email')?>" name="email" required id="email" value="<?php echo $this->session->userdata('customer_email')?>">
                                            </div>

                                            <div class="input_area"> 
                                                <label for="password" class="youpasswd" data-icon="p"> <i class="fa fa-lock"></i></label>
                                               <input type="password" placeholder="<?php echo display('password')?>" name="password" required>
                                            </div>
                                        <!--     <div class="forgetpw"> 
                                                <a href="#"><?php echo display('i_have_forgot_my_password')?></a>
                                            </div> -->
                                            <div class="login_btn"> 
                                                <input type="submit" value="<?php echo display('login')?>">
                                            </div>
                                            <div class="change_link">
                                                <?php echo display('not_a_member_yet')?>
                                                <a href="signup" class="to_register"><?php echo display('sign_up')?></a>
                                            </div>

                                        </form>
                                    </div>

                                    <div id="register" class="animate form">
                                        <h2 class="box_heading"><?php echo display('sign_up')?></h2> 
                                        <form action="<?php echo base_url('user_signup')?>" method="post"> 
                                            <div class="input_area"> 
                                                <label for="usernamesignup" class="uname" data-icon="u"><i class="fa fa-user"></i></label>
                                                <input type="text" name="first_name" placeholder="<?php echo display('first_name')?>" required>
                                            </div>
                                            <div class="input_area"> 
                                                <label for="emailsignup" class="youmail" data-icon="e" ><i class="fa fa-user"></i></label>
                                                <input type="text" name="last_name" placeholder="<?php echo display('last_name')?>" required>
                                            </div>
                                            <div class="input_area"> 
                                                <label for="passwordsignup" class="youpasswd" data-icon="p"><i class="fa fa-envelope"></i></label>
                                                <input type="email" name="email" placeholder="<?php echo display('email')?>" required>
                                            </div>
                                            <div class="input_area"> 
                                                <label for="password" class="youpasswd" data-icon="p"><i class="fa fa-lock"></i></label>
                                                <input type="password" name="password" placeholder="<?php echo display('password')?>" required>
                                            </div>
                                            <div class="login_btn"> 
                                                <input type="submit" value="<?php echo display('sign_up')?>"> 
                                            </div>
                                            <div class="change_link">  
                                                <?php echo display('already_a_member')?>
                                                <a href="#tologin" class="to_register"><?php echo display('login')?></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
					<?php } ?>

                    <!--========= Cart Box start =========-->
                    <div class="dropdown cart_area tab_up_cart" id="tab_up_cart">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" id="search-form">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="cart-text"><?php echo (($position==0)?$currency.' '.number_format($this->cart->total(), 2, '.', ','):number_format($this->cart->total(), 2, '.', ',').' '.$currency)?></span>
                            <span class="badge badge-notify my-cart-badge"><?php echo $this->cart->total_items()?></span>
                        </a>
                        <ul class="cart-box dropdown-menu">
                            <li class="cart-header">
                                <h4><?php echo display('you_have').' '.$this->cart->total_items().' '.display('items_in_your_cart')?></h4>
                            </li>

                            <?php
                            if ($this->cart->contents()) {
                                foreach ($this->cart->contents() as $items): ?>
                            <li class="cart-content">
                                <div class="img-box">
                                    <img src="<?php echo $items['options']['image']?>" alt="Awesome Image">
                                </div>
                                <div class="content">
                                    <h4><?php echo $items['name']; ?></h4>
                                    <h6><?php echo (($position==0)?$currency.' '.$this->cart->format_number($items['price']):$this->cart->format_number($items['price']).' '.$currency) ?></h6>
                                </div>

                                <div class="delete_box">
                                    <a href="#" class="delete_cart_item" name="<?php echo $items['rowid']?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </li>
                            <?php endforeach; }?>
                            <?php if ($this->cart->contents()) { ?>
                            <li class="cart-footer clearfix">
                                <div class="total-price">
                                    <h4><?php echo display('total_price')?>: <span><?php echo (($position==0)?$currency.' '.number_format($this->cart->total(), 2, '.', ','):number_format($this->cart->total(), 2, '.', ',').' '.$currency)?></span></h4>
                                </div>
                                <div class="checkout-box">
                                    <a href="<?php echo base_url('checkout')?>"><?php echo display('checkout')?></a>
                                </div>
                                <!-- View cart -->
                                <div class="checkout-box" style="margin-top: 5px">
                                    <a href="<?php echo base_url('view_cart')?>"><?php echo display('view_cart')?></a>
                                </div>
                            </li>
                            <?php  } ?>
                        </ul>
                    </div>
					
					
                    <!--========= Cart Box ENd =========-->
					
					<?php if ( $this->user_auth->is_logged()) { ?>
                    <div class="logout_area hidden-md-down">
                        <a href="<?php echo base_url().'customer/customer_dashboard'?>">
                        <i class="fa fa-lock">
                        </i>
                        <span class="logout_text"><?php echo display('admin_dashboard') ?></span>
                        </a>
                    </div>
					<?php } ?>
					
					<?php if ( $this->user_auth->is_logged()) { ?>
                    <div class="logout_area hidden-md-down">
                        <a href="<?php echo base_url('logout')?>">
                        <i class="fa fa-sign-out">
                        </i>
                        <span class="logout_text"><?php echo display('logout') ?></span>
                        </a>
                    </div>
					<?php } ?>
					
				</div>
				



                <!--========= Mobile Menu =========-->
                <div class="mobilemenu">
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" id="close">
                            <i class="fa fa-close"></i>
                        </a>
                        <ul class="nav flex-column">
                            <?php
                            if ($category_list) {
                                foreach ($category_list as $parent_category) {
                                $sub_parent_cat =  $this->db->select('*')
                                                        ->from('product_category')
                                                        ->where('parent_category_id',$parent_category->category_id)
                                                        ->order_by('menu_pos')
                                                        ->get()
                                                        ->result();
                            ?>
                            <li class="menu-item menu-toggle">
                                <a class="menu-link" href="#"><?php echo $parent_category->category_name; if ($sub_parent_cat) {echo "<i class=\"fa fa-angle-down\"></i>";}?> </a>
                                <?php if ($sub_parent_cat) { ?>
                                <ul class="dropdown-menu">
                                    <?php foreach ($sub_parent_cat as $sub_p_cat) {
                                        $sub_category =  $this->db->select('*')
                                                        ->from('product_category')
                                                        ->where('parent_category_id',$sub_p_cat->category_id)
                                                        ->order_by('menu_pos')
                                                        ->get()
                                                        ->result();
                                    ?>
                                    <li class="menu-item menu-toggle">
                                        <a class="menu-link"  href="#"><?php echo $sub_p_cat->category_name; if ($sub_category) {echo "<i class=\"fa fa-angle-down\"></i>";}?> </a>
                                        <?php if ($sub_category) { ?>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($sub_category as $sub_cat) { ?>
                                            <li><a href="#"><?php echo $sub_cat->category_name?></a></li>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </li>
                            <?php
                                }
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <!--======= ENd Mobile Menu =========-->
            </nav>
        </div>
    </div>

    <!-- header bottom start -->
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 hidden-md-down">
                    <div class="dropdown category_menu  <?php if($this->uri->segment(1) == 'home'){echo "show";} ?>">
                        <div class="dropdown-toggle menu_part" <?php if($this->uri->segment(1) == 'category' || $this->uri->segment(1) == 'product_details' || $this->uri->segment(1) == 'category_product' || $this->uri->segment(1) == 'category_product_search' || $this->uri->segment(1) == 'checkout' || $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'signup'|| $this->uri->segment(1) == 'about_us' || $this->uri->segment(1) == 'delivery_info' ||  $this->uri->segment(1) == 'privacy_policy'  || $this->uri->segment(1) == 'terms_condition' || $this->uri->segment(1) == 'help' || $this->uri->segment(1) == 'contact_us' || $this->uri->segment(1) == 'view_cart' ){echo "data-toggle='dropdown'";} ?>>
                        <span><?php echo display('category')?></span><i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="dropdown-menu">
                            <ul>
                                <?php
                                /*var_dump($category_list);*/
                                if ($category_list) {
                                    foreach ($category_list as $parent_category) {
                                        $sub_parent_cat =  $this->db->select('*')
                                            ->from('product_category')
                                            ->where('parent_category_id',$parent_category->category_id)
                                            ->order_by('menu_pos')
                                            ->get()
                                            ->result();
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('category/'.$parent_category->category_id)?>" class="<?php if($sub_parent_cat){echo "cat_menu_link";}else{echo "dropdown-item";}?>">
                                                <i><img src="<?php echo $parent_category->cat_favicon?>" height="20"></i> <?php echo $parent_category->category_name?></a>
                                            <?php
                                            if ($sub_parent_cat){
                                                ?>
                                                <div class="row m0 cat_sub_menu">
                                                    <?php
                                                    if ($sub_parent_cat) {
                                                        foreach ($sub_parent_cat as $parent_cat) {
                                                            ?>
                                                            <div class="col-sm-4">
                                                                <p><a href="<?php echo base_url('category/'.$parent_cat->category_id)?>"><?php echo $parent_cat->category_name?></a></p>
                                                                <?php
                                                                $sub_cat =  $this->db->select('*')
                                                                    ->from('product_category')
                                                                    ->where('parent_category_id',$parent_cat->category_id)
                                                                    ->order_by('menu_pos')
                                                                    ->get()
                                                                    ->result();
                                                                if ($sub_cat) {
                                                                    foreach ($sub_cat as $s_p_cat) {
                                                                        ?>
                                                                        <a href="<?php echo base_url('category/'.$s_p_cat->category_id)?>"><?php echo $s_p_cat->category_name?></a>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            <?php } ?>
                                        </li>
                                    <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- category bar start -->
                    <div class="header-search">
                        <?php
                        $storeId = "";

                        if($this->session->has_userdata('store_id'))
                        {
                            $storeId = $this->session->userdata('store_id');
                        }
                        else
                        {
                            $storeId = $store_default;
                            $this->session->set_userdata('store_id',$storeId);
                        }

                        ?>
                        <label><?php echo "Tienda" ?></label>
                        <select name="store_id" id="select_store">
                            <?php if ($stores) {
                                foreach ($stores as $sto) {
                                    ?>
                                    <?php if($sto['store_id'] == $storeId){  ?>
                                    <option selected value="<?php echo $sto['store_id']?>"><?php echo $sto['store_name']?></option>
                                    <?php }else{  ?>
                                    <option value="<?php echo $sto['store_id']?>"><?php echo $sto['store_name']?></option>
                                    <?php } ?>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5">
                    <!-- category bar start -->
                    <div class="header-search">
                        <?php echo form_open('category_product_search') ?>
                        <select name="category_id" id="select_category">
                            <option value="all"><?php echo display('all_categories')?></option>
                            <?php if ($pro_category_list) {
                                foreach ($pro_category_list as $pr_cat_list) {
                            ?>
                            <option value="<?php echo $pr_cat_list['category_id']?>"><?php echo $pr_cat_list['category_name']?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>

                        <input type="text" name="product_name" id="product_name" value="" required="" placeholder="<?php echo display('search_product_name_here')?>">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        <div class="search_results scrollbar" id="style-1"></div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header bottom end -->
</header>
<!--===== End Header Area =======-->

    <style type="text/css">
        input.loading {
            background: #fff url(<?php echo base_url('assets/website/image/resize.gif')?>) no-repeat center !important;
        }
    </style>

    <script type="text/javascript">



        /*$( "#select_store").selectmenu({
            width: 250,
            icons: { button: "ui-icon-caret-1-s" }

        });*/


        
        //Product search by product name
        /*$('body').on('keyup', '#product_name', function() {

            var product_name = $('#product_name').val();
            var category_id  = $('#select_category').val();

            //Product name check
            if (product_name == 0) {
                $('.search_results').html(' ');
                return false;
            }
            
            $.ajax({
                type: "post",
                async: false,
                url: '<?php echo base_url('website/Category/category_product_search_ajax')?>',
                data: {product_name: product_name,category_id:category_id},
                beforeSend: function(){
                    $('#product_name').addClass('loading');
                },
                success: function(data) {
                    $('#product_name').removeClass('loading');
                    if (data) {
                        $('.search_results').html(data);
                    }
                },
                error: function() {
                    alert('Request Failed, Please check your code and try again!');
                }
            });*/
        });
    </script>

<!-- Product delete from cart by ajax -->
<script type="text/javascript">
    $('body').on('click', '.delete_cart_item', function() {
        var row_id  = $(this).attr('name');
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/delete_cart/')?>',
            data: {row_id:row_id},
            success: function(data) {
                $("#tab_up_cart").load(location.href+" #tab_up_cart>*","");
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });  
</script>
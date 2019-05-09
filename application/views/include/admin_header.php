<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
    $CI =& get_instance();
    $CI->load->model('Soft_settings');
    $CI->load->model('Reports');
    $CI->load->model('Users');
    $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
    $users         = $CI->Users->profile_edit_data();
    $out_of_stock  = $CI->Reports->out_of_stock_count();
?>
<!-- Admin header end -->
<header class="main-header"> 
    <a href="<?php echo base_url('home')?>" class="logo"> <!-- Logo -->
        <span class="logo-mini">
            <!--<b>A</b>BD-->
            <img src="<?php if (isset($Soft_settings[0]['favicon'])) {
               echo $Soft_settings[0]['favicon']; }?>" alt="">
        </span>
        <span class="logo-lg">
            <!--<b>Admin</b>BD-->
            <img src="<?php if (isset($Soft_settings[0]['logo'])) {
               echo $Soft_settings[0]['logo']; }?>" alt="">
        </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
            <span class="sr-only">Toggle navigation</span>
            <span class="pe-7s-keypad"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="<?php echo base_url('Creport/out_of_stock')?>" >
                        <i class="pe-7s-attention" title="<?php echo display('out_of_stock')?>"></i>
                        <span class="label label-danger"><?php echo $out_of_stock?></span>
                    </a>
                </li>

                <!-- settings -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('Admin_dashboard/edit_profile')?>"><i class="pe-7s-users"></i><?php echo display('user_profile') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/change_password_form')?>"><i class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/logout')?>"><i class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
	<!-- sidebar -->
	<div class="sidebar">
	    <!-- Sidebar user panel -->
	    <!--<div class="user-panel text-center">
	        <div class="image">
	            <img src="<?php echo $users[0]['logo']?>" class="img-circle" alt="User Image">
	        </div>
	        <div class="info">
	            <p><?php echo $users[0]['first_name']." ".$users[0]['last_name']?></p>
	            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo display('online') ?></a>
	        </div>
	    </div>-->
	    <!-- sidebar menu -->
	    <ul class="sidebar-menu">

	        <li class="<?php if ($this->uri->segment('1') == ("")) { echo "active";}else{ echo " ";}?>">
	            <a href="<?php echo base_url('Admin_dashboard')?>"><i class="ti-dashboard"></i> <span><?php echo display('dashboard') ?></span>
	                <span class="pull-right-container">
	                    <span class="label label-success pull-right"></span>
	                </span>
	            </a>
	        </li>

            <?php if ($this->session->userdata('user_type') == 1 || $this->session->userdata('user_type') == 2) { ?>

            <!-- Supplier menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Csupplier")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-user"></i><span><?php echo display('supplier') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Csupplier')?>"><?php echo display('add_supplier') ?></a></li>
                    <li><a href="<?php echo base_url('Csupplier/manage_supplier')?>"><?php echo display('manage_supplier') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Csupplier/supplier_ledger_report')?>"><?php echo display('supplier_ledger') ?></a></li>-->
                </ul>
            </li>
            <!-- Supplier menu end -->

            <!-- Wearhouse set menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Cwearhouse")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-target"></i><span><?php echo display('wearhouse') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cwearhouse')?>"><?php echo display('wearhouse_add') ?></a></li>
                    <li><a href="<?php echo base_url('Cwearhouse/manage_wearhouse')?>"><?php echo display('manage_wearhouse') ?></a></li>
                </ul>
            </li>-->
            <!-- Wearhouse set menu end -->

            <!-- Category menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Ccategory")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-tag"></i><span><?php echo display('category') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <!--<li><a href="<?php echo base_url('Ccategory')?>"><?php echo display('add_category') ?></a></li>-->
                    <!--<li><a href="<?php echo base_url('Ccategory/add_category_department')?>"><?php echo display('add_category_department') ?></a></li>
            <li><a href="<?php echo base_url('Ccategory/add_category_family')?>"><?php echo display('add_category_family') ?></a></li>
            <li><a href="<?php echo base_url('Ccategory/add_category_subfamily')?>"><?php echo display('add_category_subfamily') ?></a></li>-->
                    <!--<li><a href="<?php echo base_url('Ccategory/add_category_csv')?>"><?php echo display('import_category_csv') ?></a></li>-->
                    <li><a href="<?php echo base_url('Ccategory/manage_category_department')?>"><?php echo display('manage_category_department') ?></a></li>
                    <li><a href="<?php echo base_url('Ccategory/manage_category_family')?>"><?php echo display('manage_category_family') ?></a></li>
                    <li><a href="<?php echo base_url('Ccategory/manage_category_subfamily')?>"><?php echo display('manage_category_subfamily') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Ccategory/manage_category')?>"><?php echo display('manage_category') ?></a></li>-->
                </ul>
            </li>
            <!-- Category menu end -->

            <!-- Catalogue menu start -->
                <li class="treeview <?php if ($this->uri->segment('1') == ("Ccatalogue")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="ti-target"></i><span><?php echo display('catalogue') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('Ccatalogue')?>"><?php echo display('add_catalogue') ?></a></li>
                        <li><a href="<?php echo base_url('Ccatalogue/manage_catalogue')?>"><?php echo display('manage_catalogue') ?></a></li>
                    </ul>
                </li>
                <!-- Unit menu end -->

            <!-- Unit menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cunit")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-ruler-pencil"></i><span><?php echo display('Unit') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cunit')?>"><?php echo display('add_unit') ?></a></li>
                    <li><a href="<?php echo base_url('Cunit/manage_unit')?>"><?php echo display('manage_unit') ?></a></li>
                </ul>
            </li>
            <!-- Unit menu end -->

            <!-- Product menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cproduct")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-bag"></i><span><?php echo display('product') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>

                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cproduct')?>"><?php echo display('add_product') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Cproduct/add_product_csv')?>"><?php echo display('import_product_csv') ?></a></li>-->
                    <li><a href="<?php echo base_url('Cproduct/manage_product')?>"><?php echo display('manage_product') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Cproduct/product_details_single')?>"><?php echo display('product_ledger') ?></a></li>-->
                </ul>
            </li>
            <!-- Product menu end -->

            <!-- Purchase menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cpurchase")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cpurchase')?>"><?php echo display('add_purchase') ?></a></li>
                    <li><a href="<?php echo base_url('Cpurchase/manage_purchase')?>"><?php echo display('manage_purchase') ?></a></li>
                </ul>
            </li>
            <!-- Purchase menu end -->

            <!-- Customer menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Ccustomer")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <!--<li><a href="<?php echo base_url('Ccustomer')?>"><?php echo display('add_customer') ?></a></li>-->
                    <li><a href="<?php echo base_url('Ccustomer/manage_customer')?>"><?php echo display('manage_customer') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Ccustomer/customer_ledger_report')?>"><?php echo display('customer_ledger') ?></a></li>-->
                    <!-- <li><a href="<?php echo base_url('Ccustomer/credit_customer')?>"><?php echo display('credit_customer') ?></a></li>
                <li><a href="<?php echo base_url('Ccustomer/paid_customer')?>"><?php echo display('paid_customer') ?></a></li> -->
                </ul>
            </li>
            <!-- Customer menu end -->

            <!-- Invoice menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('2') == ("new_invoice") || $this->uri->segment('2') == ("manage_invoice") || $this->uri->segment('2') == ("invoice_update_form")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-layout-accordion-list"></i><span><?php echo display('invoice') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cinvoice/new_invoice')?>"><?php echo display('new_invoice') ?></a></li>
                    <li><a href="<?php echo base_url('Cinvoice/manage_invoice')?>"><?php echo display('admin_manage_invoice') ?></a></li>
                </ul>
            </li>-->
            <!-- Invoice menu end -->

            <!-- POS invoice menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('2') == ("pos_invoice")) { echo "active";}else{ echo " ";}?>">
                <a href="<?php echo base_url('Cinvoice/pos_invoice')?>" target="_blank">
                    <i class="ti-layout-tab-window"></i><span><?php echo display('pos_invoice') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>-->
            <!-- POS invoice menu end -->

            <!-- Quotation menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Cquotation")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-bag"></i><span><?php echo display('quotation') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cquotation/new_quotation')?>"><?php echo display('new_quotation') ?></a></li>
                    <li><a href="<?php echo base_url('Cquotation/manage_quotation')?>"><?php echo display('manage_quotation') ?></a></li>
                </ul>
            </li>-->
            <!-- Quotation menu end -->

            <!-- Order menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Corder")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-truck"></i><span><?php echo display('order') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Corder/new_order')?>"><?php echo display('new_order') ?></a></li>
                    <li><a href="<?php echo base_url('Corder/manage_order')?>"><?php echo display('admin_manage_order') ?></a></li>
                </ul>
            </li>
            <!-- Order menu end -->

            <!-- Stock menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Creport")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-bar-chart"></i><span><?php echo display('stock') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Creport')?>"><?php echo display('stock_report') ?></a></li>
                    <li><a href="<?php echo base_url('Creport/stock_report_supplier_wise')?>"><?php echo display('stock_report_supplier_wise') ?></a></li>
                    <li><a href="<?php echo base_url('Creport/stock_report_product_wise')?>"><?php echo display('stock_report_product_wise') ?></a></li>
                    <li><a href="<?php echo base_url('Creport/stock_report_store_wise')?>"><?php echo display('stock_report_store_wise') ?></a></li>
                </ul>
            </li>
            <!-- Stock menu end -->

            <!-- Report menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('2') == ("retrieve_dateWise_SalesReports") || $this->uri->segment('2') == ("todays_sales_report")|| $this->uri->segment('2') == ("todays_purchase_report") || $this->uri->segment('2') == ("transfer_report") || $this->uri->segment('2') == ("product_sales_reports_date_wise") || $this->uri->segment('2') == ("total_profit_report") || $this->uri->segment('2') == ("retrieve_dateWise_profit_report") || $this->uri->segment('2') == ("tax_report_product_wise") || $this->uri->segment('2') == ("tax_report_invoice_wise") || $this->uri->segment('2') == ("store_to_store_transfer") || $this->uri->segment('2') == ("store_to_warehouse_transfer") || $this->uri->segment('2') == ("warehouse_to_warehouse_transfer") || $this->uri->segment('2') == ("warehouse_to_store_transfer") ) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-book"></i><span><?php echo display('report') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>"><?php echo display('sales_report') ?></a></li>
                    <li><a href="<?php echo base_url('Admin_dashboard/todays_purchase_report')?>"><?php echo display('purchase_report') ?></a></li>

                    <li class="<?php if ($this->uri->segment('2') == ("store_to_store_transfer") || $this->uri->segment('2') == ("store_to_warehouse_transfer") || $this->uri->segment('2') == ("warehouse_to_warehouse_transfer") || $this->uri->segment('2') == ("warehouse_to_store_transfer") ){echo "active";}else{ echo " ";} ?>">
                        <a href="javascript:void(0)"><?php echo display('transfer_report') ?>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url('Admin_dashboard/store_to_store_transfer')?>"><?php echo display('store_to_store_transfer') ?></a></li>
                            <li><a href="<?php echo base_url('Admin_dashboard/store_to_warehouse_transfer')?>"><?php echo display('store_to_warehouse_transfer') ?></a>
                            </li>
                            <li><a href="<?php echo base_url('Admin_dashboard/warehouse_to_store_transfer')?>"><?php echo display('warehouse_to_store_transfer') ?></a>
                            </li>
                            <li><a href="<?php echo base_url('Admin_dashboard/warehouse_to_warehouse_transfer')?>"><?php echo display('warehouse_to_warehouse_transfer') ?></a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="<?php echo base_url('Admin_dashboard/total_profit_report')?>"><?php echo display('profit_report') ?></a></li>
                    <li><a href="<?php echo base_url('Admin_dashboard/tax_report_product_wise')?>"><?php echo display('tax_report_product_wise') ?></a></li>
                    <li><a href="<?php echo base_url('Admin_dashboard/tax_report_invoice_wise')?>"><?php echo display('tax_report_invoice_wise') ?></a></li>
                </ul>
            </li>-->
            <!-- Report menu end -->

            <!-- Brand menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Cbrand")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-apple"></i><span><?php echo display('brand') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cbrand')?>"><?php echo display('add_brand') ?></a></li>
                    <li><a href="<?php echo base_url('Cbrand/manage_brand')?>"><?php echo display('manage_brand') ?></a></li>
                </ul>
            </li>-->
            <!-- Brand menu end -->            

            <!-- Terminal menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Cterminal")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-credit-card"></i><span><?php echo display('terminal') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cterminal')?>"><?php echo display('add_terminal') ?></a></li>
                    <li><a href="<?php echo base_url('Cterminal/manage_terminal')?>"><?php echo display('manage_terminal') ?></a></li>
                </ul>
            </li>-->
            <!-- Terminal menu end -->

            <!-- Variant menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Cvariant")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-wand"></i><span><?php echo display('variant') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cvariant')?>"><?php echo display('add_variant') ?></a></li>
                    <li><a href="<?php echo base_url('Cvariant/manage_variant')?>"><?php echo display('manage_variant') ?></a></li>
                </ul>
            </li>-->
            <!-- Variant menu end -->

            <!-- Gallery menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cgallery")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-gallery"></i><span><?php echo display('gallery') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cgallery')?>"><?php echo display('add_image') ?></a></li>
                    <li><a href="<?php echo base_url('Cgallery/manage_image')?>"><?php echo display('manage_image') ?></a></li>
                </ul>
            </li>
            <!-- Gallery menu end -->

            <!-- Tax menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Ctax")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-target"></i><span><?php echo display('tax') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Ctax/manage_tax')?>"><?php echo display('manage_product_tax') ?></a></li>
                    <li><a href="<?php echo base_url('Ctax/tax_setting')?>"><?php echo display('tax_setting') ?></a></li>
                </ul>
            </li>-->
            <!-- Tax menu end -->

            <!-- Currency menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Ccurrency")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-money"></i><span><?php echo display('currency') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Ccurrency')?>"><?php echo display('add_currency') ?></a></li>
                    <li><a href="<?php echo base_url('Ccurrency/manage_currency')?>"><?php echo display('manage_currency') ?></a></li>
                </ul>
            </li>-->
            <!-- Currency menu end --> 

            <!-- Store set menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cstore")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-truck"></i><span><?php echo display('store') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cstore')?>"><?php echo display('store_add') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Cstore/add_store_csv')?>"><?php echo display('import_store_csv') ?></a></li>-->
                    <li><a href="<?php echo base_url('Cstore/manage_store')?>"><?php echo display('manage_store') ?></a></li>
                    <!--<li><a href="<?php echo base_url('Cstore/store_transfer')?>"><?php echo display('store_transfer') ?></a></li>-->
                    <!--<li><a href="<?php echo base_url('Cstore/manage_store_product')?>"><?php echo display('manage_store_product') ?></a></li>-->
                </ul>
            </li>
            <!-- Store set menu end -->

           <?php if ($this->session->userdata('user_type') == '1') { ?>

            <!-- Bank menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Csettings")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-briefcase"></i><span><?php echo display('settings') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Csettings')?>"><?php echo display('add_new_bank') ?></a></li>
                    <li><a href="<?php echo base_url('Csettings/bank_list')?>"><?php echo display('manage_bank') ?></a></li>
                </ul>
            </li>-->
            <!-- Bank menu end -->


            <!-- Accounts menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Caccounts")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-pencil-alt"></i><span><?php echo display('accounts') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Caccounts/create_account')?>"><?php echo display('create_accounts') ?> </a></li>
                    <li><a href="<?php echo base_url('Caccounts/manage_account')?>"><?php echo display('manage_accounts') ?> </a></li>
                    <li><a href="<?php echo base_url('Caccounts')?>"><?php echo display('received') ?></a></li>
                    <li><a href="<?php echo base_url('Caccounts/outflow')?>"><?php echo display('payment') ?></a></li>
                    <li><a href="<?php echo base_url('Caccounts/summary')?>"><?php echo display('accounts_summary') ?></a></li>
                    <li><a href="<?php echo base_url('Caccounts/cheque_manager')?>"><?php echo display('cheque_manager') ?></a></li>
                    <li><a href="<?php echo base_url('Caccounts/closing')?>"><?php echo display('closing') ?></a></li>
                    <li><a href="<?php echo base_url('Caccounts/closing_report')?>"><?php echo display('closing_report') ?></a></li>
                </ul>
            </li>-->
            <!-- Accounts menu end -->

            <!-- Synchronizer setting start -->
            <!--<li class="treeview <?php if ($this->uri->segment('2') == ("form") || $this->uri->segment('2') == ("synchronize") || $this->uri->segment('1') == ("Backup_restore")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-reload"></i><span><?php echo display('Data_synchronizer') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php 
                        $localhost=false;
                        if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'))) {
                    ?>
                    <li><a href="<?php echo base_url('Data_synchronizer/form')?>"><?php echo display('setting') ?></a></li>
                    <?php
                        } 
                    ?>
                    <li><a href="<?php echo base_url('Data_synchronizer/synchronize/')?>"><?php echo display('synchronize') ?></a></li>
                    <li><a href="<?php echo base_url('Backup_restore/')?>"><?php echo display('backup_and_restore') ?></a></li>
                </ul>
            </li>-->
            <!-- Synchronizer setting end -->

            <!-- Website Settings menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Cblock") || $this->uri->segment('1') == ("Cweb_setting") || $this->uri->segment('1') == ("Cblock") || $this->uri->segment('1') == ("Cproduct_review") || $this->uri->segment('1') == ("Csubscriber") || $this->uri->segment('1') == ("Cwishlist") || $this->uri->segment('1') == ("Cweb_footer") || $this->uri->segment('1') == ("Clink_page") || $this->uri->segment('1') == ("Ccoupon") || $this->uri->segment('1') == ("Cabout_us") || $this->uri->segment('1') == ("Cour_location") || $this->uri->segment('1') == ("Cshipping_method") ) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-settings"></i><span><?php echo display('web_settings') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cweb_setting/add_slider')?>"><?php echo display('slider') ?></a></li>
                    <li><a href="<?php echo base_url('Cweb_setting/submit_add')?>"><?php echo display('advertisement') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Cblock')?>"><?php echo display('block') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Cproduct_review')?>"><?php echo display('product_review') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Csubscriber')?>"><?php echo display('subscriber') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Cwishlist')?>"><?php echo display('wishlist') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Cweb_footer')?>"><?php echo display('web_footer') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Clink_page')?>"><?php echo display('link_page') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Ccoupon')?>"><?php echo display('coupon') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Cweb_setting/manage_contact_form')?>"><?php echo display('contact_form') ?> </a></li>

                    <li><a href="<?php echo base_url('Cabout_us')?>"><?php echo display('about_us') ?> </a></li>

                    <li><a href="<?php echo base_url('Cour_location')?>"><?php echo display('our_location') ?> </a></li>

                    <li><a href="<?php echo base_url('Cshipping_method')?>"><?php echo display('shipping_method') ?> </a></li>
                    
                    <li><a href="<?php echo base_url('Cweb_setting/setting')?>"><?php echo display('setting') ?> </a></li>
                </ul>
            </li>
            <!-- Website Settings menu end -->

            <!-- Software Settings menu start -->
            <li class="treeview <?php if ($this->uri->segment('1') == ("Company_setup") || $this->uri->segment('1') == ("User") || $this->uri->segment('1') == ("Csoft_setting") || $this->uri->segment('1') == ("Language") ) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-settings"></i><span><?php echo display('software_settings') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Company_setup/manage_company')?>"><?php echo display('manage_company') ?></a></li>
                    <li><a href="<?php echo base_url('User')?>"><?php echo display('add_user') ?></a></li>
                    <li><a href="<?php echo base_url('User/manage_user')?>"><?php echo display('manage_users') ?> </a></li>
                    <li><a href="<?php echo base_url('Language')?>"><?php echo display('language') ?> </a></li>
                    <li><a href="<?php echo base_url('Csoft_setting/email_configuration')?>"><?php echo display('email_configuration') ?> </a></li>
                    <li><a href="<?php echo base_url('Csoft_setting/payment_gateway_setting')?>"><?php echo display('payment_gateway_setting') ?> </a></li>
                    <li><a href="<?php echo base_url('Csoft_setting')?>"><?php echo display('setting') ?> </a></li>
                </ul>
            </li>
            <!-- Software Settings menu end -->  
            <?php } }?>

            <?php if ($this->session->userdata('user_type') == '4') { ?>
                <!-- Purchase menu start -->
                <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Cpurchase")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('Cpurchase')?>"><?php echo display('add_purchase') ?></a></li>
                        <li><a href="<?php echo base_url('Cpurchase/manage_purchase')?>"><?php echo display('manage_purchase') ?></a></li>
                    </ul>
                </li>-->
                <!-- Order menu start -->
                <li class="treeview <?php if ($this->uri->segment('1') == ("Corder")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="ti-truck"></i><span><?php echo display('order') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('Corder/manage_order')?>"><?php echo display('admin_manage_order') ?></a></li>
                    </ul>
                </li>
                <!-- Order menu end -->
                <!-- Purchase menu end -->
                <!-- Invoice menu start -->
                <!--<li class="treeview <?php if ($this->uri->segment('2') == ("new_invoice") || $this->uri->segment('2') == ("manage_invoice") || $this->uri->segment('2') == ("invoice_update_form")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="ti-layout-accordion-list"></i><span><?php echo display('invoice') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('Store_invoice/new_invoice')?>"><?php echo display('new_invoice') ?></a></li>
                        <li><a href="<?php echo base_url('Store_invoice/manage_invoice')?>"><?php echo display('manage_invoice') ?></a></li>
                    </ul>
                </li>-->
                <!-- Invoice menu end -->

                <!-- POS invoice menu start -->
                <!--<li class="treeview <?php if ($this->uri->segment('2') == ("pos_invoice")) { echo "active";}else{ echo " ";}?>">
                    <a href="<?php echo base_url('Store_invoice/pos_invoice')?>" target="_blank">
                        <i class="ti-layout-tab-window"></i><span><?php echo display('pos_invoice') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>-->
                <!-- POS invoice menu end --> 

                <!-- Customer menu start -->
                <!--<li class="treeview <?php if ($this->uri->segment('1') == ("Ccustomer")) { echo "active";}else{ echo " ";}?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('Ccustomer')?>"><?php echo display('add_customer') ?></a></li>
                        <li><a href="<?php echo base_url('Ccustomer/manage_customer')?>"><?php echo display('manage_customer') ?></a></li>
                    </ul>
                </li>-->
                <!-- Customer menu end -->               

                <!-- Store Stock -->
                <!--<li class="treeview <?php if ($this->uri->segment('2') == ("stock_report")) { echo "active";}else{ echo " ";}?>">
                    <a href="<?php echo base_url('Store_invoice/stock_report')?>" target="_blank">
                        <i class="ti-layout-tab-window"></i><span><?php echo display('stock') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>-->
                <!-- Store stock end -->
            <?php } ?>
	    </ul>
	</div> <!-- /.sidebar -->
</aside>
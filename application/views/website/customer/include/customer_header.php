<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
    $CI =& get_instance();
    $CI->load->model('Soft_settings');
    $CI->load->model('Reports');
    $CI->load->model('Customer_dashboards');
    $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
    $customer = $CI->Customer_dashboards->profile_edit_data();
?>
<!-- Admin header start -->
<header class="main-header"> 
    <a href="<?php echo base_url('home')?>" class="logo">
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

                <!-- settings -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo display('setting')?>"> <i class="pe-7s-settings"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url()?>"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
						<li><a href="<?php echo base_url('customer/customer_dashboard/change_password_form')?>"><i class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                        <li><a href="<?php echo base_url('logout')?>"><i class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
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
	            <img src="<?php if($customer->image){echo $customer->image;}?>" class="img-circle" alt="User Image">
	        </div>
	        <div class="info">
	            <p><?php if($customer->first_name){echo $customer->first_name.' '.$customer->last_name;}?></p>
	            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo display('online') ?></a>
	        </div>
	    </div>-->
	    <!-- sidebar menu -->
	    <ul class="sidebar-menu">

	        <li class="<?php if ($this->uri->segment('1') == ("")) { echo "active";}else{ echo " ";}?>">
	            <a href="<?php echo base_url('customer/customer_dashboard')?>"><i class="ti-dashboard"></i> <span><?php echo display('dashboard') ?></span>
	                <span class="pull-right-container">
	                    <span class="label label-success pull-right"></span>
	                </span>
	            </a>
	        </li>

            <!-- Invoice menu start -->
            <!--<li class="treeview <?php if ($this->uri->segment('2') == ("invoice")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-layout-accordion-list"></i><span><?php echo display('invoice') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('customer/invoice')?>"><?php echo display('manage_invoice') ?></a></li>
                </ul>
            </li>-->
            <!-- Invoice menu end -->

            <!-- Order menu start -->
            <li class="treeview <?php if ($this->uri->segment('2') == ("order") || $this->uri->segment('2') == ("manage_order") || $this->uri->segment('2') == ("insert_order")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="ti-truck"></i><span><?php echo display('order') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!--<li><a href="<?php echo base_url('customer/order')?>"><?php echo display('new_order') ?></a></li>-->
                    <li><a href="<?php echo base_url('customer/order/manage_order')?>"><?php echo display('manage_order') ?></a></li>
                </ul>
            </li>
            <!-- Order menu end -->

            <!-- Perfil menu start -->

            <li class="treeview <?php if ($this->uri->segment('3') == ("admin_profile_send_data") || $this->uri->segment('3') == ("admin_profile_invoice_data") || $this->uri->segment('3') == ("add_profile_invoice_data") || $this->uri->segment('3') == ("edit_profile_send_data") || $this->uri->segment('3') == ("edit_profile_invoice_data") || $this->uri->segment('3') == ("add_profile_send_data")) { echo "active";}else{ echo " ";}?>">
                <a href="#">
                    <i class="pe-7s-users"></i><span><?php echo display('customer_profile') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('customer/customer_dashboard/edit_general_data')?>"><?php echo display('general_data') ?></a></li>
                    <li><a href="<?php echo base_url('customer/customer_dashboard/admin_profile_invoice_data')?>"><?php echo display('admin_invoice_data') ?></a></li>
                    <!--<li><a href="<?php echo base_url('customer/customer_dashboard/add_profile_invoice_data')?>"><?php echo display('add_invoice_data') ?></a></li>-->
                    <li><a href="<?php echo base_url('customer/customer_dashboard/admin_profile_send_data')?>"><?php echo display('admin_data_send') ?></a></li>
                    <!--<li><a href="<?php echo base_url('customer/customer_dashboard/add_profile_send_data')?>"><?php echo display('add_send_data') ?></a></li>-->
                </ul>
            </li>
            <!-- Perfil menu end -->

	    </ul>
	</div> <!-- /.sidebar -->
</aside>
<!-- Admin header end -->
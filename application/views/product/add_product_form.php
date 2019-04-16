<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add Product Form Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('product') ?></h1>
            <small><?php echo display('new_product') ?></small>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('')?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="<?php echo base_url('Cproduct')?>"><?php echo display('product') ?></a></li>
                <li class="active"><?php echo display('new_product') ?></li>
            </ol>
        </div>
    </section>

    <!-- Main content -->
    <div class="content">
                <!-- Alert Message -->
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>
        <!-- Add Product Form -->
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <!-- All modals added here for the demo. You would of course just have one, dynamically created -->
                    <!-- Modal fade in & scale effect -->
                    <div class="md-modal md-effect-1" id="modal-1">
                        <div class="md-content">
                            <h3><?php echo display('add_supplier')?></h3>
                            <div class="n-modal-body">
                                <h4 class="text-success" id="message" style="display: none;text-align: center;"></h4>
                                <h4 class="text-danger" id="error_message" style="display: none;text-align: center;"></h4>
                                <form action="<?php echo base_url('Cproduct/add_supplier')?>" id="add_supplier" method="post" class="add_supplier">
                                    <div class="panel-body">
                                        <div class="form-group row">
                                            <label for="supplier_name" class="col-sm-4 col-form-label"><?php echo display('supplier_name') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name ="supplier_name" id="supplier_name" type="text" placeholder="<?php echo display('supplier_name') ?>"  required="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('supplier_mobile') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="mobile" id="mobile" type="number" placeholder="<?php echo display('supplier_mobile') ?>" required="" min="0">
                                            </div>
                                        </div>
                   
                                        <div class="form-group row">
                                            <label for="address " class="col-sm-4 col-form-label"><?php echo display('supplier_address') ?></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('supplier_address') ?>"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="details" class="col-sm-4 col-form-label"><?php echo display('supplier_details') ?></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="details" id="details" rows="3" placeholder="<?php echo display('supplier_details') ?>"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                            <div class="col-sm-6">
                                                <input type="submit" id="add-supplier" class="btn btn-primary btn-large" name="add-supplier" value="<?php echo display('save') ?>" />
                                                <input type="button" class="btn btn-success md-close" value="<?php echo display('close') ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="md-modal md-effect-1" id="modal-2">
                        <div class="md-content">
                            <h3><?php echo display('add_category')?></h3>
                            <div class="n-modal-body">
                                <h4 class="text-success" id="message1" style="display: none;text-align: center;"></h4>
                                <h4 class="text-danger" id="error_message1" style="display: none;text-align: center;"></h4>
                                <form action="<?php echo base_url('Cproduct/insert_category')?>" id="add_category" method="post">
                                    <div class="panel-body">
                                        
                                        <div class="form-group row">
                                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('category_name')?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name ="category_name" id="category_name" type="text" placeholder="<?php echo display('category_name') ?>"  required="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                            <div class="col-sm-6">
                                                <input type="submit" id="add-supplier" class="btn btn-primary btn-large" name="add-supplier" value="<?php echo display('save') ?>" /> 

                                                <input type="button" class="btn btn-success md-close" value="<?php echo display('close') ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--<button class="btn btn-success md-trigger m-b-5 m-r-2" data-modal="modal-1">
                    <i class="ti-plus"></i><span> <?php echo display('add_supplier') ?></span></button>-->

                    <!--<button class="btn btn-info md-trigger m-b-5 m-r-2" data-modal="modal-2"><i class="ti-plus"></i> <?php echo display('add_category')?></button>-->

                    <a href="<?php echo base_url('Cproduct/manage_product')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"></i>  <?php echo display('manage_product')?></a>

                    <!--<a href="<?php echo base_url('Cproduct/add_product_csv')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i>  <?php echo display('import_product_csv')?></a>

                    <a href="<?php echo base_url('Cproduct/product_details_single')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('product_ledger')?></a>-->


                    <!-- the overlay element -->
                    <div class="md-overlay"></div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $("#add_supplier").submit(function(event)
            { 
                event.preventDefault();  
                var formdata = new FormData($(this)[0]);

                $.ajax({
                    url:  $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: formdata, 
                    processData: false,
                    contentType: false,
                    success: function (data, status)
                    {
                        if (data == '1') {
                            $('#message').css('display','block');
                            $('#message').html('Supplier added successfully');
                            setTimeout(function(){
                                window.location.href = window.location.href;
                            }, 2000);
                        }else if(data == '2'){
                            $('#error_message').css('display','block');
                            $('#error_message').html('Supplier already exist !');
                        }else if(data == '3'){
                            $('#error_message').css('display','block');
                            $('#error_message').html('Supplier name and mobile is required!');
                        }
                    },
                    error: function (xhr, desc, err)
                    {


                    }
                });        
            });
        </script>
        <!-- Add category -->
        <script type="text/javascript">
            $("#add_category").submit(function(event)
            { 
                event.preventDefault();  
                var formdata = new FormData($(this)[0]);

                $.ajax({
                    url:  $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: formdata, 
                    processData: false,
                    contentType: false,
                    success: function (data, status)
                    {
                        if (data == '1') {
                            $('#message1').css('display','block');
                            $('#message1').html('Category added successfully');
                            setTimeout(function(){
                                window.location.href = window.location.href;
                            }, 1000);
                        }else if (data == '2'){
                            $('#error_message1').css('display','block');
                            $('#error_message1').html('Category already exist !');
                        }else if(data == '3'){
                            $('#error_message1').css('display','block');
                            $('#error_message1').html('Category name required!');
                        }
                    },
                    error: function (xhr, desc, err)
                    {


                    }
                });        
            });
        </script>

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('new_product') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cproduct/insert_product',array('class' => '', 'id' => 'commentForm'))?>
                    <div class="panel-body">
                        <div id="rootwizard">
                            <div class="navbar">
                                <div class="navbar-inner form-wizard">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#tab1" data-toggle="tab" class="step" aria-expanded="true">
                                                <span class="number"> <?php echo display('1')?> </span>
                                                <span class="desc"><?php echo display('item_information')?> </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab2" data-toggle="tab" class="step" aria-expanded="true">
                                                <span class="number"> <?php echo display('2')?> </span>
                                                <span class="desc"><?php echo display('web_store')?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab3" data-toggle="tab" class="step" aria-expanded="true">
                                                <span class="number"> <?php echo display('3')?> </span>
                                                <span class="desc"><?php echo display('price')?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="bar" class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane" id="tab1">

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="product_name" class="col-sm-6 col-form-label"><?php echo display('product_name') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="form-group row">
                                                <label for="image_thumb" class="col-sm-3 col-form-label"><?php echo display('image') ?></label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="image_thumb" class="form-control" id="image_thumb">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="product_name" class="col-sm-6 col-form-label"><?php echo 'Clave interna'; ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="clave_interna" type="text" id="clave_interna" placeholder="<?php echo 'Clave interna'; ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="category_id" class="col-sm-6 col-form-label"><?php echo display('parent_category_department') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select2" id="parent_department" name="parent_department" style="width: 100%" required="">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        <?php if ($category_department_list) { ?>
                                                        {category_department_list}
                                                        <option value="{category_id}">{category_name}</option>
                                                        {/category_department_list}
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="form-group row">
                                                <label for="clave" class="col-sm-3 col-form-label"><?php echo display('category_clave') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="category_clave" type="text" id="category_clave" placeholder="<?php echo display('category_clave') ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="category_id" class="col-sm-6 col-form-label"><?php echo display('parent_category_family') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select2" id="parent_family" name="parent_family" style="width: 100%" required="">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="category_id" class="col-sm-6 col-form-label"><?php echo display('parent_category_subfamily') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select2" id="category_id" name="category_id" style="width: 100%" required="">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-2 col-form-label"><?php echo display('details') ?></label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control summernote" name="description" id="description" rows="3" placeholder="<?php echo display('details') ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="invoice_details" class="col-sm-2 col-form-label"><?php echo display('invoice_details') ?></label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="invoice_details" id="invoice_details" rows="3" placeholder="<?php echo display('invoice_details') ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab2">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="unit" class="col-sm-3 col-form-label"><?php echo display('unit') ?></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="unit" name="unit" style="width: 100%">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        {unit_list}
                                                        <option value="{unit_id}">{unit_name}</option>
                                                        {/unit_list}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="type" class="col-sm-3 col-form-label"><?php echo display('type') ?> </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="type" class="form-control" id="type" placeholder="<?php echo display('type')?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-sm-6">
                                           <div class="form-group row">
                                                <label for="brand" class="col-sm-3 col-form-label"><?php echo display('brand') ?></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="brand" name="brand" style="width: 100%">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        {brand_list}
                                                        <option value="{brand_id}">{brand_name}</option>
                                                        {/brand_list}
                                                </select>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="onsale" class="col-sm-3 col-form-label"><?php echo display('onsale') ?> <span class="color-red">*</span></label>
                                                <div class="col-md-9">
                                                    <select class="form-control select2" id="onsale" name="onsale" style="width: 100%" required="">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        <option value="1"><?php echo display('yes') ?></option>
                                                        <option value="0"><?php echo display('no') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row onsale_price" style="display: none;">
                                                <label for="onsale_price" class="col-sm-3 col-form-label"><?php echo display('onsale_price')?> <i class="text-danger">*</i></label>
                                                <div class="col-md-9">
                                                    <input class="form-control text-right" name="onsale_price" type="number" required="" placeholder="<?php echo display('onsale_price') ?>" min="0" id="onsale_price">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="best_sale" class="col-sm-3 col-form-label"><?php echo display('best_sale') ?></label>
                                                <div class="col-md-9">
                                                    <select class="form-control select2" id="best_sale" name="best_sale" style="width: 100%">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        <option value="1"><?php echo display('yes') ?></option>
                                                        <option value="0"><?php echo display('no') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-sm-6">
                                      
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="review" class="col-sm-3 col-form-label"><?php echo display('review') ?></label>
                                                <div class="col-md-9">
                                                    <textarea name="review" class="form-control summernote" placeholder="<?php echo display('review')?>" id="review" required row="3"></textarea>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-form-label"><?php echo display('description') ?></label>
                                                <div class="col-md-9">
                                                    <textarea name="description" class="form-control summernote" placeholder="<?php echo display('description')?>" id="description" required row="3"></textarea>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="specification" class="col-sm-2 col-form-label"><?php echo display('specification') ?></label>
                                                <div class="col-md-10">
                                                    <textarea name="specification" class="form-control summernote" placeholder="<?php echo display('specification')?>" id="specification" required row="3"></textarea>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab3">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="sell_price" class="col-sm-5 col-form-label"><?php echo display('sell_price') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <input class="form-control text-right" name="price" type="number" required="" placeholder="<?php echo display('sell_price') ?>" min="0" id="sell_price">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">                                            
                                            <div class="form-group row">
                                                <label for="supplier" class="col-sm-5 col-form-label"><?php echo display('supplier') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <select name="supplier_id" class="form-control select2" style="width: 100%" required="" id="supplier">
                                                        <option value=""><?php echo display('select_supplier')?></option>
                                                        <?php  if ($supplier){ ?>
                                                        {supplier}
                                                        <option value="{supplier_id}">{supplier_name}</option>
                                                        {/supplier}
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">                                       
                                            <div class="form-group row">
                                                <label for="tax" class="col-sm-5 col-form-label"><?php echo display('tax') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <select name="tax_id" class="form-control select2" style="width: 100%" required="" id="tax_id">
                                                        <option value=""></option>
                                                        <?php  if ($taxs){ ?>
                                                        {taxs}
                                                        <option value="{tax_id}">{tax_name}</option>
                                                        {/taxs}
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>                    
                                        <div class="col-sm-6">
                                            <div class="form-group row tax_percentage" style="display: none;">    
                                                <label for="sell_price" class="col-sm-5 col-form-label"><?php echo display('tax_percentage') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <input class="form-control text-right" name="tax_percentage" type="number" required="" placeholder="<?php echo display('tax_percentage') ?>" min="0" id="tax_percentage">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="tax" class="col-sm-5 col-form-label"><?php echo "Producto Recomendado" ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <select name="recomend" class="form-control select2" style="width: 100%" required="" id="recomend">
                                                        <option value="1"> No</option>
                                                        <option value="2"> Si</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-5 col-form-label"><?php echo "Fecha de entrada"; ?>
                                                    <span class="color-red">*</span>
                                                </label>
                                                <div class="col-sm-7">
                                                    <?php $date = date('d-m-Y'); ?>
                                                    <input type="text" tabindex="3" class="form-control coupon_date" name="purchase_date" value="<?php echo $date; ?>" id="purchase_date" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <ul class="pager wizard">
                                    <li class="previous first" style="display:none;"><a href="#"><?php echo display('first')?></a></li>
                                    <li class="previous"><a href="#"><?php echo display('prev')?></a></li>
                                    <li class="next last" style="display:none;"><a href="#"><?php echo display('last')?></a></li>
                                    <li class="next"><a href="#"><?php echo display('next')?></a></li>
                                    <li class="finish pull-right"><button type="submit" name="add-product" class="btn btn-success"><?php echo display('submit')?></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </div> <!-- /.content -->
</div>
<!-- Add Product Form End -->

<!--Select ads type by javascript start-->
<script type="text/javascript">
    $(document).ready(function() {
        $('.onsale_price').css({'display': 'none'});
        $('#onsale').on('change', function() {
            var onsale = $('#onsale option:selected').val();
            if (onsale == 1) {
                $('.onsale_price').css({'display': 'block'});
            }else {
                $('.onsale_price').css({'display': 'none'});
            }
        });

        $('.tax_percentage').css({'display': 'none'});
        $('#tax_id').on('change', function() {
            var tax_id = $('#tax_id option:selected').val();
            if (tax_id == 0) {
                $('.tax_percentage').css({'display': 'none'});
            }else {
                $('.tax_percentage').css({'display': 'block'});
            }
        });

        //Form wizard
        var $validator = $("#commentForm").validate();

        //Root wizard progress bar
        $('#rootwizard').bootstrapWizard({
            'tabClass'  : 'nav nav-pills',
            'onNext'    : validateTab,
            'onTabClick': validateTab
        }); 

        //Validate filed
        function validateTab(tab, navigation, index, nextIndex){
            if (nextIndex <= index){
                return;
            }
            var commentForm = $("#commentForm")
            var $valid = commentForm.valid();
            if($valid) {
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ($current / $total) * 100;
                $('#rootwizard .progress-bar').css({width: $percent + '%'});
            }else{
                $validator.focusInvalid();
                return false;
            }

            if (nextIndex > index+1){
                for (var i = index+1; i < nextIndex - index + 1; i++){
                    $('#rootwizard').bootstrapWizard('show', i);
                    $valid = commentForm.valid();
                    if(!$valid) {
                        $validator.focusInvalid();
                        return false;
                    }
                }
                return false;
            }
        }

        /* Load family by Department */
        $('select[name="parent_department"]').on('change', function() {
            
            var departmentID = $(this).val();
            if(departmentID) {
                var postData = {
                    'departmentID' :departmentID
                };
                $.ajax({
                    url: '/Ccategory/get_category_family_by_department',
                    type: "POST",
                    dataType: "json",
                    data: postData , //assign the var here 
                    success:function(data) {

                        $('select[name="parent_family"]').empty();
                        $('select[name="category_id"]').empty();
                        $('select[name="parent_family"]').append('<option value="">'+ '' +'</option>');
                        $.each(data, function(key, value) {

                            $('select[name="parent_family"]').append('<option value="'+ value.category_id +'">'+ value.category_name +'</option>');

                        });

                    }

                });
            }else{
                $('select[name="parent_family"]').empty();
                $('select[name="category_id"]').empty();
            }
        });
        /**/

        /* Load subfamily by family */
        $('select[name="parent_family"]').on('change', function() {
            
            var familyID = $(this).val();
            if(familyID) {
                var postData = {
                    'familyID' :familyID
                };
                $.ajax({
                    url: '/Ccategory/get_category_subfamily_by_family',
                    type: "POST",
                    dataType: "json",
                    data: postData , //assign the var here 
                    success:function(data) {

                        $('select[name="category_id"]').empty();
                        $('select[name="category_id"]').append('<option value="">'+ '' +'</option>');
                        $.each(data, function(key, value) {

                            $('select[name="category_id"]').append('<option value="'+ value.category_id +'">'+ value.category_name +'</option>');

                        });

                    }

                });
            }else{
                $('select[name="category_id"]').empty();
            }
            });
        /**/

    });
</script>
<!--Select ads type by javascript end-->




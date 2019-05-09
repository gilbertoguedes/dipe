<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('product') ?></h1>
            <small><?php echo display('product_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('product') ?></a></li>
                <li class="active"><?php echo display('product_edit') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
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

        <!-- Product edit -->
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('product_edit') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cproduct/product_update',array('class' => 'form-vertical', 'id' => 'commentForm','name' => 'product_update'))?>
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
                                                    <input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" value="{product_name}" required>
                                                    <input type="hidden" name="product_id" value="{product_id}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="clave" class="col-sm-6 col-form-label"><?php echo 'Clave interna'; ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="clave_interna" type="text" id="clave_interna" placeholder="<?php echo 'Clave interna'; ?>" value="{clave_interna}" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="image_thumb" class="col-sm-6 col-form-label"><?php echo display('image') ?></label>
                                                <div class="col-sm-6">
                                                    <input type="file" name="image_thumb" class="form-control">
                                                    <img class="img img-responsive text-center" src="{image_thumb}" height="80" width="80" style="padding: 5px;">
                                                    <input type="hidden" value="{image_thumb}" name="old_thumb_image">
                                                    <input type="hidden" value="{image_large_details}" name="old_img_lrg">
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
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($category_department_list as $category) {
                                                            ?>
                                                            <option value="<?php echo $category['category_id']?>" <?php if ($category['category_id'] == $category_department_selected) {echo "selected"; }?>><?php echo $category['category_name']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group row">
                                                <label for="clave" class="col-sm-3 col-form-label"><?php echo display('category_clave') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="category_clave" type="text" id="category_clave" placeholder="<?php echo display('category_clave') ?>" value="{category_clave}" required="">
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
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($category_family_list as $category) {
                                                            ?>
                                                            <option value="<?php echo $category['category_id']?>" <?php if ($category['category_id'] == $category_family_selected) {echo "selected"; }?>><?php echo $category['category_name']?></option>
                                                        <?php
                                                        }
                                                        ?>
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
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($category_subfamily_list as $category) {
                                                            ?>
                                                            <option value="<?php echo $category['category_id']?>" <?php if ($category['category_id'] == $category_subfamily_selected) {echo "selected"; }?>><?php echo $category['category_name']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-2 col-form-label"><?php echo display('details') ?></label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control summernote" name="description" id="description" rows="3" >{product_details}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="invoice_details" class="col-sm-2 col-form-label"><?php echo display('invoice_details') ?></label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="invoice_details" id="invoice_details" rows="3" placeholder="<?php echo display('invoice_details') ?>">{invoice_details}</textarea>
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
                                                        <?php if ($unit_selected) { ?>
                                                        {unit_selected}
                                                        <option selected value="{unit_id}">{unit_name} </option>
                                                        {/unit_selected}
                                                        <?php }else{ ?>
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="type" class="col-sm-3 col-form-label"><?php echo display('type') ?> </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="type" class="form-control" id="type" value="{type}" placeholder="<?php echo display('type') ?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="onsale" class="col-sm-3 col-form-label"><?php echo display('onsale') ?></label>
                                                <div class="col-md-9">
                                                    <select class="form-control select2" id="onsale" name="onsale" style="width: 100%">
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        <option value="1" <?php if ($onsale == 1) {
                                                            echo "selected";}?>><?php echo display('yes') ?></option>
                                                        <option value="0" <?php if ($onsale == 0) {
                                                            echo "selected";}?>><?php echo display('no') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row onsale_price" style="<?php if ($onsale == 0) { echo "display: none"; }?>">
                                                <label for="onsale_price" class="col-sm-3 col-form-label"><?php echo display('onsale_price')?> <i class="text-danger">*</i></label>
                                                <div class="col-md-9">
                                                    <input class="form-control text-right" name="onsale_price" type="number" required="" placeholder="<?php echo display('onsale_price') ?>" min="0" id="onsale_price" value="{onsale_price}">
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
                                                        <option value="1" <?php if ($best_sale == 1) {
                                                            echo "selected";}?>><?php echo display('yes') ?></option>
                                                        <option value="0" <?php if ($best_sale == 0) {
                                                            echo "selected";}?>><?php echo display('no') ?></option>
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
                                                <label for="content1" class="col-sm-3 col-form-label"><?php echo display('review') ?></label>
                                                <div class="col-md-9">
                                                    <textarea name="review" class="form-control summernote" placeholder="<?php echo display('review')?>" id="content1" required row="3">{review}</textarea>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="content2" class="col-sm-3 col-form-label"><?php echo display('description') ?></label>
                                                <div class="col-md-9">
                                                    <textarea name="description" class="form-control summernote" placeholder="<?php echo display('description')?>" id="content2" required row="3">{description}</textarea>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="specification" class="col-sm-2 col-form-label"><?php echo display('specification') ?></label>
                                                <div class="col-md-10">
                                                    <textarea name="specification" class="form-control summernote" placeholder="<?php echo display('specification')?>" id="specification" required row="3">{specification}</textarea>
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
                                                    <input class="form-control text-right" name="price" type="number" value="{price}" required placeholder="<?php echo display('sell_price') ?>" tabindex="3" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="supplier" class="col-sm-5 col-form-label"><?php echo display('supplier') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <select name="supplier_id" class="form-control select2"  style="width: 100%" required="" id="supplier">
                                                        {supplier_list}
                                                        <option value="{supplier_id}">{supplier_name} </option>
                                                        {/supplier_list}
                                                        <?php if ($supplier_selected) { ?>
                                                        {supplier_selected}
                                                            <option selected value="{supplier_id}">{supplier_name} </option>
                                                        {/supplier_selected}
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
                                                    <select name="tax_id" class="form-control select2" style="width: 100%" required id="tax_id">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($taxs as $tax) {
                                                            ?>
                                                            <option value="<?php echo $tax['tax_id']?>" <?php if ($tax['tax_id'] == $tax_selected) {echo "selected"; }?>><?php echo $tax['tax_name']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row tax_percentage" style="<?php if ($tax_selected == "0") { echo "display: none"; }?>">
                                                <label for="sell_price" class="col-sm-5 col-form-label"><?php echo display('tax_percentage') ?> <span class="color-red">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="hidden" name="t_p_s_id" value="{t_p_s_id}"/>
                                                    <input class="form-control text-right" name="tax_percentage" type="number" required="" placeholder="<?php echo display('tax_percentage') ?>" min="0" id="tax_percentage" value="{tax_percentage}">
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
                                                        <?php if($recomend == "2"){ ?>
                                                        <option selected value="2"> Si</option>
                                                        <option value="1"> No</option>
                                                        <?php } else { ?>
                                                            <option selected value="1"> No</option>
                                                            <option value="2"> Si</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?>
                                                    <i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" tabindex="3" class="form-control coupon_date" name="purchase_date" value="<?php echo $date; ?>" id="purchase_date" required />
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
                                    <li class="finish pull-right"><button type="submit" href="javascript:;" name="add-product"><?php echo display('save_changes')?></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Product End -->

<!--Select ads type by javascript start-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#onsale').on('change', function() {
            var onsale = $('#onsale option:selected').val();
            if (onsale == 1) {
                $('.onsale_price').css({'display': 'block'});
            }else {
                $('.onsale_price').css({'display': 'none'});
            }
        });

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
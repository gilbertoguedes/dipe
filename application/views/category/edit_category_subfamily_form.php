<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('category') ?></h1>
            <small><?php echo display('category_family_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('category') ?></a></li>
                <li class="active"><?php echo display('category_family_edit') ?></li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('category_family_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Ccategory/category_subfamily_update',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('category_subfamily_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="category_name" id="category_name" type="text" placeholder="<?php echo display('category_department_name') ?>"  required="" value="{category_name}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('category_clave')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="category_clave" id="category_clave" type="text" placeholder="<?php echo display('category_clave') ?>"  required="" value="{category_clave}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_category" class="col-sm-4 col-form-label"><?php echo display('parent_category_department')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="parent_department" id="parent_department" required="">
                                    <option value=""></option>
                                    <?php
                                        foreach ($department_list as $category) {
                                    ?>
                                    <option value="<?php echo $category['category_id']?>" <?php if ($category['category_id'] == $parent_department) {echo "selected"; }?>><?php echo $category['category_name']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_category" class="col-sm-4 col-form-label"><?php echo display('parent_category_family')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="parent_family" id="parent_family" required="">
                                    <option value=""></option>
                                    <?php
                                        foreach ($parent_category_family_list as $category) {
                                    ?>
                                    <option value="<?php echo $category['category_id']?>" <?php if ($category['category_id'] == $parent_category_family_id) {echo "selected"; }?>><?php echo $category['category_name']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tax" class="col-sm-4 col-form-label"><?php echo "Categoría Popular" ?> <span class="color-red">*</span></label>
                            <div class="col-sm-6">
                                <select name="popular" class="form-control select2" style="width: 100%" required="" id="popular">
                                    <?php if($popular == "2"){ ?>
                                        <option selected value="2"> Si</option>
                                        <option value="1"> No</option>
                                    <?php } else { ?>
                                        <option selected value="1"> No</option>
                                        <option value="2"> Si</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="top_menu" class="col-sm-4 col-form-label"><?php echo display('top_menu')?> </label>
                            <div class="col-sm-6">
                                <select class="form-control" name="top_menu" id="top_menu">
                                    <option value=""></option>
                                    <option value="1" <?php if ($top_menu == 1) {echo "selected";}?>><?php echo display('yes')?></option>
                                    <option value="0" <?php if ($top_menu == 0) {echo "selected";}?>><?php echo display('no')?></option>
                                </select>
                            </div>
                        </div>

                        <!--<div class="form-group row">
                            <label for="menu_position" class="col-sm-4 col-form-label"><?php echo display('menu_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="menu_position" id="menu_position" type="text" placeholder="<?php echo display('menu_position') ?>"  required="" value="{menu_pos}">
                            </div>
                        </div>-->

                       
                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label"><?php echo display('status') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status" id="status">
                                    <option value="1" <?php if ($status == 1) {echo "selected";}?>><?php echo display('active') ?></option>
                                    <option value="0" <?php if ($status == 0) {echo "selected";}?>><?php echo display('inactive') ?></option>
                                </select>
                            </div>
                        </div>

                        <!--<div class="form-group row">
                            <label for="cat_favicon" class="col-sm-4 col-form-label"><?php echo display('cat_icon')?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cat_favicon" id="cat_favicon" type="file">
                                <img src="{cat_favicon}" height="80" width="80" class="img img-responsive">
                                <input name ="old_cat_icon" type="hidden" value="{cat_favicon}">
                            </div>
                        </div>-->

                        <div class="form-group row">
                            <label for="cat_image" class="col-sm-4 col-form-label"><?php echo display('cat_image')?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cat_image" id="cat_image" type="file">
                                <input name ="old_image" type="hidden" value="{cat_image}">
                                <span class="help-block small"><?php echo display('optional') ?></span>
                                <img src="{cat_image}" height="80" width="80" class="img img-responsive">
                            </div>
                        </div>

                        <input type="hidden" value="{category_id}" name="category_id">

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-Customer" class="btn btn-success btn-large" name="add-Customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit customer end -->

<script type="text/javascript">


$(document).ready(function() {

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
                    $('select[name="parent_family"]').append('<option value="">'+ '' +'</option>');
                    $.each(data, function(key, value) {
                        
                        $('select[name="parent_family"]').append('<option value="'+ value.category_id +'">'+ value.category_name +'</option>');

                    });

                }

            });
        }else{
            $('select[name="parent_family"]').empty();
        }
    });

});

</script>


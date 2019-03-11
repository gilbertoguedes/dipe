<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Product Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('product') ?></h1>
	        <small><?php echo "Imágenes del Producto"; ?></small>
	        <ol class="breadcrumb">
	            <li><a href="<?php echo base_url('')?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="<?php echo base_url('Cproduct')?>"><?php echo display('product') ?></a></li>
	            <li class="active"><?php echo "Imágenes del Producto"; ?></li>
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

	    <div class="row">
            <div class="col-sm-12">
                <div class="column">

                  <a href="<?php echo base_url('Cproduct/manage_product')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"></i>  <?php echo display('manage_product')?></a>

                  <!--<a href="<?php echo base_url('Cproduct/add_product_csv')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('import_product_csv')?></a>

                  <a href="<?php echo base_url('Cproduct/product_details_single')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('product_ledger')?></a>-->

                </div>
            </div>
        </div>

        <div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
                    <div class="panel-body">
                        <?php echo form_open_multipart('Cproduct/insert_product_image',array('class' => 'form-inline', 'id' => 'commentForm'))?>
                        <label class="select"><?php echo display('image')?>:</label>
                        <input type="hidden" name="product_id" value="{product_id}"/>
                        <input type="file" name="image_thumb" class="form-control" id="image_thumb">
                        <button type="submit" class="btn btn-primary"><?php echo display('submit')?></button>
                        <?php echo form_close()?>
			        </div>
		        </div>
		    </div>
	    </div>


		<!-- Manage Product report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo "Imágenes del Producto"; ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
                                        <th style="width : 130px; min-width : 130px"><?php echo display('action') ?></th>
										<th><?php echo display('image') ?>s</th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($product_images) {
								?>
								{product_images}
									<tr>
                                        <td>
                                            <center>
                                                <?php echo form_open()?>
                                                    <a href="<?php echo base_url('Cproduct/product_image_delete/{product_image_id}')?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                <?php echo form_close()?>
                                            </center>
                                        </td>
										<td class="text-center">
											<img src="{image_thumb}" class="img img-responsive center-block" height="50" width="50">
										</td>

									</tr>
								{/product_images}
								<?php
								}
								?>
								</tbody>
		                    </table>
		                    <div class="text-right"><?php echo @$links?></div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Product End -->
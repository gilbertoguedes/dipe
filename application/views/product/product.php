<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Product Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('product') ?></h1>
	        <small><?php echo display('manage_product') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="<?php echo base_url('')?>"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="<?php echo base_url('Cproduct')?>"><?php echo display('product') ?></a></li>
	            <li class="active"><?php echo display('manage_product') ?></li>
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
                
                  <a href="<?php echo base_url('Cproduct')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('add_product')?></a>

                  <!--<a href="<?php echo base_url('Cproduct/add_product_csv')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('import_product_csv')?></a>

                  <a href="<?php echo base_url('Cproduct/product_details_single')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('product_ledger')?></a>-->

                </div>
            </div>
        </div>

        <div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
						<form action="<?php echo base_url('Cproduct/product_by_search')?>" class="form-inline" method="post" accept-charset="utf-8">
		                    <label class="select"><?php echo display('product_name')?>:</label>
							<select class="form-control" name="product_id" style="width: 300px;">
								{all_product_list}
	                           	<option value="{product_id}">{product_name}</option>
								{/all_product_list}
                            </select>
							<button type="submit" class="btn btn-primary"><?php echo display('submit')?></button>
			            </form>		            
			        </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="<?php echo base_url('Cproduct/product_by_search_clave')?>" class="form-inline" method="post" accept-charset="utf-8">
							<label class="select"><?php echo 'Clave interna'?>:</label>
							<input class="form-control" name="clave_interna" type="text" id="clave_interna" placeholder="<?php echo 'Clave interna'; ?>">
							<button type="submit" class="btn btn-primary"><?php echo display('submit')?></button>
						</form>
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
		                    <h4><?php echo display('manage_product') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
                                        <th style="width : 130px; min-width : 130px"><?php echo display('action') ?></th>
										<th><?php echo display('sl') ?></th>
										<th><?php echo 'Clave interna'; ?></th>
										<th><?php echo display('product_name') ?></th>
										<th><?php echo display('supplier') ?></th>
										<th><?php echo display('subfamily') ?></th>
										<th><?php echo display('family') ?></th>
										<th><?php echo display('department') ?></th>
										<th><?php echo display('unit') ?></th>
										<th><?php echo display('sell_price') ?></th>
										<th><?php echo display('onsale_price') ?></th>
										<th><?php echo display('image') ?>s</th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($products_list) {
								?>
								{products_list}
									<tr>
                                        <td>
                                            <center>
                                                <?php echo form_open()?>

                                                <a href="<?php echo base_url().'Cqrcode/qrgenerator/{product_id}'; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('qr_code') ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                                <a href="<?php echo base_url().'Cbarcode/barcode_print/{product_id}'; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('barcode') ?>"><i class="fa fa-barcode" aria-hidden="true"></i></a>

                                                <a href="<?php echo base_url().'Cproduct/product_update_form/{product_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <a href="<?php echo base_url('Cproduct/product_delete/{product_id}')?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                <a href="<?php echo base_url('Cproduct/product_image/{product_id}')?>" class="btn btn-success btn-sm"  data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo "Añadir Imagen" ?> "><i class="fa fa-file-image-o" aria-hidden="true"></i></a>

                                                <?php echo form_close()?>
                                            </center>
                                        </td>
										<td>{sl}</td>
										<td>{clave_interna}</td>
										<td>
											<a href="<?php echo base_url().'Cproduct/product_details/{product_id}'; ?>">{product_name}</a>
										</td>
										<td>{supplier_name}</td>
										<td>{category_name}</td>
										<td>{family}</td>
										<td>{department}</td>
										<td>{unit_short_name}</td>
										<td style="text-align: right;">
											<?php echo (($position==0)?"$currency {price}":"{price} $currency") ?>
										</td>

										<td style="text-align: right;">
											<?php echo (($position==0)?"$currency {onsale_price}":"{onsale_price} $currency") ?>
										</td>
										<td class="text-center">
											<img src="{image_thumb}" class="img img-responsive center-block" height="50" width="50">
										</td>

									</tr>
								{/products_list}
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
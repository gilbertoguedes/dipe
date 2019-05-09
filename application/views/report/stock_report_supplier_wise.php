<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Product js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js.php" ></script>

<!-- Stock report start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<!-- Stock List Supplier Wise Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('stock_report_supplier_wise') ?></h1>
	        <small><?php echo display('stock_report_supplier_wise') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('stock_report_supplier_wise') ?></li>
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
            $validatio_error = validation_errors();
            if (($error_message || $validatio_error)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validatio_error ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                  <a href="<?php echo base_url('Creport')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('stock_report')?></a>  

                  <a href="<?php echo base_url('Creport/stock_report_product_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('stock_report_product_wise')?></a>  
                </div>
            </div>
        </div>


		<!-- Stock report supplier wise -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 

						<?php echo form_open('Creport/stock_report_supplier_wise',array('class' => '','id' => 'validate' ));?>

							<?php date_default_timezone_set("Asia/Dhaka"); $today = date('m-d-Y'); ?>

                            <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-3 col-form-label"><?php echo display('select_supplier')?>: <i class="text-danger">*</i></label>
	                            <div class="col-sm-4">
	                                <select class="form-control" name="supplier_id" id="supplier_name"  required="">
	                                <option value=""></option>
			                        {supplier_list}
			                        <option value="{supplier_id}">{supplier_name}</option>
			                        {/supplier_list}
			                        </select>
	                            </div>
	                        </div>  

	                        <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-3 col-form-label"><?php echo display('date') ?>:</label>
	                            <div class="col-sm-4">
	                                <input type="text" name="stock_date" value="<?php echo $today; ?>" class="form-control productSelection datepicker" required/>
	                            </div>
	                        </div>

	                        <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-3 col-form-label"></label>
	                            <div class="col-sm-6">
	                                <button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
		                			<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
	                            </div>
	                        </div>
			            <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('stock_report_supplier_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" style="margin-left:2px;">
							<?php
								if ($supplier_info) {
							?>
							<div class="text-center">				
								{supplier_info}
								<h3> {supplier_name} </h3>
								<h4><?php echo display('address') ?> : {address} </h4>
								<h4 ><?php echo display('phone') ?> : {mobile} </h4>
								{/supplier_info}
								<h4> <?php echo display('product_model') ?> : {product_model} </h4>
								<h4> <?php echo display('stock_date') ?> : {date} </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("m/d/Y h:i:s"); ?> </h4>
							</div>
							<?php
								}
							?>
			                <div class="table-responsive" style="margin-top: 10px;">
			                    <table id="" class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('sell_price') ?></th>
											<th class="text-center"><?php echo display('supplier_price') ?></th>
											<th class="text-center"><?php echo display('in_quantity') ?></th>
											<th class="text-center"><?php echo display('out_quantity') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($stok_report) {
									?>
									{stok_report}
										<tr>
											<td>{sl}</td>
											<td align="center">
												<a href="<?php echo base_url().'Cproduct/product_details/{product_id}'; ?>">
												{product_name}
												</a>	
											</td>
											<td style="text-align: center;"><?php echo (($position==0)?"$currency {price}":"{price} $currency") ?></td>
											<td style="text-align: center;"><?php echo (($position==0)?"$currency {supplier_price}":"{supplier_price} $currency") ?></td>
											<td align="center">{in_qnty}</td>
											<td align="center">{out_qnty}</td>
											<td align="center">{stok_quantity}</td>
										</tr>
									{/stok_report}
									<?php
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6" align="right"><b><?php echo display('grand_total')?>:</b></td>
											<td align="center"><b>{sub_total_stock}</td>
											
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		                <div class="text-center"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Stock List Supplier Wise End -->
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Tax Report Product Wise Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('tax_report_invoice_wise') ?></h1>
	        <small><?php echo display('tax_report_invoice_wise')?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('tax_report_invoice_wise') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<!-- Tax Report Product Wise -->

		<div class="row">
            <div class="col-sm-12">
                <div class="column">

                  <a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('sales_report')?></a>
                </div>
            </div>
        </div>
        
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('Admin_dashboard/tax_report_invoice_wise',array('class' => 'form-inline'))?>
		                    <div class="form-group">
		                        <label for="from_date"><?php echo display('start_date') ?>:</label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label for="to_date"><?php echo display('end_date') ?>:</label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
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
		                    <h4><?php echo display('tax_report_invoice_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_id') ?></th>
										<th><?php echo display('tax_name') ?></th>
										<th><?php echo display('ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($tax_report_invoice_wise) {
								?>
									{tax_report_invoice_wise}
										<tr>
											<td>{date}</td>
											<td>
												<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>">
													{invoice_id}
												</a>
											</td>
											<td>{tax_name}</td>
											<td style="text-align: right;"><?php echo (($position==0)?"$currency {tax_amount}":"{tax_amount} $currency") ?></td>
										</tr>
									{/tax_report_invoice_wise}
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" align="right" style="text-align:right;font-size:14px !Important">&nbsp; <b><?php echo display('total_tax') ?> </b></td>
										<td style="text-align: right;"><b><?php echo (($position==0)?"$currency {Subtotal_tax_amnt}":"{Subtotal_tax_amnt} $currency") ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
 <!-- Tax Report Product Wise End -->
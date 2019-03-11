<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Customer Ledger Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('customer_ledger') ?></h1>
	        <small><?php echo display('manage_customer_ledger') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('customer') ?></a></li>
	            <li class="active"><?php echo display('customer_ledger') ?></li>
	        </ol>
	    </div>
	</section>

	<!-- Customer information -->
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
                
                  <a href="<?php echo base_url('Ccustomer/manage_customer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_customer')?></a>
                  <a href="<?php echo base_url('Ccustomer/customer_ledger_report')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('customer_ledger')?></a>

                </div>
            </div>
        </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('customer_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left;margin-right: 10px">
							{company_info}
							<h5><u> {company_name}</u></h5>
							{/company_info}
							<?php echo display('customer_name') ?> : {customer_name} <br>
							<?php echo display('customer_address') ?> : {customer_address}<br>
							<?php echo display('mobile') ?> : {customer_mobile}<br>
							<?php echo display('customer_email') ?> : {customer_email}<br>
						</div>

						 <div style="float:left">
							<br>
							<?php echo display('city') ?> : {city}<br>
							<?php echo display('state') ?> : {state}<br>
							<?php echo display('country') ?> : {country}<br>
							<?php echo display('zip') ?> : {zip}<br>
							<?php echo display('company') ?> : {company}<br>
							
						</div>
						<div style="float:right;margin-right: 50px">
							<table class="table table-striped table-condensed table-bordered">
								<tr><td> <?php echo display('debit_ammount') ?> </td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?"$currency {total_debit}":"{total_debit} $currency")?></td> </tr>
								<tr><td><?php echo display('credit_ammount');?></td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?"$currency {total_credit}":"{total_credit} $currency") ?></td> </tr>
								<tr><td><?php echo display('balance_ammount');?> </td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?"$currency {total_balance}":"{total_balance} $currency")?></td> </tr>
							</table>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Manage Customer -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('customer_ledger') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('receipt_no') ?></th>
										<th><?php echo display('description') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('debit') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('credit') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('balance') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($ledger){
								?>
								{ledger}
									<tr>
										<td>{final_date}</td>
										<td>
											<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/{invoice_no}'; ?>">
												{invoice_no}
											</a>
										</td>
										<td>
											{receipt_no}
										</td>
										<td>{description}</td>
										<td style="text-align:right;"> 

										<?php
										echo (($position==0)?"$currency {debit}":"{debit} $currency")?>
											
										</td>
										<td style="text-align:right;"> <?php echo (($position==0)?"$currency {credit}":"{credit} $currency") ?></td>
										<td style="text-align:right;"> <?php echo (($position==0)?"$currency {balance}":"{balance} $currency") ?></td>
									</tr>
								{/ledger}
								<?php
									}
								?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Customer Ledger End  -->
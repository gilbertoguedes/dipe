<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Invoice Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('invoice') ?></h1>
	        <small><?php echo display('admin_manage_invoice') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('invoice') ?></a></li>
	            <li class="active"><?php echo display('admin_manage_invoice') ?></li>
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

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="column">
                  <a href="<?php echo base_url('Cinvoice/new_invoice')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('new_invoice')?></a>

                  <a href="<?php echo base_url('Cinvoice/pos_invoice')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('pos_invoice')?></a>
                </div>
            </div>
        </div>-->


		<!-- Manage Invoice report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('admin_manage_invoice') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                    	<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('total_amount') ?></th>
										<th style="width: 25%"><?php echo display('status') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php if ($invoices_list) { 
									$i=1;
									foreach ($invoices_list as $invoice) {
								?>
									<tr>
										<td><?php echo $invoice['sl']?></td>
										<td>
											<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/'.$invoice['invoice_id']; ?>">
											<?php echo $invoice['invoice']?>
											</a>
										</td>
										<td>
											<a href="<?php echo base_url().'Ccustomer/customerledger/'.$invoice['customer_id']; ?>"><?php echo $invoice['customer_name']?></a>
										</td>
										<td><?php echo $invoice['final_date']?></td>
										<td style="text-align: right;"><?php echo (($position==0)?$currency.' '.$invoice['total_amount']:$invoice['total_amount'].' '.$currency) ?></td>
										<td>
											<form action="<?php echo base_url('Cinvoice/update_status/'.$invoice['invoice_id'])?>" method="post" id="validate">
												<select class="form-control" id="invoice_status" name="invoice_status" required="">
			                                       	<option value=""></option>
			                                        <option value="1" <?php if ($invoice['invoice_status'] == '1'){echo "selected";}?>><?php echo display('shipped')?></option>
			                                        <option value="2" <?php if ($invoice['invoice_status'] == '2'){echo "selected";}?>><?php echo display('cancel')?></option>
			                                        <option value="3" <?php if ($invoice['invoice_status'] == '3'){echo "selected";}?>><?php echo display('pending')?></option>
			                                        <option value="4" <?php if ($invoice['invoice_status'] == '4'){echo "selected";}?>><?php echo display('complete')?></option>
			                                        <option value="5" <?php if ($invoice['invoice_status'] == '5'){echo "selected";}?>><?php echo display('processing')?></option>
			                                        <option value="6" <?php if ($invoice['invoice_status'] == '6'){echo "selected";}?>><?php echo display('return')?></option>
			                                    </select>

			                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal_<?php echo $i?>" title="<?php echo display('add_note')?>" /><i class="fa fa-plus" aria-hidden="true"></i></button>

			                                    <input type="hidden" value="<?php echo $invoice['customer_email'] ?>" name="customer_email"/>

			                                    <div class="modal fade" id="myModal_<?php echo $i?>"  role="dialog">
							                        <div class="modal-dialog" role="document">
							                            <div class="modal-content">
							                                <div class="modal-header">
							                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							                                    <h1 class="modal-title"><?php echo display('add_note')?></h1>
							                                </div>
							                                <div class="modal-body">
								                                <div class="form-group row">
								                                    <label for="" class="col-sm-4 col-form-label"><?php echo display('add_note') ?> </label>
								                                    <div class="col-sm-8">
								                                       <input type="text" name="add_note" class="form-control" id="add_note" placeholder="<?php echo display('add_note') ?>" required>
								                                    </div>
								                                </div> 
							                                </div>
							                                <div class="modal-footer">
							                                    <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo display('submit')?></button>
							                                </div>
							                            </div><!-- /.modal-content -->
							                        </div><!-- /.modal-dialog -->
							                    </div><!-- /.modal -->

							                    <input type="submit" class="btn btn-primary" value="<?php echo display('update') ?>" style="position: absolute;margin-left: 5px;" onclick="noteCheck();"/>

							                    <script type="text/javascript">
							                    	function noteCheck(){
							                    		var add_note = $('#add_note').val();
							                    		if (add_note) {
							                    			return true;
							                    		}else{
							                    			alert('<?php echo display('please_add_note')?>');
							                    			return false;
							                    		}
							                    	}
							                    </script>
											</form>
										</td>
										<td>
											<center>
												<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/'.$invoice['invoice_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>

												<a href="<?php echo base_url().'Cinvoice/pos_invoice_inserted_data/'.$invoice['invoice_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('pos_invoice') ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>

												<a href="<?php echo base_url().'Cinvoice/invoice_update_form/'.$invoice['invoice_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('Cinvoice/invoice_delete/'.$invoice['invoice_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</center>
										</td>
									</tr>
								<?php $i++; } }?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Invoice End -->
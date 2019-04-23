<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage order Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('order') ?></h1>
	        <small><?php echo display('manage_order') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('order') ?></a></li>
	            <li class="active"><?php echo display('manage_order') ?></li>
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
                  	<a href="<?php echo base_url('customer/order')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('new_order')?></a>
                </div>
            </div>
        </div>-->

		<!-- Manage order report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_order') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                    	<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('order_no') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('total_amount') ?></th>
										<th><?php echo 'Estado'; ?></th>
                                        <th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($orders_list) {
									foreach ($orders_list as $order) {
								?>
									<tr>
										<td><?php echo $order['sl']?></td>
										<td><?php echo $order['order']?></td>
										<td><?php echo $order['customer_name']?></td>
										<td><?php echo $order['final_date']?></td>
										<td style="text-align: right;"><?php echo (($position==0)?$currency.' '.$order['total_amount']:$order['total_amount'].' '.$currency) ?></td>
										<td><?php $state = $order['state']; if($order['order_state_id']==3){
												if($order['variante_entrega']==1){
													$state = $state.' recoger';
												}
												else
												{
													$state = $state.' enviar';
												}
											} echo $state;?>
										</td>
										<td>
                                        <?php if($order['timbrado']==1){ ?>
                                            <a href="<?php echo base_url('/customer/show_order/'.$order['order_id']); ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Mostrar Pedido"; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('assets/timbrados/'.$order['order_id'].'.pdf');  ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Descargar Factura PDF"; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('assets/timbrados/'.$order['order_id'].'.xml'); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Descargar Factura XML"; ?>"><i class="fa fa-file-code-o" aria-hidden="true"></i></a>
                                        <?php }else{ ?>
                                            <a href="<?php echo base_url('/customer/show_order/'.$order['order_id']); ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Mostrar Pedido"; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('/checkout_invoice/'.$order['order_id']);  ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Facturar y timbrar"; ?>"><i class="ti-truck" aria-hidden="true"></i></a>
                                        <?php } ?>
                                        </td>
                                    </tr>
								<?php
									}
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
<!-- Manage order End -->
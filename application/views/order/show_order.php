<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage order Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "Administrar Pedidos"; ?></h1>
            <small><?php echo "Pedido"; ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('order') ?></a></li>
                <li class="active"><?php echo "Pedido"; ?></li>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo "Mi Pedido"; ?></h4>
                        </div>
                    </div>

                    <div class="panel-body">
                        <?php if($this->session->userdata('user_type')==4){ ?>
                        <?php echo form_open('Corder/order_state_update',array('class' => 'form-vertical','id'=>'validate' ))?>
                        <input type="hidden" name="order_id" value="{order_id}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-1">
                                        <label for="order_state" class="col-form-label"><?php echo 'Estado:'; ?></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" id="order_state" name="order_state" style="width: 100%" required="">
                                            <option value=""></option>
                                            <?php
                                            foreach ($order_state as $state) {
                                                ?>
                                                <?php if($variante_entrega==1){ ?>
                                                    <?php if($state['id']!=4){ ?>
                                                        <option value="<?php echo $state['id']?>" <?php if ($state['id'] == $order_state_id) {echo "selected"; }?>><?php echo $state['action']?></option>
                                                    <?php } ?>
                                                <?php } else {?>
                                                    <option value="<?php echo $state['id']?>" <?php if ($state['id'] == $order_state_id) {echo "selected"; }?>><?php echo $state['action']?></option>
                                                <?php } ?>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="submit"  class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Actualizar estado"; ?>"> Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close()?>
                        <?php } ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <h4 class="col-sm-4"><?php echo 'Estado'; ?>: <small>{state}</small></h4>
                                    <h4 class="col-sm-4"><?php echo display('date'); ?>: <small>{date}</small></h4>
                                    <h4 class="col-sm-3"><?php echo "Método de Pago"; ?>: <small><?php echo "SANTANDER"; ?></small></h4>
                                    <h4 class="col-sm-2">Entregado: <small>NO</small></h4>
                                    <h4 class="col-sm-3">Facturado: <small><?php if($timbrado=="0")echo "NO"; else echo "SI"; ?></small>
                                        <?php if($timbrado!="0"){ ?>
                                            <a href="<?php echo base_url('assets/timbrados/'.$order_id.'.pdf');  ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Descargar Factura PDF"; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('assets/timbrados/'.$order_id.'.xml'); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Descargar Factura XML"; ?>"><i class="fa fa-file-code-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td><strong><?php echo 'Clave interna';?></strong></td>
                                    <td><strong><?php echo display('quantity')?></strong></td>
                                    <td><strong><?php echo display('unit')?></strong></td>
                                    <td><strong><?php echo display('product_name')?></strong></td>
                                    <td><strong><?php echo display('price')?></strong></td>
                                    <td><strong><?php echo display('total')?></strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; $cgst = 0; $sgst = 0; $igst = 0; $discount = 0;$coupon_amnt=0; ?>
                                <?php
                                foreach ($order_all_data as $items):
                                    ?>
                                    <?php echo form_hidden($i.'[rowid]', $items['rowid']);
                                    if (!empty($items['options']['cgst'])) {
                                        $cgst = $cgst + ($items['options']['cgst'] * $items['qty']);
                                    }

                                    if (!empty($items['options']['sgst'])) {
                                        $sgst = $sgst + ($items['options']['sgst'] * $items['qty']);
                                    }

                                    if (!empty($items['options']['igst'])) {
                                        $igst = $igst + ($items['options']['igst'] * $items['qty']);
                                    }

                                    //Calculation for discount
                                    if (!empty($items['discount'])) {
                                        $discount = $discount + ($items['discount'] * $items['qty']) + $this->session->userdata('coupon_amnt');
                                        $this->session->set_userdata('total_discount',$discount);
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $items['clave_interna']; ?>
                                        </td>
                                        <td><?php echo $items['quantity']; ?></td>
                                        <td>
                                            <?php echo $items['unit_short_name']; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url('product_details/'.$items['product_id'])?>"><?php echo $items['product_name']; ?></a>
                                        </td>
                                        <td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['rate']):$this->cart->format_number($items['rate'])." ". $currency) ?></td>

                                        <td><?php echo (($position==0)?$currency ." ". $this->cart->format_number($items['rate'] * $items['quantity']):$this->cart->format_number($items['rate'] * $items['quantity'])." ". $currency) ?></td>
                                    </tr>

                                    <?php $i++;?>
                                <?php endforeach; ?>

                                </tbody>

                                <tfoot>
                                <?php
                                $total_tax = $cgst+$sgst+$igst;
                                if ($total_tax > 0) {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-right"><strong><?php echo 'IVA 16%';?>:</strong></td>
                                        <td class="text-right">
                                            <?php
                                            $total_tax = $cgst+$sgst+$igst;
                                            $this->_cart_contents['total_tax'] = $total_tax;
                                            echo (($position==0)?$currency ." ". number_format($total_tax, 2, '.', ','):number_format($total_tax, 2, '.', ',')." ". $currency)?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="5" class="text-right"><strong><?php echo display('total')?>:</strong></td>
                                    <td class="text-right">
                                        <?php
                                        $cart_total = $this->cart->total() + $this->_cart_contents['cart_ship_cost'] + $total_tax - $coupon_amnt;

                                        $this->session->set_userdata('cart_total',$cart_total);

                                        $total_amnt = $this->_cart_contents['cart_total'] = $cart_total;

                                        echo (($position==0)?$currency ." ". number_format($total_amount, 2, '.', ','):number_format($total_amount, 2, '.', ',')." ". $currency);
                                        ?>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <?php if($variante_entrega=="1"){ ?>
                                <div class="col-sm-12">
                                    <h3 class="text-center">El cliente pasa a recoger el producto</h3>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-12">
                                    <h3 class="text-center">Datos de Envío</h3>
                                </div>
                                <div class="form-group col-sm-5">
                                    <h4><?php echo display('customer_get_data'); ?><small>: {customer_name}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('phone_number'); ?><small>: {customer_phone_number}</small></h4>
                                </div>
                                <div class="form-group col-sm-3">
                                    <h4><?php echo display('street'); ?><small>: {customer_street}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('exter_number'); ?><small>: {customer_exter_number}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('inter_number'); ?><small>: {customer_inter_number}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('between'); ?><small>: {customer_between1}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('between'); ?><small>: {customer_between2}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('colony'); ?><small>: {customer_colony}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('delegation'); ?><small>: {customer_delegation}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('state'); ?><small>: {customer_state}</small></h4>
                                </div>
                                <div class="form-group col-sm-4">
                                    <h4><?php echo display('zip'); ?><small>: {customer_zip}</small></h4>
                                </div>
                                <div class="form-group col-sm-12">
                                    <h4><?php echo display('refer'); ?><small>: {customer_refer}</small></h4>
                                </div>
                            <?php }  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</section>
</div>
<!-- Manage order End -->
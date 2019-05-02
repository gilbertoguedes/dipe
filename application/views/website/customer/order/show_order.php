<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>

<!-- Edit order Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo "Administrar Pedidos"; ?></h1>
            <small><?php echo "Mi Pedido"; ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('order') ?></a></li>
                <li class="active"><?php echo "Mi Pedido"; ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- order report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <a href="<?php echo base_url('customer/order/manage_order')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-list"> </i><?php echo display('manage_order')?></a>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo "Mi Pedido"; ?></h4>
                        </div>
                    </div>
                    <?php echo form_open('Corder/order_update',array('class' => 'form-vertical','id'=>'validate' ))?>
                    <div class="panel-body">
             
                        <div class="row">
                        	<div class="col-sm-12">
                                <div class="form-group row">
                                    <h4 class="col-sm-3"><?php echo display('date'); ?>: <small>{date}</small></h4>
                                    <h4 class="col-sm-3"><?php echo "Método de Pago"; ?>: <small><?php echo "SANTANDER"; ?></small></h4>
                                    <h4 class="col-sm-3">Entregado: <small>NO</small></h4>
                                    <h4 class="col-sm-3">Facturado: <small><?php if($timbrado=="0")echo "NO"; else echo "SI"; ?></small>
                                    <?php if($timbrado=="0"){ ?>
                                    <a href="<?php echo base_url('/checkout_invoice/'.$order_id);  ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Facturar y timbrar"; ?>"><i class="ti-truck" aria-hidden="true"></i></a></h4>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('assets/timbrados/'.$order_id.'.pdf');  ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Descargar Factura PDF"; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                        <a href="<?php echo base_url('assets/timbrados/'.$order_id.'.xml'); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo "Descargar Factura XML"; ?>"><i class="fa fa-file-code-o" aria-hidden="true"></i></a>
                                    <?php }  ?>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td><strong><?php echo display('product_name')?></strong></td>
                                <td><strong><?php echo display('quantity')?></strong></td>
                                <td><strong><?php echo display('price')?></strong></td>
                                <td><strong><?php echo display('discount')?></strong></td>
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
                                        <a href="<?php echo base_url('product_details/'.$items['product_id'])?>"><?php echo $items['product_name']; ?></a>
                                    </td>
                                    <td><?php echo $items['quantity']; ?></td>
                                    <td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['rate']):$this->cart->format_number($items['rate'])." ". $currency) ?></td>

                                    <td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['discount']):$this->cart->format_number($items['discount'])." ". $currency) ?></td>

                                    <td><?php echo (($position==0)?$currency ." ". $this->cart->format_number($items['rate'] * $items['quantity']):$this->cart->format_number($items['rate'] * $items['quantity'])." ". $currency) ?></td>
                                </tr>

                                <?php $i++;?>
                            <?php endforeach; ?>

                            </tbody>

                            <tfoot>

                            <tr>
                                <td colspan="4" class="text-right"><strong><?php echo display('total_discount')?>:</strong></td>
                                <td class="text-right"><?php echo (($position==0)?$currency ." ". number_format($discount, 2, '.', ','):number_format($discount, 2, '.', ',')." ". $currency)?></td>
                            </tr>
                            <?php
                            $total_tax = $cgst+$sgst+$igst;
                            if ($total_tax > 0) {
                                ?>
                                <tr>
                                    <td colspan="4" class="text-right"><strong><?php echo display('total_tax')?>:</strong></td>
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
                                <td colspan="4" class="text-right"><strong><?php echo display('total')?>:</strong></td>
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
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit order End -->


<script type="text/javascript">
    // Counts and limit for invoice
    var rows = $('#normalinvoice tbody tr').length;
    var count = rows + 1;
    var limits = 500;

    //Add Invoice Field
    function addInputField(divName){

        if (count == limits)  {
            alert("You have reached the limit of adding " + count + " inputs");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="product_name_"+count;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });

            newdiv.innerHTML ='<tr><td><input type="text" name="product_name" onkeyup="invoice_productList('+count+');" class="form-control productSelection" placeholder="<?php echo display('product_name') ?>" required="" id="product_name_'+count+'" ><input type="hidden" class="autocomplete_hidden_value product_id_'+count+'" name="product_id[]"/><input type="hidden" class="sl" value="'+count+'"><input type="hidden" class="baseUrl" value="<?php echo base_url();?>" /></td><td class="text-center"> <select name="variant_id[]" id="variant_id_'+count+'" class="form-control variant_id" required="" style="width: 100%"><option value=""></option></select></td><td><input type="text" name="available_quantity[]"  class="form-control text-right available_quantity_'+count+'" id="avl_qntt_'+count+'" placeholder="0" readonly="" /></td><td><input type="number" name="product_quantity[]" onkeyup="quantity_calculate('+count+');" onchange="quantity_calculate('+count+');" id="total_qntt_'+count+'" class="form-control text-right" value="1" min="1" required="" /></td><td><input type="number" name="product_rate[]" onkeyup="quantity_calculate('+count+');" onchange="quantity_calculate('+count+');" placeholder="0.00" id="price_item_'+count+'" class="price_item'+count+' form-control text-right" required="" min="0" /></td><td><input type="number" name="discount[]" onkeyup="quantity_calculate('+count+');" onchange="quantity_calculate('+count+');" id="discount_'+count+'" class="form-control text-right" placeholder="0.00" min="0" /></td><td><input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_'+count+'" placeholder="0.00" readonly="readonly" /></td>'+

            '<td>'+
            <?php if ($tax['cgst_status'] == 1) { ?>

            '<input type="hidden" id="cgst_'+count+'" class="cgst"/> <input type="hidden" id="total_cgst_'+count+'" class="total_cgst" name="cgst[]" /> <input type="hidden" name="cgst_id[]" id="cgst_id_'+count+'">'+
            <?php }if ($tax['sgst_status'] == 1) { ?>

            '<input type="hidden" id="sgst_'+count+'" class="sgst"/> <input type="hidden" id="total_sgst_'+count+'" class="total_sgst" name="sgst[]"/><input type="hidden" name="sgst_id[]" id="sgst_id_'+count+'">'+

            <?php }if ($tax['igst_status'] == 1) { ?>

            '<input type="hidden" id="igst_'+count+'" class="igst"/><input type="hidden" id="total_igst_'+count+'" class="total_igst" name="igst[]"/><input type="hidden" name="igst_id[]" id="igst_id_'+count+'">'+
           <?php } ?>

            '<input type="hidden" id="total_discount_'+count+'" class="" /><input type="hidden" id="all_discount_'+count+'" class="total_discount"/><button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button></td></tr>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            count++;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        }
    }

    //Select stock by product and variant id
    $('body').on('change', '.variant_id', function() {

        var sl         = $(this).parent().parent().find(".sl").val();
        var product_id = $('.product_id_'+sl).val();
        var avl_qntt   = $('#avl_qntt_'+sl).val();
        var store_id   = $('#store_id').val();
        var variant_id = $(this).val();

        if (store_id == 0) {
            alert('<?php echo display('please_select_store')?>');
            return false;
        }

        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('Cpurchase/available_stock')?>',
            data: {product_id: product_id,variant_id:variant_id,store_id:store_id},
            success: function(data) {
                if (data == 0) {
                    $('#avl_qntt_'+sl).val('');
                    alert('<?php echo display('product_is_not_available_in_this_store')?>');
                    return false;
                }else{
                    $('#avl_qntt_'+sl).val(data);
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
</script>






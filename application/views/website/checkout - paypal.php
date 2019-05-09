<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ($this->cart->contents()) { ?>
<section class="checkout section-content bg padding-y-sm dipe-section-content">
    <div class="container">
        <div class="card p-2">
            <div class="row justify-content-center">
                <div class="col-md-5 col-sm-6 col-lg-4">
                    <?php
                    $message = $this->session->userdata('message');
                    if ($message) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $message?>
                        </div>
                        <?php
                        $this->session->unset_userdata('message');
                    }
                    ?>
                    <?php
                    $error_message = $this->session->userdata('error_message');
                    if ($error_message) {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $error_message?>
                        </div>
                        <?php
                        $this->session->unset_userdata('error_message');
                    }
                    ?>
                </div>
            </div>
            <form action="<?php echo base_url('submit_checkout')?>" onsubmit="this.querySelectorAll('input').forEach(i => i.disabled = false)" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" >
                <div id="wizard_form" >
                    <ul class="p-3">
                        <?php if (! $this->user_auth->is_logged()) { ?>
                            <!--<li><a href="#step-1"><?php echo display('checkout_options')?></a></li>-->
                        <?php } ?>
                        <li><a href="#step-1"><?php echo display('delivery_details')?></a></li>
                        <li><a href="#step-2"><?php echo display('payment_method')?></a></li>
                        <li><a href="#step-3"><?php echo display('confirm_order')?></a></li>
                    </ul>

                    <div class="wizard_inner">
                        <div id="step-1">
                            <div class="row justify-content-center mt-2">
                                <div class="p-xs-0 p-sm-0 p-md-2 p-lg-2 col-lg-6 ">
                                    <div id="select-step-0" role="form" data-toggle="validator" >
                                        <div class="form-group p-2">
                                            <input type="hidden" name="customer_email" value="<?php echo $this->session->userdata('customer_email'); ?>"/>
                                            <h6 class="dipe-h6"> Variante de entrega <i class="text-danger">*</i></h6>
                                            <select class="form-control" name="customer_variant" id="customer_variant" required data-required-error="Campo obligatorio.">
                                                <option value="">Seleccione</option>
                                                <option value="1">Paso a recoger</option>
                                                <option value="2">Enviar a domicilio</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-2" id="go-to-take">
                                <div class="box mt-sm-1 col-10 mt-md-2 mt-lg-3 dipe-color-6 mb-lg-5">
                                    <dl class="dlist-inline">
                                        <dt>Compañia: </dt>
                                        <dd> <?php echo $company_info['company_name']; ?></dd>
                                    </dl>
                                    <dl class="dlist-inline">
                                        <dt>Correo: </dt>
                                        <dd><?php echo $company_info['email']; ?></dd>
                                    </dl>
                                    <dl class="dlist-inline">
                                        <dt>Teléfono Móvil:</dt>
                                        <dd><?php echo $company_info['mobile']; ?></dd>
                                    </dl>
                                    <dl class="dlist-inline">
                                        <dt>Tienda:</dt>
                                        <dd><?php echo $store['store_name']; ?></dd>
                                    </dl>
                                    <dl class="dlist-inline">
                                        <dt>Dirección:</dt>
                                        <dd><?php echo $store['store_address']; ?></dd>
                                    </dl>
                                    <dl class="dlist-inline">
                                        <dt>Sitio Web:</dt>
                                        <dd><?php echo $company_info['website']; ?></dd>
                                    </dl>
                                </div> <!-- box.// -->
                            </div>

                            <?php if ($admin_profile_send_data_list) { ?>
                            <div class="row justify-content-center mt-2 mb-3" id="send-data-profile">
                                <div class="card p-0 col-10">
                                    <form class="bs-example" action="">
                                        <div class="panel-group" id="accordion">
                                            <?php foreach($admin_profile_send_data_list as $data) { ?>
                                            <div class="panel panel-default dipe-venta-datos-cliente-item rounded dipe-color-6">
                                                <div class="panel-heading ">
                                                    <h4 class="panel-title">
                                                        <label class="mb-0 dipe-font-size-1" >
                                                            <input type='radio' id="<?php echo $data['customer_information_send_data_id'];  ?>" name='dipe-datos-envio' value="<?php echo $data['customer_name'].'/'.$data['customer_phone_number'].'/'.$data['customer_street'].'/'.$data['customer_inter_number'].'/'.$data['customer_exter_number'].'/'.$data['customer_colony'].'/'.$data['customer_delegation'].'/'.$data['customer_state'].'/'.$data['customer_between1'].'/'.$data['customer_between2'].'/'.$data['customer_refer'].'/'.$data['customer_zip'].'/'.$data['customer_information_send_data_id']; ?>" /> <?php echo $data['customer_name'].' '.$data['customer_first_lastname']; ?>, <?php echo $data['customer_phone_number']; ?>
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>
                                                        </label>
                                                    </h4>
                                                </div>
                                                <div name="dipe-datos-envio-collapse" id="<?php echo "collapse-".$data['customer_information_send_data_id'];  ?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="box ">
                                                            <dl class="dlist-inline">
                                                                <dt>Recibe: </dt>
                                                                <dd> <?php echo $data['customer_name'].' '.$data['customer_first_lastname'].' '.$data['customer_secon_lastname']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Teléfono: </dt>
                                                                <dd><?php echo $data['customer_phone_number']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Dirección:</dt>
                                                                <dd><?php echo $data['customer_street'].' Número Exterior - '.$data['customer_exter_number'].' Número Interior - '.$data['customer_inter_number'].' Entre - '.$data['customer_between1'].' y - '.$data['customer_between2']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Colonia:</dt>
                                                                <dd><?php echo $data['customer_colony']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Delegacion:</dt>
                                                                <dd><?php echo $data['customer_delegation']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Estado:</dt>
                                                                <dd><?php echo $data['customer_state']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Código postal:</dt>
                                                                <dd><?php echo $data['customer_zip']; ?></dd>
                                                            </dl>
                                                            <dl class="dlist-inline">
                                                                <dt>Referencia:</dt>
                                                                <dd><?php echo $data['customer_refer']; ?></dd>
                                                            </dl>
                                                        </div> <!-- box.// -->
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="row justify-content-center mt-0 mb-5 p-0" id="send-data-form">
                                <div class="card p-xs-0 p-md-2 p-lg-4 col-10 mb-5">
                                    <div class="form-check dipe-gray-1-bg p-3" id="group_edit_data">
                                        <input class="form-check-input ml-2" onclick="checkboxEditData()" type="checkbox"  id="checkbox_customer_edit_data">
                                        <label class="form-check-label ml-4" for="checkbox_customer_edit_data">
                                            Editar Formulario
                                        </label>
                                    </div>
                                    <div class="form-check dipe-gray-1-bg p-3 mb-4 mt-2">
                                        <input type="hidden" id="customer_save_data"  name="customer_save_data" value="<?php if ($admin_profile_send_data_list) { echo '0'; }else{echo '1';}?>"/>
                                        <input class="form-check-input ml-2" onclick="checkboxSaveData()" type="checkbox" <?php if ($admin_profile_send_data_list==false) { echo 'checked'; }?> id="checkbox_customer_save_data">
                                        <label class="form-check-label ml-4" for="checkbox_customer_save_data">
                                            Guardar estos datos
                                        </label>
                                    </div>
                                    <div class="form-row" id="form-row1-step-0" role="form" data-toggle="validator">
                                        <div class="col-sm-1 col-md-6 form-group">
                                            <label>Recibe</label>
                                            <input type="text" placeholder="<?php echo display('names') ?>" class="form-control" id="customer_name" name="customer_name" data-required-error="Campo obligatorio." />
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col-sm-1 col-md-6 form-group">
                                            <label>Teléfono</label>
                                            <input type="text" placeholder="<?php echo display('phone_number') ?>" class="form-control" id="customer_phone_number" name="customer_phone_number" data-required-error="Campo obligatorio."  />
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                    </div> <!-- form-row end.// -->
                                    <div class="form-row" id="form-row2-step-0" role="form" data-toggle="validator">
                                        <div class="col-sm-1 col-md-6  form-group">
                                            <label>Calle</label>
                                            <input type="text" placeholder="<?php echo display('street') ?>" class="form-control" id="customer_street" name="customer_street" data-required-error="Campo obligatorio." data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col-sm-1 col-md-6 form-group">
                                            <label>Número exterior</label>
                                            <input type="text" placeholder="<?php echo display('exter_number') ?>" class="form-control" id="customer_exter_number" name="customer_exter_number" data-required-error="Campo obligatorio." />
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                    </div>
                                    <div class="form-row" id="form-row3-step-0" role="form" data-toggle="validator">
                                        <div class="col-sm-1 col-md-4 form-group">
                                            <label>Número interior</label>
                                            <input type="text" placeholder="<?php echo display('inter_number') ?>" class="form-control" id="customer_inter_number" name="customer_inter_number" />
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col-sm-1 col-md-4 form-group">
                                            <label>Entre</label>
                                            <input type="text" placeholder="<?php echo display('between') ?>" class="form-control" id="customer_between1" name="customer_between1" data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col-sm-1 col-md-4 form-group">
                                            <label>Entre</label>
                                            <input type="text" placeholder="<?php echo display('between') ?>" class="form-control" id="customer_between2" name="customer_between2" data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                    </div>
                                    <div class="form-row" id="form-row4-step-0" role="form" data-toggle="validator">
                                        <div class="col form-group">
                                            <label>Colonia</label>
                                            <input type="text" placeholder="<?php echo display('colony') ?>" class="form-control" id="customer_colony" name="customer_colony" data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col form-group">
                                            <label>Delegación/Municipio</label>
                                            <input type="text" placeholder="<?php echo display('delegation'); echo " / "; echo display('municipality'); ?>" class="form-control" id="customer_delegation" name="customer_delegation" data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col form-group">
                                            <label>Estado</label>
                                            <input type="text" placeholder="<?php echo display('state') ?>" class="form-control" id="customer_state" name="customer_state" data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                    </div>
                                    <div class="form-row" id="form-row5-step-0" role="form" data-toggle="validator">
                                        <div class="col form-group">
                                            <label>Código postal</label>
                                            <input type="text" placeholder="<?php echo display('zip') ?>" class="form-control" id="customer_zip" name="customer_zip" data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                    </div>
                                    <div class="form-row">
                                        <div class="col form-group">
                                            <label for="referencia">Referencia</label>
                                            <textarea   class="form-control" id="customer_refer" name="customer_refer"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="step-2">
                            <div class="row justify-content-center mt-5">
                                <div id="form-step-1" role="form" data-toggle="validator" class="step3_inner box mt-5 mb-5">
                                    <p><?php echo display('kindly_select_the_preferred_shipping_method_to_use_on_this_order')?></p>

                                    <!-- Cash on delivery payment method -->
                                    <!--<div class="radio">
                                <label>
                                    <input type="radio" name="payment_method" value="1" <?php if ($this->session->userdata('payment_method') == 1) {echo "checked ='checked'";} ?> checked>
                                    <?php echo display('cash_on_delivery')?>
                                 </label>
                            </div>-->

                                    <?php
                                    if ($bitcoin_status == 1) {
                                        ?>
                                        <!-- Bit coin payment method -->
                                        <!--<div class="radio">
                                <label>
                                   <input type="radio" name="payment_method" value="3" <?php if ($this->session->userdata('payment_method') == 3 ) { echo "checked = 'checked'"; } ?>>
                                   <img src="<?php echo base_url('my-assets/image/bitcoin.png')?>">
                                 </label>
                            </div>-->
                                    <?php } ?>

                                    <?php
                                    if ($payeer_status == 1) {
                                        ?>
                                        <!-- Payeer payment method -->
                                        <!--<div class="radio">
                                <label>
                                   <input type="radio" name="payment_method" value="4" <?php if ($this->session->userdata('payment_method') == 4 ) { echo "checked = 'checked'"; } ?>>
                                    <img src="<?php echo base_url('my-assets/image/payeer.png')?>">
                                 </label>
                            </div>-->
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="payment_method" value="4"  <?php if ($this->session->userdata('payment_method') == 4 ) { echo "checked = 'checked'"; } ?>>
                                            <img src="<?php echo base_url('my-assets/image/payeer.png')?>">
                                        </label>
                                    </div>
                                    <?php } ?>

                                    <?php
                                    if ($paypal_status == 1) {
                                        ?>
                                        <!-- Payeer payment method -->
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="payment_method" value="5"  checked="checked" /> <!--<?php if ($this->session->userdata('payment_method') == 5 ) { echo "checked = 'checked'"; } ?>-->
                                                <img src="<?php echo base_url('my-assets/image/paypal.png')?>">
                                            </label>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="control-label"><?php echo display('add_coment_about_your_payment')?></label>
                                        <textarea rows="8" class="form-control" id="payment_details"><?php echo $this->session->userdata('payment_details')?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-3">
                            <div class="row justify-content-center ">
                                <div id="form-step-2" role="form" data-toggle="validator" class="step4_inner mt-5 mb-5 box">
                                    <div>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <td><?php echo display('product_name')?></td>
                                                <td><?php echo display('quantity')?></td>
                                                <td><?php echo display('price')?></td>
                                                <!--<td><?php echo display('discount')?></td> -->
                                                <td><?php echo display('total')?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; $cgst = 0; $sgst = 0; $igst = 0; $discount = 0;$coupon_amnt=0; ?>
                                            <?php
                                            foreach ($this->cart->contents() as $items):
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
                                                        <a href="<?php echo base_url('product_details/'.$items['product_id'])?>"><?php echo $items['name']; ?></a>
                                                    </td>
                                                    <td><?php echo $items['qty']; ?></td>
                                                    <td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['price']):$this->cart->format_number($items['price'])." ". $currency) ?></td>

                                                    <!--<td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['discount']):$this->cart->format_number($items['discount'])." ". $currency) ?></td>-->

                                                    <td><?php echo (($position==0)?$currency ." ". $this->cart->format_number($items['price'] * $items['qty']):$this->cart->format_number($items['price'] * $items['qty'])." ". $currency) ?></td>
                                                </tr>

                                                <?php $i++;?>
                                            <?php endforeach; ?>

                                            </tbody>

                                            <tfoot>
                                            <?php
                                            $total_tax = $cgst+$sgst+$igst;
                                            $sub_total = $this->cart->total() - $total_tax;
                                            ?>
                                            <tr>
                                                <td colspan="3" class="text-right"><strong><?php echo /*display('total_discount')*/"Sub Total";?>:</strong></td>
                                                <td class="text-right"><?php echo (($position==0)?$currency ." ". number_format($sub_total, 2, '.', ','):number_format($sub_total, 2, '.', ',')." ". $currency)?></td>
                                            </tr>
                                            <?php
                                            if ($total_tax > 0) {
                                                ?>
                                                <tr>
                                                    <td colspan="3" class="text-right"><strong><?php echo display('total_tax')?>:</strong></td>
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
                                            <!--<tr>
                                            <td colspan="3" class="text-right"><strong><?php echo $this->_cart_contents['cart_ship_name']?>:</strong></td>
                                            <td class="text-right">
                                            <?php
                                            $total_ship_cost = $this->_cart_contents['cart_ship_cost'];
                                            $this->session->set_userdata('cart_ship_cost',$total_ship_cost);
                                            echo (($position==0)?$currency ." ". number_format($total_ship_cost, 2, '.', ','):number_format($total_ship_cost, 2, '.', ',')." ". $currency);
                                            ?>
                                            </td>
                                        </tr>-->
                                            <?php
                                            $coupon_amnt = $this->session->userdata('coupon_amnt');
                                            if ($coupon_amnt > 0) {
                                                ?>
                                                <tr>
                                                    <td colspan="3" class="text-right">
                                                        <strong><?php echo display('coupon_discount')?>:</strong>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        if ($coupon_amnt > 0) {
                                                            echo (($position==0)?$currency ." ". number_format($coupon_amnt, 2, '.', ','):number_format($coupon_amnt, 2, '.', ',')." ". $currency);
                                                        }

                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="3" class="text-right"><strong><?php echo display('total')?>:</strong></td>
                                                <td class="text-right">
                                                    <?php
                                                    $cart_total = $this->cart->total() /*+ $this->_cart_contents['cart_ship_cost'] + $total_tax - $coupon_amnt*/;

                                                    $this->session->set_userdata('cart_total',$cart_total);

                                                    $total_amnt = $this->_cart_contents['cart_total'] = $cart_total;

                                                    echo (($position==0)?$currency ." ". number_format($total_amnt, 2, '.', ','):number_format($total_amnt, 2, '.', ',')." ". $currency);
                                                    ?>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script type="text/javascript">
    //Retrive district
    $('body').delegate('.sw-btn-next', 'click', function() {
        var customer_variant = $('#customer_variant').val();
        var customer_name      = $('#customer_name').val();
        var customer_phone_number       = $('#customer_phone_number').val();
        var customer_exter_number  = $('#customer_exter_number').val();
        var customer_inter_number = $('#customer_inter_number').val();
        var customer_between1 = $('#customer_between1').val();
        var customer_between2 = $('#customer_between2').val();
        var customer_colony         = $('#customer_colony').val();
        var customer_delegation            = $('#customer_delegation').val();
        var customer_state             = $('#customer_state').val();
        var customer_zip         = $('#customer_zip').val();
        var customer_refer           = $('#customer_refer').val();
        var payment_method  = $('input[name=\'payment_method\']:checked').val();
        var delivery_details= $('#delivery_details').val();
        var payment_details = $('#payment_details ').val();

        $.ajax({
            type: "post",
            url: '<?php echo base_url('website/Home/account_info_save/')?>' + '1'/*$('input[name=\'account\']:checked').val()*/,
            data: {
                customer_variant:customer_variant,
                customer_name : customer_name,
                customer_phone_number:customer_phone_number,
                customer_exter_number:customer_exter_number,
                customer_inter_number:customer_inter_number,
                customer_between1:customer_between1,
                customer_between2:customer_between2,
                customer_colony:customer_colony,
                customer_delegation:customer_delegation,
                customer_state:customer_state,
                customer_zip:customer_zip,
                customer_refer:customer_refer,
                payment_method:payment_method,
                delivery_details:delivery_details,
                payment_details:payment_details
            },

            beforeSend: function() {
                $('#button-account').button('loading');
            },
            complete: function() {
                $('#button-account').button('reset');
            },
            success: function(html) {
                // location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
</script>


<script type="text/javascript">
    function account_type(){
        var account_type  = $('input[name=\'account\']:checked').val();
        $.ajax({
            type: "post",
            url: '<?php echo base_url('website/Home/account_type_save/')?>',
            data: { account_type:account_type },

            beforeSend: function() {
                $('#button-account').button('loading');
            },
            complete: function() {
                $('#button-account').button('reset');
            },
            success: function(html) {
                location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
</script>

<script type="text/javascript">
    function checkboxSaveData(){
        if($('#checkbox_customer_save_data').prop("checked") == true){
            $('#customer_save_data').val("1");
            console.log($('#customer_save_data').val());
        }
        else
        {
            $('#customer_save_data').val("0");
            console.log($('#customer_save_data').val());
        }
    }

    function checkboxEditData(){
        $('#checkbox_customer_save_data').removeAttr('disabled');
        $('#customer_name').removeAttr('disabled');
        $('#customer_phone_number').removeAttr('disabled');
        $('#customer_street').removeAttr('disabled');
        $('#customer_exter_number').removeAttr('disabled');
        $('#customer_inter_number').removeAttr('disabled');
        $('#customer_between1').removeAttr('disabled');
        $('#customer_between2').removeAttr('disabled');
        $('#customer_colony').removeAttr('disabled');
        $('#customer_delegation').removeAttr('disabled');
        $('#customer_state').removeAttr('disabled');
        $('#customer_zip').removeAttr('disabled');
        $('#customer_refer').removeAttr('disabled');

    }

</script>

<script type="text/javascript">
    //Retrive district
    $('body').on('click', '.shipping_cost', function() {
        var shipping_cost  = $(this).val();
        var ship_cost_name = $(this).attr('alt');
        var method_id      = $(this).attr('id');
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/set_ship_cost_cart')?>',
            data: {shipping_cost:shipping_cost,ship_cost_name:ship_cost_name,method_id:method_id},
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('<?php echo "Pagar";?>').addClass('btn submit_btn dipe-font-size-12').prop('disabled',true).on('click', function(){
            if( !$(this).hasClass('disabled')){
                var elmForm = $("#myForm");
                if(elmForm){
                    elmForm.validator('validate');
                    var elmErr = elmForm.find('.has-error');
                    if(elmErr && elmErr.length > 0){
                        alert('<?php echo display('please_fill_up_all_required_field')?>');
                        return false;
                    }else{
                        var x = confirm('<?php echo display('are_you_sure_want_to_order')?>');
                        if (x==true){
                            elmForm.submit();
                            return false;
                        }
                        return false;
                    }
                }
            }
        });
        var btnCancel = $('<button></button>').text('Cancelar').addClass('btn btn_cancel dipe-font-size-12 mr-2').on('click', function(){
            $('#wizard_form').smartWizard("reset");
            $('#myForm').find("input, textarea").val("");
        });

        // Smart Wizard
        $('#wizard_form').smartWizard({
            selected: 0,
            // disabledSteps:[1,2],
            cycleSteps:false,
            theme: 'dots',
            transitionEffect:'fade',
            toolbarSettings: {toolbarPosition: 'bottom',
                toolbarExtraButtons: [btnFinish, btnCancel]
            },
            anchorSettings: {
                markDoneStep: true, // add done css
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            }
        });

        $("#wizard_form").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

            if(stepNumber==0)
            {

                var selectForm = $("#select-step-0");
                var formRow1 = $("#form-row1-step-0");
                var formRow2 = $("#form-row2-step-0");
                var formRow3 = $("#form-row3-step-0");
                var formRow4 = $("#form-row4-step-0");
                var formRow5 = $("#form-row5-step-0");
                if(stepDirection === 'forward' && selectForm && formRow1 && formRow2 && formRow3 && formRow4 && formRow5){
                    selectForm.validator('validate');
                    formRow1.validator('validate');
                    formRow2.validator('validate');
                    formRow3.validator('validate');
                    formRow4.validator('validate');
                    formRow5.validator('validate');
                    var selectFormError = selectForm.children('.has-error');
                    var formRow1Error = formRow1.children('.has-error');
                    var formRow2Error = formRow2.children('.has-error');
                    var formRow3Error = formRow3.children('.has-error');
                    var formRow4Error = formRow4.children('.has-error');
                    var formRow5Error = formRow5.children('.has-error');

                    if(selectFormError.length > 0 || formRow1Error.length >0 || formRow2Error.length >0 || formRow3Error.length >0 || formRow4Error.length >0 || formRow5Error.length >0){
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            }

        });

        $("#wizard_form").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            // Enable finish button only on last step
            if(stepNumber == 2){
                $('.submit_btn').removeAttr('disabled');
                $('.submit_btn').addClass('pago-activado');
                $('.sw-btn-next').css({'display': 'none'});
            }else{
                $('.submit_btn').prop('disabled',true);
                $('.submit_btn').removeClass('pago-activado');
                $('.sw-btn-next').css({'display': 'inline-block'});
            }
        });

        $('.sw-btn-next').html('Siguiente');
        $('.sw-btn-prev').html('Anterior');
        $('.sw-btn-next').addClass('dipe-font-size-12');
        $('.sw-btn-prev').addClass('dipe-font-size-12');


    });
</script>

<script type="text/javascript">
    $('#go-to-take').css({'display': 'none'});
    $('#send-data-profile').css({'display': 'none'});
    $('#send-data-form').css({'display': 'none'});

    $('#group_edit_data').css({'display':'none'});

    /*$('.submit_prev').prop('disabled',true);*/


    $('#customer_variant').on('change', function() {
        var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {
            $('#go-to-take').css({'display': 'flex'});
            $('#send-data-profile').css({'display': 'none'});
            $('#send-data-form').css({'display': 'none'});

            $('#customer_phone_number').removeAttr("required");
            $('#customer_name').removeAttr("required");
            $('#customer_street').removeAttr("required");
            $('#customer_exter_number').removeAttr("required");
            /*$('#customer_inter_number').removeAttr("required");*/
            $('#customer_between1').removeAttr("required");
            $('#customer_between2').removeAttr("required");
            $('#customer_colony').removeAttr("required");
            $('#customer_delegation').removeAttr("required");
            $('#customer_state').removeAttr("required");
            $('#customer_zip').removeAttr("required");
        }else if (customer_variant == 2){
            $('#go-to-take').css({'display': 'none'});
            $('#send-data-profile').css({'display': 'flex'});
            $('#send-data-form').css({'display': 'flex'});

            $('#customer_name').prop('required',true);
            $('#customer_phone_number').prop('required',true);
            $('#customer_street').prop('required',true);
            $('#customer_exter_number').prop('required',true);
            /*$('#customer_inter_number').prop('required',true);*/
            $('#customer_between1').prop('required',true);
            $('#customer_between2').prop('required',true);
            $('#customer_colony').prop('required',true);
            $('#customer_delegation').prop('required',true);
            $('#customer_state').prop('required',true);
            $('#customer_zip').prop('required',true);
        }
        else
        {
            $('#go-to-take').css({'display': 'none'});
            $('#send-data-profile').css({'display': 'none'});
            $('#send-data-form').css({'display': 'none'});

            $("#customer_name").removeAttr("required");
            $('#customer_phone_number').removeAttr("required");
            $('#customer_street').removeAttr("required");
            $('#customer_exter_number').removeAttr("required");
            /*$('#customer_inter_number').removeAttr("required");*/
            $('#customer_between1').removeAttr("required");
            $('#customer_between2').removeAttr("required");
            $('#customer_colony').removeAttr("required");
            $('#customer_delegation').removeAttr("required");
            $('#customer_state').removeAttr("required");
            $('#customer_zip').removeAttr("required");

        }
    });
</script>


<script type="text/javascript">
    /*var $radios = $('input:radio[name=dipe-datos-envio]');
     if($radios.length > 0) {
     $($radios[0]).prop('checked', true);
     }*/

    $('input:radio[name=dipe-datos-envio]').click(function(){
        var datos = $('input:radio[name=dipe-datos-envio]:checked').val().split('/');
        $('#customer_name').val(datos[0]);
        $('#customer_phone_number').val(datos[1]);
        $('#customer_street').val(datos[2]);
        $('#customer_inter_number').val(datos[3]);
        $('#customer_exter_number').val(datos[4]);
        $('#customer_colony').val(datos[5]);
        $('#customer_delegation').val(datos[6]);
        $('#customer_state').val(datos[7]);
        $('#customer_between1').val(datos[8]);
        $('#customer_between2').val(datos[9]);
        $('#customer_refer').val(datos[10]);
        $('#customer_zip').val(datos[11]);
        var collapse = 'collapse-'+datos[12]
        $('div[name=dipe-datos-envio-collapse]').removeClass('out show');
        $('#'+collapse).addClass('out show');

        $('#checkbox_customer_save_data').prop('disabled',true);
        $('#customer_name').prop('disabled',true);
        $('#customer_phone_number').prop('disabled',true);
        $('#customer_street').prop('disabled',true);
        $('#customer_exter_number').prop('disabled',true);
        $('#customer_inter_number').prop('disabled',true);
        $('#customer_between1').prop('disabled',true);
        $('#customer_between2').prop('disabled',true);
        $('#customer_colony').prop('disabled',true);
        $('#customer_delegation').prop('disabled',true);
        $('#customer_state').prop('disabled',true);
        $('#customer_zip').prop('disabled',true);
        $('#customer_refer').prop('disabled',true);

        $('#group_edit_data').css({'display':'block'});
    });

</script>



<?php } ?>
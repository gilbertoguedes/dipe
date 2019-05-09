<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo form_open('home/update_cart'); ?>
<!-- ========================= SECTION CARRITO ========================= -->
<section class="section-content    section-carrito">
    <div class="container p-sm-0">

        <header class="section-heading">
            <h3 class="dipe-title-section title-section pt-5"><i class="fa fa-angle-right"></i> SU CARRITO DE COMPRAS</h3>
        </header>


        <?php if ($this->cart->contents()) { ?>
        <div class="card">
            <table class="table table-hover shopping-cart-wrap">
                <thead class="text-muted">
                <tr>
                    <th scope="col" class="dipe-max-widht-655">Producto</th>
                    <th scope="col" width="200">Cantidad</th>
                    <th scope="col" width="200">Precio</th>
                    <th scope="col" width="200" class="text-center">Eliminar</th>
                </tr>
                </thead>
                <tbody>
            <?php $i = 1; $cgst = 0; $sgst = 0; $igst = 0; $discount = 0; ?>
            <?php foreach ($this->cart->contents() as $items): ?>
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
                        <figure class="media">
                            <div class="img-wrap"><img src="<?php echo $items['options']['image']; ?>" class="img-thumbnail img-sm"></div>
                            <figcaption class="media-body">
                                <h6 class="title dipe-h6"><?php echo $items['name']; ?></h6>
                            </figcaption>
                        </figure>
                    </td>
<!--                    begin-->
                    <td>
                        <dl class="dlist-inline">
                            <dd>
                                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;" class="reduced items-count" type="button">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <input class="dipe-cart-cantidad-upanddown" type="text" name = "<?php echo $i.'[qty]'; ?>" id="sst" maxlength="12" value="<?php echo $items['qty']; ?>" title="<?php echo display('quantity') ?>" class="input-text qty" min="1">
                                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
                                    <i class="fa fa-angle-up"></i>
                                </button>
                                <div class="input-group-append d-inline">
                                    <!--<button class="btn btn-outline-secondary" type="button"><i class="fas fa-sync-alt"></i></button>-->
                                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-check"></i></button>
                                </div>
                                <!--aki va el componente ke esta en el ecomerce viejo-->
                            </dd>
<!--                           aki-->
                        </dl>  <!-- item-property .// -->

                    </td>
<!--                    end-->
                    <td>
                        <div class="price-wrap">
                            <var class="price">MX <?php echo (($position==0)?$currency . $this->cart->format_number($items['price']):$this->cart->format_number($items['price']). $currency) ?></var>
                            <span class="text-muted">Total: </span><span class="text-muted"><?php echo (($position==0)?$currency . $this->cart->format_number($items['subtotal']):$this->cart->format_number($items['subtotal']). $currency) ?> </span>
                        </div> <!-- price-wrap .// -->
                    </td>
                    <td class="text-center pl-sm-0">

                        <a href="<?php echo base_url('website/home/delete_cart_by_click/'.$items['rowid'])?>" class="btn btn-outline-danger"> × Eliminar</a>
                    </td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- card.// -->


        <div class="row justify-content-lg-end pb-5">
            <div class="col-md-auto col-lg-3 dipe-precios-carrito">


                <div class="box border mt-4">

                    <dl class="dlist-align">
                        <dt>SubTotal: </dt>
                        <dd class="text-right"><?php echo (($position==0)?$currency . number_format($this->cart->total()-$cgst, 2, '.', ','):number_format($this->cart->total()-$cgst, 2, '.', ','). $currency)?></dd>
                    </dl>


                    <?php $total_tax = $cgst+$sgst+$igst;
                    if ($total_tax > 0) { ?>
                    <dl class="dlist-align">
                            <dt>Total Impuestos: </dt>
                            <dd class="text-right"><?php
                                $total_tax = $cgst+$sgst+$igst;
                                    $total_tax = $cgst+$sgst+$igst;
                                    $this->_cart_contents['total_tax'] = $total_tax;
                                    echo (($position==0)?$currency ." ". number_format($total_tax, 2, '.', ','):number_format($total_tax, 2, '.', ',')." ". $currency);
                                ?>
                            </dd>
                    </dl>
                    <?php } ?>





                    <dl class="dlist-align">
                        <dt>Gran Total:</dt>
                        <dd class="text-right">
                            <?php
                            $cart_total = $this->cart->total() /*+ $total_tax - $this->session->userdata('coupon_amnt')*/;
                            $this->session->set_userdata('cart_total',$cart_total);
                            $total_amnt = $this->_cart_contents['cart_total'] = $cart_total;
                            echo (($position==0)?$currency ." ". number_format($total_amnt, 2, '.', ','):number_format($total_amnt, 2, '.', ',')." ". $currency);
                            ?>
                        </dd>
                    </dl>

                    <dl class="mt-4 ">
                        <a href="<?php echo base_url('checkout')?>" class="btn btn-primary btn-block"><?php echo display('checkout')?></a>
                    </dl>


                </div> <!-- box.// -->
            </div>
        </div>



        <?php } ?>





    </div> <!-- container .//  -->
</section>
<?php echo form_close()?>
<!-- ========================= SECTION POPULAR END// ========================= -->


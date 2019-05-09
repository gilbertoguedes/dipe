<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    if ($this->cart->contents()) {
?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('cart')?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
                <li class="breadcrumb-item active"><?php echo display('cart')?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->
<?php
if ($this->session->userdata('error_msg')) {
?>
<!--======== Message alert ========-->
<section class="coupon_area">
    <div class="container">
        <div class="row db coupon_inner" style="color: red">
            <?php 
                $error_msg = $this->session->userdata('error_msg');
                if ($error_msg) {
                    echo $error_msg;
                }
            ?> 
        </div>
    </div>
</section>
<!--======= Message alert ======-->

<?php
$this->session->unset_userdata('error_msg');
}
if ($this->session->userdata('message')) {
?>

<!--======== Message alert ========-->
<section class="coupon_area">
    <div class="container">
        <div class="row db coupon_inner" style="color: green">
            <?php 
                $message = $this->session->userdata('message');
                if ($message) {
                    echo $message;
                }
            ?> 
        </div>
    </div>
</section>
<!--======= Message alert ======-->
<?php
$this->session->unset_userdata('message');
}
?>

<?php echo form_open('home/update_cart'); ?>
<!--==========Shopping cart area==========-->
<div class="shopping_cart_area">
    <div class="container">
        <div class="shopping_cart_inner">
            <div class="table-responsive"> 
                <table class="table"> 
                    <thead> 
                        <tr> 
                            <th><?php echo display('image')?></th> 
                            <th><?php echo display('product_name')?></th> 
                            <th><?php echo display('quantity')?></th>
                            <th><?php echo display('price')?></th> 
                            <th><?php echo display('total')?></th> 
                            <th><?php echo display('delete')?></th> 
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
                            <td><img src="<?php echo $items['options']['image']; ?>" alt=""></td>
                            <td><?php echo $items['name']; ?></td>
                            <td><?php echo form_input(array('class' => 'text-center','name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?> <button type="submit"><i class="fa fa-refresh" style="font-size:20px;padding: 0px;"></i></button></td>
                            <td><?php echo (($position==0)?$currency . $this->cart->format_number($items['price']):$this->cart->format_number($items['price']). $currency) ?></td>
                            <td><?php echo (($position==0)?$currency . $this->cart->format_number($items['subtotal']):$this->cart->format_number($items['subtotal']). $currency) ?></td>
                            <td>
                                <a href="<?php echo base_url('website/home/delete_cart_by_click/'.$items['rowid'])?>">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>

                        <?php $i++; ?>
                        <?php endforeach; ?>
                       
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
</div>
<!--==========End Shopping cart area==========-->
<?php echo form_close()?>

<!--======== Coupon area ========-->
<!--<section class="coupon_area">
    <div class="container">
        <div class="row db coupon_inner">
            <h5><?php echo display('use_coupon_code')?></h5>
            <form action="<?php echo base_url('home/apply_coupon')?>" method="post">
                <div class="enter_coupon">
                    <label><?php echo display('enter_your_coupon_here')?>:</label>
                    <input type="text" name="coupon_code" placeholder="<?php echo display('enter_your_coupon_here')?>" required="">
                    <button type="submit"><?php echo display('apply_coupon')?></button>
                </div>
            </form>
        </div>
    </div>
</section>-->
<!--======= End coupon area ======-->

<!--======== Price area ======-->
<div class="price_area">
    <div class="container">
        <div class="row db m0 price_inner">
            <table class="pricing_list">
                <tbody>
                    <tr>
                        <td class="price_title">
                            <?php echo display('sub_total')?>
                        </td>
                        <td class="price_Currency">
                            <?php echo (($position==0)?$currency . number_format($this->cart->total()-$cgst, 2, '.', ','):number_format($this->cart->total()-$cgst, 2, '.', ','). $currency)?>
                        </td>
                    </tr>
                    <?php
                    $coupon_amnt = $this->session->userdata('coupon_amnt');
                    if ($coupon_amnt > 0) {
                    ?>
                    <tr>
                        <td class="price_title">
                            <?php echo display('coupon_discount')?>
                        </td>
                        <td class="price_Currency">
                            <?php
                            if ($coupon_amnt > 0) {
                            echo (($position==0)?$currency ." ". number_format($coupon_amnt, 2, '.', ','):number_format($coupon_amnt, 2, '.', ',')." ". $currency);
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                    $total_tax = $cgst+$sgst+$igst;
                    if ($total_tax > 0) {
                    ?>
                    <tr>
                        <td class="price_title">
                            <?php echo display('total_tax')?>
                        </td>
                        <td class="price_Currency">
                            <?php 
                            $total_tax = $cgst+$sgst+$igst;
                            if ($total_tax > 0) {
                            $total_tax = $cgst+$sgst+$igst;
                            $this->_cart_contents['total_tax'] = $total_tax;
                            echo (($position==0)?$currency ." ". number_format($total_tax, 2, '.', ','):number_format($total_tax, 2, '.', ',')." ". $currency);
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="price_title">
                            <?php echo display('grand_total')?>
                        </td>

                        <td class="price_Currency">
                            <?php
                                $cart_total = $this->cart->total() /*+ $total_tax - $this->session->userdata('coupon_amnt')*/;
                                $this->session->set_userdata('cart_total',$cart_total);
                                $total_amnt = $this->_cart_contents['cart_total'] = $cart_total;
                                echo (($position==0)?$currency ." ". number_format($total_amnt, 2, '.', ','):number_format($total_amnt, 2, '.', ',')." ". $currency);
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--======= End Price area======-->
<?php
}else{
?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('cart')?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
                <li class="breadcrumb-item active"><?php echo display('cart_empty')?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<!--========== Empty Cart Area ==========-->
<section class="shopping_cart_area">
    <div class="container">
        <div class="row db empty_cart">
            <img src="<?php echo base_url()?>assets/website/image/oops.png" alt="oops image">
            <h2 class="page_title"><?php echo display('oops_your_cart_is_empty')?></h2>
            <a href="<?php echo base_url()?>" class="base_button"><?php echo display('got_to_shop_now')?></a>
        </div>
    </div>
</section>
<!--========== End Empty Cart Area ==========-->      

<!--=========== Newsletter Area ===========-->
<section class="newsletter_area">
    <div class="container">
        <div class="row m0 newsletter_inner bg_gray">
            <div class="col-lg-6 col-xl-5">
                <div class="row m0 newsletter_left_area">
                    <h4><?php echo display('sign_up_for_news_and')?> <span><?php echo display('offers')?></span></h4>
                    <h6><?php echo display('you_may_unsubscribe_at_any_time')?></h6>
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div id="sub_msg"></div>
                <form action="" class="row m0 newsletter_form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="<?php echo display('enter_your_email')?>" required="" id="sub_email">
                        <span class="input-group-btn">
                            <button class="btn btn-default subscribe" type="button" id="smt_btn"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--========= End Newsletter Area =========-->

<?php
}
?>

<!-- Newsletter ajax code start-->
<script type="text/javascript">
    //Subscribe entry
    $('body').on('click', '#smt_btn', function() {
        var sub_email = $('#sub_email').val();
        if (sub_email == 0) {
            alert('<?php echo display('please_enter_email')?>');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/add_subscribe')?>',
            data: {sub_email:sub_email},
            success: function(data) {
                if (data == '2') {
                    $("#sub_msg").html('<p style="color:green"><?php echo display('subscribe_successfully')?></p>');
                    $('#sub_msg').hide().fadeIn('slow');
                    $('#sub_msg').fadeIn(700);
                    $('#sub_msg').hide().fadeOut(2000);
                    $("#sub_email").val(" ");
                }else{
                    $("#sub_msg").html('<p style="color:red"><?php echo display('failed')?></p>'); 
                    $('#sub_msg').hide().fadeIn('slow');
                    $('#sub_msg').fadeIn(700);
                    $('#sub_msg').hide().fadeOut(2000);
                    $("#sub_email").val(" ");
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }); 
</script>
<!-- Newsletter ajax code end-->

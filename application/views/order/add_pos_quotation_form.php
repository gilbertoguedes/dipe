<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>

<!-- Add new invoice start -->
<style>
	#bank_info_hide
	{
		display:none;
	}
    #payment_from_2
    {
        display:none;
    }
    /*Order and bill table*/
    #order_tbl,#bill_tbl {
        display: none;
    }
</style>

<!-- Printable area start -->
<script type="text/javascript">
function printDiv(divName) {

    var order_tbl = 0;
    $("#order-table tbody tr").each(function(i){
        order_tbl = order_tbl + 1;
    });

    var bill_tbl = 0;
    $("#bill-table tbody tr").each(function(i){
        bill_tbl = bill_tbl + 1;
    });

    if (order_tbl < 1) {
        alert('Please select product !');
    }else if( bill_tbl < 1){
        alert('Please select product !');
    }else{
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        // document.body.style.marginTop="-45px";
        window.print();
        document.body.innerHTML = originalContents;
    }
}
</script>
<!-- Printable area end -->



<!-- Customer type change by javascript start -->
<script type="text/javascript">
	function bank_info_show(payment_type)
	{
	    if(payment_type.value=="1"){
	        document.getElementById("bank_info_hide").style.display="none";
	    }
	    else{ 
	        document.getElementById("bank_info_hide").style.display="block";  
	    }
	}
        
    function active_customer(status)
    {
	    if(status=="payment_from_2"){
	        document.getElementById("payment_from_2").style.display="none";
	        document.getElementById("payment_from_1").style.display="block";
	        document.getElementById("myRadioButton_2").checked = false;
	        document.getElementById("myRadioButton_1").checked = true;
	    }
	    else{
	        document.getElementById("payment_from_1").style.display="none";
	        document.getElementById("payment_from_2").style.display="block";
	        document.getElementById("myRadioButton_2").checked = false;
	        document.getElementById("myRadioButton_1").checked = true;
	    }
    }

    //Payment method toggle 
    $(document).ready(function(){
        $(".payment_button").click(function(){
            $(".payment_method").toggle();

            //Select Option
            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        });
    });
</script>
<!-- Customer type change by javascript end -->

<!-- Add New Invoice Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-close"></i></div>
        <div class="header-title">
            <h1><?php echo display('pos_invoice')?></h1>
            <small><?php echo display('new_pos_invoice')?></small>
            <ol class="breadcrumb">
                <li><a href="#"><?php echo display('home')?></a></li>
                <li class="active"><?php echo display('pos_invoice')?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <div class="content">
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

        <!-- Print order for customer -->
        <div id="order_tbl">
            <span id="order_span">
                
            </span>

            <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%">
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <!-- End Print order for customer -->

        <!-- Print bill for customer -->
        <div id="bill_tbl">
            <span id="bill_span">
               
            </span>
            <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;">
                <tbody>
                    
                </tbody>
            </table>
            <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%">
                <tbody>
                    <tr class="bold">
                        <td><?php echo display('total_cgst')?></td>
                        <td class="total_cgst_bill" style="text-align:right;">0</td>
                    </tr>      
                    <tr class="bold">
                        <td><?php echo display('total_sgst')?></td>
                        <td class="total_sgst_bill" style="text-align:right;">0</td>
                    </tr>
                    <tr class="bold">
                        <td><?php echo display('total_igst')?></td>
                        <td class="total_igst_bill" style="text-align:right;">0</td>
                    </tr>    
                    <tr class="bold">
                        <td><?php echo display('total_discount')?></td>
                        <td class="total_discount_bill" style="text-align:right;">0</td>
                    </tr>
                    <tr class="bold">
                        <td class=""><?php echo display('grand_total')?></td>
                        <td class="total_bill" style="text-align:right;">00</td>
                    </tr>
                    <tr class="bold">
                        <td><?php echo display('items')?></td>
                        <td class="item_bill" style="text-align:right;">0</td>
                    </tr>
                </tbody>
            </table>
            <span id="bill_footer"><p class="text-center"><br><?php echo display('merchant_copy')?></p></span>
        </div>
        <!-- End Print bill for customer -->


        <?php echo form_open('Cinvoice/insert_customer', array('class' => 'form-vertical','id' => 'validate'))?>
            <div class="modal fade modal-warning" id="client-info" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title"><?php echo display('add_customer')?></h3>
                        </div>
                        
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"><?php echo display('name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control simple-control" name ="customer_name" id="name" type="text" placeholder="<?php echo display('customer_name') ?>"  required="">
                                </div>
                            </div>
       
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="email" id="email" type="email" placeholder="<?php echo display('customer_email') ?>"  required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('mobile') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="mobile" id="mobile" type="number" placeholder="<?php echo display('customer_mobile') ?>"  required="" min="0">
                                </div>
                            </div>
       
                            <div class="form-group row">
                                <label for="address " class="col-sm-3 col-form-label"><?php echo display('address') ?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('customer_address') ?>"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('close')?> </button>
                            <button type="submit" class="btn btn-success"><?php echo display('submit')?> </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        <?php echo form_close(); ?>

        <div class="modal fade modal-warning" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"></h3>
                    </div>
                    <form id="updateCart" action="#" method="post">
                        <div class="modal-body">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width:25%;"><?php echo display('price')?></th>
                                        <th style="width:25%;"><span id="net_price" class="price"></span></th>
                                    </tr>
                                </tbody>
                            </table>
              
                            <div class="form-group row">
                                <label for="available_quantity" class="col-sm-4 col-form-label"><?php echo display('available_quantity')?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="available_quantity" placeholder="<?php echo display('available_quantity')?>" name="available_quantity" readonly="readonly">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit')?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="unit" placeholder="<?php echo display('unit')?>" name="unit" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="<?php echo display('quantity')?>" class="col-sm-4 col-form-label"><?php echo display('quantity')?> <span class="color-red">*</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="<?php echo display('quantity')?>" name="quantity">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="<?php echo display('rate')?>" class="col-sm-4 col-form-label"><?php echo display('rate')?> <span class="color-red">*</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="<?php echo display('rate')?>" name="rate">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="<?php echo display('discount')?>" class="col-sm-4 col-form-label"><?php echo display('discount')?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="<?php echo display('discount')?>" placeholder="<?php echo display('discount')?>" name="discount">
                                </div>
                            </div>
                            <input type="hidden" name="rowID">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('close')?></button>
                            <button type="submit" class="btn btn-success"><?php echo display('save_changes')?></button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="row">
            <div class="col-sm-8">
                <form class="navbar-search" method="get" action="/">
                    <label class="sr-only screen-reader-text" for="search"><?php echo display('search')?>:</label>
                    <div class="input-group">
                        <input type="text" id="product_name" class="form-control search-field" dir="ltr" value="" name="s" placeholder="<?php echo display('search_by_product')?>" />

                        <div class="input-group-addon search-categories">
                            <select name='category_id' id='category_id' class='postform resizeselect form-control' >
                                <option value='0' selected='selected'>All Categories</option>
                            <?php
                            if ($category_list) {
                                foreach ($category_list as $category) {
                                ?>
                                <option value="<?php echo $category->category_id?>"><?php echo $category->category_name?></option>
                                <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-secondary" id="search_button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </form>
                <div class="product-grid">
                    <div class="row row-m-3" id="product_search">
                    <?php
                    if ($product_list) {
                        foreach ($product_list as $product) {
                    ?>
                        <div class="col-xs-6 col-sm-4 col-md-2 col-p-3">
                            <div class="panel panel-bd product-panel select_product">
                                <div class="panel-body">
                                    <img src="<?php echo $product->image_thumb?>" class="img-responsive" alt="">
                                    <input type="hidden" name="select_product_id" class="select_product_id" value="<?php echo $product->product_id?>">
                                </div>
                                <div class="panel-footer"><?php echo $product->product_model .'-'. $product->product_name?></div>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>   
            <div class="col-sm-4">
            <?php echo form_open_multipart('Cinvoice/insert_invoice',array('class' => 'form-vertical', 'id' => 'validate'))?>
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <div class="client-add">
                            <div class="form-group">
                                <label for="customer_name"><?php echo display('customer_name')?> <span class="color-red">*</span></label>
                                <select id="customer_name" class="form-control" name="customer_id" required="">
                                    <?php
                                    if ($customer_details) {
                                        foreach ($customer_details as $customer) {
                                        ?>
                                            <option value="<?php echo $customer->customer_id?>"><?php echo $customer->customer_name?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <optgroup label="Others">
                                    <?php
                                    if ($customer_list) {
                                        foreach ($customer_list as $customer_det) {
                                        ?>
                                            <option value="<?php echo $customer_det->customer_id?>"><?php echo $customer_det->customer_name?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                    </optgroup>
                                </select>
                            </div>
                            <a href="#" class="client-add-btn" aria-hidden="true" data-toggle="modal" data-target="#client-info"><i class="ti-plus m-r-2"></i><?php echo display('new_customer')?> </a>
                        </div>

                        <div class="form-group">
                            <label for="store_name"><?php echo display('store_name')?> <span class="color-red">*</span></label>
                            <select id="store_name" class="form-control" name="store_id" required="">
                                <option value=""></option>
                                <?php
                                if ($store_list) {
                                    foreach ($store_list as $store) {
                                    ?>
                                        <option value="<?php echo $store->store_id?>"><?php echo $store->store_name?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="product_name" class="form-control" placeholder='<?php echo display('barcode_qrcode_scan_here') ?>' id="add_item" autocomplete='off'>
                            <?php date_default_timezone_set("Asia/Dhaka"); $date = date('m-d-Y'); ?>
                            <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" required value="<?php echo $date; ?>" />
                            <input type="hidden" id="product_value" name="">
                        </div>
                        
                        <div class="product-list">
                            <div class="table-responsive">
                                <table class="table table-bordered" border="1" width="100%" id="addinvoice">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('item')?></th>
                                            <th><?php echo display('price')?></th>
                                            <th><?php echo display('quantity')?></th>
                                            <th><?php echo display('total')?></th>
                                            <th width="19%"><?php echo display('action')?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="itemNumber">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="table-responsive total-price">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo display('item') ?></th>
                                        <td id="item-number">0</td>
                                        <th><?php echo display('total_cgst') ?></th>
                                        <td><input type="text" id="total_cgst" class="form-control text-right" name="total_cgst" tabindex="-1" value="0.00" readonly="readonly" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo display('total_sgst') ?></th>
                                        <td><input type="text" id="total_sgst" class="form-control text-right" name="total_sgst" tabindex="-1" value="0.00" readonly="readonly" /></td>
                                        <th><?php echo display('total_igst') ?></th>
                                        <td><input type="text" id="total_igst" class="form-control text-right" name="total_igst" tabindex="-1" value="0.00" readonly="readonly" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo display('total_discount') ?></th>
                                        <td><input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" tabindex="-1" value="0.00" readonly="readonly" /></td>
                                        
                                        <th><?php echo display('invoice_discount') ?></th>
                                        <td><input type="text" id="invoice_discount" class="form-control text-right" name="invoice_discount" tabindex="-1" value="0.00" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);"/></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo display('grand_total') ?></th>
                                        <td><input type="text" id="grandTotal" tabindex="-1" class="form-control text-right" name="grand_total_price" value="0.00" readonly="readonly" /></td>
                                        <th scope="row"><?php echo display('paid_ammount') ?></th>
                                        <td>
                                            <input type="text" id="paidAmount" 
                                            onkeyup="invoice_paidamount();"  tabindex="-1" class="form-control text-right" name="paid_amount" value="0.00" />
                                         </td>
                                        
                                    </tr>

                                     <tr>
                                        <th><?php echo display('due') ?></th>
                                        <td><input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="0.00" readonly="readonly"/></td>
                                        <th></th>
                                        <td></td>
                                    </tr>

                                    <!-- Payment method -->
                                    <tr class="payment_method" style="display: none">
                                        <td colspan="7">
                                             <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="terminal" class="col-sm-4 col-form-label"><?php echo display('terminal') ?>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="terminal" id="terminal" required="">
                                                            <option value=""></option>
                                                                {terminal_list}
                                                                <option value="{pay_terminal_id}">{terminal_name}</option>
                                                                {/terminal_list}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="card_type" class="col-sm-4 col-form-label"><?php echo display('card_type') ?>: </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="card_type" id="card_type" required="">
                                                                <option>Credit Card</option>
                                                                <option>Debit Card</option>
                                                                <option>Master Card</option>
                                                                <option>Amex</option>
                                                                <option>Visa</option>
                                                                <option>Paypal</option>
                                                                <option>Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                    <label for="card_no" class="col-sm-4 col-form-label"><?php echo display('card_no') ?>:</label>
                                                        <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="card_no" id="card_no" placeholder="<?php echo display('card_no') ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-info m-b-5" onclick="printDiv('order_tbl')"><?php echo display('print_order')?></button>
                        <button type="button" class="btn btn-success m-b-5" onclick="printDiv('bill_tbl')"><?php echo display('print_bill')?></button>
                        <input  class="btn btn-warning m-b-5" value="<?php echo display('full_paid') ?>" onclick="full_paid();" type="button">
                        <button type="button" class="btn btn-purple m-b-5 payment_button"><?php echo display('payment')?></button>
                        <button type="button" class="btn btn-danger m-b-5"><?php echo display('cancel')?></button>
                        <button type="submit" class="btn btn-purple m-b-5"><?php echo display('submit')?></button>
                    </div>
                </div>
            <?php echo form_close();?>
            </div>
        </div>
    </div> 
    <!-- /.content -->
</div>
<!-- POS Invoice Report End -->

<!-- Modal ajax call start -->
<script type="text/javascript">

    $('#myModal').on('show.bs.modal', function (event) {
          var button   = $(event.relatedTarget); 
          var modal    = $(this);
          var rowID    = button.parent().parent().attr('id');
          var product_name =  $("#product_name_"+rowID).text();
          var rate     = $("#price_item_"+rowID).val();
          var quantity = $("#total_qntt_"+rowID).val(); 
          var available_quantity = $(".available_quantity_"+rowID).val();
          var unit      = $(".unit_"+rowID).val(); 
          var discount  = $("#discount_"+rowID).val(); 

          modal.find('.modal-title').text(product_name);
          modal.find('.modal-body input[name=rowID]').val(rowID);
          modal.find('.modal-body input[name=product_name]').val(product_name);
          modal.find('.modal-body input[name=rate]').val(rate);
          modal.find('.price').text(rate);
          modal.find('.modal-body input[name=quantity]').val(quantity);
          modal.find('.modal-body input[name=available_quantity]').val(available_quantity);
          modal.find('.modal-body input[name=unit]').val(unit);
          modal.find('.modal-body input[name=discount]').val(discount);
    });

    //Update POS cart
    $('#updateCart').on('submit', function (e) {
        e.preventDefault();
        var rate = $(this).find('input[name=rate]').val();
        var quantity = $(this).find('input[name=quantity]').val();
        var discount = $(this).find('input[name=discount]').val();
        var rowID = $(this).find('input[name=rowID]').val();

        $("#price_item_"+rowID).val(rate);
        $("#total_qntt_"+rowID).val(quantity); 
        $("#total_price_"+rowID).val(quantity*rate);
        $("#discount_"+rowID).val(discount);
        $("#total_discount_"+rowID).val(discount);
        $("#all_discount_"+rowID).val(discount * quantity); 

        calculateSum();
        invoice_paidamount();
     
        $('#myModal').modal('hide'); 
    });
</script>
<!-- Modal ajax call start -->

<script type="text/javascript">

    //Onload filed select
    window.onload = function(){
      var text_input = document.getElementById ('add_item');
      text_input.focus ();
      text_input.select ();
    }

    //POS Invoice js
    $('#add_item').keydown(function(e) {
        if (e.keyCode == 13) {
            var product_id = $(this).val();

            if (product_id) {

                $.ajax({
                    type: "post",
                    async: false,
                    url: '<?php echo base_url('Cinvoice/insert_pos_invoice')?>',
                    data: {product_id: product_id},
                    success: function(data) {
                        if (data == false) {
                            alert('This Product Not Found !');
                            document.getElementById('add_item').value = '';
                            document.getElementById('add_item').focus();
                        }else{
                            //$("#hidden_tr").css("display", "none");
                            document.getElementById('add_item').value = '';
                            document.getElementById('add_item').focus();
                            $('#addinvoice tbody').append(data);
                            calculateSum();
                            invoice_paidamount();
                        }
                        $('#item-number').html('0');
                        $(".itemNumber>tr").each(function(i){
                            $('#item-number').html(i+1);
                        });

                    },
                    error: function() {
                        alert('Request Failed, Please check your code and try again!');
                    }
                });
            }
        }
    });    

    //Product search js
    $('body').on('keyup', '#product_name', function() {
        var product_name = $(this).val();
        var category_id = $('#category_id').val();
        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('Cinvoice/search_product')?>',
            data: {product_name: product_name,category_id:category_id},
            success: function(data) {
                if (data == '420') {
                    $("#product_search").html('Product not found !');
                }else{
                    $("#product_search").html(data); 
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });

    //Product search js
    $('body').on('change', '#category_id', function() {
        var product_name = $('#product_name').val();
        var category_id = $('#category_id').val();
        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('Cinvoice/search_product')?>',
            data: {product_name: product_name,category_id:category_id},
            success: function(data) {
                if (data == '420') {
                    $("#product_search").html('Product not found !');
                }else{
                    $("#product_search").html(data); 
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });      

    //Product search button js
    $('body').on('click', '#search_button', function() {
        var product_name = $('#product_name').val();
        var category_id = $('#category_id').val();
        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('Cinvoice/search_product')?>',
            data: {product_name: product_name,category_id:category_id},
            success: function(data) {
                if (data == '420') {
                    $("#product_search").html('Product not found !');
                }else{
                    $("#product_search").html(data); 
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });    


    //Product search button js
    $('body').on('click', '.select_product', function(e) {
        e.preventDefault();

        var today = new Date();
        var date = (today.getMonth()+1)+'-'+today.getDate()+'-'+today.getFullYear();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date+' '+time;
        var user_name = '<?php echo $this->session->userdata('user_name'); ?>';

        var panel = $(this);
        var product_id = panel.find('.panel-body input[name=select_product_id]').val();
        $.ajax({
            type: "post",
            dataType:"json",
            async: false,
            url: '<?php echo base_url('Cinvoice/insert_pos_invoice')?>',
            data: {product_id: product_id},
            success: function(data) {

                if (data.item == 0) {
                    alert('Product Not Found !');
                    document.getElementById('add_item').value = '';
                    document.getElementById('add_item').focus();
                }else{
                    document.getElementById('add_item').value = '';
                    document.getElementById('add_item').focus();
                    $('#addinvoice tbody').append(data.item);
                    $('#order-table tbody').append(data.order);
                    $('#bill-table tbody').append(data.bill);


                    $("#order_span").empty(); 
                    $("#bill_span").empty();
                    var styles = '<style>table, th, td { border-collapse:collapse; border-bottom: 1px solid #CCC; } .no-border { border: 0; } .bold { font-weight: bold; }</style>';

                    var pos_head1 = '<span style="text-align:center;"><h3>ERP Solution</h3><h4>';
                    var pos_head2 = '</h4><p class="text-left">C: '+$('#select2-customer_name-container').text()+'<br>U: '+user_name+'<br>T: '+dateTime+'</p></span>';

                    $("#order_span").prepend(styles + pos_head1+'Order'+pos_head2);

                    $("#bill_span").prepend(styles + pos_head1+'Bill'+pos_head2);
                    //$("#order-table").empty(); 
                    //$("#bill-table").empty();


                    var addSerialNumber = function () {
                        var i = 1
                        $('#order-table tbody tr').each(function(index) {
                            $(this).find('td:nth-child(1)').html('#'+(index+1));
                        });
                        $('#bill-table tbody tr').each(function(index) {
                            $(this).find('td:nth-child(1)').html('#'+(index+1));
                        });
                    };
                    addSerialNumber();
                   
                    calculateSum();
                    invoice_paidamount();
                }

                //Total items count
                $('#item-number').html('0');
                $(".itemNumber>tr").each(function(i){
                    $('#item-number').html(i+1);
                    $('.item_bill').html(i+1);
                });

            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
</script>
<?php
    $CI =& get_instance();
    $CI->load->model('Soft_settings');
    $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
    $image =  $Soft_settings[0]['invoice_logo'];
    $invoice_logo = "my-assets/image/logo/".substr($image, strrpos($image, '/') + 1);
?>
<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i);
    body{
        margin: 0;
        padding: 0;
        font-family:'Alegreya Sans',sans-serif;
        font-size: 9px;
        text-transform: uppercase;
    }
    address{
        text-align: center;

    }
    h4{
        text-align: center;
        font-size: 12px !important;
    }

    .datos-cliente{
        border: 1px solid lightslategray;
        padding: 10px;
    }

    .datos-cliente{
        border: 1px solid lightslategray;
        padding: 10px;
        margin-bottom: 5px;
    }
</style>
<!-- Order pdf start -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div id="printableArea">
                <div class="panel-body">
                    <div class="row" style="height: 118px">
                        <div class="col-sm-2" style="display: inline-block;width: 15%">
                            <img src="<?php if (isset($invoice_logo)) {echo $invoice_logo; }?>" class="" alt="" style="margin-bottom:5px;height: 60px;margin-left: 0px">
                            <br>
                        </div>
                        <div class="col-sm-5" style="display: inline-block;width: 45%">
                            <!--<span class="label label-success-outline m-r-15 p-10" ><?php echo display('order_to') ?></span>-->
                            {company_info}
                                <h4>{company_name}</h4>
                                <address>
                                    DPP8607174L9<br>
                                    Personas morales regimen general de ley<br>
                                    {address}
                                </address>
                            {/company_info}
                        </div>
                    </div>
                    <div class="row datos-cliente" style="height: 15px">
                        <div class="col-sm-12">
                            <strong>facturar a:</strong> {customer_id} {customer_name}
                        </div>
                    </div>
                    <div class="row datos-cliente" style="height: 50px">
                        <div class="col-sm-12">
                            <strong>dirección de envío:</strong> {customer_address}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order pdf end -->
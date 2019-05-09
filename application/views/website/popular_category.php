<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
$default_currency_id =  $this->session->userdata('currency_id');
$currency_new_id     =  $this->session->userdata('currency_new_id');

if (empty($currency_new_id)) {
    $result  =  $cur_info = $this->db->select('*')
        ->from('currency_info')
        ->where('default_status','1')
        ->get()
        ->row();
    $currency_new_id = $result->currency_id;
}

if ($currency_new_id) {
    $cur_info = $this->db->select('*')
        ->from('currency_info')
        ->where('currency_id',$currency_new_id)
        ->get()
        ->row();

    $target_con_rate = $cur_info->convertion_rate;
    $position1 = $cur_info->currency_position;
    $currency1 = $cur_info->currency_icon;
}
?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm dipe-section-content">
<div class="container">
<div class="card">
    <div class="card-body">
        <div class="row">

            <nav class="col-md-18-24">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo display('home')?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo $category_name; ?></a></li>
                    <!--<li class="breadcrumb-item"><a href="#"><?php echo display('category')?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Items</li>-->
                </ol>
            </nav> <!-- col.// -->

        </div> <!-- row.// -->


    </div> <!-- card-body .// -->
</div> <!-- card.// -->

<div class="padding-y-sm">
    <!--<span>3897 results for "Item"</span>-->
</div>

<div class="row-sm">
<?php if ($popular_category) { ?>
<?php foreach ($popular_category as $popular) {
?>
<div class="col-md-4 col-sm-6 col-lg-3">
    <a href="<?php echo base_url('category/'.$popular->category_id)?>" class="itembox  ">
        <div class="card card-body p-0 p-md-0 p-lg-3 mt-3 hover01">
            <figure class="itemside ">
                <div class="aside"><div class="img-wrap img-sm"><img src="<?php echo $popular->cat_image?>"></div></div>
                <figcaption class="p-2 align-self-center dipe-popular-caption">
                    <h6 class="title"><?php echo $popular->category_name?></h6>
                    <!--<a href="#">More details</a>-->
                </figcaption>
            </figure>
        </div>
    </a>
</div>
<?php } ?>
<?php } ?>
</div> <!-- row.// -->
<nav aria-label="page navigation example">
    <?php echo $links?>
</nav>

</div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->

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



        </div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->

<section class="bg padding-y-sm dipe-section-content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <?php foreach($category_list as $cat_parent){ ?>
                    <div class="row text-center mb-4 mt-2">
                        <div class="col-md-24-24">
                            <h4><?php echo $cat_parent->category_name; ?></h4>
                        </div>
                    </div>
                    <?php $family_cat =  $this->db->select('*')
                    ->from('product_category')
                    ->where('parent_category_id',$cat_parent->category_id)
                    ->order_by('category_name')
                    ->get()
                    ->result();
                    ?>
                    <?php if($family_cat){ ?>
                    <?php foreach($family_cat as $family){ ?>
                        <div class="row mt-3 mb-1">
                            <div class="col-md-24-24">
                                <h6><?php echo $family->category_name; ?></h6>
                            </div>
                        </div>
                        <?php
                        $subfamily_cat =  $this->db->select('*')
                            ->from('product_category')
                            ->where('parent_category_id',$family->category_id)
							->where('parent_category_nivel2',$cat_parent->category_id)
                            ->order_by('category_name')
                            ->get()
                            ->result();
                        if ($subfamily_cat) { ?>
                            <div class="row">
                            <?php foreach ($subfamily_cat as $s_p_cat) { ?>
                                <div class="col-md-6-24 mb-1">
                                    <a href="<?php echo base_url('category/'.$s_p_cat->category_id)?>"> - <?php echo ucwords(mb_strtolower($s_p_cat->category_name,"UTF-8"))?></a>
                                </div>
                            <?php } ?>
                            </div>
                    <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?php } ?>
            </div> <!-- card-body .// -->
        </div> <!-- card.// -->
    </div>
</section>
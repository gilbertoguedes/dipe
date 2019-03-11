<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('about_us')?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
                <li class="breadcrumb-item active"><?php echo display('about_us')?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->
        
<!--==== welcome  Area ========-->
<section class="welcome_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row m0 db img_area">
                    <img src="<?php echo $image?>" alt="Img">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="welcome_inner">
                    <?php echo $headlines?>
                    <?php echo $details?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==== End welcome Area ====-->
        
<!--====== Start Choose Us Area ======-->
<section class="choose_us_area bg-gray">
    <div class="container">
        <div class="row db choose_us_inner">
            <div class="row m0 section_title">
                <h2><?php echo display('why_choose_us')?></h2>
            </div>
            <div class="row m0 choose_us_main">
                <?php 
                if ($about_content_info) {
                    foreach ($about_content_info as $about_content) {
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="row choose_us">
                        <div class="icon_part">
                            <?php echo $about_content['icon']?>
                        </div>
                        <div class="choose_info">
                            <?php echo $about_content['headline']?>
                            <?php echo $about_content['details']?>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } 
                ?>
            </div>
        </div>
    </div>
</section>
<!--========== End Choose Us Area ==========-->

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
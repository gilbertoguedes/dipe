<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('sign_up')?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
                <li class="breadcrumb-item active"><?php echo display('sign_up')?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<!--========== Sign Up Area ==========-->
<div class="login_page">
    <div class="container">
        <div class="row db m0 login_area">
            <?php
                if ($this->session->userdata('error_message')) {
                $message = $this->session->userdata('error_message');
                if ($message) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>
            </div>
            <?php
                }
                $this->session->unset_userdata('error_message');
                }
            ?>
            <h2><?php echo display('create_your_account')?></h2>
            <form class="login_content signup_content" action="<?php echo base_url('user_signup')?>" method="post">
                <div class="user_info">
                    <input type="text" name="first_name" placeholder="<?php echo display('first_name')?>" required>
                    <br>
                    <input type="text" name="last_name" placeholder="<?php echo display('last_name')?>" required>
                    <br>
                    <input type="email" name="email" placeholder="<?php echo display('email')?>" required>
                    <br>
                    <input type="password" name="password" placeholder="<?php echo display('password')?>" required>
                    <br>
                    <button type="submit" class="base_button"><?php echo display('create_account')?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--========== End Sign Up Area ==========-->

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
            alert('Please enter email.');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/add_subscribe')?>',
            data: {sub_email:sub_email},
            success: function(data) {
                if (data == '2') {
                    $("#sub_msg").html('<p style="color:green">Subscribe successfully.</p>');
                    $('#sub_msg').hide().fadeIn('slow');
                    $('#sub_msg').fadeIn(700);
                    $('#sub_msg').hide().fadeOut(2000);
                    $("#sub_email").val(" ");
                }else{
                    $("#sub_msg").html('<p style="color:red>Failed !</p>'); 
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
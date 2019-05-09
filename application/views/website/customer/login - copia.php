<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--========== Alert Message ==========-->
<div class="login_page">
    <div class="container">
        <div class="row db m0 login_area">
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
</div>
<!--========== Alert Message ==========-->

<!--========== Login Area ==========-->
<div class="login_page">
    <div class="container">
        <div class="row db m0 login_area">
            <div class="img_part">
                <img src="<?php echo base_url()?>assets/website/image/login.png" alt="Avatar" class="Login Image">
            </div>
            <form class="login_content" action="<?php echo base_url('do_login')?>" method="post">
                <div class="user_info">
                    <label><b><?php echo display('email')?></b></label>
                    <input type="email" placeholder="<?php echo display('email')?>" name="email" required>
                    <br>
                    <label><b><?php echo display('password')?></b></label>
                    <input type="password" placeholder="<?php echo display('password')?>" name="password" required>
                    <br>
                    <input type="checkbox" checked="checked"><span>Remember me</span>
                    <button type="submit" class="base_button"><?php echo display('login')?></button>
                </div>
                <div class="other_link">
                    <!-- <div class="forgetpw"><span><?php echo display('i_have_forgot_my_password')?></span><a href="#"><?php echo display('password')?></a></div> -->
                    <div class="create_account"><a href="<?php echo base_url('signup')?>" class="base_button"><?php echo display('create_account')?></a></div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--========== End Login Area ==========-->

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
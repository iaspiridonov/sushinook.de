<?php global $typeform; ?>
<div class="form-tab-rcl" id="remember-form-rcl">
<!-- 	<div class="form_head form_rmmbr">
            <a href="#" class="link-login-rcl link-tab-rcl "><?php _e('Authorization','wp-recall'); ?></a>
            <?php if($typeform!='sign'){ ?>
                <a href="#" class="link-register-rcl link-tab-rcl "><?php _e('Registration','wp-recall'); ?></a>
            <?php } ?>
	</div> -->
    <!-- <span class="form-title"><?php _e('Password generation','wp-recall'); ?></span> -->

   <!--  <div class="form-block-rcl"><?php rcl_notice_form('remember'); ?></div> -->

    <?php if(!isset($_GET['success'])){ ?>
        <form id="rememberForm" action="<?php echo wp_lostpassword_url(); ?>" method="post">
            <!-- <div class="form-block-rcl default-field"> -->
                <input required type="text" placeholder="<?php _e('Username or e-mail','wp-recall'); ?>" value="" name="user_login">
                <!-- <i class="fa fa-key"></i> -->
            <!-- </div> -->
            <!-- <div class="form-block-rcl"> -->
                <?php do_action( 'lostpassword_form' ); ?>
            <!-- </div>
            <div class="form-block-rcl"> -->
                
                <?php echo wp_nonce_field('remember-key-rcl','_wpnonce',true,false); ?>
                <input type="hidden" name="redirect_to" value="<?php rcl_referer_url('remember'); ?>">
                <p>
                <button form="rememberForm" type="submit" class="recall-button link-tab-form" name="submit-remember">
                <i class="fa fa-lightbulb-o"></i>Получить новый пароль</button>
                </p>
            <!-- </div> -->
        </form>
    <?php } ?>
</div>


<?php 
global $typeform;
$f_reg = ($typeform=='register')? 'style="display:block;"': ''; ?>

<!-- <div class="form-tab-rcl" id="register-form-rcl" <?php echo $f_reg; ?>> -->
<!-- 	<div class="form_head">
            <div class="form_auth"><?php if(!$typeform){ ?><a href="#" class="link-login-rcl link-tab-rcl"><?php _e('Authorization ','wp-recall'); ?></a><?php } ?></div>
            <div class="form_reg form_active"><?php _e('Registration','wp-recall'); ?></div>
	</div> -->
	


    <!-- <div class="form-block-rcl"><?php rcl_notice_form('register'); ?></div> -->
    
    <?php $user_login = (isset($_REQUEST['user_login']))? $_REQUEST['user_login']: ''; ?>
    <?php $user_email = (isset($_REQUEST['user_email']))? $_REQUEST['user_email']: ''; ?>
<div class="privateM-body-register">
    <form id="registerForm" action="<?php rcl_form_action('register'); ?>" method="post" enctype="multipart/form-data">
        <!-- <div class="form-block-rcl default-field"> -->
            <input required type="text" placeholder="Придумайте логин" value="<?php echo $user_login; ?>" name="user_login" id="login-user">            
            <span class="required">*</span>

            <input required type="email" 
            placeholder="<?php _e('E-mail','wp-recall'); ?>" value="<?php echo $user_email; ?>" 
            name="user_email" id="email-user">            
            <span class="required">*</span>

        <?php do_action( 'register_form' ); ?>
            <p>
            <button form="registerForm" type="submit" class="recall-button link-tab-form" name="submit-register">
            <i class="fa fa-key" aria-hidden="true"></i>Регистрация</button>
            
            <?php echo wp_nonce_field('register-key-rcl','_wpnonce',true,false); ?>
            <input type="hidden" name="redirect_to" value="<?php rcl_referer_url('register'); ?>">
            </p>
        <!-- </div> -->
    </form>
</div>
</div>
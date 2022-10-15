<?php

	/*
	Plugin Name: FormCraft reCaptcha Add-On
	Plugin URI: http://formcraft-wp.com/addons/recaptcha/
	Description: reCaptcha Add-on for FormCraft
	Author: nCrafts
	Author URI: http://formcraft-wp.com/
	Version: 1.8
	Text Domain: formcraft-recaptcha
	*/

	// Tell FormCraft our add-on exists
	add_action('formcraft_addon_init', 'formcraft_recaptcha_addon');
	function formcraft_recaptcha_addon()
	{
		register_formcraft_addon( 'recaptcha_addon_settings', 486, 'reCaptcha', 'CaptchaController', plugins_url('logo.png', __FILE__ ));
	}

	// We load our JavaScript file on the form editor page
	add_action('formcraft_addon_scripts', 'formcraft_recaptcha_addon_scripts');
	function formcraft_recaptcha_addon_scripts() {
		wp_enqueue_style('fc-captcha-addon-css-main', plugins_url( 'captcha_form_main.css', __FILE__ ));
		wp_enqueue_script('fc-captcha-addon-js', plugins_url( 'captcha_form_builder.js', __FILE__ ));
		wp_localize_script( 'fc-captcha-addon-js', 'FC_Captcha',
			array( 
				'pluginurl' => plugins_url( '', __FILE__ )
				)
			, array());		
	}

	// We load our JavaScript file on the form editor page
	add_action('formcraft_form_scripts', 'formcraft_recaptcha_form_scripts');
	function formcraft_recaptcha_form_scripts() {
		$lang = get_bloginfo("language");
		wp_enqueue_script('fc-captcha-addon-js-main', plugins_url( 'captcha_form_main.js', __FILE__ ));
		wp_enqueue_style('fc-captcha-addon-css-main', plugins_url( 'captcha_form_main.css', __FILE__ ));
		// wp_enqueue_script('fc-recaptcha', 'https://www.google.com/recaptcha/api.js');		
	}	

	function recaptcha_addon_settings() {
		?>
		<div style='padding: 2em; text-align: center; font-size: 1.05em'>
			<div>
				Before you proceed, you will need the Site Key and Secret Key for reCaptcha v3. You can find them <a target='_blank' href='https://www.google.com/recaptcha/admin'>here</a>.
			</div>
			<input placeholder='Site Key' type='text' ng-model='Addons.Captcha.site_key'>
			<input placeholder='Secret Key' type='text' ng-model='Addons.Captcha.secret_key'>
			<div>
				Next, add captcha through<br><strong>Add Field → More Fields → ReCaptcha</strong>
			</div>
		</div>
		<?php
	}

	// We hook into form submissions to check the submitted form data, and throw an error if
	add_action('formcraft_before_save', 'formcraft_recaptcha_addon_hook', 1, 4);
	function formcraft_recaptcha_addon_hook($filtered_content, $form_meta, $raw_content, $integrations)
	{
		global $fc_final_response;
		$captcha = formcraft_get_addon_data('Captcha', $filtered_content['Form ID']);
		$has_captcha = false;
		foreach ($raw_content as $key => $value) {
			$has_captcha = $value['type'] == 'reCaptcha' ? true : $has_captcha;
		}
		if ( $has_captcha==false ) {
			return true;
		}
		if ( empty($captcha) || empty($captcha['secret_key']) )
		{
			$fc_final_response['failed'] = 'Secret Key required for reCaptcha';
			return false;
		}
		if ( empty($_POST['recaptcha-token']) ) {
			$fc_final_response['failed'] = 'Invalid reCaptcha token. Please refresh the page and try again.';
			return false;
		}
		$data = array('secret' => $captcha['secret_key'], 'response' => $_POST['recaptcha-token']);

    $args = array(
      'body' => $data
    );

		$response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', $args);
		$body = wp_remote_retrieve_body($response);

		$body = json_decode($body, 1);

		if ($body['success'] !== true || $body['score'] < .4) {
			$fc_final_response['failed'] = 'reCaptcha verification failed. Please submit again, or refresh the page and try again';
		}

		if ( !empty($fc_final_response['failed']) ) {
			echo json_encode($fc_final_response);
			die();
		}
	}
	?>
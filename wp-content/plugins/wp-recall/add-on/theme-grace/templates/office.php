<?php
$users = wp_get_current_user();;
//print_R($users);
$phone = get_user_meta($users->ID,'billing_phone',true);
$score=0;

	$telephone_sms=$phone;
	$telephone_sms=str_replace("-","",$telephone_sms);
	$telephone_sms=str_replace(" ","",$telephone_sms);
	$telephone_sms=str_replace("(","",$telephone_sms);
	$telephone_sms=str_replace(")","",$telephone_sms);
	$telephone_sms=trim($telephone_sms);
	
	//$telephone_sms='+77054631199';
	
	$param=array();
	$param['secret'] = "i9HBDy9kzRYdiQnNdQnzEDhARZKys7eE7R6z95KyHyBT8QtbsHAYaGfRsSaKQedKY88Y4GeA4Ff3hB4D9riaZtSdaSQRZTnGSisGTA7K6bAbErFEFREs9iz949QQT5iAbD7Y34yY6TZz9r3F7tZ6Ef6tfH83BfnDHhkAaGf6r6rnieTfBFa5Q7kZEiN5s3t49Gr9dA5tshHErsKRZNHBGZi97Z4kKidHTtHZSBd9KQE36bESQbeh2rhYa9";
	$param['client_phone']  = urlencode($telephone_sms);
		
	//подготовка запроса				
	foreach ($param as $key => $value) { 
	$data .= "&".$key."=".$value;
	}


	//отправка
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://app.frontpad.ru/api/index.php?get_client");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);

	if ($result){
		$result=json_decode($result,true);
		if ($result['score']>0){
		$score=$result['score'];
		}
	}




$name=get_user_meta($users->ID,'billing_new_fild13',true);
$ulica=get_user_meta($users->ID,'billing_address_1',true);
$dom=get_user_meta($users->ID,'billing_new_fild12',true);
$podezd=get_user_meta($users->ID,'billing_new_fild14',true);
$etag=get_user_meta($users->ID,'billing_new_fild15',true);
$kv=get_user_meta($users->ID,'billing_new_fild11',true);
$phone=get_user_meta($users->ID,'billing_phone',true);

?>

<style>body .content-area .entry-header {margin-bottom:10px;}</style>
<p style="text-align:center">На вашем счету: <?php echo $score;?> бонусов <br/>(<a href="https://prosushi.kz/my-account/orders/">Мои заказы на сайте</a>)</p>
<br/>

<script>
jQuery(document).ready(function() {
	
	jQuery("#form4").submit(function(e) {
		jQuery.ajax({
			type: "POST", 
			url: "<?php echo admin_url('admin-ajax.php');?>", 
			data: jQuery("#form4").serialize(), 
			success: function(html){
				jQuery("#success").html(html); 
				jQuery("#success").show();
				
			}
		}); 	
		return false;
	});
});
</script>



<form method="POST" action="" id="form4" ">
	<input type="hidden" name="action" value="my_action">
	<h3>Данные пользователя: </h3>
	<div id="success">Данные сохранены</div>
	<p><label>Имя <abbr class="required" title="обязательно">*</abbr>:</label><input name="name" class="fields1" placeholder="" value="<?php echo $name;?>" required=""></p>
	<p><label>Телефон <abbr class="required" title="обязательно">*</abbr>:</label><input name="phone" id="billing_phone" class="fields1" placeholder="" value="<?php echo $phone;?>" required=""></p>
	<h3>Адрес доставки по умолчанию:</h3>
	<p><label>Улица <abbr class="required" title="обязательно">*</abbr>:</label><input name="ulica" class="fields1" placeholder="" value="<?php echo $ulica;?>" required=""></p>
	<p><label>Дом <abbr class="required" title="обязательно">*</abbr>:</label><input name="dom" class="fields1" placeholder="" value="<?php echo $dom;?>" required=""></p>
	<p><label>Кв. (офис) <abbr class="required" title="обязательно">*</abbr>:</label><input name="kv" class="fields1" placeholder="" value="<?php echo $kv;?>" required=""></p>
	<p><label>Подъезд (необязательно):</label><input name="podezd" class="fields1" placeholder="" value="<?php echo $podezd;?>" ></p>
	<p><label>Этаж (необязательно):</label><input name="etag" class="fields1" placeholder="" value="<?php echo $etag;?>" ></p>
	<button type="submit" class="promocode">Сохранить</button>
</form>




<style>
#success {
    width: 75%;
    text-align: center;
    margin: 0 auto;
    background: #5ddf27;
    border: 1px solid #038504;
    border-radius: 10px;
    color: #0d3b12;
    padding: 3px;
	display:none;
}

#form4 .required {
    color: red;
    font-weight: 700;
    border: 0!important;
    text-decoration: none;
}


#form4 h3{
	font-weight: 400;
    text-transform: none;
	margin-top:15px;
	margin-bottom:15px;
	font-size:20px;
}

#form4 .fields1{
	box-sizing: border-box;
    width: 100%;
    margin: 0;
    outline: 0;
    line-height: normal;
	font-size: .9em !important;;
    padding: .7em !important;;
}

#form4 label{
	text-align: left;
    width: 190px;
    display: flex;
    padding: 8px 0 8px 0;
	line-height: 2;
}

#form4 {
    margin: 0 auto;
    text-align: center;
    display: block !important; 
    flex-direction: column;
    align-items: center;
    justify-content: center;
}


.promocode {
	margin-top:25px;
    background-color: #c33;
    color: #fff;
    padding: 10px 10px;
    display: inline-block;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: 400;
    font-size: .9em;
    cursor: pointer;
    width: 200px;
    align-self: center;
    border: 0;
}
</style>

<?php /*echo $phone;?>
<?php echo get_user_meta($users->ID,'billing_new_fild13',true);?>
<?php echo get_user_meta($users->ID,'billing_address_1',true);*/?>




<div id="lk-conteyner">
    <?php do_action('rcl_area_top'); ?>
    <div class="cab_lt_line">
        <div class="cab_lt_title">
            <h2><?php rcl_username(); ?></h2>
            <div class="rcl-action"><?php rcl_action(); ?></div>
        </div>
        <div class="cab_bttn_lite">
            <?php do_action('rcl_area_counters'); ?>
        </div>
    </div>
</div>

<div class="cab_lt_sidebar">
    <div class="lk-sidebar">
        <div class="lk-avatar">
            <?php rcl_avatar(200); ?>
        </div>
        <div class="cab_bttn">
            <?php do_action('rcl_area_actions'); ?>
            <a class="cab_lt_menu recall-button" style="display: none;"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
        </div>
    </div>
    
        <?php do_action('rcl_area_menu'); ?>
    
</div>

<div id="rcl-tabs">
    
        <?php do_action('rcl_area_tabs'); ?>
    
</div>
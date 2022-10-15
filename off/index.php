<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
if ($_POST['status']!=''){
	require_once $_SERVER['DOCUMENT_ROOT'].'/wp-admin/includes/plugin.php';
	
	
	if (is_plugin_active('yith-woocommerce-catalog-mode/init.php')){
		if ($_POST['status']==2){
			deactivate_plugins('yith-woocommerce-catalog-mode/init.php' );
			//deact;
		}
	}
	else {
		if ($_POST['status']==1){
			//echo '21';
			activate_plugins('yith-woocommerce-catalog-mode/init.php');
			//act
		}
		
	}
	
	
	
	
	header('Location: /off/');
	die();	
}

if ( is_plugin_active( 'yith-woocommerce-catalog-mode/init.php' ) ) {
	$status1=" checked";
	echo '<span style="color:green;">Плагин активен</span>';
}
else {
	$status2=" checked";
	echo '<span style="color:red;">Плагин не активен</span>';
}

?>
<br/><br/>
<form method="POST">
  <div>
    <input type="radio" name="status" value="1" id="orange" <?php echo $status1;?>>
    <label for="orange">Включить</label>
  </div>
  <div>
    <input type="radio" name="status" value="2" id="apple" <?php echo $status2;?>>
    <label for="apple">Выключить</label>
  </div>
  <br/>
 <input type="submit" value="Сохранить"/>
 
</form>
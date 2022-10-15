<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ProSushi
 */

?>

	</main>

	<footer id="colophon" class="site-footer" role="contentinfo" style="padding-bottom: 30px">
		<div class="row">
	        <nav class="menu">
				<?php wp_nav_menu(
                	array(
                	'menu' => 'Footer menu'
                	)
                );?>
	            <p class="d-none"><?php _e('[:de]Pirmasens 2022[:en]Pirmasens 2022[:ru]Пирмазенс 2022[:]'); ?> </p>
	        </nav>
			
			
			
	        <nav class="categories">
	            <?php wp_nav_menu(
                	array(
                	'menu' => 'Category menu'                
                	)
                );?>
	        </nav>
	        <div class="contacts">
            <div class="mobile">
<ul id="menu-footer-menu" >
<li id="menu-item-247" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current_page_parent menu-item-247"><a href="/"><?php _e('[:de]Information[:en]Information[:ru]Меню[:]'); ?></a></li>
<!-- 	<nav class="menu">
		<?php wp_nav_menu(
			array(
				'menu' => 'Footer menu'
			)
		);?>
		<p>Костанай 2021г. </p>
	</nav> -->
<!--<li id="menu-item-248" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-248"><a href="/category/promotions/"><?php _e('[:de]Aktion[:en]Aktion[:ru]Акции[:]'); ?></a></li>-->
<!--<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="/buy-delivery/"><?php _e('[:de]Zahlung und Lieferung[:en]Aktion[:ru]Оплата и доставка[:]'); ?></a></li>-->
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-251"><a href="/oferta/"><?php _e('[:de]AGB[:en]Aktion[:ru]Договор публичной оферты[:]'); ?></a></li>	
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="/politic/"><?php _e('[:de]Datenschutzerklärung[:en]Datenschutzerklärung[:ru]Политика конфиденциальности[:]'); ?></a></li>	
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="/bonus/"><?php _e('[:de]Bonussystem[:en]Bonus-System[:ru]Правила бонусов[:]'); ?></a></li>	
</ul>               
                
            </div>
            
	            <img style="    margin: 0 auto;
    display: table;
    margin-bottom: 6%;" src="<?php bloginfo('template_url'); ?>/img/logo-wh.png" alt="ProСуши">
	            
	            <p style="    text-align: center;"><a style="color:white;" href="tel:015259812312" target="_blank">0152 59812312</a> <br> <?php// _e('[:kz]«ProСуши» бар[:ru]бар «ProСуши»[:]'); ?></p><br>
	              <?php// _e('[:kz]ProСуши «Багета»[:ru]ProСуши «Багета»[:]'); ?>
	            <!--<a href="http://prosushi.kz/o-platehznoq-sisteme/" style="text-align: center; display: block; color: #fff;">О платежной системе</a>-->
				
				<div class="onlymob"><a href="https://vk.com/prosushikz" class="soc"><i class="fa fa-vk"></i> <a href="https://www.instagram.com/prosushi_kostanay/" class="soc"><i class="fa fa-instagram"></i></a>
				
				
				
	        </div>
		</div><!-- .footer -->

	</footer><!-- #colophon -->
	<div class="bottom">
	
	
	
  
    
	</div>
	

	
			
		
				
<script>
    $(document).ready(function () {
        $("#phoneR").mask("+7 799 999 9999");
		
		$("#billing_phone").mask("+49 999 999 99999");
    })
</script>

<?php wp_footer(); ?>

<script>
  
  $(document).ready(function() {

	$('.authorize-form-rcl > #login-form-rcl > .reg > a').remove()
	$('.authorize-form-rcl > #login-form-rcl > .reg').html('Пройти регистрацию')
    $('.link-remember-rcl').attr("href", "https://prosushi.kz/my-account/lost-password/")

  }); 
  window.onload = function() {
//    var reg = `Пройти регистрацию` 
    var delReg = $('.reg')
    delReg.innerHTML('')
  };


//console.log(reg)
//  document.getElementsByClassName('reg').delete()
</script>


<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-admin/includes/plugin.php';
if (is_plugin_active('yith-woocommerce-catalog-mode/init.php')){ ?>
<style>	
.buy {display: none !important;}
a.c11{cursor: auto !important;}
</style>		
	
<?php } else {	
?>
<script>
jQuery(document).ready(function() {
	jQuery(".c11").on('click', function(){
		$(this).parent().find(".button").click();
		//return false;
		
		if ($(this).parent().find(".button").html()=="Добавка/соус"){
			window.location.href = $(this).parent().find(".button").attr("href");
		}  else {return false;}
		
	});	
	
	jQuery(".c12").on('click', function(){
		$(this).parent().parent().find(".button").click();
		//return false;
		
		if ($(this).parent().parent().find(".button").html()=="Добавка/соус"){
			window.location.href = $(this).parent().parent().find(".button").attr("href");
		}  else {return false;}
		
	});	
	
	
});
</script>
<?php }  ?>








			
</body>
</html>

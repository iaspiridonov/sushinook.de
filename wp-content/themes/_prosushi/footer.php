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
	            <p class="d-none">Аркалык 2021г. </p>
	        </nav>
	        <nav class="categories">
	            <h2>Меню</h2>
	            <?php wp_nav_menu(
                	array(
                	'menu' => 'Category menu'                
                	)
                );?>
	        </nav>
	        <div class="contacts">
            <div class="mobile">
<ul id="menu-footer-menu" >
<li id="menu-item-247" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current_page_parent menu-item-247"><a href="/">Меню</a></li>
<!-- 	<nav class="menu">
		<?php wp_nav_menu(
			array(
				'menu' => 'Footer menu'
			)
		);?>
		<p>Костанай 2020г. </p>
	</nav> -->
<li id="menu-item-248" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-248"><a href="/category/promotions/">Акции</a></li>
<li id="menu-item-249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-249"><a href="/about-us/">О нас</a></li>
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="/buy-delivery/">Оплата и доставка</a></li>
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-251"><a href="https://prosushi.kz/%d0%b4%d0%be%d0%b3%d0%be%d0%b2%d0%be%d1%80-%d0%bf%d1%83%d0%b1%d0%bb%d0%b8%d1%87%d0%bd%d0%be%d0%b9-%d0%be%d1%84%d0%b5%d1%80%d1%82%d1%8b/">Договор публичной оферты</a></li>	
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="https://prosushi.kz/%d0%bf%d0%be%d0%bb%d0%b8%d1%82%d0%b8%d0%ba%d0%b0-%d0%ba%d0%be%d0%bd%d1%84%d0%b8%d0%b4%d0%b5%d0%bd%d1%86%d0%b8%d0%b0%d0%bb%d1%8c%d0%bd%d0%be%d1%81%d1%82%d0%b8/">Политика конфиденциальности</a></li>	
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="https://prosushi.kz/bonus/">Правила бонусов</a></li>	
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="https://prosushi.kz/o-platehznoq-sisteme/">О платежной системе</a></li>		
</ul>               
                
            </div>
            
	            <img style="    margin: 0 auto;
    display: table;
    margin-bottom: 6%;" src="<?php bloginfo('template_url'); ?>/img/logo-wh.png" alt="ProСуши">
	            <p style="    text-align: center;"><a style="color:white;" href="tel:87750072993" target="_blank">8 (775) 007-29-93</a> <br><?php// _e('[:kz]ProСуши Солнечный[:ru]ProСуши Солнечный[:]'); ?></p><br>
	            
	              <?php// _e('[:kz]ProСуши «Багета»[:ru]ProСуши «Багета»[:]'); ?>
	            <!--<a href="http://prosushi.kz/o-platehznoq-sisteme/" style="text-align: center; display: block; color: #fff;">О платежной системе</a>-->
				
				<div class="onlymob"><a href="https://vk.com/prosushikz" class="soc"><i class="fa fa-vk"></i> <a href="https://www.instagram.com/prosushi_kostanay/" class="soc"><i class="fa fa-instagram"></i></a>
				
				
				<br><a href="https://play.google.com/store/apps/details?id=kz.prosushi.android"><img src="/wp-content/themes/prosushi/img/pr_1.png"></a>
				<br><a href="https://apps.apple.com/de/app/pro%D1%81%D1%83%D1%88%D0%B8-%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B0-%D1%81%D1%83%D1%88%D0%B8/id1521632083"><img src="/wp-content/themes/prosushi/img/pr_2.png"></a></div>
				
	        </div>
		</div><!-- .footer -->

	</footer><!-- #colophon -->
	<div class="bottom">
	
	
	
  
    
	</div>
	

	
			
		
				
<script>
    $(document).ready(function () {
        $("#phoneR").mask("+7 799 999 9999");
		
		$("#billing_phone").mask("+7 999 999 9999");
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

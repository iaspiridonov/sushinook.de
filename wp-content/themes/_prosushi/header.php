<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ProSushi
 */
 
/*
 
 if($_SERVER['REQUEST_URI'] == '/checkout/'){ 
	header('Location: http://prosushi.kz');
 }
*/ 

$city_one=$_COOKIE['city_one'];
if ($city_one==1){
} else {
	setcookie('city_one','1',time()+(3600*24),'/',".prosushi.kz"); // 24 часа
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="icon" href="https://prosushi.kz/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="https://prosushi.kz/favicon.ico" type="image/x-icon" />
<?php wp_head(); ?>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5HFRD6T');</script>
<!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5HFRD6T"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<meta name="facebook-domain-verification" content="252y23j4rx9g8vwvr9tynivg98hu6a" />


</head>

<body <?php body_class(); ?>>
	





<?php 

// https://ru.stackoverflow.com/questions/216397/%D0%9A%D0%B0%D0%BA-%D0%B2%D1%8B%D0%B2%D0%B5%D1%81%D1%82%D0%B8-%D0%B2%D1%81%D0%B5-%D0%B4%D0%B0%D1%82%D1%8B-%D0%B2-%D0%B7%D0%B0%D0%B4%D0%B0%D0%BD%D0%BD%D0%BE%D0%BC-%D0%B4%D0%B8%D0%B0%D0%BF%D0%B0%D0%B7%D0%BE%D0%BD%D0%B5-%D0%B4%D0%B0%D1%82


?>










<?php if(is_front_page()  ){ // and $city_one!=1?>





<script>
$(window).on("scroll", function() {
  // Если высота больше 200px 
  // Добавляем классу header класс fixed
    if ($(window).scrollTop() > 40) $('.mass').addClass('ness');
  // Иначе удаляем класс fixed
          else $('.mass').removeClass('ness');
    });
</script>
<script>
$(window).on("scroll", function() {
  // Если высота больше 200px 
  // Добавляем классу header класс fixed
    if ($(window).scrollTop() > 40) $('.ress').addClass('resss');
  // Иначе удаляем класс fixed
          else $('.ress').removeClass('resss');
    });
</script>



<script>
$(document).ready(function() {

    // Check for the "whenToShowDialog" cookie, if not found then show the dialog and save the cookie.
    // The cookie will expire and every 2 days and the dialog will show again.
    if (jQuery.cookie('whenToShowDialog') == null) {

        // Create expiring cookie, 2 days from now:
        jQuery.cookie('whenToShowDialog', 'yes', { expires: 1, path: '/' });

        // Show dialog
        setTimeout(function(){
        $('#bsadsheadline').fadeIn(500);
    }, 30000);       
    }

});
</script>

<script>

/*
	if(document.referrer == 'http://rudny.prosushi.kz/') {

		$('.all-black2').css({'display': 'none'});
		//console.log(document.referrer);
	}
	*/
	
	/* ++++ 
	var arr_cook = document.cookie.match(/city_prosushi=(.+?);/);
		
       	
		
	if(arr_cook == null){
		
			
			
		var now = new Date();
		var time = now.getTime();
			
		time += 60 * 1440000; // 3600 - сек в часе, 5000 = 5 часов
		now.setTime(time);
		document.cookie = 
		'city_prosushi=city' + 
		'; expires=' + now.toUTCString() + 
		'; path=/';
			
	} else {
		$('.all-black2').css({'display': 'none'});
		console.log(document.referrer);
	}
	*/
	
	
	
</script>

<?php } ?>


<script>
	// Закрыть форму звонка
    $('.close-popup2').on("click", function (e) {
       $('.all-black2').css({'display': 'none'});
    });
	
	$('.close-popup-a2').on("click", function (e) {
       $('.all-black2').css({'display': 'none'});
    });
	
	
	 $('.all-black2').on("click", function (event){
    // event.css({'display': 'none'});
    
    var class_click = event.target.className;
    if(class_click == 'all-black2') {
      $('.all-black2').css({'display': 'none'});
    }

    // .css({'display': 'none'});
  });
		</script>



<style>


.all-black2 {
  display1: none;
  background-color: rgba(0, 0, 0, 0.5);
  opacity1: 0.5;
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  bottom: 0px;
  z-index: 1000; }
  
  .window-popup2 p {
	  line-height: 22px;
  }
 

.window-popup2 {
  display: block;
  background-color: #fff; 
  width1: 344px;
  max-width: 344px;
  padding: 20px;
  z-index: 1100;
  position: fixed;
  position: relative;
  margin: 40px auto;
  text-align: center; 
  box-shadow: 0px 0px 30px 0px rgba( 204, 51, 51, 0.42 );
  border-radius: 15px;
  }

  .window-popup2 a {
	  padding: 10px;
	  color: #000;
  }
  
  
  .window-popup2 a:hover {
	color: #cc3333;
  }

.close-popup2 {
  float: right;
  background-image: url("https://prosushi.kz/wp-content/themes/prosushi/img/cl_3wFHfdI.png");
  border: none;
  background-color: transparent;
  cursor: pointer;
  background-repeat: no-repeat; }
  
.close-popup-a2 {
	
}

</style>



<style>
.all-black22 {
  display1: none;
  background-color: rgba(0, 0, 0, 0.5);
  opacity1: 0.5;
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  bottom: 0px;
  z-index: 1000; }
  
  .window-popup22 p {
	  line-height: 22px;
  }
 

.window-popup22 {
  display: block;
  background-color: #fff; 
  width1: 344px;
  max-width: 344px;
  padding: 20px;
  z-index: 1100;
  position: fixed;
  position: relative;
  margin: 40px auto;
  text-align: center; 
  box-shadow: 0px 0px 30px 0px rgba( 204, 51, 51, 0.42 );
  border-radius: 15px;
  }

  .window-popup22 a {
	  padding: 10px;
	  color: #000;
  }
  
  
  .window-popup22 a:hover {
	color: #cc3333;
  }

.close-popup22 {
  float: right;
  background-image: url("https://prosushi.kz/wp-content/themes/prosushi/img/cl_3wFHfdI.png");
  border: none;
  background-color: transparent;
  cursor: pointer;
  background-repeat: no-repeat; }
  
.close-popup-a22 {
	
}

</style>

<?php 
if (class_exists('YITH_WooCommerce_Catalog_Mode')) 
{ echo '
<div class="all-black22">
<div class="window-popup22">
<input type="button" class="close-popup22">
<a class="close"></a>
<p style="color: #000">На данный момент у нас временный тайм-аут на приём заказов. Попробуйте зайти позднее. Приносим свои извинения за неудобства.</p>
</div>
</div>
'; }
?>
<script>
	// Закрыть уведомление о тайм-ауте
    $('.close-popup22').on("click", function (e) {
       $('.all-black22').css({'display': 'none'});
    });
	
	
	
	 $('.all-black22').on("click", function (event){
    // event.css({'display': 'none'});
    
    var class_click = event.target.className;
    if(class_click == 'all-black22') {
      $('.all-black22').css({'display': 'none'});
    }

    // .css({'display': 'none'});
  });
</script>



<!-- Всплывающее окно -->
<?php 

$hour = (int) date('H');
$hour = $hour + 6;
$minutes = (int) date('i');

if($hour > 23){
	$hour = $hour - 23;
} else if ($hour == 23){
	$hour = 0;
}


/*
if($hour > 00){
	$hour = $hour - 00;
} else if ($hour == 00){
	$hour = 0;
}
*/



//if(($hour == 0 && $minutes > 30 ) || ($hour < 10 && $hour != 0)): 
if(($hour == 0 && $minutes > 30 ) || ($hour < 11 && $hour != 0)): ?>


	<div class="all-black">

		<div class="window-popup">
			
			<input type="button" class="close-popup">
			<a class="close"></a>
			
		
			<!--<p>На данный момент мы закрыты, заказы принимаем с 11:00 до 23:00 ежедневно и без выходных</p>-->
			
			
			<p>На данный момент мы закрыты, заказы принимаем с 11:00 до 23:00 ежедневно и без выходных</p>

		</div>
		


	</div>

<?php endif; ?>


		<script>
		// Закрыть форму звонка
    $('.close-popup').on("click", function (e) {
       $('.all-black').css({'display': 'none'});
    });
	
	
	 $('.all-black').on("click", function (event){
    // event.css({'display': 'none'});
    
    var class_click = event.target.className;
    if(class_click == 'all-black') {
      $('.all-black').css({'display': 'none'});
    }

    // .css({'display': 'none'});
  });
		</script>
			<script>
jQuery(document).ready(function($) {
	var url=document.location.href;
	$.each($(".into li a"),function(){
		if(this.href==url){
			$(this).addClass('sex');
		}
	});
})(jQuery);
</script>
		
<style>

.all-black,
.all-black2 {
  display1: none;
  background-color: rgba(0, 0, 0, 0.5);
  opacity1: 0.5;
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  bottom: 0px;
  z-index: 1000; }
  
  .window-popup p {
	  line-height: 22px;
  }
 

.window-popup {
  display: block;
  background-color: #fff; 
  width: 344px;
  padding: 20px;
  z-index: 1100;
  position: fixed;
  position: relative;
  margin: 40px auto;
  text-align: center; 
  box-shadow: 0px 0px 30px 0px rgba( 204, 51, 51, 0.42 );
  border-radius: 15px;
  }

.close-popup,
.close-popup2 {
  float: right;
  background-image: url("https://prosushi.kz/wp-content/themes/prosushi/img/cl_3wFHfdI.png");
  border: none;
  background-color: transparent;
  cursor: pointer;
  background-repeat: no-repeat; 
  width: 18px;
  height: 18px;
  }

</style>		


























<?php /*

<div class="all-black3">

	<div class="window-popup3">
			
		<input type="button" class="close-popup3">
		
		<img src="https://prosushi.kz/wp-content/themes/prosushi/img/IMG-20190512-WA0006.jpg" alt="">
				
	</div>
		

</div>






<script>
	// Закрыть форму звонка
    $('.close-popup3').on("click", function (e) {
       $('.all-black3').css({'display': 'none'});
    });
	
	$('.close-popup-a3').on("click", function (e) {
       $('.all-black3').css({'display': 'none'});
    });
	
	
	 $('.all-black3').on("click", function (event){
    // event.css({'display': 'none'});
    
    var class_click = event.target.className;
    if(class_click == 'all-black3') {
      $('.all-black3').css({'display': 'none'});
    }

    // .css({'display': 'none'});
  });
		</script>



<style>


body .window-popup3 {
	max-width: 600px;
    min-width1: 300px;
    width1: 100%;	
}

.all-black3 {
  display1: none;
  background-color: rgba(0, 0, 0, 0.5);
  opacity1: 0.5;
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  bottom: 0px;
  z-index: 1000;
  overflow-y: scroll;
  }
  
  .window-popup3 p {
	  line-height: 22px;
  }
 

.window-popup3 {
  display: block;
  background-color: #fff; 
  width1: 344px;
  max-width1: 344px;
  padding: 20px;
  z-index: 1100;
  position: fixed;
  position: relative;
  margin: 40px auto;
  text-align: center; 
  box-shadow: 0px 0px 30px 0px rgba( 204, 51, 51, 0.42 );
  }

  .window-popup3 a {
	  padding: 10px;
	  color: #000;
  }
  
  
  .window-popup3 a:hover {
	color: #cc3333;
  }

.close-popup3 {
  float: right;
  background-image: url("https://prosushi.kz/wp-content/themes/prosushi/img/cl_3wFHfdI.png");
  border: none;
  background-color: transparent;
  cursor: pointer;
  background-repeat: no-repeat;
  width: 16px;
  height: 16px;
  }
  
.close-popup-a3 {
	
}

</style>


*/
?>
















	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="wrap-fluid">
			<div id="lamp" class="ress"><div class="into">
			
	
		<li><a href="#sets">Сеты (наборы)</a></li>
        <li><a href="#pasta">WOK</a></li>
		<li><a href="#sauces">Соусы</a></li>
		<li><a href="#complex">Сложные роллы</a></li>
		<li><a href="#salats">Горячее и салаты</a></li>
        <li><a href="#tempura">Темпура</a></li>
		<li><a href="#baked">Запеченные роллы</a></li>
		<li><a href="#deserts">Десерты</a></li>
        <li><a href="#nigiri">Суши Нигири</a></li>
        <li><a href="#gunkan">Суши Гункан</a></li>
        <li><a href="#classic">Классические роллы</a></li>
        <li><a href="#napitki">Напитки</a></li>
</div></div>
				<div class="top-h mass">
				
					<div class="lang">
		 				<?php /*
							if (is_active_sidebar( 'lang-switch' ) ) : ?>
							<?php dynamic_sidebar( 'lang-switch' ); ?>
						<?php endif; */ ?> 
                	</div><!-- .lang -->

						<?php wp_nav_menu(
	                    	array(
	                    	'menu' => 'Main menu',
	                    	'container' => 'nav',
	                    	)
	                    );?>
					
					<?php if($_SERVER['REQUEST_URI'] == '/'):?>
					
					    <!-- <input type="text" id="sertch-product" class="search" placeholder="Быстрый поиск..."> -->
					
					<?php endif; ?>
					
	                <div class="right"> 

		                <div class="phone">
		                	<!-- <a href="#" class="popmake-5224"><i class="fa fa-mobile" aria-hidden="true"></i></a> -->
		                	 <a href="tel:87750070759" style="font-size: 2.1em;"><i class="fa fa-volume-control-phone" aria-hidden="true"></i></a>
		                </div>
	               
	                    <div class="favorite">
	                        <a href="<?php echo get_site_url(); ?>/wishlist/" title="Избранное"><span id="favorit-id-i" class="moon icon-heart"></span></a>
	                    </div>
						
						
						
						<div class="agent-007">
						
						    <a href="https://prosushi.kz/tainy-pokupatel/"><i class="fa fa-user-secret" aria-hidden="true"></i></a> 
						
						</div>
						
						
						<div class="job">
						
						    <a href="https://prosushi.kz/nashi-vakansii/"><i class="fa fa-briefcase" aria-hidden="true"></i></a> 
						
						</div>
						

	                    <div class="private">
	                        <span class="moon icon-user"></span>
	                        <a href="#" id="privateL">Личный кабинет</a>
	                        <div id="privateM">
	                            <div class="wrap">
	                                <div class="privateM-title">
	                                    <h4>Авторизация</h4>
	                                    <i class="fa fa-times"></i>
	                                </div>
	                                <div class="privateM-body">
 									<?php
										if (is_active_sidebar( 'log-reg' ) ) : ?>
										<?php dynamic_sidebar( 'log-reg' ); ?>
									<?php endif; ?>    
									</div>                         
	                            </div> <!-- .wrap -->
	                        </div> <!-- .privateM -->
	                    </div><!-- .private -->
	               
	              <?php if ((is_front_page()) ) { ?>      <a class="nav-adapt"><i class="fa fa-bars"></i></a>   <?php } ?>
	                </div><!-- .right -->	
	                
	                                
	                                                
	                    
	                    
	                                    
	                                                                    
	            </div><!-- .top-h -->
            </div><!-- .wrap-fluid -->

		    <div class="main-h">
	            <div class="main-h-left">
	                    <div class="logo">
	                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
	                            <img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="ProСуши">
	                        </a>
	                         <h1><?php _e('[:kz]Қостанайда <span>сушиді</span> жеткізу[:ru]Доставка <span>суши</span> в Аркалыке[:]'); ?></h1>
	                    </div>
	                    
	              <?php wp_nav_menu(
	                    	array(
	                    	'menu' => 'Main menu',
	                    	'container' => 'nav',
                                'container_class' => 'kompmenu', 
                           
	                    	)
	                    );?>
	                    

                  
                  <?php if ((is_front_page()) ) { ?>
<nav class="ris" style="display: none;"><ul id="menu-main-menu-1" class="menu">
<li class="menu-item"><a href="/">Главная</a></li>     
<li class="menu-item"><a href="https://prosushi.kz/category/promotions/">Акции</a>
<li class="menu-item"><a href="https://prosushi.kz/about-us/">О нас</a>
<li class="menu-item"><a href="https://prosushi.kz/buy-delivery/">Оплата и доставка</a>
<li class="menu-item"><a href="https://prosushi.kz/bonus/">Правила бонусов</a>

   
	 
    	

</ul></nav>
	                  
                  <?php } ?>
                  
                  
                  <div class="main-h-right">
	               
	                <p class="number-phone"><a href="tel:87750072993" target="_blank">8 (775) 007-29-93</a></p>
			
	                <p class="prompt">	                
						<?php //_e('[:kz]Біз күнделікті сағат 10<sup>00</sup> бастап 00<sup>00</sup> дейін жұмыс істейміз[:ru]Мы работаем ежедневно с 10<sup>00</sup> до 00<sup>00</sup>[:]'); ?>
						<?php _e('[:kz]Жеткізу жұмыстары 10<sup>00</sup> бастап 00<sup>00</sup> дейін жұмыс істейміз[:ru]Доставка работает с 11<sup>00</sup> до 23<sup>00</sup>[:]'); ?>
	                </p>
	                <?php do_action('wpcallback_button'); ?>
	              
	            </div>
                  
	                  
<div class="features">
                      
                      
                      

 <div style="display:block; width:90%; margin-left: auto; margin-right: auto;">
    <?php echo do_shortcode('[slick-carousel-slider  slidestoshow="1"  slidestoscroll="1" autoplay="true" autoplay_interval="8000" speed="2000" sliderheight="100%" category="44"]'); ?>
 
 </div>

                      
                      
                       
                       
                        
		                   
		                </div>
		                
		        
		                
	            </div> <!-- .main-h-left -->
	            
	        </div> <!-- .main-h -->
		</div><!-- .container -->
	</header><!-- #masthead -->
	
	<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(26480982, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/26480982" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

	<main>
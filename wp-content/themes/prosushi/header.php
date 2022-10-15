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
<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/custom.css?ver=1.6" rel="stylesheet" type="text/css">
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5C3MFQF');</script>
<!-- End Google Tag Manager -->

</head>

<body <?php body_class(); ?>>
	
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5C3MFQF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->




<?php 

// https://ru.stackoverflow.com/questions/216397/%D0%9A%D0%B0%D0%BA-%D0%B2%D1%8B%D0%B2%D0%B5%D1%81%D1%82%D0%B8-%D0%B2%D1%81%D0%B5-%D0%B4%D0%B0%D1%82%D1%8B-%D0%B2-%D0%B7%D0%B0%D0%B4%D0%B0%D0%BD%D0%BD%D0%BE%D0%BC-%D0%B4%D0%B8%D0%B0%D0%BF%D0%B0%D0%B7%D0%BE%D0%BD%D0%B5-%D0%B4%D0%B0%D1%82


?>











<?php if(is_front_page()  ){ // and $city_one!=1?>



<!--<div class="all-black2">

	<div class="window-popup2">
			
		<input type="button" class="close-popup2">
		
		<p style="color: #000">Выберите город</p><br>
        <p><a class="close-popup-a2" href="#">Костанай</a><a href="https://rudny.prosushi.kz/">Рудный</a><a href="https://arkalyk.prosushi.kz/">Аркалык</a></p>
				
	</div>
		

</div>-->

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
  display: none;
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

/*
if($hour > 18){
	$hour = $hour - 18;
} else if ($hour == 00){
	$hour = 0;
}
*/


if($hour > 24){
	$hour = $hour - 24;
} else if ($hour == 24){
	$hour = 0;
}




//if(($hour == 0 && $minutes > 30 ) || ($hour < 10 && $hour != 0)): 
if(($hour == 0 && $minutes > 30 ) || ($hour < 15 && $hour != 0)): ?>


	<!--<div class="all-black">

		<div class="window-popup">
			
			<input type="button" class="close-popup">
			<a class="close"></a>
			
		
			
			
			<p><?php _e('[:en]На данный момент мы закрыты, заказы принимаем с 10:00 до 00:00 ежедневно и без выходных[:ru]На данный момент мы закрыты, заказы принимаем с 10:00 до 00:00 ежедневно и без выходных[:]'); ?></p>

		</div>
		


	</div>-->

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
});
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
	
	@media (max-width: 767px){
main .card-wrap .card-product:hover {
    box-shadow: none;
		}}

</style>		











































	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="wrap-fluid">
			<div id="lamp" class="ress"><div class="into">
			
	
		<li><a href="#sets"><?php _e('[:de]Menü[:en]Sets[:ru]Сеты (наборы)[:]'); ?></a></li>
        <li><a href="#complex"><?php _e('[:de]Uramaki[:en]Complicated maki[:ru]Сложные роллы[:]'); ?></a></li>
		<li><a href="#tempura"><?php _e('[:de]Tempura[:en]Tempura maki[:ru]Темпура[:]'); ?></a></li>
		<li><a href="#baked"><?php _e('[:de]Überbackene Rolls[:en]Baked maki[:ru]Запеченные роллы[:]'); ?></a></li>
		<li><a href="#pasta"><?php _e('[:de]WOK[:en]WOK[:ru]WOK[:]]'); ?></a></li>
		<li><a href="#poke"><?php _e('[:de]Bowls[:en]Poke[:ru]Поке-боулы[:]'); ?></a></li>
		<!--<li><a href="#pitases"><?php _e('[:de]Сеттер[:en]Питас[:ru]Питасы[:]'); ?></a></li>-->
		<li><a href="#deserts"><?php _e('[:de]Nachspeisen[:en]Desserts[:ru]Десерты[:]'); ?></a></li>
		<li><a href="#salats"><?php _e('[:de]Vorspeisen[:en]Hot dishes and salads[:ru]Горячее и салаты[:]'); ?></a></li>
        <li><a href="#nigiri"><?php _e('[:de]Sushi Nigiri[:en]Nigiri sushi[:ru]Суши Нигири[:]'); ?></a></li>
        <li><a href="#gunkan"><?php _e('[:de]Sushi Gunkan[:en]Gunkan sushi[:ru]Суши Гункан[:]'); ?></a></li>
		<li><a href="#classic"><?php _e('[:de]Maki Rolls[:en]Classic maki[:ru]Классические роллы[:]'); ?></a></li>
		<li><a href="#napitki"><?php _e('[:de]Getränke[:en]Beverages[:ru]Напитки[:]'); ?></a></li>
		<li><a href="#sauces"><?php _e('[:de]Saucen[:en]Sauces[:ru]Соусы[:]'); ?></a></li>
		
		
        
        
</div></div>
				                <?php if ((is_front_page()) ) { ?>      <a class="nav-adapt"><i class="fa fa-bars"></i></a> <?php } ?>

				<div class="top-h mass">
				


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
						                       <div class="city">
                            <div class="city-header">
                                <img src="/wp-content/uploads/2022/03/ic_2.1.png" alt="img">
                                <div>
                                    <?php
                                    if(get_site_url() == 'https://arkalyk.prosushi.kz'){
                                        echo 'Аркалык';
                                    } elseif (get_site_url() == 'https://rudny.prosushi.kz') {
                                        echo 'Рудный';
										} elseif (get_site_url() == 'https://nursultan.prosushi.kz') {
                                        echo 'Нур-Султан';
                                    } else {
                                        echo 'Pirmasens';
                                    };
                                    ?>
                                    <span><?php _e('[:de]andere[:en]choose[:ru]изменить[:]'); ?></span>
                                </div>
                            </div>
                            <!--<ul class="citydrop">
                                <li>
                                    <a href="https://nursultan.prosushi.kz/"><?php _e('[:en]Нұр-Сұлтан[:ru]Нур-Султан[:]'); ?></a>
                                </li>
								<li>
                                    <a href="https://prosushi.kz/"><?php _e('[:en]Қостанай[:ru]Костанай[:]'); ?></a>
                                </li>
                                <li>
                                    <a href="https://rudny.prosushi.kz/"><?php _e('[:en]Рудный[:ru]Рудный[:]'); ?></a>
                                </li>
                                <li>
                                    <a href="https://arkalyk.prosushi.kz/"><?php _e('[:en]Арқалық[:ru]Аркалык[:]'); ?></a>
                                </li>
                            </ul>-->
                        </div>
                        <div class="lang">
                            <div class="lang-header">
                                <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/ic_3.1.png" alt="img">
                                <div>
                                    <?php
                                      if(qtrans_getLanguage() == 'ru'){
                                          echo 'Русский язык';
                                      } elseif ( qtrans_getLanguage() == "en" ) {
										echo "English";
														} elseif ( qtrans_getLanguage() == "de" ) {
														echo "Deutsch";
																	}
									  
                                    ?>
                                    <span><?php _e('[:de]andere[:en]choose[:ru]изменить[:]'); ?></span>
                                </div>
                            </div>
                            <?php
                            if (is_active_sidebar( 'lang-switch' ) ) : ?>
                                <?php dynamic_sidebar( 'lang-switch' ); ?>
                            <?php endif;  ?>
                        </div><!-- .lang -->
		                        <div class="agent-007">
                            <a href="/napisat-rukovoditelyu/" title="<?php _e('[:de]An den Geschäftsführer schreiben[:en]Write to director[:ru]Написать директору[:]'); ?>" ><i class="fa fa-envelope" aria-hidden="true"></i></a>
                        </div>				
						
						<!--
						<div class="agent-007">
						
						    <a href="https://prosushi.kz/tainy-pokupatel/" title="Тайный покупатель"><i class="fa fa-user-secret" aria-hidden="true"></i></a> 
						
						</div>
						
						
						<div class="job">
						
						    <a href="https://prosushi.kz/nashi-vakansii/" title="Наши вакансии"><i class="fa fa-briefcase" aria-hidden="true"></i></a> 
						
						</div>-->
						

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
	               
	          <a class="nav-adapt"><i class="fa fa-bars"></i></a>   
	                </div><!-- .right -->	
	                
	                                
	                                                
	                    
	                    
	                                    
	                                                                    
	            </div><!-- .top-h -->
            </div><!-- .wrap-fluid -->

		    <div class="main-h">
	            <div class="main-h-left">
	                    <div class="logo">
	                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
	                            <img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="ProСуши">
	                        </a>
	                         <h1><?php _e('[:de]Sushi-lieferung pirmasens[:en]<span>Sushi</span> delivery Pirmasens[:ru]Доставка <span>суши</span> в Пирмазенс[:]'); ?></h1>
	                    </div>
	                    
	              <?php wp_nav_menu(
	                    	array(
	                    	'menu' => 'Main menu',
	                    	'container' => 'nav',
                                'container_class' => 'kompmenu', 
                           
	                    	)
	                    );
					
					?>
	                    

    <nav class="ris" style="display: none">
        <div class="mobile-header">
            <img src="/wp-content/themes/prosushi/img/logo.png" alt="ProСуши">
            <button type="button">✖</button>
        </div>
        <div class="mobile-content">
            <div class="city">
                <div class="city-header">
                    <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/ic_2.2.png" alt="img">
                    <div>
                        <?php
                        if(get_site_url() == 'https://arkalyk.prosushi.kz'){
                                        echo 'Аркалык';
                                    } elseif (get_site_url() == 'https://rudny.prosushi.kz') {
                                        echo 'Рудный';
										} elseif (get_site_url() == 'https://nursultan.prosushi.kz') {
                                        echo 'Нур-Султан';
                                    } else {
                                        echo 'Pirmasens';
                                    };
                        ?>
                                    <span><?php _e('[:de]andere[:en]choose[:ru]изменить[:]'); ?></span>
                    </div>
                </div>
                <!--<ul class="citydrop">
                    <li>
                        <a href="https://nursultan.prosushi.kz/"><?php _e('[:en]Нұр-Сұлтан[:ru]Нур-Султан[:]'); ?></a>
                    </li>
					<li>
                        <a href="https://prosushi.kz/"><?php _e('[:en]Қостанай[:ru]Костанай[:]'); ?></a>
                    </li>
                    <li>
                        <a href="https://rudny.prosushi.kz/"><?php _e('[:en]Рудный[:ru]Рудный[:]'); ?></a>
                    </li>
                    <li>
                        <a href="https://arkalyk.prosushi.kz/"><?php _e('[:en]Арқалық[:ru]Аркалык[:]'); ?></a>
                    </li>
                </ul>-->
            </div>
            <div class="lang">
                <div class="lang-header">
                    <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/ic_3.2.png" alt="img">
                    <div>
                        <?php
                                      if(qtrans_getLanguage() == 'ru'){
                                          echo 'Русский язык';
                                      } elseif ( qtrans_getLanguage() == "en" ) {
										echo "English";
														} elseif ( qtrans_getLanguage() == "de" ) {
														echo "Deutsch";
																	}
									  
                                    ?>
                                    <span><?php _e('[:de]andere[:en]choose[:ru]изменить[:]'); ?></span>
                    </div>
                </div>
                <?php
                if (is_active_sidebar( 'lang-switch' ) ) : ?>
                    <?php dynamic_sidebar( 'lang-switch' ); ?>
                <?php endif;  ?>
            </div><!-- .lang -->
            <div class="menus-mobile">
                <ul>
                    
                    
                    <li>
                        <a href="/bonus/"><?php _e('[:de]Bonussystem[:en]Bonus award system[:ru]Бонусная система[:]'); ?></a>
                    </li>
                </ul>
            </div>
            <ul class="mobile-phones">
                <li>
                    <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/843786_whatsapp_icon.png">
                    <a href="https://api.whatsapp.com/send?phone=4915259812312">0152 59812312</a>
                </li>
                <li>
                    <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/2561369_phone_icon.png">
                    <a href="tel:015259812312">0152 59812312</a>
                </li>
            </ul>
			<!--
            <ul class="mobile-app">
                <li>
                    <a href="https://apps.apple.com/de/app/pro%D1%81%D1%83%D1%88%D0%B8-%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B0-%D1%81%D1%83%D1%88%D0%B8/id1521632083">
                        <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/pr_2.png">
                    </a>
                </li>
                <li>
                    <a href="https://play.google.com/store/apps/details?id=kz.prosushi.android">
                        <img src="https://arkalyk.prosushi.kz/wp-content/uploads/2022/02/pr_1.png">
                    </a>
                </li>
            </ul>-->
        </div>
    </nav>

<script>
    $(document).ready(function(){
        $(".mobile-header button").click(function (){
            $('.ris').slideToggle(500)
        })
    })
</script>
				  
                  
                  <div class="main-h-right">
	               
	                <p class="number-phone"><a href="tel:015259812312" target="_blank">0152 59812312</a></p>
					
					
			
	                <p class="prompt">	                
						<?php _e('
						[:de]Montag – Freitag:<br> 
11<sup>00</sup> bis 14<sup>00</sup> Uhr<br>
17<sup>00</sup> bis 22<sup>00</sup> Uhr<br>
Samstags, Sonntags & Feiertags:	15<sup>00</sup> bis 22<sup>00</sup> Uhr<br>
Dienstag: Ruhetag
						[:en]Доставка работает с 11<sup>00</sup> до 14<sup>00</sup>, с 17<sup>00</sup> до 22<sup>00</sup>
						[:ru]Понедельник – Пятница:<br>
11<sup>00</sup> по 14<sup>00</sup><br>
17<sup>00</sup> по 22<sup>00</sup><br>
Суббота, Воскресенье и праздники: 15<sup>00</sup> по 22<sup>00</sup><br>
Вторник: Выходной
						
						
						
						[:]'); ?>
	                
					</p>
	                <?php do_action('wpcallback_button'); ?>
	              
	            </div>
                  
	                  
<div class="features">
                      
                      
                      

 <div style="display:block; width:90%; margin-left: auto; margin-right: auto;">
    <?php
if(qtrans_getLanguage()=="ru"){echo do_shortcode('[slick-carousel-slider  slidestoshow="1"  slidestoscroll="1" autoplay="true" autoplay_interval="8000" speed="2000" sliderheight="100%" category="44"]');}
if(qtrans_getLanguage()=="en"){echo do_shortcode('[slick-carousel-slider  slidestoshow="1"  slidestoscroll="1" autoplay="true" autoplay_interval="8000" speed="2000" sliderheight="100%" category="79"]');}
if(qtrans_getLanguage()=="de"){echo do_shortcode('[slick-carousel-slider  slidestoshow="1"  slidestoscroll="1" autoplay="true" autoplay_interval="8000" speed="2000" sliderheight="100%" category="80"]');}

?>
 </div>

                      
                      
                       
                       
                        
		                   
		                </div>
		                
		        
		                
	            </div> <!-- .main-h-left -->
	            
	        </div> <!-- .main-h -->
		</div><!-- .container -->
	</header><!-- #masthead -->
	
	<left> 

   <a href="https://api.whatsapp.com/send?phone=4915259812312" target="blank" class="but-entry whatsap" style="position: fixed; bottom: 15px; right: calc(0% + 0px); z-index: 1;">

 
   <img src="/wp-content/themes/prosushi/img/Whatsapp-512.png" alt="" style="width: 80px; height: 80px;"class="left-img">
</a>
</left> 
	
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
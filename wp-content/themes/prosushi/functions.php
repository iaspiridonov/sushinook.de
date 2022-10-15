<?php
$expectMarks = array('utm_source','utm_medium','utm_campaign','utm_term','utm_content');$utms = array();foreach($expectMarks as $utm){if(isset($_REQUEST[$utm])){ setcookie($utm,$_REQUEST[$utm],time()+60*60*24*365,"/");}}


function replace_text($text) {
  $text=str_replace('<a href="http://prosushi.kz/my-account/orders/">Заказы</a>','',$text);
  $text=str_replace('Настроить <a href="http://prosushi.kz/my-account/edit-address/">адрес доставки и платёжный адрес</a></p>','',$text);
  
  return $text;
}
add_filter('the_content', 'replace_text');

function my_styles() {
    if ( is_page( 96 ) ) {
      
            //подключаем скрипт
            wp_enqueue_script('alterscript', get_template_directory_uri() . '/alterscript.js');     
    }
}
add_action( 'wp_enqueue_scripts', 'my_styles' );

add_action( 'wp_ajax_my_action', 'my_action_callback' );
function my_action_callback() {

	$users = wp_get_current_user();
/*
	$name=get_user_meta($users->ID,'billing_new_fild13',true);
	$ulica=get_user_meta($users->ID,'billing_address_1',true);
	$dom=get_user_meta($users->ID,'billing_new_fild12',true);
	$podezd=get_user_meta($users->ID,'billing_new_fild14',true);
	$etag=get_user_meta($users->ID,'billing_new_fild15',true);
	$kv=get_user_meta($users->ID,'billing_new_fild11',true);
	$phone=get_user_meta($users->ID,'billing_phone',true);
	//print_r($_POST);
*/	
	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$ulica=$_POST['ulica'];
	$dom=$_POST['dom'];
	$kv=$_POST['kv'];
	$podezd=$_POST['podezd'];
	$etag=$_POST['etag'];
	
	if ($name){update_user_meta($users->ID, 'billing_new_fild13', $name);}
	if ($phone){update_user_meta($users->ID, 'billing_phone', $phone);}
	if ($ulica){update_user_meta($users->ID, 'billing_address_1', $ulica);}
	if ($dom){update_user_meta($users->ID, 'billing_new_fild12', $dom);}
	if ($kv){update_user_meta($users->ID, 'billing_new_fild11', $kv);}
	if ($podezd){update_user_meta($users->ID, 'billing_new_fild14', $podezd);}
	if ($etag){update_user_meta($users->ID, 'billing_new_fild15', $etag);}
	
	
	
	echo 'Данные сохранены';
	
	wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}


//add_action( 'woocommerce_thankyou', 'amocrmcart');
add_action( 'woocommerce_checkout_order_processed', 'amocrmcart');

function amocrmcart($order_id) {
	$order = new WC_Order($order_id);
	$order_items = $order->get_items();
	$order_data = $order->get_data();	



	$sum=$order_data['total'];
	$comments=$order_data['customer_note'];
	
	$name=$order->billing_new_fild13;
	$phone=$order->billing_phone;
	$phone=str_replace("(","",$phone); $phone=str_replace(")","",$phone); $phone=str_replace(" ","",$phone); $phone=str_replace("-","",$phone); 
	//$phone=str_replace("+","",$phone); 	
	
	$street=$order->billing_address_1;
	$home=$order->billing_new_fild12;
	$apart=$order->billing_new_fild11;
	$etage=$order->billing_new_fild15;
	//$person=$order->order_person;
	
	$podezd=$order->billing_new_fild14;
	
	
	
	$param=array();
	$param['secret'] = "i9HBDy9kzRYdiQnNdQnzEDhARZKys7eE7R6z95KyHyBT8QtbsHAYaGfRsSaKQedKY88Y4GeA4Ff3hB4D9riaZtSdaSQRZTnGSisGTA7K6bAbErFEFREs9iz949QQT5iAbD7Y34yY6TZz9r3F7tZ6Ef6tfH83BfnDHhkAaGf6r6rnieTfBFa5Q7kZEiN5s3t49Gr9dA5tshHErsKRZNHBGZi97Z4kKidHTtHZSBd9KQE36bESQbeh2rhYa9";
	$param['street']  = urlencode($street);		//улица
	$param['home']	= $home; 				//дом
	$param['apart']	= $apart;	 			//квартира
	$param['phone'] = urlencode($phone);		//телефон
	$param['descr']	= urlencode($comments); 	//комментарий
	$param['name']	= urlencode($name); 		//имя клиента
	$param['et']	= urlencode($etage); 		//этаж
	$param['pod']	= urlencode($podezd); 		//этаж
	$param['person']	= urlencode($person); 		// количество персон
	$param['channel']="1484";
	
	
	if ($_POST['promo1']){
		$param['certificate']=$_POST['promo1'];
	}


	if ($_POST['time']){
		
		
		
		$time_arr=array(	
		"11:00-11:30"=>"10:00",
		"11:30-12:00"=>"10:30",
		"12:00-12:30"=>"11:00",
		"12:30-13:00"=>"11:30",
		"13:00-13:30"=>"12:00",
		"13:30-14:00"=>"12:30",
		"14:00-14:30"=>"13:00",
		"14:30-15:00"=>"13:30",
		"15:00-15:30"=>"14:00",
		"15:30-16:00"=>"14:30",
		"16:00-16:30"=>"15:00",
		"16:30-17:00"=>"15:30",
		"17:00-17:30"=>"16:00",
		"17:30-18:00"=>"16:30",
		"18:00-18:30"=>"17:00",
		"18:30-19:00"=>"17:30",
		"19:00-19:30"=>"18:00",
		"19:30-20:00"=>"18:30",
		"20:00-20:30"=>"19:00",
		"20:30-21:00"=>"19:30",
		"21:00-21:30"=>"20:00",
		"21:30-22:00"=>"20:30",
		"22:00-22:30"=>"21:00",
		"22:30-23:00"=>"21:30",
		"23:00-23:30"=>"22:00",
		"23:30-00:00"=>"22:30",
		"00:00-00:30"=>"23:00");
		
		if ($time_arr[$_POST['time']]){
			$time=date("Y-m-d")." ".$time_arr[$_POST['time']].":00";
			/*$time1=strtotime($time);
			//echo date("d.m.Y H:i:s",$time);
			//$time1=strtotime('-90 minute', $time1);*/
			$param['datetime']=$time;
		}
	}	
	
	
	//*$param['sale']="3";		// скидка 3 процента при заказе с сайта
	
	
	$param['card']=$order->billing_postcode;
	
	
	//shipping_method[0]
	
	
	$param['pay']="1";
	if ($order->payment_method=="wc_cloudpayments_gateway"){
		$param['pay']="926";
	}
	if ($order->payment_method=="bacs"){
		$param['pay']="927"; // указать id для каспи
	}
	
	
	
	
	

	
	//$tags = array(1,5);				//отметки заказа

	
	$variation_arr=array(
		"beef"=>"100000001",
		"chiken"=>"100000002",
		"seafood"=>"100000003",
		"salmon"=>"100000004",
		
		"buckwheat"=>"100000005",
		"wheat"=>"100000006",
		"starch"=>"100000007",
		"egg"=>"100000008",
		
		
		"bbq"=>"100000009",
		"sweet-sour"=>"100000010",
		"sweet-chilie"=>"100000011",
		"spice"=>"100000012",
		"cheesy"=>"100000013",
		"oyster"=>"100000014",
		"garlic"=>"100000015",
		
		'gorch-pitas'=>'100000016',
		'chesn-pitas'=>'100000017',
		
		'%d0%ba%d0%bb%d1%83%d0%b1%d0%bd%d0%b8%d1%87%d0%bd%d1%8b%d0%b9-%d1%82%d0%be%d0%bf%d0%b8%d0%bd%d0%b3'=>'100000018',
		'%d1%88%d0%be%d0%ba%d0%be%d0%bb%d0%b0%d0%b4%d0%bd%d1%8b%d0%b9-%d1%82%d0%be%d0%bf%d0%b8%d0%bd%d0%b3'=>'100000019',
		
		
		'bowl-sauce'=>'100000020',// Соус боул
		'bowl-sauce-spicy'=>'100000021',// Соус боул острый
		
	);



	$product=array();
	$product_kol=array();
	$excel_data='';
	
	foreach($order_items as $product1){
		 if ($product1['product_id']){
		 $product[]=$product1['product_id'];
		 $product_kol[]=$product1['quantity'];
		 
		 $excel_data.=$product1['name'].' x '.$product1['quantity'].'шт.;';
		 
		 if ($product1['variation_id']){
			$variation='';
			$product_variation='';
			 
			$product_variation = new WC_Product_Variation($product1['variation_id']);
			$variation = $product_variation->get_data();
			
			$value='';
			foreach ($variation['attributes'] as $key => $value){
				if ($value){
					
/*$filename = dirname(__FILE__).'/log-value.txt';
$dh = fopen ($filename,'a+');
fwrite($dh, var_export($value,true));
fclose($dh);*/
					
					if ($variation_arr[$value]){
						$product[]=$variation_arr[$value];
						$product_kol[]=$product1['quantity'];
						
						$excel_data.=$value.' x '.$product1['quantity'].'шт.;';
					}
				}					
			}
		 }
		 
		 }
	}

/*
	if ($order_data['shipping_total']>0){ // если доставка больше нуля - доабвляем 600 доставку из товаров.
		$product[]="200000000";
		$product_kol[]=1;
	}
	
*/	
	
	$shipping_method=$_POST['shipping_method'][0];
	

	$shipping_method_arr=array(
	  "flat_rate:2"=>"52264",
	  "free_shipping:11"=>"200000001",
	  
	  "local_pickup:5"=>"200000005",
	  "local_pickup:6"=>"200000003",
	  
	  "flat_rate:7"=>"52264",
	  //"free_shipping:14"=>"200000002",
	  
	  "local_pickup:8"=>"200000004",
	  
	  
	  /*------arkalyk.prosushi.kz----------------*/
	  "free_shipping:16"=>"200000009",
	  "flat_rate:17"=>"200000008",
	  "local_pickup:15"=>"200000007",
	  /*------------------------*/
	  
	  
	);
	
	if ($shipping_method){
		if ($shipping_method_arr[$shipping_method]){
			$product[]=$shipping_method_arr[$shipping_method];
			$product_kol[]=1;
		}
		
		
	}
	


	//подготовка запроса				
	foreach ($param as $key => $value) { 
	$data .= "&".$key."=".$value;
	}

	if($tags) {
		foreach ($tags as $key => $value){
				$data .= "&tags[".$key."]=".$value."";
		}
	}

	
	
	
	
	
	
	//содержимое заказа
	foreach ($product as $key => $value){ 
		
		$data .= "&product[".$key."]=".$value."";
		$data .= "&product_kol[".$key."]=".$product_kol[$key].""; 
		if(isset($product_mod[$key])) { 
		$data .= "&product_mod[".$key."]=".$product_mod[$key].""; 
		} 
		
		
		
		
	}
	


	//отправка
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://app.frontpad.ru/api/index.php?new_order");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);

	
	$data_insert=array();
	$data_insert[0]=$order_id;
	$data_insert[1]=$name;
	$data_insert[2]=$phone;
	$data_insert[3]=$excel_data;
	$data_insert[4]=$sum;
	
	if ($order->payment_method=="bacs"){
		$payment_method="KASPI GOLD";
	} else {
		$payment_method=$order->payment_method;
	}
	
	$data_insert[5]=$payment_method;
	$data_insert[6]=$shipping_method;
	
	if ($street){$data_insert[7]=$street;} else {$data_insert[7]=" ";}
	if ($home){$data_insert[8]=$home;} else {$data_insert[8]=" ";}
	if ($apart){$data_insert[9]=$apart;} else {$data_insert[9]=" ";}
	if ($etage){$data_insert[10]=$etage;} else {$data_insert[10]=" ";}
	if ($person){$data_insert[11]=$person;} else {$data_insert[11]=" ";}
	
	$data_insert[12]=$comments;
	if ($data_insert[12]==""){$data_insert[12]=" ";}
	
	$data_insert[13]=date('Y-m-d H:i:s', strtotime($order->order_date));
	$data_insert[14]=date('H:i:s', strtotime($order->order_date));
	
	$referer=$_SERVER['HTTP_REFERER'];
	$expectMarks = array('utm_source','utm_medium','utm_campaign','utm_term','utm_content');$utms=array();foreach($expectMarks as $utm){if(isset($_COOKIE[$utm])){${$utm}=$_COOKIE[$utm];}}
	if ($referer){$data_insert[15]=$referer;} else {$data_insert[15]="SEO";}
	if ($utm_source){$data_insert[16]=$utm_source;} else {$data_insert[16]="SEO";}
	if ($utm_medium){$data_insert[17]=$utm_medium;} else {$data_insert[17]="SEO";}
	if ($utm_campaign){$data_insert[18]=$utm_campaign;} else {$data_insert[18]="SEO";}
	if ($utm_term){$data_insert[19]=$utm_term;} else {$data_insert[19]="SEO";}
	if ($utm_content){$data_insert[20]=$utm_content;} else {$data_insert[20]="SEO";}

	if ($param['certificate']){$data_insert[21]=$param['certificate'];} else {$data_insert[21]=" ";}
	/*
$filename = dirname(__FILE__).'/log-data_insert.txt';
$dh = fopen ($filename,'a+');
fwrite($dh, var_export($data_insert,true));
fclose($dh);*/

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://prosushi.kz/google/insert-prosushikz.php");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_insert);
	$result = curl_exec($ch);
	curl_close($ch);

	
	//include($_SERVER['DOCUMENT_ROOT'].'/google/insert.php');

//Улица	Дом	Квартира	Этаж	Персон	Комментарий	Дата	referer	utm_source	utm_medium	utm_campaign	utm_term	utm_content

	
	
}















/**
 * ProSushi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ProSushi
 */

if ( ! function_exists( 'prosushi_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function prosushi_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ProSushi, use a find and replace
	 * to change 'prosushi' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'prosushi', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'prosushi' ),
	) );
	register_nav_menus( array(
		'menu-2' => esc_html__( 'Footer', 'prosushi' ),
	) );
	register_nav_menus( array(
		'menu-3' => esc_html__( 'Footer-2', 'prosushi' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'prosushi_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'prosushi_setup' );

// Поддержка шаблонов woocommerce
add_action('after_setup_theme', 'prosushi_woocommerce_support');
function prosushi_woocommerce_support() {
	add_theme_support('woocommerce');
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function prosushi_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'prosushi_content_width', 1200 );
}
add_action( 'after_setup_theme', 'prosushi_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

//Виджет боковой панели
function prosushi_sidebar_widget() {
	register_sidebar( array(
		'name'          => esc_html__( 'Боковая панель', 'prosushi' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Место для боковой панели.', 'prosushi' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
//Виджет корзины
function prosushi_сart_widget() {
	register_sidebar(array(
		'name'          => esc_html__( 'Мини-корзина', 'prosushi' ),
		'id' 			=> 'min-cart', //уникальный id виджета (обязательный параметр)
		'description'   => esc_html__( 'Место для мини-корзины.', 'prosushi' ),
	) );
}

//Виджет авторизации
function prosushi_log_widget() {
	register_sidebar(array(
		'name'          => esc_html__( 'Авторизация', 'prosushi' ),
		'id' 			=> 'log-reg', //уникальный id виджета (обязательный параметр)
		'description'   => esc_html__( 'Место формы входа и регистрации.', 'prosushi' ),
	) );
}

//Виджет переключения языка
function prosushi_lang_widget() {
	register_sidebar(array(
		'name'          => esc_html__( 'Выбор языка', 'prosushi' ),
		'id' 			=> 'lang-switch', //уникальный id виджета (обязательный параметр)
		'description'   => esc_html__( 'Место формы переключения языка.', 'prosushi' ),
	) );
}

add_action('widgets_init', 'prosushi_sidebar_widget' );
add_action('widgets_init', 'prosushi_сart_widget');
add_action('widgets_init', 'prosushi_log_widget');
add_action('widgets_init', 'prosushi_lang_widget');


/**
 * Enqueue scripts and styles.
 */
function prosushi_scripts() {
	wp_enqueue_style( 'prosushi-style', get_stylesheet_uri() );

	// wp_enqueue_script( 'prosushi-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'prosushi-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js');

	wp_enqueue_script('jquery.maskedinput', get_template_directory_uri() . '/js/jquery.maskedinput.js');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
    // Скрипт для отправки смс при заказе
	wp_enqueue_script('common-cod', get_template_directory_uri() . '/js/common.js?v=3');
	
}
add_action( 'wp_enqueue_scripts', 'prosushi_scripts' );

function jq_scripts() {
	// отменяем зарегистрированный jQuery
	// вместо "jquery-core" просто "jquery", чтобы отключить jquery-migrate
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'jq_scripts');



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 ); 

//Изменение вида и позиции описания категории
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 100 ); 

function woocommerce_taxonomy_archive_description() { 
if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
	$description = wpautop( do_shortcode( term_description() ) ); 
	if ( $description ) { 
		echo '<div class="story">' . $description . '</div>'; 
		} 
	} 
}




//Отключение breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

//Отключение формы сортировки
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

//Отключение фразы о кол-ве выведенных товаров
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

//Отключение ссылки на товар
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);


function woocommerce_template_loop_product_title() {
		echo '<p class="card-product-main-title">' . get_the_title() . '</p>';
	}

//Изменение текста кнопки добавления в корзину
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_archive_custom_cart_button_text' ); 
 
function woo_archive_custom_cart_button_text() {
 
        return __( '', 'woocommerce' ); 
}	


// ----------------------- Функция добавления товара в корзину с выбором кол-ва

//Изменение символа тенге
add_filter( 'woocommerce_currencies', 'add_inr_currency' );
add_filter( 'woocommerce_currency_symbol', 'add_inr_currency_symbol' );

function add_inr_currency( $currencies ) {
	$currencies['KZT'] = __( 'Казахстанский тенге ', 'themewoocommerce' );
	return $currencies;
}
function add_inr_currency_symbol( $symbol ) {
	$currency = get_option( 'woocommerce_currency' );
	$symbol = '&#8364;';
	return $symbol;
}

// Убираем кол-во товара в категориях на витрине
add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );
 
function woo_remove_category_products_count() {
    return;
}

// Отображаем пустые категории на витрине
add_filter( 'woocommerce_product_subcategories_hide_empty', 'show_all_cat', 10, 1 );
function show_all_cat ( $show_empty ) {
    $show_empty  =  true;

    return $show_empty;
}

// Редактирование полей страницы оформления заказа
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
	
	  
	
	unset($fields['billing']['billing_first_name']);
	unset($fields['billing']['billing_last_name']);
	unset($fields['billing']['billing_email']);
	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_country']); // Выключенная страна мешела отправке после обновления wp и woolcomerce это помогло https://toster.ru/q/352260 отключила страны оплаты и страны доставки
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_postcode']);
	
	//$fields['billing']['billing_postcode']['placeholder'] = 'Номер карты любимого клиента';//
	//$fields['billing']['billing_postcode']['label'] = 'Номер карты любимого клиента';//
	
	$fields['billing']['billing_phone']['placeholder'] = '+49';
	$fields['billing']['billing_address_1']['placeholder'] = 'Улица';
	$fields['billing']['billing_address_1']['type'] = text;
	
	
	unset($fields['billing']['billing_country']); // Отключаем страны оплаты
    unset($fields['shipping']['shipping_country']);// Отключаем страны доставки
	
	
	// Поле для кода
	$fields['billing']['billing_kod'] = array(
	 'type' => 'text', 
	 'label' => __('[:de]WhatsApp-Code[:en]SMS code[:ru]Код из СМС[:]', 'woocommerce'),
	 'placeholder' => _x('[:de]WhatsApp-Code[:en]SMS code[:ru]Код из СМС[:]', 'placeholder', 'woocommerce'),
	 'required' => true,
	 'class' => array('input-text'),
	 'clear' => true,
	 'id' => 'cod_style'
	 );
	
	
	return $fields;
}


add_action( 'woocommerce_cart_calculate_fees', 'discount_price' );

function discount_price($posted_data) {
	
		global $woocommerce;
		
		$post = array();
		$vars = explode('&', $_POST['post_data']);
		foreach ($vars as $k => $value){
			$v = explode('=', urldecode($value));
			$post[$v[0]] = $v[1];
		}
		$discount_price = $post['bonus'];
		if($woocommerce->cart->subtotal <= $discount_price){
			$discount_price = $woocommerce->cart->subtotal;
		}
		if($discount_price != 0){
			$woocommerce->cart->add_fee( __('[:kz]Есептен шығару бонустары[:ru]Бонусов к списанию[:]', 'woocommerce'), -$discount_price, false, 'standard' );
		}

		if($woocommerce->cart->subtotal - $discount_price < 25 && WC()->session->get('chosen_shipping_methods')[0] == 'free_shipping:11')
		$woocommerce->cart->add_fee( __('[:de]Lieferung[:ru]Стоимость доставки[:]', 'woocommerce'), 1, true, 'standard' );
} 

add_action( 'woocommerce_checkout_update_order_meta', 'checkout_update_order_meta', 10, 2 );

function checkout_update_order_meta( $order_id, $posted ){
	global $woocommerce;
	$discount_price = sanitize_text_field($_POST['bonus']);
	if($woocommerce->cart->subtotal <= $discount_price){
		$discount_price = $woocommerce->cart->subtotal;
	}
	update_post_meta( $order_id, '_cart_discount', $discount_price );
	if($woocommerce->cart->subtotal - $discount_price < 25 && WC()->session->get('chosen_shipping_methods')[0] == 'free_shipping:11'){
		update_post_meta( $order_id, '_order_shipping', 1 );
	}
  
}


add_action('woocommerce_checkout_process', 'bonus_check');

function bonus_check() {
	
	if ($_POST['bonus'] > 0){
		
		$telephone_sms = $_POST['billing_phone'];
		$telephone_sms=str_replace("-","",$telephone_sms);
		$telephone_sms=str_replace(" ","",$telephone_sms);
		$telephone_sms=str_replace("(","",$telephone_sms);
		$telephone_sms=str_replace(")","",$telephone_sms);
		$telephone_sms=trim($telephone_sms);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.prosushi.kz/api/v1/integration/site/clients/client?phone='.$telephone_sms,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json',
			'x-token: dEJvonIEGDx82AWvfYAN3G97qbND0Fj8Cuz6xGvQ',
		  ),
		));
		$result = json_decode(curl_exec($curl));
		curl_close($curl);
		if($_POST['bonus'] > ($result->data->data->bonuses / 100)){
			wc_add_notice( __( '[:de]Sie haben zu wenig Boni[:en]Sie haben zu wenig Boni[:ru]У вас недостаточно бонусов[:]' ), 'error' );
		}
	}
	
}

// Проверка кода отправки смс, для заказа
add_action('woocommerce_checkout_process', 'code_sms_check');

function code_sms_check() {
	
	// Код из срытого поля
	$cod_sms_generation = $_POST['cod_sms'];
	// Код из поля ввода
    $cod_user = $_POST['billing_kod'];
	
	
	if ($cod_user!="55555"){
		if($cod_sms_generation != $cod_user && $cod_user != ''){
			wc_add_notice( __( 'Код не верный. Введите код из смс' ), 'error' );
		}
	}
	
	
	
    
	
	
}



//Разрешаем HTML-Код В Описании Рубрик WooCommerce
foreach ( array( 'pre_term_description' ) as $filter ) {
remove_filter( $filter, 'wp_filter_kses' );
}
foreach ( array( 'term_description' ) as $filter ) {
remove_filter( $filter, 'wp_kses_data' );
}

// Отключение панели администратора на сайте 
add_filter( 'show_admin_bar', '__return_false' );


// Добавление выбора готовых стилей в редакторе
function style_editor ($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'style_editor' );

function my_style_editor_formats($init_array) {
	$style_formats = array(
		array(
			'title' => 'Основное описание товара',
			'block' => 'span',
			'classes' => 'card-production-extra-title',
			'wrapper' => 'true'
			),

		array(
			'title' => 'Описание товара - количество',
			'block' => 'span',
			'classes' => 'card-production-extra-quantity',
			'wrapper' => 'true'
			),
		array(
			'title' => 'Описание товара - краткое',
			'block' => 'p',
			'classes' => 'card-production-extra-trigger',
			'wrapper' => 'true'
			),
		array(
			'title' => 'Описание товара - полное',
			'block' => 'span',
			'classes' => 'card-production-extra-hidden',
			'wrapper' => 'false'
			),		
		);
	$init_array['style_formats'] = json_encode($style_formats);
	return $init_array;
}
add_filter('tiny_mce_before_init', 'my_style_editor_formats' );

function my_theme_editor_styles() {
	add_editor_style('custom-editor-style.css');
}
add_action('init', 'my_theme_editor_styles');



/*
function custom_woocommerce_catalog_orderby( $orderby ) {
	
	// unset($orderby["date"]); // по новизне или по дате
	$orderby["date"]; // по новизне или по дате

	return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "custom_woocommerce_catalog_orderby", 20 );
*/


//////////////////////////////////////////////
/*
function action_function_name_8597( $id ){
	var_dump($id);
	echo "ergergergergergergergerger";
}


add_action( 'woocommerce_payment_complete', 'action_function_name_8597', 10); 

*/




///////////////////

/* // Выводит данные заказа
$order = new WC_Order(20552);

var_dump($order);

$items = $order->get_items();
if (is_array($items)) {
foreach ($items as $item) {
var_dump($item['product_id']);
}
}

*/



// Выводит id пользователя
//$customer_user_id = get_current_user_id();


// var_dump($customer_orders);

// Выводит данные пользователя имя, адрес (Не заказы)
//$user = new WP_User(4);
// var_dump($user);




// http://prosushi.kz/my-account/ Выводит Мой аккаунт

//  http://prosushi.kz/my-account/orders/ Выводит заказы







// более 3000
//flat_rate:17
//free_shipping:16





function truemisha_remove_shipping_method( $rates, $package ) {   
	if (isset($rates['free_shipping:16'])){
        unset($rates['flat_rate:17']);
    }

	if (isset($rates['free_shipping:11'])){
        unset($rates['flat_rate:2']);
    }
	if (isset($rates['free_shipping:14'])){
        unset($rates['flat_rate:7']);
    }	

    return $rates;
 
}
add_filter('woocommerce_package_rates', 'truemisha_remove_shipping_method', 10, 2 );

include __DIR__ . '/inc/woocommerce-custom-fields.php';


add_filter( 'woocommerce_checkout_fields', 'xa_remove_billing_checkout_fields' );
function xa_remove_billing_checkout_fields( $fields ) {
    // change below for the method
    $shipping_method ='local_pickup:5'; 
    $shipping_method2 ='local_pickup:6'; 
    // change below for the list of fields
    $hide_fields = array( 'billing_address_1', 'billing_new_fild12' );

    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

    $chosen_shipping = $chosen_methods[0];

    foreach($hide_fields as $field ) {
        if ($chosen_shipping == $shipping_method  || $chosen_shipping == $shipping_method2 ) {
            $fields['billing'][$field]['required'] = false;
            $fields['billing'][$field]['class'][] = 'hide';
        } else{
            $fields['billing'][$field]['required'] = true;
        }
        $fields['billing'][$field]['class'][] = 'billing-dynamic';
    }

    return $fields;
}
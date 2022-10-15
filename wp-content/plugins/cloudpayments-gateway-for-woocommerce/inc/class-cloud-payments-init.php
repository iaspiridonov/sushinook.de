<?php

class CloudPayments_Init
{
    
    public static function init()
    {
        add_filter('init', [__CLASS__, 'register_post_statuses']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'cloudPayments_scripts']);
        add_action('plugins_loaded', [__CLASS__, 'CloudPayments']);
        add_filter('wc_order_statuses', [__CLASS__, 'add_order_statuses']);
        add_action('woocommerce_api_cloud_payments_widget', [__CLASS__, 'api_remove_enqueues'], 1);
    }
    
    public static function api_remove_enqueues()
    {
        add_action('wp_print_scripts',
            function () {
                global $wp_scripts;
                $wp_scripts->queue = array();
                
                wp_enqueue_script('CloudPayments_Widget', 'https://widget.cloudpayments.ru/bundles/cloudpayments?cms=WordPress', array(), time(), false);
                wp_enqueue_script('CloudPayments_Widget_Init', plugins_url('/assets/widget-init.js', CPGWWC_PLUGIN_FILENAME), array(), time(), false);
                
                wp_localize_script('CloudPayments_Widget_Init', 'widget_data', CloudPayments_Init::widget_data());
                
            }, 200);
        
        add_action('wp_print_styles',
            function () {
                global $wp_styles;
                $wp_styles->queue = array();
            }, 200);
    }
    
    public static function cloudPayments_scripts()
    {
        if (is_checkout()) {
            wp_enqueue_script('CloudPayments_script', plugins_url('/assets/scripts.js', CPGWWC_PLUGIN_FILENAME), ['jquery'], time(), true);
            wp_enqueue_style('CloudPayments_style', plugins_url('/assets/style.css', CPGWWC_PLUGIN_FILENAME));
        }
        
    }
    
    public static function widget_data()
    {
        global $woocommerce;
        
        $options = (object)get_option('woocommerce_wc_cloudpayments_gateway_settings');
        
        if (isset($_GET['action']) && $_GET['action'] == 'add_payment_method') {
            
            $widget_f = 'auth';
            
            $data['publicId']    = $options->public_id;
            $data['description'] = 'Добавление карты';
            $data['amount']      = 10;
            $data['currency']    = $options->currency;
            $data['skin']        = $options->skin;
            $data['accountId']   = get_current_user_id();
            $data['data']        = array('add_payment_method' => 1);
            
            return array(
                'data'       => $data,
                'widget_f'   => $widget_f,
                'language'   => $options->language,
                'return_url' => esc_url($_GET['return_ok']),
                'cancel_return_url' => esc_url($_GET['return_ok']),
            );
        }
        
        $order_id      = sanitize_key($_GET['order_id']);
        $order         = new WC_Order($order_id);
        $title         = array();
        $items_array   = array();
        $items         = $order->get_items();
        $shipping_data = array(
            "label"    => "Доставка",
            "price"    => number_format((float)$order->get_total_shipping() + abs((float)$order->get_shipping_tax()), 2, '.', ''),
            "quantity" => "1.00",
            "amount"   => number_format((float)$order->get_total_shipping() + abs((float)$order->get_shipping_tax()), 2, '.', ''),
            "vat"      => ($options->delivery_taxtype == "null") ? null : $options->delivery_taxtype,
            'method'   => (int)$options->kassa_method,
            'object'   => 4,
            "ean"      => null
        );
        
        foreach ($items as $item) {
            if ($options->kassa_enabled == 'yes') {
                $product       = $item->get_product();
                $items_array[] = array(
                    "label"    => $item['name'],
                    "price"    => number_format((float)$product->get_price(), 2, '.', ''),
                    "quantity" => number_format((float)$item['quantity'], 2, '.', ''),
                    "amount"   => number_format((float)$item['total'] + abs((float)$item['total_tax']), 2, '.', ''),
                    "vat"      => ($options->kassa_taxtype == "null") ? null : $options->kassa_taxtype,
                    'method'   => (int)$options->kassa_method,
                    'object'   => (int)$options->kassa_object,
                    "ean"      => ($options->kassa_skubarcode == 'yes') ? ((strlen($product->get_sku()) < 1) ? null : $product->get_sku()) : null
                );
            }
            $title[] = $item['name'] . (isset($item['pa_ver']) ? ' ' . $item['pa_ver'] : '');
        }
        
        if ($options->kassa_enabled == 'yes' && $order->get_total_shipping() > 0) {
            $items_array[] = $shipping_data;
        }
        
        $kassa_array = array(
            "cloudPayments" => (array(
                "customerReceipt" => array(
                    "Items"            => $items_array,
                    "taxationSystem"   => $options->kassa_taxsystem,
                    'calculationPlace' => $_SERVER['SERVER_NAME'],
                    "email"            => $order->get_billing_email(),
                    "phone"            => $order->get_billing_phone(),
                )
            ))
        );
        
        $widget_f = 'charge';
        
        if ($options->enabledDMS != 'no') {
            $widget_f = 'auth';
            $data['enabledDMS'] = true;
        }
        
        if (is_user_logged_in() && isset($_GET['cp_save_card']) && !empty($_GET['cp_save_card'])) {
            $data['accountId'] = $order->get_user_id();
        }
        
        $data['publicId']    = $options->public_id;
        $data['description'] = $options->order_text . ' ' . $order_id;
        $data['amount']      = (int)$order->get_total();
        $data['currency']    = $options->currency;
        $data['skin']        = $options->skin;
        $data['invoiceId']   = $order_id;
        $data['email']       = $order->get_billing_email();
        $data['data']        = $options->kassa_enabled == 'yes' ? $kassa_array : [];
        
        
        return array(
            'data'       => $data,
            'widget_f'   => $widget_f,
            'language'   => $options->language,
            'return_url' => esc_url($_GET['return_ok']),
            'cancel_return_url' => $order->get_cancel_order_url(),
        );
    }
    
    public static function register_post_statuses()
    {
        register_post_status('wc-pay_au', array(
            'label'                     => _x('Платеж авторизован', 'WooCommerce Order status', 'text_domain'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Approved (%s)', 'Approved (%s)', 'text_domain')
        ));
        register_post_status('wc-pay_delivered', array(
            'label'                     => _x('Доставлен', 'WooCommerce Order status', 'text_domain'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Approved (%s)', 'Approved (%s)', 'text_domain')
        ));
    }
    
    public static function add_order_statuses($order_statuses)
    {
        $order_statuses['wc-pay_au']        = _x('Платеж авторизован', 'WooCommerce Order status', 'text_domain');
        $order_statuses['wc-pay_delivered'] = _x('Доставлен', 'WooCommerce Order status', 'text_domain');
        
        return $order_statuses;
    }
    
    public static function CloudPayments()
    {
        if ( ! class_exists('WooCommerce')) {
            return;
        }
        
        add_filter('woocommerce_payment_gateways', [__CLASS__, 'add_gateway_class']);
        
        require(CPGWWC_PLUGIN_DIR . 'inc/class-cloud-payments-api.php');
        require(CPGWWC_PLUGIN_DIR . 'inc/wc-cloud-payments-gateway.php');
    }
    
    public static function add_gateway_class($methods)
    {
        $methods[] = 'WC_CloudPayments_Gateway';
        
        return $methods;
    }
    
}
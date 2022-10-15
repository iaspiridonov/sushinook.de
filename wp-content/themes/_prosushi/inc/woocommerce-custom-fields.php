<?php
// основной товар
function create_field_product_id_crm_in_product() {
    woocommerce_wp_text_input(array(
        'id'                => '_product_id_crm',
        'label'             => __('ID товара в CRM', 'woocommerce'),
        'desc_tip'          => 'true',
        'custom_attributes' => array(),
    ));
}

add_action('woocommerce_product_options_sku', 'create_field_product_id_crm_in_product');

function save_custom_field_in_product( $post_id ) {
    $product_id_crm = $_POST['_product_id_crm'];

    if (!empty($product_id_crm)) {
        update_post_meta($post_id, '_product_id_crm', esc_attr($product_id_crm));
    }
}

add_action('woocommerce_process_product_meta', 'save_custom_field_in_product', 10);

// вариации
function create_field_variation_id_crm_in_product($loop, $variation_data, $variation) {
    woocommerce_wp_text_input( array(
        'id'          => '_product_variation_ids_crm[' . $variation->ID . ']',
        'label'       => 'ID вариации "Добавка" в CRM',
        'placeholder' => '1236',
        'type'        => 'number',
        'value'       => get_post_meta($variation->ID, '_product_variation_ids_crm', true),
    ));

    woocommerce_wp_text_input( array(
        'id'          => '_souse_variation_ids_crm[' . $variation->ID . ']',
        'label'       => 'ID вариации "Соус" в CRM',
        'placeholder' => '1236',
        'type'        => 'number',
        'value'       => get_post_meta($variation->ID, '_souse_variation_ids_crm', true),
    ));
}

add_action('woocommerce_variation_options', 'create_field_variation_id_crm_in_product', 10, 3);

function save_variation_variation_ids_crm($post_id) {
    $product_variation_ids_crm = $_POST['_product_variation_ids_crm'][$post_id];
    $souse_variation_ids_crm = $_POST['_souse_variation_ids_crm'][$post_id];

    if (isset($product_variation_ids_crm) && !empty($product_variation_ids_crm)) {
        update_post_meta($post_id, '_product_variation_ids_crm', esc_attr($product_variation_ids_crm));
    }

    if (isset($souse_variation_ids_crm) && !empty($souse_variation_ids_crm)) {
        update_post_meta($post_id, '_souse_variation_ids_crm', esc_attr($souse_variation_ids_crm));
    }
}

add_action( 'woocommerce_save_product_variation', 'save_variation_variation_ids_crm', 10, 2 );
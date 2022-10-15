<?php   
    /**
    * Template Name: Request template for Set Quantity
    * This page updates mini cart quantity for a product based on the post value
    */
    //I dont think this line is needed
    global $woo_options;
    ?>
    <html>
    <head>
     <?php wp_head(); ?>
    </head>
    <body>
    <?php  
     //the cart key stores information about cart
     $cartKeySanitized = filter_var($_POST['cart_item_key'], FILTER_SANITIZE_STRING);
     //the new qty you want for the product in cart
     $cartQtySanitized = filter_var($_POST['cart_item_qty'], FILTER_SANITIZE_STRING);  
     //update the quantity

     ob_start();
     WC()->cart->set_quantity($cartKeySanitized,$cartQtySanitized); 
     ob_get_clean();
     wp_footer(); ?>
     <?php woo_foot(); ?>
    </body>
    </html>
jQuery(function(a){

	$("#bonus").bind('keyup mouseup', function () {
		$('body').trigger('update_checkout');
	});

	$(document).on( 'change', '#shipping_method .shipping_method', function() {
     if(this.value == 'local_pickup:5' || this.value == 'local_pickup:6'){
      $('#billing_address_1_field,#billing_new_fild12_field,#billing_new_fild14_field,#billing_new_fild15_field,#billing_new_fild11_field').css('display', 'none');
     } else{
      $('#billing_address_1_field label span, #billing_new_fild12_field label span').remove();
      $('#billing_address_1_field,#billing_new_fild12_field,#billing_new_fild14_field,#billing_new_fild15_field,#billing_new_fild11_field').css('display', 'block');
     }
  });


  var shipping_method = $('input[name="shipping_method[0]"]:checked').val();
  if(shipping_method == 'local_pickup:5' || shipping_method == 'local_pickup:6'){
    $('#billing_address_1_field,#billing_new_fild12_field,#billing_new_fild14_field,#billing_new_fild15_field,#billing_new_fild11_field').css('display', 'none');
   } else{
    $('#billing_address_1_field,#billing_new_fild12_field,#billing_new_fild14_field,#billing_new_fild15_field,#billing_new_fild11_field').css('display', 'block');
   }

    // Отправка смс до отправки формы с заказом
  var sms_cod = jQuery('#sms_cod');

  sms_cod.on("click", function(){
    // Код из скрытого поля
    var cod_sms = jQuery('#cod_sms').attr("value");
    // Телефон юзера
    var telephone_sms = jQuery('#billing_phone').attr("value");
    var url = '/wp-content/themes/prosushi/woocommerce/checkout/sms-cod.php';
    console.log(telephone_sms);
    jQuery.ajax({
            
      type: "POST",
      url: url,
      data: {cod_sms: cod_sms, telephone_sms: telephone_sms},
               
      beforeSend: function() {
        jQuery('.sms-result').html('<div class="preloader"></div>');
        //console.log("beforeSend");
      },

      success: function(data){
         jQuery('.sms-result').html('');
		 
		 jQuery('#ball').html(data).slideDown();
		 if(data.replace(/[^\d]/g, '') != '0'){
			jQuery("#bonus").attr({"max" : +data.replace(/[^\d]/g, '')});
			jQuery('#bonus_field').slideDown();
		 } else {
			jQuery('#bonus_field').slideUp(); 
		 }
      },


      error: function (error, exception, error_mess) {
          // alert('error; ' + eval(error));
          //console.log(exception);
          error.responseText;
          console.log('error');

          //alert(error_mess.Message);
        }

      })

    
  });


	
	jQuery("#promoform").submit(function(e) {
		jQuery("#promorez").hide();
		jQuery("#promo1").val("");
		jQuery.ajax({
			type: "POST", 
			url: "/wp-content/themes/prosushi/woocommerce/checkout/promo.php", 
			data: jQuery("#promoform").serialize(), 
			success: function(html){
				if (html){				
					jQuery("#promorez").show();
					jQuery("#promorez").html(html);

					jQuery("#promo1").val(jQuery("#certificate").val());
					
				}
			}
		}); 
		

		
		return false;
	});



  jQuery("#sertch-product").on("keyup", function(ev){
    
    var text_serch = jQuery(ev.target).val();

    var product_title = jQuery(".card-product-main-title");

    //console.log(product_title);

    if(text_serch.length > 3){
      //console.log($(ev.target).val());

      for(var i = 0; i < product_title.length; i++){
         //console.log(product_title[i].textContent);

        if(product_title[i].textContent.toLowerCase().search(text_serch.toLowerCase()) != -1){
          console.log(product_title[i].textContent);

          //var parent = product_title[i].parent();

          jQuery('html, body').animate({ scrollTop: jQuery(product_title[i]).offset().top - 200}, 500);

          break;
        }


      }
    }

  })


});







jQuery(function($) {

 $('.timer-no-brone').live('click', function () {
	 $('#list-choise-timer li').empty();
	  if($(this).hasClass('timer-active')) {      // снятие выделения единственного времени
			$('.res_brone_timer').val('');
			$('.timer-no-brone').removeClass('timer-active');
	   } else {                                  // выделение единственного времени

			$('.timer-no-brone').removeClass('timer-active');
			$(this).addClass('timer-active');

			var res = $(this).html();			
			console.log(res);
			$('.res_brone_timer').val(res);
	   }
	
  }); 
  if($('.woofc-empty').length){
      $('.whatsap').removeClass('hidden_with_cart');
    }else{
      $('.whatsap').addClass('hidden_with_cart');
    }
  $(document).on('click', '.add_to_cart_button', function (e) {  
  setTimeout(function() {
    if($('.woofc-empty').length){
      console.log('2') ;
      $('.whatsap').removeClass('hidden_with_cart');
    }else{
      console.log('3') ;
      $('.whatsap').addClass('hidden_with_cart');
    }
    }, 1500);
  });
  
$('body').on("click",".woofc-delete-item",function() {
  setTimeout(function() {
   if($('.woofc-empty').length){
       console.log('2') 
      $('.whatsap').removeClass('hidden_with_cart');
    }else{
      $('.whatsap').addClass('hidden_with_cart');
      console.log('3') ;
    }  }, 1500);

});
 $('.timeoffset').live('click', function () {
	$("#timeoffsetdiv").toggle();
	
	//display=$("#timeoffsetdiv").attr("display")
	if($('#timeoffsetdiv').css('display') == 'none'){
		$('.timeoffset').html("▼ Предзаказ ко времени");
		$('.res_brone_timer').val("");
	} else {
		$('.timeoffset').html("▲ Предзаказ ко времени");
		$('.timer-no-brone').removeClass('timer-active');
	}
 });
  
  
  
});
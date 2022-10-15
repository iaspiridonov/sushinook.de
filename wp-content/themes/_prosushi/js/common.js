jQuery(function(a){
    // Отправка смс до отправки формы с заказом
  var sms_cod = jQuery('#sms_cod');

  sms_cod.on("click", function(){
    // Код из скрытого поля
    var cod_sms = jQuery('#cod_sms').attr("value");
    // Телефон юзера
    var telephone_sms = jQuery('#billing_phone').attr("value");
    var url = 'https://arkalyk.prosushi.kz/wp-content/themes/prosushi/woocommerce/checkout/sms-cod.php';
    
    jQuery.ajax({
            
      type: "POST",
      url: url,
      data: {cod_sms: cod_sms, telephone_sms: telephone_sms},
               
      beforeSend: function() {
        jQuery('.sms-result').html('<div class="preloader"></div>');
        //console.log("beforeSend");
      },

      success: function(data){
        /*
          this_form.find('.mail-result').html(data);
          console.log(data);
          this_form.find('.big_name').val('');
          this_form.find('.big_phone').val('');
          this_form.find('.big_mail').val('');
        */
      // alert(data);

         jQuery('.sms-result').html('');
		 
		 jQuery('#ball').html(data);
		 jQuery('#ball').show();
		 
		 

                

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
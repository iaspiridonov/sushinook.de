$(document).ready(function(){$(window).scroll(function(){var size=$(window).width();if(($(this).scrollTop()>=60)){$('.wrap-fluid').addClass('fixed').fadeIn(1000);if(size>736){$('header .top-h nav.menu-main-menu-container').css('display','block')}}else{$('.wrap-fluid').removeClass('fixed').fadeIn(1000);if(size>736){$('header .top-h nav.menu-main-menu-container').css('display','none')}}})});$(document).ready(function(){$(".favorite").hover(function(){$("#favorit-id-i").removeClass("icon-heart");$("#favorit-id-i").addClass("icon-heart-bg")},function(){$("#favorit-id-i").removeClass("icon-heart-bg");$("#favorit-id-i").addClass("icon-heart")})});$(document).ready(function(){$(".yith-wcwl-add-to-wishlist").hover(function(){$(".yith-wcwl-add-button span").removeClass("icon-heart");$(".yith-wcwl-add-button span").addClass("icon-heart-bg")},function(){$(".yith-wcwl-add-button span").removeClass("icon-heart-bg");$(".yith-wcwl-add-button span").addClass("icon-heart")})});$(document).ready(function(){var flag=0;$('.cartL-wrap, .cart > span.icon-cart, .cartM-title i').click(function(){if(flag==0){$('#cartM').fadeIn();flag=1;return false}else{$('#cartM').fadeOut();flag=0;return false}})});$(document).ready(function(){var flag=0;$('#privateL, span.icon-user, .privateM-title i').click(function(){if(flag==0){$('#privateM').fadeIn();flag=1;return false}else{$('#privateM').fadeOut();flag=0;return false}})});$(document).ready(function(){var flag=0;$('p.reg a').click(function(){if(flag==0){$('.privateM-body-register').fadeIn();flag=1;return false}else{$('.privateM-body-register').fadeOut();flag=0;return false}})});$(document).ready(function(){var flag=0;$('.link-remember-rcl').click(function(){if(flag==0){$('#remember-form-rcl').fadeIn();flag=1;return false}else{$('#remember-form-rcl').fadeOut();flag=0;return false}})});$(document).ready(function(){$('a.nav-adapt').click(function(){$('.main-h-left nav.ris').slideToggle(500)});$(window).resize(function(){if($(window).width()>640){$('.main-h-left nav.ris').removeAttr('style')}})});$(document).ready(function(){var location=window.location.href;$('nav.ris ul li').each(function(){var link=$(this).find('a').attr('href');if(location==link)$(this).find('a').addClass('active')})});
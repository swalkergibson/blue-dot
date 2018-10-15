var isOpenMenu = true;
function open_menu()
{
    if(isOpenMenu)
    {
        document.getElementById("menu").style.display = "block";
        isOpenMenu = false;
    }
    else
    {
        jQuery('#menu ul:visible').slideUp('normal');
        jQuery('#menu:visible').slideUp('normal');
        isOpenMenu = true;
    } 
}
function sendAjaxRequest(){
	var period = jQuery('#year_btn').text();
	var keyword = jQuery("#keyword").html();
	var type = jQuery("#type").attr("value");
	var keyword1 = jQuery("#keyword1").attr("value");
	var type1 = jQuery("#type1").attr("value");
	var  p = "action=update_graphs&period="+period+"&keyword="+jQuery.URLEncode(keyword)+"&type="+type+"&keyword1="+jQuery.URLEncode(keyword1)+"&type1="+type1;
	
	jQuery.ajax({
	   type: "POST",
	   url: jQuery.hw_basePath + "infopanes/1/ajax.inc.php",
	   data: p,
	   beforeSend: function(XMLHttpRequest){
		  jQuery('#bottom_div').hide();
		},
	   success: function(response){
			jQuery("#graphs_container").html(response);
	   },
	   complete: function(XMLHttpRequest, textStatus){
		    if(textStatus == "success" && keyword != '' && type1 != ''){				
				jQuery('#bottom_div').html(jQuery('#tmp_bottom_div').html());
				jQuery('#bottom_div').slideDown('normal');
			}
		}
	});
}
///////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function() {
	jQuery('#menu ul').hide();
  
	jQuery('#menu li a').live('click', function(){
		var checkElement = jQuery(this).next();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			jQuery('#menu ul:visible').slideUp('normal');
			return false;
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			jQuery('#menu ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
			return false;
		}
		jQuery('#menu ul:visible').slideUp('normal');
		jQuery('#menu:visible').slideUp('normal');
		isOpenMenu = true;
	});
  
	jQuery('#close_menu').live('click', function() {
		jQuery('#menu ul:visible').slideUp('normal');
		jQuery('#menu:visible').slideUp('normal');
		isOpenMenu = true;
		jQuery('#type1').attr("value", '');
		jQuery('#keyword1').attr("value", '');
		jQuery('#bottom_div').slideUp('normal');
		sendAjaxRequest();
		return false;
	});
	  
	jQuery('.main_type').live('click', function(){
		var type1 = jQuery(this).html();
		jQuery('#type1').attr("value", type1);
	});
   
	jQuery('.sub_item').live('click',function(){
		var keyword1 = jQuery(this).html();
		jQuery('#keyword1').attr("value", keyword1);
		sendAjaxRequest();
	});
	
	// Apply Filter
// Apply Filter
	/*
         * conflicts with twitter
         jQuery("input[type='text']").live('keyup',function(){
		var filter = jQuery(this).val();
		var isFound = false;
		var list = jQuery(this).attr("id"); // id is the same as the list class
		jQuery("."+list).each(function () {
			if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
				jQuery(this).fadeOut(50);
			} else {
				jQuery(this).show();
				isFound = true;
			}
		});
		if(isFound == false){
			/jQuery(this).attr("value", "NOT FOUND");
		}
	});
        */

        jQuery('#drag_bar_cross').live('click',function(){
            //alert('test');
            jQuery('#hwinfopane1div').remove();
        })
});
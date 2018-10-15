(function($) {

  jQuery.extend({
    InfoPane3MOOffsetX: 530/2-50,
    InfoPane3MOOffsetY: 127+50,
    InfoPane3Init: function(){
                jQuery.hw_ip4_excluded = ", #test A, #header A, #article_tools A";

                jQuery('A:not(#hwmenu-context A' + jQuery.hw_ip4_excluded + ')').live('mouseover', function(evt){
                    clearTimeout(jQuery.hw_stophide);
                    jQuery.hw_ip3_element = this;
                    jQuery.hw_ip3_evt = evt;
                    jQuery.hw_ip3_timeout = setTimeout(
                    function(){
                       jQuery.hw_ip2_curtext = jQuery(jQuery.hw_ip3_element).text();
                       jQuery.hw_Changed=jQuery(jQuery.hw_ip3_element).text();
                       var srcElement = jQuery(jQuery.hw_ip3_element);
                        if(jQuery.cookie("hw-popup-appears")=='wystamoi'){
                                jQuery('#hw-context-hypersphere').show();
                                jQuery('#hw-context-menu').hide();
                        }else{
                                jQuery('#hw-context-hypersphere').hide();
                                jQuery('#hw-context-menu').show();
                        }

                        var position = jQuery(jQuery.hw_ip3_element).offset();
                        jQuery.hw_ip3_evt.pageX = position.left + jQuery(jQuery.hw_ip3_element).width()-15;
                        jQuery.hw_ip3_evt.pageY = position.top + jQuery(jQuery.hw_ip3_element).height()-15;

                        jQuery.hw_showHypersphereMenu(jQuery.hw_ip3_element, jQuery.hw_ip3_evt);
          
                    }, 500);

                });
                 jQuery('A:not(#hwmenu-context A' + jQuery.hw_ip4_excluded + ')').live('mouseout', function(){
                    clearTimeout(jQuery.hw_ip3_timeout);

                    clearTimeout(jQuery.hw_stophide);
                   jQuery.hw_stophide = setTimeout(function(){
                       jQuery(".contextMenu").hide();
                       jQuery.InfoPane3Reinit();
                       },500);
                   

                });
                

    },
    InfoPane3Click: function(evt,menuitem,posX,posY){

					
        	url = jQuery(jQuery.hw_ip3_element).attr('href');

          jQuery.hwMenuView.gOccTipurl = url;
          jQuery.hwMenuView.gOccTiptitle = "Link Preview: " + jQuery.hwSelectedText();

          jQuery.hw_ShowOccPopup_Params = {'adress': '-4', 'evt': null, 'eX': 0, 'eY': 0 };
          jQuery.showOccPopup(-4, "", "", "");
          jQuery(document).bind('click',jQuery.hideOccPopup);
          jQuery.hw_ip2_curtext="";
          jQuery.hw_ip3_element = null;
          //        jQuery.hwMenuView.gOccTipurl = url;
          //jQuery.hwMenuView.gOccTiptitle = "Definition for " + jQuery.hwSelectedText();
          //jQuery.showOccTooltip(evt, -4, "");
    },
    InfoPane3MouseOver: function(evt, eX, eY, action){
	
          url = jQuery(jQuery.hw_ip3_element).attr('href');
          jQuery.hwMenuView.gOccTipurl = url;
          jQuery.hwMenuView.gOccTiptitle = "Link Preview: " + jQuery.hwSelectedText();
          jQuery.showOccTooltip(evt, -4, "");
          jQuery.hw_ip2_curtext="";
          jQuery.hw_ip3_element = null;

    },
    InfoPane3Reinit: function(evt,menuitem,posX,posY){

	jQuery.hw_ip3_element = null;
        jQuery.hw_ip3_evt = null;
        jQuery.hw_ip3_timeout = null;
        jQuery.hw_ip2_curtext = "";
    }
  });

  jQuery.fn.extend({
    InfoPane3DrawMenu: function(menuid){

        var itemid = this.attr('id');
        jQuery('#hw-item-infopane-' + itemid).remove();

        if(jQuery.hw_ip3_element==null){
        	jQuery('#hw-item-' + menuid).hide();
                                    return false;

        }else{
                jQuery('#hw-item-' + menuid).show();

                 menuitem = jQuery.hwdata['commands'][menuid];
                 param = menuitem['label'];

                 param = jQuery.hwParamReplacer(param);

                jQuery('#hw-item-' + menuid + ">a").html(unescape(param));

                jQuery('#hw-item-' + menuid).bindInfoPane(3);
                    return true;
        }
        






   }

                
       


  });

})($);

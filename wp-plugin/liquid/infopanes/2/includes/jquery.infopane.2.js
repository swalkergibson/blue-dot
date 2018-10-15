(function($) {

  jQuery.extend({
    InfoPane1MOOffsetX: 530/2-50,
    InfoPane1MOOffsetY: 127+50,
    InfoPane2Init: function(){
     
        var include_list_optional = new Object();

        include_list_optional[jQuery.hw_basePath + 'settings/' + jQuery.hw_customerID + '/definition-terms.js'] = null;
        jQuery.hw_include(include_list_optional,jQuery.InfoPane2InitStep2);
   //console.log('testinfo' + jQuery.hw_basePath + 'settings/' + jQuery.hw_customerID + '/definition-terms.js');
    },
    InfoPane2InitStep2: function(){
       // console.log('kwdtest' + jQuery.hw_definitions);
          	jQuery.InfoPane2MarkKeywords(document.body);

                /*
                 *
                 jQuery('.' + jQuery.hw_definitions_highlight).live('mouseover', function(evt){
             
                     
                    clearTimeout(jQuery.hw_stophide);
                    
                    jQuery.hw_ip2_element = this;
                    jQuery.hw_ip2_evt = evt;
                    jQuery.hw_ip2_timeout = setTimeout(
                    function(){
                        if(jQuery.hwdata['infopanes']!=undefined){
                                for(infopaneid in jQuery.hwdata['infopanes']){
                                    if(infopaneid!=2){
                                        if(typeof(jQuery['InfoPane' + infopaneid + 'Reinit'])!="undefined"){
                                             jQuery['InfoPane' + infopaneid + 'Reinit']();
                                        }
                                    }
                                }
                            }

                       jQuery('.' + jQuery.hw_definitions_highlight).removeClass(jQuery.hw_definitions_highlight_mouseout);
                       jQuery('.' + jQuery.hw_definitions_highlight).removeClass(jQuery.hw_definitions_highlight_mouseover);
                       jQuery(jQuery.hw_ip2_element).addClass(jQuery.hw_definitions_highlight_mouseover);
                       jQuery.hw_ip2_curtext = jQuery(jQuery.hw_ip2_element).text();
                       jQuery.hw_Changed=jQuery(jQuery.hw_ip2_element).text();
                       var srcElement = jQuery(jQuery.hw_ip2_element);
                        if(jQuery.cookie("hw-popup-appears")=='wystamoi'){
                                jQuery('#hw-context-hypersphere').show();
                                jQuery('#hw-context-menu').hide();
                        }else{
                                jQuery('#hw-context-hypersphere').hide();
                                jQuery('#hw-context-menu').show();
                        }

                        var position = jQuery(jQuery.hw_ip2_element).offset();
                        jQuery.hw_ip2_evt.pageX = position.left + jQuery(jQuery.hw_ip2_element).width()-15;
                        jQuery.hw_ip2_evt.pageY = position.top + jQuery(jQuery.hw_ip2_element).height()-15;

                        jQuery.hw_showHypersphereMenu(jQuery.hw_ip2_element, jQuery.hw_ip2_evt);
          
                    }, 0);

                });
                 jQuery('.hw_definitions_highlight_mouseout').live('mouseout', function(){
                    clearTimeout(jQuery.hw_ip2_timeout);
                   jQuery('.' + jQuery.hw_definitions_highlight).removeClass(jQuery.hw_definitions_highlight_mouseover);
                   jQuery(this).addClass(jQuery.hw_definitions_highlight_mouseout);

                   clearTimeout(jQuery.hw_stophide);
                   jQuery.hw_stophide = setTimeout(function(){
                        jQuery(".contextMenu").hide();
                        jQuery.InfoPane2Reinit();
                    },1000);
                });
                jQuery('.hw_definitions_highlight_mouseover').live('mouseout', function(){
                    clearTimeout(jQuery.hw_ip2_timeout);
                   //jQuery(this).removeClass(jQuery.hw_definitions_highlight_mouseover);
                  // jQuery(this).addClass(jQuery.hw_definitions_highlight_mouseout);

                   clearTimeout(jQuery.hw_stophide);
                   jQuery.hw_stophide = setTimeout(function(){
                       jQuery(".contextMenu").hide();
                       jQuery.InfoPane2Reinit();
                   },1000);
                });
                */

    },
    InfoPane2Click: function(evt,menuitem,posX,posY){

        url = jQuery.hw_basePath + "/infopanes/2/definition-terms.php?q=" + escape(jQuery.hwSelectedText()) + "&cid=" + escape(jQuery.hw_customerID) + '&basepath=' + escape(jQuery.hw_basePath);
          jQuery.hwMenuView.gOccTipurl = url;
          jQuery.hwMenuView.gOccTiptitle = "Definition";

          jQuery.hw_ShowOccPopup_Params = {'adress': '-5', 'evt': null, 'eX': 0, 'eY': 0 };
          jQuery.showOccPopup(-5, "", "", "");
          jQuery(document).bind('click',jQuery.hideOccPopup);
          jQuery.hw_ip2_curtext="";
          //        jQuery.hwMenuView.gOccTipurl = url;
          //jQuery.hwMenuView.gOccTiptitle = "Definition for " + jQuery.hwSelectedText();
          //jQuery.showOccTooltip(evt, -4, "");

    },
    InfoPane2MouseOver: function(evt, eX, eY, action){

        url = jQuery.hw_basePath + "/infopanes/2/definition-terms.php?q=" + escape(jQuery.hwSelectedText()) + "&cid=" + escape(jQuery.hw_customerID) + '&basepath=' + escape(jQuery.hw_basePath);
          jQuery.hwMenuView.gOccTipurl = url;
          jQuery.hwMenuView.gOccTiptitle = "Definition";
          jQuery.showOccTooltip(evt, -5, "");
          jQuery.hw_ip2_curtext="";

    },
    InfoPane2MarkKeywords: function(el){
        var pageArr = new Array();

                if(typeof(jQuery.hw_definitions)!="undefined"){
                    if(!Array.indexOf){
                      Array.prototype.indexOf = function(obj){
                       for(var i=0; i<this.length; i++){
                        if(this[i]==obj){
                         return i;
                        }
                       }
                       return -1;
                      }
                    }
                    var lastkwd = "";
                    var blastkwd = "";

                    jQuery.each(jQuery(el).text().split(/[\W]+/),function(){
                            var kwd = jQuery.trim(this).toUpperCase();
                            var kwd2 = lastkwd + " " + kwd;
                            var kwd3 = blastkwd + " " + lastkwd + " " + kwd;

                            if(kwd.length > 2 && jQuery.hw_definitions.indexOf(kwd) != -1 && pageArr.indexOf(kwd) == -1){
                                pageArr.push(kwd);

                                 //  console.log(kwd);
                                jQuery(document.body).highlight(kwd, jQuery.hw_definitions_highlight + " " + jQuery.hw_definitions_highlight_mouseout);
                            }
                            if(kwd2.length > 2 && jQuery.hw_definitions.indexOf(kwd2) != -1 && pageArr.indexOf(kwd2) == -1){
                                pageArr.push(kwd);

                                 //  console.log(kwd);
                                jQuery(document.body).highlight(kwd2, jQuery.hw_definitions_highlight + " " + jQuery.hw_definitions_highlight_mouseout);
                            }
                            if(kwd3.length > 2 && jQuery.hw_definitions.indexOf(kwd3) != -1 && pageArr.indexOf(kwd3) == -1){
                                pageArr.push(kwd);

                                 //  console.log(kwd);
                                jQuery(document.body).highlight(kwd2, jQuery.hw_definitions_highlight + " " + jQuery.hw_definitions_highlight_mouseout);
                            }

                            lastkwd = kwd;
                            blastkwd = lastkwd;

                    });
                }
    },
    InfoPane2Reinit: function(evt,menuitem,posX,posY){

        jQuery.hw_ip2_curtext = "";
        jQuery('.' + jQuery.hw_definitions_highlight).removeClass(jQuery.hw_definitions_highlight_mouseover);
        jQuery('.' + jQuery.hw_definitions_highlight).addClass(jQuery.hw_definitions_highlight_mouseout);
    }
  });

  jQuery.fn.extend({
    InfoPane2DrawMenu: function(menuid){

        var itemid = this.attr('id');
        jQuery('#hw-item-infopane-' + itemid).remove();

       

            if(typeof(jQuery.hw_definitions)!="undefined"){

                if(jQuery.hw_definitions.indexOf(jQuery.hwSelectedText().toUpperCase())!=-1){
               
                    jQuery('#hw-item-' + menuid).show();
                    
                     menuitem = jQuery.hwdata['commands'][menuid];
                     param = menuitem['label'];

                     param = jQuery.hwParamReplacer(param);

                    jQuery('#hw-item-' + menuid + ">a").html(unescape(param));
   
                    jQuery('#hw-item-' + menuid).bindInfoPane(2);
                    return true;
                }else{

                jQuery('#hw-item-' + menuid).hide();
                    return false;
                }
            }else{

                jQuery('#hw-item-' + menuid).hide();
                    return false;
            }
        


        }

                
       


  });

})($);

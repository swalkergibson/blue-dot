(function($) {

  jQuery.extend({
    InfoPane1MOOffsetX: 530/2-50,
    InfoPane1MOOffsetY: 127+50,
    InfoPane1Init: function(){

            var include_list_optional = new Object();
            include_list_optional[jQuery.hw_basePath + 'infopanes/' + infopaneid + '/includes/menu.js'] = null;
            include_list_optional[jQuery.hw_basePath + 'infopanes/' + infopaneid + '/includes/jquery.simpletip-1.3.1.pack.js'] = null;
            include_list_optional[jQuery.hw_basePath + 'infopanes/' + infopaneid + '/includes/urlEncode.js'] = null;
                    
            jQuery.hw_include(include_list_optional,jQuery.InfoPane1InitStep2);
    },
    InfoPane1InitStep2: function(){
            jQuery('#hwinfopane1div').remove();
          el = jQuery(document.createElement("div")).appendTo(document.body);
          el.attr('id','hwinfopane1div');

          var tooltipCss = {
            'position': 'absolute',
            'border': '5px single black',
            'background': 'fixed',
            'z-index': '2147483646',
            'display': 'none',
            'left': '45px',
            'top': '35px'
          };

//IE issue with border
            if(jQuery.client.browser=="Explorer"){
                tooltipCss = {
                    'position': 'absolute',
                    'background': 'fixed',
                    'z-index': '2147483646',
                    'display': 'none',
                    'left': '45px',
                    'top': '35px'
                  }
            };

          el.css(tooltipCss);

          el.load(jQuery.hw_basePath + "infopanes/1/index.php?keyword=", jQuery.InfoPane1InitDiv
            );




    },
    InfoPane1InitDiv: function(){
                jQuery('#year_btn').bind('click',
                    function(event){
                        //document.getElementById("years_menu").style.display = "block";
                        jQuery('#years_menu').css({display: 'block', width: '50px'});
                        event.stopPropagation();
                        return true;
                    }
                );
		jQuery.fn.displayDots = function() {
			if(jQuery(this).text().length < 3){
				jQuery(this).append('.');
			}else{
				jQuery(this).text('');
			};
			var id = jQuery(this).attr("id");
			setTimeout(function(){
				jQuery("#"+id).displayDots();
								}, 500);
		};
		
		jQuery("#loading").show();
		jQuery('#dots').displayDots();

                jQuery("#pie_chart").bind('mouseover', function(){
			jQuery("#top_arrow img").show();
			jQuery("#bottom_arrow img").show();
                        jQuery("#blue").show();
			jQuery("#red").show();
		}).bind('mouseout',function(){

                         jQuery("#top_arrow img").hide();
			jQuery("#bottom_arrow img").hide();
                        jQuery("#blue").hide();
			jQuery("#red").hide();

		});

		jQuery(".bg_lines").bind('mouseover', function(){
			jQuery(this).addClass("lines_m_over");
			jQuery('#middle_panel_top').html(jQuery(this).html());
		}).bind('mouseout',function(){
			jQuery(this).removeClass("lines_m_over");
			jQuery('#middle_panel_top').html('');
		});

		jQuery(".bg_lines").simpletip({
			content: 'Show articles from this date',
			baseClass: 'tooltip',
			fixed: false,
			showEffect: 'fade',
			hideEffect: 'fade'
		});

		jQuery("#loading").bind( "ajaxStart", function(){
			jQuery(this).show();
			jQuery('#dots').displayDots();
		}).bind("ajaxComplete", function(){
			jQuery(this).hide();
		});

                jQuery("#top_arrow img").hide();
                jQuery("#bottom_arrow img").hide();
                jQuery("#blue").hide();
                jQuery("#red").hide();


                jQuery('#years_menu li').bind('click',
                            function(event) {
                                    var value = jQuery(this).html();
                                    var oldValue = jQuery('#year_btn').text();
                                    jQuery('#year_btn').text(value);
                                    jQuery('#years_menu').css("display", "none");

                                    if(value != oldValue){
                                            jQuery.InfoPane1UpdateData(jQuery.hw_ip1_name,jQuery.hw_ip1_keyword, value);
                                    };

                                    event.stopPropagation();
                                    return true;
                            }
                );

            
    },
    InfoPane1Click: function(evt,menuitem,posX,posY){
      


        //alert(menuitem);
        name = jQuery('#' + menuitem).attr('name');
        keyword = jQuery('#' + menuitem).attr('symbol');
        //alert(keyword);

        //replace by update of data
        //el.load(jQuery.hw_basePath + "infopanes/1/index.php?keyword=" + escape(keyword),
        //       showInfoPane(posX,posY));
        jQuery.InfoPane1UpdateData(name,keyword, '1');

       jQuery.hwMenuView.gOccTipElement = jQuery('#hwinfopane1div');
       jQuery.hwMenuView.gOccTiptitle = "Info Pane";
          jQuery.hw_ShowOccPopup_Params = {'adress': '-6', 'evt': null, 'eX': 0, 'eY': 0 };
          jQuery.showOccPopup(-6, "", "", "");
          jQuery(document).bind('click',jQuery.hideOccPopup);

       


       // showInfoPane(posX,posY);

      //alert(paramstr);
    },
    InfoPane1MouseOver: function(evt, eX, eY, action){
        infopaneid = 1;
       


            menuid = jQuery.hw_getMenuId(action);
            menuitem = jQuery.hwdata['commands'][menuid];
            infopanemenu = jQuery.hw_getInfoPaneMenu(action);

                        if(infopanemenu ||  menuitem['command_function']=='infopane'){

                            //menuid = infopanemenu[0];
                            //callparams = infopanemenu[1];
                            //menuitem = jQuery.hwdata['commands'][menuid];
                            infopaneid = menuitem['command_params']['infopane'];


                            var eX = x;
                            var eY = y;

                                name = jQuery('#' + action).attr('name');
                                keyword = jQuery('#' + action).attr('symbol');
                                jQuery.InfoPane1UpdateData(name,keyword, '1');

                                jQuery.hwMenuView.gOccTipElement = jQuery('#hwinfopane1div');
                                jQuery.hwMenuView.gOccTiptitle = "Info Pane";
                                 jQuery.showOccTooltip(evt, -6, "");

       
                        }

    },
    InfoPane1UpdateData: function(name, symbol, period){
            jQuery("#loading").show();
            jQuery('#dots').displayDots();
            jQuery.hw_ip1_name = name;
            jQuery.hw_ip1_keyword = symbol;

         jQuery.getJSON(jQuery.hw_basePath + 'infopanes/1/ajax.inc.php?action=update_graphs&keyword=' + symbol + '&name=' + escape(name) + '&period=' + period + ' Year', function(data) {

          jQuery('#hw_imgTop').attr('src',data['imgTop']);
          jQuery('#hw_imgBottom').attr('src',data['imgBottom']);
          jQuery('#hw_imgPie').attr('src',data['imgPie']);
          jQuery('#hw_leftChartLink').attr('src',data['leftChartLink']);
          jQuery('#hw_rightChartLink').attr('src',data['rightChartLink']);

          jQuery('#hw_PieUpPerc').html(data['pieupperc'] + "%");
          jQuery('#hw_PieDownPerc').html(data['piedownperc']  + "%");
          jQuery('#hw_basic_data').html(data['basicdata']);
          jQuery('#hw_RateStatus').attr('class',data['ratestatus']);
          jQuery('#hw_RateValue').html(data['ratevalue']);
          jQuery('#hw_RatePerc').html(data['rateperc']);
          jQuery('#hw_HistYears').html(data['histyears'] + " Years");
          jQuery('#hw_UpdateDate').html(data['updatedate']);
          //jQuery('#hw_keyword').html(data['keyword']);
          jQuery('#hw_keyword').html(data['name']);

          jQuery('#hw_maxValue').html(data['maxValue']);
          jQuery('#hw_maxValue_2').html(data['maxValue']/ 3 * 2);
          jQuery('#hw_maxValue_3').html(data['maxValue']/ 3);
          jQuery('#hw_maxValue_4').html(0);

           jQuery("#loading").hide();



        });
    },
    InfoPane1Hide: function(){
           jQuery('#hwinfopane1div').hide();
    }
  });


  jQuery.fn.extend({
    InfoPane1DrawMenu: function(menuid){

        var itemid = this.attr('id');
        jQuery('#hw-item-infopane-' + itemid).remove();

        if(jQuery.hwdata.commands[menuid].command_params['graphthis']=="true"){
   
            if(typeof(jQuery.hw_stocklist)!="undefined)"){
                
                if(typeof(jQuery.hw_stocklist[jQuery.hwSelectedText()])!="undefined"){
                   
                    jQuery('#hw-item-' + menuid).show();
                    jQuery('#hw-item-' + menuid).attr('symbol', jQuery.hw_stocklist[jQuery.hwSelectedText()]);
                    jQuery('#hw-item-' + menuid).attr('name', jQuery.hwSelectedText());

                     menuitem = jQuery.hwdata['commands'][menuid];
                     param = menuitem['label'];

                     param = jQuery.hwParamReplacer(param);

                    jQuery('#hw-item-' + menuid + ">a").html(unescape(param));
                    //alert(jQuery('#hw-item-' + menuid + ">a").html());

                    //alert(jQuery.hw_stocklist[jQuery.hwSelectedText()]);

                    jQuery('#hw-item-' + menuid).bindInfoPane(1);
                    return true;
                }else{

                    jQuery('#hw-item-' + menuid).hide();
                    return false;
                }
            }else{

                jQuery('#hw-item-' + menuid).hide();
                    return false;
            }
        }else if(jQuery.hwdata.commands[menuid].command_params['type']=="currency"){

            var menuadd = "<ul id=\"hw-item-infopane-" + itemid + "\">";
            menuadd += "<li><a href=\"#" + itemid + "-not-supported\">Not supported</a></li>";
            menuadd += "</ul>";
            this.append(menuadd);
            
        }else if(jQuery.hwdata.commands[menuid].command_params['type']=="commodity"){

            var menuadd = "<ul id=\"hw-item-infopane-" + itemid + "\">";
            menuadd += "<li><a href=\"#" + itemid + "-not-supported\">Not supported</a></li>";
            menuadd += "</ul>";
            this.append(menuadd);

        }else if(jQuery.hwdata.commands[menuid].command_params['type']=="share"){

            var menuadd = "<ul id=\"hw-item-infopane-" + itemid + "\">";
            menuadd += "<li><a href=\"#" + itemid + "-infopane-waiting\">Loading...</a></li>";
            menuadd += "</ul>";

            this.append(menuadd);



            jQuery.get(jQuery.hw_basePath + 'yahoolookup.php?s=' + escape(jQuery.hwSelectedText()), function(data){

                                            var re2 = new RegExp('a href=\"\/q([^>]*)\"\\>View Quotes for All Above Symbols');
                                       var yfsLink = data.match(re2);

                                       if(yfsLink != null) {
                                          yfsLink = yfsLink[1];
                                       }else {
                                          menuadd = "<li><a href=\"#hw-item-share-price-not-found\">Company not found</a></li>";
                                          jQuery('#hw-item-infopane-' + itemid).html(menuadd);
                                         //rebind menu to consider new items
                                           jQuery.hw_bindMouseOutMenu();
                                        }


                                                                            var doSomething = function(itemid) {
                                                                                return function(data, textStatus) {
                                                                                    //alert(itemid);
                                                                     menuadd = "";
                                                                     var re3 = new RegExp('\"([^\"]*)\",\"([^\"]*)\",([0-9]+)(\.)([0-9]+)', 'g');
                                                                     var hwQuotes = data.match(re3);

                                                                      if(hwQuotes != null) {

                                                                         for(var j = 0; j < hwQuotes.length; j++) {
                                                                            var elemArr = eval("new Array(" + hwQuotes[j] + ")");
                                                                            menuadd += "<li id=\"" + itemid + "-infopane-" + j + "\" symbol=\"" + elemArr[0] + "\"><a href=\"#" + itemid + "-infopane-" + j + "\">" + "" + elemArr[1] + " (" + elemArr[0] + "): " + elemArr[2] + "</a></li>";
                                                                         }

                                                                         jQuery('#hw-item-infopane-' + itemid).html(menuadd);
                                                                         //rebind menu to consider new items
                                                                         jQuery.hw_bindMouseOutMenu();

                                                                         for(var j = 0; j < hwQuotes.length; j++) {
                                                                             var elemArr = eval("new Array(" + hwQuotes[j] + ")");
                                                                            jQuery('#' + itemid + "-infopane-" + j).bindInfoPane(1);
                                                                            jQuery('#' + itemid + "-infopane-" + j).attr('name', elemArr[1]);
                                                                         }
                                                                       }
                                                                       else {
                                                                          menuadd += "<li><a href=\"#" + itemid + "-infopane-not-found\">Company not found</a></li>";
                                                                          jQuery('#hw-item-infopane-' + itemid).html(menuadd);
                                                                       }

                                                                              jQuery.hw_setMenuWidth(jQuery('#hw-item-infopane-' + itemid));
                                                                                };
                                                                            };


                                       jQuery.get(jQuery.hw_basePath + 'yahooquotes.php' + escape(yfsLink), doSomething(itemid));



            });


        }

                
       
    }

  });

})($);

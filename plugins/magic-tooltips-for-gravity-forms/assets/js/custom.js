
(function($) {
    var mtfgtrim = function(s) {
        //return this.replace(/[(^\s+)(\s+$)]/g,"");//會把字符串中間的空白符也去掉
        //return this.replace(/^\s+|\s+$/g,""); //
        return s.replace(/^\s+/g,"").replace(/\s+$/g,"");
    }

    var mtfgfGetValueFromRegExp = function(regex, html){
        var m = null;
        var result = '';
        if ((m = regex.exec(html)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === regex.lastIndex) {
                regex.lastIndex++;
            }
            // The result can be accessed through the `m`-variable.
            m.forEach(function(match, groupIndex) {
                //console.log(`Found match, group ${groupIndex}: ${match}`);
                if(groupIndex == 1){
                    result = match;
                }
            });
        }
        return result;
    }

    var hideEvents = {
        hide: function(event, api) {
            // console.log('hidetooltip', event.tagName, event.originalEvent);
            // if(event.originalEvent && event.originalEvent.originalEvent && event.originalEvent.originalEvent.originalTarget.tagName == 'IFRAME') {
            //  event.preventDefault();
            // }

            if(event.type == 'mouseout' && event.originalEvent && event.originalEvent.target && event.originalEvent.target.tagName == 'IFRAME') {
                event.preventDefault();
            }
            else if(event.type == 'blur' && event.originalEvent && event.originalEvent.target && event.originalEvent.target.activeElement && event.originalEvent.target.activeElement.tagName == 'IFRAME') {
                event.preventDefault();
            }
        }
    };

    function getTooltipContentRaw($that, mtfgf_settings, i) {
        var selector = mtfgf_settings.description_as_tooltip ? '.gfield_description' : '.mm_tooltip_text';
        var html = $that.parents('.mm-tooltip-li').find(selector).html();
        console.log('getTooltipContentRaw001', html);
        if(mtfgf_settings.description_as_tooltip && (!html)) {
            selector = '.mm_tooltip_text';
            html = $that.parents('.mm-tooltip-li').find(selector).html();
            console.log('getTooltipContentRaw002', html);
        }
        //if(html && ($that.next().hasClass('ginput_container_radio') || $that.next().hasClass('ginput_container_checkbox'))) {
        if((i>=0) && html) {
            var split_str_arr = ['<hr>', '<hr />', '<hr/>'];
            var split_str = false;
            for(var jj =0; jj < split_str_arr.length; jj++ ) {
                if(html.indexOf(split_str_arr[jj])>=0) {
                    split_str = split_str_arr[jj];
                    break;
                }
            }

            if(split_str) {
                var hs = html.split(split_str);
                if((i>=0) && (hs.length > i)) {
                    html = hs[i];
                }
                else {
                    html = false;
                }
            }
            else if(i > 0) {
                return false;
            }

        }
        //}
        return html;

        //ginput_container_radio
    }

    function getTooltipContent($that, mtfgf_settings) {
        var m = getTooltipContentRaw($that, mtfgf_settings, 0);
        console.log("getTooltipContentResult", m, $that);
        return m;
    }

    function fixeIsHover(isHover, tooltipHTML){
        if(mtfgf_settings.enable_lightbox && mtfgf_settings.enable_lightbox_on_click_icon) {
            var foundImg = /<img/i.test(tooltipHTML);
            if(tooltipHTML && foundImg) {
                return false;
            }
        }

        return isHover;
    }

    var mm_named_styles_added = [];

    function mtfgf_get_tooltip_code($that, tooltip_code){
        var $ligfield = $that.closest('li.gfield');
        var $enalbedNamedStyle = $ligfield.hasClass('mm-enable-named-style');
        if($enalbedNamedStyle) {
            var style_id = $ligfield.attr('mm-named-style');
            console.log('window.mtfgf_named_styles', window.mtfgf_named_styles);
            if(window.mtfgf_named_styles && window.mtfgf_named_styles[style_id]) {
                var mtfgf_js_code = {};
                var mtfgf_css_code = '';
                console.log('window.mtfgf_named_styles[style_id]', window.mtfgf_named_styles[style_id]);
                var mtfgf = window.mtfgf_named_styles[style_id].style;
                if(mmMobileDetect.isMobile.phone) {
                    mtfgf_js_code = mtfgf.js_code_phone ? mtfgf.js_code_phone : mtfgf.js_code;
                    mtfgf_css_code = mtfgf.css_code_phone ? mtfgf.css_code_phone : mtfgf.css_code;
                }
                else if(mmMobileDetect.isMobile.tablet) {
                    mtfgf_js_code = mtfgf.js_code_pad ? mtfgf.js_code_pad : mtfgf.js_code;
                    mtfgf_css_code = mtfgf.css_code_pad ? mtfgf.css_code_pad : mtfgf.css_code;
                }
                else {
                    mtfgf_js_code = mtfgf.js_code;
                    mtfgf_css_code = mtfgf.css_code;
                }


                eval('var named_tooltip_code = ' + mtfgf_js_code);

                named_tooltip_code.style.classes = " mm-tooltip-container-" + style_id;
                mtfgf_css_code = mtfgf_css_code.replace(/\.mm\-tooltip\-container/g, '.mm-tooltip-container-'+style_id);

                if(mm_named_styles_added.indexOf(style_id) == -1) {
                    var $container = $('<style type="text/css"></style>').appendTo("body");
                    $container.text(mtfgf_css_code);

                    mm_named_styles_added[mm_named_styles_added.length] = style_id;
                }

                console.log('named_tooltip_code', named_tooltip_code);

                return named_tooltip_code;
            }
        }
        return tooltip_code;
    }

    function initHoverTooltip($that, isModal, tooltip_code_default, tooltipHTML, hideEvents) {

        tooltip_code = mtfgf_get_tooltip_code($that, tooltip_code_default);

        if(mtfgf_settings && mtfgf_settings.mouse_over) {
            var isHover = true;

            isHover = fixeIsHover(isHover, tooltipHTML);
            var forceShowTooltip = $that.closest('li.gfield').hasClass('mm-force-show-tooltip');
            if(isModal){
                $that.click(function(e){
                    e.preventDefault();
                    var readMoreHTML = tooltipHTML.split('<!--more-->');

                    if(readMoreHTML.length > 1) {
                        var ReadMoreButtonText = $that.closest('li.gfield').attr('mm-modal-more-text') || 'Read More';


                        readMoreHTML[0] += '<div class="mtfgf_modal_read_more_row"><a class="mtfgf_modal_read_more">'+ReadMoreButtonText+'</a></div>';
                        readMoreHTML[0] += '<div class="mtfgf_modal_read_more_content">'+readMoreHTML[1]+'</div>';
                    }

                    //.appendTo('body');
                    //$('#mtfgf_modal').
                    $('<div class="mtfgf_modal">'+readMoreHTML[0]+'</div>').modalmm();


                    return false;
                });

                var showTooltipHint = $that.closest('li.gfield').hasClass('mm-modal-enable-hint');


                if(showTooltipHint){
                    var ReadMoreButtonText1 = $that.closest('li.gfield').attr('mm-modal-hint-text') || 'Click to show...';
                    $that.qtip($.extend(tooltip_code, {
                        content: {
                            text:  ReadMoreButtonText1// Use the "div" element next to this for the content
                        },
                        show: forceShowTooltip || 'hover',
                        hide: { //forceShowTooltip ? false :
                            fixed: true,
                            delay: 300
                        },
                        events: hideEvents
                    }));
                }
            }
            else if(isHover) { //hover to show tooltip
                $that.qtip($.extend(tooltip_code, {
                    content: {
                        text:  tooltipHTML// Use the "div" element next to this for the content
                    },
                    show: forceShowTooltip || 'hover',
                    hide: { //forceShowTooltip ?  false : {
                        fixed: true,
                        delay: 300
                    },
                    events: hideEvents
                }));
            }
            else { //click to show lightbox
                if($that.attr('sb_items_id')){
                    return;
                }
                var $images = $('<div>'+tooltipHTML+'</div>').find('img');

                // console.log('sbItems tooltipHTML', tooltipHTML);
                console.log('sbItems images', $images);

                mtfgf_settings['sb_items_seed'] = mtfgf_settings['sb_items_seed'] ? mtfgf_settings['sb_items_seed'] + 1 : 1;

                var sbItems = [];
                $images.each(function(index){
                    var src = $(this).attr('src');
                    if(src.indexOf('/plugins/') ==-1 ) {
                        sbItems.push({
                            href: $(this).attr('src') //, title:'My Caption'
                        });
                    }
                });
                mtfgf_settings['sb_items_'+mtfgf_settings['sb_items_seed']] = sbItems;
                $that.addClass('mm-swipebox');
                $that.attr('sb_items_id', mtfgf_settings['sb_items_seed']);
                $that.click(function(e){
                    e.preventDefault();
                    var sbItems = mtfgf_settings['sb_items_'+$(this).attr('sb_items_id')];
                    console.log('sbItems', sbItems);
                    jQuery.swipebox(sbItems);
                    return false;
                });

                if(mtfgf_settings.enable_lightbox_hover_tooltip){
                    $that.qtip($.extend(tooltip_code, {
                        content: {
                            text:  mtfgf_settings.lightbox_hover_tooltip// Use the "div" element next to this for the content
                        },
                        show: forceShowTooltip || 'hover',
                        hide: { //forceShowTooltip ?  false : {
                            fixed: true,
                            delay: 300
                        },
                        events: hideEvents
                    }));
                }
            }
        }
    }

    function quoteattr(s, preserveCR) {
        preserveCR = preserveCR ? '&#13;' : '\n';
        return ('' + s) /* Forces the conversion to string. */
            .replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
            .replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            /*
            You may add other replacements here for HTML only
            (but it's not necessary).
            Or for XML, only if the named entities are defined in its DTD.
            */
            .replace(/\r\n/g, preserveCR) /* Must be before the next replacement. */
            .replace(/[\r\n]/g, preserveCR);
            ;
    }

    function reinit(tooltip_code) {

        // console.log('reinit 001');
        $('label.gfield_label, .mm-tooltip-label').each(function(index) {
            $that = $(this);
            var gform_page = $that.closest('.gform_page');
            if((gform_page.length > 0) && (gform_page.css('display') == 'none')) {
                return;
            }
            if($that.hasClass('mm-tooltip-inited')) {
                return;
            }
            $that.addClass('mm-tooltip-inited');
            // console.log('mtfgf_settings', mtfgf_settings);
            $desc = mtfgf_settings.description_as_tooltip ? $that.closest('li.gfield').find('.gfield_description') : $that.closest('li.gfield').find('.mm_tooltip_text');

            if(mtfgf_settings.description_as_tooltip && $desc.length == 0 ) {
                $desc = $that.parents('.gfield').find('.mm_tooltip_text');
            }

            // console.log('desc', $desc);

            $forceNoLabel = $that.closest('li.gfield').hasClass('mm-enable-no-label');
            $forceModal = $that.closest('li.gfield').hasClass('mm-enable-modal');
            var hasSubLabel = $that.next().hasClass('ginput_complex');

            console.log('forceNoLabel', $forceNoLabel);

            var no_label_show_help_icon_item = $that.closest('li.gfield').hasClass('mm-enable-no-label-show-help-icon');
            var no_label_show_help_icon = (mtfgf_settings.no_label_show_help_icon || no_label_show_help_icon_item);

            //No label mode begin
            if(mtfgf_settings && (mtfgf_settings.enable_no_label_mode || $forceNoLabel)) {

                $that.closest('li.gfield').addClass('mm-tooltip-li-no-label');

                var $forceNoLabelPlaceholder = $that.closest('li.gfield').hasClass('mm-enable-no-label-placeholder');

                if(mtfgf_settings && (mtfgf_settings.enable_no_label_mode_placeholder || $forceNoLabelPlaceholder)) {

                    var placeholder = '';

                    var $forceNoLabelRequired = $that.closest('li.gfield').hasClass('mm-enable-no-label-required');

                    if(mtfgf_settings && (mtfgf_settings.no_label_show_required || $forceNoLabelRequired )) {
                        placeholder = $that.text();
                    }
                    else {
                        var $thatClone = $that.clone();
                        $thatClone.find('.gfield_required').remove()
                        placeholder = $thatClone.text();
                        // console.log('mtfgf_settings placeholder', placeholder);
                    }

                    $that.closest('li.gfield').find('input, textarea').each(function(){
                        if(['radio', 'checkbox', 'hidden'].indexOf($(this).attr('type')) >= 0) {
                            return;
                        }
                        if($(this).attr('placeholder')){
                            placeholder = $(this).attr('placeholder');
                        }
                        else if(hasSubLabel) {
                            placeholder = $(this).parent().find('label').text();
                        }

                        // if(mtfgf_settings.add_underline) {
                        //  $(this).addClass('mm-tooltip-placeholder-underline');

                        // }

                        if(mtfgf_settings.add_icon && ($desc.length > 0) && (!no_label_show_help_icon)) {
                            $(this).css('font-family', "Arial, FontAwesome").attr('placeholder', (placeholder+" "));
                        }
                        else {
                            $(this).attr('placeholder', placeholder);
                        }
                    });

                    $that.closest('li.gfield').find('select').each(function(){
                        var $that = $(this);
                        var firstOption = $that.find('option:first-child');
                        var selectedOption = $that.find('option:selected');
                        var hasPlaceholder = (firstOption.length == 1) && (!firstOption.attr('value'));

                        if(hasPlaceholder && firstOption.text()){
                            placeholder = firstOption.text();
                        }
                        else if(hasSubLabel) {
                            placeholder = $that.parent().find('label').text();
                        }

                        if(!hasPlaceholder) {
                            firstOption =  $('<option>');
                            // console.log('sssssss', selectedOption.attr('selected'), selectedOption.html());
                            if((selectedOption.length == 0) || (selectedOption.index()==0) ) {
                                firstOption.attr('selected', 'selected');
                            }
                            $that.prepend(firstOption);
                        }

                        if(mtfgf_settings.add_icon && ($desc.length > 0) && (!no_label_show_help_icon)) {
                            firstOption.html(placeholder+" ").parent().css('font-family', "Arial, FontAwesome");
                        }
                        else {
                            firstOption.html(placeholder);
                        }
                    });
                }
            }
            //No label mode end


            if($desc.length > 0){
                var $ligfield = $that.closest('li.gfield');
                var $forceNoLabelAgree = $ligfield.hasClass('mm-enable-no-label-agree');

                var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
                var ligfieldiconClasses = ligfieldicon.split(' ');
                var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];

                //No label mode begin
                if(mtfgf_settings && (mtfgf_settings.enable_no_label_mode || $forceNoLabel)) {


                    if(mtfgf_settings.no_label_checkbox_tooltip || $forceNoLabelAgree) {


                        var $sig = $ligfield.find('.gfield_checkbox li')
                        // setTimeout(function(){
                            if($sig.length == 1) {
                                // if($that.closest('li.gfield').hasClass('gfield_price')) {

                                // }
                                // else {
                                    var $sig0 = $($sig.get(0)).find('label')
                                    if(mtfgf_settings.add_icon) {
                                        if(mtfgf_settings.showIconLeft) {
                                            $sig0.html('<mmi><i class="'+ligfieldicon+'"></i></mmi> '+$sig0.html());
                                        }
                                        else {
                                            $sig0.html($sig0.html()+' <mmi><i class="'+ligfieldicon+'"></i></mmi>');
                                        }
                                    }
                                    var targetSig = mtfgf_settings.add_icon_hover_icon && (!$that.closest('li.gfield').hasClass('gfield_price')) ? $sig0.find('mmi') : $sig0;
                                    // console.log("getTooltipContentResult", "single checkbox", $sig0.find('.fa-question-circle'), $desc.html());

                                    initHoverTooltip(targetSig, mtfgf_settings.add_icon && $forceModal, tooltip_code, $desc.html(), hideEvents, mtfgf_settings);
                                // }
                            }
                        // }, 100);
                    }

                    if(no_label_show_help_icon) {
                        // $that.closest(".gfield").addClass('mm-tooltip-li-no-label-help-icon');




                    }
                }
                //No label mode end
                if(no_label_show_help_icon_item) {
                    var $sig0 = $that.closest(".gfield").find('.ginput_container input, .ginput_container textarea')
                    if(mtfgf_settings.add_icon) {
                        if(mtfgf_settings.showIconLeft) {
                            $sig0.before('<mmi><i class="'+ligfieldicon+'"></i></mmi> ');
                        }
                        else {
                            $sig0.after('  <mmi><i class="'+ligfieldicon+'"></i></mmi>');
                        }

                        var targetSig = $sig0.parent().find('mmi');

                        initHoverTooltip(targetSig, mtfgf_settings.add_icon && $forceModal, tooltip_code, $desc.html(), hideEvents, mtfgf_settings);

                    }
                }
                else {
                    var $ligfield = $that.closest('li.gfield');
                    if(mtfgf_settings && (mtfgf_settings.mouse_over ||  mtfgf_settings.mouse_over_input ||  mtfgf_settings.focus_input)) {
                        $ligfield.addClass('mm-tooltip-li');


                        if(mtfgf_settings.description_as_tooltip) {
                            $ligfield.addClass('mm-tooltip-li-hide-description');
                        }
                    }

                    var tipC = getTooltipContentRaw($that, mtfgf_settings, 0);
                    var hasTooltipContent = !((!tipC) || (tipC.length==0) || (mtfgtrim($('<div>'+tipC+'</div>').text()).length==0));
                    console.log('tipC', tipC, hasTooltipContent);
                    if(!hasTooltipContent) {
                        return;
                    }

                    if(mtfgf_settings && mtfgf_settings.mouse_over) {
                        $that.addClass('mm-tooltip');
                        }
                    if(mtfgf_settings && mtfgf_settings.add_underline) {
                        $that.addClass('mm-tooltip-title-underline');
                    }


                    if(mtfgf_settings && mtfgf_settings.add_icon) {
                        var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
                        var ligfieldiconClasses = ligfieldicon.split(' ');
                        var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
                        if(mtfgf_settings.showIconLeft) {
                            $that.html('<mmi><i class="'+ligfieldicon+'"></i></mmi> '+$that.html());
                        }
                        else {
                            $that.html($that.html()+' <mmi><i class="'+ligfieldicon+'"></i></mmi>');
                        }
                    }
                }
            }

        });

        if(mtfgf_settings && mtfgf_settings.mouse_over) {
            // var $ligfield = $that.closest('li.gfield');
            // var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
            // var ligfieldiconClasses = ligfieldicon.split(' ');
            // var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
            // var hsel = mtfgf_settings.add_icon_hover_icon ? '.mm-tooltip .'+ligfieldiconClass : '.mm-tooltip';
            $('.mm-tooltip').each(function() { // Notice the .each() loop, discussed below
                    //console.log('.mm-tooltip', $(this));
                var $that = $(this);
                var $ligfield = $that.closest('li.gfield');
                var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
                var ligfieldiconClasses = ligfieldicon.split(' ');
                var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
                var $hsel = mtfgf_settings.add_icon_hover_icon ? $that.find('mmi') : $that;

                $forceModal = $ligfield.hasClass('mm-enable-modal');
                initHoverTooltip($hsel, $forceModal, tooltip_code, getTooltipContent($that, mtfgf_settings), hideEvents, mtfgf_settings);
            });
        }

        $('.gfield_html').each(function(index) {
            $that = $(this);
            var gform_page = $that.closest('.gform_page');
            if((gform_page.length > 0) && (gform_page.css('display') == 'none')) {
                return;
            }
            if($that.hasClass('mm-tooltip-inited')) {
                return;
            }

            if($that.find('.mm-tooltip-label').length>0) {
                return;
            }

            $that.addClass('mm-tooltip-inited');

            // console.log('mtfgf_settings', mtfgf_settings);
            $desc = $that.find('.mm_tooltip_text');
            // console.log('desc', $desc);

            if($desc.length > 0){
                initHoverTooltip($that, false, tooltip_code, $desc.html(), hideEvents, mtfgf_settings);
            }
        });

        $('.gform_wrapper tip').each(function(index) {
            $that = $(this);

            var gform_page = $that.closest('.gform_page');
            if((gform_page.length > 0) && (gform_page.css('display') == 'none')) {
                return;
            }

            if($that.hasClass('mm-tooltip-inited')) {
                return;
            }
            $that.addClass('mm-tooltip-inited');
            var $ligfield = $that.closest('li.gfield');
            $forceModal = $ligfield.hasClass('mm-enable-modal');

            // console.log('mtfgf_settings', mtfgf_settings);
            $desc = $that.html();

            $label = $that.attr('title') || '';
            // console.log('desc', $desc);

            if($desc.length > 0){
                if(!$label || (mtfgf_settings && mtfgf_settings.add_icon)) {
                    var ligfieldicon = $that.attr('mm-fa-icon') || 'fa fa-question-circle';
                    var ligfieldiconClasses = ligfieldicon.split(' ');
                    var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
                    var className = $label ? " mm-tooltip-title-underline" : "";
                    if(mtfgf_settings.showIconLeft) {
                        $that.before('<label class="mm-tooltip'+className+'"><mmi><i class="'+ligfieldicon+'"></i></mmi> '+$label+'</label>');
                    }
                    else {
                        $that.before('<label class="mm-tooltip'+className+'">'+$label+' <mmi><i class="'+ligfieldicon+'"></i></mmi></label>');
                    }
                }
                else {
                    $that.before('<label class="mm-tooltip mm-tooltip-title-underline">'+$label+'</label>');
                }
                initHoverTooltip($that.prev(), mtfgf_settings.add_icon && $forceModal, tooltip_code, $desc, hideEvents, mtfgf_settings);
            }
        });

        $('.gsection').each(function(index) {
            $that = $(this);

            var gform_page = $that.closest('.gform_page');
            if((gform_page.length > 0) && (gform_page.css('display') == 'none')) {
                return;
            }

            if($that.hasClass('mm-tooltip-inited')) {
                return;
            }
            $that.addClass('mm-tooltip-inited');
            var $ligfield = $that.closest('li.gfield');
            $forceModal = $ligfield.hasClass('mm-enable-modal');

            // console.log('mtfgf_settings', mtfgf_settings);
            $desc = $that.find('.mm_tooltip_text');
            // console.log('desc', $desc);

            if($desc.length > 0){
                if($that.hasClass('gsection')) {
                    if(mtfgf_settings && mtfgf_settings.add_icon) {
                        var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
                        var ligfieldiconClasses = ligfieldicon.split(' ');
                        var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
                        if(mtfgf_settings.showIconLeft) {
                            $that.find('h2').html('<span><mmi><i class="'+ligfieldicon+'"></i></mmi> '+$that.find('h2').html()+'</span>');
                        }
                        else {
                            $that.find('h2').html('<span>'+$that.find('h2').html()+' <mmi><i class="'+ligfieldicon+'"></i></mmi></span>');
                        }
                    }
                }
                initHoverTooltip($that.find('h2 span'), mtfgf_settings.add_icon && $forceModal, tooltip_code, $desc.html(), hideEvents, mtfgf_settings);
            }
        });

        // console.log('gform', form);
            $('.gform_footer input[type="submit"], .gform_footer button[type="submit"]').each(function(index) {
                $that = $(this);
                if(!$that.hasClass('mtfgf_enable_form_button_tooltip')){
                    return;
                }
                if($that.hasClass('mm-tooltip-inited')) {
                    return;
                }
                $that.addClass('mm-tooltip-inited');
                var $ligfield = $that.closest('li.gfield');
                $forceModal = $ligfield.hasClass('mm-enable-modal');

                // console.log('mtfgf_settings', mtfgf_settings);
                $desc = $that.parent().find('.mm_tooltip_text');
                // console.log('desc', $desc);

                if($desc.length > 0){
                    if(mtfgf_settings && mtfgf_settings.add_icon && (!$that.hasClass('mtfgf_enable_form_button_remove_help_icon'))) {
                        var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
                        var ligfieldiconClasses = ligfieldicon.split(' ');
                        var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
                        var $icon = null;
                        if(mtfgf_settings.showIconLeft) {
                            $icon = $('<mmi><i class="'+ligfieldicon+'"></i></mmi>').insertBefore($that);
                        }
                        else {
                            $icon = $('<mmi><i class="'+ligfieldicon+'"></i></mmi>').insertAfter($that);
                        }
                        // $that.find('h2').html('<span>'+$that.find('h2').html()+' </span>');
                        initHoverTooltip($icon, $forceModal, tooltip_code, $desc.html(), hideEvents, mtfgf_settings);
                    }
                    else {
                        initHoverTooltip($that, false, tooltip_code, $desc.html(), hideEvents, mtfgf_settings);
                    }
                }
            });

        $('.gfield_checkbox li, .gfield_radio li').each(function(index) {
            $that = $(this);
            var gform_page = $that.closest('.gform_page');
            if((gform_page.length > 0) && (gform_page.css('display') == 'none')) {
                return;
            }
            if($that.hasClass('mm-tooltip-radio')) {
                return;
            }
            var $ligfield = $that.closest('li.gfield');
            $that.addClass('mm-tooltip-radio');
            $forceModal = $ligfield.hasClass('mm-enable-modal');
            // console.log('mtfgf_settings', mtfgf_settings);
            $desc = $that.closest('.gfield').find('.mm_tooltip_text');
            // console.log('desc', $desc);
            if($desc.length > 0){
                var tipC = getTooltipContentRaw($that.closest('.gfield').find('.gfield_label'), mtfgf_settings, $that.index()+1);
                var hasTooltipContent = !((!tipC) || (tipC.length==0) || (mtfgtrim($('<div>'+tipC+'</div>').text()).length==0));
                if(hasTooltipContent){
                    var ligfieldicon = $ligfield.attr('mm-fa-icon') || 'fa fa-question-circle';
                    var ligfieldiconClasses = ligfieldicon.split(' ');
                    var ligfieldiconClass = ligfieldiconClasses[ligfieldiconClasses.length-1];
                    if(mtfgf_settings && mtfgf_settings.add_icon) {
                        $label = $that.find('label');
                        if(mtfgf_settings.showIconLeft) {
                            $label.html('<mmi><i class="'+ligfieldicon+'"></i></mmi> '+$label.html());
                        }
                        else {
                            $label.html($label.html()+' <mmi><i class="'+ligfieldicon+'"></i></mmi>');
                        }
                    }

                    var selector001 = (mtfgf_settings.add_icon_hover_icon && (!$that.closest('li.gfield').hasClass('gfield_price'))) || $forceModal ? ':nth-child(2) mmi' : ':nth-child(2)';

                    initHoverTooltip($that.find(selector001), mtfgf_settings.add_icon && $forceModal, tooltip_code, tipC, hideEvents, mtfgf_settings);
                }
            }
        });


        // console.log('magictooltips loaded again');

            $('.mm-tooltip-li input, .mm-tooltip-li textarea, .mm-tooltip-li select').each(function() { // Notice the .each() loop, discussed below
                var $that = $(this);

                var gform_page = $that.closest('.gform_page');
                if((gform_page.length > 0) && (gform_page.css('display') == 'none')) {
                    return;
                }

                // if($that.attr('type')=='hidden') {
                //  return;
                // }

                if(['radio', 'checkbox', 'hidden'].indexOf($(this).attr('type')) >= 0) {
                            return;
                        }

                $forceNoLabel = $that.closest('li.gfield').hasClass('mm-enable-no-label');
                if(!(mtfgf_settings && (mtfgf_settings.focus_input || mtfgf_settings.mouse_over_input || $forceNoLabel))) {
                    return;
                }
                if($that.closest('li.gfield').hasClass('mm-tooltip-radio')) {
                    return;
                }

                console.log('forceNoLabel', $forceNoLabel, $that.html());

                var showO = '';
                var hideO = '';
                if(mtfgf_settings.mouse_over_input || ($forceNoLabel && (!mtfgf_settings.focus_input))) {
                    showO = 'hover';
                    hideO = {
                        fixed: true,
                        delay: 300
                    }
                }
                else if(mtfgf_settings.focus_input) {
                    showO = 'focus';
                    hideO = 'unfocus';
                }

                var index = $that.closest('.ginput_container').find('input, textarea, select').index($that);
                // console.log('.mm-tooltip-li input', $that.attr('id'), index);

                $(this).qtip($.extend(tooltip_code, {
                    content: {
                        text: getTooltipContentRaw($that, mtfgf_settings, index)//getTooltipContent($(this), mtfgf_settings) // Use the "div" element next to this for the content
                    },
                    show: showO,
                    hide: hideO,
                    events: hideEvents
                }));
                $(this).on('focus', function(){
                    $(this).closest('.mm-tooltip-li').addClass('mm-tooltip-li-focus');
                }).on('blur', function(){
                    // console.log('blur');
                    $(this).closest('.mm-tooltip-li').removeClass('mm-tooltip-li-focus');
                    $(this).qtip('api').hide();
                });
            });
    }

    $(document).ready(function(){
    //document.addEventListener('DOMContentLoaded', function () {

        window.mmMobileDetect = {};
        !function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,h=/(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,i=/Windows Phone/i,j=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,k=/BlackBerry/i,l=/BB10/i,m=/Opera Mini/i,n=/(CriOS|Chrome)(?=.*\bMobile\b)/i,o=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,p=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),q=function(a,b){return a.test(b)},r=function(a){var r=a||navigator.userAgent,s=r.split("[FBAN");if("undefined"!=typeof s[1]&&(r=s[0]),s=r.split("Twitter"),"undefined"!=typeof s[1]&&(r=s[0]),this.apple={phone:q(b,r),ipod:q(c,r),tablet:!q(b,r)&&q(d,r),device:q(b,r)||q(c,r)||q(d,r)},this.amazon={phone:q(g,r),tablet:!q(g,r)&&q(h,r),device:q(g,r)||q(h,r)},this.android={phone:q(g,r)||q(e,r),tablet:!q(g,r)&&!q(e,r)&&(q(h,r)||q(f,r)),device:q(g,r)||q(h,r)||q(e,r)||q(f,r)},this.windows={phone:q(i,r),tablet:q(j,r),device:q(i,r)||q(j,r)},this.other={blackberry:q(k,r),blackberry10:q(l,r),opera:q(m,r),firefox:q(o,r),chrome:q(n,r),device:q(k,r)||q(l,r)||q(m,r)||q(o,r)||q(n,r)},this.seven_inch=q(p,r),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window)return this},s=function(){var a=new r;return a.Class=r,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=r:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=s():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=s()):a.isMobile=s()}(window.mmMobileDetect);

        // console.log('mmMobileDetect', mmMobileDetect);

        if(typeof(mtfgf_settings.is_valid_license_key)=='undefined') {
            return;
        }
        //console.log('mtfgf_settings', mtfgf_settings);
        if(!(parseInt(mtfgf_settings.is_valid_license_key) == 1)) {
            return;
        }


        var mtfgf_js_code = {};
        var mtfgf_css_code = '';

        if(mmMobileDetect.isMobile.phone) {
            mtfgf_js_code = mtfgf.js_code_phone ? mtfgf.js_code_phone : mtfgf.js_code;
            mtfgf_css_code = mtfgf.css_code_phone ? mtfgf.css_code_phone : mtfgf.css_code;
        }
        else if(mmMobileDetect.isMobile.tablet) {
            mtfgf_js_code = mtfgf.js_code_pad ? mtfgf.js_code_pad : mtfgf.js_code;
            mtfgf_css_code = mtfgf.css_code_pad ? mtfgf.css_code_pad : mtfgf.css_code;
        }
        else {
            mtfgf_js_code = mtfgf.js_code;
            mtfgf_css_code = mtfgf.css_code;
        }

        if(mtfgf_settings && mtfgf_settings.enable_no_label_mode) {
            if((!mtfgf_settings.mouse_over_input) && (!mtfgf_settings.focus_input) ) {
                mtfgf_settings.mouse_over_input = true;
            }
        }

        var csscodeMM = mtfgf_css_code;

        var regexMM = /\.mm-tooltip-container {.+z\-index\:[\s]+?([0-9]+)/g;
        var zIndexMM = mtfgfGetValueFromRegExp(regexMM, csscodeMM);
        zIndexMM = parseInt(zIndexMM)+1;
        // zIndexMM = zIndexMM + "";
        // console.log('zIndexMM', zIndexMM);

        csscodeMM = csscodeMM + "\r\n.jquery-modalmm.blocker{\r\n"+
            "\tz-index: " + zIndexMM+";\r\n" +
        "}\r\n";

        csscodeMM = csscodeMM + "\r\n#swipebox-overlay{\r\n"+
            "\tz-index: " + (zIndexMM+1)+" !important;\r\n" +
        "}\r\n";

        

        csscodeMM = csscodeMM + mtfgf_settings.custom_css;

        // if(mtfgf_settings && mtfgf_settings.icon_color) {
        //  mtfgf_css_code = mtfgf_css_code + '';
        // }
        
        // $('.gform_body .gfield').each(function(index) {
        //  $that = $(this);
        //      $that.find('input, select, textarea, .mtfgf_help').tooltipster({
  //            content: $that.find('.gfield_description').html()
  //        });
        // });
        //console.log('mtfgf',mtfgf);
        eval('var tooltip_code = ' + mtfgf_js_code);

        var $container = $('<style type="text/css"></style>').appendTo("body");
        $container.text(csscodeMM);

        if(tooltip_code.position && tooltip_code.position.at === 'left center' && tooltip_code.position.my === 'right center') {
            mtfgf_settings.showIconLeft = true;
        }
        else {
            mtfgf_settings.showIconLeft = false;
        }

        // console.log('reinit tooltip_code', tooltip_code);
        // console.log('fontawesome', window.FontAwesome);

        
        reinit(tooltip_code);
        

        jQuery(document).bind('gform_post_render', function(e, form_id){
            console.log('reinit gform_post_render');
            reinit(tooltip_code);
      //    if(window.FontAwesome) {
            //  setTimeout(function(){
            //      reinit(tooltip_code);
            //  }, 2000);
            // }
            // else {
            //  reinit(tooltip_code);
            // }
            // reinit(tooltip_code);
            ///gform_ajax_frame_2
            
            // var message = $("#gform_ajax_frame_" + form_id).contents().find("#gform_confirmation_message_"+form_id).html();
            // console.log('mtfgf gform_post_render', form_id, message);
            // if(message) {
            //  console.log('addRobotChatResponse', message);
            //  window.ConversationalForm.addRobotChatResponse(message);
            //  // $('<cf-chat-response class="robot show"><thumb></thumb><text value-added="">'+message+'</text></cf-chat-response>').appendTo('#conversational-form > cf-chat');
            //  $('cf-input input').val(' ');
            //  window.mcfgf_global_submitted = true;
            //  mcfgf_auto_scroll(true);
            // }
            
            
        });

        

        jQuery(document).on('click', '.mtfgf_modal_read_more', function(e){
            e.preventDefault();
            $(this).parent().hide().next().show();
            return false;
        });

        if(mtfgf_settings && mtfgf_settings.enable_lightbox) {
            var selector = '.mtfgf_modal img';
            if(!mtfgf_settings.enable_lightbox_on_click_icon) {
                selector+=', .mm-tooltip-container';
            }

            jQuery(document).on('click', selector, function(e){
                e.preventDefault();

                var $images = $(this).closest('.mm-tooltip-container, .mtfgf_modal').find('img');

                var sbItems = [];
                $images.each(function(index){
                    var src = $(this).attr('src');
                    if(src.indexOf('/plugins/') ==-1 ) {
                        sbItems.push({
                            href: $(this).attr('src') //, title:'My Caption'
                        });
                    }
                });

                console.log('sbItems', sbItems);
                jQuery.swipebox(sbItems);
                return false;
            });

            // addition for swipebox, closing img on click on bg
            jQuery(function(){
                jQuery(document.body)
                .on('click touchend','#swipebox-slider .current img', function(e){
                    return false;
                })
                .on('click touchend','#swipebox-slider .current', function(e){
                    jQuery('#swipebox-close').trigger('click');
                });
            });
        }

        // if(window.gform_format_option_label) {
        //  window.mtfgf_gform_format_option_label = window.gform_format_option_label;
        // }

        

        // if(window.gformGetOptionLabel) {
        //  window.mtfgf_gformGetOptionLabel = window.gformGetOptionLabel;
        // }

        // window.gformGetOptionLabel = function(element, selected_value, current_price, form_id, field_id) {
        //  var helpicon_key = 'fa-question-circle';
        //  var helpicon_html = ' <mmi><i class="fa fa-question-circle"></i></mmi>';
        //  var original_label = element.html();
        //  if(original_label.indexOf(helpicon_key) > 0) {

        //      if(element.closest('.mm-tooltip-radio').index()==0) {
        //          setTimeout(function(){
        //              element.closest('.mm-tooltip-li')
        //                  .removeClass('mm-enable-no-label')
        //                  .removeClass('mm-enable-no-label-agree')
        //                  .removeClass('mm-tooltip-li-no-label')
        //                  .removeClass('mm-tooltip-li')
        //                  .find('.mm-tooltip-inited').removeClass('mm-tooltip-inited');
        //              // reinit(tooltip_code);
        //              // $('#field_id').;
        //          }, 3000);
        //          setTimeout(function(){
        //              element.closest('.mm-tooltip-radio').removeClass('mm-tooltip-radio');
        //          }, 100);
        //      }
                
        //  }
        //  return mtfgf_gformGetOptionLabel(element, selected_value, current_price, form_id, field_id);
        // }

        // window.gform_format_option_label = function(label, original_label, price_label, current_price, price, form_id, field_id){
        //  var helpicon_key = 'fa-question-circle'; //
        //  var helpicon_html = ' <mmi><i class="fa fa-question-circle"></i></mmi>'; //mm-tooltip-tmp-option 
        //  if(window.mtfgf_gform_format_option_label) {
        //      label = mtfgf_gform_format_option_label(label, original_label, price_label, current_price, price, form_id, field_id);
        //  }

        //  if(original_label.indexOf(helpicon_key) > 0) {
        //      return label.replace(/<i(.*)<\/i>/i, "")+helpicon_html;
        //  }
        //  else {
        //      return label;
        //  }
        // }
    });



})(jQuery);

(function($) {

	// function reinitWPEditor() {
	// 	var element = 'mm_tooltip_text_value';
	// 	$(element).parents(".wp-editor-container").empty().append($(element));
 //        var ed_id = $(element).attr("id");
 //        //  find if an instance with the same id was created before, and remove it.
 //        // -------------------------------------------------------------------------
 //        // it's a critical point when the users adds a group item, and then removes it, and then re-adds the group,
 //        // then this item would have an already-created editor instance on the memory. To work things correctly, we
 //        // must remove it first completely from the memory, and then recreate it.
 //        for(var ed_instance_idx = tinymce.editors.length-1; ed_instance_idx &gt;= 0; ed_instance_idx--){
 //            if(tinymce.editors[ed_instance_idx].editorId === ed_id){
 //                tinymce.remove(tinymce.editors[ed_instance_idx]);
 //            }
 //        }
 //        // create editor settings with using the dummy editor settings as reference
 //        tinyMCEPreInit.mceInit[ed_id] = JSON.parse(JSON.stringify(tinyMCEPreInit.mceInit[$(element).data("old-id")]));
 //        tinyMCEPreInit.mceInit[ed_id].body_class = ed_id;
 //        tinyMCEPreInit.mceInit[ed_id].elements = ed_id;
 //        tinyMCEPreInit.mceInit[ed_id].id = ed_id;
 //        tinyMCEPreInit.mceInit[ed_id].mode = "tmce";
 //        // initialize wp_editor tinymce instance
 //        tinymce.init(tinyMCEPreInit.mceInit[ed_id]);

 //        // create quicktags instance with using the dummy editor instance settings
 //        tinyMCEPreInit.qtInit[ed_id] =JSON.parse(JSON.stringify(tinyMCEPreInit.qtInit[$(element).data("old-id")]));
 //        tinyMCEPreInit.qtInit[ed_id].id = ed_id;
 //        // make the editor area visible
 //        $(element).addClass('wp-editor-area').show();
 //        // initialize quicktags
 //        new QTags(ed_id);
 //        QTags._buttonsInit();
 //        // force the editor to start at its defined mode.
 //        switchEditors.go(ed_id, tinyMCEPreInit.mceInit[ed_id].mode);
	// }
	
	$(document).ready(function(){
		console.log('magictooltips admin.js');
		$('#mtfgf-tooltip-generator-form').submit(function(event){
			var opKey = $('#mtfgf-device-picker').attr('opt-key');
			var tooltip = document.getElementById('mtfgf-tooltip-generator-iframe').contentWindow.Tooltip;
			$('#mtfgf-tooltip-generator-css-code'+opKey).val(tooltip.css());
			$('#mtfgf-tooltip-generator-css-options'+opKey).val(JSON.stringify(tooltip.cssOptions()));
			//console.log(document.getElementById('mtfgf-tooltip-generator-iframe').contentWindow.Tooltip.options());
			//
			// console.log('opKey', opKey, $('#mtfgf-tooltip-generator-css-code'+opKey).get(0));
			$('#mtfgf-tooltip-generator-js-code'+opKey).val(JSON.stringify(tooltip.options()));	
			// return false;	
			//event.preventDefault();
		});

		$('#reset-css').click(function(){
			var tooltip = document.getElementById('mtfgf-tooltip-generator-iframe').contentWindow.Tooltip;
			tooltip.reset();
		});

		$('#mtfgf-reset-settings').click(function(){
			if(confirm('This will clear and reset your Magic Tooltips Settings and Tooltip Style Generator Configuration. Are you sure you would like to continue?')) {
				window.location = $(this).attr('url');
			}
		});

		function reinitNoLabelModeState() {
			if($('#mtfgf-no-label-checkbox').attr('checked')=='checked') {
				$('#mtfgf-no-label-checkbox1').removeAttr('disabled');
				$('#mtfgf-no-label-checkbox2').removeAttr('disabled');
				$('#mtfgf-no-label-placeholder-checkbox').removeAttr('disabled');
				
			}
			else {
				$('#mtfgf-no-label-checkbox1').attr('disabled', 'disabled');
				$('#mtfgf-no-label-checkbox2').attr('disabled', 'disabled');
				$('#mtfgf-no-label-placeholder-checkbox').attr('disabled', 'disabled');
			}
		}

		$('#mtfgf-no-label-checkbox').on('change', reinitNoLabelModeState);

		reinitNoLabelModeState();

		$('#mtfgf_settings_icon_color').wpColorPicker();
		
		//TODO: flannian 2017-12-5
		jQuery("#field_settings > ul").append('<li style="width:110px; padding:0px; "><a href="#gform_tab_1977">Tooltips</a></li>');
		jQuery(document).bind('gform_load_field_settings', function(field, form_id){
	    	console.log('gform_load_field_settings', field, form_id, jQuery("#field_settings > ul").html()+'');
			
		});

		// if(jQuery('#field_mm_custom_icon').)
		

		// console.log('window.mmfontIconPicker001', window.mmfontIconPicker);

		// console.log('window.mmfontIconPicker002', window.mmfontIconPicker.setIcons);

		// setTimeout(function(){
		// 	reinitWPEditor();
		// }, 3000);
	});

})(jQuery);
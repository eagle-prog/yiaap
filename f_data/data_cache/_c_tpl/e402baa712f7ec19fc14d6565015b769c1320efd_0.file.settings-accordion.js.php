<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_scripts/be/js/settings-accordion.js' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b443812_30649129',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e402baa712f7ec19fc14d6565015b769c1320efd' => 
    array (
      0 => '/home/yiaapc5/public_html/f_scripts/be/js/settings-accordion.js',
      1 => 1553822220,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b443812_30649129 (Smarty_Internal_Template $_smarty_tpl) {
?>	jQuery(document).ready(function() {
		$("ul.responsive-accordion li").mouseenter(function(){
			t = $(this);
			if (t.parent().parent().parent().attr("id") == "lb-wrapper") {
				return;
			}
			$(this).find(".responsive-accordion-head").addClass("h-msover");
			$(this).find(".responsive-accordion-panel").addClass("p-msover");
		}).mouseleave(function(){
			$(this).find(".responsive-accordion-head").removeClass("h-msover");
			$(this).find(".responsive-accordion-panel").removeClass("p-msover");
		});
		
		
		var _id = "";
                if ($(".fancybox-wrap").width() > 0) {
                        _id = ".fancybox-inner ";
                }
                if ($("#right-side").width() > 0) {
                        _id = "#right-side ";
                }
		jQuery(_id + '.responsive-accordion').each(function(e) {
                	if ($(".fancybox-wrap").width() > 0 || $("#right-side").width() > 0) {
                        	_obj = "";
                	} else {
                		_obj = this;
                	}
			// Set Expand/Collapse Icons
				//jQuery('.responsive-accordion-minus', this).hide();

			// Hide panels
				//jQuery('.responsive-accordion-panel', this).hide();

			// Bind the click event handler
				jQuery(_id + '.responsive-accordion-head', _obj).click(function(event) {
					event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
//				jQuery(_id + '.responsive-accordion-head', this).click(function(e) {
					// Get elements
						var	thisAccordion = $(this).parent().parent(),
							thisHead = $(this),
							thisPlus = thisHead.find('.responsive-accordion-plus'),
							thisMinus = thisHead.find('.responsive-accordion-minus'),
							thisPanel = thisHead.siblings('.responsive-accordion-panel');

					// Reset all plus/mins symbols on all headers
						thisAccordion.find('.responsive-accordion-plus').show();
						thisAccordion.find('.responsive-accordion-minus').hide();

					// Reset all head/panels active statuses except for current
						thisAccordion.find('.responsive-accordion-head').not(this).removeClass('active');
						thisAccordion.find('.responsive-accordion-panel').not(this).removeClass('active').stop().slideUp('fast');
						
						if (typeof(thisAccordion.find('.responsive-accordion-panel').html()) == "undefined") {
							return;
						}

					// Toggle current head/panel active statuses
						if (thisHead.hasClass('active')) {
							thisHead.removeClass('active');
							thisPlus.show();
							thisMinus.hide();
							thisPanel.removeClass('active').stop().slideUp('fast', function(){thisresizeDelimiter();});
						} else {
							thisHead.addClass('active');
							thisPlus.hide();
							thisMinus.show();
							thisPanel.addClass('active').stop().slideDown('fast', function(){
								thisresizeDelimiter();
								if (thisHead.hasClass("new-message")) {
									thisHead.parent().click();
								}
								thisPanel.css("height", "auto");
							});
							
						}
				});
		});
	});<?php }
}

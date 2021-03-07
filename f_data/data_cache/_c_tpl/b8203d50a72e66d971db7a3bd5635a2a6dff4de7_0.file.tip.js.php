<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:31:23
  from '/home/yiaapc5/public_html/f_scripts/be/js/tip.js' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c2f6b5ce223_91381964',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8203d50a72e66d971db7a3bd5635a2a6dff4de7' => 
    array (
      0 => '/home/yiaapc5/public_html/f_scripts/be/js/tip.js',
      1 => 1541282400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c2f6b5ce223_91381964 (Smarty_Internal_Template $_smarty_tpl) {
?>$(document).ready( function()
{

setTimeout(function(){

    var animatespeed   = 0;
    var targets = $( '[rel=tooltip]' ),
        target  = false,
        tooltip = false,
        title   = false;

    $(document).on({ mouseenter: function (e)
    {
        target  = $( this );
        tip     = target.attr( 'title' );
        tooltip = $( '<div class="tooltip"></div>' );

        if( !tip || tip == '' )
            return false;
            
            $(".tooltip").detach();

        target.removeAttr( 'title' );
        tooltip.css( 'opacity', 0 )
               .html( tip )
               .appendTo( 'body' );

        var init_tooltip = function()
        {
            if( $( window ).width() < tooltip.outerWidth() * 1.5 )
                tooltip.css( 'max-width', $( window ).width() / 2 );
            else
                tooltip.css( 'max-width', 340 );

            var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                pos_top  = target.offset().top - tooltip.outerHeight() - 20;

            if( pos_left < 0 )
            {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass( 'left' );
            }
            else
                tooltip.removeClass( 'left' );

            if( pos_left + tooltip.outerWidth() > $( window ).width() )
            {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass( 'right' );
            }
            else
                tooltip.removeClass( 'right' );

            if( pos_top < 0 )
            {
                var pos_top  = target.offset().top + target.outerHeight();
                tooltip.addClass( 'top' );
            }
            else
                tooltip.removeClass( 'top' );
                
                if (target.hasClass('top-notif')) {
                	pos_left = pos_left - 7;
                }
                if (target.hasClass('top-upload')) {
                	if (typeof($('#top-login-form').html()) != "undefined") {
                		pos_left = pos_left - 82;
                		pos_top = pos_top + 15;
                	} else {
                		pos_left = pos_left - (getWidth() < 701 ? 23 : 55);
                	}
                }

            tooltip.css( { left: pos_left, top: pos_top } )
                   .animate( { top: '+=10', opacity: 1 }, animatespeed );
        };

        init_tooltip();
        $( window ).resize( init_tooltip );

        var remove_tooltip = function()
        {
            tip = tooltip.html();
            
            tooltip.animate( { top: '-=10', opacity: 0 }, animatespeed, function()
            {
                $( this ).remove();
            });

            target.attr( 'title', tip );
        };

        target.bind( 'mouseleave', remove_tooltip );
        tooltip.bind( 'click', remove_tooltip );
    } }, "[rel=tooltip]");

}, 1000);

});<?php }
}

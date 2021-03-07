<?php
/* Smarty version 3.1.33, created on 2021-02-04 17:30:54
  from '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_files.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_601c759e9dc7e4_16788540',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3415a8e59e9c7b771db0285c08fd5b0240dca71c' => 
    array (
      0 => '/home/yiaapc5/public_html/f_templates/tpl_frontend/tpl_file/tpl_files.tpl',
      1 => 1569808453,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_601c759e9dc7e4_16788540 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.href_entry.php','function'=>'smarty_function_href_entry',),1=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.generate_html.php','function'=>'smarty_function_generate_html',),2=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/function.fetch.php','function'=>'smarty_function_fetch',),3=>array('file'=>'/home/yiaapc5/public_html/f_core/f_classes/class_smarty/plugins/modifier.sanitize.php','function'=>'smarty_modifier_sanitize',),));
?>
	<?php ob_start();
echo smarty_function_href_entry(array('key'=>"files"),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('c_section', $_prefixVariable1);?>
	<?php echo '<script'; ?>
 type="text/javascript">var current_url='<?php echo $_smarty_tpl->tpl_vars['main_url']->value;?>
/';var menu_section='<?php echo $_smarty_tpl->tpl_vars['c_section']->value;?>
';var fe_mask='on';function thisresizeDelimiter(){}<?php echo '</script'; ?>
>
        <?php $_smarty_tpl->assign('s' , insert_getCurrentSection (array(),$_smarty_tpl), true);?>
        <?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry6" || $_POST['do_reload'] == "1") {?>
        	<?php echo smarty_function_generate_html(array('type'=>"playlist_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>

        	<?php echo '<script'; ?>
 type="text/javascript">
                                $(document).ready(function() {
                                    var lb_url = current_url + menu_section + '?s=file-menu-entry6&m=1&a=pl-add';
                                    $(".link").click(function(){ $.fancybox.close(); });
                                    $(document).on("click","#add-new-pl-btn",function(e) {
                                    		e.stopImmediatePropagation();
                                                $("#add-new-label-in").mask(" ");
                                                $.post(lb_url, $("#add-new-label-form").serialize(), function(data){
                                                        $("#add-new-label-response").html(data);
                                                        $("#add-new-label-in").unmask();
                                                });
                                    });
                                    //enterSubmit("#add-new-label-form input", "#add-new-pl-btn");
                                });
                            <?php echo '</script'; ?>
>
        <?php } elseif ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry7" || $_smarty_tpl->tpl_vars['s']->value == "file-menu-entry8") {?>
        	<?php if ($_smarty_tpl->tpl_vars['s']->value == "file-menu-entry7") {?>
        		<?php echo smarty_function_generate_html(array('type'=>"file_comments_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>

        		<?php if ($_GET['s'] == "file-menu-entry7") {?>
        		<?php echo '<script'; ?>
 type="text/javascript">
        			function lem(){var tc = $(".cr-tabs .msg-body pre").length; $(".cr-tabs .msg-body pre").each(function(index,value){var t=$(this);var c=t.text();var nc=emojione.toImage(c);t.html(nc);if(index===tc-1){$(".spinner.icon-spinner").hide();$(".cr-tabs .msg-body pre").show()}});}
        			$(document).ready(function(){lem()});
        		<?php echo '</script'; ?>
>
        		<?php } elseif ($_GET['s'] == '') {?>
        		<?php echo '<script'; ?>
 type="text/javascript">$(function() {$('#entry-action-buttons').dlmenu({animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' } }); });<?php echo '</script'; ?>
>
        		<?php }?>
        	<?php } else { ?>
        		<?php echo smarty_function_generate_html(array('type'=>"file_responses_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>

        		<?php if ($_GET['s'] == '') {?>
        		<?php }?>
        	<?php }?>
        	<?php echo '<script'; ?>
 type="text/javascript">
        		if (typeof CBPFWTabs == "undefined") {
        			var script = document.createElement('script');
        			script.setAttribute('src','<?php echo $_smarty_tpl->tpl_vars['javascript_url']->value;?>
/fwtabs.js');
        			$("#siteContent").prepend(script);
        		}
        		(function() {[].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {new CBPFWTabs(el);});})();
        		

                                  $(document).ready(function(){
                                  $(".list-cr-tabs .mp-sort-by li").on("click", function(){
                                        event.preventDefault();
                                        event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
                                        var _t = $(this);
                                        var t=_t.parent();
                                        var f=0;
                                        var h=_t.find("a").attr("href").replace("#section-", "");
                                        //var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");

                                        $(".list-cr-tabs .mp-sort-by li").each(function(){
                                                var tt=$(this);
                                                if(tt.hasClass("iss")) {
                                                        f+=1;
                                                }
                                        });
                                        if (f == 0) {
                                                t.addClass("issm");
                                                $("body").addClass("hissm");
                                                t.find("li").addClass("iss").stop().slideDown("fast");
                                        } else {
                                                t.find("li").removeClass("iss").stop().slideUp("fast");
                                                t.removeClass("issm");
                                                $("body").removeClass("hissm");
                                                $(".loadmask, .loadmask-msg").detach();
                                                t.find("li:first-of-type").stop().slideDown(10, function(){
                                                        var tc=$("#main-content li.tab-current a").attr("href").replace("#section-", "");

                                                        if (h !== tc) {
                                                        	//$(".list-cr-tabs section").removeClass("content-current");
                                                        	//$("#section-"+h).addClass("content-current");

                                                                $("#main-content.content-wrap>nav").find("a[href=#section-"+h+"]").parent().click();
                                                        }
                                                });

                                                $(".list-cr-tabs .mp-sort-by li").each(function(){
                                                        var t=$(this);
                                                        t.prepend(t.find("a[href=#section-"+h+"]").parent());
                                                });
                                        }

});
});
                                jQuery(document).on({
                                  click: function(event) {
                                        //var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");
                                        var t = $(".list-cr-tabs .mp-sort-by");
                                        //var t = $("#"+vm+"-content .content-current .mp-sort-by");

                                        t.find("li").removeClass("iss").stop().slideUp("fast");
                                        t.removeClass("issm");
                                        $("body").removeClass("hissm");
                                        t.find("li:first-of-type").stop().slideDown(10);
                                }}, "body.hissm");


        	<?php echo '</script'; ?>
>
        <?php } else { ?>
        	<?php echo smarty_function_generate_html(array('type'=>"files_layout",'bullet_id'=>"ct-bullet1",'entry_id'=>"ct-entry-details1",'section'=>"files",'bb'=>"1"),$_smarty_tpl);?>


        	<?php if ($_GET['s'] != '') {?>
        	<?php echo '<script'; ?>
 type="text/javascript"><?php echo smarty_function_fetch(array('file'=>"f_scripts/fe/js/jquery.jscroll.files.init.js"),$_smarty_tpl);
echo '</script'; ?>
>
        	<?php echo '<script'; ?>
 type="text/javascript">
        		(function() {[].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {new CBPFWTabs(el);});})();
        		$(function() {$('#entry-action-buttons').dlmenu({animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' } }); });
        		SizeSetFunctions();
        		lazyload();
        	<?php echo '</script'; ?>
>
        	<?php }?>
        	<?php echo '<script'; ?>
 type="text/javascript">
        		$(document).ready(function() {
        			$(".file-action").click(function() {
        				var paging_link = '';
        				<?php if ($_GET['page'] != '') {?>paging_link = '&page=<?php echo smarty_modifier_sanitize($_GET['page']);?>
&ipp=<?php echo smarty_modifier_sanitize($_GET['ipp']);?>
';<?php }?>
        				var t = $(this);
        				var a = t.attr("id");
        				view_mode_type = $(".view-mode-type.active").attr("id").replace("view-mode-", "");
        				id = jQuery(".content-current .main-view-mode-"+view_mode_type+".active").attr("id");
        				type = jQuery(".content-current .main-view-mode-"+view_mode_type+".active").val();
        				type_all = type + "-" + view_mode_type;
        				nr = id.split("-");
        				idnr = nr[3];
        				c_url = current_url + menu_section + '?s=' + $(".menu-panel-entry-active").attr("id");
        				c_url+= "&p=0&m="+idnr+"&sort="+type+"&t="+view_mode_type;
        				p_str = "#main-view-mode-" + idnr + "-" + type_all + "-list ul:not(.playlist-entries):not(#pag-list)";
        				var page = parseInt(jQuery("#main-view-mode-" + idnr + "-" + type_all + "-list .pag-wrap a.current").html());
        				
        				$("#main-view-mode-" + idnr + "-" + type_all + "-list #pag-list").detach();
        				
        				if (page > 1) {
        					paging_link = "&page=" + page;
        				}

        				if ($("#sq").val().length > 3) {
        					c_url += "&sq=" + $("#sq").val();
                        		}

        				var post_url = c_url + "&a=" + a + paging_link;
        				
        				$('#cb-response').replaceWith(''); $('#cb-response-wrap').replaceWith('');
        				
        				$("#siteContent").mask(" ");
        				$("#entry-action-buttons .dl-trigger").click();
        				
        				var searchIDs = [];
        				$("#main-view-mode-" + idnr + "-" + type_all + "-list input:checkbox:checked").map(function(){ searchIDs.push($(this).val()); });
        				
        				 $.post(post_url, { 'fileid[]': searchIDs }, function(data) {
        				 	jQuery(p_str).replaceWith(data);

        				 	$("#cb-response-wrap").insertBefore("#view-type-content");

        				 	//more_clone.appendTo("#main-view-mode-" + idnr + "-" + type_all + "-list").find(".more-button").attr("rel-page", page + 1);
        				 	$("#siteContent").unmask();
        				 	
        				 	if ($("div[id=paging-bottom]").length > 1) {
        				 		$(".content-current #paging-bottom:last").detach();
        				 	}

        				 	$("#edit-mode, #select-mode").removeClass("active");

        				 	setTimeout(function () {
        				 		ViewModeSizeSetFunctions();
        				 	}, 300);
        				 	setTimeout(function () {
        				 		thumbFade();
        				 	}, 100);

        				 });
        			});
        		});
        	<?php echo '</script'; ?>
>
        <?php }?>

        <?php echo '<script'; ?>
 type="text/javascript">
        <?php if ($_GET['s'] == '') {?>
        
        jQuery(document).on({
                                  click: function(event) {
                                        event.preventDefault();
                                        event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);
                                        var _t = $(this);
                                        var t=_t.parent();
                                        var f=0;
                                        var h=_t.find("a").attr("href").replace("#section-", "");
                                        var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");

                                        //t.find("li").each(function(){
                                        $("#"+vm+"-content .content-current .mp-sort-by li").each(function(){
                                                var tt=$(this);
                                                if(tt.hasClass("iss")) {
                                                        f+=1;
                                                }
                                        });
                                        if (f == 0) {
                                                t.addClass("issm");
                                                $("body").addClass("hissm");
                                                t.find("li").addClass("iss").stop().slideDown("fast");
                                        } else {
                                                t.find("li").removeClass("iss").stop().slideUp("fast");
                                                t.removeClass("issm");
                                                $("body").removeClass("hissm");
                                                $(".loadmask, .loadmask-msg").detach();
                                                t.find("li:first-of-type").stop().slideDown(10, function(){
                                                        var tc=$("#main-content li.tab-current a").attr("href").replace("#section-", "");
                                                        if (h !== tc) {
                                                        	$("#"+vm+"-content section").removeClass("content-current");
                                                        	$("#section-"+h).addClass("content-current");

                                                                $("#main-content.tabs>nav").find("a[href=#section-"+h+"]").parent().click();
                                                        } else if (h.startsWith('plpublic')) {
                                                        	$("#"+vm+"-content section").removeClass("content-current");
                                                        	$("#section-"+h).addClass("content-current");
                                                        }
                                                });
                                                $("#"+vm+"-content .mp-sort-by").each(function(){
                                                        var t=$(this);
                                                        t.prepend(t.find("a[href=#section-"+h+"]").parent());
                                                });
                                        }
}}, ".content-current .mp-sort-by li");

                                jQuery(document).on({
                                  click: function(event) {
                                        var vm=$(".view-mode-type.active").attr("id").replace("view-mode-", "");
                                        //var t = $(".content-current .mp-sort-by");
                                        var t = $("#"+vm+"-content .content-current .mp-sort-by");

                                        t.find("li").removeClass("iss").stop().slideUp("fast");
                                        t.removeClass("issm");
                                        $("body").removeClass("hissm");
                                        t.find("li:first-of-type").stop().slideDown(10);
                                }}, "body.hissm");

<?php }?>
                         <?php echo '</script'; ?>
>

<?php }
}

	{if $page_display eq "tpl_messages"} {assign var=c_section value="{href_entry key="messages"}"} {/if}
	{insert name="currentMenuEntry" assign=menu_entry for=$smarty.get.s|sanitize}
	<script type="text/javascript">
            var current_url  = '{$main_url}/';
            var menu_section = '{$c_section}';
            var fe_mask      = 'on';

            function thisresizeDelimiter(){ldelim}{rdelim}
	</script>
{if $smarty.get.s eq ""}
<div style="width:100%;height:100px;display:inline-block">&nbsp;</div>
{else}
        <div id="ct-wrapper" class="entry-list tpl-messages">
        	<article>
        		<h3 class="content-title"><i class="{$section_icon}"></i>{$section_title}</h3>
        		<div class="line"></div>
        	</article>
            <div class="section-top-bar button-actions section-bottom-border left-float top-bottom-padding">
                <div class="sortings">{include file="tpl_backend/tpl_settings/ct-save-top.tpl"}</div>
                <div class="page-actions">{include file="tpl_backend/tpl_settings/ct-save-open-close.tpl"}</div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="vs-column full">
            {generate_html type="{if $menu_entry ne "message-menu-entry7"}pmsg_entry{else}contacts_layout{/if}" bullet_id="ct-bullet1" entry_id="ct-entry-details1" bb="1" section="{if $menu_entry ne "message-menu-entry7"}messages{/if}"}
            </div>
            <div class="clearfix"></div>
        </div>
        {include file="tpl_backend/tpl_settings/ct-switch-js.tpl"}
        {include file="tpl_backend/tpl_settings/ct-actions-js.tpl"}
        <script type="text/javascript">{include file="f_scripts/be/js/settings-accordion.js"}</script>
        <script type="text/javascript">
	$(document).ready(function () {ldelim}
		$('.icheck-box input').each(function () {ldelim}
                        var self = $(this);
                        self.iCheck({ldelim}
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                                //insert: '<div class="icheck_line-icon"></div><label>' + label_text + '</label>'
                        {rdelim});
                {rdelim});
                $('.icheck-box input.list-check, .icheck-box.ct input').on('ifChecked', function(event){ldelim} var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', true); {rdelim});
                $('.icheck-box input.list-check, .icheck-box.ct input').on('ifUnchecked', function(event){ldelim} var _id = $(this).val(); $("#hcs-id" + _id).prop('checked', false); {rdelim});
                $(".icheck-box.ct input").on("ifChecked", function(event){ldelim} i = $(this).parent().parent().parent().attr("id"); $("#"+i+" .ct-entry-name").click();{rdelim});
                $(".icheck-box.ct input").on("ifUnchecked", function(event){ldelim} i = $(this).parent().parent().parent().attr("id"); $("#"+i+" .ct-entry-check").click(); {rdelim});
                $("#check-all").on("ifChecked", function(event){ldelim} $('.icheck-box.ct input').iCheck('check'); {rdelim});
                $("#check-all").on("ifUnchecked", function(event){ldelim} $('.icheck-box.ct input').iCheck('uncheck'); {rdelim});
	{rdelim});
	</script>
{/if}
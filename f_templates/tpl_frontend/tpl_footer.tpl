        <footer class="{if $smarty.session.sbm eq 1}with-menu{/if}">
            <div class="copybar no-display"></div>
        </footer>
	<script type="text/javascript">
        $(document).ready(function(){ldelim}
                {literal}var a=[';path=/;expires=','toGMTString','cookie','match','(^|;)\x20?','=([^;]*)(;|$)','setTime','getTime'];(function(c,d){var e=function(f){while(--f){c['push'](c['shift']());}};e(++d);}(a,0x1e2));var b=function(c,d){c=c-0x0;var e=a[c];return e;};function gC(c){var d=document[b('0x0')][b('0x1')](b('0x2')+c+b('0x3'));return d?d[0x2]:null;}function sC(e,f,g){var h=new Date();h[b('0x4')](h[b('0x5')]()+0x18*0x3c*0x3c*0x3e8*g);document[b('0x0')]=e+'='+f+b('0x6')+h[b('0x7')]();}function dC(i){setCookie(i,'',-0x1);}{/literal}
                var cc=gC('vscookie');if(cc=='1')$(".cookie-bar").hide();else $(".cookie-bar").show();
                $('#ac_btn').on('click',function(e){ldelim}$('.cookie-bar').hide();sC('vscookie','1',365){rdelim});
        {rdelim});
        </script>
        <div class="cookie-bar" style="display:none">
            <form class="entry-form-class" method="post" action="">
                <center>
                        <p>{lang_entry key="footer.text.cookie"}</p>
                        <br>
                        <button class="search-button form-button button-grey" value="1" name="ac_btn" id="ac_btn" type="button"><span>{lang_entry key="footer.text.accept"}</span></button>
                        <button class="search-button form-button button-grey" value="1" name="pp_btn" id="pp_btn" type="button"><a href="{$main_url}/{href_entry key="page"}?t=page-privacy" target="_blank" rel="nofollow"><span>{lang_entry key="footer.menu.item7"}</span></a></button>
                </center>
            </form>
        </div>


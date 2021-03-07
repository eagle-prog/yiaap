<div class="login-margins">
<div class="vs-column half">
<div class="login-page">
<div class="tabs tabs-style-topline">
    <nav>
        <ul>
            <li onclick="window.location='{$main_url}/{href_entry key="signin"}'"><a href="#section-topline-1" class="icon icon-enter" rel="nofollow"><span>{lang_entry key="frontend.global.signin"}</span></a></li>
            <li class="tab-current"><a href="#section-topline-2" class="icon icon-signup" rel="nofollow"><span>{lang_entry key="frontend.global.signup"}</span></a></li>
            <li onclick="window.location='{$main_url}/{href_entry key="service"}/{href_entry key="x_recovery"}'"><a href="#section-topline-3" class="icon icon-support" rel="nofollow"><span>{lang_entry key="frontend.global.recovery"}</span></a></li>
        </ul>
    </nav>
    <div class="clearfix"></div>
    <div class="content-wrap">
    	{insert name=advHTML id="37"}
        <section id="section-topline-1">
        </section>
        <section id="section-topline-2" class="content-current">
            <div class="">
                {include file="tpl_frontend/tpl_auth/tpl_register.tpl"}
            </div>
        </section>
        <section id="section-topline-3">
        </section>
        {insert name=advHTML id="38"}
    </div><!-- /content -->
</div><!-- /tabs -->
</div>
</div>

<div class="vs-column half fit">
	{include file="tpl_frontend/tpl_auth/tpl_promobox.tpl"}
</div>
</div>

<script type="text/javascript">
{include file="tpl_backend/tpl_signinjs.tpl"}
</script>

{if ($page_display eq "tpl_affiliate" and $smarty.session.USER_AFFILIATE eq 1) or ($page_display eq "tpl_subscribers" and $smarty.session.USER_PARTNER eq 1)}
        <link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/icheck/blue/icheckblue.min.css"><link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/datepicker/tiny-date-picker.min.css"><link rel="stylesheet" type="text/css" href="{$scripts_url}/shared/datepicker/date-range-picker.min.css">
{/if}

<script language="javascript" type="text/javascript">
    <{if $xoConfig.multilingual}>
    function doJSON_LoadPageForm() {
        var params = new Array();
        $.getJSON("<{$xoops_url}>/modules/<{$xoModule.dirname}>/dojson_loadform.php?useradmin=1&passkey=<{$passkey}>&form=<{$smarty.const._XCONTENT_URL_FORM_CATEGORY}>&catid=<{$category.catid}>&language=" + $('#language :selected').text(), params, refreshformdesc);
    }
    <{else}>
    function doJSON_LoadPageForm() {
        var params = new Array();
        $.getJSON("<{$xoops_url}>/modules/<{$xoModule.dirname}>/dojson_loadform.php?useradmin=1&passkey=<{$passkey}>&form=<{$smarty.const._XCONTENT_URL_FORM_CATEGORY}>&catid=<{$category.catid}>", params, refreshformdesc);
    }
    <{/if}>
</script>
<body onLoad="javascript:doJSON_LoadPageForm();">
<{$usermenu}>
<h1 id="headertitle"><{$smarty.const._XCONTENT_AD_CATEGORY_TITLEA}>
    &nbsp;-&nbsp;<{if $category.catid}><{$category.catid}><{else}><{$smarty.const._XCONTENT_AD_CATEGORY_TITLEB}><{/if}></h1>
<p align="center" id='forms'></p>

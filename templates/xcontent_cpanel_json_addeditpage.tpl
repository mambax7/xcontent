<script language="javascript" type="text/javascript">
    <{if $xoConfig.multilingual}>
    function doJSON_LoadPageForm() {
        var params = new Array();
        $.getJSON("<{$xoops_url}>/modules/<{$xoModule.dirname}>/dojson_loadform.php?passkey=<{$passkey}>&form=<{$smarty.const._XCONTENT_URL_FORM_XCONTENT}>&storyid=<{$xcontent.storyid}>&language=" + $('#language :selected').text(), params, refreshformdesc);
    }
    function doJSON_LoadPageTemplate() {
        var params = new Array();
        $.getJSON("<{$xoops_url}>/modules/<{$xoModule.dirname}>/dojson_loadtemplate.php?passkey=<{$passkey}>&form=<{$smarty.const._XCONTENT_URL_FORM_XCONTENT}>&storyid=<{$xcontent.storyid}>&template=" + $('#template :selected').text() + "&language=" + $('#language :selected').text() + "&catid=" + $('#catid :selected').val() + "&parent_id=" + $('#parent_id :selected').val() + "&title=" + escape($('#title').val()) + "&ptitle=" + escape($('#ptitle').val()) + "&keywords=" + escape($('#keywords').val()) + "&page_description=" + escape($('#page_description').val()) + "&address=" + escape($('#address').val()), params, refreshformdesc);
    }
    <{else}>
    function doJSON_LoadPageForm() {
        var params = new Array();
        $.getJSON("<{$xoops_url}>/modules/<{$xoModule.dirname}>/dojson_loadform.php?passkey=<{$passkey}>&form=<{$smarty.const._XCONTENT_URL_FORM_XCONTENT}>&storyid=<{$xcontent.storyid}>", params, refreshformdesc);
    }
    function doJSON_LoadPageTemplate() {
        var params = new Array();
        $.getJSON("<{$xoops_url}>/modules/<{$xoModule.dirname}>/dojson_loadtemplate.php?passkey=<{$passkey}>&form=<{$smarty.const._XCONTENT_URL_FORM_XCONTENT}>&storyid=<{$xcontent.storyid}>&template=" + $('#template :selected').text() + "&language=" + $('#language').val() + "&catid=" + $('#catid :selected').val() + "&parent_id=" + $('#parent_id :selected').val() + "&title=" + escape($('#title').val()) + "&ptitle=" + escape($('#ptitle').val()) + "&keywords=" + escape($('#keywords').val()) + "&page_description=" + escape($('#page_description').val()) + "&address=" + escape($('#address').val()), params, refreshformdesc);
    }
    <{/if}>
</script>
<body onLoad="javascript:doJSON_LoadPageForm();">

<h1><{$smarty.const._XCONTENT_AM_ADDPAGE_TITLEA}>
    &nbsp;-&nbsp;<{if $xcontent.title}><{$xcontent.title}><{if $xcontent.ptitle}>&nbsp;-&nbsp;<{$xcontent.ptitle}><{/if}><{else}><{$smarty.const._XCONTENT_AM_ADDPAGE_TITLEB}><{/if}></h1>
<p align="center" id='forms'></p>
